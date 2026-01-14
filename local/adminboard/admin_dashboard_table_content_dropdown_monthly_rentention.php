<?php
// admin_dashboard_table_content_dropdown_monthly_rentention.php
?>

<!-- MONTHLY RETENTION DROPDOWN (Range slider 0-100%) -->
<div class="relative inline-block">
    <!-- Trigger -->
    <button
        id="admin_dashboard_table_content_dropdown_monthly_retention_button"
        type="button"
        class="admin_dashboard_table_content_dropdown_monthly_retention_button ml-3 inline-flex items-center justify-between gap-3 w-45 px-3 py-2 rounded-md bg-white border border-slate-200 shadow-sm hover:bg-slate-50 active:bg-slate-100 transition"
        aria-haspopup="dialog"
        aria-expanded="false"
        style="height:50px;">
        <span id="admin_dashboard_table_content_dropdown_monthly_retention_button_label" class="text-slate-900 font-medium">
            Monthly Retention
        </span>

        <svg class="w-5 h-5 text-slate-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Panel -->
    <div
        id="admin_dashboard_table_content_dropdown_monthly_retention_panel"
        class="admin_dashboard_table_content_dropdown_monthly_retention_panel hidden absolute z-50 mt-2 w-[350px] rounded-xl bg-white border border-slate-200 shadow-xl"
        role="dialog"
        aria-modal="false">
        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 border-b border-slate-100">
            <span class="text-slate-900 font-semibold text-md">Monthly Retention</span>
            <button
                id="admin_dashboard_table_content_dropdown_monthly_retention_reset"
                type="button"
                class="admin_dashboard_table_content_dropdown_monthly_retention_reset inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm"
                style="margin-right:0px;">
                <span
                    class="inline-flex items-center justify-center w-4 h-4 rounded-full"
                    style="background:red; color:white; font-weight:800; font-size:7px;">✕</span>
                Reset
            </button>
        </div>

        <!-- Body -->
        <div class="px-6 py-3">
            <!-- 0% / 100% -->
            <div class="flex items-center justify-between text-slate-500" style="font-size:14px;">
                <span id="admin_dashboard_table_content_dropdown_monthly_retention_label_min">0%</span>
                <span id="admin_dashboard_table_content_dropdown_monthly_retention_label_max">100%</span>
            </div>

            <!-- Slider -->
            <div class="mt-1">
                <div
                    id="admin_dashboard_table_content_dropdown_monthly_retention_slider_outer"
                    class="admin_dashboard_table_content_dropdown_monthly_retention_slider_outer relative w-full"
                    style="height:46px;">
                    <!-- Track bg -->
                    <div
                        id="admin_dashboard_table_content_dropdown_monthly_retention_track_bg"
                        class="admin_dashboard_table_content_dropdown_monthly_retention_track_bg absolute left-0 right-0 top-1/2 -translate-y-1/2 rounded-full"
                        style="height:10px; background:#e5e7eb;"></div>

                    <!-- Track range -->
                    <div
                        id="admin_dashboard_table_content_dropdown_monthly_retention_track_range"
                        class="admin_dashboard_table_content_dropdown_monthly_retention_track_range absolute top-1/2 -translate-y-1/2 rounded-full"
                        style="height:10px; left:0px; width:0px; background:#ff2d10;"></div>

                    <!-- Thumb Left (now with white ring like right) -->
                    <div
                        id="admin_dashboard_table_content_dropdown_monthly_retention_thumb_left"
                        class="admin_dashboard_table_content_dropdown_monthly_retention_thumb_left admin_dashboard_table_content_dropdown_monthly_retention_no_select absolute top-1/2 -translate-y-1/2 rounded-full cursor-grab active:cursor-grabbing"
                        style="
                            width:22px; height:22px;
                            background:#ff2d10;
                            left:0px;
                            box-shadow:0 6px 14px rgba(0,0,0,0.15);
                        "
                        role="slider"
                        aria-label="Retention start"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="25"
                        tabindex="0">
                        <span class="block w-full h-full rounded-full"
                            style="border:4px solid #ffffff; box-sizing:border-box;"></span>
                    </div>

                    <!-- Thumb Right -->
                    <div
                        id="admin_dashboard_table_content_dropdown_monthly_retention_thumb_right"
                        class="admin_dashboard_table_content_dropdown_monthly_retention_thumb_right admin_dashboard_table_content_dropdown_monthly_retention_no_select absolute top-1/2 -translate-y-1/2 rounded-full cursor-grab active:cursor-grabbing"
                        style="
                            width:22px; height:22px;
                            background:#ff2d10;
                            left:0px;
                            box-shadow:0 8px 18px rgba(0,0,0,0.18);
                        "
                        role="slider"
                        aria-label="Retention end"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="75"
                        tabindex="0">
                        <span
                            class="block w-full h-full rounded-full"
                            style="border:4px solid #ffffff; box-sizing:border-box;"></span>
                    </div>
                </div>

                <!-- ✅ Values under (moved up closer to slider) -->
                <div
                    id="admin_dashboard_table_content_dropdown_monthly_retention_values_row"
                    class="relative"
                    style="height:20px; margin-top:-2px;">

                    <span
                        id="admin_dashboard_table_content_dropdown_monthly_retention_value_left"
                        class="absolute text-slate-900"
                        style="font-size:14px; font-weight:400; left:0; top:0; transform:translateX(-50%);">
                        25%
                    </span>

                    <span
                        id="admin_dashboard_table_content_dropdown_monthly_retention_value_right"
                        class="absolute text-slate-900"
                        style="font-size:14px; font-weight:400; left:0; top:0; transform:translateX(-50%);">
                        75%
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* ====== ELEMENTS ====== */
    const admin_dashboard_table_content_dropdown_monthly_retention_button =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_button");
    const admin_dashboard_table_content_dropdown_monthly_retention_button_label =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_button_label");
    const admin_dashboard_table_content_dropdown_monthly_retention_panel =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_panel");
    const admin_dashboard_table_content_dropdown_monthly_retention_reset =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_reset");

    const admin_dashboard_table_content_dropdown_monthly_retention_slider_outer =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_slider_outer");
    const admin_dashboard_table_content_dropdown_monthly_retention_track_range =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_track_range");

    const admin_dashboard_table_content_dropdown_monthly_retention_thumb_left =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_thumb_left");
    const admin_dashboard_table_content_dropdown_monthly_retention_thumb_right =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_thumb_right");

    const admin_dashboard_table_content_dropdown_monthly_retention_value_left =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_value_left");
    const admin_dashboard_table_content_dropdown_monthly_retention_value_right =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_value_right");

    const admin_dashboard_table_content_dropdown_monthly_retention_values_row =
        document.getElementById("admin_dashboard_table_content_dropdown_monthly_retention_values_row");

    /* ====== STATE ====== */
    let admin_dashboard_table_content_dropdown_monthly_retention_isOpen = false;

    let admin_dashboard_table_content_dropdown_monthly_retention_min = 0;
    let admin_dashboard_table_content_dropdown_monthly_retention_max = 100;

    // default like snapshot
    let admin_dashboard_table_content_dropdown_monthly_retention_leftValue = 25;
    let admin_dashboard_table_content_dropdown_monthly_retention_rightValue = 75;

    let admin_dashboard_table_content_dropdown_monthly_retention_dragging = null; // "left" | "right"
    let admin_dashboard_table_content_dropdown_monthly_retention_rect = null;

    /* ====== HELPERS ====== */
    function admin_dashboard_table_content_dropdown_monthly_retention_clamp(n, min, max) {
        return Math.max(min, Math.min(max, n));
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_setOpen(open) {
        admin_dashboard_table_content_dropdown_monthly_retention_isOpen = open;

        if (open) {
            document.dispatchEvent(
                new CustomEvent("admin_dashboard_table_content_dropdown_any_opened", {
                    detail: {
                        name: "monthly_retention"
                    }
                })
            );
        }

        if (open) {
            admin_dashboard_table_content_dropdown_monthly_retention_panel.classList.remove("hidden");
            admin_dashboard_table_content_dropdown_monthly_retention_button.setAttribute("aria-expanded", "true");
            admin_dashboard_table_content_dropdown_monthly_retention_rect =
                admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.getBoundingClientRect();
            admin_dashboard_table_content_dropdown_monthly_retention_updateUI();
        } else {
            admin_dashboard_table_content_dropdown_monthly_retention_panel.classList.add("hidden");
            admin_dashboard_table_content_dropdown_monthly_retention_button.setAttribute("aria-expanded", "false");
        }
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_valueToPx(val) {
        const w = admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.clientWidth;
        const pct = (val - admin_dashboard_table_content_dropdown_monthly_retention_min) /
            (admin_dashboard_table_content_dropdown_monthly_retention_max - admin_dashboard_table_content_dropdown_monthly_retention_min);
        return pct * w;
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_pxToValue(px) {
        const w = admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.clientWidth;
        const pct = (w === 0) ? 0 : (px / w);
        const v = admin_dashboard_table_content_dropdown_monthly_retention_min +
            pct * (admin_dashboard_table_content_dropdown_monthly_retention_max - admin_dashboard_table_content_dropdown_monthly_retention_min);
        return Math.round(v);
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_normalize() {
        admin_dashboard_table_content_dropdown_monthly_retention_leftValue =
            admin_dashboard_table_content_dropdown_monthly_retention_clamp(
                admin_dashboard_table_content_dropdown_monthly_retention_leftValue,
                admin_dashboard_table_content_dropdown_monthly_retention_min,
                admin_dashboard_table_content_dropdown_monthly_retention_max
            );

        admin_dashboard_table_content_dropdown_monthly_retention_rightValue =
            admin_dashboard_table_content_dropdown_monthly_retention_clamp(
                admin_dashboard_table_content_dropdown_monthly_retention_rightValue,
                admin_dashboard_table_content_dropdown_monthly_retention_min,
                admin_dashboard_table_content_dropdown_monthly_retention_max
            );

        if (admin_dashboard_table_content_dropdown_monthly_retention_leftValue > admin_dashboard_table_content_dropdown_monthly_retention_rightValue) {
            const t = admin_dashboard_table_content_dropdown_monthly_retention_leftValue;
            admin_dashboard_table_content_dropdown_monthly_retention_leftValue = admin_dashboard_table_content_dropdown_monthly_retention_rightValue;
            admin_dashboard_table_content_dropdown_monthly_retention_rightValue = t;
        }
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_updateButtonLabel() {
        admin_dashboard_table_content_dropdown_monthly_retention_button_label.textContent = "Monthly Retention";
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_updateUI() {
        admin_dashboard_table_content_dropdown_monthly_retention_normalize();

        const sliderW = admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.clientWidth;

        const leftPx = admin_dashboard_table_content_dropdown_monthly_retention_valueToPx(admin_dashboard_table_content_dropdown_monthly_retention_leftValue);
        const rightPx = admin_dashboard_table_content_dropdown_monthly_retention_valueToPx(admin_dashboard_table_content_dropdown_monthly_retention_rightValue);

        // Thumbs (both 22px now)
        const thumbHalf = 11; // 22px / 2

        admin_dashboard_table_content_dropdown_monthly_retention_thumb_left.style.left =
            `${admin_dashboard_table_content_dropdown_monthly_retention_clamp(leftPx - thumbHalf, 0, sliderW - 22)}px`;

        admin_dashboard_table_content_dropdown_monthly_retention_thumb_right.style.left =
            `${admin_dashboard_table_content_dropdown_monthly_retention_clamp(rightPx - thumbHalf, 0, sliderW - 22)}px`;

        // Range track
        const start = Math.min(leftPx, rightPx);
        const end = Math.max(leftPx, rightPx);
        admin_dashboard_table_content_dropdown_monthly_retention_track_range.style.left = `${start}px`;
        admin_dashboard_table_content_dropdown_monthly_retention_track_range.style.width = `${Math.max(0, end - start)}px`;

        // Values text
        admin_dashboard_table_content_dropdown_monthly_retention_value_left.textContent =
            `${admin_dashboard_table_content_dropdown_monthly_retention_leftValue}%`;
        admin_dashboard_table_content_dropdown_monthly_retention_value_right.textContent =
            `${admin_dashboard_table_content_dropdown_monthly_retention_rightValue}%`;

        // ✅ Values position (move with thumbs) + clamp inside container
        const rowW = admin_dashboard_table_content_dropdown_monthly_retention_values_row.clientWidth;

        const leftTextW = admin_dashboard_table_content_dropdown_monthly_retention_value_left.offsetWidth || 0;
        const rightTextW = admin_dashboard_table_content_dropdown_monthly_retention_value_right.offsetWidth || 0;

        const leftCenter = admin_dashboard_table_content_dropdown_monthly_retention_clamp(leftPx, leftTextW / 2, rowW - leftTextW / 2);
        const rightCenter = admin_dashboard_table_content_dropdown_monthly_retention_clamp(rightPx, rightTextW / 2, rowW - rightTextW / 2);

        admin_dashboard_table_content_dropdown_monthly_retention_value_left.style.left = `${leftCenter}px`;
        admin_dashboard_table_content_dropdown_monthly_retention_value_right.style.left = `${rightCenter}px`;

        // ARIA
        admin_dashboard_table_content_dropdown_monthly_retention_thumb_left.setAttribute("aria-valuenow", String(admin_dashboard_table_content_dropdown_monthly_retention_leftValue));
        admin_dashboard_table_content_dropdown_monthly_retention_thumb_right.setAttribute("aria-valuenow", String(admin_dashboard_table_content_dropdown_monthly_retention_rightValue));
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_startDrag(which, e) {
        admin_dashboard_table_content_dropdown_monthly_retention_dragging = which;
        admin_dashboard_table_content_dropdown_monthly_retention_rect =
            admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.getBoundingClientRect();

        const thumbEl = which === "left" ?
            admin_dashboard_table_content_dropdown_monthly_retention_thumb_left :
            admin_dashboard_table_content_dropdown_monthly_retention_thumb_right;

        thumbEl.setPointerCapture(e.pointerId);
        admin_dashboard_table_content_dropdown_monthly_retention_dragFromClientX(which, e.clientX);
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_dragFromClientX(which, clientX) {
        if (!admin_dashboard_table_content_dropdown_monthly_retention_rect) return;

        const xIn = admin_dashboard_table_content_dropdown_monthly_retention_clamp(
            clientX - admin_dashboard_table_content_dropdown_monthly_retention_rect.left,
            0,
            admin_dashboard_table_content_dropdown_monthly_retention_rect.width
        );

        const v = admin_dashboard_table_content_dropdown_monthly_retention_pxToValue(xIn);

        if (which === "left") admin_dashboard_table_content_dropdown_monthly_retention_leftValue = v;
        else admin_dashboard_table_content_dropdown_monthly_retention_rightValue = v;

        admin_dashboard_table_content_dropdown_monthly_retention_updateUI();
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_endDrag(e) {
        if (!admin_dashboard_table_content_dropdown_monthly_retention_dragging) return;

        const thumbEl = admin_dashboard_table_content_dropdown_monthly_retention_dragging === "left" ?
            admin_dashboard_table_content_dropdown_monthly_retention_thumb_left :
            admin_dashboard_table_content_dropdown_monthly_retention_thumb_right;

        try {
            thumbEl.releasePointerCapture(e.pointerId);
        } catch (_) {}
        admin_dashboard_table_content_dropdown_monthly_retention_dragging = null;
    }

    function admin_dashboard_table_content_dropdown_monthly_retention_resetAll() {
        admin_dashboard_table_content_dropdown_monthly_retention_leftValue = 25;
        admin_dashboard_table_content_dropdown_monthly_retention_rightValue = 75;
        admin_dashboard_table_content_dropdown_monthly_retention_updateUI();
    }

    /* ====== EVENTS ====== */
    admin_dashboard_table_content_dropdown_monthly_retention_button.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_monthly_retention_setOpen(!admin_dashboard_table_content_dropdown_monthly_retention_isOpen);
    });

    admin_dashboard_table_content_dropdown_monthly_retention_reset.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_monthly_retention_resetAll();
    });

    document.addEventListener("admin_dashboard_table_content_dropdown_any_opened", (e) => {
        if (e.detail && e.detail.name !== "monthly_retention") {
            admin_dashboard_table_content_dropdown_monthly_retention_setOpen(false);
        }
    });

    admin_dashboard_table_content_dropdown_monthly_retention_panel.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    document.addEventListener("click", (e) => {
        if (!admin_dashboard_table_content_dropdown_monthly_retention_isOpen) return;
        const target = e.target;
        const clickedInside =
            admin_dashboard_table_content_dropdown_monthly_retention_panel.contains(target) ||
            admin_dashboard_table_content_dropdown_monthly_retention_button.contains(target);
        if (!clickedInside) admin_dashboard_table_content_dropdown_monthly_retention_setOpen(false);
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            admin_dashboard_table_content_dropdown_monthly_retention_setOpen(false);
            admin_dashboard_table_content_dropdown_monthly_retention_button.focus();
        }
    });

    // Drag thumbs
    admin_dashboard_table_content_dropdown_monthly_retention_thumb_left.addEventListener("pointerdown", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_monthly_retention_startDrag("left", e);
    });
    admin_dashboard_table_content_dropdown_monthly_retention_thumb_right.addEventListener("pointerdown", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_monthly_retention_startDrag("right", e);
    });

    admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.addEventListener("pointermove", (e) => {
        if (!admin_dashboard_table_content_dropdown_monthly_retention_dragging) return;
        admin_dashboard_table_content_dropdown_monthly_retention_dragFromClientX(
            admin_dashboard_table_content_dropdown_monthly_retention_dragging,
            e.clientX
        );
    });
    admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.addEventListener("pointerup", admin_dashboard_table_content_dropdown_monthly_retention_endDrag);
    admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.addEventListener("pointercancel", admin_dashboard_table_content_dropdown_monthly_retention_endDrag);

    // Click on track to move nearest thumb
    admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.addEventListener("pointerdown", (e) => {
        if (e.target === admin_dashboard_table_content_dropdown_monthly_retention_thumb_left ||
            e.target === admin_dashboard_table_content_dropdown_monthly_retention_thumb_right ||
            admin_dashboard_table_content_dropdown_monthly_retention_thumb_right.contains(e.target) ||
            admin_dashboard_table_content_dropdown_monthly_retention_thumb_left.contains(e.target)) {
            return;
        }

        e.stopPropagation();
        admin_dashboard_table_content_dropdown_monthly_retention_rect =
            admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.getBoundingClientRect();

        const xIn = admin_dashboard_table_content_dropdown_monthly_retention_clamp(
            e.clientX - admin_dashboard_table_content_dropdown_monthly_retention_rect.left,
            0,
            admin_dashboard_table_content_dropdown_monthly_retention_rect.width
        );

        const v = admin_dashboard_table_content_dropdown_monthly_retention_pxToValue(xIn);

        const distLeft = Math.abs(v - admin_dashboard_table_content_dropdown_monthly_retention_leftValue);
        const distRight = Math.abs(v - admin_dashboard_table_content_dropdown_monthly_retention_rightValue);

        if (distLeft <= distRight) admin_dashboard_table_content_dropdown_monthly_retention_leftValue = v;
        else admin_dashboard_table_content_dropdown_monthly_retention_rightValue = v;

        admin_dashboard_table_content_dropdown_monthly_retention_updateUI();
    });

    window.addEventListener("resize", () => {
        if (!admin_dashboard_table_content_dropdown_monthly_retention_isOpen) return;
        admin_dashboard_table_content_dropdown_monthly_retention_rect =
            admin_dashboard_table_content_dropdown_monthly_retention_slider_outer.getBoundingClientRect();
        admin_dashboard_table_content_dropdown_monthly_retention_updateUI();
    });

    document.addEventListener("admin_dashboard_table_content_dropdown_reset_all", () => {
        admin_dashboard_table_content_dropdown_monthly_retention_resetAll();
    });

    /* ====== INIT ====== */
    admin_dashboard_table_content_dropdown_monthly_retention_updateButtonLabel();
    admin_dashboard_table_content_dropdown_monthly_retention_updateUI();
</script>