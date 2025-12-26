
<div id="calendar_admin_details_create_cohort_modal_backdrop">
  <div id="calendar_admin_details_create_cohort_modal">
    <span class="calendar_admin_details_create_cohort_close">&times;</span>
    <div style="display: flex;align-items:center">
      <h2 id="titleModalEvent">Management</h2>
      <div style="margin-left:10px;" id='deleteEvent'></div>

    </div>
    
    <!-- Conference Content: loaded by JS when needed -->
    <div id="conferenceTabContent">
      <div class="conference_modal_repeat_row">
        <div style="flex:1;">
          <div class="conference_modal_repeat_btn" style="border-bottom:2.5px solid #fe2e0c;">
            Does not repeat
            <span style="float:right; font-size:1rem;">&#9660;</span>
          </div>
        </div>
          <div class="conference_modal_label" style="font-weight:400;">Start On</div>

        <div style="flex:1;">
          <button class="conference_modal_date_btn" style="color: red;">Select Date</button>
        </div>
      </div>
      <div style="display:flex; gap:12px; align-items:center; margin-bottom:7px;">
        <button class="conference_modal_time_btn" data-time="start">Start Time</button>
        <span>-</span>
        <button class="conference_modal_time_btn" data-time="end">End Time</button>
        <a class="conference_modal_findtime_link" href="#">Find a time</a>



        <!-- Color Picker Dropdown (inline with Find a time) -->
        <div class="color-dropdown-wrapper">
          <button type="button" class="color-dropdown-toggle" id="colorDropdownToggle" style="width:75px;">
              <span class="color-circle" id="selectoPicker" style="background:#1736e6"></span>
              <span style="float:right; font-size:1rem;">▼</span>
          </button>
          <div class="color-dropdown-list" id="colorDropdownList">
            <div class="color-dropdown-color" data-color="#1736e6" style="background:#1736e6"></div>
            <div class="color-dropdown-color" data-color="#22b07e" style="background:#22b07e"></div>
            <div class="color-dropdown-color" data-color="#3c3b4d" style="background:#3c3b4d"></div>
            <div class="color-dropdown-color" data-color="#bf0eef" style="background:#bf0eef"></div>
            <div class="color-dropdown-color" data-color="#daaf36" style="background:#daaf36"></div>
          </div>
        </div>

      
      
      </div>
      <select class="conference_modal_timezone">
        <option><?php echo $USER->timezone;?></option>
      </select>
      <div class="conference_modal_fieldrow">
        <div>
          <span class="conference_modal_label">Attending Cohorts</span>
          <div class="conference_modal_dropdown_btn" id="conferenceCohortsDropdown">
            XX#
          <span style="float:right; font-size:1rem;">▼</span>
          </div>
          <div class="conference_modal_dropdown_list" id="conferenceCohortsDropdownList">
            <ul>
              <?php
                foreach ($cohorts as $cohort) {
                    echo '<li data-shortname="'.$cohort->shortname.'" data-cohort="' . $cohort->id . '">' . $cohort->name . '</li>';
                }
              ?>
            </ul>
          </div>
        </div>
        <div>
          <span class="conference_modal_label">Teachers</span>
          <div class="conference_modal_dropdown_btn" id="conferenceTeachersDropdown">
            Select Teacher
                <span style="float:right; font-size:1rem;">▼</span>
          </div>
          <div class="conference_modal_dropdown_list" id="conferenceTeachersDropdownList">
            <ul>
              <?php
                foreach ($users as $user) {
                    $userpic = $OUTPUT->user_picture($user, array(
                      'class' => 'calendar_admin_details_create_cohort_teacher_avatar'
                    )); // ajusta el size si quieres
                    echo '<li data-teacher="' . $user->id . '">'
                    . $userpic
                    . ' ' . $user->firstname . ' ' . $user->lastname
                    . '</li>';
                }
              ?>
              </ul>
          </div>
        </div>
      </div>




