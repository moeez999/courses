// ====================================================
// ===================== POPUP CLOSE ====================

import elements from "../common/Elements.js";
import { PopupClose } from "../common/index.js";
import Variable from "../common/Variable.js";

function CloseModalListener() {
  elements.backdropLevel1.addEventListener("click", () =>
    PopupClose(Variable.openContainer, elements.backdropLevel1)
  );

  elements.backdropLevel2.addEventListener("click", () =>
    PopupClose(Variable.openNestedContainer, elements.backdropLevel2)
  );

  elements.backdropLevel3.addEventListener("click", () =>
    PopupClose(Variable.openNestedChildContainer, elements.backdropLevel3)
  );

  elements.backdropLevel3Close.forEach((e) =>
    e.addEventListener("click", () => {
      PopupClose(Variable.openNestedChildContainer, elements.backdropLevel3);
    })
  );

  elements.backdropLevel2Close.forEach((e) =>
    e.addEventListener("click", () => {
      PopupClose(Variable.openNestedContainer, elements.backdropLevel2);
    })
  );

  document.querySelectorAll(".back-custom-icon").forEach((e) =>
    e.addEventListener("click", () => {
      PopupClose(Variable.openNestedContainer, elements.backdropLevel2);
    })
  );

  elements.backdropLevel1Close.forEach((e) =>
    e.addEventListener("click", () => {
      PopupClose(Variable.openContainer, elements.backdropLevel1);
    })
  );
}

export default CloseModalListener;
