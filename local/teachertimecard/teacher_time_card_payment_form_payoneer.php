<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment Modal – Payoneer Content (No Tailwind)</title>

    <!-- jQuery for event handling / slideToggle -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --teacher_time_card_payment_form_payoneer_text: #121117;
            --teacher_time_card_payment_form_payoneer_muted: #6B7280;
            --teacher_time_card_payment_form_payoneer_border: #E4E7EE;
            --teacher_time_card_payment_form_payoneer_radius: 5px;
            --teacher_time_card_payment_form_payoneer_focus: #B9C0D4;
            --teacher_time_card_payment_form_payoneer_shadow: rgba(59, 130, 246, .08);
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #fff;
            color: var(--teacher_time_card_payment_form_payoneer_text);
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 1.45;
        }

        /* Responsive wrapper */
        .teacher_time_card_payment_form_payoneer_wrap {
            max-width: 720px;
            margin: 0 auto;
        }

        @media (max-width:740px) {
            .teacher_time_card_payment_form_payoneer_wrap {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

        /* Root container (replaces Tailwind px-1 space-y-1) */
        #teacher_time_card_payment_form_payoneer_root {
            margin-top: -30px;
            padding-left: 4px;
            padding-right: 4px;
        }

        #teacher_time_card_payment_form_payoneer_root>*+* {
            margin-top: 4px;
        }

        /* Heading (replaces font-semibold text-base) */
        .teacher_time_card_payment_form_payoneer_h4 {
            font-weight: 600;
            font-size: 16px;
            margin: 0 0 2px 0;
        }

        /* Paragraph (replaces text-sm + muted color) */
        .teacher_time_card_payment_form_payoneer_p {
            font-size: 14px;
            color: var(--teacher_time_card_payment_form_payoneer_muted);
            margin: 0;
        }

        /* Spacer (replaces pt-2) */
        .teacher_time_card_payment_form_payoneer_panelspacer {
            padding-top: 8px;
        }

        /* Toggle button (replaces w-full flex items-center justify-between p-3 hover:bg-gray-50 rounded-[10px]) */
        .teacher_time_card_payment_form_payoneer_toggle {
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

        .teacher_time_card_payment_form_payoneer_toggle:hover {
            background: #f9fafb;
        }

        /* Caret (replaces w-5 h-5 text-gray-700 + rotation) */
        .teacher_time_card_payment_form_payoneer_caret {
            width: 20px;
            height: 20px;
            color: #374151;
            transition: transform .18s ease;
        }

        .teacher_time_card_payment_form_payoneer_toggle[aria-expanded="true"] .teacher_time_card_payment_form_payoneer_caret {
            transform: rotate(180deg);
        }

        /* Panel (replaces hidden px-3 pb-1 text-sm text-gray-700 leading-6) */
        #teacher_time_card_payment_form_payoneer_panel {
            display: none;
            padding: 0 12px 8px 12px;
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <!-- ============== PAYONEER CONTENT BLOCK (standalone) ============== -->
    <div class="teacher_time_card_payment_form_payoneer_wrap">
        <div id="teacher_time_card_payment_form_payoneer_root">

            <h4 class="teacher_time_card_payment_form_payoneer_h4">
                Create a Payoneer account for free
            </h4>

            <p class="teacher_time_card_payment_form_payoneer_p">
                Payoneer offers you a multi-currency account so you can pay and get paid globally.
                Receive your earnings to your Payoneer account, then withdraw them to your local bank account.
            </p>

            <!-- Explore Payoneer fees -->
            <div class="teacher_time_card_payment_form_payoneer_panelspacer">
                <button id="teacher_time_card_payment_form_payoneer_toggle" type="button"
                    class="teacher_time_card_payment_form_payoneer_toggle" aria-expanded="false"
                    aria-controls="teacher_time_card_payment_form_payoneer_panel">
                    <span>Explore Payoneer fees</span>
                    <svg class="teacher_time_card_payment_form_payoneer_caret" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="teacher_time_card_payment_form_payoneer_panel">
                    <p>Payoneer charges a foreign exchange fee when transferring to non-USD accounts.</p>
                </div>
            </div>

        </div>
    </div>
    <!-- ============== /PAYONEER CONTENT BLOCK ============== -->

    <script>
        (function($) {
            // ----- Config (kept for compatibility with your flow) -----
            const teacher_time_card_payment_form_payoneer_FEE_RATE = 0.02; // 2% example
            const teacher_time_card_payment_form_payoneer_CURRENCY = 'USD';

            // Elements (may not exist here; kept harmless for shared script compatibility)
            const $teacher_time_card_payment_form_payoneer_amount = $(
                '#teacher_time_card_payment_form_payoneer_amount');
            const $teacher_time_card_payment_form_payoneer_fee = $('#teacher_time_card_payment_form_payoneer_fee');
            const $teacher_time_card_payment_form_payoneer_after = $('#teacher_time_card_payment_form_payoneer_after');

            function teacher_time_card_payment_form_payoneer_fmt(n) {
                const v = isFinite(n) ? Number(n) : 0;
                return v.toFixed(2) + ' ' + teacher_time_card_payment_form_payoneer_CURRENCY;
            }

            function teacher_time_card_payment_form_payoneer_recalc() {
                if (!$teacher_time_card_payment_form_payoneer_amount.length) return; // no amount field in this block
                const amt = parseFloat($teacher_time_card_payment_form_payoneer_amount.val());
                if (isNaN(amt) || amt <= 0) {
                    $teacher_time_card_payment_form_payoneer_fee.text(teacher_time_card_payment_form_payoneer_fmt(0));
                    $teacher_time_card_payment_form_payoneer_after.text(teacher_time_card_payment_form_payoneer_fmt(0));
                    return;
                }
                const fee = +(amt * teacher_time_card_payment_form_payoneer_FEE_RATE);
                const after = amt - fee;
                $teacher_time_card_payment_form_payoneer_fee.text(teacher_time_card_payment_form_payoneer_fmt(fee));
                $teacher_time_card_payment_form_payoneer_after.text(teacher_time_card_payment_form_payoneer_fmt(after));
            }

            // Live update (only binds if the element exists)
            if ($teacher_time_card_payment_form_payoneer_amount.length) {
                $teacher_time_card_payment_form_payoneer_amount.on('input',
                    teacher_time_card_payment_form_payoneer_recalc);
            }

            // Accordion
            const $teacher_time_card_payment_form_payoneer_toggle = $(
                '#teacher_time_card_payment_form_payoneer_toggle');
            const $teacher_time_card_payment_form_payoneer_panel = $('#teacher_time_card_payment_form_payoneer_panel');
            $teacher_time_card_payment_form_payoneer_toggle.on('click', function() {
                const expanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', String(!expanded));
                $teacher_time_card_payment_form_payoneer_panel.stop(true, true).slideToggle(160);
            });

            // Init
            teacher_time_card_payment_form_payoneer_recalc();
        })(jQuery);
    </script>
</body>

</html>