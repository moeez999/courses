import elements from "../common/Elements.js";
import Variable from "../common/Variable.js";

// Lesson Count
const SetupLessonCountListener = () => {
  elements.HowManyLessonsYouWantModalIncrementLesson.addEventListener("click", () => {
    if (Variable.totalLesson < 6) {
      // 6 se zyada allow nahi
      Variable.totalLesson += 1;
    }

    elements.reviewYourTransferModalOpen[0].classList.remove("disabled");
    elements.HowManyLessonsYouWantModalDecrementLesson.classList.remove("disabled");

    if (Variable.totalLesson <= 5) {
      elements.HowManyLessonsYouWantModalLessonProgress.style.width = `${
        (Variable.totalLesson * 100) / 5
      }%`;

      elements.HowManyLessonsYouWantModalBalanceUsed.innerText = `$${Number(
        Variable.totalLesson * (29.44 / 5)
      ).toFixed(2)}`;
    }

    if (Variable.totalLesson > 5) {
      elements.HowManyLessonsYouWantModalSixLessonSelected.classList.add("active");
      elements.HowManyLessonsYouWantModalLessonProgress.style.backgroundColor = "rgba(149, 98, 7, 1)";
      elements.HowManyLessonsYouWantModalLessonProgress.parentElement.style.borderColor =
        "rgba(149, 98, 7, 1)";
      elements.HowManyLessonsYouWantModalIncrementLesson.classList.add("disabled");
      Variable.is6Lessons = true;
    }

    elements.HowManyLessonsYouWantModalLessonCount.innerText = `${Variable.totalLesson} lessons`;
  });

  elements.HowManyLessonsYouWantModalDecrementLesson.addEventListener("click", () => {
    if (Variable.totalLesson > 0) {
      Variable.totalLesson -= 1;
    }

    // Agar lesson count 5 se neeche aa gaya toh reset styles
    if (Variable.totalLesson <= 5) {
      elements.HowManyLessonsYouWantModalIncrementLesson.classList.remove("disabled");
      elements.HowManyLessonsYouWantModalSixLessonSelected.classList.remove("active");
      elements.HowManyLessonsYouWantModalLessonProgress.style.backgroundColor = "";
      elements.HowManyLessonsYouWantModalLessonProgress.parentElement.style.borderColor = "";
      Variable.is6Lessons = false;
    }

    // Lesson progress bar aur balance update karo
    elements.HowManyLessonsYouWantModalLessonProgress.style.width = `${
      (Variable.totalLesson * 100) / 5
    }%`;

    elements.HowManyLessonsYouWantModalBalanceUsed.innerText = `$${Number(
      Variable.totalLesson * (29.44 / 5)
    ).toFixed(2)}`;

    // Agar lesson count 0 ho gaya toh decrement button disable karo
    if (Variable.totalLesson === 0) {
      elements.HowManyLessonsYouWantModalDecrementLesson.classList.add("disabled");
    }

    elements.HowManyLessonsYouWantModalLessonCount.innerText = `${Variable.totalLesson} lessons`;
  });
};

export default SetupLessonCountListener;
