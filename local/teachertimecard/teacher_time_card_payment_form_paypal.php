<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment Modal – PayPal Content (No Tailwind)</title>

    <!-- jQuery (required for your code) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
    :root {
        --teacher_time_card_payment_form_paypal_text: #121117;
        --teacher_time_card_payment_form_paypal_muted: #6B7280;
        --teacher_time_card_payment_form_paypal_border: #E4E7EE;
        --teacher_time_card_payment_form_paypal_radius: 5px;
        --teacher_time_card_payment_form_paypal_control_h: 50px;
        --teacher_time_card_payment_form_paypal_focus: #B9C0D4;
        --teacher_time_card_payment_form_paypal_shadow: rgba(59, 130, 246, .08);
    }

    /* Base */
    html,
    body {
        margin: 0;
        padding: 0;
        background: #fff;
        color: var(--teacher_time_card_payment_form_paypal_text);
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        line-height: 1.4;
    }

    /* Container (replaces Tailwind spacing utilities) */
    #teacher_time_card_payment_form_paypal_root {
        margin-top: -30px;
        /* kept from your inline style */
        padding-left: 4px;
        padding-right: 4px;
        /* px-1 */
        display: block;
    }

    /* vertical spacing between children (replaces space-y-1) */
    #teacher_time_card_payment_form_paypal_root>*+* {
        margin-top: 4px;
    }

    /* Muted text (replaces text-sm & gray) */
    .teacher_time_card_payment_form_paypal_muted {
        font-size: 14px;
        color: var(--teacher_time_card_payment_form_paypal_muted);
    }

    /* Labels */
    .teacher_time_card_payment_form_paypal_label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        color: var(--teacher_time_card_payment_form_paypal_muted);
        font-weight: 500;
    }

    /* Input */
    .teacher_time_card_payment_form_paypal_input {
        box-sizing: border-box;
        width: 100%;
        height: var(--teacher_time_card_payment_form_paypal_control_h);
        border-radius: var(--teacher_time_card_payment_form_paypal_radius);
        border: 1.5px solid var(--teacher_time_card_payment_form_paypal_border);
        outline: 0;
        transition: border-color .15s, box-shadow .15s;
        background: #fff;
        padding: 0 16px;
        font-size: 15px;
        color: var(--teacher_time_card_payment_form_paypal_text);
    }

    .teacher_time_card_payment_form_paypal_input:focus {
        border-color: var(--teacher_time_card_payment_form_paypal_focus);
        box-shadow: 0 0 0 4px var(--teacher_time_card_payment_form_paypal_shadow);
    }

    /* Amount wrapper (for USD badge) */
    .teacher_time_card_payment_form_paypal_amountwrap {
        position: relative;
    }

    .teacher_time_card_payment_form_paypal_amountwrap .teacher_time_card_payment_form_paypal_input {
        padding-right: 64px;
        /* room for USD badge */
        padding-left: 16px;
    }

    .teacher_time_card_payment_form_paypal_currency {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #6b7280;
        user-select: none;
    }

    /* Calculated rows */
    .teacher_time_card_payment_form_paypal_row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 15px;
        margin-top: 10px;
    }

    .teacher_time_card_payment_form_paypal_row span:first-child {
        color: #374151;
    }

    /* gray-700 */
    .teacher_time_card_payment_form_paypal_row .teacher_time_card_payment_form_paypal_val {
        font-weight: 600;
    }

    /* Accordion header */
    .teacher_time_card_payment_form_paypal_toggle {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        border-radius: 10px;
        background: transparent;
        border: 0;
        font-size: 16px;
        font-weight: 600;
        text-align: left;
        cursor: pointer;
        transition: background .15s ease;
    }

    .teacher_time_card_payment_form_paypal_toggle:hover {
        background: #f9fafb;
    }

    /* hover:bg-gray-50 */

    /* Caret rotation */
    .teacher_time_card_payment_form_paypal_caret {
        width: 20px;
        height: 20px;
        color: #374151;
        transition: transform .18s ease;
    }

    .teacher_time_card_payment_form_paypal_caret[aria-expanded="true"] {
        transform: rotate(180deg);
    }

    /* Panel */
    #teacher_time_card_payment_form_paypal_panel {
        display: none;
        /* replaces Tailwind 'hidden' */
        padding: 0 12px 8px 12px;
        font-size: 14px;
        color: #374151;
        line-height: 1.6;
    }

    /* Simple responsive constraints */
    .teacher_time_card_payment_form_paypal_wrap {
        max-width: 720px;
        margin: 0 auto;
    }

    @media (max-width:740px) {
        .teacher_time_card_payment_form_paypal_wrap {
            padding-left: 12px;
            padding-right: 12px;
        }
    }
    </style>
</head>

