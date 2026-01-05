<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Payment Modal – Skrill Content (No Tailwind)</title>

  <!-- jQuery (required for slideToggle & event handling) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root {
      --teacher_time_card_payment_form_skrill_text: #121117;
      --teacher_time_card_payment_form_skrill_muted: #6B7280;
      --teacher_time_card_payment_form_skrill_border: #E4E7EE;
      --teacher_time_card_payment_form_skrill_radius: 5px;
      --teacher_time_card_payment_form_skrill_control_h: 50px;
      --teacher_time_card_payment_form_skrill_focus: #B9C0D4;
      --teacher_time_card_payment_form_skrill_shadow: rgba(59, 130, 246, .08);
    }

    /* Base */
    html,
    body {
      margin: 0;
      padding: 0;
      background: #fff;
      color: var(--teacher_time_card_payment_form_skrill_text);
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      line-height: 1.4;
    }

    /* Outer wrap for responsive width */
    .teacher_time_card_payment_form_skrill_wrap {
      max-width: 720px;
      margin: 0 auto;
    }

    @media (max-width:740px) {
      .teacher_time_card_payment_form_skrill_wrap {
        padding-left: 12px;
        padding-right: 12px;
      }
    }

    /* Root container (replaces Tailwind px-1 + space-y-1) */
    #teacher_time_card_payment_form_skrill_root {
      margin-top: -30px;
      padding-left: 4px;
      padding-right: 4px;
    }

    #teacher_time_card_payment_form_skrill_root>*+* {
      margin-top: 4px;
    }

    /* Muted paragraph */
    .teacher_time_card_payment_form_skrill_muted {
      font-size: 14px;
      color: var(--teacher_time_card_payment_form_skrill_muted);
    }

    /* Labels */
    .teacher_time_card_payment_form_skrill_label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      color: var(--teacher_time_card_payment_form_skrill_muted);
      font-weight: 500;
    }

    /* Inputs */
    .teacher_time_card_payment_form_skrill_input {
      box-sizing: border-box;
      width: 100%;
      height: var(--teacher_time_card_payment_form_skrill_control_h);
      border-radius: var(--teacher_time_card_payment_form_skrill_radius);
      border: 1.5px solid var(--teacher_time_card_payment_form_skrill_border);
      outline: 0;
      transition: border-color .15s, box-shadow .15s;
      background: #fff;
      padding: 0 16px;
      font-size: 15px;
      color: var(--teacher_time_card_payment_form_skrill_text);
    }

    .teacher_time_card_payment_form_skrill_input:focus {
      border-color: var(--teacher_time_card_payment_form_skrill_focus);
      box-shadow: 0 0 0 4px var(--teacher_time_card_payment_form_skrill_shadow);
    }

    /* Amount wrapper + currency badge */
    .teacher_time_card_payment_form_skrill_amountwrap {
      position: relative;
    }

    .teacher_time_card_payment_form_skrill_amountwrap .teacher_time_card_payment_form_skrill_input {
      padding-right: 64px;
      /* room for USD tag */
    }

    .teacher_time_card_payment_form_skrill_currency {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 14px;
      color: #6b7280;
      user-select: none;
    }

    /* Calculated rows */
    .teacher_time_card_payment_form_skrill_row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 15px;
      margin-top: 10px;
    }

    .teacher_time_card_payment_form_skrill_row span:first-child {
      color: #374151;
    }

    .teacher_time_card_payment_form_skrill_val {
      font-weight: 600;
    }

    /* Accordion button */
    .teacher_time_card_payment_form_skrill_toggle {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px;
      border-radius: 10px;
      border: 0;
      background: transparent;
      font-size: 16px;
      font-weight: 600;
      text-align: left;
      cursor: pointer;
      transition: background .15s ease;
    }

    .teacher_time_card_payment_form_skrill_toggle:hover {
      background: #f9fafb;
    }

    /* Caret rotation based on button state */
    .teacher_time_card_payment_form_skrill_caret {
      width: 20px;
      height: 20px;
      color: #374151;
      transition: transform .18s ease;
    }

    .teacher_time_card_payment_form_skrill_toggle[aria-expanded="true"] .teacher_time_card_payment_form_skrill_caret {
      transform: rotate(180deg);
    }

    /* Panel */
    #teacher_time_card_payment_form_skrill_panel {
      display: none;
      padding: 0 12px 8px 12px;
      font-size: 14px;
      color: #374151;
      line-height: 1.6;
    }

    /* Small vertical tweak groups (replacing mt-/pt- utilities) */
    .teacher_time_card_payment_form_skrill_blockspacer {
      margin-top: 6px;
    }

    .teacher_time_card_payment_form_skrill_panelspacer {
      padding-top: 8px;
    }
  </style>
</head>

