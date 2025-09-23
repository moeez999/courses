<?php
// Paste this block into any Moodle-rendered page AFTER require_login()
// No $PAGE or $OUTPUT calls here.
global $CFG, $forcedSubscriptionId;


// If you want to force a specific subscription id, set it here, else leave empty to auto-pick latest:
// $forcedSubscriptionId = ''; // e.g. 'abcd1234' or ''
$bootstrapUrl = new moodle_url('/local/membership/braintree/retry_bootstrap.php', [
    'subscriptionid' => $forcedSubscriptionId
]);
$updateUrl = new moodle_url('/local/membership/braintree/update_subscription_payment_and_retry.php');
?>

<style>



:root { --moodle-header-h: 56px; } /* sensible default */

@media (max-width: 767px) {
  #membership_withdraw_backdrop {
    top: var(--moodle-header-h);
  }
  #membership_withdraw_modal {
    top: calc(var(--moodle-header-h) + 150px); /* pushed down 100px more */
    left: 50%;
    transform: translateX(-50%);  /* no translateY on mobile */
    width: 94%;
    max-height: calc(100vh - var(--moodle-header-h) - 116px);
    overflow: auto;
    -webkit-overflow-scrolling: touch;
  }
}


/* Keep your defaults */
#membership_withdraw_backdrop { z-index: 900; }
#membership_withdraw_modal    { z-index: 9999; }

/* When the topbar menu is open, lower the modal & raise the menu */
body.rui-topbar-menu-on #membership_withdraw_backdrop { z-index: 800; }
body.rui-topbar-menu-on #membership_withdraw_modal    { z-index: 1000; }


