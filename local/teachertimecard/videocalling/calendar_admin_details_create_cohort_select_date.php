<style>
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

</style>

<!-- Custom Recurrence Modal -->
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
            <span id="customrec_period_val">...</span>
            <svg width="18" height="18" viewBox="0 0 20 20"><path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path></svg>
          </div>
          <div class="customrec_dropdown_list" id="customrec_period_list">
            <?php foreach ($weekOptions as $item) : ?>
              <div class="customrec_option" data-option="<?php echo $item; ?>"><?php echo $item; ?></div>
            <?php endforeach ?>
            <div class="customrec_option" data-option="">Does not repeat</div>

          </div>
        </div>
      </div>
    </div>
    <hr style="border:none; border-top:1.3px solid #ececec; margin:10px 0 15px 0;">
    <div>
      <label style="font-weight:600;">Repeat on</label>
      <div style="display:flex; gap:9px; margin-top:10px;">
        <button class="customrec_day_btn" data-day="sun">S</button>
        <button class="customrec_day_btn" data-day="mon">M</button>
        <button class="customrec_day_btn" data-day="tue">T</button>
        <button class="customrec_day_btn" data-day="wed">W</button>
        <button class="customrec_day_btn" data-day="thu">T</button>
        <button class="customrec_day_btn" data-day="fri">F</button>
        <button class="customrec_day_btn" data-day="sat">S</button>
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
          <button id="customrec_end_date_btn" disabled style="margin-left:10px;" class="customrec_date_btn conference_modal_date_btn2" data-modal="repeatOn">Sep 27,2024</button>
        </div>
        <!-- <div style="display:flex;align-items:center; gap:10px;">
          <input type="radio" id="customrec_end_after" name="customrec_end">
          <label for="customrec_end_after" style="font-size:1.05rem;">After</label>
          <div class="customrec_occurrence_counter" style="margin-left:12px;">
            <button class="customrec_stepper" id="customrec_occ_minus" disabled>−</button>
            <span id="customrec_occ_val" style="font-size:1.11rem;font-weight:600;color:#555;">13 occurrences</span>
            <button class="customrec_stepper" id="customrec_occ_plus" disabled>+</button>
          </div>
        </div> -->
      </div>
    </div>
    <div style="display:flex; gap:12px; margin-top:23px;">
      <!-- <button class="calendar_admin_details_create_cohort_btn" id="customrec_cancel" style="background:#fff;color:#232323;border:2px solid #232323;">Cancel</button> -->
      <button class="calendar_admin_details_create_cohort_btn" id="customrec_done" style="background:#fe2e0c;">Done</button>
    </div>
  </div>
</div>

<script>
// ===== Custom Recurrence Modal JS (DIV Trigger Version) =====
$(document).ready(function () {
  // When the conference_modal_repeat_btn is clicked and its text is "Does not repeat", open custom modal
  $('.conference_modal_repeat_btn').on('click', function(){
    var selected = $(this).text().trim().toLowerCase();
//    if(selected === "does not repeat"){
      $('#customRecurrenceModalBackdrop').fadeIn();
      // Optionally, change the button text back to a previous value if you store it somewhere
      // $(this).text('Previous value');
  //  }
  });
   $('.customrec_day_btn').on('click', function(){
      var day = $(this).attr('data-day');
      if(day in daysActive){
        daysActive[day] = !daysActive[day];
        repeat.weekDays = daysActive
      }
      
  });

  $('.customrec_day_btn').hide()
  

  // Open/close modal
  $('.calendar_admin_details_create_cohort_close.customrec, #customrec_cancel, #customRecurrenceModalBackdrop').on('click', function(e){
    if(e.target === this || $(e.target).hasClass('calendar_admin_details_create_cohort_close') || e.target.id === 'customrec_cancel') {
      $('#customRecurrenceModalBackdrop').fadeOut();
    }
  });

  // Stepper for interval
  let recInt = 1;
  $('#customrec_plus').on('click', function(){ 
    recInt++; $('#customrec_interval').text(recInt); 
    repeatEveryCount++ 
  });
  $('#customrec_minus').on('click', function(){ 
    if(recInt > 1) recInt--; $('#customrec_interval').text(recInt); 
    if(repeatEveryCount != 1){
      repeatEveryCount--

    }

  });

  // Period dropdown
  $('#customrec_period_btn').on('click', function(e){
    e.stopPropagation();
    $('#customrec_period_list').toggle();
  });
  $(document).on('click', function(){ $('#customrec_period_list').hide(); });
  $('#customrec_period_list .customrec_option').on('click', function(){
    if($(this).text().toLocaleLowerCase() == 'does not repeat'){
      $('#customrec_period_val').text('...');

    }else{
      $('#customrec_period_val').text($(this).text());
      $('#customrec_period_list').hide();

    }
  });

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

  // Custom date and occurrence counter logic
  $('#customrec_end_date_btn').on('click', function(){
    if($(this).prop('disabled')) return;
    // Add your date picker integration here
    
  });
  let occVal = 13;
  $('#customrec_occ_plus').on('click', function(){ if($('#customrec_end_after').is(':checked')){ occVal++; $('#customrec_occ_val').text(occVal + ' occurrences'); } });
  $('#customrec_occ_minus').on('click', function(){ if($('#customrec_end_after').is(':checked') && occVal > 1){ occVal--; $('#customrec_occ_val').text(occVal + ' occurrences'); } });

  $('#customrec_done').on('click', function(){
    $('#customRecurrenceModalBackdrop').fadeOut();
    // Save recurrence settings if needed
      // Cambiar texto a "Repeat"
      if(typeRepeat != null){
        $('.conference_modal_repeat_btn').contents().filter(function () {
          return this.nodeType === 3; // Solo nodos de texto
        }).first().replaceWith('Repeat ');
      }else{
        
        $('.conference_modal_repeat_btn').contents().filter(function () {
          return this.nodeType === 3; // Solo nodos de texto
        }).first().replaceWith('Does not repeat');
      }
  });
});

</script>