<body>

  <!-- ============== SKRILL CONTENT BLOCK (standalone) ============== -->
  <div class="teacher_time_card_payment_form_skrill_wrap">
    <div id="teacher_time_card_payment_form_skrill_root">
      <p class="teacher_time_card_payment_form_skrill_muted">
        Enter the amount you want to withdraw to see how fees apply
      </p>

      <!-- Email -->
      <div>
        <label for="teacher_time_card_payment_form_skrill_email"
          class="teacher_time_card_payment_form_skrill_label">
          Email (linked to Teacher’s wise account)
        </label>
        <input id="teacher_time_card_payment_form_skrill_email" type="email"
          class="teacher_time_card_payment_form_skrill_input" placeholder="">
      </div>

      <!-- Amount -->
      <div>
        <label class="teacher_time_card_payment_form_skrill_label">Amount</label>
        <div class="teacher_time_card_payment_form_skrill_amountwrap">
          <input id="teacher_time_card_payment_form_skrill_amount" type="number" min="0" step="0.01"
            class="teacher_time_card_payment_form_skrill_input" placeholder="Amount">
          <span class="teacher_time_card_payment_form_skrill_currency">USD</span>
        </div>
      </div>

      <!-- Calculated rows -->
      <div class="teacher_time_card_payment_form_skrill_blockspacer">
        <div class="teacher_time_card_payment_form_skrill_row">
          <span>Transaction fee</span>
          <span id="teacher_time_card_payment_form_skrill_fee"
            class="teacher_time_card_payment_form_skrill_val">0.00 USD</span>
        </div>
        <div class="teacher_time_card_payment_form_skrill_row">
          <span>Withdraw after fees</span>
          <span id="teacher_time_card_payment_form_skrill_after"
            class="teacher_time_card_payment_form_skrill_val">0.00 USD</span>
        </div>
      </div>

      <!-- Explore Skrill fees -->
      <div class="teacher_time_card_payment_form_skrill_panelspacer">
        <button id="teacher_time_card_payment_form_skrill_toggle" type="button"
          class="teacher_time_card_payment_form_skrill_toggle" aria-expanded="false"
          aria-controls="teacher_time_card_payment_form_skrill_panel">
          <span>Explore Skrill fees</span>
          <svg class="teacher_time_card_payment_form_skrill_caret" viewBox="0 0 20 20" fill="currentColor"
            aria-hidden="true">
            <path fill-rule="evenodd"
              d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
              clip-rule="evenodd" />
          </svg>
        </button>
        <div id="teacher_time_card_payment_form_skrill_panel">
          <p>Skrill charges a foreign exchange fee when transferring to non-USD accounts.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- ============== /SKRILL CONTENT BLOCK ============== -->

  <script>
    (function($) {
      // ----- Config -----
      const teacher_time_card_payment_form_skrill_FEE_RATE = 0.02; // 2% example
      const teacher_time_card_payment_form_skrill_CURRENCY = 'USD';

      // ----- Elements -----
      const $teacher_time_card_payment_form_skrill_amount = $('#teacher_time_card_payment_form_skrill_amount');
      const $teacher_time_card_payment_form_skrill_fee = $('#teacher_time_card_payment_form_skrill_fee');
      const $teacher_time_card_payment_form_skrill_after = $('#teacher_time_card_payment_form_skrill_after');

      // ----- Helpers -----
      function teacher_time_card_payment_form_skrill_fmt(n) {
        const v = isFinite(n) ? Number(n) : 0;
        return v.toFixed(2) + ' ' + teacher_time_card_payment_form_skrill_CURRENCY;
      }

      function teacher_time_card_payment_form_skrill_recalc() {
        const amt = parseFloat($teacher_time_card_payment_form_skrill_amount.val());
        if (isNaN(amt) || amt <= 0) {
          $teacher_time_card_payment_form_skrill_fee.text(teacher_time_card_payment_form_skrill_fmt(0));
          $teacher_time_card_payment_form_skrill_after.text(teacher_time_card_payment_form_skrill_fmt(0));
          return;
        }
        const fee = +(amt * teacher_time_card_payment_form_skrill_FEE_RATE);
        const after = amt - fee;
        $teacher_time_card_payment_form_skrill_fee.text(teacher_time_card_payment_form_skrill_fmt(fee));
        $teacher_time_card_payment_form_skrill_after.text(teacher_time_card_payment_form_skrill_fmt(after));
      }

      // Live update
      $teacher_time_card_payment_form_skrill_amount.on('input', teacher_time_card_payment_form_skrill_recalc);

      // Accordion
      const $teacher_time_card_payment_form_skrill_toggle = $('#teacher_time_card_payment_form_skrill_toggle');
      const $teacher_time_card_payment_form_skrill_panel = $('#teacher_time_card_payment_form_skrill_panel');

      $teacher_time_card_payment_form_skrill_toggle.on('click', function() {
        const expanded = $(this).attr('aria-expanded') === 'true';
        $(this).attr('aria-expanded', String(!expanded));
        $teacher_time_card_payment_form_skrill_panel.stop(true, true).slideToggle(160);
      });

      // Init
      teacher_time_card_payment_form_skrill_recalc();
    })(jQuery);
  </script>
</body>

</html>