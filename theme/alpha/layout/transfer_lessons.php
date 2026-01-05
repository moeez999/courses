<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = 'dev.latingles.com';
$path_main = "/theme/alpha/layout/css/main.css";
$path_main_part2 = "/theme/alpha/layout/css/main_part2.css";
?>
<link rel="stylesheet" href="<?php echo $protocol . $host . $path_main; ?>">

<link rel="stylesheet" href="<?php echo $protocol . $host . $path_main_part2; ?>">

<!-- Single Modal with Multiple Steps -->
<div class="custom-modal-overlay">
  <div class="custom-modal-box">
    <!-- Header with back and close buttons -->
    <div class="custom-modal-header">
      <div class="custom-modal-back" data-action="back">←</div>
      <div class="custom-modal-close" data-action="close">×</div>
    </div>
    
    <!-- Step 1: What would you like to do? -->
    <div class="modal-step active" data-step="options-modal">
      <h2 class="custom-modal-title">What would you like to do?</h2>
      <div class="custom-modal-content">
        <div class="custom-modal-option" data-target="transfer-modal_part1">
          <div><i class="fas fa-sync-alt"></i>Transfer your remaining balance between your current tutors</div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>

        <div class="custom-modal-option" id="tryNewTutorOption">
        <div><i class="fas fa-user-plus"></i>Transfer your remaining balance to try a new tutor</div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>

        <div class="custom-modal-option" data-target="transfer-subscription-modal">
        <div><i class="fas fa-user-edit"></i>Transfer your subscription to another tutor</div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
      </div>
    </div>

    <!-- Step 2: Transfer from -->
    <div class="modal-step" data-step="transfer-modal_part1">
      <h2 class="custom-modal-title">Transfer from</h2>
      <div class="custom-modal-content">
        <div class="transfer-option" data-target="transfer-to-modal_part1_step2">
          <div class="user-avatar">
            <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Wade Warren">
          </div>
          <div class="user-info">
            <div class="user-name">Wade Warren</div>
            <div class="transfer-amount">29$ to transfer</div>
          </div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
        
        <div class="transfer-option" data-target="transfer-to-modal_part1_step2">
          <div class="user-avatar">
            <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Karen V.">
          </div>
          <div class="user-info">
            <div class="user-name">Karen V.</div>
            <div class="transfer-amount">38$ to transfer</div>
          </div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
        
        <div class="transfer-option" data-target="transfer-to-modal_part1_step2">
          <div class="user-avatar">
            <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="David">
          </div>
          <div class="user-info">
            <div class="user-name">David</div>
            <div class="transfer-amount">134$ to transfer</div>
          </div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
      </div>
    </div>
    
    <!-- Step 3: Transfer to -->
    <div class="modal-step" data-step="transfer-to-modal_part1_step2">
      <h2 class="custom-modal-title">Transfer to</h2>
      <div class="custom-modal-content">
        <div class="section-title">Active Subscriptions</div>
        
        <div class="transfer-option" data-target="lessons-selection-modal" data-tutor="Daniela">
          <div class="user-avatar">
            <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Daniela">
          </div>
          <div class="user-info">
            <div class="user-name">Daniela</div>
            <div class="lesson-info">12 lessons left • $2.5 per lesson</div>
          </div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
        
        <div class="transfer-option" data-target="lessons-selection-modal" data-tutor="Karen V.">
          <div class="user-avatar">
            <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Karen V.">
          </div>
          <div class="user-info">
            <div class="user-name">Karen V.</div>
            <div class="lesson-info">8 lessons left • $3 per lesson</div>
          </div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
        
        <div class="section-divider"></div>
        <div class="section-title">Not subscribed yet</div>
        
        <div class="transfer-option" data-target="lessons-selection-modal" data-tutor="Marbe B.">
          <div class="user-avatar">
            <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="Marbe B.">
          </div>
          <div class="user-info">
            <div class="user-name">Marbe B.</div>
            <div class="lesson-info">trail lesson completed • $5 per lesson</div>
          </div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
        
        <div class="transfer-option" data-target="lessons-selection-modal" data-tutor="Anne S.">
          <div class="user-avatar">
            <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Anne S.">
          </div>
          <div class="user-info">
            <div class="user-name">Anne S.</div>
            <div class="lesson-info">$6 per lesson</div>
          </div>
          <span class="custom-modal-arrow">&rsaquo;</span>
        </div>
      </div>
    </div>
    
    <!-- Step 4: Lesson Selection -->
    <div class="modal-step active" data-step="lessons-selection-modal">
      <!-- User avatars -->
      <div class="user-avatars">
        <div class="avatar-left">
          <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="User" id="fromAvatar">
        </div>
        <div class="avatar-arrow">→</div>
        <div class="avatar-right">
          <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="Selected Tutor" id="toAvatar">
        </div>
      </div>

      <h2 class="custom-modal-title">How many lessons do you want with <span id="selectedTutor">Daniela</span>?</h2>

      <div class="lesson-selection-container">
        <!-- Lesson counter -->
        <div class="lesson-counter-container">
          <div class="lesson-counter">
            <div class="counter-btn minus-btn" id="decreaseLessons">−</div>
            <div class="lesson-count" id="count_id">0 Lessons</div>
            <div class="counter-btn plus-btn" id="increaseLessons">+</div>
          </div>
          <div class="lesson-price" id="lessonPrice">$4.97 per lesson</div>
        </div>

        <!-- Balance info -->
        <div class="balance-container">
          <div class="balance-header">
            <div class="balance-text">Balance: <span id="balanceAmount">$29.44</span></div>
            <div class="used-amount">
              <span class="used-icon">⬤</span>
              <span id="usedAmount">$0.00</span> used
            </div>
          </div>
          <div id="progressMessage" style="display:none; background: #fff3cd; color: #856404; padding: 10px; border: 1px solid #ffeeba; border-radius: 5px; margin-bottom: 10px;">
            <!-- Message will appear here -->
          </div>
          <div class="progress-bar">
            <div class="progress-fill" id="progressFill" style="width: 0%"></div>
          </div>
          <div class="show-breakdown" onclick="openModal('breakdownModal')">Show breakdown</div>
        </div>

        <!-- Continue button -->
        <button class="continue-btn disabled" id="continueBtn">Continue</button>
      </div>
    </div>



