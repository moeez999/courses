<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Confirm Payment • Latingles</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --my_teachers_details_course_purchase_confirm_payment_text: #0F172A;
      --my_teachers_details_course_purchase_confirm_payment_muted: #64748B;
      --my_teachers_details_course_purchase_confirm_payment_border: #E2E8F0;
      --my_teachers_details_course_purchase_confirm_payment_card: #fff;
      --my_teachers_details_course_purchase_confirm_payment_btn: #EF3B2D;
      --my_teachers_details_course_purchase_confirm_payment_btn_hover: #DC2626;
      --my_teachers_details_course_purchase_confirm_payment_green_bg: #bfe9e6;
      /* dropdown desktop width from your snapshot */
      --my_teachers_details_course_purchase_confirm_payment_dropdown_w: 500px;
    }

    html,
    body {
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
      color: var(--my_teachers_details_course_purchase_confirm_payment_text)
    }

    .my_teachers_details_course_purchase_confirm_payment_card {
      background: var(--my_teachers_details_course_purchase_confirm_payment_card);
      border: 1px solid var(--my_teachers_details_course_purchase_confirm_payment_border);
      border-radius: 14px;
      box-shadow: 0 1px 0 rgba(15, 23, 42, .03)
    }

    .my_teachers_details_course_purchase_confirm_payment_btn_primary {
      background: var(--my_teachers_details_course_purchase_confirm_payment_btn);
      color: #fff;
      border-radius: 5px;
      font-weight: 600;
      border: 2px solid #000;
      /* BLACK BORDER per snapshot */
    }

    .my_teachers_details_course_purchase_confirm_payment_btn_primary:hover {
      background: var(--my_teachers_details_course_purchase_confirm_payment_btn_hover)
    }

    /* Tooltip */
    .my_teachers_details_course_purchase_confirm_payment_tooltip {
      position: relative;
      cursor: help
    }

    .my_teachers_details_course_purchase_confirm_payment_tooltip_panel {
      position: absolute;
      left: 50%;
      top: 130%;
      transform: translate(-50%, -6px);
      opacity: 0;
      pointer-events: none;
      transition: all .15s ease;
      background: #0F172A;
      color: #fff;
      padding: 8px 10px;
      border-radius: 8px;
      white-space: nowrap;
      z-index: 50;
      font-size: 12px;
      line-height: 1.2
    }

    .my_teachers_details_course_purchase_confirm_payment_tooltip:hover .my_teachers_details_course_purchase_confirm_payment_tooltip_panel {
      opacity: 1;
      transform: translate(-50%, 0);
      pointer-events: auto
    }

    .my_teachers_details_course_purchase_confirm_payment_tooltip_panel:after {
      content: "";
      position: absolute;
      top: -6px;
      left: 50%;
      transform: translateX(-50%);
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-bottom: 6px solid #0F172A
    }

    /* Custom dropdown (width from variable) */
    .my_teachers_details_course_purchase_confirm_payment_select_btn {
      border: 1px solid var(--my_teachers_details_course_purchase_confirm_payment_border);
      border-radius: 10px;
      padding: .55rem .75rem;
      width: var(--my_teachers_details_course_purchase_confirm_payment_dropdown_w);
      background: #fff;
    }

    @media (max-width: 640px) {
      .my_teachers_details_course_purchase_confirm_payment_select_btn {
        width: 100%;
      }
    }

    .my_teachers_details_course_purchase_confirm_payment_select_menu {
      border: 1px solid var(--my_teachers_details_course_purchase_confirm_payment_border);
      border-radius: 10px;
      overflow: hidden;
      background: #fff;
      min-width: 500px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, .08)
    }

    .my_teachers_details_course_purchase_confirm_payment_select_item {
      padding: .6rem .8rem
    }

    .my_teachers_details_course_purchase_confirm_payment_select_item:hover {
      background: #F8FAFC
    }
  </style>
</head>

