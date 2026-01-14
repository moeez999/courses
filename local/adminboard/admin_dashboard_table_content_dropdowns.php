<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- ONLY TOPIC DROPDOWN -->
<div class="relative inline-block" style="margin-bottom: 15px;">
    <!-- Trigger -->
     
    <button
        id="admin_dashboard_table_content_dropdown_topic_button"
        type="button"
        class="admin_dashboard_table_content_dropdown_topic_button inline-flex items-center justify-between gap-3 w-35 px-2 py-2 rounded-md bg-white border border-slate-200 shadow-sm hover:bg-slate-50 active:bg-slate-100 transition"
        aria-haspopup="dialog"
        aria-expanded="false" style="height:50px;">
        <span id="admin_dashboard_table_content_dropdown_topic_button_label" class="text-slate-900 font-medium">
            Topic
        </span>

        <svg class="w-5 h-5 text-slate-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Panel -->
    <div
        id="admin_dashboard_table_content_dropdown_topic_panel"
        class="admin_dashboard_table_content_dropdown_topic_panel hidden absolute z-50 mt-2 w-[220px] sm:w-[260px] rounded-md bg-white border border-slate-200 shadow-xl"
        role="dialog"
        aria-modal="false">
        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 border-b border-slate-100">
            <span class="text-slate-900 font-semibold text-md">Range Of Topic</span>

            <button
                id="admin_dashboard_table_content_dropdown_topic_reset"
                type="button"
                class="admin_dashboard_table_content_dropdown_topic_reset inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm" style=" margin-right:10px;">
                <span class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-rose-900 text-rose-900"
                    style="background:red; color:white; font-weight:800; font-size:7px;">✕</span>
                Reset
            </button>

        </div>

        <!-- Body -->
        <div class="flex gap-3 p-1">
            <!-- Vertical bar + circles -->
            <div class="w-10 flex items-center justify-center">
                <!-- OUTER: circles visible, but everything stays inside (no overflow bug) -->
                <div
                    id="admin_dashboard_table_content_dropdown_topic_vbar_outer"
                    class="admin_dashboard_table_content_dropdown_topic_vbar_outer relative h-56 sm:h-64 w-10 overflow-hidden">
                    <!-- Background rail -->
                    <div
                        id="admin_dashboard_table_content_dropdown_topic_vbar_rail_bg"
                        class="admin_dashboard_table_content_dropdown_topic_vbar_rail_bg absolute left-1/2 -translate-x-1/2 top-0 h-full w-2 rounded-full bg-slate-200"></div>

                    <!-- Red range (NOTE: z-index LOWER than circles so line hides under circles) -->
                    <div
                        id="admin_dashboard_table_content_dropdown_topic_vbar_range"
                        class="admin_dashboard_table_content_dropdown_topic_vbar_range absolute left-1/2 -translate-x-1/2 w-2 bg-rose-500 rounded-full"
                        style="top: 0px; height: 0px; z-index: 10;"></div>

                    <!-- START CIRCLE (z-index higher, so bar start is hidden under circle) -->
                    <div
                        id="admin_dashboard_table_content_dropdown_topic_vbar_thumb_top"
                        class="admin_dashboard_table_content_dropdown_topic_vbar_thumb_top admin_dashboard_table_content_dropdown_topic_no_select absolute left-1/2 -translate-x-1/2 w-6 h-6 rounded-full bg-rose-500 border-2 border-white shadow-lg cursor-grab active:cursor-grabbing touch-none"
                        style="top: -12px; z-index: 30;"
                        role="slider"
                        aria-label="Range start"
                        aria-valuemin="0"
                        aria-valuemax="0"
                        aria-valuenow="0"
                        tabindex="0"></div>

                    <!-- END CIRCLE -->
                    <div
                        id="admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom"
                        class="admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom admin_dashboard_table_content_dropdown_topic_no_select absolute left-1/2 -translate-x-1/2 w-6 h-6 rounded-full bg-rose-500 border-2 border-white shadow-lg cursor-grab active:cursor-grabbing touch-none"
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
                        id="admin_dashboard_table_content_dropdown_topic_list"
                        class="admin_dashboard_table_content_dropdown_topic_list max-h-56 sm:max-h-64 overflow-auto pr-1"></div>

                    <div class="pointer-events-none absolute inset-y-0 right-0 w-6 bg-gradient-to-l from-white to-transparent"></div>
                </div>
            </div>
        </div>
    </div>

    <?php include "admin_dashboard_table_content_dropdown_time.php"; ?>
    <?php include "admin_dashboard_table_content_dropdown_group_size.php"; ?>
    <?php include "admin_dashboard_table_content_dropdown_attending.php"; ?>
    <?php include "admin_dashboard_table_content_dropdown_teacher.php"; ?>
    <?php include "admin_dashboard_table_content_dropdown_cohort.php"; ?>

    <?php include "admin_dashboard_table_content_dropdown_monthly_rentention.php"; ?>

    <?php include "admin_dashboard_table_content_dropdown_reset_all.php"; ?>


