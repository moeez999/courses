function openDropdownToBody(wrapperSelector, listSelector) {
  var $wrapper = $(wrapperSelector);
  var $list = $(listSelector);

  // Find position and size
  var offset = $wrapper.offset();
  var width = $wrapper.outerWidth();
  var height = $wrapper.outerHeight();

  // Move the list to body
  $list.appendTo('body').css({
    display: 'block',
    position: 'absolute',
    top: offset.top + height + 4,
    left: offset.left,
    width: width,
    zIndex: 99999
  });
  $wrapper.addClass('custom-dropdown-open');

  // Outside click closes dropdown
  $(document).on('mousedown.dropdown', function(e) {
    if (!$(e.target).closest(listSelector + ', ' + wrapperSelector).length) {
      closeDropdownToBody(wrapperSelector, listSelector);
    }
  });
}

function closeDropdownToBody(wrapperSelector, listSelector) {
  var $wrapper = $(wrapperSelector);
  var $list = $(listSelector);

  $wrapper.removeClass('custom-dropdown-open');
  $list.css({
    display: 'none',
    position: '',
    top: '',
    left: '',
    width: '',
    zIndex: ''
  });
  $list.appendTo($wrapper); // Move back into original wrapper
  $(document).off('mousedown.dropdown');
}

$(function() {
  // --- DROPDOWNS ---

  // Topic dropdown open/close
  $('#topicDropdownSelected').on('click', function(e) {
    if ($('#topicDropdownWrapper').hasClass('custom-dropdown-open')) {
      closeDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
    } else {
      openDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
    }
    e.stopPropagation();
  });

  // Topic item select
  $('#topicDropdownList').on('click', '.dropdown-item', function() {
    $('#topicDropdownText').text($(this).text());
    closeDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
  });

  // Topic create
  $('#createTopicBtn').on('click', function() {
    var val = $('#newTopicInput').val().trim();
    if(val) {
      $('#topicDropdownText').text(val);
      $('#newTopicInput').val('');
      closeDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
    }
  });

  // Assignment dropdown open/close
  $('#assignmentDropdownSelected').on('click', function(e) {
    if ($('#assignmentDropdownWrapper').hasClass('custom-dropdown-open')) {
      closeDropdownToBody('#assignmentDropdownWrapper', '#assignmentDropdownList');
    } else {
      openDropdownToBody('#assignmentDropdownWrapper', '#assignmentDropdownList');
    }
    e.stopPropagation();
  });

  // Accordion logic for Topic dropdown
  $('#topicDropdownList').on('click', '.accordion-toggle', function() {
    var acc = $(this).data('acc');
    $('#topicDropdownList .dropdown-group-label').not(this).parent().removeClass('open');
    $('#topicDropdownList .dropdown-items').not('[data-acc="'+acc+'"]').slideUp(120);
    var $group = $(this).parent();
    var $items = $group.find('.dropdown-items');
    if ($group.hasClass('open')) {
      $group.removeClass('open');
      $items.slideUp(120);
    } else {
      $group.addClass('open');
      $items.slideDown(140);
    }
  });

  // Accordion logic for Assignment dropdown
  $('#assignmentDropdownList').on('click', '.accordion-toggle', function() {
    var acc = $(this).data('acc');
    $('#assignmentDropdownList .dropdown-group-label').not(this).parent().removeClass('open');
    $('#assignmentDropdownList .dropdown-items').not('[data-acc="'+acc+'"]').slideUp(120);
    var $group = $(this).parent();
    var $items = $group.find('.dropdown-items');
    if ($group.hasClass('open')) {
      $group.removeClass('open');
      $items.slideUp(120);
    } else {
      $group.addClass('open');
      $items.slideDown(140);
    }
  });

  // --- MULTI-CHIP LOGIC (NEW) ---
  // Make sure you have: <div id="selectedAssignmentChipList" style="margin-top:10px;"></div> in your HTML

  function addAssignmentChip() {
    var assignment = $('#assignmentDropdownText').text().trim();
    var date = $('#supercal-open-btn').val().trim();

    // Find assignment group label (e.g., "Homework" or "Quiz")
    var $selectedItem = $('#assignmentDropdownList .dropdown-item').filter(function() {
      return $(this).text().trim() === assignment;
    });
    var label = '';
    if ($selectedItem.length) {
      label = $selectedItem.closest('.dropdown-group').find('.dropdown-group-label span').first().text().trim();
    }

    // Only add if both selected and not "Assignment"
    if (assignment !== '' && assignment !== 'Assignment' && date !== '') {
      // Unique key for deduplication (group+assignment+date)
      var key = label + "|" + assignment + "|" + date;

      // Prevent duplicate chips
      var alreadyExists = $('#selectedAssignmentChipList .assignment-chip').filter(function() {
        return $(this).data('chipKey') === key;
      }).length > 0;
      
  if (!alreadyExists) {
        var chipHtml =
          `<div class="custom-chip-bar assignment-chip" data-chip-key="${key}">
              <span class="chip-left">
                <span class="chip-label">${label ? label : ''}</span>
                <span class="chip-assignment"> ${assignment}:</span>
              </span>
              <span class="chip-details">${date}</span>
              <span class="chip-remove" title="Remove">&#10005;</span>
          </div>`;
        $('#selectedAssignmentChipList').append(chipHtml);

      }

    }
  }

  // Remove individual chip (event delegation)
  $(document).on('click', '.chip-remove', function() {
    $(this).closest('.assignment-chip').remove();
  });

  // Assignment dropdown select: (NO CHIP added here! just update text)
  $('#assignmentDropdownList').on('click', '.dropdown-item', function() {
    $('#assignmentDropdownText').text($(this).text());
    closeDropdownToBody('#assignmentDropdownWrapper', '#assignmentDropdownList');
    // No chip added here
  });

  // --- CALENDAR MODAL ---
  let supercalSelectedDate = new Date(2024, 9, 1); // Oct 1, 2024
  let supercalTempDate = new Date(supercalSelectedDate);
  let supercalMonth = supercalTempDate.getMonth();
  let supercalYear = supercalTempDate.getFullYear();

  function supercalFormatDate(d) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    return d.getDate() + " " + months[d.getMonth()] + ", " + d.getFullYear();
  }

  function supercalRenderCalendar(month, year, selDate) {
    $('#supercal-monthyear').text(
      new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' })
    );
    let firstDay = new Date(year, month, 1);
    let lastDay = new Date(year, month+1, 0);
    let daysInMonth = lastDay.getDate();
    let startDay = (firstDay.getDay() + 6) % 7;
    let html = '';
    let dayNum = 1;
    for(let row=0; row<6; row++) {
      for(let col=0; col<7; col++) {
        if(row === 0 && col < startDay) {
          html += `<span class="supercal-date disabled"></span>`;
        } else if(dayNum > daysInMonth) {
          html += `<span class="supercal-date disabled"></span>`;
        } else {
          let isSelected = selDate &&
            dayNum === selDate.getDate() &&
            month === selDate.getMonth() &&
            year === selDate.getFullYear();
          html += `<span class="supercal-date${isSelected ? ' selected' : ''}" data-date="${year}-${month+1}-${dayNum}">${dayNum}</span>`;
          dayNum++;
        }
      }
    }
    $('#supercal-dates').html(html);
  }

  function showSupercalModal() {
    supercalTempDate = new Date(supercalSelectedDate);
    supercalMonth = supercalTempDate.getMonth();
    supercalYear = supercalTempDate.getFullYear();
    supercalRenderCalendar(supercalMonth, supercalYear, supercalTempDate);
    $('#supercal-backdrop').show();
    $('#supercal-modal').show();
  }
  function closeSupercalModal() {
    $('#supercal-backdrop').hide();
    $('#supercal-modal').hide();
  }

  // Open calendar when clicking input field
  $('#supercal-open-btn').on('click', function(e) {
    e.stopPropagation();
    showSupercalModal();
  });

  // Calendar prev/next month
  $('#supercal-prev-month').click(function() {
    supercalMonth--;
    if(supercalMonth < 0) { supercalMonth = 11; supercalYear--; }
    supercalRenderCalendar(supercalMonth, supercalYear, supercalTempDate);
  });
  $('#supercal-next-month').click(function() {
    supercalMonth++;
    if(supercalMonth > 11) { supercalMonth = 0; supercalYear++; }
    supercalRenderCalendar(supercalMonth, supercalYear, supercalTempDate);
  });

  // Date select
  $('#supercal-modal').on('click', '.supercal-date:not(.disabled)', function() {
    $('#supercal-modal .supercal-date').removeClass('selected');
    $(this).addClass('selected');
    let parts = $(this).attr('data-date').split('-');
    supercalTempDate = new Date(parts[0], parts[1]-1, parts[2]);
  });

  // Done: Update input and CHIP, then close (CHIP ONLY ADDED HERE!)
  $('#supercal-done-btn').click(function() {
    supercalSelectedDate = new Date(supercalTempDate);
    $('#supercal-open-btn').val(supercalFormatDate(supercalSelectedDate));
    closeSupercalModal();
    addAssignmentChip();
  });

  // Close modal
  $('#supercal-backdrop, #supercal-close-btn').click(function() {
    closeSupercalModal();
  });

  // Esc key closes
  $(document).on('keydown', function(e) {
    if(e.key === "Escape") closeSupercalModal();
  });

  // Parse date from field if exists on load
  let fieldVal = $('#supercal-open-btn').val();
  if(fieldVal) {
    let match = fieldVal.match(/^(\d+)\s+([A-Za-z]+),\s*(\d{4})$/);
    if(match) {
      let months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
      let m = months.indexOf(match[2]);
      if(m > -1) supercalSelectedDate = new Date(parseInt(match[3]), m, parseInt(match[1]));
    }
  }





  

  // NOTE: If you want to use this dropdown elsewhere, change IDs to classes!

// Show/hide student/group dropdown on note-link click
$('.note-link').on('click', function() {
  // Toggle note-area as before

  // Show/hide the note dropdown
  if($('#noteDropdownWrapper').is(':visible')) {
    $('#noteDropdownWrapper').slideUp(110);
    closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
  } else {
    $('#noteDropdownWrapper').slideDown(140);
  }
});

// Open/close logic for custom dropdown (select field)
$('#noteDropdownSelected').on('click', function(e) {
  if ($('#noteDropdownWrapper').hasClass('custom-dropdown-open')) {
    closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
  } else {
    openDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
    $('#noteDropdownSearch').focus();
  }
  e.stopPropagation();
});

// Item selection
$('#noteDropdownList').on('click', '.dropdown-item', function() {
  var name = $(this).text().trim();
  $('#noteDropdownText').text(name);
  closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
});

// Fuzzy search/filter logic
$('#noteDropdownSearch').on('input', function() {
  var val = $(this).val().toLowerCase();
  $('#noteDropdownItems .dropdown-item').each(function() {
    var txt = $(this).text().toLowerCase();
    $(this).toggle(txt.indexOf(val) !== -1);
  });
});

// Close on outside click (reusing closeDropdownToBody logic)
// Already handled via closeDropdownToBody above




// This will store selected avatar URL and name for the UI
$('#noteDropdownList').on('click', '.dropdown-item', function() {
  // Parse out the avatar and name from dropdown item
  var $item = $(this);
  var avatarSrc = '';
  var name = $item.text().trim();

  // Check if item has image or FL1 (badge)
  var $img = $item.find('img');
  var $badge = $item.find('span.note-avatar');

  if ($img.length) {
    avatarSrc = $img.attr('src');
    $('#noteForAvatar').attr('src', avatarSrc).show();
  } else if ($badge.length) {
    // Render badge as an SVG or fallback img, but for now use a data-uri or blank with initials
    // Here, just set blank src and show the FL1 text in avatar box
    $('#noteForAvatar').attr('src', '').hide(); // Hide for initials only
    $('#noteForAvatar').after('<span id="noteForBadge" class="note-avatar" style="background:#1743e3;margin-left:-39px;margin-top:0;position:relative;z-index:2;">'+$badge.text()+'</span>');
  } else {
    $('#noteForAvatar').attr('src', '').hide();
  }

  $('#noteForName').text(name);
  $('#noteForNameLabel').text(name);

  // Hide dropdown, show note UI
  closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
  $('#noteDropdownWrapper').slideUp(120);
  $('#noteForStudentSection').slideDown(180);

  // Remove any old badge avatars if needed
  $('#noteForAvatar').show();
  $('#noteForBadge').remove();

  // If selected is badge only (no image), swap avatar image for badge text
  if ($img.length === 0 && $badge.length) {
    $('#noteForAvatar').hide();
    $('#noteForBadge').show();
  }
});

// Optional: When you open the note section again, reset the UI
$('.note-link').on('click', function() {
  $('#noteForStudentSection').hide();
  $('#noteForAvatar').attr('src','').show();
  $('#noteForBadge').remove();
  $('#noteTextarea').val('');
});






// Handle note submission (chip add, dropdown reappear)
$('#noteSubmitBtn').on('click', function() {
  var noteText = $('#noteTextarea').val().trim();
  var name = $('#noteForName').text();
  var avatarSrc = $('#noteForAvatar').attr('src');
  var badge = $('#noteForBadge').text() || "";
  if (!noteText) return;

  // Build the chip
  var chipHtml = `<div class="custom-chip-bar note-chip" style="margin-bottom:7px;align-items:center;">
    ${avatarSrc 
      ? `<img src="${avatarSrc}" class="note-avatar" style="width:32px;height:32px;border-radius:9px;object-fit:cover;margin-right:8px;">`
      : badge
        ? `<span class="note-avatar" style="width:32px;height:32px;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;font-size:1rem;background:#1743e3;color:#fff;margin-right:8px;">${badge}</span>`
        : ''
    }
    <span style="font-weight:600;margin-right:7px;">${name}</span>
    <span style="color:#8a8a8a;font-size:1.04rem;flex:1 1 auto;">${noteText}</span>
    <span class="chip-remove" style="font-size:1.43rem;padding:4px 8px 2px 8px;cursor:pointer;">&#10005;</span>
  </div>`;

  $('#noteChipsList').append(chipHtml);

  // Reset and show dropdown again
  $('#noteForStudentSection').hide();
  $('#noteForAvatar').attr('src','').show();
  $('#noteForBadge').remove();
  $('#noteTextarea').val('');
  $('#noteDropdownWrapper').slideDown(120);
});

// Remove chip on close
$(document).on('click', '.note-chip .chip-remove', function() {
  $(this).closest('.note-chip').remove();
});



});






































