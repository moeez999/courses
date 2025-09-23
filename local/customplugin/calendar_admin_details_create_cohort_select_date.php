<style>
/* ====== MAIN MODAL STYLES ====== */
.calendar_admin_details_create_cohort_customrec_modal_backdrop {
  display: none; position: fixed; z-index: 2050; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.18);
}
.calendar_admin_details_create_cohort_customrec_modal {
  background: #fff; border-radius: 13px; box-shadow: 0 10px 36px 0 rgba(0,0,0,.16);
  width: 340px; min-width:320px; max-width: 97vw;
  padding: 22px 18px 20px 18px; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
  font-size: 1.03rem;
}
.calendar_admin_details_create_cohort_close.customrec {
  position: absolute; top: 16px; right: 16px; font-size: 23px; cursor: pointer; color: #232323;
}
.customrec_stepper {
  border: none; background: #f3f3f3; border-radius: 50%; width: 36px; height: 36px; font-size: 1.27rem; font-weight: 600; color: #232323; cursor: pointer; transition: background 0.13s;
}
.customrec_stepper:active { background: #ececec; }
.customrec_dropdown_wrapper { position: relative; }
.customrec_dropdown_btn {
  display: flex; align-items: center; background: #fff; border: 1.3px solid #dadada; border-radius: 11px;
  padding: 8px 18px; font-size: 1.01rem; cursor: pointer; min-width: 120px; font-weight: 600; margin-left: 10px;
}
.customrec_dropdown_btn svg { margin-left: 7px; }
.customrec_dropdown_list {
  display: none; position: absolute; top: 110%; left: 0; width: 160px;
  background: #fff; border: 1.5px solid #dadada; border-radius: 13px;
  box-shadow: 0 4px 18px #0001; z-index: 110;
}
.customrec_option {
  padding: 13px 18px; font-size: 1rem; border-radius: 9px; cursor: pointer;
  transition: background 0.15s; font-weight: 500; color: #232323;
}
.customrec_option:hover { background: #f6f6f6; color: #fe2e0c;}
.customrec_day_btn {
  background: #fff; border: 2px solid #dadada; border-radius: 50%; width: 38px; height: 38px; font-size: 1.03rem;
  font-weight: 600; color: #555; cursor: pointer; transition: background 0.13s, color 0.13s, border 0.13s;
}
.customrec_day_btn.active { background: #fe2e0c; color: #fff; border-color: #fe2e0c;}
.customrec_date_btn {
  background: #ececec; border: none; border-radius: 7px; font-size: 1.01rem; font-weight: 500; color: #6d6d6d;
  padding: 8px 14px; cursor: pointer; opacity: 0.6;
}
.customrec_date_btn.enabled {
  background: #fff; color: #232323; border: 1.3px solid #dadada; opacity: 1;
}
.customrec_occurrence_counter {display:inline-flex;align-items:center;}
.customrec_occurrence_counter button {margin: 0 5px;}
/* ---- Monthly row style (like screenshot 1) ---- */
.customrec_monthly_picker_wrapper {
  display: flex; align-items: center; margin-top: 12px;
  padding-bottom: 8px; border-bottom: 2px solid #fe2e0c;
  justify-content: space-between; cursor:pointer;
}
.customrec_monthly_picker_label {
  font-size: 1.14rem;
  font-weight: 500;
  color: #232323;
}
.customrec_monthly_picker_date {
  font-size: 1.12rem; font-weight: 500; margin-left: 8px;
  color: #232323;
}
.customrec_monthly_picker_arrow {
  margin-left: 12px; margin-top: 3px;
}
.calendar_admin_details_create_cohort_btn {
  border-radius: 8px;
  padding: 12px 0;
  width: 100%;
  font-size: 1.09rem;
  font-weight: bold;
  margin-top: 0;
  transition: background .14s, color .14s, border .14s;
  border: none;
  box-shadow: 0 2px 8px #0001;
  letter-spacing: 0.01em;
  margin-bottom: 0;
  outline: none;
  cursor: pointer;
  margin-top: 0;
}
/* ====== CALENDAR MODAL STYLES (UNIQUE) ====== */
.monthly_cal_modal_backdrop {
  display: none; position: fixed; z-index: 9999; top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.14);
}
.monthly_cal_modal {
  background: #fff; border-radius: 15px; box-shadow: 0 10px 36px 0 rgba(0,0,0,.16);
  width: 340px; max-width: 97vw; padding: 26px 24px 24px 24px;
  position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
  font-family: inherit;
}
.monthly_cal_header {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;
}
.monthly_cal_month_label {
  font-size: 1.18rem; font-weight: 600;
}
.monthly_cal_grid {
  display: grid; grid-template-columns: repeat(7, 36px); grid-gap: 6px; justify-content: center;
}
.monthly_cal_day, .monthly_cal_date {
  width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
  font-size: 1.01rem; border-radius: 50%; cursor: pointer; transition: background 0.13s;
}
.monthly_cal_day { font-weight: bold; color: #888; cursor: default; }
.monthly_cal_date.selected, .monthly_cal_date:hover {
  background: #fe2e0c; color: #fff;
}
.monthly_cal_date.inactive {
  color: #c2c2c2; background: #fff; pointer-events: none; cursor: default;
}
.monthly_cal_done_btn {
  width: 100%; background: #fe2e0c; color: #fff; border: none; border-radius: 8px;
  font-size: 1.1rem; font-weight: 600; padding: 12px 0; margin-top: 19px; cursor: pointer;
  transition: background 0.13s;
}
.monthly_cal_done_btn:active { background: #e52b10; }
</style>

<!-- ========= CALENDAR MODAL HTML ========= -->
<div class="monthly_cal_modal_backdrop" id="monthly_cal_modal_backdrop">
  <div class="monthly_cal_modal">
    <div class="monthly_cal_header">
      <button id="monthly_cal_prev" style="background:none;border:none;font-size:1.4rem;cursor:pointer;">&#8592;</button>
      <span class="monthly_cal_month_label" id="monthly_cal_month"></span>
      <button id="monthly_cal_next" style="background:none;border:none;font-size:1.4rem;cursor:pointer;">&#8594;</button>
    </div>
    <div class="monthly_cal_grid" id="monthly_cal_days"></div>
    <div class="monthly_cal_grid" id="monthly_cal_dates"></div>
    <button class="monthly_cal_done_btn" id="monthly_cal_done">Done</button>
  </div>
</div>


<!-- ========= MAIN CUSTOM RECURRENCE MODAL HTML ========= -->
<div id="customRecurrenceModalBackdrop" class="calendar_admin_details_create_cohort_customrec_modal_backdrop" style="display:none;">
  <div class="calendar_admin_details_create_cohort_customrec_modal">
    <span class="calendar_admin_details_create_cohort_close customrec">&times;</span>
    <h2 style="margin-bottom:16px;">Custom Recurrence</h2>
    <div style="margin-bottom:16px;">
      <label style="font-weight:600;">Repeat Every</label>
      <div style="display:flex; align-items:center; gap:13px; margin-top:7px;">
        <button class="customrec_stepper" id="customrec_minus">−</button>
        <span id="customrec_interval" style="font-size:1.18rem;font-weight:bold;">1</span>
        <button class="customrec_stepper" id="customrec_plus">+</button>
        <div class="customrec_dropdown_wrapper">
          <div class="customrec_dropdown_btn" id="customrec_period_btn">
            <span id="customrec_period_val">Week</span>
            <svg width="18" height="18" viewBox="0 0 20 20"><path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path></svg>
          </div>
          <div class="customrec_dropdown_list" id="customrec_period_list">
            <div class="customrec_option">1 Day</div>
            <div class="customrec_option">Week</div>
            <div class="customrec_option">Monthly</div>
            <div class="customrec_option">Year</div>
          </div>
        </div>
      </div>
    </div>
    <hr style="border:none; border-top:1.3px solid #ececec; margin:10px 0 15px 0;">
    <!-- Repeat On Days (show only if Week) -->
    <div id="customrec_repeat_on_container">
      <label style="font-weight:600;">Repeat on</label>
      <div style="display:flex; gap:9px; margin-top:10px;">
        <button class="customrec_day_btn" data-day="S">S</button>
        <button class="customrec_day_btn" data-day="M">M</button>
        <button class="customrec_day_btn" data-day="T">T</button>
        <button class="customrec_day_btn" data-day="W">W</button>
        <button class="customrec_day_btn" data-day="T">T</button>
        <button class="customrec_day_btn" data-day="F">F</button>
        <button class="customrec_day_btn" data-day="S">S</button>
      </div>
    </div>
    <!-- Monthly Date Picker (Show only for Monthly) -->
    <div id="customrec_monthly_picker_container" style="display:none;">
      <div class="customrec_monthly_picker_wrapper" id="customrec_monthly_picker_btn">
        <span class="customrec_monthly_picker_label" id="customrec_monthly_picker_label">
          Monthly on <span class="customrec_monthly_picker_date" id="customrec_monthly_picker_date"></span>
        </span>
        <svg class="customrec_monthly_picker_arrow" width="18" height="18" viewBox="0 0 20 20">
          <path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path>
        </svg>
      </div>
    </div>
    <hr style="border:none; border-top:1.3px solid #ececec; margin:15px 0;">
    <div>
      <label style="font-weight:600;">Ends</label>
      <div style="margin-top:8px;">
        <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
          <input type="radio" id="customrec_end_never" name="customrec_end" checked>
          <label for="customrec_end_never" style="font-size:1.05rem;">Never</label>
        </div>
        <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
          <input type="radio" id="customrec_end_on" name="customrec_end">
          <label for="customrec_end_on" style="font-size:1.05rem;">On</label>
          <button id="customrec_end_date_btn" disabled style="margin-left:10px;" class="customrec_date_btn">Sep 27,2024</button>
        </div>
        <div style="display:flex;align-items:center; gap:10px;">
          <input type="radio" id="customrec_end_after" name="customrec_end">
          <label for="customrec_end_after" style="font-size:1.05rem;">After</label>
          <div class="customrec_occurrence_counter" style="margin-left:12px;">
            <button class="customrec_stepper" id="customrec_occ_minus" disabled>−</button>
            <span id="customrec_occ_val" style="font-size:1.11rem;font-weight:600;color:#555;">13 occurrences</span>
            <button class="customrec_stepper" id="customrec_occ_plus" disabled>+</button>
          </div>
        </div>
      </div>
    </div>
    <div style="display:flex; gap:12px; margin-top:23px;">
      <button class="calendar_admin_details_create_cohort_btn" id="customrec_cancel" style="background:#fff;color:#232323;border:2px solid #232323;">Cancel</button>
      <button class="calendar_admin_details_create_cohort_btn" id="customrec_done" style="background:#fe2e0c;">Done</button>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Util for default date format (Sep 27,2025)
function pad(n) { return n < 10 ? '0'+n : n; }
function formatDate(dateObj) {
  const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
  return `${months[dateObj.getMonth()]} ${pad(dateObj.getDate())},${dateObj.getFullYear()}`;
}

$(function() {
  // Initial Monthly and "On" date are today
  let monthlyDate = new Date();
  let endsOnDate = new Date();

  $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
  $('#customrec_end_date_btn').text(formatDate(endsOnDate));

  // Track where the calendar was opened from
  let calendarTarget = null; // "monthly" or "endsOn"

  // Open recurrence modal
  $('.conference_modal_repeat_btn').on('click', function(){
    $('#customRecurrenceModalBackdrop').fadeIn();
  });

  // Period dropdown logic
  $('#customrec_period_btn').on('click', function(e){
    e.stopPropagation();
    $('#customrec_period_list').toggle();
  });
  $(document).on('click', function(){ $('#customrec_period_list').hide(); });

  $('#customrec_period_list .customrec_option').on('click', function(){
    let period = $(this).text().trim();
    $('#customrec_period_val').text(period);
    $('#customrec_period_list').hide();

    // Show/Hide "Repeat on" and "Monthly Picker"
    if(period.toLowerCase() === "week") {
      $('#customrec_repeat_on_container').slideDown(130);
      $('#customrec_monthly_picker_container').slideUp(130);
    } else if(period.toLowerCase() === "monthly") {
      $('#customrec_repeat_on_container').slideUp(130);
      $('#customrec_monthly_picker_container').slideDown(130);
      $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
    } else {
      $('#customrec_repeat_on_container').slideUp(130);
      $('#customrec_monthly_picker_container').slideUp(130);
    }
  });

  // Initial state on load
  if ($('#customrec_period_val').text().trim().toLowerCase() === "week") {
    $('#customrec_repeat_on_container').show();
    $('#customrec_monthly_picker_container').hide();
  } else if ($('#customrec_period_val').text().trim().toLowerCase() === "monthly") {
    $('#customrec_repeat_on_container').hide();
    $('#customrec_monthly_picker_container').show();
    $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
  } else {
    $('#customrec_repeat_on_container').hide();
    $('#customrec_monthly_picker_container').hide();
  }

  // Days select
  $('.customrec_day_btn').on('click', function(){
    $(this).toggleClass('active');
  });

  // Ends radio logic
  function updateEndsUI() {
    if($('#customrec_end_on').is(':checked')){
      $('#customrec_end_date_btn').prop('disabled', false).addClass('enabled');
      $('#customrec_occ_minus,#customrec_occ_plus').prop('disabled', true);
    } else if($('#customrec_end_after').is(':checked')) {
      $('#customrec_end_date_btn').prop('disabled', true).removeClass('enabled');
      $('#customrec_occ_minus,#customrec_occ_plus').prop('disabled', false);
    } else {
      $('#customrec_end_date_btn').prop('disabled', true).removeClass('enabled');
      $('#customrec_occ_minus,#customrec_occ_plus').prop('disabled', true);
    }
  }
  $('input[name="customrec_end"]').on('change', updateEndsUI);
  updateEndsUI();

  // Rest of your logic for interval, occurance counter, done, etc...
  let recInt = 1;
  $('#customrec_plus').on('click', function(){ recInt++; $('#customrec_interval').text(recInt); });
  $('#customrec_minus').on('click', function(){ if(recInt > 1) recInt--; $('#customrec_interval').text(recInt); });

  let occVal = 13;
  $('#customrec_occ_plus').on('click', function(){ if($('#customrec_end_after').is(':checked')){ occVal++; $('#customrec_occ_val').text(occVal + ' occurrences'); } });
  $('#customrec_occ_minus').on('click', function(){ if($('#customrec_end_after').is(':checked') && occVal > 1){ occVal--; $('#customrec_occ_val').text(occVal + ' occurrences'); } });

  $('#customrec_done').on('click', function(){
    $('#customRecurrenceModalBackdrop').fadeOut();
    // Save recurrence settings if needed
  });

  // Close main modal
  $('.calendar_admin_details_create_cohort_close.customrec, #customrec_cancel, #customRecurrenceModalBackdrop').on('click', function(e){
    if(e.target === this || $(e.target).hasClass('calendar_admin_details_create_cohort_close') || e.target.id === 'customrec_cancel') {
      $('#customRecurrenceModalBackdrop').fadeOut();
    }
  });
  
  // ======== MONTHLY CALENDAR MODAL LOGIC ========
  // Modal State
  let calSelectedDate = new Date();
  let calViewMonth = calSelectedDate.getMonth();
  let calViewYear = calSelectedDate.getFullYear();

  // Open modal on monthly row click
  $('.customrec_monthly_picker_wrapper, #customrec_monthly_picker_btn').on('click', function() {
    calendarTarget = "monthly";
    calSelectedDate = new Date(monthlyDate.getTime());
    calViewMonth = calSelectedDate.getMonth();
    calViewYear = calSelectedDate.getFullYear();
    renderMonthlyCal();
    $('#monthly_cal_modal_backdrop').fadeIn(90);
  });

  // Open modal from "Ends On" date button (only if enabled)
  $('#customrec_end_date_btn').on('click', function() {
    if(!$(this).prop('disabled')) {
      calendarTarget = "endsOn";
      calSelectedDate = new Date(endsOnDate.getTime());
      calViewMonth = calSelectedDate.getMonth();
      calViewYear = calSelectedDate.getFullYear();
      renderMonthlyCal();
      $('#monthly_cal_modal_backdrop').fadeIn(90);
    }
  });

  // Calendar rendering
  function renderMonthlyCal() {
    // Header
    let monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    $('#monthly_cal_month').text(monthNames[calViewMonth] + " " + calViewYear);

    // Days row
    let days = ["Mo","Tu","We","Th","Fr","Sa","Su"];
    let $daysRow = $('#monthly_cal_days');
    $daysRow.empty();
    for(let i=0; i<7; i++) {
      $daysRow.append('<div class="monthly_cal_day">'+days[i]+'</div>');
    }

    // Dates grid
    let $datesRow = $('#monthly_cal_dates');
    $datesRow.empty();
    let firstDay = new Date(calViewYear, calViewMonth, 1).getDay(); // 0=Sun, 1=Mon
    let offset = (firstDay+6)%7; // so Monday=0

    let daysInMonth = new Date(calViewYear, calViewMonth+1, 0).getDate();
    let prevMonthDays = offset;
    for(let i=0; i<prevMonthDays; i++) {
      $datesRow.append('<div class="monthly_cal_date inactive"></div>');
    }
    for(let d=1; d<=daysInMonth; d++) {
      let isSelected = d===calSelectedDate.getDate() && calViewMonth===calSelectedDate.getMonth() && calViewYear===calSelectedDate.getFullYear();
      $datesRow.append('<div class="monthly_cal_date'+(isSelected?' selected':'')+'" data-date="'+d+'">'+d+'</div>');
    }
    // Select date logic
    $('.monthly_cal_date').off('click').on('click', function(){
      if($(this).hasClass('inactive')) return;
      let day = parseInt($(this).attr('data-date'),10);
      calSelectedDate.setFullYear(calViewYear);
      calSelectedDate.setMonth(calViewMonth);
      calSelectedDate.setDate(day);
      renderMonthlyCal();
    });
  }

  // Prev/Next month logic
  $('#monthly_cal_prev').on('click', function(){
    if(calViewMonth===0) { calViewMonth=11; calViewYear--; }
    else calViewMonth--;
    renderMonthlyCal();
  });
  $('#monthly_cal_next').on('click', function(){
    if(calViewMonth===11) { calViewMonth=0; calViewYear++; }
    else calViewMonth++;
    renderMonthlyCal();
  });

  // Done button - set date and close, for both targets
  $('#monthly_cal_done').on('click', function(){
    if(calendarTarget === "monthly") {
      monthlyDate = new Date(calSelectedDate.getTime());
      $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
    }
    else if(calendarTarget === "endsOn") {
      endsOnDate = new Date(calSelectedDate.getTime());
      $('#customrec_end_date_btn').text(formatDate(endsOnDate));
    }
    $('#monthly_cal_modal_backdrop').fadeOut(80);
  });

  // Click outside to close
  $('#monthly_cal_modal_backdrop').on('click', function(e){
    if(e.target === this) $('#monthly_cal_modal_backdrop').fadeOut(80);
  });
});





// === Recurrence label sync with the opener button (Daily / Weekly on Mon, Wed, Fri / Monthly on Sep 27 / Annually on Sep 27) ===
$(function () {
  // Remember which button opened the modal
  var $recurrenceTargetBtn = null;

  // Works for either opener you use
  $(document).on('click', '.conference_modal_repeat_btn, .cohort_schedule_btn', function () {
    $recurrenceTargetBtn = $(this);
    $('#customRecurrenceModalBackdrop').fadeIn();
  });

  function normalizePeriod() {
    var raw = ($('#customrec_period_val').text() || '').trim().toLowerCase(); // "1 day" | "week" | "monthly" | "year"
    if (raw.indexOf('day')   > -1) return 'day';
    if (raw.indexOf('week')  > -1) return 'week';
    if (raw.indexOf('month') > -1) return 'month';
    if (raw.indexOf('year')  > -1) return 'year';
    return '';
  }

  // Build a comma-separated weekday list based on the selected chips
  function selectedWeekdaysLabel() {
    // chip order is S M T W T F S (Sunday..Saturday)
    var names = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    var picked = [];
    $('#customrec_repeat_on_container .customrec_day_btn').each(function (idx) {
      if ($(this).hasClass('active')) picked.push(names[idx]);
    });
    return picked.join(', ');
  }

  // Get text like "Sep 27,2025" and trim the year → "Sep 27"
  function trimmedDateFrom(sel) {
    return ($(sel).text() || '').trim().replace(/,\s*\d{4}$/, '');
  }

  function computeRecurrenceLabel() {
    var n = parseInt($('#customrec_interval').text(), 10) || 1;
    var p = normalizePeriod();
    if (!p) return 'Does not repeat';

    if (p === 'day') {
      return (n === 1) ? 'Daily' : ('Every ' + n + ' days');
    }

    if (p === 'week') {
      var days = selectedWeekdaysLabel(); // <<— Mon, Wed, Fri
      if (n === 1) return days ? ('Weekly on ' + days) : 'Weekly';
      return 'Every ' + n + ' weeks' + (days ? (' on ' + days) : '');
    }

    if (p === 'month') {
      var on = trimmedDateFrom('#customrec_monthly_picker_date') || trimmedDateFrom('#customrec_end_date_btn');
      if (n === 1) return 'Monthly on ' + on;
      return 'Every ' + n + ' months on ' + on;
    }

    if (p === 'year') {
      var onYear = trimmedDateFrom('#customrec_end_date_btn') || trimmedDateFrom('#customrec_monthly_picker_date');
      if (n === 1) return 'Annually on ' + onYear;
      return 'Every ' + n + ' years on ' + onYear;
    }

    return 'Does not repeat';
  }

  function updateRepeatButtonLabel() {
    var $btn = ($recurrenceTargetBtn && $recurrenceTargetBtn.length)
      ? $recurrenceTargetBtn
      : $('.conference_modal_repeat_btn, .cohort_schedule_btn').first();

    if (!$btn.length) return;

    var label = computeRecurrenceLabel();

    // Keep each button's arrow style
    if ($btn.hasClass('cohort_schedule_btn')) {
      $btn.html(label + ' <span class="cohort_schedule_arrow">&#9660;</span>');
    } else if ($btn.hasClass('conference_modal_repeat_btn')) {
      $btn.html(label + '<span style="float:right; font-size:1rem;">&#9660;</span>');
    } else {
      $btn.text(label);
    }
  }

  // Update when period changes
  $(document).on('click', '#customrec_period_list .customrec_option', function () {
    setTimeout(updateRepeatButtonLabel, 0);
  });

  // Update when interval +/- changes
  $(document).on('click', '#customrec_plus, #customrec_minus', function () {
    setTimeout(updateRepeatButtonLabel, 0);
  });

  // Update live when weekday chips are toggled
  $(document).on('click', '.customrec_day_btn', function () {
    setTimeout(updateRepeatButtonLabel, 0);
  });

  // Update after choosing dates in monthly/ends-on calendar
  $(document).on('click', '#monthly_cal_done', function () {
    setTimeout(updateRepeatButtonLabel, 0);
  });

  // Update on Done
  $(document).on('click', '#customrec_done', function () {
    updateRepeatButtonLabel();
  });
});


</script>
