<?php
// admin_dashboard_table_content_dropdown_group_size.php
?>

<!-- GROUP SIZE DROPDOWN (Range) -->
<div class="relative inline-block">
    <!-- Trigger -->
    <button
        id="admin_dashboard_table_content_dropdown_group_size_button"
        type="button"
        class="admin_dashboard_table_content_dropdown_group_size_button ml-3 inline-flex items-center justify-between gap-3 w-35 px-2 py-2 rounded-md bg-white border border-slate-200 shadow-sm hover:bg-slate-50 active:bg-slate-100 transition"
        aria-haspopup="dialog"
        aria-expanded="false"
        style="height:50px;">
        <span id="admin_dashboard_table_content_dropdown_group_size_button_label" class="text-slate-900 font-medium">
            Group Size
        </span>

        <svg class="w-5 h-5 text-slate-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Panel -->
    <div
        id="admin_dashboard_table_content_dropdown_group_size_panel"
        class="admin_dashboard_table_content_dropdown_group_size_panel hidden absolute z-50 mt-2 w-[220px] sm:w-[260px] rounded-md bg-white border border-slate-200 shadow-xl"
        role="dialog"
        aria-modal="false">
        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 border-b border-slate-100">
            <span class="text-slate-900 font-semibold text-md">Group Size</span>
            <button
                id="admin_dashboard_table_content_dropdown_group_size_reset"
                type="button"
                class="admin_dashboard_table_content_dropdown_group_size_reset inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm"
                style="margin-right:10px;">
                <span
                    class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-rose-900 text-rose-900"
                    style="background:red; color:white; font-weight:800; font-size:7px;">✕</span>
                Reset
            </button>
        </div>

        <!-- Body -->
        <div class="flex gap-3 p-1">
            <!-- Vertical bar + circles -->
            <div class="w-10 flex items-center justify-center">
                <div
                    id="admin_dashboard_table_content_dropdown_group_size_vbar_outer"
                    class="admin_dashboard_table_content_dropdown_group_size_vbar_outer relative h-56 sm:h-64 w-10 overflow-hidden">
                    <!-- Background rail -->
                    <div
                        id="admin_dashboard_table_content_dropdown_group_size_vbar_rail_bg"
                        class="admin_dashboard_table_content_dropdown_group_size_vbar_rail_bg absolute left-1/2 -translate-x-1/2 top-0 h-full w-2 rounded-full bg-slate-200"></div>

                    <!-- Red range -->
                    <div
                        id="admin_dashboard_table_content_dropdown_group_size_vbar_range"
                        class="admin_dashboard_table_content_dropdown_group_size_vbar_range absolute left-1/2 -translate-x-1/2 w-2 bg-rose-500 rounded-full"
                        style="top: 0px; height: 0px; z-index: 10;"></div>

                    <!-- START CIRCLE -->
                    <div
                        id="admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top"
                        class="admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top admin_dashboard_table_content_dropdown_group_size_no_select absolute left-1/2 -translate-x-1/2 w-6 h-6 rounded-full bg-rose-500 border-2 border-white shadow-lg cursor-grab active:cursor-grabbing touch-none"
                        style="top: -12px; z-index: 30;"
                        role="slider"
                        aria-label="Range start"
                        aria-valuemin="0"
                        aria-valuemax="0"
                        aria-valuenow="0"
                        tabindex="0"></div>

                    <!-- END CIRCLE -->
                    <div
                        id="admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom"
                        class="admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom admin_dashboard_table_content_dropdown_group_size_no_select absolute left-1/2 -translate-x-1/2 w-6 h-6 rounded-full bg-rose-500 border-2 border-white shadow-lg cursor-grab active:cursor-grabbing touch-none"
                        style="top: -12px; z-index: 30;"
                        role="slider"
                        aria-label="Range end"
                        aria-valuemin="0"
                        aria-valuemax="0"
                        aria-valuenow="0"
                        tabindex="0"></div>
                </div>
            </div>

            <!-- List -->
            <div class="flex-1">
                <div class="relative">
                    <div
                        id="admin_dashboard_table_content_dropdown_group_size_list"
                        class="admin_dashboard_table_content_dropdown_group_size_list max-h-56 sm:max-h-64 overflow-auto pr-1"></div>

                    <div class="pointer-events-none absolute inset-y-0 right-0 w-6 bg-gradient-to-l from-white to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* ====== DATA ====== */
    const admin_dashboard_table_content_dropdown_group_size_items = [
        "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"
    ];

    // If you want some values disabled, set index (e.g. 0 disables "1").
    // Otherwise keep -1 for none disabled.
    const admin_dashboard_table_content_dropdown_group_size_disabledUntilIndex = -1;

    /* ====== ELEMENTS ====== */
    const admin_dashboard_table_content_dropdown_group_size_button =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_button");
    const admin_dashboard_table_content_dropdown_group_size_button_label =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_button_label");
    const admin_dashboard_table_content_dropdown_group_size_panel =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_panel");
    const admin_dashboard_table_content_dropdown_group_size_reset =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_reset");
    const admin_dashboard_table_content_dropdown_group_size_list =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_list");

    const admin_dashboard_table_content_dropdown_group_size_vbar_outer =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_vbar_outer");
    const admin_dashboard_table_content_dropdown_group_size_vbar_range =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_vbar_range");

    const admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top");
    const admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom =
        document.getElementById("admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom");

    /* ====== STATE ====== */
    let admin_dashboard_table_content_dropdown_group_size_isOpen = false;

    let admin_dashboard_table_content_dropdown_group_size_rangeStartIndex = 0;
    let admin_dashboard_table_content_dropdown_group_size_rangeEndIndex = 4;

    let admin_dashboard_table_content_dropdown_group_size_draggingThumb = null;
    let admin_dashboard_table_content_dropdown_group_size_vbarRect = null;

    let admin_dashboard_table_content_dropdown_group_size_itemHeightPx = 0;
    let admin_dashboard_table_content_dropdown_group_size_listPaddingTopPx = 0;

    /* ====== HELPERS ====== */
    function admin_dashboard_table_content_dropdown_group_size_clamp(n, min, max) {
        return Math.max(min, Math.min(max, n));
    }

    function admin_dashboard_table_content_dropdown_group_size_setOpen(open) {
        admin_dashboard_table_content_dropdown_group_size_isOpen = open;

        // Tell other dropdowns to close when this opens
        if (open) {
            document.dispatchEvent(
                new CustomEvent("admin_dashboard_table_content_dropdown_any_opened", {
                    detail: {
                        name: "group_size"
                    }
                })
            );
        }

        if (admin_dashboard_table_content_dropdown_group_size_isOpen) {
            admin_dashboard_table_content_dropdown_group_size_panel.classList.remove("hidden");
            admin_dashboard_table_content_dropdown_group_size_button.setAttribute("aria-expanded", "true");

            admin_dashboard_table_content_dropdown_group_size_vbarRect =
                admin_dashboard_table_content_dropdown_group_size_vbar_outer.getBoundingClientRect();

            admin_dashboard_table_content_dropdown_group_size_measureList();
            admin_dashboard_table_content_dropdown_group_size_updateRangeUI(false);
        } else {
            admin_dashboard_table_content_dropdown_group_size_panel.classList.add("hidden");
            admin_dashboard_table_content_dropdown_group_size_button.setAttribute("aria-expanded", "false");
        }
    }

    function admin_dashboard_table_content_dropdown_group_size_renderList() {
        admin_dashboard_table_content_dropdown_group_size_list.innerHTML = "";

        admin_dashboard_table_content_dropdown_group_size_items.forEach((item, index) => {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.id = `admin_dashboard_table_content_dropdown_group_size_item_${index}`;
            btn.className = "admin_dashboard_table_content_dropdown_group_size_item w-full text-left px-1 py-2 rounded-xl transition";

            const isDisabled = index <= admin_dashboard_table_content_dropdown_group_size_disabledUntilIndex;
            btn.innerHTML = `<span style="font-size:14px;" class="admin_dashboard_table_content_dropdown_group_size_item_text block ${isDisabled ? "text-slate-400" : "text-slate-500"}">${item}</span>`;

            if (isDisabled) {
                btn.disabled = true;
                btn.classList.add("cursor-not-allowed");
            } else {
                btn.classList.add("hover:bg-slate-50", "active:bg-slate-100");
                btn.addEventListener("click", () => admin_dashboard_table_content_dropdown_group_size_moveNearestThumbToIndex(index));
            }

            admin_dashboard_table_content_dropdown_group_size_list.appendChild(btn);
        });

        const maxIndex = admin_dashboard_table_content_dropdown_group_size_items.length - 1;
        admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top.setAttribute("aria-valuemax", String(maxIndex));
        admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom.setAttribute("aria-valuemax", String(maxIndex));
    }

    function admin_dashboard_table_content_dropdown_group_size_measureList() {
        const el = document.getElementById("admin_dashboard_table_content_dropdown_group_size_item_0");
        if (!el) return;

        admin_dashboard_table_content_dropdown_group_size_itemHeightPx = el.getBoundingClientRect().height;
        const listCs = window.getComputedStyle(admin_dashboard_table_content_dropdown_group_size_list);
        admin_dashboard_table_content_dropdown_group_size_listPaddingTopPx = parseFloat(listCs.paddingTop || "0") || 0;
    }

    function admin_dashboard_table_content_dropdown_group_size_normalizeRange() {
        const min = 0;
        const max = admin_dashboard_table_content_dropdown_group_size_items.length - 1;

        admin_dashboard_table_content_dropdown_group_size_rangeStartIndex =
            admin_dashboard_table_content_dropdown_group_size_clamp(admin_dashboard_table_content_dropdown_group_size_rangeStartIndex, min, max);
        admin_dashboard_table_content_dropdown_group_size_rangeEndIndex =
            admin_dashboard_table_content_dropdown_group_size_clamp(admin_dashboard_table_content_dropdown_group_size_rangeEndIndex, min, max);

        if (admin_dashboard_table_content_dropdown_group_size_rangeStartIndex > admin_dashboard_table_content_dropdown_group_size_rangeEndIndex) {
            const tmp = admin_dashboard_table_content_dropdown_group_size_rangeStartIndex;
            admin_dashboard_table_content_dropdown_group_size_rangeStartIndex = admin_dashboard_table_content_dropdown_group_size_rangeEndIndex;
            admin_dashboard_table_content_dropdown_group_size_rangeEndIndex = tmp;
        }
    }

    function admin_dashboard_table_content_dropdown_group_size_updateListColorsByRange() {
        const nodes = admin_dashboard_table_content_dropdown_group_size_list.querySelectorAll(".admin_dashboard_table_content_dropdown_group_size_item");
        nodes.forEach((node, i) => {
            const textSpan = node.querySelector(".admin_dashboard_table_content_dropdown_group_size_item_text");
            if (!textSpan) return;

            const inRange = i >= admin_dashboard_table_content_dropdown_group_size_rangeStartIndex && i <= admin_dashboard_table_content_dropdown_group_size_rangeEndIndex;
            const isDisabled = i <= admin_dashboard_table_content_dropdown_group_size_disabledUntilIndex;

            textSpan.classList.remove("text-black", "text-slate-500", "text-slate-400");
            if (inRange) textSpan.classList.add("text-black");
            else textSpan.classList.add(isDisabled ? "text-slate-400" : "text-slate-500");
        });
    }

    function admin_dashboard_table_content_dropdown_group_size_indexToListPixel(index) {
        return admin_dashboard_table_content_dropdown_group_size_listPaddingTopPx + (index * admin_dashboard_table_content_dropdown_group_size_itemHeightPx);
    }

    function admin_dashboard_table_content_dropdown_group_size_listPixelToIndex(listPixel) {
        const approx = Math.round((listPixel - admin_dashboard_table_content_dropdown_group_size_listPaddingTopPx) / admin_dashboard_table_content_dropdown_group_size_itemHeightPx);
        return admin_dashboard_table_content_dropdown_group_size_clamp(approx, 0, admin_dashboard_table_content_dropdown_group_size_items.length - 1);
    }

    // Red bar start/end INSIDE circles (radius 12px)
    function admin_dashboard_table_content_dropdown_group_size_updateRangeUI(shouldScrollIntoView) {
        admin_dashboard_table_content_dropdown_group_size_normalizeRange();
        admin_dashboard_table_content_dropdown_group_size_updateListColorsByRange();

        if (!admin_dashboard_table_content_dropdown_group_size_itemHeightPx) {
            admin_dashboard_table_content_dropdown_group_size_measureList();
        }

        const scrollTop = admin_dashboard_table_content_dropdown_group_size_list.scrollTop;

        const startTopPxInList = admin_dashboard_table_content_dropdown_group_size_indexToListPixel(admin_dashboard_table_content_dropdown_group_size_rangeStartIndex);
        const endTopPxInList = admin_dashboard_table_content_dropdown_group_size_indexToListPixel(admin_dashboard_table_content_dropdown_group_size_rangeEndIndex);

        const startTopPx = startTopPxInList - scrollTop;
        const endTopPx = endTopPxInList - scrollTop;

        const thumbCenterOffset = admin_dashboard_table_content_dropdown_group_size_itemHeightPx / 2;
        const topCenter = startTopPx + thumbCenterOffset;
        const bottomCenter = endTopPx + thumbCenterOffset;

        const barH = admin_dashboard_table_content_dropdown_group_size_vbar_outer.clientHeight;

        const minThumbTop = 0;
        const maxThumbTop = Math.max(0, barH - 24);

        const topThumbTop = admin_dashboard_table_content_dropdown_group_size_clamp(topCenter - 12, minThumbTop, maxThumbTop);
        const bottomThumbTop = admin_dashboard_table_content_dropdown_group_size_clamp(bottomCenter - 12, minThumbTop, maxThumbTop);

        admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top.style.top = `${topThumbTop}px`;
        admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom.style.top = `${bottomThumbTop}px`;

        const barTop = admin_dashboard_table_content_dropdown_group_size_clamp(topThumbTop + 12, 0, barH);
        const barBottom = admin_dashboard_table_content_dropdown_group_size_clamp(bottomThumbTop + 12, 0, barH);

        const finalTop = Math.min(barTop, barBottom);
        const finalBottom = Math.max(barTop, barBottom);

        admin_dashboard_table_content_dropdown_group_size_vbar_range.style.top = `${finalTop}px`;
        admin_dashboard_table_content_dropdown_group_size_vbar_range.style.height = `${Math.max(0, finalBottom - finalTop)}px`;

        admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top.setAttribute("aria-valuenow", String(admin_dashboard_table_content_dropdown_group_size_rangeStartIndex));
        admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom.setAttribute("aria-valuenow", String(admin_dashboard_table_content_dropdown_group_size_rangeEndIndex));

        if (shouldScrollIntoView) {
            const startEl = document.getElementById(`admin_dashboard_table_content_dropdown_group_size_item_${admin_dashboard_table_content_dropdown_group_size_rangeStartIndex}`);
            const endEl = document.getElementById(`admin_dashboard_table_content_dropdown_group_size_item_${admin_dashboard_table_content_dropdown_group_size_rangeEndIndex}`);
            if (startEl) startEl.scrollIntoView({
                block: "nearest"
            });
            if (endEl) endEl.scrollIntoView({
                block: "nearest"
            });
        }
    }

    function admin_dashboard_table_content_dropdown_group_size_moveNearestThumbToIndex(index) {
        const clamped = admin_dashboard_table_content_dropdown_group_size_clamp(index, 0, admin_dashboard_table_content_dropdown_group_size_items.length - 1);

        const distToStart = Math.abs(clamped - admin_dashboard_table_content_dropdown_group_size_rangeStartIndex);
        const distToEnd = Math.abs(clamped - admin_dashboard_table_content_dropdown_group_size_rangeEndIndex);

        if (distToStart <= distToEnd) admin_dashboard_table_content_dropdown_group_size_rangeStartIndex = clamped;
        else admin_dashboard_table_content_dropdown_group_size_rangeEndIndex = clamped;

        admin_dashboard_table_content_dropdown_group_size_updateRangeUI(true);
    }

    /* ====== DRAGGING ====== */
    function admin_dashboard_table_content_dropdown_group_size_startDrag(whichThumb, e) {
        admin_dashboard_table_content_dropdown_group_size_draggingThumb = whichThumb;
        admin_dashboard_table_content_dropdown_group_size_vbarRect = admin_dashboard_table_content_dropdown_group_size_vbar_outer.getBoundingClientRect();
        admin_dashboard_table_content_dropdown_group_size_measureList();

        const thumbEl = whichThumb === "top" ?
            admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top :
            admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom;

        thumbEl.setPointerCapture(e.pointerId);
        admin_dashboard_table_content_dropdown_group_size_dragFromClientY(whichThumb, e.clientY);
    }

    function admin_dashboard_table_content_dropdown_group_size_dragFromClientY(whichThumb, clientY) {
        const yInVbar = admin_dashboard_table_content_dropdown_group_size_clamp(
            clientY - admin_dashboard_table_content_dropdown_group_size_vbarRect.top,
            0,
            admin_dashboard_table_content_dropdown_group_size_vbarRect.height
        );

        const listPixel = yInVbar + admin_dashboard_table_content_dropdown_group_size_list.scrollTop;
        const idx = admin_dashboard_table_content_dropdown_group_size_listPixelToIndex(listPixel);

        if (whichThumb === "top") admin_dashboard_table_content_dropdown_group_size_rangeStartIndex = idx;
        else admin_dashboard_table_content_dropdown_group_size_rangeEndIndex = idx;

        admin_dashboard_table_content_dropdown_group_size_updateRangeUI(false);
    }

    function admin_dashboard_table_content_dropdown_group_size_onDragMove(e) {
        if (!admin_dashboard_table_content_dropdown_group_size_draggingThumb) return;
        admin_dashboard_table_content_dropdown_group_size_dragFromClientY(admin_dashboard_table_content_dropdown_group_size_draggingThumb, e.clientY);
    }

    function admin_dashboard_table_content_dropdown_group_size_endDrag(e) {
        if (!admin_dashboard_table_content_dropdown_group_size_draggingThumb) return;

        const thumbEl = admin_dashboard_table_content_dropdown_group_size_draggingThumb === "top" ?
            admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top :
            admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom;

        try {
            thumbEl.releasePointerCapture(e.pointerId);
        } catch (_) {}
        admin_dashboard_table_content_dropdown_group_size_draggingThumb = null;
    }

    /* ====== RESET ====== */
    function admin_dashboard_table_content_dropdown_group_size_resetAll() {
        admin_dashboard_table_content_dropdown_group_size_button_label.textContent = "Group Size";
        admin_dashboard_table_content_dropdown_group_size_rangeStartIndex = 0;
        admin_dashboard_table_content_dropdown_group_size_rangeEndIndex = 4;
        admin_dashboard_table_content_dropdown_group_size_list.scrollTop = 0;
        admin_dashboard_table_content_dropdown_group_size_updateRangeUI(false);
    }

    /* ====== EVENTS ====== */
    admin_dashboard_table_content_dropdown_group_size_button.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_group_size_setOpen(!admin_dashboard_table_content_dropdown_group_size_isOpen);
    });

    admin_dashboard_table_content_dropdown_group_size_reset.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_group_size_resetAll();
    });

    // Close GROUP SIZE if any other dropdown opens
    document.addEventListener("admin_dashboard_table_content_dropdown_any_opened", (e) => {
        if (e.detail && e.detail.name !== "group_size") {
            admin_dashboard_table_content_dropdown_group_size_setOpen(false);
        }
    });

    document.addEventListener("click", (e) => {
        if (!admin_dashboard_table_content_dropdown_group_size_isOpen) return;
        const target = e.target;
        const clickedInside =
            admin_dashboard_table_content_dropdown_group_size_panel.contains(target) ||
            admin_dashboard_table_content_dropdown_group_size_button.contains(target);
        if (!clickedInside) admin_dashboard_table_content_dropdown_group_size_setOpen(false);
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            admin_dashboard_table_content_dropdown_group_size_setOpen(false);
            admin_dashboard_table_content_dropdown_group_size_button.focus();
        }
    });

    // Drag circles
    admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top.addEventListener("pointerdown", (e) => admin_dashboard_table_content_dropdown_group_size_startDrag("top", e));
    admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom.addEventListener("pointerdown", (e) => admin_dashboard_table_content_dropdown_group_size_startDrag("bottom", e));

    admin_dashboard_table_content_dropdown_group_size_vbar_outer.addEventListener("pointermove", admin_dashboard_table_content_dropdown_group_size_onDragMove);
    admin_dashboard_table_content_dropdown_group_size_vbar_outer.addEventListener("pointerup", admin_dashboard_table_content_dropdown_group_size_endDrag);
    admin_dashboard_table_content_dropdown_group_size_vbar_outer.addEventListener("pointercancel", admin_dashboard_table_content_dropdown_group_size_endDrag);

    // Click on bar area to move nearest circle
    admin_dashboard_table_content_dropdown_group_size_vbar_outer.addEventListener("pointerdown", (e) => {
        if (e.target === admin_dashboard_table_content_dropdown_group_size_vbar_thumb_top || e.target === admin_dashboard_table_content_dropdown_group_size_vbar_thumb_bottom) return;

        admin_dashboard_table_content_dropdown_group_size_vbarRect = admin_dashboard_table_content_dropdown_group_size_vbar_outer.getBoundingClientRect();
        admin_dashboard_table_content_dropdown_group_size_measureList();

        const yInVbar = admin_dashboard_table_content_dropdown_group_size_clamp(
            e.clientY - admin_dashboard_table_content_dropdown_group_size_vbarRect.top,
            0,
            admin_dashboard_table_content_dropdown_group_size_vbarRect.height
        );

        const listPixel = yInVbar + admin_dashboard_table_content_dropdown_group_size_list.scrollTop;
        const idx = admin_dashboard_table_content_dropdown_group_size_listPixelToIndex(listPixel);
        admin_dashboard_table_content_dropdown_group_size_moveNearestThumbToIndex(idx);
    });

    admin_dashboard_table_content_dropdown_group_size_list.addEventListener("scroll", () => {
        admin_dashboard_table_content_dropdown_group_size_updateRangeUI(false);
    }, {
        passive: true
    });

    window.addEventListener("resize", () => {
        admin_dashboard_table_content_dropdown_group_size_vbarRect = admin_dashboard_table_content_dropdown_group_size_vbar_outer.getBoundingClientRect();
        admin_dashboard_table_content_dropdown_group_size_measureList();
        admin_dashboard_table_content_dropdown_group_size_updateRangeUI(false);
    });

    document.addEventListener("admin_dashboard_table_content_dropdown_reset_all", () => {
        admin_dashboard_table_content_dropdown_group_size_resetAll();
    });

    /* ====== INIT ====== */
    admin_dashboard_table_content_dropdown_group_size_renderList();
    admin_dashboard_table_content_dropdown_group_size_resetAll();
</script>