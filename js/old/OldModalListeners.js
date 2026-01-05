import elements from "../common/Elements.js";
import Variable from "../common/Variable.js";

function OldModalListeners() {
  // Helper function to remove 'active' class from elements
  const removeActiveClass = (elements, subSelector = null) => {
    elements.forEach((el) => {
      el.classList.remove("active");
      if (subSelector)
        el.querySelector(subSelector)?.classList.remove("active");
    });
  };

  // Other Option Textarea Click Event
  // elements.otherAsyncTextarea.addEventListener("click", () => {
  //   removeActiveClass(elements.tellUsWhy_options_option, ".circle");

  //   elements.otherAsync.classList.add("active");
  //   elements.otherAsyncTextarea.classList.add("hide");
  //   elements.otherAsync.focus();

  //   updateTellUsWhyButton(); // Function call to check initial state

  //   Variable.isOtherOptionSelected = true;
  // });

  // Listen for input event to check textarea value dynamically
  // elements.otherAsync.addEventListener("input", updateTellUsWhyButton);

  // function updateTellUsWhyButton() {
  //   if (elements.otherAsync.value.trim().length > 0) {
  //     elements.tellUsWhyBTN.classList.add("active");
  //   } else {
  //     elements.tellUsWhyBTN.classList.remove("active");
  //   }
  // }

  // Options Click Event
  // elements.tellUsWhy_options_option.forEach((option, index) => {
  //   option.addEventListener("click", () => {
  //     removeActiveClass(elements.tellUsWhy_options_option, ".circle");

  //     if (Variable.isOtherOptionSelected) {
  //       elements.otherAsync.classList.remove("active");
  //       elements.otherAsyncTextarea.classList.remove("hide");
  //       Variable.isOtherOptionSelected = false;
  //     }

  //     option.classList.add("active");
  //     option.querySelector(".circle").classList.add("active");
  //     elements.tellUsWhyBTN.classList.add("active");
  //   });
  // });

  // Teacher Box Click Event
  elements.balanceModalTeachersBox.forEach((box, index) => {
    box.addEventListener("click", () => {
      removeActiveClass(elements.balanceModalTeachersBox);
      removeActiveClass(elements.balanceModalTeachersBoxes);

      elements.balanceModalTeachersBoxes[index].classList.add("active");
      box.classList.add("active");
    });
  });

  // extralesson increment and decrement
  // ===================================
  elements.addExtraLessonIncrement.addEventListener("click", () => {
    Variable.extraLessonCount =
      Variable.extraLessonCount > 1 ? Variable.extraLessonCount - 1 : 1;
    elements.addExtraLessonValue.textContent = Variable.extraLessonCount;
    elements.addExtraLessonTotalValue.textContent =
      Variable.extraLessonCount * 5;
  });

  elements.addExtraLessonDecrement.addEventListener("click", () => {
    Variable.extraLessonCount =
      Variable.extraLessonCount >= 1 ? Variable.extraLessonCount + 1 : 1;
    elements.addExtraLessonValue.textContent = Variable.extraLessonCount;
    elements.addExtraLessonTotalValue.textContent =
      Variable.extraLessonCount * 5;
  });
  // =============== END ================

  elements.begginerLevelOpen.addEventListener("click", () => {
    elements.begginerLevel.classList.toggle("active");
  });

  // document
  //   .querySelector(".resheduleLesson .goBack")
  //   .addEventListener("click", () => {
  //     Variable.openNestedContainer = elements.change_your_plane_popup;

  //     // elements.resheduleLesson_popup.classList.remove("active");
  //     elements.change_your_plane_popup.classList.toggle("active");
  //   });

  // elements.upgrade_now_popup_open.addEventListener("click", () => {
  //   Variable.openNestedContainer = elements.upgrade_now_popup;

  //   // elements.change_your_plane_popup.classList.remove("active");
  //   elements.upgrade_now_popup.classList.toggle("active");
  // });

  // elements.review_your_changes_popupOpen.addEventListener("click", () => {
  //   Variable.openNestedContainer = elements.review_your_changes_popup;

  //   elements.upgrade_now_popup.classList.remove("active");
  //   elements.review_your_changes_popup.classList.toggle("active");
  // });

  // elements.great_popup_open.addEventListener("click", () => {
  //   Variable.openNestedContainer = elements.great_popup;

  //   elements.upgrade_now_popup.classList.remove("active");
  //   elements.great_popup.classList.toggle("active");
  // });

  // elements.upgrade_now_popup_back.addEventListener("click", () => {
  //   // Variable.openNestedContainer = elements.change_your_plane_popup;

  //   elements.upgrade_now_popup.classList.remove("active");
  //   // elements.change_your_plane_popup.classList.toggle("active");
  // });

  // elements.review_your_changes_popup_back.addEventListener("click", () => {
  //   Variable.openNestedContainer = elements.upgrade_now_popup;

  //   elements.review_your_changes_popup.classList.remove("active");
  //   elements.upgrade_now_popup.classList.toggle("active");
  // });

  // ============================================================

  // elements.changePlaneBox.addEventListener("click", () => {
  //   elements.changePlaneBox.classList.toggle("active");
  //   elements.btnToContinueChangePlane.classList.toggle("active");
  // });
}

export default OldModalListeners;
