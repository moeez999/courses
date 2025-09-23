<?php
 function displayAttendanceChart($userEmail, $weeks = 8) {
    
    try {
        $attendanceData = getAttendanceDataForChart($userEmail, $weeks);
        //print_r($attendanceData);
        echo '
        <section class="profile-card">
            <div class="card-header">
                <h2>'.get_string('overallattendance', 'core_user').'</h2>
                <div class="attendance-legend">
                    <div class="legend-item">
                        <span class="color-dot main-class"></span>
                        <span>'.get_string('mainclass', 'core_user').'</span>
                        <div class="checkbox-wrapper">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="legend-item">
                        <span class="color-dot practice-class"></span>
                        <span>'.get_string('practiceclass', 'core_user').'</span>
                        <div class="checkbox-wrapper">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div>
                    <div class="attendance-controls">
                        <button class="control-btn prev"><i class="fas fa-chevron-right"></i></button>
                        <div class="select-set" onclick="toggleDropdown()">
                            <span>'.get_string('selectset', 'core_user').'</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <button class="control-btn next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <div class="y-axis">
                    <span>100</span><span>90</span><span>80</span><span>70</span><span>60</span><span>50</span><span>40</span><span>30</span><span>20</span><span>10</span>
                </div>
                <div class="chart-bars">';
        
        if ($attendanceData && !empty($attendanceData)) {
            foreach ($attendanceData as $period => $data) {
                //print_r($data);
                $mainHeight = $data['main']['attendance'] ?? 0;
                $practiceHeight = $data['practice']['attendance'] ?? 0;
                $mainHours = $data['main']['hours'] ?? '0/0';
                $practiceHours = $data['practice']['hours'] ?? '0/0';
                
                // Convert percentage to match the y-axis scale (50 = 100%)
                $mainHeightPercent = ($mainHeight / 100) * 50;
                $practiceHeightPercent = ($practiceHeight / 100) * 50;

                list($week, $year) = explode('-', $period); // split into week and year

                // Create DateTime for Monday of that week
                $dto = new DateTime();
                $dto->setISODate((int)$year, (int)$week);

                // Get start date (Monday)
                $start = $dto->format('d/m/Y');

                // Get end date (Sunday)
                $dto->modify('+6 days');
                $end = $dto->format('d/m/Y');

                
                //echo $mainHours;
                echo '<div class="bar-group">
                        <div class="bar-wrapper">
                            <div class="bar-text">'.$mainHeight.' Hrs</div>
                            <div class="bar blue" style="height: '.$mainHeightPercent.'%;"></div>
                            <div class="bar-text2">'.$practiceHeight.' Hrs</div>
                            <div class="bar red" style="height: '.$practiceHeightPercent.'%;"></div>
                        </div>
                        <div class="bar-label">'.$start.'-'.$end.'</div>
                    </div>';
            }
        } else {
            echo '<div class="no-data">'.get_string('noattendancedata', 'core_user').'</div>';
        }
        
        echo '</div></div></section>';
        
        // Chart interaction JavaScript
        echo '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle bar visibility
            document.querySelectorAll(".checkbox-wrapper").forEach(function(checkbox) {
                checkbox.addEventListener("click", function() {
                    this.classList.toggle("checked");
                    const isMainClass = this.closest(".legend-item").querySelector(".color-dot").classList.contains("main-class");
                    const barClass = isMainClass ? "blue" : "red";
                    
                    document.querySelectorAll(".bar." + barClass).forEach(function(bar) {
                        bar.style.opacity = this.classList.contains("checked") ? "1" : "0.3";
                    }.bind(this));
                });
            });
            
            // Navigation controls
            document.querySelector(".control-btn.prev").addEventListener("click", function() {
                // Load previous period data
                console.log("Previous period clicked");
            });
            
            document.querySelector(".control-btn.next").addEventListener("click", function() {
                // Load next period data
                console.log("Next period clicked");
            });
            
            // Set selection dropdown
            document.querySelector(".select-set").addEventListener("click", function() {
                // Implement set selection dropdown
                console.log("Set selection clicked");
            });
        });
        </script>';
        
    } catch (Exception $e) {
        error_log("Attendance chart error: " . $e->getMessage());
        echo '<div class="error-message">Error loading attendance data. Please try again later.</div>';
    }
}

