<?php
// admin_dashboard_table_content_dropdown_teacher.php
?>

<!-- TEACHER DROPDOWN (Multi-select + Search) -->
<div class="relative inline-block">
    <!-- Trigger -->
    <button
        id="admin_dashboard_table_content_dropdown_teacher_button"
        type="button"
        class="admin_dashboard_table_content_dropdown_teacher_button inline-flex ml-3 items-center justify-between gap-3 w-35 px-2 py-2 rounded-md bg-white border border-slate-200 shadow-sm hover:bg-slate-50 active:bg-slate-100 transition"
        aria-haspopup="dialog"
        aria-expanded="false"
        style="height:50px;">
        <span id="admin_dashboard_table_content_dropdown_teacher_button_label" class="text-slate-900 font-medium">
            Techer
        </span>
        
        <svg class="w-5 h-5 text-slate-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Panel -->
    <div
        id="admin_dashboard_table_content_dropdown_teacher_panel"
        class="admin_dashboard_table_content_dropdown_teacher_panel hidden absolute z-50 mt-2 w-[360px] rounded-xl bg-white border border-slate-200 shadow-xl"
        role="dialog"
        aria-modal="false">

        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 border-b border-slate-100">
            <span class="text-slate-900 font-semibold text-md">Teacher</span>
            <button
                id="admin_dashboard_table_content_dropdown_teacher_reset"
                type="button"
                class="admin_dashboard_table_content_dropdown_teacher_reset inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm"
                style="margin-right:10px;">
                <span
                    class="inline-flex items-center justify-center w-4 h-4 rounded-full"
                    style="background:red; color:white; font-weight:800; font-size:7px;">✕</span>
                Reset
            </button>
        </div>

        <!-- Search -->
        <div class="px-2 pt-2">
            <input
                id="admin_dashboard_table_content_dropdown_teacher_search"
                type="text"
                placeholder="Entre teacher name"
                class="admin_dashboard_table_content_dropdown_teacher_search w-full border  rounded-md px-2 py-2 outline-none focus:ring-2 focus:ring-slate-200"
                style="font-size:14px;" />
        </div>

        <!-- List -->
        <div class="p-2">
            <div
                id="admin_dashboard_table_content_dropdown_teacher_list"
                class="admin_dashboard_table_content_dropdown_teacher_list max-h-80 overflow-auto"></div>
        </div>
    </div>
</div>

