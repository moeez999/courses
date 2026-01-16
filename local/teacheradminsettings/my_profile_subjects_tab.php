<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Profile – Subjects Tab</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root {
      --my_profile_subjects_tab_text: #121117;
      --my_profile_subjects_tab_muted: #6B7280;
      --my_profile_subjects_tab_border: #E4E7EE;
      --my_profile_subjects_tab_accent: #ff3b1f;
      --my_profile_subjects_tab_control_h: 44px;
      --my_profile_subjects_tab_radius: 10px;
    }

    .my_profile_subjects_tab_container p,
    .my_profile_subjects_tab_container label {
      color: var(--my_profile_subjects_tab_text)
    }

    .my_profile_subjects_tab_muted {
      color: var(--my_profile_subjects_tab_muted)
    }

    .my_profile_subjects_tab_input {
      height: var(--my_profile_subjects_tab_control_h);
      border: 1.5px solid var(--my_profile_subjects_tab_border);
      border-radius: var(--my_profile_subjects_tab_radius);
      padding: 0 .9rem;
      outline: 0;
    }

    .my_profile_subjects_tab_textarea {
      border: 1.5px solid var(--my_profile_subjects_tab_border);
      border-radius: var(--my_profile_subjects_tab_radius);
      padding: .85rem 1rem;
      width: 100%;
      min-height: 120px;
      outline: 0;
      resize: vertical;
    }

    /* Checkbox row */
    .my_profile_subjects_tab_row {
      display: flex;
      align-items: center;
      gap: .6rem;
      padding: .4rem 0;
    }

    /* Save button */
    .my_profile_subjects_tab_btn {
      background: var(--my_profile_subjects_tab_accent);
      color: #fff;
      border-radius: 10px;
      height: 44px;
      padding: 0 28px;
      font-weight: 600;
      border: 2px solid #000;

    }

    @media (max-width: 640px) {
      .my_profile_subjects_tab_h1 {
        font-size: 1.6rem;
        line-height: 1.25
      }
    }
  </style>
</head>

