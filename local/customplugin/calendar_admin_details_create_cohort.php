<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cohort Modal with Conference Tab and Calendar Picker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    #calendar_admin_details_create_cohort_modal_backdrop {
        display: none;
        position: fixed;
        z-index: 2000;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .6);
    }

    #calendar_admin_details_create_cohort_modal {
        background: #fff;
        width: 95%;
        max-width: 570px;
        max-height: 93vh;
        margin: 5vh auto;
        border-radius: 12px;
        padding: 28px 20px 20px 20px;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .17);
        overflow-y: auto;
        z-index: 2001 !important;
        /* modal itself */


    }

    .calendar_admin_details_create_cohort_close {
        position: absolute;
        top: 16px;
        right: 15px;
        font-size: 22px;
        cursor: pointer;
        font-weight: bold;
        color: #222;
    }

    .calendar_admin_details_create_cohort_close_sub {
        position: absolute;
        top: 16px;
        right: 15px;
        font-size: 22px;
        cursor: pointer;
        font-weight: bold;
        color: #222;
    }

    h2 {
        margin: 10px 0 0 0;
        font-size: 1.35rem;
        font-weight: bold;
    }

    .calendar_admin_details_create_cohort_tabs_scroll {
        overflow-x: auto;
        white-space: nowrap;
        border-bottom: 1px solid #ececec;
        margin: 18px 0 20px 0;
        padding-bottom: 2px;
        -webkit-overflow-scrolling: touch;
    }

    .calendar_admin_details_create_cohort_tabs {
        display: inline-flex;
        gap: 15px;
    }

    .calendar_admin_details_create_cohort_tab {
        display: inline-block;
        padding: 8px 12px 10px 12px;
        cursor: pointer;
        font-size: 1.03rem;
        color: #989898;
        border: none;
        background: none;
        font-weight: 500;
        transition: color 0.2s, border-bottom 0.2s;
    }

    .calendar_admin_details_create_cohort_tab.active {
        border-bottom: 3px solid #fe2e0c;
        color: #fe2e0c;
        font-weight: bold;
    }

    .calendar_admin_details_create_cohort_tabs_scroll::-webkit-scrollbar {
        height: 4px;
        background: #ececec;
    }

    .calendar_admin_details_create_cohort_tabs_scroll::-webkit-scrollbar-thumb {
        background: #d1d1d1;
        border-radius: 2px;
    }

    .calendar_admin_details_create_cohort_content {
        margin-top: 5px;
        animation: fadeIn .19s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Conference Content (scoped styles) */
    .conference_modal_schedule {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #b5b5b5;
        font-size: 1.07rem;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .conference_modal_schedule input[type="checkbox"] {
        accent-color: #dadada;
        width: 19px;
        height: 19px;
        margin: 0 5px 0 0;
    }

    .conference_modal_repeat_row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 7px;
    }

    .conference_modal_repeat_btn {
        padding: 11px 13px;
        border-radius: 8px 8px 0 0;
        border: none;
        border-bottom: 2.5px solid #fe2e0c;
        background: none;
        color: #232323;
        font-weight: 600;
        font-size: 1rem;
        min-width: 153px;
    }

    .conference_modal_date_btn {
        background: #fff;
        border: 2px solid #dadada;
        border-radius: 24px;
        padding: 10px 20px;
        font-size: 1.05rem;
        font-weight: 500;
        min-width: 123px;
        margin: 0 0 0 0;
        margin-right: 10px;
        cursor: pointer;
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
        border: 2px solid #fe2e0c;
        color: #fe2e0c;
        background: #fff4f1;
    }



    .conference_modal_findtime_link {
        color: #064ae6;
        font-size: 1.06rem;
        text-decoration: none;
        font-weight: 500;
    }

    .conference_modal_findtime_circle {
        width: 30px;
        height: 30px;
        background: #1736e6;
        border-radius: 50%;
        display: inline-block;
        border: 2.3px solid #1736e6;
    }

    .conference_modal_timezone {
        width: 100%;
        padding: 12px 13px;
        border-radius: 10px;
        border: 1.4px solid #dadada;
        background: #fafbfc;
        font-size: 1.02rem;
        margin-bottom: 13px;
        color: #6d6d6d;
    }

    .conference_modal_fieldrow {
        display: flex;
        flex-wrap: wrap;
        gap: 13px;
        margin-bottom: 18px;
    }

    .conference_modal_fieldrow>div {
        flex: 1 1 47%;
        min-width: 150px;
        position: relative;
    }

    .conference_modal_label {
        font-size: 1rem;
        font-weight: 500;
        color: #232323;
        margin-bottom: 4px;
        display: block;
    }

    .conference_modal_dropdown_btn {
        width: 100%;
        padding: 13px 14px;
        border: 1.5px solid #dadada;
        border-radius: 10px;
        background: #fff;
        font-size: 1.02rem;
        text-align: left;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 50px;
    }

    .conference_modal_dropdown_btn svg {
        width: 18px;
        height: 18px;
        margin-left: auto;
        fill: #aaa;
    }

    .conference_modal_dropdown_list {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #fff;
        border: 1.5px solid #dadada;
        border-radius: 11px;
        box-shadow: 0 4px 18px #0001;
        z-index: 100;
        margin-top: 1px;
    }

    .conference_modal_dropdown_list ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .conference_modal_dropdown_list li {
        padding: 13px 18px;
        font-size: 1rem;
        cursor: pointer;
        border-radius: 8px;
        transition: background 0.18s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .conference_modal_dropdown_list li:hover {
        background: #f7f7f7;
        color: #fe2e0c;
    }

    .conference_modal_teacher_avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        background: #eaeaea;
        border: 1.2px solid #ececec;
    }

    .conference_modal_attendees_section {
        margin: 18px 0 9px 0;
    }

    .conference_modal_attendees_list {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 11px #0002;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .conference_modal_attendee {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 12px 16px;
        border-bottom: 1px solid #f1f1f1;
        font-size: 1.02rem;
        background: #fff;
    }

    .conference_modal_attendee:last-child {
        border-bottom: none;
    }

    .conference_modal_cohort_chip {
        background: #d6e8cf;
        color: #497b26;
        font-weight: 700;
        font-size: 1rem;
        padding: 7px 13px;
        border-radius: 50px;
        margin-right: 7px;
        display: flex;
        align-items: center;
        min-width: 35px;
        justify-content: center;
    }

    .conference_modal_attendee_name {
        font-weight: 600;
    }

    .conference_modal_icon {
        font-size: 1.3rem;
        color: #626262;
        margin-left: auto;
        margin-right: 6px;
        display: flex;
        align-items: center;
    }

    .conference_modal_icon.user {
        font-size: 1.17rem;
    }

    .conference_modal_remove {
        color: #c53c2a;
        cursor: pointer;
        font-size: 1.5rem;
        margin-left: 8px;
    }

    .conference_modal_btn {
        width: 100%;
        background-color: #fe2e0c;
        color: white;
        padding: 15px 0;
        border: none;
        font-weight: bold;
        font-size: 1.11rem;
        margin-top: 18px;
        border-radius: 9px;
        cursor: pointer;
        letter-spacing: .5px;
        box-shadow: 0 3px 13px 0 rgba(254, 46, 12, .07);
    }

    /* Time Picker Modal Styles */
    .calendar_admin_details_create_cohort_time_modal_backdrop {
        display: none;
        position: fixed;
        z-index: 3001;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.08);
    }

    .calendar_admin_details_create_cohort_time_modal {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px 0 rgba(0, 0, 0, .14);
        width: 210px;
        max-width: 98vw;
        max-height: 72vh;
        overflow-y: auto;
        padding: 0;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        margin-top: 8px;
        animation: fadeIn .16s;
        border: 1.5px solid #eaeaea;
    }

    .calendar_admin_details_create_cohort_time_modal ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .calendar_admin_details_create_cohort_time_modal li {
        font-size: 1.13rem;
        padding: 14px 28px;
        cursor: pointer;
        transition: background .15s, color .15s;
        border-radius: 0;
        text-align: left;
        color: #232323;
    }

    .calendar_admin_details_create_cohort_time_modal li:hover,
    .calendar_admin_details_create_cohort_time_modal li.selected {
        background: #f7f7f7;
        color: #fe2e0c;
    }

    @media(max-width: 600px) {
        .calendar_admin_details_create_cohort_time_modal {
            width: 96vw;
            padding: 0;
            font-size: 1rem;
        }

        .calendar_admin_details_create_cohort_time_modal li {
            padding: 12px 10vw;
        }
    }

    /* All your previous styles remain below! */
    .calendar_admin_details_create_cohort_row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 13px;
    }

    .calendar_admin_details_create_cohort_row>div {
        flex: 1 1 45%;
        position: relative;
    }

    .calendar_admin_details_create_cohort_dropdown_wrapper,
    .calendar_admin_details_create_cohort_teacher_dropdown_wrapper,
    .calendar_admin_details_create_cohort_class_dropdown_wrapper,
    .calendar_admin_details_create_cohort_shortname_dropdown_wrapper {
        position: relative;
        margin-bottom: 12px;
    }

    .calendar_admin_details_create_cohort_dropdown_btn,
    .calendar_admin_details_create_cohort_shortname_btn,
    .calendar_admin_details_create_cohort_teacher_btn,
    .calendar_admin_details_create_cohort_class_btn {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #232323;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        font-size: 1rem;
        text-align: left;
        position: relative;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 55px;
    }

    .calendar_admin_details_create_cohort_dropdown_btn svg,
    .calendar_admin_details_create_cohort_shortname_btn svg,
    .calendar_admin_details_create_cohort_teacher_btn svg,
    .calendar_admin_details_create_cohort_class_btn svg {
        width: 19px;
        height: 19px;
        margin-left: auto;
        fill: #232323;
        flex-shrink: 0;
    }








    /* --- Improved Dropdowns for Cohort & Short Name --- */

    .calendar_admin_details_create_cohort_dropdown_list,
    .calendar_admin_details_create_cohort_shortname_list {
        display: none;
        position: absolute;
        top: 108%;
        left: 0;
        width: 290px;
        /* Wider for readability */
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 5px 24px 0 rgba(0, 0, 0, 0.14);
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
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        min-width: 180px;
        max-height: 290px;
        overflow-y: auto;
        background: #fff;
        border: 1.5px solid #232323;
        border-radius: 10px;
        box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.14);
        z-index: 40;
        display: none;
        padding: 8px 0 8px 0;
        margin-top: 0;
        box-sizing: border-box;
    }

    .calendar_admin_details_create_cohort_teacher_list li {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.18s;
    }

    .calendar_admin_details_create_cohort_teacher_list li:hover {
        background: #f7f7f7;
        color: #fe2e0c;
    }

    .calendar_admin_details_create_cohort_teacher_avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        background: #eaeaea;
        border: 1.2px solid #ececec;
    }

    .calendar_admin_details_create_cohort_time_btn.selected {
        border: 2px solid #fe2e0c;
        color: #fe2e0c;
        background: #fff4f1;
    }

    label {
        font-size: .97rem;
        font-weight: 500;
        color: #232323;
    }


    /* .calendar_admin_details_create_cohort_event_nav {
      display: flex; align-items: center; justify-content: center; gap: 18px; margin: 18px 0 13px 0;
      font-size: 1.07rem; font-weight: 600;
    }
    .calendar_admin_details_create_cohort_event_nav button {
      background: #fff; border: 1.1px solid #ccc; border-radius: 7px; padding: 4px 12px;
      font-weight: 600; font-size: 1.14rem; color: #232323; cursor: pointer; outline: none; transition: background .16s;
    }
    .calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_add {
      color: #fff; background: #fe2e0c; border: none; font-size: 1.3rem; border-radius: 50%; width: 34px; height: 34px; padding: 0;
      display: flex; align-items: center; justify-content: center; margin-left: 6px; box-shadow: 0 2px 8px rgba(254,46,12,0.10);
    } */











    /* Event nav row */
    .calendar_admin_details_create_cohort_event_nav {
        position: relative;
        display: flex;
        align-items: center;
        min-height: 48px;
        margin: 18px 0 13px 0;
    }

    /* Centered [<] Events [>] cluster */
    .calendar_event_group {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0;
        background: transparent !important;
        /* kill the tan strip */
        box-shadow: none !important;
        border: 0 !important;
    }

    .calendar_event_group>* {
        pointer-events: auto;
    }

    /* Title */
    .calendar_event_nav_title {
        margin: 0;
        line-height: 1;
        font-weight: 800;
        color: #111;
        background: transparent !important;
        /* make sure no bg */
        padding: 0 2px;
    }

    /* Arrow buttons (subtle gray rounded squares) */
    .calendar_event_nav_btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-radius: 10px;
        background: #fff !important;
        border: 1.5px solid #e7e7ef;
        color: #8f96a3;
        box-shadow: none;
        transition: background .15s, border-color .15s, transform .08s;
    }

    .calendar_event_nav_btn:hover {
        background: #f7f7fb;
        border-color: #dcdcea;
    }

    .calendar_event_nav_btn:active {
        transform: translateY(1px);
    }

    .calendar_event_nav_btn svg {
        width: 18px;
        height: 18px;
        display: block;
    }

    /* Keep the + on the right and red */
    .calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_add {
        margin-left: auto;
        /* pushes to far right */
        width: 42px;
        height: 42px;
        padding: 0;
        border-radius: 50%;
        background: #ff2f1b !important;
        color: #fff;
        font-size: 22px;
        line-height: 1;
        border: 2px solid #111;
        box-shadow: 0 6px 16px rgba(255, 47, 27, .28);
    }

    /* Defensive: remove any leftover bg that might wrap the cluster */
    .calendar_admin_details_create_cohort_event_nav>span,
    .calendar_admin_details_create_cohort_event_nav>div {
        background: transparent !important;
        box-shadow: none !important;
        border: 0 !important;
    }


















    select,
    input[type="text"],
    input[type="date"] {
        width: 100%;
        padding: 9px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
        margin-top: 2px;
        margin-bottom: 6px;
    }

    .calendar_admin_details_create_cohort_find-time {
        display: flex;
        gap: 10px;
        align-items: center;
        margin: 5px 0 0 0;
    }

    .calendar_admin_details_create_cohort_find-time a {
        color: #064ae6;
        font-size: 1.03rem;
        text-decoration: none;
        font-weight: 500;
    }

    .calendar_admin_details_create_cohort_circle-dropdown {
        width: 26px;
        height: 26px;
        background: #1736e6;
        border-radius: 50%;
        display: inline-block;
        position: relative;
        cursor: pointer;
        border: 2px solid #1736e6;
    }







    .calendar_admin_details_create_cohort_btn {
        width: 100%;
        background-color: #fe2e0c;
        color: white;
        padding: 15px 0;
        border: none;
        font-weight: bold;
        font-size: 1.11rem;
        margin-top: 13px;
        border-radius: 9px;
        cursor: pointer;
        letter-spacing: .5px;
        box-shadow: 0 3px 13px 0 rgba(254, 46, 12, .07);
        position: sticky;
        bottom: 0;
        /* stick to bottom edge of the scrollport */
        z-index: 5;
        /* above form fields, below popups */
    }

    /* Optional: add a soft separator behind the sticky button for readability */
    .calendar_admin_details_create_cohort_btn::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 100%;
        height: 14px;
        pointer-events: none;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0), #fff 70%);
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }


    /* Calendar modal styles ... */
    .calendar_admin_details_create_cohort_calendar_modal_backdrop {
        display: none;
        position: fixed;
        z-index: 2050;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.11);
    }

    .calendar_admin_details_create_cohort_calendar_modal {
        background: #fff;
        border-radius: 13px;
        box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .16);
        width: 340px;
        padding: 20px 18px 18px 18px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 96vw;
    }

    .calendar_admin_details_create_cohort_calendar_nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 1.18rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .calendar_admin_details_create_cohort_calendar_nav button {
        background: #fafafa;
        border: none;
        font-size: 1.45rem;
        border-radius: 7px;
        padding: 2px 13px;
        cursor: pointer;
        color: #222;
        transition: background .15s;
    }

    .calendar_admin_details_create_cohort_calendar_nav button:hover {
        background: #ececec;
    }

    .calendar_admin_details_create_cohort_calendar_days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 3px;
        text-align: center;
        font-size: 1.07rem;
        margin-bottom: 10px;
    }

    .calendar_admin_details_create_cohort_calendar_day_header {
        color: #b2b2b2;
        font-weight: 600;
        padding: 7px 0 4px 0;
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
        color: #bdbdbd;
        background: #fafafa;
        cursor: not-allowed;
    }

    .calendar_admin_details_create_cohort_calendar_day.selected {
        border: 2px solid #fe2e0c;
        color: #fe2e0c;
        background: #fff;
        font-weight: 700;
    }

    .calendar_admin_details_create_cohort_calendar_done_btn {
        width: 100%;
        background: #fe2e0c;
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        padding: 12px 0;
        margin-top: 14px;
        font-size: 1.12rem;
        cursor: pointer;
        box-shadow: 0 3px 11px 0 rgba(254, 46, 12, .07);
    }

    @media(max-width:600px) {
        #calendar_admin_details_create_cohort_modal {
            padding: 16px 2vw;
        }

        .calendar_admin_details_create_cohort_row>div {
            flex: 1 1 100%;
        }

        .calendar_admin_details_create_cohort_tabs {
            font-size: .97rem;
        }

        .conference_modal_fieldrow {
            flex-direction: column;
            gap: 8px;
        }

        .calendar_admin_details_create_cohort_calendar_modal {
            width: 96vw;
            padding: 13px 1vw;
        }
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
        width: 22px;
        height: 22px;
        border-radius: 50%;
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

    @media(max-width:600px) {
        .color-dropdown-list {
            min-width: 46px;
        }

        .color-dropdown-toggle {
            width: 44px;
            height: 28px;
        }

        .color-dropdown-color {
            width: 22px;
            height: 22px;
        }
    }




    .conference_modal_lists_row {
        display: flex;
        gap: 28px;
        justify-content: space-between;
        align-items: flex-start;
    }

    .conference_modal_lists_row>.conference_modal_attendees_section {
        flex: 1 1 0;
    }

    .conference_modal_cohort_list,
    .conference_modal_attendees_list {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 11px #0002;
        padding: 0;
        margin: 0;
        list-style: none;
        min-height: 42px;
    }

    .conference_modal_cohort_list li,
    .conference_modal_attendees_list li {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 12px 16px;
        border-bottom: 1px solid #f1f1f1;
        font-size: 1.02rem;
        background: #fff;
    }

    .conference_modal_cohort_list li:last-child,
    .conference_modal_attendees_list li:last-child {
        border-bottom: none;
    }

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
        width: 24px;
        height: 24px;
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




    /* .calendar_admin_details_cohort_tab_time_buttons_row {
  display: flex;
  align-items: center;
  gap: 0;
  width: 100%;
} */

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
        width: 15px;
        /* Adjust width to your need */
        height: 1px;
        background: #ff3c1a;
        /* Or #fe2e0c if you use that elsewhere */
        margin: 0 4px;
        border-radius: 2px;
        margin-top: 15px;
    }


    <style>.calendar_admin_details_cohort_tab_timezone_wrapper {
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
        height: 50px;
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













    /* White circular trash chip positioned just below the + */
    .calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_remove {
        position: absolute;
        right: 6px;
        /* aligns with the + on the right edge */
        top: 50%;
        transform: translateY(28px);
        /* places it below the + */
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        background: #fff !important;
        /* white chip */
        color: #ff2f1b;
        /* red trash icon */
        border: 1px solid #e7e7ef;
        /* subtle ring */
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(0, 0, 0, .12);
        /* soft shadow like your mock */
        z-index: 2;
    }

    .calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_remove svg {
        width: 18px;
        height: 18px;
        display: block;
        fill: currentColor;
        /* inherit the red color */
    }

    .calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_remove:hover {
        border-color: #ff2f1b;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .14);
    }




























    /* === Class Name dropdown: card style like snapshot === */
    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_dropdown_wrapper {
        position: relative;

    }

    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_btn {
        border: 1.8px solid #232323;
        /* crisp border like mock */
        border-radius: 12px;
        height: 56px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 14px;
    }

    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_btn svg {
        transition: transform .18s;
    }

    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_btn.open svg {
        transform: rotate(180deg);
    }

    /* The menu card */
    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_list {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        /* little gap under the button */
        left: 0;
        width: 100%;
        /* same width as button */
        background: #ffffff;
        border: none !important;
        /* remove old border */
        border-radius: 16px;
        box-shadow: 0 18px 36px rgba(0, 0, 0, .12), 0 6px 16px rgba(0, 0, 0, .06);
        padding: 8px 6px;
        z-index: 120;
        /* above sticky footer btn */
    }

    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_list ul {
        list-style: none;
        margin: 0;
        padding: 6px;
    }

    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_list li {
        padding: 13px 14px;
        font-size: 1.06rem;
        color: #232323;
        border-radius: 10px;
        cursor: pointer;
        transition: background .12s ease;
    }

    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_list li:hover,
    #calendar_admin_details_create_cohort_modal .calendar_admin_details_create_cohort_class_list li.selected {
        background: #f7f7f7;
        /* subtle hover like snapshot */
    }








    /* Tabs: light background on hover, don't change active */
    .calendar_admin_details_create_cohort_tab {
        /* border-radius: 10px; */
        transition: background .15s ease;
    }

    /* Hover only affects non-active tabs */
    .calendar_admin_details_create_cohort_tab:not(.active):hover {
        background: #f7f7f9;
        /* light pill bg */
        box-shadow: none;
        /* cancel any earlier shadow rules */
        transform: none;
        /* no lift */
        /* color left unchanged on purpose */
    }

    /* Keep active look exactly the same, even on hover */
    .calendar_admin_details_create_cohort_tab.active,
    .calendar_admin_details_create_cohort_tab.active:hover {
        background: transparent;
        color: #fe2e0c;
        border-bottom: 3px solid #fe2e0c;
    }

    .field-error {
        outline: 2px solid #ff4d4f !important;
        border-color: #ff4d4f !important;
        box-shadow: 0 0 0 3px rgba(255, 77, 79, .25) !important;
        transition: box-shadow .2s ease;
    }
    </style>

