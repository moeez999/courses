document.addEventListener("DOMContentLoaded", function() {
    // Your existing DOMContentLoaded code remains the same...
    // Function to toggle between tabs and tables
    const tabs = document.querySelectorAll(".tab");
    const tables = document.querySelectorAll(".table");

    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            tabs.forEach((t) => t.classList.remove("active"));
            tables.forEach((table) => table.classList.remove("active"));

            tab.classList.add("active");
            const targetTable = document.querySelector(
                `.${tab.dataset.target}-table`
            );
            if (targetTable) {
                targetTable.classList.add("active");
            } else {
                console.error(`No table found for target: ${tab.dataset.target}`);
            }
        });
    });

    // Handle edit button clicks with event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-container, .edit-container-timeline, .note-container')) {
            const button = e.target.closest('.edit-container, .edit-container-timeline, .note-container');
            const date = button.getAttribute('data-date');
            const teacherId = button.getAttribute('data-teacherid');
            
            if (date && teacherId) {
                showLoadingPopup();
                fetchEditData(date, teacherId);
            } else {
                console.error('Missing date or teacherId data attributes');
            }
        }
    });

    // Handle filter button
    const filterButton = document.querySelector(".btn-filter");
    const filterPopup = document.querySelector(".filter-checkbox");

    if (filterButton && filterPopup) {
        filterButton.addEventListener("click", () => {
            filterPopup.classList.toggle("active");
        });
    }

    // Handle calendar button
    const calendarButton = document.querySelector(".btn-calendar");
    const calendarPopup = document.querySelector(".popup-calendar");

    if (calendarButton && calendarPopup) {
        calendarButton.addEventListener("click", () => {
            calendarPopup.classList.toggle("active");
        });
    }

    // Close popup if clicked outside
    document.addEventListener('click', function(e) {
        const overlay = document.querySelector('.overlay');
        const popup = document.querySelector('.edit-popup-container');
        
        if (overlay && popup && e.target === overlay) {
            popup.style.display = 'none';
            overlay.style.display = 'none';
        }
    });

    // Initialize jQuery functionality
    if (typeof jQuery !== 'undefined') {
        setupPopupEvents();
    }

    if (calendarButton) {
        calendarButton.addEventListener("click", function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById("dropdown");
            if (dropdown) {
                dropdown.classList.toggle("show");
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById("dropdown");
        const calendarBtn = document.getElementById("calendar-btn");
        
        if (dropdown && dropdown.classList.contains('show') && 
            !dropdown.contains(e.target) && 
            !calendarBtn.contains(e.target)) {
            dropdown.classList.remove("show");
        }
    });

    // Select option functionality
    const optionDivs = document.querySelectorAll("#dropdown .dropdown-option");
    optionDivs.forEach(div => {
        div.addEventListener("click", function() {
            const optionText = this.getAttribute('data-value');
            const days = this.getAttribute('data-days');
            
            // Update the display text with the option text
            const selectedTextElement = document.getElementById("selected-text");
            if (selectedTextElement) {
                selectedTextElement.textContent = optionText;
            }
            
            // Calculate dates based on selection if it's not a custom range
            if (days) {
                let startDate, endDate;
                const today = new Date();
                
                switch(days) {
                    case '1': // Today
                        startDate = today;
                        endDate = today;
                        break;
                    case '2': // Yesterday
                        startDate = new Date(today);
                        startDate.setDate(today.getDate() - 1);
                        endDate = new Date(today);
                        endDate.setDate(today.getDate() - 1);
                        break;
                    default: // Days-based selection
                        startDate = new Date(today);
                        startDate.setDate(today.getDate() - parseInt(days));
                        endDate = today;
                }
                
                // Update date inputs
                document.getElementById("fromDate").value = formatDateForParam(startDate);
                document.getElementById("toDate").value = formatDateForParam(endDate);
                
                // Reload page with new parameters
                reloadWithParams(optionText, formatDateForParam(startDate), formatDateForParam(endDate));
            }
        });
    });

    // Apply custom range
    const applyButton = document.getElementById("applyCustomRange");
    if (applyButton) {
        applyButton.addEventListener("click", function() {
            const from = document.getElementById("fromDate").value;
            const to = document.getElementById("toDate").value;
            
            if (from && to) {
                // For custom range, use "Custom Range" as the option text
                const optionText = "Custom Range";
                
                // Update the display text
                const selectedTextElement = document.getElementById("selected-text");
                if (selectedTextElement) {
                    selectedTextElement.textContent = optionText;
                }
                
                // Reload page with new parameters
                reloadWithParams(optionText, from, to);
            } else {
                alert('Please select both start and end dates');
            }
        });
    }
    
    // Helper functions
    function formatDateForParam(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    
    function reloadWithParams(period, startDate, endDate) {
        // Get current URL and params
        const url = new URL(window.location.href);
        
        // Update or add parameters
        url.searchParams.set('period', period);
        url.searchParams.set('startdate', startDate);
        url.searchParams.set('enddate', endDate);
        
        // Keep the teacherid parameter if it exists
        const teacherId = url.searchParams.get('teacherid');
        if (teacherId) {
            url.searchParams.set('teacherid', teacherId);
        }
        
        // Navigate to the updated URL
        window.location.href = url.toString();
    }
});

