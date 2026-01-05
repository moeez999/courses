// Close modal functionality
const modal = document.getElementById("calendarModal");
const closeBtn = document.getElementById("closeBtn");
const calendarOpen = document.querySelector(".calendarOpen");
const flatpickrDay = document.querySelectorAll(".flatpickr-day");
const calendar_backdrop = document.querySelector(".calendar_backdrop");

calendarOpen.addEventListener("click", () => {
  modal.classList.add("active");
  calendar_backdrop.classList.add("active");
});
closeBtn.addEventListener("click", () => {
  modal.classList.remove("active");
  calendar_backdrop.classList.remove("active");
});
calendar_backdrop.addEventListener("click", () => {
  modal.classList.remove("active");
  calendar_backdrop.classList.remove("active");
});

// Initialize Flatpickr
flatpickr("#datePicker", {
  inline: true, // Display calendar inline
  dateFormat: "F j, Y", // Customize the date format
  disableMobile: true, // Ensure consistent appearance on mobile
  onChange: function (selectedDates, dateStr, instance) {
    document.querySelector("#selectedData").innerHTML = dateStr;
    modal.classList.remove("active");
    calendar_backdrop.classList.remove("active");
  },
});
