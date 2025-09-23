import elements from "../common/Elements.js";

function SuggestedFeedbackOptionsSelected() {
  const parentButtons = elements.suggestedFeedbackOptionsParent;
  const nestedGroups = elements.suggestedFeedbackOptionsNested;

  parentButtons.forEach((parent) => {
    parent.addEventListener("click", () => {
      // Reset all parents & nested groups
      parentButtons.forEach((btn) => btn.classList.remove("active"));
      nestedGroups.forEach((group) => {
        group.classList.remove("active");
        group
          .querySelectorAll(".nested")
          .forEach((n) => n.classList.remove("active"));
      });

      // Activate clicked parent
      parent.classList.add("active");

      const targetId = parent.dataset.target;
      const nested = document.getElementById(targetId);

      if (nested) {
        // Agar nested hai → show nested & remove active from parent itself
        // parent.classList.remove("active");
        nested.classList.add("active");
      }
    });
  });

  // Nested option logic (sirf ek select hoga)
  nestedGroups.forEach((group) => {
    const nestedButtons = group.querySelectorAll(".nested");

    nestedButtons.forEach((nested) => {
      nested.addEventListener("click", () => {
        // Reset all nested in this group
        nestedButtons.forEach((btn) => btn.classList.remove("active"));
        nested.classList.add("active");
      });
    });
  });
}

export default SuggestedFeedbackOptionsSelected;
