<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>1:1 Class – Latingles</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    :root {
      --one_and_one_class_border: #E5E7EB;
      --one_and_one_class_text: #0F172A;
      --one_and_one_class_muted: #64748B;
      --one_and_one_class_soft: #F8FAFC;
      --one_and_one_class_shadow: 0 10px 24px rgba(0, 0, 0, .10);
      --one_and_one_class_radius: 16px;
    }

    html,
    body {
      margin: 0;
      padding: 0
    }

    body {
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue",
        Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
      color: var(--one_and_one_class_text);
      background: #fff;
    }

    .one_and_one_class_container {
      max-width: 1240px;
      margin: 0 auto;
      padding: 32px 16px 80px 16px;
    }

    .one_and_one_class_sectionhead {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 0 0 16px 0;
    }

    .one_and_one_class_sectionhead h2 {
      margin: 0;
      font-size: 28px;
      line-height: 1.2;
      font-weight: 700;
    }

    .one_and_one_class_chev {
      border: 1px solid var(--one_and_one_class_border);
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: #fff;
      cursor: pointer;
      display: grid;
      place-items: center;
    }

    .one_and_one_class_chev svg {
      width: 20px;
      height: 20px;
      stroke: #111;
      transition: transform .2s ease;
    }

    /* Rotate based on state */
    .one_and_one_class_chev[aria-expanded="true"] svg {
      transform: rotate(0deg);
    }

    /* up */
    .one_and_one_class_chev[aria-expanded="false"] svg {
      transform: rotate(180deg);
    }

    /* down */

    .one_and_one_class_scroller {
      display: flex;
      gap: 20px;
      padding: 12px 0;
      overflow-x: auto;
      overflow-y: visible;
      scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
    }

    .one_and_one_class_scroller::-webkit-scrollbar {
      display: none;
    }

    .one_and_one_class_scroller {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .one_and_one_class_card {
      min-width: 170px;
      width: 170px;
      height: 140px;
      background: #fff;
      border: 1px solid var(--one_and_one_class_border);
      border-radius: var(--one_and_one_class_radius);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      scroll-snap-align: start;
      position: relative;
    }

    .one_and_one_class_card--select {
      width: 210px;
      min-width: 210px;
      height: 150px;
      align-items: flex-start;
      padding: 0 20px;
    }

    .one_and_one_class_avatar {
      width: 64px;
      height: 64px;
      border-radius: 999px;
      object-fit: cover;
      display: block;
      margin: 0 0 12px 0;
    }

    .one_and_one_class_avatar_placeholder {
      width: 56px;
      height: 56px;
      border-radius: 999px;
      background: #F1F5F9;
      display: grid;
      place-items: center;
      margin-bottom: 12px;
      position: relative;
    }

    .one_and_one_class_avatar_placeholder svg {
      width: 28px;
      height: 28px;
      fill: #334155;
    }

    /* kill any injected number badges (e.g., "100") */
    .one_and_one_class_avatar_placeholder::before,
    .one_and_one_class_avatar_placeholder::after,
    .one_and_one_class_avatar_placeholder .badge,
    .one_and_one_class_avatar_placeholder .count,
    .one_and_one_class_avatar_placeholder [class*="badge"],
    .one_and_one_class_avatar_placeholder [class*="count"] {
      content: none !important;
      display: none !important;
    }

    .one_and_one_class_name {
      margin: 0;
      font-size: 14px;
      font-weight: 600;
    }

    .one_and_one_class_btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      font-weight: 600;
      color: #111;
      border: 1px solid var(--one_and_one_class_border);
      padding: 8px 12px;
      border-radius: 10px;
      background: #fff;
      cursor: pointer;
    }

    .one_and_one_class_btn svg {
      width: 16px;
      height: 16px;
      stroke: #111;
    }

    /* body-portaled dropdowns — fixed so they follow on scroll */
    .one_and_one_class_dropdown {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 9999;
      width: 320px;
      background: #fff;
      border: 1px solid var(--one_and_one_class_border);
      border-radius: 14px;
      box-shadow: var(--one_and_one_class_shadow);
    }

    .one_and_one_class_dropdown_head {
      padding: 10px 12px;
      border-bottom: 1px solid var(--one_and_one_class_border);
    }

    .one_and_one_class_dropdown_input {
      width: 100%;
      font-size: 14px;
      color: #0f172a;
      border: 1px solid var(--one_and_one_class_border);
      border-radius: 10px;
      padding: 9px 12px;
      outline: none;
      background: #fff;
    }

    .one_and_one_class_dropdown_list {
      max-height: 260px;
      overflow-y: auto;
    }

    .one_and_one_class_dropdown_list::-webkit-scrollbar {
      display: none;
    }

    .one_and_one_class_dropdown_list {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .one_and_one_class_dropdown_item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      cursor: pointer;
    }

    .one_and_one_class_dropdown_item:hover {
      background: #F3F4F6;
    }

    .one_and_one_class_dropdown_item img {
      width: 32px;
      height: 32px;
      border-radius: 999px;
      object-fit: cover;
    }

    .one_and_one_class_dropdown_item span {
      font-size: 14px;
      font-weight: 600;
      color: #111;
    }

    .one_and_one_class_panel {
      border: 1px solid var(--one_and_one_class_border);
      border-radius: 14px;
      background: #fff;
      padding: 24px;
      color: #334155;
      font-size: 14px;
    }

    @media (max-width:480px) {
      .one_and_one_class_sectionhead h2 {
        font-size: 22px;
      }

      .one_and_one_class_card {
        min-width: 150px;
        width: 150px;
      }

      .one_and_one_class_card--select {
        min-width: 190px;
        width: 190px;
      }

      .one_and_one_class_dropdown {
        width: 280px;
      }
    }
  </style>
