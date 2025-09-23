  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="css/calendar_admin_details.css">
    <link rel="stylesheet" href="css/calendar_admin_details_calendar_content.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_tab_details.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_class_tab.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_merge_tab.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_add_time_tab.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort.css">

<div class="calendar_admin_main_wrapper">
  
    <!-- Sidebar -->
    <aside class="calendar_admin_sidebar">
      <button class="calendar_admin_btn calendar_admin_btn_active calendar_admin_details_create_cohort_open">Create Cohort</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_manage_cohort">Manage Cohort</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_merge">Merge Cohort</button>
      <button class="calendar_admin_btn calendar_admin_details_1_1_class">1:1 Class</button>
      <button class="calendar_admin_btn calendar_admin_details_conference">Conference</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_peer_talk">Peer talk</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_add_time_off">Add time off</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_add_extra_slots">Add Extra Slots</button>
      <a href="calendar_admin_details_setup_availablity.php"><button class="calendar_admin_btn">Setup Availability</button></a>
      <div class="calendar_admin_tags_section">
        <h3>Tags</h3>
        <ul class="calendar_admin_tags_list">
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_first"></span>First Student</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_student"></span>Student Class</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_cohort"></span>Cohort Class</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_conversation"></span>Conversational Class</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_busy"></span>Busy Time</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_google"></span>Google Calendar</li>
        </ul>
        <h3>Lesson status</h3>
        <ul class="calendar_admin_status_list">
          <li><span class="calendar_admin_status_icon calendar_admin_status_icon_confirmed"></span>Confirmed by the student</li>
          <li><span class="calendar_admin_status_icon calendar_admin_status_icon_not_confirmed"></span>Not confirmed by the student</li>
          <li><img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1F501.svg" style="width:14px;margin-right:6px;vertical-align:middle;">Weekly Class</li>
          <li><img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1F4C5.svg" style="width:14px;margin-right:6px;vertical-align:middle;">Single class</li>
        </ul>
      </div>
    </aside>




  <!-- Calendar Main -->
  <main class="calendar_admin_calendar_outer">
      <!-- Header -->
    <div class="calendar_admin_calendar_header">


      <button class="calendar_arrow_btn" id="prev-week">
        <svg width="20" height="20" viewBox="0 0 24 24">
          <polyline points="15 19 8 12 15 5" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      <button class="calendar_arrow_btn" id="next-week">
        <svg width="20" height="20" viewBox="0 0 24 24">
          <polyline points="9 5 16 12 9 19" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      
   <span class="calendar_admin_calendar_title" id="calendar-range"></span>



 

      <!-- <div class="calendar-topbar2">
    <div class="calendar-arrows arrow-btns">
      <div class="calendar-arrow arrow-btn" id="prev-week">&#x2039;</div>
      <div class="calendar-arrow arrow-btn" id="next-week">&#x203A;</div>
    </div> -->


  <div class="calendar_admin_header_section">
      <div class="cohort-select dropdown" id="cohort-select">
        <span class="cohort-icon">&#9776;</span>
        Cohorts
        <span class="dropdown-arrow"><i class="fa fa-chevron-down" style="font-size:14px;"></i></span>
        <div class="dropdown-menu" id="cohort-dropdown">
          <form class="cohort-dropdown-list">
            <label><input type="checkbox" id="select-all-cohorts"> Select All</label>
            <label><input type="checkbox" name="cohort" value="FL1"> FL1</label>
            <label><input type="checkbox" name="cohort" value="FL2"> FL2</label>
            <label><input type="checkbox" name="cohort" value="TX1"> TX1</label>
            <label><input type="checkbox" name="cohort" value="TX2"> TX2</label>
          </form>
        </div>
      </div>


      <!-- Profile Dropdown -->
      <div class="profile-dropdown profile-dropdown-trigger" id="profile-dropdown-trigger">
        <img src="https://randomuser.me/api/portraits/women/15.jpg" class="profile-pic" alt="profile">
        dlinela
        <span class="dropdown-arrow"><i class="fa fa-chevron-down" style="font-size:14px;"></i></span>
        <div class="dropdown-menu profile-menu" id="profile-dropdown">
          <div class="profile-dropdown-list">
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/men/32.jpg"> Edwards</div></div>
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/women/15.jpg"> Daniela</div></div>
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/men/15.jpg"> Hawkins</div></div>
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/men/45.jpg"> Warren</div></div>
          </div>
        </div>
      </div>
       <?php require_once('calendar_admin_details_tabs.php'); ?>
        </div>
      </div>





<!--============Calendar Content start======================-->
<style>
  /* Force selected empty slots to be white */
#grid .day .day-inner .slots > div.slot-white{
  background:#fff !important;
}

</style>


<div class="wrap" id="calendar_admin_calendar_flexrow">
  <div class="cal">
    <div id="head" class="cal-head"><div class="gutter"></div></div>
    <div id="grid" class="grid">
      <div id="gutter" class="gutter"></div>
    </div>
  </div>
</div>
<!--============Calendar Content end======================-->

<?php require_once('calendar_admin_details_agenda_tab.php'); ?>

    </main>
  </div>



<script>
$(function() {
  // On "Semana" button click
  $('#calendar_admin_semana_btn').on('click', function() {
    $('#calendar_admin_semana_btn').addClass('active');
    $('#calendar_admin_agenda_btn').removeClass('active');

    $('#calendar_admin_calendar_flexrow').show();
    $('#calendar_admin_agenda_content').hide();
  });

  // On "Agenda" button click
  $('#calendar_admin_agenda_btn').on('click', function() {
    $('#calendar_admin_agenda_btn').addClass('active');
    $('#calendar_admin_semana_btn').removeClass('active');

    $('#calendar_admin_calendar_flexrow').hide();
    $('#calendar_admin_agenda_content').show();
  });
});
</script>

<script src="js/calendar_admin_details.js"></script>
<script src="js/calendar_admin_details_calendar_content.js"></script>
<?php require_once('calendar_admin_details_create_cohort.php'); ?>
<script src="js/calendar_admin_details_create_cohort_tab_details.js"></script>
<script src="js/calendar_admin_details_create_cohort_class_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_merge_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_add_time_tab.js"></script>

<script src="js/calendar_admin_details_create_cohort.js"></script>
<?php require_once('calendar_admin_details_time_off.php'); ?>
<?php require_once('calendar_admin_details_lesson_information.php'); ?>  

