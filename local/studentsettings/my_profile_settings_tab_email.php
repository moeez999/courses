<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Email – Settings</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_settings_tab_email_border:#E4E7EE;
      --my_profile_settings_tab_email_red:#FF3B11;
      --my_profile_settings_tab_email_red_hover:#e2340f;
    }
    .my_profile_settings_tab_email_input{
      width:100%;
      border:1px solid var(--my_profile_settings_tab_email_border);
      border-radius:5px;
      background:#fff;
      padding:.625rem .875rem;
      line-height:1.35;
      font-size:.95rem;
    }
    .my_profile_settings_tab_email_input:focus{
      outline:none; border-color:#C7CDD8; box-shadow:0 0 0 3px rgba(59,130,246,.1);
    }
    .my_profile_settings_tab_email_savebtn{
      background:var(--my_profile_settings_tab_email_red);
      border:1px solid #000;
      color:#fff; font-weight:600;
      border-radius:5px;
      padding:10px 20px;
      width:100%; max-width:520px;
      transition:background .15s ease;
    }
    .my_profile_settings_tab_email_savebtn:hover{ background:var(--my_profile_settings_tab_email_red_hover); }
  </style>
</head>
<body class="bg-white antialiased">

  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-semibold mb-6">Email</h1>

    <form id="my_profile_settings_tab_email_form" class="space-y-6" style="width:70%;">
      <div>
        <label for="my_profile_settings_tab_email_input"
               class="block font-semibold mb-2">Email</label>
        <input id="my_profile_settings_tab_email_input"
               type="email"
               class="my_profile_settings_tab_email_input"
               placeholder="you@example.com"
               value="latingles.academy@gmail.com">
      </div>

      <div class="pt-1">
        <button type="submit" class="my_profile_settings_tab_email_savebtn">
          Save changes
        </button>
      </div>
    </form>
  </div>

  <script>
    // Simple demo validation + submit hook
    function my_profile_settings_tab_email_init(){
      $('#my_profile_settings_tab_email_form').on('submit', function(e){
        e.preventDefault();
        const v = $('#my_profile_settings_tab_email_input').val().trim();
        // basic email check
        const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        if(!ok){ alert('Please enter a valid email.'); return; }
        // TODO: replace with AJAX to your backend
        alert('Email saved (demo).');
      });
    }
    $(document).ready(my_profile_settings_tab_email_init);
  </script>
</body>
</html>
