function setProgress(percentage) {
  const circle = document.querySelector(".progress-ring__circle");
  // const radius = circle.r.baseVal.value; // 20 (new radius)
  // const circumference = 2 * Math.PI * radius; // 125.6

  // circle.style.strokeDasharray = `${circumference} ${circumference}`;
  // circle.style.strokeDashoffset = circumference;

  // const offset = circumference - (percentage / 100) * circumference;
  // circle.style.strokeDashoffset = offset;

  // document.querySelector(".progress-text").textContent = `${percentage}%`;
}

// Example: Set progress to 100%
setProgress(100);

const querySelectorElement = (e) => document.querySelector(e);
const querySelectorElements = (e) => document.querySelectorAll(e);

const elements = {
  subLevelOpen: querySelectorElement(".subLevelOpen"),
  sub_level: querySelectorElement(".sub_level"),
  userOptionOpen: querySelectorElements(".userOptionOpen"),
  userOptions: querySelectorElement(".userOptions"),
  backdrop: querySelectorElement(".backdrop"),
  backdrop_nested: querySelectorElement(".backdrop_nested"),
  shareTutor_popup: querySelectorElement(".shareTutor"),
  shareTutoOpen: querySelectorElement(".shareTutorOpen"),
  shareTutor_close_icon: querySelectorElement(".shareTutor_close_icon"),
  changePlaneBox: querySelectorElement(".changePlaneBox"),
  btnToContinueChangePlane: querySelectorElement(".btnToContinueChangePlane"),
  cancel_popup_open: querySelectorElement(".cancel_popup_open"),
  cancel_lesson_popup: querySelectorElement(".cancel_lesson_popup"),
  cancel_lesson_popup_close: querySelectorElement(
    ".cancel_lesson_popup .closeIcon"
  ),
  reshedule_popup_open: querySelectorElement(".reshedule_popup_open"),
  resheduleLesson_popup: querySelectorElement(".resheduleLesson_popup"),
  resheduleLesson_popup_closeIcon: querySelectorElement(
    ".resheduleLesson_popup .closeIcon"
  ),
  change_your_plane_popup: querySelectorElement(".change_your_plane_popup"),
  change_your_plane_popup_close: querySelectorElement(
    ".change_your_plane_popup .closeIcon"
  ),
  upgrade_now_popup_open: querySelectorElement(".btnToContinueChangePlane"),
  upgrade_now_popup: querySelectorElement(".upgradeNow_popup"),
  upgrade_now_popup_close: querySelectorElement(".upgradeNow_popup .closeIcon"),
  upgrade_now_popup_back: querySelectorElement(".upgradeNow_popup .backArrow"),

  review_your_changes_popupOpen: querySelectorElement(
    ".review_your_changes_popupOpen"
  ),
  review_your_changes_popup: querySelectorElement(".review_your_changes_popup"),
  review_your_changes_popup_close: querySelectorElement(
    ".review_your_changes_popup .closeIcon"
  ),
  review_your_changes_popup_back: querySelectorElement(
    ".review_your_changes_popup .backArrow"
  ),
  great_popup_open: querySelectorElement(".great_popup_open"),
  great_popup: querySelectorElement(".great_popup"),
  great_popup_close: querySelectorElement(".great_popup .closeIcon"),
  great_popup_closeButton: querySelectorElement(
    ".great_popup .great_popup_closeButton"
  ),
  toaster: querySelectorElement(".toaster"),
  toasterText: querySelectorElement(".toaster p"),
  resheduleContinueBTN: querySelectorElement(".resheduleContinueBTN"),
  secondLayerBackdropClose: querySelectorElements(".secondLayerBackdropClose"),
  subscription_dropdown_options: querySelectorElement(
    ".subscription_dropdown_options"
  ),
  subscription_dropdown_options_open: querySelectorElements(
    ".subscription_dropdown_options_open"
  ),
  addExtraLessonsModalOpen: querySelectorElement(".addExtraLessonsModalOpen"),
  extraLesson: querySelectorElement(".extraLesson"),
  extraLesson_increment: querySelectorElement(".extraLesson .increment"),
  extraLesson_decrement: querySelectorElement(".extraLesson .decrement"),
  extraLesson_value: querySelectorElement(".extraLesson .value h1"),
  after_increment_and_decrement_value: querySelectorElement(
    ".after_increment_and_decrement_value"
  ),
  firstLayerBackdropClose: querySelectorElements(".firstLayerBackdropClose"),
  confirm_payment_modal_open: querySelectorElement(
    ".confirm_payment_modal_open"
  ),
  confirm_payment_modal: querySelectorElement(".confirm_payment"),
  confirm_payment_modal_goBack: querySelectorElement(
    ".confirm_payment .goBack"
  ),

  extraLesson_count: querySelectorElement(".extraLesson_count"),
  totalLessonAmount: querySelectorElement(".totalLessonAmount"),
  totalLesson_amountWithProcessingFee: querySelectorElement(
    ".totalLesson_amountWithProcessingFee"
  ),
  totalAmountShowInBtn: querySelectorElement(".totalAmountShowInBtn"),

  selectGroup_titleChange: querySelectorElement(".selectGroup_titleChange"),

  whichTutorModal: querySelectorElement(".whichTutor"),
  whichTutorModal_open: querySelectorElement(".whichTutor_open"),

  subscribePopupOpen: querySelectorElement(".subscribePopupOpen"),
  subscribePopup: querySelectorElement(".subscribePopup"),

  teacherBoxOpen: querySelectorElements(".balanceModal .topPart .teacherBox"),
  teacherBoxes: querySelectorElements(".balanceModal .bottomPart .box01"),

  balanceModalOpen: querySelectorElement(".balanceModalOpen"),
  balanceModal: querySelectorElement(".balanceModal"),

  languageAndCurrencyDropdownOpen: querySelectorElement(
    ".languageAndCurrencyDropdownOpen"
  ),
  languageDropdown_options: querySelectorElement(".languageDropdown_options"),

  languageDropdown_options_language: querySelectorElements(
    ".languageDropdown_options .language"
  ),

  notificationModalOpen: querySelectorElement(".notificationModalOpen"),
  notificationModal: querySelectorElement(".notificationModal"),

  transferLessons_subscription_modalOpen: querySelectorElements(
    ".transferLessons_subscription_modalOpen"
  ),
  transferLessons_subscription: querySelectorElement(
    ".transferLessons_subscription"
  ),

  tellUsWhy_options_option: querySelectorElements(
    ".tellUsWhy .options .option"
  ),
  otherAsync: querySelectorElement(".otherAsync"),
  otherAsyncTextarea: querySelectorElement(".otherAsyncTextarea"),
  tellUsWhyBTN: querySelectorElement(".tellUsWhy button"),

  transferLessonsOpen: querySelectorElement(".transferLessonsOpen"),
  transferLessons: querySelectorElement(".transferLessons"),

  messageModalOpen: querySelectorElement(".messageModalOpen"),
  messagesModal: querySelectorElement(".messagesModal"),

  reviewYourTransfer: querySelectorElement(".reviewYourTransfer"),

  profileSettingOptions_Open: querySelectorElement(
    ".profileSettingOptions_Open"
  ),
  profileSettingOptions: querySelectorElement(".profileSettingOptions"),

  ArchiveTutor_open: querySelectorElements(".ArchiveTutor_open"),
  ArchiveTutor: querySelectorElements(".ArchiveTutor"),

  messageCard: querySelectorElements(
    ".messagesModal .message_BottomArea .all .card"
  ),
  messageBox: querySelectorElement(".messageBox"),

  messageBoxGoBack: querySelectorElement(".messageBox .goBack"),
};

// Variables
let openContainer = null;
let openNestedContainer = null;
let extraLessonCount = 1;
let isOtherOptionSelected = false;

// messageCard

// elements.messageBoxGoBack.addEventListener("click", () => {
//   elements.messagesModal.classList.add("active");
//   elements.messageBox.classList.remove("active");
//   openContainer = elements.messagesModal;
// });

// elements.messageCard.forEach((e) =>
//   e.addEventListener("click", () => {
//     elements.messagesModal.classList.remove("active");
//     elements.messageBox.classList.add("active");
//     openContainer = elements.messageBox;
//     elements.messageBox.addEventListener("click", (e) => e.stopPropagation());
//   })
// );

// ArchiveTutor

let archiveTutorIndex = NaN;

elements.ArchiveTutor_open.forEach((element, index) => {
  element.addEventListener("click", (event) => {
    // elements.ArchiveTutor_open.forEach((e, i) => {elements.ArchiveTutor[i].classList.remove("active"); elements.messageCard[i].classList.remove("active");});

    event.stopPropagation();

    archiveTutorIndex = index;
    elements.ArchiveTutor[index].classList.toggle("active");
    elements.messageCard[index].classList.toggle("active");
  });
});

window.addEventListener("click", (event) => {
  if (archiveTutorIndex) {
    console.log(event.target);
  }
});

// Helper function to remove 'active' class from elements
const removeActiveClass = (elements, subSelector = null) => {
  elements.forEach((el) => {
    el.classList.remove("active");
    if (subSelector) el.querySelector(subSelector)?.classList.remove("active");
  });
};

// Other Option Textarea Click Event
elements.otherAsyncTextarea.addEventListener("click", () => {
  removeActiveClass(elements.tellUsWhy_options_option, ".circle");

  elements.otherAsync.classList.add("active");
  elements.otherAsyncTextarea.classList.add("hide");
  elements.otherAsync.focus();

  updateTellUsWhyButton(); // Function call to check initial state

  isOtherOptionSelected = true;
});

// Listen for input event to check textarea value dynamically
elements.otherAsync.addEventListener("input", updateTellUsWhyButton);

function updateTellUsWhyButton() {
  if (elements.otherAsync.value.trim().length > 0) {
    elements.tellUsWhyBTN.classList.add("active");
  } else {
    elements.tellUsWhyBTN.classList.remove("active");
  }
}

// Options Click Event
elements.tellUsWhy_options_option.forEach((option, index) => {
  option.addEventListener("click", () => {
    removeActiveClass(elements.tellUsWhy_options_option, ".circle");

    if (isOtherOptionSelected) {
      elements.otherAsync.classList.remove("active");
      elements.otherAsyncTextarea.classList.remove("hide");
      isOtherOptionSelected = false;
    }

    option.classList.add("active");
    option.querySelector(".circle").classList.add("active");
    elements.tellUsWhyBTN.classList.add("active");
  });
});

