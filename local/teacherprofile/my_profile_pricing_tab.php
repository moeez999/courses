<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>My Profile – Pricing Tab</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_pricing_tab_text:#121117;
      --my_profile_pricing_tab_muted:#6B7280;
      --my_profile_pricing_tab_border:#E4E7EE;
      --my_profile_pricing_tab_accent:#ff3b1f;

      --my_profile_pricing_tab_radius:12px;
      --my_profile_pricing_tab_control_h:48px;
    }

    .my_profile_pricing_tab_container p,
    .my_profile_pricing_tab_container label{ color:var(--my_profile_pricing_tab_text) }
    .my_profile_pricing_tab_muted{ color:var(--my_profile_pricing_tab_muted) }

    .my_profile_pricing_tab_input{
      width:100%;
      height:var(--my_profile_pricing_tab_control_h);
      border:1.5px solid var(--my_profile_pricing_tab_border);
      border-radius:var(--my_profile_pricing_tab_radius);
      padding:0 14px;
      outline:0;
      transition:border-color .15s, box-shadow .15s;
    }
    .my_profile_pricing_tab_input:focus{
      border-color:#b9c0d4;
      box-shadow:0 0 0 4px rgba(59,130,246,.08);
    }

    .my_profile_pricing_tab_disclosure{
      border:1.5px solid var(--my_profile_pricing_tab_border);
      border-radius:var(--my_profile_pricing_tab_radius);
      background:#fff;
    }

    .my_profile_pricing_tab_btn_save{
      background:var(--my_profile_pricing_tab_accent);
      color:#fff;
      height:46px;
      padding:0 28px;
      border-radius:10px;
      font-weight:600;
      /* Black border per spec */
      border:2px solid #000;
      transition:box-shadow .15s ease;
    }
    .my_profile_pricing_tab_btn_save:focus{ outline:0; box-shadow:0 0 0 4px rgba(17,24,39,.06) }

    @media (max-width:640px){
      .my_profile_pricing_tab_h1{ font-size:1.6rem; line-height:1.25 }
    }
  </style>
</head>
<body class="bg-white text-[15px] sm:text-[16px]">
  <main class="my_profile_pricing_tab_container max-w-3xl mx-auto px-4 sm:px-6 py-10">

    <!-- Title -->
    <h1 class="my_profile_pricing_tab_h1 text-[28px] sm:text-[32px] font-semibold mb-8">
      Set your 50 minute lesson price
    </h1>

    <!-- 1:1 price -->
    <div class="mb-5">
      <input id="my_profile_pricing_tab_price_11" type="number" min="0" step="1" placeholder="10"
             class="my_profile_pricing_tab_input" />
      <p class="my_profile_pricing_tab_muted text-[13px] mt-2">
        Price for 1:1 classes in USD only
      </p>
    </div>

    <!-- Group price -->
    <div class="mb-8">
      <input id="my_profile_pricing_tab_price_group" type="number" min="0" step="1" placeholder="12"
             class="my_profile_pricing_tab_input" />
      <p class="my_profile_pricing_tab_muted text-[13px] mt-2">
        Price for Group classes in USD only
      </p>
    </div>

    <!-- Latingles commission (collapse) -->
    <div id="my_profile_pricing_tab_commission" class="my_profile_pricing_tab_disclosure mb-8">
      <button id="my_profile_pricing_tab_toggle" type="button"
              class="w-full flex items-center justify-between px-4 h-12">
        <span class="font-semibold">Latingles commission</span>
        <svg id="my_profile_pricing_tab_chev" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform"
             viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
        </svg>
      </button>
      <div id="my_profile_pricing_tab_panel" class="hidden border-t" style="border-color:var(--my_profile_pricing_tab_border)">
        <div class="px-4 py-4">
          <p class="my_profile_pricing_tab_muted">
            Commission details go here (placeholder). Replace with your actual policy text or dynamic values.
          </p>
        </div>
      </div>
    </div>

    <!-- Save -->
    <button id="my_profile_pricing_tab_btnSave" class="my_profile_pricing_tab_btn_save">
      Save
    </button>
  </main>

  <script>
    (function($){
      // Toggle commission panel
      $("#my_profile_pricing_tab_toggle").on("click", function(){
        $("#my_profile_pricing_tab_panel").toggleClass("hidden");
        $("#my_profile_pricing_tab_chev").toggleClass("rotate-180");
      });

      // Basic input guard: prevent negatives & decimals if step=1
      $("#my_profile_pricing_tab_price_11, #my_profile_pricing_tab_price_group").on("input", function(){
        const v = $(this).val();
        if(Number(v) < 0) $(this).val(0);
      });

      // Save (demo)
      $("#my_profile_pricing_tab_btnSave").on("click", function(){
        $(this).addClass("ring-2 ring-black/10");
        setTimeout(()=>$(this).removeClass("ring-2 ring-black/10"), 300);
        const p1 = $("#my_profile_pricing_tab_price_11").val() || "—";
        const pg = $("#my_profile_pricing_tab_price_group").val() || "—";
        alert(`Saved (demo): 1:1 = $${p1}, Group = $${pg}`);
      });
    })(jQuery);
  </script>
</body>
</html>