<body>

    <!-- PAYPAL CONTENT BLOCK -->
    <div class="teacher_time_card_payment_form_paypal_wrap">
        <div id="teacher_time_card_payment_form_paypal_root">
            <p class="teacher_time_card_payment_form_paypal_muted">
                Enter the amount you want to withdraw to see how fees apply
            </p>

            <!-- Email -->
            <div>
                <label for="teacher_time_card_payment_form_paypal_email"
                    class="teacher_time_card_payment_form_paypal_label">
                    Email (linked to Teacher’s Wise account)
                </label>
                <input id="teacher_time_card_payment_form_paypal_email" type="email"
                    class="teacher_time_card_payment_form_paypal_input" placeholder="">
            </div>

            <!-- Amount -->
            <div>
                <label class="teacher_time_card_payment_form_paypal_label">Amount</label>
                <div class="teacher_time_card_payment_form_paypal_amountwrap">
                    <input id="teacher_time_card_payment_form_paypal_amount" type="number" min="0" step="0.01"
                        class="teacher_time_card_payment_form_paypal_input" placeholder="Amount">
                    <span class="teacher_time_card_payment_form_paypal_currency">USD</span>
                </div>
            </div>

            <!-- Calculated rows -->
            <div style="margin-top:6px;">
                <div class="teacher_time_card_payment_form_paypal_row">
                    <span>Transaction fee</span>
                    <span id="teacher_time_card_payment_form_paypal_fee"
                        class="teacher_time_card_payment_form_paypal_val">0.00 USD</span>
                </div>
                <div class="teacher_time_card_payment_form_paypal_row">
                    <span>Withdraw after fees</span>
                    <span id="teacher_time_card_payment_form_paypal_after"
                        class="teacher_time_card_payment_form_paypal_val">0.00 USD</span>
                </div>
            </div>

            <!-- Explore PayPal fees -->
            <div style="padding-top:8px;">
                <button id="teacher_time_card_payment_form_paypal_toggle" type="button"
                    class="teacher_time_card_payment_form_paypal_toggle" aria-expanded="false"
                    aria-controls="teacher_time_card_payment_form_paypal_panel">
                    <span>Explore PayPal fees</span>
                    <svg class="teacher_time_card_payment_form_paypal_caret" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="teacher_time_card_payment_form_paypal_panel">
                    <p>PayPal charges a foreign exchange fee when transferring to non-USD accounts.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /PAYPAL CONTENT BLOCK -->

    <script>
    (function($) {
        // ----- Config -----
        const teacher_time_card_payment_form_paypal_FEE_RATE = 0.02; // 2%
        const teacher_time_card_payment_form_paypal_CURRENCY = 'USD';

        // ----- Elements -----
        const $teacher_time_card_payment_form_paypal_amount = $('#teacher_time_card_payment_form_paypal_amount');
        const $teacher_time_card_payment_form_paypal_fee = $('#teacher_time_card_payment_form_paypal_fee');
        const $teacher_time_card_payment_form_paypal_after = $('#teacher_time_card_payment_form_paypal_after');

        // ----- Helpers -----
        function teacher_time_card_payment_form_paypal_fmt(n) {
            const v = isFinite(n) ? Number(n) : 0;
            return v.toFixed(2) + ' ' + teacher_time_card_payment_form_paypal_CURRENCY;
        }

        function teacher_time_card_payment_form_paypal_recalc() {
            const amt = parseFloat($teacher_time_card_payment_form_paypal_amount.val());
            if (isNaN(amt) || amt <= 0) {
                $teacher_time_card_payment_form_paypal_fee.text(teacher_time_card_payment_form_paypal_fmt(0));
                $teacher_time_card_payment_form_paypal_after.text(teacher_time_card_payment_form_paypal_fmt(0));
                return;
            }
            const fee = +(amt * teacher_time_card_payment_form_paypal_FEE_RATE);
            const after = amt - fee;
            $teacher_time_card_payment_form_paypal_fee.text(teacher_time_card_payment_form_paypal_fmt(fee));
            $teacher_time_card_payment_form_paypal_after.text(teacher_time_card_payment_form_paypal_fmt(after));
        }

        // live update
        $teacher_time_card_payment_form_paypal_amount.on('input', teacher_time_card_payment_form_paypal_recalc);

        // accordion
        const $teacher_time_card_payment_form_paypal_toggle = $('#teacher_time_card_payment_form_paypal_toggle');
        const $teacher_time_card_payment_form_paypal_panel = $('#teacher_time_card_payment_form_paypal_panel');

        $teacher_time_card_payment_form_paypal_toggle.on('click', function() {
            const expanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', String(!expanded));
            // rotate caret by toggling aria on the svg too (optional)
            $(this).find('.teacher_time_card_payment_form_paypal_caret').attr('aria-expanded', String(!
                expanded));
            $teacher_time_card_payment_form_paypal_panel.stop(true, true).slideToggle(160);
        });

        // init
        teacher_time_card_payment_form_paypal_recalc();
    })(jQuery);
    </script>
</body>

</html>