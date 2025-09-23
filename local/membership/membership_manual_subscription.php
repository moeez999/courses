
<!-- <button id="openSubscriptionModalBtn">Create Subscription</button> -->
<div class="modal-backdrop" id="subscriptionModalBackdrop">
  <div class="subscription-modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-header">
      <h2 id="modalTitle">Add Manual Subscription</h2>
      <button class="modal-close" id="closeSubscriptionModalBtn" aria-label="Close">&times;</button>
    </div>
    <div class="modal-content">
      <form class="subscription-form" autocomplete="off">
        <div class="form-group full-width">
          <label class="subscription-label">User Type</label>
          <div class="custom-user-dropdown-wrapper">
            <div class="custom-user-dropdown" id="customUserDropdown">
              <span id="customUserSelected">New Student</span>
              <svg class="custom-user-arrow" width="18" height="18" viewBox="0 0 20 20">
                <path d="M5.8 8l4.2 4.2 4.2-4.2" stroke="currentColor" stroke-width="1.4" fill="none" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="custom-user-options" id="customUserOptions">
              <div class="custom-user-option" data-value="New Student">New Student</div>
              <div class="custom-user-option" data-value="Existing Student">Existing Student</div>
            </div>
            <div class="existing-student-input-wrapper" id="existingStudentInputWrapper" style="display: none;">
              <input type="text" class="existing-student-input" id="existingStudentInput" autocomplete="off" placeholder="Enter student name">
              <div class="student-list" id="studentList"></div>
            </div>
            <input type="hidden" id="userType" name="userType" value="New Student">
            <input type="hidden" id="selectedStudentId" name="selectedStudentId" value="">
          </div>
        </div>
        <div class="form-group">
          <label for="firstName" class="subscription-label">First name</label>
          <input class="form-input" id="firstName" type="text" placeholder="First name">
        </div>
        <div class="form-group">
          <label for="lastName" class="subscription-label">Last name</label>
          <input class="form-input" id="lastName" type="text" placeholder="Last name">
        </div>
        <div class="form-group">
          <label for="email" class="subscription-label">Email</label>
          <input class="form-input" id="email" type="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label for="contactNumber" class="subscription-label">Contact number</label>
          <input class="form-input" id="contactNumber" type="tel" placeholder="Contact number">
        </div>
        <div class="form-group">
          <label for="password" class="subscription-label">Password</label>
          <input class="form-input" id="password" type="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="paymentMethod" class="subscription-label">Payment method</label>
          <select class="form-select" id="paymentMethod">
            <option value="">Payment method</option>
            <option>zelle</option>
            <option>western union</option>
            <option>Cash</option>
            <option>Other</option>
          </select>
        </div>
        <div class="form-group">
          <label class="subscription-label">Interval</label>
          <div class="interval-row">
            <button type="button" class="interval-btn" id="intervalMinus">-</button>
            <input class="form-input" id="intervalValue" type="number" min="1" value="1" style="width: 44px; text-align:center; padding:0;">
            <button type="button" class="interval-btn" id="intervalPlus">+</button>
            <select class="form-select" id="intervalType" style="flex:1; min-width:80px;">
              <option>Week</option>
              <option selected>Month</option>
              <option>Year</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="price" class="subscription-label">Price</label>
          <input class="form-input" id="price" type="number" min="0" placeholder="Price">
        </div>
         <?php

        global $DB;

// Get all visible cohorts (you can remove "visible = 1" if not needed)
$cohorts = $DB->get_records('cohort', ['visible' => 1], 'name ASC');
?>
        <div class="form-group">
    <label for="cohort" class="subscription-label">Cohort</label>
    <select class="form-select" id="cohort" name="cohort">
        <option value="">Select Cohort</option>
        <?php foreach ($cohorts as $cohort): ?>
            <option value="<?php echo s($cohort->idnumber); ?>">
                <?php echo format_string($cohort->name) . ' (' . $cohort->idnumber . ')'; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
        <div class="form-group">
  <label for="subscriberId" class="subscription-label">Subscriber ID</label>
  <input class="form-input" id="subscriberId" type="text" placeholder="Subscriber ID" readonly>
