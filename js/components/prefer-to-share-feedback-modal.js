import elements from "../common/Elements.js";
import Variable from "../common/Variable.js";

function FeedbackModalHandler(options, type) {
  options.forEach((element) => {
    element.addEventListener("click", () => {
      const continueBtn = element.closest("main").querySelector(".red-button");

      // Remove active from all
      options.forEach((opt) => opt.classList.remove("active"));

      // Add active to clicked
      element.classList.add("active");

      // Set variable conditionally
      Variable.isPublicReviewForGroup = false;
      Variable.isPublicReviewForTeacher = false;

      if (element.querySelector(".public-review-for-group")) {
        Variable.isPublicReviewForGroup = true;
      }

      if (element.querySelector(".public-review-for-teacher")) {
        Variable.isPublicReviewForTeacher = true;
      }

      // Enable continue button
      continueBtn.classList.remove("disabled-button");
    });
  });
}

// Wrapper function to initialize both modals
function InitFeedbackModals() {
  FeedbackModalHandler(elements.bulletSelectOptionsButton);
}

export default InitFeedbackModals;