// Teacher Box Click Event
elements.teacherBoxOpen.forEach((box, index) => {
  box.addEventListener("click", () => {
    removeActiveClass(elements.teacherBoxOpen);
    removeActiveClass(elements.teacherBoxes);

    elements.teacherBoxes[index].classList.add("active");
    box.classList.add("active");
  });
});

// extralesson increment and decrement
// ===================================
elements.extraLesson_increment.addEventListener("click", () => {
  extraLessonCount = extraLessonCount > 1 ? extraLessonCount - 1 : 1;
  elements.extraLesson_value.textContent = extraLessonCount;
  elements.after_increment_and_decrement_value.textContent =
    extraLessonCount * 5;
});

elements.extraLesson_decrement.addEventListener("click", () => {
  extraLessonCount = extraLessonCount >= 1 ? extraLessonCount + 1 : 1;
  elements.extraLesson_value.textContent = extraLessonCount;
  elements.after_increment_and_decrement_value.textContent =
    extraLessonCount * 5;
});
// =============== END ================

// level 1
document.querySelector(".subLevelOpen1").addEventListener("click", () => {
  document.querySelector("#level2").classList.remove("active");
  document.querySelector("#level3").classList.remove("active");
  document.querySelector("#level4").classList.remove("active");

  // add
  document.querySelector("#level1").classList.add("active");
});

// level 2
document.querySelector(".subLevelOpen2").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level3").classList.remove("active");
  document.querySelector("#level4").classList.remove("active");
  document.querySelector("#level5").classList.remove("active");

  // add
  document.querySelector("#level2").classList.add("active");
});

// level 3
document.querySelector(".subLevelOpen3").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level2").classList.remove("active");
  document.querySelector("#level4").classList.remove("active");
  document.querySelector("#level5").classList.remove("active");

  // add
  document.querySelector("#level3").classList.add("active");
});

// level 4
document.querySelector(".subLevelOpen4").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level2").classList.remove("active");
  document.querySelector("#level3").classList.remove("active");
  document.querySelector("#level5").classList.remove("active");

  // add
  document.querySelector("#level4").classList.add("active");
});

// level 4
document.querySelector(".subLevelOpen5").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level2").classList.remove("active");
  document.querySelector("#level3").classList.remove("active");
  document.querySelector("#level4").classList.remove("active");

  // add
  document.querySelector("#level5").classList.add("active");
});

// elements.subLevelOpen.addEventListener("click", () => {
//   elements.sub_level.classList.toggle("active");
// });

document
  .querySelector(".resheduleLesson .goBack")
  .addEventListener("click", () => {
    openNestedContainer = elements.change_your_plane_popup;

    elements.resheduleLesson_popup.classList.remove("active");
    elements.change_your_plane_popup.classList.toggle("active");
  });

elements.upgrade_now_popup_open.addEventListener("click", () => {
  openNestedContainer = elements.upgrade_now_popup;

  elements.change_your_plane_popup.classList.remove("active");
  elements.upgrade_now_popup.classList.toggle("active");
});

elements.review_your_changes_popupOpen.addEventListener("click", () => {
  openNestedContainer = elements.review_your_changes_popup;

  elements.upgrade_now_popup.classList.remove("active");
  elements.review_your_changes_popup.classList.toggle("active");
});

elements.great_popup_open.addEventListener("click", () => {
  openNestedContainer = elements.great_popup;

  elements.upgrade_now_popup.classList.remove("active");
  elements.great_popup.classList.toggle("active");
});

elements.upgrade_now_popup_back.addEventListener("click", () => {
  openNestedContainer = elements.change_your_plane_popup;

  elements.upgrade_now_popup.classList.remove("active");
  elements.change_your_plane_popup.classList.toggle("active");
});

elements.review_your_changes_popup_back.addEventListener("click", () => {
  openNestedContainer = elements.upgrade_now_popup;

  elements.review_your_changes_popup.classList.remove("active");
  elements.upgrade_now_popup.classList.toggle("active");
});

// detec and adjust position
// *************************
function detectAndAdjustPosition(elementGetPosition, modalToSetPosition) {
  const rect = elementGetPosition.getBoundingClientRect();
  // e]initial modal position
  let left = rect.left + window.scrollX;
  let top = rect.bottom + window.scrollY;

  // Get modal dimensions
  const modalWidth = modalToSetPosition.getBoundingClientRect().width; // Modal width
  const viewportWidth = window.innerWidth;

  // Check if modal goes out of the right boundary
  if (left + modalWidth > viewportWidth) {
    left = viewportWidth - modalWidth - 24; // scrollbar width (14px) and spacing from right (10px)
  }

  // if (window.innerWidth <= 600) {
  //   modalToSetPosition.style.top = `${top}px`;
  // } else {
  top = top - 100;
  left = left - 300;
  modalToSetPosition.style.top = `${top}px`;
  modalToSetPosition.style.left = `${left}px`;

  // }
}

function bgMoodle(control) {
  switch (control) {
    case true:
      document.getElementById("page").style.backgroundColor =
        "rgba(0, 0, 0, 0.180)";
      document.getElementById("s-page-footer").style.backgroundColor =
        "rgba(0, 0, 0, 0.010)";
      break;
    case false:
      document.getElementById("page").style.backgroundColor = "white";
      document.getElementById("s-page-footer").style.backgroundColor = "white";
      break;

    default:
      break;
  }
  // rgba(0, 0, 0, 0.180)
  // footer rgba(0, 0, 0, 0.010)
}

function detectAndAdjustPositionCustomDeiker(
  elementGetPosition,
  modalToSetPosition
) {
  const rect = elementGetPosition.getBoundingClientRect();
  // e]initial modal position
  let left = rect.left + window.scrollX;
  let top = rect.bottom + window.scrollY;

  // Get modal dimensions
  const modalWidth = modalToSetPosition.getBoundingClientRect().width; // Modal width
  const viewportWidth = window.innerWidth;

  // Check if modal goes out of the right boundary
  if (left + modalWidth > viewportWidth) {
    left = viewportWidth - modalWidth - 24; // scrollbar width (14px) and spacing from right (10px)
  }

  // if (window.innerWidth <= 600) {
  //   modalToSetPosition.style.top = `${top}px`;
  // } else {
  top = 1300;
  left = left + 50;
  modalToSetPosition.style.top = `${top}px`;
  modalToSetPosition.style.left = `${left}px`;

  // }
}

// ====================================================
// ===================== POPUP OPEN ====================
function popupOpen(backdropContainer, popup, nested) {
  if (nested) {
    openNestedContainer = popup;
  } else {
    openContainer = popup;
  }
  backdropContainer.classList.add("active");
  popup.classList.add("active");
  bgMoodle(true);
}

elements.userOptionOpen.forEach((e, i) =>
  e.addEventListener("click", () => {
    detectAndAdjustPosition(e, elements.userOptions);
    popupOpen(elements.backdrop, elements.userOptions);
  })
);
elements.subscription_dropdown_options_open.forEach((e, i) =>
  e.addEventListener("click", () => {
    detectAndAdjustPositionCustomDeiker(
      e,
      elements.subscription_dropdown_options
    );
    popupOpen(elements.backdrop, elements.subscription_dropdown_options);
  })
);

elements.transferLessons_subscription_modalOpen.forEach((e) =>
  e.addEventListener("click", () => {
    popupOpen(
      elements.backdrop_nested,
      elements.transferLessons_subscription,
      true
    );
  })
);

elements.shareTutoOpen.addEventListener("click", () =>
  popupOpen(elements.backdrop_nested, elements.shareTutor_popup, true)
);
elements.cancel_popup_open.addEventListener("click", () =>
  popupOpen(elements.backdrop_nested, elements.cancel_lesson_popup, true)
);
// elements.reshedule_popup_open.addEventListener("click", () =>
//   popupOpen(elements.backdrop_nested, elements.resheduleLesson_popup, true)
// );

elements.addExtraLessonsModalOpen.addEventListener("click", () =>
  popupOpen(elements.backdrop, elements.extraLesson)
);

// elements.profileSettingOptions_Open.addEventListener("click", () =>
//   popupOpen(elements.backdrop, elements.profileSettingOptions)
// );

// elements.messageModalOpen.addEventListener("click", () => {
//   elements.messagesModal.addEventListener("click", (e) => e.stopPropagation());
//   popupOpen(elements.backdrop, elements.messagesModal);
// });

// elements.balanceModalOpen.addEventListener("click", () =>
//   popupOpen(elements.backdrop, elements.balanceModal)
// );
// elements.notificationModalOpen.addEventListener("click", () => {
//   elements.notificationModal.addEventListener("click", (e) =>
//     e.stopPropagation()
//   );
//   popupOpen(elements.backdrop, elements.notificationModal);
// });

