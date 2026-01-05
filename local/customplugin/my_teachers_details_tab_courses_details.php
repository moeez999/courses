<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Courses – my_teachers_details_tab_courses_details_</title>

    <style>
        /* ---------- TOKENS (all prefixed) ---------- */
        :root {
            --my_teachers_details_tab_courses_details_text: #0e0e0e;
            --my_teachers_details_tab_courses_details_muted: #6f757d;
            --my_teachers_details_tab_courses_details_border: #e9eaee;
            --my_teachers_details_tab_courses_details_chip_border: #dfe3ea;
            --my_teachers_details_tab_courses_details_price: #ff3b2f;
            --my_teachers_details_tab_courses_details_star: #ff5722;
            --my_teachers_details_tab_courses_details_radius: 18px;
            --my_teachers_details_tab_courses_details_inner_radius: 14px;
            --my_teachers_details_tab_courses_details_button_radius: 999px;
            --my_teachers_details_tab_courses_details_shadow: 0 12px 24px rgba(0, 0, 0, .06);
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            -webkit-font-smoothing: antialiased;
            color: var(--my_teachers_details_tab_courses_details_text);
            background: #fff;
        }

        .my_teachers_details_tab_courses_details_wrap {
            max-width: 1260px;
            margin: 0 auto;
            padding: 28px 18px 64px;
        }

        /* ===== Grid ===== */
        .my_teachers_details_tab_courses_details_grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 32px 28px;
        }

        @media (max-width:1024px) {
            .my_teachers_details_tab_courses_details_grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width:640px) {
            .my_teachers_details_tab_courses_details_grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===== Card ===== */
        .my_teachers_details_tab_courses_details_card {
            border: 1px solid var(--my_teachers_details_tab_courses_details_border);
            border-radius: var(--my_teachers_details_tab_courses_details_radius);
            box-shadow: var(--my_teachers_details_tab_courses_details_shadow);
            background: #fff;
            padding: 18px;
        }

        .my_teachers_details_tab_courses_details_thumb {
            border-radius: var(--my_teachers_details_tab_courses_details_inner_radius);
            overflow: hidden;
            border: 1px solid #eef0f4;
            margin-bottom: 16px;
        }

        .my_teachers_details_tab_courses_details_thumb img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        /* rating + price row */
        .my_teachers_details_tab_courses_details_row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .my_teachers_details_tab_courses_details_rating {
            display: inline-flex;
            gap: 6px;
            align-items: center;
            /* font-weight: 700; */
        }

        .my_teachers_details_tab_courses_details_stars {
            display: inline-flex;
            gap: 3px;
        }

        .my_teachers_details_tab_courses_details_stars svg {
            width: 16px;
            height: 16px;
        }

        .my_teachers_details_tab_courses_details_price {
            color: var(--my_teachers_details_tab_courses_details_price);
            font-weight: 500;
            letter-spacing: .2px;
        }

        .my_teachers_details_tab_courses_details_title {
            margin: 0 2px 16px;
            font-size: 18px;
            line-height: 1.35;
            font-weight: 600;
        }

        /* info chips row */
        .my_teachers_details_tab_courses_details_chips {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin: 0 2px 18px;
        }

        .my_teachers_details_tab_courses_details_chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border: 1px solid var(--my_teachers_details_tab_courses_details_chip_border);
            border-radius: 12px;
            background: #fff;
            color: #222;
            font-size: 14px;
        }

        .my_teachers_details_tab_courses_details_chip svg {
            width: 16px;
            height: 16px;
        }

        /* View Course button (red fill + black border) */
        .my_teachers_details_tab_courses_details_btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: var(--my_teachers_details_tab_courses_details_button_radius);
            background: var(--my_teachers_details_tab_courses_details_price);
            color: #fff;
            font-size: 14xpx;
            /* font-weight: 500; */
            border: 2px solid #000;
            cursor: pointer;
        }

        .my_teachers_details_tab_courses_details_btn:active {
            transform: translateY(1px);
        }
    </style>
</head>

