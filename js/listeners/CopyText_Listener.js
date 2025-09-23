// =====================================================
// ==================== COPY TEXT ======================

import CopyText from "../features/CopyText.js";

// import copyText from "../features/CopyText";

function CopyTextListener() {
  document.querySelectorAll(".copyLinkBTN").forEach((e) => {
    e.addEventListener("click", () => {
      e.style.pointerEvents = "none";
      CopyText(document.getElementById("copyLinkText"), e);
    });
  });
}

export default CopyTextListener;
