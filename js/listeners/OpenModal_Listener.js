// ====================================================
// ================ MODAL MANAGER ===================

import elements from "../common/Elements.js";
import { ModalStackCreate, PopupOpen } from "../common/index.js";
import Variable from "../common/Variable.js";
import detectAndAdjustPosition from "../features/DetectAndAdjustPosition.js";

/**
 * Modal configuration object
 * Each key represents a trigger element, value contains modal configuration
 */
const MODAL_CONFIG = {
  // Simple modals with backdrop level 2
  whyNeedToTransferSubscriptionModalOpen: {
    modal: "whyNeedToTransferSubscriptionModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  issueReportedModalOpen: {
    modal: "issueReportedModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  explainYourIssueModalOpen: {
    modal: "explainYourIssueModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  tellUsWhatHappenedModalOpen: {
    modal: "tellUsWhatHappenedModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  badOptionSelectModalOpen: {
    modal: "badOptionSelectModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  questionOneModalOpen: {
    modal: "questionOneModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  greatOptionSelectModalOpen: {
    modal: "greatOptionSelectModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  questionTwoModalOpen: {
    modal: "questionTwoModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  questionThreeModalOpen: {
    modal: "questionThreeModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  questionFourModalOpen: {
    modal: "questionFourModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  preferToShareFeedbackModalOpen: {
    modal: "preferToShareFeedbackModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  giveFeedbackToTeacherModalOpen: {
    modal: "giveFeedbackToTeacherModal",
    backdrop: "backdropLevel2",
    useModalStack: true,
    nested: true,
  },

  shareTutorModalOpen: {
    modal: "shareTutorModal",
    backdrop: "backdropLevel2",
    nested: true,
  },

  cancelModalOpen: {
    modal: "cancelLessonModal",
    backdrop: "backdropLevel2",
    nested: true,
  },

  // Simple modals with backdrop level 1
  addExtraLessonModalOpen: {
    modal: "addExtraLessonModal",
    backdrop: "backdropLevel1",
  },

  profileSettingModalOpen: {
    modal: "profileSettingModal",
    backdrop: "backdropLevel1",
  },

  balanceModalOpen: {
    modal: "balanceModal",
    backdrop: "backdropLevel1",
  },

  languageAndCurrencyModalOpen: {
    modal: "languageAndCurrencyModal",
    backdrop: "backdropLevel1",
  },

  subscribeModalOpen: {
    modal: "subscribeModal",
    backdrop: "backdropLevel1",
  },

  whichTutorModalOpen: {
    modal: "whichTutorModal",
    backdrop: "backdropLevel1",
  },

  resubscribeLessonModalOpen: {
    modal: "resubscribeLessonModal",
    backdrop: "backdropLevel1",
    nested: true,
  },

  // Modals with position detection
  groupClassesOptionsModalOpen: {
    modal: "groupClassesOptionsModal",
    backdrop: "backdropLevel1",
    usePositionDetection: true,
  },

  // Modal with custom click handling
  messageModalOpen: {
    modal: "messagesModal",
    backdrop: "backdropLevel1",
    preventBubbling: true,
  },

  notificationModalOpen: {
    modal: "notificationModal",
    backdrop: "backdropLevel1",
    preventBubbling: true,
  },

  // Modals with backdrop level 3
  saveAPaymentCardModalOpen: {
    modal: "saveAPaymentCardModal",
    backdrop: "backdropLevel3",
    nested: false,
    nestedChild: true,
  },
};

/**
 * Complex modal handlers that require custom logic
 */