<body>

    <div class="my_teachers_details_tab_courses_details_wrap" id="my_teachers_details_tab_courses_details_wrap">

        <div class="my_teachers_details_tab_courses_details_grid" id="my_teachers_details_tab_courses_details_grid">

            <!-- CARD 1 -->
            <article class="my_teachers_details_tab_courses_details_card">
                <div class="my_teachers_details_tab_courses_details_thumb">
                    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1200&auto=format&fit=crop" alt="">
                </div>

                <div class="my_teachers_details_tab_courses_details_row">
                    <div class="my_teachers_details_tab_courses_details_rating">
                        <span class="my_teachers_details_tab_courses_details_stars" aria-hidden="true">
                            <!-- five stars -->
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                        </span>
                        <span>4.5k</span>
                    </div>
                    <div class="my_teachers_details_tab_courses_details_price">$50.00</div>
                </div>

                <h3 class="my_teachers_details_tab_courses_details_title">Mastering Everyday English For Real-Life Situations</h3>

                <div class="my_teachers_details_tab_courses_details_chips">
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 4h14v14H5zM5 9h14" stroke="#111" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                        Lesson 10
                    </div>
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="8" stroke="#111" stroke-width="1.7" />
                            <path d="M12 8v5l3 2" stroke="#111" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                        19h 30m
                    </div>
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="8" r="3" stroke="#111" stroke-width="1.7" />
                            <path d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6" stroke="#111" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                        Students 20+
                    </div>
                </div>
                <button class="my_teachers_details_tab_courses_details_btn" type="button"><a href="my_teachers_details_course_purchase.php" style="color:white;">Course</a></button>
            </article>

            <!-- CARD 2 -->
            <article class="my_teachers_details_tab_courses_details_card">
                <div class="my_teachers_details_tab_courses_details_thumb">
                    <img src="https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?q=80&w=1200&auto=format&fit=crop" alt="">
                </div>

                <div class="my_teachers_details_tab_courses_details_row">
                    <div class="my_teachers_details_tab_courses_details_rating">
                        <span class="my_teachers_details_tab_courses_details_stars" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                        </span>
                        <span>4.5k</span>
                    </div>
                    <div class="my_teachers_details_tab_courses_details_price">$50.00</div>
                </div>

                <h3 class="my_teachers_details_tab_courses_details_title">Speak With Confidence: English Conversation Skills</h3>

                <div class="my_teachers_details_tab_courses_details_chips">
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 4h14v14H5zM5 9h14" stroke="#111" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                        Lesson 10
                    </div>
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="8" stroke="#111" stroke-width="1.7" />
                            <path d="M12 8v5l3 2" stroke="#111" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                        19h 30m
                    </div>
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="8" r="3" stroke="#111" stroke-width="1.7" />
                            <path d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6" stroke="#111" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                        Students 20+
                    </div>
                </div>

                <button class="my_teachers_details_tab_courses_details_btn" type="button">View Course</button>
            </article>

            <!-- CARD 3 -->
            <article class="my_teachers_details_tab_courses_details_card">
                <div class="my_teachers_details_tab_courses_details_thumb">
                    <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?q=80&w=1200&auto=format&fit=crop" alt="">
                </div>

                <div class="my_teachers_details_tab_courses_details_row">
                    <div class="my_teachers_details_tab_courses_details_rating">
                        <span class="my_teachers_details_tab_courses_details_stars" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l2.7 5.6 6.2.9-4.5 4.4 1.1 6.2L12 17.9 6.5 20l1.1-6.2-4.5-4.4 6.2-.9L12 3Z" fill="var(--my_teachers_details_tab_courses_details_star)" />
                            </svg>
                        </span>
                        <span>4.5k</span>
                    </div>
                    <div class="my_teachers_details_tab_courses_details_price">$50.00</div>
                </div>

                <h3 class="my_teachers_details_tab_courses_details_title">Step-By-Step Guide To Clear English Grammar</h3>

                <div class="my_teachers_details_tab_courses_details_chips">
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 4h14v14H5zM5 9h14" stroke="#111" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                        Lesson 10
                    </div>
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="8" stroke="#111" stroke-width="1.7" />
                            <path d="M12 8v5l3 2" stroke="#111" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                        19h 30m
                    </div>
                    <div class="my_teachers_details_tab_courses_details_chip">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="8" r="3" stroke="#111" stroke-width="1.7" />
                            <path d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6" stroke="#111" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                        Students 20+
                    </div>
                </div>

                <button class="my_teachers_details_tab_courses_details_btn" type="button">View Course</button>
            </article>

        </div>
    </div>

</body>

</html>