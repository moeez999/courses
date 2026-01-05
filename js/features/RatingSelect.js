import elements from "../common/Elements.js";

const buttonMap = {
  "disabled-btn-remove-1": elements.questionTwoModalOpen,
  "disabled-btn-remove-2": elements.questionThreeModalOpen,
  "disabled-btn-remove-3": elements.questionFourModalOpen,
  "disabled-btn-remove-4": elements.anonymousFeedbackLastModalOpen[elements.anonymousFeedbackLastModalOpen.length - 1],
};

const removeDisabledClass = (btnClass) => {
  const targetButton = buttonMap[btnClass];
  if (targetButton) {
    targetButton.classList.remove("disabled-button");
  } else {
    console.warn(`No button found for class: ${btnClass}`);
  }
};

const ratingOption1To10Select = () => {
  if (!elements.ratingOption1To10) {
    console.warn("Rating elements not found");
    return;
  }

  elements.ratingOption1To10.forEach((element) => {
    element.addEventListener("click", () => {
      elements.ratingOption1To10.forEach((el) => el.classList.remove("active"));
      element.classList.add("active");

      const btnClass = Array.from(element.parentElement.classList).find((cls) =>
        cls.startsWith("disabled-btn-remove")
      );
      removeDisabledClass(btnClass);

      const selectedRating = element.textContent || element.dataset.rating;
      console.log("Selected rating:", selectedRating);

      document.dispatchEvent(
        new CustomEvent("ratingChanged", {
          detail: { rating: selectedRating, element: element },
        })
      );
    });
  });
};

export default ratingOption1To10Select;
