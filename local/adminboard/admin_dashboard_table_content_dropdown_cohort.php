<?php
// admin_dashboard_table_content_dropdown_cohort.php
?>

<!-- COHORT DROPDOWN (Multi-select + Search like Teacher) -->
<div class="relative inline-block">
    <!-- Trigger -->
    <button
        id="admin_dashboard_table_content_dropdown_cohort_button"
        type="button"
        class="admin_dashboard_table_content_dropdown_cohort_button ml-3 inline-flex items-center justify-between gap-3 w-35 px-2 py-2 rounded-md bg-white border border-slate-200 shadow-sm hover:bg-slate-50 active:bg-slate-100 transition"
        aria-haspopup="dialog"
        aria-expanded="false"
        style="height:50px;">
        <span id="admin_dashboard_table_content_dropdown_cohort_button_label" class="text-slate-900 font-medium">
            Cohort
        </span>

        <svg class="w-5 h-5 text-slate-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Panel -->
    <div
        id="admin_dashboard_table_content_dropdown_cohort_panel"
        class="admin_dashboard_table_content_dropdown_cohort_panel hidden absolute z-50 mt-2 w-[360px] rounded-xl bg-white border border-slate-200 shadow-xl"
        role="dialog"
        aria-modal="false">
        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 border-b border-slate-100">
            <span class="text-slate-900 font-semibold text-md">Cohort</span>
            <button
                id="admin_dashboard_table_content_dropdown_cohort_reset"
                type="button"
                class="admin_dashboard_table_content_dropdown_cohort_reset inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm"
                style="margin-right:10px;">
                <span
                    class="inline-flex items-center justify-center w-4 h-4 rounded-full"
                    style="background:red; color:white; font-weight:800; font-size:7px;">✕</span>
                Reset
            </button>
        </div>

        <!-- Search -->
        <div class="px-2 pt-1">
            <input
                id="admin_dashboard_table_content_dropdown_cohort_search"
                type="text"
                placeholder="Entre Cohort Name"
                class="admin_dashboard_table_content_dropdown_cohort_search w-full border border-slate-200  px-2 py-1 outline-none focus:ring-2 focus:ring-slate-200"
                style="font-size:14px;" />
        </div>

        <!-- List -->
        <div class="p-2">
            <div
                id="admin_dashboard_table_content_dropdown_cohort_list"
                class="admin_dashboard_table_content_dropdown_cohort_list max-h-80 overflow-auto rounded-md"></div>
        </div>
    </div>
</div>