elements.languageDropdown_options_language.forEach(
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

// elements.languageAndCurrencyDropdownOpen.addEventListener("click", () =>
//   popupOpen(elements.backdrop, elements.languageDropdown_options)
// );
// elements.subscribePopupOpen.addEventListener("click", () =>
//   popupOpen(elements.backdrop, elements.subscribePopup)
// );
if (elements.whichTutorModal_open) {
  elements.whichTutorModal_open.addEventListener("click", () =>
    popupOpen(elements.backdrop, elements.whichTutorModal)
  );
}

elements.confirm_payment_modal_open.addEventListener("click", () => {
  elements.extraLesson_count.textContent = extraLessonCount;
  elements.totalLessonAmount.textContent = extraLessonCount * 5;
  elements.totalLesson_amountWithProcessingFee.textContent =
    extraLessonCount * 5 + 0.54;
  elements.totalAmountShowInBtn.textContent = extraLessonCount * 5 + 0.54;

  elements.extraLesson.classList.remove("active");
  popupOpen(elements.backdrop, elements.confirm_payment_modal);
});

elements.confirm_payment_modal_goBack.addEventListener("click", () => {
  elements.confirm_payment_modal.classList.remove("active");
  popupOpen(elements.backdrop, elements.extraLesson);
});

// ==================================================
// ===================== END =======================

// ====================================================
// ===================== POPUP CLOSE ====================
function closePopup(openPopup, backdropContainer) {
  backdropContainer.classList.remove("active");
  openPopup.classList.remove("active");
  bgMoodle(false);
}

elements.backdrop.addEventListener("click", () =>
  closePopup(openContainer, elements.backdrop)
);
elements.backdrop_nested.addEventListener("click", () =>
  closePopup(openNestedContainer, elements.backdrop_nested)
);

// ============================================================
elements.secondLayerBackdropClose.forEach((e) =>
  e.addEventListener("click", () =>
    closePopup(openNestedContainer, elements.backdrop_nested)
  )
);
elements.firstLayerBackdropClose.forEach((e) =>
  e.addEventListener("click", () => {
    closePopup(openContainer, elements.backdrop);
  })
);
// ============================================================

elements.changePlaneBox.addEventListener("click", () => {
  elements.changePlaneBox.classList.toggle("active");
  elements.btnToContinueChangePlane.classList.toggle("active");
});

// ==================================================
// ===================== END =======================

// Function to toggle dropdown
const toggleDropdown = (dropdownMenu) => {
  document.querySelectorAll(".dropdown-menu").forEach((menu) => {
    if (menu !== dropdownMenu) menu.classList.remove("active");
  });
  dropdownMenu.classList.toggle("active");
};

// Function to select an item
const selectItem = (item, buttonElement, dropdownMenu) => {
  buttonElement.textContent = item.textContent;
  dropdownMenu.classList.remove("active");
};

// Function to handle dropdown logic
const setupDropdown = (dropdownClass) => {
  const dropdownButton = document.querySelector(
    `.${dropdownClass} .dropdown-button`
  );
  const dropdownMenu = document.querySelector(
    `.${dropdownClass} .dropdown-menu`
  );
  const dropdownItems = dropdownMenu.querySelectorAll(".dropdown-item");

  dropdownButton.addEventListener("click", (e) => {
    e.stopPropagation(); // Prevent click from bubbling to window
    toggleDropdown(dropdownMenu);
  });

  dropdownItems.forEach((item) =>
    item.addEventListener("click", () => {
      selectItem(item, dropdownButton.querySelector("p"), dropdownMenu);
    })
  );
};

// Initialize all dropdowns
["time_dropdown", "limitedTime", "reasonOption"].forEach(setupDropdown);

// Close dropdown when clicking outside
window.addEventListener("click", () => {
  document.querySelectorAll(".dropdown-menu").forEach((menu) => {
    menu.classList.remove("active");
  });
});

// =====================================================
// ==================== COPY TEXT ======================

function copyText(element, steelElement) {
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

document.querySelectorAll(".copyLinkBTN").forEach((e) => {
  e.addEventListener("click", () => {
    e.style.pointerEvents = "none";
    copyText(document.getElementById("copyLinkText"), e);
  });
});

// =====================================================
// ==================== END ======================

// =========== transferLessons_subscription ==========
// ===================================================

const transferLessons_subscription_cards = document.querySelectorAll(
  ".transferLessons_subscription .cards .card"
);
const transferLessons_subscription_button = document.querySelector(
  ".transferLessons_subscription button"
);

const transferBalance_cards = document.querySelectorAll(
  ".transferBalance .cardsfrom .card"
);
const transferBalance_button = document.querySelector(
  ".transferBalance button"
);

const transferBalanceTo_cards = document.querySelectorAll(
  ".transferBalance .cardsTo .card"
);
const transferBalanceTo_button = document.querySelector(
  ".transferBalanceTo button"
);

let selectedCard = 0;

function selectedCardFunction(cards, button, storeData = false) {
  cards.forEach((card, index) => {
    card.addEventListener("click", () => {
      cards.forEach((e) => e.classList.remove("active"));
      card.classList.add("active");

      if (storeData) {
        selectedCard = index;
      }

      button.classList.add("active");
    });
  });
}

selectedCardFunction(
  transferLessons_subscription_cards,
  transferLessons_subscription_button,
  true
);

selectedCardFunction(transferBalance_cards, transferBalance_button);

selectedCardFunction(transferBalanceTo_cards, transferBalanceTo_button);

const transferLessons_subscription_btn_ModalOpen = document.querySelector(
  ".transferLessons_subscription_btn_ModalOpen"
);
const transferBalance = document.querySelector(".transferBalance");

const transferBalanceFrom_ModalOpen = document.querySelector(
  ".transferBalanceFrom_ModalOpen"
);
const transferBalanceTo = document.querySelector(".transferBalanceTo");

const transferBalance_backBTN = transferBalance.querySelector(".backButton");
const transferBalanceTo_backBTN =
  transferBalanceTo.querySelector(".backButton");

const tellUsWhyOpen = document.querySelector(".tellUsWhyOpen");
const tellUsWhy = document.querySelector(".tellUsWhy");
const tellUsWhyBackBTN = tellUsWhy.querySelector(".backButton");

const transferCompleteOpen = document.querySelector(".transferCompleteOpen");
const TransferComplete = document.querySelector(".TransferComplete");

const transferLessons_backButton = document.querySelector(
  ".transferLessons .backButton"
);

const reviewYourTransfer_backButton = document.querySelector(
  ".reviewYourTransfer .backButton"
);

transferLessons_subscription_btn_ModalOpen.addEventListener("click", () => {
  elements.transferLessons_subscription.classList.remove("active");

  popupOpen(elements.backdrop_nested, transferBalance, true);
  if (selectedCard === 1 || selectedCard === 0) {
    transferBalance.querySelector(".heading").textContent = "Transfer Lessons";
  } else if (selectedCard === 2) {
    transferBalance.querySelector(".heading").textContent =
      "Transfer Subscription";
  }
});

transferBalanceFrom_ModalOpen.addEventListener("click", () => {
  transferBalance.classList.remove("active");
  popupOpen(elements.backdrop_nested, transferBalanceTo, true);
  if (selectedCard === 1 || selectedCard === 0) {
    transferBalanceTo.querySelector(".heading").textContent =
      "Transfer Lessons";
  } else if (selectedCard === 2) {
    transferBalanceTo.querySelector(".heading").textContent =
      "Transfer Subscription";
  }
});

transferBalance_backBTN.addEventListener("click", () => {
  openNestedContainer = elements.transferLessons_subscription;

  transferBalance.classList.remove("active");
  elements.transferLessons_subscription.classList.add("active");
});
transferBalanceTo_backBTN.addEventListener("click", () => {
  openNestedContainer = transferBalance;

  transferBalanceTo.classList.remove("active");
  transferBalance.classList.add("active");
});

elements.transferLessonsOpen.addEventListener("click", () => {
  if (selectedCard === 1) {
    const thumb = document.querySelector(".slider-thumb");
    const track = document.querySelector(".slider-track");
    const lessonCount = document.getElementById("lessonCount");
    const accortingLessonTexts = document.querySelector(
      ".accortingLessonTexts"
    );
    const fromLessonAndAmount = document.querySelector(".fromLessonAndAmount");
    const toLessonAndAmount = document.querySelector(".toLessonAndAmount");
    const lessonFromBox = document.querySelector(".lessonFromBox");
    const lessonToBox = document.querySelector(".lessonToBox");
    const shortDetail_fromUser = document.querySelector(
      ".shortDetail_fromUser"
    );
    const shortDetail_toUser = document.querySelector(".shortDetail_toUser");
    const extraContent_ofTransferLessons = document.querySelector(
      ".extraContent_ofTransferLessons"
    );
    const lessonDetailBox = document.querySelector(".lessonDetailBox");

    let min = 0,
      max = 5,
      step = 1;
    let value = min;

    track.parentElement.addEventListener("click", function (event) {
      let rect = track.parentElement.getBoundingClientRect();
      let offsetX = event.clientX - rect.left;
      let percent = Math.max(0, Math.min(1, offsetX / rect.width));
      let newValue = Math.round(percent * (max - min)) + min;

      if (newValue !== value) {
        value = newValue;
        updateSlider(value);
      }
    });

    function accortingLessonTextsFn(val) {
      switch (val) {
        case 0:
          tellUsWhyOpen.style.display = "none";
          lessonDetailBox.style.display = "none";
          shortDetail_fromUser.innerHTML = "0 lesson";
          break;
        case 1:
          accortingLessonTexts.innerHTML = `<p>Your tutors have different lesson prices, so when you
          transfer <span>1 lesson from Dinela ($5.18/lesson)</span>, you will need to cover a price difference of <span>$2.50 to get 1 lesson with Chloe ($7.68/lesson)</span></p>`;
          fromLessonAndAmount.textContent = "1 lesson · $5.18";
          toLessonAndAmount.textContent = "1 lesson · $7.68";
          lessonFromBox.innerHTML = "<div></div>";
          lessonToBox.innerHTML = "<div></div>";
          shortDetail_fromUser.innerHTML = "1 lesson";
          shortDetail_toUser.innerHTML =
            "<span>$2.50 to pay</span> for a full lesson";
          extraContent_ofTransferLessons.style.display = "none";
          extraContent_ofTransferLessons.textContent = "";
          tellUsWhyOpen.style.display = "flex";
          lessonDetailBox.style.display = "flex";
          break;
        case 2:
          accortingLessonTexts.innerHTML = `<p>Your tutors have different lesson prices, so when you
          transfer <span> 2 lessons from Dinela ($5.18/lesson)</span>, you’ll get <span> 1 lesson with Marbe B. ($7.68/lesson)</span></p>`;
          fromLessonAndAmount.textContent = "2 lessons · $10.37";
          toLessonAndAmount.textContent = "1 lesson · $7.68";
          lessonFromBox.innerHTML = "<div></div><div></div>";
          lessonToBox.innerHTML = "<div></div>";
          shortDetail_fromUser.innerHTML = "2 lesson";
          shortDetail_toUser.innerHTML =
            " 1 lesson <span> + $2.69 credit</span>";
          extraContent_ofTransferLessons.style.display = "block";
          extraContent_ofTransferLessons.textContent =
            "The remaining $2.69 will be saved as credit you can use forfuture payments.";
          tellUsWhyOpen.style.display = "flex";
          lessonDetailBox.style.display = "flex";
          break;
        case 3:
          accortingLessonTexts.innerHTML = `<p>Your tutors have different lesson prices, so when you
          transfer <span>  3 lessons from Dinela ($5.18/lesson)</span>, you’ll get <span> 2 lesson with Marbe B. ($7.68/lesson)</span></p>`;
          fromLessonAndAmount.textContent = "3 lessons · $15.55";
          toLessonAndAmount.textContent = "2 lessons · $15.36";
          lessonFromBox.innerHTML = "<div></div><div></div><div></div>";
          lessonToBox.innerHTML = "<div></div><div></div>";
          shortDetail_fromUser.innerHTML = "3 lesson";
          shortDetail_toUser.innerHTML =
            " 2 lessons <span>+ $0.19 credit </span>";
          extraContent_ofTransferLessons.style.display = "block";
          extraContent_ofTransferLessons.textContent =
            "The remaining $0.19 will be saved as credit you can use forfuture payments.";
          tellUsWhyOpen.style.display = "flex";
          lessonDetailBox.style.display = "flex";
          break;
        case 4:
          accortingLessonTexts.innerHTML = `<p>Your tutors have different lesson prices, so when you
          transfer  <span> 4 lessons from Dinela ($5.18/lesson)</span>, you’ll get <span> 3 lesson with Marbe B. ($7.68/lesson)</span></p>`;
          fromLessonAndAmount.textContent = "4 lessons · $20.74";
          toLessonAndAmount.textContent = "3 lessons · $23.04";
          lessonFromBox.innerHTML =
            "<div></div><div></div><div></div><div></div>";
          lessonToBox.innerHTML = "<div></div><div></div><div></div>";
          shortDetail_fromUser.innerHTML = "4 lesson";
          shortDetail_toUser.innerHTML =
            "<span>$2.30 to pay .</span> 3 lessons";
          extraContent_ofTransferLessons.style.display = "none";
          extraContent_ofTransferLessons.textContent = "";
          tellUsWhyOpen.style.display = "flex";
          lessonDetailBox.style.display = "flex";
          break;
        case 5:
          accortingLessonTexts.innerHTML = `<p>Your tutors have different lesson prices, so when you
          transfer <span> 5 lessons from Dinela ($5.18/lesson)</span>, you’ll get <span> 4 lesson with Marbe B. ($7.68/lesson)</span></p>`;
          fromLessonAndAmount.textContent = "5 lessons · $25.92";
          toLessonAndAmount.textContent = "3 lessons · $23.04";
          lessonFromBox.innerHTML =
            "<div></div><div></div><div></div><div></div><div></div>";
          lessonToBox.innerHTML =
            "<div></div><div></div><div></div><div></div>";
          shortDetail_fromUser.innerHTML = "4 lesson";
          shortDetail_toUser.innerHTML =
            "<span>$2.30 to pay .</span> 4 lessons";
          extraContent_ofTransferLessons.style.display = "none";
          extraContent_ofTransferLessons.textContent = "";
          tellUsWhyOpen.style.display = "flex";
          lessonDetailBox.style.display = "flex";
          break;
        default:
          accortingLessonTexts.textContent = "";
      }
    }

    function updateSlider(val) {
      let percentage = ((val - min) / (max - min)) * 100;
      thumb.style.left =
        percentage > 0 ? `calc(${percentage}% - 31px)` : `${percentage}%`;
      track.style.width = `${percentage}%`;
      lessonCount.textContent = `${val} Lesson${val > 1 ? "s" : ""}`;
      accortingLessonTextsFn(val);
    }

    thumb.addEventListener("mousedown", function (event) {
      event.preventDefault();
      function move(event) {
        let rect = track.parentElement.getBoundingClientRect();
        let offsetX = event.clientX - rect.left;
        let percent = Math.max(0, Math.min(1, offsetX / rect.width));
        let newValue = Math.round(percent * (max - min)) + min;
        if (newValue !== value) {
          value = newValue;
          updateSlider(value);
        }
      }
      function stop() {
        document.removeEventListener("mousemove", move);
        document.removeEventListener("mouseup", stop);
      }
      document.addEventListener("mousemove", move);
      document.addEventListener("mouseup", stop);
    });

    updateSlider(value);
  }

  if (selectedCard === 2) {
    openNestedContainer = elements.reviewYourTransfer;
    elements.reviewYourTransfer.classList.add("active");
  } else {
    openNestedContainer = elements.transferLessons;
    elements.transferLessons.classList.add("active");
  }

  transferBalanceTo.classList.remove("active");
});

transferLessons_backButton.addEventListener("click", () => {
  openNestedContainer = transferBalanceTo;

  elements.transferLessons.classList.remove("active");
  transferBalanceTo.classList.add("active");
});

reviewYourTransfer_backButton.addEventListener("click", () => {
  openNestedContainer = transferBalanceTo;

  elements.reviewYourTransfer.classList.remove("active");
  transferBalanceTo.classList.add("active");
});

tellUsWhyOpen.addEventListener("click", () => {
  openNestedContainer = tellUsWhy;

  elements.transferLessons.classList.remove("active");

  // elements.change_your_plane_popup.classList.remove("active");
  tellUsWhy.classList.add("active");
});

tellUsWhyBackBTN.addEventListener("click", () => {
  openNestedContainer = elements.transferLessons;

  tellUsWhy.classList.remove("active");
  elements.transferLessons.classList.add("active");
});

transferCompleteOpen.addEventListener("click", () => {
  // debugger;
  openNestedContainer = TransferComplete;

  tellUsWhy.classList.remove("active");

  // elements.change_your_plane_popup.classList.remove("active");
  TransferComplete.classList.add("active");
});

(function () {
  const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
  const $ = (sel, ctx = document) => ctx.querySelector(sel);

  // ====== Elements ======
  const backdrop = $("[data-subscribe-modal]");
  const openers = $$(".subscribe-modal-open");
  const closeBtns = $$("[data-subscribe-close]");
  const planRadios = $$('input[name="plan"]');

  // Summary targets
  const summaryTitleEl = $(".plan-title-section h4");
  const summaryLineEl = $(".plan-title-section p b");
  const scheduledP = $(".features-list .feature-item p");

  // ✅ Use the actual ID present in your HTML
  const customSelector =
    $("#plan-selector") || document.querySelector('[id*="plan-selector" i]');

  // Custom selector sub-elements (scoped to the section)
  const customDropdownBtn = customSelector?.querySelector(".plan-dropdown");
  const customDropdownValue = customSelector?.querySelector(
    ".plan-dropdown-value"
  ); // the "12" in the pill
  const customDurationNum = customSelector?.querySelector(
    ".plan-details .duration-number"
  ); // big "12"
  const customPriceAmount = customSelector?.querySelector(
    ".plan-pricing .price-amount"
  ); // "$180.00"
  const customPriceDesc = customSelector?.querySelector(
    ".plan-pricing .price-description"
  ); // "charged per 12 Month"
  const planBadge = customSelector?.querySelector(".plan-pricing .plan-badge"); // optional
  const pricingOptions = customSelector?.querySelector("#pricing-options"); // dropdown list container (keep it inside the section)

  // ====== Plan map for preset radios ======
  const PLAN_MAP = {
    "plan-1": { months: 1, price: 36.0, label: "1 Month" },
    "plan-4": { months: 4, price: 72.0, label: "4 Months" },
    "plan-6": { months: 6, price: 108.0, label: "6 Months" },
    "plan-9": { months: 9, price: 144.0, label: "9 Months" },
    "plan-12": { months: 12, price: 180.0, label: "12 Months" },
    "plan-custom": { months: null, price: null, label: "Custom plan" },
  };

  // ====== Utils ======
  function money(n) {
    return `$${Number(n).toFixed(2)}`;
  }

  // ✅ Fix regex: use a real regex literal and \d
  function parseMonthsFromText(txt) {
    const m = String(txt).match(/(\d+)\s*Month/i);
    return m ? Number(m[1]) : null;
  }

  function parsePriceFromText(txt) {
    const clean = String(txt).replace(/[^\d.]/g, "");
    return clean ? Number(clean) : null;
  }

  // ====== Modal controls (unchanged) ======
  function openModal() {
    backdrop?.classList.add("is-open");
    document.body.style.overflow = "hidden";
  }
  function closeModal(modal) {
    backdrop?.classList.remove("is-open");
    modal.classList.remove("active");
    document.body.style.overflow = "";
    closePricingOptions(); // safety
  }
  openers.forEach((btn) =>
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      openModal();
    })
  );
  closeBtns.forEach((btn) => btn.addEventListener("click", closeModal));
  backdrop?.addEventListener("click", (e) => {
    if (e.target === backdrop) closeModal();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      if (isPricingOpen()) closePricingOptions();
      else closeModal();
    }
  });

  // ====== Pricing dropdown controls ======
  function isPricingOpen() {
    return pricingOptions?.classList.contains("is-open");
  }
  function openPricingOptions() {
    if (!pricingOptions) return;
    pricingOptions.hidden = false;
    pricingOptions.classList.add("is-open");
    document.addEventListener("click", outsideCloseHandler, { capture: true });
  }
  function closePricingOptions() {
    if (!pricingOptions) return;
    pricingOptions.hidden = true;
    pricingOptions.classList.remove("is-open");
    document.removeEventListener("click", outsideCloseHandler, {
      capture: true,
    });
  }
  function togglePricingOptions() {
    if (!pricingOptions) return;
    isPricingOpen() ? closePricingOptions() : openPricingOptions();
  }
  function outsideCloseHandler(e) {
    if (!pricingOptions) return;
    const clickInsideList = pricingOptions.contains(e.target);
    const clickOnButton = customDropdownBtn?.contains(e.target);
    if (!clickInsideList && !clickOnButton) closePricingOptions();
  }

  // Wire dropdown button
  customDropdownBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    togglePricingOptions();
  });
  customDropdownBtn?.addEventListener("keydown", (e) => {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      togglePricingOptions();
    }
  });

  // Handle item selection from dropdown list
  pricingOptions?.addEventListener("click", (e) => {
    const item = e.target.closest(".pricing-item");
    if (!item) return;

    // prevent the document click handler from running after selection
    e.preventDefault();
    e.stopPropagation();

    const labelEl = item.querySelector(".item-label");
    const priceEl = item.querySelector(".item-price");

    const months = parseMonthsFromText(labelEl?.textContent || "");
    const price = parsePriceFromText(priceEl?.textContent || "");
    if (!months || !price) return;

    // Update UI
    if (customDropdownValue) customDropdownValue.textContent = String(months);
    if (customDurationNum) customDurationNum.textContent = String(months);
    if (customPriceAmount) customPriceAmount.textContent = money(price);
    if (customPriceDesc)
      customPriceDesc.textContent = `charged per ${months} Month`;

    const customRadio = $("#plan-custom");
    if (customRadio && !customRadio.checked) {
      customRadio.checked = true;
      syncCustomVisibility("plan-custom");
    }

    updateSummaryCustom(months, price);

    // Close dropdown (use rAF so updates paint first)
    requestAnimationFrame(closePricingOptions);
  });

  document.addEventListener("click", outsideCloseHandler, { capture: true });

  // ====== Show/hide custom selector with plan choice ======
  function openCustom() {
    if (!customSelector) return;
    customSelector.hidden = false;
    customSelector.classList.add("is-visible");
    customSelector.setAttribute("aria-hidden", "false");
    customDropdownBtn?.focus({ preventScroll: false });
    $(".plan-title-section").style.display = "none";
    customSelector.scrollIntoView({ behavior: "smooth", block: "nearest" });
  }
  function closeCustom() {
    if (!customSelector) return;
    customSelector.hidden = true;
    customSelector.classList.remove("is-visible");
    customSelector.setAttribute("aria-hidden", "true");
    $(".plan-title-section").style.display = "block";
    closePricingOptions();
  }
  function syncCustomVisibility(planId) {
    if (planId === "plan-custom") openCustom();
    else closeCustom();
  }

  // ====== Summary updater ======
  function updateSummaryCustom(months, price) {
    if (summaryTitleEl) summaryTitleEl.textContent = `${months} Months Plan`;
    if (summaryLineEl)
      summaryLineEl.textContent = `${months} Months Plan at ${money(price)}.`;
    if (scheduledP) {
      scheduledP.innerHTML = scheduledP.innerHTML.replace(
        /scheduled for <b>.*?<\/b>/,
        `scheduled for <b>${months} Months</b>`
      );
    }
  }

  function updateSummaryById(planId) {
    const plan = PLAN_MAP[planId];
    if (!plan) return;

    if (planId === "plan-custom") {
      const months = parseInt(customDurationNum?.textContent || "", 10);
      const price = parsePriceFromText(customPriceAmount?.textContent || "");
      if (months && price) {
        updateSummaryCustom(months, price);
      } else {
        if (summaryTitleEl) summaryTitleEl.textContent = "Custom Plan";
        if (summaryLineEl)
          summaryLineEl.textContent = "Choose a custom number of months.";
        if (scheduledP) {
          scheduledP.innerHTML = scheduledP.innerHTML.replace(
            /scheduled for .*?<\/b>/,
            "scheduled for <b>your chosen duration</b>"
          );
        }
      }
      return;
    }

    const { months, price, label } = plan;
    if (summaryTitleEl) summaryTitleEl.textContent = `${label} Plan`;
    if (summaryLineEl)
      summaryLineEl.textContent = `${label} Plan at ${money(price)}.`;
    if (scheduledP) {
      scheduledP.innerHTML = scheduledP.innerHTML.replace(
        /scheduled for <b>.*?<\/b>/,
        `scheduled for <b>${months} Months</b>`
      );
    }
  }

  // ====== Wire up radios ======
  planRadios.forEach((r) => {
    r.addEventListener("change", () => {
      if (r.checked) {
        updateSummaryById(r.id);
        syncCustomVisibility(r.id);
      }
    });
  });

  // ====== Init ======
  // Hide custom selector unless custom is selected
  const initial = planRadios.find((r) => r.checked) || planRadios[0];
  if (initial) {
    updateSummaryById(initial.id);
    syncCustomVisibility(initial.id);
  } else {
    // no radio? just hide custom UI by default
    closeCustom();
  }

  // ===== Promo code toggle =====
  const promoLink = document.querySelector(".promo-link");
  const promoRow = document.querySelector(".promo-row");
  const promoInput = document.getElementById("promo-input");
  const promoApply = document.querySelector(".promo-apply");

  if (promoLink && promoRow && promoInput && promoApply) {
    promoLink.addEventListener("click", (e) => {
      e.preventDefault();
      promoLink.setAttribute("hidden", ""); // hide the link
      promoRow.hidden = false; // show the input+button
      promoInput.focus(); // focus the input
    });

    promoApply.addEventListener("click", () => {
      const code = promoInput.value.trim();
      if (!code) {
        promoInput.focus();
        return;
      }
      // TODO: replace with your real apply-code call
      // Example: applyPromo(code).then(...).catch(...)
      console.log("Applying promo code:", code);
    });

    // Allow Enter key in the input to trigger Apply
    promoInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        promoApply.click();
      }
    });
  }

  // ===== Payment dropdown =====
  const selectorBtn = document.querySelector(".payment-selector");
  const menu = document.querySelector(".payment-menu");
  const options = menu
    ? Array.from(menu.querySelectorAll(".payment-option"))
    : [];
  const numberSpan = document.querySelector(".card-number"); // in the button
  let menuOpen = false;
  let activeIndex = -1;

  function openMenu() {
    if (!selectorBtn || !menu) return;
    menu.hidden = false;
    menuOpen = true;
    selectorBtn.setAttribute("aria-expanded", "true");
    selectorBtn.setAttribute("aria-haspopup", "listbox");
    // Focus the first option by default
    setActive(0);
    options[0]?.focus();
    document.addEventListener("click", onDocumentClick);
    document.addEventListener("keydown", onKeydown);
  }

  function closeMenu() {
    if (!selectorBtn || !menu) return;
    menu.hidden = true;
    menuOpen = false;
    selectorBtn.setAttribute("aria-expanded", "false");
    activeIndex = -1;
    document.removeEventListener("click", onDocumentClick);
    document.removeEventListener("keydown", onKeydown);
  }

  function toggleMenu() {
    if (menuOpen) closeMenu();
    else openMenu();
  }

  function onDocumentClick(e) {
    if (!menuOpen) return;
    const isInside = menu.contains(e.target) || selectorBtn.contains(e.target);
    if (!isInside) closeMenu();
  }

  function onKeydown(e) {
    if (!menuOpen) return;
    const key = e.key;

    if (key === "Escape") {
      e.preventDefault();
      closeMenu();
      selectorBtn.focus();
      return;
    }

    if (key === "ArrowDown" || key === "Down") {
      e.preventDefault();
      setActive(Math.min(options.length - 1, activeIndex + 1));
      options[activeIndex]?.focus();
    } else if (key === "ArrowUp" || key === "Up") {
      e.preventDefault();
      setActive(Math.max(0, activeIndex - 1));
      options[activeIndex]?.focus();
    } else if (key === "Enter" || key === " ") {
      // Space or Enter selects when focus is on an option
      if (
        document.activeElement &&
        document.activeElement.classList.contains("payment-option")
      ) {
        e.preventDefault();
        selectOption(document.activeElement);
      }
    }
  }

  function setActive(index) {
    if (activeIndex >= 0 && options[activeIndex]) {
      options[activeIndex].removeAttribute("aria-selected");
    }
    activeIndex = index;
    if (activeIndex >= 0 && options[activeIndex]) {
      options[activeIndex].setAttribute("aria-selected", "true");
    }
  }

  function selectOption(el) {
    const label = el.getAttribute("data-label") || el.textContent.trim();
    const method = el.getAttribute("data-method");

    // Update the visible text on the trigger button
    if (numberSpan && label) {
      numberSpan.textContent = label;
    }

    // Handle special methods
    switch (method) {
      case "new-card":
        // TODO: open your "add card" flow/modal here
        console.log('Open "New Payment Card" flow');
        break;
      case "apple-pay":
        // TODO: trigger your Apple Pay flow
        console.log("Selected Apple Pay");
        break;
      case "google-pay":
        // TODO: trigger your Google Pay flow
        console.log("Selected Google Pay");
        break;
      default:
        // 'visa' or other saved methods—no-op or fetch details
        console.log("Selected saved method:", label);
    }

    closeMenu();
    selectorBtn.focus();
  }

  if (selectorBtn && menu) {
    // Toggle on click
    selectorBtn.addEventListener("click", (e) => {
      e.preventDefault();
      toggleMenu();
    });

    // Make options clickable
    options.forEach((opt, idx) => {
      opt.addEventListener("click", () => selectOption(opt));
      opt.addEventListener("mousemove", () => setActive(idx)); // hover updates active
    });

    // Improve ARIA on first load
    selectorBtn.setAttribute("aria-expanded", "false");
    selectorBtn.setAttribute("aria-haspopup", "listbox");
    menu.setAttribute("role", "listbox");
    options.forEach((o) => o.setAttribute("role", "option"));
  }
  function selectOption(el) {
    const label = el.getAttribute("data-label") || el.textContent.trim();
    const method = el.getAttribute("data-method");

    // Update visible label on the trigger button
    if (numberSpan && label) {
      numberSpan.textContent = label;
    }

    // Hide all conditional sections
    document.querySelector(".new-card-form")?.setAttribute("hidden", "");
    document.querySelector(".apple-pay-button")?.setAttribute("hidden", "");
    document.querySelector(".google-pay-button")?.setAttribute("hidden", "");
    document.querySelector(".confirm-button")?.removeAttribute("hidden");

    // Show relevant UI based on selection
    switch (method) {
      case "new-card":
        document.querySelector(".new-card-form")?.removeAttribute("hidden");
        break;
      case "apple-pay":
        document.querySelector(".apple-pay-button")?.removeAttribute("hidden");
        document.querySelector(".confirm-button")?.setAttribute("hidden", "");
        break;
      case "google-pay":
        document.querySelector(".google-pay-button")?.removeAttribute("hidden");
        document.querySelector(".confirm-button")?.setAttribute("hidden", "");
        break;
      case "visa":
      default:
        // Default saved card → confirm button remains
        break;
    }

    closeMenu();
    selectorBtn.focus();
  }
  const openBtn = document.querySelector(".open-faq-modal");
  const overlay = document.querySelector("[data-faq-overlay]");
  const modal = overlay?.querySelector(".modal");
  const closeBtn = overlay?.querySelector("[data-faq-close]");
  const triggers = Array.from(overlay?.querySelectorAll(".faq-trigger") || []);

  if (!openBtn || !overlay || !modal || !closeBtn) return;

  // --- Modal open/close with focus trap
  let lastFocused = null;

  function openModalSub() {
    lastFocused = document.activeElement;
    overlay.hidden = false;
    modal.setAttribute("data-anim", "in");
    // focus first interactive element
    (closeBtn || modal).focus();

    document.addEventListener("keydown", onKeydown);
    document.addEventListener("focus", trapFocus, true);
    overlay.addEventListener("click", onOverlayClick);
  }

  function closeModalSub() {
    modal.setAttribute("data-anim", "out");
    // wait for animation end then hide
    const done = () => {
      overlay.hidden = true;
      modal.removeAttribute("data-anim");
      document.removeEventListener("keydown", onKeydown);
      document.removeEventListener("focus", trapFocus, true);
      overlay.removeEventListener("click", onOverlayClick);
      if (lastFocused) lastFocused.focus();
      modal.removeEventListener("animationend", done);
    };
    modal.addEventListener("animationend", done);
  }

  function onOverlayClick(e) {
    if (e.target === overlay) closeModalSub();
  }

  function onKeydown(e) {
    if (e.key === "Escape") {
      e.preventDefault();
      closeModal();
    }
    if (e.key === "Tab") {
      // simple focus trap: keep focus inside modal
      const focusables = modal.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
      );
      const list = Array.from(focusables).filter(
        (el) => !el.hasAttribute("disabled")
      );
      if (!list.length) return;

      const first = list[0];
      const last = list[list.length - 1];

      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    }
  }

  function trapFocus(e) {
    if (!overlay.hidden && !modal.contains(e.target)) {
      e.stopPropagation();
      (closeBtn || modal).focus();
    }
  }

  openBtn.addEventListener("click", openModalSub);
  closeBtn.addEventListener("click", closeModal);

  // --- FAQ accordion behavior with animation
  triggers.forEach((btn) => {
    btn.addEventListener("click", () => togglePanel(btn));
    btn.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        togglePanel(btn);
      }
    });
  });

  function togglePanel(btn) {
    const panelId = btn.getAttribute("aria-controls");
    const panel = document.getElementById(panelId);
    const expanded = btn.getAttribute("aria-expanded") === "true";

    if (expanded) {
      // Close clicked
      btn.setAttribute("aria-expanded", "false");
      panel.classList.remove("open");

      // Wait until transition ends, then hide
      panel.addEventListener(
        "transitionend",
        () => {
          if (!panel.classList.contains("open")) {
            panel.hidden = true;
          }
        },
        { once: true }
      );
    } else {
      // Close ALL others first
      triggers.forEach((otherBtn) => {
        const otherId = otherBtn.getAttribute("aria-controls");
        const otherPanel = document.getElementById(otherId);

        if (otherBtn !== btn) {
          otherBtn.setAttribute("aria-expanded", "false");
          otherPanel.classList.remove("open");
          otherPanel.addEventListener(
            "transitionend",
            () => {
              if (!otherPanel.classList.contains("open")) {
                otherPanel.hidden = true;
              }
            },
            { once: true }
          );

          const chev = otherBtn.querySelector(".chev");
          if (chev) chev.style.transform = "rotate(0deg)";
        }
      });

      // Open clicked
      panel.hidden = false; // make sure it's visible before animating
      requestAnimationFrame(() => panel.classList.add("open"));
      btn.setAttribute("aria-expanded", "true");
    }

    // Chevron update
    const chev = btn.querySelector(".chev");
    if (chev)
      chev.style.transform = expanded ? "rotate(0deg)" : "rotate(180deg)";
  }

  const checkoutBtn = document.querySelector(".checkout-button");
  const confirmModal = document.querySelector(".confirm-section");
  const planSelectionModal = document.querySelector(".plan-selection-panel");
  checkoutBtn.addEventListener("click", () => {
    confirmModal.style.display = "flex";
    planSelectionModal.style.display = "none";
  });

  const cyp = document.querySelector(".c_y_p");
  cyp.addEventListener("click", () => {
    const popup = document.querySelector(".modal-wrapper");
    popup.classList.add("active");
  });
  const closeModalButton = document.querySelector(".modal-close-button");
  closeModalButton.addEventListener("click", () => {
    const popup = document.querySelector(".modal-wrapper");
    popup.classList.remove("active");
    document.querySelector(".backdrop").classList.remove("active");
  });
})();

