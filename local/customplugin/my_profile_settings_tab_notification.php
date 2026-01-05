<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Notification Settings</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_settings_tab_notifications_border:#E4E7EE;
      --my_profile_settings_tab_notifications_text:#111827;
      --my_profile_settings_tab_notifications_muted:#6B7280;
      --my_profile_settings_tab_notifications_red:#FF3B11;
      --my_profile_settings_tab_notifications_red_hover:#e2340f;
    }

    body{ color:var(--my_profile_settings_tab_notifications_text); }

    .my_profile_settings_tab_notifications_label{
      font-weight:600; color:var(--my_profile_settings_tab_notifications_text);
    }

    .my_profile_settings_tab_notifications_save{
      background:var(--my_profile_settings_tab_notifications_red);
      border:1px solid #000; color:#fff; font-weight:600;
      border-radius:12px; padding:14px 20px;
      width:100%; max-width:520px; transition:background .15s ease;
    }
    .my_profile_settings_tab_notifications_save:hover{
      background:var(--my_profile_settings_tab_notifications_red_hover);
    }

    /* custom checkbox to match figma */
    .my_profile_settings_tab_notifications_cb{
      appearance:none; -webkit-appearance:none;
      width:18px; height:18px; border:2px solid #9CA3AF; border-radius:4px;
      display:inline-grid; place-content:center; cursor:pointer;
      transition:border-color .15s ease, background .15s ease;
      margin-top:2px;
    }
    .my_profile_settings_tab_notifications_cb:checked{
      background:#111827; border-color:#111827;
    }
    .my_profile_settings_tab_notifications_cb:checked::before{
      content:"✓"; color:#fff; font-size:12px; line-height:1;
    }
  </style>
</head>
<body class="bg-white antialiased">

  <div class="my_profile_settings_tab_notifications_wrapper max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-semibold mb-6">Notification Settings</h1>

    <!-- Email notifications -->
    <div class="mb-6">
      <h2 class="my_profile_settings_tab_notifications_label mb-3">Email notifications</h2>

      <!-- Lessons and learning (checked) -->
      <label class="flex items-start gap-3 mb-4 cursor-pointer">
        <input id="my_profile_settings_tab_notifications_lessons"
               type="checkbox" class="my_profile_settings_tab_notifications_cb" checked>
        <div>
          <div class="font-semibold">Lessons and learning</div>
          <p class="text-sm text-gray-600 max-w-2xl">
            Get updates about your lessons, messages, and learning journey.
          </p>
        </div>
      </label>

      <!-- Tips and discounts -->
      <label class="flex items-start gap-3 cursor-pointer">
        <input id="my_profile_settings_tab_notifications_tips"
               type="checkbox" class="my_profile_settings_tab_notifications_cb">
        <div>
          <div class="font-semibold">Tips and discounts</div>
          <p class="text-sm text-gray-600 max-w-2xl">
            Discover tips for learning on Latingles and receive special promotions.
          </p>
        </div>
      </label>
    </div>

    <!-- Latingles Insights -->
    <div class="mb-8">
      <h2 class="my_profile_settings_tab_notifications_label mb-3">Latingles Insights</h2>

      <label class="flex items-start gap-3 cursor-pointer">
        <input id="my_profile_settings_tab_notifications_surveys"
               type="checkbox" class="my_profile_settings_tab_notifications_cb">
        <div>
          <div class="font-semibold">Surveys and interviews</div>
          <p class="text-sm text-gray-600 max-w-2xl">
            Earn rewards by offering feedback on your learning experience.
          </p>
        </div>
      </label>
    </div>

    <!-- Save -->
    <div class="pt-1">
      <button id="my_profile_settings_tab_notifications_save"
              class="my_profile_settings_tab_notifications_save">Save changes</button>
    </div>
  </div>

  <script>
    function my_profile_settings_tab_notifications_init(){
      $('#my_profile_settings_tab_notifications_save').on('click', function(e){
        e.preventDefault();
        const data = {
          lessons: $('#my_profile_settings_tab_notifications_lessons').is(':checked'),
          tips: $('#my_profile_settings_tab_notifications_tips').is(':checked'),
          surveys: $('#my_profile_settings_tab_notifications_surveys').is(':checked'),
        };
        // Replace with AJAX to persist:
        alert('Saved (demo):\n' + JSON.stringify(data, null, 2));
      });
    }
    $(document).ready(my_profile_settings_tab_notifications_init);
  </script>
</body>
</html>