// Set up jQuery event handlers for the popup
function setupPopupEvents() {
    // Handle remove sessions functionality
    jQuery(document).off('click', '.remove-sessions-btn').on('click', '.remove-sessions-btn', function() {
        // Show checkboxes for removal
        jQuery('.remove-checkbox').show();
        jQuery('.restore-checkbox').hide();
        
        // Show/hide appropriate buttons
        jQuery('.select-all-btn').show();
        jQuery('.cancel-remove-btn').show();
        jQuery('.remove-sessions-btn').hide();
    });

    jQuery(document).off('click', '.cancel-remove-btn').on('click', '.cancel-remove-btn', function() {
        // Hide all checkboxes
        jQuery('.session-checkbox').hide();
        
        // Show/hide appropriate buttons
        jQuery('.select-all-btn').hide();
        jQuery('.cancel-remove-btn').hide();
        jQuery('.remove-sessions-btn').show();
    });

    jQuery(document).off('click', '.select-all-btn').on('click', '.select-all-btn', function() {
        // Toggle all checkboxes
        var allChecked = jQuery('.remove-checkbox:visible:not(:checked)').length > 0;
        jQuery('.remove-checkbox:visible').prop('checked', allChecked);
    });

    jQuery(document).off('click', '.hours-save').on('click', '.hours-save', function() {
        var teacherid = jQuery(this).data('teacherid');
        var date = jQuery(this).data('date');
        
        // Get all checked remove session checkboxes
        var removedSessions = [];
        var removedSessionData = {};
        
        jQuery('.remove-checkbox:checked').each(function() {
            var sessionId = jQuery(this).val();
            removedSessions.push(sessionId);
            
            // Get session data from the table row
            var row = jQuery(this).closest('tr');
            removedSessionData[sessionId] = {
                duration: parseInt(row.find('td:eq(2)').text().replace(' min', '')),
                attendance: parseInt(row.find('td:eq(3)').text().split('/')[0]),
                student_count: parseInt(row.find('td:eq(3)').text().split('/')[1]),
                payable: row.find('td:eq(4)').text(),
                amount: row.find('td:eq(5)').text().replace('$ ', '').trim()
            };
        });
        
        // Get all checked restore session checkboxes
        jQuery('.restore-checkbox:checked').each(function() {
            var sessionId = jQuery(this).val();
            
            // Remove this session from the removed sessions array if it exists
            var index = removedSessions.indexOf(sessionId);
            if (index !== -1) {
                removedSessions.splice(index, 1);
                delete removedSessionData[sessionId];
            }
        });
        
        // Add existing removed sessions that weren't restored (with their stored data)
        jQuery('.restore-checkbox').each(function() {
            if (!jQuery(this).is(':checked')) {
                var sessionId = jQuery(this).val();
                if (removedSessions.indexOf(sessionId) === -1) {
                    removedSessions.push(sessionId);
                    
                    // Get session data from the table row
                    var row = jQuery(this).closest('tr');
                    removedSessionData[sessionId] = {
                        duration: parseInt(row.find('td:eq(2)').text().replace(' min', '')),
                        attendance: parseInt(row.find('td:eq(3)').text().split('/')[0]),
                        student_count: parseInt(row.find('td:eq(3)').text().split('/')[1]),
                        payable: row.find('td:eq(4)').text(),
                        amount: row.find('td:eq(5)').text().replace('$ ', '').trim()
                    };
                }
            }
        });
        
        // Send AJAX request to save removed sessions
        jQuery.ajax({
            url: M.cfg.wwwroot + '/local/teachertimecard/ajax_popup.php',
            type: 'POST',
            data: {
                save_removed: 1,
                teacherid: teacherid,
                date: date,
                removed_sessions: JSON.stringify(removedSessions),
                removed_session_data: JSON.stringify(removedSessionData)
            },
            success: function(response) {
                try {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert('Changes saved successfully');
                        // Close the popup
                        jQuery('.edit-popup-container').hide();
                        jQuery('.overlay').hide();
                        // Refresh the page
                        location.reload();
                    } else {
                        alert('Error saving changes: ' + (data.error || 'Unknown error'));
                    }
                } catch (e) {
                    alert('Error parsing response: ' + e);
                    console.error('Response:', response);
                }
            },
            error: function(xhr, status, error) {
                alert('Error saving changes: ' + error);
                console.error('AJAX Error:', status, error);
            }
        });
    });
    
    // Close popup handlers
    jQuery(document).off('click', '.close-edit-popup, .hours-cancel').on('click', '.close-edit-popup, .hours-cancel', function() {
        jQuery('.edit-popup-container').hide();
        jQuery('.overlay').hide();
    });
    
    // Initialize both modal systems after popup is loaded
    initGeneralNotesInPopup();
    initManualTimeModal();
}

function showLoadingPopup() {
    // Create or show a loading popup
    let loadingPopup = document.getElementById('loading-popup');
    if (!loadingPopup) {
        loadingPopup = document.createElement('div');
        loadingPopup.id = 'loading-popup';
        loadingPopup.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 5px; z-index: 10001; box-shadow: 0 2px 10px rgba(0,0,0,0.2);';
        loadingPopup.innerHTML = '<p>Loading...</p>';
        document.body.appendChild(loadingPopup);
    }
    loadingPopup.style.display = 'block';
}

function fetchEditData(date, teacherId) {
    // Make AJAX request to get edit data
    const formData = new FormData();
    formData.append('date', date);
    formData.append('teacherid', teacherId);
    
    fetch(M.cfg.wwwroot + '/local/teachertimecard/ajax_popup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showEditPopup(data.html);
        } else if (data.error) {
            alert('Error: ' + data.error);
        } else {
            alert('Unknown error occurred');
        }
    })
    .catch(error => {
        alert('Request failed: ' + error);
    })
    .finally(() => {
        // Hide loading popup
        const loadingPopup = document.getElementById('loading-popup');
        if (loadingPopup) {
            loadingPopup.style.display = 'none';
        }
    });
}

function showEditPopup(htmlContent) {
    // Create or update edit popup
    let editPopup = document.getElementById('edit-popup-container');
    if (!editPopup) {
        editPopup = document.createElement('div');
        editPopup.id = 'edit-popup-container';
        editPopup.className = 'edit-popup-container';
        document.body.appendChild(editPopup);
    }
    
    // Populate with HTML content from AJAX
    editPopup.innerHTML = htmlContent;
    
    // Show popup and overlay
    editPopup.style.display = 'block';
    document.querySelector('.overlay').style.display = 'block';
    
    // Set up jQuery event handlers for the new content
    if (typeof jQuery !== 'undefined') {
        setupPopupEvents();
    }
    
    // Add vanilla JS event listeners for close buttons
    const closeButton = editPopup.querySelector('.close-edit-popup');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            editPopup.style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        });
    }
    
    const cancelButton = editPopup.querySelector('.hours-cancel');
    if (cancelButton) {
        cancelButton.addEventListener('click', function() {
            editPopup.style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        });
    }
}

