// Function to toggle dropdown
const ToggleDropdown = (dropdownMenu) => {
  document.querySelectorAll(".dropdown-menu").forEach((menu) => {
    if (menu !== dropdownMenu) menu.classList.remove("active");
  });
  dropdownMenu.classList.toggle("active");
};

// Function to select an item
const SelectItem = (item, buttonElement, dropdownMenu) => {
  buttonElement.textContent = item.textContent;
  dropdownMenu.classList.remove("active");
};

// Function to handle dropdown logic
const SetupDropdown = (dropdownClass) => {
  const dropdownButton = document.querySelector(
    `.${dropdownClass} .dropdown-button`
  );
  const dropdownMenu = document.querySelector(
    `.${dropdownClass} .dropdown-menu`
  );
  const dropdownItems = dropdownMenu.querySelectorAll(".dropdown-item");

  dropdownButton.addEventListener("click", (e) => {
    e.stopPropagation(); // Prevent click from bubbling to window
    ToggleDropdown(dropdownMenu);
  });

  dropdownItems.forEach((item) =>
    item.addEventListener("click", () => {
      SelectItem(item, dropdownButton.querySelector("p"), dropdownMenu);
    })
  );
};

// Initialize all dropdowns
["reasonOption"].forEach(SetupDropdown);

// Close dropdown when clicking outside
window.addEventListener("click", () => {
  document.querySelectorAll(".dropdown-menu").forEach((menu) => {
    menu.classList.remove("active");
  });
});
