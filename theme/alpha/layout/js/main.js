$(document).ready(function() {

  let currentStep = 'options-modal';
  let previousStep = '';
  let selectedFromTutor = 'Wade Warren';
  let selectedToTutor = 'Daniela';
  let lessonCount = 0;
  const pricePerLesson = 4.97;
  const totalBalance = 29.44;
  const maxLessons = 10; // Allow more lessons for the condition > 5

  // Open modal showing first step
  $('.openTransfer').on('click', function() {
    $('.custom-modal-overlay').fadeIn(200);
    $('.modal-step').removeClass('active');
    $('.modal-step[data-step="options-modal"]').addClass('active');
    currentStep = 'options-modal';
    previousStep = '';
    $('.custom-modal-back').css('visibility', 'hidden');
  });

  // Handle clicks on modal options - switch to next step
  $('.custom-modal-option, .transfer-option').on('click', function() {

    const target = $(this).data('target');
    if (target) {
      previousStep = currentStep;
      currentStep = target;

      if (target === 'lessons-selection-modal') {
        selectedToTutor = $(this).data('tutor') || 'Daniela';
        $('#selectedTutor').text(selectedToTutor);
        lessonCount = 0;
        updateLessonDisplay();
      }

      $('.modal-step.active').fadeOut(200, function() {
        $(this).removeClass('active');
        $('.modal-step[data-step="' + target + '"]').fadeIn(200).addClass('active');
        $('.custom-modal-back').css('visibility', target !== 'options-modal' ? 'visible' : 'hidden');
      });
    }
  });




  $('[data-action="close"]').on('click', function() {
    $('.custom-modal-overlay').fadeOut(200);
  });

  $('.custom-modal-back').on('click', function() {
    const newStep = previousStep;
    previousStep = (newStep === 'options-modal') ? '' : 'options-modal';
    currentStep = newStep;

    $('.modal-step.active').fadeOut(200, function() {
      $(this).removeClass('active');
      $('.modal-step[data-step="' + newStep + '"]').fadeIn(200).addClass('active');
      $('.custom-modal-back').css('visibility', newStep !== 'options-modal' ? 'visible' : 'hidden');
    });
  });

  $('.custom-modal-overlay').on('click', function(e) {
    if ($(e.target).is('.custom-modal-overlay')) {
      $(this).fadeOut(200);
    }
  });

  function updateLessonDisplay() {
    $('#count_id').html(lessonCount + ' Lessons');
    const totalUsed = (lessonCount * pricePerLesson).toFixed(2);
    $('#usedAmount').text('$' + totalUsed);

    const percentUsed = Math.min((lessonCount / maxLessons) * 100, 100);
    $('#progressFill').css('width', percentUsed + '%');

    if (lessonCount >= maxLessons) {
      $('#progressMessage').fadeIn(200).css('color', 'black').text(' To get 6 lessons with Daniela, you will need to pay a $0.37 price difference');
    } else {
      $('#progressMessage').fadeOut(200);
    }

    $('#decreaseLessons').toggleClass('disabled', lessonCount === 0);
    $('#increaseLessons').toggleClass('disabled', lessonCount >= maxLessons);
    $('#continueBtn').toggleClass('disabled', lessonCount === 0);
  }

  updateLessonDisplay();

  $('#increaseLessons').on('click', function() {
    if (!$(this).hasClass('disabled')) {
      lessonCount++;
      updateLessonDisplay();
    }
  });

  $('#decreaseLessons').on('click', function() {
    if (lessonCount > 0 && !$(this).hasClass('disabled')) {
      lessonCount--;
      updateLessonDisplay();
    }
  });

  $('#continueBtn').on('click', function() {
    if (lessonCount > 0 && !$(this).hasClass('disabled')) {
  
      if (lessonCount > 5) {
        // Show Updated Checkout Modal
        previousStep = currentStep;
        currentStep = 'review-transfer-checkout-modal';
  
        $('.modal-step.active').fadeOut(200, function() {
          $(this).removeClass('active');
          $('.modal-step[data-step="review-transfer-checkout-modal"]').fadeIn(200).addClass('active');
          $('.custom-modal-back').css('visibility', 'visible');
        });
  
      } else {
        // Show Original Confirm Modal
        const lessonTotal = (lessonCount * pricePerLesson).toFixed(2);
        const remainingCredit = (totalBalance - lessonTotal).toFixed(2);
  
        $('#lessonCountReviewConfirm').text(lessonCount);
        $('#lessonTotalReviewConfirm').text('$' + lessonTotal);
        $('#remainingCreditConfirm').text('$' + remainingCredit);
        $('#lessonCountReview2Confirm').text(lessonCount);
        $('#lessonTotalReview2Confirm').text('$' + lessonTotal);
        $('#remainingCredit2Confirm').text('$' + remainingCredit);
        $('#selectedTutorReviewConfirm, #selectedTutorReview2Confirm').text(selectedToTutor);
  
        previousStep = currentStep;
        currentStep = 'review-transfer-confirm-modal';
  
        $('.modal-step.active').fadeOut(200, function() {
          $(this).removeClass('active');
          $('.modal-step[data-step="review-transfer-confirm-modal"]').fadeIn(200).addClass('active');
          $('.custom-modal-back').css('visibility', 'visible');
        });
      }
    }
  });
  












  // Handle Continue to Checkout Button
$('#continueCheckoutBtn').on('click', function() {
  previousStep = currentStep;
  currentStep = 'confirm-payment-modal';

  $('.modal-step.active').fadeOut(200, function() {
    $(this).removeClass('active');
    $('.modal-step[data-step="confirm-payment-modal"]').fadeIn(200).addClass('active');
    $('.custom-modal-back').css('visibility', 'visible');
  });
});

// Handle Confirm Payment Button (opens Transfer Complete)
$('#confirmPaymentBtn').on('click', function() {
  previousStep = currentStep;
  currentStep = 'transfer-complete-modal';

  $('.modal-step.active').fadeOut(200, function() {
    $(this).removeClass('active');
    $('.modal-step[data-step="transfer-complete-modal"]').fadeIn(200).addClass('active');
    $('.custom-modal-back').css('visibility', 'hidden');
  });
});

// Handle Confirm Transfer Button (for lessonCount ≤ 5 - already exists but clarify)
$('#confirmTransferBtn').on('click', function() {
  previousStep = currentStep;
  currentStep = 'transfer-complete-modal';

  $('.modal-step.active').fadeOut(200, function() {
    $(this).removeClass('active');
    $('.modal-step[data-step="transfer-complete-modal"]').fadeIn(200).addClass('active');
    $('.custom-modal-back').css('visibility', 'hidden');
  });
});






});

function openModal(id) {
  document.getElementById(id).style.display = 'block';
}

function closeModal(id) {
  document.getElementById(id).style.display = 'none';
}
