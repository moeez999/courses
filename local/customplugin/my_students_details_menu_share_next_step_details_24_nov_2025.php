<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Next Steps – Latingles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Font (similar to Preply) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_students_details_menu_share_next_step_details-main-text: #202124;
            --my_students_details_menu_share_next_step_details-muted-text: #202124;
            --my_students_details_menu_share_next_step_details-border: #f3f4f6;
            --my_students_details_menu_share_next_step_details-bg: #ffffff;
            --my_students_details_menu_share_next_step_details-page-bg: #f1f3f4;
            --my_students_details_menu_share_next_step_details-pill-bg: #f1f3f4;
            --my_students_details_menu_share_next_step_details-pill-border: #dadce0;
            --my_students_details_menu_share_next_step_details-pill-selected-bg: #000000;
            --my_students_details_menu_share_next_step_details-pill-selected-text: #ffffff;
            --my_students_details_menu_share_next_step_details-primary-btn-bg: #6248ff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--my_students_details_menu_share_next_step_details-page-bg);
            font-family: "Roboto", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--my_students_details_menu_share_next_step_details-main-text);
            padding-bottom: 96px;
        }

        .my_students_details_menu_share_next_step_details_page {
            min-height: 100vh;
            display: flex;
            /* justify-content: center; */
        }

        .my_students_details_menu_share_next_step_details_outer_container {
            width: 100%;
            max-width: 1000px;
            background: var(--my_students_details_menu_share_next_step_details-bg);
            padding: 40px 56px 32px;
        }

        @media (max-width: 900px) {
            .my_students_details_menu_share_next_step_details_outer_container {
                padding: 32px 20px 24px;
            }
        }

        /* HEADER */

        .my_students_details_menu_share_next_step_details_main_heading {
            font-size: 32px;
            line-height: 1.25;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .my_students_details_menu_share_next_step_details_main_heading span {
            display: block;
        }

        /* QUICK TIP CARD */

        .my_students_details_menu_share_next_step_details_quick_tip_section {
            margin-top: 32px;
        }

        .my_students_details_menu_share_next_step_details_quick_tip_card {
            width: 100%;
            max-width: 100%;
            background: #f3f4f6;
            border-radius: 5px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid var(--my_students_details_menu_share_next_step_details-border);
        }

        .my_students_details_menu_share_next_step_details_quick_tip_icon_wrapper {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: #e6f4ea;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .my_students_details_menu_share_next_step_details_quick_tip_icon_wrapper img {
            width: 32px;
            height: 32px;
        }

        .my_students_details_menu_share_next_step_details_quick_tip_text_title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .my_students_details_menu_share_next_step_details_quick_tip_text_body {
            font-size: 14px;
            color: var(--my_students_details_menu_share_next_step_details-muted-text);
        }

        .my_students_details_menu_share_next_step_details_quick_tip_text_body span {
            font-weight: 500;
        }

        /* SECTION GENERIC */

        .my_students_details_menu_share_next_step_details_section {
            margin-top: 32px;
        }

        .my_students_details_menu_share_next_step_details_section_title {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .my_students_details_menu_share_next_step_details_section_description {
            font-size: 14px;
            color: var(--my_students_details_menu_share_next_step_details-muted-text);
            margin-bottom: 18px;
        }

        /* SKILLS PILLS */

        .my_students_details_menu_share_next_step_details_skills_wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .my_students_details_menu_share_next_step_details_skill_pill {
            padding: 7px 18px;
            border-radius: 5px;
            border: 1px solid var(--my_students_details_menu_share_next_step_details-pill-border);
            background: var(--my_students_details_menu_share_next_step_details-pill-bg);
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }

        .my_students_details_menu_share_next_step_details_skill_icon_wrapper {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 1px solid #dadce0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .my_students_details_menu_share_next_step_details_skill_icon_wrapper img {
            width: 18px;
            height: 18px;
        }

        .my_students_details_menu_share_next_step_details_skill_pill_selected {
            background: var(--my_students_details_menu_share_next_step_details-pill-selected-bg);
            color: var(--my_students_details_menu_share_next_step_details-pill-selected-text);
            border-color: var(--my_students_details_menu_share_next_step_details-pill-selected-bg);
        }

        .my_students_details_menu_share_next_step_details_skill_pill_selected .my_students_details_menu_share_next_step_details_skill_icon_wrapper {
            border-color: transparent;
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 520px) {
            .my_students_details_menu_share_next_step_details_skill_pill {
                width: 100%;
                justify-content: flex-start;
            }
        }

        /* SUB-SKILL OPTIONS (all skills) */

        .my_students_details_menu_share_next_step_details_commitment_suboptions_wrapper,
        .my_students_details_menu_share_next_step_details_listening_suboptions_wrapper,
        .my_students_details_menu_share_next_step_details_speaking_suboptions_wrapper,
        .my_students_details_menu_share_next_step_details_vocabulary_suboptions_wrapper,
        .my_students_details_menu_share_next_step_details_reading_suboptions_wrapper,
        .my_students_details_menu_share_next_step_details_grammar_suboptions_wrapper,
        .my_students_details_menu_share_next_step_details_writing_suboptions_wrapper {
            margin-top: 12px;
            display: none;
            flex-wrap: wrap;
            gap: 10px;
        }

        .my_students_details_menu_share_next_step_details_commitment_option,
        .my_students_details_menu_share_next_step_details_listening_option,
        .my_students_details_menu_share_next_step_details_speaking_option,
        .my_students_details_menu_share_next_step_details_vocabulary_option,
        .my_students_details_menu_share_next_step_details_reading_option,
        .my_students_details_menu_share_next_step_details_grammar_option,
        .my_students_details_menu_share_next_step_details_writing_option {
            padding: 9px 20px;
            border-radius: 5px;
            border: 1px solid var(--my_students_details_menu_share_next_step_details-border);
            background: #f3f4f6;
            font-size: 14px;
            cursor: pointer;
            transition: border-color 0.15s ease, background 0.15s ease;
        }

        .my_students_details_menu_share_next_step_details_commitment_option_selected,
        .my_students_details_menu_share_next_step_details_listening_option_selected,
        .my_students_details_menu_share_next_step_details_speaking_option_selected,
        .my_students_details_menu_share_next_step_details_vocabulary_option_selected,
        .my_students_details_menu_share_next_step_details_reading_option_selected,
        .my_students_details_menu_share_next_step_details_grammar_option_selected,
        .my_students_details_menu_share_next_step_details_writing_option_selected {
            border-color: #000000;
            background: #ffffff;
        }

        /* INPUT GROUPS */

        .my_students_details_menu_share_next_step_details_input_group {
            margin-top: 24px;
        }

        .my_students_details_menu_share_next_step_details_input_label {
            font-size: 16px;
            font-weight: 500;
            display: block;
            margin-bottom: 4px;
        }

        .my_students_details_menu_share_next_step_details_hint_text {
            font-size: 13px;
            color: var(--my_students_details_menu_share_next_step_details-muted-text);
            margin-bottom: 10px;
        }

        .my_students_details_menu_share_next_step_details_text_input {
            width: 100%;
            border-radius: 6px;
            border: 1px solid var(--my_students_details_menu_share_next_step_details-border);
            padding: 11px 12px;
            font-size: 14px;
            outline: none;
        }

        .my_students_details_menu_share_next_step_details_text_area {
            width: 100%;
            border-radius: 6px;
            border: 1px solid var(--my_students_details_menu_share_next_step_details-border);
            padding: 11px 12px;
            font-size: 14px;
            outline: none;
            resize: vertical;
            min-height: 120px;
        }

        .my_students_details_menu_share_next_step_details_text_area:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 1px #1a73e833;
        }

        .my_students_details_menu_share_next_step_details_char_row {
            display: flex;
            justify-content: flex-end;
            margin-top: 4px;
        }

        .my_students_details_menu_share_next_step_details_char_counter {
            font-size: 12px;
            color: var(--my_students_details_menu_share_next_step_details-muted-text);
        }

        /* LESSONS LIST */

        .my_students_details_menu_share_next_step_details_lessons_container {
            margin-top: 8px;
        }

        .my_students_details_menu_share_next_step_details_lesson_row {
            margin-bottom: 16px;
        }

        .my_students_details_menu_share_next_step_details_lesson_input_wrapper {
            position: relative;
        }

        .my_students_details_menu_share_next_step_details_text_input_lesson {
            width: 100%;
            border-radius: 10px;
            padding-right: 40px;
            border: 1px solid var(--my_students_details_menu_share_next_step_details-border);
            padding: 12px 12px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .my_students_details_menu_share_next_step_details_text_input_lesson:hover,
        .my_students_details_menu_share_next_step_details_text_input_lesson:focus {
            border-color: #000000;
            box-shadow: 0 0 0 1px #0000001a;
        }

        .my_students_details_menu_share_next_step_details_lesson_remove_btn {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            color: #5f6368;
            padding: 0;
        }

        .my_students_details_menu_share_next_step_details_lesson_remove_btn:hover {
            color: #202124;
        }

        .my_students_details_menu_share_next_step_details_add_lesson_link {
            display: inline-block;
            margin-top: 4px;
            font-size: 14px;
            color: #000000;
            text-decoration: underline;
            cursor: pointer;
        }

        .my_students_details_menu_share_next_step_details_add_lesson_link:hover {
            color: #000000;
        }

        /* MESSAGE TEMPLATES (inside textarea) */

        .my_students_details_menu_share_next_step_details_message_wrapper {
            position: relative;
        }

        .my_students_details_menu_share_next_step_details_message_wrapper .my_students_details_menu_share_next_step_details_text_area {
            padding-bottom: 40px;
        }

        .my_students_details_menu_share_next_step_details_templates_row {
            position: absolute;
            left: 16px;
            bottom: 10px;
            margin-top: 0;
        }

        .my_students_details_menu_share_next_step_details_templates_link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #000000;
            cursor: pointer;
        }

        .my_students_details_menu_share_next_step_details_templates_link:hover {
            color: #5b3b1a;
        }

        .my_students_details_menu_share_next_step_details_templates_icon_wrapper {
            width: 18px;
            height: 18px;
            border-radius: 3px;
            border: 1px solid var(--my_students_details_menu_share_next_step_details-border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .my_students_details_menu_share_next_step_details_templates_icon_wrapper img {
            width: 14px;
            height: 14px;
        }

        /* BONUS QUESTION */

        .my_students_details_menu_share_next_step_details_badge_bonus {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 5px;
            background: #e6f4ea;
            color: #137333;
            font-weight: 500;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .my_students_details_menu_share_next_step_details_inline_optional {
            font-size: 13px;
            color: var(--my_students_details_menu_share_next_step_details-muted-text);
            margin-left: 4px;
        }

        /* FIXED FOOTER BAR */

        .my_students_details_menu_share_next_step_details_bottom_bar {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background: #ffffff;
            box-shadow: 0 -1px 4px rgba(60, 64, 67, 0.2);
            z-index: 50;
            padding: 14px 0;
        }

        .my_students_details_menu_share_next_step_details_bottom_bar_inner {
            margin: 0 auto;
            padding: 0 56px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        @media (max-width: 900px) {
            .my_students_details_menu_share_next_step_details_bottom_bar_inner {
                padding: 0 20px;
            }
        }

        .my_students_details_menu_share_next_step_details_button_preview,
        .my_students_details_menu_share_next_step_details_button_save {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 24px;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid transparent;
            font-size: 15px;
            font-weight: 500;
            background: transparent;
            white-space: nowrap;
            margin-right: 100px;
        }

        .my_students_details_menu_share_next_step_details_button_preview {
            border-color: var(--my_students_details_menu_share_next_step_details-border);
            background: #ffffff;
            color: var(--my_students_details_menu_share_next_step_details-main-text);
        }

        .my_students_details_menu_share_next_step_details_button_save {
            background: #f3f0ff;
            border-color: #d3c5ff;
            color: #3c4043;
        }

        .my_students_details_menu_share_next_step_details_button_preview:hover {
            background: #f8f9fa;
        }

        .my_students_details_menu_share_next_step_details_button_save:hover {
            background: #e6ddff;
        }

        .my_students_details_menu_share_next_step_details_button_icon_circle {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1px solid #dadce0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #ffffff;
        }

        .my_students_details_menu_share_next_step_details_button_icon_circle img {
            width: 18px;
            height: 18px;
        }

        .my_students_details_menu_share_next_step_details_button_icon_bookmark_wrapper {
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .my_students_details_menu_share_next_step_details_button_icon_bookmark_wrapper img {
            width: 16px;
            height: 16px;
        }

        @media (max-width: 640px) {
            .my_students_details_menu_share_next_step_details_bottom_bar_inner {
                flex-direction: column;
                align-items: stretch;
            }

            .my_students_details_menu_share_next_step_details_button_preview,
            .my_students_details_menu_share_next_step_details_button_save {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="my_students_details_menu_share_next_step_details_page">
        <div class="my_students_details_menu_share_next_step_details_outer_container">
            <!-- HEADER -->
            <h1 class="my_students_details_menu_share_next_step_details_main_heading">
                <span>Take a moment to draft the next steps for</span>
                <span>Latingles.</span>
            </h1>

            <!-- QUICK TIP -->
            <section class="my_students_details_menu_share_next_step_details_quick_tip_section">
                <div class="my_students_details_menu_share_next_step_details_quick_tip_card">
                    <div class="my_students_details_menu_share_next_step_details_quick_tip_icon_wrapper">
                        <img src="img/my_students/icon_quick_tip_arrow.svg" alt="Quick tip" />
                    </div>
                    <div>
                        <div class="my_students_details_menu_share_next_step_details_quick_tip_text_title">
                            Quick Tip
                        </div>
                        <div class="my_students_details_menu_share_next_step_details_quick_tip_text_body">
                            When learners understand the next steps toward their goal, they’re
                            <span>60% more likely</span> to subscribe.
                        </div>
                    </div>
                </div>
            </section>

            <!-- SKILLS -->
            <section class="my_students_details_menu_share_next_step_details_section">
                <div class="my_students_details_menu_share_next_step_details_section_title">
                    What skills should Latingles focus on next?
                </div>

                <div class="my_students_details_menu_share_next_step_details_skills_wrapper"
                    id="my_students_details_menu_share_next_step_details_skills_wrapper">
                    <button type="button"
                        class="my_students_details_menu_share_next_step_details_skill_pill"
                        data-my_students_details_menu_share_next_step_details-skill="Commitment">
                        <span class="my_students_details_menu_share_next_step_details_skill_icon_wrapper">
                            <img src="img/my_students/icon_commitment.svg" alt="Commitment" />
                        </span>
                        Commitment
                    </button>

                    <button type="button"
                        class="my_students_details_menu_share_next_step_details_skill_pill"
                        data-my_students_details_menu_share_next_step_details-skill="Listening">
                        <span class="my_students_details_menu_share_next_step_details_skill_icon_wrapper">
                            <img src="img/my_students/icon_listening.svg" alt="Listening" />
                        </span>
                        Listening
                    </button>

                    <button type="button"
                        class="my_students_details_menu_share_next_step_details_skill_pill"
                        data-my_students_details_menu_share_next_step_details-skill="Speaking">
                        <span class="my_students_details_menu_share_next_step_details_skill_icon_wrapper">
                            <img src="img/my_students/icon_speaking.svg" alt="Speaking" />
                        </span>
                        Speaking
                    </button>

                    <button type="button"
                        class="my_students_details_menu_share_next_step_details_skill_pill"
                        data-my_students_details_menu_share_next_step_details-skill="Vocabulary">
                        <span class="my_students_details_menu_share_next_step_details_skill_icon_wrapper">
                            <img src="img/my_students/icon_vocabulary.svg" alt="Vocabulary" />
                        </span>
                        Vocabulary
                    </button>

                    <button type="button"
                        class="my_students_details_menu_share_next_step_details_skill_pill"
                        data-my_students_details_menu_share_next_step_details-skill="Reading">
                        <span class="my_students_details_menu_share_next_step_details_skill_icon_wrapper">
                            <img src="img/my_students/icon_reading.svg" alt="Reading" />
                        </span>
                        Reading
                    </button>

                    <button type="button"
                        class="my_students_details_menu_share_next_step_details_skill_pill"
                        data-my_students_details_menu_share_next_step_details-skill="Grammar">
                        <span class="my_students_details_menu_share_next_step_details_skill_icon_wrapper">
                            <img src="img/my_students/icon_grammar.svg" alt="Grammar" />
                        </span>
                        Grammar
                    </button>

                    <button type="button"
                        class="my_students_details_menu_share_next_step_details_skill_pill"
                        data-my_students_details_menu_share_next_step_details-skill="Writing">
                        <span class="my_students_details_menu_share_next_step_details_skill_icon_wrapper">
                            <img src="img/my_students/icon_writing.svg" alt="Writing" />
                        </span>
                        Writing
                    </button>
                </div>

                <!-- Commitment sub-options -->
                <div id="my_students_details_menu_share_next_step_details_commitment_suboptions"
                    class="my_students_details_menu_share_next_step_details_commitment_suboptions_wrapper">
                    <button type="button" class="my_students_details_menu_share_next_step_details_commitment_option">
                        Time talking in lessons
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_commitment_option">
                        Taking risks
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_commitment_option">
                        Using new language
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_commitment_option">
                        Enjoying speaking
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_commitment_option">
                        Preparation
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_commitment_option">
                        Focus on the goal
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_commitment_option">
                        Sounding confident
                    </button>
                </div>

                <!-- Listening sub-options -->
                <div id="my_students_details_menu_share_next_step_details_listening_suboptions"
                    class="my_students_details_menu_share_next_step_details_listening_suboptions_wrapper">
                    <button type="button" class="my_students_details_menu_share_next_step_details_listening_option">
                        Listening for the main idea
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_listening_option">
                        Listening for details
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_listening_option">
                        Offering responses
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_listening_option">
                        Good turn-taking
                    </button>
                </div>

                <!-- Speaking sub-options -->
                <div id="my_students_details_menu_share_next_step_details_speaking_suboptions"
                    class="my_students_details_menu_share_next_step_details_speaking_suboptions_wrapper">
                    <button type="button" class="my_students_details_menu_share_next_step_details_speaking_option">
                        Intonation
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_speaking_option">
                        Organizing ideas
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_speaking_option">
                        Self-correction
                    </button>
                </div>

                <!-- Vocabulary sub-options -->
                <div id="my_students_details_menu_share_next_step_details_vocabulary_suboptions"
                    class="my_students_details_menu_share_next_step_details_vocabulary_suboptions_wrapper">
                    <button type="button" class="my_students_details_menu_share_next_step_details_vocabulary_option">
                        Recognizing new words
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_vocabulary_option">
                        Understanding new words
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_vocabulary_option">
                        Using new words
                    </button>
                </div>

                <!-- Reading sub-options -->
                <div id="my_students_details_menu_share_next_step_details_reading_suboptions"
                    class="my_students_details_menu_share_next_step_details_reading_suboptions_wrapper">
                    <button type="button" class="my_students_details_menu_share_next_step_details_reading_option">
                        Understanding the main idea
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_reading_option">
                        Understanding details
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_reading_option">
                        Understanding variety of texts &amp; articles
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_reading_option">
                        Deducing meaning of unknown words
                    </button>
                </div>

                <!-- Grammar sub-options -->
                <div id="my_students_details_menu_share_next_step_details_grammar_suboptions"
                    class="my_students_details_menu_share_next_step_details_grammar_suboptions_wrapper">
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Sentence structure
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Verb tenses
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Subject-verb agreement
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Active and passive voice
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Prepositions
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Modifiers
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Conjunctions
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Interjections
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_grammar_option">
                        Clauses
                    </button>
                </div>

                <!-- Writing sub-options -->
                <div id="my_students_details_menu_share_next_step_details_writing_suboptions"
                    class="my_students_details_menu_share_next_step_details_writing_suboptions_wrapper">
                    <button type="button" class="my_students_details_menu_share_next_step_details_writing_option">
                        Correct punctuation
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_writing_option">
                        Correct spelling
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_writing_option">
                        Organizing ideas
                    </button>
                    <button type="button" class="my_students_details_menu_share_next_step_details_writing_option">
                        Writing with clarity
                    </button>
                </div>
            </section>

            <!-- TOPICS & MESSAGE -->
            <section class="my_students_details_menu_share_next_step_details_section">

                <!-- Topics (LESSONS LIST) -->
                <div class="my_students_details_menu_share_next_step_details_input_group">
                    <label class="my_students_details_menu_share_next_step_details_input_label">
                        What topics will you cover in the next lessons?
                    </label>
                    <div class="my_students_details_menu_share_next_step_details_section_description">
                        A basic plan can motivate Latingles to keep learning.
                    </div>

                    <div id="my_students_details_menu_share_next_step_details_lessons_container"
                        class="my_students_details_menu_share_next_step_details_lessons_container">
                        <!-- lesson rows added by JS -->
                    </div>

                    <a href="#" id="my_students_details_menu_share_next_step_details_add_lesson_link"
                        class="my_students_details_menu_share_next_step_details_add_lesson_link">
                        Add another lesson
                    </a>
                </div>

                <!-- Message -->
                <div class="my_students_details_menu_share_next_step_details_input_group">
                    <label class="my_students_details_menu_share_next_step_details_input_label"
                        for="my_students_details_menu_share_next_step_details_message_area">
                        Write a short message to Latingles
                    </label>
                    <div class="my_students_details_menu_share_next_step_details_hint_text">
                        You might thank Latingles and introduce the next steps.
                    </div>

                    <div class="my_students_details_menu_share_next_step_details_message_wrapper">
                        <textarea
                            id="my_students_details_menu_share_next_step_details_message_area"
                            class="my_students_details_menu_share_next_step_details_text_area"></textarea>

                        <div class="my_students_details_menu_share_next_step_details_templates_row my_student_details_menu_give_feedback_details_message_template_step1_button_open">
                            <div class="my_students_details_menu_share_next_step_details_templates_link">
                                <span class="my_students_details_menu_share_next_step_details_templates_icon_wrapper">
                                    <img src="img/my_students/icon_message_templates.svg" alt="Templates" />
                                </span>
                                <span>Message templates</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- BONUS QUESTION -->
            <section class="my_students_details_menu_share_next_step_details_section">
                <div class="my_students_details_menu_share_next_step_details_badge_bonus">
                    Bonus question
                </div>

                <div class="my_students_details_menu_share_next_step_details_input_group">
                    <label class="my_students_details_menu_share_next_step_details_input_label"
                        for="my_students_details_menu_share_next_step_details_resources_area">
                        What additional resources would you recommend?
                        <span class="my_students_details_menu_share_next_step_details_inline_optional">· Optional</span>
                    </label>
                    <textarea
                        id="my_students_details_menu_share_next_step_details_resources_area"
                        class="my_students_details_menu_share_next_step_details_text_area"
                        placeholder="Share activities, articles, videos, etc..."></textarea>
                </div>
            </section>
        </div>
    </div>

    <!-- FIXED BOTTOM BAR -->
    <div class="my_students_details_menu_share_next_step_details_bottom_bar">
        <div class="my_students_details_menu_share_next_step_details_bottom_bar_inner">

            <a href="my_students_details_menu_share_next_step_preview.php">
                <button type="button"
                    id="my_students_details_menu_share_next_step_details_button_preview"
                    class="my_students_details_menu_share_next_step_details_button_preview">
                    <span class="my_students_details_menu_share_next_step_details_button_icon_circle">
                        <img src="img/my_students/icon_preview_eye.svg" alt="Preview" />
                    </span>
                    <span>Preview</span>
                </button>
            </a>

            <button type="button"
                id="my_students_details_menu_share_next_step_details_button_save"
                class="my_students_details_menu_share_next_step_details_button_save">
                <span class="my_students_details_menu_share_next_step_details_button_icon_bookmark_wrapper">
                    <img src="img/my_students/icon_save_bookmark.svg" alt="Save" />
                </span>
                <span>Save</span>
            </button>
        </div>
    </div>

    <script>
        var my_students_details_menu_share_next_step_details_maxLessonChars = 100;

        function my_students_details_menu_share_next_step_details_updateLessonCharCount($input) {
            var length = $input.val().length;
            var $counter = $input
                .closest(".my_students_details_menu_share_next_step_details_lesson_row")
                .find(".my_students_details_menu_share_next_step_details_char_counter");

            $counter.text(
                length + "/" +
                my_students_details_menu_share_next_step_details_maxLessonChars +
                " characters"
            );
        }

        function my_students_details_menu_share_next_step_details_renumberLessonPlaceholders() {
            $("#my_students_details_menu_share_next_step_details_lessons_container")
                .find(".my_students_details_menu_share_next_step_details_text_input_lesson")
                .each(function(index) {
                    $(this).attr("placeholder", "Lesson " + (index + 1));
                });
        }

        function my_students_details_menu_share_next_step_details_addLessonRow(isFirst) {
            var $container = $("#my_students_details_menu_share_next_step_details_lessons_container");
            var index = $container.find(".my_students_details_menu_share_next_step_details_lesson_row").length + 1;

            var removeBtnHtml = isFirst ?
                "" :
                '<button type="button" class="my_students_details_menu_share_next_step_details_lesson_remove_btn" aria-label="Remove lesson">✕</button>';

            var rowHtml =
                '<div class="my_students_details_menu_share_next_step_details_lesson_row">' +
                '<div class="my_students_details_menu_share_next_step_details_lesson_input_wrapper">' +
                '<input type="text" ' +
                'maxlength="' + my_students_details_menu_share_next_step_details_maxLessonChars + '" ' +
                'class="my_students_details_menu_share_next_step_details_text_input_lesson" ' +
                'placeholder="Lesson ' + index + '" />' +
                removeBtnHtml +
                '</div>' +
                '<div class="my_students_details_menu_share_next_step_details_char_row">' +
                '<div class="my_students_details_menu_share_next_step_details_char_counter">0/' +
                my_students_details_menu_share_next_step_details_maxLessonChars +
                ' characters</div>' +
                '</div>' +
                '</div>';

            $container.append(rowHtml);
        }

        $(document).ready(function my_students_details_menu_share_next_step_details_ready() {
            // initial lesson row (no remove button)
            my_students_details_menu_share_next_step_details_addLessonRow(true);

            // skill pill click
            $(".my_students_details_menu_share_next_step_details_skill_pill").on("click", function() {
                $(this).toggleClass("my_students_details_menu_share_next_step_details_skill_pill_selected");

                var skill = $(this).data("my_students_details_menu_share_next_step_details-skill");

                // helper to toggle sub-groups
                function handleGroup(skillName, wrapperSelector, optionSelector, selectedClass) {
                    if (skill === skillName) {
                        var isSelected = $(this).hasClass("my_students_details_menu_share_next_step_details_skill_pill_selected");
                        var $sub = $(wrapperSelector);
                        if (isSelected) {
                            $sub.css("display", "flex");
                        } else {
                            $sub.hide();
                            $(optionSelector).removeClass(selectedClass);
                        }
                    }
                }

                handleGroup.call(
                    this,
                    "Commitment",
                    "#my_students_details_menu_share_next_step_details_commitment_suboptions",
                    ".my_students_details_menu_share_next_step_details_commitment_option",
                    "my_students_details_menu_share_next_step_details_commitment_option_selected"
                );

                handleGroup.call(
                    this,
                    "Listening",
                    "#my_students_details_menu_share_next_step_details_listening_suboptions",
                    ".my_students_details_menu_share_next_step_details_listening_option",
                    "my_students_details_menu_share_next_step_details_listening_option_selected"
                );

                handleGroup.call(
                    this,
                    "Speaking",
                    "#my_students_details_menu_share_next_step_details_speaking_suboptions",
                    ".my_students_details_menu_share_next_step_details_speaking_option",
                    "my_students_details_menu_share_next_step_details_speaking_option_selected"
                );

                handleGroup.call(
                    this,
                    "Vocabulary",
                    "#my_students_details_menu_share_next_step_details_vocabulary_suboptions",
                    ".my_students_details_menu_share_next_step_details_vocabulary_option",
                    "my_students_details_menu_share_next_step_details_vocabulary_option_selected"
                );

                handleGroup.call(
                    this,
                    "Reading",
                    "#my_students_details_menu_share_next_step_details_reading_suboptions",
                    ".my_students_details_menu_share_next_step_details_reading_option",
                    "my_students_details_menu_share_next_step_details_reading_option_selected"
                );

                handleGroup.call(
                    this,
                    "Grammar",
                    "#my_students_details_menu_share_next_step_details_grammar_suboptions",
                    ".my_students_details_menu_share_next_step_details_grammar_option",
                    "my_students_details_menu_share_next_step_details_grammar_option_selected"
                );

                handleGroup.call(
                    this,
                    "Writing",
                    "#my_students_details_menu_share_next_step_details_writing_suboptions",
                    ".my_students_details_menu_share_next_step_details_writing_option",
                    "my_students_details_menu_share_next_step_details_writing_option_selected"
                );
            });

            // multi-select handlers for all sub-groups
            $("#my_students_details_menu_share_next_step_details_commitment_suboptions")
                .on("click", ".my_students_details_menu_share_next_step_details_commitment_option", function() {
                    $(this).toggleClass("my_students_details_menu_share_next_step_details_commitment_option_selected");
                });

            $("#my_students_details_menu_share_next_step_details_listening_suboptions")
                .on("click", ".my_students_details_menu_share_next_step_details_listening_option", function() {
                    $(this).toggleClass("my_students_details_menu_share_next_step_details_listening_option_selected");
                });

            $("#my_students_details_menu_share_next_step_details_speaking_suboptions")
                .on("click", ".my_students_details_menu_share_next_step_details_speaking_option", function() {
                    $(this).toggleClass("my_students_details_menu_share_next_step_details_speaking_option_selected");
                });

            $("#my_students_details_menu_share_next_step_details_vocabulary_suboptions")
                .on("click", ".my_students_details_menu_share_next_step_details_vocabulary_option", function() {
                    $(this).toggleClass("my_students_details_menu_share_next_step_details_vocabulary_option_selected");
                });

            $("#my_students_details_menu_share_next_step_details_reading_suboptions")
                .on("click", ".my_students_details_menu_share_next_step_details_reading_option", function() {
                    $(this).toggleClass("my_students_details_menu_share_next_step_details_reading_option_selected");
                });

            $("#my_students_details_menu_share_next_step_details_grammar_suboptions")
                .on("click", ".my_students_details_menu_share_next_step_details_grammar_option", function() {
                    $(this).toggleClass("my_students_details_menu_share_next_step_details_grammar_option_selected");
                });

            $("#my_students_details_menu_share_next_step_details_writing_suboptions")
                .on("click", ".my_students_details_menu_share_next_step_details_writing_option", function() {
                    $(this).toggleClass("my_students_details_menu_share_next_step_details_writing_option_selected");
                });

            // delegated input handler for lessons char counter
            $("#my_students_details_menu_share_next_step_details_lessons_container")
                .on("input", ".my_students_details_menu_share_next_step_details_text_input_lesson", function() {
                    my_students_details_menu_share_next_step_details_updateLessonCharCount($(this));
                });

            // add another lesson
            $("#my_students_details_menu_share_next_step_details_add_lesson_link").on("click", function(e) {
                e.preventDefault();
                my_students_details_menu_share_next_step_details_addLessonRow(false);
                my_students_details_menu_share_next_step_details_renumberLessonPlaceholders();
            });

            // remove lesson
            $("#my_students_details_menu_share_next_step_details_lessons_container")
                .on("click", ".my_students_details_menu_share_next_step_details_lesson_remove_btn", function() {
                    $(this)
                        .closest(".my_students_details_menu_share_next_step_details_lesson_row")
                        .remove();
                    my_students_details_menu_share_next_step_details_renumberLessonPlaceholders();
                });

            $("#my_students_details_menu_share_next_step_details_button_save").on("click", function() {
                alert("Save clicked – hook your save logic here.");
            });
        });
    </script>

    <?php
    require_once('my_students_details_menu_give_feedback_details_message_template.php');
    ?>


</body>

</html>