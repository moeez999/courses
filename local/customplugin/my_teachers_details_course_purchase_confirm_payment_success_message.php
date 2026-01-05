<style>
    /* ===== Success Modal (exact to snapshot) ===== */
    .my_teachers_details_course_purchase_confirm_payment_modal_overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .4);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .my_teachers_details_course_purchase_confirm_payment_modal_card {
        background: #fff;
        border-radius: 16px;
        width: min(720px, 92vw);
        text-align: center;
        position: relative;
        overflow: hidden;
        padding: 36px 28px 28px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, .18);
    }

    /* Confetti dots/strips scattered behind content */
    .my_teachers_details_course_purchase_confirm_payment_confetti {
        pointer-events: none;
        position: absolute;
        inset: 0;
        overflow: hidden;
    }

    .my_teachers_details_course_purchase_confirm_payment_confetti span {
        position: absolute;
        display: block;
        width: 6px;
        height: 12px;
        border-radius: 2px;
        opacity: .95;
    }

    @keyframes my_teachers_details_course_purchase_confirm_payment_float {
        0% {
            transform: translateY(-6px) rotate(0deg);
        }

        50% {
            transform: translateY(6px) rotate(15deg);
        }

        100% {
            transform: translateY(-6px) rotate(0deg);
        }
    }

    /* Big heading & paragraph like snapshot */
    .my_teachers_details_course_purchase_confirm_payment_modal_h1 {
        font-size: clamp(36px, 6vw, 40px);
        font-weight: 600;
        line-height: 1.05;
        letter-spacing: -.02em;
    }

    .my_teachers_details_course_purchase_confirm_payment_modal_p {
        font-size: clamp(14px, 2.2vw, 18px);
        color: #6B7280;
        line-height: 1.65;
    }

    /* Red button with black border exactly */
    .my_teachers_details_course_purchase_confirm_payment_modal_btn {
        background: #EF3B2D;
        color: #fff;
        border: 2px solid #000;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        padding: 12px 28px;
        display: inline-block;
    }
</style>



<!-- Congratulations Modal -->
<div id="my_teachers_details_course_purchase_confirm_payment_success_modal"
    class="my_teachers_details_course_purchase_confirm_payment_modal_overlay">
    <div class="my_teachers_details_course_purchase_confirm_payment_modal_card">
        <!-- Confetti layer -->
        <div id="my_teachers_details_course_purchase_confirm_payment_confetti_layer"
            class="my_teachers_details_course_purchase_confirm_payment_confetti"></div>

        <!-- Emoji/illustration -->
        <img src="https://cdn-icons-png.flaticon.com/512/4319/4319025.png"
            alt="Celebration" class="w-24 h-24 mx-auto mb-4 select-none" draggable="false" />

        <!-- Heading -->
        <h2 class="my_teachers_details_course_purchase_confirm_payment_modal_h1 mb-3">
            Congratulations!
        </h2>

        <!-- Description (course title is bold & dynamic) -->
        <p class="my_teachers_details_course_purchase_confirm_payment_modal_p mx-auto max-w-[640px]">
            Your purchase of
            <strong id="my_teachers_details_course_purchase_confirm_payment_modal_course_title">
                Mastering Everyday English for Real-Life Situations
            </strong>
            has been completed successfully.
        </p>

        <!-- Button -->
        <button id="my_teachers_details_course_purchase_confirm_payment_success_close"
            class="my_teachers_details_course_purchase_confirm_payment_modal_btn mt-6">
            Okay, thanks!
        </button>
    </div>
</div>


<script>
    // Build scattered confetti each time the modal opens
    function my_teachers_details_course_purchase_confirm_payment_buildConfetti(container) {
        const colors = ["#f97316", "#facc15", "#94a3b8"]; // orange, yellow, slate (matches snapshot vibe)
        const count = 90; // density like your image
        container.innerHTML = "";
        const {
            width,
            height
        } = container.getBoundingClientRect();
        for (let i = 0; i < count; i++) {
            const dot = document.createElement("span");
            const x = Math.random() * width,
                y = Math.random() * height;
            const w = 5 + Math.random() * 4,
                h = 8 + Math.random() * 8;
            const rot = (Math.random() * 70 - 35).toFixed(1);
            dot.style.left = x + "px";
            dot.style.top = y + "px";
            dot.style.width = w + "px";
            dot.style.height = h + "px";
            dot.style.background = colors[i % colors.length];
            dot.style.transform = `rotate(${rot}deg)`;
            dot.style.animation = `my_teachers_details_course_purchase_confirm_payment_float ${2+Math.random()*1.6}s ease-in-out ${Math.random()}s infinite`;
            container.appendChild(dot);
        }
    }

    // Open modal: set dynamic course title, generate confetti, show
    $("#my_teachers_details_course_purchase_confirm_payment_confirm_btn").off("click").on("click", function() {
        const title = $("section.my_teachers_details_course_purchase_confirm_payment_card p.font-semibold")
            .first().text().trim();
        if (title) {
            $("#my_teachers_details_course_purchase_confirm_payment_modal_course_title").text(title);
        }
        const confettiLayer = document.getElementById("my_teachers_details_course_purchase_confirm_payment_confetti_layer");
        my_teachers_details_course_purchase_confirm_payment_buildConfetti(confettiLayer);

        $("#my_teachers_details_course_purchase_confirm_payment_success_modal").css("display", "flex");
    });

    // Close modal on button click or clicking the overlay
    $("#my_teachers_details_course_purchase_confirm_payment_success_close, #my_teachers_details_course_purchase_confirm_payment_success_modal")
        .off("click")
        .on("click", function(e) {
            if (e.target.id === "my_teachers_details_course_purchase_confirm_payment_success_close" ||
                e.target.id === "my_teachers_details_course_purchase_confirm_payment_success_modal") {
                $("#my_teachers_details_course_purchase_confirm_payment_success_modal").hide();
            }
        });
</script>