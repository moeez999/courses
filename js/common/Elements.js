const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

const modal = (name) => $(`.${name}`);

const elements = Object.freeze({
  // Level cards (A1, A2, B1, B2, and C1) begginer card open and get.
  get begginerLevelOpen() { return $(".begginer-level-a1-open"); },
  get begginerLevel() { return $(".begginer-level-a1"); },

  // class option modal open and get that modal
  get classOptionsModalOpen() { return $$(".class-options-modal-open"); },
  get classOptionsModal() { return modal("class-options-modal"); },
  
  // level decide which backdrop display first large level display first 
  get backdropLevel1() {return $(".backdrop-level-1"); },
  get backdropLevel2() {return $(".backdrop-level-2"); },
  get backdropLevel3() {return $(".backdrop-level-3"); },

  // back modal
  get backModal() {return $$(".back-modal")},

  // Share tutor modal get, open and close
  get shareTutorModal() {return modal("share-tutor"); },
  get shareTutorModalOpen() {return $(".share-tutor-open"); },
  get shareTutorModalClose() {return $(".share-tutor-close"); },

  // Cancel modal get and open
  get cancelLessonModal() {return modal("cancel-lesson-modal");},
  get cancelModalOpen() {return $(".cancel-modal-open");},

  // Toaster 
  get toaster() {return $(".toaster");},
  get toasterText() {return $(".toaster p")},
  
  // backdropLevel Close
  get backdropLevel1Close() {return $$(".backdrop-level-1-close")},
  get backdropLevel2Close() {return $$(".backdrop-level-2-close")},
  get backdropLevel3Close() {return $$(".backdrop-level-3-close")},

  // Lesson setting modal get and open
  get lessonSettingModal() {return modal("lesson-setting-modal")},
  get lessonSettingModalOpen() {return $$(".lesson-setting-modal-open")},

  // Add extra lesson modal get, open, increment, descrement and value set.
  get addExtraLessonModal() {return modal("add-extra-lesson-modal")},
  get addExtraLessonModalOpen() {return $(".add-extra-lesson-modal-open")},
  get addExtraLessonIncrement() {return $(".add-extra-lesson-modal .increment")},
  get addExtraLessonDecrement() {return $(".add-extra-lesson-modal .decrement")},
  get addExtraLessonTotalValue() {return $(".add-extra-lesson-total-value")},
  get addExtraLessonValue() {return $(".add-extra-lesson-modal .value h1")},

  // confirm payment modal get, open and goBack
  get confirmPaymentModal() {return modal("confirm-payment-modal")},

  get confirmPaymentModal02() {return modal("confirm-payment-modal-02")},
  get confirmPaymentModal02Open() {return $(".confirm-payment-modal-02-open")},  
  get confirmPaymentModal02GoBack() {return modal("confirm-payment-modal-02 .goBack")},
  
  get confirmPaymentModalExtraLessonCount() {return $(".add-extra-lesson-total-value")},
  get confirmPaymentModalExtraLessonAmount() {return $(".total-lesson-amount")},
  get confirmPaymentModalTotalFee() {return $(".total-amount")},
  get confirmPaymentModalTotalAmountShowInBTN() {return $(".total-amount-show")},

  // Which tutor modal
  get whichTutorModal() {return modal("which-tutor")},
  get whichTutorModalOpen() {return $(".which-tutor-open")},

  // subscribe modal get and open
  get subscribeModal() {return modal("subscribe-modal")},
  get subscribeModalOpen() {return $(".subscribe-modal-open")},

  // Balance modal 
  get balanceModal() {return modal("balance-modal")},
  get balanceModalOpen() {return $(".balance-modal-open")},
  get balanceModalTeachersBox() {return $$(".balance-modal .topPart .teacherBox")},
  get balanceModalTeachersBoxes() {return $$(".balance-modal .bottomPart .box01")},

  // language and currency modal get, open and language set
  get languageAndCurrencyModal() {return modal("language-and-currency-modal")},
  get languageAndCurrencyModalOpen() {return $(".language-and-currency-modal-open")},
  get languageAndCurrencyModalLanguage() {return $$(".language-and-currency-modal .language")},

  // notification modal
  get notificationModal() {return modal("notification-modal")},
  get notificationModalOpen() {return $(".notification-modal-open")},

  // message modal
  get messagesModal() {return modal("messages-modal")},
  get messageModalOpen() {return $(".message-modal-open")},

  // Transfer balance or subscription modal open
  get transferBalanceOrSubscriptionModalOpen() {return $$(".transfer-balance-or-subscription-modol-open")},

  // what would you like to do modal open
  get whatWouldYouLikeToDo() {return modal("what-would-you-like-to-do-modal")},

  // transfer form modal get and open
  get transferFromModal() {return modal("transfer-from-modal")},
  get transferFromModalOpen() {return $$(".transfer-from-modal-open")},
  
  // transfer form modal get and open
  get transferToModal() {return modal("transfer-to-modal")},
  get transferToModalOpen() {return $$(".transfer-to-modal-open")},

  // profile setting modal
  get profileSettingModal() {return modal("profile-setting-modal")},
  get profileSettingModalOpen() {return $(".profile-setting-modal-open")},

  // archive tutor open and get
  get ArchiveTutor() {return $$(".archive-tutor")},
  get ArchiveTutorOpen() {return $$(".archive-tutor-open")},

  // message card 
  get messageCard() {return $$(".messages-modal .message-bottom-area .all .card")},
  get messageBox() {return modal("message-box")},
  get messageBoxGoBack() {return $(".message-box .goBack")},

  // How many lesson you want modal get and open
  get HowManyLessonsYouWantModal() {return modal("how-many-lessons-you-want-modal")},
  get HowManyLessonsYouWantModalOpen() {return $$(".how-many-lessons-you-want-modal-open")},
  get HowManyLessonsYouWantModalIncrementLesson() {return $(".how-many-lessons-you-want-modal .increment-lesson")},
  get HowManyLessonsYouWantModalDecrementLesson() {return $(".how-many-lessons-you-want-modal .decrement-lesson")},
  get HowManyLessonsYouWantModalLessonCount() {return $(".how-many-lessons-you-want-modal .lesson-count")},
  get HowManyLessonsYouWantModalLessonProgress() {return $(".how-many-lessons-you-want-modal .lesson-progress")},
  get HowManyLessonsYouWantModalBalanceUsed() {return $(".how-many-lessons-you-want-modal .balance-used")},
  get HowManyLessonsYouWantModalSixLessonSelected() {return $(".how-many-lessons-you-want-modal .six-lesson-selected")},

  // show breakdown modal open and get
  get showBreakdownModal() {return modal("show-break-down-modal")},
  get showBreakdownModalOpen() {return $(".show-breakdown-modal-open")},
  get showBreakdownModalRemainingBalance() {return $(".show-break-down-modal .remaining-balance")},
  get showBreakdownModalAmountUsed() {return $(".show-break-down-modal .amount-used")},
  get showBreakdownModalRemainingBalanceTextChange() {return $(".show-break-down-modal .remaining-balance-text-change")},

  // Transfer complete modal get and open
  get transferCompleteModal() {return modal("transfer-complete-modal")},
  get transferCompleteModalOpen() {return $(".transfer-complete-modal-Open")},
  get transferCompleteModalOpenV1() {return $$(".transfer-complete-modal-open-v1")},

  // review your tansfer
  get reviewYourTransferModal() {return modal("review-your-transfer-modal")},
  get reviewYourTransferModalOpen() {return $$(".review-your-transfer-modal-open")},
  get reviewYourTransferModalExtraMessage() {return $(".review-your-transfer-modal .extra-message")},
  get whatHappensNextListContent() {return $(".review-your-transfer-modal .what-happens-next-list-content")},
  get reviewYourTransferModalExtraPrice() {return $(".review-your-transfer-modal .extra-price")},

  // save a payment card modal
  get saveAPaymentCardModal() {return modal("save-a-payment-card-modal")},
  get saveAPaymentCardModalOpen() {return $(".save-a-payment-card-modal-open")},
  get saveAPaymentCardModalCardNumber() {return $(".save-a-payment-card-modal #card-number")},
  get saveAPaymentCardModalExpiryDate() {return $(".save-a-payment-card-modal #expiry")},

  // transfer ramaining balance (transfer to)
  get transferRemainingBalanceTransferTo() {return $(".transfer-remaining-balance-transfer-to")},

  // transfer subscription from modal
  get transferSubscriptionFromModal() {return modal("transfer-subscription-from-modal")},

  // choose your trail lesson duration modal
  get chooseYourTrialLessonDurationModal() {return modal("choose-your-trial-lesson-duration-modal")},
  get chooseYourTrialLessonDurationModalOpen() {return $$(".choose-your-trial-lesson-duration-modal-open")},

  // transfer subscription to modal
  get transferSubscriptionToModal() {return modal("transfer-subscription-to-modal")},
  get transferSubscriptionToModalOpen() {return $$(".transfer-subscription-to-modal-open")},

  // also transfer remaining balance modal 
  get alsoTransferRemainingBalanceModal() {return modal("also-transfer-remaining-balance-modal")},
  get alsoTransferRemainingBalanceModalOpen() {return $$(".also-transfer-remaining-balance-modal-open")},

  //  why do you need to transfer your subscription modal
  get whyNeedToTransferSubscriptionModal() {return modal("why-need-to-transfer-subscription-modal")},
  get whyNeedToTransferSubscriptionModalOpen() {return $(".why-need-to-transfer-subscription-modal-open")},

  // transfer subscription review transfer modal
  get transferSubscriptionReviewTransferModal() {return modal("transfer-subscription-review-transfer-modal")},
  get transferSubscriptionReviewTransferModalOpen() {return $$(".transfer-subscription-review-transfer-modal-open")},

  // Resubscribe to dainiela
  get resubscribeLessonModal() {return modal("resubscribe-lesson-modal")},
  get resubscribeLessonModalOpen() {return $(".resubscribe-lesson-modal-open")},
  
  // group classes options modal
  get groupClassesOptionsModal() {return $(".group-classes-options-modal")},
  get groupClassesOptionsModalOpen() {return $(".group-classes-options-modal-open")},

  // Prefer to share feedback modal
  get preferToShareFeedbackModal() {return modal("prefer-to-share-feedback-modal")},
  get preferToShareFeedbackModalOpen() {return $(".prefer-to-share-feedback-modal-open")},
  get preferToShareFeedbackModalOptions() {return $$(".prefer-to-share-feedback-modal .bullet-select-options button")},
  get preferToShareFeedbackModalContinueBTN() {return $(".prefer-to-share-feedback-modal .red-button")},

  // Give feedback to teacher modal
  get giveFeedbackToTeacherModal() {return modal("give-feedback-to-teacher-modal")},
  get giveFeedbackToTeacherModalOpen() {return $(".give-feedback-to-teacher-modal-open")},
  get giveFeedbackToTeacherModalOptions() {return $$(".give-feedback-to-teacher-modal .bullet-select-options button")},
  get giveFeedbackToTeacherModalContinueBTN() {return $(".give-feedback-to-teacher-modal .red-button")},

  get bulletSelectOptionsButton() {return $$(".bullet-select-options button")},
  
  get publicFeedbackToTeacherModal() {return modal("public-feedback-to-teacher-modal")},
  get anonymousFeedbackToTeacherModal() {return modal("anonymous-feedback-to-teacher-modal")},

  get greatOptionSelectModalOpen() {return $(".great-option-select-modal-open")},
  get greatOptionSelectModal() {return $(".great-option-select-modal")},

  get badOptionSelectModalOpen() {return $(".bad-option-select-modal-open")},
  get badOptionSelectModal() {return modal("bad-option-select-modal")},

  get anonymousTeacherFeedbackLastModalOpen() {return $$(".anonymous-teacher-feedback-last-modal-open")},
  get anonymousTeacherFeedbackLastModal() {return modal("anonymous-teacher-feedback-last-modal")},
  
  // Report a issue
  get tellUsWhatHappenedModalOpen() {return $(".tell-us-what-happened-modal-open")},
  get tellUsWhatHappenedModal() {return modal("tell-us-what-happened-modal")},

  get explainYourIssueModalOpen() {return $(".explain-your-issue-modal-open")},
  get explainYourIssueModal() {return modal("explain-your-issue-modal")},

  get issueReportedModalOpen() {return $(".issue-reported-modal-open")},
  get issueReportedModal() {return $(".issue-reported-modal")},

  // Publish your review for florida 1 modal
  get publishYourReviewForFlorida1Modal() {return modal("publish-your-review-for-florida-1-modal")},
  
  // Success modal for providing feedback modal
  get successModalForProvidingFeedbackModal() {return modal("success-modal-for-providing-feedback-modal")},
  get successModalForProvidingFeedbackModalOpen() {return $$(".success-modal-for-providing-feedback-modal-open")},

  // Anonymous Feedback modals
  get rateYourTeacher4QuestionsModal() {return modal("rate-your-teacher-4-questions-modal")},
  get questionOneModalOpen() {return $(".question-one-modal-open")},
  get questionOneModal() {return modal("question-one-modal")},
  get questionTwoModalOpen() {return $(".question-two-modal-open")},
  get questionTwoModal() {return modal("question-two-modal")},
  get questionThreeModalOpen() {return $(".question-three-modal-open")},
  get questionThreeModal() {return modal("question-three-modal")},
  get questionFourModalOpen() {return $(".question-four-modal-open")},
  get questionFourModal() {return modal("question-four-modal")},
  get anonymousFeedbackLastModalOpen() {return $$(".anonymous-feedback-last-modal-open")},
  get anonymousFeedbackLastModal() {return modal("anonymous-feedback-last-modal")},

  // star fill on hove and click
  get outlineAndFillStarOne() {return $$(".outline-and-fill-star-container-one .outline-and-fill-star")},
  get outlineAndFillStarTwo() {return $$(".outline-and-fill-star-container-two .outline-and-fill-star")},

  // rate 1 to 10 options
  get ratingOption1To10() {return $$(".rating-1-to-10-options .options li")},

  // Suggested feedback options
  get suggestedFeedbackOptionsParent() {return $$(".suggested-feedback-options .parent-option")},
  get suggestedFeedbackOptionsNested() {return $$(".suggested-feedback-options .nested-options")},
});

export default elements;