$(function() {
  // Initial value can be changed as desired
  let currentPercent = 25;

  function renderClassicSlider(percent) {
    let $track = $('.classic-slider-bar-track');
    $track.find('.classic-slider-thumb').remove();

    // Render thumb (no value inside)
    $track.append(`
      <div class="classic-slider-thumb" style="left:calc(${percent}% - 18px);"></div>
    `);

    // Track fill (progress)
    $track.css('background', `linear-gradient(90deg,#FF3B18 0 ${percent}%,#ededed ${percent}% 100%)`);

    // Highlight the closest label
    $('.classic-slider-bar-labels span').removeClass('selected');
    $('.classic-slider-bar-labels span').each(function() {
      let labelVal = parseInt($(this).text().replace('%','').trim());
      if (Math.abs(labelVal - percent) < 2) {
        $(this).addClass('selected');
      }
    });
  }

  function percentFromPageX(pageX) {
    let trackLeft = $('.classic-slider-bar-track').offset().left;
    let w = $('.classic-slider-bar-track').width();
    let rel = (pageX - trackLeft) / w;
    rel = Math.max(0, Math.min(1, rel));
    return rel * 100;
  }

  let dragging = false;
  $(document).on('mousedown touchstart', '.classic-slider-thumb', function(e) {
    dragging = true; e.preventDefault();
  });
  $(document).on('mousemove touchmove', function(e) {
    if (!dragging) return;
    let pageX = e.type === "touchmove" ? e.originalEvent.touches[0].pageX : e.pageX;
    let percent = percentFromPageX(pageX);
    currentPercent = percent;
    renderClassicSlider(currentPercent);
  });
  $(document).on('mouseup touchend', function() { dragging = false; });

  // Click bar to jump to any percent
  $('.classic-slider-bar-track').on('click', function(e) {
    let pageX = e.type === "touchstart" ? e.originalEvent.touches[0].pageX : e.pageX;
    let percent = percentFromPageX(pageX);
    currentPercent = percent;
    renderClassicSlider(currentPercent);
  });

  // Initial render
  renderClassicSlider(currentPercent);
});



















