<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>My Profile – Background Tab</title>

  <!-- Tailwind + jQuery -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root{
      --my_profile_background_tab_text:#121117;
      --my_profile_background_tab_muted:#6B7280;
      --my_profile_background_tab_border:#E4E7EE;
      --my_profile_background_tab_accent:#ff3b1f;

      --my_profile_background_tab_green_bg:#DDF5EA;
      --my_profile_background_tab_green_bd:#B9E7D1;

      --my_profile_background_tab_radius:12px;
      --my_profile_background_tab_control_h:48px;
    }

    .my_profile_background_tab_container p,
    .my_profile_background_tab_container label{ color:var(--my_profile_background_tab_text) }
    .my_profile_background_tab_muted{ color:var(--my_profile_background_tab_muted) }

    .my_profile_background_tab_input,
    .my_profile_background_tab_select{
      width:100%;
      height:var(--my_profile_background_tab_control_h);
      border:1.5px solid var(--my_profile_background_tab_border);
      border-radius:var(--my_profile_background_tab_radius);
      padding:0 14px;
      outline:0;
      background:#fff;
      transition:border-color .15s, box-shadow .15s;
    }
    .my_profile_background_tab_input:focus,
    .my_profile_background_tab_select:focus{
      border-color:#b9c0d4;
      box-shadow:0 0 0 4px rgba(59,130,246,.08);
    }

    .my_profile_background_tab_btn{
      background:var(--my_profile_background_tab_accent);
      color:#fff; border-radius:10px; height:46px; padding:0 28px; font-weight:600;
      border:1.5px solid #000; /* matches your Save style in other tabs */
    }

    .my_profile_background_tab_card{
      border:1.5px solid var(--my_profile_background_tab_border);
      border-radius:12px;
      background:#fff;
    }

    .my_profile_background_tab_verify{
      border:1.5px solid var(--my_profile_background_tab_green_bd);
      background:var(--my_profile_background_tab_green_bg);
      border-radius:10px;
    }

    .my_profile_background_tab_iconbtn{
      width:36px;height:36px;border:1.5px solid var(--my_profile_background_tab_border);
      border-radius:10px;display:inline-flex;align-items:center;justify-content:center;background:#fff;
    }

    .my_profile_background_tab_link{ text-decoration: underline; font-weight: 600 }
    .my_profile_background_tab_link:hover{ text-decoration: none }

    @media (max-width:640px){
      .my_profile_background_tab_h1{ font-size:1.6rem; line-height:1.25 }
    }
  </style>