</head>

<body>

    <!-- <button id="calendar_admin_details_create_cohort_open">Create Cohort</button> -->
    <div id="calendar_admin_details_create_cohort_modal_backdrop">
        <div id="calendar_admin_details_create_cohort_modal">
            <span class="calendar_admin_details_create_cohort_close">&times;</span>
            <h2>Management</h2>
            <div class="calendar_admin_details_create_cohort_tabs_scroll">
                <div class="calendar_admin_details_create_cohort_tabs">
                    <div class="calendar_admin_details_create_cohort_tab active" data-tab="cohort">Cohort</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="manage">Manage Cohort</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="class">1:1 Class</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="merge">Merge</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="conference">Conference</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="peertalk">Peer Talk</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="addtime">Add Time</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="extraslots">Add Extra Slots</div>
                </div>
            </div>

            <div class="calendar_admin_details_create_cohort_content" id="mainModalContent">






                <div class="calendar_admin_details_create_cohort_row">
                    <div class="container-fluid">
                        <!-- One row, fixed halves -->
                        <div class="d-flex mb-3" style="gap:16px;">

                            <!-- Left column -->
                            <div class="position-relative" style="flex:1 1 0;max-width:50%;box-sizing:border-box;">
                                <label for="cohortInput" class="form-label"
                                    style="font-weight:500;color:#232323;font-size:1.05rem;display:block;margin-bottom:6px;">
                                    Cohort
                                </label>

                                <!-- Wrap to anchor tooltip below the input -->
                                <div style="position:relative;display:block;">
                                    <input type="text" readonly aria-readonly="true"
                                        class="form-control cohort-tooltip-target" id="cohortInput"
                                        placeholder="XXX-#-#####-###" style="width:100%;height:50px;border-radius:12px;border:1.5px solid #e3e3e7;
                        font-size:1rem;color:#818191;font-weight:500;background:#fff;
                        letter-spacing:2px;cursor:default;">

                                    <!-- Tooltip: BELOW the field -->
                                    <div class="custom-tooltip" style="display:none;position:absolute;left:0;top:calc(100% + 8px);
                      background:#111;color:#fff;border-radius:20px;padding:8px 14px;
                      font-size:.95rem;font-weight:500;white-space:nowrap;
                      box-shadow:0 6px 18px rgba(0,0,0,.25);pointer-events:none;z-index:10;">
                                        <span
                                            style="font-size:1.2em;vertical-align:-2px;margin-right:6px;">&#9432;</span>
                                        Start selecting below
                                    </div>
                                </div>
                            </div>

                            <!-- Right column -->
                            <div class="position-relative" style="flex:1 1 0;max-width:50%;box-sizing:border-box;">
                                <label for="cohortShortInput" class="form-label"
                                    style="font-weight:500;color:#232323;font-size:1.05rem;display:block;margin-bottom:6px;">
                                    Cohort’s Short Name
                                </label>

                                <div style="position:relative;display:block;">
                                    <input type="text" readonly aria-readonly="true"
                                        class="form-control cohort-tooltip-target" id="cohortShortInput"
                                        placeholder="XX#" style="width:100%;height:50px;border-radius:12px;border:1.5px solid #e3e3e7;
                        font-size:1rem;color:#818191;font-weight:500;background:#fff;
                        letter-spacing:2px;cursor:default;">

                                    <!-- Tooltip: BELOW the field -->
                                    <div class="custom-tooltip" style="display:none;position:absolute;left:0;top:calc(100% + 8px);
                      background:#111;color:#fff;border-radius:20px;padding:8px 14px;
                      font-size:.95rem;font-weight:500;white-space:nowrap;
                      box-shadow:0 6px 18px rgba(0,0,0,.25);pointer-events:none;z-index:10;">
                                        <span
                                            style="font-size:1.2em;vertical-align:-2px;margin-right:6px;">&#9432;</span>
                                        Start selecting below
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>




                </div>



                <!-- Event navigation -->
                <div class="calendar_admin_details_create_cohort_event_nav">
                    <div class="calendar_event_group">
                        <button type="button" class="calendar_event_nav_btn prev" aria-label="Previous">
                            <svg viewBox="0 0 24 24">
                                <polyline points="15 19 8 12 15 5" stroke="currentColor" stroke-width="2.2" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <span class="calendar_event_nav_title">Events</span>

                        <button type="button" class="calendar_event_nav_btn next" aria-label="Next">
                            <svg viewBox="0 0 24 24">
                                <polyline points="9 5 16 12 9 19" stroke="currentColor" stroke-width="2.2" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <!-- this keeps the red + visible on the far right -->
                    <button type="button" class="calendar_admin_details_create_cohort_add">+</button>

                    <!-- NEW: delete button -->
                    <button type="button" class="calendar_admin_details_create_cohort_remove"
                        aria-label="Remove last teacher">
                        <!-- trash icon -->
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M9 3h6a1 1 0 0 1 1 1v1h4v2h-1v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7H4V5h4V4a1 1 0 0 1 1-1Zm1 2v0h4V4h-4v1Zm-2 2v12h8V7H8Zm2 2h2v8h-2V9Zm4 0h2v8h-2V9Z" />
                        </svg>
                    </button>
                </div>





















                <!-- 2-up teacher carousel -->
                <div class="calendar_admin_details_create_cohort_row" id="teacherBlocks">
                    <!-- Teacher 1 -->
                    <div class="teacher-block" data-teacher="1">
                        <div>
                            <!-- <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
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
      </div> -->


                            <?php
