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
    width: 95%;               /* Slightly wider */
    max-width: 480px;         /* Increased max width */
    min-height: 200px;        /* Optional: ensures a bit more height */
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
</style>

<div id="membership_withdraw_backdrop"></div>

<div id="membership_withdraw_modal">
    <div class="membership_withdraw_modal_header">
        <h2><img src="lock-icon.svg" alt="" style="width:32px; vertical-align:middle; margin-right:8px;">Subscription Info</h2>
    </div>
    <div class="membership_withdraw_modal_body">
        <p id="subscription_dates_message">Loading subscription info...</p>
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

    // ✅ Read from global vars (set before including this file)
    const startDate = window.subscriptionStartDate || 'N/A';
    const endDate = window.subscriptionEndDate || 'N/A';

    $('#subscription_dates_message').text(`Your subscription will start on ${startDate} and renews on ${endDate}.`);
});
</script>