<div class="conference_modal_lists_row">
<!-- Cohorts List (left side) -->
<div class="conference_modal_attendees_section">
  <div style="font-weight:600; margin-bottom:6px;">Cohorts</div>
  <ul class="conference_modal_cohort_list">
    <!-- Example cohort item (will be added by JS on selection) -->
    <!--
    <li class="conference_modal_attendee" data-cohort="FL1">
      <span class="conference_modal_cohort_chip">FL1</span>
      <span class="conference_modal_attendee_name">Florida 1</span>
      <span class="conference_modal_remove">&times;</span>
    </li>
    -->
  </ul>
</div>
<!-- Teachers List (right side) -->
<div class="conference_modal_attendees_section">
  <div style="font-weight:600; margin-bottom:6px;">Teachers</div>
  <ul class="conference_modal_attendees_list">
    <!-- Example teacher item (added by JS) -->
    <!--
    <li class="conference_modal_attendee" data-email="jackson.graham@example.com">
      <img src="https://randomuser.me/api/portraits/men/31.jpg" style="width:40px;height:40px;border-radius:50%;border:1.2px solid #e1e1e1;">
      <span>jackson.graham@example.com</span>
      <span class="conference_modal_icon user">&#128100;</span>
      <span class="conference_modal_remove">&times;</span>
    </li>
    -->
  </ul>
