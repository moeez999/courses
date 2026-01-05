    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_book_trial_lesson.css">

    <style>
        :root {
            --my_teachers_details_tab_one_and_one_class_details_text: #0E0E0E;
            --my_teachers_details_tab_one_and_one_class_details_muted: #6F757D;
            --my_teachers_details_tab_one_and_one_class_details_border: #E3E6ED;
            --my_teachers_details_tab_one_and_one_class_details_soft: #F7F8FB;
            --my_teachers_details_tab_one_and_one_class_details_card: #FFFFFF;
            --my_teachers_details_tab_one_and_one_class_details_accent: #FF3B2F;
            /* red */
            --my_teachers_details_tab_one_and_one_class_details_shadow: 0 8px 24px rgba(16, 24, 40, .06);
            --my_teachers_details_tab_one_and_one_class_details_radius: 18px;
            --my_teachers_details_tab_one_and_one_class_details_black: #0F172A;
        }

        html,
        body {
            margin: 0;
            background: #fff;
            color: var(--my_teachers_details_tab_one_and_one_class_details_text);
            font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif
        }

        .my_teachers_details_tab_one_and_one_class_details_wrap {
            padding: 24px;
            display: flex;
            justify-content: center
        }

        .my_teachers_details_tab_one_and_one_class_details_card {
            width: min(1100px, 96vw);
            background: var(--my_teachers_details_tab_one_and_one_class_details_card);
            border: 1px solid var(--my_teachers_details_tab_one_and_one_class_details_border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--my_teachers_details_tab_one_and_one_class_details_shadow);
            position: relative;
        }

        .my_teachers_details_tab_one_and_one_class_details_grid {
            display: grid;
            grid-template-columns: 132px 1fr 320px;
            gap: 24px;
            align-items: start;
        }

        /* avatar */
        .my_teachers_details_tab_one_and_one_class_details_avatarbox {
            width: 132px;
            height: 132px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
        }

        .my_teachers_details_tab_one_and_one_class_details_avatarbox img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .my_teachers_details_tab_one_and_one_class_details_online {
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 18px;
            height: 18px;
            border-radius: 15%;
            background: #1DD75B;
            border: 2px solid #fff
        }

        /* left info */
        .my_teachers_details_tab_one_and_one_class_details_name {
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 6px
        }

        .my_teachers_details_tab_one_and_one_class_details_verified {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #1DA1F2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff
        }

        .my_teachers_details_tab_one_and_one_class_details_row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 6px 0;
            color: #111
        }

        .my_teachers_details_tab_one_and_one_class_details_row .i {
            width: 18px;
            height: 18px
        }

        .my_teachers_details_tab_one_and_one_class_details_muted {
            color: var(--my_teachers_details_tab_one_and_one_class_details_muted)
        }

        .my_teachers_details_tab_one_and_one_class_details_dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--my_teachers_details_tab_one_and_one_class_details_muted)
        }

        .my_teachers_details_tab_one_and_one_class_details_bio {
            margin-top: 8px;
            line-height: 1.6;
            font-size: 15px
        }

        .my_teachers_details_tab_one_and_one_class_details_see {
            color: #0A66C2;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none
        }

        /* right meta + buttons */
        .my_teachers_details_tab_one_and_one_class_details_meta {
            display: flex;
            justify-content: flex-end;
            gap: 22px;
            align-items: center
        }

        .my_teachers_details_tab_one_and_one_class_details_price {
            font-weight: 700
        }

        .my_teachers_details_tab_one_and_one_class_details_small {
            font-size: 12px;
            color: var(--my_teachers_details_tab_one_and_one_class_details_muted)
        }

        .my_teachers_details_tab_one_and_one_class_details_btns {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: flex-end
        }

        .my_teachers_details_tab_one_and_one_class_details_btn {
            padding: 14px 22px;
            border-radius: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: transform .04s ease, box-shadow .16s ease;
            width: 320px;
            max-width: 100%;
            border: 2px solid var(--my_teachers_details_tab_one_and_one_class_details_black);
        }

        .my_teachers_details_tab_one_and_one_class_details_btn:active {
            transform: translateY(1px)
        }

        .my_teachers_details_tab_one_and_one_class_details_btn_primary {
            background: var(--my_teachers_details_tab_one_and_one_class_details_accent);
            color: #fff;
        }

        .my_teachers_details_tab_one_and_one_class_details_btn_outline {
            background: #fff;
            color: #111;
        }

        /* review block (revealed on See More) */
        .my_teachers_details_tab_one_and_one_class_details_morewrap {
            display: none;
            margin-top: 16px
        }

        .my_teachers_details_tab_one_and_one_class_details_heading {
            font-weight: 700;
            margin: 16px 0 12px
        }

        .my_teachers_details_tab_one_and_one_class_details_review {
            border: 1px solid var(--my_teachers_details_tab_one_and_one_class_details_border);
            border-radius: 16px;
            padding: 18px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(16, 24, 40, .04);
            max-width: 700px;
        }

        .my_teachers_details_tab_one_and_one_class_details_review_top {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 8px
        }

        .my_teachers_details_tab_one_and_one_class_details_review_avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            overflow: hidden;
            flex: 0 0 44px
        }

        .my_teachers_details_tab_one_and_one_class_details_review_avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .my_teachers_details_tab_one_and_one_class_details_review_name {
            font-weight: 600
        }

        .my_teachers_details_tab_one_and_one_class_details_review_date {
            font-size: 12px;
            color: var(--my_teachers_details_tab_one_and_one_class_details_muted)
        }

        .my_teachers_details_tab_one_and_one_class_details_stars {
            display: flex;
            gap: 6px;
            margin: 8px 0
        }

        .my_teachers_details_tab_one_and_one_class_details_star svg {
            width: 18px;
            height: 18px;
            color: #111
        }

        .my_teachers_details_tab_one_and_one_class_details_more_toggle {
            margin-top: 16px;
            font-weight: 600;
            text-align: center
        }

        .my_teachers_details_tab_one_and_one_class_details_more_toggle a {
            color: #0A66C2;
            text-decoration: none;
            cursor: pointer
        }

        /* responsive */
        @media (max-width: 920px) {
            .my_teachers_details_tab_one_and_one_class_details_grid {
                grid-template-columns: 110px 1fr;
            }

            .my_teachers_details_tab_one_and_one_class_details_meta {
                justify-content: flex-start;
                margin-top: 8px
            }

            .my_teachers_details_tab_one_and_one_class_details_btns {
                align-items: stretch
            }

            .my_teachers_details_tab_one_and_one_class_details_btn {
                width: 100%
            }
        }
    </style>
    <div class="my_teachers_details_tab_one_and_one_class_details_wrap">
        <section class="my_teachers_details_tab_one_and_one_class_details_card" id="my_teachers_details_tab_one_and_one_class_details_card">

            <div class="my_teachers_details_tab_one_and_one_class_details_grid">
                <!-- Avatar -->
                <div class="my_teachers_details_tab_one_and_one_class_details_avatarbox">
                    <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=1200&auto=format&fit=crop" alt="Teacher" />
                    <span class="my_teachers_details_tab_one_and_one_class_details_online" aria-label="online"></span>
                </div>

                <!-- Left info -->
                <div>
                    <h1 class="my_teachers_details_tab_one_and_one_class_details_name">
                        Daniela
                        <span class="my_teachers_details_tab_one_and_one_class_details_verified" title="Verified">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9.5 16.2 5.8 12.5l1.4-1.4 2.3 2.3 5.3-5.3 1.4 1.4-6.7 6.7Z" />
                            </svg>
                        </span>
                    </h1>

                    <div class="my_teachers_details_tab_one_and_one_class_details_row">
                        <span class="i" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M4 19V5a2 2 0 0 1 2-2h8l6 6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" stroke="currentColor" stroke-width="1.6" />
                                <path d="M14 3v4h4" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                        </span>
                        <span>English</span>
                    </div>

                    <div class="my_teachers_details_tab_one_and_one_class_details_row">
                        <span class="i" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 12c2.8 0 5-2.2 5-5S14.8 2 12 2 7 4.2 7 7s2.2 5 5 5Zm0 2c-4 0-8 2-8 6v1h16v-1c0-4-4-6-8-6Z" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                        </span>
                        <span class="my_teachers_details_tab_one_and_one_class_details_muted">30 active students</span>
                        <span class="my_teachers_details_tab_one_and_one_class_details_dot"></span>
                        <span class="my_teachers_details_tab_one_and_one_class_details_muted">1,260 lessons</span>
                    </div>

                    <div class="my_teachers_details_tab_one_and_one_class_details_row">
                        <span class="i" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.6" />
                                <path d="M8.5 10.5c.6-.6 1.4-1 2.3-1 .9 0 1.7.4 2.3 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span>Speaks · English (Native)</span>
                    </div>

                    <div class="my_teachers_details_tab_one_and_one_class_details_bio">
                        Hi! I’m Daniela, an experienced English teacher with over a decade of helping students master the language. I’m passionate about creating
                        <a class="my_teachers_details_tab_one_and_one_class_details_see" id="my_teachers_details_tab_one_and_one_class_details_see"> See More…</a>
                    </div>

                    <!-- Hidden details section -->
                    <div class="my_teachers_details_tab_one_and_one_class_details_morewrap" id="my_teachers_details_tab_one_and_one_class_details_morewrap">
                        <p style="margin:10px 0 0">
                            engaging, confidence-building lessons tailored to your goals—conversation practice, exam prep, or professional fluency.
                            I love making progress visible and fun.
                        </p>

                        <h3 class="my_teachers_details_tab_one_and_one_class_details_heading">
                            Why Choose English Group Classes (Bilingual)
                        </h3>

                        <div class="my_teachers_details_tab_one_and_one_class_details_review">
                            <div class="my_teachers_details_tab_one_and_one_class_details_review_top">
                                <div class="my_teachers_details_tab_one_and_one_class_details_review_avatar">
                                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=600&auto=format&fit=crop" alt="Reviewer" />
                                </div>
                                <div>
                                    <div class="my_teachers_details_tab_one_and_one_class_details_review_name">Efren</div>
                                    <div class="my_teachers_details_tab_one_and_one_class_details_review_date">September 14, 2024</div>
                                </div>
                            </div>

                            <div class="my_teachers_details_tab_one_and_one_class_details_stars" aria-label="5 stars">
                                <span class="my_teachers_details_tab_one_and_one_class_details_star"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2 9.2 8H3l5 3.9L6.8 18 12 14.6 17.2 18 16 11.9 21 8h-6.2L12 2Z" />
                                    </svg></span>
                                <span class="my_teachers_details_tab_one_and_one_class_details_star"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2 9.2 8H3l5 3.9L6.8 18 12 14.6 17.2 18 16 11.9 21 8h-6.2L12 2Z" />
                                    </svg></span>
                                <span class="my_teachers_details_tab_one_and_one_class_details_star"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2 9.2 8H3l5 3.9L6.8 18 12 14.6 17.2 18 16 11.9 21 8h-6.2L12 2Z" />
                                    </svg></span>
                                <span class="my_teachers_details_tab_one_and_one_class_details_star"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2 9.2 8H3l5 3.9L6.8 18 12 14.6 17.2 18 16 11.9 21 8h-6.2L12 2Z" />
                                    </svg></span>
                                <span class="my_teachers_details_tab_one_and_one_class_details_star"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2 9.2 8H3l5 3.9L6.8 18 12 14.6 17.2 18 16 11.9 21 8h-6.2L12 2Z" />
                                    </svg></span>
                            </div>

                            <p style="margin:6px 0 0;color:#444">
                                He is an excellent teacher with incredible patience and effective teaching methods.
                                The classes are comprehensive, engaging, and dynamic. I truly enjoy learning English with him!
                            </p>
                        </div>

                        <div class="my_teachers_details_tab_one_and_one_class_details_more_toggle">
                            <a id="my_teachers_details_tab_one_and_one_class_details_hide">Hide Details</a>
                        </div>
                    </div>
                </div>

                <!-- Right meta + buttons -->
                <div>
                    <div class="my_teachers_details_tab_one_and_one_class_details_meta">
                        <div style="display:flex;align-items:center;gap:6px">
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px">
                                <path d="M12 2 9.2 8H3l5 3.9L6.8 18 12 14.6 17.2 18 16 11.9 21 8h-6.2L12 2Z" />
                            </svg>
                            <strong>4.7</strong>
                        </div>
                        <div class="my_teachers_details_tab_one_and_one_class_details_small">17 reviews</div>
                        <div class="my_teachers_details_tab_one_and_one_class_details_small">858 lessons</div>
                        <div class="my_teachers_details_tab_one_and_one_class_details_price">US$8&nbsp;<span class="my_teachers_details_tab_one_and_one_class_details_small">50-min lesson</span></div>
                    </div>

                    <div class="my_teachers_details_tab_one_and_one_class_details_btns">
                        <button class="my_teachers_details_tab_one_and_one_class_details_btn my_teachers_details_tab_one_and_one_class_details_btn_primary my_lessons_tutor_profile_details_book_trial_lesson_btn" id="my_teachers_details_tab_one_and_one_class_details_btn_trial">Book trial lesson US$0</button>
                        <button class="my_teachers_details_tab_one_and_one_class_details_btn my_teachers_details_tab_one_and_one_class_details_btn_outline" id="my_teachers_details_tab_one_and_one_class_details_btn_msg">Send a Message</button>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <script>
        // Toggle "See More…" -> show details like your second snapshot
        function my_teachers_details_tab_one_and_one_class_details_open() {
            $('#my_teachers_details_tab_one_and_one_class_details_morewrap').stop(true, true).slideDown(220);
            $('#my_teachers_details_tab_one_and_one_class_details_see').text(' Hide Details').attr('id', 'my_teachers_details_tab_one_and_one_class_details_hide_trigger');
        }

        function my_teachers_details_tab_one_and_one_class_details_close() {
            $('#my_teachers_details_tab_one_and_one_class_details_morewrap').stop(true, true).slideUp(200);
            $('#my_teachers_details_tab_one_and_one_class_details_hide_trigger').text(' See More…').attr('id', 'my_teachers_details_tab_one_and_one_class_details_see');
        }

        // Delegated handlers (ID changes on toggle)
        $(document).on('click', '#my_teachers_details_tab_one_and_one_class_details_see', function(e) {
            e.preventDefault();
            my_teachers_details_tab_one_and_one_class_details_open();
        });
        $(document).on('click', '#my_teachers_details_tab_one_and_one_class_details_hide, #my_teachers_details_tab_one_and_one_class_details_hide_trigger', function(e) {
            e.preventDefault();
            my_teachers_details_tab_one_and_one_class_details_close();
        });

        // Demo actions (replace with your real flows)
        // $('#my_teachers_details_tab_one_and_one_class_details_btn_trial').on('click', function() {
        //     alert('Open trial booking flow');
        // });

        $('#my_teachers_details_tab_one_and_one_class_details_btn_msg').on('click', function() {
            alert('Open message modal');
        });
    </script>



    <?php require_once('my_lessons_tutor_profile_details_book_trail_lesson.php'); ?>

    <script src="js/my_lessons_tutor_profile_details_book_trial_lesson.js"></script>

