import elements from "../common/Elements.js";
import { PopupBack } from "../common/index.js";

function BackModalListener() {
  elements.backModal.forEach((e) => {
    e.addEventListener("click", () => {
      PopupBack();
    });
  });
}

export default BackModalListener;
