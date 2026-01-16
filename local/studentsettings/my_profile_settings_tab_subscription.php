<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Subscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        :root {
            --my_profile_settings_tab_subscription_border: #E4E7EE;
            --my_profile_settings_tab_subscription_text: #111827;
            --my_profile_settings_tab_subscription_radius: 12px;
            --my_profile_settings_tab_subscription_shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        .my_profile_settings_tab_subscription_card {
            border: 1px solid var(--my_profile_settings_tab_subscription_border);
            border-radius: var(--my_profile_settings_tab_subscription_radius);
            background: #fff;
            position: relative;
        }

        /* defensive: prevent unexpected ::before/::after content inside the card */
        .my_profile_settings_tab_subscription_card *,
        .my_profile_settings_tab_subscription_card *::before,
        .my_profile_settings_tab_subscription_card *::after {
            counter-reset: none !important;
        }

        /* 3-dot + dropdown */
        .my_profile_settings_tab_subscription_dotbtn {
            width: 34px;
            height: 34px;
            border: 1px solid var(--my_profile_settings_tab_subscription_border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            cursor: pointer;
        }

        .my_profile_settings_tab_subscription_dropdown {
            position: absolute;
            top: 60px;
            right: 10px;
            width: 310px;
            background: #fff;
            border: 1px solid var(--my_profile_settings_tab_subscription_border);
            border-radius: 12px;
            box-shadow: var(--my_profile_settings_tab_subscription_shadow);
            padding: 8px 0;
            display: none;
            z-index: 100;
        }

        .my_profile_settings_tab_subscription_dropdown.show {
            display: block;
        }

        .my_profile_settings_tab_subscription_item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            cursor: pointer;
            color: var(--my_profile_settings_tab_subscription_text);
            font-weight: 500;
            transition: background .15s;
        }

        .my_profile_settings_tab_subscription_item:hover {
            background: #F8F9FB;
        }

        .my_profile_settings_tab_subscription_icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }
    </style>
</head>

<body class="bg-white antialiased">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-semibold mb-6">Manage your subscription</h1>

        <div id="my_profile_settings_tab_subscription_card" class="my_profile_settings_tab_subscription_card p-5 mb-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-4">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                        alt="tutor" class="w-14 h-14 rounded-lg object-cover" />
                    <div>
                        <div class="font-semibold">Dainiela</div>
                        <div class="text-sm text-gray-600">English | 20 lessons – $119.60 every 4 weeks</div>
                    </div>
                </div>

                <!-- 3 dots -->
                <button id="my_profile_settings_tab_subscription_dots"
                    class="my_profile_settings_tab_subscription_dotbtn" aria-label="Open menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor">
                        <circle cx="5" cy="12" r="2" />
                        <circle cx="12" cy="12" r="2" />
                        <circle cx="19" cy="12" r="2" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div id="my_profile_settings_tab_subscription_dropdown" class="my_profile_settings_tab_subscription_dropdown">
                    <div class="my_profile_settings_tab_subscription_item my_lesson_tutor_detail_change_your_plan_button">
                        <!-- $ icon -->
                        <svg class="my_profile_settings_tab_subscription_icon" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" fill="#000" />
                            <path d="M13.8 9.2c0-.77-.62-1.2-1.8-1.2-1.14 0-1.86.42-2.1 1.28m0 0c-.06.2-.1.42-.1.64 0 .97.62 1.42 2.1 1.74l.7.15c1.66.36 2.4.94 2.4 2.06 0 1.34-1.1 2.17-2.9 2.17-1.78 0-2.94-.77-3.02-2.19m0 0" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 6.5v1.2m0 8.6v1.2" stroke="#fff" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                        Change your plan
                    </div>

                    <div class="my_profile_settings_tab_subscription_item">
                        <!-- refresh -->
                        <svg class="my_profile_settings_tab_subscription_icon" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a7 7 0 0 1 12.49-4.13M21 12a7 7 0 0 1-12.49 4.13" />
                            <path d="M9 5H4V0" />
                            <path d="M15 19h5v5" />
                        </svg>
                        Change renewal date
                    </div>

                    <div class="my_profile_settings_tab_subscription_item">
                        <!-- wallet -->
                        <svg class="my_profile_settings_tab_subscription_icon" viewBox="0 0 24 24">
                            <path d="M3 7h15a3 3 0 0 1 3 3v7a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7z" fill="#000" />
                            <path d="M3 7V6a3 3 0 0 1 3-3h12v4" fill="#000" />
                            <circle cx="18" cy="13" r="1.6" fill="#fff" />
                        </svg>
                        Add extra lessons
                    </div>

                    <div class="my_profile_settings_tab_subscription_item">
                        <!-- transfer -->
                        <svg class="my_profile_settings_tab_subscription_icon" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a7 7 0 0 1 12.49-4.13M21 12a7 7 0 0 1-12.49 4.13" />
                            <path d="M9 5H4V0" />
                            <path d="M15 19h5v5" />
                        </svg>
                        Transfer lessons or subscription
                    </div>

                    <div class="my_profile_settings_tab_subscription_item">
                        <!-- cancel -->
                        <svg class="my_profile_settings_tab_subscription_icon" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" fill="none" stroke="#FF3B11" stroke-width="2.2" />
                            <path d="M6.7 17.3 17.3 6.7" stroke="#FF3B11" stroke-width="2.2" stroke-linecap="round" />
                        </svg>
                        <span class="text-red-500">Cancel Subscription</span>
                    </div>
                </div>
            </div>

            <!-- <div class="h-px bg-gray-200 my-4"></div> -->
            <div class="text-sm font-semibold">Renews in 14 days (Jan 30, 2025) | 1 lesson left</div>
        </div>
    </div>

    <script>
        /* Remove any rogue bare-number text nodes (e.g., '200') inside the card */
        function my_profile_settings_tab_subscription_strip_digits(rootSel) {
            const root = document.querySelector(rootSel);
            if (!root) return;
            const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
            const toRemove = [];
            while (walker.nextNode()) {
                const t = walker.currentNode;
                // If the node is ONLY digits (with optional surrounding whitespace), remove it
                if (/^\s*\d+\s*$/.test(t.nodeValue)) {
                    toRemove.push(t);
                }
            }
            toRemove.forEach(n => n.parentNode && n.parentNode.removeChild(n));
        }

        function my_profile_settings_tab_subscription_init() {
            const $menu = $('#my_profile_settings_tab_subscription_dropdown');
            const $btn = $('#my_profile_settings_tab_subscription_dots');

            // Toggle dropdown
            $btn.on('click', function(e) {
                e.stopPropagation();
                $menu.toggleClass('show');
                // sanitize in case any theme injects text
                my_profile_settings_tab_subscription_strip_digits('#my_profile_settings_tab_subscription_card');
            });

            // Close when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#my_profile_settings_tab_subscription_dropdown, #my_profile_settings_tab_subscription_dots').length) {
                    $menu.removeClass('show');
                }
            });

            // Run sanitizer on load as well
            my_profile_settings_tab_subscription_strip_digits('#my_profile_settings_tab_subscription_card');
        }

        $(document).ready(my_profile_settings_tab_subscription_init);
    </script>






    <!-- <link rel="stylesheet" href="css/my_lesson_details_tutor_details.css"> -->
    <link rel="stylesheet" href="css/my_lesson_details_tutor_details_change_your_plan.css">

    <?php require_once('my_lesson_details_tutor_details_change_your_plan.php'); ?>
    <script src="js/my_lessons_details_tutor_details_change_your_plan.js"></script>

</body>

</html>