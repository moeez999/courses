<!-- <button id="openSubscriptionModalBtn">Create Subscription</button> -->
<div class="modal-backdrop" id="subscriptionUpdateModalBackdrop">
  <div class="subscription-modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-header">
      <h2 id="modalTitle">Update Manual Subscription</h2>
      <button class="modal-close" id="closeSubscriptionModalBtn" aria-label="Close">&times;</button>
    </div>
    <div class="modal-content">
      <form class="subscription-form" autocomplete="off">
        <input type="hidden" id="update_row_id">
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
          <label for="paymentMethod" class="subscription-label">Payment method</label>
          <select class="form-select" id="paymentMethod">
            <option value="">Payment method</option>
             <option>zelle</option>
            <option>western union</option>
            <option>Cash</option>
            <option>Exclusive</option>
            <option>PayPal</option>
            <option>PayPal invoice</option>
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
          <button type="submit" class="subscription-submit-btn">Update Subscription</button>
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
  // Unchanged: payment method → subscriber id
  document.getElementById('paymentMethod').addEventListener('change', function() {
      debugger
    const method = this.value;
    if (!method) return;

    const startDate = document.getElementById('startDate')?.value.trim();
    const endDate = document.getElementById('endDate')?.value.trim();

    if (!startDate || !endDate) {
      alert('⚠️ Please select both Start Date and End Date first.');
      this.value = '';
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
// ===== Helpers / Scoped root for UPDATE modal =====
const updateModalRoot = document.getElementById('subscriptionUpdateModalBackdrop');
const $U = (sel) => updateModalRoot.querySelector(sel);

// ---- Status dropdown (no change) ----
function setCustomStatusUI(val) {
  const map = {
    'active':   { text: 'Active',   dotClass: 'status-dot-active' },
    'inactive': { text: 'Inactive', dotClass: 'status-dot-inactive' },
    'paused':   { text: 'Paused',   dotClass: 'status-dot-paused' }
  };
  const key = String(val || '').toLowerCase();
  const cfg = map[key] || map['active'];

  $U('#customStatus').value = cfg.text;
  $U('#customStatusPlaceholder').style.display = 'none';
  $U('#customStatusSelected').style.display = '';
  $U('#customStatusText').textContent = cfg.text;
  $U('#customStatusDot').className = 'custom-status-dot ' + cfg.dotClass;
}

$U('#customStatusDropdown').addEventListener('click', function(e){
  $U('#customStatusOptions').style.display =
    $U('#customStatusOptions').style.display === 'block' ? 'none' : 'block';
  this.classList.toggle('active');
  e.stopPropagation();
});

$U('#customStatusOptions').querySelectorAll('.custom-status-option').forEach(opt => {
  opt.addEventListener('click', function(e){
    const value = this.getAttribute('data-value');
    setCustomStatusUI(value);
    $U('#customStatusOptions').style.display = 'none';
    $U('#customStatusDropdown').classList.remove('active');
    e.stopPropagation();
  });
});

// ---- Submit (no change) ----
$U('.subscription-submit-btn').addEventListener('click', function(e){
    debugger
  e.preventDefault();

  const formData = {
    id: $U('#update_row_id').value,
    firstname: $U('#firstName')?.value.trim(),
    lastname: $U('#lastName')?.value.trim(),
    email: $U('#email')?.value.trim(),
    contactnumber: $U('#contactNumber')?.value.trim(),
    paymentmethod: $U('#paymentMethod')?.value,
    intervalvalue: parseInt($U('#intervalValue')?.value || 1),
    intervaltype: $U('#intervalType')?.value,
    price: parseFloat($U('#price')?.value || 0),
    cohort: $U('#cohort')?.value || '',
    subscriberid: $U('#subscriberId')?.value || '',
    paymentref: $U('#paymentReference')?.value || '',
    start_date: $U('#startDate')?.value || '',
    end_date: $U('#endDate')?.value || '',
    referralcode: $U('#referralCode')?.value.trim() || '',
    status: $U('#customStatus')?.value || 'Active'
  };

  if (!formData.id) { alert('Missing subscription id.'); return; }
  if (!formData.email || !formData.paymentmethod || !formData.intervalvalue || !formData.intervaltype ||
      !formData.price || !formData.cohort || !formData.subscriberid) {
    alert('Please fill all required fields.');
    return;
  }

  debugger

  fetch('update_manual_subscription.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(formData)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('✅ Subscription updated successfully!');
      jQuery('#subscriptionUpdateModalBackdrop').removeClass('active');
      jQuery('body').css('overflow', '');
      if (window.subscriptionsDT) window.subscriptionsDT.ajax.reload(null, false);
    } else {
      alert('❌ ' + (data.message || 'Update failed.'));
    }
  })
  .catch(err => {
    console.error(err);
    alert('❌ Request failed.');
  });
});

// ---- Close behavior (no change) ----
jQuery('#closeSubscriptionModalBtn, #subscriptionUpdateModalBackdrop').on('click', function(e) {
  if (e.target === this) {
    jQuery('#subscriptionUpdateModalBackdrop').removeClass('active');
    jQuery('body').css('overflow', '');
  }
});
jQuery('.subscription-modal').on('click', function(e) { e.stopPropagation(); });

/* ===========================================
   FIX #1: DATE PICKER — use delegated events
   scoped to the UPDATE modal backdrop.
   This works even if there are two modals
   with duplicate IDs on the page.
   =========================================== */
jQuery('#subscriptionUpdateModalBackdrop')
  .on('click', '#startDate', function(e){
    e.stopPropagation();
    openCalendarVanilla(this, 'start');
  })
  .on('click', '#endDate', function(e){
    e.stopPropagation();
    openCalendarVanilla(this, 'end');
  })
  .on('click', '.date-input-icon', function(e){
    e.stopPropagation();
    const input = this.previousElementSibling; // input in same wrapper
    openCalendarVanilla(input, input.id === 'startDate' ? 'start' : 'end');
  });

/* ===========================================
   FIX #2: INTERVAL +/- — delegated & scoped
   (avoids conflicts with another modal that
   uses the same element IDs)
   =========================================== */
jQuery('#subscriptionUpdateModalBackdrop')
  .on('click', '#intervalMinus', function(){
    const $val = jQuery('#subscriptionUpdateModalBackdrop #intervalValue');
    let v = parseInt($val.val() || '1', 10);
    if (v > 1) $val.val(v - 1);
  })
  .on('click', '#intervalPlus', function(){
    const $val = jQuery('#subscriptionUpdateModalBackdrop #intervalValue');
    let v = parseInt($val.val() || '1', 10);
    $val.val(v + 1);
  });

</script>

<script>
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

// (Demo submit block kept as-is if you still need it)
jQuery('.subscription-form').on('submit', function(e){
  e.preventDefault();
  alert('Form submitted!');
  jQuery('#subscriptionUpdateModalBackdrop').removeClass('active');
  jQuery('body').css('overflow', '');
});
</script>
