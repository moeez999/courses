<!-- ===== Withdraw Verification Modal (NO TAILWIND, STANDALONE) ===== -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Withdraw Verification Modal</title>

    <!-- jQuery (required for the script below) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --ttcpf-verify-text: #121117;
            --ttcpf-verify-muted: #6B7280;
            --ttcpf-verify-border: #E4E7EE;
            --ttcpf-verify-focus: #B9C0D4;
            --ttcpf-verify-shadow: rgba(59, 130, 246, .08);
            --ttcpf-verify-info-bg: #E3EEFF;
            --ttcpf-verify-info-bd: #D0E0FF;
        }

        /* replicate Tailwind's .hidden used by the JS */
        .hidden {
            display: none !important;
        }

        /* Backdrop & modal root */
        #teacher_time_card_payment_form_verify_modal {
            position: fixed;
            inset: 0;
            z-index: 2000;
            /* z-[2000] */
            color: var(--ttcpf-verify-text);
        }

        .teacher_time_card_payment_form_verify_backdrop {
            position: absolute;
            inset: 0;
            background: rgba(18, 17, 23, .45);
        }

        /* Centering container */
        .teacher_time_card_payment_form_verify_container {
            position: relative;
            margin: 24px auto;
            /* my-6 */
            width: 100%;
            max-width: 520px;
            /* max-w-xl(~36rem) + some leeway */
            padding-left: 16px;
            padding-right: 16px;
            /* px-4 */
        }

        /* Card */
        .teacher_time_card_payment_form_verify_card {
            background: #fff;
            border: 1px solid var(--ttcpf-verify-border);
            border-radius: 6px;
            /* rounded-md */
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            margin-top: 115px;
            /* keep your offset */
            box-shadow: 0 16px 48px rgba(0, 0, 0, .18), 0 24px 64px rgba(0, 0, 0, .12);
        }

        /* Header */
        .teacher_time_card_payment_form_verify_header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 16px;
            padding-bottom: 8px;
            flex-shrink: 0;
        }

        .teacher_time_card_payment_form_verify_title {
            font-size: 20px;
            font-weight: 800;
            line-height: 1.75rem;
            margin: 0;
        }

        .teacher_time_card_payment_form_verify_closeX {
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            line-height: 0;
            border: none;
            background: #fff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background .15s ease;
        }

        .teacher_time_card_payment_form_verify_closeX:hover {
            background: #f3f4f6;
        }

        /* Body */
        .teacher_time_card_payment_form_verify_body {
            padding: 0 16px 16px 16px;
            display: block;
            overflow-y: auto;
            max-height: calc(88vh - 160px);
        }

        .teacher_time_card_payment_form_verify_body p {
            margin: 0 0 12px 0;
        }

        .teacher_time_card_payment_form_verify_muted {
            font-size: 15px;
            line-height: 1.5;
            color: var(--ttcpf-verify-muted);
        }

        .teacher_time_card_payment_form_verify_email {
            font-weight: 600;
            color: #121117;
        }

        /* OTP inputs row */
        .teacher_time_card_payment_form_verify_otp {
            display: flex;
            gap: 12px;
            margin: 12px 0;
        }

        .teacher_time_card_payment_form_verify_input {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            border: 1.5px solid var(--ttcpf-verify-border);
            text-align: center;
            font-size: 18px;
            outline: 0;
            transition: border-color .15s, box-shadow .15s;
        }

        .teacher_time_card_payment_form_verify_input:focus {
            border-color: var(--ttcpf-verify-focus);
            box-shadow: 0 0 0 4px var(--ttcpf-verify-shadow);
        }

        /* Info notice */
        .teacher_time_card_payment_form_verify_info {
            background: var(--ttcpf-verify-info-bg);
            border: 1px solid var(--ttcpf-verify-info-bd);
            border-radius: 10px;
            padding: 12px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .teacher_time_card_payment_form_verify_info_badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 18px;
            border: 1.6px solid #111827;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 12px;
            background: #fff;
            color: #111827;
            margin-top: 2px;
            user-select: none;
            flex: 0 0 auto;
        }

        .teacher_time_card_payment_form_verify_info_text {
            font-size: 14px;
            line-height: 22px;
            color: #121117;
            margin: 0;
        }

        /* Footer */
        .teacher_time_card_payment_form_verify_footer {
            padding: 0 16px 16px 16px;
            display: block;
            flex-shrink: 0;
        }

        .teacher_time_card_payment_form_verify_btn_primary,
        .teacher_time_card_payment_form_verify_btn_outline {
            width: 100%;
            height: 50px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            border: 1.5px solid transparent;
            cursor: pointer;
        }

        .teacher_time_card_payment_form_verify_btn_primary {
            color: #fff;
            background: linear-gradient(180deg, #ff5a2f, #ff3b1f);
        }

        .teacher_time_card_payment_form_verify_btn_outline {
            background: #fff;
            color: #121117;
            border-color: #121117;
            margin-top: 12px;
        }

        /* Responsive niceties */
        @media (max-width:480px) {
            .teacher_time_card_payment_form_verify_title {
                font-size: 18px;
            }

            .teacher_time_card_payment_form_verify_input {
                width: 44px;
                height: 44px;
            }
        }
    </style>
</head>

<body>

    <div id="teacher_time_card_payment_form_verify_modal" class="hidden">
        <div class="teacher_time_card_payment_form_verify_backdrop"></div>

        <div class="teacher_time_card_payment_form_verify_container">
            <div class="teacher_time_card_payment_form_verify_card">
                <!-- Header -->
                <div class="teacher_time_card_payment_form_verify_header">
                    <h3 class="teacher_time_card_payment_form_verify_title">Verify your withdrawal to proceed</h3>
                    <button id="teacher_time_card_payment_form_verify_close"
                        class="teacher_time_card_payment_form_verify_closeX" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="teacher_time_card_payment_form_verify_body">
                    <p class="teacher_time_card_payment_form_verify_muted">
                        To help us make sure it’s really you, please enter a 6-digit verification code we sent to
                        <span id="teacher_time_card_payment_form_verify_email"
                            class="teacher_time_card_payment_form_verify_email">
                            name@example.com
                        </span>
                    </p>

                    <!-- 6 OTP boxes -->
                    <div class="teacher_time_card_payment_form_verify_otp">
                        <input inputmode="numeric" maxlength="1" class="teacher_time_card_payment_form_verify_input" />
                        <input inputmode="numeric" maxlength="1" class="teacher_time_card_payment_form_verify_input" />
                        <input inputmode="numeric" maxlength="1" class="teacher_time_card_payment_form_verify_input" />
                        <input inputmode="numeric" maxlength="1" class="teacher_time_card_payment_form_verify_input" />
                        <input inputmode="numeric" maxlength="1" class="teacher_time_card_payment_form_verify_input" />
                        <input inputmode="numeric" maxlength="1" class="teacher_time_card_payment_form_verify_input" />
                    </div>

                    <!-- Info notice -->
                    <div class="teacher_time_card_payment_form_verify_info">
                        <span class="teacher_time_card_payment_form_verify_info_badge">i</span>
                        <p class="teacher_time_card_payment_form_verify_info_text">
                            Please keep this window open until you have entered the code.
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="teacher_time_card_payment_form_verify_footer">
                    <button id="teacher_time_card_payment_form_verify_proceed"
                        class="teacher_time_card_payment_form_verify_btn_primary">
                        Proceed
                    </button>
                    <button id="teacher_time_card_payment_form_verify_resend"
                        class="teacher_time_card_payment_form_verify_btn_outline">
                        Request a new code
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function($) {
            const $vm = $('#teacher_time_card_payment_form_verify_modal');
            const $inputs = $vm.find('.teacher_time_card_payment_form_verify_input');
            const $email = $('#teacher_time_card_payment_form_verify_email');

            // Public API
            window.teacher_time_card_payment_form_verify_open = function(email) {
                if (email) $email.text(email);
                $vm.removeClass('hidden');
                setTimeout(() => $inputs.first().trigger('focus'), 50);
            };
            window.teacher_time_card_payment_form_verify_close = function() {
                $vm.addClass('hidden');
                $inputs.val('');
            };

            // Close handlers
            $('#teacher_time_card_payment_form_verify_close').on('click', window
                .teacher_time_card_payment_form_verify_close);
            $vm.on('click', function(e) {
                if (!$(e.target).closest('.teacher_time_card_payment_form_verify_card').length) {
                    window.teacher_time_card_payment_form_verify_close();
                }
            });
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && !$vm.hasClass('hidden')) {
                    window.teacher_time_card_payment_form_verify_close();
                }
            });

            // OTP logic
            $inputs.on('input', function() {
                this.value = this.value.replace(/\D/g, '').slice(0, 1);
                if (this.value && this.nextElementSibling) {
                    this.nextElementSibling.focus();
                }
            });
            $inputs.on('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && this.previousElementSibling) {
                    this.previousElementSibling.focus();
                }
                if (e.key >= '0' && e.key <= '9' && this.value) {
                    this.value = ''; // allow overwrite; input event will advance
                }
            });
            $inputs.first().on('paste', function(e) {
                const t = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0,
                    6);
                if (!t) return;
                e.preventDefault();
                $inputs.each(function(i) {
                    this.value = t[i] || '';
                });
                const target = $inputs.get(Math.min(t.length, 5));
                if (target) target.focus();
            });

            // Button demos (replace with AJAX)
            $('#teacher_time_card_payment_form_verify_proceed').on('click', function() {
                const code = $inputs.map(function() {
                    return this.value;
                }).get().join('');
                if (code.length !== 6) {
                    alert('Please enter the 6-digit code.');
                    return;
                }
                alert('Code submitted: ' + code);
                window.teacher_time_card_payment_form_verify_close();
            });
            $('#teacher_time_card_payment_form_verify_resend').on('click', function() {
                alert('A new code has been requested.');
            });
        })(jQuery);
    </script>

</body>

</html>