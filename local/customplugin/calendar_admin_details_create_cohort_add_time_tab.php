

  <div class="calendar_admin_details_create_cohort_content tab-content" id="addTimeTabContent" style="display:none;">
  <form id="addTimeForm">
    <label class="addtime-label" style="margin-top:5px;">Teacher</label>
    <div class="addtime-teacher-dropdown">
      <div class="addtime-teacher-selected">
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="addtime-teacher-avatar">
        <span>Daniella</span>
      </div>
    </div>
    
    <label class="addtime-label" style="margin-top:16px;">Title</label>
    <input type="text" class="addtime-title-input" value="Busy" />



<style>
  .calendar_admin_details_create_cohort_add_time_tab_label{
    display:block;font-weight:600;margin:10px 0 6px;color:#222;
  }
  .calendar_admin_details_create_cohort_add_time_tab_row{
    display:grid;gap:12px;grid-template-columns:minmax(260px,1fr) 160px;
    align-items:center;margin-bottom:14px;
  }
  @media(max-width:520px){
    .calendar_admin_details_create_cohort_add_time_tab_row{grid-template-columns:1fr 130px;}
  }

  /* date pill */
  .calendar_admin_details_create_cohort_add_time_tab_date_btn{
    width:100%;text-align:left;cursor:pointer;
    background:#fff;border:1.5px solid #e7e7ef;color:#222;border-radius:12px;
    padding:12px 14px;font-size:15px;box-shadow:0 2px 8px rgba(0,0,0,.03);
    display:flex;align-items:center;justify-content:space-between;
  }

  /* === your OLD time field classes === */
  /* .custom-time-pill{
    position:relative;background:#fff;border:1.5px solid #e7e7ef;border-radius:12px;
    padding:10px 12px;box-shadow:0 2px 8px rgba(0,0,0,.03);
  } */
  .time-input{
    width:100%;border:0;outline:none;background:transparent;font-size:15px;color:#222;cursor:pointer;
  }
  .custom-time-dropdown{
    display:none;position:absolute;left:0;right:0;top:calc(100% + 6px);z-index:10;
    background:#fff;border:1px solid #eee;border-radius:12px;max-height:220px;overflow:auto;
    box-shadow:0 12px 26px rgba(0,0,0,.12);
  }
  .custom-time-dropdown button{
    width:100%;text-align:left;padding:9px 11px;border:0;background:#fff;cursor:pointer;
  }
  .custom-time-dropdown button:hover{background:#f6f6fb;}

  /* calendar modal (centered) */
  .calendar_admin_details_create_cohort_add_time_tab_backdrop{
    position:fixed;inset:0;display:none;align-items:center;justify-content:center;
    background:rgba(0,0,0,.25);z-index:3002;padding:20px;
  }
  .calendar_admin_details_create_cohort_add_time_tab_modal{
    background:#fff;border-radius:18px;width:320px;max-width:95vw;
    box-shadow:0 12px 36px rgba(0,0,0,.2);padding:16px 16px 18px;
  }
  .calendar_admin_details_create_cohort_add_time_tab_header{
    display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;
  }
  .calendar_admin_details_create_cohort_add_time_tab_navbtn{
    width:40px;height:40px;border-radius:12px;background:#f6f6fb;border:1px solid #eee;
    display:flex;align-items:center;justify-content:center;cursor:pointer;
  }
  .calendar_admin_details_create_cohort_add_time_tab_month_label{font-weight:700;font-size:16px;}
  .calendar_admin_details_create_cohort_add_time_tab_weekdays{
    display:grid;grid-template-columns:repeat(7,1fr);gap:6px;margin:10px 0 6px;
    color:#8b8b95;font-weight:700;font-size:12px;
  }
  .calendar_admin_details_create_cohort_add_time_tab_grid{
    display:grid;grid-template-columns:repeat(7,1fr);gap:6px;
  }
  .calendar_admin_details_create_cohort_add_time_tab_day{
    height:38px;border-radius:10px;border:1px solid transparent;background:#fff;
    display:flex;align-items:center;justify-content:center;cursor:pointer;
  }
  .calendar_admin_details_create_cohort_add_time_tab_day--selected{
    border-color:#ff3b00;color:#ff3b00;font-weight:700;
  }
  .calendar_admin_details_create_cohort_add_time_tab_done{
    margin-top:14px;width:100%;background:#ff3b00;color:#fff;border:0;border-radius:12px;
    padding:12px;font-weight:700;cursor:pointer;
  }
</style>

<div>
  <!-- FROM -->
  <label class="calendar_admin_details_create_cohort_add_time_tab_label">From</label>
  
  
  
  <div class="calendar_admin_details_create_cohort_add_time_tab_row" id="calendar_admin_details_create_cohort_add_time_tab_from_row">
    <!-- date pill -->
    <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_date_btn"
            id="calendar_admin_details_create_cohort_add_time_tab_from_btn" data-iso="2025-08-05">
      <span id="calendar_admin_details_create_cohort_add_time_tab_from_text">Tuesday, August 5, 2025</span>
      <svg width="18" height="18" viewBox="0 0 20 20"><path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
    </button>
    <!-- time pill (OLD classes/ids) -->
    <div class="custom-time-pill">
      <input type="text" class="time-input" value="9:30 am" readonly>
      <div class="custom-time-dropdown"></div>
    </div>
  </div>


  
  <!-- UNTIL -->
  <label class="calendar_admin_details_create_cohort_add_time_tab_label">Until</label>
  <div class="calendar_admin_details_create_cohort_add_time_tab_row" id="calendar_admin_details_create_cohort_add_time_tab_until_row">
    <!-- date pill -->
    <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_date_btn"
            id="calendar_admin_details_create_cohort_add_time_tab_until_btn" data-iso="2025-08-05">
      <span id="calendar_admin_details_create_cohort_add_time_tab_until_text">Tuesday, August 5, 2025</span>
      <svg width="18" height="18" viewBox="0 0 20 20"><path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
    </button>
    <!-- time pill (OLD classes/ids) -->
    <div class="custom-time-pill">
      <input type="text" class="time-input" value="9:30 am" readonly>
      <div class="custom-time-dropdown"></div>
    </div>
  </div>
</div>

<!-- calendar modal (reused for both) -->
<div class="calendar_admin_details_create_cohort_add_time_tab_backdrop" id="calendar_admin_details_create_cohort_add_time_tab_backdrop">
  <div class="calendar_admin_details_create_cohort_add_time_tab_modal" role="dialog" aria-modal="true">
    <div class="calendar_admin_details_create_cohort_add_time_tab_header">
      <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_navbtn" id="calendar_admin_details_create_cohort_add_time_tab_prev">
        <svg width="22" height="22" viewBox="0 0 24 24"><polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <div class="calendar_admin_details_create_cohort_add_time_tab_month_label" id="calendar_admin_details_create_cohort_add_time_tab_month_label">August 2025</div>
      <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_navbtn" id="calendar_admin_details_create_cohort_add_time_tab_next">
        <svg width="22" height="22" viewBox="0 0 24 24"><polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>
    <div class="calendar_admin_details_create_cohort_add_time_tab_weekdays">
      <div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div><div>Su</div>
    </div>
    <div class="calendar_admin_details_create_cohort_add_time_tab_grid" id="calendar_admin_details_create_cohort_add_time_tab_grid"></div>
    <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_done" id="calendar_admin_details_create_cohort_add_time_tab_done">Done</button>
  </div>
</div>

<script>
(function($){
  /* ========= DATE HELPERS ========= */
  function calendar_admin_details_create_cohort_add_time_tab_fmtLong(d){
    return d.toLocaleDateString(undefined,{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  }
  function calendar_admin_details_create_cohort_add_time_tab_readISO($btn){
    const iso = $btn.attr('data-iso'); return iso ? new Date(iso) : new Date();
  }
  function calendar_admin_details_create_cohort_add_time_tab_writeField($btn,$span,dateObj){
    $btn.attr('data-iso', dateObj.toISOString().slice(0,10));
    $span.text(calendar_admin_details_create_cohort_add_time_tab_fmtLong(dateObj));
  }

  /* ========= CALENDAR STATE ========= */
  let calendar_admin_details_create_cohort_add_time_tab_active_target = null; // 'from'|'until'
  let calendar_admin_details_create_cohort_add_time_tab_viewYear = new Date().getFullYear();
  let calendar_admin_details_create_cohort_add_time_tab_viewMonth = new Date().getMonth();
  let calendar_admin_details_create_cohort_add_time_tab_tempSelected = new Date();

  const $calendar_admin_details_create_cohort_add_time_tab_backdrop = $('#calendar_admin_details_create_cohort_add_time_tab_backdrop');
  const $calendar_admin_details_create_cohort_add_time_tab_grid = $('#calendar_admin_details_create_cohort_add_time_tab_grid');
  const $calendar_admin_details_create_cohort_add_time_tab_label = $('#calendar_admin_details_create_cohort_add_time_tab_month_label');

  function calendar_admin_details_create_cohort_add_time_tab_openCalendar(target, seed){
    calendar_admin_details_create_cohort_add_time_tab_active_target = target;
    calendar_admin_details_create_cohort_add_time_tab_viewYear  = seed.getFullYear();
    calendar_admin_details_create_cohort_add_time_tab_viewMonth = seed.getMonth();
    calendar_admin_details_create_cohort_add_time_tab_tempSelected = new Date(seed.getFullYear(),seed.getMonth(),seed.getDate());
    calendar_admin_details_create_cohort_add_time_tab_renderCalendar();
    $calendar_admin_details_create_cohort_add_time_tab_backdrop.css('display','flex').hide().fadeIn(120); // centered
  }

  function calendar_admin_details_create_cohort_add_time_tab_renderCalendar(){
    const monthName = new Date(calendar_admin_details_create_cohort_add_time_tab_viewYear, calendar_admin_details_create_cohort_add_time_tab_viewMonth, 1)
      .toLocaleString(undefined,{month:'long'});
    $calendar_admin_details_create_cohort_add_time_tab_label.text(monthName+' '+calendar_admin_details_create_cohort_add_time_tab_viewYear);

    $calendar_admin_details_create_cohort_add_time_tab_grid.empty();
    const first = new Date(calendar_admin_details_create_cohort_add_time_tab_viewYear, calendar_admin_details_create_cohort_add_time_tab_viewMonth, 1);
    const startIdx = (first.getDay()+6)%7;
    const daysInMonth = new Date(calendar_admin_details_create_cohort_add_time_tab_viewYear, calendar_admin_details_create_cohort_add_time_tab_viewMonth+1,0).getDate();

    for(let i=0;i<startIdx;i++){ $calendar_admin_details_create_cohort_add_time_tab_grid.append('<div></div>'); }
    for(let d=1; d<=daysInMonth; d++){
      const dateObj = new Date(calendar_admin_details_create_cohort_add_time_tab_viewYear, calendar_admin_details_create_cohort_add_time_tab_viewMonth, d);
      const $b = $('<button type="button" class="calendar_admin_details_create_cohort_add_time_tab_day"></button>').text(d);
      if (dateObj.toDateString() === calendar_admin_details_create_cohort_add_time_tab_tempSelected.toDateString()){
        $b.addClass('calendar_admin_details_create_cohort_add_time_tab_day--selected');
      }
      $b.on('click', function(){
        calendar_admin_details_create_cohort_add_time_tab_tempSelected = dateObj;
        $calendar_admin_details_create_cohort_add_time_tab_grid.find('.calendar_admin_details_create_cohort_add_time_tab_day--selected').removeClass('calendar_admin_details_create_cohort_add_time_tab_day--selected');
        $(this).addClass('calendar_admin_details_create_cohort_add_time_tab_day--selected');
      });
      $calendar_admin_details_create_cohort_add_time_tab_grid.append($b);
    }
  }

  // nav & done
  $('#calendar_admin_details_create_cohort_add_time_tab_prev').on('click', function(){
    calendar_admin_details_create_cohort_add_time_tab_viewMonth--;
    if(calendar_admin_details_create_cohort_add_time_tab_viewMonth<0){calendar_admin_details_create_cohort_add_time_tab_viewMonth=11;calendar_admin_details_create_cohort_add_time_tab_viewYear--;}
    calendar_admin_details_create_cohort_add_time_tab_renderCalendar();
  });
  $('#calendar_admin_details_create_cohort_add_time_tab_next').on('click', function(){
    calendar_admin_details_create_cohort_add_time_tab_viewMonth++;
    if(calendar_admin_details_create_cohort_add_time_tab_viewMonth>11){calendar_admin_details_create_cohort_add_time_tab_viewMonth=0;calendar_admin_details_create_cohort_add_time_tab_viewYear++;}
    calendar_admin_details_create_cohort_add_time_tab_renderCalendar();
  });
  $('#calendar_admin_details_create_cohort_add_time_tab_done').on('click', function(){
    if(!calendar_admin_details_create_cohort_add_time_tab_tempSelected) return;
    if(calendar_admin_details_create_cohort_add_time_tab_active_target==='from'){
      calendar_admin_details_create_cohort_add_time_tab_writeField(
        $('#calendar_admin_details_create_cohort_add_time_tab_from_btn'),
        $('#calendar_admin_details_create_cohort_add_time_tab_from_text'),
        calendar_admin_details_create_cohort_add_time_tab_tempSelected
      );
    }else{
      calendar_admin_details_create_cohort_add_time_tab_writeField(
        $('#calendar_admin_details_create_cohort_add_time_tab_until_btn'),
        $('#calendar_admin_details_create_cohort_add_time_tab_until_text'),
        calendar_admin_details_create_cohort_add_time_tab_tempSelected
      );
    }
    $calendar_admin_details_create_cohort_add_time_tab_backdrop.fadeOut(120,function(){ $(this).css('display','none'); });
  });
  $calendar_admin_details_create_cohort_add_time_tab_backdrop.on('click', function(e){
    if(e.target===this){ $(this).fadeOut(120,function(){ $(this).css('display','none'); }); }
  });

  // openers
  $('#calendar_admin_details_create_cohort_add_time_tab_from_btn').on('click', function(){
    calendar_admin_details_create_cohort_add_time_tab_openCalendar('from', calendar_admin_details_create_cohort_add_time_tab_readISO($(this)));
  });
  $('#calendar_admin_details_create_cohort_add_time_tab_until_btn').on('click', function(){
    calendar_admin_details_create_cohort_add_time_tab_openCalendar('until', calendar_admin_details_create_cohort_add_time_tab_readISO($(this)));
  });

  /* ========= TIME DROPDOWNS (using your OLD classes) ========= */
  function calendar_admin_details_create_cohort_add_time_tab_buildTimes(){
    const out=[]; const pad=n=>(n<10?'0':'')+n;
    for(let h=0;h<24;h++){ for(let m=0;m<60;m+=30){
      const h12=((h+11)%12)+1, ampm=h<12?'am':'pm'; out.push(`${h12}:${pad(m)} ${ampm}`.replace(':00',''));
    }}
    return out;
  }
  const calendar_admin_details_create_cohort_add_time_tab_allTimes = calendar_admin_details_create_cohort_add_time_tab_buildTimes();

  function calendar_admin_details_create_cohort_add_time_tab_attachTime($context){
    const $pill = $context.find('.custom-time-pill');
    const $input = $pill.find('.time-input');
    const $dd = $pill.find('.custom-time-dropdown');

    // build options once
    if(!$dd.data('built')){
      calendar_admin_details_create_cohort_add_time_tab_allTimes.forEach(t=>{
        const $b=$('<button type="button"></button>').text(t);
        $b.on('click', function(){ $input.val(t); $dd.hide(); });
        $dd.append($b);
      });
      $dd.data('built', true);
    }
    // toggle
    $pill.on('click', function(e){
      e.stopPropagation();
      $('.custom-time-dropdown').not($dd).hide();
      $dd.toggle();
    });
  }

  // attach to both rows (no time IDs used—only your old classes)
  calendar_admin_details_create_cohort_add_time_tab_attachTime($('#calendar_admin_details_create_cohort_add_time_tab_from_row'));
  calendar_admin_details_create_cohort_add_time_tab_attachTime($('#calendar_admin_details_create_cohort_add_time_tab_until_row'));

  // close time dropdowns on outside click
  $(document).on('click', function(){ $('.custom-time-dropdown').hide(); });
})(jQuery);
</script>














    <label class="addtime-checkbox-label" style="margin-top:15px;">
      <input type="checkbox" id="addTimeAllDay">
      All Day
    </label>
    <button type="submit" class="addtime-submit-btn">Schedule Time off</button>
  </form>
</div>