</div>
        <div class="form-group">
          <label for="paymentReference" class="subscription-label">Payment Reference</label>
          <input class="form-input" id="paymentReference" type="text" placeholder="Payment Reference">
        </div>
        <div class="form-group">
          <label for="customStatus" class="subscription-label">Status</label>
          <div class="custom-status-dropdown-wrapper">
            <div class="custom-status-dropdown" tabindex="0" id="customStatusDropdown">
              <span class="custom-status-placeholder" id="customStatusPlaceholder">Status</span>
              <span class="custom-status-selected" id="customStatusSelected" style="display:none;">
                <span class="custom-status-dot status-dot-active" id="customStatusDot"></span>
                <span id="customStatusText">Active</span>
              </span>
              <svg class="custom-status-arrow" viewBox="0 0 20 20">
                <path d="M5.8 8l4.2 4.2 4.2-4.2" stroke="currentColor" stroke-width="1.4" fill="none" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="custom-status-options" id="customStatusOptions">
              <div class="custom-status-option status-bg-active" data-value="Active">
                <span class="custom-status-dot status-dot-active"></span>
                Active
              </div>
              <div class="custom-status-option status-bg-inactive" data-value="Inactive">
                <span class="custom-status-dot status-dot-inactive"></span>
                Inactive
              </div>
              <div class="custom-status-option status-bg-paused" data-value="Paused">
                <span class="custom-status-dot status-dot-paused"></span>
                Paused
              </div>
            </div>
            <input type="hidden" id="customStatus" name="customStatus" value="">
          </div>
        </div>
        <div class="form-group">
          <label for="startDate" class="subscription-label">Start date</label>
          <div class="date-input-wrapper">
            <input type="text" class="date-input" id="startDate" placeholder="07/01/24" readonly>
            <svg class="date-input-icon" viewBox="0 0 24 24">
              <rect x="3" y="5" width="18" height="16" rx="4" fill="none" stroke="#757575" stroke-width="1.5"/>
              <rect x="7" y="9" width="10" height="4" rx="1" fill="none" stroke="#757575" stroke-width="1.2"/>
              <rect x="7.5" y="2.8" width="2" height="4.4" rx="1" fill="#757575"/>
              <rect x="14.5" y="2.8" width="2" height="4.4" rx="1" fill="#757575"/>
            </svg>
          </div>
        </div>
        <div class="form-group">
          <label for="endDate" class="subscription-label">End date</label>
          <div class="date-input-wrapper">
            <input type="text" class="date-input" id="endDate" placeholder="12/31/24" readonly>
            <svg class="date-input-icon" viewBox="0 0 24 24">
              <rect x="3" y="5" width="18" height="16" rx="4" fill="none" stroke="#757575" stroke-width="1.5"/>
              <rect x="7" y="9" width="10" height="4" rx="1" fill="none" stroke="#757575" stroke-width="1.2"/>
              <rect x="7.5" y="2.8" width="2" height="4.4" rx="1" fill="#757575"/>
              <rect x="14.5" y="2.8" width="2" height="4.4" rx="1" fill="#757575"/>
            </svg>
          </div>
        </div>
        <div class="form-group">
        <label for="referralCode" class="subscription-label">Referral Code</label>
        <input class="form-input" id="referralCode" type="text" placeholder="Enter referral code (optional)">
      </div>
        <div class="form-group full-width">
          <label for="notes" class="subscription-label">Notes</label>
          <textarea id="notes" class="notes-textarea" placeholder="Notes"></textarea>
        </div>
        
        


      </form>
    </div>

            <div class="form-group full-width">
          <button type="submit" class="subscription-submit-btn">Create Subscription</button>
        </div>


  </div>
