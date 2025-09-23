  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body { font-family: Arial, sans-serif; }
    #calendar_admin_details_create_cohort_modal_backdrop {
      display: none; position: fixed; z-index: 1000;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,.6);
    }
    #calendar_admin_details_create_cohort_modal {
      background: #fff;
      width: 95%; max-width: 570px; max-height: 93vh;
      margin: 5vh auto; border-radius: 12px;
      padding: 28px 20px 20px 20px;
      overflow-y: auto; position: relative;
      box-shadow: 0 10px 36px 0 rgba(0,0,0,.17);
    }
    .calendar_admin_details_create_cohort_close {
      position: absolute; top: 16px; right: 15px;
      font-size: 22px; cursor: pointer; font-weight: bold; color: #222;
    }
    h2 { margin: 10px 0 0 0; font-size: 1.35rem; font-weight: bold; }
    .calendar_admin_details_create_cohort_tabs_scroll {
      overflow-x: auto;
      white-space: nowrap;
      border-bottom: 1px solid #ececec;
      margin: 18px 0 20px 0;
      padding-bottom: 2px;
      -webkit-overflow-scrolling: touch;
    }
    .calendar_admin_details_create_cohort_tabs {
      display: inline-flex; gap: 15px;
    }
    .calendar_admin_details_create_cohort_tab {
      display: inline-block;
      padding: 8px 12px 10px 12px; cursor: pointer; font-size: 1.03rem;
      color: #989898;
      border: none; background: none;
      font-weight: 500;
      transition: color 0.2s, border-bottom 0.2s;
    }
    .calendar_admin_details_create_cohort_tab.active {
      border-bottom: 3px solid #fe2e0c; color: #fe2e0c; font-weight: bold;
    }
    .calendar_admin_details_create_cohort_tabs_scroll::-webkit-scrollbar {height:4px;background:#ececec;}
    .calendar_admin_details_create_cohort_tabs_scroll::-webkit-scrollbar-thumb {background:#d1d1d1; border-radius:2px;}
    .calendar_admin_details_create_cohort_content {
      margin-top: 5px;
      animation: fadeIn .19s;
    }








    @keyframes fadeIn {from{opacity:0;}to{opacity:1;}}
    /* Conference Content (scoped styles) */
    .conference_modal_schedule {
      display: flex; align-items: center; gap: 7px;
      color: #b5b5b5; font-size: 1.07rem; font-weight: 600;
      margin-bottom: 7px;
    }
    .conference_modal_schedule input[type="checkbox"] {
      accent-color: #dadada; width: 19px; height: 19px; margin: 0 5px 0 0;
    }
    .conference_modal_repeat_row {
      display: flex; align-items: center; gap: 15px; margin-bottom: 7px;
    }
    .conference_modal_repeat_btn {
      padding: 11px 13px;
      border-radius: 8px 8px 0 0;
      border: none; border-bottom: 2.5px solid #fe2e0c;
      background: none; color: #232323; font-weight: 600; font-size: 1rem;
      min-width: 153px;
    }
    .conference_modal_date_btn {
      background: #fff; border: 2px solid #dadada; border-radius: 24px;
      padding: 10px 20px; font-size: 1.05rem; font-weight: 500;
      min-width: 123px; margin: 0 0 0 0;
      margin-right: 10px; cursor: pointer;
    }
    .conference_modal_time_btn,
    .calendar_admin_details_create_cohort_time_btn {
        flex: 1 1 0;
        background: #fff;
        border: 2px solid #232323;
        border-radius: 18px;
        padding: 12px 0;
        font-size: 15px;
        text-align: center;
        cursor: pointer;
        min-width: 95px;
        margin-top: 10px;

    }
    .conference_modal_time_btn.selected,
    .calendar_admin_details_create_cohort_time_btn.selected {
      border: 2px solid #fe2e0c; color: #fe2e0c; background: #fff4f1;
    }


    
    .conference_modal_findtime_link {
      color: #064ae6; font-size: 1.06rem; text-decoration: none; font-weight: 500;
    }
    .conference_modal_findtime_circle {
      width: 30px; height: 30px; background: #1736e6; border-radius: 50%; display: inline-block; border: 2.3px solid #1736e6;
    }
    .conference_modal_timezone {
      width: 100%; padding: 12px 13px;
      border-radius: 10px; border: 1.4px solid #dadada;
      background: #fafbfc; font-size: 1.02rem; margin-bottom: 13px;
      color: #6d6d6d;
    }
    .conference_modal_fieldrow {
      display: flex; flex-wrap: wrap; gap: 13px;
      margin-bottom: 18px;
    }
    .conference_modal_fieldrow > div {
      flex: 1 1 47%; min-width: 150px; position: relative;
    }
    .conference_modal_label {
      font-size: 1rem; font-weight: 500; color: #232323; margin-bottom: 4px; display: block;
    }
    /* .conference_modal_dropdown_btn {
      width: 100%; padding: 13px 14px;
      border: 1.5px solid #dadada;
      border-radius: 10px; background: #fff;
      font-size: 1.02rem; text-align: left;
      cursor: pointer; position: relative;
      display: flex; align-items: center; justify-content: space-between;
    }
    .conference_modal_dropdown_btn svg {
      width: 18px; height: 18px; margin-left: auto; fill: #aaa;
    } */
    .conference_modal_dropdown_list {
      display: none; position: absolute; top: 100%; left: 0; width: 100%;
      background: #fff; border: 1.5px solid #dadada;
      border-radius: 11px; box-shadow: 0 4px 18px #0001;
      z-index: 100; margin-top: 1px;
    }
    .conference_modal_dropdown_list ul { list-style: none; padding: 0; margin: 0; }
    .conference_modal_dropdown_list li {
      padding: 13px 18px; font-size: 1rem;
      cursor: pointer; border-radius: 8px;
      transition: background 0.18s;
      display: flex; align-items: center; gap: 10px;
    }
    .conference_modal_dropdown_list li:hover {
      background: #f7f7f7; color: #fe2e0c;
    }
    .conference_modal_teacher_avatar {
      width: 38px; height: 38px; border-radius: 50%; object-fit: cover; background: #eaeaea; border: 1.2px solid #ececec;
    }
    .conference_modal_attendees_section {margin: 18px 0 9px 0;}
    .conference_modal_attendees_list {
      background: #fff; border-radius: 12px; box-shadow: 0 2px 11px #0002;
      padding: 0; margin: 0; list-style: none;
    }
    .conference_modal_attendee {
      display: flex; align-items: center; gap: 13px;
      padding: 12px 16px; border-bottom: 1px solid #f1f1f1;
      font-size: 1.02rem; background: #fff;
    }
    .conference_modal_attendee:last-child { border-bottom: none; }
    .conference_modal_cohort_chip {
      background: #d6e8cf; color: #497b26; font-weight: 700; font-size: 1rem;
      padding: 7px 13px; border-radius: 50px; margin-right: 7px;
      display: flex; align-items: center; min-width: 35px; justify-content: center;
    }
    .conference_modal_attendee_name { font-weight: 600; }
    .conference_modal_icon {
      font-size: 1.3rem; color: #626262; margin-left: auto; margin-right: 6px;
      display: flex; align-items: center;
    }
    .conference_modal_icon.user { font-size: 1.17rem; }
    .conference_modal_remove { color: #c53c2a; cursor: pointer; font-size: 1.5rem; margin-left: 8px; }
    .conference_modal_btn {
      width: 100%; background-color: #fe2e0c; color: white; padding: 15px 0;
      border: none; font-weight: bold; font-size: 1.11rem; margin-top: 18px;
      border-radius: 9px; cursor: pointer; letter-spacing: .5px;
      box-shadow: 0 3px 13px 0 rgba(254,46,12,.07);
    }









    /* Time Picker Modal Styles */
    .calendar_admin_details_create_cohort_time_modal_backdrop {
      display: none; position: fixed; z-index: 3001; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.08);
    }
    .calendar_admin_details_create_cohort_time_modal {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 24px 0 rgba(0,0,0,.14);
      width: 210px;
      max-width: 98vw;
      max-height: 72vh;
      overflow-y: auto;
      padding: 0;
      position: absolute;
      left: 50%; transform: translateX(-50%);
      margin-top: 8px;
      animation: fadeIn .16s;
      border: 1.5px solid #eaeaea;
    }
    .calendar_admin_details_create_cohort_time_modal ul { list-style: none; margin: 0; padding: 0; }
    .calendar_admin_details_create_cohort_time_modal li {
      font-size: 1.13rem; padding: 14px 28px; cursor: pointer; transition: background .15s, color .15s;
      border-radius: 0;
      text-align: left; color: #232323;
    }
    .calendar_admin_details_create_cohort_time_modal li:hover,
    .calendar_admin_details_create_cohort_time_modal li.selected {
      background: #f7f7f7; color: #fe2e0c;
    }
    @media(max-width: 600px){
      .calendar_admin_details_create_cohort_time_modal {
        width: 96vw; padding: 0; font-size: 1rem;
      }
      .calendar_admin_details_create_cohort_time_modal li { padding: 12px 10vw; }
    }
    /* All your previous styles remain below! */
    .calendar_admin_details_create_cohort_row {display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 13px;}
    .calendar_admin_details_create_cohort_row > div {flex: 1 1 45%; position: relative;}
    .calendar_admin_details_create_cohort_dropdown_wrapper,
    .calendar_admin_details_create_cohort_teacher_dropdown_wrapper,
    .calendar_admin_details_create_cohort_class_dropdown_wrapper,
    .calendar_admin_details_create_cohort_shortname_dropdown_wrapper {position: relative; margin-bottom: 12px;}
    .calendar_admin_details_create_cohort_dropdown_btn,
    .calendar_admin_details_create_cohort_shortname_btn,
    .calendar_admin_details_create_cohort_teacher_btn,
    .calendar_admin_details_create_cohort_class_btn {
      width: 100%; padding: 12px 14px;
      border: 1.5px solid #232323; border-radius: 8px; background: #fff;
      cursor: pointer; font-size: 1rem; text-align: left;
      position: relative; box-sizing: border-box;
      display: flex; align-items: center; justify-content: space-between;
    }
    .calendar_admin_details_create_cohort_dropdown_btn svg,
    .calendar_admin_details_create_cohort_shortname_btn svg,
    .calendar_admin_details_create_cohort_teacher_btn svg,
    .calendar_admin_details_create_cohort_class_btn svg {
      width: 19px; height: 19px; margin-left: auto;
      fill: #232323; flex-shrink: 0;
    }

 /* --- Improved Dropdowns for Cohort & Short Name --- */
.calendar_admin_details_create_cohort_dropdown_list,
.calendar_admin_details_create_cohort_shortname_list {
  display: none;
  position: absolute;
  top: 108%;
  left: 0;
  width: 290px;        /* Wider for readability */
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 5px 24px 0 rgba(0,0,0,0.14);
  border: none;
  padding: 16px 0 18px 0;
  z-index: 60;
}

.calendar_admin_details_create_cohort_dropdown_list button[type="button"],
.calendar_admin_details_create_cohort_create_btn {
  display: block;
  width: 92%;
  margin: 0 auto 14px auto;
  padding: 12px 0;
  background: #fe2e0c;
  color: #fff;
  font-size: 1.13rem;
  font-weight: bold;
  border: 2px solid #c72d0c;
  border-radius: 11px;
  cursor: pointer;
  transition: background .15s, color .15s;
  box-shadow: 0 2px 8px #f33c1a18;
}
.calendar_admin_details_create_cohort_dropdown_list button[type="button"]:hover,
.calendar_admin_details_create_cohort_create_btn:hover {
  background: #b82209;
}

.calendar_admin_details_create_cohort_dropdown_list strong {
  font-size: 1.29rem;
  font-weight: 700;
  color: #232323;
  margin-left: 26px;
  margin-bottom: 12px;
  display: block;
  letter-spacing: .02em;
}

.calendar_admin_details_create_cohort_dropdown_list ul,
.calendar_admin_details_create_cohort_shortname_list ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.calendar_admin_details_create_cohort_dropdown_list li,
.calendar_admin_details_create_cohort_shortname_list li {
  padding: 14px 28px;
  font-size: 1.10rem;
  color: #232323;
  cursor: pointer;
  border-radius: 8px;
  font-weight: 500;
  transition: background .15s, color .12s;
  margin-bottom: 3px;
}

.calendar_admin_details_create_cohort_dropdown_list li:hover,
.calendar_admin_details_create_cohort_shortname_list li:hover {
  background: #f7f7f7;
  color: #fe2e0c;
}

/* Arrow animation for dropdown button */
.calendar_admin_details_create_cohort_dropdown_btn svg,
.calendar_admin_details_create_cohort_shortname_btn svg {
  margin-left: 9px;
  transition: transform .19s;
}
.calendar_admin_details_create_cohort_dropdown_btn.active svg,
.calendar_admin_details_create_cohort_shortname_btn.active svg {
  transform: rotate(180deg);
}

/* Make sure buttons are not stretched if container is narrow */
@media (max-width: 450px) {
  .calendar_admin_details_create_cohort_dropdown_list,
  .calendar_admin_details_create_cohort_shortname_list {
    width: 95vw;
    left: 50%;
    transform: translateX(-50%);
    min-width: 0;
    padding-left: 0;
    padding-right: 0;
  }
  .calendar_admin_details_create_cohort_dropdown_list li,
  .calendar_admin_details_create_cohort_shortname_list li {
    padding: 14px 8vw;
  }
}

    .calendar_admin_details_create_cohort_dropdown_list,
    .calendar_admin_details_create_cohort_shortname_list,
    .calendar_admin_details_create_cohort_teacher_list,
    .calendar_admin_details_create_cohort_class_list {
      position: absolute; top: 100%; left: 0;
      width: 100%; min-width: 180px; max-height: 290px; overflow-y: auto;
      background: #fff; border: 1.5px solid #232323;
      border-radius: 10px; box-shadow: 0px 4px 16px rgba(0,0,0,0.14);
      z-index: 40; display: none;
      padding: 8px 0 8px 0; margin-top: 0; box-sizing: border-box;
    }
    .calendar_admin_details_create_cohort_teacher_list li {
      display: flex; align-items: center; gap: 11px;
      padding: 10px 14px; border-radius: 8px; font-size: 1rem; cursor: pointer; transition: background 0.18s;
    }
    .calendar_admin_details_create_cohort_teacher_list li:hover {background: #f7f7f7; color: #fe2e0c;}
    .calendar_admin_details_create_cohort_teacher_avatar {
      width: 38px; height: 38px; border-radius: 50%;
      object-fit: cover; background: #eaeaea; border: 1.2px solid #ececec;
    }
    .calendar_admin_details_create_cohort_time_btn.selected {border: 2px solid #fe2e0c; color: #fe2e0c; background: #fff4f1;}
    label { font-size: .97rem; font-weight: 500; color: #232323; }


/*     
    .calendar_admin_details_create_cohort_event_nav {
      display: flex; align-items: center; justify-content: center; gap: 18px; margin: 18px 0 13px 0;
      font-size: 1.07rem; font-weight: 600;
    }
    .calendar_admin_details_create_cohort_event_nav button {
      background: #fff; border: 1.1px solid #ccc; border-radius: 7px; padding: 4px 12px;
      font-weight: 600; font-size: 1.14rem; color: #232323; cursor: pointer; outline: none; transition: background .16s;
    }
     */
    /* .calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_add {
      color: #fff; background: #fe2e0c; border: none; font-size: 1.3rem; border-radius: 50%; width: 34px; height: 34px; padding: 0;
      display: flex; align-items: center; justify-content: center; margin-left: 6px; box-shadow: 0 2px 8px rgba(254,46,12,0.10);
    } */

    select, input[type="text"], input[type="date"] {
      width: 100%; padding: 9px; border-radius: 5px; border: 1px solid #ccc;
      font-size: 1rem; margin-top: 2px; margin-bottom: 6px;
    }
    .calendar_admin_details_create_cohort_find-time {
      display: flex; gap: 10px; align-items: center; margin: 5px 0 0 0;
    }
    .calendar_admin_details_create_cohort_find-time a {
      color: #064ae6; font-size: 1.03rem; text-decoration: none; font-weight: 500;
    }
    .calendar_admin_details_create_cohort_circle-dropdown {
      width: 26px; height: 26px; background: #1736e6;
      border-radius: 50%; display: inline-block; position: relative; cursor: pointer; border: 2px solid #1736e6;
    }











    .calendar_admin_details_create_cohort_bottom {
      display: flex; gap: 16px; 
      /* justify-content: space-between; */
      align-items: center; margin: 20px 0 10px 0;
    }
    .calendar_admin_details_create_cohort_switch {
      display: flex; align-items: center; gap: 9px; font-size: 1.07rem;
    }
    .calendar_admin_details_create_cohort_toggle {
      width: 43px; height: 24px; background: #ededed; border-radius: 20px; position: relative; cursor: pointer; transition: background 0.2s; border: 1.5px solid #ddd;
    }
    .calendar_admin_details_create_cohort_toggle::before {
      content: ''; width: 21px; height: 21px; background: #fff; position: absolute; top: 1px; left: 1px; border-radius: 50%; transition: all 0.28s; box-shadow: 0 1px 6px 0 rgba(0,0,0,.07);
    }
    .calendar_admin_details_create_cohort_toggle.active {background: #fe2e0c; border-color: #fe2e0c;}
    .calendar_admin_details_create_cohort_toggle.active::before {left: 21px;}








    .calendar_admin_details_create_cohort_btn {
      width: 100%; background-color: #fe2e0c; color: white; padding: 15px 0;
      border: none; font-weight: bold; font-size: 1.11rem; margin-top: 13px;
      border-radius: 9px; cursor: pointer; letter-spacing: .5px;
      box-shadow: 0 3px 13px 0 rgba(254,46,12,.07);
    }
    /* Calendar modal styles ... */
    .calendar_admin_details_create_cohort_calendar_modal_backdrop {
      display: none; position: fixed; z-index: 2050;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.11);
    }
    .calendar_admin_details_create_cohort_calendar_modal {
      background: #fff;
      border-radius: 13px;
      box-shadow: 0 10px 36px 0 rgba(0,0,0,.16);
      width: 340px;
      padding: 20px 18px 18px 18px;
      position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
      max-width: 96vw;
    }
    .calendar_admin_details_create_cohort_calendar_nav {
      display: flex; align-items: center; justify-content: space-between;
      font-size: 1.18rem; font-weight: 600;
      margin-bottom: 10px;
    }
    .calendar_admin_details_create_cohort_calendar_nav button {
      background: #fafafa; border: none; font-size: 1.45rem; border-radius: 7px;
      padding: 2px 13px; cursor: pointer; color: #222;
      transition: background .15s;
    }
    .calendar_admin_details_create_cohort_calendar_nav button:hover {
      background: #ececec;
    }
    .calendar_admin_details_create_cohort_calendar_days {
      display: grid; grid-template-columns: repeat(7,1fr); gap: 3px;
      text-align: center; font-size: 1.07rem; margin-bottom: 10px;
    }
    .calendar_admin_details_create_cohort_calendar_day_header {
      color: #b2b2b2; font-weight: 600; padding: 7px 0 4px 0;
    }
    .calendar_admin_details_create_cohort_calendar_day,
    .calendar_admin_details_create_cohort_calendar_day_inactive {
      padding: 11px 0;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1.11rem;
      font-weight: 500;
      transition: background .15s, color .15s, border .17s;
    }
    .calendar_admin_details_create_cohort_calendar_day_inactive {
      color: #bdbdbd; background: #fafafa; cursor: not-allowed;
    }
    .calendar_admin_details_create_cohort_calendar_day.selected {
      border: 2px solid #fe2e0c;
      color: #fe2e0c;
      background: #fff;
      font-weight: 700;
    }
    .calendar_admin_details_create_cohort_calendar_done_btn {
      width: 100%; background: #fe2e0c; color: #fff; font-weight: bold;
      border: none; border-radius: 8px; padding: 12px 0; margin-top: 14px; font-size: 1.12rem;
      cursor: pointer; box-shadow: 0 3px 11px 0 rgba(254,46,12,.07);
    }
    @media(max-width:600px){
      #calendar_admin_details_create_cohort_modal {padding: 16px 2vw;}
      .calendar_admin_details_create_cohort_row > div {flex: 1 1 100%;}
      .calendar_admin_details_create_cohort_tabs {font-size: .97rem;}
      .conference_modal_fieldrow {flex-direction: column; gap: 8px;}
      .calendar_admin_details_create_cohort_calendar_modal {width:96vw;padding:13px 1vw;}
    }

.color-dropdown-wrapper {
  display: inline-block;
  position: relative;
  margin-left: 10px;
  vertical-align: middle;
}
.color-dropdown-toggle {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 54px;
  height: 32px;
  border: 2px solid #232323;
  border-radius: 18px;
  background: #fff;
  padding: 3px 8px 3px 3px;
  cursor: pointer;
  transition: border .15s;
  position: relative;
}
.color-dropdown-toggle .color-circle {
  width: 22px; height: 22px; border-radius: 50%;
  display: inline-block;
  border: none;
}
.color-dropdown-toggle .color-dropdown-arrow {
  margin-left: 5px;
  transition: transform .16s;
}
.color-dropdown-toggle.active .color-dropdown-arrow {
  transform: rotate(180deg);
}
.color-dropdown-list {
  display: none;
  position: absolute;
  top: 115%;
  left: 50%;
  transform: translateX(-50%);
  min-width: 54px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 5px 18px #0001;
  padding: 13px 8px 13px 8px;
  z-index: 101;
}
.color-dropdown-color {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  margin: 8px auto;
  cursor: pointer;
  border: 2.2px solid transparent;
  transition: border .15s;
}
.color-dropdown-color:hover,
.color-dropdown-color.selected {
  border: 2.2px solid #fe2e0c;
}
@media(max-width:600px){
  .color-dropdown-list { min-width: 46px; }
  .color-dropdown-toggle { width: 44px; height: 28px; }
  .color-dropdown-color { width: 22px; height: 22px; }
}




.conference_modal_lists_row {
  display: flex;
  gap: 28px;
  justify-content: space-between;
  align-items: flex-start;
}
.conference_modal_lists_row > .conference_modal_attendees_section {
  flex: 1 1 0;
}
.conference_modal_cohort_list,
.conference_modal_attendees_list {
  background: #fff; border-radius: 12px; box-shadow: 0 2px 11px #0002;
  padding: 0; margin: 0; list-style: none; min-height: 42px;
}
.conference_modal_cohort_list li,
.conference_modal_attendees_list li {
  display: flex; align-items: center; gap: 13px;
  padding: 12px 16px; border-bottom: 1px solid #f1f1f1;
  font-size: 1.02rem; background: #fff;
}
.conference_modal_cohort_list li:last-child,
.conference_modal_attendees_list li:last-child { border-bottom: none; }
@media (max-width: 600px) {
  .conference_modal_lists_row {
    flex-direction: column;
    gap: 13px;
  }
}




.cohort_schedule_row {
  display: flex;
  gap: 24px;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 16px;
}
.cohort_schedule_box {
  flex: 1 1 0;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.cohort_schedule_header {
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 7px;
  color: #8d9299;
}
.cohort_schedule_icon {
  width: 24px; height: 24px;
  background: #f3f4f6;
  color: #888;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-size: 1.1rem;
  border: 1.5px solid #e3e3e3;
  margin-right: 3px;
}
.cohort_schedule_btn {
  width: 100%;
  background: transparent;
  border: none;
  border-bottom: 2px solid #fe2e0c;
  padding: 10px 12px 10px 0;
  font-size: 1.08rem;
  color: #232323;
  font-weight: 500;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  outline: none;
  transition: border .15s;
}
.cohort_schedule_btn:focus {
  border-bottom: 2px solid #1736e6;
}
.cohort_schedule_arrow {
  font-size: 1.1rem;
  margin-left: 8px;
  color: #bdbdbd;
}
@media (max-width: 600px) {
  .cohort_schedule_row {
    flex-direction: column;
    gap: 13px;
  }
}




.calendar_admin_details_cohort_tab_time_buttons_row {
  display: flex;
  align-items: center;
  gap: 0;
  width: 100%;
}

.calendar_admin_details_cohort_tab_time_btn_1 {
  flex: 1 1 0;
  background: #fff;
  border: 2px solid #232323;
  border-radius: 18px;
  padding: 12px 0;
  font-size: 15px;
  text-align: center;
  cursor: pointer;
  min-width: 95px;
  margin-top: 10px;
}

.calendar_admin_details_cohort_tab_time_divider {
  width: 15px;         /* Adjust width to your need */
  height: 1px;
  background: #ff3c1a; /* Or #fe2e0c if you use that elsewhere */
  margin: 0 4px;
  border-radius: 2px;
  margin-top:15px;
}


<style>
.calendar_admin_details_cohort_tab_timezone_wrapper {
  margin-top: 10px;
  width: 100%;
}
.calendar_admin_details_cohort_tab_timezone_label {
  display: block;
  margin-bottom: 3px;
  font-size: 1rem;
  color: #232323;
  font-weight: 500;
}
.calendar_admin_details_cohort_tab_timezone_dropdown {
  position: relative;
  width: 100%;
  background: #fafbfc;
  border: 1.6px solid #dadada;
  border-radius: 11px;
  display: flex;
  align-items: center;
  padding: 13px 15px;
  cursor: pointer;
  font-size: 1.04rem;
  transition: border .15s;
  min-width: 180px;
  color: #787878;
}
.calendar_admin_details_cohort_tab_timezone_arrow {
  margin-left: auto;
  pointer-events: none;
}
.calendar_admin_details_cohort_tab_timezone_list {
  display: none;
  position: absolute;
  left: 0;
  top: 110%;
  width: 100%;
  background: #fff;
  border-radius: 13px;
  box-shadow: 0 5px 18px #0001;
  border: 1.3px solid #dadada;
  z-index: 15;
  max-height: 250px;
  overflow-y: auto;
}
.calendar_admin_details_cohort_tab_timezone_list ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.calendar_admin_details_cohort_tab_timezone_list li {
  padding: 13px 19px;
  cursor: pointer;
  font-size: 1rem;
  color: #232323;
  border-radius: 7px;
  transition: background .13s;
}
.calendar_admin_details_cohort_tab_timezone_list li:hover,
.calendar_admin_details_cohort_tab_timezone_list li.selected {
  background: #f7f7f7;
  color: #fe2e0c;
}


.calendar_admin_details_cohort_tab_timezone_wrapper_right {
  margin-top: 10px;
  width: 100%;
}
.calendar_admin_details_cohort_tab_timezone_label_right {
  display: block;
  margin-bottom: 3px;
  font-size: 1rem;
  color: #232323;
  font-weight: 500;
}
.calendar_admin_details_cohort_tab_timezone_dropdown_right {
  position: relative;
  width: 100%;
  background: #fafbfc;
  border: 1.6px solid #dadada;
  border-radius: 11px;
  display: flex;
  align-items: center;
  padding: 13px 15px;
  cursor: pointer;
  font-size: 1.04rem;
  transition: border .15s;
  min-width: 180px;
  color: #787878;
}
.calendar_admin_details_cohort_tab_timezone_arrow_right {
  margin-left: auto;
  pointer-events: none;
}
.calendar_admin_details_cohort_tab_timezone_list_right {
  display: none;
  position: absolute;
  left: 0;
  top: 110%;
  width: 100%;
  background: #fff;
  border-radius: 13px;
  box-shadow: 0 5px 18px #0001;
  border: 1.3px solid #dadada;
  z-index: 15;
  max-height: 250px;
  overflow-y: auto;
}
.calendar_admin_details_cohort_tab_timezone_list_right ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.calendar_admin_details_cohort_tab_timezone_list_right li {
  padding: 13px 19px;
  cursor: pointer;
  font-size: 1rem;
  color: #232323;
  border-radius: 7px;
  transition: background .13s;
}
.calendar_admin_details_cohort_tab_timezone_list_right li:hover,
.calendar_admin_details_cohort_tab_timezone_list_right li.selected {
  background: #f7f7f7;
  color: #fe2e0c;
}












</style>


  <!-- <div id="calendar_admin_details_create_cohort_modal_backdrop">
    <div id="calendar_admin_details_create_cohort_modal"> -->

      <div class="calendar_admin_details_create_cohort_content tab-content" id="manage_cohort_tab_content" style="display:none;">
        <div class="calendar_admin_details_create_cohort_row">
          <div class="calendar_admin_details_create_cohort_dropdown_wrapper">
            <label>Cohort</label>
            <div class="calendar_admin_details_create_cohort_dropdown_btn" id="cohortDropdownBtn">
              Select Existing Cohort
              <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
            </div>
            <div class="calendar_admin_details_create_cohort_dropdown_list" id="cohortDropdownList">
              <!-- <button type="button">Create Cohort</button> -->
              <strong>Existing Cohorts</strong>
              <ul>
                <li>FII-1–030423–0090</li>
                <li>OH–12–032023–0089</li>
                <li>NY–2–042522–0088</li>
                <li>OH–12–032023–0089</li>
                <li>TX–1–030423–0090</li>
              </ul>
            </div>
          </div>
          <div class="calendar_admin_details_create_cohort_shortname_dropdown_wrapper">
            <label>Cohort’s Short Name</label>
            <div class="calendar_admin_details_create_cohort_shortname_btn" id="shortNameDropdownBtn">
              XX#
              <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
            </div>
            <div class="calendar_admin_details_create_cohort_shortname_list" id="shortNameDropdownList">
              <ul>
                <li>TX1</li>
                <li>FL6</li>
                <li>OHI2</li>
                <li>NY2</li>
                <li>FL1</li>
              </ul>
            </div>
          </div>
        </div>













        <!-- Event navigation -->        
        <div class="calendar_admin_details_create_cohort_event_nav">
          <div class="calendar_event_group">
            <button type="button" class="calendar_event_nav_btn prev" aria-label="Previous">
              <svg viewBox="0 0 24 24"><polyline points="15 19 8 12 15 5" stroke="currentColor" stroke-width="2.2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <span class="calendar_event_nav_title">Events</span>

            <button type="button" class="calendar_event_nav_btn next" aria-label="Next">
              <svg viewBox="0 0 24 24"><polyline points="9 5 16 12 9 19" stroke="currentColor" stroke-width="2.2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>

          <!-- this keeps the red + visible on the far right -->
          <button type="button" class="calendar_admin_details_create_cohort_add">+</button>

            <!-- NEW: delete button -->
            <button type="button" class="calendar_admin_details_create_cohort_remove" aria-label="Remove last teacher">
              <!-- trash icon -->
              <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                <path d="M9 3h6a1 1 0 0 1 1 1v1h4v2h-1v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7H4V5h4V4a1 1 0 0 1 1-1Zm1 2v0h4V4h-4v1Zm-2 2v12h8V7H8Zm2 2h2v8h-2V9Zm4 0h2v8h-2V9Z"/>
              </svg>
            </button>
        </div>












<!-- 2-up teacher carousel -->
<div class="calendar_admin_details_create_cohort_row" id="teacherBlocks">
  <!-- Teacher 1 -->
  <div class="teacher-block" data-teacher="1">
    <div>
      <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
        <label>Teacher 1</label>
        <div class="calendar_admin_details_create_cohort_teacher_btn" id="teacher1DropdownBtn">
          Select Teacher
          <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
        </div>
        <div class="calendar_admin_details_create_cohort_teacher_list" id="teacher1DropdownList">
          <ul>
            <li><img src="https://randomuser.me/api/portraits/men/11.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"> <span style="margin-left:10px;">Edwards</span></li>
            <li><img src="https://randomuser.me/api/portraits/women/44.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px;"> Daniela</span></li>
            <li><img src="https://randomuser.me/api/portraits/men/31.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px;">Hawkins</span></li>
            <li><img src="https://randomuser.me/api/portraits/men/32.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px;"> Lane</span></li>
            <li><img src="https://randomuser.me/api/portraits/men/33.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px;">Warren</span></li>
            <li><img src="https://randomuser.me/api/portraits/men/52.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px;"> Fox</span></li>
          </ul>
        </div>
      </div>

      <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
        <label>Class Name</label>
          <div class="calendar_admin_details_create_cohort_class_btn" id="className1DropdownBtn">
            Select Class
            <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
          </div>

        <div class="calendar_admin_details_create_cohort_class_list" id="className1DropdownList">
          <ul>
            <li>Main Class</li>
            <li>Tutoring Class</li>
            <li>Conversational Class</li>
          </ul>
        </div>
      </div>









      <div class="cohort_schedule_box">
        <div class="cohort_schedule_header">
          <span class="cohort_schedule_icon">&#9432;</span>
          <span>Class Schedule</span>
        </div>
        <button type="button" class="cohort_schedule_btn">
          Does not repeat
          <span class="cohort_schedule_arrow">&#9660;</span>
        </button>
      </div>



      
      <div class="d-flex" id="customTimeFields" style="margin-top: 10px;">
        <div class="custom-time-pill">
          <input type="text" class="form-control time-input" value="9:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
          <div class="custom-time-dropdown"></div>
        </div>
        <div class="time-dash">–</div>
        <div class="custom-time-pill">
          <input type="text" class="form-control time-input" value="10:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
          <div class="custom-time-dropdown"></div>
        </div>
      </div>





        <div class="calendar_admin_details_cohort_tab_timezone_wrapper_right">
          <label class="calendar_admin_details_cohort_tab_timezone_label_right">Event time zone</label>
          <div class="calendar_admin_details_cohort_tab_timezone_dropdown_right">
            <span>(GMT+05:00) Pakistan</span>
            <svg class="calendar_admin_details_cohort_tab_timezone_arrow_right" width="18" height="18" viewBox="0 0 20 20">
              <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/>
            </svg>
            <div class="calendar_admin_details_cohort_tab_timezone_list_right">
              <ul>
                <li>(GMT+00:00) London</li>
                <li>(GMT+01:00) Berlin, Paris</li>
                <li>(GMT+03:00) Moscow, Nairobi</li>
                <li>(GMT+05:00) Pakistan</li>
                <li>(GMT+05:30) India</li>
                <li>(GMT+08:00) Beijing, Singapore</li>
                <li>(GMT+09:00) Tokyo, Seoul</li>
                <li>(GMT+10:00) Sydney</li>
                <li>(GMT-05:00) Eastern Time (US & Canada)</li>
                <li>(GMT-06:00) Central Time (US & Canada)</li>
                <li>(GMT-07:00) Mountain Time (US & Canada)</li>
                <li>(GMT-08:00) Pacific Time (US & Canada)</li>
              </ul>
            </div>
          </div>
        </div>

      <label style="margin-top:20px;">Start On</label>
      <button class="conference_modal_date_btn">Select Date</button>

      <div class="create_new_cohort_tab_select_color_left_row">
        <label class="create_new_cohort_tab_select_color_left_label">Find a time</label>
        <div class="create_new_cohort_tab_select_color_left_dropdown" id="createNewCohortSelectColorLeft">
          <span class="create_new_cohort_tab_select_color_left_selected" id="createNewCohortSelectedColorLeft">
            <span class="create_new_cohort_tab_select_color_left_circle" style="background:#1649c7"></span>
          </span>
          <svg width="18" height="18" class="create_new_cohort_tab_select_color_left_arrow" viewBox="0 0 20 20">
            <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/>
          </svg>
          <div class="create_new_cohort_tab_select_color_left_list" id="createNewCohortColorListLeft">
            <ul>
              <li data-color="#1649c7" style="background:#1649c7"></li>
              <li data-color="#20a88e" style="background:#20a88e"></li>
              <li data-color="#3f3f48" style="background:#3f3f48"></li>
              <li data-color="#fe2e0c" style="background:#fe2e0c"></li>
              <li data-color="#daa520" style="background:#daa520"></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Teacher 2 -->
  <div class="teacher-block" data-teacher="2">
    <div>
      <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
        <label>Teacher 2</label>
        <div class="calendar_admin_details_create_cohort_teacher_btn" id="teacher2DropdownBtn">
          Select Teacher
          <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
        </div>
        <div class="calendar_admin_details_create_cohort_teacher_list" id="teacher2DropdownList">
          <ul>
            <li><img src="https://randomuser.me/api/portraits/women/45.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px;">Maria</span></li>
            <li><img src="https://randomuser.me/api/portraits/men/38.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"> <span style="margin-left:10px;">Joseph</span></li>
            <li><img src="https://randomuser.me/api/portraits/women/32.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"> <span style="margin-left:10px;">Lisa</span></li>
            <li><img src="https://randomuser.me/api/portraits/men/21.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"> <span style="margin-left:10px;">Fox</span></li>
          </ul>
        </div>
      </div>

      <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
        <label>Class Name</label>
        
          <div class="calendar_admin_details_create_cohort_class_btn" id="className2DropdownBtn">
            Select Class
            <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
          </div>

        <div class="calendar_admin_details_create_cohort_class_list" id="className2DropdownList">
          <ul>
            <li>Main Class</li>
            <li>Tutoring Class</li>
            <li>Conversational Class</li>
          </ul>
        </div>
      </div>

      <div class="cohort_schedule_box">
        <div class="cohort_schedule_header">
          <span class="cohort_schedule_icon">&#9432;</span>
          <span>Tutoring Schedule</span>
        </div>
        <button type="button" class="cohort_schedule_btn">
          Does not repeat
          <span class="cohort_schedule_arrow">&#9660;</span>
        </button>
      </div>

      <div class="d-flex calendar_admin_details_time_right" style="margin-top:10px;">
        <div class="calendar_admin_details_time_right_time-pill">
          <input type="text" class="form-control calendar_admin_details_time_right_time-input" value="9:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
          <div class="calendar_admin_details_time_right_time-dropdown"></div>
        </div>
        <div class="calendar_admin_details_time_right_time-dash">–</div>
        <div class="calendar_admin_details_time_right_time-pill">
          <input type="text" class="form-control calendar_admin_details_time_right_time-input" value="10:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
          <div class="calendar_admin_details_time_right_time-dropdown"></div>
        </div>
      </div>

        <div class="calendar_admin_details_cohort_tab_timezone_wrapper_right">
          <label class="calendar_admin_details_cohort_tab_timezone_label_right">Event time zone (Right)</label>
          <div class="calendar_admin_details_cohort_tab_timezone_dropdown_right">
            <span>(GMT+05:00) Pakistan</span>
            <svg class="calendar_admin_details_cohort_tab_timezone_arrow_right" width="18" height="18" viewBox="0 0 20 20">
              <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/>
            </svg>
            <div class="calendar_admin_details_cohort_tab_timezone_list_right">
              <ul>
                <li>(GMT+00:00) London</li>
                <li>(GMT+01:00) Berlin, Paris</li>
                <li>(GMT+03:00) Moscow, Nairobi</li>
                <li>(GMT+05:00) Pakistan</li>
                <li>(GMT+05:30) India</li>
                <li>(GMT+08:00) Beijing, Singapore</li>
                <li>(GMT+09:00) Tokyo, Seoul</li>
                <li>(GMT+10:00) Sydney</li>
                <li>(GMT-05:00) Eastern Time (US & Canada)</li>
                <li>(GMT-06:00) Central Time (US & Canada)</li>
                <li>(GMT-07:00) Mountain Time (US & Canada)</li>
                <li>(GMT-08:00) Pacific Time (US & Canada)</li>
              </ul>
            </div>
          </div>
        </div>
      <label style="margin-top:20px;">Start On</label>
      <button class="conference_modal_date_btn">Select Date</button>

      <div class="create_new_cohort_tab_select_color_right_row">
        <label class="create_new_cohort_tab_select_color_right_label">Find a time</label>
        <div class="create_new_cohort_tab_select_color_right_dropdown" id="createNewCohortSelectColorRight">
          <span class="create_new_cohort_tab_select_color_right_selected" id="createNewCohortSelectedColorRight">
            <span class="create_new_cohort_tab_select_color_right_circle" style="background:#1649c7"></span>
          </span>
          <svg width="18" height="18" class="create_new_cohort_tab_select_color_right_arrow" viewBox="0 0 20 20">
            <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/>
          </svg>
          <div class="create_new_cohort_tab_select_color_right_list" id="createNewCohortColorListRight">
            <ul>
              <li data-color="#1649c7" style="background:#1649c7"></li>
              <li data-color="#20a88e" style="background:#20a88e"></li>
              <li data-color="#3f3f48" style="background:#3f3f48"></li>
              <li data-color="#fe2e0c" style="background:#fe2e0c"></li>
              <li data-color="#daa520" style="background:#daa520"></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>































        <div class="calendar_admin_details_create_cohort_bottom">
          <div class="calendar_admin_details_create_cohort_switch">
            <div class="calendar_admin_details_create_cohort_toggle" id="toggleActive"></div> Active
          </div>
          <div class="calendar_admin_details_create_cohort_switch">
            <div class="calendar_admin_details_create_cohort_toggle" id="toggleAvailable"></div> Available
          </div>
        </div>
        
        
        
        
        
        
        
        
        
        
        
        <button class="calendar_admin_details_create_cohort_btn">Update Cohort</button>
      </div>






                        

                    <style>
                      /* ===== 1:1 Class Tab Styles ===== */
                  .one2one-section-label {
                    font-size: 1.05rem;
                    color: #232323;
                    font-weight: 500;
                    margin-top: 16px;
                    margin-bottom: 7px;
                    display: block;
                    letter-spacing: -.1px;
                  }

                  .one2one-teacher-card {
                    display: flex;
                    align-items: center;
                    padding: 10px 14px;
                    background: #fff;
                    border: 2px solid #ececec;
                    border-radius: 12px;
                    margin-bottom: 10px;
                    gap: 13px;
                  }
                  .one2one-teacher-avatar {
                    width: 36px; height: 36px;
                    border-radius: 50%; object-fit: cover;
                    border: 1.4px solid #ececec;
                    background: #eaeaea;
                  }
                  .one2one-teacher-name {
                    font-weight: 600; color: #232323;
                    font-size: 1.04rem;
                  }

                  .one2one-add-student-card {
                    display: flex; align-items: center; gap: 13px;
                    padding: 13px 14px;
                    background: #fff;
                    border: 2px solid #ececec;
                    border-radius: 12px;
                    margin-bottom: 12px;
                    color: #232323; font-size: 1.01rem;
                    cursor: pointer;
                    transition: border .13s;
                  }
                  .one2one-add-student-card:hover {
                    border: 2px solid #1736e6;
                  }

                  .one2one-add-student-icon {
                    width: 25px; height: 25px;
                    border-radius: 50%; background: #e6e7ed;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 1.18rem; color: #232323;
                  }
                  .one2one-lesson-type-row {
                    display: flex; gap: 17px; margin: 10px 0 16px 0;
                  }
                  .one2one-lesson-type-btn {
                    flex: 1 1 0;
                    background: #fff;
                    border: 2px solid #ececec;
                    border-radius: 10px;
                    padding: 12px 0 12px 16px;
                    display: flex; align-items: center; gap: 12px;
                    font-size: 1.04rem; font-weight: 500; color: #232323;
                    cursor: pointer;
                    transition: border .13s, color .13s;
                    position: relative;
                  }
                  .one2one-lesson-type-btn.selected,
                  .one2one-lesson-type-btn:active {
                    border: 2px solid #1736e6; color: #1736e6;
                  }
                  .one2one-lesson-type-icon {
                    font-size: 1.24rem;
                  }
                  .one2one-radio {
                    margin-left: auto;
                    width: 22px; height: 22px;
                    accent-color: #1736e6;
                  }

                  .one2one-datetime-group {
                    margin: 10px 0 14px 0;
                  }
                  .one2one-datetime-dropdown,
                  .one2one-datetime-dropdown-row select {
                    width: 100%; padding: 13px 14px;
                    border-radius: 10px; border: 1.5px solid #dadada;
                    background: #fff; font-size: 1.05rem;
                    margin-bottom: 12px; color: #232323;
                    cursor: pointer;
                    transition: border .13s;
                  }
                  .one2one-datetime-dropdown-row {
                    display: flex; gap: 10px;
                  }
                  .one2one-datetime-dropdown-row select {
                    flex: 1 1 0; min-width: 80px;
                  }

                  </style>



        <!-- </div> -->



        <!-- Time Picker Modal -->
        <div class="calendar_admin_details_create_cohort_time_modal_backdrop" id="timeModalBackdrop">
          <div class="calendar_admin_details_create_cohort_time_modal" id="timeModal">
            <ul>
              <!-- Time options rendered via JS -->
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



  <!-- </div> -->


  <script>
    $(document).ready(function () {



// Peer Talk Tab: Schedule Peer Talk Button
$('#peerTalkScheduleBtn').on('click', function(e) {
  e.preventDefault();

  // Repeat
  let repeat = $('#peerTalkTabContent .conference_modal_repeat_btn').text().trim();
  // Start On
  let startOn = $('#peerTalkTabContent .conference_modal_date_btn').first().text().trim();
  // Start & End Time
  let startTime = $('#peerTalkTabContent .conference_modal_time_btn').eq(0).text().trim();
  let endTime = $('#peerTalkTabContent .conference_modal_time_btn').eq(1).text().trim();
  // Timezone
  let timezone = $('#peerTalkTabContent .conference_modal_timezone').val();
  // Cohorts (selected in dropdown, and chips)
  let selectedCohortDropdown = $('#peerTalkCohortsDropdown').contents().first()[0].textContent.trim();
  let cohortList = [];
  $('#peerTalkTabContent .conference_modal_cohort_list .conference_modal_cohort_chip').each(function(){
    cohortList.push($(this).text().trim());
  });
  // Teachers (selected in dropdown, and chips)
  let selectedTeacherDropdown = $('#peerTalkTeachersDropdown').text().replace(/\s+/g, ' ').trim();
  let teacherList = [];
  $('#peerTalkTabContent .conference_modal_attendees_list .conference_modal_attendee').each(function(){
    teacherList.push($(this).find('span').eq(1).text().trim());
  });
  // Color
  let color = $('#peerTalkColorDropdownToggle .color-circle').css('background-color');

  // Build Peer Talk Data Object
  let peerTalkData = {
    repeat: repeat,
    startOn: startOn,
    startTime: startTime,
    endTime: endTime,
    timezone: timezone,
    selectedCohortDropdown: selectedCohortDropdown,
    cohortList: cohortList,
    selectedTeacherDropdown: selectedTeacherDropdown,
    teacherList: teacherList,
    color: color
  };

  alert(JSON.stringify(peerTalkData, null, 2));
});

      $('#peerTalkColorDropdownToggle').click(function(e){
        e.stopPropagation();
        $(this).toggleClass('active');
        $('#peerTalkColorDropdownList').toggle();
        // Close the conference color dropdown if open
        $('#colorDropdownList').hide();
        $('#colorDropdownToggle').removeClass('active');
      });

        $('#peerTalkColorDropdownList .color-dropdown-color').click(function(e){
        e.stopPropagation();
        var color = $(this).attr('data-color');
        $('#peerTalkColorDropdownToggle .color-circle').css('background', color);
        $('#peerTalkColorDropdownList .color-dropdown-color').removeClass('selected');
        $(this).addClass('selected');
        $('#peerTalkColorDropdownList').hide();
        $('#peerTalkColorDropdownToggle').removeClass('active');
      });


      // Modal open/close
      $('#calendar_admin_details_create_cohort_open').click(function () {
        $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
      });
      $('.calendar_admin_details_create_cohort_close').click(function () {
        $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();
      });





      // Tabs - Peer Talk tab shows Conference content
      $('.calendar_admin_details_create_cohort_tab').click(function () {
        $('.calendar_admin_details_create_cohort_tab').removeClass('active');
        $(this).addClass('active');
        let tab = $(this).data('tab');
        $('#manage_cohort_tab_content').toggle(tab === "manage");
        
        $('#conferenceTabContent').toggle(tab === "conference");
        $('#peerTalkTabContent').toggle(tab === "peertalk");


        // Hide both if not cohort/conference/peertalk
        if(tab !== "manage" && tab !== "conference" && tab !== "peertalk"){
          $('#manage_cohort_tab_content').hide();
          $('#conferenceTabContent').hide();
        }
      });





      // Dropdowns
      $('#cohortDropdownBtn').click(function (e) {
        e.stopPropagation();
        $('#cohortDropdownList').toggle();
        $('#shortNameDropdownList, #teacher1DropdownList_manage_cohort, #teacher2DropdownList_manage_cohrt, #className1DropdownList_manage_cohort, #className2DropdownList_manage_cohort').hide();
      });
      $('#cohortDropdownList li').click(function () {
        $('#cohortDropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
        $('#cohortDropdownList').hide();
      });

      
      $('#shortNameDropdownBtn').click(function (e) {
        e.stopPropagation();
        $('#shortNameDropdownList').toggle();
        $('#cohortDropdownList, #teacher1DropdownList_manage_cohort, #teacher2DropdownList_manage_cohrt, #className1DropdownList_manage_cohort, #className2DropdownList_manage_cohort').hide();
      });className1DropdownList_manage_cohort
      $('#shortNameDropdownList li').click(function () {
        $('#shortNameDropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
        $('#shortNameDropdownList').hide();
      });
      $('#teacher1DropdownBtn_manage_cohort').click(function(e){
        e.stopPropagation();
        $('#teacher1DropdownList_manage_cohort').toggle();
        $('#cohortDropdownList, #shortNameDropdownList, #teacher2DropdownList_manage_cohrt, #className1DropdownList_manage_cohort, #className2DropdownList_manage_cohort').hide();
      });
      $('#teacher1DropdownList_manage_cohort li').click(function(){
        $('#teacher1DropdownBtn_manage_cohort').html($(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
        $('#teacher1DropdownList_manage_cohort').hide();
      });
      $('#teacher2DropdownBtn_manage_cohort').click(function(e){
        e.stopPropagation();
        $('#teacher2DropdownList_manage_cohrt').toggle();
        $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList_manage_cohort, #className1DropdownList_manage_cohort, #className2DropdownList_manage_cohort').hide();
      });
      $('#teacher2DropdownList_manage_cohrt li').click(function(){
        $('#teacher2DropdownBtn_manage_cohort').html($(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
        $('#teacher2DropdownList_manage_cohrt').hide();
      });
      $('#className1DropdownBtn_manage_cohort').click(function(e){
        e.stopPropagation();
        $('#className1DropdownList_manage_cohort').toggle();
        $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList_manage_cohort, #teacher2DropdownList_manage_cohrt, #className2DropdownList_manage_cohort').hide();
      });
      $('#className1DropdownList_manage_cohort li').click(function(){
        $('#className1DropdownBtn_manage_cohort').contents().first()[0].textContent = $(this).text() + " ";
        $('#className1DropdownList_manage_cohort').hide();
      });

      $('#className2DropdownBtn_manage_cohort').click(function(e){
        e.stopPropagation();

        $('#className2DropdownList_manage_cohort').toggle();
        $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList_manage_cohort, #teacher2DropdownList_manage_cohrt, #className1DropdownList_manage_cohort').hide();
      });

      $('#className2DropdownList_manage_cohort li').click(function(){
        $('#className2DropdownBtn_manage_cohort').contents().first()[0].textContent = $(this).text() + " ";
        $('#className2DropdownList_manage_cohort').hide();
      });

      // Conference tab dropdowns
      $('#conferenceCohortsDropdown').click(function(e){
        e.stopPropagation();
        $('#conferenceCohortsDropdownList').toggle();
        $('#conferenceTeachersDropdownList').hide();
      });
      $('#conferenceTeachersDropdown').click(function(e){
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

            // 2. Get teacher info
            let imgHtml = $(this).find('img').prop('outerHTML');
            let name = $(this).text().trim();
            let email = name.replace(/\s/g, '').toLowerCase() + "@example.com"; // Or set email as you wish

            // 3. Prevent duplicates
            let exists = false;
            $('#conferenceTabContent .conference_modal_attendee').each(function(){
              if($(this).find('.conference_modal_attendee_name').text().trim() === name) exists = true;
              if($(this).find('span').eq(1).text().trim() === name) exists = true;
            });
            if(exists) return;

            // 4. Add to attendee list
            $('#conferenceTabContent .conference_modal_attendees_list').append(`
              <li class="conference_modal_attendee">
                ${imgHtml}
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
          calendarModalMonth = {year: 2025, month: 0}; // Jan 2025
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
      $('.calendar_admin_details_create_cohort_calendar_done_btn').click(function(){
        if(selectedCalendarDate && calendarDateTargetBtn){
          let d = selectedCalendarDate;
          let nice = d.toLocaleDateString('en-GB', { day: '2-digit', month:'short', year:'numeric' });
          calendarDateTargetBtn.text(nice);
          $('#calendarDateModalBackdrop').fadeOut();
        }
      });
      $('#calendarDateModalBackdrop').click(function(e){
        if(e.target === this) $(this).fadeOut();
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




      // Conference modal button example
      $('.conference_modal_btn').on('click', function(e) {
        e.preventDefault();
        let repeat = $('.conference_modal_repeat_btn').text().trim();
        let startOn = $('#conferenceTabContent .conference_modal_date_btn').first().text().trim();
        let startTime = $('#conferenceTabContent .conference_modal_time_btn').eq(0).text().trim();
        let endTime = $('#conferenceTabContent .conference_modal_time_btn').eq(1).text().trim();
        let timezone = $('#conferenceTabContent .conference_modal_timezone').val();
        let cohorts = $('#conferenceTabContent #conferenceCohortsDropdown').contents().first()[0].textContent.trim();
        let teachers = $('#conferenceTabContent #conferenceTeachersDropdown').text().replace(/\s+/g, ' ').trim();
        let attendees = [];
        $('#conferenceTabContent .conference_modal_attendee').each(function() {
          let cohort = $(this).find('.conference_modal_attendee_name').text().trim();
          let email = $(this).find('span').eq(1).text().trim();
          if(cohort) attendees.push(cohort);
          else if(email) attendees.push(email);
        });
        let confData = {
          repeat: repeat,
          startOn: startOn,
          startTime: startTime,
          endTime: endTime,
          timezone: timezone,
          cohorts: cohorts,
          teachers: teachers,
          attendees: attendees
        };
        alert(JSON.stringify(confData, null, 2));
      });

    });
  


    // Add cohort to cohort list when selected
$('#conferenceCohortsDropdownList li').click(function(){
  let cohort = $(this).text().trim();
  // Prevent duplicates
  if ($('.conference_modal_cohort_list li[data-cohort="'+cohort+'"]').length === 0) {
    $('.conference_modal_cohort_list').append(`
      <li data-cohort="${cohort}">
        <span class="conference_modal_cohort_chip">${cohort}</span>
        <span class="conference_modal_attendee_name">${cohort}</span>
        <span class="conference_modal_remove">&times;</span>
      </li>
    `);
  }
  $('#conferenceCohortsDropdown').contents().first()[0].textContent = cohort + " ";
  $('#conferenceCohortsDropdownList').hide();
});


// Remove cohort attendee (from cohort list)
$(document).on('click', '.conference_modal_cohort_list .conference_modal_remove', function() {
  $(this).closest('li').fadeOut(200, function() { $(this).remove(); });
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


  $('#eventTimezoneDropdown_manage_cohort').click(function(e){
  e.stopPropagation();
  $('#eventTimezoneDropdownList').toggle();
});

$('#eventTimezoneDropdownList li').click(function(e){
  e.stopPropagation();
  $('#eventTimezoneSelected').text($(this).text());
  $('#eventTimezoneDropdownList').hide();
});


// Close dropdown on outside click
$(document).click(function() {
  $('#eventTimezoneDropdownList').hide();
});

$('#eventTimezoneDropdownRight_manage_cohort').click(function(e){
  e.stopPropagation();
  $('#eventTimezoneDropdownListRight').toggle();
});

$('#eventTimezoneDropdownListRight li').click(function(e){
  e.stopPropagation();
  $('#eventTimezoneSelectedRight').text($(this).text());
  $('#eventTimezoneDropdownListRight').hide();
});

// Close dropdown on outside click
$(document).click(function() {
  $('#eventTimezoneDropdownListRight').hide();
});
</script>

<script>
// document.querySelectorAll('.calendar_admin_details_create_cohort_toggle')
//   .forEach(toggle => {
//     toggle.addEventListener('click', function() {
//       this.classList.toggle('active');   // add/remove active class
//     });
//   });
</script>


<script src="js/calendar_admin_details_manage_cohort_plus_icon_new_content.js"></script>
<?php require_once('calendar_admin_details_create_cohort_select_date.php');?>
<?php require_once('calendar_admin_details_create_cohort_tab_does_repeat.php');?>