<body class="bg-white text-[15px] sm:text-[16px]">
  <main class="my_profile_subjects_tab_container max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

    <!-- Title -->
    <h1 class="my_profile_subjects_tab_h1 text-[28px] sm:text-[32px] font-semibold mb-8">
      Tutoring subjects
    </h1>

    <!-- Years of experience -->
    <section class="mb-8">
      <label for="my_profile_subjects_tab_years"
        class="block text-[15px] font-semibold mb-2">Years of experience</label>
      <input id="my_profile_subjects_tab_years" type="number" min="0" step="1" placeholder="0"
        class="my_profile_subjects_tab_input w-[110px]" />
    </section>

    <!-- Student proficiency level -->
    <section class="mb-8">
      <h2 class="text-[16px] font-semibold mb-2">Student proficiency level</h2>

      <div class="space-y-1">
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>Beginner</span>
        </label>
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>Pre Intermediate</span>
        </label>
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>Intermediate</span>
        </label>
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>Upper Intermediate</span>
        </label>
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" checked /> <span>Advanced</span>
        </label>
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" checked /> <span>Proficiency</span>
        </label>
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>Not Specified</span>
        </label>
      </div>
    </section>

    <!-- Preferred age group -->
    <section class="mb-10">
      <h2 class="text-[16px] font-semibold mb-2">Preferred age group</h2>

      <div class="space-y-1">
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Toddlers (1–3)</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Preschoolers (4–6)</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Primary school (6–12)</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Secondary school (12–17)</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Students (17–22)</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Adults (23–40)</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Adults (40+)</span></label>
      </div>
    </section>

    <!-- English specializations -->
    <section class="mb-12">
      <h2 class="text-[15px] font-semibold mb-3">English</h2>

      <!-- Conversational English -->
      <div class="mb-4">
        <label class="my_profile_subjects_tab_row">
          <input id="my_profile_subjects_tab_chk_convo" class="accent-black w-4 h-4" type="checkbox" checked />
          <span>Conversational English</span>
        </label>
        <div id="my_profile_subjects_tab_note_convo" class="pl-7 pt-2">
          <textarea class="my_profile_subjects_tab_textarea"
            placeholder="Add details...">Soy Nativa del idioma Español por lo que puedo conversar perfectamente en el idioma sobre cualquier tema que sea de tu interés</textarea>
        </div>
      </div>

      <!-- English for beginners -->
      <div class="mb-4">
        <label class="my_profile_subjects_tab_row">
          <input id="my_profile_subjects_tab_chk_beg" class="accent-black w-4 h-4" type="checkbox" />
          <span>English for beginners</span>
        </label>
        <div id="my_profile_subjects_tab_note_beg" class="pl-7 pt-2 hidden">
          <textarea class="my_profile_subjects_tab_textarea" placeholder="Add details..."></textarea>
        </div>
      </div>

      <!-- Intensive English -->
      <div class="mb-4">
        <label class="my_profile_subjects_tab_row">
          <input id="my_profile_subjects_tab_chk_intensive" class="accent-black w-4 h-4" type="checkbox" />
          <span>Intensive English</span>
        </label>
        <div id="my_profile_subjects_tab_note_intensive" class="pl-7 pt-2 hidden">
          <textarea class="my_profile_subjects_tab_textarea" placeholder="Add details..."></textarea>
        </div>
      </div>

      <!-- Latin American English -->
      <div class="mb-6">
        <label class="my_profile_subjects_tab_row">
          <input id="my_profile_subjects_tab_chk_latam" class="accent-black w-4 h-4" type="checkbox" checked />
          <span>Latin American English</span>
        </label>
        <div id="my_profile_subjects_tab_note_latam" class="pl-7 pt-2">
          <textarea class="my_profile_subjects_tab_textarea"
            placeholder="Add details...">Soy Venezolana, por tanto, mi español es Latino</textarea>
        </div>
      </div>

      <!-- DELE -->
      <div class="mb-2">
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>DELE</span>
        </label>
      </div>

      <!-- English for children -->
      <div class="mb-2">
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>English for children</span>
        </label>
      </div>

      <!-- European English -->
      <div class="mb-6">
        <label class="my_profile_subjects_tab_row">
          <input class="accent-black w-4 h-4" type="checkbox" /> <span>European English</span>
        </label>
      </div>

      <!-- Business English -->
      <div class="mb-6">
        <label class="my_profile_subjects_tab_row">
          <input id="my_profile_subjects_tab_chk_business" class="accent-black w-4 h-4" type="checkbox" checked />
          <span>Business English</span>
        </label>
        <div id="my_profile_subjects_tab_note_business" class="pl-7 pt-2">
          <textarea class="my_profile_subjects_tab_textarea"
            placeholder="Add details...">Soy Ingeniera Mecánica, por lo que puedo hablar sobre temas específicos y técnicos relacionados con la ingeniería. También tengo experiencia en atención al cliente y ventas</textarea>
        </div>
      </div>

      <!-- General English -->
      <div class="mb-10">
        <label class="my_profile_subjects_tab_row">
          <input id="my_profile_subjects_tab_chk_general" class="accent-black w-4 h-4" type="checkbox" checked />
          <span>General English</span>
        </label>
        <div id="my_profile_subjects_tab_note_general" class="pl-7 pt-2">
          <textarea class="my_profile_subjects_tab_textarea"
            placeholder="Add details...">Me encanta tener conversaciones sobre temas de todo tipo</textarea>
        </div>
      </div>

      <!-- More options list -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-8">
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Ap English</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Mexican English</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Colombian English</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>English Literature</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>SAT English</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Cuban English</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>Chilean English</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>English for ADHD students</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>SIELE</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>English for dyslexic students</span></label>
        <label class="my_profile_subjects_tab_row"><input class="accent-black w-4 h-4" type="checkbox" /> <span>English for students with Asperger's syndrome</span></label>
      </div>
    </section>

    <!-- Save -->
    <div class="mt-6">
      <button id="my_profile_subjects_tab_btnSave" class="my_profile_subjects_tab_btn">Save</button>
    </div>
  </main>

  <script>
    // Toggle helper
    function my_profile_subjects_tab_toggle(noteId, isOn) {
      const $el = jQuery(noteId);
      if (isOn) {
        $el.removeClass("hidden");
      } else {
        $el.addClass("hidden");
      }
    }

    (function($) {
      // Hook toggles for the items that show notes
      $("#my_profile_subjects_tab_chk_convo").on("change", function() {
        my_profile_subjects_tab_toggle("#my_profile_subjects_tab_note_convo", this.checked);
      });
      $("#my_profile_subjects_tab_chk_beg").on("change", function() {
        my_profile_subjects_tab_toggle("#my_profile_subjects_tab_note_beg", this.checked);
      });
      $("#my_profile_subjects_tab_chk_intensive").on("change", function() {
        my_profile_subjects_tab_toggle("#my_profile_subjects_tab_note_intensive", this.checked);
      });
      $("#my_profile_subjects_tab_chk_latam").on("change", function() {
        my_profile_subjects_tab_toggle("#my_profile_subjects_tab_note_latam", this.checked);
      });
      $("#my_profile_subjects_tab_chk_business").on("change", function() {
        my_profile_subjects_tab_toggle("#my_profile_subjects_tab_note_business", this.checked);
      });
      $("#my_profile_subjects_tab_chk_general").on("change", function() {
        my_profile_subjects_tab_toggle("#my_profile_subjects_tab_note_general", this.checked);
      });

      // Save (demo)
      $("#my_profile_subjects_tab_btnSave").on("click", function() {
        $(this).addClass("ring-2 ring-black/10");
        setTimeout(() => $(this).removeClass("ring-2 ring-black/10"), 350);
        alert("Subjects saved (demo).");
      });
    })(jQuery);
  </script>
</body>

</html>