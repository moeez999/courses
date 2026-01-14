<style>
    .admin_dashboard_table_content_menu_teacher_management_add_student_shadow {
        box-shadow: 0 20px 45px rgba(16, 24, 40, 0.18);
    }

    /* Smooth open/close */
    .admin_dashboard_table_content_menu_teacher_management_add_student_hidden {
        opacity: 0;
        transform: translateY(10px);
        pointer-events: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_shown {
        opacity: 1;
        transform: translateY(0px);
        pointer-events: auto;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_modal_radius {
        border-radius: 12px;
    }

    /* SINGLE border only */
    .admin_dashboard_table_content_menu_teacher_management_add_student_input_like {
        border: 2px solid #e5e7eb;
        border-radius: 5px;
        padding: 5px 14px;
        background: #fff;
        transition: box-shadow 180ms ease, border-color 180ms ease, transform 180ms ease;
        cursor: text;
        position: relative;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_input_like:hover {
        border-color: #cbd5e1;
        box-shadow: 0 10px 18px rgba(16, 24, 40, 0.08);
        transform: translateY(-1px);
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_input_like:focus-within {
        border-color: #1f3a8a;
        box-shadow: 0 0 0 4px rgba(31, 58, 138, 0.15);
        transform: translateY(-1px);
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_tile_like {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 12px;
        background: #fff;
        min-height: 56px;
        transition: box-shadow 180ms ease, border-color 180ms ease, transform 180ms ease;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_tile_like:hover {
        border-color: #cbd5e1;
        box-shadow: 0 12px 22px rgba(16, 24, 40, 0.10);
        transform: translateY(-1px);
    }

    /* Selected tile */
    .admin_dashboard_table_content_menu_teacher_management_add_student_tile_selected {
        border-color: #d1d5db;
        box-shadow: 0 10px 18px rgba(16, 24, 40, 0.08);
    }

    /* Checkbox UI */
    .admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_box {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 2px solid #e5e7eb;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 160ms ease, border-color 160ms ease, transform 160ms ease, box-shadow 160ms ease;
        flex: 0 0 auto;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_box:hover {
        transform: translateY(-1px);
        border-color: #cbd5e1;
        box-shadow: 0 8px 16px rgba(16, 24, 40, 0.08);
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_checked {
        background: #ef4444;
        border-color: #ef4444;
    }

    /* Confirm button */
    .admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn_style {
        border-radius: 5px;
        transition: transform 180ms ease, opacity 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn_style:hover {
        opacity: 0.96;
        box-shadow: 0 12px 22px rgba(0, 0, 0, 0.22);
        background-color: #dc2626;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn_style:active {
        transform: translateY(1px);
        opacity: 0.92;
    }

    /* Dropdown panel */
    .admin_dashboard_table_content_menu_teacher_management_add_student_dropdown_panel {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 18px 35px rgba(16, 24, 40, 0.10);
        overflow: hidden;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_dropdown_hidden {
        display: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_student_item {
        transition: background-color 160ms ease;
        cursor: pointer;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_student_item:hover {
        background-color: #f8fafc;
    }

    /* ===================== CALENDAR MODAL ===================== */
    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay_hidden {
        display: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_shadow {
        box-shadow: 0 18px 40px rgba(16, 24, 40, 0.18);
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_navbtn {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 160ms ease, box-shadow 160ms ease, border-color 160ms ease, background-color 160ms ease;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_navbtn:hover {
        transform: translateY(-1px);
        border-color: #cbd5e1;
        box-shadow: 0 10px 18px rgba(16, 24, 40, 0.10);
        background-color: #f8fafc;
    }

    /* Arrow icon sizing (replace src later) */
    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_nav_icon {
        width: 20px;
        height: 20px;
        object-fit: contain;
        display: block;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #0f172a;
        transition: transform 140ms ease, background-color 140ms ease, box-shadow 140ms ease, border-color 140ms ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day:hover {
        transform: translateY(-1px);
        background-color: #f8fafc;
        box-shadow: 0 10px 18px rgba(16, 24, 40, 0.10);
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day_muted {
        color: #94a3b8;
        cursor: default;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day_muted:hover {
        transform: none;
        background: transparent;
        box-shadow: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day_selected {
        border-color: #ef4444;
        background-color: #fff;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done_btn {
        border: 2px solid #000;
        border-radius: 10px;
        background: #ef4444;
        color: #fff;
        font-weight: 700;
        padding: 12px 22px;
        transition: transform 160ms ease, box-shadow 160ms ease, opacity 160ms ease, background-color 160ms ease;
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done_btn:hover {
        opacity: 0.96;
        box-shadow: 0 12px 22px rgba(0, 0, 0, 0.22);
        background-color: #dc2626;
        transform: translateY(-1px);
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done_btn:active {
        transform: translateY(1px);
        opacity: 0.92;
    }

    /* ✅ Selected student avatar inside input */
    .admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar {
        width: 34px;
        height: 34px;
        border-radius: 9999px;
        object-fit: cover;
        flex: 0 0 auto;
        border: 2px solid #fff;
        box-shadow: 0 6px 14px rgba(16, 24, 40, 0.12);
    }

    .admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar_hidden {
        display: none;
    }
</style>

<!-- Modal Overlay -->
<div
    id="admin_dashboard_table_content_menu_teacher_management_add_student_overlay"
    class="fixed inset-0 z-[90] hidden"
    aria-hidden="true">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/25"></div>

    <!-- Modal container -->
    <div class="absolute inset-0 flex items-center justify-center p-3 sm:p-6">
        <div
            id="admin_dashboard_table_content_menu_teacher_management_add_student_modal"
            class="w-[96vw] max-w-[500px] bg-white admin_dashboard_table_content_menu_teacher_management_add_student_shadow border border-slate-200 transition-all duration-150 admin_dashboard_table_content_menu_teacher_management_add_student_hidden admin_dashboard_table_content_menu_teacher_management_add_student_modal_radius"
            role="dialog"
            aria-modal="true"
            aria-labelledby="admin_dashboard_table_content_menu_teacher_management_add_student_title"
            tabindex="-1">

            <!-- Header -->
            <div class="relative px-6 sm:px-10 pt-8">
                <button
                    id="admin_dashboard_table_content_menu_teacher_management_add_student_close_btn"
                    type="button"
                    class="absolute right-3 top-2 inline-flex h-10 w-10 items-center justify-center rounded-full hover:bg-slate-100"
                    aria-label="Close">
                    <span class="text-2xl leading-none text-slate-900">&times;</span>
                </button>

                <h2
                    id="admin_dashboard_table_content_menu_teacher_management_add_student_title"
                    class="text-center text-2xl font-semibold text-slate-900">
                    Add Student
                </h2>

                <p
                    id="admin_dashboard_table_content_menu_teacher_management_add_student_subtitle"
                    class="mt-2 text-center text-sm text-slate-600">
                    Select a student you want to add to FL1
                </p>
            </div>

            <!-- Content -->
            <div class="px-3 sm:px-10 pt-3 pb-3">
                <!-- Input-like field -->
                <div class="relative">
                    <div
                        id="admin_dashboard_table_content_menu_teacher_management_add_student_input_card"
                        class="admin_dashboard_table_content_menu_teacher_management_add_student_input_like">

                        <div class="flex items-center gap-3">
                            <img
                                id="admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar"
                                src=""
                                alt="Selected Student"
                                class="admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar_hidden" />

                            <input
                                id="admin_dashboard_table_content_menu_teacher_management_add_student_search_input"
                                type="text"
                                placeholder="Add student"
                                class="w-full bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:outline-none text-sm text-slate-900 placeholder:text-slate-400"
                                autocomplete="off"
                                style="margin-left:-20px;" />
                        </div>
                    </div>

                    <!-- Dropdown -->
                    <div
                        id="admin_dashboard_table_content_menu_teacher_management_add_student_dropdown"
                        class="admin_dashboard_table_content_menu_teacher_management_add_student_dropdown_panel admin_dashboard_table_content_menu_teacher_management_add_student_dropdown_hidden absolute left-0 right-0 mt-2 z-[200]">
                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_list"
                            class="max-h-[260px] overflow-y-auto"></div>
                    </div>
                </div>

                <!-- Tiles -->
                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Left tile with clickable checkbox -->
                    <div
                        id="admin_dashboard_table_content_menu_teacher_management_add_student_left_card"
                        class="admin_dashboard_table_content_menu_teacher_management_add_student_tile_like flex items-center gap-3 cursor-pointer select-none">
                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_box"
                            aria-pressed="false"
                            aria-label="Toggle Efficient Now">
                            <svg
                                id="admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_icon"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="white"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-4 w-4 hidden">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                        </button>

                        <div class="text-slate-900" style="font-size: 12px;">Efficent Now</div>
                    </div>

                    <!-- Right tile: Pick date and time -->
                    <div
                        id="admin_dashboard_table_content_menu_teacher_management_add_student_right_card"
                        class="admin_dashboard_table_content_menu_teacher_management_add_student_tile_like flex items-center justify-between gap-3 cursor-pointer select-none">
                        <div>
                            <div
                                id="admin_dashboard_table_content_menu_teacher_management_add_student_date_label"
                                class="text-[11px] text-slate-500 leading-4">
                                Change on
                            </div>
                            <div
                                id="admin_dashboard_table_content_menu_teacher_management_add_student_date_value"
                                class="text-slate-900 leading-5"
                                style="font-size: 12px;">
                                Pick date and time
                            </div>
                        </div>

                        <img
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_img_calendar"
                            src="img/calendar.svg"
                            alt="Calendar"
                            class="h-5 w-5 object-contain"
                            loading="lazy" />
                    </div>
                </div>

                <!-- From -> To -->
                <div class="mt-4 grid grid-cols-3 items-center">
                    <div class="text-center">
                        <div class="text-xs text-slate-500">From</div>
                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_from_value"
                            class="text-sm font-semibold text-slate-900">
                            Select Student
                        </div>
                    </div>

                    <div class="text-center text-2xl text-slate-900">&rarr;</div>

                    <div class="text-center">
                        <div class="text-xs text-slate-500">To</div>
                        <div class="text-sm font-semibold text-slate-900">FL1</div>
                    </div>
                </div>

                <!-- Confirm -->
                <button
                    id="admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn"
                    type="button"
                    class="mt-7 w-full bg-red-600 text-white border-2 border-black py-3 text-1xl admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn_style">
                    Confirm
                </button>
            </div>

            <!-- =================== CALENDAR OVERLAY (inside modal) =================== -->
            <div
                id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay"
                class="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay_hidden absolute inset-0 z-[300] flex items-center justify-center">
                <!-- Backdrop inside modal -->
                <div class="absolute inset-0 bg-black/25"></div>

                <!-- Calendar box -->
                <div
                    id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_box"
                    class="relative w-[92%] max-w-[400px] bg-white admin_dashboard_table_content_menu_teacher_management_add_student_calendar_shadow rounded-xl border border-slate-200 overflow-hidden">
                    <!-- Close button -->
                    <button
                        id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close"
                        type="button"
                        class="absolute right-3 top-3 inline-flex h-10 w-10 items-center justify-center rounded-full hover:bg-slate-100"
                        aria-label="Close calendar">
                    </button>

                    <!-- Header -->
                    <div class="px-4 pt-4 pb-3 flex items-center justify-between">
                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_prev"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_navbtn"
                            aria-label="Previous month">
                            <img
                                id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_prev_icon"
                                src="img/arrow-left.svg"
                                alt="Prev"
                                class="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_nav_icon" />
                        </button>

                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_month_title"
                            class="text-lg font-semibold text-slate-900">
                            January 2025
                        </div>

                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_next"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_navbtn"
                            aria-label="Next month">
                            <img
                                id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_next_icon"
                                src="img/arrow-right.svg"
                                alt="Next"
                                class="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_nav_icon" />
                        </button>
                    </div>

                    <!-- Weekdays -->
                    <div class="px-3 pb-2">
                        <div class="grid grid-cols-7 text-sm text-slate-500 font-medium">
                            <div class="text-center">Mo</div>
                            <div class="text-center">Tu</div>
                            <div class="text-center">We</div>
                            <div class="text-center">Th</div>
                            <div class="text-center">Fr</div>
                            <div class="text-center">Sa</div>
                            <div class="text-center">Su</div>
                        </div>
                    </div>

                    <!-- Days grid -->
                    <div class="px-3 pb-3">
                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_days"
                            class="grid grid-cols-7 gap-2"></div>
                    </div>

                    <!-- Footer (DONE button right) -->
                    <div class="px-4 pb-3 flex justify-end">
                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done_btn w-[180px]">
                            Done
                        </button>
                    </div>
                </div>
            </div>
            <!-- =================== /CALENDAR OVERLAY =================== -->
        </div>
    </div>
</div>

<script>
    // =========================================================
    // ✅ NEW FLOW: open via onclick="...toggle(this)" (NO ID dependency)
    // =========================================================

    // Dummy trigger reference: store last clicked trigger (for focus return)
    let admin_dashboard_table_content_menu_teacher_management_add_student_active_trigger = null;

    // ================== ELEMENTS ==================
    const admin_dashboard_table_content_menu_teacher_management_add_student_overlay =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_overlay");

    const admin_dashboard_table_content_menu_teacher_management_add_student_modal =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_modal");

    const admin_dashboard_table_content_menu_teacher_management_add_student_close_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_close_btn");

    const admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn");

    const admin_dashboard_table_content_menu_teacher_management_add_student_input_card =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_input_card");

    const admin_dashboard_table_content_menu_teacher_management_add_student_dropdown =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_dropdown");

    const admin_dashboard_table_content_menu_teacher_management_add_student_list =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_list");

    const admin_dashboard_table_content_menu_teacher_management_add_student_search_input =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_search_input");

    const admin_dashboard_table_content_menu_teacher_management_add_student_from_value =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_from_value");

    const admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar");

    // checkbox elements
    const admin_dashboard_table_content_menu_teacher_management_add_student_left_card =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_left_card");

    const admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn");

    const admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_icon =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_icon");

    // right date tile elements
    const admin_dashboard_table_content_menu_teacher_management_add_student_right_card =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_right_card");

    const admin_dashboard_table_content_menu_teacher_management_add_student_date_value =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_date_value");

    // calendar elements
    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay");

    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_box =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_box");

    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close");

    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_prev =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_prev");

    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_next =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_next");

    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_month_title =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_month_title");

    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_days =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_days");

    const admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done");

    // ================== DATA ==================
    const admin_dashboard_table_content_menu_teacher_management_add_student_students = [{
            id: 1,
            name: "Edwards",
            avatar: "https://i.pravatar.cc/80?img=11"
        },
        {
            id: 2,
            name: "Anna",
            avatar: "https://i.pravatar.cc/80?img=12"
        },
        {
            id: 3,
            name: "Alina",
            avatar: "https://i.pravatar.cc/80?img=13"
        },
        {
            id: 4,
            name: "Bay",
            avatar: "https://i.pravatar.cc/80?img=14"
        },
        {
            id: 5,
            name: "Karma",
            avatar: "https://i.pravatar.cc/80?img=15"
        },
    ];

    let admin_dashboard_table_content_menu_teacher_management_add_student_selected_student = null;

    // checkbox state
    let admin_dashboard_table_content_menu_teacher_management_add_student_is_efficient_now_checked = false;

    // calendar state
    let admin_dashboard_table_content_menu_teacher_management_add_student_calendar_is_open = false;
    let admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year = 2025;
    let admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month = 0;
    let admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected = null;
    const admin_dashboard_table_content_menu_teacher_management_add_student_default_time_text = "23:00";

    // ================== HELPERS ==================
    function admin_dashboard_table_content_menu_teacher_management_add_student_monthName(m) {
        const names = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return names[m];
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_formatFullDateForTile(dateObj) {
        const month = admin_dashboard_table_content_menu_teacher_management_add_student_monthName(dateObj.getMonth());
        const day = dateObj.getDate();
        const year = dateObj.getFullYear();
        return `${month} ${day}, ${year} at ${admin_dashboard_table_content_menu_teacher_management_add_student_default_time_text}`;
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_set_checkbox_ui(checked) {
        admin_dashboard_table_content_menu_teacher_management_add_student_is_efficient_now_checked = checked;

        if (checked) {
            admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn.classList.add(
                "admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_checked"
            );
            admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_icon.classList.remove("hidden");
            admin_dashboard_table_content_menu_teacher_management_add_student_left_card.classList.add(
                "admin_dashboard_table_content_menu_teacher_management_add_student_tile_selected"
            );
            admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn.setAttribute("aria-pressed", "true");
        } else {
            admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn.classList.remove(
                "admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_checked"
            );
            admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_icon.classList.add("hidden");
            admin_dashboard_table_content_menu_teacher_management_add_student_left_card.classList.remove(
                "admin_dashboard_table_content_menu_teacher_management_add_student_tile_selected"
            );
            admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn.setAttribute("aria-pressed", "false");
        }
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_show_avatar(url) {
        admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar.src = url || "";
        admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar_hidden"
        );
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_hide_avatar() {
        admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar.src = "";
        admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_add_student_selected_avatar_hidden"
        );
    }

    // ================== DROPDOWN ==================
    function admin_dashboard_table_content_menu_teacher_management_add_student_open_dropdown() {
        admin_dashboard_table_content_menu_teacher_management_add_student_dropdown.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_add_student_dropdown_hidden"
        );
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_close_dropdown() {
        admin_dashboard_table_content_menu_teacher_management_add_student_dropdown.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_add_student_dropdown_hidden"
        );
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_render_list(filterText = "") {
        const q = filterText.trim().toLowerCase();
        const filtered = admin_dashboard_table_content_menu_teacher_management_add_student_students.filter((s) =>
            s.name.toLowerCase().includes(q)
        );

        admin_dashboard_table_content_menu_teacher_management_add_student_list.innerHTML = "";

        if (filtered.length === 0) {
            admin_dashboard_table_content_menu_teacher_management_add_student_list.innerHTML =
                `<div class="px-4 py-4 text-sm text-slate-500">No students found</div>`;
            return;
        }

        filtered.forEach((student) => {
            const item = document.createElement("div");
            item.className =
                "admin_dashboard_table_content_menu_teacher_management_add_student_student_item flex items-center gap-3 px-4 py-3 border-b border-slate-100 last:border-b-0";

            item.innerHTML = `
        <img src="${student.avatar}" alt="${student.name}" class="h-9 w-9 rounded-full object-cover" />
        <div class="text-sm font-semibold text-slate-900">${student.name}</div>
      `;

            item.addEventListener("click", () => {
                admin_dashboard_table_content_menu_teacher_management_add_student_selected_student = student;
                admin_dashboard_table_content_menu_teacher_management_add_student_from_value.textContent = student.name;
                admin_dashboard_table_content_menu_teacher_management_add_student_search_input.value = student.name;

                admin_dashboard_table_content_menu_teacher_management_add_student_show_avatar(student.avatar);
                admin_dashboard_table_content_menu_teacher_management_add_student_close_dropdown();
            });

            admin_dashboard_table_content_menu_teacher_management_add_student_list.appendChild(item);
        });
    }

    // ================== CALENDAR ==================
    function admin_dashboard_table_content_menu_teacher_management_add_student_calendar_open_fn() {
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_is_open = true;
        admin_dashboard_table_content_menu_teacher_management_add_student_close_dropdown();

        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay_hidden"
        );
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_render();
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close_fn() {
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_is_open = false;
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay_hidden"
        );
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_calendar_render() {
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_month_title.textContent =
            `${admin_dashboard_table_content_menu_teacher_management_add_student_monthName(
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month
      )} ${admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year}`;

        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_days.innerHTML = "";

        const firstDay = new Date(
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year,
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month,
            1
        );

        const firstDayIndexMon = (firstDay.getDay() + 6) % 7;

        const daysInMonth = new Date(
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year,
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month + 1,
            0
        ).getDate();

        const prevMonthLast = new Date(
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year,
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month,
            0
        ).getDate();

        const totalCells = 42;

        for (let cell = 0; cell < totalCells; cell++) {
            const dayBtn = document.createElement("button");
            dayBtn.type = "button";
            dayBtn.className = "admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day";

            const dayNumber = cell - firstDayIndexMon + 1;

            if (dayNumber < 1 || dayNumber > daysInMonth) {
                dayBtn.classList.add("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day_muted");
                dayBtn.textContent = dayNumber < 1 ? (prevMonthLast + dayNumber) : (dayNumber - daysInMonth);
                dayBtn.disabled = true;
            } else {
                dayBtn.textContent = dayNumber;

                if (
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected &&
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected.getFullYear() ===
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year &&
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected.getMonth() ===
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month &&
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected.getDate() === dayNumber
                ) {
                    dayBtn.classList.add("admin_dashboard_table_content_menu_teacher_management_add_student_calendar_day_selected");
                }

                dayBtn.addEventListener("click", () => {
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected = new Date(
                        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year,
                        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month,
                        dayNumber
                    );
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_render();
                });
            }

            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_days.appendChild(dayBtn);
        }
    }

    // ================== MODAL FLOW (open from function) ==================
    function admin_dashboard_table_content_menu_teacher_management_add_student_reset_state() {
        admin_dashboard_table_content_menu_teacher_management_add_student_render_list("");
        admin_dashboard_table_content_menu_teacher_management_add_student_close_dropdown();

        admin_dashboard_table_content_menu_teacher_management_add_student_search_input.value = "";
        admin_dashboard_table_content_menu_teacher_management_add_student_from_value.textContent = "Select Student";
        admin_dashboard_table_content_menu_teacher_management_add_student_selected_student = null;

        admin_dashboard_table_content_menu_teacher_management_add_student_hide_avatar();

        admin_dashboard_table_content_menu_teacher_management_add_student_set_checkbox_ui(false);
        admin_dashboard_table_content_menu_teacher_management_add_student_date_value.textContent = "Pick date and time";

        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year = 2025;
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month = 0;
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected = null;
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_open(triggerEl) {
        admin_dashboard_table_content_menu_teacher_management_add_student_active_trigger = triggerEl || null;

        admin_dashboard_table_content_menu_teacher_management_add_student_reset_state();

        admin_dashboard_table_content_menu_teacher_management_add_student_overlay.classList.remove("hidden");
        admin_dashboard_table_content_menu_teacher_management_add_student_overlay.setAttribute("aria-hidden", "false");

        requestAnimationFrame(() => {
            admin_dashboard_table_content_menu_teacher_management_add_student_modal.classList.remove(
                "admin_dashboard_table_content_menu_teacher_management_add_student_hidden"
            );
            admin_dashboard_table_content_menu_teacher_management_add_student_modal.classList.add(
                "admin_dashboard_table_content_menu_teacher_management_add_student_shown"
            );
        });

        setTimeout(() => {
            admin_dashboard_table_content_menu_teacher_management_add_student_modal.focus();
        }, 0);
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_close() {
        admin_dashboard_table_content_menu_teacher_management_add_student_close_dropdown();
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close_fn();

        admin_dashboard_table_content_menu_teacher_management_add_student_modal.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_add_student_shown"
        );
        admin_dashboard_table_content_menu_teacher_management_add_student_modal.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_add_student_hidden"
        );

        window.setTimeout(() => {
            admin_dashboard_table_content_menu_teacher_management_add_student_overlay.classList.add("hidden");
            admin_dashboard_table_content_menu_teacher_management_add_student_overlay.setAttribute("aria-hidden", "true");

            if (admin_dashboard_table_content_menu_teacher_management_add_student_active_trigger) {
                admin_dashboard_table_content_menu_teacher_management_add_student_active_trigger.focus();
            }

            admin_dashboard_table_content_menu_teacher_management_add_student_active_trigger = null;
        }, 150);
    }

    function admin_dashboard_table_content_menu_teacher_management_add_student_toggle(triggerEl) {
        const isOpen = !admin_dashboard_table_content_menu_teacher_management_add_student_overlay.classList.contains("hidden");
        if (isOpen) {
            admin_dashboard_table_content_menu_teacher_management_add_student_close();
        } else {
            admin_dashboard_table_content_menu_teacher_management_add_student_open(triggerEl);
        }
    }

    // ================== EVENTS (same behavior, but no trigger listener) ==================
    admin_dashboard_table_content_menu_teacher_management_add_student_close_btn.addEventListener("click", () => {
        admin_dashboard_table_content_menu_teacher_management_add_student_close();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_overlay.addEventListener("click", (e) => {
        const clicked_inside = admin_dashboard_table_content_menu_teacher_management_add_student_modal.contains(e.target);
        if (!clicked_inside) admin_dashboard_table_content_menu_teacher_management_add_student_close();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_modal.addEventListener("click", (e) => {
        if (admin_dashboard_table_content_menu_teacher_management_add_student_calendar_is_open) {
            e.stopPropagation();
            return;
        }

        const clickedOnField =
            admin_dashboard_table_content_menu_teacher_management_add_student_input_card.contains(e.target) ||
            admin_dashboard_table_content_menu_teacher_management_add_student_dropdown.contains(e.target);

        if (!clickedOnField) admin_dashboard_table_content_menu_teacher_management_add_student_close_dropdown();
        e.stopPropagation();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_input_card.addEventListener("click", () => {
        if (admin_dashboard_table_content_menu_teacher_management_add_student_calendar_is_open) return;

        admin_dashboard_table_content_menu_teacher_management_add_student_open_dropdown();
        admin_dashboard_table_content_menu_teacher_management_add_student_search_input.focus();
        admin_dashboard_table_content_menu_teacher_management_add_student_render_list(
            admin_dashboard_table_content_menu_teacher_management_add_student_search_input.value
        );
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_search_input.addEventListener("input", (e) => {
        if (admin_dashboard_table_content_menu_teacher_management_add_student_calendar_is_open) return;

        admin_dashboard_table_content_menu_teacher_management_add_student_open_dropdown();
        admin_dashboard_table_content_menu_teacher_management_add_student_render_list(e.target.value);

        const typed = e.target.value.trim().toLowerCase();
        if (
            admin_dashboard_table_content_menu_teacher_management_add_student_selected_student &&
            typed === admin_dashboard_table_content_menu_teacher_management_add_student_selected_student.name.toLowerCase()
        ) {
            admin_dashboard_table_content_menu_teacher_management_add_student_show_avatar(
                admin_dashboard_table_content_menu_teacher_management_add_student_selected_student.avatar
            );
        } else {
            admin_dashboard_table_content_menu_teacher_management_add_student_hide_avatar();
        }
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_checkbox_btn.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_add_student_set_checkbox_ui(
            !admin_dashboard_table_content_menu_teacher_management_add_student_is_efficient_now_checked
        );
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_left_card.addEventListener("click", () => {
        admin_dashboard_table_content_menu_teacher_management_add_student_set_checkbox_ui(
            !admin_dashboard_table_content_menu_teacher_management_add_student_is_efficient_now_checked
        );
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_right_card.addEventListener("click", () => {
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_open_fn();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close.addEventListener("click", () => {
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close_fn();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_prev.addEventListener("click", () => {
        if (admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month === 0) {
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month = 11;
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year -= 1;
        } else {
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month -= 1;
        }
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_render();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_next.addEventListener("click", () => {
        if (admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month === 11) {
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month = 0;
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_year += 1;
        } else {
            admin_dashboard_table_content_menu_teacher_management_add_student_calendar_view_month += 1;
        }
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_render();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_done.addEventListener("click", () => {
        if (admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected) {
            admin_dashboard_table_content_menu_teacher_management_add_student_date_value.textContent =
                admin_dashboard_table_content_menu_teacher_management_add_student_formatFullDateForTile(
                    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_selected
                );
        }
        admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close_fn();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_overlay.addEventListener("click", (e) => {
        const clickedInsideBox = admin_dashboard_table_content_menu_teacher_management_add_student_calendar_box.contains(e.target);
        if (!clickedInsideBox) admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close_fn();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_calendar_box.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    admin_dashboard_table_content_menu_teacher_management_add_student_confirm_btn.addEventListener("click", () => {
        admin_dashboard_table_content_menu_teacher_management_add_student_close();
    });

    document.addEventListener("keydown", (e) => {
        const isOpen = !admin_dashboard_table_content_menu_teacher_management_add_student_overlay.classList.contains("hidden");
        if (!isOpen) return;

        if (e.key === "Escape") {
            if (admin_dashboard_table_content_menu_teacher_management_add_student_calendar_is_open) {
                admin_dashboard_table_content_menu_teacher_management_add_student_calendar_close_fn();
                return;
            }
            admin_dashboard_table_content_menu_teacher_management_add_student_close();
        }
    });

    // initial list render
    admin_dashboard_table_content_menu_teacher_management_add_student_render_list("");
</script>