import elements from "../common/Elements.js";

function CopyText(element, steelElement) {
  let text = element.innerText;

  let tempInput = document.createElement("textarea");
  tempInput.value = text;
  document.body.appendChild(tempInput);

  tempInput.select();
  document.execCommand("copy");

  document.body.removeChild(tempInput);

  elements.toasterText.textContent = "Link copied!";
  elements.toaster.classList.remove("notActive");
  elements.toaster.classList.add("active");

  setTimeout(() => {
    elements.toaster.classList.remove("active");
    elements.toaster.classList.add("notActive");
    steelElement.style.pointerEvents = "unset";
  }, 2000);
}

export default CopyText;
