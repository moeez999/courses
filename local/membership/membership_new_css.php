<style id="sections-styles">
  :root {
    --primary-color: #001cb1;
    --text-dark: #000000;
    --text-light: #667085;
    --text-white: #ffffff;
    --border-color: rgba(0, 0, 0, 0.12);
    --background-white: #ffffff;
    --background-light-gray: #f5f5f5;
    --status-active-bg: #ecfdf3;
    --status-active-text: #027a48;
    --status-inactive-bg: #f2f4f7;
    --status-inactive-text: #344054;
    --status-paused-bg: rgba(221, 133, 62, 0.15);
    --status-paused-text: #dd853e;
  }

  /* Base Styles */
  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: var(--background-white);
    color: var(--text-dark);
  }

  .page-container {
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 20px;
    background-color: var(--background-white);
  }

  * {
    box-sizing: border-box;
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  img {
    max-width: 100%;
    height: auto;
    display: block;
  }

  /* Header Styles */
  .site-header {
    background-color: var(--background-white);
    padding-top: 16px;
  }

  .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 26px;
    height: 38px;
    margin-bottom: 13px;
  }

  .logo {
    width: 172px;
    height: 30px;
  }

  .user-actions {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .icon-group {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .icon-button {
    background-color: rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    padding: 0;
  }

  .icon-button img {
    width: 21px;
    height: 21px;
  }

  .profile-link .avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1.2px solid rgba(18, 17, 23, 0.06);
  }

  .main-nav {
    background-color: rgba(255, 255, 255, 0.7);
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    padding: 0 26px;
  }

  .main-nav ul {
    display: flex;
    gap: 4px;
  }

  .main-nav li a {
    display: block;
    padding: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-dark);
    line-height: 21px;
  }

  .main-nav li a.active {
    color: #ff2500;
    border: 1px solid #ff2500;
    border-radius: 4px;
    margin: 9px 0;
    padding: 9px 9px;
  }

  /* Dashboard Content */
  .dashboard-content {
    padding-top: 34px;
    padding-bottom: 50px;
  }

  .dashboard-title {
    font-size: 32px;
    font-weight: 600;
    line-height: 48px;
    margin: 0 0 20px 0;
  }

  /* Stats Section */
  .stats-section {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 40px;
  }

  .stats-filters {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .filter-button {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 8px;
    padding: 16px;
    background-color: var(--background-white);
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    cursor: pointer;
  }

  .filter-button.date-range-button {
    gap: 16px;
    padding: 8px 24px;
  }

  .date-range-button div {
    display: flex;
    flex-direction: column;
    text-align: left;
  }

  .date-label {
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    color: rgba(0, 0, 0, 0.6);
  }

  .date-value {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
  }

  .date-info {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
  }

  .stat-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding-right: 18px;
    border-right: 1px solid var(--border-color);
  }

  .stat-item:last-child {
    border-right: none;
  }

  .stat-title {
    display: flex;
    align-items: center;
    gap: 7px;
    margin: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 23px;
    color: var(--text-dark);
  }

  .stat-title .dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
  }

  .stat-value {
    font-size: 42px;
    font-weight: 500;
    line-height: 47px;
    margin: 0;
  }

  .stat-comparison {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    margin: 0;
  }

  .stat-comparison.negative {
    color: #b42318;
  }

  .stat-comparison.positive {
    color: #027a48;
  }

  .stat-comparison span {
    color: rgba(0, 0, 0, 0.6);
    font-size: 12px;
  }

  /* Graph Section */
  .graph-section {
    border: 1px solid #d2d5da;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 40px;
  }

  .graph-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .graph-title {
    font-size: 18px;
    font-weight: 500;
    margin: 0;
  }

  .toggle-button {
    border: 1px solid rgba(0, 0, 0, 0.2);
    background: transparent;
    border-radius: 6px;
    padding: 4px;
    cursor: pointer;
    transform: rotate(180deg);
  }

  .graph-legends {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    margin-bottom: 20px;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
  }

  .legend-item .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
  }

  .graph-body {
    position: relative;
    display: flex;
  }

  .y-axis {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding-right: 10px;
    font-size: 10px;
    color: #6d7280;
    height: 238px;
  }

  .y-label {
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .y-label hr {
    flex-grow: 1;
    border: none;
    border-top: 1px solid #d2d5da;
    width: 1200px;
  }

  .chart-area {
    position: relative;
    flex-grow: 1;
    height: 238px;
  }

  .chart-lines {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .chart-line {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: bottom left;
  }

  .hover-line {
    position: absolute;
    top: -20px;
    height: calc(100% + 20px);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: rgba(0, 0, 0, 0.6);
  }

  .hover-line .line {
    width: 1px;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .x-axis {
    display: flex;
    justify-content: space-between;
    padding: 10px 10px 0 40px;
    font-size: 10px;
    color: #6d7280;
  }

  /* Table Section */
  .table-section {
    margin-bottom: 40px;
  }

  .table-controls {
    display: flex;
    justify-content: space-between;
    align-items: stretch;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
  }
  
  .search-filter-group,
  .action-buttons-group {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: stretch;
  }

  .search-input,
  .control-button {
    height: 56px;
    display: flex;
    align-items: center;
    box-sizing: border-box;
  }

  .search-input {
    padding: 0 16px;
  }

  .search-input input {
    border: none;
    outline: none;
    background: transparent;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    width: 250px;
    height: 100%;
  }

  .control-button {
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 12px;
    padding: 0 18px;
    background-color: var(--background-white);
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
  }

  .control-button img {
    width: 20px;
    height: 20px;
    object-fit: contain;
  }

  .dropdown .control-button {
    position: relative;
    padding-right: 30px;
  }

  .dropdown .control-button::after {
    content: '';
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid currentColor;
  }

  .table-container {
    overflow-x: auto;
  }

  .table-header,
  .table-row {
    display: grid;
    grid-template-columns: 177px 285px 106px 132px 71px 127px 121px 97px 87px 77px;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
  }

  .table-header {
    background-color: var(--primary-color);
    color: var(--text-white);
    font-size: 16px;
    font-weight: 400;
    border-radius: 12px 12px 0 0;
  }

  .table-header>div {
    padding: 22px 16px;
  }

  .table-row>div {
    padding: 16px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 300;
  }

  .td-name {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .td-name img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }

  .td-contact {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .td-contact>div {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 2px 11px 2px 8px;
    border-radius: 16px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
  }

  .status-badge::before {
    content: '';
    width: 11px;
    height: 11px;
    border-radius: 50%;
  }

  .status-badge.active {
    background-color: var(--status-active-bg);
    color: var(--status-active-text);
  }

  .status-badge.active::before {
    background-color: var(--status-active-text);
  }

  .status-badge.inactive {
    background-color: var(--status-inactive-bg);
    color: var(--status-inactive-text);
  }

  .status-badge.inactive::before {
    background-color: var(--status-inactive-text);
  }

  .status-badge.paused {
    background-color: var(--status-paused-bg);
    color: var(--status-paused-text);
  }

  .status-badge.paused::before {
    background-color: var(--status-paused-text);
  }

  .edit-button {
    position: relative;
    width: 41px;
    height: 41px;
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
  }

  .edit-button img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  /* Pagination Section */
  .pagination-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
  }

  .pagination-info {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: var(--text-light);
  }

  .pagination-info .bold {
    font-weight: 400;
    color: var(--text-dark);
  }

  .pagination-refresh {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: var(--text-light);
  }

  .page-navigation {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .page-link {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 60px;
    height: 56px;
    border: 0.5px solid rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: var(--text-dark);
  }

  .page-link.arrow {
    background-color: var(--background-light-gray);
  }

  .page-link.active {
    background-color: var(--background-light-gray);
  }

  /* Dropdown Styles */
  .dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    color: var(--text-dark);
    font-size: 16px;
    transition: background-color 0.2s;
    text-decoration: none;
  }

  .dropdown-icon {
    width: 16px;
    text-align: center;
    font-size: 16px;
  }

  .dropdown-item:hover {
    background-color: #f5f5f5;
  }

  .dropdown-item span {
    flex-grow: 1;
  }

  /* Responsive Styles */
  @media (max-width: 1200px) {
    .stats-grid {
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .stat-item {
      border-right: none;
      padding-right: 0;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--border-color);
    }

    .stat-item:last-child {
      border-bottom: none;
    }
  }

  @media (max-width: 768px) {
    .page-container {
      padding: 0 15px;
    }

    .dashboard-title {
      font-size: 24px;
    }

    .table-controls {
      flex-direction: column;
      align-items: stretch;
    }

    .pagination-section {
      flex-direction: column;
      align-items: center;
    }
  }

  /* DataTable Custom Styles */
  .custom-datatable-header {
    background-color: #001cb1;
    color: white;
  }

  #subscriptionsTable {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px 10px 0 0;
    overflow: hidden;
  }

  #subscriptionsTable thead th {
    padding: 20px 15px;
    border: none;
    font-weight: 700;
    color: #fff;
  }

  #subscriptionsTable thead th:first-child {
    border-top-left-radius: 10px;
  }

  #subscriptionsTable thead th:last-child {
    border-top-right-radius: 10px;
  }

  #subscriptionsTable tbody tr {
    transition: background-color 0.2s;
    border-bottom: 1px solid #e5e7eb;
  }

  #subscriptionsTable tbody tr:last-child {
    border-bottom: none;
  }

  #subscriptionsTable tbody tr:hover {
    background-color: #f5f5f5;
  }

  .btn-container {
    display: flex;
    gap: 5px;
  }

  .btn-primary {
    background-color: #001cb1;
    border-color: #001cb1;
  }

  .btn-primary:hover {
    background-color: #001cb1;
    border-color: #001cb1;
  }

  /* Hide default DataTable elements */
  .dataTables_filter,
  .dataTables_length,
  .dataTables_info {
    display: none !important;
  }

  /* Action dropdown container */
  .subscription-actions-container {
    position: relative;
    display: inline-block;
  }

  /* Trigger button */
  .subscription-actions-trigger {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
  }

  /* Dropdown menu */
  .subscription-actions-menu {
    display: none;
    position: absolute;
    right: 0;
    z-index: 1000;
    min-width: 200px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 5px 0;
  }

  /* Show menu when active */
  .subscription-actions-container.active .subscription-actions-menu {
    display: block;
  }

  /* Menu items */
  .subscription-action-item {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 8px 15px;
    background: none;
    border: none;
    text-align: left;
    color: #333;
    cursor: pointer;
    gap: 10px;
  }

  .subscription-action-item:hover {
    background-color: #f5f5f5;
  }

  .subscription-action-item i {
    width: 20px;
    text-align: center;
  }

</style>