</div>
<div class="calendar-popover-backdrop" id="calendarPopoverBackdrop"></div>
<div class="calendar-popover" id="calendarPopover">
  <div class="calendar-header">
    <button class="calendar-nav-btn" id="calendarPrevMonthBtn">&#8592;</button>
    <span id="calendarMonthYear"></span>
    <button class="calendar-nav-btn" id="calendarNextMonthBtn">&#8594;</button>
  </div>
  <div class="calendar-divider"></div>
  <div class="calendar-grid" id="calendarWeekdays"></div>
  <div class="calendar-grid" id="calendarDays"></div>
  <button class="calendar-done-btn" id="calendarDoneBtn">Done</button>
</div>


<script>

  document.getElementById('paymentMethod').addEventListener('change', function() {
  const method = this.value;
  if (!method) return;

  const startDate = document.getElementById('startDate')?.value.trim();
  const endDate = document.getElementById('endDate')?.value.trim();

  if (!startDate || !endDate) {
    alert('⚠️ Please select both Start Date and End Date first.');
    this.value = ''; // Reset the selection
    return;
  }

fetch('get_latest_subscriber_id.php?method=' + encodeURIComponent(method) + '&startdate=' + encodeURIComponent(startDate))
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById('subscriberId').value = data.subscriber_id;
      } else {
        console.warn('Failed to get subscriber ID:', data.error);
      }
    })
    .catch(err => console.error('Error fetching subscriber ID:', err));
});
        </script>



<script>
document.querySelector('.subscription-submit-btn').addEventListener('click', function(e) {
   e.preventDefault();

debugger;

// Get selected user type
const usertypee = document.getElementById('userType')?.value;

const formData = {
    usertype: usertypee,
    selecteduserid: document.getElementById('selectedStudentId')?.value || '',
    firstname: document.getElementById('firstName')?.value.trim(),
    lastname: document.getElementById('lastName')?.value.trim(),
    email: document.getElementById('email')?.value.trim(),
    contactnumber: document.getElementById('contactNumber')?.value.trim(),
    password: document.getElementById('password')?.value.trim(),
    paymentmethod: document.getElementById('paymentMethod')?.value,
    intervalvalue: parseInt(document.getElementById('intervalValue')?.value || 1),
    intervaltype: document.getElementById('intervalType')?.value,
    price: parseFloat(document.getElementById('price')?.value || 0),
    cohort: document.getElementById('cohort')?.value || '',
    subscriberid: document.getElementById('subscriberId')?.value || '',
    paymentref: document.getElementById('paymentReference')?.value || '',
    start_date: document.getElementById('startDate')?.value || '',
    end_date: document.getElementById('endDate')?.value || '',
    referralcode: document.getElementById('referralCode')?.value.trim() || ''
};

// Optional validation
if (usertypee === 'New Student') {
    if (!formData.firstname || !formData.lastname || !formData.email || !formData.password || !formData.contactnumber || !formData.paymentmethod || !formData.intervalvalue || !formData.intervaltype || !formData.price || !formData.cohort || !formData.subscriberid || !formData.paymentref) {
        alert("Please fill all required fields.");
        return;
    }
} else {
    if (!formData.firstname || !formData.lastname || !formData.email || !formData.paymentmethod || !formData.intervalvalue || !formData.intervaltype || !formData.price || !formData.cohort || !formData.subscriberid || !formData.paymentref) {
        alert("Please fill all required fields.");
        return;
    }
}

    fetch('create_user_and_assign.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Subscription created successfully!');
            // Optionally redirect or reset form here

             // Reset all individual fields by ID
            const idsToClear = [
                'selectedStudentId', 'firstName', 'lastName', 'email', 'contactNumber',
                'password', 'paymentMethod', 'intervalValue', 'intervalType',
                'price', 'cohort', 'subscriberId', 'paymentReference',
                'startDate', 'endDate', 'userType'
            ];

            idsToClear.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    } else {
                        el.value = '';
                    }
                }
            });
     
        } else {
            alert('❌ ' + (data.message || 'Something went wrong.'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Request failed.');
    });
});
</script>

<script>
// --- Student Dropdown & Search Logic (jQuery) ---

let students = [];

fetch('get_cohort_students.php')
  .then(res => res.json())
  .then(data => {
    students = data;
  });