// =========================== progress start===============================//
const subscription_modal_progress_bar_progress = document.querySelector(
  ".subscription_modal_progress_bar_progressShow"
);
const subscription_modal_progress_bar_draggable = subscription_modal_progress_bar_progress.querySelector(
  ".subscription_modal_progress_bar_draggable"
);
const subscription_modal_progress_bar_draggable_percentage_value =
  subscription_modal_progress_bar_draggable.querySelector(
    ".subscription_modal_progress_bar_draggable_percentage_value"
  );
const subscription_modal_progress_bar_completed = document.querySelector(
  ".subscription_modal_progress_bar_completed"
);

let subscription_modal_progress_bar_isDragging = false;

subscription_modal_progress_bar_draggable.addEventListener("mousedown", (event) => {
  subscription_modal_progress_bar_isDragging = true;
  setTimeout(() => {
    subscription_modal_progress_bar_draggable_percentage_value.classList.add("active");
  }, 1000);
  document.addEventListener("mousemove", subscription_modal_progress_bar_onDrag);
  document.addEventListener("mouseup", () => {
    subscription_modal_progress_bar_isDragging = false;
    setTimeout(() => {
      subscription_modal_progress_bar_draggable_percentage_value.classList.remove("active");
    }, 1000);
    document.removeEventListener("mousemove", subscription_modal_progress_bar_onDrag);
  });
});

