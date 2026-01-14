<?php
// admin_dashboard_table_content_dropdown_reset_all.php
?>

<!-- RESET ALL BUTTON (Dispatches global reset event) -->
<div class="relative inline-block">
    <button
        id="admin_dashboard_table_content_dropdown_reset_all_button"
        type="button"
        class="admin_dashboard_table_content_dropdown_reset_all_button ml-3 inline-flex items-center gap-2 text-slate-900 hover:text-slate-900 text-sm"
    >
        <span
            class="inline-flex items-center justify-center w-4 h-4 rounded-full"
            style="background:red; color:white; font-weight:800; font-size:9px;"
        >✕</span>
        Reset all
    </button>
</div>

<script>
/* ====== ELEMENTS ====== */
const admin_dashboard_table_content_dropdown_reset_all_button =
    document.getElementById("admin_dashboard_table_content_dropdown_reset_all_button");

/* ====== ACTION ====== */
function admin_dashboard_table_content_dropdown_reset_all_dispatch() {
    document.dispatchEvent(
        new CustomEvent("admin_dashboard_table_content_dropdown_reset_all", {
            detail: { source: "reset_all_button" }
        })
    );
}

/* ====== EVENTS ====== */
admin_dashboard_table_content_dropdown_reset_all_button.addEventListener("click", (e) => {
    e.stopPropagation();
    admin_dashboard_table_content_dropdown_reset_all_dispatch();
});
</script>
