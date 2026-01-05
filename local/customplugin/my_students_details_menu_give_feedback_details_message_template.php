<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Message Templates Multistep Modal</title>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        /* ==================== PAGE WRAPPER ==================== */
        body.my_student_details_menu_give_feedback_details_message_template_step1_body_no_scroll,
        body.my_students_details_menu_give_feedback_details_message_template_step2_body_no_scroll {
            overflow: hidden;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_page_wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f5f5f7;
            padding: 20px;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }


        /* ==================== MODAL OVERLAY & DIALOG – STEP 1 ==================== */

        #my_student_details_menu_give_feedback_details_message_template_step1_modal_overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 16px;
            box-sizing: border-box;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_modal_dialog {
            background: #ffffff;
            border-radius: 5px;
            max-width: 480px;
            width: 100%;
            padding: 24px 24px 20px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.25);
            position: relative;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_modal_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 8px;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_modal_title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_modal_close_button {
            background: transparent;
            border: none;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_modal_close_button:hover {
            color: #111827;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_modal_description {
            font-size: 13px;
            color: #4b5563;
            margin: 0 0 16px;
            line-height: 1.4;
        }

        /* ==================== TEMPLATE LIST – STEP 1 ==================== */
        .my_student_details_menu_give_feedback_details_message_template_step1_template_list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 18px;
            max-height: 260px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_item {
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 10px 12px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            cursor: pointer;
            transition: box-shadow 0.15s ease, border-color 0.15s ease, transform 0.1s ease;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_item:hover {
            border-color: #ff3b30;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
            transform: translateY(-1px);
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_text_wrapper {
            flex: 1 1 auto;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_title {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 2px;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_preview {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.35;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button {
            background: transparent;
            border: none;
            cursor: pointer;
            flex: 0 0 auto;
            padding: 4px;
            color: #000000;
            font-size: 16px;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button_icon {
            font-size: 16px;
            color: #000000;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button:hover {
            opacity: 0.8;
        }

        /* ==================== ADD NEW TEMPLATE BUTTON – STEP 1 ==================== */
        .my_student_details_menu_give_feedback_details_message_template_step1_add_button {
            width: 100%;
            border-radius: 5px;
            border: 2px solid #000;
            background: #ff3b30;
            color: #ffffff;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 4px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
            transition: box-shadow 0.15s ease, transform 0.1s ease, filter 0.1s ease;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_add_button:hover {
            filter: brightness(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.28);
            transform: translateY(-1px);
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_add_button_icon {
            font-size: 18px;
            line-height: 1;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_list::-webkit-scrollbar {
            width: 6px;
        }

        .my_student_details_menu_give_feedback_details_message_template_step1_template_list::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 999px;
        }

        /* ==================== MODAL – STEP 2 (Add / Edit Template) ==================== */

        #my_students_details_menu_give_feedback_details_message_template_step2_modal_overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            padding: 16px;
            box-sizing: border-box;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_modal_dialog {
            background: #ffffff;
            border-radius: 5px;
            max-width: 480px;
            width: 100%;
            padding: 24px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.25);
            position: relative;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_modal_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_modal_title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #111827;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_modal_close_button {
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_modal_close_button:hover {
            color: #111827;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_field_group {
            margin-bottom: 16px;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_label {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
            display: block;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_input,
        .my_students_details_menu_give_feedback_details_message_template_step2_textarea {
            width: 100%;
            border-radius: 5px;
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            font-size: 13px;
            box-sizing: border-box;
            outline: none;
            resize: vertical;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_input:focus,
        .my_students_details_menu_give_feedback_details_message_template_step2_textarea:focus {
            border-color: #111827;
            box-shadow: 0 0 0 1px #11182710;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_helper {
            font-size: 11px;
            color: #6b7280;
            margin-top: 4px;
        }

        .my_students_details_menu_give_feedback_details_message_template_step2_textarea {
            min-height: 120px;
        }

        /* Save button – default (disabled) */
        #my_students_details_menu_give_feedback_details_message_template_step2_save_button {
            width: 120px;
            height: 40px;
            border-radius: 5px;
            border: 2px solid #000;
            background: #e5e7eb;
            color: #4b5563;
            font-weight: 600;
            cursor: not-allowed;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
            transition: box-shadow 0.15s ease, transform 0.1s ease, filter 0.1s ease, background 0.1s ease, color 0.1s ease;
        }

        /* Save button – ACTIVE */
        #my_students_details_menu_give_feedback_details_message_template_step2_save_button.my_students_details_menu_give_feedback_details_message_template_step2_save_button_active {
            background: #ff3b30;
            color: #ffffff;
            cursor: pointer;
        }

        #my_students_details_menu_give_feedback_details_message_template_step2_save_button.my_students_details_menu_give_feedback_details_message_template_step2_save_button_active:hover {
            filter: brightness(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.28);
            transform: translateY(-1px);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 640px) {

            .my_student_details_menu_give_feedback_details_message_template_step1_modal_dialog,
            .my_students_details_menu_give_feedback_details_message_template_step2_modal_dialog {
                max-width: 100%;
                width: 100%;
                padding: 18px 16px 16px;
            }

            .my_student_details_menu_give_feedback_details_message_template_step1_modal_title,
            .my_students_details_menu_give_feedback_details_message_template_step2_modal_title {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- ======================= STEP 1 MODAL ======================= -->
    <div
        id="my_student_details_menu_give_feedback_details_message_template_step1_modal_overlay"
        aria-hidden="true">
        <div
            class="my_student_details_menu_give_feedback_details_message_template_step1_modal_dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="my_student_details_menu_give_feedback_details_message_template_step1_modal_title_id">
            <div class="my_student_details_menu_give_feedback_details_message_template_step1_modal_header">
                <h2
                    id="my_student_details_menu_give_feedback_details_message_template_step1_modal_title_id"
                    class="my_student_details_menu_give_feedback_details_message_template_step1_modal_title">
                    Your message templates
                </h2>
                <button
                    type="button"
                    class="my_student_details_menu_give_feedback_details_message_template_step1_modal_close_button"
                    aria-label="Close">
                    &times;
                </button>
            </div>

            <p class="my_student_details_menu_give_feedback_details_message_template_step1_modal_description">
                Save time on writing similar messages. Choose a template to add it to your message and personalize it before sending.
            </p>

            <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_list">
                <!-- Template 1 -->
                <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_item">
                    <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_text_wrapper">
                        <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_title">
                            Reserve weekly spot
                        </div>
                        <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_preview">
                            Hi [Student name], I see you've scheduled single lessons for 3 weeks in a row at the same day and time...
                        </div>
                    </div>
                    <button
                        type="button"
                        class="my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button"
                        aria-label="Edit template Reserve weekly spot">
                        <span class="my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button_icon">✎</span>
                    </button>
                </div>

                <!-- Template 2 -->
                <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_item">
                    <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_text_wrapper">
                        <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_title">
                            PARA PERSONAS QUE NO QUIEREN CLASES
                        </div>
                        <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_preview">
                            Good morning XXX! Thanks for contacting me. Right now, I just teach Spanish through this platform...
                        </div>
                    </div>
                    <button
                        type="button"
                        class="my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button"
                        aria-label="Edit template PARA PERSONAS QUE NO QUIEREN CLASES">
                        <span class="my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button_icon">✎</span>
                    </button>
                </div>

                <!-- Template 3 -->
                <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_item">
                    <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_text_wrapper">
                        <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_title">
                            PRIMER CONTACTO ING
                        </div>
                        <div class="my_student_details_menu_give_feedback_details_message_template_step1_template_preview">
                            Hello XXX! I hope you’re great. I saw that you were interested in my profile and I would like to know more about your goals...
                        </div>
                    </div>
                    <button
                        type="button"
                        class="my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button"
                        aria-label="Edit template PRIMER CONTACTO ING">
                        <span class="my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button_icon">✎</span>
                    </button>
                </div>
            </div>

            <button
                type="button"
                class="my_student_details_menu_give_feedback_details_message_template_step1_add_button">
                <span class="my_student_details_menu_give_feedback_details_message_template_step1_add_button_icon">+</span>
                <span>Add a new template</span>
            </button>
        </div>
    </div>

    <!-- ======================= STEP 2 MODAL ======================= -->
    <div
        id="my_students_details_menu_give_feedback_details_message_template_step2_modal_overlay"
        aria-hidden="true">
        <div
            class="my_students_details_menu_give_feedback_details_message_template_step2_modal_dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="my_students_details_menu_give_feedback_details_message_template_step2_modal_title_id">
            <div class="my_students_details_menu_give_feedback_details_message_template_step2_modal_header">
                <h2
                    id="my_students_details_menu_give_feedback_details_message_template_step2_modal_title_id"
                    class="my_students_details_menu_give_feedback_details_message_template_step2_modal_title">
                    Add a new template
                </h2>
                <button
                    type="button"
                    class="my_students_details_menu_give_feedback_details_message_template_step2_modal_close_button"
                    aria-label="Close">
                    &times;
                </button>
            </div>

            <!-- Title field -->
            <div class="my_students_details_menu_give_feedback_details_message_template_step2_field_group">
                <label
                    for="my_students_details_menu_give_feedback_details_message_template_step2_title_input"
                    class="my_students_details_menu_give_feedback_details_message_template_step2_label">
                    Title
                </label>
                <input
                    type="text"
                    id="my_students_details_menu_give_feedback_details_message_template_step2_title_input"
                    class="my_students_details_menu_give_feedback_details_message_template_step2_input"
                    placeholder="Reserve weekly spot" />
                <div class="my_students_details_menu_give_feedback_details_message_template_step2_helper">
                    Only visible to you so you can find the template faster
                </div>
            </div>

            <!-- Message field -->
            <div class="my_students_details_menu_give_feedback_details_message_template_step2_field_group">
                <label
                    for="my_students_details_menu_give_feedback_details_message_template_step2_message_textarea"
                    class="my_students_details_menu_give_feedback_details_message_template_step2_label">
                    Message
                </label>
                <textarea
                    id="my_students_details_menu_give_feedback_details_message_template_step2_message_textarea"
                    class="my_students_details_menu_give_feedback_details_message_template_step2_textarea"
                    placeholder="Hi [Student name], I see you’ve scheduled single lessons..."></textarea>
                <div class="my_students_details_menu_give_feedback_details_message_template_step2_helper">
                    You’ll be able to personalize the message before sending it
                </div>
            </div>

            <!-- Save button -->
            <button
                type="button"
                id="my_students_details_menu_give_feedback_details_message_template_step2_save_button">
                Save
            </button>
        </div>
    </div>

    <!-- ======================= SCRIPT ======================= -->
    <script>
        /* ---------- STEP 1 MODAL JS ---------- */
        var my_student_details_menu_give_feedback_details_message_template_step1_is_modal_open = false;

        function my_student_details_menu_give_feedback_details_message_template_step1_open_modal() {
            var $overlay = $('#my_student_details_menu_give_feedback_details_message_template_step1_modal_overlay');

            $overlay
                .css('display', 'flex')
                .hide()
                .fadeIn(150);

            $('body').addClass('my_student_details_menu_give_feedback_details_message_template_step1_body_no_scroll');
            my_student_details_menu_give_feedback_details_message_template_step1_is_modal_open = true;
        }

        function my_student_details_menu_give_feedback_details_message_template_step1_close_modal() {
            var $overlay = $('#my_student_details_menu_give_feedback_details_message_template_step1_modal_overlay');

            $overlay.fadeOut(150, function() {
                $(this).hide();
            });

            $('body').removeClass('my_student_details_menu_give_feedback_details_message_template_step1_body_no_scroll');
            my_student_details_menu_give_feedback_details_message_template_step1_is_modal_open = false;
        }

        /* ---------- STEP 2 MODAL JS ---------- */
        var my_students_details_menu_give_feedback_details_message_template_step2_is_modal_open = false;

        function my_students_details_menu_give_feedback_details_message_template_step2_update_save_button_state() {
            var titleVal = $.trim($('#my_students_details_menu_give_feedback_details_message_template_step2_title_input').val());
            var messageVal = $.trim($('#my_students_details_menu_give_feedback_details_message_template_step2_message_textarea').val());
            var $saveBtn = $('#my_students_details_menu_give_feedback_details_message_template_step2_save_button');

            if (titleVal.length > 0 && messageVal.length > 0) {
                $saveBtn
                    .addClass('my_students_details_menu_give_feedback_details_message_template_step2_save_button_active')
                    .prop('disabled', false);
            } else {
                $saveBtn
                    .removeClass('my_students_details_menu_give_feedback_details_message_template_step2_save_button_active')
                    .prop('disabled', true);
            }
        }

        function my_students_details_menu_give_feedback_details_message_template_step2_open_modal(prefillTitle, prefillMessage) {
            var $overlay = $('#my_students_details_menu_give_feedback_details_message_template_step2_modal_overlay');

            // Pre-fill fields if values are provided (or clear if empty strings)
            if (typeof prefillTitle === 'string') {
                $('#my_students_details_menu_give_feedback_details_message_template_step2_title_input').val($.trim(prefillTitle));
            }
            if (typeof prefillMessage === 'string') {
                $('#my_students_details_menu_give_feedback_details_message_template_step2_message_textarea').val($.trim(prefillMessage));
            }

            // Update save button state
            my_students_details_menu_give_feedback_details_message_template_step2_update_save_button_state();

            $overlay
                .css('display', 'flex')
                .hide()
                .fadeIn(150);

            $('body').addClass('my_students_details_menu_give_feedback_details_message_template_step2_body_no_scroll');
            my_students_details_menu_give_feedback_details_message_template_step2_is_modal_open = true;
        }

        function my_students_details_menu_give_feedback_details_message_template_step2_close_modal() {
            var $overlay = $('#my_students_details_menu_give_feedback_details_message_template_step2_modal_overlay');

            $overlay.fadeOut(150, function() {
                $(this).hide();
            });

            $('body').removeClass('my_students_details_menu_give_feedback_details_message_template_step2_body_no_scroll');
            my_students_details_menu_give_feedback_details_message_template_step2_is_modal_open = false;
        }

        $(document).ready(function() {
            /* ----- Step 1 open button ----- */
            $('.my_student_details_menu_give_feedback_details_message_template_step1_button_open').on('click', function() {
                my_student_details_menu_give_feedback_details_message_template_step1_open_modal();
            });

            /* ----- Step 1 close button & overlay click ----- */
            $('.my_student_details_menu_give_feedback_details_message_template_step1_modal_close_button').on('click', function() {
                my_student_details_menu_give_feedback_details_message_template_step1_close_modal();
            });

            $('#my_student_details_menu_give_feedback_details_message_template_step1_modal_overlay').on('click', function(event) {
                if (event.target === this) {
                    my_student_details_menu_give_feedback_details_message_template_step1_close_modal();
                }
            });

            /* ----- Step 2 close button & overlay click ----- */
            $('.my_students_details_menu_give_feedback_details_message_template_step2_modal_close_button').on('click', function() {
                my_students_details_menu_give_feedback_details_message_template_step2_close_modal();
            });

            $('#my_students_details_menu_give_feedback_details_message_template_step2_modal_overlay').on('click', function(event) {
                if (event.target === this) {
                    my_students_details_menu_give_feedback_details_message_template_step2_close_modal();
                }
            });

            /* ----- ESC key closes whichever modal is open ----- */
            $(document).on('keyup', function(event) {
                if (event.key === 'Escape') {
                    if (my_students_details_menu_give_feedback_details_message_template_step2_is_modal_open) {
                        my_students_details_menu_give_feedback_details_message_template_step2_close_modal();
                    } else if (my_student_details_menu_give_feedback_details_message_template_step1_is_modal_open) {
                        my_student_details_menu_give_feedback_details_message_template_step1_close_modal();
                    }
                }
            });

            /* ----- Step 1 -> Step 2: click FIRST pencil icon ----- */
            $('.my_student_details_menu_give_feedback_details_message_template_step1_template_edit_button')
                .first()
                .on('click', function(e) {
                    e.stopPropagation();
                    var $item = $(this).closest('.my_student_details_menu_give_feedback_details_message_template_step1_template_item');
                    var titleText = $item
                        .find('.my_student_details_menu_give_feedback_details_message_template_step1_template_title')
                        .text();
                    var messageText = $item
                        .find('.my_student_details_menu_give_feedback_details_message_template_step1_template_preview')
                        .text();

                    my_student_details_menu_give_feedback_details_message_template_step1_close_modal();
                    my_students_details_menu_give_feedback_details_message_template_step2_open_modal(titleText, messageText);
                });

            /* ----- Step 1 -> Step 2: Add a new template button ----- */
            $('.my_student_details_menu_give_feedback_details_message_template_step1_add_button').on('click', function() {
                // close step1 and open step2 with EMPTY fields
                my_student_details_menu_give_feedback_details_message_template_step1_close_modal();
                my_students_details_menu_give_feedback_details_message_template_step2_open_modal('', '');
            });

            /* ----- Step 2: update Save button when typing ----- */
            $('#my_students_details_menu_give_feedback_details_message_template_step2_title_input, #my_students_details_menu_give_feedback_details_message_template_step2_message_textarea')
                .on('input', function() {
                    my_students_details_menu_give_feedback_details_message_template_step2_update_save_button_state();
                });

            /* ----- Step 2: Save click (demo) ----- */
            $('#my_students_details_menu_give_feedback_details_message_template_step2_save_button').on('click', function() {
                if (!$(this).hasClass('my_students_details_menu_give_feedback_details_message_template_step2_save_button_active')) {
                    return;
                }
                // Here you could send data to backend, etc.
                my_students_details_menu_give_feedback_details_message_template_step2_close_modal();
                alert('Template saved (demo)');
            });
        });
    </script>
</body>

</html>