</head>

<body>

  <main class="one_and_one_class_container">

    <?php require_once('my_teachers_details_top_section.php'); ?>



    <!-- TEACHERS -->
    <section class="one_and_one_class_section">
      <div class="one_and_one_class_sectionhead">
        <h2>Search 1:1 Sessions by Teacher</h2>
        <button id="one_and_one_class_toggle_teachers" class="one_and_one_class_chev" aria-expanded="true" title="Collapse/Expand">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M6 15l6-6 6 6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>

      <div id="one_and_one_class_row_teachers" class="one_and_one_class_scroller">
        <!-- Select teacher -->
        <div class="one_and_one_class_card one_and_one_class_card--select">
          <div class="one_and_one_class_avatar_placeholder">
            <svg viewBox="0 0 24 24">
              <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM2 20.5C2 16.91 7.58 15 12 15s10 1.91 10 5.5V22H2v-1.5z" />
            </svg>
          </div>

          <button id="one_and_one_class_select_teacher_btn" class="one_and_one_class_btn">
            <span id="one_and_one_class_select_teacher_label">Select teacher</span>
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M6 9l6 6 6-6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>

        <!-- Teacher avatars -->
        <div class="one_and_one_class_card"><img class="one_and_one_class_avatar" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?q=80&w=160&auto=format&fit=crop" alt="">
          <p class="one_and_one_class_name">Robert Fox</p>
        </div>
        <div class="one_and_one_class_card"><img class="one_and_one_class_avatar" src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=160&auto=format&fit=crop" alt="">
          <p class="one_and_one_class_name">Guy Hawkins</p>
        </div>
        <div class="one_and_one_class_card"><img class="one_and_one_class_avatar" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=160&auto=format&fit=crop" alt="">
          <p class="one_and_one_class_name">Bessie Cooper</p>
        </div>
        <div class="one_and_one_class_card"><img class="one_and_one_class_avatar" src="https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?q=80&w=160&auto=format&fit=crop" alt="">
          <p class="one_and_one_class_name">Jane Cooper</p>
        </div>
        <div class="one_and_one_class_card"><img class="one_and_one_class_avatar" src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?q=80&w=160&auto=format&fit=crop" alt="">
          <p class="one_and_one_class_name">Jenny Wilson</p>
        </div>
        <div class="one_and_one_class_card"><img class="one_and_one_class_avatar" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=160&auto=format&fit=crop" alt="">
          <p class="one_and_one_class_name">Jacob Jones</p>
        </div>
        <div class="one_and_one_class_card"><img class="one_and_one_class_avatar" src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=160&auto=format&fit=crop" alt="">
          <p class="one_and_one_class_name">Floyd Miles</p>
        </div>
      </div>
    </section>
    
    <!-- Active Students -->
    <section style="margin-top:24px;">
      <?php require_once('my_teachers_details_profile_section.php'); ?>
    </section>
    <?php require_once('my_teachers_details_tab_videos_details.php'); ?>


  </main>




























  <!-- Body-level dropdowns -->
  <div id="one_and_one_class_teacher_dropdown" class="one_and_one_class_dropdown" role="listbox" aria-label="Teacher selector">
    <div class="one_and_one_class_dropdown_head">
      <input id="one_and_one_class_teacher_search" class="one_and_one_class_dropdown_input" type="text" placeholder="Enter teacher name" />
    </div>
    <div class="one_and_one_class_dropdown_list" id="one_and_one_class_teacher_list">
      <div class="one_and_one_class_dropdown_item" data-name="Edwards"><img src="https://randomuser.me/api/portraits/men/35.jpg" alt=""><span>Edwards</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="Daniela"><img src="https://randomuser.me/api/portraits/women/45.jpg" alt=""><span>Daniela</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="Hawkins"><img src="https://randomuser.me/api/portraits/men/30.jpg" alt=""><span>Hawkins</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="Lane"><img src="https://randomuser.me/api/portraits/men/70.jpg" alt=""><span>Lane</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="Warren"><img src="https://randomuser.me/api/portraits/men/15.jpg" alt=""><span>Warren</span></div>
    </div>
  </div>

  <div id="one_and_one_class_student_dropdown" class="one_and_one_class_dropdown" role="listbox" aria-label="Student selector">
    <div class="one_and_one_class_dropdown_head">
      <input id="one_and_one_class_student_search" class="one_and_one_class_dropdown_input" type="text" placeholder="Enter student name" />
    </div>
    <div class="one_and_one_class_dropdown_list" id="one_and_one_class_student_list">
      <div class="one_and_one_class_dropdown_item" data-name="Maria"><img src="https://randomuser.me/api/portraits/women/40.jpg" alt=""><span>Maria</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="John"><img src="https://randomuser.me/api/portraits/men/55.jpg" alt=""><span>John</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="Ali"><img src="https://randomuser.me/api/portraits/men/28.jpg" alt=""><span>Ali</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="Sara"><img src="https://randomuser.me/api/portraits/women/15.jpg" alt=""><span>Sara</span></div>
      <div class="one_and_one_class_dropdown_item" data-name="Asim"><img src="https://randomuser.me/api/portraits/men/80.jpg" alt=""><span>Asim</span></div>
    </div>
  </div>

  <script>
    /* =============================================================================
   one_and_one_class_ behavior
   - Fixed-position dropdowns follow triggers while scrolling
   - Working/rotating chevrons with proper aria-expanded state
   ============================================================================= */
    (function($) {

      function one_and_one_class_close_all() {
        $('.one_and_one_class_dropdown').hide();
      }

      function one_and_one_class_clamp(x, min, max) {
        return Math.max(min, Math.min(max, x));
      }

      var one_and_one_class_openState = {
        $btn: null,
        $menu: null
      };

      function one_and_one_class_apply_fixed_position($btn, $menu) {
        if (!$btn || !$menu) return;
        var rect = $btn.get(0).getBoundingClientRect();
        var gap = 8;
        var left = rect.left;
        var top = rect.bottom + gap;

        var vw = window.innerWidth || document.documentElement.clientWidth;
        var menuW = $menu.outerWidth();
        left = one_and_one_class_clamp(left, 12, vw - menuW - 12);

        $menu.css({
          left: left + 'px',
          top: top + 'px'
        });
      }

      var one_and_one_class_rAF = null;

      function one_and_one_class_schedule_reposition() {
        if (!one_and_one_class_openState.$menu || !one_and_one_class_openState.$menu.is(':visible')) return;
        if (one_and_one_class_rAF) return;
        one_and_one_class_rAF = window.requestAnimationFrame(function() {
          one_and_one_class_apply_fixed_position(one_and_one_class_openState.$btn, one_and_one_class_openState.$menu);
          one_and_one_class_rAF = null;
        });
      }

      function one_and_one_class_open_dropdown($btn, $menu) {
        one_and_one_class_openState.$btn = $btn;
        one_and_one_class_openState.$menu = $menu;
        $menu.show();
        one_and_one_class_apply_fixed_position($btn, $menu);
        $menu.find('input').val('').trigger('input').trigger('focus');
      }

      // TEACHER dropdown
      $('#one_and_one_class_select_teacher_btn').on('click', function(e) {
        e.stopPropagation();
        var $menu = $('#one_and_one_class_teacher_dropdown');
        var open = $menu.is(':visible');
        one_and_one_class_close_all();
        if (!open) one_and_one_class_open_dropdown($(this), $menu);
      });

      // STUDENT dropdown
      $('#one_and_one_class_select_student_btn').on('click', function(e) {
        e.stopPropagation();
        var $menu = $('#one_and_one_class_student_dropdown');
        var open = $menu.is(':visible');
        one_and_one_class_close_all();
        if (!open) one_and_one_class_open_dropdown($(this), $menu);
      });

      // keep open on inside click
      $('#one_and_one_class_teacher_dropdown, #one_and_one_class_student_dropdown').on('click', function(e) {
        e.stopPropagation();
      });

      // filtering
      $('#one_and_one_class_teacher_search').on('input', function() {
        var q = $(this).val().toLowerCase();
        $('#one_and_one_class_teacher_list .one_and_one_class_dropdown_item').each(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
        });
      });
      $('#one_and_one_class_student_search').on('input', function() {
        var q = $(this).val().toLowerCase();
        $('#one_and_one_class_student_list .one_and_one_class_dropdown_item').each(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
        });
      });

      // selection
      $('#one_and_one_class_teacher_list').on('click', '.one_and_one_class_dropdown_item', function() {
        $('#one_and_one_class_select_teacher_label').text($(this).text().trim());
        one_and_one_class_close_all();
      });
      $('#one_and_one_class_student_list').on('click', '.one_and_one_class_dropdown_item', function() {
        $('#one_and_one_class_select_student_label').text($(this).text().trim());
        one_and_one_class_close_all();
      });

      // Close on outside / ESC
      $(document).on('click', function() {
        one_and_one_class_close_all();
        one_and_one_class_openState.$btn = null;
        one_and_one_class_openState.$menu = null;
      });
      $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
          one_and_one_class_close_all();
          one_and_one_class_openState.$btn = null;
          one_and_one_class_openState.$menu = null;
        }
      });

      // Reposition on scroll/resize
      $(window).on('scroll resize', one_and_one_class_schedule_reposition);

      // ===== Chevron toggles with rotation + correct aria-expanded =====
      function one_and_one_class_toggleRow($btn, $row) {
        var isOpen = $row.is(':visible'); // current state before toggle
        $row.slideToggle(160);
        $btn.attr('aria-expanded', String(!isOpen)); // set to new state
      }

      $('#one_and_one_class_toggle_teachers').on('click', function() {
        one_and_one_class_toggleRow($(this), $('#one_and_one_class_row_teachers'));
      });
      $('#one_and_one_class_toggle_students').on('click', function() {
        one_and_one_class_toggleRow($(this), $('#one_and_one_class_row_students'));
      });

    })(jQuery);
  </script>
</body>

</html>