/* Ensure the header stays above the backdrop */
header#page-header, .navbar, #page-header {
  position: relative;
  z-index: 1000; /* higher than backdrop's 900 */
}

    #membership_withdraw_backdrop {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 900;   /* lower than header (~1000) */
}
#membership_withdraw_modal {
    z-index: 9999;  /* keep modal itself above everything */
}
    /* #membership_withdraw_backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
    } */
    #membership_withdraw_modal {
        display: none;
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 90%; max-width: 420px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.25);
        z-index: 9999;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }
    .membership_withdraw_modal_header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 16px 18px; border-bottom: 1px solid #eee;
    }
    .membership_withdraw_modal_header h2 {
        margin: 0; font-size: 1.15rem; display: flex; align-items: center; gap: 8px;
    }
    .membership_withdraw_modal_body { padding: 16px 18px; font-size: .95rem; }
    .membership_withdraw_modal_body p { margin: 0 0 12px; }
    .membership_withdraw_modal_body hr { border: none; border-top: 1px solid #eee; margin: 12px 0; }
    .membership_withdraw_price { text-align: center; font-size: 1.05rem; font-weight: 600; padding: 8px; background: #fafafa; border: 1px solid #eee; border-radius: 8px; }
    #dropin-container { border: 1px dashed #ddd; border-radius: 8px; padding: 10px; margin-top: 10px; }
    .membership_withdraw_modal_footer { padding: 16px 18px; border-top: 1px solid #eee; }
    #membership_withdraw_proceed_btn {
        width: 100%; background: #0a7cff; color: #fff;
        border: none; padding: 12px; font-size: 1rem; border-radius: 6px; cursor: pointer;
    }
    #membership_withdraw_proceed_btn[disabled]{ opacity: .6; cursor: not-allowed; }

    .retry_msg_error {
        display: none; margin-top: 10px;
        background: #fff4f4; border: 1px solid #ffd6d6; color: #b10000;
        padding: 10px 12px; border-radius: 6px; font-size: .9rem;
    }
    .retry_msg_success {
        display: none; margin-top: 10px;
        background: #f3fff4; border: 1px solid #c8f0cc; color: #156d22;
        padding: 10px 12px; border-radius: 6px; font-size: .9rem;
    }
    .retry_spinner {
        display: none; margin-top: 8px; justify-content: center; align-items: center; gap: 8px; font-size: .9rem;
    }
    .retry_spinner .dot { width: 8px; height: 8px; border-radius: 50%; background: #333; animation: blip 1s infinite ease-in-out; }
    .retry_spinner .dot:nth-child(2){ animation-delay: .15s; }
    .retry_spinner .dot:nth-child(3){ animation-delay: .3s; }
    @keyframes blip { 0%,80%,100%{ transform: scale(0); } 40%{ transform: scale(1); } }

    #nav-notification-popover-container.popover-region.collapsed.popover-region-notifications {
  pointer-events: none;   /* disables all clicks, hovers, etc. */
  opacity: 0.6;           /* optional: dim it a bit to show it's inactive */
}

/* Disable clicks on the Messages popover */
.popover-region.collapsed[data-region="popover-region-messages"] {
  pointer-events: none !important;
  opacity: 0.6; /* optional visual cue */
}

</style>

<div id="membership_withdraw_backdrop"></div>

<div id="membership_withdraw_modal" role="dialog" aria-modal="true">
    <div class="membership_withdraw_modal_header">
        <h2>
            <img src="<?php echo $CFG->wwwroot; ?>/course/lock.svg" alt="" style="width:24px;height:24px">
            Pay Subscription
        </h2>
        <!-- no close button -->
    </div>
    <div class="membership_withdraw_modal_body">
        <p>Please renew your subscription to access your account and classes.</p>
        <hr>
        <p class="membership_withdraw_price">Price: <strong id="retry_price">$—</strong></p>

        <div id="dropin-container"></div>

        <div id="retry_error" class="retry_msg_error"></div>
        <div id="retry_success" class="retry_msg_success"></div>
        <div id="retry_spinner" class="retry_spinner" aria-live="polite">
            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
            <span>Processing…</span>
        </div>
    </div>
    <div class="membership_withdraw_modal_footer">
        <button id="membership_withdraw_proceed_btn">Update Payment & Retry</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.braintreegateway.com/web/dropin/1.40.4/js/dropin.min.js"></script>
<script>
(function(){
    const bootstrapUrl = <?php echo json_encode($bootstrapUrl->out(false)); ?>;
    const updateUrl    = <?php echo json_encode($updateUrl->out(false)); ?>;
    const sesskey      = <?php echo json_encode($sesskey); ?>;

    function show()  { $('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200); }
    function error(m){ $('#retry_error').text(m).slideDown(120); }
    function ok(m)   { $('#retry_success').text(m).slideDown(120); }
    function clear() { $('#retry_error, #retry_success').hide().text(''); }
    function busy(b) {
        if (b) { $('#membership_withdraw_proceed_btn').attr('disabled','disabled'); $('#retry_spinner').css('display','flex'); }
        else   { $('#membership_withdraw_proceed_btn').removeAttr('disabled'); $('#retry_spinner').hide(); }
    }

    // Block ESC/backdrop close
    $(document).on('keydown', function(e){ if (e.key === 'Escape') e.preventDefault(); });
    $('#membership_withdraw_backdrop').on('click', function(e){ e.stopPropagation(); });

    debugger

    let dropinInstance = null;
    let subscriptionId = null;

// 1) Bootstrap (get clientToken, price, subscriptionId)
(async function(){
    try {
        const res = await fetch(bootstrapUrl, {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        });

        if (!res.ok) {
            throw new Error("Network response was not ok: " + res.status);
        }

        const resp = await res.json();

        if (!resp || !resp.success) {
            error(resp && resp.error ? resp.error : 'Cannot initialize payment.');
            show();
            return;
        }

        subscriptionId = resp.subscriptionId;
        document.getElementById('retry_price').textContent = resp.displayPrice;

      try {
  const dropin = await loadBraintreeDropinAMD('1.43.0'); // or 1.42.0 / 1.41.0 if needed
  dropin.create({
    authorization: resp.clientToken,
    container: '#dropin-container',
    card: { cardholderName: true }
  }, function(createErr, instance) {
    if (createErr) {
      console.error('Drop-in create error:', createErr);
      error('Unable to load payment form. Please refresh and try again.');
      show();
      return;
    }
    dropinInstance = instance;
    show();
  });
} catch (e) {
  console.error('AMD load failed:', e);
  error('Could not load payment form library.');
  show();
}

    } catch (err) {
        console.error("Bootstrap fetch failed:", err);
        error('Failed to contact server.');
        show();
    }
})();


// Map the AMD module name to the CDN file (pick a valid version)
function loadBraintreeDropinAMD(version = '1.43.0') {
  return new Promise(function(resolve, reject) {
    if (typeof requirejs !== 'function' && typeof require !== 'function') {
      reject(new Error('RequireJS not found on this page.'));
      return;
    }
    // Moodle exposes requirejs/require
    const r = (typeof requirejs === 'function') ? requirejs : require;
    r.config({
      paths: {
        'braintree-web-drop-in': 'https://js.braintreegateway.com/web/dropin/' + version + '/js/dropin.min'
      }
    });
    r(['braintree-web-drop-in'], function(dropin) {
      resolve(dropin);
    }, function(err) {
      reject(err);
    });
  });
}



    // 3) Submit → update same subscription + retry
    $('#membership_withdraw_proceed_btn').on('click', function(){
    debugger
        clear();
        if (!dropinInstance) { error('Payment form not ready yet.'); return; }

        busy(true);
        dropinInstance.requestPaymentMethod(function (err, payload) {
            if (err) {
                console.error(err);
                busy(false);
                error('Could not get payment details. Please check and try again.');
                return;
            }
            $.ajax({
                url: updateUrl,
                method: 'POST',
                dataType: 'json',
                data: {
                    subscriptionId: subscriptionId,
                    paymentMethodNonce: payload.nonce,
                    sesskey: sesskey
                }
            })
            .done(function(resp){
                if (!resp || !resp.success) {
                    const msg = resp && resp.error ? resp.error : 'Update/retry failed.';
                    error(msg);
                    busy(false);
                    return;
                }
                ok('Payment updated successfully. Finishing up…');
                setTimeout(function(){ window.location.reload(); }, 900);
            })
            .fail(function(xhr){
                console.error(xhr);
                const msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Network/server error.';
                error(msg);
                busy(false);
            });
        });
    });
})();
</script>

<script>
(function() {
  // Try common Moodle header selectors; fall back to navbar
  var $hdr = document.querySelector('#page-header') 
          || document.querySelector('header#page-header') 
          || document.querySelector('.navbar');

  var h = $hdr ? ($hdr.getBoundingClientRect().height || 56) : 56;
  // Add a little safe-area padding for notches on iOS
  var pad = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--sat')||0,10) || 0;
  document.documentElement.style.setProperty('--moodle-header-h', (h + pad) + 'px');
})();
</script>

<script>
(function () {
  // 1) Find the button you mentioned
  var btn = document.querySelector('.rui-topbar-btn.rui-mobile-nav-btn-close.d-md-none, .rui-topbar-btn.d-md-none');
  if (!btn) return;

  // 2) Try to resolve the target menu/panel from attributes
  var selector = btn.getAttribute('data-bs-target') || btn.getAttribute('data-target') || btn.getAttribute('aria-controls') || '';
  var panel = selector ? document.querySelector(selector) : null;

  // 3) Fallbacks: typical RemUI containers
  if (!panel) {
    panel = document.querySelector('.rui-topbar-menu, .rui-topbar-dropdown, .rui-right-panel, .rui-mobile-nav, .rui-mobile-nav-panel');
  }

  // Helper: is the panel visible/open?
  function isOpen(el) {
    if (!el) return false;
    // Common patterns: "show" class, or visible in layout
    return el.classList.contains('show') || el.classList.contains('open') || el.offsetParent !== null;
  }

  // Apply body class based on state
  function syncState() {
    var on = isOpen(panel) || btn.getAttribute('aria-expanded') === 'true';
    document.body.classList.toggle('rui-topbar-menu-on', !!on);
  }

  // 4) Hook button clicks & aria-expanded changes
  btn.addEventListener('click', function () {
    // Let the UI toggle, then sync
    setTimeout(syncState, 0);
  });

  // 5) Observe class changes on the panel (open/close)
  if (panel && 'MutationObserver' in window) {
    var mo = new MutationObserver(function (m) {
      for (var i=0;i<m.length;i++) {
        if (m[i].attributeName === 'class' || m[i].attributeName === 'style') {
          syncState();
          break;
        }
      }
    });
    mo.observe(panel, { attributes: true, attributeFilter: ['class', 'style'] });
  }

  // 6) Also observe body for drawer/topbar class flips (theme side effects)
  var mob = new MutationObserver(function (m) {
    for (var i=0;i<m.length;i++) {
      if (m[i].attributeName === 'class') {
        syncState();
        break;
      }
    }
  });
  mob.observe(document.body, { attributes: true });

  // Initial pass
  syncState();
})();
</script>