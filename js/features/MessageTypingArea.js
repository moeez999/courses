document.addEventListener("DOMContentLoaded", function () {
  const messageArea = document.querySelector(".messageTypingArea");
  const defaultText = "Your message"; // Default placeholder text

  // Jab user click kare to placeholder remove ho
  messageArea.addEventListener("focus", function () {
    if (messageArea.textContent === defaultText) {
      messageArea.textContent = "";
      messageArea.classList.remove("placeholder"); // CSS class for styling
    }
  });

  // Jab user bahar click kare aur agar empty ho to placeholder wapas aa jaye
  messageArea.addEventListener("blur", function () {
    if (messageArea.textContent.trim() === "") {
      messageArea.textContent = defaultText;
      messageArea.classList.add("placeholder");
    }
  });
});