<script>
    /* ====== DATA ======
       Replace with your real cohort list later.
    */
    const admin_dashboard_table_content_dropdown_cohort_items = [{
            id: "FL1",
            name: "FL1"
        },
        {
            id: "OH1",
            name: "OH1"
        },
        {
            id: "NY2",
            name: "NY2"
        },
        {
            id: "OH2",
            name: "OH2"
        },
        {
            id: "TX3",
            name: "TX3"
        },
    ];

    /* ====== ELEMENTS ====== */
    const admin_dashboard_table_content_dropdown_cohort_button =
        document.getElementById("admin_dashboard_table_content_dropdown_cohort_button");
    const admin_dashboard_table_content_dropdown_cohort_button_label =
        document.getElementById("admin_dashboard_table_content_dropdown_cohort_button_label");
    const admin_dashboard_table_content_dropdown_cohort_panel =
        document.getElementById("admin_dashboard_table_content_dropdown_cohort_panel");
    const admin_dashboard_table_content_dropdown_cohort_reset =
        document.getElementById("admin_dashboard_table_content_dropdown_cohort_reset");
    const admin_dashboard_table_content_dropdown_cohort_search =
        document.getElementById("admin_dashboard_table_content_dropdown_cohort_search");
    const admin_dashboard_table_content_dropdown_cohort_list =
        document.getElementById("admin_dashboard_table_content_dropdown_cohort_list");

    /* ====== STATE ====== */
    let admin_dashboard_table_content_dropdown_cohort_isOpen = false;
    let admin_dashboard_table_content_dropdown_cohort_selectedIds = new Set(); // multi select
    let admin_dashboard_table_content_dropdown_cohort_query = "";

    /* ====== HELPERS ====== */
    function admin_dashboard_table_content_dropdown_cohort_setOpen(open) {
        admin_dashboard_table_content_dropdown_cohort_isOpen = open;

        // Tell other dropdowns to close when this opens
        if (open) {
            document.dispatchEvent(
                new CustomEvent("admin_dashboard_table_content_dropdown_any_opened", {
                    detail: {
                        name: "cohort"
                    }
                })
            );
        }

        if (open) {
            admin_dashboard_table_content_dropdown_cohort_panel.classList.remove("hidden");
            admin_dashboard_table_content_dropdown_cohort_button.setAttribute("aria-expanded", "true");
            admin_dashboard_table_content_dropdown_cohort_renderList();

            setTimeout(() => {
                admin_dashboard_table_content_dropdown_cohort_search.focus();
            }, 0);
        } else {
            admin_dashboard_table_content_dropdown_cohort_panel.classList.add("hidden");
            admin_dashboard_table_content_dropdown_cohort_button.setAttribute("aria-expanded", "false");
        }
    }

    function admin_dashboard_table_content_dropdown_cohort_escapeHtml(s) {
        return String(s)
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function admin_dashboard_table_content_dropdown_cohort_filteredItems() {
        const q = admin_dashboard_table_content_dropdown_cohort_query.trim().toLowerCase();
        if (!q) return admin_dashboard_table_content_dropdown_cohort_items;
        return admin_dashboard_table_content_dropdown_cohort_items.filter(t =>
            String(t.name || "").toLowerCase().includes(q)
        );
    }

    function admin_dashboard_table_content_dropdown_cohort_updateButtonLabel() {
        const selected = admin_dashboard_table_content_dropdown_cohort_items
            .filter(t => admin_dashboard_table_content_dropdown_cohort_selectedIds.has(t.id))
            .map(t => t.name);

        if (selected.length === 0) {
            admin_dashboard_table_content_dropdown_cohort_button_label.textContent = "Cohort";
            return;
        }

        if (selected.length === 1) {
            admin_dashboard_table_content_dropdown_cohort_button_label.textContent = selected[0];
        } else {
            admin_dashboard_table_content_dropdown_cohort_button_label.textContent = `${selected[0]} +${selected.length - 1}`;
        }
    }

    function admin_dashboard_table_content_dropdown_cohort_toggleSelected(cohortId) {
        if (admin_dashboard_table_content_dropdown_cohort_selectedIds.has(cohortId)) {
            admin_dashboard_table_content_dropdown_cohort_selectedIds.delete(cohortId);
        } else {
            admin_dashboard_table_content_dropdown_cohort_selectedIds.add(cohortId);
        }

        // keep dropdown OPEN (multi-select)
        admin_dashboard_table_content_dropdown_cohort_updateButtonLabel();
        admin_dashboard_table_content_dropdown_cohort_renderList();
    }

    function admin_dashboard_table_content_dropdown_cohort_renderList() {
        const items = admin_dashboard_table_content_dropdown_cohort_filteredItems();

        if (items.length === 0) {
            admin_dashboard_table_content_dropdown_cohort_list.innerHTML =
                `<div class="p-4 text-slate-500 text-sm">No cohorts found</div>`;
            return;
        }

        admin_dashboard_table_content_dropdown_cohort_list.innerHTML = "";

        items.forEach((t) => {
            const isSelected = admin_dashboard_table_content_dropdown_cohort_selectedIds.has(t.id);

            const row = document.createElement("button");
            row.type = "button";
            row.id = `admin_dashboard_table_content_dropdown_cohort_item_${admin_dashboard_table_content_dropdown_cohort_escapeHtml(t.id)}`;
            row.className = "admin_dashboard_table_content_dropdown_cohort_item w-full flex items-center justify-between gap-3 px-2 py-3 transition";

            // ✅ Persistent background helper (selected stays highlighted after mouse leaves)
            function applyBaseBackground() {
                row.style.background = isSelected ? "#f1f5f9" : "#ffffff";
            }

            row.innerHTML = `
                <div class="admin_dashboard_table_content_dropdown_cohort_name text-slate-900" style="font-size:14px;">
                    ${admin_dashboard_table_content_dropdown_cohort_escapeHtml(t.name)}
                </div>

                <div class="admin_dashboard_table_content_dropdown_cohort_radio_wrap flex items-center justify-center">
                    <span
                        class="admin_dashboard_table_content_dropdown_cohort_radio inline-flex items-center justify-center w-4 h-4 rounded-full border-2"
                        style="
                            border-color: ${isSelected ? '#0f172a' : '#cbd5e1'};
                            background: ${isSelected ? '#f8f8f9' : 'transparent'};
                        ">
                        <span
                            class="admin_dashboard_table_content_dropdown_cohort_radio_dot w-2 h-2 rounded-full"
                            style="background:#000; display:${isSelected ? 'block' : 'none'};"
                        ></span>
                    </span>
                </div>
            `;

            // ✅ Set initial base background correctly
            applyBaseBackground();

            // Hover effect (temporary)
            row.addEventListener("mouseenter", () => {
                row.style.background = isSelected ? "#e9eef6" : "#f8fafc";
            });

            // ✅ Restore persistent background on mouse leave
            row.addEventListener("mouseleave", () => {
                applyBaseBackground();
            });

            // CLICK: toggle selection but DO NOT CLOSE
            row.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                admin_dashboard_table_content_dropdown_cohort_toggleSelected(t.id);
            });

            admin_dashboard_table_content_dropdown_cohort_list.appendChild(row);
        });
    }

    function admin_dashboard_table_content_dropdown_cohort_resetAll() {
        admin_dashboard_table_content_dropdown_cohort_selectedIds = new Set();
        admin_dashboard_table_content_dropdown_cohort_query = "";
        admin_dashboard_table_content_dropdown_cohort_search.value = "";
        admin_dashboard_table_content_dropdown_cohort_updateButtonLabel();
        admin_dashboard_table_content_dropdown_cohort_renderList();
    }

    /* ====== EVENTS ====== */
    admin_dashboard_table_content_dropdown_cohort_button.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_cohort_setOpen(!admin_dashboard_table_content_dropdown_cohort_isOpen);
    });

    admin_dashboard_table_content_dropdown_cohort_reset.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_cohort_resetAll();
    });

    // Close COHORT if any other dropdown opens
    document.addEventListener("admin_dashboard_table_content_dropdown_any_opened", (e) => {
        if (e.detail && e.detail.name !== "cohort") {
            admin_dashboard_table_content_dropdown_cohort_setOpen(false);
        }
    });

    // Search (keep open)
    admin_dashboard_table_content_dropdown_cohort_search.addEventListener("input", (e) => {
        admin_dashboard_table_content_dropdown_cohort_query = e.target.value || "";
        admin_dashboard_table_content_dropdown_cohort_renderList();
    });

    // Prevent clicks inside panel from closing dropdown
    admin_dashboard_table_content_dropdown_cohort_panel.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    // Outside click close
    document.addEventListener("click", (e) => {
        if (!admin_dashboard_table_content_dropdown_cohort_isOpen) return;
        const target = e.target;
        const clickedInside =
            admin_dashboard_table_content_dropdown_cohort_panel.contains(target) ||
            admin_dashboard_table_content_dropdown_cohort_button.contains(target);
        if (!clickedInside) admin_dashboard_table_content_dropdown_cohort_setOpen(false);
    });

    // ESC close
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            admin_dashboard_table_content_dropdown_cohort_setOpen(false);
            admin_dashboard_table_content_dropdown_cohort_button.focus();
        }
    });

    document.addEventListener("admin_dashboard_table_content_dropdown_reset_all", () => {
        admin_dashboard_table_content_dropdown_cohort_resetAll();
    });

    /* ====== INIT ====== */
    admin_dashboard_table_content_dropdown_cohort_updateButtonLabel();
</script>