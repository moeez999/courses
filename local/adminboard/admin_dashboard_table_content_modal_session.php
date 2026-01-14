<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
  .admin_dashboard_table_content_modal_session_modalEnter {
    animation: admin_dashboard_table_content_modal_session_fadeIn 120ms ease-out;
    transform-origin: top left;
  }

  @keyframes admin_dashboard_table_content_modal_session_fadeIn {
    from {
      opacity: 0;
      transform: translateY(6px) scale(0.98);
    }

    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  .admin_dashboard_table_content_modal_session_pointer {
    width: 12px;
    height: 12px;
    background: white;
    position: absolute;
    transform: rotate(45deg);
    box-shadow: -2px -2px 8px rgba(0, 0, 0, 0.06);
  }
</style>


<!-- Click-away overlay -->
<div
  id="admin_dashboard_table_content_modal_session_overlay"
  class="fixed inset-0 hidden"
  style="z-index: 9998;"></div>

<!-- Modal -->
<div
  id="admin_dashboard_table_content_modal_session_modal"
  class="fixed hidden admin_dashboard_table_content_modal_session_modalEnter"
  role="dialog"
  aria-modal="true"
  aria-labelledby="admin_dashboard_table_content_modal_session_modal_title"
  style="z-index: 9999;">
  <div
    id="admin_dashboard_table_content_modal_session_pointer"
    class="admin_dashboard_table_content_modal_session_pointer hidden md:block"></div>

  <!-- Card -->
  <div class="w-[400px] max-w-[94vw] bg-white rounded-md shadow-2xl border border-black/10 overflow-hidden">
    <!-- Header -->
    <div class="flex items-start justify-between px-3 pt-3">
      <h3
        id="admin_dashboard_table_content_modal_session_modal_title"
        class="text-[18px] font-semibold text-[#111827]">
        Session Detail
      </h3>

      <button
        type="button"
        id="admin_dashboard_table_content_modal_session_btn_close"
        class="w-9 h-9 -mt-1 rounded-full grid place-items-center hover:bg-black/5 active:bg-black/10"
        aria-label="Close">
        <span class="text-xl leading-none text-black/60">×</span>
      </button>
    </div>

    <!-- Body -->
    <div class="px-3 pt-3 pb-3">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-2">
        <div>
          <label class="block text-[12px] text-black/60 mb-1">Taught Sessions</label>
          <input
            id="admin_dashboard_table_content_modal_session_input_taught"
            class="w-full h-9 rounded-md border border-black/15 px-4 text-sm outline-none focus:ring-2 focus:ring-black/10"
            placeholder="00"
            inputmode="numeric" />
        </div>

        <div>
          <label class="block text-[12px] text-black/60 mb-1">Target Sessions</label>
          <input
            id="admin_dashboard_table_content_modal_session_input_target"
            class="w-full h-9 rounded-md border border-black/15 px-4 text-sm outline-none focus:ring-2 focus:ring-black/10"
            placeholder="00"
            inputmode="numeric" />
        </div>

        <div>
          <label class="block text-[12px] text-black/60 mb-1">Average Score</label>
          <input
            id="admin_dashboard_table_content_modal_session_input_score"
            class="w-full h-9 rounded-md border border-black/15 px-4 text-sm outline-none focus:ring-2 focus:ring-black/10"
            placeholder="00"
            inputmode="numeric" />
        </div>

        <div>
          <label class="block text-[12px] text-black/60 mb-1">Average Attendance</label>
          <input
            id="admin_dashboard_table_content_modal_session_input_attendance"
            class="w-full h-9 rounded-md border border-black/15 px-4 text-sm outline-none focus:ring-2 focus:ring-black/10"
            placeholder="0/0" />
        </div>
      </div>

      <!-- Footer -->
      <div class="pt-3 flex justify-end">
        <button
          type="button"
          id="admin_dashboard_table_content_modal_session_btn_done"
          class="
            h-9 w-[160px] rounded-md
            bg-[#FF3B30] text-white
            border-[1.5px] border-black
            shadow-md
            cursor-pointer
            transition-all duration-150
            hover:bg-[#e2342a]
            hover:shadow-lg
            hover:-translate-y-[1px]
            active:translate-y-0
          ">
          Done
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  const admin_dashboard_table_content_modal_session_modal =
    document.getElementById("admin_dashboard_table_content_modal_session_modal");

  const admin_dashboard_table_content_modal_session_overlay =
    document.getElementById("admin_dashboard_table_content_modal_session_overlay");

  const admin_dashboard_table_content_modal_session_btn_close =
    document.getElementById("admin_dashboard_table_content_modal_session_btn_close");

  const admin_dashboard_table_content_modal_session_btn_done =
    document.getElementById("admin_dashboard_table_content_modal_session_btn_done");

  const admin_dashboard_table_content_modal_session_pointer =
    document.getElementById("admin_dashboard_table_content_modal_session_pointer");

  let admin_dashboard_table_content_modal_session_isOpen = false;
  let admin_dashboard_table_content_modal_session_anchorEl = null;

  function admin_dashboard_table_content_modal_session_isMobile() {
    return window.matchMedia("(max-width: 767px)").matches;
  }

  function admin_dashboard_table_content_modal_session_positionNearAnchor() {
    if (admin_dashboard_table_content_modal_session_isMobile()) {
      admin_dashboard_table_content_modal_session_modal.style.left = "50%";
      admin_dashboard_table_content_modal_session_modal.style.bottom = "18px";
      admin_dashboard_table_content_modal_session_modal.style.top = "";
      admin_dashboard_table_content_modal_session_modal.style.transform = "translateX(-50%)";
      admin_dashboard_table_content_modal_session_pointer.classList.add("hidden");
      return;
    }

    if (!admin_dashboard_table_content_modal_session_anchorEl) return;

    const r = admin_dashboard_table_content_modal_session_anchorEl.getBoundingClientRect();
    admin_dashboard_table_content_modal_session_modal.style.left = (r.left + 14) + "px";
    admin_dashboard_table_content_modal_session_modal.style.top = (r.top + 14) + "px";
    admin_dashboard_table_content_modal_session_modal.style.bottom = "";
    admin_dashboard_table_content_modal_session_modal.style.transform = "";
    admin_dashboard_table_content_modal_session_pointer.classList.remove("hidden");
  }

  // ✅ OPEN ONLY BY FUNCTION CALL
  function admin_dashboard_table_content_modal_session_openModal(event) {
    if (event) event.stopPropagation();

    // anchor = clicked element (the one that has onclick)
    admin_dashboard_table_content_modal_session_anchorEl = event?.currentTarget || null;

    admin_dashboard_table_content_modal_session_isOpen = true;

    if (admin_dashboard_table_content_modal_session_anchorEl) {
      admin_dashboard_table_content_modal_session_anchorEl.setAttribute("aria-expanded", "true");
    }

    admin_dashboard_table_content_modal_session_overlay.classList.remove("hidden");
    admin_dashboard_table_content_modal_session_modal.classList.remove("hidden");

    admin_dashboard_table_content_modal_session_positionNearAnchor();
  }

  function admin_dashboard_table_content_modal_session_closeModal() {
    admin_dashboard_table_content_modal_session_isOpen = false;

    if (admin_dashboard_table_content_modal_session_anchorEl) {
      admin_dashboard_table_content_modal_session_anchorEl.setAttribute("aria-expanded", "false");
    }

    admin_dashboard_table_content_modal_session_modal.classList.add("hidden");
    admin_dashboard_table_content_modal_session_overlay.classList.add("hidden");
  }

  // Close handlers (same behavior)
  admin_dashboard_table_content_modal_session_btn_close.onclick =
    admin_dashboard_table_content_modal_session_btn_done.onclick =
    admin_dashboard_table_content_modal_session_overlay.onclick =
    () => admin_dashboard_table_content_modal_session_closeModal();

  // Keep position correct on resize/scroll while open
  window.addEventListener("resize", () => {
    if (admin_dashboard_table_content_modal_session_isOpen) {
      admin_dashboard_table_content_modal_session_positionNearAnchor();
    }
  });

  window.addEventListener("scroll", () => {
    if (admin_dashboard_table_content_modal_session_isOpen) {
      admin_dashboard_table_content_modal_session_positionNearAnchor();
    }
  }, true);

  // ✅ REQUIRED for inline onclick to work
  window.admin_dashboard_table_content_modal_session_openModal =
    admin_dashboard_table_content_modal_session_openModal;

  window.admin_dashboard_table_content_modal_session_closeModal =
    admin_dashboard_table_content_modal_session_closeModal;
</script>