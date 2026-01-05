<!-- Share Tutor Modal (hidden by default) -->
<div class="modal_backdrop" id="shareTutorModal" style="display:none;">
  <div class="modal_card" role="dialog" aria-modal="true" aria-labelledby="shareTutorTitle">
    <button class="modal_close" type="button" onclick="closeShareModal()" aria-label="Close">
      &times;
    </button>

    <h2 class="modal_title" id="shareTutorTitle">Share this tutor</h2>

    <!-- Tutor info row -->
    <div class="modal_tutor_row">
      <img
        class="modal_tutor_avatar"
        src="https://randomuser.me/api/portraits/men/32.jpg"
        alt="Tutor photo" />
      <div class="modal_tutor_meta">
        <div class="modal_tutor_name">
          <span class="modal_tutor_name_text">Robertson</span>
          <span class="modal_tutor_star">★</span>
          <span class="modal_tutor_rating_value">5</span>
          <span class="modal_tutor_reviews">(28 reviews)</span>
        </div>
        <div class="modal_tutor_tags">
          <span class="modal_tutor_tag">
            <img src="img/my_students/varified_icon.svg" alt="" class="modal_icon">
            Verified
          </span>
          <span class="modal_tutor_tag">
            <img src="img/my_students/proffesional_icon.svg" alt="" class="modal_icon">
            Professional
          </span>
        </div>
      </div>
    </div>

    <!-- Link + Copy button row -->
    <div class="modal_link_row">
      <div class="modal_input_copy">
        <input
          type="text"
          value="https://latingles.com/Robertson"
          id="shareLink"
          readonly />
        <button type="button" class="modal_input_icon_btn" onclick="copyLink()" aria-label="Copy link">
          <img src="img/my_students/text_field_icon.svg" alt="">
        </button>
      </div>
      <button class="modal_copy_btn" type="button" onclick="copyLink()" id="copyLinkButton">
        Copy link
      </button>
    </div>

    <!-- Social buttons grid -->
    <div class="modal_social_grid">
      <button class="modal_social_btn" type="button">
        <img src="img/my_students/email_icon.svg" alt="" class="modal_social_icon">
        <span>Email</span>
      </button>

      <button class="modal_social_btn" type="button">
        <img src="img/my_students/whatsapp_icon.svg" alt="" class="modal_social_icon">
        <span>WhatsApp</span>
      </button>

      <button class="modal_social_btn" type="button">
        <img src="img/my_students/linkedin_icon.svg" alt="" class="modal_social_icon">
        <span>LinkedIn</span>
      </button>
      
      <button class="modal_social_btn" type="button">
        <img src="img/my_students/twitter_icon.svg" alt="" class="modal_social_icon">
        <span>X (Twitter)</span>
      </button>
    </div>
  </div>
</div>