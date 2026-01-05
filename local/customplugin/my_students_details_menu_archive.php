<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Archive Student Modal</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f5f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* ===== Modal overlay ===== */
        #my_student_details_menu_archive_modal_overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 16px;
        }

        #my_student_details_menu_archive_modal_overlay.my_student_details_menu_archive_open {
            display: flex;
        }

        /* ===== Modal box ===== */
        .my_student_details_menu_archive_modal {
            background: #ffffff;
            width: 100%;
            max-width: 520px;
            border-radius: 12px;
            padding: 24px 24px 24px;
            position: relative;
            box-sizing: border-box;
        }

        /* Header */
        .my_student_details_menu_archive_header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .my_student_details_menu_archive_title {
            font-size: 24px;
            line-height: 1.2;
            margin: 0;
            font-weight: 700;
        }

        .my_student_details_menu_archive_close_button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            line-height: 1;
        }

        .my_student_details_menu_archive_description {
            margin: 0 0 20px;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Buttons */
        .my_student_details_menu_archive_button_primary,
        .my_student_details_menu_archive_button_secondary {
            width: 100%;
            padding: 10px 16px;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 10px;
            border: 2px solid black;
            transition: box-shadow 0.25s ease;
            box-sizing: border-box;
        }

        .my_student_details_menu_archive_button_primary {
            background: #d22215;
            /* red */
            color: #ffffff;
        }

        .my_student_details_menu_archive_button_secondary {
            background: #ffffff;
            color: #111827;
        }

        .my_student_details_menu_archive_button_primary:hover,
        .my_student_details_menu_archive_button_secondary:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.45);
        }

        @media (max-width: 480px) {
            .my_student_details_menu_archive_modal {
                padding: 20px 16px;
            }

            .my_student_details_menu_archive_title {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <!-- Archive modal -->
    <div id="my_student_details_menu_archive_modal_overlay">
        <div class="my_student_details_menu_archive_modal">
            <div class="my_student_details_menu_archive_header">
                <h2 class="my_student_details_menu_archive_title">
                    Do you want to archive this student?
                </h2>
                <button
                    class="my_student_details_menu_archive_close_button"
                    id="my_student_details_menu_archive_close_button"
                    aria-label="Close">
                    &times;
                </button>
            </div>

            <p class="my_student_details_menu_archive_description">
                You will be able to find this student in the "Archived student" section.
                You can unarchive them anytime.
            </p>

            <button
                id="my_student_details_menu_archive_confirm_button"
                class="my_student_details_menu_archive_button_primary">
                Archive student
            </button>

            <button
                id="my_student_details_menu_archive_back_button"
                class="my_student_details_menu_archive_button_secondary">
                Go back
            </button>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(function() {
            function my_student_details_menu_archive_openModal() {
                $("#my_student_details_menu_archive_modal_overlay")
                    .addClass("my_student_details_menu_archive_open");
            }

            function my_student_details_menu_archive_closeModal() {
                $("#my_student_details_menu_archive_modal_overlay")
                    .removeClass("my_student_details_menu_archive_open");
            }

            // Open modal
            $("#my_student_details_menu_archive_button").on("click", function() {
                my_student_details_menu_archive_openModal();
            });

            // Close via X or Go back
            $("#my_student_details_menu_archive_close_button, #my_student_details_menu_archive_back_button")
                .on("click", function() {
                    my_student_details_menu_archive_closeModal();
                });

            // Confirm archive (you can add your logic here)
            $("#my_student_details_menu_archive_confirm_button").on("click", function() {
                // TODO: AJAX call or other logic
                my_student_details_menu_archive_closeModal();
            });

            // Close by clicking outside the modal
            $("#my_student_details_menu_archive_modal_overlay").on("click", function(e) {
                if (e.target === this) {
                    my_student_details_menu_archive_closeModal();
                }
            });

            // Optional: close with ESC key
            $(document).on("keyup", function(e) {
                if (e.key === "Escape") {
                    my_student_details_menu_archive_closeModal();
                }
            });
        });
    </script>
</body>

</html>