</head>
<body class="bg-white text-[15px] sm:text-[16px]">
  <main class="my_profile_background_tab_container max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

    <!-- ===================== Teaching certification ===================== -->
    <h1 class="my_profile_background_tab_h1 text-[28px] sm:text-[32px] font-semibold mb-6">
      Teaching certification
    </h1>

    <div id="my_profile_background_tab_certs" class="space-y-8">
      <!-- Certificate item (template instance rendered via JS as well) -->
      <div class="my_profile_background_tab_certItem">
        <!-- Subject + delete -->
        <div class="flex items-center gap-2 mb-4">
          <div class="relative flex-1">
            <label class="block text-[15px] font-semibold mb-2">Subject</label>
            <select class="my_profile_background_tab_select pr-10">
              <option>English</option>
              <option>Spanish</option>
              <option>Portuguese</option>
              <option>French</option>
            </select>
            <svg class="pointer-events-none w-5 h-5 absolute right-3 top-[38px] text-black"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
            </svg>
          </div>
          <button type="button" class="my_profile_background_tab_delCert my_profile_background_tab_iconbtn mt-7" title="Delete certificate">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="1.6" d="M3 6h18M8 6v12m8-12v12M5 6l1 14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-14M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>
            </svg>
          </button>
        </div>

        <!-- Certificate -->
        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Certificate</label>
          <input type="text" class="my_profile_background_tab_input" placeholder="Language Certificate"/>
        </div>

        <!-- Description -->
        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Description</label>
          <input type="text" class="my_profile_background_tab_input" placeholder="Latingles Language Teaching Certificate"/>
        </div>

        <!-- Issued by -->
        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Issued by</label>
          <input type="text" class="my_profile_background_tab_input" placeholder="Latingles"/>
        </div>

        <!-- Years of study -->
        <div class="mb-2">
          <label class="block text-[15px] font-semibold mb-2">Years of study</label>
          <div class="flex gap-3">
            <div class="relative flex-1">
              <select class="my_profile_background_tab_select my_profile_background_tab_yearStart"></select>
              <svg class="pointer-events-none w-5 h-5 absolute right-3 top-3.5 text-black"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
              </svg>
            </div>
            <div class="relative flex-1">
              <select class="my_profile_background_tab_select my_profile_background_tab_yearEnd"></select>
              <svg class="pointer-events-none w-5 h-5 absolute right-3 top-3.5 text-black"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Verification card -->
    <div class="my_profile_background_tab_card mt-8 p-4 sm:p-5">
      <p class="font-semibold mb-2">Get a “Certificate verified” badge</p>
      <p class="my_profile_background_tab_muted mb-4">
        Upload your certificate to boost your credibility! Our team will review it and add the badge to your profile.
        Once reviewed, your files will be deleted.
      </p>
      <p class="my_profile_background_tab_muted mb-3">JPG or PNG format; maximum size of 20MB.</p>

      <div class="flex items-center gap-3">
        <button type="button" id="my_profile_background_tab_btnUpload" class="my_profile_background_tab_iconbtn px-4 w-auto h-[40px]">
          Upload
        </button>
        <input id="my_profile_background_tab_file" type="file" accept="image/png,image/jpeg" class="hidden"/>
        <span id="my_profile_background_tab_fileName" class="text-sm my_profile_background_tab_muted"></span>
      </div>
    </div>

    <div class="mt-4 mb-10">
      <button type="button" id="my_profile_background_tab_addCert" class="my_profile_background_tab_link">Add another certificate</button>
    </div>

    <div class="mb-12">
      <button class="my_profile_background_tab_btn" id="my_profile_background_tab_saveCert">Save</button>
    </div>

    <!-- ===================== Education ===================== -->
    <h2 class="text-[22px] sm:text-[24px] font-semibold mb-4">Education</h2>

    <div id="my_profile_background_tab_eduList" class="space-y-10">
      <div class="my_profile_background_tab_eduItem">
        <!-- University + delete -->
        <div class="flex items-center gap-2 mb-4">
          <div class="flex-1">
            <label class="block text-[15px] font-semibold mb-2">University</label>
            <input type="text" class="my_profile_background_tab_input" placeholder="Universidad del Zulia"/>
          </div>
          <button type="button" class="my_profile_background_tab_delEdu my_profile_background_tab_iconbtn mt-7" title="Delete education">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="1.6" d="M3 6h18M8 6v12m8-12v12M5 6l1 14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-14M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>
            </svg>
          </button>
        </div>

        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Degree</label>
          <input type="text" class="my_profile_background_tab_input" placeholder="Bachelor’s degree in Mechanical Engineering"/>
        </div>

        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Degree type</label>
          <div class="relative">
            <select class="my_profile_background_tab_select pr-10">
              <option>Other degree</option>
              <option>Bachelor’s degree</option>
              <option>Master’s degree</option>
              <option>PhD / Doctorate</option>
            </select>
            <svg class="pointer-events-none w-5 h-5 absolute right-3 top-3.5 text-black"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
            </svg>
          </div>
        </div>

        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Specialization</label>
          <input type="text" class="my_profile_background_tab_input" placeholder="Mechanical Engineering"/>
        </div>

        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Years of study</label>
          <div class="flex gap-3">
            <div class="relative flex-1">
              <select class="my_profile_background_tab_select my_profile_background_tab_yearStart"></select>
              <svg class="pointer-events-none w-5 h-5 absolute right-3 top-3.5 text-black"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
              </svg>
            </div>
            <div class="relative flex-1">
              <select class="my_profile_background_tab_select my_profile_background_tab_yearEnd"></select>
              <svg class="pointer-events-none w-5 h-5 absolute right-3 top-3.5 text-black"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- Verified strip -->
        <div class="my_profile_background_tab_verify flex items-start gap-3 p-3 sm:p-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-width="1.6" d="M20 7l-9 9-4-4"/>
            <path stroke-width="1.6" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10"/>
          </svg>
          <div>
            <p class="font-semibold">Your diploma is verified</p>
            <p class="my_profile_background_tab_muted text-[14px]">
              See a green verification badge on your tutor profile
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4 mb-10">
      <button type="button" id="my_profile_background_tab_addEdu" class="my_profile_background_tab_link">Add another education</button>
    </div>

    <div class="mb-12">
      <button class="my_profile_background_tab_btn" id="my_profile_background_tab_saveEdu">Save</button>
    </div>

    <!-- ===================== Experience ===================== -->
    <h2 class="text-[22px] sm:text-[24px] font-semibold mb-4">Experience</h2>

    <div id="my_profile_background_tab_jobList" class="space-y-10">
      <div class="my_profile_background_tab_jobItem">
        <!-- Company + delete -->
        <div class="flex items-center gap-2 mb-4">
          <div class="flex-1">
            <label class="block text-[15px] font-semibold mb-2">Company</label>
            <input type="text" class="my_profile_background_tab_input" placeholder="Latingles Academy"/>
          </div>
          <button type="button" class="my_profile_background_tab_delJob my_profile_background_tab_iconbtn mt-7" title="Delete job">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="1.6" d="M3 6h18M8 6v12m8-12v12M5 6l1 14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-14M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>
            </svg>
          </button>
        </div>

        <div class="mb-4">
          <label class="block text-[15px] font-semibold mb-2">Position</label>
          <input type="text" class="my_profile_background_tab_input" placeholder="Operation and Logistics Manager"/>
        </div>

        <div class="mb-2">
          <label class="block text-[15px] font-semibold mb-2">Period of employment</label>
          <div class="flex gap-3">
            <div class="relative flex-1">
              <select class="my_profile_background_tab_select my_profile_background_tab_yearStart"></select>
              <svg class="pointer-events-none w-5 h-5 absolute right-3 top-3.5 text-black"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
              </svg>
            </div>
            <div class="relative flex-1">
              <select class="my_profile_background_tab_select my_profile_background_tab_yearEnd"></select>
              <svg class="pointer-events-none w-5 h-5 absolute right-3 top-3.5 text-black"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-width="1.6" d="M6 9l6 6 6-6"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4 mb-10">
      <button type="button" id="my_profile_background_tab_addJob" class="my_profile_background_tab_link">Add another job</button>
    </div>

    <div class="mb-4">
      <button class="my_profile_background_tab_btn" id="my_profile_background_tab_saveJob">Save</button>
    </div>
  </main>

  <script>
    (function($){

      /* ------------ helpers ------------ */
      function my_profile_background_tab_yearOptions(){
        const now = new Date().getFullYear();
        const years = [];
        for(let y = now; y >= 1970; y--) years.push(`<option>${y}</option>`);
        years.push('<option>Present</option>');
        return years.join('');
      }

      function my_profile_background_tab_initYears($scope){
        $scope.find('.my_profile_background_tab_yearStart').each(function(){
          $(this).html(my_profile_background_tab_yearOptions()).val(new Date().getFullYear().toString());
        });
        $scope.find('.my_profile_background_tab_yearEnd').each(function(){
          $(this).html(my_profile_background_tab_yearOptions()).val('Present');
        });
      }

      function my_profile_background_tab_buttonPulse($btn){
        $btn.addClass("ring-2 ring-black/10");
        setTimeout(()=> $btn.removeClass("ring-2 ring-black/10"), 300);
      }

      /* ------------ certificates ------------ */
      $("#my_profile_background_tab_btnUpload").on("click", function(){
        $("#my_profile_background_tab_file").trigger("click");
      });
      $("#my_profile_background_tab_file").on("change", function(){
        const file = this.files && this.files[0];
        const $name = $("#my_profile_background_tab_fileName");
        $name.text('');
        if(!file) return;

        if(!/image\/(png|jpeg)/.test(file.type)) return $name.text("Please upload JPG or PNG.");
        if(file.size > 20*1024*1024) return $name.text("File exceeds 20MB.");
        $name.text(file.name);
      });

      $("#my_profile_background_tab_addCert").on("click", function(){
        const $tmpl = $(".my_profile_background_tab_certItem").first().clone(true, true);
        $tmpl.find("input").val("");
        $("#my_profile_background_tab_certs").append($tmpl);
        my_profile_background_tab_initYears($tmpl);
      });

      $(document).on("click", ".my_profile_background_tab_delCert", function(){
        const $items = $(".my_profile_background_tab_certItem");
        if($items.length > 1) $(this).closest(".my_profile_background_tab_certItem").remove();
      });

      $("#my_profile_background_tab_saveCert").on("click", function(){
        my_profile_background_tab_buttonPulse($(this));
        alert("Certification saved (demo).");
      });

      /* ------------ education ------------ */
      $("#my_profile_background_tab_addEdu").on("click", function(){
        const $tmpl = $(".my_profile_background_tab_eduItem").first().clone(true, true);
        $tmpl.find("input").val("");
        $("#my_profile_background_tab_eduList").append($tmpl);
        my_profile_background_tab_initYears($tmpl);
      });

      $(document).on("click", ".my_profile_background_tab_delEdu", function(){
        const $items = $(".my_profile_background_tab_eduItem");
        if($items.length > 1) $(this).closest(".my_profile_background_tab_eduItem").remove();
      });

      $("#my_profile_background_tab_saveEdu").on("click", function(){
        my_profile_background_tab_buttonPulse($(this));
        alert("Education saved (demo).");
      });

      /* ------------ experience ------------ */
      $("#my_profile_background_tab_addJob").on("click", function(){
        const $tmpl = $(".my_profile_background_tab_jobItem").first().clone(true, true);
        $tmpl.find("input").val("");
        $("#my_profile_background_tab_jobList").append($tmpl);
        my_profile_background_tab_initYears($tmpl);
      });

      $(document).on("click", ".my_profile_background_tab_delJob", function(){
        const $items = $(".my_profile_background_tab_jobItem");
        if($items.length > 1) $(this).closest(".my_profile_background_tab_jobItem").remove();
      });

      $("#my_profile_background_tab_saveJob").on("click", function(){
        my_profile_background_tab_buttonPulse($(this));
        alert("Experience saved (demo).");
      });

      /* ------------ initial ------------ */
      my_profile_background_tab_initYears($(document));

    })(jQuery);
  </script>
</body>
</html>