<body class="bg-white">
  <!-- Top mini header (ONE flag only) -->
  <div class="w-full border-b border-slate-200">
    <div class="max-w-[1150px] mx-auto px-4 md:px-6 lg:px-8 py-2 flex items-center gap-2">
      <img alt="Country" class="h-4 w-6 rounded-sm object-cover" src="https://flagcdn.com/w20/gb.png" />
      <span class="text-[13px] text-slate-600">English, USD</span>
    </div>
  </div>

  <div class="max-w-[1150px] mx-auto px-4 md:px-6 lg:px-8 py-7">
    <h1 class="text-[28px] font-bold mb-7">Payment method</h1>

    <div class="grid grid-cols-1 lg:grid-cols-[380px,1fr] gap-6 lg:gap-10 items-start">

      <!-- LEFT -->
      <aside class="space-y-6">
        <!-- Tutor card -->
        <section class="my_teachers_details_course_purchase_confirm_payment_card p-5">
          <div class="flex items-start gap-3">
            <img src="https://i.pravatar.cc/80?img=32" class="w-14 h-14 object-cover" alt="Daniela" />
            <div class="flex-1">
              <div class="flex items-center gap-2">
                <h2 class="text-[20px] font-semibold">Daniela</h2>
                <!-- ONE flag beside name -->
                <img src="https://flagcdn.com/w20/gb.png" class="h-4 w-6 rounded-sm" alt="GB" />
                <!-- Black tick -->
                <span title="Verified" class="inline-flex items-center justify-center w-5 h-5 rounded-md bg-black text-white text-[11px] font-bold">✓</span>
              </div>
              <div class="flex items-center gap-2 mt-1">
                <div class="flex text-amber-400 text-[16px]">★★★★★</div>
                <span class="text-[12.5px] text-slate-500">5</span>
                <span class="text-[12.5px] text-slate-500">(65 reviews)</span>
              </div>
            </div>
          </div>

          <p class="mt-4 font-semibold text-[16px] leading-snug">
            Speak With Confidence: English Conversation Skills
          </p>

          <!-- Borderless stats row (like snapshot) -->
          <div class="mt-4 flex items-end gap-8 sm:gap-12">
            <div class="flex items-center gap-2">
              <span class="text-[18px]">🎓</span>
              <div>
                <div class="font-semibold text-[15px] leading-none">17</div>
                <div class="text-[12.5px] text-slate-500 leading-tight">Lesson</div>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-[18px]">⏱️</span>
              <div>
                <div class="font-semibold text-[15px] leading-none">19</div>
                <div class="text-[12.5px] text-slate-500 leading-tight">Hours</div>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-[18px]">📅</span>
              <div>
                <div class="font-semibold text-[15px] leading-none">20+</div>
                <div class="text-[12.5px] text-slate-500 leading-tight">Students</div>
              </div>
            </div>
          </div>
        </section>

        <!-- Order summary -->
        <section class="my_teachers_details_course_purchase_confirm_payment_card p-5">
          <h3 class="font-semibold text-[16px] mb-3">Your order</h3>

          <div class="space-y-3 text-[14.5px]">
            <div class="flex items-center justify-between">
              <span class="text-slate-600">English Course</span>
              <span class="font-semibold">$50.00</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-600 flex items-center gap-2">
                Processing fee
                <span class="my_teachers_details_course_purchase_confirm_payment_tooltip inline-flex items-center justify-center w-5 h-5 rounded-full border border-slate-300 text-slate-500 text-[11px]" style="border: 2px solid black !important; color:black !important;">?
                  <span class="my_teachers_details_course_purchase_confirm_payment_tooltip_panel">This amount includes applicable taxes and a <br>Processing fee to secure your payment and <br>allow us to pay your tutor when <br>lessons are completed</span>
                </span>
              </span>
              <span class="font-semibold">$0.30</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-600 flex items-center gap-2">
                Your Latingles credit
                <span class="my_teachers_details_course_purchase_confirm_payment_tooltip inline-flex items-center justify-center w-5 h-5 rounded-full border border-slate-300 text-slate-500 text-[11px]" style="border: 2px solid black !important; color:black !important;">i
                  <span class="my_teachers_details_course_purchase_confirm_payment_tooltip_panel">This amount includes applicable taxes and a <br>Processing fee to secure your payment and <br>allow us to pay your tutor when <br>lessons are completed</span>
                </span>
              </span>
              <span class="font-semibold text-emerald-600">−$4.80</span>
            </div>
            <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
              <span class="font-semibold">Total</span>
              <span class="font-bold text-[18px]">$7.50</span>
            </div>

            <button id="my_teachers_details_course_purchase_confirm_payment_toggle_promo" class="text-slate-600 underline text-[13.5px]">
              Have a promo code?
            </button>

            <div id="my_teachers_details_course_purchase_confirm_payment_promo_row" class="hidden">
              <div class="flex gap-2">
                <input id="my_teachers_details_course_purchase_confirm_payment_promo_input" type="text" placeholder="Enter code"
                  class="flex-1 border border-slate-200 rounded-[10px] px-3 py-2 text-[14px]" />
                <button id="my_teachers_details_course_purchase_confirm_payment_apply_promo"
                  class="px-4 py-2 rounded-lg border border-slate-200 text-[14px] font-medium">
                  Apply
                </button>
              </div>
              <p id="my_teachers_details_course_purchase_confirm_payment_promo_msg" class="text-[12.5px] text-emerald-600 mt-2 hidden">Code applied!</p>
            </div>
          </div>

          <!-- Green strip (NO RADIUS, NO BORDER) -->
          <div class="mt-2 p-3 rounded-none" style="background:var(--my_teachers_details_course_purchase_confirm_payment_green_bg);">
            <div class="flex items-start gap-3">
              <span class="inline-flex items-center justify-center w-6 h-6 text-black text-[14px] font-bold mt-0.5">✓</span>
              <div>
                <p class="font-semibold text-[14px] text-black">Free replacement or refund</p>
                <p class="text-[12.5px] text-black/80 mt-1">Try another tutor for free or get a refund</p>
              </div>
            </div>
          </div>
        </section>
      </aside>

      <!-- RIGHT -->
      <main class="space-y-6">
        <!-- Payment box -->
        <section class="my_teachers_details_course_purchase_confirm_payment_card p-5 md:p-6">
          <div class="flex flex-col gap-4">
            <!-- VISA + custom dropdown with fixed width -->
            <div class="flex items-center gap-3">
              <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-5 w-auto" alt="Visa" />
              <div class="relative" id="my_teachers_details_course_purchase_confirm_payment_card_select_root">
                <button id="my_teachers_details_course_purchase_confirm_payment_card_select_btn" type="button"
                  class="my_teachers_details_course_purchase_confirm_payment_select_btn flex items-center justify-between gap-6 text-[14px]">
                  <span id="my_teachers_details_course_purchase_confirm_payment_card_select_label">Visa ****7583</span>
                  <img alt="open" class="h-4 w-4 opacity-70"
                    src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 20 20' fill='none'><path d='M5 7l5 6 5-6' stroke='%2364748B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>">
                </button>
                <div id="my_teachers_details_course_purchase_confirm_payment_card_select_menu"
                  class="hidden absolute z-50 mt-2 my_teachers_details_course_purchase_confirm_payment_select_menu">
                  <div class="my_teachers_details_course_purchase_confirm_payment_select_item cursor-pointer" data-value="Visa ****7583">Visa ****7583</div>
                  <div class="my_teachers_details_course_purchase_confirm_payment_select_item cursor-pointer" data-value="Mastercard ****9210">Mastercard ****9210</div>
                  <div class="my_teachers_details_course_purchase_confirm_payment_select_item cursor-pointer" data-value="Add new card…">Add new card…</div>
                </div>
              </div>
            </div>

            <button id="my_teachers_details_course_purchase_confirm_payment_confirm_btn"
              class="my_teachers_details_course_purchase_confirm_payment_btn_primary w-full py-2 text-[14px]">
              Confirm payment · $7.50
            </button>

            <p class="text-[12.5px] text-slate-500">
              By pressing the “Confirm payment · $7.50” button, you agree to
              <a href="#" class="underline">Latingles Refund</a> and
              <a href="#" class="underline">Payment Policy</a>.
            </p>

            <hr class="border-t border-slate-200 mt-1" />
          </div>
        </section>

        <!-- Reviews -->
        <section class="my_teachers_details_course_purchase_confirm_payment_card p-5 md:p-6">
          <div class="flex items-center justify-between">
            <!-- Stars + 5 -->
            <div class="flex items-center gap-3">
              <div class="inline-flex items-center gap-2 px-3 py-2 rounded-sm border border-slate-200">
                <div class="flex text-amber-400 text-[16px] leading-none">★★★★★</div>
                <span class="font-semibold leading-none">5</span>
              </div>
              <span class="text-slate-500">65 reviews</span>
            </div>

            <!-- Joined arrows group (as snapshot) -->
            <div class="inline-flex items-center rounded-md border border-slate-200 overflow-hidden">
              <button id="my_teachers_details_course_purchase_confirm_payment_prev_review" class="w-11 h-10 grid place-items-center bg-white">
                <img alt="prev" class="h-4 w-4"
                  src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 20 20' fill='none'><path d='M12 5l-5 5 5 5' stroke='%2369748B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>">
              </button>
              <div class="h-10 w-px bg-slate-200"></div>
              <button id="my_teachers_details_course_purchase_confirm_payment_next_review" class="w-11 h-10 grid place-items-center bg-white">
                <img alt="next" class="h-4 w-4"
                  src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 20 20' fill='none'><path d='M8 5l5 5-5 5' stroke='%2369748B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>">
              </button>
            </div>
          </div>

          <!-- Review card -->
          <div id="my_teachers_details_course_purchase_confirm_payment_review_card" class="mt-4 rounded-md border border-slate-200 p-4">
            <div class="flex items-start gap-3">
              <img id="my_teachers_details_course_purchase_confirm_payment_review_avatar" src="https://i.pravatar.cc/60?img=11" class="w-10 h-10 rounded-lg object-cover" alt="Reviewer" />
              <div class="flex-1">
                <p class="font-semibold leading-tight">Wassim</p>
                <p id="my_teachers_details_course_purchase_confirm_payment_review_text" class="mt-1 text-[14px] text-slate-700">
                  I would love to have the chance to express my high appreciation and gratitude to this respectable and respectful tutor, Mr Jonathan. There is much to say but in brief, he is very professional,…
                </p>
                <button id="my_teachers_details_course_purchase_confirm_payment_read_more" class="mt-2 text-[13.5px] underline">Read more</button>
              </div>
            </div>
          </div>
        </section>
      </main>

    </div>
  </div>