<!-- Updated 5th Step: Checkout Modal -->
<div class="modal-step" data-step="review-transfer-checkout-modal">
  <div class="user-avatars review-avatars">
    <div class="avatar-left">
      <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="From Tutor" id="fromAvatarReview">
    </div>
    <div class="avatar-arrow">→</div>
    <div class="avatar-right">
      <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="To Tutor" id="toAvatarReview">
    </div>
  </div>

  <h2 class="custom-modal-title">Review your transfer</h2>
  <div class="custom-modal-content">
    <div class="balance-info">
      <div class="balance-row">
        <span>Balance with Wade Warren</span>
        <span class="amount">$29.44</span>
      </div>
      <div class="balance-row">
        <span>5 lessons with Daniela</span>
        <span class="amount">$32.84</span>
      </div>
      <div class="balance-row">
        <span>Price difference</span>
        <span class="amount">- $2.76</span>
      </div>
    </div>

    <div class="next-steps">
      <h3 class="section-title">What happens next?</h3>
      <ul>
        <li>You’ll get <strong>5 lessons ($24.84) with Daniela</strong> after you pay a $2.76 difference.</li>
      </ul>
    </div>

    <button id="continueCheckoutBtn" class="continue-btn">Continue to checkout</button>
  </div>
</div>



<!-- Original 5th Step: Confirm Transfer Modal -->
<div class="modal-step" data-step="review-transfer-confirm-modal">
  <div class="user-avatars review-avatars">
    <div class="avatar-left">
      <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="From Tutor" id="fromAvatarReviewConfirm">
    </div>
    <div class="avatar-arrow">→</div>
    <div class="avatar-right">
      <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="To Tutor" id="toAvatarReviewConfirm">
    </div>
  </div>

  <h2 class="custom-modal-title">Review your transfer</h2>
  <div class="custom-modal-content">
    <div class="balance-info">
      <div class="balance-row">
        <span>Balance with Wade Warren</span>
        <span class="amount">$29.44</span>
      </div>
      <div class="balance-row">
        <span><span id="lessonCountReviewConfirm">5</span> lessons with <span id="selectedTutorReviewConfirm">Daniela</span></span>
        <span class="amount" id="lessonTotalReviewConfirm">$24.84</span>
      </div>
      <div class="section-divider"></div>
      <div class="balance-row">
        <span>Remaining balance with Wade Warren</span>
        <span class="amount" id="remainingCreditConfirm">$4.60</span>
      </div>
    </div>

    <div class="next-steps">
      <h3 class="section-title">What happens next?</h3>
      <ul>
        <li>You’ll get <strong><span id="lessonCountReview2Confirm">5</span> lessons (<span id="lessonTotalReview2Confirm">$24.84</span>)</strong> with <span id="selectedTutorReview2Confirm">Daniela</span>.</li>
        <li>The remaining <strong><span id="remainingCredit2Confirm">$4.60</span> will be added to your latinglés credit</strong>.</li>
      </ul>
    </div>

    <button id="confirmTransferBtn" class="continue-btn">Confirm transfer</button>
  </div>
