import elements from "../common/Elements.js";

function languageDropdown_options() {
  elements.languageAndCurrencyModalLanguage.forEach(
    (dropdownContainer, index) => {
      const customDropdown = dropdownContainer.querySelector(
        ".dropdown .custom_dropdown"
      );
      const customDropdownItems = dropdownContainer.querySelectorAll(
        ".dropdown .custom_dropdown li"
      );
      const selectedLanguage = dropdownContainer.querySelector(
        ".dropdown .selectedLanguage"
      );

      // Toggle dropdown on click
      dropdownContainer.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevent window click from triggering immediately

        document
          .querySelectorAll(
            ".languageDropdown_options .dropdown .custom_dropdown"
          )
          .forEach((dropdown) => {
            if (dropdown !== customDropdown) {
              dropdown.classList.remove("active");
            }
          });

        customDropdown.classList.toggle("active");
      });

      // Handle dropdown item selection
      customDropdownItems.forEach((item) => {
        item.addEventListener("click", () => {
          selectedLanguage.textContent = item.textContent; // Set selected text
          customDropdownItems.forEach((li) => {
            li.classList.remove("active");
          });
          item.classList.add("active");

          switch (index) {
            case 0:
              document.querySelector(".language_value").textContent =
                item.textContent;
              break;

            case 1:
              document.querySelector(".currency_value").textContent =
                item.textContent;
              break;
          }

          customDropdown.classList.remove("active"); // Close dropdown after selection
        });
      });

      // Close dropdown when clicking outside
      window.addEventListener("click", () => {
        customDropdown.classList.remove("active");
      });

      // Prevent closing when clicking inside the dropdown
      customDropdown.addEventListener("click", (event) =>
        event.stopPropagation()
      );
    }
  );
}

export default languageDropdown_options;