function subscription_modal_progress_bar_onDrag(event) {
  if (!subscription_modal_progress_bar_isDragging) return;

  let progressRect = subscription_modal_progress_bar_progress.getBoundingClientRect();
  let newLeft = event.clientX - progressRect.left;

  // Ensure the draggable stays within the progress bar
  if (newLeft < 0) newLeft = 0;
  if (newLeft > progressRect.width) newLeft = progressRect.width;

  // Calculate percentage
  let percentage = (newLeft / progressRect.width) * 100;
  percentage = Math.round(percentage);

  if (percentage > 100) percentage = 100;

  let draggableWidth = subscription_modal_progress_bar_draggable.offsetWidth;
  let adjustedLeft = `calc(${percentage}% - ${draggableWidth / 2}px)`;

  subscription_modal_progress_bar_draggable.style.left = adjustedLeft;
  subscription_modal_progress_bar_completed.style.width = `${percentage}%`;
  subscription_modal_progress_bar_draggable_percentage_value.textContent = `${percentage}%`;
}
// =========================== progress end===============================//




























// jQuery for Congratulations Modal
$(function() {
  // On submit button click, show the congrats modal and hide the previous modal
  $('.modal-submit-btn').on('click', function(e) {
    e.preventDefault();
    $('.custom-modal').hide(); // Hides the background modal
    $('#congratsModalBackdrop').fadeIn(120);
    $('#congratsModal').fadeIn(170);
  });

  // Close modal on "Okay" or clicking outside
  $('#congratsOkayBtn, #congratsModalBackdrop').on('click', function() {
    $('#congratsModalBackdrop').fadeOut(120);
    $('#congratsModal').fadeOut(170, function() {
      // Optionally show the previous modal again if needed:
      // $('.custom-modal').show();
    });
  });
});

