
<style>
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_shadow {
        box-shadow: 0 20px 45px rgba(16, 24, 40, 0.18);
    }

    /* Smooth open/close */
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_hidden {
        opacity: 0;
        transform: translateY(10px);
        pointer-events: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_shown {
        opacity: 1;
        transform: translateY(0px);
        pointer-events: auto;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_modal_radius {
        border-radius: 12px;
    }

    /* ======= FIELD (NO LAYOUT SHIFT / NO LIFT) ======= */
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_field {
        border: 2px solid #e5e7eb;
        border-radius: 5px;
        background: #fff;
        transition: border-color 180ms ease, box-shadow 180ms ease;
        position: relative;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_field:focus-within {
        border-color: #1d4ed8;
        box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.12);
    }

    /* Segmented control */
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_wrap {
        border: 2px solid #e5e7eb;
        border-radius: 9999px;
        background: #fff;
        padding: 6px;
        display: flex;
        gap: 6px;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn {
        flex: 1 1 0%;
        border-radius: 9999px;
        padding: 10px 12px;
        font-weight: 600;
        font-size: 14px;
        transition: background-color 160ms ease, color 160ms ease, box-shadow 160ms ease;
        color: #64748b;
        background: transparent;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active {
        background: #0b2aa6;
        color: #fff;
        box-shadow: 0 10px 18px rgba(11, 42, 166, 0.18);
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active:hover {
        background: #0b2aa6;
        color: #fff;
    }

    /* Red primary button */
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_primary_btn {
        border: 2px solid #000;
        border-radius: 5px;
        transition: opacity 180ms ease, box-shadow 180ms ease, background-color 180ms ease, transform 180ms ease;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_primary_btn:hover {
        opacity: 0.96;
        box-shadow: 0 12px 22px rgba(0, 0, 0, 0.22);
        background-color: #dc2626;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_primary_btn:active {
        transform: translateY(1px);
        opacity: 0.92;
    }

    /* Copy link button */
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_btn {
        border: 2px solid #e5e7eb;
        border-radius: 5px;
        transition: border-color 180ms ease, box-shadow 180ms ease, opacity 180ms ease;
        background: #fff;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_btn:hover {
        border-color: #cbd5e1;
        box-shadow: 0 10px 18px rgba(16, 24, 40, 0.08);
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_btn:active {
        opacity: 0.92;
    }

    /* Trial section show/hide */
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_hidden {
        display: none;
    }

    /* =================== CUSTOM DROPDOWN (FLOATING MENU PORTAL) =================== */
    .admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 12px;
        background: transparent;
        border: 0;
        outline: none;
        cursor: pointer;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_value {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        text-align: left;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_icon {
        width: 15px;
        height: 15px;
        flex: 0 0 auto;
        opacity: 0.9;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu {
        position: fixed;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 18px 35px rgba(16, 24, 40, 0.12);
        overflow: hidden;
        z-index: 100000;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_hidden {
        display: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_float_item {
        padding: 14px 16px;
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        cursor: pointer;
        transition: background-color 160ms ease;
        user-select: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_edit_membership_float_item:hover {
        background: #f8fafc;
    }
</style>

<!-- Modal Overlay -->
<div
    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay"
    class="fixed inset-0 z-[90] hidden"
    aria-hidden="true">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/25"></div>

    <!-- Modal container -->
    <div class="absolute inset-0 flex items-center justify-center p-3 sm:p-6">
        <div
            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_modal"
            class="w-[96vw] max-w-[500px] bg-white admin_dashboard_table_content_menu_teacher_management_edit_membership_shadow border border-slate-200 transition-all duration-150 admin_dashboard_table_content_menu_teacher_management_edit_membership_hidden admin_dashboard_table_content_menu_teacher_management_edit_membership_modal_radius"
            role="dialog"
            aria-modal="true"
            aria-labelledby="admin_dashboard_table_content_menu_teacher_management_edit_membership_title"
            tabindex="-1">

            <!-- Header -->
            <div class="relative px-3 sm:px-10 pt-3">
                <button
                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_close_btn"
                    type="button"
                    class="absolute right-3 top-2 inline-flex h-10 w-10 items-center justify-center rounded-full hover:bg-slate-100"
                    aria-label="Close">
                    <span class="text-2xl leading-none text-slate-900">&times;</span>
                </button>

                <h2
                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_title"
                    class="text-left text-xl font-semibold text-slate-900">
                    Edit Membership
                </h2>
            </div>

            <!-- Content -->
            <div class="px-3 sm:px-10 pt-4 pb-3">
                <!-- Membership name -->
                <div
                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_name_field"
                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_field py-1">
                    <input
                        id="admin_dashboard_table_content_menu_teacher_management_edit_membership_name_input"
                        type="text"
                        placeholder="Entre Membership name"
                        class="w-full bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:outline-none text-sm text-slate-900 placeholder:text-slate-400" />
                </div>

                <!-- Segmented tabs -->
                <div class="mt-3">
                    <div
                        id="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_wrap"
                        class="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_wrap">
                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_annual"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active">
                            Annual
                        </button>
                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_biannual"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn">
                            Biannual
                        </button>
                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_monthly"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn">
                            Monthly
                        </button>
                        <button
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_trial"
                            type="button"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn">
                            Trial
                        </button>
                    </div>
                </div>

                <!-- ============ STANDARD SECTION ============ -->
                <div id="admin_dashboard_table_content_menu_teacher_management_edit_membership_standard_section">
                    <!-- Row: Fee -->
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 items-center gap-3">
                        <div class="text-sm font-semibold text-slate-900">
                            <span id="admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_label">Annual Fee</span>
                        </div>

                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_field"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_field flex items-center justify-start">
                            <input
                                id="admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_input"
                                type="text"
                                value="$ 100"
                                class="w-full bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:outline-none text-sm font-semibold text-slate-900 placeholder:text-slate-400" />
                        </div>
                    </div>

                    <!-- Row: Interval value -->
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 items-center gap-3">
                        <div class="text-sm font-semibold text-slate-900">
                            <span id="admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_label">Annual Interval Value</span>
                        </div>

                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_field"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_field">
                            <button
                                id="admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_btn"
                                type="button"
                                class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_btn"
                                aria-expanded="false">
                                <div
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_value"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_value">1</div>
                                <img
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_icon"
                                    src="img/chevron-down.svg"
                                    alt="Open"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_icon" />
                            </button>
                        </div>
                    </div>

                    <!-- Row: Billing cycle -->
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 items-center gap-3">
                        <div class="text-sm font-semibold text-slate-900">
                            <span id="admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_label">Number Of Annual Billing Cycle</span>
                        </div>

                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_field"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_field">
                            <button
                                id="admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_btn"
                                type="button"
                                class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_btn"
                                aria-expanded="false">
                                <div
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_value"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_value">Never expires</div>
                                <img
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_icon"
                                    src="img/chevron-down.svg"
                                    alt="Open"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_icon" />
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ============ /STANDARD SECTION ============ -->

                <!-- ============ TRIAL SECTION ============ -->
                <div
                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_section"
                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_hidden">

                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 items-center gap-3">
                        <div class="text-sm font-semibold text-slate-900">Membership Type</div>

                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_field"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_field px-2 py-2">
                            <button
                                id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_btn"
                                type="button"
                                class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_btn"
                                aria-expanded="false">
                                <div
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_value"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_value">Monthly</div>
                                <img
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_icon"
                                    src="img/chevron-down.svg"
                                    alt="Open"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_icon" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 items-center gap-3">
                        <div class="text-sm font-semibold text-slate-900">Trial Duration</div>

                        <div
                            id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_field"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_field px-2 py-2">
                            <button
                                id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_btn"
                                type="button"
                                class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_btn"
                                aria-expanded="false">
                                <div
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_value"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_value">1 Month</div>
                                <img
                                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_icon"
                                    src="img/chevron-down.svg"
                                    alt="Open"
                                    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_icon" />
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ============ /TRIAL SECTION ============ -->

                <!-- Copy registration link -->
                <button
                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_link_btn"
                    type="button"
                    class="mt-3 w-full py-3 admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_btn">
                    <span class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-red-600">
                        Copy Registration link
                        <img
                            src="img/copy_reg.svg"
                            alt="Copy"
                            class="admin_dashboard_table_content_menu_teacher_management_edit_membership_dd_icon" />
                    </span>
                </button>

                <!-- Update Membership -->
                <button
                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_update_btn"
                    type="button"
                    class="mt-3 w-full bg-red-600 text-white py-3 text-sm font-semibold admin_dashboard_table_content_menu_teacher_management_edit_membership_primary_btn">
                    Update Membership
                </button>

                <div
                    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback"
                    class="mt-3 text-center text-xs text-slate-500 hidden">
                    Link copied!
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Shared floating dropdown menu (PORTAL) -->
<div
    id="admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu"
    class="admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_hidden"
    role="listbox"
    aria-hidden="true">
    <div id="admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_items"></div>
</div>

<script>
    // =========================================================
    // ✅ Same flow as above: open via onclick="...toggle(this)"
    // =========================================================

    // Store trigger so we can focus back on close
    let admin_dashboard_table_content_menu_teacher_management_edit_membership_active_trigger = null;

    // ================== Elements ==================
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_modal =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_modal");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_close_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_close_btn");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_link_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_link_btn");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_update_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_update_btn");

    // Sections + labels
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_standard_section =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_standard_section");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_section =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_section");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_label =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_label");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_label =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_label");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_label =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_label");

    // Segments
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_annual =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_annual");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_biannual =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_biannual");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_monthly =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_monthly");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_trial =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_trial");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_segments = [
        admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_annual,
        admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_biannual,
        admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_monthly,
        admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_trial,
    ];

    // Standard dropdown buttons / values
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_btn");
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_value =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_value");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_btn");
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_value =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_value");

    // Trial dropdown buttons / values
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_btn");
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_value =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_value");

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_btn =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_btn");
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_value =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_value");

    // Floating menu
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu");
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_items =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_items");

    // ================== State ==================
    let admin_dashboard_table_content_menu_teacher_management_edit_membership_active_plan = "annual";
    let admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open = false;
    let admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn = null;
    let admin_dashboard_table_content_menu_teacher_management_edit_membership_float_on_select = null;

    // Options
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_options = ["1", "2", "3", "4", "6", "12"];
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_options = ["Never expires", "1", "2", "3", "4", "6", "12"];

    const admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_options = ["Monthly", "Biannual", "Annual"];
    const admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_options = ["1 Month", "2 Month", "3 Month", "4 Month"];

    // ================== Modal Open/Close (function-based) ==================
    function admin_dashboard_table_content_menu_teacher_management_edit_membership_is_open() {
        return !admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay.classList.contains("hidden");
    }

    function admin_dashboard_table_content_menu_teacher_management_edit_membership_open(triggerEl) {
        admin_dashboard_table_content_menu_teacher_management_edit_membership_active_trigger = triggerEl || null;

        admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay.classList.remove("hidden");
        admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay.setAttribute("aria-hidden", "false");

        requestAnimationFrame(() => {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_modal.classList.remove(
                "admin_dashboard_table_content_menu_teacher_management_edit_membership_hidden"
            );
            admin_dashboard_table_content_menu_teacher_management_edit_membership_modal.classList.add(
                "admin_dashboard_table_content_menu_teacher_management_edit_membership_shown"
            );
        });

        // default state
        admin_dashboard_table_content_menu_teacher_management_edit_membership_set_active_segment("annual");

        setTimeout(() => admin_dashboard_table_content_menu_teacher_management_edit_membership_modal.focus(), 0);
    }

    function admin_dashboard_table_content_menu_teacher_management_edit_membership_close() {
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();

        admin_dashboard_table_content_menu_teacher_management_edit_membership_modal.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_edit_membership_shown"
        );
        admin_dashboard_table_content_menu_teacher_management_edit_membership_modal.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_edit_membership_hidden"
        );

        window.setTimeout(() => {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay.classList.add("hidden");
            admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay.setAttribute("aria-hidden", "true");

            if (admin_dashboard_table_content_menu_teacher_management_edit_membership_active_trigger) {
                admin_dashboard_table_content_menu_teacher_management_edit_membership_active_trigger.focus();
            }
            admin_dashboard_table_content_menu_teacher_management_edit_membership_active_trigger = null;
        }, 150);
    }

    // ✅ This is what your (future) dynamic button will call: onclick="...toggle(this)"
    function admin_dashboard_table_content_menu_teacher_management_edit_membership_toggle(triggerEl) {
        if (admin_dashboard_table_content_menu_teacher_management_edit_membership_is_open()) {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_close();
        } else {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_open(triggerEl);
        }
    }

    // ================== Segments ==================
    function admin_dashboard_table_content_menu_teacher_management_edit_membership_set_active_segment(planKey) {
        admin_dashboard_table_content_menu_teacher_management_edit_membership_active_plan = planKey;
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();

        admin_dashboard_table_content_menu_teacher_management_edit_membership_segments.forEach((btn) => {
            btn.classList.remove("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active");
        });

        if (planKey === "annual") admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_annual.classList.add("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active");
        if (planKey === "biannual") admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_biannual.classList.add("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active");
        if (planKey === "monthly") admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_monthly.classList.add("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active");
        if (planKey === "trial") admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_trial.classList.add("admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_btn_active");

        if (planKey === "trial") {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_standard_section.classList.add(
                "admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_hidden"
            );
            admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_section.classList.remove(
                "admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_hidden"
            );
            return;
        }

        admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_section.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_hidden"
        );
        admin_dashboard_table_content_menu_teacher_management_edit_membership_standard_section.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_hidden"
        );

        if (planKey === "annual") {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_label.textContent = "Annual Fee";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_label.textContent = "Annual Interval Value";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_label.textContent = "Number Of Annual Billing Cycle";
        } else if (planKey === "biannual") {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_label.textContent = "Biannual Fee";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_label.textContent = "Biannual Interval Value";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_label.textContent = "Number Of Biannual Billing Cycle";
        } else {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_fee_label.textContent = "Monthly Fee";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_label.textContent = "Monthly Interval Value";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_label.textContent = "Number Of Monthly Billing Cycle";
        }
    }

    // ================== Floating Dropdown (Portal) ==================
    function admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open_for_button(btnEl, options, onSelect) {
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();

        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn = btnEl;
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_on_select = onSelect;

        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_items.innerHTML = "";
        options.forEach((opt) => {
            const item = document.createElement("div");
            item.className = "admin_dashboard_table_content_menu_teacher_management_edit_membership_float_item";
            item.textContent = opt;
            item.addEventListener("click", (e) => {
                e.stopPropagation();
                if (admin_dashboard_table_content_menu_teacher_management_edit_membership_float_on_select) {
                    admin_dashboard_table_content_menu_teacher_management_edit_membership_float_on_select(opt);
                }
                admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();
            });
            admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_items.appendChild(item);
        });

        const rect = btnEl.getBoundingClientRect();
        const top = rect.bottom + 10;
        const left = rect.left;
        const width = rect.width;

        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.style.top = `${top}px`;
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.style.left = `${left}px`;
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.style.width = `${width}px`;

        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_hidden"
        );
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.setAttribute("aria-hidden", "false");
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open = true;

        btnEl.setAttribute("aria-expanded", "true");
    }

    function admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close() {
        if (admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn) {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn.setAttribute("aria-expanded", "false");
        }
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn = null;
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_on_select = null;

        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu_hidden"
        );
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.setAttribute("aria-hidden", "true");
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open = false;
    }

    function admin_dashboard_table_content_menu_teacher_management_edit_membership_float_reposition_if_open() {
        if (!admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open) return;
        if (!admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn) return;

        const rect = admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn.getBoundingClientRect();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.style.top = `${rect.bottom + 10}px`;
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.style.left = `${rect.left}px`;
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.style.width = `${rect.width}px`;
    }

    function admin_dashboard_table_content_menu_teacher_management_edit_membership_toggle_float(btnEl, options, onSelect) {
        const isSame = admin_dashboard_table_content_menu_teacher_management_edit_membership_float_anchor_btn === btnEl;
        if (admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open && isSame) {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();
            return;
        }
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open_for_button(btnEl, options, onSelect);
    }

    // ================== Events ==================
    admin_dashboard_table_content_menu_teacher_management_edit_membership_close_btn.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_close();
    });

    admin_dashboard_table_content_menu_teacher_management_edit_membership_overlay.addEventListener("click", (e) => {
        const clicked_inside = admin_dashboard_table_content_menu_teacher_management_edit_membership_modal.contains(e.target);
        if (!clicked_inside) admin_dashboard_table_content_menu_teacher_management_edit_membership_close();
    });

    // clicking inside modal closes dropdown (but not if click on dropdown button)
    admin_dashboard_table_content_menu_teacher_management_edit_membership_modal.addEventListener("click", () => {
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();
    });

    // segment clicks
    admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_annual.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_set_active_segment("annual");
    });
    admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_biannual.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_set_active_segment("biannual");
    });
    admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_monthly.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_set_active_segment("monthly");
    });
    admin_dashboard_table_content_menu_teacher_management_edit_membership_segment_trial.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_set_active_segment("trial");
    });

    // Standard dropdowns
    admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_btn.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_toggle_float(
            admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_btn,
            admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_options,
            (val) => (admin_dashboard_table_content_menu_teacher_management_edit_membership_interval_dd_value.textContent = val)
        );
    });

    admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_btn.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_toggle_float(
            admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_btn,
            admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_options,
            (val) => (admin_dashboard_table_content_menu_teacher_management_edit_membership_billing_dd_value.textContent = val)
        );
    });

    // Trial dropdowns
    admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_btn.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_toggle_float(
            admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_btn,
            admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_options,
            (val) => (admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_type_dd_value.textContent = val)
        );
    });

    admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_btn.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_toggle_float(
            admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_btn,
            admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_options,
            (val) => (admin_dashboard_table_content_menu_teacher_management_edit_membership_trial_duration_dd_value.textContent = val)
        );
    });

    // clicking on floating menu should not close it
    admin_dashboard_table_content_menu_teacher_management_edit_membership_float_menu.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    // reposition on scroll/resize
    window.addEventListener("scroll", admin_dashboard_table_content_menu_teacher_management_edit_membership_float_reposition_if_open, true);
    window.addEventListener("resize", admin_dashboard_table_content_menu_teacher_management_edit_membership_float_reposition_if_open);

    // Copy link (demo)
    admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_link_btn.addEventListener("click", async (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();

        const link_to_copy = "https://example.com/registration";
        try {
            await navigator.clipboard.writeText(link_to_copy);
            admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback.textContent = "Link copied!";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback.classList.remove("hidden");
            setTimeout(() => admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback.classList.add("hidden"), 1200);
        } catch (err) {
            admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback.textContent = "Unable to copy (browser blocked).";
            admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback.classList.remove("hidden");
            setTimeout(() => admin_dashboard_table_content_menu_teacher_management_edit_membership_copy_feedback.classList.add("hidden"), 1400);
        }
    });

    // Update (demo)
    admin_dashboard_table_content_menu_teacher_management_edit_membership_update_btn.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();
        admin_dashboard_table_content_menu_teacher_management_edit_membership_close();
    });

    // ESC
    document.addEventListener("keydown", (e) => {
        if (!admin_dashboard_table_content_menu_teacher_management_edit_membership_is_open()) return;

        if (e.key === "Escape") {
            if (admin_dashboard_table_content_menu_teacher_management_edit_membership_float_open) {
                admin_dashboard_table_content_menu_teacher_management_edit_membership_float_close();
                return;
            }
            admin_dashboard_table_content_menu_teacher_management_edit_membership_close();
        }
    });
</script>