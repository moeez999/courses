
// Teacher Management menu (extracted from the original Group Setting modal)
(function () {
  const dim = document.querySelector(".groupSettingDim");
  const modal = document.querySelector(".groupSetting");
  const closeIcon = document.querySelector(".grouptSetting-closeIcon");
  const openBtn = document.getElementById("openTeacherManagementMenuBtn");

  if (!dim || !modal) return;

  const open = () => dim.classList.add("active");
  const close = () => dim.classList.remove("active");

  // NEW: open from button
  openBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    open();
  });

  // Close when clicking the dim background or the X icon
  dim.addEventListener("click", close);
  closeIcon?.addEventListener("click", close);

  // Prevent closing when clicking inside the modal itself
  modal.addEventListener("click", (e) => e.stopPropagation());
})();
