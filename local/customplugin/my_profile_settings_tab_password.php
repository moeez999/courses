<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Change Password</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root {
      --my_profile_settings_tab_password_border: #E4E7EE;
      --my_profile_settings_tab_password_text: #121117;
      --my_profile_settings_tab_password_red: #FF3B11;
      --my_profile_settings_tab_password_red_hover: #e2340f;
    }

    .my_profile_settings_tab_password_input {
      width: 100%;
      border: 1px solid var(--my_profile_settings_tab_password_border);
      border-radius: 10px;
      background: #fff;
      padding: 0.625rem 2.75rem 0.625rem 0.875rem;
      line-height: 1.35;
      font-size: 0.95rem;
    }

    .my_profile_settings_tab_password_input:focus {
      outline: none;
      border-color: #C7CDD8;
      box-shadow: 0 0 0 3px rgba(59,130,246,.1);
    }

    .my_profile_settings_tab_password_toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      width: 22px;
      height: 22px;
      cursor: pointer;
      color: #444;
    }

    .my_profile_settings_tab_password_savebtn {
      background: var(--my_profile_settings_tab_password_red);
      border: 1px solid #000;
      color: #fff;
      font-weight: 600;
      border-radius: 5px;
      padding: 10px 20px;
      width: 100%;
      max-width: 520px;
      transition: background .15s ease;
    }

    .my_profile_settings_tab_password_savebtn:hover {
      background: var(--my_profile_settings_tab_password_red_hover);
    }

    .my_profile_settings_tab_password_forgot {
      color: #000;
      text-decoration: underline;
      font-weight: 600;
      font-size: 0.9rem;
    }

    .my_profile_settings_tab_password_forgot:hover {
      text-decoration: none;
    }
  </style>
</head>
<body class="bg-white antialiased">

  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-semibold mb-6">Change Password</h1>

    <form id="my_profile_settings_tab_password_form" class="space-y-6" style="width:70%;">
      <!-- Current password -->
      <div>
        <label class="block font-semibold mb-2">Current password</label>
        <div class="relative">
          <input type="password" id="my_profile_settings_tab_password_current" class="my_profile_settings_tab_password_input" placeholder="Enter current password" />
          <svg id="my_profile_settings_tab_password_toggle_current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="my_profile_settings_tab_password_toggle">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <div class="mt-2">
          <a href="#" class="my_profile_settings_tab_password_forgot">Forgot your password?</a>
        </div>
      </div>

      <!-- New password -->
      <div>
        <label class="block font-semibold mb-2">New password</label>
        <div class="relative">
          <input type="password" id="my_profile_settings_tab_password_new" class="my_profile_settings_tab_password_input" placeholder="Enter new password" />
          <svg id="my_profile_settings_tab_password_toggle_new" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="my_profile_settings_tab_password_toggle">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
      </div>

      <!-- Verify password -->
      <div>
        <label class="block font-semibold mb-2">Verify password</label>
        <div class="relative">
          <input type="password" id="my_profile_settings_tab_password_verify" class="my_profile_settings_tab_password_input" placeholder="Re-enter new password" />
          <svg id="my_profile_settings_tab_password_toggle_verify" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="my_profile_settings_tab_password_toggle">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
      </div>

      <!-- Save button -->
      <div class="pt-2">
        <button type="submit" class="my_profile_settings_tab_password_savebtn">
          Save changes
        </button>
      </div>
    </form>
  </div>

  <script>
    // Toggle password visibility for each field
    function my_profile_settings_tab_password_init(){
      const togglePassword = (inputId, toggleId) => {
        const input = $(inputId);
        const icon = $(toggleId);
        let visible = false;
        icon.on('click', () => {
          visible = !visible;
          input.attr('type', visible ? 'text' : 'password');
          icon.toggleClass('text-gray-400', !visible);
          icon.toggleClass('text-black', visible);
        });
      };

      togglePassword('#my_profile_settings_tab_password_current', '#my_profile_settings_tab_password_toggle_current');
      togglePassword('#my_profile_settings_tab_password_new', '#my_profile_settings_tab_password_toggle_new');
      togglePassword('#my_profile_settings_tab_password_verify', '#my_profile_settings_tab_password_toggle_verify');

      $('#my_profile_settings_tab_password_form').on('submit', function(e){
        e.preventDefault();
        alert('Password updated successfully (demo)');
      });
    }

    $(document).ready(my_profile_settings_tab_password_init);
  </script>
</body>
</html>
