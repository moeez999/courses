$(document).ready(function() {
  // Initial setup: show options modal
  $('.modal-step').removeClass('active');
  $('.modal-step[data-step="options-modal"]').addClass('active');

  // When user clicks "Transfer your remaining balance to try a new tutor"
  $('#tryNewTutorOption').on('click', function() {
    // Hide current modal
    $('.modal-step.active').fadeOut(200, function() {
      $(this).removeClass('active');
      // Show Transfer From modal (Second snapshot)
      $('.modal-step[data-step="transfer-from-modal"]').fadeIn(200).addClass('active');
    });
  });

  // You can add similar handlers for the other rows if needed
});


// Handle click on Transfer From users
$('.transfer-option_part2_step2').on('click', function() {
  $('.modal-step.active').fadeOut(200, function() {
    $(this).removeClass('active');
    $('.modal-step_part2_step3[data-step="transfer-to-modal_step3"]').fadeIn(200).addClass('active');
  });
});





// Open “Choose your trial lesson” step when clicking “Book with my balance”
$('#bookBalanceBtn').on('click', function() {
  // fade out whatever step is currently active…
  $('.modal-step_part2_step3.active').fadeOut(200, function() {
    $(this).removeClass('active');
    // …then fade in the lesson-selector step
    $('.lesson-step--selector[data-step="choose-lesson-step"]')
      .fadeIn(200)
      .addClass('active');
  });
});





// — 2) From “Choose your trial lesson” → “Review your transfer” (Step 5)
$('.lesson-step--selector .lesson-option').on('click', function() {
  $('.lesson-step--selector.active').fadeOut(200, function() {
    $(this).removeClass('active');
    $('.review-step--container[data-step="review-transfer-step"]')
      .fadeIn(200)
      .addClass('active');
  });
});

// — 3) Back arrow in “Review your transfer” → “Choose your trial lesson”
$('.review-step--container .review-back').on('click', function() {
  $('.review-step--container.active').fadeOut(200, function() {
    $(this).removeClass('active');
    $('.lesson-step--selector[data-step="choose-lesson-step"]')
      .fadeIn(200)
      .addClass('active');
  });
});

// — 4) Close any open step (overlay or × in either header)
$('.modal-overlay, .lesson-close, .review-close').on('click', function() {
  $('.modal-step.active').fadeOut(200, function() {
    $(this).removeClass('active');
  });
});





// Inside your existing $(function(){ … });
$('#transferModal_step5').on('click', function() {
  // Fade out the active “Review your transfer” panel…
  $('.review-step[data-step="review-transfer-step"].active')
    .fadeOut(200, function() {
      $(this).removeClass('active');
      // …and fade in the “Transfer complete” panel
      $('.modal-step[data-step="transfer-complete-step6"]')
        .fadeIn(200)
        .addClass('active');
    });
});
