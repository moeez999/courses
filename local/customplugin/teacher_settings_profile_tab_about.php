<?php //require_once('teacher_settings_profile_contact_info.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Profile – About</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_profile_about_text: #121117;
            --my_profile_about_muted: #6B7280;
            --my_profile_about_border: #E4E7EE;
            --my_profile_about_accent: #ff3b1f;
            --my_profile_about_radius: 10px;
            --my_profile_about_control_h: 52px;
            --my_profile_about_panel_shadow: 0 18px 50px rgba(17, 17, 23, .12), 0 8px 22px rgba(17, 17, 23, .08);
        }

        .my_profile_about_root {
            font-family: Inter, ui-sans-serif, system-ui, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        }

        .my_profile_about_field {
            box-sizing: border-box;
            height: var(--my_profile_about_control_h);
            border: 1.5px solid var(--my_profile_about_border);
            border-radius: 10px;
            outline: 0;
            transition: border-color .15s, box-shadow .15s;
            background: #fff;
        }

        .my_profile_about_field:focus {
            border-color: #B9C0D4;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .08)
        }

        .my_profile_about_sidebar_item {
            position: relative;
            border-left: 4px solid transparent;
            padding: .5rem 0 .5rem 1rem;
            border-radius: 8px;
            display: block;
        }

        .my_profile_about_sidebar_item.my_profile_about_active::before {
            content: "";
            position: absolute;
            left: -5px;
            top: 6px;
            width: 3px;
            height: 30px;
            background: var(--my_profile_about_accent);
            border-radius: 1px;
        }

        .my_profile_about_sidebar_item.my_profile_about_active {
            color: var(--my_profile_about_text);
            font-weight: 600;
            border-left-color: transparent;
        }

        .my_profile_about_card_shadow {
            box-shadow: 0 14px 42px rgba(0, 0, 0, .08), 0 8px 18px rgba(0, 0, 0, .06)
        }

        .my_profile_about_badge {
            background: #E8F0FF;
            color: #1F4CF0;
            font-weight: 600;
            border-radius: 9999px;
            padding: .2rem .5rem;
            font-size: .75rem
        }

        .my_profile_about_btn {
            height: 44px;
            border-radius: 12px;
            border: 2px solid #000;
        }

        .my_profile_about_btn_primary {
            background: var(--my_profile_about_accent);
            color: #fff;
            border: 2px solid #000;
        }

        .my_profile_about_helper {
            color: var(--my_profile_about_muted);
            font-size: .90rem;
        }

        .my_profile_about_label {
            font-size: .95rem;
            color: var(--my_profile_about_text);
            font-weight: 500;
            margin-bottom: .5rem
        }

        /* ===== OUTER LAYOUT: 70% (left) / 30% (right) ===== */
        .my_profile_about_layout {
            display: grid;
            grid-template-columns: 70% 30%;
            gap: 20px;
            position: relative;
            align-items: start;
            min-height: 100%;
        }

        /* Collapsed — keep same grid; hide left inner content only */
        .my_profile_about_layout.collapsed {
            grid-template-columns: 70% 30%;
        }

        /* LEFT 70% WRAPPER + BORDER */
        .my_profile_left_bundle {
            grid-column: 1;
            border: 1px solid var(--my_profile_about_border);
            border-radius: 14px;
            padding: 16px;
            background: #fff;
        }

        /* Nested grid (sidebar 220px + main 1fr) inside the 70% column */
        .my_profile_left_bundle_grid {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 20px;
            align-items: start;
        }

        /* RIGHT 30% PANEL (comes from included PHP) */
        .my_profile_about_right {
            grid-column: 2;
            width: 100%;
            position: static !important;
            top: auto;
            transition: all .2s ease;
        }

        @media(max-width:1024px) {
            .my_profile_about_layout {
                grid-template-columns: 1fr;
            }

            .my_profile_about_layout.collapsed {
                grid-template-columns: 1fr;
            }

            .my_profile_about_right {
                position: static;
                grid-column: auto;
                width: 100%;
            }
        }

        @media(max-width:768px) {
            .my_profile_about_layout {
                grid-template-columns: 1fr
            }

            .my_profile_about_right {
                position: static
            }
        }

        /* ===== shared custom dropdown ===== */
        .my_profile_about_dropdown_wrap {
            position: relative;
        }

        .my_profile_about_dropdown_display {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: 0 2.25rem 0 .75rem;
            cursor: pointer;
        }

        .my_profile_about_dropdown_chev {
            position: absolute;
            right: .6rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .my_profile_about_dropdown_panel {
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border: 1px solid var(--my_profile_about_border);
            border-radius: 12px;
            box-shadow: var(--my_profile_about_panel_shadow);
            z-index: 50;
            display: none;
        }

        .my_profile_about_dropdown_search {
            height: 46px;
            border: none;
            border-bottom: 1px solid var(--my_profile_about_border);
            outline: none;
            padding: 0 12px;
            border-radius: 12px 12px 0 0;
        }

        .my_profile_about_dropdown_list {
            max-height: 280px;
            overflow: auto;
            padding: 6px 0;
        }

        .my_profile_about_dropdown_item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            cursor: pointer;
        }

        .my_profile_about_dropdown_item:hover,
        .my_profile_about_dropdown_item[aria-selected="true"] {
            background: #F6F7FB;
        }

        .my_profile_about_dropdown_nores {
            padding: 14px 12px;
            color: var(--my_profile_about_muted);
            font-size: .93rem;
        }

        .my_profile_about_dropdown_wrap.open .my_profile_about_field {
            border-color: #B9C0D4;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
        }

        .my_profile_about_country_flag {
            width: 22px;
            height: 16px;
            border-radius: 3px;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .08);
            flex: 0 0 22px;
        }

        .my_profile_about_phone_prefix {
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 8px;
            border-radius: 8px;
            border: 1px solid var(--my_profile_about_border);
            background: #fff;
            height: 34px;
            cursor: pointer;
            z-index: 1;
        }

        .my_profile_about_phone_flag {
            width: 22px;
            height: 16px;
            border-radius: 3px;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .08);
        }

        .my_profile_about_phone_input {
            padding-left: 140px !important;
        }
        
        /* ===== Collapsible Top Bar ===== */
        .tps_bar {
            background: #F5F6F8;
            border: 1px solid var(--my_profile_about_border);
            border-radius: 12px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            cursor: pointer;
            user-select: none;
            width: 70%;
        }

        .tps_title {
            font-size: 1.05rem;
            font-weight: 600;
        }

        .tps_chev {
            transition: transform .15s ease;
        }

        .tps_bar[aria-expanded="false"] .tps_chev {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="my_profile_about_root bg-white text-[color:var(--my_profile_about_text)]">
    <div class="mx-auto px-4 md:px-6 lg:px-8 py-8">
        <!-- ===== Teacher Profile Setting top bar ===== -->
        <div id="tps_toggle" class="tps_bar mb-4" role="button" tabindex="0" aria-expanded="true"
            aria-controls="my_profile_about_left my_profile_about_center">
            <div class="tps_title">Teacher Profile Setting</div>
            <svg class="tps_chev" width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M5 12l5-6 5 6" stroke="#111827" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <!-- ===== OUTER GRID: 70% / 30% ===== -->
        <div class="my_profile_about_layout" id="my_profile_about_grid">

            <!-- LEFT 70%: wrapper with border -->
            <div class="my_profile_left_bundle">
                <div class="my_profile_left_bundle_grid">
                    <!-- LEFT NAV -->
                    <aside id="my_profile_about_left" class="my_profile_about_left">
                        <nav aria-label="Profile sections" class="space-y-1">
                            <a href="#about" data-tab="about" class="my_profile_about_tablink my_profile_about_sidebar_item my_profile_about_active text-[1.03rem]">About</a>
                            <a href="#photo" data-tab="photo" class="my_profile_about_tablink my_profile_about_sidebar_item text-[1.03rem] text-[color:var(--my_profile_about_muted)]">Photo</a>
                            <a href="#description" data-tab="description" class="my_profile_about_tablink my_profile_about_sidebar_item text-[1.03rem] text-[color:var(--my_profile_about_muted)]">Description</a>
                            <a href="#video" data-tab="video" class="my_profile_about_tablink my_profile_about_sidebar_item text-[1.03rem] text-[color:var(--my_profile_about_muted)]">Video</a>
                            <a href="#subjects" data-tab="subjects" class="my_profile_about_tablink my_profile_about_sidebar_item text-[1.03rem] text-[color:var(--my_profile_about_muted)]">Subjects</a>
                            <a href="#pricing" data-tab="pricing" class="my_profile_about_tablink my_profile_about_sidebar_item text-[1.03rem] text-[color:var(--my_profile_about_muted)]">Pricing</a>
                            <a href="#background" data-tab="background" class="my_profile_about_tablink my_profile_about_sidebar_item text-[1.03rem] text-[color:var(--my_profile_about_muted)]">Background</a>
                        </nav>
                    </aside>

                    <!-- CENTER MAIN -->
                    <main id="my_profile_about_center" class="my_profile_about_center space-y-8">
                        <section id="my_profile_about_tab_about" class="my_profile_about_tabpanel">
                            <h1 class="text-[2rem] md:text-[2.25rem] font-semibold tracking-tight">About</h1>
                            <p class="my_profile_about_helper mt-3 max-w-[680px]">
                                Start creating your public tutor profile. Your progress will be automatically saved as you complete each section.
                            </p>

                            <form class="mt-7 space-y-6" onsubmit="return false;">
                                <div>
                                    <label class="my_profile_about_label">First name</label>
                                    <input type="text" value="Karen" class="my_profile_about_field w-full px-4" />
                                </div>
                                <div>
                                    <label class="my_profile_about_label">Last name</label>
                                    <input type="text" value="Carelon" class="my_profile_about_field w-full px-4" />
                                </div>

                                <!-- Country -->
                                <div>
                                    <label class="my_profile_about_label">Country of birth • <span class="text-[color:var(--my_profile_about_muted)]">Optional</span></label>
                                    <div class="my_profile_about_dropdown_wrap" id="my_profile_about_country_wrap" data-open="false">
                                        <div class="my_profile_about_field my_profile_about_dropdown_display w-full" id="my_profile_about_country_display"
                                            role="combobox" aria-expanded="false" aria-controls="my_profile_about_country_panel" tabindex="0">
                                            <span class="my_profile_about_country_flag" id="my_profile_about_country_flag"></span>
                                            <span class="truncate" id="my_profile_about_country_text">USA</span>
                                            <svg class="my_profile_about_dropdown_chev" width="18" height="18" viewBox="0 0 20 20" fill="none">
                                                <path d="M5 7l5 6 5-6" stroke="#6B7280" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <input type="hidden" name="country_of_birth" id="my_profile_about_country_value" value="USA" />
                                        <div class="my_profile_about_dropdown_panel" id="my_profile_about_country_panel">
                                            <input type="text" placeholder="Search Country name" class="my_profile_about_dropdown_search w-full" id="my_profile_about_country_search" />
                                            <div class="my_profile_about_dropdown_list" id="my_profile_about_country_list" role="listbox"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timezone -->
                                <div>
                                    <label class="my_profile_about_label">Timezone • <span class="text-[color:var(--my_profile_about_muted)]">Optional</span></label>
                                    <div class="my_profile_about_dropdown_wrap" id="my_profile_about_tz_wrap" data-open="false">
                                        <div class="my_profile_about_field my_profile_about_dropdown_display w-full" id="my_profile_about_tz_display"
                                            role="combobox" aria-expanded="false" aria-controls="my_profile_about_tz_panel" tabindex="0">
                                            <span class="truncate" id="my_profile_about_tz_text">05:57 (GMT-4) – America, Caracas</span>
                                            <svg class="my_profile_about_dropdown_chev" width="18" height="18" viewBox="0 0 20 20" fill="none">
                                                <path d="M5 7l5 6 5-6" stroke="#6B7280" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <input type="hidden" name="timezone" id="my_profile_about_tz_value" value="05:57 (GMT-4) – America, Caracas" />
                                        <div class="my_profile_about_dropdown_panel" id="my_profile_about_tz_panel">
                                            <input type="text" placeholder="Search Timezone" class="my_profile_about_dropdown_search w-full" id="my_profile_about_tz_search" />
                                            <div class="my_profile_about_dropdown_list" id="my_profile_about_tz_list" role="listbox"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Languages -->
                                <div>
                                    <div class="flex items-end justify-between gap-4 flex-wrap">
                                        <div class="my_profile_about_label mb-1">Languages you speak • <span class="text-[color:var(--my_profile_about_muted)]">Optional</span></div>
                                        <button type="button" id="my_profile_about_add_lang_btn" class="text-[.95rem] underline decoration-1 hover:text-[color:var(--my_profile_about_accent)]">Add another language</button>
                                    </div>
                                    <div id="my_profile_about_lang_rows" class="mt-3 space-y-4"><!-- injected by JS --></div>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="my_profile_about_label">Phone number <span class="text-[color:var(--my_profile_about_muted)]">(optional)</span></label>
                                    <div class="relative">
                                        <div class="my_profile_about_phone_prefix" id="my_profile_about_phone_prefix" role="button" aria-haspopup="listbox" aria-expanded="false" tabindex="0">
                                            <span class="my_profile_about_phone_flag" id="my_profile_about_phone_flag"></span>
                                            <span id="my_profile_about_phone_dial">+58</span>
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                                <path d="M5 7l5 6 5-6" stroke="#6B7280" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>

                                        <input type="text" id="my_profile_about_phone_input" value="+58 424 696 775 5" class="my_profile_about_field my_profile_about_phone_input w-full pr-4" />

                                        <div class="my_profile_about_dropdown_panel" id="my_profile_about_phone_panel" style="left:8px; right:auto; width:360px;">
                                            <input type="text" placeholder="Search country" class="my_profile_about_dropdown_search w-full" id="my_profile_about_phone_search" />
                                            <div class="my_profile_about_dropdown_list" id="my_profile_about_phone_list" role="listbox"></div>
                                        </div>

                                        <input type="hidden" name="phone_country" id="my_profile_about_phone_country" value="VEN">
                                        <input type="hidden" name="phone_dial_code" id="my_profile_about_phone_code" value="+58">
                                    </div>
                                </div>

                                <div class="pt-1">
                                    <button class="my_profile_about_btn my_profile_about_btn_primary px-6 w-[150px] text-[1rem] font-semibold">Save</button>
                                </div>
                            </form>
                        </section>

                        <!-- PHP includes for other tabs -->
                        <section id="my_profile_about_tab_photo" class="my_profile_about_tabpanel hidden"><?php require_once('my_profile_photo_tab.php'); ?></section>
                        <section id="my_profile_about_tab_description" class="my_profile_about_tabpanel hidden"><?php require_once('my_profile_description_tab.php'); ?></section>
                        <section id="my_profile_about_tab_video" class="my_profile_about_tabpanel hidden"><?php require_once('my_profile_video_tab.php'); ?></section>
                        <section id="my_profile_about_tab_subjects" class="my_profile_about_tabpanel hidden"><?php require_once('my_profile_subjects_tab.php'); ?></section>
                        <section id="my_profile_about_tab_pricing" class="my_profile_about_tabpanel hidden"><?php require_once('my_profile_pricing_tab.php'); ?></section>
                        <section id="my_profile_about_tab_background" class="my_profile_about_tabpanel hidden"><?php require_once('my_profile_background_tab.php'); ?></section>
                    </main>
                </div>
            </div>

            <!-- ===== RIGHT 30%: included inside the grid so it stays beside, not below ===== -->
            <?php require_once('teacher_settings_profile_contact_info.php'); ?>

        </div>

        <!-- (If you still need the overview include, keep it here; it won’t affect the 70/30 grid) -->
        <?php require_once('teacher_settings_profile_teacher_profile_overview.php'); ?>

    </div>

    <script>
        /* ===========================
       Collapsible Top Bar
       =========================== */
        function setCollapsedState(collapsed) {
            const $left = $('#my_profile_about_left');
            const $center = $('#my_profile_about_center');
            const $grid = $('#my_profile_about_grid');
            const $bar = $('#tps_toggle');

            if (collapsed) {
                $left.addClass('hidden');
                $center.addClass('hidden');
                $grid.addClass('collapsed');
                $bar.attr('aria-expanded', 'false');
            } else {
                $left.removeClass('hidden');
                $center.removeClass('hidden');
                $grid.removeClass('collapsed');
                $bar.attr('aria-expanded', 'true');
            }
        }

        $(document).on('click keydown', '#tps_toggle', function(e) {
            if (e.type === 'keydown' && !['Enter', ' '].includes(e.key)) return;
            e.preventDefault();
            const collapsed = $(this).attr('aria-expanded') === 'true';
            setCollapsedState(collapsed);
        });

        /* ===========================
           TABS
           =========================== */
        function my_profile_about_activateTab(tab) {
            $('.my_profile_about_tablink')
                .removeClass('my_profile_about_active')
                .addClass('text-[color:var(--my_profile_about_muted)]');
            $('.my_profile_about_tablink[data-tab="' + tab + '"]')
                .addClass('my_profile_about_active')
                .removeClass('text-[color:var(--my_profile_about_muted)]');

            $('.my_profile_about_tabpanel').addClass('hidden');
            $('#my_profile_about_tab_' + tab).removeClass('hidden');
        }

        function my_profile_about_bindTabs() {
            $('.my_profile_about_tablink').off('click').on('click', function(e) {
                e.preventDefault();
                const t = $(this).data('tab');
                if (history.pushState) {
                    history.pushState(null, '', '#' + t);
                } else {
                    location.hash = '#' + t;
                }
                my_profile_about_activateTab(t);
            });

            const initial = (location.hash || '').replace('#', '') || 'about';
            const validTabs = ['about', 'photo', 'description', 'video', 'subjects', 'pricing', 'background'];
            my_profile_about_activateTab(validTabs.includes(initial) ? initial : 'about');

            $(window).on('hashchange', function() {
                const t = (location.hash || '').replace('#', '') || 'about';
                my_profile_about_activateTab(t);
            });
        }

        /* ===== country dataset + flags ===== */
        const my_profile_about_countries = [{
                code: 'USA',
                name: 'United States',
                dial: '+1'
            },
            {
                code: 'GBR',
                name: 'United Kingdom',
                dial: '+44'
            },
            {
                code: 'PAK',
                name: 'Pakistan',
                dial: '+92'
            },
            {
                code: 'AFG',
                name: 'Afghanistan',
                dial: '+93'
            },
            {
                code: 'VEN',
                name: 'Venezuela',
                dial: '+58'
            },
            {
                code: 'CAN',
                name: 'Canada',
                dial: '+1'
            },
            {
                code: 'ESP',
                name: 'Spain',
                dial: '+34'
            },
            {
                code: 'FRA',
                name: 'France',
                dial: '+33'
            },
            {
                code: 'DEU',
                name: 'Germany',
                dial: '+49'
            },
            {
                code: 'ITA',
                name: 'Italy',
                dial: '+39'
            },
            {
                code: 'UAE',
                name: 'United Arab Emirates',
                dial: '+971'
            },
            {
                code: 'IND',
                name: 'India',
                dial: '+91'
            }
        ];

        function my_profile_about_flagSVG(code) {
            switch (code) {
                case 'FRA':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="1" height="2" fill="#002395"/><rect x="1" width="1" height="2" fill="#fff"/><rect x="2" width="1" height="2" fill="#ED2939"/></svg>`;
                case 'DEU':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="3" height="2" fill="#000"/><rect y="0.666" width="3" height="0.666" fill="#DD0000"/><rect y="1.333" width="3" height="0.667" fill="#FFCE00"/></svg>`;
                case 'AFG':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="1" height="2" fill="#000"/><rect x="1" width="1" height="2" fill="#D32011"/><rect x="2" width="1" height="2" fill="#007A36"/><circle cx="1.5" cy="1" r="0.18" fill="#fff"/></svg>`;
                case 'USA':
                    return `<svg width="22" height="16" viewBox="0 0 190 100"><rect width="190" height="100" fill="#b22234"/><g fill="#fff"><rect y="10" width="190" height="10"/><rect y="30" width="190" height="10"/><rect y="50" width="190" height="10"/><rect y="70" width="190" height="10"/><rect y="90" width="190" height="10"/></g><rect width="76" height="53" fill="#3c3b6e"/></svg>`;
                case 'PAK':
                    return `<svg width="22" height="16" viewBox="0 0 30 20"><rect width="30" height="20" fill="#01411C"/><rect width="5" height="20" fill="#fff"/><path d="M18 10a5.5 5.5 0 11-3.5-10 6.5 6.5 0 100 13 5.5 5.5 0 003.5-3z" fill="#fff"/><path d="M18.7 7.4l1 .6-.4-1.1 1-.6-1.2-.1-.4-1.1-.4 1.1-1.2.1 1 .6-.4 1.1 1-.6z" fill="#fff"/></svg>`;
                case 'GBR':
                    return `<svg width="22" height="16" viewBox="0 0 60 30"><path d="M0 0h60v30H0z" fill="#012169"/><path d="M0 0l60 30m0-30L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0l60 30m0-30L0 30" stroke="#C8102E" stroke-width="4"/><path d="M30 0v30M0 15h60" stroke="#fff" stroke-width="10"/><path d="M30 0v30M0 15h60" stroke="#C8102E" stroke-width="6"/></svg>`;
                case 'CAN':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="0.5" height="2" fill="#D52B1E"/><rect x="2.5" width="0.5" height="2" fill="#D52B1E"/><rect x="0.5" width="2" height="2" fill="#fff"/><path d="M1.5.35l.09.22h.23l-.18.14.07.22-.21-.13-.21.13.07-.22-.18-.14h.23z" fill="#D52B1E"/></svg>`;
                case 'VEN':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="3" height="2" fill="#CF142B"/><rect y="0.667" width="3" height="0.666" fill="#00247D"/><rect y="0" width="3" height="0.667" fill="#FFCC00"/></svg>`;
                case 'ESP':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="3" height="2" fill="#AA151B"/><rect y="0.5" width="3" height="1" fill="#F1BF00"/></svg>`;
                case 'ITA':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="1" height="2" fill="#009246"/><rect x="1" width="1" height="2" fill="#fff"/><rect x="2" width="1" height="2" fill="#ce2b37"/></svg>`;
                case 'UAE':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect x="0" y="0" width="3" height="0.666" fill="#00732F"/><rect y="0.666" width="3" height="0.666" fill="#fff"/><rect y="1.333" width="3" height="0.667" fill="#000"/><rect width="0.6" height="2" fill="#FF0000"/></svg>`;
                case 'IND':
                    return `<svg width="22" height="16" viewBox="0 0 3 2"><rect width="3" height="2" fill="#FF9933"/><rect y="0.666" width="3" height="0.666" fill="#fff"/><rect y="1.333" width="3" height="0.667" fill="#128807"/><circle cx="1.5" cy="1" r="0.18" fill="#00008B"/></svg>`;
                default:
                    return `<svg width="22" height="16"><rect width="22" height="16" fill="#F3F4F6"/></svg>`;
            }
        }

        function my_profile_about_renderCountryItem(c, active) {
            return `<div class="my_profile_about_dropdown_item" role="option" data-code="${c.code}" data-name="${c.name}" aria-selected="${active?'true':'false'}"><span class="my_profile_about_country_flag">${my_profile_about_flagSVG(c.code)}</span><span>${c.name}</span></div>`;
        }

        function my_profile_about_openCountryPanel(open) {
            const w = $('#my_profile_about_country_wrap'),
                p = $('#my_profile_about_country_panel'),
                d = $('#my_profile_about_country_display');
            if (open) {
                w.addClass('open').attr('data-open', 'true');
                d.attr('aria-expanded', 'true');
                p.stop(true, true).fadeIn(100);
                $('#my_profile_about_country_search').val('').trigger('input').focus();
            } else {
                w.removeClass('open').attr('data-open', 'false');
                d.attr('aria-expanded', 'false');
                p.stop(true, true).fadeOut(100);
            }
        }

        function my_profile_about_setCountry(code, name) {
            $('#my_profile_about_country_value').val(name);
            $('#my_profile_about_country_text').text(name);
            $('#my_profile_about_country_flag').html(my_profile_about_flagSVG(code));
        }

        function my_profile_about_buildCountryList(list, filter = '') {
            const norm = s => s.toLowerCase().normalize('NFD').replace(/\p{Diacritic}/gu, '');
            const q = norm(filter);
            const res = my_profile_about_countries
                .filter(c => norm(c.name).includes(q))
                .sort((a, b) => a.name.localeCompare(b.name));
            list.html(res.length ? res.map((c, i) => my_profile_about_renderCountryItem(c, i === 0)).join('') : `<div class="my_profile_about_dropdown_nores">No results</div>`);
        }

        /* ===== timezone dataset ===== */
        const my_profile_about_tz_list = [
            "05:57 (GMT-4) – America, Caracas",
            "(GMT+05:00) Kazakhstan Time –", "(GMT+05:00) Maldives Time", "(GMT+05:00) Pakistan Standard Time",
            "(GMT+05:00) Tajikistan Time", "(GMT+05:00) Turkmenistan  Time", "(GMT+05:00) Vostok Time", "(GMT+05:00) Yekaterinburg  Time",
            "(GMT+01:00) Central European Time – Berlin", "(GMT+00:00) UTC", "(GMT-05:00) Eastern Time – New York", "(GMT+04:00) Gulf Standard Time – Dubai"
        ];

        function my_profile_about_renderTzItem(label, active) {
            return `<div class="my_profile_about_dropdown_item" role="option" data-tz="${label.replace(/"/g,'&quot;')}" aria-selected="${active?'true':'false'}"><span>${label}</span></div>`;
        }

        function my_profile_about_openTzPanel(open) {
            const w = $('#my_profile_about_tz_wrap'),
                p = $('#my_profile_about_tz_panel'),
                d = $('#my_profile_about_tz_display');
            if (open) {
                w.addClass('open').attr('data-open', 'true');
                d.attr('aria-expanded', 'true');
                p.stop(true, true).fadeIn(100);
                $('#my_profile_about_tz_search').val('').trigger('input').focus();
            } else {
                w.removeClass('open').attr('data-open', 'false');
                d.attr('aria-expanded', 'false');
                p.stop(true, true).fadeOut(100);
            }
        }

        function my_profile_about_setTz(label) {
            $('#my_profile_about_tz_value').val(label);
            $('#my_profile_about_tz_text').text(label);
        }

        function my_profile_about_buildTzList($list, filter = '') {
            const q = filter.toLowerCase();
            const res = my_profile_about_tz_list.filter(s => s.toLowerCase().includes(q));
            $list.html(res.length ? res.map((t, i) => my_profile_about_renderTzItem(t, i === 0)).join('') : `<div class="my_profile_about_dropdown_nores">No results</div>`);
        }

        /* ===== languages + levels ===== */
        const my_profile_about_languages = ["English", "Spanish", "French", "German", "Portuguese", "Arabic", "Urdu", "Hindi", "Chinese", "Japanese", "Korean", "Italian", "Russian", "Turkish", "Persian"];
        const my_profile_about_levels = ["Native", "C2 (Proficient)", "C1 (Advanced)", "B2 (Upper Intermediate)", "B1 (Intermediate)", "A2 (Elementary)", "A1 (Beginner)"];

        function my_profile_about_renderSimpleItem(text, active) {
            return `<div class="my_profile_about_dropdown_item" role="option" data-label="${text.replace(/"/g,'&quot;')}" aria-selected="${active?'true':'false'}"><span>${text}</span></div>`;
        }

        function my_profile_about_languageRowTemplate(rowId, langDefault = "English", levelDefault = "B2 (Upper Intermediate)") {
            return `
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4" data-row="${rowId}">
        <div class="my_profile_about_dropdown_wrap" id="my_profile_about_lang_wrap_${rowId}" data-open="false">
          <div class="my_profile_about_field my_profile_about_dropdown_display w-full" id="my_profile_about_lang_display_${rowId}" role="combobox" aria-expanded="false" aria-controls="my_profile_about_lang_panel_${rowId}" tabindex="0">
            <span class="truncate" id="my_profile_about_lang_text_${rowId}">${langDefault}</span>
            <svg class="my_profile_about_dropdown_chev" width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M5 7l5 6 5-6" stroke="#6B7280" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <input type="hidden" name="languages[${rowId}][name]" id="my_profile_about_lang_value_${rowId}" value="${langDefault}"/>
          <div class="my_profile_about_dropdown_panel" id="my_profile_about_lang_panel_${rowId}">
            <div class="my_profile_about_dropdown_list" id="my_profile_about_lang_list_${rowId}" role="listbox"></div>
          </div>
        </div>
        <div class="my_profile_about_dropdown_wrap" id="my_profile_about_level_wrap_${rowId}" data-open="false">
          <div class="my_profile_about_field my_profile_about_dropdown_display w-full" id="my_profile_about_level_display_${rowId}" role="combobox" aria-expanded="false" aria-controls="my_profile_about_level_panel_${rowId}" tabindex="0">
            <span class="truncate" id="my_profile_about_level_text_${rowId}">${levelDefault}</span>
            <svg class="my_profile_about_dropdown_chev" width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M5 7l5 6 5-6" stroke="#6B7280" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <input type="hidden" name="languages[${rowId}][level]" id="my_profile_about_level_value_${rowId}" value="${levelDefault}"/>
          <div class="my_profile_about_dropdown_panel" id="my_profile_about_level_panel_${rowId}">
            <div class="my_profile_about_dropdown_list" id="my_profile_about_level_list_${rowId}" role="listbox"></div>
          </div>
        </div>
      </div>`;
        }

        function my_profile_about_buildLanguageList(rowId) {
            $(`#my_profile_about_lang_list_${rowId}`).html(my_profile_about_languages.map((t, i) => my_profile_about_renderSimpleItem(t, i === 0)).join(''));
        }

        function my_profile_about_buildLevelList(rowId) {
            $(`#my_profile_about_level_list_${rowId}`).html(my_profile_about_levels.map((t, i) => my_profile_about_renderSimpleItem(t, i === 0)).join(''));
        }

        function my_profile_about_openPanel(idPrefix, rowId, open) {
            const wrap = $(`#${idPrefix}_wrap_${rowId}`),
                panel = $(`#${idPrefix}_panel_${rowId}`),
                display = $(`#${idPrefix}_display_${rowId}`);
            if (open) {
                wrap.addClass('open').attr('data-open', 'true');
                display.attr('aria-expanded', 'true');
                panel.stop(true, true).fadeIn(100);
            } else {
                wrap.removeClass('open').attr('data-open', 'false');
                display.attr('aria-expanded', 'false');
                panel.stop(true, true).fadeOut(100);
            }
        }

        function my_profile_about_setValue(idPrefix, rowId, value) {
            $(`#${idPrefix}_value_${rowId}`).val(value);
            $(`#${idPrefix}_text_${rowId}`).text(value);
        }
        let my_profile_about_row_counter = 0;

        function my_profile_about_addLanguageRow(langDefault = "English", levelDefault = "B2 (Upper Intermediate)") {
            const rowId = ++my_profile_about_row_counter;
            $('#my_profile_about_lang_rows').append(my_profile_about_languageRowTemplate(rowId, langDefault, levelDefault));
            my_profile_about_buildLanguageList(rowId);
            my_profile_about_buildLevelList(rowId);
            $(`#my_profile_about_lang_display_${rowId}`).on('click', () => my_profile_about_openPanel('my_profile_about_lang', rowId, $(`#my_profile_about_lang_wrap_${rowId}`).attr('data-open') !== 'true'));
            $(`#my_profile_about_level_display_${rowId}`).on('click', () => my_profile_about_openPanel('my_profile_about_level', rowId, $(`#my_profile_about_level_wrap_${rowId}`).attr('data-open') !== 'true'));
            $(`#my_profile_about_lang_list_${rowId}`).on('click', '.my_profile_about_dropdown_item', function() {
                my_profile_about_setValue('my_profile_about_lang', rowId, $(this).data('label'));
                my_profile_about_openPanel('my_profile_about_lang', rowId, false);
            });
            $(`#my_profile_about_level_list_${rowId}`).on('click', '.my_profile_about_dropdown_item', function() {
                my_profile_about_setValue('my_profile_about_level', rowId, $(this).data('label'));
                my_profile_about_openPanel('my_profile_about_level', rowId, false);
            });
        }

        /* ===== phone dropdown ===== */
        function my_profile_about_renderPhoneItem(c, active) {
            return `<div class="my_profile_about_dropdown_item" role="option" data-code="${c.code}" data-name="${c.name}" data-dial="${c.dial}" aria-selected="${active?'true':'false'}">
        <span class="my_profile_about_phone_flag">${my_profile_about_flagSVG(c.code)}</span>
        <span class="flex-1">${c.name}</span>
        <span class="text-[color:var(--my_profile_about_muted)]">${c.dial}</span>
      </div>`;
        }

        function my_profile_about_buildPhoneList(filter = '') {
            const norm = s => s.toLowerCase().normalize('NFD').replace(/\p{Diacritic}/gu, '');
            const q = norm(filter);
            const res = my_profile_about_countries.filter(c => norm(c.name).includes(q) || c.dial.includes(filter));
            const html = res.map((c, i) => my_profile_about_renderPhoneItem(c, i === 0)).join('');
            $('#my_profile_about_phone_list').html(html || `<div class="my_profile_about_dropdown_nores">No results</div>`);
        }

        function my_profile_about_openPhonePanel(open) {
            const panel = $('#my_profile_about_phone_panel');
            const chip = $('#my_profile_about_phone_prefix');
            if (open) {
                chip.attr('aria-expanded', 'true');
                panel.stop(true, true).fadeIn(100);
                $('#my_profile_about_phone_search').val('').trigger('input').focus();
            } else {
                chip.attr('aria-expanded', 'false');
                panel.stop(true, true).fadeOut(100);
            }
        }

        function my_profile_about_setPhoneCountry(code, dial) {
            $('#my_profile_about_phone_country').val(code);
            $('#my_profile_about_phone_code').val(dial);
            $('#my_profile_about_phone_flag').html(my_profile_about_flagSVG(code));
            $('#my_profile_about_phone_dial').text(dial);
            const $inp = $('#my_profile_about_phone_input');
            const val = $inp.val();
            const newVal = val.replace(/^\+\d+/, dial).trim();
            if (newVal.match(/^\+\d/)) {
                $inp.val(newVal);
            } else {
                $inp.val(`${dial} ${val.replace(/^\+?\s*/,'')}`);
            }
        }

        /* ===== init everything ===== */
        $(function() {
            // tabs
            my_profile_about_bindTabs();

            // Country
            $('#my_profile_about_country_flag').html(my_profile_about_flagSVG('USA'));
            const $countryList = $('#my_profile_about_country_list');
            my_profile_about_buildCountryList($countryList, '');
            $('#my_profile_about_country_display')
                .on('click', () => my_profile_about_openCountryPanel($('#my_profile_about_country_wrap').attr('data-open') !== 'true'))
                .on('keydown', e => {
                    if (['Enter', ' '].includes(e.key)) {
                        e.preventDefault();
                        my_profile_about_openCountryPanel($('#my_profile_about_country_wrap').attr('data-open') !== 'true');
                    } else if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        my_profile_about_openCountryPanel(true);
                    }
                });
            $('#my_profile_about_country_search').on('input', function() {
                my_profile_about_buildCountryList($countryList, $(this).val());
            });
            $(document).on('click', '.my_profile_about_dropdown_item[data-name]', function() {
                if ($(this).closest('#my_profile_about_country_panel').length) {
                    my_profile_about_setCountry($(this).data('code'), $(this).data('name'));
                    my_profile_about_openCountryPanel(false);
                }
            });

            // Timezone
            const $tzList = $('#my_profile_about_tz_list');
            my_profile_about_buildTzList($tzList, '');
            $('#my_profile_about_tz_display')
                .on('click', () => my_profile_about_openTzPanel($('#my_profile_about_tz_wrap').attr('data-open') !== 'true'))
                .on('keydown', e => {
                    if (['Enter', ' '].includes(e.key)) {
                        e.preventDefault();
                        my_profile_about_openTzPanel($('#my_profile_about_tz_wrap').attr('data-open') !== 'true');
                    } else if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        my_profile_about_openTzPanel(true);
                    }
                });
            $('#my_profile_about_tz_search').on('input', function() {
                my_profile_about_buildTzList($tzList, $(this).val());
            });
            $(document).on('click', '.my_profile_about_dropdown_item[data-tz]', function() {
                my_profile_about_setTz($(this).data('tz'));
                my_profile_about_openTzPanel(false);
            });

            // Languages rows
            my_profile_about_addLanguageRow("English", "B2 (Upper Intermediate)");
            my_profile_about_addLanguageRow("Spanish", "B2 (Upper Intermediate)");
            my_profile_about_addLanguageRow("German", "Native");
            $('#my_profile_about_add_lang_btn').on('click', () => my_profile_about_addLanguageRow());

            // Phone
            $('#my_profile_about_phone_flag').html(my_profile_about_flagSVG('VEN'));
            my_profile_about_buildPhoneList('');
            $('#my_profile_about_phone_prefix')
                .on('click', () => my_profile_about_openPhonePanel($('#my_profile_about_phone_panel').is(':hidden')))
                .on('keydown', e => {
                    if (['Enter', ' '].includes(e.key)) {
                        e.preventDefault();
                        my_profile_about_openPhonePanel($('#my_profile_about_phone_panel').is(':hidden'));
                    }
                });
            $('#my_profile_about_phone_search').on('input', function() {
                my_profile_about_buildPhoneList($(this).val());
            });
            $(document).on('click', '#my_profile_about_phone_list .my_profile_about_dropdown_item', function() {
                my_profile_about_setPhoneCountry($(this).data('code'), $(this).data('dial'));
                my_profile_about_openPhonePanel(false);
            });

            // Close on outside click / Esc for dropdowns
            $(document).on('mousedown', function(e) {
                if (!$('#my_profile_about_country_wrap').is(e.target) && $('#my_profile_about_country_wrap').has(e.target).length === 0) my_profile_about_openCountryPanel(false);
                if (!$('#my_profile_about_tz_wrap').is(e.target) && $('#my_profile_about_tz_wrap').has(e.target).length === 0) my_profile_about_openTzPanel(false);
                if (!$('#my_profile_about_phone_panel').is(e.target) && $('#my_profile_about_phone_panel').has(e.target).length === 0 && !$('#my_profile_about_phone_prefix').is(e.target)) my_profile_about_openPhonePanel(false);
                $('[id^="my_profile_about_lang_wrap_"],[id^="my_profile_about_level_wrap_"]').each(function() {
                    const $w = $(this);
                    if (!$w.is(e.target) && $w.has(e.target).length === 0) {
                        const id = $w.attr('id');
                        const row = id.split('_').pop();
                        if (id.startsWith('my_profile_about_lang')) my_profile_about_openPanel('my_profile_about_lang', row, false);
                        else my_profile_about_openPanel('my_profile_about_level', row, false);
                    }
                });
            });
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    my_profile_about_openCountryPanel(false);
                    my_profile_about_openTzPanel(false);
                    my_profile_about_openPhonePanel(false);
                    $('[id^="my_profile_about_lang_wrap_"],[id^="my_profile_about_level_wrap_"]').each(function() {
                        const id = $(this).attr('id');
                        const row = id.split('_').pop();
                        if (id.startsWith('my_profile_about_lang')) my_profile_about_openPanel('my_profile_about_lang', row, false);
                        else my_profile_about_openPanel('my_profile_about_level', row, false);
                    });
                }
            });

            // Ensure initial state is expanded
            setCollapsedState(false);
        });
    </script>
</body>

</html>