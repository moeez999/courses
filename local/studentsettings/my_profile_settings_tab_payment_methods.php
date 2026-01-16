<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment methods</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_profile_settings_tab_payment_methods_border: #E4E7EE;
            --my_profile_settings_tab_payment_methods_text: #111827;
            --my_profile_settings_tab_payment_methods_muted: #6B7280;
            --my_profile_settings_tab_payment_methods_hint: #4B5563;
            --my_profile_settings_tab_payment_methods_success_bg: #DFF4EA;
            --my_profile_settings_tab_payment_methods_btn_border: #111111;
            --my_profile_settings_tab_payment_methods_disabled: #D1D5DB;
            --my_profile_settings_tab_payment_methods_radius: 12px;
            --my_profile_settings_tab_payment_methods_card_w: 720px;
            --my_profile_settings_tab_payment_methods_red: #FF3B11;
            --my_profile_settings_tab_payment_methods_red_hover: #e2340f;
        }

        .my_profile_settings_tab_payment_methods_wrapper {
            color: var(--my_profile_settings_tab_payment_methods_text);
        }

        .my_profile_settings_tab_payment_methods_card {
            width: 100%;
            max-width: var(--my_profile_settings_tab_payment_methods_card_w);
            border: 1px solid var(--my_profile_settings_tab_payment_methods_border);
            border-radius: var(--my_profile_settings_tab_payment_methods_radius);
            background: #fff;
        }

        .my_profile_settings_tab_payment_methods_row {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .my_profile_settings_tab_payment_methods_tag {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .625rem .875rem;
            border-radius: 10px;
            background: var(--my_profile_settings_tab_payment_methods_success_bg);
            font-weight: 600;
        }

        .my_profile_settings_tab_payment_methods_btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .55rem .95rem;
            border: 1px solid var(--my_profile_settings_tab_payment_methods_btn_border);
            border-radius: 10px;
            background: #fff;
            font-weight: 600;
            transition: background .12s ease;
        }

        .my_profile_settings_tab_payment_methods_btn:hover {
            background: #F6F7FB;
        }

        .my_profile_settings_tab_payment_methods_btn--muted {
            border-color: var(--my_profile_settings_tab_payment_methods_disabled);
            color: #374151;
            background: #F9FAFB;
        }

        .my_profile_settings_tab_payment_methods_btn--muted:hover {
            background: #F3F4F6;
        }

        .my_profile_settings_tab_payment_methods_badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--my_profile_settings_tab_payment_methods_border);
            border-radius: 8px;
            padding: .25rem .5rem;
            font-weight: 800;
            background: #fff;
        }

        .my_profile_settings_tab_payment_methods_footnote {
            color: var(--my_profile_settings_tab_payment_methods_hint);
            font-size: .9rem;
        }

        /* ===================== MODAL ===================== */
        .my_profile_settings_tab_payment_methods_overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: saturate(100%) blur(1px);
            display: none;
            z-index: 9998;
        }

        .my_profile_settings_tab_payment_methods_modal {
            position: fixed;
            inset: 0;
            display: none;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .my_profile_settings_tab_payment_methods_modal_card {
            width: 100%;
            max-width: 480px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, .18);
            border: 1px solid rgba(0, 0, 0, .06);
        }

        .my_profile_settings_tab_payment_methods_modal_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 22px 10px 22px;
        }

        .my_profile_settings_tab_payment_methods_modal_close {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
        }

        .my_profile_settings_tab_payment_methods_modal_close:hover {
            background: #F3F4F6;
        }

        .my_profile_settings_tab_payment_methods_input {
            width: 100%;
            border: 1px solid var(--my_profile_settings_tab_payment_methods_border);
            border-radius: 5px;
            background: #fff;
            padding: .7rem .9rem;
            line-height: 1.35;
        }

        .my_profile_settings_tab_payment_methods_input:focus {
            outline: none;
            border-color: #C7CDD8;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
        }

        /* floating tiny labels like snapshot */
        .my_profile_settings_tab_payment_methods_flabel {
            position: absolute;
            top: -10px;
            left: 12px;
            background: #fff;
            padding: 0 8px;
            font-size: .75rem;
            color: #6B7280;
            border-radius: 6px;
            border: 1px solid var(--my_profile_settings_tab_payment_methods_border);
            line-height: 1.1;
        }
        
        .my_profile_settings_tab_payment_methods_save {
            background: var(--my_profile_settings_tab_payment_methods_red);
            color: #fff;
            font-weight: 600;
            border: 2px solid #000;
            border-radius: 5px;
            padding: 10px 20px;
            width: 100%;
            transition: background .15s ease;
        }

        .my_profile_settings_tab_payment_methods_save:hover {
            background: var(--my_profile_settings_tab_payment_methods_red_hover);
        }

        .my_profile_settings_tab_payment_methods_privacy {
            background: #f3f9ff;
            border: 1px solid var(--my_profile_settings_tab_payment_methods_border);
            border-radius: 5px;
            font-size: .82rem;
            color: #4B5563;
            padding: 14px;
        }

        @media (max-width: 640px) {
            .my_profile_settings_tab_payment_methods_btn {
                width: 100%;
            }

            .my_profile_settings_tab_payment_methods_actions {
                gap: .5rem;
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>

<body class="bg-white antialiased">

    <div class="my_profile_settings_tab_payment_methods_wrapper max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-semibold mb-6">Payment methods</h1>

        <!-- Latingles Credit -->
        <section class="my_profile_settings_tab_payment_methods_card p-3 mb-5" style="width:70%;">
            <h2 class="font-semibold mb-4">Latingles Credit</h2>

            <div class="my_profile_settings_tab_payment_methods_tag mb-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="shrink-0">
                    <path d="M3 7.5h14.5a2 2 0 0 1 2 2V17a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7.5z" stroke="#111827" stroke-width="1.5" />
                    <path d="M3 7.5V6a2 2 0 0 1 2-2h10.5v3.5" stroke="#111827" stroke-width="1.5" />
                    <circle cx="17" cy="12.5" r="1.25" fill="#111827" />
                </svg>
                <span>Your current latingles credit is $2</span>
            </div>

            <p class="text-gray-600">Your current latingles credit is $2</p>
        </section>

        <!-- Credit / debit card -->
        <section class="my_profile_settings_tab_payment_methods_card p-3" style="width:70%;">
            <h2 class="font-semibold mb-4">Credit or debit card</h2>

            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="my_profile_settings_tab_payment_methods_row">
                    <span class="my_profile_settings_tab_payment_methods_badge">VISA</span>
                    <span class="text-gray-800">Visa **** 6543</span>
                </div>

                <div class="my_profile_settings_tab_payment_methods_actions flex items-center gap-3">
                    <button type="button" id="my_profile_settings_tab_payment_methods_change_btn"
                        class="my_profile_settings_tab_payment_methods_btn">Change card</button>
                    <button type="button" id="my_profile_settings_tab_payment_methods_remove_btn"
                        class="my_profile_settings_tab_payment_methods_btn my_profile_settings_tab_payment_methods_btn--muted">Remove</button>
                </div>
            </div>

            <p class="text-gray-600 mt-4">To remove, cancel your subscriptions first</p>
        </section>

        <div class="flex items-center gap-2 mt-4">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M6.5 10.5V8A5.5 5.5 0 0 1 12 2.5 5.5 5.5 0 0 1 17.5 8v2.5" stroke="#111827" stroke-width="1.5" />
                <rect x="4" y="10.5" width="16" height="11" rx="2" stroke="#111827" stroke-width="1.5" />
            </svg>
            <p class="my_profile_settings_tab_payment_methods_footnote">
                Latingles uses industry-standard encryption to protect your information
            </p>
        </div>
    </div>

    <!-- =================== MODAL + OVERLAY =================== -->
    <div id="my_profile_settings_tab_payment_methods_overlay" class="my_profile_settings_tab_payment_methods_overlay"></div>

    <div id="my_profile_settings_tab_payment_methods_modal" class="my_profile_settings_tab_payment_methods_modal">
        <div class="my_profile_settings_tab_payment_methods_modal_card">
            <!-- header -->
            <div class="my_profile_settings_tab_payment_methods_modal_header">
                <h3 class="text-[22px] font-semibold">Save A Payment Card</h3>
                <button id="my_profile_settings_tab_payment_methods_modal_close"
                    class="my_profile_settings_tab_payment_methods_modal_close" aria-label="Close">
                    ×
                </button>
            </div>

            <!-- body -->
            <div class="px-3 pb-3">
                <!-- Cardholder -->
                <div class="relative mb-4 mt-4">
                    <span class="my_profile_settings_tab_payment_methods_flabel">Cardholder Name</span>
                    <input id="my_profile_settings_tab_payment_methods_name"
                        type="text"
                        class="my_profile_settings_tab_payment_methods_input"
                        placeholder="Haider Ali" value="Haider Ali">
                </div>

                <!-- Card number -->
                <div class="relative mb-4">
                    <span class="my_profile_settings_tab_payment_methods_flabel">Card Number</span>
                    <input id="my_profile_settings_tab_payment_methods_number"
                        type="text"
                        class="my_profile_settings_tab_payment_methods_input"
                        placeholder="5218 – 9811 – 4323 – 5216">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <!-- Expire -->
                    <div class="relative">
                        <span class="my_profile_settings_tab_payment_methods_flabel">Expire Date</span>
                        <input id="my_profile_settings_tab_payment_methods_expiry"
                            type="text"
                            class="my_profile_settings_tab_payment_methods_input"
                            placeholder="09 / 2025" value="09 / 2025">
                    </div>
                    <!-- CVC -->
                    <div class="relative">
                        <span class="my_profile_settings_tab_payment_methods_flabel">Security Code</span>
                        <input id="my_profile_settings_tab_payment_methods_cvc"
                            type="text"
                            class="my_profile_settings_tab_payment_methods_input"
                            placeholder="CVC / CVV">
                    </div>
                </div>

                <!-- Save btn -->
                <button id="my_profile_settings_tab_payment_methods_save"
                    class="my_profile_settings_tab_payment_methods_save mb-4">Save Card</button>

                <!-- privacy note -->
                <div class="my_profile_settings_tab_payment_methods_privacy">
                    Your privacy and security are our top priority. Rest assured, we do not store any of your payment information, ensuring a safe and seamless experience every time.
                </div>
            </div>
        </div>
    </div>

    <script>
        function my_profile_settings_tab_payment_methods_init() {
            // open
            $('#my_profile_settings_tab_payment_methods_change_btn').on('click', function() {
                $('#my_profile_settings_tab_payment_methods_overlay').fadeIn(120);
                $('#my_profile_settings_tab_payment_methods_modal').fadeIn(120).css('display', 'flex');
            });

            // close
            function my_profile_settings_tab_payment_methods_close() {
                $('#my_profile_settings_tab_payment_methods_modal').fadeOut(120, () => $(this).hide());
                $('#my_profile_settings_tab_payment_methods_overlay').fadeOut(120);
            }
            $('#my_profile_settings_tab_payment_methods_modal_close, #my_profile_settings_tab_payment_methods_overlay').on('click', my_profile_settings_tab_payment_methods_close);

            // demo Save
            $('#my_profile_settings_tab_payment_methods_save').on('click', function() {
                alert('Card saved (demo)');
                // You can validate & send AJAX here.
                // After success:
                $('#my_profile_settings_tab_payment_methods_modal_close').click();
            });

            // Light mask: card number grouping #### – #### – #### – ####
            $('#my_profile_settings_tab_payment_methods_number').on('input', function() {
                const v = $(this).val().replace(/[^\d]/g, '').slice(0, 16);
                const parts = v.match(/.{1,4}/g) || [];
                $(this).val(parts.join(' – '));
            });

            // Expiry mask: MM / YYYY
            $('#my_profile_settings_tab_payment_methods_expiry').on('input', function() {
                const v = $(this).val().replace(/[^\d]/g, '').slice(0, 6);
                let out = '';
                if (v.length <= 2) {
                    out = v;
                } else {
                    out = v.slice(0, 2) + ' / ' + v.slice(2);
                }
                $(this).val(out);
            });

            // CVC mask: 3–4 digits
            $('#my_profile_settings_tab_payment_methods_cvc').on('input', function() {
                $(this).val($(this).val().replace(/[^\d]/g, '').slice(0, 4));
            });

            // Remove (demo)
            $('#my_profile_settings_tab_payment_methods_remove_btn').on('click', function() {
                alert('To remove this card, cancel your subscriptions first (demo).');
            });
        }

        $(document).ready(my_profile_settings_tab_payment_methods_init);
    </script>
</body>

</html>