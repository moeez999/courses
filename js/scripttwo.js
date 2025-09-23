/**
 * Latingles Student Home - Main Application Entry Point
 *
 * This file serves as the main entry point for the Latingles student home page.
 * It imports and initializes all necessary features, listeners, and components.
 *
 * @author Latingles Development Team
 * @version 2.0.0
 */

// =================== FEATURE IMPORTS ===================
import languageDropdown from "./features/LanguageDropdown.js";
import setProgress from "./features/Progress.js";
import CardInput from "./features/CardInput.js";
import "./features/Calendar.js";
import "./features/MessageTypingArea.js";
import "./features/ToggleDropdown.js";

// =================== LISTENER IMPORTS ===================
import BackModalListener from "./listeners/BackModal_Listener.js";
import CloseModalListener from "./listeners/CloseModal_Listener.js";
import CopyTextListener from "./listeners/CopyText_Listener.js";
import OpenModalListener from "./listeners/OpenModal_Listener.js";
import SetupLessonCountListener from "./listeners/setupLessonCount_Listener.js";
import SetupMessageListener from "./listeners/SetupMessage_Listener.js";
import SuggestedFeedbackOptionsSelected from "./features/suggested-feedback-options-selected.js";

// =================== LEGACY IMPORTS ===================
import OldModalListeners from "./old/OldModalListeners.js";
// import "./old/TransferLessonsSubscription.js";

// =================== UTILITIES & CONFIGURATION ===================
import AppConfig from "./config/AppConfig.js";
import Utils from "./utils/Utils.js";
// import OutlineStarFillOnHoverAndSelect from "./utils/outline-start-fill-on-hover-and-select.js";
import { InitStarRatings } from "./utils/index.js";

// ==================== Components =====================
import ratingOption1To10Select from "./features/RatingSelect.js";
import InitFeedbackModals from "./components/prefer-to-share-feedback-modal.js";

// =================== INITIALIZATION FUNCTIONS ===================

/**
 * Initialize all application features
 */
function initializeFeatures() {
  try {
    setProgress(AppConfig.ui.defaultProgress);
    CardInput();
    languageDropdown();

    Utils.log("info", "Features initialized successfully");
  } catch (error) {
    Utils.log("error", "Error initializing features:", error);
  }
}

/**
 * Initialize all event listeners
 */
function initializeListeners() {
  try {
    // Core modal listeners
    OpenModalListener();
    CloseModalListener();
    BackModalListener();

    // Feature-specific listeners
    CopyTextListener();
    SetupMessageListener();
    SetupLessonCountListener();
    ratingOption1To10Select();
    // Legacy listeners (to be refactored)
    OldModalListeners();
    SuggestedFeedbackOptionsSelected();

    // Components
    InitFeedbackModals();

    // Utils
    InitStarRatings();

    Utils.log("info", "Listeners initialized successfully");
  } catch (error) {
    Utils.log("error", "Error initializing listeners:", error);
  }
}

/**
 * Main application initialization
 */
function initializeApp() {
  Utils.log(
    "info",
    `Initializing ${AppConfig.app.name} v${AppConfig.app.version}`
  );

  initializeFeatures();
  initializeListeners();

  Utils.log("info", "Application initialized successfully");
}

// =================== APP STARTUP ===================
document.addEventListener("DOMContentLoaded", initializeApp);

const tabs = document.querySelectorAll(".tabbar .tab");

tabs.forEach((tab) => {
  tab.addEventListener("click", function (e) {
    e.preventDefault(); // Prevent navigation (optional)

    // Remove 'active' class from all tabs
    tabs.forEach((t) => t.classList.remove("active"));

    // Add 'active' to the clicked tab
    this.classList.add("active");
  });
});

document.querySelectorAll(".tabbar .tab").forEach((tab) => {
  tab.addEventListener("click", (e) => {
    e.preventDefault();

    // 1. Toggle "active" class in tabbar
    document
      .querySelectorAll(".tabbar .tab")
      .forEach((t) => t.classList.remove("active"));
    tab.classList.add("active");

    // 2. Find matching desktop trigger and simulate click
    const tabKey = tab.dataset.tab;
    if (tabKey) {
      const desktopTrigger = document.querySelector(
        `.desktop-lg [data-tab="${tabKey}"]`
      );
      if (desktopTrigger) desktopTrigger.click();
    }
  });
});