/**
 * Custom Modal Manager for the provided markup
 * ------------------------------------------------------
 * - No external deps
 * - Auto-wires elements with classes ending in `-modal-open`
 * - Opens the corresponding modal whose class matches without `-open`
 * - Supports backdrop levels (1, 2, 3), nested stacks, and back navigation
 * - Handles bullet-select groups, star ratings, and 1-10 rating enablement
 * - Implements the specific "Continue" flows for the feedback modals
 *
 * Usage: include this file at the end of <body>:
 *   <script src="custom-modals.js"></script>
 */

(function () {
  "use strict";

  // ---------- Utilities ----------
  const qs = (sel, root = document) => root.querySelector(sel);
  const qsa = (sel, root = document) => Array.from(root.querySelectorAll(sel));
  const on = (el, ev, fn, opts) => el && el.addEventListener(ev, fn, opts);

  // ---------- Backdrops & Modal Stack ----------
  const BACKDROP_IDS = {
    1: "backdrop-level-1",
    2: "backdrop-level-2",
    3: "backdrop-level-3",
  };

  function ensureBackdrop(level = 2) {
    const id = BACKDROP_IDS[level] || BACKDROP_IDS[2];
    let el = qs(`#${id}`);
    if (!el) {
      el = document.createElement("div");
      el.id = id;
      el.dataset.level = String(level);
      el.className = `modal-backdrop level-${level}`;
      Object.assign(el.style, {
        position: "fixed",
        inset: "0",
        background:
          "rgba(0,0,0," +
          (level === 1 ? "0.25" : level === 2 ? "0.45" : "0.6") +
          ")",
        zIndex: String(900 + level * 100),
        display: "none",
      });
      document.body.appendChild(el);
    }
    return el;
  }

  const modalStack = []; // [{ modal, level }]

  function showBackdrop(level) {
    const el = ensureBackdrop(level);
    el.style.display = "block";
    // Clicking backdrop closes only the top-most modal of the same level
    on(
      el,
      "click",
      () => {
        const top = modalStack[modalStack.length - 1];
        if (top && top.level === level) closeModal(top.modal);
      },
      { once: true }
    );
  }

  function hideBackdropIfNoModals(level) {
    const stillOpenAtLevel = modalStack.some((m) => m.level === level);
    if (!stillOpenAtLevel) {
      const el = ensureBackdrop(level);
      el.style.display = "none";
    }
  }

  function openModal(modal, level = 2, nested = true) {
    if (!modal) return;
    // Default: treat <main> as display:flex container when active
    modal.classList.add("active");

    modal.style.zIndex = String(910 + level * 100 + modalStack.length);
    modal.setAttribute("aria-hidden", "false");

    showBackdrop(level);
    modalStack.push({ modal, level });
  }

  function closeModal(modal) {
    if (!modal) return;
    modal.classList.remove("active");
    modal.style.display = "none";
    modal.setAttribute("aria-hidden", "true");

    // remove from stack (top-most occurrence)
    for (let i = modalStack.length - 1; i >= 0; i--) {
      if (modalStack[i].modal === modal) {
        const level = modalStack[i].level;
        modalStack.splice(i, 1);
        hideBackdropIfNoModals(level);
        break;
      }
    }
  }

  function closeTopModal() {
    const top = modalStack[modalStack.length - 1];
    if (top) closeModal(top.modal);
  }

  function goBackOneModal() {
    // Back: close current and leave previous in place
    closeTopModal();
  }

  // ---------- Helpers to infer target modal & backdrop level ----------
  function getTargetModalFromTrigger(trigger) {
    // Any class that ends with "-modal-open" -> strip "-open" for target class
    const openClass = Array.from(trigger.classList).find((c) =>
      c.endsWith("-modal-open")
    );
    if (!openClass) return null;
    const targetClass = openClass.replace(/-open$/, "");
    // Find <main> with that class
    return qs(`main.${targetClass}`);
  }

  function inferBackdropLevel(trigger, modal) {
    // Priority:
    // 1) data-backdrop on trigger: 1|2|3
    // 2) data-backdrop on modal
    // 3) heuristics: options sheet uses level 1, otherwise level 2
    const fromTrigger = parseInt(trigger?.dataset?.backdrop || "", 10);
    if (fromTrigger === 1 || fromTrigger === 2 || fromTrigger === 3)
      return fromTrigger;

    const fromModal = parseInt(modal?.dataset?.backdrop || "", 10);
    if (fromModal === 1 || fromModal === 2 || fromModal === 3) return fromModal;

    // Heuristic based on your markup names
    const name = modal?.className || "";
    if (
      /group-classes-options-modal|class-options-modal|lesson-setting-modal/.test(
        name
      )
    )
      return 1;
    if (/save-a-payment-card|breakdown|backdrop-level-3/.test(name)) return 3;
    return 2;
  }

  // ---------- Wire up generic open triggers ----------
  function initOpenTriggers() {
    qsa("[class*='-modal-open']").forEach((trigger) => {
      const modal = getTargetModalFromTrigger(trigger);
      if (!modal) return;
      on(trigger, "click", (e) => {
        e.preventDefault();
        const level = inferBackdropLevel(trigger, modal);
        openModal(modal, level, true);
      });
    });
  }

  // ---------- Wire up close/back controls inside modals ----------
  function initCloseAndBack() {
    // Generic "X" close controls (your markup uses classes like .backdrop-level-2-close)
    qsa(
      ".backdrop-level-1-close, .backdrop-level-2-close, .backdrop-level-3-close"
    ).forEach((btn) => {
      on(btn, "click", (e) => {
        e.preventDefault();
        // close the closest <main> modal
        const modal =
          btn.closest("main.modal-basic-style") || btn.closest("main");

        modal.classList.remove("active");

        closeAllModals();
        if (modal) closeModal(modal);
        else closeTopModal();
      });
    });

    // Back arrow control (go to previous modal)
    qsa(".back-modal").forEach((btn) => {
      on(btn, "click", (e) => {
        e.preventDefault();
        goBackOneModal();
      });
    });
  }
  function closeAllModals() {
    // grab any modal elements marked active (adjust selector if needed)
    qsa(
      "main.modal-basic-style.active, [data-modal].active, [role='dialog'].active"
    ).forEach((modal) => {
      closeModal(modal); // let your own logic handle cleanup/transition
    });
  }

  // ---------- Bullet radio groups (enable Continue) ----------
  function initBulletSelects() {
    qsa(".bullet-select-options").forEach((group) => {
      const buttons = qsa("button", group);
      const container = group.closest("main");
      const continueBtn = container ? qs(".red-button", container) : null;

      buttons.forEach((btn) => {
        on(btn, "click", () => {
          buttons.forEach((b) => b.classList.remove("active"));
          btn.classList.add("active");
          if (continueBtn) continueBtn.classList.remove("disabled-button");
        });
      });
    });
  }

  // ---------- 1-10 rating groups ----------
  function initNumericRatings() {
    qsa(".rating-1-to-10-options").forEach((block) => {
      const ul = qs("ul.options", block);
      if (!ul) return;
      const buttons = qsa("button", ul);
      const modal = block.closest("main");
      const nextBtn = modal
        ? qs(".red-button:not(.back-modal):not(.backdrop-level-2-close)", modal)
        : null;

      buttons.forEach((btn, idx) => {
        on(btn, "click", () => {
          buttons.forEach((b) => b.classList.remove("active"));
          btn.classList.add("active");
          if (nextBtn) nextBtn.classList.remove("disabled-button");
        });
      });
    });
  }

  // ---------- Selectable star ratings ----------
  function initStars() {
    // Containers that hold multiple "outline-and-fill-star"
    qsa(
      ".outline-and-fill-star-container-one, .outline-and-fill-star-container-two"
    ).forEach((container) => {
      const starPairs = qsa(".outline-and-fill-star", container);
      starPairs.forEach((pair, index) => {
        on(pair, "click", () => {
          // mark all up to index as selected
          starPairs.forEach((p, i) => p.classList.toggle("active", i <= index));
        });
      });
    });
  }

  // ---------- Flows/custom logic for your specific modals ----------
  function openByClass(modalClass, level = 2) {
    const modal = qs(`main.${modalClass}`);
    if (modal) openModal(modal, level, true);
  }

  function initFeedbackFlows() {
    // 1) "How Would You Prefer to Share Your Feedback for Florida 1 Group?"
    const groupPrefModal = qs("main.prefer-to-share-feedback-modal");
    if (groupPrefModal) {
      const continueBtn = qs(".red-button", groupPrefModal);
      const options = qsa(".bullet-select-options button", groupPrefModal);

      if (continueBtn) {
        on(continueBtn, "click", (e) => {
          e.preventDefault();
          const selected = options.find((b) => b.classList.contains("active"));
          if (!selected) return;
          // If the selected text contains "Public Review" -> go to publish review
          const isPublic = /Public Review/i.test(selected.textContent || "");
          closeModal(groupPrefModal);
          if (isPublic) {
            openByClass("publish-your-review-for-florida-1-modal", 2);
          } else {
            openByClass("rate-your-teacher-4-questions-modal", 2);
          }
        });
      }
    }

    // 2) Steps for the 4 questions wizard
    const q1 = qs("main.question-one-modal");
    const q2 = qs("main.question-two-modal");
    const q3 = qs("main.question-three-modal");
    const q4 = qs("main.question-four-modal");
    if (q1) {
      const next1 =
        qs(".red-button.question-two-modal-open", q1) || qs(".red-button", q1);
      on(next1, "click", (e) => {
        if (next1.classList.contains("disabled-button")) return;
        e.preventDefault();
        closeModal(q1);
        openByClass("question-two-modal", 2);
        setProgress(q2, 25);
      });
    }
    if (q2) {
      const next2 =
        qs(".red-button.question-three-modal-open", q2) ||
        qs(".red-button", q2);
      on(next2, "click", (e) => {
        if (next2.classList.contains("disabled-button")) return;
        e.preventDefault();
        closeModal(q2);
        openByClass("question-three-modal", 2);
        setProgress(q3, 50);
      });
    }
    if (q3) {
      const next3 =
        qs(".red-button.question-four-modal-open", q3) || qs(".red-button", q3);
      on(next3, "click", (e) => {
        if (next3.classList.contains("disabled-button")) return;
        e.preventDefault();
        closeModal(q3);
        openByClass("question-four-modal", 2);
        setProgress(q4, 75);
      });
    }
    if (q4) {
      const next4 =
        qs(".red-button.anonymous-feedback-last-modal-open", q4) ||
        qs(".red-button", q4);
      on(next4, "click", (e) => {
        if (next4.classList.contains("disabled-button")) return;
        e.preventDefault();
        closeModal(q4);
        openByClass("anonymous-feedback-last-modal", 2);
        setProgress(qs("main.anonymous-feedback-last-modal"), 100);
      });
    }

    function setProgress(modal, pct) {
      if (!modal) return;
      const bar = qs(".question-progress-bar", modal);
      if (bar) bar.style.setProperty("--question-answer-progress", pct + "%");
    }

    // 3) "How Would You Prefer to Share Your Feedback for Daniela Canelon?"
    const teacherPrefModal = qs("main.give-feedback-to-teacher-modal");
    if (teacherPrefModal) {
      const continueBtn = qs(".red-button", teacherPrefModal);
      const options = qsa(".bullet-select-options button", teacherPrefModal);
      if (continueBtn) {
        on(continueBtn, "click", (e) => {
          e.preventDefault();
          const selected = options.find((b) => b.classList.contains("active"));
          if (!selected) return;
          const isPublic = /Public Review/i.test(selected.textContent || "");
          closeModal(teacherPrefModal);
          if (isPublic) {
            openByClass("public-feedback-to-teacher-modal", 2);
          } else {
            openByClass("anonymous-feedback-to-teacher-modal", 2);
          }
        });
      }
    }

    // 4) Great/Bad option branches (anonymous feedback to teacher follow-ups)
    const howDidItGo = qs("main.anonymous-feedback-to-teacher-modal");
    if (howDidItGo) {
      const bad = qs(".bad-option-select-modal-open", howDidItGo);
      const great = qs(".great-option-select-modal-open", howDidItGo);
      on(bad, "click", (e) => {
        e.preventDefault();
        closeModal(howDidItGo);
        openByClass("bad-option-select-modal", 2);
      });
      on(great, "click", (e) => {
        e.preventDefault();
        closeModal(howDidItGo);
        openByClass("great-option-select-modal", 2);
      });
    }

    // 5) Success modal (triggered by "Post review" buttons)
    qsa(".success-modal-for-providing-feedback-modal-open").forEach((btn) => {
      on(btn, "click", (e) => {
        e.preventDefault();
        // close the parent modal then open success
        const parentModal = btn.closest("main");
        if (parentModal) closeModal(parentModal);
        openByClass("success-modal-for-providing-feedback-modal", 2);
      });
    });
  }

  // ---------- Enable/disable "Continue" buttons initially ----------
  function initDisabledButtonsGuard() {
    // If a button has .disabled-button, prevent default
    qsa("button.disabled-button").forEach((btn) => {
      on(btn, "click", (e) => {
        e.preventDefault();
        e.stopPropagation();
      });
    });
  }

  // ---------- Misc small UX helpers for the provided markup ----------
  function initSuggestedNestedOptions() {
    // Parent options toggle their nested .nested-options visibility & selection
    qsa(".suggested-feedback-options .parent-option").forEach((parent) => {
      const targetId = parent.getAttribute("data-target");
      const nested = targetId ? qs(`#${CSS.escape(targetId)}`) : null;
      on(parent, "click", (e) => {
        e.preventDefault();
        parent.classList.toggle("active");
        if (nested) nested.classList.toggle("open");
      });
    });

    // Clicking a nested option toggles selected state
    qsa(".suggested-feedback-options .nested-options .nested").forEach(
      (btn) => {
        on(btn, "click", (e) => {
          e.preventDefault();
          btn.classList.toggle("active");
        });
      }
    );
  }

  // ---------- Bootstrap ----------
  function init() {
    initOpenTriggers();
    initCloseAndBack();
    initBulletSelects();
    initNumericRatings();
    initStars();
    initFeedbackFlows();
    initSuggestedNestedOptions();
    initDisabledButtonsGuard();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }

  document
    .querySelectorAll(".transfer-balance-or-subscription")
    .forEach((el) => {
      el.addEventListener("click", function (e) {
        e.stopPropagation(); // prevent bubbling
        document
          .getElementById("what-would-you-like-to-do-modal")
          .classList.add("active");
        document.querySelector(".backdrop-level-3").classList.add("active");
      });
    });
})();