<script>
    /* ====== DATA ======
       Replace avatars/names with your real list.
    */
    const admin_dashboard_table_content_dropdown_teacher_items = [{
            id: 1,
            name: "Jonas",
            avatar: "https://i.pravatar.cc/80?img=11"
        },
        {
            id: 2,
            name: "Mary Janes",
            avatar: "https://i.pravatar.cc/80?img=47"
        },
        {
            id: 3,
            name: "Brooklyn Simmons",
            avatar: "https://i.pravatar.cc/80?img=12"
        },
        {
            id: 4,
            name: "Albert Flores",
            avatar: "https://i.pravatar.cc/80?img=15"
        },
        {
            id: 5,
            name: "Theresa Webb",
            avatar: "https://i.pravatar.cc/80?img=32"
        },
        {
            id: 6,
            name: "Marvin McKinney",
            avatar: "https://i.pravatar.cc/80?img=60"
        },
    ];

    /* ====== ELEMENTS ====== */
    const admin_dashboard_table_content_dropdown_teacher_button =
        document.getElementById("admin_dashboard_table_content_dropdown_teacher_button");
    const admin_dashboard_table_content_dropdown_teacher_button_label =
        document.getElementById("admin_dashboard_table_content_dropdown_teacher_button_label");
    const admin_dashboard_table_content_dropdown_teacher_panel =
        document.getElementById("admin_dashboard_table_content_dropdown_teacher_panel");
    const admin_dashboard_table_content_dropdown_teacher_reset =
        document.getElementById("admin_dashboard_table_content_dropdown_teacher_reset");
    const admin_dashboard_table_content_dropdown_teacher_search =
        document.getElementById("admin_dashboard_table_content_dropdown_teacher_search");
    const admin_dashboard_table_content_dropdown_teacher_list =
        document.getElementById("admin_dashboard_table_content_dropdown_teacher_list");

    /* ====== STATE ====== */
    let admin_dashboard_table_content_dropdown_teacher_isOpen = false;
    let admin_dashboard_table_content_dropdown_teacher_selectedIds = new Set();
    let admin_dashboard_table_content_dropdown_teacher_query = "";

    /* ====== HELPERS ====== */
    function admin_dashboard_table_content_dropdown_teacher_setOpen(open) {
        admin_dashboard_table_content_dropdown_teacher_isOpen = open;

        // Tell other dropdowns to close when this opens
        if (open) {
            document.dispatchEvent(
                new CustomEvent("admin_dashboard_table_content_dropdown_any_opened", {
                    detail: {
                        name: "teacher"
                    }
                })
            );
        }

        if (open) {
            admin_dashboard_table_content_dropdown_teacher_panel.classList.remove("hidden");
            admin_dashboard_table_content_dropdown_teacher_button.setAttribute("aria-expanded", "true");
            admin_dashboard_table_content_dropdown_teacher_renderList();

            setTimeout(() => {
                admin_dashboard_table_content_dropdown_teacher_search.focus();
            }, 0);
        } else {
            admin_dashboard_table_content_dropdown_teacher_panel.classList.add("hidden");
            admin_dashboard_table_content_dropdown_teacher_button.setAttribute("aria-expanded", "false");
        }
    }

    function admin_dashboard_table_content_dropdown_teacher_escapeHtml(s) {
        return String(s)
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function admin_dashboard_table_content_dropdown_teacher_filteredItems() {
        const q = admin_dashboard_table_content_dropdown_teacher_query.trim().toLowerCase();
        if (!q) return admin_dashboard_table_content_dropdown_teacher_items;
        return admin_dashboard_table_content_dropdown_teacher_items.filter(t =>
            String(t.name || "").toLowerCase().includes(q)
        );
    }

    function admin_dashboard_table_content_dropdown_teacher_updateButtonLabel() {
        const selected = admin_dashboard_table_content_dropdown_teacher_items
            .filter(t => admin_dashboard_table_content_dropdown_teacher_selectedIds.has(t.id))
            .map(t => t.name);

        if (selected.length === 0) {
            admin_dashboard_table_content_dropdown_teacher_button_label.textContent = "Techer";
            return;
        }

        // keep it compact like a filter chip
        if (selected.length === 1) {
            admin_dashboard_table_content_dropdown_teacher_button_label.textContent = selected[0];
        } else {
            admin_dashboard_table_content_dropdown_teacher_button_label.textContent = `${selected[0]} +${selected.length - 1}`;
        }
    }

    function admin_dashboard_table_content_dropdown_teacher_toggleSelected(teacherId) {
        if (admin_dashboard_table_content_dropdown_teacher_selectedIds.has(teacherId)) {
            admin_dashboard_table_content_dropdown_teacher_selectedIds.delete(teacherId);
        } else {
            admin_dashboard_table_content_dropdown_teacher_selectedIds.add(teacherId);
        }

        // IMPORTANT: keep dropdown OPEN (multi-select)
        admin_dashboard_table_content_dropdown_teacher_updateButtonLabel();
        admin_dashboard_table_content_dropdown_teacher_renderList();
    }

    function admin_dashboard_table_content_dropdown_teacher_renderList() {
        const items = admin_dashboard_table_content_dropdown_teacher_filteredItems();

        if (items.length === 0) {
            admin_dashboard_table_content_dropdown_teacher_list.innerHTML =
                `<div class="p-4 text-slate-500 text-sm">No teachers found</div>`;
            return;
        }

        admin_dashboard_table_content_dropdown_teacher_list.innerHTML = "";

        items.forEach((t) => {
            const isSelected = admin_dashboard_table_content_dropdown_teacher_selectedIds.has(t.id);

            const row = document.createElement("button");
            row.type = "button";
            row.id = `admin_dashboard_table_content_dropdown_teacher_item_${t.id}`;
            row.className = "admin_dashboard_table_content_dropdown_teacher_item w-full flex items-center justify-between gap-3 px-2 py-2 transition";

            // ✅ Persistent background helper (selected stays highlighted even after mouse leave)
            function applyBaseBackground() {
                row.style.background = isSelected ? "#f1f5f9" : "#ffffff";
            }

            row.innerHTML = `
                <div class="flex items-center gap-3">
                    <img
                        src="${admin_dashboard_table_content_dropdown_teacher_escapeHtml(t.avatar)}"
                        alt="${admin_dashboard_table_content_dropdown_teacher_escapeHtml(t.name)}"
                        class="admin_dashboard_table_content_dropdown_teacher_avatar w-9 h-9 rounded-md object-cover"
                    />
                    <div class="admin_dashboard_table_content_dropdown_teacher_name text-slate-900 " style="font-size:14px;">
                        ${admin_dashboard_table_content_dropdown_teacher_escapeHtml(t.name)}
                    </div>
                </div>

                <div class="admin_dashboard_table_content_dropdown_teacher_radio_wrap flex items-center justify-center">
                    <span
                        class="admin_dashboard_table_content_dropdown_teacher_radio inline-flex items-center justify-center w-4 h-4 rounded-full border-2"
                        style="
                            border-color: ${isSelected ? '#0f172a' : '#cbd5e1'};
                            background: ${isSelected ? '#ffffff' : 'transparent'};
                        "
                    >
                        <span
                            class="admin_dashboard_table_content_dropdown_teacher_radio_dot w-2 h-2 rounded-full"
                            style="background:#000; display:${isSelected ? 'block' : 'none'};"
                        ></span>
                    </span>
                </div>
            `;

            // ✅ Set initial background correctly
            applyBaseBackground();

            // Hover effect like snapshot (subtle)
            row.addEventListener("mouseenter", () => {
                row.style.background = isSelected ? "#f0f2f5" : "#f8fafc";
            });

            // ✅ On mouse leave, restore persistent selected background
            row.addEventListener("mouseleave", () => {
                applyBaseBackground();
            });

            // CLICK: toggle selection but DO NOT CLOSE
            row.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation(); // prevent outside click close
                admin_dashboard_table_content_dropdown_teacher_toggleSelected(t.id);
            });

            admin_dashboard_table_content_dropdown_teacher_list.appendChild(row);
        });
    }

    function admin_dashboard_table_content_dropdown_teacher_resetAll() {
        admin_dashboard_table_content_dropdown_teacher_selectedIds = new Set();
        admin_dashboard_table_content_dropdown_teacher_query = "";
        admin_dashboard_table_content_dropdown_teacher_search.value = "";
        admin_dashboard_table_content_dropdown_teacher_updateButtonLabel();
        admin_dashboard_table_content_dropdown_teacher_renderList();
    }

    /* ====== EVENTS ====== */
    admin_dashboard_table_content_dropdown_teacher_button.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_teacher_setOpen(!admin_dashboard_table_content_dropdown_teacher_isOpen);
    });

    admin_dashboard_table_content_dropdown_teacher_reset.addEventListener("click", (e) => {
        e.stopPropagation();
        admin_dashboard_table_content_dropdown_teacher_resetAll();
    });

    // Close TEACHER if any other dropdown opens
    document.addEventListener("admin_dashboard_table_content_dropdown_any_opened", (e) => {
        if (e.detail && e.detail.name !== "teacher") {
            admin_dashboard_table_content_dropdown_teacher_setOpen(false);
        }
    });

    // Search (keep open)
    admin_dashboard_table_content_dropdown_teacher_search.addEventListener("input", (e) => {
        admin_dashboard_table_content_dropdown_teacher_query = e.target.value || "";
        admin_dashboard_table_content_dropdown_teacher_renderList();
    });

    // Prevent clicks inside panel from closing dropdown
    admin_dashboard_table_content_dropdown_teacher_panel.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    // Outside click close
    document.addEventListener("click", (e) => {
        if (!admin_dashboard_table_content_dropdown_teacher_isOpen) return;
        const target = e.target;
        const clickedInside =
            admin_dashboard_table_content_dropdown_teacher_panel.contains(target) ||
            admin_dashboard_table_content_dropdown_teacher_button.contains(target);
        if (!clickedInside) admin_dashboard_table_content_dropdown_teacher_setOpen(false);
    });

    // ESC close
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            admin_dashboard_table_content_dropdown_teacher_setOpen(false);
            admin_dashboard_table_content_dropdown_teacher_button.focus();
        }
    });

    document.addEventListener("admin_dashboard_table_content_dropdown_reset_all", () => {
        admin_dashboard_table_content_dropdown_teacher_resetAll();
    });

    /* ====== INIT ====== */
    admin_dashboard_table_content_dropdown_teacher_updateButtonLabel();
</script>