</div>
</div>


      <button id="sendDataButton" class="conference_modal_btn">Schedule Conference</button>
    </div>
  </div>
  <!-- Time Picker Modal -->
  <div class="calendar_admin_details_create_cohort_time_modal_backdrop" id="timeModalBackdrop">
    <div class="calendar_admin_details_create_cohort_time_modal" id="timeModal">
      <ul>
        
        <?php
        for ($i=0; $i <= 23; $i++) : ?>

            <li><?php echo $i < 10? "0".$i : $i; echo ":00"; ?></li>
        <?php endfor?>
      </ul>
    </div>
  </div>
  <!-- Calendar Date Picker Modal -->
  <div class="calendar_admin_details_create_cohort_calendar_modal_backdrop" id="calendarDateModalBackdrop" style="display:none;">
    <div class="calendar_admin_details_create_cohort_calendar_modal" id="calendarDateModal">
      <div class="calendar_admin_details_create_cohort_calendar_nav">
        <button class="calendar_prev_month">&lt;</button>
        <span id="calendarDateMonth"></span>
        <button class="calendar_next_month">&gt;</button>
      </div>
      <div class="calendar_admin_details_create_cohort_calendar_days"></div>
      <button class="calendar_admin_details_create_cohort_calendar_done_btn">Done</button>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    let repetOnActive = false
    
    $('.customrec_option').on('click', function () {
      typeRepeat = $(this).data('option').toLocaleLowerCase();
      if(typeRepeat == ''){
        $('.customrec_day_btn').hide()
        activeRepeat = false
        typeRepeat = null;
        return
      }
      activeRepeat = true
      if(typeRepeat.toLocaleLowerCase() == 'week'){
        $('.customrec_day_btn').show()

      }else{
        $('.customrec_day_btn').hide()

      }
    });

    $('.calendar_admin_details_create_cohort_close').click(function () {
      
      $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();

    });

    // Tabs - Peer Talk tab shows Conference content
    $('.calendar_admin_details_create_cohort_tab').click(function () {
      $('.calendar_admin_details_create_cohort_tab').removeClass('active');
      $(this).addClass('active');
      let tab = $(this).data('tab');
      $('#mainModalContent').toggle(tab === "cohort");
      
      $('#conferenceTabContent').toggle(tab === "conference");


      // Hide both if not cohort/conference/peertalk
      if(tab !== "cohort" && tab !== "conference" && tab !== "peertalk"){
        $('#mainModalContent').hide();
        $('#conferenceTabContent').hide();
      }
    });

    // Dropdowns
    $('#cohortDropdownBtn').click(function (e) {
      e.stopPropagation();
      $('#cohortDropdownList').toggle();
      $('#shortNameDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className1DropdownList, #className2DropdownList').hide();
    });
    $('#cohortDropdownList li').click(function () {
      $('#cohortDropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
      $('#cohortDropdownList').hide();
    });
    $('#shortNameDropdownBtn').click(function (e) {
      e.stopPropagation();
      $('#shortNameDropdownList').toggle();
      $('#cohortDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className1DropdownList, #className2DropdownList').hide();
    });
    $('#shortNameDropdownList li').click(function () {
      $('#shortNameDropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
      $('#shortNameDropdownList').hide();
    });
    $('#teacher1DropdownBtn').click(function(e){
      e.stopPropagation();
      $('#teacher1DropdownList').toggle();
      $('#cohortDropdownList, #shortNameDropdownList, #teacher2DropdownList, #className1DropdownList, #className2DropdownList').hide();
    });
    $('#teacher1DropdownList li').click(function(){
      $('#teacher1DropdownBtn').html($(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
      $('#teacher1DropdownList').hide();
    });
    $('#teacher2DropdownBtn').click(function(e){
      e.stopPropagation();
      $('#teacher2DropdownList').toggle();
      $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList, #className1DropdownList, #className2DropdownList').hide();
    });
    $('#teacher2DropdownList li').click(function(){
      $('#teacher2DropdownBtn').html($(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
      $('#teacher2DropdownList').hide();
    });
    $('#className1DropdownBtn').click(function(e){
      e.stopPropagation();
      $('#className1DropdownList').toggle();
      $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className2DropdownList').hide();
    });
    $('#className1DropdownList li').click(function(){
      $('#className1DropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
      $('#className1DropdownList').hide();
    });
    $('#className2DropdownBtn').click(function(e){
      e.stopPropagation();
      $('#className2DropdownList').toggle();
      $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className1DropdownList').hide();
    });
    $('#className2DropdownList li').click(function(){
      $('#className2DropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
      $('#className2DropdownList').hide();
    });
    // Conference tab dropdowns
    $('#conferenceCohortsDropdown').click(function(e){
      if(refresh) return
      e.stopPropagation();
      $('#conferenceCohortsDropdownList').toggle();
      $('#conferenceTeachersDropdownList').hide();
    });
    $('#conferenceTeachersDropdown').click(function(e){
      if(refresh) return

      e.stopPropagation();
      $('#conferenceTeachersDropdownList').toggle();
      $('#conferenceCohortsDropdownList').hide();
    });
    $('#conferenceCohortsDropdownList li').click(function(){
      $('#conferenceCohortsDropdown').contents().first()[0].textContent = $(this).text() + " ";
      $('#conferenceCohortsDropdownList').hide();
    });
    
    
    // $('#conferenceTeachersDropdownList li').click(function(){
    //   $('#conferenceTeachersDropdown').html($(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
    //   $('#conferenceTeachersDropdownList').hide();
    // });

        $('#conferenceTeachersDropdownList li').click(function(){
          // 1. Set dropdown value
          $('#conferenceTeachersDropdown').html($(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
          $('#conferenceTeachersDropdownList').hide();
          // console.log(idTeachersModal)

          // 2. Get teacher info
          let imgHtml = $(this).find('img').prop('outerHTML');
          let name = $(this).text().trim();
          let idTeacher = $(this).attr('data-teacher');
          if(idTeachersModal.includes(idTeacher)){
            return
          }
          let email = name.replace(/\s/g, '').toLowerCase() + "@example.com"; // Or set email as you wish
          idTeachersModal.push(idTeacher)
          // console.log(idTeachersModal)

          // 3. Prevent duplicates
          // let exists = false;
          // $('#conferenceTabContent .conference_modal_attendee').each(function(){
          //   if($(this).find('.conference_modal_attendee_name').text().trim() === name) exists = true;
          //   if($(this).find('span').eq(1).text().trim() === name) exists = true;
          // });
          // if(exists) return;

          // 4. Add to attendee list
          $('#conferenceTabContent .conference_modal_attendees_list').append(`
            <li data-teacher="${idTeacher}" class="conference_modal_attendee">
              ${typeof(imgHtml)!='string' ? '' : imgHtml}
              <span>${name}</span>
              <span class="conference_modal_icon user">&#128100;</span>
              <span class="conference_modal_remove">&times;</span>
            </li>
          `);
        });


    $(document).click(function () {
      $('.calendar_admin_details_create_cohort_dropdown_list, .calendar_admin_details_create_cohort_teacher_list, .calendar_admin_details_create_cohort_class_list, .calendar_admin_details_create_cohort_shortname_list, .conference_modal_dropdown_list').hide();
    });
    // Remove attendee
    // $('.conference_modal_remove').click(function(){
    //   $(this).closest('.conference_modal_attendee').fadeOut(200, function() { $(this).remove(); });
    // });

      $(document).on('click', '.conference_modal_remove', function(){
        $(this).closest('.conference_modal_attendee').fadeOut(200, function() { $(this).remove(); });
      });

    // Toggles
    $('#toggleActive, #toggleAvailable').click(function () {
      $(this).toggleClass('active');
    });

    // ===== TIME PICKER (all "Start Time" & "End Time" buttons, both tabs) =====
    function openTimePickerModal($btn) {
      let times = [];
      let start = 10; // 5:00 AM (10th half hour after midnight)
      let end = 47; // 11:30 PM
      for (let i = start; i <= end; i++) {
        let hour = Math.floor(i/2);
        let min = i%2 === 0 ? "00" : "30";
        let hour12 = ((hour+11)%12+1);
        let ampm = hour < 12 ? "AM" : "PM";
        let str = hour12.toString().padStart(2, "0") + ":" + min + " " + ampm;
        times.push(str);
      }
      let html = "";
      for (let t of times) html += `<li>${t}</li>`;
      // $('#timeModal ul').html(html);
      // Position
      let offset = $btn.offset();
      let left = offset.left + $btn.outerWidth()/2 - 105; // Centered (210px wide)
      let top = offset.top + $btn.outerHeight() + 2;
      if ($(window).width() < 500) {
        left = "50%"; top = $(window).scrollTop() + $(window).height() * 0.20;
        $('#timeModal').css({ left: left, top: top, transform: "translate(-50%,0)" });
      } else {
        $('#timeModal').css({ left: left, top: top, transform: "none" });
      }
      $('#timeModalBackdrop').show().data('targetBtn', $btn);
    }
    // --- Bind time picker for both class and conference time buttons! ---
    $(document).on("click", ".calendar_admin_details_create_cohort_time_btn, .conference_modal_time_btn", function(e){
      e.stopPropagation();
      openTimePickerModal($(this));
    });
    $('#timeModal').off("click", "li").on("click", "li", function(){
      let $btn = $('#timeModalBackdrop').data('targetBtn');
      $btn.text($(this).text()).addClass('selected');
      let typeClickEvent = $btn.attr('data-time')
      const selectedTimeStr = $(this).text().trim(); // por ejemplo, "04:00"
      
      // Actualiza TimeEvent en UTC ISO string
      if(typeClickEvent == 'start'){
        const newStartMoment = moment.tz(
          moment(startTimeEvent).format('YYYY-MM-DD') + 'T' + selectedTimeStr,
          'YYYY-MM-DDTHH:mm',
          timeZone
        );
        startTimeEvent = newStartMoment.clone().utc().toISOString();

      }else{
        const newStartMoment = moment.tz(
          moment(startTimeEvent).format('YYYY-MM-DD') + 'T' + selectedTimeStr,
          'YYYY-MM-DDTHH:mm',
          timeZone
        );
        finishTimeEvent = newStartMoment.clone().utc().toISOString();

      }

      $('#timeModalBackdrop').hide();
    });
    $('#timeModalBackdrop').off("click").on("click", function(e){
      if (e.target === this) $(this).hide();
    });
    $(document).on("keydown", function(e){
      if (e.key === "Escape") $('#timeModalBackdrop').hide();
    });

    // ===== CALENDAR PICKER LOGIC =====
    function daysInMonth(year, month) {
      return new Date(year, month+1, 0).getDate();
    }
    let calendarDateTargetBtn = null;
    let selectedCalendarDate = null;
    let calendarModalMonth = null;
    $(document).on('click', '.conference_modal_date_btn', function(e){
      e.preventDefault();
      calendarDateTargetBtn = $(this);
      if ($(this).parents('#conferenceTabContent').length) {
        calendarModalMonth = {year: 2025, month: moment().month()}; // Jan 2025
      } else {
        let now = new Date();
        calendarModalMonth = {year: now.getFullYear(), month: now.getMonth()};
      }
      selectedCalendarDate = null;
      renderCalendarModal();
      $('#calendarDateModalBackdrop').fadeIn();
    });
    $(document).on('click', '.conference_modal_date_btn2', function(e){
      e.preventDefault();
      calendarDateTargetBtn = $(this);
      if($(this).attr('data-modal') == 'repeatOn'){
        $('#customRecurrenceModalBackdrop').css('z-index',999)
        repetOnActive = true
      }
      if ($(this).parents('#conferenceTabContent').length) {
        calendarModalMonth = {year: 2025, month: moment().month()}; // Jan 2025
      } else {
        let now = new Date();
        calendarModalMonth = {year: now.getFullYear(), month: now.getMonth()};
      }
      selectedCalendarDate = null;
      renderCalendarModal();
      $('#calendarDateModalBackdrop').fadeIn();
    });
    $(document).on('click', '.calendar_prev_month', function(){
      calendarModalMonth.month--;
      if(calendarModalMonth.month < 0) {
        calendarModalMonth.month = 11; calendarModalMonth.year--;
      }
      renderCalendarModal();
    });
    $(document).on('click', '.calendar_next_month', function(){
      calendarModalMonth.month++;
      if(calendarModalMonth.month > 11) {
        calendarModalMonth.month = 0; calendarModalMonth.year++;
      }
      renderCalendarModal();
    });
    function renderCalendarModal(){
      const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
      let y = calendarModalMonth.year, m = calendarModalMonth.month;
      $('#calendarDateMonth').text(`${monthNames[m]} ${y}`);
      let html = '';
      let dayHeaders = ['Mo','Tu','We','Th','Fr','Sa','Su'];
      for(let d=0;d<7;d++) html += `<div class="calendar_admin_details_create_cohort_calendar_day_header">${dayHeaders[d]}</div>`;
      let firstDay = new Date(y,m,1).getDay(); firstDay = (firstDay+6)%7;
      let totalDays = daysInMonth(y,m);
      let prevMonthDays = firstDay;
      let day = 1;
      for(let i=0;i<prevMonthDays;i++) html += `<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>`;
      for(let d=1; d<=totalDays; d++){
        let sel = selectedCalendarDate &&
          selectedCalendarDate.getFullYear() === y &&
          selectedCalendarDate.getMonth() === m &&
          selectedCalendarDate.getDate() === d ? ' selected' : '';
        html += `<div class="calendar_admin_details_create_cohort_calendar_day${sel}" data-day="${d}">${d}</div>`;
        day++;
      }
      let rem = (prevMonthDays + totalDays)%7;
      if(rem>0) for(let i=rem;i<7;i++) html += `<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>`;
      $('.calendar_admin_details_create_cohort_calendar_days').html(html);
    }
    
    $(document).on('click', '.calendar_admin_details_create_cohort_calendar_day', function(){
      $('.calendar_admin_details_create_cohort_calendar_day').removeClass('selected');
      $(this).addClass('selected');
      let day = parseInt($(this).attr('data-day'));
      selectedCalendarDate = new Date(calendarModalMonth.year, calendarModalMonth.month, day);
    });
    
   
    $('.calendar_admin_details_create_cohort_calendar_done_btn').click(function() {
      if (selectedCalendarDate && calendarDateTargetBtn) {
        let d = selectedCalendarDate;
        let nice = d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        calendarDateTargetBtn.text(nice);
        $('#calendarDateModalBackdrop').fadeOut();
        // si se abrio el modal de los repeat

        if(repetOnActive){
          $('#customRecurrenceModalBackdrop').css('z-index',2050)
          repetOnActive = false
          // Asegurar formato correcto de fecha con zona
          let dateStr = moment(d).tz(timeZone).format('YYYY-MM-DD');

          // Construir nuevos eventos
          let newStartRepeat = moment(`${dateStr}T${'00:00'}`, 'YYYY-MM-DDTHH:mm');

          repeat.repeatOn = newStartRepeat.clone().set({ date: d.getDate(), hour: 0, minute: 0, second: 0, millisecond: 0 }).utc().toISOString();
          return
        }        

        if (startTimeEvent && finishTimeEvent) {
          // Obtener hora original
          let originalStartTime = moment.tz(startTimeEvent, timeZone).format('HH:mm');
          let originalFinishTime = moment.tz(finishTimeEvent, timeZone).format('HH:mm');

          // Asegurar formato correcto de fecha con zona
          let dateStr = moment(d).tz(timeZone).format('YYYY-MM-DD');

          // Construir nuevos eventos
          let newStart = moment.tz(`${dateStr}T${originalStartTime}`, 'YYYY-MM-DDTHH:mm', timeZone);
          let newFinish = moment.tz(`${dateStr}T${originalFinishTime}`, 'YYYY-MM-DDTHH:mm', timeZone);

          startTimeEvent = newStart.clone().set('date', d.getDate()).utc().toISOString();
          finishTimeEvent = newFinish.clone().set('date', d.getDate()).utc().toISOString();
        }
      }
    });


    $('#calendarDateModalBackdrop').click(function(e){
      if(e.target === this) $(this).fadeOut();
      if(e.target === this && repetOnActive){
          // console.log('1')
        $('#customRecurrenceModalBackdrop').css('z-index',2050)
        repetOnActive = false
      }
    });

    // Color dropdown logic
    $('#colorDropdownToggle').click(function(e){
      e.stopPropagation();
      $(this).toggleClass('active');
      $('#colorDropdownList').toggle();
    });
    $('#colorDropdownList .color-dropdown-color').click(function(e){
      e.stopPropagation();
      var color = $(this).attr('data-color');
      $('#colorDropdownToggle .color-circle').css('background', color);
      $('#colorDropdownList .color-dropdown-color').removeClass('selected');
      $(this).addClass('selected');
      $('#colorDropdownList').hide();
      $('#colorDropdownToggle').removeClass('active');
    });

    $(document).click(function(){

      $('#colorDropdownList').hide();
        $('#peerTalkCohortsDropdownList, #peerTalkTeachersDropdownList, #conferenceCohortsDropdownList, #conferenceTeachersDropdownList').hide();
      $('#colorDropdownToggle').removeClass('active');
      $('#colorDropdownList, #peerTalkColorDropdownList').hide();
      $('#colorDropdownToggle, #peerTalkColorDropdownToggle').removeClass('active');


    });

  });



  // Add cohort to cohort list when selected
$('#conferenceCohortsDropdownList li').click(function(){
  let cohort = $(this).text().trim();
  let cohortid = $(this).attr('data-cohort');
  if(idCohortsModal.includes(cohortid)){
    return
  }
  let shortname = $(this).attr('data-shortname');
  idCohortsModal.push(cohortid)
  // Prevent duplicates
  if ($('.conference_modal_cohort_list li[data-cohort="'+cohortid+'"]').length === 0) {
    $('.conference_modal_cohort_list').append(`
      <li data-cohort="${cohortid}">
        <span class="conference_modal_cohort_chip">${shortname}</span>
        <span class="conference_modal_attendee_name">${cohort}</span>
        <span class="conference_modal_remove">&times;</span>
      </li>
    `);
  }
  $('#conferenceCohortsDropdown').contents().first()[0].textContent = cohort + " ";
  $('#conferenceCohortsDropdownList').hide();
  // console.log(idCohortsModal);
});



// Remove cohort attendee (from cohort list)
$(document).on('click', '.conference_modal_cohort_list .conference_modal_remove', function() {
  let $li = $(this).closest('li'); // Obtener el elemento li contenedor
  let cohort = $li.attr('data-cohort');
  idCohortsModal = idCohortsModal.filter(c => c !== cohort);
  $li.fadeOut(200, function() { 
    $(this).remove();
  });
});


// Remove cohort attendee (from cohort list)
$(document).on('click', '.conference_modal_attendees_list .conference_modal_remove', function() {
  let $li = $(this).closest('li'); // Obtener el elemento li contenedor
  
  let teacher = $li.attr('data-teacher');
  idTeachersModal = idTeachersModal.filter(c => c !== teacher);

  
  $li.fadeOut(200, function() { 
    $(this).remove();
  });
});





// Peer Talk: Add cohort to cohort list (left side)
$('#peerTalkCohortsDropdownList li').click(function(){
let cohort = $(this).text().trim();
// Prevent duplicates in Peer Talk cohort list
let $list = $('#peerTalkTabContent .conference_modal_cohort_list');
if ($list.find('li[data-cohort="'+cohort+'"]').length === 0) {
  $list.append(`
    <li class="conference_modal_attendee" data-cohort="${cohort}">
      <span class="conference_modal_cohort_chip">${cohort}</span>
      <span class="conference_modal_attendee_name">${cohort}</span>
      <span class="conference_modal_remove">&times;</span>
    </li>
  `);
}
$('#peerTalkCohortsDropdown').contents().first()[0].textContent = cohort + " ";
$('#peerTalkCohortsDropdownList').hide();
});


// Peer Talk: Add teacher to teacher list (right side)
$('#peerTalkTeachersDropdownList li').click(function(){
let name = $(this).text().trim();
let imgHtml = $(this).find('img').prop('outerHTML');
let $list = $('#peerTalkTabContent .conference_modal_attendees_list');
// Prevent duplicates
let exists = false;
$list.find('.conference_modal_attendee').each(function(){
  if($(this).find('span').eq(1).text().trim() === name) exists = true;
});
if(exists) return;
$list.append(`
  <li class="conference_modal_attendee">
    ${imgHtml}
    <span>${name}</span>
    <span class="conference_modal_icon user">&#128100;</span>
    <span class="conference_modal_remove">&times;</span>
  </li>
`);
$('#peerTalkTeachersDropdown').html($(this).html() + '<span style="float:right; font-size:1rem;">▼</span>');
$('#peerTalkTeachersDropdownList').hide();
});


$(document).on('click', '.conference_modal_remove', function(){
$(this).closest('.conference_modal_attendee').fadeOut(200, function() { $(this).remove(); });
});


// Peer Talk Cohorts dropdown
$('#peerTalkCohortsDropdown').click(function(e){
e.stopPropagation();
$('#peerTalkCohortsDropdownList').toggle();
$('#peerTalkTeachersDropdownList').hide();
});
$('#peerTalkTeachersDropdown').click(function(e){
e.stopPropagation();
$('#peerTalkTeachersDropdownList').toggle();
$('#peerTalkCohortsDropdownList').hide();
});





</script>

<?php require_once('calendar_admin_details_create_cohort_select_date.php');?>


