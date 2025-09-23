<?php
global $price;
$displayPrice = !empty($price) ? '$' . htmlspecialchars($price) : '$20'; // fallback if $price not set
?>
<style>
    #membership_withdraw_backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 99;
    }

    #membership_withdraw_modal {
        display: none;
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 90%; max-width: 400px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        z-index: 100;
        font-family: sans-serif;
    }

    .membership_withdraw_modal_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
    }

    .membership_withdraw_modal_header h2 {
        margin: 0;
        font-size: 1.25em;
        display: flex;
        align-items: center;
    }

    .membership_withdraw_modal_body {
        padding: 16px;
        font-size: 0.95em;
    }

    .membership_withdraw_modal_body p {
        margin: 0 0 12px;
    }

    .membership_withdraw_modal_body hr {
        border: none;
        border-top: 1px solid #eee;
        margin: 12px 0;
    }

    .membership_withdraw_price {
        text-align: center;
        font-size: 1.1em;
    }

    .membership_withdraw_modal_footer {
        padding: 16px;
    }

    #membership_withdraw_proceed_btn {
        width: 100%;
        background: #e60000;
        color: #fff;
        border: none;
        padding: 12px;
        font-size: 1em;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div id="membership_withdraw_backdrop"></div>

<div id="membership_withdraw_modal">
    <div class="membership_withdraw_modal_header">
        <h2><img src="lock-icon.svg" alt="" style="width:32px; vertical-align:middle; margin-right:8px;">Pay Subscription</h2>
        <!-- Close button removed -->
    </div>
    <div class="membership_withdraw_modal_body">
        <p>Please, renew your subscription to access your account and classes.</p>
        <hr>
        <p class="membership_withdraw_price">Price: <strong><?php echo $displayPrice; ?></strong></p>
    </div>
    <div class="membership_withdraw_modal_footer">
        <button id="membership_withdraw_proceed_btn">Pay Now</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function(){
    // Show modal and backdrop
    $('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200);

    // Prevent ESC key from closing the modal
    $(document).on('keydown', function(e) {
        if (e.key === "Escape") {
            e.preventDefault();
        }
    });

    // Disable clicking on the backdrop to close (do nothing)
    $('#membership_withdraw_backdrop').on('click', function(e) {
        e.stopPropagation();
    });

    // Pay button redirects
    $('#membership_withdraw_proceed_btn').on('click', function(){
        var userid = '<?php global $USER, $CFG; echo $USER->id; ?>';
        var url = '<?php echo $CFG->wwwroot; ?>/local/membership/plan.php?userid=' + userid;
        window.location.href = url;
    });
});
</script>