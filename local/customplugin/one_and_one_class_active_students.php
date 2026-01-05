<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Active Students – Latingles</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        
        :root {
            --one_and_one_class_border: #E5E7EB;
            --one_and_one_class_text: #0F172A;
            --one_and_one_class_shadow: 0 6px 22px rgba(0, 0, 0, .06);
            --one_and_one_class_radius: 18px;

            --one_and_one_class_red: #EF2E1F;
            /* Join button */
            --one_and_one_class_red_underline: #EF4444;
            /* Active day underline */
            --one_and_one_class_blue: #2F6FE4;
            /* Time ring (blue) */
            --one_and_one_class_olive: #708C2B;
            /* Time ring (olive) */
            --one_and_one_class_green: #16A34A;
            /* Status green */
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            margin: 0;
            padding: 0
        }

        body {
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color: var(--one_and_one_class_text);
            background: #fff;
        }

        /* Full-width section (no side gaps) */
        .one_and_one_class_active_wrap {
            max-width: 100%;
            margin: 0;
        }

        .one_and_one_class_active_card {
            width: 100%;
            background: #fff;
            border: 1px solid var(--one_and_one_class_border);
            border-radius: var(--one_and_one_class_radius);
            box-shadow: var(--one_and_one_class_shadow);
        }

        .one_and_one_class_active_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 12px 0 12px;
        }

        .one_and_one_class_active_title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .one_and_one_class_active_collapse {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            border: 1px solid var(--one_and_one_class_border);
            display: grid;
            place-items: center;
            background: #fff;
            cursor: pointer;
        }

        .one_and_one_class_active_collapse svg {
            width: 16px;
            height: 16px;
            stroke: #111;
            transition: transform .2s ease;
        }

        .one_and_one_class_active_collapse[aria-expanded="false"] svg {
            transform: rotate(180deg);
        }

        .one_and_one_class_active_top {
            display: grid;
            grid-template-columns: 110px 1fr auto;
            gap: 12px;
            padding: 12px;
            align-items: start;
        }

        .one_and_one_class_active_avatar {
            width: 110px;
            height: 110px;
            border-radius: 12px;
            object-fit: cover;
        }

        .one_and_one_class_active_session {
            display: flex;
            flex-direction: column;
        }

        .one_and_one_class_active_session_head {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .one_and_one_class_active_dash {
            color: #9CA3AF;
            font-weight: 900;
            padding: 0 6px;
        }

        .one_and_one_class_active_session_title {
            font-size: 18px;
            font-weight: 600;
        }

        /* Days row: 5 content-sized columns with tight gap (matches snapshot) */
        .one_and_one_class_active_tabs {
            display: grid;
            grid-template-columns: repeat(5, max-content);
            column-gap: 80px;
            row-gap: 0;
            border-bottom: 1px solid var(--one_and_one_class_border);
            padding: 6px 0 8px 0;
            margin-top: 6px;
        }

        .one_and_one_class_active_day {
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            padding-bottom: 4px;
            position: relative;
            cursor: pointer;
        }

        .one_and_one_class_active_day.one_and_one_class_active_day__active::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -8px;
            height: 3px;
            background: var(--one_and_one_class_red_underline);
            border-radius: 2px;
        }

        /* Time row uses the exact same grid as days; place slots in columns 1,3,5 */
        .one_and_one_class_active_times {
            display: grid;
            grid-template-columns: repeat(5, max-content);
            column-gap: 48px;
            row-gap: 0;
            padding: 10px 0 4px 0;
            align-items: center;
        }

        .one_and_one_class_col1 {
            grid-column: 1;
        }

        .one_and_one_class_col3 {
            grid-column: 3;
        }

        .one_and_one_class_col5 {
            grid-column: 5;
        }

        .one_and_one_class_active_time_btn {
            --ring: var(--one_and_one_class_border);
            border: 2px solid var(--ring);
            border-radius: 5px;
            background: #fff;
            padding: 7px 23px 10px 10px;
            font-size: 14px;
            font-weight: 600;
            color: #111;
            cursor: pointer;
            position: relative;
            line-height: 1.5;
        }

        .one_and_one_class_active_time_btn::after {
            content: "";
            position: absolute;
            right: 9px;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="%23111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>') no-repeat center/12px;
            pointer-events: none;
        }

        .one_and_one_class_active_time_btn--blue {
            --ring: var(--one_and_one_class_blue);
        }

        .one_and_one_class_active_time_btn--olive {
            --ring: var(--one_and_one_class_olive);
        }

        .one_and_one_class_active_actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .one_and_one_class_active_join {
            background: var(--one_and_one_class_red);
            color: #fff;
            font-weight: 600;
            border: 2px solid #000;
            border-radius: 5px;
            padding: 10px 16px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .04) inset;
        }

        .one_and_one_class_active_seeall {
            font-size: 14px;
            font-weight: 700;
            text-decoration: underline;
            cursor: pointer;
        }

        .one_and_one_class_active_divider {
            height: 1px;
            background: var(--one_and_one_class_border);
            margin: 8px 12px 0 12px;
        }

        .one_and_one_class_active_body {
            padding: 10px 12px 12px 12px;
        }

        .one_and_one_class_active_upnext_title {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 8px 0;
        }

        .one_and_one_class_active_scroll {
            max-height: 360px;
            overflow-y: auto;
            border-left: 3px solid #E6E7EA;
            padding-left: 14px;
        }

        .one_and_one_class_active_scroll::-webkit-scrollbar {
            width: 10px;
        }

        .one_and_one_class_active_scroll::-webkit-scrollbar-thumb {
            background: #C9CDD5;
            border-radius: 8px;
        }

        .one_and_one_class_active_scroll {
            scrollbar-width: thin;
            scrollbar-color: #C9CDD5 transparent;
        }

        .one_and_one_class_active_item {
            padding: 14px 0;
            border-bottom: 1px solid var(--one_and_one_class_border);
            position: relative;
        }

        .one_and_one_class_active_item:last-child {
            border-bottom: none;
        }

        .one_and_one_class_active_bullet {
            position: absolute;
            left: -22px;
            top: 20px;
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #111;
        }

        .one_and_one_class_active_row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px 12px;
            font-size: 15px;
            font-weight: 700;
        }

        .one_and_one_class_active_today {
            color: #111;
            font-weight: 700;
        }

        .one_and_one_class_active_time_range {
            color: #111;
        }

        .one_and_one_class_active_sep {
            color: #9CA3AF;
        }

        .one_and_one_class_active_status_green {
            color: var(--one_and_one_class_green);
            font-weight: 700;
        }

        .one_and_one_class_active_status_red {
            color: #D23B32;
            font-weight: 700;
        }

        .one_and_one_class_active_kv {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 8px;
            font-size: 14px;
        }

        .one_and_one_class_active_kv b {
            font-weight: 600;
        }

        /* Fixed-position time dropdown menu anchored to button (stays right under it) */
        .one_and_one_class_time_menu {
            position: fixed;
            z-index: 9999;
            display: none;
            background: #fff;
            border: 1px solid var(--one_and_one_class_border);
            border-radius: 12px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .12);
            width: 160px;
        }

        .one_and_one_class_time_menu_item {
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 600;
            color: #111;
            cursor: pointer;
        }

        .one_and_one_class_time_menu_item:hover {
            background: #F3F4F6;
        }

        @media (max-width:720px) {
            .one_and_one_class_active_top {
                grid-template-columns: 80px 1fr;
            }

            .one_and_one_class_active_actions {
                grid-column: 1 / -1;
                align-items: flex-start;
            }

            .one_and_one_class_active_avatar {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>

    <section class="one_and_one_class_active_wrap">
        <div class="one_and_one_class_active_card">
            <!-- Header -->
            <div class="one_and_one_class_active_header">
                <h3 class="one_and_one_class_active_title">Maria’s Progress and 1:1 Session History</h3>
                <button class="one_and_one_class_active_collapse" id="one_and_one_class_active_toggle" aria-expanded="true" title="Collapse/Expand">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M6 15l6-6 6 6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div id="one_and_one_class_active_area">
                <div class="one_and_one_class_active_top">
                    <img class="one_and_one_class_active_avatar" alt="Maria" src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?q=80&w=400&auto=format&fit=crop" />

                    <div class="one_and_one_class_active_session">
                        <div class="one_and_one_class_active_session_head">
                            Upcoming Session:<span class="one_and_one_class_active_dash">•</span>
                            <span class="one_and_one_class_active_session_title">August 28, Thursday At 11:00 AM</span>
                        </div>

                        <!-- Days -->
                        <div class="one_and_one_class_active_tabs">
                            <div class="one_and_one_class_active_day one_and_one_class_active_day__active">Mon</div>
                            <div class="one_and_one_class_active_day">Tue</div>
                            <div class="one_and_one_class_active_day">Wed</div>
                            <div class="one_and_one_class_active_day">Thu</div>
                            <div class="one_and_one_class_active_day">Fri</div>
                        </div>

                        <!-- Times directly under Mon, Wed, Fri -->
                        <div class="one_and_one_class_active_times">
                            <div class="one_and_one_class_col1">
                                <button class="one_and_one_class_active_time_btn one_and_one_class_active_time_btn--blue" data-time="Mon">5: 40 am</button>
                            </div>
                            <div class="one_and_one_class_col3">
                                <button class="one_and_one_class_active_time_btn one_and_one_class_active_time_btn--blue" data-time="Wed">5: 40 am</button>
                            </div>
                            <div class="one_and_one_class_col5">
                                <button class="one_and_one_class_active_time_btn one_and_one_class_active_time_btn--olive" data-time="Fri">5: 40 am</button>
                            </div>
                        </div>
                    </div>

                    <div class="one_and_one_class_active_actions">
                        <button class="one_and_one_class_active_join">Join Lesson</button>
                        <div class="one_and_one_class_active_seeall">See all (12)</div>
                    </div>
                </div>

                <div class="one_and_one_class_active_divider"></div>

                <div class="one_and_one_class_active_body">
                    <h4 class="one_and_one_class_active_upnext_title">Up Next</h4>

                    <div class="one_and_one_class_active_scroll">
                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Today</span>
                                <span class="one_and_one_class_active_time_range">Thursday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_red">Missed and covered by Teacher Jessica</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Alphabet</div>
                                <div><b>Notes :</b> Student left the class 15 minutes earlier</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 30%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">August 28</span>
                                <span class="one_and_one_class_active_time_range">Thursday at 11:00 AM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_green">Taught</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Alphabet</div>
                                <div><b>Notes :</b> Quiz was assigned</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 30%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Aug 21</span>
                                <span class="one_and_one_class_active_time_range">Wednesday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_green">Taught</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Vowels</div>
                                <div><b>Notes :</b> Homework submitted</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 60%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Aug 14</span>
                                <span class="one_and_one_class_active_time_range">Wednesday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_red">Missed</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Consonants</div>
                                <div><b>Notes :</b> Reschedule recommended</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 45%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Aug 07</span>
                                <span class="one_and_one_class_active_time_range">Wednesday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_green">Taught</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Basics</div>
                                <div><b>Notes :</b> Good participation</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 20%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="one_and_one_class_active_wrap" style="margin-top:20px">
        <div class="one_and_one_class_active_card">
            <!-- Header -->
            <div class="one_and_one_class_active_header">
                <h3 class="one_and_one_class_active_title">Maria’s Progress and 1:1 Session History</h3>
                <button class="one_and_one_class_active_collapse" id="one_and_one_class_active_toggle" aria-expanded="true" title="Collapse/Expand">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M6 15l6-6 6 6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div id="one_and_one_class_active_area">
                <div class="one_and_one_class_active_top">
                    <img class="one_and_one_class_active_avatar" alt="Maria" src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?q=80&w=400&auto=format&fit=crop" />

                    <div class="one_and_one_class_active_session">
                        <div class="one_and_one_class_active_session_head">
                            Upcoming Session:<span class="one_and_one_class_active_dash">•</span>
                            <span class="one_and_one_class_active_session_title">August 28, Thursday At 11:00 AM</span>
                        </div>

                        <!-- Days -->
                        <div class="one_and_one_class_active_tabs">
                            <div class="one_and_one_class_active_day one_and_one_class_active_day__active">Mon</div>
                            <div class="one_and_one_class_active_day">Tue</div>
                            <div class="one_and_one_class_active_day">Wed</div>
                            <div class="one_and_one_class_active_day">Thu</div>
                            <div class="one_and_one_class_active_day">Fri</div>
                        </div>

                        <!-- Times directly under Mon, Wed, Fri -->
                        <div class="one_and_one_class_active_times">
                            <div class="one_and_one_class_col1">
                                <button class="one_and_one_class_active_time_btn one_and_one_class_active_time_btn--blue" data-time="Mon">5: 40 am</button>
                            </div>
                            <div class="one_and_one_class_col3">
                                <button class="one_and_one_class_active_time_btn one_and_one_class_active_time_btn--blue" data-time="Wed">5: 40 am</button>
                            </div>
                            <div class="one_and_one_class_col5">
                                <button class="one_and_one_class_active_time_btn one_and_one_class_active_time_btn--olive" data-time="Fri">5: 40 am</button>
                            </div>
                        </div>
                    </div>

                    <div class="one_and_one_class_active_actions">
                        <button class="one_and_one_class_active_join" style="background:#bfbfbf; color:#000;border: 2px solid gray;">Join in 30 mintues</button>
                        <div class="one_and_one_class_active_seeall">See all (12)</div>
                    </div>
                </div>

                <div class="one_and_one_class_active_divider"></div>

                <div class="one_and_one_class_active_body">
                    <h4 class="one_and_one_class_active_upnext_title">Up Next</h4>

                    <div class="one_and_one_class_active_scroll">
                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Today</span>
                                <span class="one_and_one_class_active_time_range">Thursday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_red">Missed and covered by Teacher Jessica</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Alphabet</div>
                                <div><b>Notes :</b> Student left the class 15 minutes earlier</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 30%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">August 28</span>
                                <span class="one_and_one_class_active_time_range">Thursday at 11:00 AM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_green">Taught</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Alphabet</div>
                                <div><b>Notes :</b> Quiz was assigned</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 30%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Aug 21</span>
                                <span class="one_and_one_class_active_time_range">Wednesday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_green">Taught</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Vowels</div>
                                <div><b>Notes :</b> Homework submitted</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 60%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Aug 14</span>
                                <span class="one_and_one_class_active_time_range">Wednesday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_red">Missed</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Consonants</div>
                                <div><b>Notes :</b> Reschedule recommended</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 45%</div>
                            </div>
                        </div>

                        <div class="one_and_one_class_active_item">
                            <span class="one_and_one_class_active_bullet"></span>
                            <div class="one_and_one_class_active_row">
                                <span class="one_and_one_class_active_today">Aug 07</span>
                                <span class="one_and_one_class_active_time_range">Wednesday at 7:00 PM – 8:00 PM</span>
                                <span class="one_and_one_class_active_sep">•</span>
                                <span class="one_and_one_class_active_status_green">Taught</span>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Topic :</b> Basics</div>
                                <div><b>Notes :</b> Good participation</div>
                            </div>
                            <div class="one_and_one_class_active_kv">
                                <div><b>Completion :</b> 20%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <!-- Fixed-position time menu (shared instance) -->
    <div id="one_and_one_class_time_menu" class="one_and_one_class_time_menu" role="listbox" aria-hidden="true">
        <div class="one_and_one_class_time_menu_item">5: 40 am</div>
        <div class="one_and_one_class_time_menu_item">11:30 pm</div>
        <div class="one_and_one_class_time_menu_item">4:00 pm</div>
    </div>

    <script>
        // Collapse / expand
        $('#one_and_one_class_active_toggle').on('click', function() {
            const $btn = $(this);
            const expanded = $btn.attr('aria-expanded') === 'true';
            $btn.attr('aria-expanded', String(!expanded));
            $('#one_and_one_class_active_area').slideToggle(200);
        });

        // Active day underline
        $('.one_and_one_class_active_day').on('click', function() {
            $('.one_and_one_class_active_day').removeClass('one_and_one_class_active_day__active');
            $(this).addClass('one_and_one_class_active_day__active');
        });

        // ===== Fixed-position time dropdown menu =====
        let one_and_one_class_time_anchor = null;

        function one_and_one_class_openMenu($btn) {
            const $menu = $('#one_and_one_class_time_menu');
            const r = $btn.get(0).getBoundingClientRect();
            // place directly below the button, clipped to viewport sides
            const vw = window.innerWidth || document.documentElement.clientWidth;
            const menuW = Math.max(r.width, 160);
            const left = Math.min(Math.max(r.left, 8), vw - menuW - 8);
            const top = r.bottom + 6; // gap below

            $menu.css({
                    left: left + 'px',
                    top: top + 'px',
                    width: menuW + 'px'
                })
                .show()
                .attr('aria-hidden', 'false');
            one_and_one_class_time_anchor = $btn;
        }

        function one_and_one_class_closeMenu() {
            $('#one_and_one_class_time_menu').hide().attr('aria-hidden', 'true');
            one_and_one_class_time_anchor = null;
        }

        $(document).on('click', '.one_and_one_class_active_time_btn', function(e) {
            e.stopPropagation();
            const $btn = $(this);
            if (one_and_one_class_time_anchor && one_and_one_class_time_anchor.is($btn)) {
                one_and_one_class_closeMenu();
                return;
            }
            one_and_one_class_openMenu($btn);
        });

        $('#one_and_one_class_time_menu').on('click', '.one_and_one_class_time_menu_item', function(e) {
            e.stopPropagation();
            const value = $(this).text().trim();
            if (one_and_one_class_time_anchor) {
                one_and_one_class_time_anchor.text(value);
            }
            one_and_one_class_closeMenu();
        });

        // Close on outside click / Esc / resize / scroll
        $(document).on('click', function() {
            one_and_one_class_closeMenu();
        });
        $(window).on('keydown', function(e) {
            if (e.key === 'Escape') one_and_one_class_closeMenu();
        });
        $(window).on('scroll resize', function() {
            if ($('#one_and_one_class_time_menu').is(':visible')) one_and_one_class_closeMenu();
        });
    </script>
</body>

</html>