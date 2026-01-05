// const expiryInput = document.getElementById("expiry");
import elements from "../common/Elements";
elements.saveAPaymentCardModalExpiryDate.addEventListener("input", (e) => {
  let value = e.target.value.replace(/\D/g, ""); // sirf digits

  if (value.length >= 3) {
    value = value.slice(0, 2) + "/" + value.slice(2, 4);
  }

  e.target.value = value;
});
