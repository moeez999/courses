<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .admin_dashboard_table_content_menu_teacher_management_shadow {
        box-shadow: 0 20px 45px rgba(16, 24, 40, 0.18);
    }

    .admin_dashboard_table_content_menu_teacher_management_menu_title {
        letter-spacing: -0.02em;
    }

    .admin_dashboard_table_content_menu_teacher_management_menu_item:hover {
        background: rgba(15, 23, 42, 0.03);
    }

    /* For smooth open/close */
    .admin_dashboard_table_content_menu_teacher_management_popover_hidden {
        opacity: 0;
        transform: translateY(6px);
        pointer-events: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_popover_shown {
        opacity: 1;
        transform: translateY(0px);
        pointer-events: auto;
    }

    /* ===== Footer "Copy Registration link" hover like snapshot ===== */
    .admin_dashboard_table_content_menu_teacher_management_footer_btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 14px;
        border-radius: 8px;
        border: 1px solid #f5f5f5;
        color: #ef4444;
        /* red-500 */
        background: transparent;
        user-select: none;
    }

    .admin_dashboard_table_content_menu_teacher_management_footer_btn:hover {
        background: #ffffff;
        border-color: rgba(15, 23, 42, 0.9);
        /* dark border like snapshot */
    }

    .admin_dashboard_table_content_menu_teacher_management_footer_btn:active {
        transform: translateY(1px);
    }

    .admin_dashboard_table_content_menu_teacher_management_footer_btn:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.25);
    }
</style>

<!-- Transparent click-catcher for outside click (no dark background) -->
<div
    id="admin_dashboard_table_content_menu_teacher_management_outside_layer"
    class="fixed inset-0 z-[60] hidden"
    aria-hidden="true"></div>

<!-- Popover menu (single instance; positioned based on the clicked button passed into the function) -->
<div
    id="admin_dashboard_table_content_menu_teacher_management_popover"
    class="fixed z-[70] hidden transition-all duration-150 admin_dashboard_table_content_menu_teacher_management_popover_hidden"
    role="dialog"
    aria-modal="false"
    aria-labelledby="admin_dashboard_table_content_menu_teacher_management_title">
    <div style="margin-top:100px;"
        id="admin_dashboard_table_content_menu_teacher_management_modal"
        class=" w-[92vw] max-w-[300px] rounded-md bg-white admin_dashboard_table_content_menu_teacher_management_shadow border border-slate-200"
        tabindex="-1">
        <!-- Header -->
        <div class="px-3 sm:px-6 pt-3 sm:pt-6 pb-3">
            <h3
                id="admin_dashboard_table_content_menu_teacher_management_title"
                class="admin_dashboard_table_content_menu_teacher_management_menu_title sm:text-xl font-semibold text-slate-900">
                Teacher Management
            </h3>
        </div>

        <!-- Menu items -->
        <div class="px-1 sm:px-4 pb-1">
            <!-- Item 1 -->
            <button
                id="admin_dashboard_table_content_menu_teacher_management_item_manage_group"
                type="button"
                class="admin_dashboard_table_content_menu_teacher_management_menu_item w-full flex items-center gap-3 rounded-md px-2 sm:px-2 py-2 text-left">
                <span class="shrink-0 inline-flex h-9 w-9 items-center justify-center">
                    <img
                        src="img/manage_group.svg"
                        alt="Manage Group"
                        class="h-5 w-5 object-contain"
                        loading="lazy" />
                </span>
                <span class="text-base sm:text-md text-slate-900">Manage Group</span>
            </button>

            <!-- Item 2 -->
            <button
                onclick="admin_dashboard_table_content_menu_teacher_management_add_student_toggle(this)"
                type="button"
                class="admin_dashboard_table_content_menu_teacher_management_menu_item w-full flex items-center gap-3 rounded-md px-2 sm:px-2 py-2 text-left">
                <span class="shrink-0 inline-flex h-9 w-9 items-center justify-center">
                    <img
                        src="img/add_student.svg"
                        alt="Add Student"
                        class="h-5 w-5 object-contain"
                        loading="lazy" />
                </span>
                <span class="text-base sm:text-md text-slate-900">Add Student</span>
            </button>

            <!-- Item 3 -->
            <a href="http://localhost/latingles_lms_v4/local/attendance/">
                <button
                    id="admin_dashboard_table_content_menu_teacher_management_item_view_attendance"
                    type="button"
                    class="admin_dashboard_table_content_menu_teacher_management_menu_item w-full flex items-center gap-3 rounded-md px-2 sm:px-2 py-2 text-left">
                    <span class="shrink-0 inline-flex h-9 w-9 items-center justify-center">
                        <img
                            src="img/view_attendence.svg"
                            alt="View Attendance"
                            class="h-5 w-5 object-contain"
                            loading="lazy" />
                    </span>
                    <span class="text-base sm:text-md text-slate-900">View Attendence</span>
                </button>
            </a>

            <!-- Item 4 -->
            <button
                onclick="admin_dashboard_table_content_menu_teacher_management_edit_membership_toggle(this)"
                type="button"
                class="admin_dashboard_table_content_menu_teacher_management_menu_item w-full flex items-center gap-3 px-2 sm:px-2 py-2 text-left rounded-md">
                <span class="shrink-0 inline-flex h-9 w-9 items-center justify-center">
                    <img
                        src="img/edit_membership.svg"
                        alt="Edit Membership"
                        class="h-5 w-5 object-contain"
                        loading="lazy" />
                </span>
                <span class="text-base sm:text-md text-slate-900">Edit Membership</span>
            </button>
        </div>

        <!-- Footer -->
        <div class="px-1 sm:px-6 pb-2 sm:pb-6">
            <button
                id="admin_dashboard_table_content_menu_teacher_management_copy_link"
                type="button"
                class="admin_dashboard_table_content_menu_teacher_management_footer_btn">
                <span class="text-sm font-semibold">Copy Registration link</span>

                <img
                    src="img/reg_link.svg"
                    alt="Copy"
                    class="h-4 w-4 object-contain"
                    loading="lazy" />
            </button>

            <div
                id="admin_dashboard_table_content_menu_teacher_management_toast"
                class="mt-3 hidden rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600">
                Link copied!
            </div>
        </div>
    </div>
