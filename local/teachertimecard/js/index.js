document.addEventListener("DOMContentLoaded", function() {
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
    
    // Initialize general notes functionality after popup is loaded
    initGeneralNotesInPopup();
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

// General Notes functionality in popup
function initGeneralNotesInPopup() {
    // Add note button
    jQuery(document).off('click', '.add-general-note-btn').on('click', '.add-general-note-btn', function() {
        jQuery('#generalNotesAddForm').show();
    });
    
    // Close add note form
    jQuery(document).off('click', '#closeAddNoteForm, .btn-cancel-note').on('click', '#closeAddNoteForm, .btn-cancel-note', function() {
        jQuery('#generalNotesAddForm').hide();
        jQuery('#generalNoteInput').val('');
    });
    
    // Submit note
    jQuery(document).off('click', '.btn-submit-note').on('click', '.btn-submit-note', function() {
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
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        alert('Note submitted successfully!');
                        jQuery('#generalNotesAddForm').hide();
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
            error: function(xhr, status, error) {
                alert('Error saving note: ' + error);
            }
        });
    });
    
    // Remove notes button
    jQuery(document).off('click', '.remove-general-note-btn').on('click', '.remove-general-note-btn', function() {
        const notesList = jQuery('#generalNotesList');
        const isRemoveMode = notesList.hasClass('remove-mode');
        
        if (isRemoveMode) {
            // Already in remove mode, remove selected notes
            removeSelectedNotes();
        } else {
            // Enter remove mode
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
            success: function(response) {
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
            error: function(xhr, status, error) {
                console.error('Error loading notes:', error);
            }
        });
    }
    
    // Cancel remove mode
    function exitRemoveMode() {
        jQuery('#generalNotesList').removeClass('remove-mode');
        jQuery('#generalNotesList .note-checkbox').hide().prop('checked', false);
        jQuery('.remove-general-note-btn').text('Remove');
    }
    
    // Remove selected notes
    function removeSelectedNotes() {
        const checkedNotes = jQuery('#generalNotesList .note-checkbox:checked');
        
        if (checkedNotes.length === 0) {
            alert('Please select at least one note to remove.');
            return;
        }
        
        // if (!confirm(`Are you sure you want to remove ${checkedNotes.length} note(s)?`)) {
        //     return;
        // }
        
        const noteIds = checkedNotes.map(function() {
            return jQuery(this).closest('.general-notes-item').data('noteid');
        }).get();
        
        // Send AJAX request to delete notes
        jQuery.ajax({
            url: M.cfg.wwwroot + '/local/teachertimecard/ajax_notes.php',
            type: 'POST',
            data: {
                action: 'delete_notes',
                note_ids: JSON.stringify(noteIds)
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        alert('Notes removed successfully!');
                        exitRemoveMode();
                        // Refresh notes list
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
            error: function(xhr, status, error) {
                alert('Error removing notes: ' + error);
            }
        });
    }
}