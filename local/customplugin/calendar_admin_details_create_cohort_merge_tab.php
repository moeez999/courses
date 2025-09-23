<div class="calendar_admin_details_create_cohort_content tab-content" id="mergeTabContent" style="display:none;">
  <form id="mergeCohortForm">
    <div class="merge-row">
      <!-- Closing Cohort -->
      <div class="merge-col">
        <label class="merge-label">Closing Cohort</label>
        <div class="merge-dropdown-wrapper">
          <div class="merge-dropdown-btn" id="mergeClosingCohortBtn">
            <span class="merge-dropdown-selected" id="mergeClosingCohortSelected">FL-6-XXXXXX-0092</span>
            <svg width="20" height="20"><path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
          </div>
          <div class="merge-dropdown-list" id="mergeClosingCohortList">
            <div class="merge-dropdown-title">Existing Cohorts</div>
            <ul>
              <li>TX-1-030423-0090</li>
              <li>OH-12-032023-0089</li>
              <li>NY-2-042522-0088</li>
              <li>OH-12-032023-0089</li>
              <li>TX-1-030423-0090</li>
            </ul>
          </div>
        </div>
        <label class="merge-label" style="margin-top:14px;">Closing Date</label>
        <button type="button" class="merge-date-btn" id="mergeClosingDateBtn">Select Date</button>

        <label class="merge-checkbox-label" style="margin-top:17px;">
          <input type="checkbox" id="mergeNow">
          Close now
        </label>
 

      </div>
      <!-- Joining Cohort -->
      <div class="merge-col">
        <label class="merge-label">Joining Cohort</label>
        <div class="merge-dropdown-wrapper">
          <div class="merge-dropdown-btn" id="mergeJoiningCohortBtn">
            <span class="merge-dropdown-selected" id="mergeJoiningCohortSelected">FL-6-XXXXXX-0092</span>
            <svg width="20" height="20"><path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
          </div>
          <div class="merge-dropdown-list" id="mergeJoiningCohortList">
            <div class="merge-dropdown-title">Existing Cohorts</div>
            <ul>
              <li>TX-1-030423-0090</li>
              <li>OH-12-032023-0089</li>
              <li>NY-2-042522-0088</li>
              <li>OH-12-032023-0089</li>
              <li>TX-1-030423-0090</li>
            </ul>
          </div>
        </div>

        <label class="merge-label" style="margin-top:14px;">Merging Date</label>
        <button type="button" class="merge-date-btn" id="mergeMergingDateBtn">Select Date</button>
        <label class="merge-checkbox-label" style="margin-top:17px;">
          <input type="checkbox" id="mergeNow">
          Merge now
        </label>

      </div>
    </div>
    <button type="submit" class="merge-cohort-btn">Merge Cohort</button>
  </form>
</div>











<!-- Calendar Modal -->
<div class="merge-calendar-modal-backdrop" id="mergeCalendarModalBackdrop" style="display:none;">
  <div class="merge-calendar-modal" id="mergeCalendarModal">
    <div class="merge-calendar-header">
      <button type="button" class="merge-calendar-prev">&lt;</button>
      <span id="mergeCalendarMonth"></span>
      <button type="button" class="merge-calendar-next">&gt;</button>
    </div>
    <div class="merge-calendar-days"></div>
    <button class="merge-calendar-done-btn" type="button">Done</button>
  </div>
</div>



