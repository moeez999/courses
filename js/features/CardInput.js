import elements from "../common/Elements.js";

function CardInput() {
  elements.saveAPaymentCardModalCardNumber.addEventListener("input", (e) => {
    let value = e.target.value.replace(/\D/g, ""); // sirf digits rakhein
    value = value.substring(0, 16); // sirf 16 digits allow karein

    // Hyphen after every 4 digits
    const formattedValue = value.replace(/(.{4})/g, "$1-").replace(/-$/, "");

    e.target.value = formattedValue;
  });
}

export default CardInput;