const COMPLEX_MODAL_HANDLERS = {
  preferToShareFeedbackModalContinueBTN: () => {
    if (Variable.isPublicReviewForGroup) {
      ModalStackCreate(elements.publishYourReviewForFlorida1Modal);
      PopupOpen(
        elements.backdropLevel2,
        elements.publishYourReviewForFlorida1Modal,
        true
      );
    } else {
      ModalStackCreate(elements.rateYourTeacher4QuestionsModal);
      PopupOpen(
        elements.backdropLevel2,
        elements.rateYourTeacher4QuestionsModal,
        true
      );
    }
  },

  giveFeedbackToTeacherModalContinueBTN: () => {
    if (Variable.isPublicReviewForTeacher) {
      ModalStackCreate(elements.publicFeedbackToTeacherModal);
      PopupOpen(
        elements.backdropLevel2,
        elements.publicFeedbackToTeacherModal,
        true
      );
    } else {
      ModalStackCreate(elements.anonymousFeedbackToTeacherModal);
      PopupOpen(
        elements.backdropLevel2,
        elements.anonymousFeedbackToTeacherModal,
        true
      );
    }
  },

  showBreakdownModalOpen: () => {
    elements.showBreakdownModalAmountUsed.innerText = `-${elements.HowManyLessonsYouWantModalBalanceUsed.innerText}`;

    if (Variable.is6Lessons) {
      elements.showBreakdownModalRemainingBalance.innerText = "$0.37";
      elements.showBreakdownModalRemainingBalanceTextChange.innerText =
        "Amount to pay";
      elements.showBreakdownModalRemainingBalance.classList.add("redColor");
    } else {
      elements.showBreakdownModalRemainingBalanceTextChange.innerText =
        "Remaining balance";
      elements.showBreakdownModalRemainingBalance.classList.remove("redColor");
      const balanceUsed = Number(
        elements.HowManyLessonsYouWantModalBalanceUsed.innerText.slice(1)
      );
      elements.showBreakdownModalRemainingBalance.innerText = `$${(
        29.44 - balanceUsed
      ).toFixed(2)}`;
    }

    PopupOpen(
      elements.backdropLevel3,
      elements.showBreakdownModal,
      false,
      true
    );
  },

  confirmPaymentModal02Open: () => {
    const { extraLessonCount } = Variable;
    const lessonAmount = extraLessonCount * 5;
    const totalFee = lessonAmount + 0.54;

    elements.confirmPaymentModalExtraLessonCount.textContent = extraLessonCount;
    elements.confirmPaymentModalExtraLessonAmount.textContent = lessonAmount;
    elements.confirmPaymentModalTotalFee.textContent = totalFee;
    elements.confirmPaymentModalTotalAmountShowInBTN.textContent = totalFee;

    elements.addExtraLessonModal.classList.remove("active");
    PopupOpen(elements.backdropLevel1, elements.confirmPaymentModal02);
  },

  confirmPaymentModal02GoBack: () => {
    elements.confirmPaymentModal02.classList.remove("active");
    PopupOpen(elements.backdropLevel1, elements.addExtraLessonModal);
  },

  transferCompleteModalOpen: () => {
    if (Variable.is6Lessons) {
      ModalStackCreate(elements.confirmPaymentModal);
      PopupOpen(elements.backdropLevel2, elements.confirmPaymentModal, true);
    } else {
      ModalStackCreate(elements.reviewYourTransferModal);
      PopupOpen(elements.backdropLevel2, elements.transferCompleteModal, true);
    }
  },
};

/**
 * Modal content templates for transfer modals
 */
const TRANSFER_MODAL_TEMPLATES = {
  is6Lessons: {
    content: `<li>You'll get <span>5 lessons ($24.84) with Daniela.</span> after you pay a $2.76 difference.</li>`,
    extraMessage: "Price difference",
    extraPrice: "-$2.76",
    buttonText: "Continue to checkout",
  },

  isTransferRemainingBalance: {
    content: `
      <li>You'll get a <span>25-min trial lesson ($11.59) with Karen V.</span></li>
      <li>You'll still have <span>1 lesson ($7.36) with Daniela</span></li>
      <li>The remaining <span>$3.13 will be added to your Preply credit.</span> You'll see it at checkout during your next payment.</li>
    `,
    extraMessage: "Remaining balance with Daniela",
    extraPrice: "$16.00",
    buttonText: "Confirm transfer",
  },

  default: {
    content: `
      <li>You'll get <span>5 lessons ($24.84) with Daniela.</span></li>
      <li>The remaining <span>$4.60 will be added to your latingles credit</span>. You'll see it at checkout during your next payment.</li>
    `,
    extraMessage: "Remaining balance with Wade Warren",
    extraPrice: "$0.00",
    buttonText: "Confirm transfer",
  },
};

/**
 * Utility class for modal management
 */
class ModalManager {
  /**
   * Opens a modal based on configuration
   */
  static openModal(triggerElement, config) {
    const modal = elements[config.modal];
    const backdrop = elements[config.backdrop];

    if (config.usePositionDetection) {
      detectAndAdjustPosition(triggerElement, modal);
    }

    if (config.useModalStack) {
      ModalStackCreate(modal);
    }

    if (config.preventBubbling) {
      modal.addEventListener("click", (e) => e.stopPropagation());
    }

    PopupOpen(backdrop, modal, config.nested, config.nestedChild);
  }

  /**
   * Sets up event listeners for multiple elements
   */
  static setupMultipleListeners(elementKey, handler) {
    const elements_list = elements[elementKey];
    if (elements_list.length > 0) {
      elements_list.forEach((element, index) => {
        element.addEventListener("click", () => handler(element, index));
      });
    }
  }

  /**
   * Updates transfer modal content based on current state
   */
  static updateTransferModalContent() {
    let template;

    if (Variable.is6Lessons) {
      template = TRANSFER_MODAL_TEMPLATES.is6Lessons;
    } else if (Variable.isTransferRemainingBalance) {
      template = TRANSFER_MODAL_TEMPLATES.isTransferRemainingBalance;
    } else {
      template = TRANSFER_MODAL_TEMPLATES.default;
    }

    elements.whatHappensNextListContent.innerHTML = template.content;
    elements.reviewYourTransferModalExtraMessage.innerText =
      template.extraMessage;
    elements.reviewYourTransferModalExtraPrice.innerText = template.extraPrice;
    elements.transferCompleteModalOpen.innerText = template.buttonText;
  }
}

/**
 * Sets up transfer-related modal handlers
 */
