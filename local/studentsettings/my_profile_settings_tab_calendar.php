<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Google Calendar</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_settings_tab_calendar_border:#E4E7EE;
      --my_profile_settings_tab_calendar_text:#111827;
      --my_profile_settings_tab_calendar_muted:#6B7280;
      --my_profile_settings_tab_calendar_red:#FF3B11;
      --my_profile_settings_tab_calendar_red_hover:#e2340f;
    }

    body{
      font-family:'Inter', sans-serif;
      color:var(--my_profile_settings_tab_calendar_text);
    }

    .my_profile_settings_tab_calendar_label{
      font-weight:600;
      color:var(--my_profile_settings_tab_calendar_text);
      margin-bottom:.4rem;
      display:block;
    }

    .my_profile_settings_tab_calendar_input{
      width:100%;
      border:1px solid var(--my_profile_settings_tab_calendar_border);
      border-radius:10px;
      padding:.7rem .9rem;
      color:var(--my_profile_settings_tab_calendar_text);
      font-size:.95rem;
      background:#fff;
    }

    .my_profile_settings_tab_calendar_input:focus{
      outline:none;
      border-color:#C7CDD8;
      box-shadow:0 0 0 3px rgba(59,130,246,.1);
    }

    .my_profile_settings_tab_calendar_save{
      background:var(--my_profile_settings_tab_calendar_red);
      border:1px solid #000;
      color:#fff;
      font-weight:600;
      border-radius:12px;
      padding:14px 20px;
      width:100%;
      max-width:520px;
      transition:background .15s ease;
    }

    .my_profile_settings_tab_calendar_save:hover{
      background:var(--my_profile_settings_tab_calendar_red_hover);
    }

    /* checkbox and radio custom */
    .my_profile_settings_tab_calendar_checkbox,
    .my_profile_settings_tab_calendar_radio{
      appearance:none; -webkit-appearance:none;
      width:18px; height:18px;
      border:2px solid #9CA3AF;
      border-radius:4px;
      cursor:pointer;
      display:inline-grid;
      place-content:center;
      transition:border-color .15s ease, background .15s ease;
    }

    .my_profile_settings_tab_calendar_checkbox:checked{
      background:#111827;
      border-color:#111827;
    }

    .my_profile_settings_tab_calendar_checkbox:checked::before{
      content:"✓"; color:#fff; font-size:12px;
    }

    .my_profile_settings_tab_calendar_radio{
      border-radius:50%;
    }

    .my_profile_settings_tab_calendar_radio:checked::before{
      content:""; width:8px; height:8px; border-radius:50%; background:#111827;
    }
  </style>
</head>
<body class="bg-white antialiased">

  <div class="my_profile_settings_tab_calendar_wrapper max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-semibold mb-6">Google Calendar</h1>

    <!-- Connected Account -->
    <div class="flex items-center gap-3 mb-2">
      <img src="https://www.svgrepo.com/show/355037/google.svg" alt="google" class="w-6 h-6">
      <span class="font-medium text-gray-800">Currently connected account</span>
    </div>

    <p class="font-semibold text-lg mb-3">ArnoldAddyson77@gmail.com</p>

    <button id="my_profile_settings_tab_calendar_disconnect"
            class="my_profile_settings_tab_calendar_input text-center font-semibold mb-6">
      Disconnect Google Calendar
    </button>

    <!-- Add lessons -->
    <label class="my_profile_settings_tab_calendar_label">Add lessons to calendar</label>
    <p class="text-sm text-gray-600 mb-2">
      Use this setting to automatically add Latingles lessons to your connected calendar.
    </p>
    <div class="relative mb-6">
      <select id="my_profile_settings_tab_calendar_email" class="my_profile_settings_tab_calendar_input">
        <option value="arnoldaddyson77@gmail.com">ArnoldAddyson77@gmail.com</option>
        <option value="otheremail@gmail.com">Otheremail@gmail.com</option>
      </select>
    </div>

    <!-- Check calendars -->
    <label class="my_profile_settings_tab_calendar_label">Check calendars for conflict</label>
    <p class="text-sm text-gray-600 mb-3">
      Choose calendars which you would like to check to schedule new lessons on Latingles:
    </p>

    <div class="space-y-3 mb-8">
      <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" class="my_profile_settings_tab_calendar_checkbox"
               id="my_profile_settings_tab_calendar_check1" checked>
        <span class="text-gray-800 text-[15px]">ArnoldAddyson77</span>
      </label>

      <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" class="my_profile_settings_tab_calendar_checkbox"
               id="my_profile_settings_tab_calendar_check2">
        <span class="text-gray-800 text-[15px]">Holidays in United States</span>
      </label>

      <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" class="my_profile_settings_tab_calendar_checkbox"
               id="my_profile_settings_tab_calendar_check3">
        <span class="text-gray-800 text-[15px]">Birthdays</span>
      </label>
    </div>

    <!-- Reminder -->
    <label class="my_profile_settings_tab_calendar_label">Remind me before a lesson</label>
    <p class="text-sm text-gray-600 mb-3">
      How far in advance you would like us to send you a reminder before your scheduled lesson.
    </p>

    <div class="space-y-3 mb-8">
      <label class="flex items-center gap-3 cursor-pointer">
        <input type="radio" name="my_profile_settings_tab_calendar_reminder"
               class="my_profile_settings_tab_calendar_radio"
               value="none">
        <span>No notification</span>
      </label>

      <label class="flex items-center gap-3 cursor-pointer">
        <input type="radio" name="my_profile_settings_tab_calendar_reminder"
               class="my_profile_settings_tab_calendar_radio"
               value="15min" checked>
        <span>15 min before a lesson</span>
      </label>

      <label class="flex items-center gap-3 cursor-pointer">
        <input type="radio" name="my_profile_settings_tab_calendar_reminder"
               class="my_profile_settings_tab_calendar_radio"
               value="60min">
        <span>60 min before a lesson</span>
      </label>

      <label class="flex items-center gap-3 cursor-pointer">
        <input type="radio" name="my_profile_settings_tab_calendar_reminder"
               class="my_profile_settings_tab_calendar_radio"
               value="24h">
        <span>24 hours before a lesson</span>
      </label>
    </div>

    <!-- Save -->
    <button id="my_profile_settings_tab_calendar_save"
            class="my_profile_settings_tab_calendar_save">
      Save changes
    </button>
  </div>

  <script>
    function my_profile_settings_tab_calendar_init(){
      // Disconnect Google
      $('#my_profile_settings_tab_calendar_disconnect').on('click', function(){
        alert('Google Calendar disconnected (demo).');
      });

      // Save changes
      $('#my_profile_settings_tab_calendar_save').on('click', function(){
        const email = $('#my_profile_settings_tab_calendar_email').val();
        const reminder = $('input[name="my_profile_settings_tab_calendar_reminder"]:checked').val();
        const conflicts = [];
        $('.my_profile_settings_tab_calendar_checkbox:checked').each(function(){
          conflicts.push($(this).next('span').text());
        });
        alert(`Settings saved:\nEmail: ${email}\nReminder: ${reminder}\nChecked calendars: ${conflicts.join(', ')}`);
      });
    }

    $(document).ready(my_profile_settings_tab_calendar_init);
  </script>
</body>
</html>
