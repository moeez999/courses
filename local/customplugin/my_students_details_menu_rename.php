<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Student Rename Modal</title>

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


        /* ===== MODAL OVERLAY ===== */
        #my_student_details_menu_rename_modal_overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 16px;
        }

        #my_student_details_menu_rename_modal_overlay.my_student_details_menu_rename_open {
            display: flex;
        }

        /* ===== MODAL BOX ===== */
        .my_student_details_menu_rename_modal {
            background: #fff;
            width: 100%;
            max-width: 480px;
            border-radius: 12px;
            padding: 24px 24px 20px;
            position: relative;
        }

        /* Header */
        .my_student_details_menu_rename_header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .my_student_details_menu_rename_title {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
        }

        .my_student_details_menu_rename_close_button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* INPUT */
        #my_student_details_menu_rename_input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 5px;
            border: 2px solid #d1d5db;
            font-size: 15px;
            margin-top: 16px;
            margin-bottom: 18px;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        #my_student_details_menu_rename_input:hover {
            border-color: black;
        }

        #my_student_details_menu_rename_input:focus {
            outline: none;
            border-color: black;
            box-shadow: 0 0 0 1px black;
        }

        /* ===== BUTTONS WITH HOVER SHADOW ===== */

        .my_student_details_menu_rename_button_primary,
        .my_student_details_menu_rename_button_secondary {
            width: 100%;
            padding: 10px 16px;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 10px;
            transition: box-shadow 0.25s ease;
        }

        /* SAVE BUTTON */
        .my_student_details_menu_rename_button_primary {
            background: red;
            color: white;
            border: 2px solid black;
        }

        .my_student_details_menu_rename_button_primary:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.45);
        }

        /* GO BACK BUTTON */
        .my_student_details_menu_rename_button_secondary {
            background: #fff;
            color: #111827;
            border: 2px solid black;
        }

        .my_student_details_menu_rename_button_secondary:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.45);
        }

        @media (max-width: 480px) {
            .my_student_details_menu_rename_modal {
                padding: 20px 16px;
            }

            .my_student_details_menu_rename_title {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <!-- <div id="my_student_details_menu_rename_page_wrapper">
        <button id="my_student_details_menu_rename_button">Rename</button>
    </div> -->

    <!-- Modal -->
    <div id="my_student_details_menu_rename_modal_overlay">
        <div class="my_student_details_menu_rename_modal">
            <div class="my_student_details_menu_rename_header">
                <h2 class="my_student_details_menu_rename_title">Change student's name</h2>
                <button class="my_student_details_menu_rename_close_button">&times;</button>
            </div>

            <input
                id="my_student_details_menu_rename_input"
                type="text"
                placeholder="Latingles A." />

            <button
                id="my_student_details_menu_rename_save_button"
                class="my_student_details_menu_rename_button_primary">
                Save
            </button>

            <button
                id="my_student_details_menu_rename_back_button"
                class="my_student_details_menu_rename_button_secondary">
                Go back
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(function() {
            function my_student_details_menu_rename_openModal() {
                $("#my_student_details_menu_rename_modal_overlay")
                    .addClass("my_student_details_menu_rename_open");
            }

            function my_student_details_menu_rename_closeModal() {
                $("#my_student_details_menu_rename_modal_overlay")
                    .removeClass("my_student_details_menu_rename_open");
            }

            $("#my_student_details_menu_rename_button").click(function() {
                my_student_details_menu_rename_openModal();
            });

            $(".my_student_details_menu_rename_close_button, #my_student_details_menu_rename_back_button").click(
                function() {
                    my_student_details_menu_rename_closeModal();
                }
            );

            $("#my_student_details_menu_rename_save_button").click(function() {
                my_student_details_menu_rename_closeModal();
            });

            $("#my_student_details_menu_rename_modal_overlay").click(function(e) {
                if (e.target === this) my_student_details_menu_rename_closeModal();
            });
        });
    </script>
</body>

</html>