function getAttendanceDataForChart($userEmail, $weeks = 58) {
    global $DB;
    
    try {
        $endDate = date('Y-m-d H:i:s');
        $startDate = date('Y-m-d H:i:s', strtotime("-$weeks weeks"));
        
        // PROPER TABLE EXISTENCE CHECK
        $tables = $DB->get_tables();
        if (!in_array('google_meet_activities', $tables)) {
            throw new Exception("Required table 'google_meet_activities' doesn't exist");
        }
        
        // Check if giax_googlemeet table exists
        $giaxTableExists = in_array('giax_googlemeet', $tables);
        
        // Build the SQL query based on table availability
        //if ($giaxTableExists) {
            $sql = "SELECT a.*, g.name as meeting_type 
                    FROM {google_meet_activities} a
                    LEFT JOIN {googlemeet} g ON 
                        LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                        LOWER(CONCAT(
                            SUBSTRING(a.meeting_code, 1, 3), '-',
                            SUBSTRING(a.meeting_code, 4, 3), '-',
                            SUBSTRING(a.meeting_code, 7, 3)
                        ))
                    WHERE a.identifier = ? AND a.activity_time BETWEEN ? AND ?
                    
                    ORDER BY a.activity_time DESC"; //
        // } else {
        //     $sql = "SELECT * FROM {google_meet_activities}
        //             WHERE user_email = ? 
        //             AND activity_time BETWEEN ? AND ?
        //             ORDER BY a.activity_time DESC";
        // }
        echo $sql;
        $activities = $DB->get_records_sql($sql, [$userEmail, $startDate, $endDate]);//
        
         //print_r($activities);
        
        if (empty($activities)) {
            return [];
        }
        
        $groupedData = [];
        
        foreach ($activities as $activity) {
           
            // Convert activity_time to week format (W-Y)
            $week = date('W-Y', strtotime($activity->activity_time));
            
            // Convert duration from seconds to hours
            $durationHours = round($activity->duration_seconds / 3600, 2);
            
            if (!isset($groupedData[$week])) {
                $groupedData[$week] = [
                    'main' => ['hours' => '0/0', 'attendance' => 0, 'count' => 0],
                    'practice' => ['hours' => '0/0', 'attendance' => 0, 'count' => 0]
                ];
            }
            
            // Determine class type - since your sample shows meeting_type is empty, we'll use display_name
            $isPractice = false;
            $isMain = false;
            
            // First check display_name (which contains participant name in your sample)
            // You may need to adjust this based on where the class type is stored
            if (!empty($activity->display_name)) {
                $isPractice = (stripos($activity->display_name, 'Practice') !== false) || 
                            (stripos($activity->display_name, 'Practical') !== false);
                $isMain = (stripos($activity->display_name, 'Main') !== false);
            }
            // Fallback to organizer_email if needed
            else if (!empty($activity->organizer_email)) {
                $isPractice = (stripos($activity->organizer_email, 'Practice') !== false) || 
                            (stripos($activity->organizer_email, 'Practical') !== false);
                $isMain = (stripos($activity->organizer_email, 'Main') !== false);
            }
            
            // Default to main class if neither flag is set
            $type = ($isPractice && !$isMain) ? 'practice' : 'main';
            
            // Update hours (convert seconds to hours)
            list($currentHours, $totalHours) = explode('/', $groupedData[$week][$type]['hours']);
            $groupedData[$week][$type]['hours'] = 
                number_format($currentHours + $durationHours, 2) . '/' . 
                number_format($totalHours + $durationHours, 2);
            
            // For attendance percentage - since your sample doesn't show attended/expected counts,
            // we'll need to determine how to calculate this based on your actual data
            // This is a placeholder - adjust according to your actual attendance tracking
            $attendedCount = 1; // Assuming 1 participant for this session
            $expectedCount = 1; // Adjust based on your expected participants
            
            if ($expectedCount > 0) {
                $attendancePercent = min(100, ($attendedCount / $expectedCount) * 100);
                $currentAvg = $groupedData[$week][$type]['attendance'];
                $currentCount = $groupedData[$week][$type]['count'];
                $groupedData[$week][$type]['attendance'] =  $currentHours + $durationHours;
                $groupedData[$week][$type]['count']++;
            }
        }
        //print_r($groupedData);
        return $groupedData;
        
    } catch (Exception $e) {
        error_log("Attendance chart error: " . $e->getMessage());
        echo '<div class="error-message">Error loading attendance data. Please try again later.</div>';
    }
}
?>
<!-- Dropdown -->
<div class="dropdown-container" id="dropdownMenu">
    <div class="dropdown-header">
        <span>Topic</span>
        <span style="cursor:pointer;" onclick="toggleDropdown()">✕</span>
    </div>

    <!-- Topic Section -->
    <div class="dropdown-section">
        <div class="expandable" onclick="toggleSublist('a1-level1', this)">
            A1 - Level 1 <span class="arrow">▶</span>
        </div>
        <ul class="dropdown-sublist" id="a1-level1">
            <li>Alphabet</li>
            <li>Number</li>
            <li>Self Introduction</li>
            <li>Verb Be</li>
        </ul>
    </div>

    <div class="dropdown-section">
        <div class="expandable" onclick="toggleSublist('a1-level2', this)">
            A1 - Level 2 <span class="arrow">▶</span>
        </div>
        <ul class="dropdown-sublist" id="a1-level2">
            <li>Topic 1</li>
            <li>Topic 2</li>
        </ul>
    </div>

    <div class="dropdown-section">
        <div class="expandable" onclick="toggleSublist('b1-level5', this)">
            B1 - Level 5 <span class="arrow">▶</span>
        </div>
        <ul class="dropdown-sublist" id="b1-level5">
            <li>Topic A</li>
            <li>Topic B</li>
        </ul>
    </div>

    <div class="dropdown-section">
        <div class="expandable" onclick="toggleSublist('b1-level6', this)">
            B1 - Level 6 <span class="arrow">▶</span>
        </div>
        <ul class="dropdown-sublist" id="b1-level6">
            <li>Topic X</li>
            <li>Topic Y</li>
        </ul>
    </div>

    <!-- Sets of Time -->
    <div class="dropdown-section">
        <div class="dropdown-title">Sets Of Time</div>
        <ul>
            <li class="dropdown-item">Day</li>
            <li class="dropdown-item">Week</li>
            <li class="dropdown-item">Month</li>
            <li class="dropdown-item">Past 3 months</li>
            <li class="dropdown-item">Past 6 months</li>
        </ul>
    </div>

    <!-- Date Inputs -->
    <div class="date-input" onclick="openCalendar('from')">
        From : <span id="fromDate">1st Jan</span> 📅
    </div>
    <div class="date-input" onclick="openCalendar('to')">
        To : <span id="toDate">31 Jul 2024</span> 📅
    </div>
