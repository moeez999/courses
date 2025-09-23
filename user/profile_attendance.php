 
    <section class="profile-card">
        <div class="card-header">
            
            <div class="attendance-legend">
                <h2 id="chart-title">Overall Attendance</h2>
                <div class="legend-item">
                    <span class="color-dot main-class"></span>
                    <span id="main-class-label">Main Class</span>
                    <div class="checkbox-wrapper checked">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="color-dot practice-class"></span>
                    <span id="practice-class-label">Practice Class</span>
                    <div class="checkbox-wrapper checked">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <div class="controls-container">
                    <div class="attendance-controls">
                        <button class="control-btn prev"><i class="fas fa-chevron-left"></i></button>
                        <div class="select-set" onclick="toggleDropdown()">
                            <span id="time-period-label">Last 5 Weeks</span>
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
            <div class="chart-bars" id="chart-bars-container"></div>
        </div>
    </section>

    <!-- Dropdown Menu -->
    <div class="dropdown-container" id="dropdownMenu">
        <div class="dropdown-header">
            <span>Topic</span>
            <span style="cursor:pointer;" onclick="toggleDropdown()">✕</span>
        </div>

        <!-- Topic Section -->
         <?php
     
        // Get all cohort IDs the user belongs to
        $current_cohorts = cohort_get_user_cohorts($user->id);
        $cohort_ids = array_column($current_cohorts, 'id'); // Extract just the IDs

        if (empty($cohort_ids)) {
            echo '<div class="error">User is not in any cohorts</div>';
        } else {
            // Convert cohort IDs to comma-separated string for SQL IN clause
            list($cohort_sql, $params) = $DB->get_in_or_equal($cohort_ids, SQL_PARAMS_NAMED, 'cohort');
            
            // Get courses available to ANY of these cohorts
            $sql_courses = "
                SELECT DISTINCT c.id, c.fullname, c.shortname,c.category
                FROM {course} c
                JOIN {context} ctx ON ctx.instanceid = c.id AND ctx.contextlevel = 50
                WHERE c.id <> 2
                AND EXISTS (
                    SELECT 1
                    FROM {role_assignments} ra
                    JOIN {cohort_members} cm ON ra.userid = cm.userid
                    WHERE cm.cohortid {$cohort_sql}
                    AND ra.contextid = ctx.id
                )
                ORDER BY c.fullname
            ";

            $courses = $DB->get_records_sql($sql_courses, $params);
            
            if (empty($courses)) {
                //echo '<div class="error">No courses available for your cohorts</div>';
            } else {
                $has_content = false;
                
                foreach ($courses as $course) {
                    // Get all visible sections
                    $sql = "
                          SELECT cs1.id, cs1.name, cs1.section, cs1.sequence
                          FROM {course_sections} cs1
                          JOIN {course_sections} cs2 
                              ON cs1.course = cs2.course
                              AND cs2.section = cs1.section + 1  -- Ensure the next section exists
                          WHERE cs1.sequence = ''  -- Current section has no sequence
                          AND cs2.sequence != ''   -- The next section has a sequence
                          AND cs1.course = :courseid  -- Filter by the given course ID
                          AND cs1.visible = 1  -- Only visible sections
                          ORDER BY cs1.section;
                      ";

                      // Execute the query using the course ID
                      $sections = $DB->get_records_sql($sql, ['courseid' => $course->id]);

                    // $sections = $DB->get_records('course_sections', 
                    //     ['course' => $course->id, 'visible' => 1], 
                    //     'section ASC'
                    // );
                    $category = $DB->get_record('course_categories', ['id' => $course->category]);
                    $category_name = $category->name;
                    echo '<div class="dropdown-section">';    
                    echo '<div class="expandable" onclick="toggleSublist(\'section-'.$course->id.'\', this)">';
                    echo $category_name." - ".htmlspecialchars($course->fullname).' <span class="arrow">▶</span>';
                    echo '</div>';
                    
                    if (!empty($sections)) {
                        echo '<ul class="dropdown-sublist" id="section-'.$course->id.'">';
                        foreach ($sections as $section) {
                            // Get visible modules
                            // $modules = $DB->get_records('course_modules', 
                            //     ['section' => $section->id, 'visible' => 1]
                            // );
                            
                            // if (!empty($modules)) {
                            //     $has_content = true;
                                $sectionName = format_string($section->name);
                                if (empty($sectionName)) {
                                    $sectionName = "Section ".$section->section;
                                }
                                
                                echo '<li onclick="selectTopic(\''.format_string($sectionName).'\','.$section->id.')">';
                                echo format_string($sectionName);
                                echo '</li>';
                                // echo '<div class="expandable" onclick="toggleSublist(\'section-'.$section->id.'\', this)">';
                                // echo htmlspecialchars($sectionName).' <span class="arrow">▶</span>';
                                // echo '</div>';
                                
                                // echo '<ul class="dropdown-sublist" id="section-'.$section->id.'">';
                                // foreach ($modules as $module) {
                                //     $moduleInfo = $DB->get_record('modules', ['id' => $module->module]);
                                //     if ($moduleInfo) {
                                //         $moduleInstance = $DB->get_record($moduleInfo->name, ['id' => $module->instance]);
                                //         if ($moduleInstance) {
                                //             echo '<li onclick="selectTopic(\''.format_string($moduleInstance->name).'\')">';
                                //             echo format_string($moduleInstance->name);
                                //             echo '</li>';
                                //         }
                                //     }
                                // }
                                
                               
                            // }
                        }
                        echo '</ul>';
                    }
                    echo '</div>';
                }
                
                if (!$has_content) {
                    //echo '<div class="error">No visible content found in any courses</div>';
                }
            }
        }
    ?>
         
        <!-- Sets of Time -->
        <div class="dropdown-section">
            <div class="dropdown-title">Time Period</div>
            <ul>
                <li class="dropdown-item" onclick="selectTimePeriod('day')">Day</li>
                <li class="dropdown-item" onclick="selectTimePeriod('week')">Week</li>
                <li class="dropdown-item" onclick="selectTimePeriod('month')">Month</li>
                <li class="dropdown-item" onclick="selectTimePeriod('3months')">Past 3 months</li>
                <li class="dropdown-item" onclick="selectTimePeriod('6months')">Past 6 months</li>
            </ul>
        </div>

        <!-- Date Inputs -->
        <div class="dropdown-section">
            <div class="dropdown-title">Custom Date Range</div>
            <div class="date-input" onclick="openCalendar('from')">
                From: <span id="fromDate">Select date</span> 📅
            </div>
            <div class="date-input" onclick="openCalendar('to')">
                To: <span id="toDate">Select date</span> 📅
            </div>
        </div>
    </div>

    <!-- Calendar Popup -->
    <div class="calendar-popup" id="calendarPopup" onclick="event.stopPropagation()">
        <div class="calendar-header">
            <button onclick="prevMonth()">&#8592;</button>
            <span id="calendarMonth">January 2025</span>
            <button onclick="nextMonth()">&#8594;</button>
        </div>
        <div class="calendar-grid" id="calendarDays"></div>
        <button class="done-btn" onclick="closeCalendar()">Done</button>
    </div>

    <script>

        
        // Configuration
        const config = {
            initialWeeks: 5,
            maxBarWidth: 60,
            minBarWidth: 30,
            mobileBreakpoint: 768,
            timePeriods: {
                'day': 'Daily',
                'week': 'Weekly',
                'month': 'Monthly',
                '3months': 'Past 3 Months',
                '6months': 'Past 6 Months'
            },
            timePeriodValues: {
                'day': 300,    // Last 30 days
                'week': 15,   // Last 12 weeks
                'month': 5,   // Last 6 months
                '3months': 3, // Last 3 months
                '6months': 6  // Last 6 months
            },
            apiEndpoint: 'attendance_api.php'
        };

        // Chart state
        let chartState = {
            currentPeriod: 'week',
            currentPage: 0,
            totalPages: 0,
            attendanceData: [],
            showMainClass: true,
            showPracticeClass: true,
            dateRange: {
                from: null,
                to: null
            },
            currentTopic: null
        };

        // DOM Elements
        const chartBarsContainer = document.getElementById('chart-bars-container');
        const prevBtn = document.querySelector('.control-btn.prev');
        const nextBtn = document.querySelector('.control-btn.next');
        const timePeriodLabel = document.getElementById('time-period-label');
        const mainClassCheckbox = document.querySelectorAll('.checkbox-wrapper')[0];
        const practiceClassCheckbox = document.querySelectorAll('.checkbox-wrapper')[1];
        const fromDateElement = document.getElementById('fromDate');
        const toDateElement = document.getElementById('toDate');

        // Initialize the chart
        async function initChart() {
            try {
                // Set default to last 5 weeks
                timePeriodLabel.textContent = 'Last 5 Weeks';
                
                // Fetch initial data
                await loadData();
                
                // Set up event listeners
                setupEventListeners();
            } catch (error) {
                console.error('Error initializing chart:', error);
                showError('Error loading attendance data. Please try again later.');
            }
        }

        // Load data based on current period or date range
        async function loadData() {
            try {
                // Get user email from your authentication system
                // In a real app, this would come from your auth context
                const userEmail = getCurrentUserEmail(); // Implement this function
                
                let apiParams = {
                    email: userEmail
                };
                
                if (chartState.dateRange.from && chartState.dateRange.to) {
                    // Fetch by date range
                    apiParams.action = 'get_attendance_by_date';
                    apiParams.from = formatDateForAPI(chartState.dateRange.from);
                    apiParams.to = formatDateForAPI(chartState.dateRange.to);
                } else {
                    // Fetch by time period
                    apiParams.action = 'get_attendance_data';
                    apiParams.weeks = config.timePeriodValues[chartState.currentPeriod] || 5;
                    apiParams.period = chartState.currentPeriod;
                }
                
                // Add topic filter if selected
                if (chartState.currentTopic) {
                    apiParams.topic = chartState.currentTopic;
                }
                
                // Call the API
                const data = await callAPI(apiParams);
                
                chartState.attendanceData = data;
                chartState.totalPages = Math.ceil(data.length / 5); // Show 5 items per "page"
                chartState.currentPage = 0;
                
                renderChart();
            } catch (error) {
                console.error('Error loading data:', error);
                throw error;
            }
        }

        async function loadDataTopic() {
            try {
                // Get user email from your authentication system
                // In a real app, this would come from your auth context
                const userEmail = getCurrentUserEmail(); // Implement this function
                
                let apiParams = {
                    email: userEmail
                };
                
                
                // Fetch by time period
                apiParams.action = 'get_attendance_topic';
                apiParams.weeks = 5;
                apiParams.period = 'day';
                apiParams.topic = chartState.currentTopic;
                
                 
                 
                // Call the API
                const data = await callAPI(apiParams);
                
                chartState.attendanceData = data;
                chartState.totalPages = Math.ceil(data.length / 5); // Show 5 items per "page"
                chartState.currentPage = 0;
                
                renderChart();
            } catch (error) {
                console.error('Error loading data:', error);
                throw error;
            }
        }

        // Call the API endpoint
        async function callAPI(params) {
            try {
                const response = await fetch(config.apiEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(params)
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (result.status !== 'success') {
                    throw new Error(result.message || 'Error fetching data from API');
                }
                
                return result.data;
            } catch (error) {
                console.error('API call failed:', error);
                throw error;
            }
        }

        // Helper function to get current user email
        function getCurrentUserEmail() { 
            return '<?php echo $user->email; ?>';
             
        }

        // Render the chart with real data
        function renderChart() {
            chartBarsContainer.innerHTML = '';
            
            if (!chartState.attendanceData || chartState.attendanceData.length === 0) {
                chartBarsContainer.innerHTML = '<div class="no-data">No attendance data available</div>';
                return;
            }
            
            // Calculate visible data range
            const itemsPerPage = 5; // Always show 5 items per "page"
            const startIndex = chartState.currentPage * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, chartState.attendanceData.length);
            //const visibleData = chartState.attendanceData.slice(startIndex, endIndex);
            const visibleData = chartState.attendanceData.slice(startIndex, endIndex).reverse();
            // Calculate bar width based on number of bars and container width
            const containerWidth = chartBarsContainer.clientWidth;
            const barCount = visibleData.length;
            let barWidth = Math.min(config.maxBarWidth, (containerWidth - 20) / barCount);
            barWidth = Math.max(barWidth, config.minBarWidth);
            
            // Create bars for each period
            visibleData.forEach((periodData, index) => {
                const { period, main, practice , period_label,expected_type} = periodData;
                
                // Format label based on time period
                //let label;
                 
                // In the renderChart function, replace the label formatting logic with:
            let label;

            if (chartState.currentPeriod === 'day') {
                // For daily view - period is in Y-m-d format (e.g., "2023-05-15")
                const [year, month, day] = period.split('-');
                label = period_label;//`${day}/${month}/${year}`; // Display as "15/05"
            } else if (chartState.currentPeriod === 'week') {
                // For weekly view - period is in W-Y format (e.g., "20-2023")
                const [week, year] = period.split('-');
                const date = new Date();
                date.setFullYear(parseInt(year), 0, 1);
                const dayOffset = date.getDay() === 0 ? 1 : (8 - date.getDay());
                date.setDate((parseInt(week) - 1) * 7 + dayOffset);
                
                const startDate = new Date(date);
                const endDate = new Date(date);
                endDate.setDate(date.getDate() + 6);
                
                label = `${startDate.getDate()}/${startDate.getMonth() + 1}-${endDate.getDate()}/${endDate.getMonth() + 1}`;
            } else if (chartState.currentPeriod === 'month' || 
                    chartState.currentPeriod === '3months' || 
                    chartState.currentPeriod === '6months') {
                // For monthly view - period is in Y-m format (e.g., "2023-05")
                const [month,year ] = period.split('-');
                const date = new Date(year, month-1, 1);
                label = date.toLocaleString('default', { month: 'short' }) + ' ' + year; // "May 2023"
            } else {
                // Fallback - use the period as-is
                label = period;
            }
                
                

                // Create bar group
                const barGroup = document.createElement('div');
                barGroup.className = 'bar-group';
                barGroup.style.width = `${barWidth}px`;
                
                // Create bar wrapper
                const barWrapper = document.createElement('div');
                barWrapper.className = 'bar-wrapper';

                if (chartState.currentPeriod === 'day') {
                   
                    // For day view, show only the bar matching the expected_type
                    const expectedType = expected_type; // 'main' or 'practice'
                    if(expected_type === 'main'){
                        if (chartState.showMainClass) {
                            const mainHeightPercent = main.attendance;
                            
                            const mainText = document.createElement('div');
                            mainText.className = 'fullbar-text';
                            const barTotalHeight = 364; // Total height of the bar container in pixels
                            // Calculate top position (from the top of the container)
                            const textTopPosition = (barTotalHeight * (100 - mainHeightPercent) / 100)-40;
                            mainText.style.top = `${textTopPosition}px`;
                            if (chartState.currentPeriod === 'day') {
                                mainText.textContent = `${Math.round(main.attendance)} min`;
                            } else {
                                mainText.textContent = `${Math.round(main.attendance)}% \n ${main.hours}Hrs`;
                            }
                            
                            const mainBar = document.createElement('div');
                            mainBar.className = 'fullbar blue';
                            mainBar.style.height = `${mainHeightPercent}%`;
                            
                            barWrapper.appendChild(mainText);
                            barWrapper.appendChild(mainBar);
                        }
                    
                    } else {
                        if (chartState.showPracticeClass) {
                            const practiceHeightPercent = practice.attendance;
                            
                            const practiceText = document.createElement('div');
                            practiceText.className = 'fullbar-text';
                            const barTotalHeight = 364; // Total height of the bar container in pixels
                            // Calculate top position (from the top of the container)
                            // Calculate top position (from the top of the container)
                            const textTopPosition = (barTotalHeight * (100 - practiceHeightPercent) / 100)-40;
                            practiceText.style.top = `${textTopPosition}px`;
                            if (chartState.currentPeriod === 'day') {
                                practiceText.textContent = `${Math.round(practice.attendance)} min`;
                            } else {
                                practiceText.textContent = `${Math.round(practice.attendance)}% \n ${practice.hours}Hrs`;
                            }
                            const practiceBar = document.createElement('div');
                            practiceBar.className = 'fullbar red';
                            practiceBar.style.height = `${practiceHeightPercent}%`;
                            
                            barWrapper.appendChild(practiceText);
                            barWrapper.appendChild(practiceBar);
                        }

                    } 
                } else {
                
                    // Create main class bar if enabled
                    if (chartState.showMainClass) {
                        const mainHeightPercent = main.attendance;
                        
                        const mainText = document.createElement('div');
                        mainText.className = 'bar-text';
                        const barTotalHeight = 364; // Total height of the bar container in pixels
                        // Calculate top position (from the top of the container)
                        const textTopPosition = (barTotalHeight * (100 - mainHeightPercent) / 100)-40;
                        mainText.style.top = `${textTopPosition}px`;
                        if (chartState.currentPeriod === 'day') {
                            mainText.textContent = `${Math.round(main.attendance)} min`;
                        } else {
                            mainText.textContent = `${Math.round(main.attendance)}% \n ${main.hours}Hrs`;
                        }
                        
                        const mainBar = document.createElement('div');
                        mainBar.className = 'bar blue';
                        mainBar.style.height = `${mainHeightPercent}%`;
                        
                        barWrapper.appendChild(mainText);
                        barWrapper.appendChild(mainBar);
                    }
                    
                    // Create practice class bar if enabled
                    if (chartState.showPracticeClass) {
                        const practiceHeightPercent = practice.attendance;
                        
                        const practiceText = document.createElement('div');
                        practiceText.className = 'bar-text2';
                        const barTotalHeight = 364; // Total height of the bar container in pixels
                        // Calculate top position (from the top of the container)
                        // Calculate top position (from the top of the container)
                        const textTopPosition = (barTotalHeight * (100 - practiceHeightPercent) / 100)-40;
                        practiceText.style.top = `${textTopPosition}px`;
                        if (chartState.currentPeriod === 'day') {
                            practiceText.textContent = `${Math.round(practice.attendance)} min`;
                        } else {
                            practiceText.textContent = `${Math.round(practice.attendance)}% \n ${practice.hours}Hrs`;
                        }
                        const practiceBar = document.createElement('div');
                        practiceBar.className = 'bar red';
                        practiceBar.style.height = `${practiceHeightPercent}%`;
                        
                        barWrapper.appendChild(practiceText);
                        barWrapper.appendChild(practiceBar);
                    }
                }
                
                // Create label
                const barLabel = document.createElement('div');
                barLabel.className = 'bar-label';
                barLabel.textContent = label;
                
                // Assemble the bar group
                barGroup.appendChild(barWrapper);
                barGroup.appendChild(barLabel);
                
                // Add to container
                chartBarsContainer.appendChild(barGroup);
            });
            
            updateNavigationControls();
            updateTimePeriodLabel();
        }

        // Update navigation controls state
        function updateNavigationControls() {
            nextBtn.disabled = chartState.currentPage === 0;
            prevBtn.disabled = (chartState.currentPage + 1) * 5 >= chartState.attendanceData.length;
        }

        // Update time period label
        function updateTimePeriodLabel() {
            if (chartState.dateRange.from && chartState.dateRange.to) {
                // Custom date range selected
                const fromStr = formatDate(chartState.dateRange.from);
                const toStr = formatDate(chartState.dateRange.to);
                timePeriodLabel.textContent = `${fromStr} - ${toStr}`;
            } else {
                // Standard time period selected
                const periodName = config.timePeriods[chartState.currentPeriod] || 'Week';
                const itemsPerPage = 5;
                const totalItems = chartState.attendanceData.length;
                const startItem = chartState.currentPage * itemsPerPage + 1;
                const endItem = Math.min((chartState.currentPage + 1) * itemsPerPage, totalItems);
                
                timePeriodLabel.textContent = `${periodName} ${startItem}-${endItem}`;
            }
        }

        // Format date for display
        function formatDate(date) {
            if (!date) return '';
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Format date for API
        function formatDateForAPI(date) {
            if (!date) return '';
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Set up event listeners
        function setupEventListeners() {
            // Navigation controls
            nextBtn.addEventListener('click', () => {
                if (chartState.currentPage > 0) {
                    chartState.currentPage--;
                    renderChart();
                }
            });
            
            prevBtn.addEventListener('click', () => {
                const itemsPerPage = 5;
                if ((chartState.currentPage + 1) * itemsPerPage < chartState.attendanceData.length) {
                    chartState.currentPage++;
                    renderChart();
                }
            });
            
            // Toggle bar visibility with proper checked state
            // mainClassCheckbox.addEventListener('click', () => {
            //     const isChecked = mainClassCheckbox.classList.contains('checked');
            //     mainClassCheckbox.classList.toggle('checked', !isChecked);
            //     chartState.showMainClass = !isChecked;
            //     renderChart();
            // });

            // practiceClassCheckbox.addEventListener('click', () => {
            //     const isChecked = practiceClassCheckbox.classList.contains('checked');
            //     practiceClassCheckbox.classList.toggle('checked', !isChecked);
            //     chartState.showPracticeClass = !isChecked;
            //     renderChart();
            // });


            // Toggle main class visibility
            mainClassCheckbox.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent event bubbling
                const isChecked = mainClassCheckbox.classList.contains('checked');
                
                // Toggle checked state
                mainClassCheckbox.classList.toggle('checked', !isChecked);
                
                // Toggle check icon
                const icon = mainClassCheckbox.querySelector('i');
                if (!isChecked) {
                    icon.classList.add('fa-check');
                } else {
                    icon.classList.remove('fa-check');
                }
                
                // Update chart state and render
                chartState.showMainClass = !isChecked;
                renderChart();
            });

            // Toggle practice class visibility
            practiceClassCheckbox.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent event bubbling
                const isChecked = practiceClassCheckbox.classList.contains('checked');
                
                // Toggle checked state
                practiceClassCheckbox.classList.toggle('checked', !isChecked);
                
                // Toggle check icon
                const icon = practiceClassCheckbox.querySelector('i');
                if (!isChecked) {
                    icon.classList.add('fa-check');
                } else {
                    icon.classList.remove('fa-check');
                }
                
                // Update chart state and render
                chartState.showPracticeClass = !isChecked;
                renderChart();
            });
            
            // Window resize for responsiveness
            window.addEventListener('resize', debounce(() => {
                renderChart();
            }, 200));
        }

        // Helper function to debounce rapid events
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    func.apply(context, args);
                }, wait);
            };
        }

        // Show error message
        function showError(message) {
            chartBarsContainer.innerHTML = `<div class="error-message">${message}</div>`;
        }

        // Dropdown functions
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
                arrow.textContent = '▶';
            } else {
                sublist.style.display = 'block';
                arrow.textContent = '▼';
            }
        }

        function selectTimePeriod(period) {
            chartState.currentPeriod = period;
            chartState.dateRange.from = null;
            chartState.dateRange.to = null;
            fromDateElement.textContent = 'Select date';
            toDateElement.textContent = 'Select date';
            
            // Update the label
            timePeriodLabel.textContent = config.timePeriods[period] || period;
            
            // Load data for the selected period
            loadData();
            
            // Close dropdown
            toggleDropdown();
        }

        function selectTopic(topic,id) {
            chartState.currentTopic = id;
            timePeriodLabel.textContent = topic;
            loadDataTopic();
            toggleDropdown();
        }

        function openCalendar(type) {
            selectedInput = type;
            document.getElementById('calendarPopup').style.display = 'block';
            renderCalendar();
        }

        function closeCalendar() {
            document.getElementById('calendarPopup').style.display = 'none';
            if (chartState.dateRange.from && chartState.dateRange.to) {
                // Update the time period label
                const fromStr = formatDate(chartState.dateRange.from);
                const toStr = formatDate(chartState.dateRange.to);
                timePeriodLabel.textContent = `${fromStr} - ${toStr}`;
                chartState.currentPeriod = 'day';
                toggleDropdown();
                // Load the data
                loadData();

            }
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
                
                // Highlight if this date is selected
                const date = new Date(currentYear, currentMonth, day);
                if (selectedInput === 'from' && chartState.dateRange.from && 
                    date.toDateString() === chartState.dateRange.from.toDateString()) {
                    d.style.backgroundColor = '#3498db';
                    d.style.color = 'white';
                } else if (selectedInput === 'to' && chartState.dateRange.to && 
                    date.toDateString() === chartState.dateRange.to.toDateString()) {
                    d.style.backgroundColor = '#3498db';
                    d.style.color = 'white';
                }
                
                d.onclick = () => selectDate(day);
                grid.appendChild(d);
            }
        }

        function selectDate(day) {
            const selectedDate = new Date(currentYear, currentMonth, day);
            
            //const selectedDate = new Date(currentYear, currentMonth, day);
    
            if (selectedInput === 'from') {
                chartState.dateRange.from = selectedDate;
                fromDateElement.textContent = formatDate(selectedDate);
                
                // If "to" date is before "from" date, reset "to" date
                if (chartState.dateRange.to && chartState.dateRange.to < selectedDate) {
                    chartState.dateRange.to = null;
                    toDateElement.textContent = 'Select date';
                }
            } else {
                chartState.dateRange.to = selectedDate;
                toDateElement.textContent = formatDate(selectedDate);
                
                // If "from" date is after "to" date, reset "from" date
                if (chartState.dateRange.from && chartState.dateRange.from > selectedDate) {
                    chartState.dateRange.from = null;
                    fromDateElement.textContent = 'Select date';
                }
            }
            
            // If both dates are selected, load data
            if (chartState.dateRange.from && chartState.dateRange.to) {
                //loadData();
            }
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

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            const dropdown = document.getElementById('dropdownMenu');
            const selectSet = document.querySelector('.select-set');
            const calendarPopup = document.getElementById('calendarPopup');
            
            // Don't close if clicking on these elements
            if (dropdown.contains(event.target) || 
                selectSet.contains(event.target) || 
                (calendarPopup && calendarPopup.contains(event.target))) {
                return;
            }
            
            if (dropdownOpen) {
                toggleDropdown();
            }
        });

        // Initialize the chart when DOM is loaded
        document.addEventListener('DOMContentLoaded', initChart);
    </script> 