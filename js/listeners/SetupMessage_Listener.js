import elements from "../common/Elements.js";
import Variable from "../common/Variable.js";

const SetupMessageListener = () => {
  elements.messageBoxGoBack.addEventListener("click", () => {
    elements.messagesModal.classList.add("active");
    elements.messageBox.classList.remove("active");
    Variable.openContainer = elements.messagesModal;
    // elements = elements.messagesModal;
  });

  elements.messageCard.forEach((e) =>
    e.addEventListener("click", () => {
      elements.messagesModal.classList.remove("active");
      elements.messageBox.classList.add("active");
      Variable.openContainer = elements.messageBox;
      elements.messageBox.addEventListener("click", (e) => e.stopPropagation());
    })
  );

  elements.ArchiveTutorOpen.forEach((element, index) => {
    element.addEventListener("click", (event) => {
      event.stopPropagation();

      Variable.archiveTutorIndex = index;
      elements.ArchiveTutor[index].classList.toggle("active");
      elements.messageCard[index].classList.toggle("active");
    });
  });

  window.addEventListener("click", (event) => {
    if (Variable.archiveTutorIndex) {
      console.log(event.target);
    }
  });
};

export default SetupMessageListener;