</div>

<!-- Calendar Popup -->
<div class="calendar-popup" id="calendarPopup">
    <div class="calendar-header">
        <button onclick="prevMonth()">&#8592;</button>
        <span id="calendarMonth">January 2025</span>
        <button onclick="nextMonth()">&#8594;</button>
    </div>
    <div class="calendar-grid" id="calendarDays"></div>
    <button class="done-btn" onclick="closeCalendar()">Done</button>
</div>
<script>
let dropdownOpen = false;
let selectedInput = null;
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    dropdownOpen = !dropdownOpen;
    menu.style.display = dropdownOpen ? 'block' : 'none';
}

function toggleSublist(id, element) {
    const sublist = document.getElementById(id);
    const arrow = element.querySelector('.arrow');
    if (sublist.style.display === 'block') {
        sublist.style.display = 'none';
        arrow.classList.remove('open');
    } else {
        sublist.style.display = 'block';
        arrow.classList.add('open');
    }
}

function openCalendar(type) {
    selectedInput = type;
    document.getElementById('calendarPopup').style.display = 'block';
    renderCalendar();
}

function closeCalendar() {
    document.getElementById('calendarPopup').style.display = 'none';
}

function renderCalendar() {
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    document.getElementById('calendarMonth').innerText = monthNames[currentMonth] + ' ' + currentYear;

    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const grid = document.getElementById('calendarDays');
    grid.innerHTML = "";

    // Empty slots before 1st day
    for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement('div');
        grid.appendChild(empty);
    }

    // Add days
    for (let day = 1; day <= daysInMonth; day++) {
        const d = document.createElement('div');
        d.innerText = day;
        d.classList.add('calendar-day');
        d.onclick = () => selectDate(day);
        grid.appendChild(d);
    }
}

