<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Next Steps Preview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Optional font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        /* ---- Base ---- */
        body {
            margin: 0;
            font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f5f5f7;
            color: #111827;
        }

        button {
            font-family: inherit;
        }

        /* ---- Page Wrapper ---- */
        .my_student_details_menu_share_next_step_details_preview_page_wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            /* space for fixed footer */
            padding-bottom: 80px;
        }

        /* ---- Top Preview Bar ---- */
        .my_student_details_menu_share_next_step_details_preview_preview_bar {
            background-color: #fff7d6;
            border-bottom: 1px solid #f3e8a3;
            padding: 10px 380px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wrapper-course {
            padding: 30px 0px !important;
        }

        .my_student_details_menu_share_next_step_details_preview_preview_bar_icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .my_student_details_menu_share_next_step_details_preview_preview_bar_text strong {
            font-weight: 600;
            margin-right: 4px;
        }

        /* ---- Main Content ---- */
        .my_student_details_menu_share_next_step_details_preview_main {
            flex: 1;
            padding: 32px 40px 24px;
            display: flex;
            justify-content: center;
        }

        .my_student_details_menu_share_next_step_details_preview_main_inner {
            width: 100%;
            max-width: 1180px;
        }

        .my_student_details_menu_share_next_step_details_preview_layout {
            display: flex;
            gap: 32px;
            align-items: flex-start;
        }

        /* ---- Left Column ---- */
        .my_student_details_menu_share_next_step_details_preview_left {
            flex: 1.1;
        }

        .my_student_details_menu_share_next_step_details_preview_title_row {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 12px;
        }

        .my_student_details_menu_share_next_step_details_preview_title_icon {
            width: 72px;
            height: 72px;
            flex-shrink: 0;
        }

        .my_student_details_menu_share_next_step_details_preview_title {
            font-size: 40px;
            line-height: 1.1;
            font-weight: 700;
            margin: 0;
        }

        .my_student_details_menu_share_next_step_details_preview_subtitle {
            font-size: 16px;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .my_student_details_menu_share_next_step_details_preview_message_card {
            background-color: #ffffff;
            border-radius: 5px;
            border: 1px solid #000000;
            /* black border */
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.08);
        }

        .my_student_details_menu_share_next_step_details_preview_message_avatar {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .my_student_details_menu_share_next_step_details_preview_message_avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .my_student_details_menu_share_next_step_details_preview_message_name {
            font-weight: 600;
            font-size: 15px;
        }

        /* ---- Right Column ---- */
        .my_student_details_menu_share_next_step_details_preview_right {
            flex: 0.9;
        }

        .my_student_details_menu_share_next_step_details_preview_next_steps_card {
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid #000000;
            /* black border */
            padding: 20px 22px;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.08);
        }

        .my_student_details_menu_share_next_step_details_preview_next_steps_title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 14px;
        }

        .my_student_details_menu_share_next_step_details_preview_divider {
            height: 1px;
            background-color: #e5e7eb;
            margin-bottom: 18px;
        }

        .my_student_details_menu_share_next_step_details_preview_next_steps_item {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            font-weight: 500;
        }

        .my_student_details_menu_share_next_step_details_preview_calendar_icon_wrap {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e5f6f4;
            flex-shrink: 0;
        }

        .my_student_details_menu_share_next_step_details_preview_calendar_icon_img {
            width: 20px;
            height: 20px;
            display: block;
        }

        /* ---- Fixed Bottom Bar ---- */
        .my_student_details_menu_share_next_step_details_preview_bottom_bar {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 10px 40px 14px;
            display: flex;
            justify-content: center;
            z-index: 50;
            box-shadow: 0 -4px 10px rgba(15, 23, 42, 0.06);
        }

        .my_student_details_menu_share_next_step_details_preview_bottom_inner {
            width: 100%;
            max-width: 1180px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .my_student_details_menu_share_next_step_details_preview_button_secondary,
        .my_student_details_menu_share_next_step_details_preview_button_primary {
            border-radius: 5px;
            /* requested */
            padding: 10px 20px;
            /* closer to screenshot */
            font-size: 14px;
            font-weight: 500;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            background-color: transparent;
            transition: background-color 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease,
                transform 0.05s ease;
        }

        .my_student_details_menu_share_next_step_details_preview_button_secondary {
            border-color: #d1d5db;
            background-color: #ffffff;
        }

        .my_student_details_menu_share_next_step_details_preview_button_secondary:hover {
            background-color: #f9fafb;
        }

        .my_student_details_menu_share_next_step_details_preview_button_primary {
            background-color: #ede9fe;
            color: #111827;
            border-color: #d4cffb;
            box-shadow: 0 4px 10px rgba(148, 132, 245, 0.35);
        }

        .my_student_details_menu_share_next_step_details_preview_button_primary:hover {
            background-color: #ddd6fe;
        }

        .my_student_details_menu_share_next_step_details_preview_button_icon_img {
            width: 16px;
            height: 16px;
            display: block;
        }

        .my_student_details_menu_share_next_step_details_preview_button_secondary:active,
        .my_student_details_menu_share_next_step_details_preview_button_primary:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        /* ---- Responsive ---- */
        @media (max-width: 900px) {
            .my_student_details_menu_share_next_step_details_preview_main {
                padding: 24px 16px 18px;
            }

            .my_student_details_menu_share_next_step_details_preview_bottom_bar {
                padding: 10px 16px 14px;
            }

            .my_student_details_menu_share_next_step_details_preview_layout {
                flex-direction: column;
            }

            .my_student_details_menu_share_next_step_details_preview_title {
                font-size: 32px;
            }

            .my_student_details_menu_share_next_step_details_preview_title_icon {
                width: 60px;
                height: 60px;
            }
        }

        @media (max-width: 600px) {
            .my_student_details_menu_share_next_step_details_preview_preview_bar {
                flex-direction: column;
                align-items: flex-start;
                font-size: 13px;
            }

            .my_student_details_menu_share_next_step_details_preview_bottom_inner {
                flex-direction: column-reverse;
                align-items: stretch;
                gap: 10px;
            }

            .my_student_details_menu_share_next_step_details_preview_button_secondary,
            .my_student_details_menu_share_next_step_details_preview_button_primary {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="my_student_details_menu_share_next_step_details_preview_page_wrapper">

        <!-- Top Preview Bar -->
        <div class="my_student_details_menu_share_next_step_details_preview_preview_bar">
            <svg style="width:20px;" data-preply-ds-component="SvgTokyoUIIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M12 19c-7 0-10-7-10-7s3-7 10-7 10 7 10 7-3 7-10 7zm-8.164-6.207v.002-.002zm.46-.864l-.04.071.042.07c.337.568.85 1.322 1.544 2.07C7.23 15.635 9.236 17 12 17s4.77-1.364 6.16-2.86a12.39 12.39 0 001.543-2.07l.042-.07-.042-.07a12.39 12.39 0 00-1.544-2.07C16.77 8.365 14.764 7 12 7S7.23 8.364 5.84 9.86a12.386 12.386 0 00-1.543 2.07zM12 9a3 3 0 100 6 3 3 0 000-6z" clip-rule="evenodd"></path>
            </svg>
            <span class="my_student_details_menu_share_next_step_details_preview_preview_bar_text">
                <strong>You're in preview mode.</strong>
                This is how Latingles will view next steps. It will be sent via the Preply chat.
            </span>
        </div>

        <!-- Main Content -->
        <main class="my_student_details_menu_share_next_step_details_preview_main">
            <div class="my_student_details_menu_share_next_step_details_preview_main_inner">
                <div class="my_student_details_menu_share_next_step_details_preview_layout">

                    <!-- Left Column -->
                    <section class="my_student_details_menu_share_next_step_details_preview_left">
                        <div class="my_student_details_menu_share_next_step_details_preview_title_row">
                            <img
                                src="img/my_students/awesome.svg"
                                alt="Target"
                                class="my_student_details_menu_share_next_step_details_preview_title_icon" />
                            <h1 class="my_student_details_menu_share_next_step_details_preview_title">
                                Congrats on a great first lesson!
                            </h1>
                        </div>

                        <div class="my_student_details_menu_share_next_step_details_preview_subtitle">
                            Here is a message from Karen:
                        </div>

                        <div class="my_student_details_menu_share_next_step_details_preview_message_card">
                            <div class="my_student_details_menu_share_next_step_details_preview_message_avatar">
                                <!-- Replace with your real avatar image if needed -->
                                <img src="img/my_students/avatar_isbb2lpke6k.jpg" alt="Karen V." />
                            </div>
                            <div class="my_student_details_menu_share_next_step_details_preview_message_name">
                                Karen V.
                            </div>
                        </div>
                    </section>

                    <!-- Right Column -->
                    <section class="my_student_details_menu_share_next_step_details_preview_right">
                        <div class="my_student_details_menu_share_next_step_details_preview_next_steps_card">
                            <div class="my_student_details_menu_share_next_step_details_preview_next_steps_title">
                                Here are the next steps that Karen recommends:
                            </div>

                            <div class="my_student_details_menu_share_next_step_details_preview_divider"></div>

                            <div class="my_student_details_menu_share_next_step_details_preview_next_steps_item">
                                <div class="my_student_details_menu_share_next_step_details_preview_calendar_icon_wrap">
                                    <img
                                        src="img/my_students/calendar.svg"
                                        alt="Calendar"
                                        class="my_student_details_menu_share_next_step_details_preview_calendar_icon_img" />
                                </div>
                                <div class="my_student_details_menu_share_next_step_details_preview_next_steps_text">
                                    Topics for the next lessons
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </main>

        <!-- Fixed Bottom Bar / Footer -->
        <div class="my_student_details_menu_share_next_step_details_preview_bottom_bar">
            <div class="my_student_details_menu_share_next_step_details_preview_bottom_inner">

                <a href="my_students_details_menu_share_next_step.php">
                    <button
                        class="my_student_details_menu_share_next_step_details_preview_button_secondary"
                        type="button">

                        <svg style="width:20px;" data-preply-ds-component="SvgTokyoUIIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path fill-rule="evenodd" d="M3 5.414L4.414 4l14.85 14.85-1.415 1.413-1.936-1.935a9.695 9.695 0 01-3.913.806c-7 0-10-7-10-7s1.036-2.416 3.31-4.41L3 5.414zm9.538 9.538l1.824 1.824a7.789 7.789 0 01-2.362.358c-2.764 0-4.77-1.364-6.16-2.86a12.39 12.39 0 01-1.543-2.069l-.042-.07.042-.072c.337-.566.85-1.32 1.544-2.068.271-.293.567-.58.886-.853l2.321 2.32a3 3 0 003.49 3.49zm5.793-.868a12.455 12.455 0 001.372-1.879l.042-.07-.042-.072a12.39 12.39 0 00-1.544-2.068C16.77 8.5 14.764 7.135 12 7.135a8.97 8.97 0 00-.597.02L9.658 5.412A9.869 9.869 0 0112 5.134c7 0 10 7 10 7s-.712 1.662-2.253 3.367l-1.416-1.417zM3.836 12.927v.002-.002z" clip-rule="evenodd"></path>
                        </svg>

                        <span>Exit preview mode</span>
                    </button>
                </a>
                <button
                    class="my_student_details_menu_share_next_step_details_preview_button_primary"
                    type="button">
                    <span>Save</span>
                    <svg data-preply-ds-component="SvgTokyoUIIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M19 21l-7-5-7 5V3h14zM7 5v12.5l5-3.5 5 3.5V5z"></path>
                    </svg>

                </button>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Simple layout helper using jQuery (kept with required prefix)
        $(document).ready(function() {
            var my_student_details_menu_share_next_step_details_preview_updateLayout = function() {
                var my_student_details_menu_share_next_step_details_preview_windowWidth = $(window).width();

                if (my_student_details_menu_share_next_step_details_preview_windowWidth < 900) {
                    $('.my_student_details_menu_share_next_step_details_preview_layout')
                        .addClass('my_student_details_menu_share_next_step_details_preview_layout_mobile');
                } else {
                    $('.my_student_details_menu_share_next_step_details_preview_layout')
                        .removeClass('my_student_details_menu_share_next_step_details_preview_layout_mobile');
                }
            };

            my_student_details_menu_share_next_step_details_preview_updateLayout();
            $(window).on('resize', my_student_details_menu_share_next_step_details_preview_updateLayout);
        });
    </script>
</body>

</html>