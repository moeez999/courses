<!-- right_section.php -->
<style>
  /* ============ RIGHT PANEL DESIGN ============ */
  .rpanel_card {
    background: #fff;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 5px;
    padding: 14px;
    position: relative;
  }

  .rpanel_header {
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 14px;
    padding: 10px;
    background: #fff;
  }

  .rpanel_section {
    border: 1px solid var(--my_profile_about_border);
    border-radius: 14px;
    padding: 14px;
    margin-top: 14px;
    position: relative;
  }

  .rpanel_title {
    font-weight: 700;
    font-size: 1.05rem;
    margin-bottom: 10px;
  }

  .rpanel_row {
    border: 1px solid var(--my_profile_about_border);
    border-radius: 12px;
    padding: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    background: #fff;
  }

  .rpanel_row+.rpanel_row {
    margin-top: 12px;
  }

  .rpanel_row_label {
    font-weight: 700;
    font-size: .95rem;
  }

  .rpanel_row_value {
    color: var(--my_profile_about_muted);
    margin-top: 2px;
    font-size: .95rem;
  }

  .rpanel_icon_btn {
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 10px;
    background: #fff;
    flex: 0 0 40px;
    transition: all .15s ease;
  }

  .rpanel_icon_btn:active {
    transform: translateY(1px);
  }

  .rpanel_row_editing {
    border-color: #4F46E5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, .12);
  }

  .rpanel_input {
    height: 44px;
    border: 1.5px solid var(--my_profile_about_border);
    border-radius: 10px;
    padding: 0 12px;
    outline: 0;
    width: 100%;
  }

  .rpanel_input:focus {
    border-color: #B9C0D4;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
  }

  .rpanel_icon_btn.save-mode {
    background: #ff3b1f;
    border-color: #ff3b1f;
  }

  .rpanel_icon_btn.save-mode svg path,
  .rpanel_icon_btn.save-mode svg polyline {
    stroke: #fff;
  }

  /* ============ TEACHER DROPDOWN (header) ============ */
  .teacher-selector {
    flex: 1;
    min-width: 0
  }

  #teacher_selector_btn {
    width: 100%;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 5px;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    background: #f2f2f2;
  }

  #teacher_selector_dropdown {
    position: absolute;
    top: 86px;
    left: 14px;
    right: 14px;
    background: #fff;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    padding: 14px;
    z-index: 40;
    display: none;
  }

  .ts_search {
    height: 48px;
    border: 1.5px solid var(--my_profile_about_border);
    border-radius: 5px;
    width: 100%;
    padding: 0 14px;
    outline: 0;
  }

  .ts_search:focus {
    border-color: #B9C0D4;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
  }

  .ts_list {
    margin-top: 14px;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 16px;
    padding: 8px;
    max-height: 360px;
    overflow: auto;
    -webkit-overflow-scrolling: touch;
  }

  .ts_item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px;
    border-radius: 12px;
    cursor: pointer;
  }

  .ts_item:hover {
    background: #f6f7fb;
  }

  .ts_avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
  }

  /* ============ FIXED OVERLAY DROPDOWNS (scroll-safe) ============ */
  #country_dropdown,
  #timezone_dropdown {
    position: fixed !important;
    background: #fff;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    padding: 14px;
    z-index: 99999 !important;
    display: none;
    max-width: 520px;
    will-change: top, left, width;
    pointer-events: auto;
  }

  #country_dropdown.dd-locked,
  #timezone_dropdown.dd-locked {
    top: var(--dd-top) !important;
    left: var(--dd-left) !important;
    width: var(--dd-width) !important;
  }

  .my_profile_about_layout,
  .rpanel_card,
  .rpanel_section,
  .rpanel_header {
    overflow: visible !important;
  }

  .dropdown_search {
    height: 48px;
    border: 1.5px solid var(--my_profile_about_border);
    border-radius: 10px;
    width: 100%;
    padding: 0 14px;
    outline: 0;
  }

  .dropdown_search:focus {
    border-color: #B9C0D4;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
  }

  .dropdown_list {
    margin-top: 14px;
    border: 1px solid var(--my_profile_about_border);
    border-radius: 16px;
    padding: 10px;
    max-height: min(70vh, 520px);
    overflow: auto;
    -webkit-overflow-scrolling: touch;
  }

  .dropdown_item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px;
    border-radius: 12px;
    cursor: pointer;
  }

  .dropdown_item:hover {
    background: #f6f7fb;
  }

  .flag {
    width: 28px;
    height: 20px;
    border-radius: 3px;
    object-fit: cover;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, .06) inset;
  }

  .country_name,
  .timezone_name {
    font-weight: 600;
    color: #111827;
  }

  /* ============ LOGIN ACTIVITY (Right section 2) ============ */
  .la_right_panel {
    width: 100%;
    max-width: 100%;
    margin-top: 14px;
  }

  .la_card {
    background: #fff;
    border: 1px solid var(--my_profile_about_border, #E4E7EE);
    border-radius: 16px;
    padding: 14px;
    position: sticky;
    top: 80px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .04);
  }

  .la_title {
    font-weight: 700;
    font-size: 1.05rem;
    margin-bottom: 12px;
    color: var(--my_profile_about_text, #121117);
  }

  .la_item {
    border: 1px solid var(--my_profile_about_border, #E4E7EE);
    border-radius: 12px;
    padding: 12px;
    background: #fff;
  }

  .la_item+.la_item {
    margin-top: 10px;
  }

  .la_item_label {
    font-weight: 700;
    font-size: .95rem;
    color: var(--my_profile_about_text, #121117);
    margin-bottom: 6px;
  }

  .la_item_value {
    color: var(--my_profile_about_muted, #6B7280);
    font-size: .92rem;
    line-height: 1.25rem;
  }

  .la_item_value small {
    display: block;
    margin-top: 2px;
    opacity: .9;
  }

  @media (max-width: 1024px) {
    .la_card {
      position: static;
      top: auto;
    }
  }
</style>

<!-- IMPORTANT: my_profile_about_right now sits inside the 30% column of the outer grid -->
<aside class="my_profile_about_right">
  <!-- ===== Right Card #1: Header + Contact Info ===== -->   
  <div class="rpanel_card my_profile_about_card_shadow" style="margin-top:-85px;">

  <!-- Header -->
    <div class="rpanel_header">
      <div class="teacher-selector">
        <button id="teacher_selector_btn" type="button" aria-expanded="false">
          <span class="flex items-center gap-2">
            <img id="ts_current_avatar" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=128&auto=format&fit=crop" class="w-10 h-10 rounded-full object-cover" alt="Avatar">
            <span id="ts_current_name" class="font-semibold text-[1rem]">Daniela</span>
          </span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 9l6 6 6-6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>

        <div id="teacher_selector_dropdown" role="listbox" aria-label="Choose teacher">
          <input id="ts_search" type="text" class="ts_search" placeholder="Entre Teacher name" autocomplete="off">
          <div class="ts_list" id="ts_list">
            <div class="ts_item" data-name="Edwards" data-avatar="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=128&auto=format&fit=crop"><img class="ts_avatar" src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=128&auto=format&fit=crop"><span>Edwards</span></div>
            <div class="ts_item" data-name="Daniela" data-avatar="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=128&auto=format&fit=crop"><img class="ts_avatar" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=128&auto=format&fit=crop"><span>Daniela</span></div>
            <div class="ts_item" data-name="Hawkins" data-avatar="https://images.unsplash.com/photo-1607746882042-944635dfe10e?q=80&w=128&auto=format&fit=crop"><img class="ts_avatar" src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?q=80&w=128&auto=format&fit=crop"><span>Hawkins</span></div>
            <div class="ts_item" data-name="Lane" data-avatar="https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?q=80&w=128&auto=format&fit=crop"><img class="ts_avatar" src="https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?q=80&w=128&auto=format&fit=crop"><span>Lane</span></div>
            <div class="ts_item" data-name="Warren" data-avatar="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=128&auto=format&fit=crop"><img class="ts_avatar" src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=128&auto=format&fit=crop"><span>Warren</span></div>
            <div class="ts_item" data-name="Fox" data-avatar="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=128&auto=format&fit=crop"><img class="ts_avatar" src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=128&auto=format&fit=crop"><span>Fox</span></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Information -->
    <div class="rpanel_section">
      <div class="rpanel_title">Contact Information</div>

      <div class="rpanel_row" data-row="name">
        <div class="flex-1">
          <div class="rpanel_row_label">Name</div>
          <div class="rpanel_row_value" data-view>Daniela</div>
          <div class="hidden" data-edit><input type="text" class="rpanel_input" value="Daniela"></div>
        </div>
        <button class="rpanel_icon_btn" data-action="toggle" aria-label="Edit name">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" stroke="#111827" stroke-width="1.5" />
            <path d="M14.06 4.94l3.75 3.75" stroke="#111827" stroke-width="1.5" />
          </svg>
        </button>
      </div>

      <div class="rpanel_row" data-row="phone">
        <div class="flex-1">
          <div class="rpanel_row_label">Phone</div>
          <div class="rpanel_row_value" data-view>(316) 555–0116</div>
          <div class="hidden" data-edit><input type="text" class="rpanel_input" value="(316) 555–0116"></div>
        </div>
        <button class="rpanel_icon_btn" data-action="toggle" aria-label="Edit phone">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" stroke="#111827" stroke-width="1.5" />
            <path d="M14.06 4.94l3.75 3.75" stroke="#111827" stroke-width="1.5" />
          </svg>
        </button>
      </div>

      <div class="rpanel_row" data-row="country">
        <div class="flex-1">
          <div class="rpanel_row_label">Country</div>
          <div class="rpanel_row_value" data-view>United States</div>
        </div>
        <button class="rpanel_icon_btn" id="country_edit_btn" aria-label="Edit country">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" stroke="#111827" stroke-width="1.5" />
            <path d="M14.06 4.94l3.75 3.75" stroke="#111827" stroke-width="1.5" />
          </svg>
        </button>
      </div>

      <div class="rpanel_row" data-row="timezone">
        <div class="flex-1">
          <div class="rpanel_row_label">Timezone</div>
          <div class="rpanel_row_value" data-view>America/New_York</div>
        </div>
        <button class="rpanel_icon_btn" id="timezone_edit_btn" aria-label="Edit timezone">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" stroke="#111827" stroke-width="1.5" />
            <path d="M14.06 4.94l3.75 3.75" stroke="#111827" stroke-width="1.5" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- ===== Right Card #2: Login Activity (stacked below) ===== -->
  <div class="la_right_panel" aria-label="Login Activity Sidebar">
    <div class="la_card">
      <div class="la_title">Login Activity</div>

      <div class="la_item">
        <div class="la_item_label">First access to site</div>
        <div class="la_item_value">
          Wednesday, 23 April 2025, 12:16 PM
          <small>(70 days 21 hours)</small>
        </div>
      </div>

      <div class="la_item">
        <div class="la_item_label">Last access to site</div>
        <div class="la_item_value">
          Wednesday, 23 April 2025, 12:16 PM
          <small>(70 days 21 hours)</small>
        </div>
      </div>

      <div class="la_item">
        <div class="la_item_label">Last IP address</div>
        <div class="la_item_value">38.25.165.161</div>
      </div>
    </div>
  </div>
</aside>

<!-- Country dropdown overlay -->
<div id="country_dropdown" role="listbox" aria-label="Choose country">
  <input id="country_search" class="dropdown_search" type="text" placeholder="Search Country name" autocomplete="off">
  <div id="country_list" class="dropdown_list">
    <div class="dropdown_item" data-value="France"><img class="flag" src="https://flagcdn.com/w40/fr.png"><span class="country_name">France</span></div>
    <div class="dropdown_item" data-value="Germany"><img class="flag" src="https://flagcdn.com/w40/de.png"><span class="country_name">Germany</span></div>
    <div class="dropdown_item" data-value="Afghanistan"><img class="flag" src="https://flagcdn.com/w40/af.png"><span class="country_name">Afghanistan</span></div>
    <div class="dropdown_item" data-value="United States"><img class="flag" src="https://flagcdn.com/w40/us.png"><span class="country_name">United States</span></div>
    <div class="dropdown_item" data-value="United Kingdom"><img class="flag" src="https://flagcdn.com/w40/gb.png"><span class="country_name">United Kingdom</span></div>
    <div class="dropdown_item" data-value="Pakistan"><img class="flag" src="https://flagcdn.com/w40/pk.png"><span class="country_name">Pakistan</span></div>
  </div>
</div>

<!-- Timezone dropdown overlay -->
<div id="timezone_dropdown" role="listbox" aria-label="Choose timezone">
  <input id="timezone_search" class="dropdown_search" type="text" placeholder="Search Timezone" autocomplete="off">
  <div id="timezone_list" class="dropdown_list">
    <div class="dropdown_item" data-value="(GMT+00:00) UTC"><span class="timezone_name">(GMT+00:00) UTC</span></div>
    <div class="dropdown_item" data-value="(GMT+01:00) Central European Time"><span class="timezone_name">(GMT+01:00) Central European Time</span></div>
    <div class="dropdown_item" data-value="(GMT+04:00) Gulf Standard Time"><span class="timezone_name">(GMT+04:00) Gulf Standard Time</span></div>
    <div class="dropdown_item" data-value="(GMT+05:00) Pakistan Standard Time"><span class="timezone_name">(GMT+05:00) Pakistan Standard Time</span></div>
    <div class="dropdown_item" data-value="(GMT+05:30) India Standard Time"><span class="timezone_name">(GMT+05:30) India Standard Time</span></div>
    <div class="dropdown_item" data-value="(GMT+08:00) China Standard Time"><span class="timezone_name">(GMT+08:00) China Standard Time</span></div>
    <div class="dropdown_item" data-value="(GMT-05:00) Eastern Time (US & Canada)"><span class="timezone_name">(GMT-05:00) Eastern Time (US & Canada)</span></div>
  </div>
</div>

<script>
  /* ===== Icons ===== */
  const ICON_PENCIL = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" stroke="#111827" stroke-width="1.5"/><path d="M14.06 4.94l3.75 3.75" stroke="#111827" stroke-width="1.5"/></svg>`;
  const ICON_CHECK = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

  /* ===== Fixed overlay placement helper (viewport-anchored) ===== */
  function placeOverlayUnderRow($row, $overlay) {
    const rect = $row[0].getBoundingClientRect();

    const wasHidden = !$overlay.is(':visible');
    if (wasHidden) $overlay.css({
      visibility: 'hidden',
      display: 'block'
    });

    const ddHeight = $overlay.outerHeight();
    const spaceBelow = window.innerHeight - rect.bottom - 12;
    const spaceAbove = rect.top - 12;

    let top;
    if (spaceBelow >= ddHeight) {
      top = rect.bottom + 6;
    } else if (spaceAbove >= ddHeight) {
      top = rect.top - ddHeight - 6;
    } else {
      top = rect.bottom + 6;
      const innerList = $overlay.find('.dropdown_list');
      const headerH = $overlay.outerHeight() - innerList.outerHeight();
      const maxH = Math.max(140, window.innerHeight - top - 12 - headerH);
      innerList.css('max-height', maxH + 'px');
    }

    $overlay[0].style.setProperty('--dd-left', rect.left + 'px');
    $overlay[0].style.setProperty('--dd-top', top + 'px');
    $overlay[0].style.setProperty('--dd-width', rect.width + 'px');
    $overlay.addClass('dd-locked');

    $overlay.css({
      left: rect.left + 'px',
      top: top + 'px',
      width: rect.width + 'px'
    });

    if (wasHidden) $overlay.css({
      visibility: '',
      display: 'none'
    });
  }

  function clearOverlayLock($overlay) {
    $overlay.removeClass('dd-locked');
    $overlay[0].style.removeProperty('--dd-left');
    $overlay[0].style.removeProperty('--dd-top');
    $overlay[0].style.removeProperty('--dd-width');
    const innerList = $overlay.find('.dropdown_list');
    innerList.css('max-height', '');
  }

  /* ===== Name & Phone inline toggle ===== */
  function bindToggleRow($row) {
    const $btn = $row.find('[data-action="toggle"]');
    const $view = $row.find('[data-view]');
    const $edit = $row.find('[data-edit]');
    const $input = $edit.find('input');
    $btn.html(ICON_PENCIL);

    function toEdit() {
      $row.addClass('rpanel_row_editing');
      $view.addClass('hidden');
      $edit.removeClass('hidden');
      $btn.addClass('save-mode').html(ICON_CHECK);
      setTimeout(() => $input.trigger('focus'), 0);
    }

    function toView(save = true) {
      if (save) $view.text($input.val());
      $row.removeClass('rpanel_row_editing');
      $edit.addClass('hidden');
      $view.removeClass('hidden');
      $btn.removeClass('save-mode').html(ICON_PENCIL);
    }
    $btn.on('click', () => $row.hasClass('rpanel_row_editing') ? toView(true) : toEdit());
    $input.on('keydown', e => {
      if (e.key === 'Enter') toView(true);
      if (e.key === 'Escape') toView(false);
    });
    $input.on('blur', () => {
      if ($row.hasClass('rpanel_row_editing')) toView(true);
    });
  }

  /* ===== Teacher dropdown ===== */
  function ts_open() {
    $('#teacher_selector_dropdown').fadeIn(120);
    $('#teacher_selector_btn').attr('aria-expanded', 'true');
    $('#ts_search').val('').trigger('input').trigger('focus');
  }

  function ts_close() {
    $('#teacher_selector_dropdown').fadeOut(100);
    $('#teacher_selector_btn').attr('aria-expanded', 'false');
  }

  /* ===== Init ===== */
  $(function() {
    $('#country_dropdown,#timezone_dropdown').appendTo('body');

    // Teacher open/close
    $('#teacher_selector_btn').on('click', function(e) {
      e.stopPropagation();
      $('#teacher_selector_dropdown').is(':visible') ? ts_close() : ts_open();
    });
    $(document).on('click', function(e) {
      const $dd = $('#teacher_selector_dropdown'),
        $btn = $('#teacher_selector_btn');
      if (!$dd.is(e.target) && $dd.has(e.target).length === 0 && !$btn.is(e.target) && $btn.has(e.target).length === 0) ts_close();
    });
    $(document).on('keydown', e => {
      if (e.key === 'Escape') ts_close();
    });
    $('#ts_search').on('input', function() {
      const q = this.value.toLowerCase().trim();
      $('#ts_list .ts_item').each(function() {
        $(this).toggle(String($(this).data('name')).toLowerCase().includes(q));
      });
    });
    $('#ts_list').on('click keydown', '.ts_item', function(e) {
      if (e.type === 'keydown' && !['Enter', ' '].includes(e.key)) return;
      const name = $(this).data('name'),
        avatar = $(this).data('avatar');
      $('#ts_current_name').text(name);
      $('#ts_current_avatar').attr('src', avatar);
      const $nameRow = $('.rpanel_row[data-row="name"]');
      $nameRow.find('[data-view]').text(name);
      $nameRow.find('input').val(name);
      ts_close();
    });

    bindToggleRow($('.rpanel_row[data-row="name"]'));
    bindToggleRow($('.rpanel_row[data-row="phone"]'));

    /* ===== Country overlay ===== */
    const $countryBtn = $('#country_edit_btn');
    const $countryDD = $('#country_dropdown');
    const $countryRow = $('.rpanel_row[data-row="country"]');

    $countryBtn.on('click', function(e) {
      e.stopPropagation();
      if ($countryDD.is(':visible')) {
        $countryDD.fadeOut(100, () => clearOverlayLock($countryDD));
        return;
      }
      placeOverlayUnderRow($countryRow, $countryDD);
      $countryDD.fadeIn(120);
      $('#country_search').val('').trigger('input').trigger('focus');
    });
    $('#country_search').on('input', function() {
      const q = this.value.toLowerCase().trim();
      $('#country_list .dropdown_item').each(function() {
        $(this).toggle(String($(this).data('value')).toLowerCase().includes(q));
      });
    });
    $('#country_list').on('click keydown', '.dropdown_item', function(e) {
      if (e.type === 'keydown' && !['Enter', ' '].includes(e.key)) return;
      const val = $(this).data('value');
      $countryRow.find('[data-view]').text(val);
      $countryDD.fadeOut(100, () => clearOverlayLock($countryDD));
    });

    /* ===== Timezone overlay ===== */
    const $timezoneBtn = $('#timezone_edit_btn');
    const $timezoneDD = $('#timezone_dropdown');
    const $timezoneRow = $('.rpanel_row[data-row="timezone"]');

    $timezoneBtn.on('click', function(e) {
      e.stopPropagation();
      if ($timezoneDD.is(':visible')) {
        $timezoneDD.fadeOut(100, () => clearOverlayLock($timezoneDD));
        return;
      }
      placeOverlayUnderRow($timezoneRow, $timezoneDD);
      $timezoneDD.fadeIn(120);
      $('#timezone_search').val('').trigger('input').trigger('focus');
    });
    $('#timezone_search').on('input', function() {
      const q = this.value.toLowerCase().trim();
      $('#timezone_list .dropdown_item').each(function() {
        $(this).toggle(String($(this).data('value')).toLowerCase().includes(q));
      });
    });
    $('#timezone_list').on('click keydown', '.dropdown_item', function(e) {
      if (e.type === 'keydown' && !['Enter', ' '].includes(e.key)) return;
      const val = $(this).data('value');
      $timezoneRow.find('[data-view]').text(val);
      $timezoneDD.fadeOut(100, () => clearOverlayLock($timezoneDD));
    });

    /* ===== Outside click / ESC close ===== */
    $(document).on('click', function(e) {
      if (!$(e.target).closest('#country_dropdown,#country_edit_btn').length)
        $countryDD.fadeOut(100, () => clearOverlayLock($countryDD));
      if (!$(e.target).closest('#timezone_dropdown,#timezone_edit_btn').length)
        $timezoneDD.fadeOut(100, () => clearOverlayLock($timezoneDD));
    });
    $(document).on('keydown', function(e) {
      if (e.key === 'Escape') {
        $countryDD.fadeOut(100, () => clearOverlayLock($countryDD));
        $timezoneDD.fadeOut(100, () => clearOverlayLock($timezoneDD));
      }
    });

    /* ===== Stay fixed on scroll; reflow only on resize ===== */
    $(window).off('scroll');
    $(window).on('resize', function() {
      if ($countryDD.is(':visible')) placeOverlayUnderRow($countryRow, $countryDD);
      if ($timezoneDD.is(':visible')) placeOverlayUnderRow($timezoneRow, $timezoneDD);
    });
  });
</script>