const customUserDropdown = document.getElementById('customUserDropdown');
const customUserOptions = document.getElementById('customUserOptions');
const customUserSelected = document.getElementById('customUserSelected');
const existingStudentInputWrapper = document.getElementById('existingStudentInputWrapper');
const userTypeInput = document.getElementById('userType');
const selectedStudentIdInput = document.getElementById('selectedStudentId');
const existingStudentInput = document.getElementById('existingStudentInput');
const studentList = document.getElementById('studentList');

document.addEventListener('click', function(e) {
  // Hide dropdown and student list on outside click
  if (!customUserDropdown.contains(e.target) && !customUserOptions.contains(e.target) && !existingStudentInputWrapper.contains(e.target)) {
    customUserOptions.style.display = 'none';
    studentList.style.display = 'none';
  }
});

customUserDropdown.addEventListener('click', function(e) {
  customUserOptions.style.display = customUserOptions.style.display === 'block' ? 'none' : 'block';
});

Array.from(customUserOptions.children).forEach(function(option) {
  option.addEventListener('click', function(e) {
    const value = option.getAttribute('data-value');
    customUserSelected.textContent = value;
    userTypeInput.value = value;
    customUserOptions.style.display = 'none';
    if (value === 'Existing Student') {
      existingStudentInputWrapper.style.display = 'block';
      existingStudentInput.value = '';
      selectedStudentIdInput.value = '';
      studentList.style.display = 'none';
      existingStudentInput.focus();
    } else {
      existingStudentInputWrapper.style.display = 'none';
      studentList.style.display = 'none';
      existingStudentInput.value = '';
      selectedStudentIdInput.value = '';
    }
  });
});

// Filter and render student list
existingStudentInput.addEventListener('input', function() {
  renderStudentList(existingStudentInput.value);
});
existingStudentInput.addEventListener('focus', function() {
  renderStudentList(existingStudentInput.value);
});

function renderStudentList(filter = "") {
  let filtered = students.filter(s => s.name.toLowerCase().includes((filter||"").toLowerCase()));
  if (filtered.length === 0) {
    studentList.innerHTML = '<div style="padding:13px 16px;color:#999;">No students found</div>';
  } else {
    studentList.innerHTML = filtered.map(s =>
      `<div class="student-list-item" data-id="${s.id}" data-name="${s.name}">
        <img src="${s.avatar}" class="student-avatar" alt="${s.name}" />
        <span>${s.name}</span>
      </div>`
    ).join('');
  }
  studentList.style.display = 'block';
  Array.from(document.getElementsByClassName('student-list-item')).forEach(function(item) {
    item.onclick = function(e) {
      debugger
  const studentId = item.getAttribute('data-id');
  existingStudentInput.value = item.getAttribute('data-name');
  selectedStudentIdInput.value = studentId;
  studentList.style.display = 'none';
  customUserOptions.style.display = 'none';
  existingStudentInputWrapper.style.display = 'none';

  // Fetch user details
  fetch('get_user_details.php?userid=' + encodeURIComponent(studentId))
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const u = data.data;
        document.getElementById('firstName').value = u.firstname;
        document.getElementById('lastName').value = u.lastname;
        document.getElementById('email').value = u.email;
        document.getElementById('contactNumber').value = u.contactnumber;
        document.getElementById('password').value = ''; // Leave blank for existing
      } else {
        alert('⚠️ ' + data.error);
      }
    })
    .catch(err => console.error('Error fetching user details:', err));
};
  });
}

