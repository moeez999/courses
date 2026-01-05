<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>my_teachers_details – Profile Section</title>

    <style>
        :root {
            --my_teachers_details_text: #0e0e0e;
            --my_teachers_details_muted: #70757d;
            --my_teachers_details_border: #000;
            --my_teachers_details_soft_border: #e9eaee;
            --my_teachers_details_bg: #fff;
            --my_teachers_details_accent: #ff3b2f;
            --my_teachers_details_radius: 5px;
            --my_teachers_details_shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }

        /* top horizontal line */
        .my_teachers_details_top_rule {
            height: 1px;
            width: 100%;
            background: #e6e6ea;
            margin-bottom: 24px;
        }

        /* layout */
        .my_teachers_details_profile {
            display: flex;
            align-items: flex-start;
            gap: 22px;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* avatar */
        .my_teachers_details_avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            flex: 0 0 90px;
            box-shadow: var(--my_teachers_details_shadow);
        }

        .my_teachers_details_avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* text section */
        .my_teachers_details_info {
            flex: 1;
        }

        .my_teachers_details_info h1 {
            margin: 0 0 6px;
            font-size: 30px;
            font-weight: 600;
            line-height: 1.15;
        }

        .my_teachers_details_stats {
            color: var(--my_teachers_details_muted);
            font-size: 15px;
            margin-bottom: 10px;
        }

        .my_teachers_details_bio {
            color: var(--my_teachers_details_muted);
            font-size: 15px;
            line-height: 1.55;
            max-width: 750px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* buttons below bio */
        .my_teachers_details_actions {
            display: flex;
            gap: 12px;
            margin-top: 18px;
            position: relative;
        }

        .my_teachers_details_btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 26px;
            border-radius: var(--my_teachers_details_radius);
            font-size: 16px;
            font-weight: 500;
            border: 2px solid var(--my_teachers_details_border);
            box-shadow: var(--my_teachers_details_shadow);
            cursor: pointer;
            transition: transform .06s ease;
        }

        .my_teachers_details_btn:active {
            transform: translateY(1px);
        }

        .my_teachers_details_btn--subscribe {
            background: var(--my_teachers_details_accent);
            color: #fff;
            border: 2px solid black;
        }

        .my_teachers_details_btn--follow {
            background: #fff;
            color: #111;
        }

        /* dropdown menu */
        .my_teachers_details_menu {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            background: #fff;
            border: 1px solid var(--my_teachers_details_soft_border);
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, .08);
            padding: 8px 0;
            width: 200px;
            display: none;
            z-index: 10;
        }

        .my_teachers_details_menu_item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 15px;
            cursor: pointer;
            color: #111;
        }

        .my_teachers_details_menu_item:hover {
            background: #f7f8fa;
        }

        .my_teachers_details_menu_item svg {
            width: 18px;
            height: 18px;
        }
    </style>
</head>

<body>

    <div class="my_teachers_details_top_rule"></div>

    <section class="my_teachers_details_profile">
        <div class="my_teachers_details_avatar">
            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=300&auto=format&fit=crop" alt="Profile">
        </div>

        <div class="my_teachers_details_info">
            <h1>Daniela Canelon</h1>
            <p class="my_teachers_details_stats">500 Followers • 20 vedios</p>
            <p class="my_teachers_details_bio">
                Hi, I'm Daniela Canelon, an experienced English teacher with over 10 years of helping students from all over the world achieve their language goals. I hold a Master's degree in Linguistics and have a passion for making learning fun and meaningful.
            </p>

            <!-- buttons below bio -->
            <div class="my_teachers_details_actions">
                <button id="my_teachers_details_subscribe_btn"
                    class="my_teachers_details_btn my_teachers_details_btn--subscribe"
                    aria-haspopup="menu" aria-expanded="false">
                    Subscribe
                </button>

                <button class="my_teachers_details_btn my_teachers_details_btn--follow">Follow</button>

                <!-- ✅ Your dropdown (now with data-tab on items) -->
                <div id="my_teachers_details_menu" class="my_teachers_details_menu" role="menu" aria-label="Subscribe menu">
                    <div class="my_teachers_details_menu_item" role="menuitem" tabindex="0" data-tab="oneonone">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="4" width="14" height="10" rx="2" stroke="#222" stroke-width="1.6" />
                            <path d="M10 16l-2 4m6-4l2 4" stroke="#222" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                        1:1 Class
                    </div>

                    <div class="my_teachers_details_menu_item" role="menuitem" tabindex="0" data-tab="groups">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="8" r="3" stroke="#222" stroke-width="1.6" />
                            <path d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6" stroke="#222" stroke-width="1.6" stroke-linecap="round" />
                            <circle cx="5" cy="10" r="2" stroke="#222" stroke-width="1.6" />
                            <circle cx="19" cy="10" r="2" stroke="#222" stroke-width="1.6" />
                        </svg>
                        Groups
                    </div>
                </div>



            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // toggle dropdown
        (function() {
            var $btn = $('#my_teachers_details_subscribe_btn');
            var $menu = $('#my_teachers_details_menu');

            $btn.on('click', function(e) {
                e.stopPropagation();
                var open = $menu.is(':visible');
                if (open) {
                    $menu.hide();
                    $btn.attr('aria-expanded', 'false');
                } else {
                    $menu.show();
                    $btn.attr('aria-expanded', 'true');
                }
            });

            $(document).on('click', function() {
                $menu.hide();
                $btn.attr('aria-expanded', 'false');
            });

            $(window).on('resize scroll', function() {
                if ($menu.is(':visible')) $menu.hide();
            });
        })();
    </script>
</body>

</html>