function hideOverlay() {
    const overlay = document.querySelector('.overlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// General Notes Modal System
function initGeneralNotesInPopup() {
    function ensureGlobalNotesModal() {
        var $modal = jQuery('#generalNotesAddForm');
        if ($modal.length && !$modal.parent().is('body')) {
            $modal.appendTo('body');
        }
        $modal.css({
            position: 'fixed',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            zIndex: 1100,
            display: 'none'
        });
    }

    function showNotesBackdrop() {
        if (!jQuery('#generalNotesBackdrop').length) {
            jQuery('<div id="generalNotesBackdrop" class="modal-backdrop"></div>')
                .appendTo('body')
                .css({
                    position: 'fixed',
                    inset: 0,
                    background: 'rgba(18,17,23,0.45)',
                    zIndex: 1095,
                    display: 'none'
                })
                .fadeIn(150);
        }
    }

    function hideNotesBackdrop() {
        jQuery('#generalNotesBackdrop').fadeOut(150, function () {
            jQuery(this).remove();
        });
    }

    // Call once on init to prepare modal
    ensureGlobalNotesModal();

    // Add note button (OPEN)
    jQuery(document)
        .off('click', '.add-general-note-btn')
        .on('click', '.add-general-note-btn', function () {
            ensureGlobalNotesModal();
            showNotesBackdrop();
            jQuery('#generalNotesAddForm').fadeIn(150);
        });

    // Close add note form (CLOSE)
    jQuery(document)
        .off('click', '#closeAddNoteForm, .btn-cancel-note, #generalNotesBackdrop')
        .on('click', '#closeAddNoteForm, .btn-cancel-note, #generalNotesBackdrop', function () {
            jQuery('#generalNotesAddForm').fadeOut(150);
            hideNotesBackdrop();
            jQuery('#generalNoteInput').val('');
        });

    // Submit note
    jQuery(document)
        .off('click', '.btn-submit-note')
        .on('click', '.btn-submit-note', function () {
            const noteContent = jQuery('#generalNoteInput').val().trim();
            const teacherId = jQuery(this).data('teacherid');
            const date = jQuery(this).data('date');

            if (!noteContent) {
                alert('Please enter a note before submitting.');
                return;
            }

            // Send AJAX request to save note
            jQuery.ajax({
                url: M.cfg.wwwroot + '/local/teachertimecard/ajax_notes.php',
                type: 'POST',
                data: {
                    action: 'save_note',
                    teacherid: teacherId,
                    date: date,
                    note: noteContent
                },
                success: function (response) {
                    try {
                        const data = JSON.parse(response);
                        if (data.success) {
                            alert('Note submitted successfully!');
                            jQuery('#generalNotesAddForm').fadeOut(150);
                            hideNotesBackdrop();
                            jQuery('#generalNoteInput').val('');
                            // Refresh notes list
                            loadGeneralNotes(teacherId, date);
                        } else {
                            alert('Error: ' + data.message);
                        }
                    } catch (e) {
                        alert('Error parsing response: ' + e);
                    }
                },
                error: function (xhr, status, error) {
                    alert('Error saving note: ' + error);
                }
            });
        });

    // Remove notes button
    jQuery(document)
        .off('click', '.remove-general-note-btn')
        .on('click', '.remove-general-note-btn', function () {
            const notesList = jQuery('#generalNotesList');
            const isRemoveMode = notesList.hasClass('remove-mode');

            if (isRemoveMode) {
                removeSelectedNotes();
            } else {
                notesList.addClass('remove-mode');
                notesList.find('.note-checkbox').show();
                jQuery(this).text('Remove Selected');
            }
        });

    // Load general notes
    function loadGeneralNotes(teacherId, date) {
        jQuery.ajax({
            url: M.cfg.wwwroot + '/local/teachertimecard/ajax_notes.php',
            type: 'POST',
            data: {
                action: 'get_notes',
                teacherid: teacherId,
                startdate: date,
                enddate: date
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        jQuery('#generalNotesList').html(data.html);
                    } else {
                        console.error('Error loading notes:', data.message);
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading notes:', error);
            }
        });
    }

    function exitRemoveMode() {
        jQuery('#generalNotesList').removeClass('remove-mode');
        jQuery('#generalNotesList .note-checkbox').hide().prop('checked', false);
        jQuery('.remove-general-note-btn').text('Remove');
    }

    function removeSelectedNotes() {
        const checkedNotes = jQuery('#generalNotesList .note-checkbox:checked');
        if (checkedNotes.length === 0) {
            alert('Please select at least one note to remove.');
            return;
        }

        const noteIds = checkedNotes.map(function () {
            return jQuery(this).closest('.general-notes-item').data('noteid');
        }).get();

        jQuery.ajax({
            url: M.cfg.wwwroot + '/local/teachertimecard/ajax_notes.php',
            type: 'POST',
            data: {
                action: 'delete_notes',
                note_ids: JSON.stringify(noteIds)
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        alert('Notes removed successfully!');
                        exitRemoveMode();
                        const teacherId = jQuery('.hours-save').data('teacherid');
                        const date = jQuery('.hours-save').data('date');
                        loadGeneralNotes(teacherId, date);
                    } else {
                        alert('Error: ' + data.message);
                    }
                } catch (e) {
                    alert('Error parsing response: ' + e);
                }
            },
            error: function (xhr, status, error) {
                alert('Error removing notes: ' + error);
            }
        });
    }
}