<?php require_once('my_teachers_details_course_purchase_confirm_payment_success_message.php');?>









  <script>
    /* ===== REVIEWS DATA ===== */
    const my_teachers_details_course_purchase_confirm_payment_reviews = [{
        name: "Wassim",
        avatar: "https://i.pravatar.cc/60?img=11",
        text: "I would love to have the chance to express my high appreciation and gratitude to this respectable and respectful tutor, Mr Jonathan. There is much to say but in brief, he is very professional, kind, and always prepared. My confidence grew with every session."
      },
      {
        name: "Sofia",
        avatar: "https://i.pravatar.cc/60?img=12",
        text: "Fantastic teacher! Clear explanations, patient corrections and engaging topics. I improved my conversation skills quickly."
      },
      {
        name: "Kenji",
        avatar: "https://i.pravatar.cc/60?img=15",
        text: "Great experience overall. Lessons are structured yet flexible. Highly recommended for speaking practice."
      }
    ];
    let my_teachers_details_course_purchase_confirm_payment_idx = 0;
    let my_teachers_details_course_purchase_confirm_payment_expanded = false;

    function my_teachers_details_course_purchase_confirm_payment_renderReview() {
      const r = my_teachers_details_course_purchase_confirm_payment_reviews[my_teachers_details_course_purchase_confirm_payment_idx];
      $("#my_teachers_details_course_purchase_confirm_payment_review_avatar").attr("src", r.avatar);
      $("#my_teachers_details_course_purchase_confirm_payment_review_card .font-semibold").first().text(r.name);
      const t = my_teachers_details_course_purchase_confirm_payment_expanded ? r.text :
        (r.text.length > 190 ? r.text.slice(0, 190) + "…" : r.text);
      $("#my_teachers_details_course_purchase_confirm_payment_review_text").text(t);
      $("#my_teachers_details_course_purchase_confirm_payment_read_more")
        .text(my_teachers_details_course_purchase_confirm_payment_expanded ? "Read less" : "Read more");
    }

    function my_teachers_details_course_purchase_confirm_payment_next() {
      my_teachers_details_course_purchase_confirm_payment_idx =
        (my_teachers_details_course_purchase_confirm_payment_idx + 1) % my_teachers_details_course_purchase_confirm_payment_reviews.length;
      my_teachers_details_course_purchase_confirm_payment_expanded = false;
      my_teachers_details_course_purchase_confirm_payment_renderReview();
    }

    function my_teachers_details_course_purchase_confirm_payment_prev() {
      my_teachers_details_course_purchase_confirm_payment_idx =
        (my_teachers_details_course_purchase_confirm_payment_idx - 1 + my_teachers_details_course_purchase_confirm_payment_reviews.length) %
        my_teachers_details_course_purchase_confirm_payment_reviews.length;
      my_teachers_details_course_purchase_confirm_payment_expanded = false;
      my_teachers_details_course_purchase_confirm_payment_renderReview();
    }

    function my_teachers_details_course_purchase_confirm_payment_applyPromo(code) {
      if (code.trim().toUpperCase() === "PROMO5") {
        $("#my_teachers_details_course_purchase_confirm_payment_promo_msg")
          .removeClass("hidden").removeClass("text-red-600").addClass("text-emerald-600")
          .text("Code applied! New total: $2.50");
        $("#my_teachers_details_course_purchase_confirm_payment_confirm_btn").text("Confirm payment · $2.50");
      } else {
        $("#my_teachers_details_course_purchase_confirm_payment_promo_msg")
          .removeClass("hidden").removeClass("text-emerald-600").addClass("text-red-600")
          .text("Invalid code");
      }
    }

    $(function() {
      my_teachers_details_course_purchase_confirm_payment_renderReview();

      $("#my_teachers_details_course_purchase_confirm_payment_next_review").on("click", my_teachers_details_course_purchase_confirm_payment_next);
      $("#my_teachers_details_course_purchase_confirm_payment_prev_review").on("click", my_teachers_details_course_purchase_confirm_payment_prev);
      $("#my_teachers_details_course_purchase_confirm_payment_read_more").on("click", function() {
        my_teachers_details_course_purchase_confirm_payment_expanded = !my_teachers_details_course_purchase_confirm_payment_expanded;
        my_teachers_details_course_purchase_confirm_payment_renderReview();
      });

      $("#my_teachers_details_course_purchase_confirm_payment_toggle_promo").on("click", function() {
        $("#my_teachers_details_course_purchase_confirm_payment_promo_row").toggleClass("hidden");
        $("#my_teachers_details_course_purchase_confirm_payment_promo_msg").addClass("hidden");
      });
      $("#my_teachers_details_course_purchase_confirm_payment_apply_promo").on("click", function() {
        const code = $("#my_teachers_details_course_purchase_confirm_payment_promo_input").val();
        my_teachers_details_course_purchase_confirm_payment_applyPromo(code);
      });

      // Custom dropdown
      const $btn = $("#my_teachers_details_course_purchase_confirm_payment_card_select_btn");
      const $menu = $("#my_teachers_details_course_purchase_confirm_payment_card_select_menu");
      const $label = $("#my_teachers_details_course_purchase_confirm_payment_card_select_label");

      $btn.on("click", function(e) {
        e.stopPropagation();
        $menu.toggleClass("hidden");
      });
      $menu.on("click", ".my_teachers_details_course_purchase_confirm_payment_select_item", function() {
        const val = $(this).data("value");
        $label.text(val);
        $menu.addClass("hidden");
        if (String(val).includes("Add new")) alert("Open add-card flow (demo).");
      });
      $(document).on("click", function() {
        $menu.addClass("hidden");
      });

      // $("#my_teachers_details_course_purchase_confirm_payment_confirm_btn").on("click", function() {
      //   alert("Payment confirmed (demo).");
      // });

    });
  </script>
</body>

</html>