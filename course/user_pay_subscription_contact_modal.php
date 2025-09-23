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
        width: 95%;
        max-width: 480px;
        min-height: 200px;
        background: #fff;
        border-radius: 10px;
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
        line-height: 1.5em;
    }

    .membership_withdraw_modal_body p {
        margin: 0 0 12px;
    }

    .membership_withdraw_modal_body hr {
        border: none;
        border-top: 1px solid #eee;
        margin: 12px 0;
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
        <h2>
            <img src="lock-icon.svg" alt="" style="width:32px; vertical-align:middle; margin-right:8px;">
            Renew Subscription
        </h2>
    </div>
    <div class="membership_withdraw_modal_body">
        <p>
            You need to renew your subscription. Please click the button below to complete payment,
            or contact customer service via call or WhatsApp at <strong>+1 754-364-4125</strong>.
        </p>
    </div>
    <div class="membership_withdraw_modal_footer">
        <button id="membership_withdraw_proceed_btn">Pay Now</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function(){
    $('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200);

    $(document).on('keydown', function(e) {
        if (e.key === "Escape") e.preventDefault();
    });

    $('#membership_withdraw_backdrop').on('click', function(e) {
        e.stopPropagation();
    });

    $('#membership_withdraw_proceed_btn').on('click', function(){
        var userid = '<?php global $USER, $CFG; echo $USER->id; ?>';
        var url = '<?php echo $CFG->wwwroot; ?>/local/membership/plan.php?userid=' + userid;
        window.location.href = url;
    });
});
</script>