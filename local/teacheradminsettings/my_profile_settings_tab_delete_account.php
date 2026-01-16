<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Delete Account</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_settings_tab_delete_account_border:#E4E7EE;
      --my_profile_settings_tab_delete_account_text:#111827;
      --my_profile_settings_tab_delete_account_muted:#6B7280;
      --my_profile_settings_tab_delete_account_red:#FF3B11;
      --my_profile_settings_tab_delete_account_red_hover:#e2340f;
    }

    body{
      color:var(--my_profile_settings_tab_delete_account_text);
      font-family:'Inter', sans-serif;
    }

    .my_profile_settings_tab_delete_account_input{
      width:100%;
      border:1px solid var(--my_profile_settings_tab_delete_account_border);
      border-radius:10px;
      background:#fff;
      padding:.7rem .9rem;
      color:var(--my_profile_settings_tab_delete_account_text);
      font-size:.95rem;
    }

    .my_profile_settings_tab_delete_account_input:focus{
      outline:none;
      border-color:#C7CDD8;
      box-shadow:0 0 0 3px rgba(59,130,246,.1);
    }

    .my_profile_settings_tab_delete_account_btn{
      background:#fff;
      border:1px solid #000;
      border-radius:12px;
      font-weight:600;
      padding:12px 20px;
      color:#111;
      transition:all .15s ease;
      width:100%;
      max-width:240px;
    }

    .my_profile_settings_tab_delete_account_btn:hover{
      background:#f9f9f9;
    }
  </style>
</head>
<body class="bg-white antialiased">

  <div class="my_profile_settings_tab_delete_account_wrapper max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-semibold mb-6">Delete account</h1>

    <p class="text-[15px] text-gray-600 leading-6 mb-6 max-w-2xl">
      Deleting your account is permanent and all your account information will be deleted along with it.
      If you're sure you want to proceed, enter your email address below.
    </p>

    <div class="mb-6">
      <label for="my_profile_settings_tab_delete_account_email"
             class="block font-semibold mb-2">Email</label>
      <input id="my_profile_settings_tab_delete_account_email"
             type="email"
             placeholder="you@example.com"
             class="my_profile_settings_tab_delete_account_input">
    </div>

    <button id="my_profile_settings_tab_delete_account_btn"
            class="my_profile_settings_tab_delete_account_btn">
      Delete account
    </button>
  </div>

  <script>
    function my_profile_settings_tab_delete_account_init(){
      $('#my_profile_settings_tab_delete_account_btn').on('click', function(e){
        e.preventDefault();
        const email = $('#my_profile_settings_tab_delete_account_email').val().trim();
        if(!email){
          alert('Please enter your email before deleting the account.');
          return;
        }
        if(confirm('Are you sure you want to permanently delete your account?')){
          // TODO: Replace this alert with an AJAX call to delete the account
          alert('Account deletion process started for ' + email + ' (demo).');
        }
      });
    }
    $(document).ready(my_profile_settings_tab_delete_account_init);
  </script>
</body>
</html>
