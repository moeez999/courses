<?php

/**
 * Local plugin "calendars" - Lib file
 *
 * @package    local_calendarcontrolplugin
 * @copyright  2024 Deiker, Venezuela <deiker21004@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../config.php');
require_once(__DIR__ . '/lib.php');
ob_start(); // prevent any accidental output

global $CFG, $DB, $PAGE, $USER;

$PAGE->set_context(context_system::instance());
$PAGE->set_title('Attendance');
$PAGE->set_url($CFG->wwwroot . '/local/calendarcontrolplugin/index.php');

$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js'), true);
$PAGE->requires->css(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css'), true);

$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/flatpickr'), true);

$PAGE->requires->js(new moodle_url('https://cdn.datatables.net/2.1.8/js/dataTables.min.js'), true);
$PAGE->requires->css(new moodle_url('https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css'), true);
$PAGE->requires->css(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'), true);

// cargar css cache
$PAGE->requires->css(new moodle_url('/local/attendance/css/index.css?v=' . time()), true);

$PAGE->requires->css(new moodle_url('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'), true);



require_once($CFG->dirroot . '/lib/moodlelib.php');
require_once($CFG->dirroot . '/lib/weblib.php'); // Incluye el archivo weblib.php

require_login();

$username = $USER->username;

// $PAGE->set_heading('Profesores particulares de inglés online: reserva ya tus clases');
// $PAGE->set_heading('Disponibilidad - ' . $username );
$urlUser = new moodle_url($CFG->wwwroot . '/user/view.php?id');


echo $OUTPUT->header();

?>
<script>

    function openMenu(name, status, email, number, activeTime, imgUrl, uid) {
        Swal.fire({
            position: "center-end",
            showConfirmButton: false,
            html: `

                <div style="height:100%;" id="asideMenu">
                    <div class="containerMenuItem">
                        <div style="display:flex; justify-content:start;align-items:center;gap:15px;">
                            <img src="${imgUrl}" style="height:48px;width:auto;border-radius:100%" alt="img"/>
                            <div 
    ${uid !== 0 ? `onclick="window.location.href='<?= $CFG->wwwroot ?>/user/profile.php?id=${uid}'"` : ''} 
    style="display:flex; flex-direction:column; align-items: flex-start; ${uid !== 0 ? 'cursor: pointer;' : ''}">
    
    <b style="font-size: 16px;
              line-height: 19.36px;
              font-weight: 600;
              font-family: 'Inter', sans-serif;
              color: #000000;">${name}</b>
    <span style="font-size: 12px;
                 line-height: 18px;
                 font-weight: 400;
                 font-family: 'Poppins', sans-serif;
                 color: #000000;">Paid Member</span>  
</div>
                        </div>
                        <div style="display:flex; width:100%;justify-content:space-around;align-items:center;gap:10px">
                            <button class="buttonMenu buttonMenu--positive"><i class="fa fa-paper-plane" aria-hidden="true"></i>Message</button>
                            <button class="buttonMenu buttonMenu--negative"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>More</button>
                        </div>

                    </div>

                    <h4 style="text-align:left">Contact Information</h4>
                    <div class="containerItemModal">
                        <div >
                            <h3>Email</h3>
                            <span>${email}</span>
                        </div>
                        <div>
                            <h3>Whatsapp Number</h3>
                            <span>${number}</span>
                        </div>
                        <div>
                            <h3>Active Time</h3>
                            <span>${activeTime} Moth</span>
                        </div>
                        <div>
                            <h3>Membership</h3>
                            <span>${status}</span>
                        </div>
                    </div>

                    

                    <h4 style="text-align:left;margin-top:20px">Notes</h4>
                    
                    <form action="" style="display:flex; justify-content:start;align-items:center">
                        <textarea style="resize: none; width:100%;background: none;color: black;border: none;border: 0.9px solid #00000033;border-radius: 10px;padding: 10px;font-size: 0.8em;height: 100px;" name="" id=""></textarea>
                    
                    </form>

                    <h4 style="text-align:left;margin-top:20px">Payment History</h4>

                    <ul class="paymentContainer">
                        <li class="paymentItem"><div class="leftSide"><img style="height: 30px;width:auto;" src=${imgUrl} alt=""> <p>August 08, 2023</p></div><div class="rightSide">$3 <div class="dot"></div> <span class="goodSpan">Succes</span></div></li>
                        <li class="paymentItem"><div class="leftSide"><img style="height: 30px;width:auto;" src=${imgUrl} alt=""> <p>August 08, 2023</p></div><div class="rightSide">$3 <div class="dot"></div> <span class="goodSpan">Succes</span></div></li>
                        <li class="paymentItem"><div class="leftSide"><img style="height: 30px;width:auto;" src=${imgUrl} alt=""> <p>August 08, 2023</p></div><div class="rightSide">$3 <div class="dot"></div> <span class="goodSpan">Succes</span></div></li>
                    </ul>
                    <h4 style="text-align:left;margin-top:20px">Active Time</h4>

                    <ul class="paymentContainer">
                        <li class="paymentItem"><div class="dataCourseItem"><div class="tittleCourse"><b>A1</b><span>Lvl</span></div><div class="contentCohortLi">KY2 - 6544<span class="goodSpan">00/00/0000</span></div></div><div><span style="font-size: 14px;">Test</span></div></li>
                        <li class="paymentItem"><div class="dataCourseItem"><div class="tittleCourse"><b>A1</b><span>Lvl</span></div><div class="contentCohortLi">KY2 - 6544<span class="goodSpan">00/00/0000</span></div></div><div><span style="font-size: 14px;">Test</span></div></li>
                        <li class="paymentItem"><div class="dataCourseItem"><div class="tittleCourse"><b>A1</b><span>Lvl</span></div><div class="contentCohortLi">KY2 - 6544<span class="goodSpan">00/00/0000</span></div></div><div><span style="font-size: 14px;">Test</span></div></li>
                    </ul>
                </div>
            `,
            showClass: {
                popup: `
                animate__animated
                animate__fadeInRight
                animate__faster
                `
            },
            hideClass: {
                popup: `
                animate__animated
                animate__fadeOutRight
                animate__faster
                `
            },
            customClass: {
                popup: 'menu-swal'
            }
        });
    }

    function openModal(event, name, status, email, number, activeTime, imgUrl) {
        debugger
        let mouseX = event.clientX;
        let mouseY = event.clientY;

        Swal.fire({
            title: `<img src="${imgUrl}" style="height:50px;width:auto;border-radius:100%" alt="img"/> ${name}`,
            html: `
                <div class="containerItemModal">
                    <div>
                        <h3>Email</h3>
                        <span>${email}</span>
                    </div>
                    <div>
                        <h3>Whatsapp Number</h3>
                        <span>${number}</span>
                    </div>
                    <div>
                        <h3>Active Time</h3>
                        <span>${activeTime} Moth</span>
                    </div>
                    <div>
                        <h3>Membership</h3>
                        <span>${status}</span>
                    </div>
                </div>
            `,

            customClass: {
                title: 'titleModal'
            },
            showCloseButton: true,
            showConfirmButton: false,
            background: '#fff',
            willOpen: () => {
                const swalPopup = document.querySelector('.swal2-popup');
                if (swalPopup) {
                    swalPopup.style.left = mouseX + 'px';
                    swalPopup.style.top = (mouseY + 20) + 'px';
                }
            }
        });
    }
</script>
<div class="containerTables">

    <div class="item-container">

        <section class="toolBar">
            <h2>Attendance: </h2> <!-- This will be updated dynamically -->
            <div class="item-toolBar teacher-item-toolbar" id="teacherContainer"></div>
        </section>
        <section class="toolBar">

            <div id="searchContainer"></div>

            <div class="item-toolBar">

                <div id="selectWeek" class="inputAdmin">

                    <button id="downDay">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </button>
                    <span>

                        <i class="fa fa-calendar calendar-icon" aria-hidden="true"></i>


                        <span id="buttonLabel"></span>
                    </span>
                    <button id="topDay">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>

                </div>
                <?php
                global $DB;
                // Get all cohorts sorted by name.
                 //$cohorts = $DB->get_records('cohort', null, 'name ASC');
                $cohorts = $DB->get_records('cohort', ['visible' => 1], 'name ASC');
                ?>

                <form id="cohortForm" name="cohort" action="">
                    <select id="selectCohort" class="inputAdmin">
                    <option value="">Select Cohort</option>
                    <?php
                    $first = true;
                    foreach ($cohorts as $cohort) {
                        echo '<option value="' . $cohort->id . '"' . ($first ? ' selected' : '') . '>' . $cohort->idnumber . '</option>';
                        $first = false;
                    }
                ?>
                </select>
                </form>
            </div>



        </section>
        <div id="loader" class="loader" style="display: none;"></div>
        <table id="myTable" class="display" style="width: 100%; height: 100vh;">
            <thead class="headTable">
                <tr>
                    <th>
                        <div class="form-check" style="padding: unset;">
                            <div class="checkboxCustome">
                                <input class="form-check-input row-select" type="checkbox" value="" id="select-all">
                                <div class="checkbox-div">
                                    <svg width="12" height="9" viewBox="0 0 12 9" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.8162 0.207014C12.0701 0.473695 12.0597 0.895677 11.793 1.14954L4.08929 8.48287C3.95773 8.6081 3.78078 8.67424 3.59933 8.66598C3.41788 8.65772 3.24766 8.57579 3.12803 8.43912L0.165063 5.05451C-0.0774581 4.77747 -0.0494802 4.35629 0.227553 4.11377C0.504586 3.87125 0.925768 3.89923 1.16829 4.17626L3.67342 7.0379L10.8737 0.183799C11.1404 -0.070061 11.5624 -0.0596674 11.8162 0.207014Z"
                                            fill="white" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </th>
                    <th
                        style="width: 100%;  display: flex; align-items: center; justify-content: space-between; border-bottom: none;  height: 100%;">
                        <span>Student</span> <span id="membershipColumn">Membership</span></th>
                    <th id="WANumberColumn">WA Number</th>
                    <th id="EmailColumn" style="width: 270px;">Email</th>
                    <th class="rowDayHead" id="day0">
                        <div class="contentDay">Apr-07</div>
                    </th>
                    <th class="rowDayHead" id="day1">
                        <div class="contentDay">Apr-08</div>
                    </th>
                    <th class="rowDayHead" id="day2">
                        <div class="contentDay">Apr-09</div>
                    </th>
                    <th class="rowDayHead" id="day3">
                        <div class="contentDay">Apr-10</div>
                    </th>
                    <th class="rowDayHead" id="day4">
                        <div class="contentDay">Apr-11</div>
                    </th>
                    <th class="rowDayHead" id="day5">
                        <div class="contentDay">Apr-12</div>
                    </th>
                    <th class="rowDayHead" id="day6">
                        <div class="contentDay">Apr-13</div>
                    </th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>


</div>

<?php
// Cargar js cache
?>
<!-- <script src="js/index.js?v=<?php echo time(); ?>"></script> -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait a brief moment to ensure all elements are fully loaded
    setTimeout(function() {
        const select = document.getElementById('selectCohort');
        if (select && select.options.length > 1) {
            // Manually set the selected index to 1 (first real option)
            select.selectedIndex = 1;
            
            // Create and dispatch the change event
            const event = new Event('change', {
                bubbles: true,
                cancelable: true
            });
            select.dispatchEvent(event);
        }
    }, 100); // 100ms delay to ensure everything is ready
});
</script>





<script>

      // Function to extract dates from elements with ids day0 to day6
      function getDatesArray() {
        let datesArray = [];
        for (let i = 0; i <= 6; i++) {
            const dayElement = document.getElementById(`day${i}`);
            if (dayElement && dayElement.querySelector('.contentDay')) {
                // Assuming the date is inside a .contentDay element
                datesArray.push(dayElement.querySelector('.contentDay').innerText);
            }
        }
        return datesArray;
    }

$(document).ready(function() {

// Datatable
var table = $('#myTable').DataTable({
    ordering: false,
    dom: '<"top"f>rt<"bottom"ilp><"clear">',
    lengthChange: false,
    select: {
        style: 'multi',
        selector: 'td:first-child'
    }
});


 // Initial day and now values
 let day = moment().local();
    let now = moment().local();
    let buttonLabel = moment().local().format('MMM DD, YYYY');
    $('#buttonLabel').text(buttonLabel);

    // Default weekDay object structure
   // Default weekDay object structure
let weekDay = {
    oneDay: day.format('MMM-DD'),
    secondDay: day.subtract(1, 'days').format('MMM-DD'),
    threeDay: day.subtract(1, 'days').format('MMM-DD'),
    fourthDay: day.subtract(1, 'days').format('MMM-DD'),
    fiveDay: day.subtract(1, 'days').format('MMM-DD'),
    sixDay: day.subtract(1, 'days').format('MMM-DD'),
    sevenDay: day.subtract(1, 'days').format('MMM-DD'),
};

     // Update contentDay elements with default values on page load
     $('.contentDay').each(function(index) {
        switch (index) {
            case 0: $(this).text(weekDay.sevenDay); break;
            case 1: $(this).text(weekDay.sixDay); break;
            case 2: $(this).text(weekDay.fiveDay); break;
            case 3: $(this).text(weekDay.fourthDay); break;
            case 4: $(this).text(weekDay.threeDay); break;
            case 5: $(this).text(weekDay.secondDay); break;
            case 6: $(this).text(weekDay.oneDay); break;
            default: break;
        }
    });

     // Adding the functionality for 'topDay' and 'downDay' buttons
     $('#topDay').click(function() {
            for (let key in weekDay) {
                if (weekDay.hasOwnProperty(key)) {
                    let currentDate = moment(weekDay[key], 'MMM-DD');
                    currentDate.add(1, 'days');
                    weekDay[key] = currentDate.format('MMM-DD');
                }
            }

            buttonLabel = now.add(1, 'days').format('MMM DD, YYYY');
            $('#buttonLabel').text(buttonLabel);

            const daysArray = [
                weekDay.oneDay, weekDay.secondDay, weekDay.threeDay,
                weekDay.fourthDay, weekDay.fiveDay, weekDay.sixDay, weekDay.sevenDay
            ];

            $('.contentDay').each(function(index) {
                if (daysArray[index]) {
                    $(this).text(daysArray[index]);
                }
            });
        });


        $('#downDay').click(function() {
            for (let key in weekDay) {
                if (weekDay.hasOwnProperty(key)) {
                    let currentDate = moment(weekDay[key], 'MMM-DD');
                    currentDate.subtract(1, 'days');
                    weekDay[key] = currentDate.format('MMM-DD');
                }
            }

            buttonLabel = now.subtract(1, 'days').format('MMM DD, YYYY');
            $('#buttonLabel').text(buttonLabel);

            const daysArray = [
                weekDay.oneDay, weekDay.secondDay, weekDay.threeDay,
                weekDay.fourthDay, weekDay.fiveDay, weekDay.sixDay, weekDay.sevenDay
            ];

            $('.contentDay').each(function(index) {
                if (daysArray[index]) {
                    $(this).text(daysArray[index]);
                }
            });
        });

// Search placeholder
$('.dt-search .dt-input').attr('placeholder', 'Search by');
$('.dt-search .dt-input').addClass('inputAdmin');
var inputElement = $('.dt-search .dt-input');
$('#searchContainer').append(inputElement);    
$('.dt-search').empty();
$('.rui-breadcrumbs').remove();

$('#select-all').on('click', function() {
    var rows = table.rows({ search: 'applied' }).nodes();
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
});

$('#myTable tbody').on('change', 'input[type="checkbox"]', function() {
    if (!this.checked) {
        var el = $('#select-all').get(0);
        if (el && el.checked && ('indeterminate' in el)) {
            el.indeterminate = true;
        }
    }
});

    // Listen for cohort selection change
    document.getElementById('selectCohort').addEventListener('change', async function () {
        const cohortId = this.value;
        const tableBody = document.getElementById('tableBody');
        const teacherContainer = document.getElementById('teacherContainer');
        const attendanceSection = document.querySelector('.toolBar');
        const attendanceHeading = attendanceSection.querySelector('h2');

        let cohortDays = []; // Global variable accessible everywhere

        // Initial day and now values
        let day = moment().local();
        let now = moment().local();
        let buttonLabel = moment().local().format('MMM DD, YYYY');
        $('#buttonLabel').text(buttonLabel);

        // Default weekDay object structure
        let weekDay = {
            oneDay: day.format('MMM-DD'),
            secondDay: day.add(1, 'days').format('MMM-DD'),
            threeDay: day.add(1, 'days').format('MMM-DD'),
            fourthDay: day.add(1, 'days').format('MMM-DD'),
            fiveDay: day.add(1, 'days').format('MMM-DD'),
            sixDay: day.add(1, 'days').format('MMM-DD'),
            sevenDay: day.add(1, 'days').format('MMM-DD'),
        };

        try {
            loader.style.display = 'block'; // Show the loader
            const response = await fetch('getCohortDays.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `cohortid=${encodeURIComponent(cohortId)}&currentdate=${weekDay.oneDay}`
            });

            debugger

            const data = await response.json(); // Await the parsing too
            cohortDays = data.cohortDays || []; // Update global variable
            console.log('Received Cohort Days:', cohortDays);

            // Ensure cohortDays has at least 7 items
            if (cohortDays.length >= 7) {
                // ✅ Set day and now using the first cohort day
                const firstDay = moment(cohortDays[0], 'DD MMM'); // Parse from "21 Apr"
                day = firstDay.clone();
                now = firstDay.clone();

                // ✅ Set button label
                buttonLabel = day.format('MMM DD, YYYY');
                $('#buttonLabel').text(buttonLabel);

                // ✅ Set weekDay object from cohortDays
                // ✅ Set weekDay object from cohortDays (Reversed order)
                weekDay = {
                    oneDay: moment(cohortDays[6], 'DD MMM').format('MMM-DD'),
                    secondDay: moment(cohortDays[5], 'DD MMM').format('MMM-DD'),
                    threeDay: moment(cohortDays[4], 'DD MMM').format('MMM-DD'),
                    fourthDay: moment(cohortDays[3], 'DD MMM').format('MMM-DD'),
                    fiveDay: moment(cohortDays[2], 'DD MMM').format('MMM-DD'),
                    sixDay: moment(cohortDays[1], 'DD MMM').format('MMM-DD'),
                    sevenDay: moment(cohortDays[0], 'DD MMM').format('MMM-DD'),
                };


                // Update contentDay elements
                // $('.contentDay').each(function(index) {
                //     if (cohortDays[index]) {
                //         switch (index) {
                //             case 0: $(this).text(weekDay.oneDay); break;
                //             case 1: $(this).text(weekDay.secondDay); break;
                //             case 2: $(this).text(weekDay.threeDay); break;
                //             case 3: $(this).text(weekDay.fourthDay); break;
                //             case 4: $(this).text(weekDay.fiveDay); break;
                //             case 5: $(this).text(weekDay.sixDay); break;
                //             case 6: $(this).text(weekDay.sevenDay); break;
                //             default: break;
                //         }
                //     }
                // });

                $('.contentDay').each(function(index) {
    if (cohortDays[index]) {
        let dayText = "";
        switch (index) {
            case 0: dayText = weekDay.oneDay; break;
            case 1: dayText = weekDay.secondDay; break;
            case 2: dayText = weekDay.threeDay; break;
            case 3: dayText = weekDay.fourthDay; break;
            case 4: dayText = weekDay.fiveDay; break;
            case 5: dayText = weekDay.sixDay; break;
            case 6: dayText = weekDay.sevenDay; break;
            default: break;
        }

        $(this).text(dayText);

        if(index == 0)
        {
// Reverse the cohortDays array in-place
        cohortDays.reverse();  // This modifies the original array
        }
        

        // Safely extract date and type from cohortDays[index]
        const cohortEntry = cohortDays[index];
        if (cohortEntry) {
            const parts = cohortEntry.split(',');
            if (parts.length === 2) {
                const type = parts[1].trim(); // 'main' or 'tutor'
                $(this).removeClass('main tutor').addClass(type);
            }
        }
    }
});
            } } catch (error) {
            console.error('Error fetching cohort days:', error);
        }

        let clickCounter = 0; // Keep track of the clicks

// Function to find the weekday pattern from the initial cohortDays
// function findWeekdayPattern(cohortDays) {
//     // Convert cohortDays to weekdays (0: Sunday, 1: Monday, ..., 6: Saturday)
//     const weekdayPattern = cohortDays.map(dateStr => moment(dateStr, 'DD MMM YYYY').day());
    
//     // Remove duplicates and sort the weekdays to identify the active days
//     const uniqueWeekdays = [...new Set(weekdayPattern)].sort();
//     return uniqueWeekdays;
// }

function findWeekdayPattern(cohortDays) {
    const patternMap = {};

    cohortDays.forEach(entry => {
        const [dateStr, type] = entry.split(',').map(s => s.trim());
        const dayOfWeek = moment(dateStr, 'DD MMM YYYY').day(); // 0-6 (Sun-Sat)

        if (!patternMap.hasOwnProperty(dayOfWeek)) {
            patternMap[dayOfWeek] = type; // 'main' or 'tutor'
        }
    });

    return patternMap; // Example: {1: 'main', 3: 'tutor'}
}

// Function to get the next valid date based on the weekday pattern
// function getNextValidDate(lastDate, pattern) {
//     const nextDate = moment(lastDate, 'DD MMM YYYY');

//     // Determine the next valid weekday based on the pattern
//     let found = false;
//     for (let i = 1; i <= 7; i++) {  // Check up to 7 days
//         const nextDay = nextDate.clone().add(i, 'days');
//         if (pattern.includes(nextDay.day())) {
//             return nextDay.format('DD MMM YYYY');
//         }
//     }

//     return null; // In case something goes wrong (shouldn't happen)
// }

function getNextValidDate(lastDate, patternMap) {
    const nextDate = moment(lastDate, 'DD MMM YYYY');

    for (let i = 1; i <= 7; i++) {
        const nextDay = nextDate.clone().add(i, 'days');
        const dayOfWeek = nextDay.day();

        if (patternMap.hasOwnProperty(dayOfWeek)) {
            const type = patternMap[dayOfWeek];
            return `${nextDay.format('DD MMM YYYY')}, ${type}`;
        }
    }

    return null;
}

// Function to get the previous valid date based on the weekday pattern
// function getPreviousValidDate(lastDate, pattern) {
//     const prevDate = moment(lastDate, 'DD MMM YYYY');

//     // Check up to 7 days in the past
//     for (let i = 1; i <= 7; i++) {
//         const prevDay = prevDate.clone().subtract(i, 'days');
//         if (pattern.includes(prevDay.day())) {
//             return prevDay.format('DD MMM YYYY');
//         }
//     }

//     return null; // Shouldn't happen if pattern is valid
// }

function getPreviousValidDate(lastDate, patternMap) {
    const prevDate = moment(lastDate, 'DD MMM YYYY');

    for (let i = 1; i <= 7; i++) {
        const prevDay = prevDate.clone().subtract(i, 'days');
        const dayOfWeek = prevDay.day();

        if (patternMap.hasOwnProperty(dayOfWeek)) {
            const type = patternMap[dayOfWeek];
            return `${prevDay.format('DD MMM YYYY')}, ${type}`;
        }
    }

    return null;
}


$('#topDay').click(function () {
    debugger
    // Reverse the cohortDays array in-place
    cohortDays.reverse();  // This modifies the original array

    if (cohortDays.length < 7) return; // Ensure there are at least 7 days in the cohortDays array

    // Find the weekday pattern from the initial cohortDays
    const pattern = findWeekdayPattern(cohortDays);
    console.log('Detected Pattern:', pattern);

    // Remove the last date from the array
    cohortDays.pop();

    // Get the last date in the cohortDays array
    const currentLastDate = cohortDays[0];

    // Calculate the next valid date based on the detected pattern
    const nextDate = getNextValidDate(currentLastDate, pattern);

    if (nextDate) {
    cohortDays.unshift(nextDate); // Add the next valid date to the beginning
}

    // Rebuild the weekDay object based on the updated cohortDays
    const keys = ['oneDay', 'secondDay', 'threeDay', 'fourthDay', 'fiveDay', 'sixDay', 'sevenDay'];
    let weekDay = {}; // Reinitialize weekDay object
    const reversedCohortDays = [...cohortDays].reverse(); // Create a reversed copy

    // reversedCohortDays.forEach((dayStr, index) => {
    //     const dayMoment = moment(dayStr, 'DD MMM YYYY');
    //     weekDay[keys[index]] = dayMoment.format('MMM-DD');
    // });

    reversedCohortDays.forEach((dayStr, index) => {
    const [datePart, type] = dayStr.split(','); // split into date and type
    const dayMoment = moment(datePart.trim(), 'DD MMM'); // parse only the date
    const formattedDate = dayMoment.format('MMM-DD');

    // Store with type
    weekDay[keys[index]] = `${formattedDate}, ${type ? type.trim() : 'main'}`;
});

    // Update the button label with the first item in the new cohortDays array
    const buttonLabel = moment(cohortDays[0], 'DD MMM YYYY').format('MMM DD, YYYY');
    $('#buttonLabel').text(buttonLabel);

    // Update the UI with the new days (contentDay elements)
    // const daysArray = Object.values(weekDay);
    // $('.contentDay').each(function (index) {
    //     if (daysArray[index]) {
    //         $(this).text(daysArray[index]);
    //     }
    // });

    const daysArray = Object.values(weekDay);

$('.contentDay').each(function (index) {
    debugger
    if(index == 0)
        {
     // Reverse the cohortDays array in-place
     cohortDays.reverse();  // This modifies the original array
     }
    if (daysArray[index] && cohortDays[index]) {
        const dayText = daysArray[index].split(',')[0].trim();
        const cohortEntry = cohortDays[index]; // e.g., "29 Apr, main"
        const parts = cohortEntry.split(',');

        let type = 'main'; // default
        if (parts.length === 2) {
            type = parts[1].trim(); // 'main' or 'tutor'
        }

        $(this).text(dayText);
        $(this).removeClass('main tutor').addClass(type);
    }
});

    clickCounter++; // Increment click count
    const dates = getDatesArray(); // Get the array of dates
    const loader = document.getElementById('loader');
    loadData(dates, cohortId, tableBody, teacherContainer, attendanceSection, attendanceHeading);
    loader.style.display = 'none'; // Hide the loader when the response is received
    console.log(`Click #${clickCounter}`, cohortDays);
});

$('#downDay').click(function () {
    debugger
    cohortDays.reverse();  
    if (cohortDays.length < 7) return;

    // Detect current pattern from the cohortDays
    const pattern = findWeekdayPattern(cohortDays);
    console.log('Detected Pattern:', pattern);

    // Remove the first (earliest) date from the array
    cohortDays.shift();

    // Get the last date in the current array (latest)
    const currentLastDate = cohortDays[cohortDays.length - 1];

    const previousDate = getPreviousValidDate(currentLastDate, pattern);

    if (previousDate) {
        cohortDays.push(previousDate); // Add it to the end
    }

    // Build reversed weekDay object
    const keys = ['oneDay', 'secondDay', 'threeDay', 'fourthDay', 'fiveDay', 'sixDay', 'sevenDay'];
    let weekDay = {};
    const reversedCohortDays = [...cohortDays].reverse();

    // reversedCohortDays.forEach((dayStr, index) => {
    //     const dayMoment = moment(dayStr, 'DD MMM YYYY');
    //     weekDay[keys[index]] = dayMoment.format('MMM-DD');
    // });

    reversedCohortDays.forEach((dayStr, index) => {
    const [datePart, type] = dayStr.split(','); // split into date and type
    const dayMoment = moment(datePart.trim(), 'DD MMM'); // parse only the date
    const formattedDate = dayMoment.format('MMM-DD');

    // Store with type
    weekDay[keys[index]] = `${formattedDate}, ${type ? type.trim() : 'main'}`;
});

    // Update the button label with the new "first" item
    const buttonLabel = moment(cohortDays[0], 'DD MMM YYYY').format('MMM DD, YYYY');
    $('#buttonLabel').text(buttonLabel);

    // Update the UI content
    // const daysArray = Object.values(weekDay);
    // $('.contentDay').each(function (index) {
    //     if (daysArray[index]) {
    //         $(this).text(daysArray[index]);
    //     }
    // });

    const daysArray = Object.values(weekDay);

$('.contentDay').each(function (index) {
    if(index == 0)
        {
    cohortDays.reverse(); } 
    if (daysArray[index] && cohortDays[index]) {
        const dayText = daysArray[index].split(',')[0].trim();
        const cohortEntry = cohortDays[index]; // e.g., "29 Apr, main"
        const parts = cohortEntry.split(',');


        let type = 'main'; // default
        if (parts.length === 2) {
            type = parts[1].trim(); // 'main' or 'tutor'
        }

        $(this).text(dayText);
        $(this).removeClass('main tutor').addClass(type);
    }
});

    clickCounter--;
    const dates = getDatesArray(); // Get the array of dates
    const loader = document.getElementById('loader');
    loadData(dates, cohortId, tableBody, teacherContainer, attendanceSection, attendanceHeading);
    loader.style.display = 'none'; // Hide the loader when the response is received
    
    console.log(`Click #${clickCounter}`, cohortDays);
});








        
        const dates = getDatesArray(); // Get the array of dates

        loadData(dates, cohortId, tableBody, teacherContainer, attendanceSection, attendanceHeading);
        


        // Function to get the next valid date based on the weekday pattern
        function loadData(dates, cohortId, tableBody, teacherContainer, attendanceSection, attendanceHeading) {
        if (cohortId) {
            const loader = document.getElementById('loader');
            const datesParam = encodeURIComponent(JSON.stringify(dates));
           

            fetch('fetch_cohort_members.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `cohortid=${encodeURIComponent(cohortId)}&dates=${datesParam}`
            })
                .then(response => response.json())
                .then(data => {
                    debugger
                    loader.style.display = 'none'; // Hide the loader when the response is received

                    // Update the <h2> element within the 'toolBar' section
                    attendanceHeading.innerText = `Attendance: ${data.teachers[0].cohortid}`;

                    // Clear existing table rows and teacher data
                    tableBody.innerHTML = '';
                    teacherContainer.innerHTML = '';

                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    debugger

                    let membersEmailBased = data.members.email_based_attendance || [];
                    let membersDisplayNameBased = data.members.display_name_based_attendance || [];
                    let formerStudents = data.members.former_students_attendance || [];
                    let teachersAttendance = data.members.teachers_attendance || [];

                    // To keep track of rows for each student, we need a map by email
                    let studentRows = {};
                    debugger

                    // Populate email-based attendance
                    membersEmailBased.forEach(member => {
                        // Ensure we have a row for this student, or find the existing one
                        if (!studentRows[member.email]) {
                            // Create a new row for this student
                            const attendanceCells = dates.map(date => {
                                const today = new Date().setHours(0, 0, 0, 0); // Today's date with time reset

                                // Append the current year to the date for comparison
                                const currentYear = new Date().getFullYear(); // Get the current year
                                const formattedDate = `${date}-${currentYear}`; // Append the year (e.g., "Jan-02-2025")
                                const currentDate = new Date(formattedDate).setHours(0, 0, 0, 0); // Convert to Date object and reset time


                                // If the date is in the future, return an empty cell
                                if (currentDate > today) {
                                    return `<td><div class="buttonTable btn-empty"></div></td>`;
                                }
                                // const attendance = member.attendance 
                                //     ? member.find(att => att.date === date) 
                                //     : { status: 'A' }; // Default to 'A' if attendance is not an array or not set

                                const attendance = member.attendance && member.date === date
                                    ? member.attendance // Directly use the attendance object
                                    : { status: 'A' }; // Default to 'A' if no matching attendance

                                // Generate the hover box content
                                // const hoverBox = `
                                //     <div class="hover-box" style="display: none;">
                                //         <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                //         <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                //         <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                //     </div>
                                // `;


                                if (attendance.status) {
                                    const statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                    const hoverBox = statusClass === 'btn-hard'
                                        ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                        : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                    return `<td><div class="buttonTable ${statusClass}">${hoverBox}${attendance.status}</div></td>`;
                                } else {
                                    const statusClass = 'A' === attendance ? 'btn-hard' : 'btn-good'; // If attendance is 'A', set as absent, else present
                                    const hoverBox = statusClass === 'btn-hard'
                                        ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                        : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                    return `<td><div class="buttonTable ${statusClass}">${hoverBox}${attendance}</div></td>`;
                                }


                            }).join('');

                            // Add the row to the table body and store it in the studentRows map
                            const rowHTML = `
                        <tr id="student-${member.email}">
                            <td>
                                <div class="form-check" style="padding: unset;">
                                   
                                    <div class="checkboxCustome">
                                <input class="form-check-input row-select" type="checkbox" value=""  id="flexCheckDefault">
                                <div class="checkbox-div">
                                    <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8162 0.207014C12.0701 0.473695 12.0597 0.895677 11.793 1.14954L4.08929 8.48287C3.95773 8.6081 3.78078 8.67424 3.59933 8.66598C3.41788 8.65772 3.24766 8.57579 3.12803 8.43912L0.165063 5.05451C-0.0774581 4.77747 -0.0494802 4.35629 0.227553 4.11377C0.504586 3.87125 0.925768 3.89923 1.16829 4.17626L3.67342 7.0379L10.8737 0.183799C11.1404 -0.070061 11.5624 -0.0596674 11.8162 0.207014Z" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                                </div>
                            </td>
                            <td>
                                <button class="btnStudent">
                                    <div onclick="openModal(event, '${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, '${member.profile_picture}', ${member.id})" 
                                        style="display:flex;align-items: center;gap:10px">
                                        <img src="${member.profile_picture}" alt="Profile Picture" onerror="this.onerror=null;this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png';">       
                                        ${member.firstname} ${member.lastname}
                                    </div>
                                     <span 
                                        onclick="openMenu('${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, '${member.profile_picture}', ${member.id})" 
                                        style="
                                            background-color: ${member.status.toLowerCase() === 'active' || /^exclusive\d*$/.test(member.status.toLowerCase()) ? '#f0fdf4' : '#fdf4f4'};
                                            color: ${member.status.toLowerCase() === 'active' || /^exclusive\d*$/.test(member.status.toLowerCase()) ? '#22a33d' : '#d93737'};
                                            border: 1.5px solid ${member.status.toLowerCase() === 'active' || /^exclusive\d*$/.test(member.status.toLowerCase()) ? '#22a33d' : '#d93737'};
                                            padding: 10px 15px 8px;
                                            border-radius: 10px;
                                        ">
                                        ${member.status}
                                    </span>
                                </button>
                            </td>
                            <td class="PhoneColumn" style="padding-left: 20px;">${member.phone}</td>
                            <td class="EmailColumn" ><a href="#">${member.email}</a></td>
                            ${attendanceCells}
                        </tr>
                    `;
                            tableBody.innerHTML += rowHTML;
                            studentRows[member.email] = true; // Mark this student as added
                        } else {
                            // If the student already exists in the rows, we only need to update their attendance for the new dates
                            const row = document.getElementById(`student-${member.email}`);

                            // Get all the <th> elements that represent the dates
                            const dateHeaders = row.closest('table').querySelectorAll('th'); // Find all <th> elements in the table (assuming dates are in <th>)

                            // Loop through each date (from your dates array or similar)
                            dates.forEach(date => {

                                if (member.date === date) {


                                    const attendance = member.attendance && member.date === date
                                        ? member.attendance // Directly use the attendance object
                                        : { status: 'A' }; // Default to 'A' if no matching attendance

                                    let aval = '';
                                    let statusClass = '';
                                    let hoverBoxx = '';
                                    if (attendance.status) {
                                        statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                        hoverBoxx = statusClass === 'btn-hard'
                                            ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                            : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                        aval = attendance.status;
                                    } else {
                                        statusClass = attendance === 'P' ? 'btn-good' : 'btn-hard';
                                        hoverBoxx = statusClass === 'btn-hard'
                                            ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                            : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                        aval = attendance;
                                    }


                                    // Find the index of the <th> element where the date matches
                                    const dateColumnIndex = Array.from(dateHeaders).findIndex(th => th.innerText === date);

                                    if (dateColumnIndex !== -1) {
                                        // Find the corresponding <td> in the row (skip the first 4 columns)
                                        const tdCell = row.querySelectorAll('td')[dateColumnIndex];
                                        if (tdCell) {
                                            tdCell.innerHTML = `<div class="buttonTable ${statusClass}">${hoverBoxx}${aval}</div>`;
                                        }
                                    }
                                }
                            });
                        }
                    });

                    // To keep track of rows for each student in membersDisplayNameBased, use their combined firstname and lastname
                    let displayNameRows = {};

                    // Add a bar-like header for "Non-Student Attendance" if there are display-name-based records
                    if (membersDisplayNameBased.length > 0) {
                        tableBody.innerHTML += `
                        <tr>
                            <td colspan="${dates.length + 4}" style="padding: 0;">
                                <div class="nonStudentHeader" style="text-align:center; font-weight:bold; background-color:#f5f5f5; padding:10px;">
                                    Non-Student Attendance
                                </div>
                            </td>
                        </tr>
                    `;

                        // Populate display-name-based attendance
                        membersDisplayNameBased.forEach(member => {
                            const fullName = `${member.firstname} ${member.lastname}`;

                            // Ensure we have a row for this student, or find the existing one
                            if (!displayNameRows[fullName]) {
                                // Create a new row for this student
                                const attendanceCells = dates.map(date => {
                                    const today = new Date().setHours(0, 0, 0, 0); // Today's date with time reset

                                    // Append the current year to the date for comparison
                                    const currentYear = new Date().getFullYear(); // Get the current year
                                    const formattedDate = `${date}-${currentYear}`; // Append the year (e.g., "Jan-02-2025")
                                    const currentDate = new Date(formattedDate).setHours(0, 0, 0, 0); // Convert to Date object and reset time


                                    // If the date is in the future, return an empty cell
                                    if (currentDate > today) {
                                        return `<td><div class="buttonTable btn-empty"></div></td>`;
                                    }
                                    
                                    // const attendance = member.attendance 
                                    //     ? member.find(att => att.date === date) 
                                    //     : { status: 'A' }; // Default to 'A' if attendance is not an array or not set
                                    const attendance = member.attendance && member.date === date
                                        ? { status: member.attendance } // Directly use the attendance object
                                        : { status: 'A' }; // Default to 'A' if no matching attendance
                                    if (attendance.status) {
                                        const statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                        const hoverBox1 = statusClass === 'btn-hard'
                                            ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                            : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                        return `<td><div class="buttonTable ${statusClass}">${hoverBox1}${attendance.status}</div></td>`;
                                    } else {
                                        const statusClass = attendance === 'P' ? 'btn-good' : 'btn-hard';
                                        const hoverBox1 = statusClass === 'btn-hard'
                                            ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                            : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                        return `<td><div class="buttonTable ${statusClass}">${hoverBox1}${attendance}</div></td>`;
                                    }
                                }).join('');

                                // Add the row to the table body and store it in the displayNameRows map
                                const rowHTML = `
                                <tr id="student-${fullName}">
                                    <td>
                                        <div class="form-check" style="padding: unset;">
                                            
                                               <div class="checkboxCustome">
                                <input class="form-check-input row-select" type="checkbox" value=""  id="flexCheckDefault">
                                <div class="checkbox-div">
                                    <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8162 0.207014C12.0701 0.473695 12.0597 0.895677 11.793 1.14954L4.08929 8.48287C3.95773 8.6081 3.78078 8.67424 3.59933 8.66598C3.41788 8.65772 3.24766 8.57579 3.12803 8.43912L0.165063 5.05451C-0.0774581 4.77747 -0.0494802 4.35629 0.227553 4.11377C0.504586 3.87125 0.925768 3.89923 1.16829 4.17626L3.67342 7.0379L10.8737 0.183799C11.1404 -0.070061 11.5624 -0.0596674 11.8162 0.207014Z" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btnStudent">
                                            <div onclick="openModal(event, '${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png')" 
                                                style="display:flex;align-items: center;gap:10px">
                                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png" alt="">
                                                ${member.firstname} ${member.lastname}
                                            </div>
                                            <span 
                                            onclick="openMenu('${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png', 0)" 
                                            style="
                                                background-color: #fdf4f4;
                                                color: #d93737;
                                                border: 1.5px solid #d93737;
                                                padding: 10px 15px 8px;
                                                border-radius: 10px;">
                                            NA
                                        </span>
                                        </button>
                                    </td>
                                    <td class="PhoneColumn" style="padding-left: 20px;">${member.phone || '-'}</td>
                                    <td class="EmailColumn" ><a href="mailto:${member.email}">${member.email || '-'}</a></td>
                                    ${attendanceCells}
                                </tr>
                            `;
                                tableBody.innerHTML += rowHTML;
                                displayNameRows[fullName] = true; // Mark this student as added
                            } else {
                                // If the student already exists in the rows, we only need to update their attendance for the new dates
                                const row = document.getElementById(`student-${fullName}`);
                                // Get all the <th> elements that represent the dates
                                const dateHeaders = row.closest('table').querySelectorAll('th'); // Find all <th> elements in the table (assuming dates are in <th>)
                                const attendanceCells = dates.map(date => {
                                    if (member.date === date) {
                                        const attendance = member.attendance && member.date === date
                                            ? member.attendance // Directly use the attendance object
                                            : { status: 'A' }; // Default to 'A' if no matching attendance

                                        let aval = '';
                                        let statusClass = '';
                                        let hoverBox2 = '';

                                        // Determine the class and value based on attendance status
                                        if (attendance.status) {
                                            statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                            hoverBox2 = statusClass === 'btn-hard'
                                                ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                                : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                            aval = attendance.status;
                                        } else {
                                            statusClass = attendance === 'P' ? 'btn-good' : 'btn-hard';
                                            hoverBox2 = statusClass === 'btn-hard'
                                                ? `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                    </div>
                `
                                                : `
                    <div class="hover-box" style="display: none;">
                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                    </div>
                `;
                                            aval = attendance;
                                        }

                                        // Find the column index for the matching date
                                        const dateColumnIndex = Array.from(dateHeaders).findIndex(th => th.innerText === date);

                                        if (dateColumnIndex !== -1) {
                                            // Get the corresponding <td> and update its content
                                            const tdCell = row.querySelectorAll('td')[dateColumnIndex];
                                            if (tdCell) {
                                                tdCell.innerHTML = `<div class="buttonTable ${statusClass}">${hoverBox2}${aval}</div>`;
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }




                    // Add a bar-like header for "Former Student Attendance" if there are display-name-based records
                    if (formerStudents.length > 0) {
                        tableBody.innerHTML += `
                            <tr>
                                <td colspan="${dates.length + 4}" style="padding: 0;">
                                    <div class="nonStudentHeader" style="text-align:center; font-weight:bold; background-color:#f5f5f5; padding:10px;">
                                        Former Students
                                    </div>
                                </td>
                            </tr>
                           
                        `;


                        // To keep track of rows for each student, we need a map by email
                        let formerStudentRows = {};

                        // Populate email-based attendance
                        formerStudents.forEach(member => {
                            // Ensure we have a row for this student, or find the existing one
                            if (!formerStudentRows[member.email]) {
                                // Create a new row for this student
                                const attendanceCells = dates.map(date => {
                                    const today = new Date().setHours(0, 0, 0, 0); // Today's date with time reset

                                    // Append the current year to the date for comparison
                                    const currentYear = new Date().getFullYear(); // Get the current year
                                    const formattedDate = `${date}-${currentYear}`; // Append the year (e.g., "Jan-02-2025")
                                    const currentDate = new Date(formattedDate).setHours(0, 0, 0, 0); // Convert to Date object and reset time


                                    // If the date is in the future, return an empty cell
                                    if (currentDate > today) {
                                        return `<td><div class="buttonTable btn-empty"></div></td>`;
                                    }
                                    // const attendance = member.attendance 
                                    //     ? member.find(att => att.date === date) 
                                    //     : { status: 'A' }; // Default to 'A' if attendance is not an array or not set

                                    const attendance = member.attendance && member.date === date
                                        ? member.attendance // Directly use the attendance object
                                        : { status: 'A' }; // Default to 'A' if no matching attendance


                                    if (attendance.status) {
                                        const statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                        const hoverBox3 = statusClass === 'btn-hard'
                                            ? `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                </div>
                                            `
                                            : `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                </div>
                                            `;
                                        return `<td><div class="buttonTable ${statusClass}">${hoverBox3}${attendance.status}</div></td>`;
                                    } else {
                                        const statusClass = attendance === 'P' ? 'btn-good' : 'btn-hard';
                                        const hoverBox3 = statusClass === 'btn-hard'
                                            ? `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                </div>
                                            `
                                            : `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                </div>
                                            `;
                                        return `<td><div class="buttonTable ${statusClass}">${hoverBox3}${attendance}</div></td>`;
                                    }


                                }).join('');

                                // Add the row to the table body and store it in the studentRows map
                                const rowHTML = `
                                    <tr id="student-${member.email}">
                                                <td>
                                                    <div class="form-check" style="padding: unset;">
                                                        
                                                        <div class="checkboxCustome">
                                            <input class="form-check-input row-select" type="checkbox" value=""  id="flexCheckDefault">
                                            <div class="checkbox-div">
                                                <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8162 0.207014C12.0701 0.473695 12.0597 0.895677 11.793 1.14954L4.08929 8.48287C3.95773 8.6081 3.78078 8.67424 3.59933 8.66598C3.41788 8.65772 3.24766 8.57579 3.12803 8.43912L0.165063 5.05451C-0.0774581 4.77747 -0.0494802 4.35629 0.227553 4.11377C0.504586 3.87125 0.925768 3.89923 1.16829 4.17626L3.67342 7.0379L10.8737 0.183799C11.1404 -0.070061 11.5624 -0.0596674 11.8162 0.207014Z" fill="white"/>
                                                </svg>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btnStudent">
                                            <div onclick="openModal(event, '${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, '${member.profile_picture}')" 
                                                style="display:flex;align-items: center;gap:10px">
                                                <img src="${member.profile_picture}" alt="Profile Picture" onerror="this.onerror=null;this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png';">       
                                                ${member.firstname} ${member.lastname}
                                            </div>
                                            <span 
                                        onclick="openMenu('${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, '${member.profile_picture}', ${member.id})" 
                                        style="
                                            background-color: ${member.status.toLowerCase() === 'active' ? '#f0fdf4' : '#fdf4f4'};
                                            color: ${member.status.toLowerCase() === 'active' ? '#22a33d' : '#d93737'};
                                            border: 1.5px solid ${member.status.toLowerCase() === 'active' ? '#22a33d' : '#d93737'};
                                            padding: 10px 15px 8px;
                                            border-radius: 10px;
                                        ">
                                        ${member.status}
                                    </span>
                                        </button>
                                    </td>
                                    <td class="PhoneColumn" style="padding-left: 20px;">${member.phone}</td>
                                    <td class="EmailColumn" ><a href="#">${member.email}</a></td>
                                    ${attendanceCells}
                                </tr>
                            `;
                                tableBody.innerHTML += rowHTML;
                                formerStudentRows[member.email] = true; // Mark this student as added
                            } else {
                                // If the student already exists in the rows, we only need to update their attendance for the new dates
                                const row = document.getElementById(`student-${member.email}`);

                                // Get all the <th> elements that represent the dates
                                const dateHeaders = row.closest('table').querySelectorAll('th'); // Find all <th> elements in the table (assuming dates are in <th>)

                                // Loop through each date (from your dates array or similar)
                                dates.forEach(date => {

                                    if (member.date === date) {

                                        const attendance = member.attendance && member.date === date
                                            ? member.attendance // Directly use the attendance object
                                            : { status: 'A' }; // Default to 'A' if no matching attendance

                                        let aval = '';
                                        let statusClass = '';
                                        let hoverBox4 = '';
                                        if (attendance.status) {
                                            statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                            hoverBox4 = statusClass === 'btn-hard'
                                                ? `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                    </div>
                                                `
                                                : `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                    </div>
                                                `;
                                            aval = attendance.status;
                                        } else {
                                            statusClass = attendance === 'P' ? 'btn-good' : 'btn-hard';
                                            hoverBox4 = statusClass === 'btn-hard'
                                                ? `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                    </div>
                                                `
                                                : `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                    </div>
                                                `;
                                            aval = attendance;
                                        }


                                        // Find the index of the <th> element where the date matches
                                        const dateColumnIndex = Array.from(dateHeaders).findIndex(th => th.innerText === date);

                                        if (dateColumnIndex !== -1) {
                                            // Find the corresponding <td> in the row (skip the first 4 columns)
                                            const tdCell = row.querySelectorAll('td')[dateColumnIndex];
                                            if (tdCell) {
                                                tdCell.innerHTML = `<div class="buttonTable ${statusClass}">${hoverBox4}${aval}</div>`;
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }



                    debugger
                     // Add a bar-like header for "Former Student Attendance" if there are display-name-based records
                     if (teachersAttendance.length > 0) {
                        tableBody.innerHTML += `
                            <tr>
                                <td colspan="${dates.length + 4}" style="padding: 0;">
                                    <div class="nonStudentHeader" style="text-align:center; font-weight:bold; background-color:#f5f5f5; padding:10px;">
                                        Teachers Attendance
                                    </div>
                                </td>
                            </tr>
                           
                        `;


                        // To keep track of rows for each student, we need a map by email
                        let teachersRows = {};

                        // Populate email-based attendance
                        teachersAttendance.forEach(member => {
                            debugger
                            // Ensure we have a row for this student, or find the existing one
                            if (!teachersRows[member.firstname + ' ' + member.lastname]) {
                                // Create a new row for this student
                                const attendanceCells = dates.map(date => {
                                    const today = new Date().setHours(0, 0, 0, 0); // Today's date with time reset

                                    // Append the current year to the date for comparison
                                    const currentYear = new Date().getFullYear(); // Get the current year
                                    const formattedDate = `${date}-${currentYear}`; // Append the year (e.g., "Jan-02-2025")
                                    const currentDate = new Date(formattedDate).setHours(0, 0, 0, 0); // Convert to Date object and reset time


                                    // If the date is in the future, return an empty cell
                                    if (currentDate > today) {
                                        return `<td><div class="buttonTable btn-empty"></div></td>`;
                                    }
                                    // const attendance = member.attendance 
                                    //     ? member.find(att => att.date === date) 
                                    //     : { status: 'A' }; // Default to 'A' if attendance is not an array or not set

                                    const attendance = member.attendance && member.date === date
                                        ? member.attendance // Directly use the attendance object
                                        : { status: 'A' }; // Default to 'A' if no matching attendance


                                    if (attendance.status) {
                                        const statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                        const hoverBox3 = statusClass === 'btn-hard'
                                            ? `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                </div>
                                            `
                                            : `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                </div>
                                            `;
                                        return `<td><div class="buttonTable ${statusClass}">${hoverBox3}${attendance.status}</div></td>`;
                                    } else {
                                        const statusClass = attendance === 'P' ? 'btn-good' : 'btn-hard';
                                        const hoverBox3 = statusClass === 'btn-hard'
                                            ? `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                </div>
                                            `
                                            : `
                                                <div class="hover-box" style="display: none;">
                                                    <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                    <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                </div>
                                            `;
                                        return `<td><div class="buttonTable ${statusClass}">${hoverBox3}${attendance}</div></td>`;
                                    }


                                }).join('');

                                // Add the row to the table body and store it in the studentRows map
                                const rowHTML = `
                                    <tr id="student-${member.firstname} ${member.lastname}">
                                                <td>
                                                    <div class="form-check" style="padding: unset;">
                                                        
                                                        <div class="checkboxCustome">
                                            <input class="form-check-input row-select" type="checkbox" value=""  id="flexCheckDefault">
                                            <div class="checkbox-div">
                                                <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8162 0.207014C12.0701 0.473695 12.0597 0.895677 11.793 1.14954L4.08929 8.48287C3.95773 8.6081 3.78078 8.67424 3.59933 8.66598C3.41788 8.65772 3.24766 8.57579 3.12803 8.43912L0.165063 5.05451C-0.0774581 4.77747 -0.0494802 4.35629 0.227553 4.11377C0.504586 3.87125 0.925768 3.89923 1.16829 4.17626L3.67342 7.0379L10.8737 0.183799C11.1404 -0.070061 11.5624 -0.0596674 11.8162 0.207014Z" fill="white"/>
                                                </svg>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btnStudent">
                                            <div onclick="openModal(event, '${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, '${member.profile_picture}')" 
                                                style="display:flex;align-items: center;gap:10px">
                                               <img src="${member.profile_picture}" alt="Profile Picture" onerror="this.onerror=null;this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png';">    
                                                ${member.firstname} ${member.lastname}
                                            </div>
                                            <span 
                                            onclick="openMenu('${member.firstname} ${member.lastname}', 'completed', '${member.email}', '${member.phone}', 1, '${member.profile_picture}', ${member.id})" 
                                            style="
                                                background-color: #f0fdf4;
                                                color: #22a33d;
                                                border: 1.5px solid #22a33d;
                                                padding: 10px 15px 8px;
                                                border-radius: 10px;">
                                            Active
                                        </span>
                                        </button>
                                    </td>
                                    <td class="PhoneColumn" style="padding-left: 20px;">${member.phone}</td>
                                    <td class="EmailColumn" ><a href="#">${member.email}</a></td>
                                    ${attendanceCells}
                                </tr>
                            `;
                                tableBody.innerHTML += rowHTML;
                                //formerStudentRows[member.email] = true; // Mark this student as added
                                teachersRows[member.firstname + ' ' + member.lastname] =  true;
                            } else {
                                // If the student already exists in the rows, we only need to update their attendance for the new dates
                                const row = document.getElementById(`student-${member.firstname} ${member.lastname}`);

                                // Get all the <th> elements that represent the dates
                                const dateHeaders = row.closest('table').querySelectorAll('th'); // Find all <th> elements in the table (assuming dates are in <th>)

                                // Loop through each date (from your dates array or similar)
                                dates.forEach(date => {

                                    if (member.date === date) {

                                        const attendance = member.attendance && member.date === date
                                            ? member.attendance // Directly use the attendance object
                                            : { status: 'A' }; // Default to 'A' if no matching attendance

                                        let aval = '';
                                        let statusClass = '';
                                        let hoverBox4 = '';
                                        if (attendance.status) {
                                            statusClass = attendance.status === 'P' ? 'btn-good' : 'btn-hard';
                                            hoverBox4 = statusClass === 'btn-hard'
                                                ? `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                    </div>
                                                `
                                                : `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                    </div>
                                                `;
                                            aval = attendance.status;
                                        } else {
                                            statusClass = attendance === 'P' ? 'btn-good' : 'btn-hard';
                                            hoverBox4 = statusClass === 'btn-hard'
                                                ? `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>NA</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>NA</span></div></div>
                                                    </div>
                                                `
                                                : `
                                                    <div class="hover-box" style="display: none;">
                                                        <div><div class="hover-box-child"><strong>In Class for</strong><span>${member.duration}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Entered at</strong><span>${member.start}</span></div></div>
                                                        <div><div class="hover-box-child"><strong>Left at</strong><span>${member.left}</span></div></div>
                                                    </div>
                                                `;
                                            aval = attendance;
                                        }


                                        // Find the index of the <th> element where the date matches
                                        const dateColumnIndex = Array.from(dateHeaders).findIndex(th => th.innerText === date);

                                        if (dateColumnIndex !== -1) {
                                            // Find the corresponding <td> in the row (skip the first 4 columns)
                                            const tdCell = row.querySelectorAll('td')[dateColumnIndex];
                                            if (tdCell) {
                                                tdCell.innerHTML = `<div class="buttonTable ${statusClass}">${hoverBox4}${aval}</div>`;
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }



 
                    // Populate teacher data
                    data.teachers.forEach(teacher => {
                        teacherContainer.innerHTML += `
                    <div class="teacherData">
                        <div class="itemTeacher">
                            <img src="${teacher.profile_picture}" alt="Profile Picture" onerror="this.onerror=null;this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png';">        
                            ${teacher.firstname}
                        </div>
                        <div class="itemTeacher borderGrayColor">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            ${teacher.days}
                        </div>
                        <div class="itemTeacher borderGrayColor">
                            <i class="fa fa-clock" aria-hidden="true"></i>
                            ${teacher.sessiontiming}
                        </div>
                    </div>
                    <div class="borderTeacher"></div>
                `;
                    });
                })
                .catch(error => console.error('Error fetching cohort members:', error));
        } 
        else {
            tableBody.innerHTML = ''; // Clear table if no cohort is selected
            teacherContainer.innerHTML = ''; // Clear teacher section
        }}
    });

})




</script>

<!-- <script src="js/calendar_modal.js"></script> -->

<?php

echo $OUTPUT->footer();