</div>









<!-- Confirm Payment Modal -->
<div class="modal-step" data-step="confirm-payment-modal">
  <h2 class="custom-modal-title">Confirm payment</h2>
  <div class="custom-modal-content">
    <div class="balance-info">
      <div class="balance-row">
        <span>Price difference</span>
        <span class="amount">$2.76</span>
      </div>
      <div class="balance-row">
        <span>Processing fee</span>
        <span class="amount" style="color: green;">Free</span>
      </div>
      <div class="balance-row">
        <span>Your Preply credit</span>
        <span class="amount" style="color: green;">- $2.39</span>
      </div>
      <div class="section-divider"></div>
      <div class="balance-row">
        <span>Total</span>
        <span class="amount">$0.37</span>
      </div>
    </div>

    <div class="payment-method">
      <h3 class="section-title">Payment method</h3>
      <div class="payment-card">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" style="width: 40px;">
        <span>Visa ****7583</span>
        <span style="margin-left:auto;">Edit</span>
      </div>
    </div>

    <button id="confirmPaymentBtn" class="continue-btn">Confirm $0.37</button>
  </div>
</div>



<!-- Transfer Complete Modal - Final Design -->
<div class="modal-step" data-step="transfer-complete-modal" style="border-radius: 12px; overflow: hidden;">
  <!-- Top section with light pink background -->
  <div style="background: #ffeae5; padding: 20px; text-align: center;">
    <div style="display: flex; justify-content: center; align-items: center;">
      <!-- Left Avatar -->
      <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="From Tutor" style="width: 48px; height: 48px; border-radius: 50%; margin-right: 12px;">
      <!-- Arrow -->
      <div style="font-size: 20px; color: #ff5331; font-weight: bold;">»»»</div>
      <!-- Right Avatar with +1 -->
      <div style="position: relative; margin-left: 12px;">
        <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="To Tutor" style="width: 48px; height: 48px; border-radius: 50%;">
        <div style="position: absolute; top: -5px; right: -5px; background: #ff5331; color: white; font-size: 10px; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">+1</div>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <div style="padding: 24px; text-align: center;">
    <h2 style="font-size: 20px; font-weight: bold; color: #000; margin-bottom: 12px;">Transfer complete</h2>
    <p style="font-size: 14px; color: #333; margin-bottom: 20px;">
      Nice! You have 1 lesson with Daniela, and a $2.39 Preply credit for your future payments. Now it’s time to schedule your lesson.
    </p>

    <!-- Buttons -->
    <button class="continue-btn" style="width: 100%; background: #ff5331; border: none; color: white; font-weight: bold; font-size: 16px; padding: 12px; margin-bottom: 12px; border-radius: 6px;">Schedule lesson</button>
    <button class="secondary-btn" style="width: 100%; background: white; border: 1px solid #000; color: #000; font-weight: bold; font-size: 16px; padding: 12px; border-radius: 6px;">I'll do it later</button>
  </div>
</div>

<?php
require_once('transfer_lesson_part2.php');
?>


  </div>
</div>

<!-- Modal 2: Breakdown -->
<div id="breakdownModal" class="lesson-modal" style="display: none;">
  <div class="lesson-modal-content">
    <span class="lesson-modal-close" onclick="closeModal('breakdownModal')">&times;</span>

    <div class="breakdown-header">
      <img src="avatar2.jpg" alt="Daniela" class="lesson-avatar" />
      <div>
        <strong>Your balance with Daniela</strong><br />
        <span>Price per lesson: $7.36</span>
      </div>
    </div>

    <table class="breakdown-table">
      <tr><td>4 unscheduled lessons</td><td>$29.44</td></tr>
      <tr><td>0 scheduled lessons</td><td>$0.00</td></tr>
      <tr><td>Amount used for transfer</td><td>-$22.00</td></tr>
      <tr class="highlight-row"><td>Remaining balance</td><td class="green">$7.36</td></tr>
    </table>

    <button onclick="closeModal('breakdownModal')" class="breakdown-close-btn">Close</button>
  </div>
</div>

<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = 'dev.latingles.com';
$jsPath = "/theme/alpha/layout/js/main.js";
$jsPath_main_part2 = "/theme/alpha/layout/js/main_part2.js";
?>

<script src="<?php echo $protocol . $host . $jsPath; ?>"></script>

<script src="<?php echo $protocol . $host . $jsPath_main_part2; ?>"></script>

