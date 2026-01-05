<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>my_teacher_details_course_purchase_details_ – Course Detail</title>


  <!-- <link rel="stylesheet" href="css/my_lessons_tutor_profile_details.css"> -->

  <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_reviews.css">
  <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_show_more.css">
  <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_post_reviews.css">


  <style>
    /* ================= TOKENS (all prefixed) ================= */
    :root {
      --my_teacher_details_course_purchase_details_text: #0e0e0e;
      --my_teacher_details_course_purchase_details_muted: #6f757d;
      --my_teacher_details_course_purchase_details_border: #eceef3;
      --my_teacher_details_course_purchase_details_soft: #f7f8fb;
      --my_teacher_details_course_purchase_details_card: #ffffff;
      --my_teacher_details_course_purchase_details_price: #ff3b2f;
      --my_teacher_details_course_purchase_details_star: #ff5722;
      --my_teacher_details_course_purchase_details_accent: #0e0e0e;
      --my_teacher_details_course_purchase_details_radius: 16px;
      --my_teacher_details_course_purchase_details_radius_sm: 12px;
      --my_teacher_details_course_purchase_details_pill: 999px;
      --my_teacher_details_course_purchase_details_shadow: 0 10px 24px rgba(0, 0, 0, .08);
    }

    html,
    body {
      height: 100%
    }

    body {
      margin: 0;
      font-family: Inter, ui-sans-serif, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      -webkit-font-smoothing: antialiased;
      color: var(--my_teacher_details_course_purchase_details_text);
      background: #fff;
    }

    /* ================= LAYOUT ================= */
    .my_teacher_details_course_purchase_details_page {
      max-width: 1260px;
      margin: 0 auto;
      padding: 26px 18px 80px;
    }

    .my_teacher_details_course_purchase_details_grid {
      display: grid;
      grid-template-columns: minmax(0, 1fr) 360px;
      /* left flexible, right fixed */
      gap: 28px;
      align-items: flex-start;
    }

    .my_teacher_details_course_purchase_details_sticky {
      position: sticky;
      top: 20px;
    }

    /* ================= LEFT (SCROLLING) ================= */
    .my_teacher_details_course_purchase_details_breadcrumb {
      color: #2a6fe9;
      font-weight: 500;
      font-size: 13px;
      margin-bottom: 10px;
    }

    .my_teacher_details_course_purchase_details_title {
      margin: 0 0 8px;
      font-size: 47px;
      line-height: 1.08;
      font-weight: 600;
      letter-spacing: .2px;
    }

    @media (max-width:700px) {
      .my_teacher_details_course_purchase_details_grid {
        grid-template-columns: 1fr;
      }

      .my_teacher_details_course_purchase_details_title {
        font-size: 36px;
      }
    }

    .my_teacher_details_course_purchase_details_meta {
      display: flex;
      gap: 14px;
      align-items: center;
      flex-wrap: wrap;
      color: var(--my_teacher_details_course_purchase_details_muted);
      font-weight: 500;
      margin-bottom: 14px;
    }

    .my_teacher_details_course_purchase_details_bul {
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background: #c3c7ce;
      display: inline-block;
    }

    .my_teacher_details_course_purchase_details_intro {
      color: var(--my_teacher_details_course_purchase_details_muted);
      font-size: 14px;
      line-height: 1.65;
      max-width: 780px;
      margin: 10px 0 18px;
    }

    .my_teacher_details_course_purchase_details_instructor {
      display: flex;
      gap: 12px;
      align-items: center;
      color: #1a1a1a;
      font-weight: 500;
      margin: 14px 0 16px;
    }

    .my_teacher_details_course_purchase_details_instructor img {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      object-fit: cover;
    }

    .my_teacher_details_course_purchase_details_updated {
      color: var(--my_teacher_details_course_purchase_details_muted);
      font-weight: 500;
      display: inline-flex;
      gap: 8px;
      align-items: center;
      margin-left: 12px;
    }

    /* Skills chips */
    .my_teacher_details_course_purchase_details_h3 {
      margin: 24px 0 12px;
      font-size: 22px;
      font-weight: 600;
    }

    .my_teacher_details_course_purchase_details_chips {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .my_teacher_details_course_purchase_details_chip {
      padding: 10px 14px;
      background: #fff;
      border: 1px solid var(--my_teacher_details_course_purchase_details_border);
      border-radius: var(--my_teacher_details_course_purchase_details_pill);
      font-weight: 500;
      color: #333;
    }

    /* About */
    .my_teacher_details_course_purchase_details_h2 {
      margin: 32px 0 12px;
      font-size: 25px;
      font-weight: 600;
    }

    .my_teacher_details_course_purchase_details_p {
      margin: 0 0 10px;
      color: #3d424a;
      line-height: 1.7;
    }

    /* Learning Videos LIST */
    .my_teacher_details_course_purchase_details_listwrap {
      margin-top: 10px;
      border: 1px solid var(--my_teacher_details_course_purchase_details_border);
      border-radius: var(--my_teacher_details_course_purchase_details_radius);
      overflow: hidden;
      background: #fff;
    }

    .my_teacher_details_course_purchase_details_listitem {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 14px;
      padding: 16px 18px;
      border-top: 1px solid var(--my_teacher_details_course_purchase_details_border);
      cursor: pointer;
      transition: background .2s;
    }

    .my_teacher_details_course_purchase_details_listitem:hover {
      background: #f9f9f9;
    }

    .my_teacher_details_course_purchase_details_listitem:first-child {
      border-top: none;
    }

    .my_teacher_details_course_purchase_details_left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .my_teacher_details_course_purchase_details_play {
      width: 18px;
      height: 18px;
      border: 1px solid #111;
      border-radius: 50%;
      display: grid;
      place-items: center;
    }

    .my_teacher_details_course_purchase_details_play:before {
      content: "";
      width: 0;
      height: 0;
      border-left: 7px solid #111;
      border-top: 5px solid transparent;
      border-bottom: 5px solid transparent;
      margin-left: 2px;
    }

    .my_teacher_details_course_purchase_details_vidtitle {
      color: #111;
    }

    .my_teacher_details_course_purchase_details_sub {
      color: #858b93;
      font-size: 12px;
      margin-top: 4px;
      font-weight: 700;
    }

    .my_teacher_details_course_purchase_details_lock {
      color: var(--my_teacher_details_course_purchase_details_price);
      font-weight: 900;
      border: 2px solid currentColor;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      display: grid;
      place-items: center;
    }

    /* Accordions (Course outline) */
    .my_teacher_details_course_purchase_details_acc {
      margin-top: 22px;
    }

    .my_teacher_details_course_purchase_details_acc_item {
      border: 1px solid var(--my_teacher_details_course_purchase_details_border);
      border-radius: var(--my_teacher_details_course_purchase_details_radius_sm);
      margin-bottom: 12px;
      overflow: hidden;
      background: #fff;
    }

    .my_teacher_details_course_purchase_details_acc_head {
      padding: 16px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      font-weight: 500;
    }

    .my_teacher_details_course_purchase_details_acc_body {
      display: none;
      padding: 0 18px 16px;
      color: #4a5058;
      line-height: 1.7;
    }

    .my_teacher_details_course_purchase_details_acc_item.my_teacher_details_course_purchase_details_open .my_teacher_details_course_purchase_details_acc_body {
      display: block;
    }

    .my_teacher_details_course_purchase_details_toggle {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      border: 1px solid var(--my_teacher_details_course_purchase_details_border);
      display: grid;
      place-items: center;
      font-weight: 900;
    }

    /* Reviews */
    .my_teacher_details_course_purchase_details_reviews {
      margin-top: 28px;
    }

    .my_teacher_details_course_purchase_details_rating_big {
      font-size: 35px;
      font-weight: 500;
      margin: 0 0 8px;
    }

    .my_teacher_details_course_purchase_details_stars_line {
      display: flex;
      gap: 3px;
      color: #111;
      margin-bottom: 6px;
    }

    .my_teacher_details_course_purchase_details_star {
      width: 16px;
      height: 16px;
      background: var(--my_teacher_details_course_purchase_details_star);
      clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
    }

    .my_teacher_details_course_purchase_details_dist {
      display: grid;
      grid-template-columns: 22px 1fr 40px;
      gap: 10px;
      align-items: center;
      margin: 12px 0;
    }

    .my_teacher_details_course_purchase_details_bar {
      height: 8px;
      background: #e7eaf0;
      border-radius: 8px;
      overflow: hidden;
    }

    .my_teacher_details_course_purchase_details_bar>span {
      display: block;
      height: 100%;
      background: #111;
    }

    .my_teacher_details_course_purchase_details_review {
      display: grid;
      grid-template-columns: 40px 1fr;
      gap: 12px;
      margin: 18px 0;
    }

    .my_teacher_details_course_purchase_details_review img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .my_teacher_details_course_purchase_details_btn_light {
      padding: 10px 14px;
      border: 1px solid #dfe3ea;
      border-radius: 10px;
      background: #fff;
      cursor: pointer;
    }

    /* ================= RIGHT (STICKY CARD) ================= */
    .my_teacher_details_course_purchase_details_card {
      background: var(--my_teacher_details_course_purchase_details_card);
      border: 1px solid var(--my_teacher_details_course_purchase_details_border);
      border-radius: var(--my_teacher_details_course_purchase_details_radius);
      box-shadow: var(--my_teacher_details_course_purchase_details_shadow);
      padding: 14px;
    }

    .my_teacher_details_course_purchase_details_cardthumb {
      border: 1px solid #eef0f4;
      border-radius: 14px;
      overflow: hidden;
      margin-bottom: 12px;
    }

    .my_teacher_details_course_purchase_details_cardthumb img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      display: block;
    }

    .my_teacher_details_course_purchase_details_row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin: 6px 2px 10px;
    }

    .my_teacher_details_course_purchase_details_cardstars {
      display: flex;
      gap: 3px;
      align-items: center;
    }

    .my_teacher_details_course_purchase_details_cardstars .my_teacher_details_course_purchase_details_star {
      width: 14px;
      height: 14px;
    }

    .my_teacher_details_course_purchase_details_price {
      color: var(--my_teacher_details_course_purchase_details_price);
    }

    .my_teacher_details_course_purchase_details_cardtitle {
      margin: 8px 2px 12px;
      font-size: 18px;
      font-weight: 600;
      line-height: 1.35;
    }

    .my_teacher_details_course_purchase_details_infochips {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin: 0 2px 12px;
    }

    .my_teacher_details_course_purchase_details_infochip {
      display: inline-flex;
      gap: 8px;
      align-items: center;
      padding: 10px 12px;
      border: 1px solid #dfe3ea;
      border-radius: 12px;
      font-size: 14px;
      background: #fff;
    }

    .my_teacher_details_course_purchase_details_buy {
      width: 100%;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      padding: 14px 18px;
      background: var(--my_teacher_details_course_purchase_details_price);
      color: #fff;
      font-size: 16px;
      border-radius: 999px;
      border: 2px solid #000;
      cursor: pointer;
      margin-top: 8px;
    }

    /* ========== VIDEO MODAL (NEW) ========== */
    .my_teacher_details_course_purchase_details_video_modal {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .82);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      padding: 18px;
    }

    .my_teacher_details_course_purchase_details_video_modal.my_teacher_details_course_purchase_details_active {
      display: flex;
    }

    .my_teacher_details_course_purchase_details_video_shell {
      position: relative;
      background: #000;
      width: min(1000px, 94vw);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .55);
    }

    /* TALLER video */
    .my_teacher_details_course_purchase_details_video_shell video {
      width: 100%;
      height: 65vh;
      /* <— taller player */
      max-height: 80vh;
      /* keep within viewport */
      display: block;
      background: #000;
      object-fit: contain;
      /* letterbox without cropping */
    }

    .my_teacher_details_course_purchase_details_close_btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: rgba(0, 0, 0, .6);
      border: none;
      color: #fff;
      font-size: 22px;
      font-weight: 700;
      border-radius: 50%;
      width: 34px;
      height: 34px;
      cursor: pointer;
      line-height: 1;
    }

    .my_teacher_details_course_purchase_details_no_scroll {
      overflow: hidden;
    }
  </style>