(() => {
  // ===== Helpers =====
  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  // Elements
  const container = $(".rm-container");
  const monthLabel = $(".rm-month", container);
  const grid = $(".rm-grid", container);
  const prevBtn = $(".rm-nav-btn.prev", container);
  const nextBtn = $(".rm-nav-btn.next", container);
  const startOut = $("#rm-start-display");
  const endOut = $("#rm-end-display");

  // Weekday header cells are the first 7 children inside .rm-grid
  const weekdayCells = $$(".rm-weekday", grid);

  // Configuration
  const today = startOfDay(new Date());
  const minDate = today; // block any date < today
  let viewYear = today.getFullYear();
  let viewMonth = today.getMonth(); // 0-11

  // Selection state
  let rangeStart = null;
  let rangeEnd = null;

  // ===== Date utils =====
  function startOfDay(d) {
    const x = new Date(d);
    x.setHours(0, 0, 0, 0);
    return x;
  }
  function addDays(d, n) {
    const x = new Date(d);
    x.setDate(x.getDate() + n);
    return x;
  }
  function daysInMonth(year, month) {
    return new Date(year, month + 1, 0).getDate();
  }
  function formatLabel(d) {
    return new Intl.DateTimeFormat(undefined, {
      month: "long",
      year: "numeric",
    }).format(d);
  }
  function formatHuman(d) {
    return new Intl.DateTimeFormat(undefined, { dateStyle: "medium" }).format(
      d
    );
  }
  function isoDate(d) {
    // YYYY-MM-DD for data attributes
    return d.toISOString().slice(0, 10);
  }
  function isBefore(a, b) {
    return startOfDay(a).getTime() < startOfDay(b).getTime();
  }
  function isAfter(a, b) {
    return startOfDay(a).getTime() > startOfDay(b).getTime();
  }
  function isSameDay(a, b) {
    return startOfDay(a).getTime() === startOfDay(b).getTime();
  }

  // ===== Rendering =====
  function render() {
    // Header label
    const viewDate = new Date(viewYear, viewMonth, 1);
    monthLabel.textContent = formatLabel(viewDate);

    // Remove all day cells (keep weekday headers)
    const toRemove = $$(".rm-day", grid);
    toRemove.forEach((el) => el.remove());

    // Build a 6x7 grid (42 cells) to be safe for any month layout
    const firstDow = new Date(viewYear, viewMonth, 1).getDay(); // 0=Sun
    const totalDays = daysInMonth(viewYear, viewMonth);

    // Days from previous month to fill leading blanks
    const prevMonth = viewMonth === 0 ? 11 : viewMonth - 1;
    const prevYear = viewMonth === 0 ? viewYear - 1 : viewYear;
    const prevTotal = daysInMonth(prevYear, prevMonth);
    const leading = firstDow; // number of cells before day 1

    // Create 42 day cells
    const cells = 42;
    for (let i = 0; i < cells; i++) {
      const cell = document.createElement("div");
      cell.className = "rm-day";
      let cellDate, label;

      if (i < leading) {
        // previous month
        const dayNum = prevTotal - leading + 1 + i;
        cell.classList.add("other");
        cellDate = new Date(prevYear, prevMonth, dayNum);
        label = String(dayNum);
      } else if (i < leading + totalDays) {
        // current month
        const dayNum = i - leading + 1;
        cellDate = new Date(viewYear, viewMonth, dayNum);
        label = String(dayNum);
      } else {
        // next month
        const nextIndex = i - (leading + totalDays) + 1;
        const nextMonth = viewMonth === 11 ? 0 : viewMonth + 1;
        const nextYear = viewMonth === 11 ? viewYear + 1 : viewYear;
        cell.classList.add("other");
        cellDate = new Date(nextYear, nextMonth, nextIndex);
        label = String(nextIndex);
      }

      cell.textContent = label;
      cell.dataset.date = isoDate(cellDate);

      // State classes (today / disabled / selected / in-range)
      if (isSameDay(cellDate, today)) {
        cell.classList.add("is-today");
      }

      if (isBefore(cellDate, minDate)) {
        cell.classList.add("is-disabled");
      } else {
        // Click handler only for enabled cells
        cell.addEventListener("click", () => handleDateClick(cellDate));
      }

      // Selection styling
      if (rangeStart && isSameDay(cellDate, rangeStart)) {
        cell.classList.add("is-selected");
      }
      if (rangeEnd && isSameDay(cellDate, rangeEnd)) {
        cell.classList.add("is-selected");
      }
      if (
        rangeStart &&
        rangeEnd &&
        isAfter(cellDate, rangeStart) &&
        isBefore(cellDate, rangeEnd)
      ) {
        cell.classList.add("is-in-range");
      }

      grid.appendChild(cell);
    }

    // Optional: disable the prev nav button when the whole displayed month is in the past
    const lastOfView = new Date(viewYear, viewMonth, totalDays);
    prevBtn.disabled = isBefore(lastOfView, minDate);

    // Next button always enabled (you can cap if needed)
    nextBtn.disabled = false;

    // Update the selection readout
    updateSelectionReadout();
  }

  function updateSelectionReadout() {
    if (startOut)
      startOut.textContent = rangeStart ? formatHuman(rangeStart) : "—";
    if (endOut) endOut.textContent = rangeEnd ? formatHuman(rangeEnd) : "—";
  }

  // ===== Selection logic =====
  function handleDateClick(date) {
    // Block past dates (should already be disabled visually)
    if (isBefore(date, minDate)) return;

    if (!rangeStart || (rangeStart && rangeEnd)) {
      // Start fresh
      rangeStart = date;
      rangeEnd = null;
    } else if (rangeStart && !rangeEnd) {
      // Set end if >= start, else restart with new start
      if (isBefore(date, rangeStart)) {
        rangeStart = date;
        rangeEnd = null;
      } else {
        rangeEnd = date;
      }
    }
    render();
  }

  // ===== Navigation =====
  prevBtn.addEventListener("click", () => {
    // Move to previous month (allowed even if past; selection still blocked)
    if (viewMonth === 0) {
      viewMonth = 11;
      viewYear -= 1;
    } else {
      viewMonth -= 1;
    }
    render();
  });

  nextBtn.addEventListener("click", () => {
    if (viewMonth === 11) {
      viewMonth = 0;
      viewYear += 1;
    } else {
      viewMonth += 1;
    }
    render();
  });

  // ===== Initialize =====
  render();

  // ===== Optional: expose selection on CTA click =====
  const cta = $(".rm-cta", container);
  if (cta) {
    cta.addEventListener("click", () => {
      if (!rangeStart || !rangeEnd) {
        alert("Please choose a start and end date for the pause.");
        return;
      }
      // Example payload you might send to your backend:
      const payload = {
        pause_start: isoDate(rangeStart),
        pause_end: isoDate(rangeEnd),
      };
      console.log("Selected pause range:", payload);
      // fetch('/api/pause', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload) })
      //   .then(r => r.json()).then(...);
      alert(
        `Pausing from ${formatHuman(rangeStart)} to ${formatHuman(rangeEnd)}.`
      );
    });
  }
})();