// --- Modal open/close, interval, status logic (jQuery) ---
// $('#openSubscriptionModalBtn').on('click', function() {
//   $('#subscriptionModalBackdrop').addClass('active');
//   $('body').css('overflow', 'hidden');
// });
$('#closeSubscriptionModalBtn, #subscriptionModalBackdrop').on('click', function(e) {
  if (e.target === this) {
    $('#subscriptionModalBackdrop').removeClass('active');
    $('body').css('overflow', '');
  }
});
$('.subscription-modal').on('click', function(e) { e.stopPropagation(); });
$('#intervalMinus').on('click', function() {
  let val = parseInt($('#intervalValue').val());
  if (val > 1) $('#intervalValue').val(val - 1);
});
$('#intervalPlus').on('click', function() {
  let val = parseInt($('#intervalValue').val());
  $('#intervalValue').val(val + 1);
});
$('#customStatusDropdown').on('click', function(e) {
  $('#customStatusOptions').toggle();
  $(this).toggleClass('active');
  e.stopPropagation();
});
$('.custom-status-option').on('click', function(e) {
  let value = $(this).data('value');
  let text = $(this).text().trim();
  let dotClass = $(this).find('.custom-status-dot').attr('class').replace('custom-status-dot', '').trim();
  $('#customStatus').val(value);
  $('#customStatusPlaceholder').hide();
  $('#customStatusSelected').show();
  $('#customStatusText').text(text);
  $('#customStatusDot').attr('class', 'custom-status-dot ' + dotClass);
  $('#customStatusOptions').hide();
  $('#customStatusDropdown').removeClass('active');
  e.stopPropagation();
});
$(document).on('click', function() {
  $('#customStatusOptions').hide();
  $('#customStatusDropdown').removeClass('active');
});
$('#customStatusOptions').on('click', function(e) { e.stopPropagation(); });

// --- VANILLA JS CALENDAR CODE (no jQuery used below!) ---
let calendarSelection = { start: null, end: null };
let calendarTargetInput = null;
let calendarType = null;
let calendarMonth = null, calendarYear = null;

// Format MM/DD/YY
function formatDate(date) {
  if (!date) return '';
  let m = date.getMonth() + 1;
  let d = date.getDate();
  let y = date.getFullYear();
  return (m < 10 ? '0' + m : m) + '/' + (d < 10 ? '0' + d : d) + '/' + y.toString().slice(-2);
}

// Open calendar
function openCalendarVanilla(targetInput, type) {
  calendarTargetInput = targetInput;
  calendarType = type;
  // Use existing date if any
  let value = targetInput.value;
  let today = new Date();
  let selectedDate = null;
  if (calendarSelection[type] instanceof Date) {
    selectedDate = new Date(calendarSelection[type].getTime());
  } else if (value && /^\d{2}\/\d{2}\/\d{2,4}$/.test(value)) {
    let parts = value.split('/');
    selectedDate = new Date(parts[2].length === 2 ? '20'+parts[2] : parts[2], parseInt(parts[0])-1, parts[1]);
  }
  calendarMonth = selectedDate ? selectedDate.getMonth() : today.getMonth();
  calendarYear = selectedDate ? selectedDate.getFullYear() : today.getFullYear();
  calendarSelection[type] = selectedDate;
  renderCalendarVanilla();

  // Position popover
  const popover = document.getElementById('calendarPopover');
  const backdrop = document.getElementById('calendarPopoverBackdrop');
  const rect = targetInput.getBoundingClientRect();
  let top = rect.bottom + window.scrollY + 4;
  let left = rect.left + window.scrollX;
  popover.style.top = top + 'px';
  popover.style.left = left + 'px';
  popover.classList.add('show');
  backdrop.classList.add('show');
}