require_once(__DIR__ . '/../../config.php');
require_login();

global $DB, $PAGE, $OUTPUT;

/** Collect unique teacher user IDs from cohorts */
$userids = $DB->get_fieldset_sql("
    SELECT DISTINCT uid
      FROM (
            SELECT cohortmainteacher AS uid FROM {cohort}
             WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
            UNION
            SELECT cohortguideteacher AS uid FROM {cohort}
             WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
      ) t
");

/** Fetch user records (not deleted/suspended) */
$teachers = [];
if ($userids) {
    list($insql, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
    $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
    $teachers = $DB->get_records_select('user', "id $insql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
}

/** Build reusable <li> HTML */
$teachers_li_html = '';
if ($teachers) {
    foreach ($teachers as $t) {
        $pic = new user_picture($t);
        $pic->size = 50;
        $url  = $pic->get_url($PAGE)->out(false);
        $name = fullname($t, true);

        $teachers_li_html .= '<li class="teacher-option" data-userid="'.(int)$t->id.'" data-name="'.s($name).'" data-pic="'.s($url).'">'
            .'<img src="'.s($url).'" class="calendar_admin_details_create_cohort_teacher_avatar" alt="'.s($name).'">'
            .'<span style="margin-left:10px;">'.format_string($name).'</span>'
            .'</li>';
    }
} else {
    $teachers_li_html = '<li class="muted">No teachers found</li>';
}
?>

                            <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
                                <label>Teacher 1</label>

                                <div class="calendar_admin_details_create_cohort_teacher_btn" id="teacher1DropdownBtn">
                                    <span class="label">Select Teacher</span>
                                    <svg viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3"></path>
                                    </svg>
                                </div>

                                <!-- store the selected teacher id for this block -->
                                <input type="hidden" name="teacher1_userid" id="teacher1UserId" value="">

                                <div class="calendar_admin_details_create_cohort_teacher_list"
                                    id="teacher1DropdownList">
                                    <ul>
                                        <?php echo $teachers_li_html; ?>
                                    </ul>
                                </div>
                            </div>


                            <script>
                            (function() {
                                // For every teacher dropdown wrapper on the page
                                document.querySelectorAll(
                                        '.calendar_admin_details_create_cohort_teacher_dropdown_wrapper')
                                    .forEach(function(wrapper) {

                                        const btn = wrapper.querySelector(
                                            '.calendar_admin_details_create_cohort_teacher_btn');
                                        const list = wrapper.querySelector(
                                            '.calendar_admin_details_create_cohort_teacher_list');
                                        const label = btn.querySelector('.label') ||
                                            btn; // fallback if label span missing
                                        const hidden = wrapper.querySelector('input[type="hidden"]');

                                        // Open/close the list
                                        btn.addEventListener('click', function(e) {
                                            if (!e.target.closest(
                                                    '.calendar_admin_details_create_cohort_teacher_list'
                                                )) {
                                                list.classList.toggle(
                                                    'open'); // make sure CSS shows .open
                                            }
                                        });

                                        // Close when clicking outside this wrapper
                                        document.addEventListener('click', function(e) {
                                            if (!wrapper.contains(e.target)) list.classList.remove(
                                                'open');
                                        });

                                        // Select a teacher
                                        list.addEventListener('click', function(e) {
                                            const li = e.target.closest('li.teacher-option');
                                            if (!li) return;

                                            // Update label text (you can also inject the avatar if you want)
                                            label.textContent = li.dataset.name;

                                            // Save selected id
                                            if (hidden) hidden.value = li.dataset.userid;

                                            // Close
                                            list.classList.remove('open');
                                        });
                                    });
                            })();
                            </script>


                            <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
                                <label>Class Name</label>
                                <div class="calendar_admin_details_create_cohort_class_btn" id="className1DropdownBtn">
                                    Select Class
                                    <svg viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3"></path>
                                    </svg>
                                </div>

                                <div class="calendar_admin_details_create_cohort_class_list"
                                    id="className1DropdownList">
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
                                    <input type="text" class="form-control time-input" value="9:30 am"
                                        autocomplete="off" readonly style="background-color:#ffffff;" />
                                    <div class="custom-time-dropdown"></div>
                                </div>
                                <div class="time-dash">–</div>
                                <div class="custom-time-pill">
                                    <input type="text" class="form-control time-input" value="10:30 am"
                                        autocomplete="off" readonly style="background-color:#ffffff;" />
                                    <div class="custom-time-dropdown"></div>
                                </div>
                            </div>





                            <div class="calendar_admin_details_cohort_tab_timezone_wrapper" style="margin-top:10px;">
                                <label class="calendar_admin_details_cohort_tab_timezone_label">Event time zone</label>
                                <div class="calendar_admin_details_cohort_tab_timezone_dropdown"
                                    id="eventTimezoneDropdown">
                                    <span id="eventTimezoneSelected">(GMT-05:00) Eastern</span>
                                    <svg class="calendar_admin_details_cohort_tab_timezone_arrow" width="18" height="18"
                                        viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none"
                                            stroke-linecap="round" />
                                    </svg>
                                    <div class="calendar_admin_details_cohort_tab_timezone_list"
                                        id="eventTimezoneDropdownList">
                                        <ul>
                                            <li>(GMT-12:00) International Date Line West</li>
                                            <li>(GMT-11:00) Midway Island, Samoa</li>
                                            <li>(GMT-10:00) Hawaii</li>
                                            <li>(GMT-09:00) Alaska</li>
                                            <li>(GMT-08:00) Pacific Time (US & Canada)</li>
                                            <li>(GMT-07:00) Mountain Time (US & Canada)</li>
                                            <li>(GMT-06:00) Central Time (US & Canada)</li>
                                            <li>(GMT-05:00) Eastern Time (US & Canada)</li>
                                            <li>(GMT+00:00) London</li>
                                            <li>(GMT+01:00) Berlin, Paris</li>
                                            <li>(GMT+03:00) Moscow, Nairobi</li>
                                            <li>(GMT+05:00) Pakistan</li>
                                            <li>(GMT+05:30) India</li>
                                            <li>(GMT+08:00) Beijing, Singapore</li>
                                            <li>(GMT+09:00) Tokyo, Seoul</li>
                                            <li>(GMT+10:00) Sydney</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <label style="margin-top:20px;">Start On</label>
                            <button class="conference_modal_date_btn">Select Date</button>

                            <div class="create_new_cohort_tab_select_color_left_row">
                                <label class="create_new_cohort_tab_select_color_left_label">Find a time</label>
                                <div class="create_new_cohort_tab_select_color_left_dropdown"
                                    id="createNewCohortSelectColorLeft">
                                    <span class="create_new_cohort_tab_select_color_left_selected"
                                        id="createNewCohortSelectedColorLeft">
                                        <span class="create_new_cohort_tab_select_color_left_circle"
                                            style="background:#1649c7"></span>
                                    </span>
                                    <svg width="18" height="18" class="create_new_cohort_tab_select_color_left_arrow"
                                        viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none"
                                            stroke-linecap="round" />
                                    </svg>
                                    <div class="create_new_cohort_tab_select_color_left_list"
                                        id="createNewCohortColorListLeft">
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
                            <!-- <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
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
      </div> -->



                            <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper"
                                id="teacher2Wrapper">
                                <label>Teacher 2</label>

                                <div class="calendar_admin_details_create_cohort_teacher_btn" id="teacher2DropdownBtn">
                                    <span class="label">Select Teacher</span>
                                    <svg viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3"></path>
                                    </svg>
                                </div>

                                <!-- store the selected Teacher 2 user id -->
                                <input type="hidden" name="teacher2_userid" id="teacher2UserId" value="">

                                <div class="calendar_admin_details_create_cohort_teacher_list"
                                    id="teacher2DropdownList">
                                    <ul>
                                        <?php echo $teachers_li_html; ?>
                                    </ul>
                                </div>
                            </div>

                            <script>
                            $('#teacher2DropdownList').on('click', 'li.teacher-option', function() {
                                $('#teacher2UserId').val($(this).data('userid') || '');
                            });
                            </script>

                            <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
                                <label>Class Name</label>

                                <div class="calendar_admin_details_create_cohort_class_btn" id="className2DropdownBtn">
                                    Select Class
                                    <svg viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3"></path>
                                    </svg>
                                </div>

                                <div class="calendar_admin_details_create_cohort_class_list"
                                    id="className2DropdownList">
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
                                    <input type="text" class="form-control calendar_admin_details_time_right_time-input"
                                        value="9:30 am" autocomplete="off" readonly style="background-color:#ffffff;" />
                                    <div class="calendar_admin_details_time_right_time-dropdown"></div>
                                </div>
                                <div class="calendar_admin_details_time_right_time-dash">–</div>
                                <div class="calendar_admin_details_time_right_time-pill">
                                    <input type="text" class="form-control calendar_admin_details_time_right_time-input"
                                        value="10:30 am" autocomplete="off" readonly
                                        style="background-color:#ffffff;" />
                                    <div class="calendar_admin_details_time_right_time-dropdown"></div>
                                </div>
                            </div>

                            <div class="calendar_admin_details_cohort_tab_timezone_wrapper_right">
                                <label class="calendar_admin_details_cohort_tab_timezone_label_right">Event time
                                    zone</label>
                                <div class="calendar_admin_details_cohort_tab_timezone_dropdown_right"
                                    id="eventTimezoneDropdownRight">
                                    <span id="eventTimezoneSelectedRight">(GMT+05:00) Pakistan</span>
                                    <svg class="calendar_admin_details_cohort_tab_timezone_arrow_right" width="18"
                                        height="18" viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none"
                                            stroke-linecap="round" />
                                    </svg>
                                    <div class="calendar_admin_details_cohort_tab_timezone_list_right"
                                        id="eventTimezoneDropdownListRight">
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
                                <div class="create_new_cohort_tab_select_color_right_dropdown"
                                    id="createNewCohortSelectColorRight">
                                    <span class="create_new_cohort_tab_select_color_right_selected"
                                        id="createNewCohortSelectedColorRight">
                                        <span class="create_new_cohort_tab_select_color_right_circle"
                                            style="background:#1649c7"></span>
                                    </span>
                                    <svg width="18" height="18" class="create_new_cohort_tab_select_color_right_arrow"
                                        viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none"
                                            stroke-linecap="round" />
                                    </svg>
                                    <div class="create_new_cohort_tab_select_color_right_list"
                                        id="createNewCohortColorListRight">
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









                <button class="calendar_admin_details_create_cohort_btn">Create Cohort</button>
            </div>





            <script>
            (function() {
                // ---------------- utils ----------------
                const $ = (sel, root = document) => root.querySelector(sel);
                const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
                const txt = (sel, root = document) => (root.querySelector(sel)?.textContent ?? "").trim();
                const val = (sel, root = document) => (root.querySelector(sel)?.value ?? "").trim();

                const clearErrors = () => $$('.field-error').forEach(n => n.classList.remove('field-error'));
                const highlightFocus = (node) => {
                    if (!node) return;
                    node.classList.add('field-error');
                    node.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    const focusable = node.matches('input,button,select,textarea') ?
                        node : (node.querySelector('input,button,select,textarea') || node);
                    focusable.focus?.();
                    setTimeout(() => node.classList.remove('field-error'), 1800);
                };

                const rgbToHex = (rgb) => {
                    if (!rgb) return null;
                    const m = rgb.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
                    if (!m) return null;
                    const toHex = (n) => ('0' + (parseInt(n, 10) & 255).toString(16)).slice(-2).toUpperCase();
                    return `#${toHex(m[1])}${toHex(m[2])}${toHex(m[3])}`;
                };

                // accepts "9:30 am", "06:00 PM", "9 am" → {hour, minute, label}
                const parseTime12to24 = (s) => {
                    if (!s) return null;
                    const m = s.trim().match(/^(\d{1,2})(?::(\d{2}))?\s*([ap]m)$/i);
                    if (!m) return null;
                    let h = parseInt(m[1], 10);
                    const min = parseInt(m[2] ?? '0', 10);
                    const ampm = m[3].toLowerCase();
                    if (ampm === 'pm' && h < 12) h += 12;
                    if (ampm === 'am' && h === 12) h = 0;
                    return {
                        hour: h,
                        minute: min,
                        label: s.trim()
                    };
                };

                const mins = (t) => (t && Number.isFinite(t.hour) && Number.isFinite(t.minute)) ?
                    (t.hour * 60 + t.minute) : null;

                // "22 Oct 2025" / "2025-10-22" → unix; "Select Date" → null
                const parseDateLabelToUnix = (label) => {
                    if (!label || /select date/i.test(label)) return null;
                    const d = new Date(label);
                    return isNaN(d.getTime()) ? null : Math.floor(d.getTime() / 1000);
                };

                // strip ▼ and whitespace noise
                const cleanBtnText = (btn) => (btn?.textContent ?? '')
                    .replace(/▼/g, '')
                    .replace(/\s+/g, ' ')
                    .trim();

                // rough IANA mapping from visible labels (extend as needed)
                const tzLabelToIana = (label) => {
                    const s = (label || '').toLowerCase();
                    if (!s) return null;
                    if (s.includes('international date line')) return 'Etc/GMT+12';
                    if (s.includes('midway') || s.includes('samoa')) return 'Pacific/Pago_Pago';
                    if (s.includes('hawaii')) return 'Pacific/Honolulu';
                    if (s.includes('alaska')) return 'America/Anchorage';
                    if (s.includes('pacific')) return 'America/Los_Angeles';
                    if (s.includes('mountain')) return 'America/Denver';
                    if (s.includes('central')) return 'America/Chicago';
                    if (s.includes('eastern')) return 'America/New_York';
                    if (s.includes('london')) return 'Europe/London';
                    if (s.includes('berlin') || s.includes('paris')) return 'Europe/Berlin';
                    if (s.includes('moscow')) return 'Europe/Moscow';
                    if (s.includes('nairobi')) return 'Africa/Nairobi';
                    if (s.includes('pakistan')) return 'Asia/Karachi';
                    if (s.includes('india')) return 'Asia/Kolkata';
                    if (s.includes('beijing') || s.includes('singapore')) return 'Asia/Singapore';
                    if (s.includes('tokyo') || s.includes('seoul')) return 'Asia/Tokyo';
                    if (s.includes('sydney')) return 'Australia/Sydney';
                    return null;
                };

                // --------- SIMPLE day helpers (names only) ---------
                const DAY_NAMES = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                const RANGE_RE =
                    /(\bSun|\bMon|\bTue|\bWed|\bThu|\bFri|\bSat)\s*[–-]\s*(Sun|Mon|Tue|Wed|Thu|Fri|Sat)/i;

                // read 'pressed/checked/selected' from an element
                const daySelected = (node) => {
                    if (!node) return false;
                    if (node.matches('input[type=checkbox],input[type=radio]')) return !!node.checked;
                    if (node.hasAttribute('aria-pressed')) return node.getAttribute('aria-pressed') === 'true';
                    return node.classList.contains('selected') || node.classList.contains('active');
                };

                // Collect selected day NAMES inside a teacher block
                const collectSelectedDays = (root, opts = {
                    tutor: false
                }) => {
                    const pref = opts.tutor ? 'tutor-' : '';
                    const sel = (day) => [
                        `[data-${pref}day="${day}"]`,
                        `.${pref ? pref : ''}day-${day.slice(0,3)}`
                    ].join(',');

                    const order = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday',
                        'saturday'
                    ];
                    const picked = [];

                    order.forEach(n => {
                        const node = root.querySelector(sel(n));
                        if (daySelected(node)) {
                            const name = n[0].toUpperCase() + n.slice(1, 3); // "Sun","Mon","Tue",...
                            picked.push(name);
                        }
                    });

                    return picked; // ["Tue","Wed"]
                };

                // Parse a "Mon, Wed" / "Mon–Fri" string into ["Mon","Wed"] or ["Mon","Tue","Wed","Thu","Fri"]
                const parseDaysList = (s) => {
                    if (!s) return [];
                    let str = s.trim();

                    // "Mon–Fri" range
                    const r = str.match(RANGE_RE);
                    if (r) {
                        const start = DAY_NAMES.indexOf(r[1].substr(0, 3));
                        const end = DAY_NAMES.indexOf(r[2].substr(0, 3));
                        if (start !== -1 && end !== -1) {
                            const out = [];
                            for (let i = start; i !== (end + 1) % 7; i = (i + 1) % 7) {
                                out.push(DAY_NAMES[i]);
                                if (i === end) break;
                            }
                            return out;
                        }
                    }

                    // "Fri, Sat" list
                    return str.split(/\s*,\s*/).map(x => {
                        const m = (x.match(/Sun|Mon|Tue|Wed|Thu|Fri|Sat/i) || [])[0];
                        return m ? m.substr(0, 3)[0].toUpperCase() + m.substr(1, 2).toLowerCase() :
                            null;
                    }).filter(Boolean);
                };

                // Parse schedule label text into object {type, doesRepeat, interval, days[], label}
                // Supports: "Does not repeat", "Weekly on Tue, Wed", "Every week on Fri", "Every 2 weeks on Fri, Sat",
                //           "Every weekday", "Daily", "Every N days"
                const parseScheduleFromLabel = (label) => {
                    const raw = (label || '').replace(/▼/g, '').trim();
                    if (!raw) return {
                        type: 'UNKNOWN',
                        doesRepeat: false,
                        interval: null,
                        days: [],
                        label: ''
                    };

                    // none
                    if (/does not repeat/i.test(raw)) {
                        return {
                            type: 'NONE',
                            doesRepeat: false,
                            interval: null,
                            days: [],
                            label: 'Does not repeat'
                        };
                    }

                    // weekday
                    if (/every\s+weekday/i.test(raw)) {
                        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
                        return {
                            type: 'WEEKLY',
                            doesRepeat: true,
                            interval: 1,
                            days,
                            label: `Weekly on ${days.join(', ')}`
                        };
                    }

                    // daily
                    if (/^daily$/i.test(raw)) {
                        return {
                            type: 'DAILY',
                            doesRepeat: true,
                            interval: 1,
                            days: [],
                            label: 'Daily'
                        };
                    }
                    const mDailyN = raw.match(/^every\s+(\d+)\s+days?$/i);
                    if (mDailyN) {
                        const n = Math.max(1, parseInt(mDailyN[1], 10));
                        return {
                            type: 'DAILY',
                            doesRepeat: true,
                            interval: n,
                            days: [],
                            label: `Every ${n} days`
                        };
                    }

                    // weekly forms
                    // "Weekly on Tue, Wed"
                    const mWeeklyOn = raw.match(/^weekly\s+on\s+(.+)$/i);
                    if (mWeeklyOn) {
                        const days = parseDaysList(mWeeklyOn[1]);
                        return {
                            type: 'WEEKLY',
                            doesRepeat: true,
                            interval: 1,
                            days,
                            label: `Weekly on ${days.join(', ')}`
                        };
                    }

                    // "Every week on Fri" | "Every 2 weeks on Fri, Sat"
                    const mEveryWeeks = raw.match(/^every\s+(\d+)?\s*weeks?\s+on\s+(.+)$/i);
                    if (mEveryWeeks) {
                        const n = Math.max(1, parseInt(mEveryWeeks[1] || '1', 10));
                        const days = parseDaysList(mEveryWeeks[2]);
                        return {
                            type: 'WEEKLY',
                            doesRepeat: true,
                            interval: n,
                            days,
                            label: `Every ${n} week${n>1?'s':''} on ${days.join(', ')}`
                        };
                    }

                    // fallback: unknown text
                    return {
                        type: 'UNKNOWN',
                        doesRepeat: true,
                        interval: 1,
                        days: [],
                        label: raw
                    };
                };

                // find name via selected li (when label didn't update for some reason)
                const getTeacherNameById = (listSel, id) => {
                    if (!id) return '';
                    const li = document.querySelector(`${listSel} li.teacher-option[data-userid="${id}"]`);
                    return li?.dataset?.name?.trim() || '';
                };

                const getColorHex = (sel) => {
                    const circle = $(sel);
                    const bg = circle ? getComputedStyle(circle).backgroundColor : '';
                    return rgbToHex(bg);
                };

                const inferClassType = (className) => {
                    const s = (className || '').toLowerCase();
                    if (s.includes('main')) return 'main';
                    if (s.includes('tutor')) return 'tutor';
                    if (s.includes('convers')) return 'conversation';
                    return 'class';
                };

                // ---------------- readers ----------------
                const readTeacher1 = () => {
                    const root = $('.teacher-block[data-teacher="1"]') || document;

                    const times = $$('#customTimeFields .time-input');
                    const startLabel = times[0]?.value?.trim() || '';
                    const endLabel = times[1]?.value?.trim() || '';

                    const tzLabel = txt('#eventTimezoneSelected');
                    const dateLabel = root.querySelector('.conference_modal_date_btn')?.textContent.trim() ||
                        '';

                    const idVal = val('#teacher1UserId');
                    let fullName = txt('#teacher1DropdownBtn .label');
                    if (!fullName) fullName = getTeacherNameById('#teacher1DropdownList', idVal);
                    const shortName = fullName.split(/\s+/).slice(-1)[0] || '';

                    const className = cleanBtnText($('#className1DropdownBtn'));
                    const labelFromBtn = cleanBtnText(root.querySelector(
                        '.cohort_schedule_box .cohort_schedule_btn') || $(
                        '.cohort_schedule_box .cohort_schedule_btn'));
                    const parsedFromLabel = parseScheduleFromLabel(labelFromBtn);

                    // Try DOM day buttons first (if they exist in this block), else keep parsed days from label
                    const domDays = collectSelectedDays(root, {
                        tutor: false
                    });
                    const schedule = (domDays.length) ? {
                            ...parsedFromLabel,
                            type: 'WEEKLY',
                            doesRepeat: true,
                            interval: parsedFromLabel.interval || 1,
                            days: domDays,
                            label: `Weekly on ${domDays.join(', ')}`
                        } :
                        parsedFromLabel;

                    return {
                        id: idVal || null,
                        fullName,
                        shortName,
                        className,
                        classType: inferClassType(className),

                        timeStartLabel: startLabel,
                        timeEndLabel: endLabel,
                        timeStart24: parseTime12to24(startLabel),
                        timeEnd24: parseTime12to24(endLabel),

                        timezoneLabel: tzLabel,
                        timezoneIANA: tzLabelToIana(tzLabel),

                        colorHex: getColorHex(
                            '#createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle'
                        ),

                        scheduleLabel: schedule.label,
                        schedule,

                        startDateLabel: dateLabel,
                        startDateUnix: parseDateLabelToUnix(dateLabel)
                    };
                };

                const readTeacher2 = () => {
                    const root = $('.teacher-block[data-teacher="2"]') || document;

                    const times = $$(
                        '.calendar_admin_details_time_right .calendar_admin_details_time_right_time-input');
                    const startLabel = times[0]?.value?.trim() || '';
                    const endLabel = times[1]?.value?.trim() || '';

                    const tzLabel = txt('#eventTimezoneSelectedRight');
                    const dateLabel = root.querySelector('.conference_modal_date_btn')?.textContent.trim() ||
                        '';

                    const idVal = val('#teacher2UserId');
                    let fullName = txt('#teacher2DropdownBtn .label');
                    if (!fullName) fullName = getTeacherNameById('#teacher2DropdownList', idVal);
                    const shortName = fullName.split(/\s+/).slice(-1)[0] || '';

                    const className = cleanBtnText($('#className2DropdownBtn'));
                    const labelFromBtn = cleanBtnText(root.querySelector(
                        '.cohort_schedule_box .cohort_schedule_btn'));
                    const parsedFromLabel = parseScheduleFromLabel(labelFromBtn);

                    const domDays = collectSelectedDays(root, {
                        tutor: true
                    });
                    const schedule = (domDays.length) ? {
                            ...parsedFromLabel,
                            type: 'WEEKLY',
                            doesRepeat: true,
                            interval: parsedFromLabel.interval || 1,
                            days: domDays,
                            label: `Weekly on ${domDays.join(', ')}`
                        } :
                        parsedFromLabel;

                    return {
                        id: idVal || null,
                        fullName,
                        shortName,
                        className,
                        classType: inferClassType(className),

                        timeStartLabel: startLabel,
                        timeEndLabel: endLabel,
                        timeStart24: parseTime12to24(startLabel),
                        timeEnd24: parseTime12to24(endLabel),

                        timezoneLabel: tzLabel,
                        timezoneIANA: tzLabelToIana(tzLabel),

                        colorHex: getColorHex(
                            '#createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle'
                        ),

                        scheduleLabel: schedule.label,
                        schedule,

                        startDateLabel: dateLabel,
                        startDateUnix: parseDateLabelToUnix(dateLabel)
                    };
                };

                // ---------------- validation ----------------
                const validate = ({
                    t1,
                    t2
                }) => {
                    const errors = [];

                    // Cohort basics
                    const cohortIdEl = $('#cohortInput');
                    const cohortShortEl = $('#cohortShortInput');
                    if (!val('#cohortInput')) errors.push({
                        msg: 'Cohort is required',
                        node: cohortIdEl
                    });
                    if (!val('#cohortShortInput')) errors.push({
                        msg: 'Cohort short name is required',
                        node: cohortShortEl
                    });

                    // Teacher 1
                    if (!t1.id || !t1.fullName || /select teacher/i.test(t1.fullName)) {
                        errors.push({
                            msg: 'Select Teacher 1',
                            node: $('#teacher1DropdownBtn')
                        });
                    }
                    if (!t1.className || /select class/i.test(t1.className)) {
                        errors.push({
                            msg: 'Select Class for Teacher 1',
                            node: $('#className1DropdownBtn')
                        });
                    }
                    if (!t1.scheduleLabel) {
                        errors.push({
                            msg: 'Choose a schedule for Teacher 1',
                            node: $(
                                    '.teacher-block[data-teacher="1"] .cohort_schedule_box .cohort_schedule_btn'
                                ) ||
                                $('.cohort_schedule_box .cohort_schedule_btn')
                        });
                    }
                    // If it's a weekly schedule (either "Weekly on ..." or "Every N weeks on ..."), require days
                    if (t1.schedule.type === 'WEEKLY' && (!t1.schedule.days.length)) {
                        errors.push({
                            msg: 'Teacher 1 schedule is weekly but no days were selected',
                            node: $(
                                    '.teacher-block[data-teacher="1"] .cohort_schedule_box .cohort_schedule_btn'
                                ) ||
                                $('.cohort_schedule_box .cohort_schedule_btn')
                        });
                    }
                    if (!t1.timeStartLabel || !t1.timeEndLabel) {
                        errors.push({
                            msg: 'Pick start & end time for Teacher 1',
                            node: $('#customTimeFields')
                        });
                    } else {
                        const s = mins(t1.timeStart24),
                            e = mins(t1.timeEnd24);
                        if (s !== null && e !== null && e <= s) {
                            errors.push({
                                msg: 'Teacher 1: End time must be after start time',
                                node: $('#customTimeFields')
                            });
                        }
                    }
                    if (!t1.timezoneLabel) {
                        errors.push({
                            msg: 'Pick event time zone for Teacher 1',
                            node: $('#eventTimezoneDropdown')
                        });
                    }
                    if (!t1.startDateUnix) {
                        errors.push({
                            msg: 'Select Start Date for Teacher 1',
                            node: $('.teacher-block[data-teacher="1"] .conference_modal_date_btn') || $(
                                '#mainModalContent')
                        });
                    }

                    // Teacher 2
                    if (!t2.id || !t2.fullName || /select teacher/i.test(t2.fullName)) {
                        errors.push({
                            msg: 'Select Teacher 2',
                            node: $('#teacher2DropdownBtn')
                        });
                    }
                    if (!t2.className || /select class/i.test(t2.className)) {
                        errors.push({
                            msg: 'Select Class for Teacher 2',
                            node: $('#className2DropdownBtn')
                        });
                    }
                    if (!t2.scheduleLabel) {
                        errors.push({
                            msg: 'Choose a schedule for Teacher 2',
                            node: $(
                                '.teacher-block[data-teacher="2"] .cohort_schedule_box .cohort_schedule_btn'
                            )
                        });
                    }
                    if (t2.schedule.type === 'WEEKLY' && (!t2.schedule.days.length)) {
                        errors.push({
                            msg: 'Teacher 2 schedule is weekly but no days were selected',
                            node: $(
                                '.teacher-block[data-teacher="2"] .cohort_schedule_box .cohort_schedule_btn'
                            )
                        });
                    }
                    if (!t2.timeStartLabel || !t2.timeEndLabel) {
                        errors.push({
                            msg: 'Pick start & end time for Teacher 2',
                            node: $('.calendar_admin_details_time_right')
                        });
                    } else {
                        const s = mins(t2.timeStart24),
                            e = mins(t2.timeEnd24);
                        if (s !== null && e !== null && e <= s) {
                            errors.push({
                                msg: 'Teacher 2: End time must be after start time',
                                node: $('.calendar_admin_details_time_right')
                            });
                        }
                    }
                    if (!t2.timezoneLabel) {
                        errors.push({
                            msg: 'Pick event time zone for Teacher 2',
                            node: $('#eventTimezoneDropdownRight')
                        });
                    }
                    if (!t2.startDateUnix) {
                        errors.push({
                            msg: 'Select Start Date for Teacher 2',
                            node: $('.teacher-block[data-teacher="2"] .conference_modal_date_btn')
                        });
                    }

                    if (errors.length) {
                        console.warn('Validation errors:', errors.map(e => e.msg));
                        highlightFocus(errors[0].node);
                        return {
                            ok: false,
                            errors
                        };
                    }
                    return {
                        ok: true,
                        errors: []
                    };
                };

                // ---------------- payload builder ----------------
                const buildPayload = (t1, t2) => {
                    const main = (t1.classType === 'main') ? t1 : (t2.classType === 'main') ? t2 : t1;
                    const tutor = (main === t1) ? t2 : t1;

                    const cohort = {
                        idNumber: val('#cohortInput') || '',
                        shortName: val('#cohortShortInput') || '',

                        teachers: {
                            teacher1: t1, // includes schedule.days: ["Fri","Sat"] etc.
                            teacher2: t2
                        },

                        scheduleLabels: {
                            main: main.schedule.label || 'Does not repeat',
                            tutor: tutor.schedule.label || 'Does not repeat',
                            timezoneMainLabel: main.timezoneLabel || '',
                            timezoneTutorLabel: tutor.timezoneLabel || ''
                        }
                    };

                    return [cohort];
                };

                // ---------------- wire button ----------------
                const attach = () => {
                    const createBtn = $('.calendar_admin_details_create_cohort_btn');
                    if (!createBtn) return;

                    createBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        clearErrors();

                        const t1 = readTeacher1();
                        const t2 = readTeacher2();

                        const check = validate({
                            t1,
                            t2
                        });
                        if (!check.ok) return;

                        const payload = buildPayload(t1, t2);
                        console.log('✅ Cohort payload (array):', payload);
                        console.log('✅ Cohort payload JSON:\n', JSON.stringify(payload, null, 2));
                    }, {
                        passive: false
                    });
                };

                attach();
            })();
            </script>



            <?php require_once('calendar_admin_details_create_cohort_class_tab.php');?>

            <?php require_once('calendar_admin_details_create_cohort_merge_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_manage_cohort.php');?>

            <?php require_once('calendar_admin_details_create_cohort_add_time_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_add_extra_slots_tab.php');?>




            <div class="calendar_admin_details_create_cohort_content tab-content" id="peerTalkTabContent"
                style="display:none;">
                <!-- Peer Talk: (same structure as Conference, you can modify as needed) -->
                <div class="conference_modal_schedule">
                    <input type="checkbox" disabled checked> Peer Talk Schedule
                </div>
                <div class="conference_modal_repeat_row">
                    <div style="flex:1;">
                        <div class="conference_modal_repeat_btn" style="border-bottom:2.5px solid #fe2e0c;">
                            Does not repeat
                            <span style="float:right; font-size:1rem;">&#9660;</span>
                        </div>
                    </div>
                    <div class="conference_modal_label" style="font-weight:400;">Start On</div>
                    <div style="flex:1;">
                        <button class="conference_modal_date_btn">Select Date</button>
                    </div>
                </div>


                <div style="display:flex; gap:12px; align-items:center; margin-bottom:7px;">

                    <div class="d-flex" id="customTimeFields" style="margin-top: 10px;">
                        <div class="custom-time-pill">
                            <input type="text" class="form-control time-input" value="9:30 am" autocomplete="off"
                                readonly style="background-color:#ffffff;" />
                            <div class="custom-time-dropdown"></div>
                        </div>
                        <div class="time-dash">–</div>
                        <div class="custom-time-pill">
                            <input type="text" class="form-control time-input" value="10:30 am" autocomplete="off"
                                readonly style="background-color:#ffffff;" />
                            <div class="custom-time-dropdown"></div>
                        </div>
                    </div>


                    <a class="conference_modal_findtime_link" href="#">Find a time</a>
                    <div class="color-dropdown-wrapper">
                        <button type="button" class="color-dropdown-toggle" id="peerTalkColorDropdownToggle"
                            style="width:75px;">
                            <span class="color-circle" style="background:#22b07e"></span>
                            <span style="float:right; font-size:1rem;">▼</span>
                        </button>
                        <div class="color-dropdown-list" id="peerTalkColorDropdownList">
                            <div class="color-dropdown-color" data-color="#1736e6" style="background:#1736e6"></div>
                            <div class="color-dropdown-color" data-color="#22b07e" style="background:#22b07e"></div>
                            <div class="color-dropdown-color" data-color="#3c3b4d" style="background:#3c3b4d"></div>
                            <div class="color-dropdown-color" data-color="#ff2f1b" style="background:#ff2f1b"></div>
                            <div class="color-dropdown-color" data-color="#daaf36" style="background:#daaf36"></div>
                        </div>
                    </div>
                </div>







                <div class="calendar_admin_details_cohort_tab_timezone_wrapper" style="margin-top:10px;">
                    <label class="calendar_admin_details_cohort_tab_timezone_label">Event time zone</label>
                    <div class="calendar_admin_details_cohort_tab_timezone_dropdown"
                        id="eventTimezoneDropdown_peer_talk_tab_wrapper">
                        <span id="eventTimezoneDropdown_peer_talk_tab_selected">(GMT-05:00) Eastern</span>
                        <svg class="calendar_admin_details_cohort_tab_timezone_arrow" width="18" height="18"
                            viewBox="0 0 20 20">
                            <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none"
                                stroke-linecap="round" />
                        </svg>
                        <div class="calendar_admin_details_cohort_tab_timezone_list"
                            id="eventTimezoneDropdown_peer_talk_tab_list">
                            <ul>
                                <li>(GMT-12:00) International Date Line West</li>
                                <li>(GMT-11:00) Midway Island, Samoa</li>
                                <li>(GMT-10:00) Hawaii</li>
                                <li>(GMT-09:00) Alaska</li>
                                <li>(GMT-08:00) Pacific Time (US & Canada)</li>
                                <li>(GMT-07:00) Mountain Time (US & Canada)</li>
                                <li>(GMT-06:00) Central Time (US & Canada)</li>
                                <li>(GMT-05:00) Eastern Time (US & Canada)</li>
                                <li>(GMT+00:00) London</li>
                                <li>(GMT+01:00) Berlin, Paris</li>
                                <li>(GMT+03:00) Moscow, Nairobi</li>
                                <li>(GMT+05:00) Pakistan</li>
                                <li>(GMT+05:30) India</li>
                                <li>(GMT+08:00) Beijing, Singapore</li>
                                <li>(GMT+09:00) Tokyo, Seoul</li>
                                <li>(GMT+10:00) Sydney</li>
                            </ul>
                        </div>
                    </div>
                </div>




                <div class="conference_modal_fieldrow">
                    <div>
                        <span class="conference_modal_label">Attending Cohorts</span>
                        <div class="conference_modal_dropdown_btn" id="peerTalkCohortsDropdown">
                            XX#
                            <span style="float:right; font-size:1rem;">▼</span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="peerTalkCohortsDropdownList">
                            <ul>
                                <li>FL1</li>
                                <li>TX1</li>
                                <li>NY2</li>
                                <li>OHI2</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <span class="conference_modal_label">Teachers</span>
                        <div class="conference_modal_dropdown_btn" id="peerTalkTeachersDropdown">
                            Select Teacher
                            <span style="float:right; font-size:1rem;">▼</span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="peerTalkTeachersDropdownList">
                            <ul>
                                <li><img src="https://randomuser.me/api/portraits/men/11.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Edwards</li>
                                <li><img src="https://randomuser.me/api/portraits/women/44.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Daniela</li>
                                <li><img src="https://randomuser.me/api/portraits/men/31.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Hawkins</li>
                                <li><img src="https://randomuser.me/api/portraits/men/32.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Lane</li>
                                <li><img src="https://randomuser.me/api/portraits/men/33.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Warren</li>
                                <li><img src="https://randomuser.me/api/portraits/men/52.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Fox</li>
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
                <button class="conference_modal_btn">Schedule Peer Talk</button>
            </div>
























            <!-- Conference Content: loaded by JS when needed -->
            <div id="conferenceTabContent" style="display:none;">

                <label class="addtime-label" style="margin-top:16px;">Conference Title</label>
                <input type="text" class="addtime-title-input" value="Conference Title" />

                <div class="conference_modal_schedule">
                    <input type="checkbox" disabled checked> Conference Schedule
                </div>
                <div class="conference_modal_repeat_row">
                    <div style="flex:1;">
                        <div class="conference_modal_repeat_btn" style="border-bottom:2.5px solid #fe2e0c;">
                            Does not repeat
                            <span style="float:right; font-size:1rem;">&#9660;</span>
                        </div>
                    </div>
                    <div class="conference_modal_label" style="font-weight:400;">Start On</div>

                    <div style="flex:1;">
                        <button class="conference_modal_date_btn">Select Date</button>
                    </div>
                </div>

                <div style="display:flex; gap:12px; align-items:center; margin-bottom:7px;">

                    <div class="d-flex" id="customTimeFields" style="margin-top: 10px;">
                        <div class="custom-time-pill">
                            <input type="text" class="form-control time-input" value="9:30 am" autocomplete="off"
                                readonly style="background-color:#ffffff;" />
                            <div class="custom-time-dropdown"></div>
                        </div>
                        <div class="time-dash">–</div>
                        <div class="custom-time-pill">
                            <input type="text" class="form-control time-input" value="10:30 am" autocomplete="off"
                                readonly style="background-color:#ffffff;" />
                            <div class="custom-time-dropdown"></div>
                        </div>
                    </div>

                    <a class="conference_modal_findtime_link" href="#">Find a time</a>



                    <!-- Color Picker Dropdown (inline with Find a time) -->
                    <div class="color-dropdown-wrapper">
                        <button type="button" class="color-dropdown-toggle" id="colorDropdownToggle"
                            style="width:75px;">
                            <span class="color-circle" style="background:#1736e6"></span>
                            <span style="float:right; font-size:1rem;">▼</span>
                        </button>
                        <div class="color-dropdown-list" id="colorDropdownList">
                            <div class="color-dropdown-color" data-color="#1736e6" style="background:#1736e6"></div>
                            <div class="color-dropdown-color" data-color="#22b07e" style="background:#22b07e"></div>
                            <div class="color-dropdown-color" data-color="#3c3b4d" style="background:#3c3b4d"></div>
                            <div class="color-dropdown-color" data-color="#ff2f1b" style="background:#ff2f1b"></div>
                            <div class="color-dropdown-color" data-color="#daaf36" style="background:#daaf36"></div>
                        </div>
                    </div>



                </div>




                <div class="calendar_admin_details_cohort_tab_timezone_wrapper" style="margin-top:10px;">
                    <label class="calendar_admin_details_cohort_tab_timezone_label">Event time zone</label>
                    <div class="calendar_admin_details_cohort_tab_timezone_dropdown"
                        id="eventTimezoneDropdown_conference_tab_wrapper">
                        <span id="eventTimezoneDropdown_conference_tab_selected">(GMT-05:00) Eastern</span>
                        <svg class="calendar_admin_details_cohort_tab_timezone_arrow" width="18" height="18"
                            viewBox="0 0 20 20">
                            <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none"
                                stroke-linecap="round" />
                        </svg>
                        <div class="calendar_admin_details_cohort_tab_timezone_list"
                            id="eventTimezoneDropdown_conference_tab_list">
                            <ul>
                                <li>(GMT-12:00) International Date Line West</li>
                                <li>(GMT-11:00) Midway Island, Samoa</li>
                                <li>(GMT-10:00) Hawaii</li>
                                <li>(GMT-09:00) Alaska</li>
                                <li>(GMT-08:00) Pacific Time (US & Canada)</li>
                                <li>(GMT-07:00) Mountain Time (US & Canada)</li>
                                <li>(GMT-06:00) Central Time (US & Canada)</li>
                                <li>(GMT-05:00) Eastern Time (US & Canada)</li>
                                <li>(GMT+00:00) London</li>
                                <li>(GMT+01:00) Berlin, Paris</li>
                                <li>(GMT+03:00) Moscow, Nairobi</li>
                                <li>(GMT+05:00) Pakistan</li>
                                <li>(GMT+05:30) India</li>
                                <li>(GMT+08:00) Beijing, Singapore</li>
                                <li>(GMT+09:00) Tokyo, Seoul</li>
                                <li>(GMT+10:00) Sydney</li>
                            </ul>
                        </div>
                    </div>
                </div>





                <div class="conference_modal_fieldrow">
                    <div>
                        <span class="conference_modal_label">Attending Cohorts</span>
                        <div class="conference_modal_dropdown_btn" id="conferenceCohortsDropdown">
                            XX#
                            <span style="float:right; font-size:1rem;">▼</span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="conferenceCohortsDropdownList">
                            <ul>
                                <li>FL1</li>
                                <li>TX1</li>
                                <li>NY2</li>
                                <li>OHI2</li>
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
                                <li><img src="https://randomuser.me/api/portraits/men/11.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Edwards</li>
                                <li><img src="https://randomuser.me/api/portraits/women/44.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Daniela</li>
                                <li><img src="https://randomuser.me/api/portraits/men/31.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Hawkins</li>
                                <li><img src="https://randomuser.me/api/portraits/men/32.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Lane</li>
                                <li><img src="https://randomuser.me/api/portraits/men/33.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Warren</li>
                                <li><img src="https://randomuser.me/api/portraits/men/52.jpg"
                                        class="calendar_admin_details_create_cohort_teacher_avatar"> Fox</li>
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

                <button class="conference_modal_btn">Schedule Conference</button>
            </div>
        </div>
        <!-- Time Picker Modal -->
        <div class="calendar_admin_details_create_cohort_time_modal_backdrop" id="timeModalBackdrop">
            <div class="calendar_admin_details_create_cohort_time_modal" id="timeModal">
                <ul>
                    <!-- Time options rendered via JS -->
                </ul>
            </div>
        </div>
        <!-- Calendar Date Picker Modal -->
        <div class="calendar_admin_details_create_cohort_calendar_modal_backdrop" id="calendarDateModalBackdrop"
            style="display:none;">
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
    $(document).ready(function() {



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
            let selectedCohortDropdown = $('#peerTalkCohortsDropdown').contents().first()[0].textContent
                .trim();
            let cohortList = [];
            $('#peerTalkTabContent .conference_modal_cohort_list .conference_modal_cohort_chip').each(
                function() {
                    cohortList.push($(this).text().trim());
                });
            // Teachers (selected in dropdown, and chips)
            let selectedTeacherDropdown = $('#peerTalkTeachersDropdown').text().replace(/\s+/g, ' ')
                .trim();
            let teacherList = [];
            $('#peerTalkTabContent .conference_modal_attendees_list .conference_modal_attendee').each(
                function() {
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

        // $('#peerTalkColorDropdownToggle').click(function(e){
        //   e.stopPropagation();
        //   $(this).toggleClass('active');
        //   $('#peerTalkColorDropdownList').toggle();
        //   // Close the conference color dropdown if open
        //   $('#colorDropdownList').hide();
        //   $('#colorDropdownToggle').removeClass('active');
        // });

        $('#peerTalkColorDropdownList .color-dropdown-color').click(function(e) {
            e.stopPropagation();
            var color = $(this).attr('data-color');
            $('#peerTalkColorDropdownToggle .color-circle').css('background', color);
            $('#peerTalkColorDropdownList .color-dropdown-color').removeClass('selected');
            $(this).addClass('selected');
            $('#peerTalkColorDropdownList').hide();
            $('#peerTalkColorDropdownToggle').removeClass('active');
        });

        // Modal open/close
        $('.calendar_admin_details_create_cohort_open').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();

            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="cohort"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'none');
            $('#conferenceTabContent').css('display', 'none');
            $('#peerTalkTabContent').css('display', 'none');
            $('#addTimeTabContent').css('display', 'none');
            $('#addExtraSlotsTabContent').css('display', 'none');
            $('#mainModalContent').css('display', 'block');
            $('#classTabContent').css('display', 'none');
            $('#manage_cohort_tab_content').css('display', 'none');
        });



        $('.calendar_admin_details_create_cohort_close_sub').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();
        });



        //=======================1_1_CLASS Tab=========================// 
        $('.calendar_admin_details_1_1_class').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="class"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();

            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'none');
            $('#conferenceTabContent').css('display', 'none');
            $('#peerTalkTabContent').css('display', 'none');
            $('#addTimeTabContent').css('display', 'none');
            $('#addExtraSlotsTabContent').css('display', 'none');
            $('#mainModalContent').css('display', 'none');
            $('#classTabContent').css('display', 'block');
            $('#manage_cohort_tab_content').css('display', 'none');

        });

        //=======================conference Tab=========================//
        $('.calendar_admin_details_conference').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="conference"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();

            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'none');
            $('#conferenceTabContent').css('display', 'block');
            $('#peerTalkTabContent').css('display', 'none');
            $('#addTimeTabContent').css('display', 'none');
            $('#addExtraSlotsTabContent').css('display', 'none');
            $('#mainModalContent').css('display', 'none');
            $('#classTabContent').css('display', 'none');
            $('#manage_cohort_tab_content').css('display', 'none');
        });

        //=======================peertalk Tab=========================//
        $('#calendar_admin_details_peer_talk').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="peertalk"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'none');
            $('#conferenceTabContent').css('display', 'none');
            $('#peerTalkTabContent').css('display', 'block');
            $('#addTimeTabContent').css('display', 'none');
            $('#addExtraSlotsTabContent').css('display', 'none');
            $('#mainModalContent').css('display', 'none');
            $('#classTabContent').css('display', 'none');
            $('#manage_cohort_tab_content').css('display', 'none');

        });

        //=======================merge cohort Tab=========================//
        $('#calendar_admin_details_merge').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="merge"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'block');
            $('#conferenceTabContent').css('display', 'none');
            $('#peerTalkTabContent').css('display', 'none');
            $('#addTimeTabContent').css('display', 'none');
            $('#addExtraSlotsTabContent').css('display', 'none');
            $('#mainModalContent').css('display', 'none');
            $('#classTabContent').css('display', 'none');
            $('#manage_cohort_tab_content').css('display', 'none');
        });


        //=======================Manage cohort content Tab=========================//
        $('#calendar_admin_details_manage_cohort').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="manage"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'none');
            $('#manage_cohort_tab_content').css('display', 'block');
            $('#conferenceTabContent').css('display', 'none');
            $('#peerTalkTabContent').css('display', 'none');
            $('#addTimeTabContent').css('display', 'none');
            $('#addExtraSlotsTabContent').css('display', 'none');
            $('#mainModalContent').css('display', 'none');
            $('#classTabContent').css('display', 'none');
        });

        //=======================add time off Tab=========================//
        $('#calendar_admin_details_add_time_off').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="addtime"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'none');
            $('#conferenceTabContent').css('display', 'none');
            $('#peerTalkTabContent').css('display', 'none');
            $('#addTimeTabContent').css('display', 'block');
            $('#addExtraSlotsTabContent').css('display', 'none');
            $('#mainModalContent').css('display', 'none');
            $('#classTabContent').css('display', 'none');
            $('#manage_cohort_tab_content').css('display', 'none');
        });


        //=======================Add extra slots Tab=========================//
        $('#calendar_admin_details_add_extra_slots').click(function() {
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab')
                .removeClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop .calendar_admin_details_create_cohort_tab[data-tab="extraslots"]')
                .addClass('active');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
            $('#calendar_admin_details_create_cohort_content').html('');
            $('#mergeTabContent').css('display', 'none');
            $('#conferenceTabContent').css('display', 'none');
            $('#peerTalkTabContent').css('display', 'none');
            $('#addTimeTabContent').css('display', 'none');
            $('#addExtraSlotsTabContent').css('display', 'block');
            $('#mainModalContent').css('display', 'none');
            $('#classTabContent').css('display', 'none');
            $('#manage_cohort_tab_content').css('display', 'none');
        });


        // Tabs - Peer Talk tab shows Conference content
        $('.calendar_admin_details_create_cohort_tab').click(function() {
            $('.calendar_admin_details_create_cohort_tab').removeClass('active');
            $(this).addClass('active');
            let tab = $(this).data('tab');
            $('#mainModalContent').toggle(tab === "cohort");

            $('#conferenceTabContent').toggle(tab === "conference");
            $('#peerTalkTabContent').toggle(tab === "peertalk");


            // Hide both if not cohort/conference/peertalk
            if (tab !== "cohort" && tab !== "conference" && tab !== "peertalk") {
                $('#mainModalContent').hide();
                $('#conferenceTabContent').hide();
            }
        });


        // Dropdowns
        // $('#cohortDropdownBtn').click(function (e) {
        //   e.stopPropagation();
        //   $('#cohortDropdownList').toggle();
        //   $('#shortNameDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className1DropdownList, #className2DropdownList').hide();
        // });
        // $('#cohortDropdownList li').click(function () {
        //   $('#cohortDropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
        //   $('#cohortDropdownList').hide();
        // });
        // $('#shortNameDropdownBtn').click(function (e) {
        //   e.stopPropagation();
        //   $('#shortNameDropdownList').toggle();
        //   $('#cohortDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className1DropdownList, #className2DropdownList').hide();
        // });
        // $('#shortNameDropdownList li').click(function () {
        //   $('#shortNameDropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
        //   $('#shortNameDropdownList').hide();
        // });






        $('#teacher1DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#teacher1DropdownList').toggle();
            $('#cohortDropdownList, #shortNameDropdownList, #teacher2DropdownList, #className1DropdownList, #className2DropdownList')
                .hide();
        });
        $('#teacher1DropdownList li').click(function() {
            $('#teacher1DropdownBtn').html($(this).html() +
                '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
            $('#teacher1DropdownList').hide();
        });
        $('#teacher2DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#teacher2DropdownList').toggle();
            $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList, #className1DropdownList, #className2DropdownList')
                .hide();
        });
        $('#teacher2DropdownList li').click(function() {
            $('#teacher2DropdownBtn').html($(this).html() +
                '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
            $('#teacher2DropdownList').hide();
        });
        $('#className1DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#className1DropdownList').toggle();
            $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className2DropdownList')
                .hide();
        });
        $('#className1DropdownList li').click(function() {
            $('#className1DropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
            $('#className1DropdownList').hide();
        });
        $('#className2DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#className2DropdownList').toggle();
            $('#cohortDropdownList, #shortNameDropdownList, #teacher1DropdownList, #teacher2DropdownList, #className1DropdownList')
                .hide();
        });
        $('#className2DropdownList li').click(function() {
            $('#className2DropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
            $('#className2DropdownList').hide();
        });
        // Conference tab dropdowns
        $('#conferenceCohortsDropdown').click(function(e) {
            e.stopPropagation();
            $('#conferenceCohortsDropdownList').toggle();
            $('#conferenceTeachersDropdownList').hide();
        });
        $('#conferenceTeachersDropdown').click(function(e) {
            e.stopPropagation();
            $('#conferenceTeachersDropdownList').toggle();
            $('#conferenceCohortsDropdownList').hide();
        });
        $('#conferenceCohortsDropdownList li').click(function() {
            $('#conferenceCohortsDropdown').contents().first()[0].textContent = $(this).text() + " ";
            $('#conferenceCohortsDropdownList').hide();
        });


        // $('#conferenceTeachersDropdownList li').click(function(){
        //   $('#conferenceTeachersDropdown').html($(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
        //   $('#conferenceTeachersDropdownList').hide();
        // });

        $('#conferenceTeachersDropdownList li').click(function() {
            // 1. Set dropdown value
            $('#conferenceTeachersDropdown').html($(this).html() +
                '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>');
            $('#conferenceTeachersDropdownList').hide();

            // 2. Get teacher info
            let imgHtml = $(this).find('img').prop('outerHTML');
            let name = $(this).text().trim();
            let email = name.replace(/\s/g, '').toLowerCase() +
                "@example.com"; // Or set email as you wish

            // 3. Prevent duplicates
            let exists = false;
            $('#conferenceTabContent .conference_modal_attendee').each(function() {
                if ($(this).find('.conference_modal_attendee_name').text().trim() === name)
                    exists = true;
                if ($(this).find('span').eq(1).text().trim() === name) exists = true;
            });
            if (exists) return;

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






        $(document).click(function() {
            $('.calendar_admin_details_create_cohort_dropdown_list, .calendar_admin_details_create_cohort_teacher_list, .calendar_admin_details_create_cohort_class_list, .calendar_admin_details_create_cohort_shortname_list, .conference_modal_dropdown_list')
                .hide();
        });
        // Remove attendee
        // $('.conference_modal_remove').click(function(){
        //   $(this).closest('.conference_modal_attendee').fadeOut(200, function() { $(this).remove(); });
        // });

        $(document).on('click', '.conference_modal_remove', function() {
            $(this).closest('.conference_modal_attendee').fadeOut(200, function() {
                $(this).remove();
            });
        });

        // Toggles
        $('#toggleActive, #toggleAvailable').click(function() {
            $(this).toggleClass('active');
        });










        // ===== TIME PICKER (all "Start Time" & "End Time" buttons, both tabs) =====
        function openTimePickerModal($btn) {
            let times = [];
            let start = 10; // 5:00 AM (10th half hour after midnight)
            let end = 47; // 11:30 PM
            for (let i = start; i <= end; i++) {
                let hour = Math.floor(i / 2);
                let min = i % 2 === 0 ? "00" : "30";
                let hour12 = ((hour + 11) % 12 + 1);
                let ampm = hour < 12 ? "AM" : "PM";
                let str = hour12.toString().padStart(2, "0") + ":" + min + " " + ampm;
                times.push(str);
            }
            let html = "";
            for (let t of times) html += `<li>${t}</li>`;
            $('#timeModal ul').html(html);
            // Position
            let offset = $btn.offset();
            let left = offset.left + $btn.outerWidth() / 2 - 105; // Centered (210px wide)
            let top = offset.top + $btn.outerHeight() + 2;
            if ($(window).width() < 500) {
                left = "50%";
                top = $(window).scrollTop() + $(window).height() * 0.20;
                $('#timeModal').css({
                    left: left,
                    top: top,
                    transform: "translate(-50%,0)"
                });
            } else {
                $('#timeModal').css({
                    left: left,
                    top: top,
                    transform: "none"
                });
            }
            $('#timeModalBackdrop').show().data('targetBtn', $btn);
        }



        // --- Bind time picker for both class and conference time buttons! ---
        $(document).on("click", ".calendar_admin_details_create_cohort_time_btn, .conference_modal_time_btn",
            function(e) {
                e.stopPropagation();
                openTimePickerModal($(this));
            });
        $('#timeModal').off("click", "li").on("click", "li", function() {
            let $btn = $('#timeModalBackdrop').data('targetBtn');
            $btn.text($(this).text()).addClass('selected');
            $('#timeModalBackdrop').hide();
        });
        $('#timeModalBackdrop').off("click").on("click", function(e) {
            if (e.target === this) $(this).hide();
        });
        $(document).on("keydown", function(e) {
            if (e.key === "Escape") $('#timeModalBackdrop').hide();
        });



















        // ===== CALENDAR PICKER LOGIC =====
        function daysInMonth(year, month) {
            return new Date(year, month + 1, 0).getDate();
        }
        let calendarDateTargetBtn = null;
        let selectedCalendarDate = null;
        let calendarModalMonth = null;
        $(document).on('click', '.conference_modal_date_btn', function(e) {
            e.preventDefault();
            calendarDateTargetBtn = $(this);
            if ($(this).parents('#conferenceTabContent').length) {
                calendarModalMonth = {
                    year: 2025,
                    month: 0
                }; // Jan 2025
            } else {
                let now = new Date();
                calendarModalMonth = {
                    year: now.getFullYear(),
                    month: now.getMonth()
                };
            }
            selectedCalendarDate = null;
            renderCalendarModal();
            $('#calendarDateModalBackdrop').fadeIn();
        });
        $(document).on('click', '.calendar_prev_month', function() {
            calendarModalMonth.month--;
            if (calendarModalMonth.month < 0) {
                calendarModalMonth.month = 11;
                calendarModalMonth.year--;
            }
            renderCalendarModal();
        });
        $(document).on('click', '.calendar_next_month', function() {
            calendarModalMonth.month++;
            if (calendarModalMonth.month > 11) {
                calendarModalMonth.month = 0;
                calendarModalMonth.year++;
            }
            renderCalendarModal();
        });

        function renderCalendarModal() {

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                "September", "October", "November", "December"
            ];
            let y = calendarModalMonth.year,
                m = calendarModalMonth.month;
            $('#calendarDateMonth').text(`${monthNames[m]} ${y}`);
            let html = '';
            let dayHeaders = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
            for (let d = 0; d < 7; d++) html +=
                `<div class="calendar_admin_details_create_cohort_calendar_day_header">${dayHeaders[d]}</div>`;
            let firstDay = new Date(y, m, 1).getDay();
            firstDay = (firstDay + 6) % 7;
            let totalDays = daysInMonth(y, m);
            let prevMonthDays = firstDay;
            let day = 1;
            for (let i = 0; i < prevMonthDays; i++) html +=
                `<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>`;
            for (let d = 1; d <= totalDays; d++) {
                let sel = selectedCalendarDate &&
                    selectedCalendarDate.getFullYear() === y &&
                    selectedCalendarDate.getMonth() === m &&
                    selectedCalendarDate.getDate() === d ? ' selected' : '';
                html +=
                    `<div class="calendar_admin_details_create_cohort_calendar_day${sel}" data-day="${d}">${d}</div>`;
                day++;
            }
            let rem = (prevMonthDays + totalDays) % 7;
            if (rem > 0)
                for (let i = rem; i < 7; i++) html +=
                    `<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>`;
            $('.calendar_admin_details_create_cohort_calendar_days').html(html);
        }
        $(document).on('click', '.calendar_admin_details_create_cohort_calendar_day', function() {
            $('.calendar_admin_details_create_cohort_calendar_day').removeClass('selected');
            $(this).addClass('selected');
            let day = parseInt($(this).attr('data-day'));
            selectedCalendarDate = new Date(calendarModalMonth.year, calendarModalMonth.month, day);
        });
        $('.calendar_admin_details_create_cohort_calendar_done_btn').click(function() {

            if (selectedCalendarDate && calendarDateTargetBtn) {
                let d = selectedCalendarDate;
                let nice = d.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                calendarDateTargetBtn.text(nice);
                setCohortDate(selectedCalendarDate); // updates #cohortInput
                $('#calendarDateModalBackdrop').fadeOut();
            }
        });








        // ================== save value in the text field above in create cohort modal (MMDDYY) ================== //
        function setCohortDate(dateVal, fieldSel) {
            var $cohort = $(fieldSel || '#cohortInput');
            if (!$cohort.length) return false;

            // Get a Date object
            var d;
            if (dateVal instanceof Date) {
                d = dateVal;
            } else if (typeof dateVal === 'string' && dateVal.trim()) {
                // Try to parse strings like "Aug/21/2025" or "2025-08-21"
                var safe = dateVal.replace(/-/g, '/'); // mild normalization
                d = new Date(safe);
            } else {
                return false;
            }
            if (isNaN(d)) return false;

            // Build MMDDYY, zero-padded
            var mm = String(d.getMonth() + 1).padStart(2, '0'); // 01-12
            var dd = String(d.getDate()).padStart(2, '0'); // 01-31
            var yy = String(d.getFullYear()).slice(-2); // last two digits
            var mdy6 = mm + dd + yy; // e.g., "082125"

            // Use current value or placeholder as template: e.g., "CO1-#-#####-###"
            var template = ($cohort.val() || $cohort.attr('placeholder') || '').trim();
            if (!template) {
                $cohort.val(mdy6).trigger('input').trigger('change');
                return mdy6;
            }

            // Prefer exact 4-part pattern: seg1 - seg2 - seg3 - seg4  (replace seg2)
            var rx = /^([^-]+)-[^-]+-[^-]+-([^-]+)$/; // capture seg1 and seg4
            var updated;

            if (rx.test(template)) {
                updated = template.replace(rx, function(_, seg1, seg4) {
                    return seg1 + '-' + mdy6 + '-' + seg4;
                });
            } else {
                // Fallback: try literal replacement of "#-#####"
                updated = template.replace(/#-#####/, mdy6);
                // If no placeholder pattern exists, just set the field to the date
                if (updated === template) updated = mdy6;
            }

            $cohort.val(updated).trigger('input').trigger('change');
            return updated;
        }
        // ================== end ================== //







        $('#calendarDateModalBackdrop').click(function(e) {
            if (e.target === this) $(this).fadeOut();
        });


















        // Color dropdown logic
        $('#colorDropdownToggle').click(function(e) {
            e.stopPropagation();
            $(this).toggleClass('active');
            $('#colorDropdownList').toggle();
        });
        $('#colorDropdownList .color-dropdown-color').click(function(e) {
            e.stopPropagation();
            var color = $(this).attr('data-color');
            $('#colorDropdownToggle .color-circle').css('background', color);
            $('#colorDropdownList .color-dropdown-color').removeClass('selected');
            $(this).addClass('selected');
            $('#colorDropdownList').hide();
            $('#colorDropdownToggle').removeClass('active');
        });

        $(document).click(function() {

            $('#colorDropdownList').hide();
            $('#peerTalkCohortsDropdownList, #peerTalkTeachersDropdownList, #conferenceCohortsDropdownList, #conferenceTeachersDropdownList')
                .hide();
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
            let cohorts = $('#conferenceTabContent #conferenceCohortsDropdown').contents().first()[0]
                .textContent.trim();
            let teachers = $('#conferenceTabContent #conferenceTeachersDropdown').text().replace(/\s+/g,
                ' ').trim();
            let attendees = [];
            $('#conferenceTabContent .conference_modal_attendee').each(function() {
                let cohort = $(this).find('.conference_modal_attendee_name').text().trim();
                let email = $(this).find('span').eq(1).text().trim();
                if (cohort) attendees.push(cohort);
                else if (email) attendees.push(email);
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
    $('#conferenceCohortsDropdownList li').click(function() {
        let cohort = $(this).text().trim();
        // Prevent duplicates
        if ($('.conference_modal_cohort_list li[data-cohort="' + cohort + '"]').length === 0) {
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
        $(this).closest('li').fadeOut(200, function() {
            $(this).remove();
        });
    });




    // Peer Talk: Add cohort to cohort list (left side)
    $('#peerTalkCohortsDropdownList li').click(function() {
        let cohort = $(this).text().trim();
        // Prevent duplicates in Peer Talk cohort list
        let $list = $('#peerTalkTabContent .conference_modal_cohort_list');
        if ($list.find('li[data-cohort="' + cohort + '"]').length === 0) {
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
    $('#peerTalkTeachersDropdownList li').click(function() {
        let name = $(this).text().trim();
        let imgHtml = $(this).find('img').prop('outerHTML');
        let $list = $('#peerTalkTabContent .conference_modal_attendees_list');
        // Prevent duplicates
        let exists = false;
        $list.find('.conference_modal_attendee').each(function() {
            if ($(this).find('span').eq(1).text().trim() === name) exists = true;
        });
        if (exists) return;
        $list.append(`
    <li class="conference_modal_attendee">
      ${imgHtml}
      <span>${name}</span>
      <span class="conference_modal_icon user">&#128100;</span>
      <span class="conference_modal_remove">&times;</span>
    </li>
  `);
        $('#peerTalkTeachersDropdown').html($(this).html() +
            '<span style="float:right; font-size:1rem;">▼</span>');
        $('#peerTalkTeachersDropdownList').hide();
    });


    $(document).on('click', '.conference_modal_remove', function() {
        $(this).closest('.conference_modal_attendee').fadeOut(200, function() {
            $(this).remove();
        });
    });


    // Peer Talk Cohorts dropdown
    $('#peerTalkCohortsDropdown').click(function(e) {
        e.stopPropagation();
        $('#peerTalkCohortsDropdownList').toggle();
        $('#peerTalkTeachersDropdownList').hide();
    });
    $('#peerTalkTeachersDropdown').click(function(e) {
        e.stopPropagation();
        $('#peerTalkTeachersDropdownList').toggle();
        $('#peerTalkCohortsDropdownList').hide();
    });


    $('#eventTimezoneDropdown').click(function(e) {
        e.stopPropagation();
        $('#eventTimezoneDropdownList').toggle();
    });

    $('#eventTimezoneDropdownList li').click(function(e) {
        e.stopPropagation();
        $('#eventTimezoneSelected').text($(this).text());
        $('#eventTimezoneDropdownList').hide();
    });



    // Close dropdown on outside click
    $(document).click(function() {
        $('#eventTimezoneDropdownList').hide();
    });

    $('#eventTimezoneDropdownRight').click(function(e) {
        e.stopPropagation();
        $('#eventTimezoneDropdownListRight').toggle();
    });

    $('#eventTimezoneDropdownListRight li').click(function(e) {
        e.stopPropagation();
        $('#eventTimezoneSelectedRight').text($(this).text());
        $('#eventTimezoneDropdownListRight').hide();
    });

    // Close dropdown on outside click
    $(document).click(function() {
        $('#eventTimezoneDropdownListRight').hide();
    });

    // When a Teacher 1 option is clicked, set #cohortInput -> "CO1-#-#####-###"
    $(document).on('click', '#teacher1DropdownList li', function() {

        debugger

        alert('clicked');
        const $cohort = $('#cohortInput');
        if (!$cohort.length) return;

        // Start from current value or the placeholder template (e.g., "XXX-#-#####-###")
        // var template = ($cohort.val() || $cohort.attr('placeholder') || '').trim();
        // if (!template) return;

        // // Replace ONLY the first segment with CO1 (prefer explicit "XXX", else first segment before "-")
        // var updated = template.replace(/^XXX(?=-|$)/, 'FL1');
        // if (updated === template) updated = template.replace(/^[^-]+/, 'FL1');

        // $cohort.val(updated).trigger('input').trigger('change');

        // Build query string like $.getJSON did (GET + query params)

        const $li = $(this);

        // assume $li and $cohort are already defined
        const $cohortShortInput = $('#cohortShortInput');
        if (!$cohort.length) return;

        // Optional: derive 1-based index within the list as teacher_index
        const teacherIndex = $li.index() + 1;

        const params = new URLSearchParams({
            sesskey: M.cfg.sesskey,
            teacherid: $li.data('userid') || '', // ← from data-userid
            teacher_name: $li.data('name') || '', // ← from data-name (if your PHP wants it)
            teacher_pic: $li.data('pic') || '', // ← from data-pic (if useful server-side)
            teacher_index: teacherIndex || '' // ← only if you need it
        });

        fetch(M.cfg.wwwroot + '/local/customplugin/ajax/get_cohort_template.php?' + params.toString(), {
                method: 'GET',
                credentials: 'same-origin'
            })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(resp => {
                if (resp && resp.success && resp.template) {
                    $cohort.val(resp.template).trigger('input').trigger('change');

                    // Set short name (prefer explicit, else derive from template)
                    const shortname = resp.nextshortname || String(resp.template).split('-')[0] || '';
                    if ($cohortShortInput.length && shortname) {
                        $cohortShortInput.val(shortname).trigger('input').trigger('change');
                        $cohortShortInput.closest('div').find('.custom-tooltip').hide();
                    }
                } else {
                    // fallback: keep your old client-side logic
                    const template = ($cohort.val() || $cohort.attr('placeholder') || '').trim();
                    if (!template) return;
                    let updated = template.replace(/^XXX(?=-|$)/, 'CO1');
                    if (updated === template) updated = template.replace(/^[^-]+/, 'CO1');
                    $cohort.val(updated).trigger('input').trigger('change');
                }
            })
            .catch(() => {
                const template = ($cohort.val() || $cohort.attr('placeholder') || '').trim();
                if (!template) return;
                let updated = template.replace(/^XXX(?=-|$)/, 'CO1');
                if (updated === template) updated = template.replace(/^[^-]+/, 'CO1');
                $cohort.val(updated).trigger('input').trigger('change');
            });
    });
    </script>
    <script>
    // Show tooltip on hover/focus for BOTH fields; place BELOW the input
    (function($) {
        $('.cohort-tooltip-target')
            .on('mouseenter focus', function() {
                $(this).siblings('.custom-tooltip').stop(true, true).fadeIn(140);
            })
            .on('mouseleave blur', function() {
                $(this).siblings('.custom-tooltip').stop(true, true).fadeOut(140);
            });
    })(jQuery);
    </script>




    <script>
    // ------- Class Name dropdown (snapshot look & behavior) -------
    function wireClassDropdown(btnSel, listSel) {
        // open/close
        $(btnSel).off('click').on('click', function(e) {
            e.stopPropagation();
            const $btn = $(this);
            const $list = $(listSel);

            // close other open class menus
            $('.calendar_admin_details_create_cohort_class_list').not($list).hide();
            $('.calendar_admin_details_create_cohort_class_btn').not($btn).removeClass('open');

            // toggle this one
            $btn.toggleClass('open');
            if ($btn.hasClass('open')) {
                // width already 100% (wrapper = button width), just show
                $list.show();

                // highlight current selection
                const current = ($btn.contents().first()[0].textContent || '').trim();
                $list.find('li').removeClass('selected')
                    .filter(function() {
                        return $(this).text().trim() === current;
                    })
                    .addClass('selected');
            } else {
                $list.hide();
            }
        });

        // choose item
        $(listSel).off('click', 'li').on('click', 'li', function(e) {
            e.stopPropagation();
            const text = $(this).text().trim();
            // set button label (keep arrow svg)
            const $btn = $(btnSel);
            const svg = $btn.find('svg').prop('outerHTML');
            $btn.html(text + ' ' + svg);

            // close menu
            $(listSel).hide();
            $btn.removeClass('open');
        });
    }

    // apply to Teacher 1 & 2
    wireClassDropdown('#className1DropdownBtn', '#className1DropdownList');
    wireClassDropdown('#className2DropdownBtn', '#className2DropdownList');

    // close on outside click
    $(document).off('click.classdd').on('click.classdd', function() {
        $('.calendar_admin_details_create_cohort_class_list').hide();
        $('.calendar_admin_details_create_cohort_class_btn').removeClass('open');
    });














    $(document).ready(function() {
        const $dropdownWrapper = $("#eventTimezoneDropdown_conference_tab_wrapper");
        const $dropdownList = $("#eventTimezoneDropdown_conference_tab_list");
        const $selected = $("#eventTimezoneDropdown_conference_tab_selected");

        // Toggle dropdown
        $dropdownWrapper.on("click", function(e) {
            e.stopPropagation(); // prevent bubbling
            $dropdownList.toggle();
        });

        // Select timezone
        $dropdownList.find("li").on("click", function(e) {
            e.stopPropagation();
            const selectedText = $(this).text();
            $selected.text(selectedText);
            $dropdownList.hide();
        });

        // Close when clicking outside
        $(document).on("click", function() {
            $dropdownList.hide();
        });
    });

    $(document).ready(function() {
        const $dropdownWrapper = $("#eventTimezoneDropdown_peer_talk_tab_wrapper");
        const $dropdownList = $("#eventTimezoneDropdown_peer_talk_tab_list");
        const $selected = $("#eventTimezoneDropdown_peer_talk_tab_selected");

        // Toggle dropdown
        $dropdownWrapper.on("click", function(e) {
            e.stopPropagation(); // prevent bubbling
            $dropdownList.toggle();
        });

        // Select timezone
        $dropdownList.find("li").on("click", function(e) {
            e.stopPropagation();
            const selectedText = $(this).text();
            $selected.text(selectedText);
            $dropdownList.hide();
        });

        // Close when clicking outside
        $(document).on("click", function() {
            $dropdownList.hide();
        });
    });
    </script>



    <script src="js/calendar_admin_details_create_cohort_plus_icon_new_content.js"></script>

    <?php require_once('calendar_admin_details_create_cohort_select_date.php');?>
    <?php require_once('calendar_admin_details_create_cohort_tab_does_repeat.php');?>

</body>

</html>