// Manual Time Modal System
// Manual Time Modal System
function initManualTimeModal() {
    // Data
    const add_manual_time_for_step1_students = [{
            id: 1,
            name: 'Edwards',
            initials: 'E',
            avatar: 'https://i.pravatar.cc/96?u=edwards@latingles'
        },
        {
            id: 2,
            name: 'Daniela',
            initials: 'D',
            avatar: 'https://i.pravatar.cc/96?u=daniela@latingles'
        },
        {
            id: 3,
            name: 'Hawkins',
            initials: 'H',
            avatar: 'https://i.pravatar.cc/96?u=hawkins@latingles'
        },
        {
            id: 4,
            name: 'Lane',
            initials: 'L',
            avatar: 'https://i.pravatar.cc/96?u=lane@latingles'
        },
        {
            id: 5,
            name: 'Warren',
            initials: 'W',
            avatar: 'https://i.pravatar.cc/96?u=warren@latingles'
        },
        {
            id: 6,
            name: 'Fox',
            initials: 'F',
            avatar: 'https://i.pravatar.cc/96?u=fox@latingles'
        },
        {
            id: 7,
            name: 'Jonas',
            initials: 'J',
            avatar: 'https://i.pravatar.cc/96?u=jonas@latingles'
        },
        {
            id: 8,
            name: 'Mary',
            initials: 'M',
            avatar: 'https://i.pravatar.cc/96?u=mary@latingles'
        },
    ];

    const add_manual_time_for_step1_groups = [{
            id: 'FL-1-030423-0090'
        },
        {
            id: 'OH-12-032023-0089'
        },
        {
            id: 'NY-2-042522-0088'
        },
        {
            id: 'OH-12-032023-0089'
        },
        {
            id: 'TX-1-030423-0090'
        },
        {
            id: 'CA-3-060123-0012'
        },
        {
            id: 'WA-5-021523-0042'
        },
        {
            id: 'AK-2-040423-0123'
        }
    ];

    // State
    let add_manual_time_for_step1_selected = null;
    let add_manual_time_for_step1_stage = 1;
    let add_manual_time_for_step1_student_value = null;
    let add_manual_time_for_step1_group_value = null;

    function ensureGlobalManualTimeModal() {
        var $modal = jQuery('#add_manual_time_for_step1_modal');
        if ($modal.length && !$modal.parent().is('body')) {
            $modal.appendTo('body');
        }
        $modal.css({
            position: 'fixed',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            zIndex: 1100,
            display: 'none'
        });
    }

    function showManualTimeBackdrop() {
        if (!jQuery('#manualTimeBackdrop').length) {
            jQuery('<div id="manualTimeBackdrop" class="modal-backdrop"></div>')
                .appendTo('body')
                .css({
                    position: 'fixed',
                    inset: 0,
                    background: 'rgba(18,17,23,0.45)',
                    zIndex: 1095,
                    display: 'none'
                })
                .fadeIn(150);
        }
    }

    function hideManualTimeBackdrop() {
        jQuery('#manualTimeBackdrop').fadeOut(150, function () {
            jQuery(this).remove();
        });
    }

    // Modal open/close
    function add_manual_time_for_step1_open() {
        ensureGlobalManualTimeModal();
        showManualTimeBackdrop();
        jQuery('#add_manual_time_for_step1_modal').css('display', 'flex').attr('aria-hidden', 'false');
        jQuery('body').addClass('add_manual_time_for_step1_lock');
        add_manual_time_for_step1_goToStep(1, true);
    }

    function add_manual_time_for_step1_close() {
        jQuery('#add_manual_time_for_step1_modal').fadeOut(120, function() {
            jQuery(this).attr('aria-hidden', 'true').hide();
        });
        jQuery('body').removeClass('add_manual_time_for_step1_lock');
        hideManualTimeBackdrop();
        // Reset form when closing
        add_manual_time_for_step1_resetForm();
    }

    // Reset form completely
    function add_manual_time_for_step1_resetForm() {
        add_manual_time_for_step1_selected = null;
        add_manual_time_for_step1_stage = 1;
        add_manual_time_for_step1_student_value = null;
        add_manual_time_for_step1_group_value = null;
        
        // Reset UI to step 1
        jQuery('#add_manual_time_for_step1_step1').addClass('is-active');
        jQuery('#add_manual_time_for_step1_step2').removeClass('is-active');
        jQuery('#add_manual_time_for_step1_title_txt').text('Add Manual Time for');
        jQuery('#add_manual_time_for_step1_primary_btn').text('Continue').prop('disabled', true)
            .removeClass('add_manual_time_for_step1_submit').addClass('add_manual_time_for_step1_continue');
        jQuery('#add_manual_time_for_step1_card').removeClass('add_manual_time_for_step1_is_step2');
        
        // Clear all selections
        jQuery('.add_manual_time_for_step1_option').removeClass('add_manual_time_for_step1_selected').attr('aria-checked', 'false');
        
        // Clear all form fields
        jQuery('#add_manual_time_for_step1_student_fake_label').text('Select student');
        jQuery('#add_manual_time_for_step1_group_fake_label').text('Select cohort');
        jQuery('#add_manual_time_for_step1_duration').val('');
        jQuery('#add_manual_time_for_step1_attendance').val('');
        jQuery('#add_manual_time_for_step1_payable_label').text('Yes');
        jQuery('#add_manual_time_for_step1_amount').val('');
        jQuery('#add_manual_time_for_step1_notes').val('');
        
        // Hide all dropdowns
        add_manual_time_for_step1_closeDropdowns();
    }

    // Step 1 selection
    function add_manual_time_for_step1_select($opt) {
        jQuery('.add_manual_time_for_step1_option').removeClass('add_manual_time_for_step1_selected').attr('aria-checked', 'false');
        $opt.addClass('add_manual_time_for_step1_selected').attr('aria-checked', 'true');
        add_manual_time_for_step1_selected = $opt.data('add_manual_time_for_step1_value');
        jQuery('#add_manual_time_for_step1_primary_btn').prop('disabled', !add_manual_time_for_step1_selected);
    }

    // Step change
    function add_manual_time_for_step1_goToStep(step, resetSelection) {
        add_manual_time_for_step1_stage = step;
        const $card = jQuery('#add_manual_time_for_step1_card');
        
        if (step === 1) {
            jQuery('#add_manual_time_for_step1_step1').addClass('is-active');
            jQuery('#add_manual_time_for_step1_step2').removeClass('is-active');
            jQuery('#add_manual_time_for_step1_title_txt').text('Add Manual Time for');
            jQuery('#add_manual_time_for_step1_primary_btn').text('Continue').prop('disabled', !add_manual_time_for_step1_selected)
                .removeClass('add_manual_time_for_step1_submit').addClass('add_manual_time_for_step1_continue');
            $card.removeClass('add_manual_time_for_step1_is_step2');
            
            if (resetSelection) {
                add_manual_time_for_step1_selected = null;
                jQuery('.add_manual_time_for_step1_option').removeClass('add_manual_time_for_step1_selected').attr('aria-checked', 'false');
                jQuery('#add_manual_time_for_step1_primary_btn').prop('disabled', true);
            }
        } else {
            // Step 2
            jQuery('#add_manual_time_for_step1_step1').removeClass('is-active');
            jQuery('#add_manual_time_for_step1_step2').addClass('is-active');
            jQuery('#add_manual_time_for_step1_title_txt').text('Add Manual Time');
            jQuery('#add_manual_time_for_step1_primary_btn').text('Submit').prop('disabled', false)
                .removeClass('add_manual_time_for_step1_continue').addClass('add_manual_time_for_step1_submit');
            $card.addClass('add_manual_time_for_step1_is_step2');

            // Show proper first field
            if (add_manual_time_for_step1_selected === 'one_to_one') {
                jQuery('#add_manual_time_for_step1_student_field').show();
                jQuery('#add_manual_time_for_step1_group_field').hide();
            } else {
                jQuery('#add_manual_time_for_step1_student_field').hide();
                jQuery('#add_manual_time_for_step1_group_field').show();
            }
        }
        add_manual_time_for_step1_closeDropdowns();
    }

    function add_manual_time_for_step1_closeDropdowns() {
        jQuery('#add_manual_time_for_step1_student_dropdown').hide();
        jQuery('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
        jQuery('#add_manual_time_for_step1_payable_dropdown').hide();
        jQuery('#add_manual_time_for_step1_group_dropdown').hide();
        jQuery('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
    }

    // Student dropdown functions
    function add_manual_time_for_step1_renderStudentList(list) {
        const $list = jQuery('#add_manual_time_for_step1_student_list');
        $list.empty();
        list.forEach(s => {
            const $row = jQuery(`
            <div class="add_manual_time_for_step1_dropdown_item" data-id="${s.id}" data-name="${s.name}">
                <div class="add_manual_time_for_step1_avatar_wrap">
                    <img class="add_manual_time_for_step1_avatar_img" src="${s.avatar}" alt="${s.name}"
                        onerror="this.style.display='none'; this.parentNode.querySelector('.add_manual_time_for_step1_avatar_fallback').style.display='flex';"/>
                    <span class="add_manual_time_for_step1_avatar_fallback">${s.initials}</span>
                </div>
                <div class="add_manual_time_for_step1_name">${s.name}</div>
            </div>`);
            $list.append($row);
        });
    }

    function add_manual_time_for_step1_renderGroupList(list) {
        const $list = jQuery('#add_manual_time_for_step1_group_list');
        $list.empty();
        list.forEach(g => {
            const $row = jQuery(`<div class="add_manual_time_for_step1_dropdown_item" data-id="${g.id}"><div class="add_manual_time_for_step1_name">${g.id}</div></div>`);
            $list.append($row);
        });
    }

    function add_manual_time_for_step1_toggleStudentDropdown(forceOpen) {
        const $dd = jQuery('#add_manual_time_for_step1_student_dropdown');
        const isOpen = $dd.is(':visible');
        if (forceOpen === true || !isOpen) {
            add_manual_time_for_step1_closeDropdowns();
            $dd.show();
            jQuery('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'true');
            jQuery('#add_manual_time_for_step1_student_search').val('').trigger('input').focus();
        } else {
            $dd.hide();
            jQuery('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
        }
    }

    function add_manual_time_for_step1_toggleGroupDropdown(forceOpen) {
        const $dd = jQuery('#add_manual_time_for_step1_group_dropdown');
        const isOpen = $dd.is(':visible');
        if (forceOpen === true || !isOpen) {
            add_manual_time_for_step1_closeDropdowns();
            $dd.show();
            jQuery('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'true');
            jQuery('#add_manual_time_for_step1_group_search').val('').trigger('input').focus();
        } else {
            $dd.hide();
            jQuery('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
        }
    }

    // Initialize the lists
    add_manual_time_for_step1_renderStudentList(add_manual_time_for_step1_students);
    add_manual_time_for_step1_renderGroupList(add_manual_time_for_step1_groups);

    // Event bindings
    jQuery(document)
        .off('click', '#add_manual_time_for_step1_open_btn')
        .on('click', '#add_manual_time_for_step1_open_btn', function () {
            add_manual_time_for_step1_open();
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_close_btn, #manualTimeBackdrop')
        .on('click', '#add_manual_time_for_step1_close_btn, #manualTimeBackdrop', function () {
            add_manual_time_for_step1_close();
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_modal')
        .on('click', '#add_manual_time_for_step1_modal', function (e) {
            if (e.target === this) add_manual_time_for_step1_close();
        });

    jQuery(document)
        .off('keydown')
        .on('keydown', function (e) {
            if (jQuery('#add_manual_time_for_step1_modal').is(':visible') && e.key === 'Escape') {
                add_manual_time_for_step1_close();
            }
        });

    jQuery(document)
        .off('click', '.add_manual_time_for_step1_option')
        .on('click', '.add_manual_time_for_step1_option', function () {
            add_manual_time_for_step1_select(jQuery(this));
        });

    jQuery(document)
        .off('keydown', '.add_manual_time_for_step1_option')
        .on('keydown', '.add_manual_time_for_step1_option', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                add_manual_time_for_step1_select(jQuery(this));
            }
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_primary_btn')
        .on('click', '#add_manual_time_for_step1_primary_btn', function () {
            if (add_manual_time_for_step1_stage === 1) {
                // Only proceed to step 2 if we have a selection
                if (add_manual_time_for_step1_selected) {
                    add_manual_time_for_step1_goToStep(2, false);
                }
            } else {
                // Step 2 - Submit the form
                const payload = {
                    type: add_manual_time_for_step1_selected,
                    student: add_manual_time_for_step1_student_value,
                    group: add_manual_time_for_step1_group_value,
                    duration: jQuery('#add_manual_time_for_step1_duration').val(),
                    attendance: jQuery('#add_manual_time_for_step1_attendance').val(),
                    payable: jQuery('#add_manual_time_for_step1_payable_label').text(),
                    amount: jQuery('#add_manual_time_for_step1_amount').val(),
                    notes: jQuery('#add_manual_time_for_step1_notes').val()
                };
                console.log('Submit payload:', payload);
                alert('Manual time submitted successfully!');
                add_manual_time_for_step1_close();
            }
        });

    jQuery(document)
        .off('input', '#add_manual_time_for_step1_student_search')
        .on('input', '#add_manual_time_for_step1_student_search', function () {
            const q = jQuery(this).val().toLowerCase();
            const filtered = add_manual_time_for_step1_students.filter(s => s.name.toLowerCase().includes(q));
            add_manual_time_for_step1_renderStudentList(filtered);
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_student_fake')
        .on('click', '#add_manual_time_for_step1_student_fake', function () {
            add_manual_time_for_step1_toggleStudentDropdown();
        });

    jQuery(document)
        .off('keydown', '#add_manual_time_for_step1_student_fake')
        .on('keydown', '#add_manual_time_for_step1_student_fake', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                add_manual_time_for_step1_toggleStudentDropdown(true);
            }
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_student_list .add_manual_time_for_step1_dropdown_item')
        .on('click', '#add_manual_time_for_step1_student_list .add_manual_time_for_step1_dropdown_item', function () {
            const id = jQuery(this).data('id');
            const name = jQuery(this).data('name');
            add_manual_time_for_step1_student_value = id;
            jQuery('#add_manual_time_for_step1_student_fake_label').text(name);
            jQuery('#add_manual_time_for_step1_student_dropdown').hide();
            jQuery('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
        });

    jQuery(document)
        .off('input', '#add_manual_time_for_step1_group_search')
        .on('input', '#add_manual_time_for_step1_group_search', function () {
            const q = jQuery(this).val().toLowerCase();
            const filtered = add_manual_time_for_step1_groups.filter(g => g.id.toLowerCase().includes(q));
            add_manual_time_for_step1_renderGroupList(filtered);
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_group_fake')
        .on('click', '#add_manual_time_for_step1_group_fake', function () {
            add_manual_time_for_step1_toggleGroupDropdown();
        });

    jQuery(document)
        .off('keydown', '#add_manual_time_for_step1_group_fake')
        .on('keydown', '#add_manual_time_for_step1_group_fake', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                add_manual_time_for_step1_toggleGroupDropdown(true);
            }
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_group_list .add_manual_time_for_step1_dropdown_item')
        .on('click', '#add_manual_time_for_step1_group_list .add_manual_time_for_step1_dropdown_item', function () {
            const id = jQuery(this).data('id');
            add_manual_time_for_step1_group_value = id;
            jQuery('#add_manual_time_for_step1_group_fake_label').text(id);
            jQuery('#add_manual_time_for_step1_group_dropdown').hide();
            jQuery('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
        });

    jQuery(document)
        .off('mousedown', '#add_manual_time_for_step1_modal')
        .on('mousedown', '#add_manual_time_for_step1_modal', function (e) {
            const $sWrap = jQuery('#add_manual_time_for_step1_student_wrap');
            const $pWrap = jQuery('#add_manual_time_for_step1_payable_fake').parent();
            const $gWrap = jQuery('#add_manual_time_for_step1_group_wrap');
            if (!$sWrap.is(e.target) && $sWrap.has(e.target).length === 0) {
                jQuery('#add_manual_time_for_step1_student_dropdown').hide();
                jQuery('#add_manual_time_for_step1_student_fake').attr('aria-expanded', 'false');
            }
            if (!$pWrap.is(e.target) && $pWrap.has(e.target).length === 0) {
                jQuery('#add_manual_time_for_step1_payable_dropdown').hide();
            }
            if (!$gWrap.is(e.target) && $gWrap.has(e.target).length === 0) {
                jQuery('#add_manual_time_for_step1_group_dropdown').hide();
                jQuery('#add_manual_time_for_step1_group_fake').attr('aria-expanded', 'false');
            }
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_payable_fake')
        .on('click', '#add_manual_time_for_step1_payable_fake', function () {
            const $dd = jQuery('#add_manual_time_for_step1_payable_dropdown');
            if ($dd.is(':visible')) $dd.hide();
            else {
                add_manual_time_for_step1_closeDropdowns();
                $dd.show();
            }
        });

    jQuery(document)
        .off('click', '#add_manual_time_for_step1_payable_list .add_manual_time_for_step1_dropdown_item')
        .on('click', '#add_manual_time_for_step1_payable_list .add_manual_time_for_step1_dropdown_item', function () {
            jQuery('#add_manual_time_for_step1_payable_label').text(jQuery(this).data('value'));
            jQuery('#add_manual_time_for_step1_payable_dropdown').hide();
        });
}

// teacher_time_card_filters.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing Teacher Time Card Filters...');
    
    // Filter state
    const filterState = {
        groupHours: true,
        oneOnOne: true
    };
    
    // Get DOM elements
    const filterBtn = document.getElementById('ttc_filter_btn');
    const filterMenu = document.getElementById('ttc_filter_menu');
    const filterCheckboxes = document.querySelectorAll('.ttc-check');
    
    if (!filterBtn || !filterMenu) {
        console.error('Filter elements not found');
        return;
    }
    
    console.log('Filter elements found, setting up event listeners...');
    
    // Toggle filter menu
    filterBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isExpanded = filterBtn.getAttribute('aria-expanded') === 'true';
        
        if (isExpanded) {
            closeFilterMenu();
        } else {
            openFilterMenu();
        }
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!filterMenu.contains(e.target) && e.target !== filterBtn) {
            closeFilterMenu();
        }
    });
    
    // Prevent menu from closing when clicking inside
    filterMenu.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Handle checkbox changes
    filterCheckboxes.forEach((checkbox, index) => {
        checkbox.addEventListener('change', function() {
            handleFilterChange(index, this.checked);
        });
    });
    
    function openFilterMenu() {
        filterMenu.style.display = 'block';
        filterBtn.setAttribute('aria-expanded', 'true');
        console.log('Filter menu opened');
    }
    
    function closeFilterMenu() {
        filterMenu.style.display = 'none';
        filterBtn.setAttribute('aria-expanded', 'false');
        console.log('Filter menu closed');
    }
    
    function handleFilterChange(index, isChecked) {
        console.log(`Filter change: index ${index}, checked: ${isChecked}`);
        
        switch(index) {
            case 0: // "Both" checkbox
                if (isChecked) {
                    // Enable both filters
                    filterState.groupHours = true;
                    filterState.oneOnOne = true;
                    filterCheckboxes[1].checked = true;
                    filterCheckboxes[2].checked = true;
                } else {
                    // Disable both filters
                    filterState.groupHours = false;
                    filterState.oneOnOne = false;
                    filterCheckboxes[1].checked = false;
                    filterCheckboxes[2].checked = false;
                }
                break;
                
            case 1: // "Group hours" checkbox
                filterState.groupHours = isChecked;
                updateBothCheckbox();
                break;
                
            case 2: // "1:1 Sessions" checkbox
                filterState.oneOnOne = isChecked;
                updateBothCheckbox();
                break;
        }
        
        applyFilters();
        updateFilterButtonState();
    }
    
    function updateBothCheckbox() {
        // Update "Both" checkbox based on individual states
        const bothChecked = filterState.groupHours && filterState.oneOnOne;
        filterCheckboxes[0].checked = bothChecked;
    }
    
    function applyFilters() {
        console.log('Applying filters:', filterState);
        filterTimecardTable();
        filterTimelineTable();
        updateStatistics();
    }
    
    function filterTimecardTable() {
        const rows = document.querySelectorAll('#timecard-body tr');
        let totalVisibleSessions = 0;
        
        console.log(`Filtering ${rows.length} timecard rows...`);
        
        rows.forEach((row, rowIndex) => {
            // Skip if it's a no-results message row
            if (row.classList.contains('no-results-message')) {
                return;
            }
            
            const visibleSessionsInRow = filterTimecardSessionsInRow(row);
            totalVisibleSessions += visibleSessionsInRow;
            
            // Show/hide entire row based on whether it has any visible sessions
            if (visibleSessionsInRow > 0) {
                row.style.display = '';
                console.log(`Timecard Row ${rowIndex}: SHOW (${visibleSessionsInRow} sessions visible)`);
            } else {
                row.style.display = 'none';
                console.log(`Timecard Row ${rowIndex}: HIDE (no visible sessions)`);
            }
        });
        
        showNoResultsMessage(totalVisibleSessions, 'timecard');
        console.log(`Timecard filtering complete. ${totalVisibleSessions} total sessions visible.`);
    }
    
    function filterTimelineTable() {
        const rows = document.querySelectorAll('#timeline-body tr');
        let totalVisibleSessions = 0;
        
        console.log(`Filtering ${rows.length} timeline rows...`);
        
        rows.forEach((row, rowIndex) => {
            // Skip if it's a no-results message row
            if (row.classList.contains('no-results-message')) {
                return;
            }
            
            const visibleSessionsInRow = filterTimelineSessionsInRow(row);
            totalVisibleSessions += visibleSessionsInRow;
            
            // Show/hide entire row based on whether it has any visible sessions
            if (visibleSessionsInRow > 0) {
                row.style.display = '';
                console.log(`Timeline Row ${rowIndex}: SHOW (${visibleSessionsInRow} sessions visible)`);
            } else {
                row.style.display = 'none';
                console.log(`Timeline Row ${rowIndex}: HIDE (no visible sessions)`);
            }
        });
        
        showNoResultsMessage(totalVisibleSessions, 'timeline');
        console.log(`Timeline filtering complete. ${totalVisibleSessions} total sessions visible.`);
    }
    
    function filterTimecardSessionsInRow(row) {
        // Get all session dots from both practice and main cells
        const practiceCell = row.querySelector('.practice-cell');
        const mainCell = row.querySelector('.main-cell');
        let visibleSessionCount = 0;
        
        // Filter sessions in practice cell
        if (practiceCell) {
            const sessionContainers = practiceCell.querySelectorAll('.session-dot-container');
            sessionContainers.forEach(container => {
                const sessionDot = container.querySelector('.session-dot');
                if (sessionDot && shouldShowSession(sessionDot)) {
                    container.style.display = '';
                    visibleSessionCount++;
                } else {
                    container.style.display = 'none';
                }
            });
        }
        
        // Filter sessions in main cell
        if (mainCell) {
            const sessionContainers = mainCell.querySelectorAll('.session-dot-container');
            sessionContainers.forEach(container => {
                const sessionDot = container.querySelector('.session-dot');
                if (sessionDot && shouldShowSession(sessionDot)) {
                    container.style.display = '';
                    visibleSessionCount++;
                } else {
                    container.style.display = 'none';
                }
            });
        }
        
        return visibleSessionCount;
    }
    
    function filterTimelineSessionsInRow(row) {
        // Get all session progress elements from timeline
        const timelineCell = row.querySelector('.timeline-content-cell');
        let visibleSessionCount = 0;
        
        if (timelineCell) {
            const sessionProgressElements = timelineCell.querySelectorAll('.session-progress');
            sessionProgressElements.forEach(session => {
                if (shouldShowSession(session)) {
                    session.style.display = '';
                    visibleSessionCount++;
                } else {
                    session.style.display = 'none';
                }
            });
        }
        
        return visibleSessionCount;
    }
    
    function shouldShowSession(sessionElement) {
        const isGroup = isGroupSession(sessionElement);
        const isOneOnOne = isOneOnOneSession(sessionElement);
        
        console.log('Session analysis:', {
            content: sessionElement.innerHTML,
            isGroup,
            isOneOnOne
        });
        
        // Show session if it matches active filters
        if (isGroup && filterState.groupHours) return true;
        if (isOneOnOne && filterState.oneOnOne) return true;
        
        return false;
    }
    
    function isGroupSession(sessionElement) {
        // Group sessions have text codes like AK3, KY4, TX4, etc.
        // Check if the element contains only text (no images) and the text matches session code pattern
        const hasImage = sessionElement.querySelector('img') !== null;
        const textContent = sessionElement.textContent.trim();
        
        // Session code pattern: 2-4 uppercase letters followed by optional numbers
        const isSessionCode = /^[A-Z]{2,4}\d*$/.test(textContent);
        
        // It's a group session if it has a session code and no image
        return isSessionCode && !hasImage;
    }
    
    function isOneOnOneSession(sessionElement) {
        // 1:1 sessions have user avatar images
        const hasImage = sessionElement.querySelector('img') !== null;
        
        // Also check if it's an image session (user avatar)
        if (hasImage) {
            return true;
        }
        
        // Additional check: if it doesn't have a session code pattern, it might be 1:1
        const textContent = sessionElement.textContent.trim();
        const isSessionCode = /^[A-Z]{2,4}\d*$/.test(textContent);
        
        // If it has no session code and no image, we don't know what it is - default to showing it
        return !isSessionCode && textContent.length === 0;
    }
    
    function showNoResultsMessage(totalVisibleSessions, tableType) {
        const tbody = tableType === 'timecard' ? 
            document.getElementById('timecard-body') : 
            document.getElementById('timeline-body');
        
        if (!tbody) return;
        
        let message = tbody.querySelector('.no-results-message');
        
        if (totalVisibleSessions === 0) {
            if (!message) {
                message = document.createElement('tr');
                message.className = 'no-results-message';
                const colspan = tableType === 'timecard' ? 8 : 3;
                message.innerHTML = `
                    <td colspan="${colspan}" style="text-align: center; padding: 40px; color: #6c757d;">
                        <div>
                            <h4>No sessions match your current filters</h4>
                            <p>Try adjusting your filter criteria.</p>
                        </div>
                    </td>
                `;
                tbody.appendChild(message);
            }
        } else if (message) {
            message.remove();
        }
    }
    
    function updateStatistics() {
        // Update statistics based on visible sessions across both tables
        const timecardSessions = document.querySelectorAll('#timecard-body .session-dot:not([style*="display: none"])');
        const timelineSessions = document.querySelectorAll('#timeline-body .session-progress:not([style*="display: none"])');
        
        const totalVisibleSessions = timecardSessions.length + timelineSessions.length;
        
        // For now, we'll count each visible session as 1 hour (adjust based on your actual duration logic)
        const totalHours = totalVisibleSessions;
        
        // Update the display - you might need to adjust this based on your actual hour calculation
        updateStatElement('#total-hours strong', totalHours);
        updateStatElement('#taught-hours strong', totalHours); // Adjust as needed
        updateStatElement('#missed-hours strong', 0); // Adjust as needed
        
        console.log('Statistics updated. Total visible sessions:', totalVisibleSessions);
    }
    
    function updateStatElement(selector, value) {
        const element = document.querySelector(selector);
        if (element) {
            element.textContent = value + ':00';
        }
    }
    
    function updateFilterButtonState() {
        // Add active class to filter button when filters are applied
        const isFiltered = !filterState.groupHours || !filterState.oneOnOne;
        
        if (isFiltered) {
            filterBtn.classList.add('active');
            console.log('Filter button: ACTIVE (filters applied)');
        } else {
            filterBtn.classList.remove('active');
            console.log('Filter button: INACTIVE (no filters)');
        }
    }
    
    // Add CSS styles
    const style = document.createElement('style');
    style.textContent = `
        .ttc-filter-menu {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            min-width: 150px;
        }
        
        #ttc_filter_btn.active {
            background-color: #e3f2fd;
            border-color: #2196f3;
            color: #1976d2;
        }
        
        .ttc-filter-item {
            display: flex;
            align-items: center;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 3px;
            white-space: nowrap;
        }
        
        .ttc-filter-item:hover {
            background-color: #f5f5f5;
        }
        
        .ttc-check {
            margin-right: 8px;
        }
        
        .no-results-message {
            background-color: #f8f9fa;
        }
        
        /* Ensure the filter wrap has relative positioning for dropdown */
        .ttc-filter-wrap {
            position: relative;
            display: inline-block;
        }
        
        /* Style for filtered out session containers */
        .session-dot-container[style*="display: none"] {
            display: none !important;
        }
        
        /* Style for filtered out timeline sessions */
        .session-progress[style*="display: none"] {
            display: none !important;
        }
    `;
    document.head.appendChild(style);
    
    console.log('Teacher Time Card Filters initialized successfully');
    
    // Initial filter application
    applyFilters();
});