function setupTransferModalHandlers() {
  // Transfer balance or subscription modal
  ModalManager.setupMultipleListeners(
    "anonymousTeacherFeedbackLastModalOpen",
    () => {
      ModalStackCreate(elements.anonymousTeacherFeedbackLastModal);
      PopupOpen(
        elements.backdropLevel2,
        elements.anonymousTeacherFeedbackLastModal,
        true
      );
    }
  );

  ModalManager.setupMultipleListeners(
    "successModalForProvidingFeedbackModalOpen",
    () => {
      ModalStackCreate(elements.successModalForProvidingFeedbackModal);
      PopupOpen(
        elements.backdropLevel2,
        elements.successModalForProvidingFeedbackModal,
        true
      );
    }
  );

  ModalManager.setupMultipleListeners(
    "transferBalanceOrSubscriptionModalOpen",
    () => {
      ModalStackCreate(elements.whatWouldYouLikeToDo);
      PopupOpen(elements.backdropLevel2, elements.whatWouldYouLikeToDo, true);
    }
  );

  ModalManager.setupMultipleListeners("anonymousFeedbackLastModalOpen", () => {
    ModalStackCreate(elements.anonymousFeedbackLastModal);
    PopupOpen(
      elements.backdropLevel2,
      elements.anonymousFeedbackLastModal,
      true
    );
  });

  // Transfer from modal with variable state management
  ModalManager.setupMultipleListeners(
    "transferFromModalOpen",
    (element, index) => {
      // Reset variables
      Variable.isTransferRemainingBalance = false;
      Variable.isTransferYourSubscriptionToAnotherTutor = false;

      switch (index) {
        case 1:
          Variable.isTransferRemainingBalance = true;
          break;
        case 2:
          Variable.isTransferYourSubscriptionToAnotherTutor = true;
          ModalStackCreate(elements.transferSubscriptionFromModal);
          PopupOpen(
            elements.backdropLevel2,
            elements.transferSubscriptionFromModal,
            true
          );
          return;
      }

      ModalStackCreate(elements.transferFromModal);
      PopupOpen(elements.backdropLevel2, elements.transferFromModal, true);
    }
  );

  // Transfer to modal
  ModalManager.setupMultipleListeners("transferToModalOpen", () => {
    const modal = Variable.isTransferRemainingBalance
      ? elements.transferRemainingBalanceTransferTo
      : elements.transferToModal;

    ModalStackCreate(modal);
    PopupOpen(elements.backdropLevel2, modal, true);
  });

  // Review transfer modal with dynamic content
  ModalManager.setupMultipleListeners("reviewYourTransferModalOpen", () => {
    ModalStackCreate(elements.reviewYourTransferModal);
    ModalManager.updateTransferModalContent();
    PopupOpen(elements.backdropLevel2, elements.reviewYourTransferModal, true);
  });

  // Transfer complete modal V1
  ModalManager.setupMultipleListeners("transferCompleteModalOpenV1", () => {
    Variable.is6Lessons = false;
    Variable.isTransferRemainingBalance = false;
    ModalStackCreate(elements.confirmPaymentModal);
    PopupOpen(elements.backdropLevel2, elements.transferCompleteModal, true);
  });

  // Other transfer-related modals
  const transferModalConfigs = [
    "HowManyLessonsYouWantModalOpen",
    "transferSubscriptionToModalOpen",
    "alsoTransferRemainingBalanceModalOpen",
    "transferSubscriptionReviewTransferModalOpen",
    "chooseYourTrialLessonDurationModalOpen",
  ];

  transferModalConfigs.forEach((configKey) => {
    const modalKey = configKey.replace("Open", "");
    ModalManager.setupMultipleListeners(configKey, () => {
      ModalStackCreate(elements[modalKey]);
      PopupOpen(elements.backdropLevel2, elements[modalKey], true);
    });
  });
}

/**
 * Sets up position-based modal handlers
 */
function setupPositionBasedModals() {
  // Class options modal
  ModalManager.setupMultipleListeners("classOptionsModalOpen", (element) => {
    detectAndAdjustPosition(element, elements.classOptionsModal);
    PopupOpen(elements.backdropLevel1, elements.classOptionsModal);
  });

  // Lesson setting modal
  ModalManager.setupMultipleListeners("lessonSettingModalOpen", (element) => {
    detectAndAdjustPosition(element, elements.lessonSettingModal);
    PopupOpen(elements.backdropLevel1, elements.lessonSettingModal);
  });
}

/**
 * Main function to set up all modal listeners
 */
function OpenModalListener() {
  // Setup simple modals from configuration
  Object.entries(MODAL_CONFIG).forEach(([triggerKey, config]) => {
    const triggerElement = elements[triggerKey];
    if (triggerElement) {
      triggerElement.addEventListener("click", () => {
        ModalManager.openModal(triggerElement, config);
      });
    }
  });

  // Setup complex modal handlers
  Object.entries(COMPLEX_MODAL_HANDLERS).forEach(([triggerKey, handler]) => {
    const triggerElement = elements[triggerKey];
    if (triggerElement) {
      triggerElement.addEventListener("click", handler);
    }
  });

  // Setup specialized handlers
  setupTransferModalHandlers();
  setupPositionBasedModals();
}

export default OpenModalListener;

// ====================================================
// ===================== END =========================
