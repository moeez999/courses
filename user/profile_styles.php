<style>
/* Root Variables */
:root {
  --color-primary: #4F46E5;
  --color-secondary: #1E40AF;
  --color-white: #FFFFFF;
  --color-border: #E5E7EB;
  --color-text-dark: #111827;
  --color-text-light: #6B7280;
  --color-text-link: #3B82F6;
  --color-text-link-strong: #2563EB;
  --color-success: #10B981;
  --color-active: #FF3D00;
}

/* Base Styles */
.user-profile-modern {
  font-family: 'Inter', sans-serif;
  color: var(--color-text-dark);
}

/* Layout and Structure */
.container-fluid {
  padding: 0 16px;
}

.row {
  margin: 0 -8px;
}

.col-lg-8, .col-lg-6, .col-lg-4,
.col-md-12, .col-md-6 {
  padding: 0 8px;
}

.profile-container {
  max-width: auto;
  margin: 0 auto;
  padding: 0 16px;
}

.profile-grid {
  display: grid;
  grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
  gap: 24px;
  align-items: start;
  padding: 24px 0;
}

.profile-col-left, .profile-col-right {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.wrapper-course {
  width: 100%;
  padding: 0px 0px;
  background-color: #fff;
  border-radius: 7px;
  transition: all 0.2s ease-in-out;
}

.column {
  background-color: white;
  border-radius: 10px;
  padding: 20px;
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  height: 100%;
}

/* Header Styles */
.page-header {
  background-color: var(--color-white);
  border-bottom: 1px solid var(--color-border);
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(5px);
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 60px;
  padding: 0 60px;
  max-width: none;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.logo {
  font-size: 22px;
  font-weight: 600;
  color: #00337C;
  margin: 0;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 16px;
}

.icon-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  height: 38px;
  background-color: rgba(0, 0, 0, 0.03);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 50%;
  cursor: pointer;
  font-size: 20px;
  color: var(--color-text-dark);
}

.user-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 1.2px solid rgba(18, 17, 23, 0.06);
}

.nav-row {
  display: flex;
  gap: 24px;
  padding: 12px 50px;
  border-top: 1px solid var(--color-border);
  border-bottom: 1px solid var(--color-border);
  background-color: var(--color-white);
}

.main-nav ul {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  gap: 24px;
}

.main-nav a {
  display: block;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  color: var(--color-text-dark);
  position: relative;
  padding-bottom: 4px;
}

.main-nav a.active {
  color: var(--color-active);
  font-weight: 600;
}

.main-nav a.active::after {
  content: "";
  position: absolute;
  bottom: -6px;
  left: 0;
  width: 100%;
  height: 2px;
  background-color: var(--color-active);
}

/* Card Styles */
.card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  padding: 20px;
  margin-bottom: 20px;
}

.card h2 {
  font-size: 1.25rem;
  margin: 0 0 15px 0;
  color: #333;
}

.profile-card {
  background-color: var(--color-white);
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 20px;
  border: 1px solid #ddd;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.profile-card h2 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 16px;
}

.profile-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

/* Profile Card Specific */
.mdl-profilecard {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #ffffff;
  border-radius: 12px;
  padding: 12px 16px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);  
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
}

.mdl-profilecard-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.mdl-profilecard-avatar img {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
}

.mdl-profilecard-name {
  font-size: 16px;
  font-weight: 600;
  color: #212121;
}

.mdl-profilecard-editbtn {
  background-color: #f5f5f5;
  border: none;
  border-radius: 50%;
  padding: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s ease;
}

.mdl-profilecard-editbtn:hover {
  background-color: #e0e0e0;
}

.profile-avatar-wrapper {
  position: relative;
  width: 48px;
  height: 48px;
}

.profile-avatar {
  width: 100%;
  height: 100%;
  border-radius: 50%;
}

.edit-profile-btn {
  position: absolute;
  bottom: -4px;
  right: -4px;
  width: 20px;
  height: 20px;
  background-color: var(--color-white);
  border: 1px solid var(--color-border);
  border-radius: 50%;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.profile-name {
  font-size: 16px;
  font-weight: 600;
  margin: 0;
}

/* Info List Styles */
.info-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding: 16px 12px;
  border: 0.5px solid rgba(0, 0, 0, 0.2);
  border-radius: 12px;
}

.info-label {
  font-size: 15px;
  font-weight: 600;
}

.info-value {
  font-size: 14px;
  color: var(--color-text-light);
}

