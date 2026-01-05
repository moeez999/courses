import Variable from "./Variable.js";

// ===================== POPUP OPEN ====================
function PopupOpen(backdropContainer, popup, nested = false, nestedChild=false) {
  if (nested) {
    Variable.openNestedContainer = popup;
  } else if (nestedChild) {
    Variable.openNestedChildContainer = popup;
  } else {
    Variable.openContainer = popup;
  }

  backdropContainer.classList.add("active");
  popup.classList.add("active");
}

// ===================== POPUP CLOSE ====================
function PopupClose(openPopup, backdropContainer) {
  backdropContainer.classList.remove("active");
  openPopup.classList.remove("active");
}

// ==================== Modal Stack =====================
function ModalStackCreate(popup) {
  // Pehle wale modal ko stack mein add karo
  if (Variable.modalStack.length > 0) {
    let lastModal = Variable.modalStack[Variable.modalStack.length - 1];
    lastModal.classList.remove("active"); // Pehla modal hide karo
  }

  Variable.modalStack.push(popup); // Naya modal stack mein daal do
}

// ==================== Popup Back =====================
function PopupBack() {
  if (Variable.modalStack.length > 1) {
    let currentModal = Variable.modalStack.pop(); // Current modal remove karo
    currentModal.classList.remove("active");

    let previousModal = Variable.modalStack[Variable.modalStack.length - 1]; // Previous modal lo
    previousModal.classList.add("active"); // Previous modal ko show karo
    Variable.openNestedContainer = previousModal;
  } else {
    let lastModal = Variable.modalStack.pop();
    lastModal.classList.remove("active");
    Variable.openNestedContainer = lastModal;
  }
}

export { PopupOpen, PopupClose, PopupBack, ModalStackCreate };
