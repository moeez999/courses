<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Progress Areas Modal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --my_students_details_menu_give_feedback_edit_bg: #ffffff;
            --my_students_details_menu_give_feedback_edit_text: #111827;
            --my_students_details_menu_give_feedback_edit_muted: #6b7280;
            --my_students_details_menu_give_feedback_edit_border: #e5e7eb;
            --my_students_details_menu_give_feedback_edit_chip_border: #d1d5db;
            --my_students_details_menu_give_feedback_edit_chip_selected_bg: #111827;
            --my_students_details_menu_give_feedback_edit_chip_selected_text: #ffffff;
            --my_students_details_menu_give_feedback_edit_overlay: rgba(15, 23, 42, 0.6);
            --my_students_details_menu_give_feedback_edit_footer_bg: #f9fafb;
            --my_students_details_menu_give_feedback_edit_save_bg: #ef4444;
            --my_students_details_menu_give_feedback_edit_save_bg_hover: #b91c1c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f3f4f6;
            color: var(--my_students_details_menu_give_feedback_edit_text);
        }

        .my_students_details_menu_give_feedback_edit_page_wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* Overlay & modal */
        .my_students_details_menu_give_feedback_edit_modal_overlay {
            position: fixed;
            inset: 0;
            background: var(--my_students_details_menu_give_feedback_edit_overlay);
            display: none;
            align-items: flex-start;
            justify-content: center;
            z-index: 50;
        }

        .my_students_details_menu_give_feedback_edit_modal_overlay.my_students_details_menu_give_feedback_edit_modal_open {
            display: flex;
        }

        .my_students_details_menu_give_feedback_edit_modal {
            background: var(--my_students_details_menu_give_feedback_edit_bg);
            border-radius: 5px;
            width: 100%;
            max-width: 840px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.25);
            overflow: hidden;
            margin-top: 60px;
            /* space from top header */
        }

        .my_students_details_menu_give_feedback_edit_modal_header {
            padding: 24px 32px 16px;
            border-bottom: 1px solid var(--my_students_details_menu_give_feedback_edit_border);
        }

        .my_students_details_menu_give_feedback_edit_modal_title {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
        }

        .my_students_details_menu_give_feedback_edit_modal_body {
            padding: 16px 32px 8px;
            overflow-y: auto;
        }

        .my_students_details_menu_give_feedback_edit_section_group {
            margin-bottom: 24px;
        }

        .my_students_details_menu_give_feedback_edit_section_header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .my_students_details_menu_give_feedback_edit_section_icon {
            font-size: 18px;
        }

        .my_students_details_menu_give_feedback_edit_section_title {
            font-size: 16px;
            font-weight: 600;
        }

        .my_students_details_menu_give_feedback_edit_chip_row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .my_students_details_menu_give_feedback_edit_chip {
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 14px;
            border: 1px solid var(--my_students_details_menu_give_feedback_edit_chip_border);
            background: #ffffff;
            cursor: pointer;
            font-weight: 500;
            white-space: nowrap;
            transition: background 0.15s ease, box-shadow 0.15s ease, transform 0.05s ease;
        }

        .my_students_details_menu_give_feedback_edit_chip:hover {
            box-shadow: 0 3px 8px rgba(15, 23, 42, 0.18);
        }

        .my_students_details_menu_give_feedback_edit_chip:active {
            transform: translateY(1px);
        }

        .my_students_details_menu_give_feedback_edit_chip.my_students_details_menu_give_feedback_edit_chip_selected {
            background: var(--my_students_details_menu_give_feedback_edit_chip_selected_bg);
            color: var(--my_students_details_menu_give_feedback_edit_chip_selected_text);
            border-color: #000000;
        }

        .my_students_details_menu_give_feedback_edit_divider {
            height: 1px;
            background: var(--my_students_details_menu_give_feedback_edit_border);
            margin: 16px 0;
        }

        .my_students_details_menu_give_feedback_edit_specific_label {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .my_students_details_menu_give_feedback_edit_specific_helper {
            font-size: 13px;
            color: var(--my_students_details_menu_give_feedback_edit_muted);
            margin-bottom: 10px;
        }

        /* Note area like Figma */
        .my_students_details_menu_give_feedback_edit_note_input_wrapper {
            border: none;
            padding: 0;
            background: transparent;
        }

        .my_students_details_menu_give_feedback_edit_note_label {
            font-size: 13px;
            color: var(--my_students_details_menu_give_feedback_edit_muted);
            margin-bottom: 4px;
        }

        .my_students_details_menu_give_feedback_edit_note_input {
            width: 100%;
            border-radius: 12px;
            border: 1px solid var(--my_students_details_menu_give_feedback_edit_border);
            padding: 10px 12px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            background: #ffffff;
        }

        .my_students_details_menu_give_feedback_edit_note_input::placeholder {
            color: #9ca3af;
        }

        .my_students_details_menu_give_feedback_edit_note_footer {
            display: flex;
            justify-content: flex-end;
            font-size: 12px;
            color: var(--my_students_details_menu_give_feedback_edit_muted);
            margin-top: 4px;
        }

        .my_students_details_menu_give_feedback_edit_modal_footer {
            border-top: 1px solid var(--my_students_details_menu_give_feedback_edit_border);
            background: var(--my_students_details_menu_give_feedback_edit_footer_bg);
            padding: 12px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .my_students_details_menu_give_feedback_edit_selected_counter {
            font-size: 14px;
            color: var(--my_students_details_menu_give_feedback_edit_muted);
        }

        .my_students_details_menu_give_feedback_edit_footer_actions {
            display: flex;
            gap: 8px;
        }

        .my_students_details_menu_give_feedback_edit_button {
            min-width: 96px;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: 2px solid #000000;
            background: #ffffff;
            transition: box-shadow 0.15s ease, transform 0.05s ease, background 0.15s ease;
        }

        .my_students_details_menu_give_feedback_edit_button:hover {
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }

        .my_students_details_menu_give_feedback_edit_button:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        .my_students_details_menu_give_feedback_edit_button_primary {
            background: var(--my_students_details_menu_give_feedback_edit_save_bg);
            color: #ffffff;
        }

        .my_students_details_menu_give_feedback_edit_button_primary:hover {
            background: var(--my_students_details_menu_give_feedback_edit_save_bg_hover);
            box-shadow: 0 4px 12px rgba(248, 113, 113, 0.45);
        }

        @media (max-width: 768px) {
            .my_students_details_menu_give_feedback_edit_modal {
                max-width: 100%;
                max-height: 100vh;
                border-radius: 0;
                margin-top: 32px;
            }

            .my_students_details_menu_give_feedback_edit_modal_header,
            .my_students_details_menu_give_feedback_edit_modal_body,
            .my_students_details_menu_give_feedback_edit_modal_footer {
                padding-left: 16px;
                padding-right: 16px;
            }
        }

        @media (max-width: 480px) {
            .my_students_details_menu_give_feedback_edit_modal_title {
                font-size: 18px;
            }

            .my_students_details_menu_give_feedback_edit_footer_actions {
                width: 100%;
                justify-content: flex-end;
            }

            .my_students_details_menu_give_feedback_edit_button {
                min-width: 0;
                padding-inline: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="my_students_details_menu_give_feedback_edit_page_wrapper">
        <!-- Edit button that opens modal -->
        
        <!-- <button type="button"
            class="my_students_details_menu_give_feedback_edit_open_button"
            id="my_students_details_menu_give_feedback_edit_open_button">
            Edit
        </button> -->


    </div>

    <!-- Modal -->
    <div class="my_students_details_menu_give_feedback_edit_modal_overlay"
        id="my_students_details_menu_give_feedback_edit_modal_overlay">
        <div class="my_students_details_menu_give_feedback_edit_modal"
            id="my_students_details_menu_give_feedback_edit_modal">
            <div class="my_students_details_menu_give_feedback_edit_modal_header">
                <h2 class="my_students_details_menu_give_feedback_edit_modal_title">
                    Choose up to 3 areas where you’ve seen progress
                </h2>
            </div>

            <div class="my_students_details_menu_give_feedback_edit_modal_body">
                <!-- Effort -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_section_header">
                        <span class="my_students_details_menu_give_feedback_edit_section_icon">💪</span>
                        <span class="my_students_details_menu_give_feedback_edit_section_title">Effort</span>
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_chip_row">
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Time talking in lessons</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Motivation</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Curiosity</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Out-of-class activities</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Taking regular lessons</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Willing to experiment</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Effective learning techniques</button>
                    </div>
                </div>

                <!-- Speaking -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_section_header">
                        <span class="my_students_details_menu_give_feedback_edit_section_icon">💬</span>
                        <span class="my_students_details_menu_give_feedback_edit_section_title">Speaking</span>
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_chip_row">
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Fluency</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Clarity</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Pronunciation</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Sounding confident</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Organising ideas</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Self-correction</button>
                    </div>
                </div>

                <!-- Listening -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_section_header">
                        <span class="my_students_details_menu_give_feedback_edit_section_icon">🔊</span>
                        <span class="my_students_details_menu_give_feedback_edit_section_title">Listening</span>
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_chip_row">
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Listening for the main idea</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Listening for details</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Offering responses</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Good turn-taking</button>
                    </div>
                </div>

                <!-- Vocabulary -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_section_header">
                        <span class="my_students_details_menu_give_feedback_edit_section_icon">🧠</span>
                        <span class="my_students_details_menu_give_feedback_edit_section_title">Vocabulary</span>
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_chip_row">
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Recognising new words</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Understanding new words</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Using new words</button>
                    </div>
                </div>

                <!-- Grammar -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_section_header">
                        <span class="my_students_details_menu_give_feedback_edit_section_icon">⚙️</span>
                        <span class="my_students_details_menu_give_feedback_edit_section_title">Grammar</span>
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_chip_row">
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Using a variety of structures</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Accuracy</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Self-correction</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Experimenting with new grammar</button>
                    </div>
                </div>

                <!-- Reading -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_section_header">
                        <span class="my_students_details_menu_give_feedback_edit_section_icon">📖</span>
                        <span class="my_students_details_menu_give_feedback_edit_section_title">Reading</span>
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_chip_row">
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Understanding the main idea</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Understanding details</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Understanding variety of texts &amp; articles</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Deducing meaning of unknown words</button>
                    </div>
                </div>

                <!-- Writing -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_section_header">
                        <span class="my_students_details_menu_give_feedback_edit_section_icon">✍️</span>
                        <span class="my_students_details_menu_give_feedback_edit_section_title">Writing</span>
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_chip_row">
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Correct punctuation</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Correct spelling</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Organising ideas</button>
                        <button type="button" class="my_students_details_menu_give_feedback_edit_chip">Writing with clarity</button>
                    </div>
                </div>

                <div class="my_students_details_menu_give_feedback_edit_divider"></div>

                <!-- Something specific -->
                <div class="my_students_details_menu_give_feedback_edit_section_group">
                    <div class="my_students_details_menu_give_feedback_edit_specific_label">
                        Something specific to highlight?
                    </div>
                    <div class="my_students_details_menu_give_feedback_edit_specific_helper">
                        Use this space to quickly mention a unique progress point not captured in the list above.
                    </div>

                    <div class="my_students_details_menu_give_feedback_edit_note_input_wrapper">
                        <div class="my_students_details_menu_give_feedback_edit_note_label">
                            Add a note · Optional
                        </div>
                        <input type="text"
                            id="my_students_details_menu_give_feedback_edit_note_input"
                            maxlength="100"
                            class="my_students_details_menu_give_feedback_edit_note_input"
                            placeholder="E.g. Your consonant pronunciation is improving!">
                        <div class="my_students_details_menu_give_feedback_edit_note_footer">
                            <span id="my_students_details_menu_give_feedback_edit_note_counter">0/100 characters</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my_students_details_menu_give_feedback_edit_modal_footer">
                <div class="my_students_details_menu_give_feedback_edit_selected_counter"
                    id="my_students_details_menu_give_feedback_edit_selected_counter">
                    0/3 areas
                </div>

                <div class="my_students_details_menu_give_feedback_edit_footer_actions">
                    <button type="button"
                        class="my_students_details_menu_give_feedback_edit_button"
                        id="my_students_details_menu_give_feedback_edit_cancel_button">
                        Cancel
                    </button>
                    <button type="button"
                        class="my_students_details_menu_give_feedback_edit_button my_students_details_menu_give_feedback_edit_button_primary"
                        id="my_students_details_menu_give_feedback_edit_save_button">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (still included, but logic below uses vanilla JS so it works even if this fails) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        const my_students_details_menu_give_feedback_edit_max_areas = 3;

        function my_students_details_menu_give_feedback_edit_update_selected_counter() {
            const selectedCount = document.querySelectorAll(
                ".my_students_details_menu_give_feedback_edit_chip_selected"
            ).length;

            const counterEl = document.getElementById(
                "my_students_details_menu_give_feedback_edit_selected_counter"
            );

            if (counterEl) {
                counterEl.textContent =
                    selectedCount + "/" +
                    my_students_details_menu_give_feedback_edit_max_areas +
                    " areas";
            }
        }

        function my_students_details_menu_give_feedback_edit_update_note_counter() {
            const input = document.getElementById(
                "my_students_details_menu_give_feedback_edit_note_input"
            );
            const counterEl = document.getElementById(
                "my_students_details_menu_give_feedback_edit_note_counter"
            );

            if (input && counterEl) {
                const length = input.value.length;
                counterEl.textContent = length + "/100 characters";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const overlay = document.getElementById(
                "my_students_details_menu_give_feedback_edit_modal_overlay"
            );
            const openBtn = document.getElementById(
                "my_students_details_menu_give_feedback_edit_open_button"
            );
            const cancelBtn = document.getElementById(
                "my_students_details_menu_give_feedback_edit_cancel_button"
            );
            const saveBtn = document.getElementById(
                "my_students_details_menu_give_feedback_edit_save_button"
            );
            const noteInput = document.getElementById(
                "my_students_details_menu_give_feedback_edit_note_input"
            );
            const chips = document.querySelectorAll(
                ".my_students_details_menu_give_feedback_edit_chip"
            );

            function openModal() {
                if (overlay) {
                    overlay.classList.add(
                        "my_students_details_menu_give_feedback_edit_modal_open"
                    );
                }
            }

            function closeModal() {
                if (overlay) {
                    overlay.classList.remove(
                        "my_students_details_menu_give_feedback_edit_modal_open"
                    );
                }
            }

            if (openBtn) {
                openBtn.addEventListener("click", openModal);
            }

            if (cancelBtn) {
                cancelBtn.addEventListener("click", closeModal);
            }

            // Click outside to close
            if (overlay) {
                overlay.addEventListener("click", function(e) {
                    if (e.target === overlay) {
                        closeModal();
                    }
                });
            }

            // Chips logic: all clickable, max 3 selected
            chips.forEach(function(chip) {
                chip.addEventListener("click", function() {
                    const isSelected = chip.classList.contains(
                        "my_students_details_menu_give_feedback_edit_chip_selected"
                    );

                    if (isSelected) {
                        chip.classList.remove(
                            "my_students_details_menu_give_feedback_edit_chip_selected"
                        );
                    } else {
                        const currentCount = document.querySelectorAll(
                            ".my_students_details_menu_give_feedback_edit_chip_selected"
                        ).length;

                        if (currentCount >= my_students_details_menu_give_feedback_edit_max_areas) {
                            return; // do nothing if already 3 selected
                        }

                        chip.classList.add(
                            "my_students_details_menu_give_feedback_edit_chip_selected"
                        );
                    }

                    my_students_details_menu_give_feedback_edit_update_selected_counter();
                });
            });

            // Note input counter
            if (noteInput) {
                noteInput.addEventListener("input", function() {
                    my_students_details_menu_give_feedback_edit_update_note_counter();
                });
                my_students_details_menu_give_feedback_edit_update_note_counter();
            }

            // Save button demo
            if (saveBtn) {
                saveBtn.addEventListener("click", function() {
                    const selectedLabels = [];
                    document
                        .querySelectorAll(
                            ".my_students_details_menu_give_feedback_edit_chip_selected"
                        )
                        .forEach(function(chip) {
                            selectedLabels.push(chip.textContent.trim());
                        });

                    const noteValue = noteInput ? noteInput.value : "";

                    console.log("Selected areas:", selectedLabels);
                    console.log("Note:", noteValue);

                    closeModal();
                });
            }

            // Initial counter
            my_students_details_menu_give_feedback_edit_update_selected_counter();
        });
    </script>
</body>

</html>