</head>

<body>

  <div class="my_teacher_details_course_purchase_details_page">

    <div class="my_teacher_details_course_purchase_details_grid">

      <!-- ================= LEFT: SCROLLING CONTENT ================= -->
      <main aria-label="Course main">
        <div class="my_teacher_details_course_purchase_details_breadcrumb">Free Spoken English Course for Beginners</div>

        <h1 class="my_teacher_details_course_purchase_details_title">
          Mastering Everyday English for Real-Life Situations
        </h1>

        <div class="my_teacher_details_course_purchase_details_meta">
          <span>★ 4.42</span> <span class="my_teacher_details_course_purchase_details_bul"></span>
          <span>Beginner level</span> <span class="my_teacher_details_course_purchase_details_bul"></span>
          <span>1.5 learning hrs</span> <span class="my_teacher_details_course_purchase_details_bul"></span>
          <span>200+ Learners</span>
        </div>

        <p class="my_teacher_details_course_purchase_details_intro">
          Enhance pronunciation, expand vocabulary, and master professional communication & jargon.
          Join our free spoken English course and elevate your communication skills.
        </p>

        <div class="my_teacher_details_course_purchase_details_instructor">
          Instructor:
          <img src="https://images.unsplash.com/photo-1548142813-c348350df52b?q=80&w=200&auto=format&fit=crop" alt="">
          <a href="explore_tutors.php" style="color:#2563eb;text-decoration:none;">Daniela</a>
          <span class="my_teacher_details_course_purchase_details_updated">• Modules updated 07/2025</span>
        </div>

        <h3 class="my_teacher_details_course_purchase_details_h3">Skills you will gain</h3>
        <div class="my_teacher_details_course_purchase_details_chips">
          <span class="my_teacher_details_course_purchase_details_chip">Verbal Communication</span>
          <span class="my_teacher_details_course_purchase_details_chip">Professional Etiquette</span>
          <span class="my_teacher_details_course_purchase_details_chip">Jargon</span>
          <span class="my_teacher_details_course_purchase_details_chip">Communication Rules</span>
          <span class="my_teacher_details_course_purchase_details_chip">Similar-Sounding Words</span>
          <span class="my_teacher_details_course_purchase_details_chip">Correct Word Usage</span>
          <span class="my_teacher_details_course_purchase_details_chip">Vocabulary</span>
          <span class="my_teacher_details_course_purchase_details_chip">Emotional Word Differences</span>
        </div>

        <h2 class="my_teacher_details_course_purchase_details_h2">About this course</h2>
        <p class="my_teacher_details_course_purchase_details_p">
          Daniela is a free skilled teacher offering free English speaking course. This free online spoken English course is tailored to boost your communication ability! Learn essential topics covered, including an Introduction to Communication Skills, navigating Professional Communication, and becoming adept at Professional Jargon.
        </p>
        <p class="my_teacher_details_course_purchase_details_p">
          You’ll learn the fundamentals of Verbal Communication, explore similar-sounding words, and understand the nuanced use of “Also,” “As well,” and “Too.” Enhance your linguistic skills with targeted English Vocabulary lessons, refine your English Pronunciation, and enrich your lexicon with English Vocabulary designed specifically for Competitive Exams.
        </p>

        <h2 class="my_teacher_details_course_purchase_details_h2" style="margin-top:28px;">Learning Videos</h2>
        <div style="color:#99a0a8; margin-bottom:8px;">10 Videos</div>

        <div class="my_teacher_details_course_purchase_details_listwrap" id="my_teacher_details_course_purchase_details_videos">
          <!-- Each item can have optional data-video attribute -->
          <div class="my_teacher_details_course_purchase_details_listitem"
            data-video="https://videos.pexels.com/video-files/856933/856933-hd_1280_720_30fps.mp4"
            id="my_teacher_details_course_purchase_details_intro_item">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play" aria-hidden="true"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Introduction to the Course</div>
                <div class="my_teacher_details_course_purchase_details_sub">4 Mins 44 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">The Importance of Business English</div>
                <div class="my_teacher_details_course_purchase_details_sub">4 Mins 2 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Attending Job Interviews</div>
                <div class="my_teacher_details_course_purchase_details_sub">12 Mins 56 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Writing Business Emails</div>
                <div class="my_teacher_details_course_purchase_details_sub">9 Mins 34 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Business Phone Calls</div>
                <div class="my_teacher_details_course_purchase_details_sub">7 Mins 37 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Business English for Negotiation</div>
                <div class="my_teacher_details_course_purchase_details_sub">5 Mins 24 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Business Presentations</div>
                <div class="my_teacher_details_course_purchase_details_sub">7 Mins 8 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Business Abbreviations</div>
                <div class="my_teacher_details_course_purchase_details_sub">5 Mins 3 Secs</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_listitem">
            <div class="my_teacher_details_course_purchase_details_left">
              <span class="my_teacher_details_course_purchase_details_play"></span>
              <div>
                <div class="my_teacher_details_course_purchase_details_vidtitle">Summary</div>
                <div class="my_teacher_details_course_purchase_details_sub">2 Mins 1 Sec</div>
              </div>
            </div>
            <div class="my_teacher_details_course_purchase_details_lock">⛉</div>
          </div>
        </div>

        <h2 class="my_teacher_details_course_purchase_details_h2">Course outline</h2>
        <div class="my_teacher_details_course_purchase_details_acc" id="my_teacher_details_course_purchase_details_acc">
          <div class="my_teacher_details_course_purchase_details_acc_item my_teacher_details_course_purchase_details_open">
            <div class="my_teacher_details_course_purchase_details_acc_head">
              <span>Introduction to Communication Skills</span>
              <span class="my_teacher_details_course_purchase_details_toggle">–</span>
            </div>
            <div class="my_teacher_details_course_purchase_details_acc_body">
              You’ll learn the fundamentals of Verbal Communication, explore similar-sounding words, and understand the nuanced use of “Also,” “As well,” and “Too.” Enhance your linguistic skills with targeted English vocabulary.
            </div>
          </div>

          <div class="my_teacher_details_course_purchase_details_acc_item">
            <div class="my_teacher_details_course_purchase_details_acc_head">
              <span>What is Professional Communication?</span>
              <span class="my_teacher_details_course_purchase_details_toggle">+</span>
            </div>
            <div class="my_teacher_details_course_purchase_details_acc_body">
              Build confidence to communicate effectively in professional environments with frameworks and examples.
            </div>
          </div>

          <div class="my_teacher_details_course_purchase_details_acc_item">
            <div class="my_teacher_details_course_purchase_details_acc_head">
              <span>Professional Jargons</span>
              <span class="my_teacher_details_course_purchase_details_toggle">+</span>
            </div>
            <div class="my_teacher_details_course_purchase_details_acc_body">
              Learn common jargon and when to use it appropriately in workplace communication.
            </div>
          </div>

          <div class="my_teacher_details_course_purchase_details_acc_item">
            <div class="my_teacher_details_course_purchase_details_acc_head">
              <span>Rules of Verbal Communication</span>
              <span class="my_teacher_details_course_purchase_details_toggle">+</span>
            </div>
            <div class="my_teacher_details_course_purchase_details_acc_body">
              Practical dos and don’ts with examples and exercises.
            </div>
          </div>

          <div class="my_teacher_details_course_purchase_details_acc_item">
            <div class="my_teacher_details_course_purchase_details_acc_head">
              <span>Similar sounding words</span>
              <span class="my_teacher_details_course_purchase_details_toggle">+</span>
            </div>
            <div class="my_teacher_details_course_purchase_details_acc_body">
              Distinguish and use commonly confused words through drills.
            </div>
          </div>
        </div>

        <section class="my_teacher_details_course_purchase_details_reviews">
          <h2 class="my_teacher_details_course_purchase_details_h2">What my students say</h2>
          <div style="display:grid; grid-template-columns: 220px 1fr auto; gap:24px; align-items:start;">
            <div>
              <div class="my_teacher_details_course_purchase_details_rating_big">4.7</div>
              <div class="my_teacher_details_course_purchase_details_stars_line">
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star" style="opacity:.3"></span>
              </div>
              <div style="color:#7b828a;">17 reviews</div>
            </div>

            <div>
              <div class="my_teacher_details_course_purchase_details_dist">
                <div>5</div>
                <div class="my_teacher_details_course_purchase_details_bar"><span style="width:92%"></span></div>
                <div style="color:#7b828a;">(15)</div>
              </div>
              <div class="my_teacher_details_course_purchase_details_dist">
                <div>4</div>
                <div class="my_teacher_details_course_purchase_details_bar"><span style="width:6%"></span></div>
                <div style="color:#7b828a;">(1)</div>
              </div>
              <div class="my_teacher_details_course_purchase_details_dist">
                <div>3</div>
                <div class="my_teacher_details_course_purchase_details_bar"><span style="width:0%"></span></div>
                <div style="color:#7b828a;">(0)</div>
              </div>
              <div class="my_teacher_details_course_purchase_details_dist">
                <div>2</div>
                <div class="my_teacher_details_course_purchase_details_bar"><span style="width:0%"></span></div>
                <div style="color:#7b828a;">(0)</div>
              </div>
              <div class="my_teacher_details_course_purchase_details_dist">
                <div>1</div>
                <div class="my_teacher_details_course_purchase_details_bar"><span style="width:2%"></span></div>
                <div style="color:#7b828a;">(1)</div>
              </div>
            </div>

            <button class="my_teacher_details_course_purchase_details_btn_light my_lessons_tutor_profile_details_post_review_trigger">Post review</button>
          </div>

          <div class="my_teacher_details_course_purchase_details_review">
            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop" alt="">
            <div>
              <div class="my_teacher_details_course_purchase_details_review_name">Latingles <span style="color:#97a0aa;">• May 14, 2025</span></div>
              <div class="my_teacher_details_course_purchase_details_stars_line" style="margin-top:4px;">
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
              </div>
              <div style="margin-top:6px;">Great!</div>
            </div>
          </div>

          <div class="my_teacher_details_course_purchase_details_review">
            <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?q=80&w=200&auto=format&fit=crop" alt="">
            <div>
              <div class="my_teacher_details_course_purchase_details_review_name">mayte <span style="color:#97a0aa;">• July 29, 2024</span></div>
              <div class="my_teacher_details_course_purchase_details_stars_line" style="margin-top:4px;">
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star" style="opacity:.4"></span>
                <span class="my_teacher_details_course_purchase_details_star" style="opacity:.4"></span>
              </div>
              <div style="margin-top:6px;">My class ended early</div>
              <button class="my_teacher_details_course_purchase_details_btn_light my_lessson_tutor_profile_detail_show_more_trigger" style="margin-top:8px;">Show More</button>
            </div>
          </div>

          <div class="my_teacher_details_course_purchase_details_review">
            <img src="https://images.unsplash.com/photo-1542156822-6924d1a71ace?q=80&w=200&auto=format&fit=crop" alt="">
            <div>
              <div class="my_teacher_details_course_purchase_details_review_name">Efren <span style="color:#97a0aa;">• September 14, 2024</span></div>
              <div class="my_teacher_details_course_purchase_details_stars_line" style="margin-top:4px;">
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
              </div>
              <div style="margin-top:6px;">
                He is an excellent teacher with incredible patience and effective teaching methods. The classes are comprehensive, engaging, and dynamic. I truly enjoy learning English with him!
              </div>
            </div>
          </div>

          <div class="my_teacher_details_course_purchase_details_review">
            <img src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=200&auto=format&fit=crop" alt="">
            <div>
              <div class="my_teacher_details_course_purchase_details_review_name">Kathryn Murphy <span style="color:#97a0aa;">• September 14, 2024</span></div>
              <div class="my_teacher_details_course_purchase_details_stars_line" style="margin-top:4px;">
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
                <span class="my_teacher_details_course_purchase_details_star"></span>
              </div>
              <div style="margin-top:6px;">
                Amazing teacher! I feel more confident speaking English now.
              </div>
            </div>
          </div>

          <button class="my_teacher_details_course_purchase_details_btn_light my_lessson_tutor_profile_detail_show_more_trigger">Show all 8 reviews</button>
        </section>
      </main>

      <!-- ================= RIGHT: STICKY PURCHASE CARD ================= -->
      <aside class="my_teacher_details_course_purchase_details_sticky" aria-label="Purchase panel">
        <div class="my_teacher_details_course_purchase_details_card">
          <div class="my_teacher_details_course_purchase_details_cardthumb">
            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1200&auto=format&fit=crop" alt="">
          </div>

          <div class="my_teacher_details_course_purchase_details_row">
            <div class="my_teacher_details_course_purchase_details_cardstars">
              <span class="my_teacher_details_course_purchase_details_star"></span>
              <span class="my_teacher_details_course_purchase_details_star"></span>
              <span class="my_teacher_details_course_purchase_details_star"></span>
              <span class="my_teacher_details_course_purchase_details_star"></span>
              <span class="my_teacher_details_course_purchase_details_star"></span>
              <span style="margin-left:6px;">4.5k</span>
            </div>
            <div class="my_teacher_details_course_purchase_details_price">$50.00</div>
          </div>

          <div class="my_teacher_details_course_purchase_details_cardtitle">
            Mastering Everyday English For Real-Life Situations
          </div>

          <div class="my_teacher_details_course_purchase_details_infochips">
            <div class="my_teacher_details_course_purchase_details_infochip">🗂️ Lesson 10</div>
            <div class="my_teacher_details_course_purchase_details_infochip">⏱️ 19h 30m</div>
            <div class="my_teacher_details_course_purchase_details_infochip">👥 Students 20+</div>
          </div>

          <button class="my_teacher_details_course_purchase_details_buy" type="button">
            <a href="my_teachers_details_course_purchase_confirm_payment.php" style="color:white;text-decoration:none;">Buy this course</a>
          </button>
        </div>
      </aside>

    </div>
  </div>

  <!-- ===== VIDEO MODAL (NEW) ===== -->
  <div class="my_teacher_details_course_purchase_details_video_modal"
    id="my_teacher_details_course_purchase_details_video_modal">
    <div class="my_teacher_details_course_purchase_details_video_shell">
      <button class="my_teacher_details_course_purchase_details_close_btn"
        id="my_teacher_details_course_purchase_details_close_video">&times;</button>
      <video id="my_teacher_details_course_purchase_details_video" controls preload="metadata">
        <!-- src will be injected dynamically -->
        Your browser does not support the video tag.
      </video>
    </div>
  </div>

  <script>
    // ======= Accordions: expand/collapse (kept intact) =======
    (function my_teacher_details_course_purchase_details_bindAccordions() {
      var container = document.getElementById('my_teacher_details_course_purchase_details_acc');
      if (!container) return;
      container.querySelectorAll('.my_teacher_details_course_purchase_details_acc_item')
        .forEach(function(item) {
          var head = item.querySelector('.my_teacher_details_course_purchase_details_acc_head');
          head.addEventListener('click', function() {
            var open = item.classList.toggle('my_teacher_details_course_purchase_details_open');
            var toggle = item.querySelector('.my_teacher_details_course_purchase_details_toggle');
            if (toggle) {
              toggle.textContent = open ? '–' : '+';
            }
          });
        });
    })();

    // ======= Video Modal Logic (NEW) =======
    (function my_teacher_details_course_purchase_details_videoInit() {
      var list = document.getElementById('my_teacher_details_course_purchase_details_videos');
      var modal = document.getElementById('my_teacher_details_course_purchase_details_video_modal');
      var video = document.getElementById('my_teacher_details_course_purchase_details_video');
      var btnClose = document.getElementById('my_teacher_details_course_purchase_details_close_video');

      if (!list || !modal || !video || !btnClose) return;

      // open only for the clicked item that has data-video (we set it for "Introduction to the Course")
      list.addEventListener('click', function(e) {
        var item = e.target.closest('.my_teacher_details_course_purchase_details_listitem');
        if (!item) return;

        var src = item.getAttribute('data-video');
        if (!src) return; // other items locked/no video

        // set video source dynamically (works if you later add different sources per item)
        if (video.src !== src) {
          video.src = src;
        }

        modal.classList.add('my_teacher_details_course_purchase_details_active');
        document.body.classList.add('my_teacher_details_course_purchase_details_no_scroll');

        // start fresh for consistent UX
        try {
          video.currentTime = 0;
        } catch (e) {}
        video.play().catch(function() {
          /* autoplay may be blocked; controls are visible */
        });
      });

      function closeModal() {
        try {
          video.pause();
        } catch (e) {}
        try {
          video.currentTime = 0;
        } catch (e) {}
        modal.classList.remove('my_teacher_details_course_purchase_details_active');
        document.body.classList.remove('my_teacher_details_course_purchase_details_no_scroll');
      }

      btnClose.addEventListener('click', closeModal);

      // Close when clicking the dark overlay outside the video shell
      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          closeModal();
        }
      });

      // Close on Escape
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('my_teacher_details_course_purchase_details_active')) {
          closeModal();
        }
      });
    })();
  </script>



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <?php //require_once('my_lessons_tutor_profile_details_reviews.php'); 
  ?>
  <?php require_once('my_lessons_tutor_profile_details_show_more.php');
  ?>
  <?php require_once('my_lessons_tutor_profile_details_post_reviews.php'); ?>


  <!-- <script src="js/my_lessons_tutor_profile_details.js"></script>
  <script src="js/my_lessons_tutor_profile_details_reviews.js"></script>
   -->
  <script src="js/my_lessons_tutor_profile_details_show_more.js"></script>
  <script src="js/my_lessons_tutor_profile_details_post_reviews.js"></script>

</body>

</html>