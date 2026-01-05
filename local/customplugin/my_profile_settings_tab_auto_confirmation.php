<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Lesson autoconfirmation</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_settings_tab_autoconfirmation_border:#E4E7EE;
      --my_profile_settings_tab_autoconfirmation_text:#111827;
      --my_profile_settings_tab_autoconfirmation_muted:#6B7280;
      --my_profile_settings_tab_autoconfirmation_red:#FF3B11;
      --my_profile_settings_tab_autoconfirmation_red_hover:#e2340f;
    }

    .my_profile_settings_tab_autoconfirmation_para{
      color:var(--my_profile_settings_tab_autoconfirmation_muted);
      line-height:1.6;
      font-size:1rem;
    }
    .my_profile_settings_tab_autoconfirmation_bold{
      color:var(--my_profile_settings_tab_autoconfirmation_text);
      font-weight:700;
    }

    /* custom radio look to match Figma (subtle ring with filled center when checked) */
    .my_profile_settings_tab_autoconfirmation_radio{
      appearance:none; -webkit-appearance:none; -moz-appearance:none;
      width:18px; height:18px; border:2px solid #9CA3AF; border-radius:999px;
      display:inline-grid; place-content:center; margin-top:2px; cursor:pointer;
      transition:border-color .15s ease, box-shadow .15s ease;
    }
    .my_profile_settings_tab_autoconfirmation_radio:focus{
      outline:none; box-shadow:0 0 0 3px rgba(59,130,246,.15);
    }
    .my_profile_settings_tab_autoconfirmation_radio:checked{
      border-color:#111827;
    }
    .my_profile_settings_tab_autoconfirmation_radio:checked::before{
      content:""; width:8px; height:8px; border-radius:999px; background:#111827;
    }

    .my_profile_settings_tab_autoconfirmation_save{
      background:var(--my_profile_settings_tab_autoconfirmation_red);
      border:1px solid #000; color:#fff; font-weight:600;
      border-radius:12px; padding:14px 20px; width:100%; max-width:520px;
      transition:background .15s ease;
    }
    .my_profile_settings_tab_autoconfirmation_save:hover{
      background:var(--my_profile_settings_tab_autoconfirmation_red_hover);
    }
  </style>
</head>
<body class="bg-white antialiased">

  <div class="my_profile_settings_tab_autoconfirmation_wrapper max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-semibold mb-6">Lesson autoconfirmation</h1>

    <!-- Intro copy -->
    <p class="my_profile_settings_tab_autoconfirmation_para mb-4">
      We automatically confirm your lessons so your tutor can get paid. Here’s how the autoconfirmation timing works:
    </p>

    <p class="my_profile_settings_tab_autoconfirmation_para mb-2">
      <span class="my_profile_settings_tab_autoconfirmation_bold">Lessons completed in the Latingles classroom</span> are autoconfirmed 15 minutes after completion.
    </p>
    <p class="my_profile_settings_tab_autoconfirmation_para mb-6">
      <span class="my_profile_settings_tab_autoconfirmation_bold">Lessons completed outside Latingles</span> are autoconfirmed 72 hours after the original scheduled end time.
    </p>

    <p class="my_profile_settings_tab_autoconfirmation_para mb-3">
      Choose your settings for lessons that take place outside Latingles:
    </p>

    <!-- Options -->
    <div class="space-y-4 mb-6">
      <!-- Option 1 -->
      <label class="flex items-start gap-3 cursor-pointer">
        <input type="radio" name="my_profile_settings_tab_autoconfirmation_choice"
               class="my_profile_settings_tab_autoconfirmation_radio"
               value="own_only">
        <span class="text-[15px] leading-6 text-gray-800">
          Only lessons scheduled by you or rescheduled by your tutor on your behalf
        </span>
      </label>

      <!-- Option 2 (default) -->
      <label class="flex items-start gap-3 cursor-pointer">
        <input type="radio" name="my_profile_settings_tab_autoconfirmation_choice"
               class="my_profile_settings_tab_autoconfirmation_radio"
               value="all_lessons" checked>
        <span class="text-[15px] leading-6 text-gray-800">
          Autoconfirm all my lessons, including weekly lessons and lessons scheduled or rescheduled by my tutor.
        </span>
      </label>
    </div>

    <p class="my_profile_settings_tab_autoconfirmation_para mb-6">
      If you have any problems with your lessons, please let us know as soon as possible and we'll help you find a solution.
    </p>

    <!-- Save -->
    <div class="pt-1">
      <button id="my_profile_settings_tab_autoconfirmation_save"
              class="my_profile_settings_tab_autoconfirmation_save">
        Save changes
      </button>
    </div>
  </div>

  <script>
    function my_profile_settings_tab_autoconfirmation_init(){
      // demo submit
      $('#my_profile_settings_tab_autoconfirmation_save').on('click', function(e){
        e.preventDefault();
        const choice = $('input[name="my_profile_settings_tab_autoconfirmation_choice"]:checked').val();
        alert('Saved: ' + (choice === 'all_lessons'
               ? 'Autoconfirm ALL lessons'
               : 'Autoconfirm only lessons scheduled by you / on your behalf') + ' (demo).');
      });
    }
    $(document).ready(my_profile_settings_tab_autoconfirmation_init);
  </script>
</body>
</html>
