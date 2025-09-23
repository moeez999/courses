// =========== transferLessons_subscription ==========
// ===================================================
import Elements from "../common/Elements.js";

// const transferLessons_subscription_cards = document.querySelectorAll(
//   ".transferLessons_subscription .cards .card"
// );
// const transferLessons_subscription_button = document.querySelector(
//   ".transferLessons_subscription button"
// );

// const transferBalance_cards = document.querySelectorAll(
//   ".transferBalance .cardsfrom .card"
// );
// const transferBalance_button = document.querySelector(
//   ".transferBalance button"
// );

// const transferBalanceTo_cards = document.querySelectorAll(
//   ".transferBalance .cardsTo .card"
// );
// const transferBalanceTo_button = document.querySelector(
//   ".transferBalanceTo button"
// );
// const transferLessons_subscription_btn_ModalOpen = document.querySelector(
//   ".transferLessons_subscription_btn_ModalOpen"
// );
// const transferBalance = document.querySelector(".transferBalance");

// const transferBalanceFrom_ModalOpen = document.querySelector(
//   ".transferBalanceFrom_ModalOpen"
// );
// const transferBalanceTo = document.querySelector(".transferBalanceTo");

// const transferBalance_backBTN = transferBalance.querySelector(".backButton");
// const transferBalanceTo_backBTN =
  // transferBalanceTo.querySelector(".backButton");

// const tellUsWhyOpen = document.querySelector(".tellUsWhyOpen");
// const tellUsWhy = document.querySelector(".tellUsWhy");
// const tellUsWhyBackBTN = tellUsWhy.querySelector(".backButton");

// const transferCompleteOpen = document.querySelector(".transferCompleteOpen");
// const TransferComplete = document.querySelector(".TransferComplete");

// const transferLessons_backButton = document.querySelector(
//   ".transferLessons .backButton"
// );

// const reviewYourTransfer_backButton = document.querySelector(
//   ".reviewYourTransfer .backButton"
// );

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

// transferLessons_subscription_btn_ModalOpen.addEventListener("click", () => {
//   Elements.transferLessons_subscription.classList.remove("active");

//   popupOpen(Elements.backdropLevel2, transferBalance, true);
//   if (selectedCard === 1 || selectedCard === 0) {
//     transferBalance.querySelector(".heading").textContent = "Transfer Lessons";
//   } else if (selectedCard === 2) {
//     transferBalance.querySelector(".heading").textContent =
//       "Transfer Subscription";
//   }
// });

transferBalanceFrom_ModalOpen.addEventListener("click", () => {
  transferBalance.classList.remove("active");
  popupOpen(Elements.backdropLevel2, transferBalanceTo, true);
  if (selectedCard === 1 || selectedCard === 0) {
    transferBalanceTo.querySelector(".heading").textContent =
      "Transfer Lessons";
  } else if (selectedCard === 2) {
    transferBalanceTo.querySelector(".heading").textContent =
      "Transfer Subscription";
  }
});

transferBalance_backBTN.addEventListener("click", () => {
  openNestedContainer = Elements.transferLessons_subscription;

  transferBalance.classList.remove("active");
  Elements.transferLessons_subscription.classList.add("active");
});
transferBalanceTo_backBTN.addEventListener("click", () => {
  openNestedContainer = transferBalance;

  transferBalanceTo.classList.remove("active");
  transferBalance.classList.add("active");
});

Elements.transferLessonsOpen.addEventListener("click", () => {
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
    openNestedContainer = Elements.reviewYourTransferModal;
    Elements.reviewYourTransferModal.classList.add("active");
  } else {
    openNestedContainer = Elements.transferLessons;
    Elements.transferLessons.classList.add("active");
  }

  transferBalanceTo.classList.remove("active");
});

transferLessons_backButton.addEventListener("click", () => {
  openNestedContainer = transferBalanceTo;

  Elements.transferLessons.classList.remove("active");
  transferBalanceTo.classList.add("active");
});

reviewYourTransfer_backButton.addEventListener("click", () => {
  openNestedContainer = transferBalanceTo;

  Elements.reviewYourTransferModal.classList.remove("active");
  transferBalanceTo.classList.add("active");
});

tellUsWhyOpen.addEventListener("click", () => {
  openNestedContainer = tellUsWhy;

  Elements.transferLessons.classList.remove("active");

  // Elements.change_your_plane_popup.classList.remove("active");
  tellUsWhy.classList.add("active");
});

tellUsWhyBackBTN.addEventListener("click", () => {
  openNestedContainer = Elements.transferLessons;

  tellUsWhy.classList.remove("active");
  Elements.transferLessons.classList.add("active");
});

transferCompleteOpen.addEventListener("click", () => {
  // debugger;
  openNestedContainer = TransferComplete;

  tellUsWhy.classList.remove("active");

  // Elements.change_your_plane_popup.classList.remove("active");
  TransferComplete.classList.add("active");
});