</div>

<script>
    // ====== Single menu instance, works for ANY trigger button via onclick(this) ======

    // Elements (still one menu, one outside layer)
    const admin_dashboard_table_content_menu_teacher_management_outside_layer =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_outside_layer");

    const admin_dashboard_table_content_menu_teacher_management_popover =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_popover");

    const admin_dashboard_table_content_menu_teacher_management_modal =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_modal");

    const admin_dashboard_table_content_menu_teacher_management_copy_link =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_copy_link");

    const admin_dashboard_table_content_menu_teacher_management_toast =
        document.getElementById("admin_dashboard_table_content_menu_teacher_management_toast");

    // ✅ Stores the button that opened the menu (so we can position relative to it)
    let admin_dashboard_table_content_menu_teacher_management_active_trigger = null;

    function admin_dashboard_table_content_menu_teacher_management_is_mobile_layout() {
        return window.matchMedia("(max-width: 640px)").matches;
    }

    function admin_dashboard_table_content_menu_teacher_management_is_open() {
        return !admin_dashboard_table_content_menu_teacher_management_popover.classList.contains("hidden");
    }

    function admin_dashboard_table_content_menu_teacher_management_set_popover_position() {
        if (!admin_dashboard_table_content_menu_teacher_management_active_trigger) return;

        const rect =
            admin_dashboard_table_content_menu_teacher_management_active_trigger.getBoundingClientRect();

        const gap = 10;
        const popover_width = Math.min(420, window.innerWidth * 0.92);

        let left = rect.left;
        let top = rect.bottom + gap;

        if (admin_dashboard_table_content_menu_teacher_management_is_mobile_layout()) {
            left = rect.left + rect.width / 2 - popover_width / 2;
        }

        const padding = 12;
        left = Math.max(
            padding,
            Math.min(left, window.innerWidth - popover_width - padding)
        );

        const estimated_height = 420;
        if (top + estimated_height > window.innerHeight) {
            const above_top = rect.top - gap - estimated_height;
            top = Math.max(padding, above_top);
        }

        admin_dashboard_table_content_menu_teacher_management_popover.style.left = left + "px";
        admin_dashboard_table_content_menu_teacher_management_popover.style.top = top + "px";
        admin_dashboard_table_content_menu_teacher_management_popover.style.width = popover_width + "px";
    }

    function admin_dashboard_table_content_menu_teacher_management_open(triggerEl) {
        admin_dashboard_table_content_menu_teacher_management_active_trigger = triggerEl;

        admin_dashboard_table_content_menu_teacher_management_set_popover_position();

        admin_dashboard_table_content_menu_teacher_management_outside_layer.classList.remove("hidden");
        admin_dashboard_table_content_menu_teacher_management_outside_layer.setAttribute("aria-hidden", "false");

        admin_dashboard_table_content_menu_teacher_management_popover.classList.remove("hidden");

        requestAnimationFrame(() => {
            admin_dashboard_table_content_menu_teacher_management_popover.classList.remove(
                "admin_dashboard_table_content_menu_teacher_management_popover_hidden"
            );
            admin_dashboard_table_content_menu_teacher_management_popover.classList.add(
                "admin_dashboard_table_content_menu_teacher_management_popover_shown"
            );
        });

        setTimeout(() => admin_dashboard_table_content_menu_teacher_management_modal.focus(), 0);
    }

    function admin_dashboard_table_content_menu_teacher_management_close() {
        admin_dashboard_table_content_menu_teacher_management_popover.classList.remove(
            "admin_dashboard_table_content_menu_teacher_management_popover_shown"
        );
        admin_dashboard_table_content_menu_teacher_management_popover.classList.add(
            "admin_dashboard_table_content_menu_teacher_management_popover_hidden"
        );

        window.setTimeout(() => {
            admin_dashboard_table_content_menu_teacher_management_popover.classList.add("hidden");

            admin_dashboard_table_content_menu_teacher_management_outside_layer.classList.add("hidden");
            admin_dashboard_table_content_menu_teacher_management_outside_layer.setAttribute("aria-hidden", "true");

            // return focus to the trigger that opened the menu
            if (admin_dashboard_table_content_menu_teacher_management_active_trigger) {
                admin_dashboard_table_content_menu_teacher_management_active_trigger.focus();
            }

            admin_dashboard_table_content_menu_teacher_management_active_trigger = null;
        }, 140);
    }

    // ✅ This is what your button calls: onclick="...toggle(this)"
    function admin_dashboard_table_content_menu_teacher_management_toggle(triggerEl) {
        // If clicking the same trigger while open -> close
        if (admin_dashboard_table_content_menu_teacher_management_is_open()) {
            // If a different trigger button is clicked while menu is open -> re-open & reposition
            if (admin_dashboard_table_content_menu_teacher_management_active_trigger !== triggerEl) {
                admin_dashboard_table_content_menu_teacher_management_open(triggerEl);
            } else {
                admin_dashboard_table_content_menu_teacher_management_close();
            }
            return;
        }

        admin_dashboard_table_content_menu_teacher_management_open(triggerEl);
    }

    function admin_dashboard_table_content_menu_teacher_management_show_toast() {
        admin_dashboard_table_content_menu_teacher_management_toast.classList.remove("hidden");
        window.clearTimeout(window.admin_dashboard_table_content_menu_teacher_management_toast_timer);

        window.admin_dashboard_table_content_menu_teacher_management_toast_timer = window.setTimeout(() => {
            admin_dashboard_table_content_menu_teacher_management_toast.classList.add("hidden");
        }, 1400);
    }

    // ====== Events (menu behavior stays the same) ======

    admin_dashboard_table_content_menu_teacher_management_outside_layer.addEventListener("click", () => {
        admin_dashboard_table_content_menu_teacher_management_close();
    });

    admin_dashboard_table_content_menu_teacher_management_modal.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    document.addEventListener("keydown", (e) => {
        if (admin_dashboard_table_content_menu_teacher_management_is_open() && e.key === "Escape") {
            admin_dashboard_table_content_menu_teacher_management_close();
        }
    });

    window.addEventListener("resize", () => {
        if (admin_dashboard_table_content_menu_teacher_management_is_open()) {
            admin_dashboard_table_content_menu_teacher_management_set_popover_position();
        }
    });

    window.addEventListener(
        "scroll",
        () => {
            if (admin_dashboard_table_content_menu_teacher_management_is_open()) {
                admin_dashboard_table_content_menu_teacher_management_set_popover_position();
            }
        },
        true
    );

    // Copy link action (replace with your real URL later)
    admin_dashboard_table_content_menu_teacher_management_copy_link.addEventListener("click", async () => {
        const admin_dashboard_table_content_menu_teacher_management_registration_url =
            "https://example.com/registration"; // change later

        try {
            await navigator.clipboard.writeText(
                admin_dashboard_table_content_menu_teacher_management_registration_url
            );
            admin_dashboard_table_content_menu_teacher_management_show_toast();
        } catch (err) {
            const temp_input = document.createElement("input");
            temp_input.value = admin_dashboard_table_content_menu_teacher_management_registration_url;
            document.body.appendChild(temp_input);
            temp_input.select();
            document.execCommand("copy");
            document.body.removeChild(temp_input);
            admin_dashboard_table_content_menu_teacher_management_show_toast();
        }
    });

    // Close menu on item clicks
    document
        .getElementById("admin_dashboard_table_content_menu_teacher_management_item_manage_group")
        .addEventListener("click", () => admin_dashboard_table_content_menu_teacher_management_close());

    document
        .getElementById("admin_dashboard_table_content_menu_teacher_management_item_add_student")
        .addEventListener("click", () => admin_dashboard_table_content_menu_teacher_management_close());

    document
        .getElementById("admin_dashboard_table_content_menu_teacher_management_item_view_attendance")
        .addEventListener("click", () => admin_dashboard_table_content_menu_teacher_management_close());

    document
        .getElementById("admin_dashboard_table_content_menu_teacher_management_item_edit_membership")
        .addEventListener("click", () => admin_dashboard_table_content_menu_teacher_management_close());
</script>

<?php
require_once("admin_dashboard_table_content_menu_teacher_management_add_student.php");
?>

<?php
require_once("admin_dashboard_table_content_menu_teacher_management_edit_membership.php");
?>