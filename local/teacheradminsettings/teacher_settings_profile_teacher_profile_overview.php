<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Teacher Profile Overview (Left Panel)</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>    
        :root {
            --teacher_settings_profile_teacher_profile_overview-text: #0F172A;
            --teacher_settings_profile_teacher_profile_overview-muted: #374151;
            --teacher_settings_profile_teacher_profile_overview-border: #E4E7EE;
            --teacher_settings_profile_teacher_profile_overview-soft: #FBE0DC;
            --teacher_settings_profile_teacher_profile_overview-card: #ffffff;
            --teacher_settings_profile_teacher_profile_overview-shadow: 0 2px 8px rgba(16, 24, 40, .06);
            --teacher_settings_profile_teacher_profile_overview-grid: #E5E7EB; 
            --teacher_settings_profile_teacher_profile_overview-blue: #1F6FEB;
            --teacher_settings_profile_teacher_profile_overview-blueDot: #1F6FEB;

            --teacher_settings_profile_teacher_profile_overview-mint: #D1FAE5;
            --teacher_settings_profile_teacher_profile_overview-mintBorder: #A7F3D0;
            --teacher_settings_profile_teacher_profile_overview-mintCheck: #065F46;

            --teacher_settings_profile_teacher_profile_overview-liveBg: #EAF1FF;
            --teacher_settings_profile_teacher_profile_overview-liveBorder: #C7D9FF;
            --teacher_settings_profile_teacher_profile_overview-liveIcon: #2B5BD7;

            /* notch sizing (new subscriptions) */
            --teacher_settings_profile_teacher_profile_overview-notchW: 25px;
            --teacher_settings_profile_teacher_profile_overview-notchH: 100px;
        }

        body {
            color: var(--teacher_settings_profile_teacher_profile_overview-text);
        }

        /* Top gray bar (separate) */
        .teacher_settings_profile_teacher_profile_overview-topbar {
            background: #F3F4F6;
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-border);
            border-radius: 16px;
        }

        /* White outer container */
        .teacher_settings_profile_teacher_profile_overview-panel {
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-border);
            border-radius: 20px;
            background: #fff;
            padding: 20px;
        }

        .teacher_settings_profile_teacher_profile_overview-section {
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-border);
            border-radius: 16px;
            background: #fff;
        }

        .teacher_settings_profile_teacher_profile_overview-soft {
            background: var(--teacher_settings_profile_teacher_profile_overview-soft);
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-soft);
        }

        .teacher_settings_profile_teacher_profile_overview-badge {
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-border);
            border-radius: 12px;
            padding: .7rem .9rem;
            background: #fff;
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            font-weight: 700;
            color: var(--teacher_settings_profile_teacher_profile_overview-text);
        }

        /* ====== GENERIC CARD ====== */
        .teacher_settings_profile_teacher_profile_overview-card {
            position: relative;
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-border);
            border-radius: 14px;
            background: #fff;
            box-shadow: var(--teacher_settings_profile_teacher_profile_overview-shadow);
            padding: 16px;
        }

        /* ====== KPI (COMPACT) ====== */
        .teacher_settings_profile_teacher_profile_overview-kpi {
            position: relative;
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-border);
            border-radius: 14px;
            background: #fff;
            box-shadow: var(--teacher_settings_profile_teacher_profile_overview-shadow);
            padding: 18px 16px;
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .kpi-title {
            font-size: 16px;
            font-weight: 700;
        }

        .kpi-sub {
            font-size: 12px;
            color: #6B7280;
            margin-top: 2px;
            line-height: 1.15;
        }

        .kpi-val {
            font-size: 30px;
            font-weight: 800;
            margin-top: 6px;
        }

        /* Small info icon (top-right) */
        .teacher_settings_profile_teacher_profile_overview-info {
            position: absolute;
            right: 12px;
            top: 12px;
            width: 20px;
            height: 20px;
            border-radius: 9999px;
            border: 1px solid #CBD5E1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #6B7280;
            background: #fff;
        }

        /* BADGE: green check */
        .teacher_settings_profile_teacher_profile_overview-badgeCheck {
            position: absolute;
            right: 14px;
            bottom: 14px;
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background: var(--teacher_settings_profile_teacher_profile_overview-mint);
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-mintBorder);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 2px rgba(16, 24, 40, .08);
        }

        .teacher_settings_profile_teacher_profile_overview-badgeCheck svg {
            width: 16px;
            height: 16px;
            stroke: var(--teacher_settings_profile_teacher_profile_overview-mintCheck);
            stroke-width: 2.5;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* BADGE: blue live spinner (used elsewhere) */
        .teacher_settings_profile_teacher_profile_overview-badgeLive {
            position: absolute;
            right: 14px;
            bottom: 14px;
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background: var(--teacher_settings_profile_teacher_profile_overview-liveBg);
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-liveBorder);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 2px rgba(16, 24, 40, .08);
        }

        .teacher_settings_profile_teacher_profile_overview-badgeLive svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: var(--teacher_settings_profile_teacher_profile_overview-liveIcon);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            animation: teacher_settings_profile_teacher_profile_overview-spin 1.4s linear infinite;
        }

        @keyframes teacher_settings_profile_teacher_profile_overview-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Chart visuals */
        .teacher_settings_profile_teacher_profile_overview-chart {
            width: 100%;
            height: 240px;
        }

        .teacher_settings_profile_teacher_profile_overview-x text,
        .teacher_settings_profile_teacher_profile_overview-y text {
            font-size: 11px;
            fill: #6B7280;
        }

        /* Journey icon badges */
        .teacher_settings_profile_teacher_profile_overview-emojiBadge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid var(--teacher_settings_profile_teacher_profile_overview-border);
            background: #fff;
            box-shadow: var(--teacher_settings_profile_teacher_profile_overview-shadow);
            font-size: 26px;
        }

        /* small live pill (used in other sections) */
        .teacher_settings_profile_teacher_profile_overview-livePill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #EAF1FF;
            border: 1px solid #D7E4FF;
            color: #1E3A8A;
            font-weight: 600;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 10px;
        }

        /* New subscriptions stacked diag notch */
        .teacher_settings_profile_teacher_profile_overview-stackedWrap {
            position: relative;
            overflow: hidden;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
        }

        .teacher_settings_profile_teacher_profile_overview-stackedWrap::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: var(--teacher_settings_profile_teacher_profile_overview-notchW);
            height: var(--teacher_settings_profile_teacher_profile_overview-notchH);
            background: #ffffff;
            border-top-right-radius: 14px;
            clip-path: polygon(100% 0, 0 0, 100% 100%);
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-[#F7F7FB] text-[15px] leading-6">

    <!-- Left-aligned container -->
    <div class="max-w-[980px] px-4 py-6">
        <div class="teacher_settings_profile_teacher_profile_overview-panel">

            <!-- Gray Top Bar -->
            <div class="teacher_settings_profile_teacher_profile_overview-topbar px-4 py-4 mb-4">
                <button id="teacher_settings_profile_teacher_profile_overview_header"
                    class="w-full flex items-center justify-between">
                    <span class="font-semibold text-[16px]">Teacher Profile Overview</span>
                    <svg id="teacher_settings_profile_teacher_profile_overview_chev" class="w-5 h-5 transition-transform" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- Collapsible Body -->
            <div id="teacher_settings_profile_teacher_profile_overview_body" class="space-y-4">

                <!-- ================= OVERVIEW (match snapshot) ================= -->
                <section class="teacher_settings_profile_teacher_profile_overview-section teacher_settings_profile_teacher_profile_overview-soft p-5">
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">
                        <!-- Left column -->
                        <div class="lg:col-span-2">
                            <h2 class="text-[32px] font-semibold">Overview</h2>
                            <p class="text-[15px] text-[#4B5563] -mt-1">Your business at a glance.</p>

                            <div class="mt-5">
                                <button id="teacher_settings_profile_teacher_profile_overview_range_btn"
                                    class="teacher_settings_profile_teacher_profile_overview-badge">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="4" width="18" height="17" rx="2" stroke="#111827" stroke-width="1.5" />
                                        <path d="M8 2v4M16 2v4M3 9h18" stroke="#111827" stroke-width="1.5" />
                                    </svg>
                                    <span>Last 90 days</span>
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none">
                                        <path d="M6 8l4 4 4-4" stroke="#111827" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- KPI row (4 compact cards like snapshot) -->
                        <div class="lg:col-span-3">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 md:gap-5">
                                <!-- Earnings -->
                                <div class="teacher_settings_profile_teacher_profile_overview-kpi">
                                    <div>
                                        <div class="kpi-title">Earnings</div>
                                    </div>
                                    <div class="kpi-val">$0</div>
                                </div>

                                <!-- Lessons -->
                                <div class="teacher_settings_profile_teacher_profile_overview-kpi">
                                    <div>
                                        <div class="kpi-title">Lessons</div>
                                    </div>
                                    <div class="kpi-val">0</div>
                                </div>

                                <!-- Active students with info icon -->
                                <div class="teacher_settings_profile_teacher_profile_overview-kpi">
                                    <div>
                                        <div class="kpi-title">Active<br />students</div>
                                        <span class="teacher_settings_profile_teacher_profile_overview-info">i</span>
                                    </div>
                                    <div class="kpi-val">0</div>
                                </div>

                                <!-- New students with info icon -->
                                <div class="teacher_settings_profile_teacher_profile_overview-kpi">
                                    <div>
                                        <div class="kpi-title">New<br />students</div>
                                        <span class="teacher_settings_profile_teacher_profile_overview-info">i</span>
                                    </div>
                                    <div class="kpi-val">0</div>
                                </div>
                            </div>

                            <p class="text-[12px] text-[#4B5563] mt-4">
                                Data from May 13 – August 11, compared to February 11 – May 12.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- ================= KEYS TO SUCCESS ================= -->
                <section class="teacher_settings_profile_teacher_profile_overview-section p-5">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <h3 class="text-[22px] font-semibold">Keys to success</h3>
                            <p class="text-[13px] text-[#4B5563] -mt-0.5">These metrics are designed to help and support you grow your business, attract newstudents, and keep them engaged.</p>
                        </div>
                        <button class="teacher_settings_profile_teacher_profile_overview-badge">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="4" width="18" height="17" rx="2" stroke="#111827" stroke-width="1.5" />
                                <path d="M8 2v4M16 2v4M3 9h18" stroke="#111827" stroke-width="1.5" />
                            </svg>
                            <span>Last 90 days</span>
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none">
                                <path d="M6 8l4 4 4-4" stroke="#111827" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <!-- small Live pill -->
                    <div class="mt-3">
                        <span class="teacher_settings_profile_teacher_profile_overview-livePill">Live</span>
                    </div>

                    <!-- row 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 mt-3">
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="font-semibold text-[14px]">Lessons Daniela rescheduled</div>
                            <div class="text-[12px] text-[#4B5563]">Aim for less than 10%</div>
                            <div class="mt-6 text-[28px] font-semibold">2%</div>
                            <div class="teacher_settings_profile_teacher_profile_overview-badgeCheck">
                                <svg viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="font-semibold text-[14px]">Lessons Daniela cancelled</div>
                            <div class="text-[12px] text-[#4B5563]">Aim for less than 5%</div>
                            <div class="mt-6 text-[28px] font-semibold">2%</div>
                            <div class="teacher_settings_profile_teacher_profile_overview-badgeCheck">
                                <svg viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- row 2 -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-5 mt-4">
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="text-[14px] font-semibold">Total lessons missed</div>
                            <div class="text-[12px] text-[#4B5563]">Aim for 0</div>
                            <div class="mt-5 text-[26px] font-semibold">0</div>
                            <div class="teacher_settings_profile_teacher_profile_overview-badgeCheck">
                                <svg viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>

                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="text-[14px] font-semibold">Weekly lessons</div>
                            <div class="text-[12px] text-[#4B5563]">Aim for 75%</div>
                            <div class="mt-5 text-[26px] font-semibold">0%</div>
                            <div class="teacher_settings_profile_teacher_profile_overview-badgeLive">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 2a10 10 0 1 0 10 10" />
                                </svg>
                            </div>
                        </div>

                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="text-[14px] font-semibold">Lessons in the Latingles classroom</div>
                            <div class="text-[12px] text-[#4B5563]">Aim for more than 75%</div>
                            <div class="mt-5 text-[26px] font-semibold">0%</div>
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 mt-4">
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="text-[14px] font-semibold">Replies within 24h</div>
                            <div class="text-[12px] text-[#4B5563]">Aim for more than 90%</div>
                            <div class="mt-6 text-[28px] font-semibold">100%</div>
                        </div>
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="text-[14px] font-semibold">Trial follow-ups</div>
                            <div class="text-[12px] text-[#4B5563]">Aim for more than 90%</div>
                            <div class="mt-6 text-[28px] font-semibold">0%</div>
                            <div class="teacher_settings_profile_teacher_profile_overview-badgeCheck">
                                <svg viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ================= NEW SUBSCRIPTIONS ================= -->
                <section class="teacher_settings_profile_teacher_profile_overview-section p-5">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <h3 class="text-[22px] font-semibold">New subscriptions</h3>
                        <button class="teacher_settings_profile_teacher_profile_overview-badge">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="4" width="18" height="17" rx="2" stroke="#111827" stroke-width="1.5" />
                                <path d="M8 2v4M16 2v4M3 9h18" stroke="#111827" stroke-width="1.5" />
                            </svg>
                            <span>Last 90 days</span>
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none">
                                <path d="M6 8l4 4 4-4" stroke="#111827" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                        <!-- stacked blocks with diagonal notch -->
                        <div class="teacher_settings_profile_teacher_profile_overview-card p-0 lg:col-span-2 overflow-hidden rounded-[14px]">
                            <div class="teacher_settings_profile_teacher_profile_overview-stackedWrap h-40">
                                <div class="grid grid-cols-3 h-full">
                                    <div class="bg-[#91B5FF]"></div>
                                    <div class="bg-[#2F7BFF]"></div>
                                    <div class="bg-[#0C3A7C]"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 text-center text-[13px] p-3 border-t border-gray-200 bg-white">
                                <div>Profile views<br><span class="text-[22px] font-semibold">152</span></div>
                                <div>Trial lessons<br><span class="text-[22px] font-semibold">0</span></div>
                                <div>New subscriptions<br><span class="text-[22px] font-semibold">0</span></div>
                            </div>
                        </div>

                        <!-- right stats -->
                        <div class="space-y-3">
                            <div class="teacher_settings_profile_teacher_profile_overview-card">
                                <div class="text-[14px] font-semibold">
                                    Average profile position
                                    <span class="teacher_settings_profile_teacher_profile_overview-livePill ml-2 -translate-y-0.5">Live</span>
                                </div>
                                <div class="mt-3 text-[28px] font-semibold">770</div>
                            </div>

                            <div class="teacher_settings_profile_teacher_profile_overview-card">
                                <div class="text-[14px] font-semibold">Take a trial lesson</div>
                                <div class="text-[12px] text-[#4B5563]">Aim for more than 2%</div>
                                <div class="mt-3 text-[24px] font-semibold">0%</div>
                                <div class="teacher_settings_profile_teacher_profile_overview-badgeLive">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 10 10" />
                                    </svg>
                                </div>
                            </div>

                            <div class="teacher_settings_profile_teacher_profile_overview-card">
                                <div class="text-[14px] font-semibold">Subscribe after the trial lesson</div>
                                <div class="text-[12px] text-[#4B5563]">Aim for more than 60%</div>
                                <div class="mt-3 text-[24px] font-semibold">0%</div>
                                <div class="teacher_settings_profile_teacher_profile_overview-badgeLive">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 10 10" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-[11px] text-[#6B7280] mt-2">Data from May 13 – Aug 11. Live metrics updated Aug 11, 20:26.</p>
                </section>

                <!-- ================= EARNINGS (chart) ================= -->
                <section class="teacher_settings_profile_teacher_profile_overview-section p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-[22px] font-semibold">Earnings</h3>
                        <button class="teacher_settings_profile_teacher_profile_overview-badge">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="4" width="18" height="17" rx="2" stroke="#111827" stroke-width="1.5" />
                                <path d="M8 2v4M16 2v4M3 9h18" stroke="#111827" stroke-width="1.5" />
                            </svg>
                            <span>Last 90 days</span>
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none">
                                <path d="M6 8l4 4 4-4" stroke="#111827" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <div class="teacher_settings_profile_teacher_profile_overview-card p-4 mt-3">
                        <div class="text-[14px] font-semibold">$341</div>
                        <div class="text-[12px] text-[#4B5563] -mt-0.5">
                            Income earned <span class="inline-block align-middle ml-1 w-4 h-4 rounded-full border border-gray-400 text-center text-[10px]">i</span>
                        </div>

                        <div class="mt-4">
                            <svg class="teacher_settings_profile_teacher_profile_overview-chart" viewBox="0 0 760 240" xmlns="http://www.w3.org/2000/svg">
                                <g stroke="var(--teacher_settings_profile_teacher_profile_overview-grid)" stroke-width="1">
                                    <path d="M60 40 H740" />
                                    <path d="M60 90 H740" />
                                    <path d="M60 140 H740" />
                                    <path d="M60 190 H740" />
                                </g>
                                <g class="teacher_settings_profile_teacher_profile_overview-y">
                                    <text x="30" y="44">100</text>
                                    <text x="40" y="94">50</text>
                                    <text x="46" y="144">0</text>
                                </g>
                                <g class="teacher_settings_profile_teacher_profile_overview-x">
                                    <g transform="translate(80,0) rotate(-25 0 210)"><text x="0" y="210">Sep ‘23</text></g>
                                    <g transform="translate(120,0) rotate(-25 0 210)"><text x="0" y="210">Oct ‘23</text></g>
                                    <g transform="translate(160,0) rotate(-25 0 210)"><text x="0" y="210">Nov ‘23</text></g>
                                    <g transform="translate(200,0) rotate(-25 0 210)"><text x="0" y="210">Dec ‘23</text></g>
                                    <g transform="translate(240,0) rotate(-25 0 210)"><text x="0" y="210">Jan ‘24</text></g>
                                    <g transform="translate(280,0) rotate(-25 0 210)"><text x="0" y="210">Feb ‘24</text></g>
                                    <g transform="translate(320,0) rotate(-25 0 210)"><text x="0" y="210">Mar ‘24</text></g>
                                    <g transform="translate(360,0) rotate(-25 0 210)"><text x="0" y="210">Apr ‘24</text></g>
                                    <g transform="translate(400,0) rotate(-25 0 210)"><text x="0" y="210">May ‘24</text></g>
                                    <g transform="translate(440,0) rotate(-25 0 210)"><text x="0" y="210">Jun ‘24</text></g>
                                    <g transform="translate(480,0) rotate(-25 0 210)"><text x="0" y="210">Jul ‘24</text></g>
                                    <g transform="translate(520,0) rotate(-25 0 210)"><text x="0" y="210">Aug ‘24</text></g>
                                    <g transform="translate(560,0) rotate(-25 0 210)"><text x="0" y="210">Sep ‘24</text></g>
                                    <g transform="translate(600,0) rotate(-25 0 210)"><text x="0" y="210">Oct ‘24</text></g>
                                    <g transform="translate(640,0) rotate(-25 0 210)"><text x="0" y="210">Nov ‘24</text></g>
                                </g>

                                <path d="M60 140 H740" stroke="#CBD5E1" stroke-width="1" />
                                <polyline fill="none" stroke="var(--teacher_settings_profile_teacher_profile_overview-blue)" stroke-width="3"
                                    points="80,135 100,133 120,120 140,100 160,96 180,98 200,130 220,125 240,128 260,127 280,126 300,125 320,124 340,123 360,122 380,121 400,120 420,80 440,70 460,85 480,100 500,140 520,140 540,140 560,140 580,140 600,140 620,140 640,140" />
                                <g fill="#fff" stroke="var(--teacher_settings_profile_teacher_profile_overview-blueDot)" stroke-width="3">
                                    <circle cx="80" cy="135" r="5" />
                                    <circle cx="120" cy="120" r="5" />
                                    <circle cx="160" cy="96" r="5" />
                                    <circle cx="200" cy="130" r="5" />
                                    <circle cx="240" cy="128" r="5" />
                                    <circle cx="280" cy="126" r="5" />
                                    <circle cx="320" cy="124" r="5" />
                                    <circle cx="360" cy="122" r="5" />
                                    <circle cx="400" cy="120" r="5" />
                                    <circle cx="440" cy="70" r="5" />
                                    <circle cx="480" cy="100" r="5" />
                                    <circle cx="520" cy="140" r="5" />
                                    <circle cx="560" cy="140" r="5" />
                                    <circle cx="600" cy="140" r="5" />
                                    <circle cx="640" cy="140" r="5" />
                                </g>
                            </svg>
                        </div>
                    </div>
                </section>

                <!-- ================= JOURNEY ================= -->
                <section class="teacher_settings_profile_teacher_profile_overview-section p-5">
                    <h3 class="text-[22px] font-semibold">Daniela Latingles journey</h3>
                    <p class="text-[13px] text-[#4B5563]">See what you’ve accomplished since you started in September 2023.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 mt-3">
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="teacher_settings_profile_teacher_profile_overview-emojiBadge">💪</div>
                            <div class="mt-3 text-[30px] font-semibold">80.5</div>
                            <div class="text-[13px] text-[#4B5563] -mt-1">Hours taught</div>
                        </div>
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="teacher_settings_profile_teacher_profile_overview-emojiBadge">🗣️</div>
                            <div class="mt-3 text-[30px] font-semibold">84</div>
                            <div class="text-[13px] text-[#4B5563] -mt-1">Lessons taught</div>
                        </div>
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="teacher_settings_profile_teacher_profile_overview-emojiBadge">🎓</div>
                            <div class="mt-3 text-[30px] font-semibold">7</div>
                            <div class="text-[13px] text-[#4B5563] -mt-1">Total students</div>
                        </div>
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="teacher_settings_profile_teacher_profile_overview-emojiBadge">😊</div>
                            <div class="mt-3 text-[30px] font-semibold">698</div>
                            <div class="text-[13px] text-[#4B5563] -mt-1">Days on Latingles</div>
                        </div>
                        <div class="teacher_settings_profile_teacher_profile_overview-card">
                            <div class="teacher_settings_profile_teacher_profile_overview-emojiBadge">🪙</div>
                            <div class="mt-3 text-[30px] font-semibold">$341</div>
                            <div class="text-[13px] text-[#4B5563] -mt-1">Total earnings</div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script>
        // Toggle body from the gray top bar
        $('#teacher_settings_profile_teacher_profile_overview_header').on('click', function() {
            const $body = $('#teacher_settings_profile_teacher_profile_overview_body');
            const $chev = $('#teacher_settings_profile_teacher_profile_overview_chev');
            $body.slideToggle(180);
            $chev.toggleClass('rotate-180');
        });

        // Range (placeholder)
        $('#teacher_settings_profile_teacher_profile_overview_range_btn').on('click', function(e) {
            e.preventDefault();
            alert('Range selector placeholder (Last 90 days)');
        });
    </script>
</body>

</html>