<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>my_teachers_details – Tabs & Videos Grid</title>

    <style>
        :root {
            --my_teachers_details_text: #0e0e0e;
            --my_teachers_details_muted: #6f757d;
            --my_teachers_details_border: #e9eaee;
            --my_teachers_details_active: #ff3b2f;
            /* red underline */
            --my_teachers_details_card_bg: #fff;
            --my_teachers_details_radius: 5px;
            --my_teachers_details_shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .my_teachers_details_wrap {
            max-width: 1260px;
            margin: 0 auto;
            padding: 24px 18px 60px;
        }

        /* ------ Tabbar row ------ */
        .my_teachers_details_tabbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 1px solid var(--my_teachers_details_border);
            padding: 10px 6px 0;
            margin-bottom: 18px;
        }

        .my_teachers_details_tabs {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .my_teachers_details_tab {
            position: relative;
            padding: 12px 0 14px;
            font-size: 16px;
            /* font-weight: 700; */
            color: #7a8087;
            cursor: pointer;
            user-select: none;
        }

        .my_teachers_details_tab.my_teachers_details_active {
            color: var(--my_teachers_details_active);
        }

        .my_teachers_details_tab.my_teachers_details_active::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 3px;
            background: var(--my_teachers_details_active);
            border-radius: 3px;
        }

        /* Sort By pill (right) */
        .my_teachers_details_sort {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border: 1px solid #121212;
            border-radius: 5px;
            background: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .my_teachers_details_sort svg {
            width: 18px;
            height: 18px;
        }

        /* ------ Panels ------ */
        .my_teachers_details_panels {
            margin-top: 18px;
        }

        .my_teachers_details_panel {
            display: none;
        }

        .my_teachers_details_panel.my_teachers_details_show {
            display: block;
        }

        /* ------ Videos grid ------ */
        .my_teachers_details_grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px 26px;
        }

        @media (max-width:1024px) {
            .my_teachers_details_grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width:640px) {
            .my_teachers_details_grid {
                grid-template-columns: 1fr;
            }
        }

        .my_teachers_details_card {
            background: var(--my_teachers_details_card_bg);
        }

        .my_teachers_details_thumb_wrap {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #eef0f4;
        }

        .my_teachers_details_thumb {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        .my_teachers_details_duration {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background: #2b2b2b;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 10px;
            opacity: .95;
        }

        /* .my_teachers_details_title{
    margin:12px 4px 6px;
    font-size:20px; line-height:1.3; font-weight:800;
  } */
        .my_teachers_details_meta {
            margin: 0 4px;
            color: var(--my_teachers_details_muted);
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="my_teachers_details_wrap">

        <!-- Top tabbar -->
        <div class="my_teachers_details_tabbar" id="my_teachers_details_tabbar">
            <div class="my_teachers_details_tabs" role="tablist" aria-label="Teacher sections">
                <div class="my_teachers_details_tab my_teachers_details_active" role="tab"
                    data-tab="videos" aria-selected="true" tabindex="0">videos</div>
                <div class="my_teachers_details_tab" role="tab" data-tab="courses" tabindex="0">Courses</div>
                <div class="my_teachers_details_tab" role="tab" data-tab="groups" tabindex="0">Groups</div>
                <div class="my_teachers_details_tab" role="tab" data-tab="oneonone" tabindex="0">1:1 Classes</div>
            </div>

            <!-- Sort By pill (as in screenshot) -->
            <button class="my_teachers_details_sort" id="my_teachers_details_sort_btn" type="button" aria-haspopup="listbox" aria-expanded="false">
                <span>Sort By : Latest</span>
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 10l5 5 5-5" stroke="#111" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <!-- Panels -->
        <div class="my_teachers_details_panels">

            <!-- VIDEOS (default visible) -->
            <section id="my_teachers_details_panel_videos" class="my_teachers_details_panel my_teachers_details_show" role="tabpanel" aria-label="Videos">
                <div class="my_teachers_details_grid">
                    <!-- Card 1 -->
                    <article class="my_teachers_details_card">
                        <div class="my_teachers_details_thumb_wrap">
                            <img class="my_teachers_details_thumb" src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=1200&auto=format&fit=crop" alt="">
                            <span class="my_teachers_details_duration">12:24</span>
                        </div>
                        <h3 class="my_teachers_details_title">Master English Pronunciation in 30 Minutes</h3>
                        <p class="my_teachers_details_meta">2k views • 1 day ago</p>
                    </article>

                    <!-- Card 2 -->
                    <article class="my_teachers_details_card">
                        <div class="my_teachers_details_thumb_wrap">
                            <img class="my_teachers_details_thumb" src="https://images.unsplash.com/photo-1516387938699-a93567ec168e?q=80&w=1200&auto=format&fit=crop" alt="">
                            <span class="my_teachers_details_duration">12:24</span>
                        </div>
                        <h3 class="my_teachers_details_title">Top 10 English Idioms You Need to Know</h3>
                        <p class="my_teachers_details_meta">2k views • 2 day ago</p>
                    </article>

                    <!-- Card 3 -->
                    <article class="my_teachers_details_card">
                        <div class="my_teachers_details_thumb_wrap">
                            <img class="my_teachers_details_thumb" src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?q=80&w=1200&auto=format&fit=crop" alt="">
                            <span class="my_teachers_details_duration">12:24</span>
                        </div>
                        <h3 class="my_teachers_details_title">Boost Your Vocabulary with These 15 Powerful Words</h3>
                        <p class="my_teachers_details_meta">2k views • 2 day ago</p>
                    </article>

                    <!-- Card 4 -->
                    <article class="my_teachers_details_card">
                        <div class="my_teachers_details_thumb_wrap">
                            <img class="my_teachers_details_thumb" src="https://images.unsplash.com/photo-1520975936060-7da4a4d1ab30?q=80&w=1200&auto=format&fit=crop" alt="">
                            <span class="my_teachers_details_duration">12:24</span>
                        </div>
                        <h3 class="my_teachers_details_title">How to Ace Your IELTS Speaking Test: Tips & Tricks</h3>
                        <p class="my_teachers_details_meta">2k views • 5 day ago</p>
                    </article>

                    <!-- Card 5 -->
                    <article class="my_teachers_details_card">
                        <div class="my_teachers_details_thumb_wrap">
                            <img class="my_teachers_details_thumb" src="https://images.unsplash.com/photo-1510915228340-29c85a43dcfe?q=80&w=1200&auto=format&fit=crop" alt="">
                            <span class="my_teachers_details_duration">12:24</span>
                        </div>
                        <h3 class="my_teachers_details_title">Understanding English Tenses: A Beginner’s Guide</h3>
                        <p class="my_teachers_details_meta">2k views • 1 week ago</p>
                    </article>

                    <!-- Card 6 -->
                    <article class="my_teachers_details_card">
                        <div class="my_teachers_details_thumb_wrap">
                            <img class="my_teachers_details_thumb" src="https://images.unsplash.com/photo-1517433670267-08bbd4be890f?q=80&w=1200&auto=format&fit=crop" alt="">
                            <span class="my_teachers_details_duration">12:24</span>
                        </div>
                        <h3 class="my_teachers_details_title">Fluent English Conversations: Practice with Real-Life Scenarios</h3>
                        <p class="my_teachers_details_meta">2k views • 2 weeks ago</p>
                    </article>
                </div>
            </section>

            <!-- COURSES -->
            <section id="my_teachers_details_panel_courses" class="my_teachers_details_panel" role="tabpanel" aria-label="Courses">
                <?php require_once('my_teachers_details_tab_courses_details.php'); ?>
            </section>

            <!-- GROUPS -->
            <section id="my_teachers_details_panel_groups" class="my_teachers_details_panel" role="tabpanel" aria-label="Groups">
                <?php require_once('my_teachers_details_tab_groups_details.php'); ?>
            </section>

            <!-- 1:1 CLASSES -->
            <section id="my_teachers_details_panel_oneonone" class="my_teachers_details_panel" role="tabpanel" aria-label="1:1 Classes">
                <?php require_once('my_teachers_details_tab_one_and_one_class_details.php'); ?>
                <!-- <h3 style="margin:16px 4px 8px;font-size:22px;font-weight:800;">1:1 Classes</h3>
                <p style="margin:0 4px;color:#60656c;">This is placeholder content for 1:1 Classes. Replace with your sessions grid or schedule.</p>
 -->

            </section>

        </div>
    </div>

    <script>
        // ---- Tabs behavior (click & keyboard) ----
        (function() {
            var tabs = document.querySelectorAll('.my_teachers_details_tab');
            var panels = {
                videos: document.getElementById('my_teachers_details_panel_videos'),
                courses: document.getElementById('my_teachers_details_panel_courses'),
                groups: document.getElementById('my_teachers_details_panel_groups'),
                oneonone: document.getElementById('my_teachers_details_panel_oneonone')
            };

            // ✅ Expose globally so other UI (dropdown) can switch tabs
            window.my_teachers_details_showTab = function(name) {
                if (!panels[name]) return;
                // activate tab
                tabs.forEach(function(t) {
                    var isActive = t.dataset.tab === name;
                    t.classList.toggle('my_teachers_details_active', isActive);
                    t.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
                // show panel
                Object.keys(panels).forEach(function(k) {
                    panels[k].classList.toggle('my_teachers_details_show', k === name);
                });
                // optional: scroll into view of tabbar
                // document.getElementById('my_teachers_details_tabbar')?.scrollIntoView({behavior:'smooth', block:'start'});
            };

            // existing tab clicks/keyboard
            tabs.forEach(function(t) {
                t.addEventListener('click', function() {
                    window.my_teachers_details_showTab(t.dataset.tab);
                });
                t.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        window.my_teachers_details_showTab(t.dataset.tab);
                    }
                });
            });
        })();

        // ---- Wire the dropdown to switch tabs ----
        (function() {
            var menu = document.getElementById('my_teachers_details_menu');
            if (!menu) return;

            // Click
            menu.addEventListener('click', function(e) {
                var item = e.target.closest('.my_teachers_details_menu_item');
                if (!item) return;
                var tab = item.getAttribute('data-tab');
                if (tab) window.my_teachers_details_showTab(tab);
            });

            // Keyboard (Enter/Space)
            menu.addEventListener('keydown', function(e) {
                if (e.key !== 'Enter' && e.key !== ' ') return;
                var item = e.target.closest('.my_teachers_details_menu_item');
                if (!item) return;
                e.preventDefault();
                var tab = item.getAttribute('data-tab');
                if (tab) window.my_teachers_details_showTab(tab);
            });
        })();
        
        // ---- Sort pill demo (kept as-is) ----
        (function() {
            var btn = document.getElementById('my_teachers_details_sort_btn');
            if (!btn) return;
            btn.addEventListener('click', function() {
                var expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                alert('Sort dropdown placeholder – wire your list here.');
            });
        })();
    </script>



</body>

</html>