/* Tab Styles */
.tabs {
  display: flex;
  gap: 8px;
  background: #f6f6f6;
  border-radius: 8px;
  padding: 4px;
  margin-top: 16px;
}

.tab-btn {
  flex: 1;
  padding: 8px 12px;
  border: none;
  background: none;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  border-radius: 6px;
  transition: all 0.2s;
}

.tab-btn.active {
  background: #fff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  font-weight: 600;
}

.tab-content {
  display: none;
}

.tab-content.active {
  display: block;
}

/* Modern Tab Styles */
.modern-tab-wrapper {
  width: 100%;
  margin: 0;
  background: #fff;
  border-radius: 8px;
  border: 1px solid #ddd;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.modern-tab-nav {
  background-color: #f6f6f6;
  border-radius: 8px;
  margin: 10px; 
}

.modern-tab-btn {
  padding: 12px 16px;
  background: none;
  border: none;
  border-bottom: 3px solid transparent;
  cursor: pointer;
  font-size: 16px;
  font-weight: 600;
  color: #000000ff;
  transition: all 0.2s ease;
  position: relative;
  margin-right: 8px;
}

.modern-tab-btn:hover {
  color: #202124;
}

.modern-tab-btn.active {
  color: #000000ff;
  border-bottom-color: #f6f6f6;
  background-color: #ffffffff;
  font-weight: 500;
  border-radius: 8px;
  border: 2px solid #ddd;
}

.modern-tab-content {
  padding: 16px;
}

.modern-tab-panel {
  display: none;
}

.modern-tab-panel.active {
  display: block;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(5px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Style the content to match WhatsApp image */
.modern-tab-panel ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.modern-tab-panel li {
  padding: 12px 12px;
  border-bottom: 1px solid #f1f1f1;
}

.modern-tab-panel li:last-child {
  border-bottom: none;
}

.modern-tab-panel a {
  color: #3b82f6;
  text-decoration: none;
  display: block;
  font-size: 16px;
}

.modern-tab-panel .card-body h5 {
  display: none !important;
}

.modern-tab-panel li:hover {
  background-color: #f8f9fa
}

/* Card styling inside tabs */
.modern-tab-panel .card {
  border: none;
  box-shadow: none;
  margin-bottom: 0;
}

.modern-tab-panel .card-body {
  padding: 0;
}

/* Attendance Chart Styles */
.attendance-legend, .attendance-controls, .legend-item {
  display: flex;
  align-items: center;
  gap: 8px;
}
.controls-container {
    flex-grow: 1; /* takes remaining space */
    min-width: 0; /* allows shrinking */
}

.attendance-controls {
    display: flex;
    justify-content: flex-end; /* aligns content to right */
    gap: 10px;
    width: 100%;
}
.attendance-legend { 
  gap: 16px;
  margin-bottom: 50px;
}
#chart-title {
    margin: 0;
    display: inline-block;
}
.color-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
}

