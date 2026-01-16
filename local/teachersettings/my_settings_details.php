<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Settings – Change Password</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --my_settings_details_tab_password_text: #0F172A;
            --my_settings_details_tab_password_muted: #64748B;
            --my_settings_details_tab_password_border: #E5E7EB;
            --my_settings_details_tab_password_soft: #F8FAFC;
            --my_settings_details_tab_password_accent: #FF3B2F;
        }

        html,
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
        }

        .my_settings_details_tab_password_btn-primary {
            border: 1.8px solid #000;
            /* black border per design */
            background: var(--my_settings_details_tab_password_accent);
            color: #fff;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .08);
            transition: transform .05s ease, box-shadow .15s ease;
        }

        .my_settings_details_tab_password_btn-primary:active {
            transform: translateY(1px);
        }

        .my_settings_details_tab_password_btn-primary:focus-visible {
            outline: 2px solid #000;
            outline-offset: 2px;
        }

        .my_settings_details_tab_password_tab {
            border-left: 4px solid transparent;
            color: var(--my_settings_details_tab_password_text);
        }

        .my_settings_details_tab_password_tab-active {
            border-left-color: var(--my_settings_details_tab_password_accent);
            font-weight: 600;
            background: #fff;
        }

        .my_settings_details_tab_password_input {
            border: 1px solid var(--my_settings_details_tab_password_border);
            outline: none;
        }

        .my_settings_details_tab_password_input:focus {
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, .08);
        }

        @media (max-width:1024px) {
            .my_settings_details_tab_password_tabs-scroll {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>

<body class="bg-white text-[color:var(--my_settings_details_tab_password_text)]">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-12 gap-8">
            <!-- Sidebar -->
            <aside class="col-span-12 lg:col-span-3">
                <nav class="my_settings_details_tab_password_tabs-scroll bg-white rounded-xl border border-[color:var(--my_settings_details_tab_password_border)] p-2 lg:p-0 lg:border-0">
                    <ul class="space-y-1 lg:space-y-0">
                        <li>
                            <button id="my_settings_details_tab_password_tab_password" data-tab="password"
                                class="my_settings_details_tab_password_tab my_settings_details_tab_password_tab-active w-full text-left px-4 py-3 rounded-md lg:rounded-none hover:bg-[color:var(--my_settings_details_tab_password_soft)]">
                                Password
                            </button>
                        </li>
                        <li>
                            <button id="my_settings_details_tab_password_tab_taxes" data-tab="taxes"
                                class="my_settings_details_tab_password_tab w-full text-left px-4 py-3 rounded-md lg:rounded-none hover:bg-[color:var(--my_settings_details_tab_password_soft)]">
                                Taxes
                            </button>
                        </li>
                        <li>
                            <button id="my_settings_details_tab_password_tab_notifications" data-tab="notifications"
                                class="my_settings_details_tab_password_tab w-full text-left px-4 py-3 rounded-md lg:rounded-none hover:bg-[color:var(--my_settings_details_tab_password_soft)]">
                                Notifications
                            </button>
                        </li>
                        <li>
                            <button id="my_settings_details_tab_password_tab_delete" data-tab="delete"
                                class="my_settings_details_tab_password_tab w-full text-left px-4 py-3 rounded-md lg:rounded-none hover:bg-[color:var(--my_settings_details_tab_password_soft)]">
                                Delete account
                            </button>
                        </li>
                        <li>
                            <button id="my_settings_details_tab_password_tab_history" data-tab="history"
                                class="my_settings_details_tab_password_tab w-full text-left px-4 py-3 rounded-md lg:rounded-none hover:bg-[color:var(--my_settings_details_tab_password_soft)]">
                                Payment history
                            </button>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Content -->
            <section class="col-span-12 lg:col-span-9">
                <!-- PASSWORD (full content – unchanged) -->
                <div id="my_settings_details_tab_password_panel_password" class="my_settings_details_tab_password_panel">
                    <h1 class="text-3xl sm:text-[32px] font-semibold tracking-tight mb-6">Change Password</h1>

                    <form class="space-y-5 max-w-2xl">
                        <!-- Current password -->
                        <div>
                            <label for="my_settings_details_tab_password_current" class="block text-sm font-medium mb-2">Current password</label>
                            <div class="relative">
                                <input id="my_settings_details_tab_password_current" type="password"
                                    class="my_settings_details_tab_password_input w-full rounded-md px-3.5 py-2.5 pr-10"
                                    placeholder="Enter current password" />
                                <button type="button" class="my_settings_details_tab_password_eye absolute inset-y-0 right-0 px-3 flex items-center"
                                    data-target="#my_settings_details_tab_password_current" aria-label="Toggle current password visibility">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                        <circle cx="12" cy="12" r="3.5"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Forgot link -->
                        <div>
                            <a href="#" class="text-sm font-medium underline underline-offset-2 hover:no-underline">Forgot your password?</a>
                        </div>

                        <!-- New password -->
                        <div>
                            <label for="my_settings_details_tab_password_new" class="block text-sm font-medium mb-2">New password</label>
                            <div class="relative">
                                <input id="my_settings_details_tab_password_new" type="password"
                                    class="my_settings_details_tab_password_input w-full rounded-md px-3.5 py-2.5 pr-10"
                                    placeholder="Enter new password" />
                                <button type="button" class="my_settings_details_tab_password_eye absolute inset-y-0 right-0 px-3 flex items-center"
                                    data-target="#my_settings_details_tab_password_new" aria-label="Toggle new password visibility">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                        <circle cx="12" cy="12" r="3.5"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Verify password -->
                        <div>
                            <label for="my_settings_details_tab_password_verify" class="block text-sm font-medium mb-2">Verify password</label>
                            <div class="relative">
                                <input id="my_settings_details_tab_password_verify" type="password"
                                    class="my_settings_details_tab_password_input w-full rounded-md px-3.5 py-2.5 pr-10"
                                    placeholder="Re-enter new password" />
                                <button type="button" class="my_settings_details_tab_password_eye absolute inset-y-0 right-0 px-3 flex items-center"
                                    data-target="#my_settings_details_tab_password_verify" aria-label="Toggle verify password visibility">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                        <circle cx="12" cy="12" r="3.5"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Save button -->
                        <div class="pt-2">
                            <button type="button" id="my_settings_details_tab_password_save_btn" style="width:100%;"
                                class="my_settings_details_tab_password_btn-primary inline-flex items-center justify-center rounded-md px-6 py-3 text-base font-semibold">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>


                <!-- TAXES (heading + dummy text) -->
                <div id="my_settings_details_tab_password_panel_taxes" class="my_settings_details_tab_password_panel hidden">
                    <?php require('my_settings_details_tab_taxes.php'); ?>
                </div>

                <!-- NOTIFICATIONS (heading + dummy text) -->
                <div id="my_settings_details_tab_password_panel_notifications" class="my_settings_details_tab_password_panel hidden">
                    <?php require('my_settings_details_tab_notification.php'); ?>
                </div>

                <!-- DELETE ACCOUNT (heading + dummy text) -->
                <div id="my_settings_details_tab_password_panel_delete" class="my_settings_details_tab_password_panel hidden">
                    <?php require('my_settings_details_tab_delete_account.php'); ?>
                </div>

                <!-- PAYMENT HISTORY (heading + dummy text) -->
                <div id="my_settings_details_tab_password_panel_history" class="my_settings_details_tab_password_panel hidden">
                    <?php require('my_settings_details_tab_payment_history.php'); ?>
                </div>
            </section>
        </div>
    </div>

    <script>
        /* ===========================
       Prefix: my_settings_details_tab_password
       =========================== */

        function my_settings_details_tab_password_activateTab(tabKey) {
            // buttons
            $('.my_settings_details_tab_password_tab').removeClass('my_settings_details_tab_password_tab-active');
            $('#my_settings_details_tab_password_tab_' + tabKey).addClass('my_settings_details_tab_password_tab-active');

            // panels
            $('.my_settings_details_tab_password_panel').addClass('hidden');
            $('#my_settings_details_tab_password_panel_' + tabKey).removeClass('hidden');
        }

        function my_settings_details_tab_password_toggleEye(targetSelector) {
            const $input = $(targetSelector);
            $input.attr('type', $input.attr('type') === 'password' ? 'text' : 'password');
        }

        $(function() {
            // Default tab
            my_settings_details_tab_password_activateTab('password');

            // Hash deep-link (optional)
            const hash = window.location.hash.replace('#', '').trim();
            if (['password', 'taxes', 'notifications', 'delete', 'history'].includes(hash)) {
                my_settings_details_tab_password_activateTab(hash);
            }

            // Tab click handler
            $('.my_settings_details_tab_password_tab').on('click', function() {
                const key = $(this).data('tab');
                my_settings_details_tab_password_activateTab(key);
                history.replaceState(null, '', '#' + key); // optional
            });

            // Eye toggles
            $('.my_settings_details_tab_password_eye').on('click', function() {
                my_settings_details_tab_password_toggleEye($(this).data('target'));
            });

            // Demo save action
            $('#my_settings_details_tab_password_save_btn').on('click', function() {
                const $btn = $(this);
                $btn.text('Saved').prop('disabled', true);
                setTimeout(() => {
                    $btn.text('Save changes').prop('disabled', false);
                }, 1200);
            });
        });
    </script>
</body>

</html>