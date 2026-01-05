  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <link href="css/teacher_time_card_add_manual_time_for.css" rel="stylesheet">

  <div style="padding:32px;text-align:center;">
    <button id="add_manual_time_for_step1_open_btn"
      style="padding:12px 22px;background:#ff3b1f;color:#fff;border:2px solid #000;border-radius:10px;font-weight:700;cursor:pointer;">
      Add
    </button>
  </div>

  <!-- Trigger (demo) -->

  <!-- Modal -->
  <div id="add_manual_time_for_step1_modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="add_manual_time_for_step1_card" role="document" id="add_manual_time_for_step1_card">
      <div class="add_manual_time_for_step1_header">
        <h2 class="add_manual_time_for_step1_title" id="add_manual_time_for_step1_title_txt">Add Add Manual Time for</h2>
        <button class="add_manual_time_for_step1_close" id="add_manual_time_for_step1_close_btn" aria-label="Close">&times;</button>
      </div>

      <div class="add_manual_time_for_step1_body">
        <!-- STEP 1 -->
        <div class="add_manual_time_for_step1_step is-active" id="add_manual_time_for_step1_step1">
          <div class="add_manual_time_for_step1_option" data-add_manual_time_for_step1_value="one_to_one" tabindex="0" role="radio" aria-checked="false">
            <span class="add_manual_time_for_step1_option_label"><span class="add_manual_time_for_step1_icon">👤</span> 1:1 Lessons</span>
            <div class="add_manual_time_for_step1_radio">
              <div class="add_manual_time_for_step1_radio_dot"></div>
            </div>
          </div>

          <div class="add_manual_time_for_step1_option" data-add_manual_time_for_step1_value="group_lessons" tabindex="0" role="radio" aria-checked="false">
            <span class="add_manual_time_for_step1_option_label"><span class="add_manual_time_for_step1_icon">👥</span> Group Lessons</span>
            <div class="add_manual_time_for_step1_radio">
              <div class="add_manual_time_for_step1_radio_dot"></div>
            </div>
          </div>
        </div>

        <!-- STEP 2 (shared layout) -->
        <div class="add_manual_time_for_step1_step" id="add_manual_time_for_step1_step2">

          <!-- FIRST FIELD (Student OR Group) -->
          <!-- Student variant -->
          <div class="add_manual_time_for_step1_field" id="add_manual_time_for_step1_student_field">
            <div class="add_manual_time_for_step1_label">Add Student</div>
            <div class="add_manual_time_for_step1_select_wrap" id="add_manual_time_for_step1_student_wrap">
              <div class="add_manual_time_for_step1_select_fake" id="add_manual_time_for_step1_student_fake" tabindex="0" aria-haspopup="listbox" aria-expanded="false">
                <span id="add_manual_time_for_step1_student_fake_label">Select student</span>
                <span class="add_manual_time_for_step1_caret" aria-hidden="true"></span>
              </div>

              <div class="add_manual_time_for_step1_dropdown" id="add_manual_time_for_step1_student_dropdown" role="listbox">
                <div class="add_manual_time_for_step1_dropdown_search">
                  <input type="text" id="add_manual_time_for_step1_student_search" placeholder="Enter student name" autocomplete="off" />
                </div>
                <div class="add_manual_time_for_step1_dropdown_list" id="add_manual_time_for_step1_student_list"></div>
              </div>
            </div>
          </div>

          <!-- Group variant -->
          <div class="add_manual_time_for_step1_field" id="add_manual_time_for_step1_group_field" style="display:none;">
            <div class="add_manual_time_for_step1_label">Add group</div>
            <div class="add_manual_time_for_step1_select_wrap" id="add_manual_time_for_step1_group_wrap">
              <div class="add_manual_time_for_step1_select_fake" id="add_manual_time_for_step1_group_fake" tabindex="0" aria-haspopup="listbox" aria-expanded="false">
                <span id="add_manual_time_for_step1_group_fake_label">Select cohort</span>
                <span class="add_manual_time_for_step1_caret" aria-hidden="true"></span>
              </div>

              <div class="add_manual_time_for_step1_dropdown" id="add_manual_time_for_step1_group_dropdown" role="listbox">
                <div class="add_manual_time_for_step1_dropdown_search">
                  <input type="text" id="add_manual_time_for_step1_group_search" placeholder="Search for cohort" autocomplete="off" />
                </div>
                <div class="add_manual_time_for_step1_dropdown_list" id="add_manual_time_for_step1_group_list"></div>
              </div>
            </div>
          </div>

          <!-- Shared form fields -->
          <div class="add_manual_time_for_step1_field">
            <div class="add_manual_time_for_step1_label">Duration</div>
            <input type="text" id="add_manual_time_for_step1_duration" class="add_manual_time_for_step1_input" placeholder="Duration" />
          </div>

          <div class="add_manual_time_for_step1_field">
            <div class="add_manual_time_for_step1_label">Attendance</div>
            <input type="text" id="add_manual_time_for_step1_attendance" class="add_manual_time_for_step1_input" placeholder="Attendance" />
          </div>

          <div class="add_manual_time_for_step1_field">
            <div class="add_manual_time_for_step1_label">Payable</div>
            <div class="add_manual_time_for_step1_select_wrap">
              <div class="add_manual_time_for_step1_select_fake" id="add_manual_time_for_step1_payable_fake" tabindex="0">
                <span id="add_manual_time_for_step1_payable_label">Yes</span>
                <span class="add_manual_time_for_step1_caret"></span>
              </div>
              <div class="add_manual_time_for_step1_dropdown" id="add_manual_time_for_step1_payable_dropdown">
                <div class="add_manual_time_for_step1_dropdown_list" id="add_manual_time_for_step1_payable_list">
                  <div class="add_manual_time_for_step1_dropdown_item" data-value="Yes">
                    <div class="add_manual_time_for_step1_name">Yes</div>
                  </div>
                  <div class="add_manual_time_for_step1_dropdown_item" data-value="No">
                    <div class="add_manual_time_for_step1_name">No</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="add_manual_time_for_step1_field">
            <div class="add_manual_time_for_step1_label">Amount</div>
            <input type="text" id="add_manual_time_for_step1_amount" class="add_manual_time_for_step1_input" placeholder="Amount" />
          </div>

          <div class="add_manual_time_for_step1_field">
            <div class="add_manual_time_for_step1_label">Notes</div>
            <textarea id="add_manual_time_for_step1_notes" class="add_manual_time_for_step1_textarea" placeholder="Add Notes"></textarea>
          </div>

        </div>
      </div>

      <div class="add_manual_time_for_step1_footer">
        <button id="add_manual_time_for_step1_primary_btn" class="add_manual_time_for_step1_continue" disabled>Continue</button>
      </div>
    </div>
  </div>
  
 <script src="js/teacher_time_card_add_manual_time_for.js"></script>