<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Lesson Button with Right Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
                sans-serif;
            background: #f2f3f7;
            color: #333;
        }

        /* PAGE LAYOUT (only for positioning the button) */
        .my_student_details_lessons_layout {
            min-height: 100vh;
            display: flex;
            justify-content: flex-end;
            /* button on the right side */
            align-items: center;
            padding: 32px 24px;
            box-sizing: border-box;
        }

        /* BLUE LESSON BUTTON */
        .my_student_details_lessons_lesson_button {
            padding: 10px 26px;
            border-radius: 999px;
            border: none;
            background: #2563eb;
            color: #ffffff;
            font-size: 14px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4);
            transition: background 0.2s ease, transform 0.1s ease,
                box-shadow 0.2s ease;
        }

        .my_student_details_lessons_lesson_button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.45);
        }

        .my_student_details_lessons_lesson_button:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.35);
        }

        /* RIGHT PANEL OVERLAY */
        .my_student_details_lessons_overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease;
            z-index: 20;
        }

        .my_student_details_lessons_overlay.my_student_details_lessons_is_open {
            opacity: 1;
            visibility: visible;
        }

        /* RIGHT PANEL */
        .my_student_details_lessons_panel {
            position: fixed;
            top: 0;
            right: 0;
            width: 450px;
            max-width: 100%;
            height: 100vh;
            background: #ffffff;
            box-shadow: -12px 0 30px rgba(15, 23, 42, 0.18);
            transform: translateX(100%);
            transition: transform 0.25s ease;
            z-index: 30;
            display: flex;
            flex-direction: column;
        }

        .my_student_details_lessons_panel.my_student_details_lessons_is_open {
            transform: translateX(0%);
        }

        .my_student_details_lessons_panel_header {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .my_student_details_lessons_panel_header_left {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .my_student_details_lessons_panel_header_title {
            font-weight: 600;
            font-size: 13px;
            color: #64748b;
        }

        .my_student_details_lessons_panel_header_close {
            border: none;
            background: transparent;
            font-size: 18px;
            cursor: pointer;
            color: #94a3b8;
        }

        .my_student_details_lessons_panel_body {
            padding: 18px 20px 20px;
            overflow-y: auto;
            flex: 1;
        }

        /* PROFILE INFO */
        .my_student_details_lessons_profile_top {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 20px;
        }

        .my_student_details_lessons_profile_avatar {
            width: 44px;
            height: 44px;
            border-radius: 5px;
            background: url("https://images.pexels.com/photos/936229/pexels-photo-936229.jpeg?auto=compress&cs=tinysrgb&w=120") center/cover no-repeat;
        }

        .my_student_details_lessons_profile_name {
            font-weight: 600;
            font-size: 15px;
        }

        .my_student_details_lessons_profile_subscription {
            margin-top: 6px;
            display: inline-flex;
            padding: 3px 8px;
            border-radius: 5px;
            background: #c1daee;
            color: #000;
            font-size: 11px;
            font-weight: 600;
        }

        /* TABS */
        .my_student_details_lessons_tabs {
            display: flex;
            gap: 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .my_student_details_lessons_tab_item {
            border: none;
            background: transparent;
            padding: 0 0 10px;
            cursor: pointer;
            color: #64748b;
            position: relative;
            font-size: 13px;
        }

        .my_student_details_lessons_tab_item.my_student_details_lessons_tab_active {
            color: #111827;
            font-weight: 600;
        }

        .my_student_details_lessons_tab_item.my_student_details_lessons_tab_active::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 100%;
            border-radius: 999px;
            background: #ef4444;
        }

        .my_student_details_lessons_tab_panel {
            display: none;
        }

        .my_student_details_lessons_tab_panel.my_student_details_lessons_tab_panel_active {
            display: block;
        }

        /* DROPDOWN */
        .my_student_details_lessons_dropdown_section {
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .my_student_details_lessons_dropdown_wrapper {
            position: relative;
        }

        .my_student_details_lessons_dropdown {
            font-weight: 600;
            border-radius: 999px;
            /* border: 1px solid #e2e8f0; */
            padding: 6px 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            min-width: 130px;
            /* box-shadow: 0 1px 2px rgba(148, 163, 184, 0.25); */
        }

        .my_student_details_lessons_dropdown_label {
            font-size: 13px;
        }

        .my_student_details_lessons_dropdown_arrow {
            font-size: 11px;
            color: #64748b;
        }

        .my_student_details_lessons_dropdown_menu {
            position: absolute;
            top: 110%;
            left: 0;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.18);
            padding: 6px 0;
            min-width: 200px;
            display: none;
            z-index: 40;
        }

        .my_student_details_lessons_dropdown_menu.my_student_details_lessons_dropdown_menu_open {
            display: block;
        }

        .my_student_details_lessons_dropdown_option {
            padding: 8px 14px;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .my_student_details_lessons_dropdown_option:hover {
            background: #f3f4f6;
        }

        .my_student_details_lessons_dropdown_option_active {
            font-weight: 600;
        }

        .my_student_details_lessons_dropdown_option_check {
            font-size: 14px;
            color: #2563eb;
            margin-left: 8px;
        }

        .my_student_details_lessons_section_title {
            font-size: 12px;
            font-weight: 600;
            /* text-transform: uppercase; */
            letter-spacing: 0.05em;
            color: #000;
            margin-bottom: 10px;
        }

        /* LESSON CARDS */
        .my_student_details_lessons_lesson_card {
            border-radius: 5px;
            border: 1px solid #e2e8f0;
            padding: 10px 12px;
            display: grid;
            grid-template-columns: 60px 1fr auto;
            align-items: center;
            font-size: 12px;
            gap: 8px;
            /* margin-bottom: 10px; */
            position: relative;
        }

        .my_student_details_lessons_lesson_date {
            text-align: center;
        }

        .my_student_details_lessons_lesson_date_month {
            font-size: 11px;
            color: #000;
            text-transform: uppercase;
        }

        .my_student_details_lessons_lesson_date_day {
            font-size: 18px;
            font-weight: 700;
        }

        .my_student_details_lessons_lesson_main_title {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .my_student_details_lessons_lesson_time {
            font-size: 11px;
            color: #64748b;
        }

        .my_student_details_lessons_badge_scheduled {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 5px;
            background: #c1daee;
            color: #000;
            font-weight: 600;
            font-size: 11px;
        }

        .my_student_details_lessons_badge_small_cancelled {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 5px;
            background: #fef2f2;
            color: #b91c1c;
            font-weight: 600;
            font-size: 11px;
        }

        .my_student_details_lessons_section_spacer {
            height: 16px;
        }

        /* OTHER TABS SIMPLE CONTENT */
        .my_student_details_lessons_simple_block {
            font-size: 13px;
            color: #4b5563;
            line-height: 1.5;
            background: #f9fafb;
            border-radius: 10px;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
        }

        /* 3 DOTS MENU */
        .my_student_details_lessons_lesson_actions {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            position: relative;
        }

        .my_student_details_lessons_more_button {
            border: none;
            background: transparent;
            cursor: pointer;
            padding: 4px;
            border-radius: 999px;
            line-height: 1;
            font-size: 18px;
            color: #000;
            /* BLACK 3 DOTS */
        }

        .my_student_details_lessons_more_button:hover {
            background: #f3f4f6;
            color: #000;
        }

        .my_student_details_lessons_more_menu {
            position: absolute;
            top: 110%;
            right: 0;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.18);
            padding: 6px 0;
            min-width: 180px;
            display: none;
            z-index: 50;
        }

        .my_student_details_lessons_more_menu.my_student_details_lessons_more_menu_open {
            display: block;
        }

        .my_student_details_lessons_more_item {
            width: 100%;
            border: none;
            background: transparent;
            cursor: pointer;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #111827;
            text-align: left;
        }

        .my_student_details_lessons_more_item:hover {
            background: #f3f4f6;
        }

        .my_student_details_lessons_more_item_icon {
            width: 16px;
            height: 16px;
            display: inline-block;
            object-fit: contain;
        }

        .my_student_details_lessons_more_item_danger {
            color: #b91c1c;
        }

        /* Responsive: button full width on phones */
        @media (max-width: 600px) {
            .my_student_details_lessons_layout {
                justify-content: center;
            }

            .my_student_details_lessons_lesson_button {
                width: 100%;
                max-width: 260px;
                text-align: center;
            }

            .my_student_details_lessons_panel {
                width: 100%;
            }
        }

        /* ============================
           LEARNING NEEDS TAB (simple, SVG-based)
           ============================ */
        .my_student_details_lessons_learning_empty {
            padding: 40px 16px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: #4b5563;
        }

        .my_student_details_lessons_learning_icon {
            width: 210px;
            max-width: 100%;
            margin-bottom: 24px;
        }

        .my_student_details_lessons_learning_title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }

        .my_student_details_lessons_learning_text {
            font-size: 13px;
            color: #6b7280;
            max-width: 260px;
        }

        /* ============================
           OVERVIEW TAB
           ============================ */
        .my_student_details_lessons_overview_wrapper {
            display: flex;
            flex-direction: column;
            gap: 16px;
            font-size: 13px;
        }

        .my_student_details_lessons_overview_stats {
            display: flex;
            gap: 40px;
            padding-bottom: 8px;
        }

        .my_student_details_lessons_overview_stat {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .my_student_details_lessons_overview_stat_value {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .my_student_details_lessons_overview_stat_label {
            font-size: 12px;
            color: #6b7280;
        }

        .my_student_details_lessons_overview_card {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 14px 16px;
            background: #ffffff;
        }

        .my_student_details_lessons_overview_card_title {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #111827;
        }

        .my_student_details_lessons_overview_list {
            margin: 0;
        }

        .my_student_details_lessons_overview_row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 4px 0;
            font-size: 13px;
        }

        .my_student_details_lessons_overview_row_label {
            color: #6b7280;
        }

        .my_student_details_lessons_overview_row_value {
            font-weight: 500;
            color: #111827;
            text-align: right;
        }

        .my_student_details_lessons_overview_row:last-child {
            padding-bottom: 0;
        }
    </style>
</head>

<body>

    <!-- overlay -->
    <div
        class="my_student_details_lessons_overlay"
        id="my_student_details_lessons_overlay"></div>

    <!-- right side panel -->
    <aside
        class="my_student_details_lessons_panel"
        id="my_student_details_lessons_panel">
        <div class="my_student_details_lessons_panel_header">
            <div class="my_student_details_lessons_panel_header_left">
                <span class="my_student_details_lessons_panel_header_title">Student profile</span>
            </div>
            <button
                class="my_student_details_lessons_panel_header_close"
                id="my_student_details_lessons_close_button"
                aria-label="Close">
                ×
            </button>
        </div>

        <div class="my_student_details_lessons_panel_body">
            <!-- profile -->
            <div class="my_student_details_lessons_profile_top">
                <div class="my_student_details_lessons_profile_avatar"></div>
                <div>
                    <div class="my_student_details_lessons_profile_name">
                        Courtney Henry
                    </div>
                    <div class="my_student_details_lessons_profile_subscription">
                        Subscription
                    </div>
                </div>
            </div>

            <!-- tabs -->
            <div class="my_student_details_lessons_tabs">
                <button
                    class="my_student_details_lessons_tab_item my_student_details_lessons_tab_active"
                    data-my_student_details_lessons_tab="lessons">
                    Lessons
                </button>
                <button
                    class="my_student_details_lessons_tab_item"
                    data-my_student_details_lessons_tab="learning">
                    Learning needs
                </button>
                <button
                    class="my_student_details_lessons_tab_item"
                    data-my_student_details_lessons_tab="overview">
                    Overview
                </button>
            </div>

            <!-- TAB PANELS -->
            <!-- Lessons tab -->
            <div
                class="my_student_details_lessons_tab_panel my_student_details_lessons_tab_panel_lessons my_student_details_lessons_tab_panel_active">
                <!-- dropdown -->
                <div class="my_student_details_lessons_dropdown_section">
                    <div class="my_student_details_lessons_dropdown_wrapper">
                        <div
                            class="my_student_details_lessons_dropdown"
                            id="my_student_details_lessons_dropdown">
                            <span
                                class="my_student_details_lessons_dropdown_label"
                                id="my_student_details_lessons_dropdown_label">All lessons</span>
                            <span class="my_student_details_lessons_dropdown_arrow">▼</span>
                        </div>

                        <div
                            class="my_student_details_lessons_dropdown_menu"
                            id="my_student_details_lessons_dropdown_menu">
                            <div
                                class="my_student_details_lessons_dropdown_option my_student_details_lessons_dropdown_option_active"
                                data-my_student_details_lessons_value="All lessons">
                                <span>All lessons</span>
                                <span
                                    class="my_student_details_lessons_dropdown_option_check">✓</span>
                            </div>
                            <div
                                class="my_student_details_lessons_dropdown_option"
                                data-my_student_details_lessons_value="Paid">
                                <span>Paid</span>
                                <span class="my_student_details_lessons_dropdown_option_check"></span>
                            </div>
                            <div
                                class="my_student_details_lessons_dropdown_option"
                                data-my_student_details_lessons_value="Waiting for confirmation">
                                <span>Waiting for confirmation</span>
                                <span class="my_student_details_lessons_dropdown_option_check"></span>
                            </div>
                            <div
                                class="my_student_details_lessons_dropdown_option"
                                data-my_student_details_lessons_value="Cancelled">
                                <span>Cancelled</span>
                                <span class="my_student_details_lessons_dropdown_option_check"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- section titles & lesson list -->
                <div class="my_student_details_lessons_section_title">Upcoming</div>

                <div class="my_student_details_lessons_lesson_card">
                    <div class="my_student_details_lessons_lesson_date">
                        <div class="my_student_details_lessons_lesson_date_month">
                            Nov
                        </div>
                        <div class="my_student_details_lessons_lesson_date_day">29</div>
                    </div>
                    <div>
                        <div class="my_student_details_lessons_lesson_main_title">
                            Saturday
                        </div>
                        <div class="my_student_details_lessons_lesson_time">
                            08:30 - 09:20
                        </div>
                    </div>
                    <div style="text-align: right">
                        <!-- actions container with Scheduled badge + 3 dots -->
                        <div class="my_student_details_lessons_lesson_actions">
                            <div class="my_student_details_lessons_badge_scheduled">
                                Scheduled
                            </div>
                            <button
                                type="button"
                                class="my_student_details_lessons_more_button"
                                aria-label="More actions">
                                ⋯
                            </button>
                            <div class="my_student_details_lessons_more_menu">
                                <button
                                    type="button"
                                    class="my_student_details_lessons_more_item my_student_details_lessons_more_item_reschedule">
                                    <!-- ICON AS IMAGE (update src as you like) -->
                                    <img
                                        src="img/my_students/calendar_lesson.svg"
                                        alt="Reschedule"
                                        class="my_student_details_lessons_more_item_icon" />
                                    <span>Reschedule</span>
                                </button>
                                <button
                                    type="button"
                                    class="my_student_details_lessons_more_item my_student_details_lessons_more_item_danger my_student_details_lessons_more_item_cancel">
                                    <!-- ICON AS IMAGE (update src as you like) -->
                                    <img
                                        src="img/my_students/cancel_lesson.svg"
                                        alt="Cancel"
                                        class="my_student_details_lessons_more_item_icon" />
                                    <span>Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="my_student_details_lessons_section_spacer"></div>

                <div class="my_student_details_lessons_section_title">Previous</div>

                <div class="my_student_details_lessons_lesson_card">
                    <div class="my_student_details_lessons_lesson_date">
                        <div class="my_student_details_lessons_lesson_date_month">
                            May
                        </div>
                        <div class="my_student_details_lessons_lesson_date_day">30</div>
                    </div>
                    <div>
                        <div class="my_student_details_lessons_lesson_main_title">
                            Friday
                        </div>
                        <div class="my_student_details_lessons_lesson_time">
                            13:00 - 13:25
                        </div>
                    </div>
                    <div style="text-align: right">
                        <div class="my_student_details_lessons_badge_small_cancelled">
                            Cancelled
                        </div>
                    </div>
                </div>

                <div class="my_student_details_lessons_lesson_card">
                    <div class="my_student_details_lessons_lesson_date">
                        <div class="my_student_details_lessons_lesson_date_month">
                            May
                        </div>
                        <div class="my_student_details_lessons_lesson_date_day">21</div>
                    </div>
                    <div>
                        <div class="my_student_details_lessons_lesson_main_title">
                            Wednesday
                        </div>
                        <div class="my_student_details_lessons_lesson_time">
                            16:00 - 16:25
                        </div>
                    </div>
                    <div style="text-align: right">
                        <div class="my_student_details_lessons_badge_small_cancelled">
                            Cancelled
                        </div>
                    </div>
                </div>

                <div class="my_student_details_lessons_lesson_card">
                    <div class="my_student_details_lessons_lesson_date">
                        <div class="my_student_details_lessons_lesson_date_month">
                            May
                        </div>
                        <div class="my_student_details_lessons_lesson_date_day">21</div>
                    </div>
                    <div>
                        <div class="my_student_details_lessons_lesson_main_title">
                            Wednesday
                        </div>
                        <div class="my_student_details_lessons_lesson_time">
                            15:30 - 15:55
                        </div>
                    </div>
                    <div style="text-align: right">
                        <div class="my_student_details_lessons_badge_small_cancelled">
                            Cancelled
                        </div>
                    </div>
                </div>

                <div class="my_student_details_lessons_lesson_card">
                    <div class="my_student_details_lessons_lesson_date">
                        <div class="my_student_details_lessons_lesson_date_month">
                            May
                        </div>
                        <div class="my_student_details_lessons_lesson_date_day">20</div>
                    </div>
                    <div>
                        <div class="my_student_details_lessons_lesson_main_title">
                            Tuesday
                        </div>
                        <div class="my_student_details_lessons_lesson_time">
                            15:30 - 15:55
                        </div>
                    </div>
                    <div style="text-align: right">
                        <div class="my_student_details_lessons_badge_small_cancelled">
                            Cancelled
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning needs tab -->
            <div
                class="my_student_details_lessons_tab_panel my_student_details_lessons_tab_panel_learning">
                <div class="my_student_details_lessons_learning_empty">
                    <!-- Replace this src with your real SVG icon path -->
                    <img
                        src="img/my_students/learning_content.svg"
                        alt="No learning needs"
                        class="my_student_details_lessons_learning_icon" />

                    <div class="my_student_details_lessons_learning_title">
                        No learning needs shared yet
                    </div>
                    <div class="my_student_details_lessons_learning_text">
                        Ask Latingles to fill out their goals and preferences so you can
                        better plan future lessons.
                    </div>
                </div>
            </div>

            <!-- Overview tab -->
            <div
                class="my_student_details_lessons_tab_panel my_student_details_lessons_tab_panel_overview">
                <div class="my_student_details_lessons_overview_wrapper">
                    <div class="my_student_details_lessons_overview_stats">
                        <div class="my_student_details_lessons_overview_stat">
                            <div class="my_student_details_lessons_overview_stat_value">0</div>
                            <div class="my_student_details_lessons_overview_stat_label">
                                Lessons
                            </div>
                        </div>
                        <div class="my_student_details_lessons_overview_stat">
                            <div class="my_student_details_lessons_overview_stat_value">9</div>
                            <div class="my_student_details_lessons_overview_stat_label">
                                Months
                            </div>
                        </div>
                    </div>

                    <div class="my_student_details_lessons_overview_card">
                        <div class="my_student_details_lessons_overview_card_title">
                            Subscription info
                        </div>
                        <div class="my_student_details_lessons_overview_list">
                            <div class="my_student_details_lessons_overview_row">
                                <div class="my_student_details_lessons_overview_row_label">
                                    Type
                                </div>
                                <div class="my_student_details_lessons_overview_row_value">
                                    Subscription
                                </div>
                            </div>
                            <div class="my_student_details_lessons_overview_row">
                                <div class="my_student_details_lessons_overview_row_label">
                                    Lesson price
                                </div>
                                <div class="my_student_details_lessons_overview_row_value">
                                    $4.00
                                </div>
                            </div>
                            <div class="my_student_details_lessons_overview_row">
                                <div class="my_student_details_lessons_overview_row_label">
                                    Price changes
                                </div>
                                <div class="my_student_details_lessons_overview_row_value">
                                    0
                                </div>
                            </div>
                            <div class="my_student_details_lessons_overview_row">
                                <div class="my_student_details_lessons_overview_row_label">
                                    Frequency
                                </div>
                                <div class="my_student_details_lessons_overview_row_value">
                                    4 lessons every 4 weeks
                                </div>
                            </div>
                            <div class="my_student_details_lessons_overview_row">
                                <div class="my_student_details_lessons_overview_row_label">
                                    Lessons
                                </div>
                                <div class="my_student_details_lessons_overview_row_value">
                                    1 scheduled (or completed) out of 1
                                </div>
                            </div>
                            <div class="my_student_details_lessons_overview_row">
                                <div class="my_student_details_lessons_overview_row_label">
                                    Renewal date
                                </div>
                                <div class="my_student_details_lessons_overview_row_value">
                                    November 19, 2025
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <script>
        jQuery(function() {
            /* PANEL OPEN/CLOSE */
            var my_student_details_lessons_is_open = false;

            function my_student_details_lessons_open_panel() {
                my_student_details_lessons_is_open = true;
                jQuery("#my_student_details_lessons_panel").addClass(
                    "my_student_details_lessons_is_open"
                );
                jQuery("#my_student_details_lessons_overlay").addClass(
                    "my_student_details_lessons_is_open"
                );
            }

            function my_student_details_lessons_close_panel() {
                my_student_details_lessons_is_open = false;
                jQuery("#my_student_details_lessons_panel").removeClass(
                    "my_student_details_lessons_is_open"
                );
                jQuery("#my_student_details_lessons_overlay").removeClass(
                    "my_student_details_lessons_is_open"
                );
                my_student_details_lessons_close_dropdown(); // also close dropdown
            }

            jQuery("#my_student_details_lessons_open_button").on("click", function() {
                my_student_details_lessons_open_panel();
            });

            jQuery("#my_student_details_lessons_close_button").on(
                "click",
                function() {
                    my_student_details_lessons_close_panel();
                }
            );

            jQuery("#my_student_details_lessons_overlay").on("click", function() {
                if (my_student_details_lessons_is_open) {
                    my_student_details_lessons_close_panel();
                }
            });

            /* TABS */
            jQuery(".my_student_details_lessons_tab_item").on("click", function() {
                var my_student_details_lessons_target =
                    jQuery(this).data("my_student_details_lessons_tab");

                jQuery(".my_student_details_lessons_tab_item").removeClass(
                    "my_student_details_lessons_tab_active"
                );
                jQuery(this).addClass("my_student_details_lessons_tab_active");

                jQuery(".my_student_details_lessons_tab_panel").removeClass(
                    "my_student_details_lessons_tab_panel_active"
                );
                jQuery(
                    ".my_student_details_lessons_tab_panel_" +
                    my_student_details_lessons_target
                ).addClass("my_student_details_lessons_tab_panel_active");
            });

            /* DROPDOWN */
            var my_student_details_lessons_dropdown_is_open = false;

            function my_student_details_lessons_open_dropdown() {
                my_student_details_lessons_dropdown_is_open = true;
                jQuery("#my_student_details_lessons_dropdown_menu").addClass(
                    "my_student_details_lessons_dropdown_menu_open"
                );
            }

            function my_student_details_lessons_close_dropdown() {
                my_student_details_lessons_dropdown_is_open = false;
                jQuery("#my_student_details_lessons_dropdown_menu").removeClass(
                    "my_student_details_lessons_dropdown_menu_open"
                );
            }

            jQuery("#my_student_details_lessons_dropdown").on(
                "click",
                function(event) {
                    event.stopPropagation();
                    if (my_student_details_lessons_dropdown_is_open) {
                        my_student_details_lessons_close_dropdown();
                    } else {
                        my_student_details_lessons_open_dropdown();
                    }
                }
            );

            jQuery(
                ".my_student_details_lessons_dropdown_option"
            ).on("click", function(event) {
                event.stopPropagation();
                var my_student_details_lessons_value = jQuery(this).data(
                    "my_student_details_lessons_value"
                );

                jQuery("#my_student_details_lessons_dropdown_label").text(
                    my_student_details_lessons_value
                );

                // active state & checkmark
                jQuery(
                    ".my_student_details_lessons_dropdown_option"
                ).removeClass("my_student_details_lessons_dropdown_option_active");
                jQuery(
                    ".my_student_details_lessons_dropdown_option_check"
                ).text("");
                jQuery(this).addClass(
                    "my_student_details_lessons_dropdown_option_active"
                );
                jQuery(this)
                    .find(".my_student_details_lessons_dropdown_option_check")
                    .text("✓");

                my_student_details_lessons_close_dropdown();
            });

            // Close dropdown on clicking anywhere else
            jQuery(document).on("click", function() {
                if (my_student_details_lessons_dropdown_is_open) {
                    my_student_details_lessons_close_dropdown();
                }
            });

            /* 3 DOTS MENU LOGIC */
            var my_student_details_lessons_open_more_menu = null;

            // open / close menu when clicking the 3 dots
            jQuery(".my_student_details_lessons_more_button").on("click", function(e) {
                e.stopPropagation();
                var menu = jQuery(this)
                    .siblings(".my_student_details_lessons_more_menu");

                // close previously open menu
                if (
                    my_student_details_lessons_open_more_menu &&
                    my_student_details_lessons_open_more_menu[0] !== menu[0]
                ) {
                    my_student_details_lessons_open_more_menu.removeClass(
                        "my_student_details_lessons_more_menu_open"
                    );
                }

                menu.toggleClass("my_student_details_lessons_more_menu_open");

                if (menu.hasClass("my_student_details_lessons_more_menu_open")) {
                    my_student_details_lessons_open_more_menu = menu;
                } else {
                    my_student_details_lessons_open_more_menu = null;
                }
            });

            // prevent clicks inside the menu from closing via document handler
            jQuery(".my_student_details_lessons_more_menu").on("click", function(e) {
                e.stopPropagation();
            });

            // close 3-dots menu when clicking anywhere else
            jQuery(document).on("click", function() {
                jQuery(".my_student_details_lessons_more_menu").removeClass(
                    "my_student_details_lessons_more_menu_open"
                );
                my_student_details_lessons_open_more_menu = null;
            });

            // OPTIONAL: placeholder actions for menu items
            jQuery(".my_student_details_lessons_more_item_reschedule").on(
                "click",
                function() {
                    alert("Reschedule clicked");
                }
            );

            jQuery(".my_student_details_lessons_more_item_cancel").on(
                "click",
                function() {
                    alert("Cancel clicked");
                }
            );
        });
    </script>
</body>

</html>