<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>my_teachers_details – Videos UI</title>

    <style>
        /* ---------- TOKENS ---------- */
        :root {
            --my_teachers_details_text: #0e0e0e;
            --my_teachers_details_muted: #7b7f85;
            --my_teachers_details_border: #dcdce0;
            --my_teachers_details_bg: #ffffff;
            --my_teachers_details_chip_bg: #ffffff;
            --my_teachers_details_shadow: 0 1px 0 rgba(0, 0, 0, .03), 0 1px 2px rgba(0, 0, 0, .04);
            --my_teachers_details_radius: 5px;
            --my_teachers_details_pill: 999px;
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: var(--my_teachers_details_bg);
            color: var(--my_teachers_details_text);
            -webkit-font-smoothing: antialiased;
            padding: 36px 56px 60px;
        }

        /* ---------- Toolbar ---------- */
        .my_teachers_details_toolbar {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 20px;
            align-items: center;
        }

        /* Single bordered search field */
        .my_teachers_details_search_shell {
            position: relative;
            max-width: 500px;
            width: 100%;
        }

        .my_teachers_details_search_input {
            width: 100%;
            border: 1px solid var(--my_teachers_details_border);
            border-radius: var(--my_teachers_details_radius);
            padding: 12px 16px 12px 40px;
            /* space for icon */
            font-size: 16px;
            outline: none;
            color: var(--my_teachers_details_text);
            box-shadow: var(--my_teachers_details_shadow);
        }

        .my_teachers_details_search_input::placeholder {
            color: #a8abb0;
        }

        .my_teachers_details_search_icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            opacity: .75;
            pointer-events: none;
        }

        /* ---------- Filter & Sort ---------- */
        .my_teachers_details_pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid var(--my_teachers_details_border);
            border-radius: var(--my_teachers_details_radius);
            padding: 12px 16px;
            white-space: nowrap;
            cursor: pointer;
            box-shadow: var(--my_teachers_details_shadow);
            font-size: 15px;
            line-height: 1;
        }

        .my_teachers_details_pill svg {
            width: 18px;
            height: 18px;
            opacity: .8
        }

        .my_teachers_details_sort {
            padding: 12px 18px
        }

        .my_teachers_details_sort_text {
            opacity: .95
        }

        .my_teachers_details_caret {
            margin-left: 4px
        }

        /* ---------- Section Title ---------- */
        /* .my_teachers_details_title {
            font-weight: 800;
            font-size: 38px;
            line-height: 1.12;
            margin: 28px 0 18px;
            letter-spacing: .1px;
        } */

        /* ---------- Scroller ---------- */
        .my_teachers_details_scroller_wrap {
            position: relative
        }

        .my_teachers_details_scroller {
            display: flex;
            gap: 18px;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 2px 2px 12px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .my_teachers_details_scroller::-webkit-scrollbar {
            display: none
        }

        .my_teachers_details_chip {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border: 1px solid var(--my_teachers_details_border);
            border-radius:10px;
            background: var(--my_teachers_details_chip_bg);
            box-shadow: var(--my_teachers_details_shadow);
            font-size: 16px;
            color: #1b1b1b;
            user-select: none;
            cursor: pointer;
        }

        .my_teachers_details_trend svg {
            width: 16px;
            height: 16px
        }

        /* ---------- Responsive ---------- */
        @media (max-width:1000px) {
            body {
                padding: 28px 18px 48px
            }

            .my_teachers_details_toolbar {
                grid-template-columns: 1fr 1fr;
                gap: 12px
            }

            .my_teachers_details_sort {
                grid-column: 1 / -1;
                justify-self: end
            }

            .my_teachers_details_title {
                font-size: 30px
            }
        }
    </style>
</head>

<body>

    <!-- ===== Toolbar ===== -->
    <div class="my_teachers_details_toolbar" id="my_teachers_details_toolbar">

        <!-- Search -->
        <div class="my_teachers_details_search_shell">
            <svg class="my_teachers_details_search_icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle cx="11" cy="11" r="7" stroke="#9aa0a6" stroke-width="2"></circle>
                <path d="M20 20L16.65 16.65" stroke="#9aa0a6" stroke-width="2" stroke-linecap="round"></path>
            </svg>
            <input id="my_teachers_details_search_input" class="my_teachers_details_search_input" type="text"
                placeholder="Search vedio lessons" />
        </div>

        <!-- Filter -->
        <button class="my_teachers_details_pill my_teachers_details_filter" id="my_teachers_details_filter_btn" type="button">
            <span>Filter</span>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 7h8M16 7h4M10 7v10M14 17h6M4 17h6M14 17V7" stroke="#222" stroke-width="1.7" stroke-linecap="round" />
            </svg>
        </button>

        <!-- Sort -->
        <button class="my_teachers_details_pill my_teachers_details_sort" id="my_teachers_details_sort_btn" type="button"
            aria-haspopup="listbox" aria-expanded="false">
            <span class="my_teachers_details_sort_text">Sort By : Recommended</span>
            <svg class="my_teachers_details_caret" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 10l5 5 5-5" stroke="#222" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>

    <!-- ===== Title ===== -->
    <h2 class="my_teachers_details_title" style="margin-top:30px;">Search vedio lessons by trending Topic</h2>

    <!-- ===== Scrollable Buttons (Chips) ===== -->
    <div class="my_teachers_details_scroller_wrap">
        <div class="my_teachers_details_scroller" id="my_teachers_details_chip_scroller" role="listbox"
            aria-label="Trending topics">

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Simple Present</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Make &amp; Do</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Present Continuous</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Connectors</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Adverbs</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Possessives</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Articles</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Demonstratives</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Prepositions</div>

            <div class="my_teachers_details_chip"><span class="my_teachers_details_trend">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 14l5-5 4 4 7-7" stroke="#111" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>Self Intro</div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Smooth horizontal scroll
        (function my_teachers_details_bindScroller() {
            var $s = $('#my_teachers_details_chip_scroller');
            $s.on('wheel', function(e) {
                if (this.scrollWidth > this.clientWidth) {
                    e.preventDefault();
                    this.scrollLeft += e.originalEvent.deltaY;
                }
            });

            var dragging = false,
                startX = 0,
                startScroll = 0;
            $s.on('mousedown', function(e) {
                dragging = true;
                startX = e.pageX - this.offsetLeft;
                startScroll = this.scrollLeft;
                $(this).css('cursor', 'grabbing');
            });
            $(document).on('mouseup', function() {
                dragging = false;
                $s.css('cursor', 'default');
            });
            $s.on('mousemove', function(e) {
                if (!dragging) return;
                e.preventDefault();
                var x = e.pageX - this.offsetLeft;
                this.scrollLeft = startScroll - (x - startX);
            });
        })();

        // Demo actions
        $('#my_teachers_details_filter_btn').on('click', function() {
            alert('Filter clicked');
        });
        $('#my_teachers_details_sort_btn').on('click', function() {
            var expanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !expanded);
            alert('Sort By clicked');
        });
    </script>
</body>

</html>