</div>
<script>
    /* ====== DATA ====== */
    const admin_dashboard_table_content_dropdown_topic_items = [
        "Alphabet",
        "Number",
        "Self Introduction",
        "Verb Be",
        "Demonstratives",
        "Present Continuous",
        "Possessive Adjectives",
        "Articles",
        "Plural Nouns",
        "Wh- Questions",
        "Simple Present",
        "Adverbs of Frequency",
        "There is / There are",
        "Prepositions of Place",
        "Imperatives",
        "Can / Can't",
        "Past Simple",
        "Future (Going to)",
    ];

    const admin_dashboard_table_content_dropdown_topic_disabledUntilIndex = 1;

    /* ====== ELEMENTS ====== */
    const admin_dashboard_table_content_dropdown_topic_button =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_button");
    const admin_dashboard_table_content_dropdown_topic_button_label =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_button_label");
    const admin_dashboard_table_content_dropdown_topic_panel =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_panel");
    const admin_dashboard_table_content_dropdown_topic_reset =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_reset");
    const admin_dashboard_table_content_dropdown_topic_list =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_list");

    const admin_dashboard_table_content_dropdown_topic_vbar_outer =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_vbar_outer");
    const admin_dashboard_table_content_dropdown_topic_vbar_range =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_vbar_range");

    const admin_dashboard_table_content_dropdown_topic_vbar_thumb_top =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_vbar_thumb_top");
    const admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom =
        document.getElementById("admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom");

    /* ====== STATE ====== */
    let admin_dashboard_table_content_dropdown_topic_isOpen = false;

    let admin_dashboard_table_content_dropdown_topic_rangeStartIndex = 0;
    let admin_dashboard_table_content_dropdown_topic_rangeEndIndex = 2;

    let admin_dashboard_table_content_dropdown_topic_draggingThumb = null;
    let admin_dashboard_table_content_dropdown_topic_vbarRect = null;

    let admin_dashboard_table_content_dropdown_topic_itemHeightPx = 0;
    let admin_dashboard_table_content_dropdown_topic_listPaddingTopPx = 0;

    /* ====== HELPERS ====== */
    function admin_dashboard_table_content_dropdown_topic_clamp(n, min, max) {
        return Math.max(min, Math.min(max, n));
    }

    function admin_dashboard_table_content_dropdown_topic_setOpen(open) {
        admin_dashboard_table_content_dropdown_topic_isOpen = open;

        if (open) {
            document.dispatchEvent(
                new CustomEvent("admin_dashboard_table_content_dropdown_any_opened", {
                    detail: {
                        name: "topic"
                    }
                })
            );
        }


        if (admin_dashboard_table_content_dropdown_topic_isOpen) {
            admin_dashboard_table_content_dropdown_topic_panel.classList.remove("hidden");
            admin_dashboard_table_content_dropdown_topic_button.setAttribute("aria-expanded", "true");

            admin_dashboard_table_content_dropdown_topic_vbarRect =
                admin_dashboard_table_content_dropdown_topic_vbar_outer.getBoundingClientRect();

            admin_dashboard_table_content_dropdown_topic_measureList();
            admin_dashboard_table_content_dropdown_topic_updateRangeUI(false);
        } else {
            admin_dashboard_table_content_dropdown_topic_panel.classList.add("hidden");
            admin_dashboard_table_content_dropdown_topic_button.setAttribute("aria-expanded", "false");
        }
    }

    function admin_dashboard_table_content_dropdown_topic_renderList() {
        admin_dashboard_table_content_dropdown_topic_list.innerHTML = "";

        admin_dashboard_table_content_dropdown_topic_items.forEach((item, index) => {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.id = `admin_dashboard_table_content_dropdown_topic_item_${index}`;
            btn.className = "admin_dashboard_table_content_dropdown_topic_item w-full text-left px-1 py-2 rounded-xl transition";

            const isDisabled = index <= admin_dashboard_table_content_dropdown_topic_disabledUntilIndex;
            btn.innerHTML = `<span style='font-size:14px;' class="admin_dashboard_table_content_dropdown_topic_item_text  block ${isDisabled ? "text-slate-400" : "text-slate-500"}">${item}</span>`;

            if (isDisabled) {
                btn.disabled = true;
                btn.classList.add("cursor-not-allowed");
            } else {
                btn.classList.add("hover:bg-slate-50", "active:bg-slate-100");
                btn.addEventListener("click", () => admin_dashboard_table_content_dropdown_topic_moveNearestThumbToIndex(index));
            }

            admin_dashboard_table_content_dropdown_topic_list.appendChild(btn);
        });

        const maxIndex = admin_dashboard_table_content_dropdown_topic_items.length - 1;
        admin_dashboard_table_content_dropdown_topic_vbar_thumb_top.setAttribute("aria-valuemax", String(maxIndex));
        admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom.setAttribute("aria-valuemax", String(maxIndex));
    }

    function admin_dashboard_table_content_dropdown_topic_measureList() {
        const el = document.getElementById("admin_dashboard_table_content_dropdown_topic_item_0");
        if (!el) return;

        admin_dashboard_table_content_dropdown_topic_itemHeightPx = el.getBoundingClientRect().height;
        const listCs = window.getComputedStyle(admin_dashboard_table_content_dropdown_topic_list);
        admin_dashboard_table_content_dropdown_topic_listPaddingTopPx = parseFloat(listCs.paddingTop || "0") || 0;
    }

    function admin_dashboard_table_content_dropdown_topic_normalizeRange() {
        const min = 0;
        const max = admin_dashboard_table_content_dropdown_topic_items.length - 1;

        admin_dashboard_table_content_dropdown_topic_rangeStartIndex =
            admin_dashboard_table_content_dropdown_topic_clamp(admin_dashboard_table_content_dropdown_topic_rangeStartIndex, min, max);
        admin_dashboard_table_content_dropdown_topic_rangeEndIndex =
            admin_dashboard_table_content_dropdown_topic_clamp(admin_dashboard_table_content_dropdown_topic_rangeEndIndex, min, max);

        if (admin_dashboard_table_content_dropdown_topic_rangeStartIndex > admin_dashboard_table_content_dropdown_topic_rangeEndIndex) {
            const tmp = admin_dashboard_table_content_dropdown_topic_rangeStartIndex;
            admin_dashboard_table_content_dropdown_topic_rangeStartIndex = admin_dashboard_table_content_dropdown_topic_rangeEndIndex;
            admin_dashboard_table_content_dropdown_topic_rangeEndIndex = tmp;
        }
    }

    function admin_dashboard_table_content_dropdown_topic_updateListColorsByRange() {
        const nodes = admin_dashboard_table_content_dropdown_topic_list.querySelectorAll(".admin_dashboard_table_content_dropdown_topic_item");
        nodes.forEach((node, i) => {
            const textSpan = node.querySelector(".admin_dashboard_table_content_dropdown_topic_item_text");
            if (!textSpan) return;

            const inRange = i >= admin_dashboard_table_content_dropdown_topic_rangeStartIndex && i <= admin_dashboard_table_content_dropdown_topic_rangeEndIndex;
            const isDisabled = i <= admin_dashboard_table_content_dropdown_topic_disabledUntilIndex;

            textSpan.classList.remove("text-black", "text-slate-500", "text-slate-400");
            if (inRange) textSpan.classList.add("text-black");
            else textSpan.classList.add(isDisabled ? "text-slate-400" : "text-slate-500");
        });
    }

    function admin_dashboard_table_content_dropdown_topic_indexToListPixel(index) {
        return admin_dashboard_table_content_dropdown_topic_listPaddingTopPx + (index * admin_dashboard_table_content_dropdown_topic_itemHeightPx);
    }

    function admin_dashboard_table_content_dropdown_topic_listPixelToIndex(listPixel) {
        const approx = Math.round((listPixel - admin_dashboard_table_content_dropdown_topic_listPaddingTopPx) / admin_dashboard_table_content_dropdown_topic_itemHeightPx);
        return admin_dashboard_table_content_dropdown_topic_clamp(approx, 0, admin_dashboard_table_content_dropdown_topic_items.length - 1);
    }

    // ===== Key change: make red bar start/end INSIDE the circles =====
    // Circle radius = 12px. So bar top = topCircleTop + 12, bar bottom = bottomCircleTop + 12.
    // That way the line is hidden under circles exactly like your snapshot.
    function admin_dashboard_table_content_dropdown_topic_updateRangeUI(shouldScrollIntoView) {
        admin_dashboard_table_content_dropdown_topic_normalizeRange();
        admin_dashboard_table_content_dropdown_topic_updateListColorsByRange();

        if (!admin_dashboard_table_content_dropdown_topic_itemHeightPx) {
            admin_dashboard_table_content_dropdown_topic_measureList();
        }

        const scrollTop = admin_dashboard_table_content_dropdown_topic_list.scrollTop;

        const startTopPxInList = admin_dashboard_table_content_dropdown_topic_indexToListPixel(admin_dashboard_table_content_dropdown_topic_rangeStartIndex);
        const endTopPxInList = admin_dashboard_table_content_dropdown_topic_indexToListPixel(admin_dashboard_table_content_dropdown_topic_rangeEndIndex);

        // visible item tops
        const startTopPx = startTopPxInList - scrollTop;
        const endTopPx = endTopPxInList - scrollTop;

        const thumbCenterOffset = admin_dashboard_table_content_dropdown_topic_itemHeightPx / 2;
        const topCenter = startTopPx + thumbCenterOffset;
        const bottomCenter = endTopPx + thumbCenterOffset;

        const barH = admin_dashboard_table_content_dropdown_topic_vbar_outer.clientHeight;

        // thumb top styles (center - 12)
        const minThumbTop = 0;
        const maxThumbTop = Math.max(0, barH - 24);

        const topThumbTop = admin_dashboard_table_content_dropdown_topic_clamp(topCenter - 12, minThumbTop, maxThumbTop);
        const bottomThumbTop = admin_dashboard_table_content_dropdown_topic_clamp(bottomCenter - 12, minThumbTop, maxThumbTop);

        // place circles
        admin_dashboard_table_content_dropdown_topic_vbar_thumb_top.style.top = `${topThumbTop}px`;
        admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom.style.top = `${bottomThumbTop}px`;

        // Bar should start/end under circles:
        // start at (topThumbTop + 12), end at (bottomThumbTop + 12)
        const barTop = admin_dashboard_table_content_dropdown_topic_clamp(topThumbTop + 12, 0, barH);
        const barBottom = admin_dashboard_table_content_dropdown_topic_clamp(bottomThumbTop + 12, 0, barH);

        const finalTop = Math.min(barTop, barBottom);
        const finalBottom = Math.max(barTop, barBottom);

        admin_dashboard_table_content_dropdown_topic_vbar_range.style.top = `${finalTop}px`;
        admin_dashboard_table_content_dropdown_topic_vbar_range.style.height = `${Math.max(0, finalBottom - finalTop)}px`;

        admin_dashboard_table_content_dropdown_topic_vbar_thumb_top.setAttribute("aria-valuenow", String(admin_dashboard_table_content_dropdown_topic_rangeStartIndex));
        admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom.setAttribute("aria-valuenow", String(admin_dashboard_table_content_dropdown_topic_rangeEndIndex));

        if (shouldScrollIntoView) {
            const startEl = document.getElementById(`admin_dashboard_table_content_dropdown_topic_item_${admin_dashboard_table_content_dropdown_topic_rangeStartIndex}`);
            const endEl = document.getElementById(`admin_dashboard_table_content_dropdown_topic_item_${admin_dashboard_table_content_dropdown_topic_rangeEndIndex}`);
            if (startEl) startEl.scrollIntoView({
                block: "nearest"
            });
            if (endEl) endEl.scrollIntoView({
                block: "nearest"
            });
        }
    }

    function admin_dashboard_table_content_dropdown_topic_moveNearestThumbToIndex(index) {
        const clamped = admin_dashboard_table_content_dropdown_topic_clamp(index, 0, admin_dashboard_table_content_dropdown_topic_items.length - 1);

        const distToStart = Math.abs(clamped - admin_dashboard_table_content_dropdown_topic_rangeStartIndex);
        const distToEnd = Math.abs(clamped - admin_dashboard_table_content_dropdown_topic_rangeEndIndex);

        if (distToStart <= distToEnd) admin_dashboard_table_content_dropdown_topic_rangeStartIndex = clamped;
        else admin_dashboard_table_content_dropdown_topic_rangeEndIndex = clamped;

        admin_dashboard_table_content_dropdown_topic_updateRangeUI(true);
    }

    /* ====== DRAGGING ====== */
    function admin_dashboard_table_content_dropdown_topic_startDrag(whichThumb, e) {
        admin_dashboard_table_content_dropdown_topic_draggingThumb = whichThumb;
        admin_dashboard_table_content_dropdown_topic_vbarRect = admin_dashboard_table_content_dropdown_topic_vbar_outer.getBoundingClientRect();
        admin_dashboard_table_content_dropdown_topic_measureList();

        const thumbEl = whichThumb === "top" ?
            admin_dashboard_table_content_dropdown_topic_vbar_thumb_top :
            admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom;

        thumbEl.setPointerCapture(e.pointerId);
        admin_dashboard_table_content_dropdown_topic_dragFromClientY(whichThumb, e.clientY);
    }

    function admin_dashboard_table_content_dropdown_topic_dragFromClientY(whichThumb, clientY) {
        const yInVbar = admin_dashboard_table_content_dropdown_topic_clamp(
            clientY - admin_dashboard_table_content_dropdown_topic_vbarRect.top,
            0,
            admin_dashboard_table_content_dropdown_topic_vbarRect.height
        );

        const listPixel = yInVbar + admin_dashboard_table_content_dropdown_topic_list.scrollTop;
        const idx = admin_dashboard_table_content_dropdown_topic_listPixelToIndex(listPixel);

        if (whichThumb === "top") admin_dashboard_table_content_dropdown_topic_rangeStartIndex = idx;
        else admin_dashboard_table_content_dropdown_topic_rangeEndIndex = idx;

        admin_dashboard_table_content_dropdown_topic_updateRangeUI(false);
    }

    function admin_dashboard_table_content_dropdown_topic_onDragMove(e) {
        if (!admin_dashboard_table_content_dropdown_topic_draggingThumb) return;
        admin_dashboard_table_content_dropdown_topic_dragFromClientY(admin_dashboard_table_content_dropdown_topic_draggingThumb, e.clientY);
    }

    function admin_dashboard_table_content_dropdown_topic_endDrag(e) {
        if (!admin_dashboard_table_content_dropdown_topic_draggingThumb) return;

        const thumbEl = admin_dashboard_table_content_dropdown_topic_draggingThumb === "top" ?
            admin_dashboard_table_content_dropdown_topic_vbar_thumb_top :
            admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom;

        try {
            thumbEl.releasePointerCapture(e.pointerId);
        } catch (_) {}
        admin_dashboard_table_content_dropdown_topic_draggingThumb = null;
    }

    /* ====== RESET ====== */
    function admin_dashboard_table_content_dropdown_topic_resetAll() {
        admin_dashboard_table_content_dropdown_topic_button_label.textContent = "Topic";
        admin_dashboard_table_content_dropdown_topic_rangeStartIndex = 0;
        admin_dashboard_table_content_dropdown_topic_rangeEndIndex = 2;
        admin_dashboard_table_content_dropdown_topic_list.scrollTop = 0;
        admin_dashboard_table_content_dropdown_topic_updateRangeUI(false);
    }

    /* ====== EVENTS ====== */
    admin_dashboard_table_content_dropdown_topic_button.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_topic_setOpen(!admin_dashboard_table_content_dropdown_topic_isOpen);
    });

    admin_dashboard_table_content_dropdown_topic_reset.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_topic_resetAll();
    });

    document.addEventListener("click", (e) => {
        if (!admin_dashboard_table_content_dropdown_topic_isOpen) return;
        const target = e.target;
        const clickedInside =
            admin_dashboard_table_content_dropdown_topic_panel.contains(target) ||
            admin_dashboard_table_content_dropdown_topic_button.contains(target);
        if (!clickedInside) admin_dashboard_table_content_dropdown_topic_setOpen(false);
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            admin_dashboard_table_content_dropdown_topic_setOpen(false);
            admin_dashboard_table_content_dropdown_topic_button.focus();
        }
    });

    // Drag circles
    admin_dashboard_table_content_dropdown_topic_vbar_thumb_top.addEventListener("pointerdown", (e) => admin_dashboard_table_content_dropdown_topic_startDrag("top", e));
    admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom.addEventListener("pointerdown", (e) => admin_dashboard_table_content_dropdown_topic_startDrag("bottom", e));

    admin_dashboard_table_content_dropdown_topic_vbar_outer.addEventListener("pointermove", admin_dashboard_table_content_dropdown_topic_onDragMove);
    admin_dashboard_table_content_dropdown_topic_vbar_outer.addEventListener("pointerup", admin_dashboard_table_content_dropdown_topic_endDrag);
    admin_dashboard_table_content_dropdown_topic_vbar_outer.addEventListener("pointercancel", admin_dashboard_table_content_dropdown_topic_endDrag);

    // Click on bar area to move nearest circle
    admin_dashboard_table_content_dropdown_topic_vbar_outer.addEventListener("pointerdown", (e) => {
        if (e.target === admin_dashboard_table_content_dropdown_topic_vbar_thumb_top || e.target === admin_dashboard_table_content_dropdown_topic_vbar_thumb_bottom) return;

        admin_dashboard_table_content_dropdown_topic_vbarRect = admin_dashboard_table_content_dropdown_topic_vbar_outer.getBoundingClientRect();
        admin_dashboard_table_content_dropdown_topic_measureList();

        const yInVbar = admin_dashboard_table_content_dropdown_topic_clamp(
            e.clientY - admin_dashboard_table_content_dropdown_topic_vbarRect.top,
            0,
            admin_dashboard_table_content_dropdown_topic_vbarRect.height
        );

        const listPixel = yInVbar + admin_dashboard_table_content_dropdown_topic_list.scrollTop;
        const idx = admin_dashboard_table_content_dropdown_topic_listPixelToIndex(listPixel);
        admin_dashboard_table_content_dropdown_topic_moveNearestThumbToIndex(idx);
    });

    admin_dashboard_table_content_dropdown_topic_list.addEventListener("scroll", () => {
        admin_dashboard_table_content_dropdown_topic_updateRangeUI(false);
    }, {
        passive: true
    });

    window.addEventListener("resize", () => {
        admin_dashboard_table_content_dropdown_topic_vbarRect = admin_dashboard_table_content_dropdown_topic_vbar_outer.getBoundingClientRect();
        admin_dashboard_table_content_dropdown_topic_measureList();
        admin_dashboard_table_content_dropdown_topic_updateRangeUI(false);
    });


    // Close TOPIC when another dropdown opens
    document.addEventListener("admin_dashboard_table_content_dropdown_any_opened", (e) => {
        if (e.detail && e.detail.name !== "topic") {
            admin_dashboard_table_content_dropdown_topic_setOpen(false);
        }
    });

    document.addEventListener("admin_dashboard_table_content_dropdown_reset_all", () => {
        admin_dashboard_table_content_dropdown_topic_resetAll();
    });


    /* ====== INIT ====== */
    admin_dashboard_table_content_dropdown_topic_renderList();
    admin_dashboard_table_content_dropdown_topic_resetAll();
</script>