.color-dot.main-class { background-color: #FF3D00; }
.color-dot.practice-class { background-color:var(--color-secondary) ; }

.checkbox-wrapper {
  width: 18px;
  height: 18px;
  border-radius: 4px;
  border: 1px solid rgba(0,0,0,0.4);
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
}

.control-btn {
  width: 40px;
  height: 40px;
  border: 1px solid var(--color-border);
  border-radius: 8px;
  background-color: var(--color-white);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}

 

.select-set {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  border: 1px solid var(--color-border);
  border-radius: 8px;
  font-size: 14px;
}

.chart-container {
  display: flex;
  gap: 16px;
  margin-top: 20px;
}

.y-axis {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  font-size: 12px;
  color: var(--color-text-light);
  text-align: right;
  padding-bottom: 28px;
}

.chart-bars {
  flex-grow: 1;
  display: flex;
  justify-content: space-around;
  align-items: flex-end;
  gap: 16px;
  border-left: 1px solid var(--color-border);
  border-bottom: 1px solid var(--color-border);
  padding-left: 16px;
  padding-top: 16px;
}

.bar-group {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  flex-grow: 1;
}

.bar-wrapper {
  position: relative;
  display: flex;
  align-items: flex-end;
  gap: 4px;
  height: 364px;
  width: 100%;
}

.bar-text {
  position: absolute;
  top: 344px;
  left: 25%;
  transform: translateX(-50%);
  font-size: 14px;
  font-weight: 500;
  text-align: center;
  line-height: 1.2;
  color: var(--color-text-dark);
  white-space: pre; /* Respects \n as line breaks */ 
}
.bar-text2 {
  position: absolute;
  top: 344px;
  left: 75%;
  transform: translateX(-50%);
  font-size: 14px;
  font-weight: 500;
  text-align: center;
  line-height: 1.2;
  color: var(--color-text-dark);
  white-space: pre; /* Respects \n as line breaks */ 
}
.bar {
  width: 50%;
}
.fullbar {
  width: 100%;
}
.fullbar-text {
  position: absolute;
  top: 344px;
  left: 45%;
  transform: translateX(-50%);
  font-size: 14px;
  font-weight: 500;
  text-align: center;
  line-height: 1.2;
  color: var(--color-text-dark);
  white-space: pre; /* Respects \n as line breaks */ 
}
.fullbar.red { background-color: #1E40AF; }
.fullbar.blue { background-color: #FF3D00; }
.bar.red { background-color: #1E40AF; }
.bar.blue { background-color: #FF3D00; }

.bar-label {
  font-size: 14px;
  color: var(--color-text-light);
  white-space: nowrap;
}

/* Accordion Styles */
.accordion {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 16px;
}

.accordion-item {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
  transition: all 0.2s;
}

.accordion-item:hover {
  border-color: #d0d0d0;
}

.accordion-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  cursor: pointer;
  background: #f9f9f9;
  transition: background 0.2s;
}

.accordion-header:hover {
  background: #f0f0f0;
}

.accordion-header span {
  font-weight: 500;
}

.exam-meta {
  display: flex;
  align-items: center;
  gap: 12px;
}

.score {
  font-weight: 600;
}

.percentage {
  min-width: 40px;
  text-align: right;
}

.accordion-header i {
  transition: transform 0.2s;
  margin-left: 8px;
  color: #666;
}

.accordion-item.active .accordion-header i {
  transform: rotate(180deg);
}

.accordion-content {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease;
  padding: 0 16px;
}

.accordion-item.active .accordion-content {
  max-height: 500px;
  padding: 16px;
}

/* Result Details */
.result-details {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
  margin-bottom: 16px;
}

.detail-row {
  display: flex;
  justify-content: space-between;
  padding: 4px 0;
}

.detail-row span:first-child {
  font-weight: 500;
  color: #555;
}

/* Chart Styles */
.result-chart {
  height: 8px;
  background: #f0f0f0;
  border-radius: 4px;
  margin: 12px 0;
  overflow: hidden;
}

.chart-bar {
  height: 100%;
  background: #4CAF50;
  border-radius: 4px;
}

/* Feedback */
.feedback {
  padding: 12px;
  background: #f5f5f5;
  border-radius: 6px;
  margin-top: 12px;
  font-size: 14px;
  line-height: 1.5;
}

.feedback strong {
  display: block;
  margin-bottom: 4px;
}

.feedback-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.feedback-item {
  padding: 16px;
  border: 0.5px solid rgba(0, 0, 0, 0.2);
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.feedback-text {
  margin: 0;
  font-size: 14px;
  line-height: 21px;
}

.feedback-meta {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 500;
  color: var(--color-text-light);
}

.feedback-meta .dot {
  width: 4px;
  height: 4px;
  background-color: var(--color-text-light);
  border-radius: 50%;
}

.feedback-meta a {
  color: var(--color-text-link-strong);
  font-weight: 600;
  text-decoration: none;
}

/* Payment History Styles */
.payment-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.payment-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  border-radius: 6px;
  background: #f9f9f9;
  transition: all 0.2s;
}

.payment-item:hover {
  background: #f0f0f0;
}

.payment-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.payment-method-badge {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 50px;
  height: 50px;
  border-radius: 8px;
  color: white;
  font-weight: bold;
}

.method-main {
  font-size: 16px;
  line-height: 1;
}

.method-sub {
  font-size: 10px;
  font-weight: normal;
  margin-top: 2px;
}

.payment-method-badge.paypal {
  background: #253b80;
}

.payment-method-badge.braintree {
  background: #6f42c1;
}

.payment-method-badge.patreon {
  background: #f96854;
}

.payment-date {
  font-size: 14px;
  color: #666;
}

.payment-date.present {
  color: #28a745;
  font-weight: 500;
}

/* Cohort Styles */
.cohort-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.cohort-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 12px;
  border: 0.5px solid rgba(0, 0, 0, 0.2);
  border-radius: 12px;
}

.cohort-info {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 500;
}

.cohort-level-badge {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: var(--color-white);
}

.cohort-level-badge.purple { background-color: #6d264e; }
.cohort-level-badge.olive { background-color: #747c27; }

.level-main {
  font-size: 14px;
  font-weight: 600;
  line-height: 1;
}

.level-sub {
  font-size: 10px;
  opacity: 0.7;
  line-height: 1;
}

.cohort-date {
  font-size: 14px;
  font-weight: 500;
  color: var(--color-text-light);
}

.cohort-date.present { color: var(--color-success); }

/* Misc Links */
.misc-links {
  display: flex;
  flex-direction: column;
}

.misc-links a {
  padding: 16px 12px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.2);
  text-decoration: none;
  color: var(--color-text-link);
  font-size: 16px;
}

.misc-links a:first-child {
  border-top: 1px solid rgba(0, 0, 0, 0.2);
}

/* Empty State Styles */
.no-results, .no-payments, .no-cohorts {
  padding: 20px;
  text-align: center;
  color: #666;
  font-style: italic;
  border: 1px dashed #ddd;
  border-radius: 8px;
}

/* Responsive Design */
@media (max-width: 992px) {
  .header-container {
    padding: 0 20px;
  }
  
  .main-nav ul {
    gap: 12px;
  }
}

@media (max-width: 768px) {
  .profile-grid {
    grid-template-columns: 1fr;
  }
  
  .result-details {
    grid-template-columns: 1fr;
  }
  
  .tabs {
    flex-direction: column;
  }
  
  .exam-meta {
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
  }
  
  .payment-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .payment-date {
    align-self: flex-end;
  }
  
  .chart-container {
    flex-direction: column;
  }
  
  .y-axis {
    flex-direction: row;
    justify-content: space-between;
    padding-bottom: 0;
    padding-right: 16px;
  }
 
  .chart-bars {
    border-left: none;
    border-top: 1px solid var(--color-border);
    padding-left: 0;
    padding-top: 16px;
  }
}
 .y-axis span {
    display: block;
    padding: 8px 0; /* Adds padding above and below each label */
} 
@media (max-width: 576px) {
  .header-container {
    padding: 0 12px;
  }
  
  .main-nav ul {
    gap: 8px;
    font-size: 12px;
  }
}
.feedback-tab-content {
    display: none;
}

.feedback-tab-content.active {
    display: block;
}




.select-btn {
        padding: 10px 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: white;
        cursor: pointer;
    }

    /* Dropdown Container */
    .dropdown-container {
        position: absolute;
        top: 100px;
        right: 0px;
        width: 530px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 16px;
        display: none;
        z-index: 10;
    }

    .dropdown-header {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 12px;
    }

    .dropdown-section {
        margin-bottom: 16px;
    }

    .dropdown-title {
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .expandable {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-weight: 600;
        cursor: pointer;
    }

    .arrow {
        transition: transform 0.3s ease;
    }
    .arrow.open { transform: rotate(90deg); }

    .dropdown-sublist {
        list-style: none;
        padding-left: 20px;
        display: none;
    }
    .dropdown-sublist li {
        padding: 6px;
        cursor: pointer;
        border-radius: 6px;
        transition: background 0.2s;
    }
    .dropdown-sublist li:hover { background: #f5f5f5; }

    .dropdown-item {
        padding: 10px;
        cursor: pointer;
        border-radius: 8px;
        transition: background 0.2s;
    }
    .dropdown-item:hover { background: #f1f1f1; }

    /* Date Input */
    .date-input {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-top: 8px;
        background: #fafafa;
        cursor: pointer;
    }
    .date-input span {
        font-weight: 600;
    }

    /* Calendar Modal */
    .calendar-popup {
        display: none;
        position: absolute;
        top: 200px;
        right: 380px;
        width: 320px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 16px;
        z-index: 20;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-weight: 600;
    }
    .calendar-header button {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
        text-align: center;
        margin-top: 10px;
    }
    .calendar-day {
        padding: 8px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.2s;
    }
    .calendar-day:hover {
        background: #f0f0f0;
    }
    .calendar-day.selected {
        border: 2px solid #ff3b00;
        color: #ff3b00;
        font-weight: bold;
    }

    .done-btn {
        width: 100%;
        margin-top: 12px;
        padding: 10px;
        background: #ff3b00;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }
 

 
 

</style>                     