(() => {
  // ===== Helpers =====
  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  // Elements (ps- namespace)
  const container = $(".ps-container");
  const monthLabel = $(".ps-month", container);
  const grid = $(".ps-grid", container);
  const prevBtn = $(".ps-nav__btn.is-prev", container);
  const nextBtn = $(".ps-nav__btn.is-next", container);

  // Optional selection readouts (supports new ps- ids, falls back to old rm-)
  const startOut = $("#ps-start-display") || $("#rm-start-display");
  const endOut = $("#ps-end-display") || $("#rm-end-display");

  // Weekday header cells are the first 7 children inside .ps-grid
  const weekdayCells = $$(".ps-weekday", grid);

  // Configuration
  const today = startOfDay(new Date());
  const minDate = today; // block any date < today
  let viewYear = today.getFullYear();
  let viewMonth = today.getMonth(); // 0-11

  // Selection state
  let rangeStart = null;
  let rangeEnd = null;

  // ===== Date utils =====
  function startOfDay(d) {
    const x = new Date(d);
    x.setHours(0, 0, 0, 0);
    return x;
  }
  function addDays(d, n) {
    const x = new Date(d);
    x.setDate(x.getDate() + n);
    return x;
  }
  function daysInMonth(year, month) {
    return new Date(year, month + 1, 0).getDate();
  }
  function formatLabel(d) {
    return new Intl.DateTimeFormat(undefined, {
      month: "long",
      year: "numeric",
    }).format(d);
  }
  function formatHuman(d) {
    return new Intl.DateTimeFormat(undefined, { dateStyle: "medium" }).format(
      d
    );
  }
  function isoDate(d) {
    // YYYY-MM-DD for data attributes
    return d.toISOString().slice(0, 10);
  }
  function isBefore(a, b) {
    return startOfDay(a).getTime() < startOfDay(b).getTime();
  }
  function isAfter(a, b) {
    return startOfDay(a).getTime() > startOfDay(b).getTime();
  }
  function isSameDay(a, b) {
    return startOfDay(a).getTime() === startOfDay(b).getTime();
  }

  // ===== Rendering =====
  function render() {
    // Header label
    const viewDate = new Date(viewYear, viewMonth, 1);
    monthLabel.textContent = formatLabel(viewDate);

    // Remove all day cells (keep weekday headers)
    const toRemove = $$(".ps-day", grid);
    toRemove.forEach((el) => el.remove());

    // Build a 6x7 grid (42 cells)
    const firstDow = new Date(viewYear, viewMonth, 1).getDay(); // 0=Sun
    const totalDays = daysInMonth(viewYear, viewMonth);

    // Days from previous month to fill leading blanks
    const prevMonth = viewMonth === 0 ? 11 : viewMonth - 1;
    const prevYear = viewMonth === 0 ? viewYear - 1 : viewYear;
    const prevTotal = daysInMonth(prevYear, prevMonth);
    const leading = firstDow; // number of cells before day 1

    // Create 42 day cells
    const cells = 42;
    for (let i = 0; i < cells; i++) {
      const cell = document.createElement("div");
      cell.className = "ps-day";
      let cellDate, label;

      if (i < leading) {
        // previous month
        const dayNum = prevTotal - leading + 1 + i;
        cell.classList.add("is-other");
        cellDate = new Date(prevYear, prevMonth, dayNum);
        label = String(dayNum);
      } else if (i < leading + totalDays) {
        // current month
        const dayNum = i - leading + 1;
        cellDate = new Date(viewYear, viewMonth, dayNum);
        label = String(dayNum);
      } else {
        // next month
        const nextIndex = i - (leading + totalDays) + 1;
        const nextMonth = viewMonth === 11 ? 0 : viewMonth + 1;
        const nextYear = viewMonth === 11 ? viewYear + 1 : viewYear;
        cell.classList.add("is-other");
        cellDate = new Date(nextYear, nextMonth, nextIndex);
        label = String(nextIndex);
      }

      cell.textContent = label;
      cell.dataset.date = isoDate(cellDate);

      // State classes (today / disabled / selected / in-range)
      if (isSameDay(cellDate, today)) {
        cell.classList.add("is-today");
      }

      if (isBefore(cellDate, minDate)) {
        cell.classList.add("is-disabled");
      } else {
        // Click handler only for enabled cells
        cell.addEventListener("click", () => handleDateClick(cellDate));
      }

      // Selection styling
      if (rangeStart && isSameDay(cellDate, rangeStart)) {
        cell.classList.add("is-selected");
      }
      if (rangeEnd && isSameDay(cellDate, rangeEnd)) {
        cell.classList.add("is-selected");
      }
      if (
        rangeStart &&
        rangeEnd &&
        isAfter(cellDate, rangeStart) &&
        isBefore(cellDate, rangeEnd)
      ) {
        cell.classList.add("is-in-range");
      }

      grid.appendChild(cell);
    }

    // Optional: disable the prev nav button when the whole displayed month is in the past
    const lastOfView = new Date(viewYear, viewMonth, totalDays);
    prevBtn.disabled = isBefore(lastOfView, minDate);

    // Next button always enabled (you can cap if needed)
    nextBtn.disabled = false;

    // Update the selection readout
    updateSelectionReadout();
  }

  function updateSelectionReadout() {
    if (startOut)
      startOut.textContent = rangeStart ? formatHuman(rangeStart) : "—";
    if (endOut) endOut.textContent = rangeEnd ? formatHuman(rangeEnd) : "—";
  }

  // ===== Selection logic =====
  function handleDateClick(date) {
    // Block past dates (should already be disabled visually)
    if (isBefore(date, minDate)) return;

    if (!rangeStart || (rangeStart && rangeEnd)) {
      // Start fresh
      rangeStart = date;
      rangeEnd = null;
    } else if (rangeStart && !rangeEnd) {
      // Set end if >= start, else restart with new start
      if (isBefore(date, rangeStart)) {
        rangeStart = date;
        rangeEnd = null;
      } else {
        rangeEnd = date;
      }
    }
    render();
  }

  // ===== Navigation =====
  prevBtn.addEventListener("click", () => {
    // Move to previous month (allowed even if past; selection still blocked)
    if (viewMonth === 0) {
      viewMonth = 11;
      viewYear -= 1;
    } else {
      viewMonth -= 1;
    }
    render();
  });

  nextBtn.addEventListener("click", () => {
    if (viewMonth === 11) {
      viewMonth = 0;
      viewYear += 1;
    } else {
      viewMonth += 1;
    }
    render();
  });

  // ===== Initialize =====
  render();

  // ===== Optional: expose selection on CTA click =====
  const cta = $(".ps-cta", container);
  if (cta) {
    cta.addEventListener("click", () => {
      if (!rangeStart || !rangeEnd) {
        alert("Please choose a start and end date for the pause.");
        return;
      }
      const payload = {
        pause_start: isoDate(rangeStart),
        pause_end: isoDate(rangeEnd),
      };
      console.log("Selected pause range:", payload);
      alert(
        `Pausing from ${formatHuman(rangeStart)} to ${formatHuman(rangeEnd)}.`
      );
    });
  }
})();
