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
})


// level 2
document.querySelector(".subLevelOpen2").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level3").classList.remove("active");
  document.querySelector("#level4").classList.remove("active");
  document.querySelector("#level5").classList.remove("active");


  // add
  document.querySelector("#level2").classList.add("active");
})




// level 3
document.querySelector(".subLevelOpen3").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level2").classList.remove("active");
  document.querySelector("#level4").classList.remove("active");
  document.querySelector("#level5").classList.remove("active");


  // add
  document.querySelector("#level3").classList.add("active");
})



// level 4
document.querySelector(".subLevelOpen4").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level2").classList.remove("active");
  document.querySelector("#level3").classList.remove("active");
  document.querySelector("#level5").classList.remove("active");


  // add
  document.querySelector("#level4").classList.add("active");
})



// level 4
document.querySelector(".subLevelOpen5").addEventListener("click", () => {
  document.querySelector("#level1").classList.remove("active");
  document.querySelector("#level2").classList.remove("active");
  document.querySelector("#level3").classList.remove("active");
  document.querySelector("#level4").classList.remove("active");


  // add
  document.querySelector("#level5").classList.add("active");
})


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

function bgMoodle(control){
  switch (control) {
    case true:
      document.getElementById("page").style.backgroundColor = "rgba(0, 0, 0, 0.180)"
      document.getElementById("s-page-footer").style.backgroundColor = "rgba(0, 0, 0, 0.010)"
      break;
    case false:
      
      document.getElementById("page").style.backgroundColor = "white"
      document.getElementById("s-page-footer").style.backgroundColor = "white"
      break;
  
    default:
      break;
  }
  // rgba(0, 0, 0, 0.180)
  // footer rgba(0, 0, 0, 0.010)
}

function detectAndAdjustPositionCustomDeiker(elementGetPosition, modalToSetPosition) {
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
  bgMoodle(true)
}

elements.userOptionOpen.forEach((e, i) =>
  e.addEventListener("click", () => {
    detectAndAdjustPosition(e, elements.userOptions);
    popupOpen(elements.backdrop, elements.userOptions);
  })
);
elements.subscription_dropdown_options_open.forEach((e, i) =>
  e.addEventListener("click", () => {
    detectAndAdjustPositionCustomDeiker(e, elements.subscription_dropdown_options); 
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
elements.reshedule_popup_open.addEventListener("click", () =>
  popupOpen(elements.backdrop_nested, elements.resheduleLesson_popup, true)
);

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
if(elements.whichTutorModal_open){

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
  bgMoodle(false)

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