// Render calendar
function renderCalendarVanilla() {
  const type = calendarType;
  const selectedDate = calendarSelection[type];
  const weekdayLabels = ['Mo','Tu','We','Th','Fr','Sa','Su'];
  const weekdaysDiv = document.getElementById('calendarWeekdays');
  weekdaysDiv.innerHTML = '';
  for (let i = 0; i < 7; ++i) {
    const div = document.createElement('div');
    div.className = 'calendar-weekday';
    div.textContent = weekdayLabels[i];
    weekdaysDiv.appendChild(div);
  }
  const daysDiv = document.getElementById('calendarDays');
  daysDiv.innerHTML = '';
  let first = new Date(calendarYear, calendarMonth, 1);
  let last = new Date(calendarYear, calendarMonth+1, 0);
  let startDay = (first.getDay() + 6) % 7; // Monday-start
  let today = new Date(), todayDay = today.getDate(), todayMonth = today.getMonth(), todayYear = today.getFullYear();
  let prevMonth = new Date(calendarYear, calendarMonth, 0);

  // Previous month
  for (let i = 0; i < startDay; ++i) {
    let d = prevMonth.getDate() - startDay + i + 1;
    const btn = document.createElement('button');
    btn.className = 'calendar-day disabled';
    btn.disabled = true;
    btn.textContent = d;
    daysDiv.appendChild(btn);
  }
  // Current month
  for (let d = 1; d <= last.getDate(); ++d) {
    let classes = ["calendar-day"];
    let isToday = d === todayDay && calendarMonth === todayMonth && calendarYear === todayYear;
    let isSelected = selectedDate &&
      d === selectedDate.getDate() &&
      calendarMonth === selectedDate.getMonth() &&
      calendarYear === selectedDate.getFullYear();
    if (isSelected) classes.push("selected");
    else if (isToday) classes.push("today");
    const btn = document.createElement('button');
    btn.className = classes.join(' ');
    btn.dataset.day = d;
    btn.textContent = d;
    btn.onclick = function(e) {
      calendarSelection[calendarType] = new Date(calendarYear, calendarMonth, d);
      renderCalendarVanilla();
      e.stopPropagation();
    };
    daysDiv.appendChild(btn);
  }
  // Fill up calendar
  let cells = startDay + last.getDate();
  for (let i = 1; cells+i <= 35; ++i) {
    const btn = document.createElement('button');
    btn.className = 'calendar-day disabled';
    btn.disabled = true;
    btn.textContent = i;
    daysDiv.appendChild(btn);
  }
  document.getElementById('calendarMonthYear').textContent =
    first.toLocaleString('default', {month: 'long', year: 'numeric'});
}

// Calendar controls
document.getElementById('calendarPrevMonthBtn').onclick = function(e) {
  e.stopPropagation();
  calendarMonth--;
  if (calendarMonth < 0) {
    calendarMonth = 11;
    calendarYear--;
  }
  renderCalendarVanilla();
};
document.getElementById('calendarNextMonthBtn').onclick = function(e) {
  e.stopPropagation();
  calendarMonth++;
  if (calendarMonth > 11) {
    calendarMonth = 0;
    calendarYear++;
  }
  renderCalendarVanilla();
};
document.getElementById('calendarDoneBtn').onclick = function() {
  const type = calendarType;
  const sel = calendarSelection[type];
  if (sel && calendarTargetInput) {
    calendarTargetInput.value = formatDate(sel);
  }
  document.getElementById('calendarPopover').classList.remove('show');
  document.getElementById('calendarPopoverBackdrop').classList.remove('show');
};
document.getElementById('calendarPopoverBackdrop').onclick = function() {
  document.getElementById('calendarPopover').classList.remove('show');
  document.getElementById('calendarPopoverBackdrop').classList.remove('show');
};
document.getElementById('calendarPopover').onclick = function(e) { e.stopPropagation(); };
window.addEventListener('scroll', function() {
  if (document.getElementById('calendarPopover').classList.contains('show') && calendarTargetInput) {
    openCalendarVanilla(calendarTargetInput, calendarType);
  }
});
document.addEventListener('keydown', function(e) {
  if (e.key === "Escape") {
    document.getElementById('calendarPopover').classList.remove('show');
    document.getElementById('calendarPopoverBackdrop').classList.remove('show');
  }
});
document.getElementById('startDate').addEventListener('click', function(e) {
  e.stopPropagation();
  openCalendarVanilla(this, 'start');
});
document.getElementById('endDate').addEventListener('click', function(e) {
  e.stopPropagation();
  openCalendarVanilla(this, 'end');
});
Array.from(document.getElementsByClassName('date-input-icon')).forEach(function(icon) {
  icon.addEventListener('click', function(e) {
    e.stopPropagation();
    let input = this.previousElementSibling;
    openCalendarVanilla(input, input.id === 'startDate' ? 'start' : 'end');
  });
});

// --- Demo submit ---
$('.subscription-form').on('submit', function(e){
  e.preventDefault();
  alert('Form submitted!');
  $('#subscriptionModalBackdrop').removeClass('active');
  $('body').css('overflow', '');
});

</script>