function selectDate(day) {
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const formatted = `${day} ${monthNames[currentMonth]} ${currentYear}`;
    if (selectedInput === 'from') {
        document.getElementById('fromDate').innerText = formatted;
    } else {
        document.getElementById('toDate').innerText = formatted;
    }
    closeCalendar();
}

function prevMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar();
}
</script>
 <?php
// Example usage:
 displayAttendanceChart($user->email, 58); // Show last 8 weeks
 

            // // Attendance Chart Section
            // echo '
            // <section class="profile-card">
            // <div class="card-header">
            //     <h2>'.get_string('overallattendance', 'core_user').'</h2>
            //     <div class="attendance-legend">
            //     <div class="legend-item">
            //         <span class="color-dot main-class"></span>
            //         <span>'.get_string('mainclass', 'core_user').'</span>
            //         <div class="checkbox-wrapper">
            //         <i class="fas fa-check"></i>
            //         </div>
            //     </div>
            //     <div class="legend-item">
            //         <span class="color-dot practice-class"></span>
            //         <span>'.get_string('practiceclass', 'core_user').'</span>
            //         <div class="checkbox-wrapper">
            //         <i class="fas fa-check"></i>
            //         </div>
            //     </div>
                
            //     <div class="attendance-controls">
            //     <button class="control-btn prev"><i class="fas fa-chevron-left"></i></button>
            //     <div class="select-set">
            //         <span>'.get_string('selectset', 'core_user').'</span>
            //         <i class="fas fa-chevron-down"></i>
            //     </div>
            //     <button class="control-btn next"><i class="fas fa-chevron-right"></i></button>
            //     </div>
            //     </div>
            // </div>
            // <div class="chart-container">
            //     <div class="y-axis">
            //     <span>50</span><span>40</span><span>30</span><span>20</span><span>10</span>
            //     </div>
            //     <div class="chart-bars">
            //     <div class="bar-group">
            //         <div class="bar-wrapper">
            //         <div class="bar-text">75%<br>8/10 Hrs</div>
            //         <div class="bar blue" style="height: 100%;"></div>
            //         <div class="bar red" style="height: 90%;"></div>
            //         </div>
            //         <div class="bar-label">7/1/24 - 12/31/24</div>
            //     </div>
            //     <div class="bar-group">
            //         <div class="bar-wrapper">
            //         <div class="bar-text">75%<br>7/10 Hrs</div>
            //         <div class="bar blue" style="height: 80%;"></div>
            //         <div class="bar red" style="height: 100%;"></div>
            //         </div>
            //         <div class="bar-label">7/1/24 - 12/31/24</div>
            //     </div>
            //     <div class="bar-group">
            //         <div class="bar-wrapper">
            //         <div class="bar-text">75%<br>7/10 Hrs</div>
            //         <div class="bar blue" style="height: 81%;"></div>
            //         <div class="bar red" style="height: 64%;"></div>
            //         </div>
            //         <div class="bar-label">7/1/24 - 12/31/24</div>
            //     </div>
            //     <div class="bar-group">
            //         <div class="bar-wrapper">
            //         <div class="bar-text">75%<br>7/10 Hrs</div>
            //         <div class="bar blue" style="height: 47%;"></div>
            //         <div class="bar red" style="height: 30%;"></div>
            //         </div>
            //         <div class="bar-label">7/1/24 - 12/31/24</div>
            //     </div>
            //     <div class="bar-group">
            //         <div class="bar-wrapper">
            //         <div class="bar-text">75%<br>7/10 Hrs</div>
            //         <div class="bar blue" style="height: 89%;"></div>
            //         <div class="bar red" style="height: 80%;"></div>
            //         </div>
            //         <div class="bar-label">7/1/24 - 12/31/24</div>
            //     </div>
            //     </div>
            // </div>
            // </section>
            // ';
         ?>