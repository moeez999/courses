<?php
/*  File: admin_dashboard_table_content_modal_cohorts.php

  UPDATE (per your last snapshot):
  ✅ Pointer is now EXACTLY like the screenshot:
     - a DOWNWARD triangle sitting on the bar edge (under the bar line)
     - centered under the bubble
  ✅ Axis labels stay aligned (0/25/70/100) and show only once
  ✅ Modal still opens near the clicked button
  ✅ Markers still move left/right + bar fill animates
*/
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>admin_dashboard_table_content_modal_cohorts</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ========= Prefix: admin_dashboard_table_content_modal_cohorts_ ========= */

        #admin_dashboard_table_content_modal_cohorts_overlay {
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }

        #admin_dashboard_table_content_modal_cohorts_modal {
            box-shadow: 0 18px 50px rgba(0, 0, 0, .20);
        }

        .admin_dashboard_table_content_modal_cohorts_teacher-pill {
            position: relative;
            padding-left: 38px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            background: #fff;
            font-weight: 600;
            line-height: 1;
            white-space: nowrap;
            font-size: 14px;
        }

        .admin_dashboard_table_content_modal_cohorts_teacher-pill img {
            position: absolute;
            left: 8px;
            width: 28px;
            height: 28px;
            border-radius: 9999px;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
        }

        .admin_dashboard_table_content_modal_cohorts_time-chip {
            height: 35px;
            padding: 0 12px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
        }

        .admin_dashboard_table_content_modal_cohorts_time-chip.red {
            color: #ff2f1a;
            background: rgba(255, 47, 26, .12);
        }

        .admin_dashboard_table_content_modal_cohorts_time-chip.blue {
            color: #1e57ff;
            background: rgba(30, 87, 255, .12);
        }

        .admin_dashboard_table_content_modal_cohorts_info-chip {
            height: 35px;
            padding: 0 12px;
            border-radius: 9999px;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .10);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            white-space: nowrap;
        }

        .admin_dashboard_table_content_modal_cohorts_info-chip span {
            color: rgba(17, 24, 39, .55);
            font-weight: 500;
        }

        .admin_dashboard_table_content_modal_cohorts_info-chip b {
            font-weight: 600;
            color: #111827;
        }

        .admin_dashboard_table_content_modal_cohorts_progress-panel {
            border-radius: 12px;
            padding: 28px 14px 2px 14px;
        }

        .admin_dashboard_table_content_modal_cohorts_track-wrap {
            position: relative;
            padding-bottom: 26px;
            /* space for axis labels */
        }

        .admin_dashboard_table_content_modal_cohorts_track {
            position: relative;
            height: 10px;
            border-radius: 9999px;
            background: #eef2f7;
            overflow: visible;
            --admin_dashboard_table_content_modal_cohorts_fill_scale: 0;
            /* 0..1 */
            --admin_dashboard_table_content_modal_cohorts_color: #ff2f1a;
        }

        .admin_dashboard_table_content_modal_cohorts_fill {
            position: absolute;
            inset: 0;
            height: 10px;
            border-radius: 9999px;
            background: var(--admin_dashboard_table_content_modal_cohorts_color, #ff2f1a);
            transform-origin: left center;
            transform: scaleX(var(--admin_dashboard_table_content_modal_cohorts_fill_scale, 0));
        }

        /* Marker = bubble above + DOWN triangle sitting under the bar (like your screenshot) */
        .admin_dashboard_table_content_modal_cohorts_marker-wrap {
            position: absolute;
            top: -24px;
            /* bubble above */
            width: 26px;
            height: 44px;
            /* bubble + pointer */
            pointer-events: none;
            transition: left 380ms cubic-bezier(.2, .8, .2, 1);
            --admin_dashboard_table_content_modal_cohorts_marker_color: #ff2f1a;
        }

        .admin_dashboard_table_content_modal_cohorts_marker-bubble {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 9999px;
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            background: var(--admin_dashboard_table_content_modal_cohorts_marker_color, #ff2f1a);
            box-shadow: 0 10px 16px rgba(0, 0, 0, .14);
        }

        /* DOWNWARD triangle placed just under the bar (points down) */
        .admin_dashboard_table_content_modal_cohorts_marker-arrow {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 34px;
            /* aligns under the 10px bar */
            width: 0;
            height: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-top: 9px solid var(--admin_dashboard_table_content_modal_cohorts_marker_color, #ff2f1a);
            filter: drop-shadow(0 2px 1px rgba(0, 0, 0, .10));
        }

        /* Axis labels aligned by % */
        .admin_dashboard_table_content_modal_cohorts_axis {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 18px;
            pointer-events: none;
            color: rgba(17, 24, 39, .55);
            font-size: 12px;
            font-weight: 600;
        }

        .admin_dashboard_table_content_modal_cohorts_axis-label {
            position: absolute;
            bottom: 0;
            transform: translateX(-50%);
            white-space: nowrap;
        }

        .admin_dashboard_table_content_modal_cohorts_axis-label.left {
            transform: translateX(0);
            left: 0;
        }

        .admin_dashboard_table_content_modal_cohorts_axis-label.right {
            transform: translateX(-100%);
            left: 100%;
        }

        .admin_dashboard_table_content_modal_cohorts_close {
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            background: #fff;
            color: rgba(17, 24, 39, .75);
        }

        .admin_dashboard_table_content_modal_cohorts_close:hover {
            background: rgba(17, 24, 39, .04);
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100">
    <!-- Demo trigger (remove in production) -->
    <div class="p-6">
        <!-- <button
            class="rounded-xl bg-slate-900 text-white px-5 py-3 font-semibold shadow"
            onclick="admin_dashboard_table_content_modal_cohorts_openModal(event)">
            Open Modal
        </button> -->
    </div>

    <!-- Overlay -->
    <div id="admin_dashboard_table_content_modal_cohorts_overlay"
        class="fixed inset-0 z-50 hidden bg-black/20">

        <!-- Modal (near button) -->
        <div id="admin_dashboard_table_content_modal_cohorts_modal"
            class="absolute w-[500px] max-w-[92vw] rounded-2xl bg-white px-3 py-3 md:px-5 md:py-5">

            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3 flex-wrap">
                    <h2 class="text-[16px] md:text-[17px] font-semibold text-slate-900">
                        Teachers of FL1
                    </h2>

                    <div class="flex items-center gap-2">
                        <div class="admin_dashboard_table_content_modal_cohorts_teacher-pill border border-red/800 text-slate-900" style="width:100px; border:1px solid red !important">
                            <img alt="Daniela" src="https://i.pravatar.cc/60?img=12" />
                            Daniela
                        </div>

                        <div class="admin_dashboard_table_content_modal_cohorts_teacher-pill border-2 border-blue-500 text-black-600" style="width:90px; border:1px solid blue !important">
                            <img alt="david" src="https://i.pravatar.cc/60?img=5" />
                            david
                        </div>
                    </div>
                </div>

                <button type="button"
                    class="admin_dashboard_table_content_modal_cohorts_close"
                    aria-label="Close modal"
                    onclick="admin_dashboard_table_content_modal_cohorts_closeModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <!-- Times -->
            <div class="mt-3 flex flex-wrap items-center gap-2">
                <span class="admin_dashboard_table_content_modal_cohorts_time-chip red">M - 6:30 pm</span>
                <span class="admin_dashboard_table_content_modal_cohorts_time-chip red">W - 6:30 pm</span>
                <span class="admin_dashboard_table_content_modal_cohorts_time-chip blue">F - 7:30 pm</span>
            </div>

            <!-- Info -->
            <div class="mt-3 flex flex-wrap items-center gap-2">
                <div class="admin_dashboard_table_content_modal_cohorts_info-chip">
                    <span>Level :</span> <b>1-A1</b>
                </div>
                <div class="admin_dashboard_table_content_modal_cohorts_info-chip">
                    <span>Topic :</span> <b>Alphabet</b>
                </div>
                <div class="admin_dashboard_table_content_modal_cohorts_info-chip">
                    <span>Target Sessions :</span> <b>3</b>
                </div>
            </div>

            <!-- Bars -->
            <div class="mt-4 space-y-3">

                <!-- RED -->
                <div class="admin_dashboard_table_content_modal_cohorts_progress-panel border-2 border-[#ff2f1a]/90">
                    <div class="admin_dashboard_table_content_modal_cohorts_track-wrap">
                        <div class="admin_dashboard_table_content_modal_cohorts_track"
                            data-admin-dashboard-table-content-modal-cohorts-track="red"
                            style="--admin_dashboard_table_content_modal_cohorts_color:#ff2f1a;">
                            <div class="admin_dashboard_table_content_modal_cohorts_fill"></div>
                        </div>

                        <div class="admin_dashboard_table_content_modal_cohorts_axis">
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label left">0%</div>
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label" style="left:25%;">25%</div>
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label" style="left:70%;">70%</div>
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label right">100%</div>
                        </div>
                    </div>
                </div>

                <!-- BLUE -->
                <div class="admin_dashboard_table_content_modal_cohorts_progress-panel border-2 border-[#1e57ff]/90">
                    <div class="admin_dashboard_table_content_modal_cohorts_track-wrap">
                        <div class="admin_dashboard_table_content_modal_cohorts_track"
                            data-admin-dashboard-table-content-modal-cohorts-track="blue"
                            style="--admin_dashboard_table_content_modal_cohorts_color:#1e57ff;">
                            <div class="admin_dashboard_table_content_modal_cohorts_fill"></div>
                        </div>

                        <div class="admin_dashboard_table_content_modal_cohorts_axis">
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label left">0%</div>
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label" style="left:25%;">25%</div>
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label" style="left:70%;">70%</div>
                            <div class="admin_dashboard_table_content_modal_cohorts_axis-label right">100%</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // ========= Prefix: admin_dashboard_table_content_modal_cohorts_ =========

        const admin_dashboard_table_content_modal_cohorts_overlay =
            document.getElementById('admin_dashboard_table_content_modal_cohorts_overlay');
        const admin_dashboard_table_content_modal_cohorts_modal =
            document.getElementById('admin_dashboard_table_content_modal_cohorts_modal');

        function admin_dashboard_table_content_modal_cohorts_openModal(e) {
            admin_dashboard_table_content_modal_cohorts_overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            const btn = e?.currentTarget || e?.target;
            if (btn && btn.getBoundingClientRect) {
                const r = btn.getBoundingClientRect();
                const modalW = admin_dashboard_table_content_modal_cohorts_modal.offsetWidth || 560;

                let left = r.left + window.scrollX;
                let top = r.bottom + window.scrollY + 10;

                const maxLeft = window.scrollX + document.documentElement.clientWidth - modalW - 12;
                left = Math.max(window.scrollX + 12, Math.min(left, maxLeft));

                const modalH = admin_dashboard_table_content_modal_cohorts_modal.offsetHeight || 360;
                const maxTop = window.scrollY + document.documentElement.clientHeight - modalH - 12;
                if (top > maxTop) top = Math.max(window.scrollY + 12, r.top + window.scrollY - modalH - 10);

                admin_dashboard_table_content_modal_cohorts_modal.style.left = left + 'px';
                admin_dashboard_table_content_modal_cohorts_modal.style.top = top + 'px';
            } else {
                admin_dashboard_table_content_modal_cohorts_modal.style.left = (window.scrollX + 16) + 'px';
                admin_dashboard_table_content_modal_cohorts_modal.style.top = (window.scrollY + 16) + 'px';
            }
        }

        function admin_dashboard_table_content_modal_cohorts_closeModal() {
            admin_dashboard_table_content_modal_cohorts_overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        admin_dashboard_table_content_modal_cohorts_overlay.addEventListener('click', function(e) {
            if (e.target === admin_dashboard_table_content_modal_cohorts_overlay) {
                admin_dashboard_table_content_modal_cohorts_closeModal();
            }
        });

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !admin_dashboard_table_content_modal_cohorts_overlay.classList.contains('hidden')) {
                admin_dashboard_table_content_modal_cohorts_closeModal();
            }
        });

        function admin_dashboard_table_content_modal_cohorts_animateFill(trackEl, toPercent, durationMs) {
            const to = Math.max(0, Math.min(100, Number(toPercent || 0))) / 100;
            const from = Number(getComputedStyle(trackEl).getPropertyValue('--admin_dashboard_table_content_modal_cohorts_fill_scale')) || 0;
            const start = performance.now();
            const duration = Math.max(120, Number(durationMs || 450));

            function easeOutCubic(t) {
                return 1 - Math.pow(1 - t, 3);
            }

            function step(now) {
                const t = Math.min(1, (now - start) / duration);
                const v = from + (to - from) * easeOutCubic(t);
                trackEl.style.setProperty('--admin_dashboard_table_content_modal_cohorts_fill_scale', v.toFixed(4));
                if (t < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        function admin_dashboard_table_content_modal_cohorts_upsertMarkers(trackEl, markers) {
            const existing = new Map();
            trackEl.querySelectorAll('.admin_dashboard_table_content_modal_cohorts_marker-wrap').forEach(el => {
                existing.set(el.dataset.markerKey, el);
            });

            const nextKeys = new Set();

            (markers || []).forEach(m => {
                const key = String(m.key ?? m.label);
                nextKeys.add(key);

                let wrap = existing.get(key);
                if (!wrap) {
                    wrap = document.createElement('div');
                    wrap.className = 'admin_dashboard_table_content_modal_cohorts_marker-wrap';
                    wrap.dataset.markerKey = key;

                    const bubble = document.createElement('div');
                    bubble.className = 'admin_dashboard_table_content_modal_cohorts_marker-bubble';

                    const pointer = document.createElement('div');
                    pointer.className = 'admin_dashboard_table_content_modal_cohorts_marker-arrow';

                    wrap.appendChild(bubble);
                    wrap.appendChild(pointer);
                    trackEl.appendChild(wrap);
                }

                wrap.querySelector('.admin_dashboard_table_content_modal_cohorts_marker-bubble').textContent = String(m.label ?? '');

                const color = (m.color || getComputedStyle(trackEl).getPropertyValue('--admin_dashboard_table_content_modal_cohorts_color') || '#ff2f1a').trim();
                wrap.style.setProperty('--admin_dashboard_table_content_modal_cohorts_marker_color', color);

                const pos = Math.max(0, Math.min(100, Number(m.pos ?? 0)));
                wrap.style.left = `calc(${pos}% - 13px)`; // 26/2
            });

            existing.forEach((el, key) => {
                if (!nextKeys.has(key)) el.remove();
            });
        }

        // Public API
        function admin_dashboard_table_content_modal_cohorts_setProgress(trackSelectorValue, fillPercent, markers, animate = true) {
            const trackEl = document.querySelector(`[data-admin-dashboard-table-content-modal-cohorts-track="${trackSelectorValue}"]`);
            if (!trackEl) return;

            if (fillPercent !== null && fillPercent !== undefined) {
                const safeFill = Math.max(0, Math.min(100, Number(fillPercent)));
                if (animate) {
                    admin_dashboard_table_content_modal_cohorts_animateFill(trackEl, safeFill, 450);
                } else {
                    trackEl.style.setProperty('--admin_dashboard_table_content_modal_cohorts_fill_scale', (safeFill / 100).toFixed(4));
                }
            }

            if (Array.isArray(markers)) {
                admin_dashboard_table_content_modal_cohorts_upsertMarkers(trackEl, markers);
            }
        }

        function admin_dashboard_table_content_modal_cohorts_init() {
            admin_dashboard_table_content_modal_cohorts_setProgress('red', 70, [{
                    key: 'm0',
                    label: '0',
                    pos: 25,
                    color: '#ff2f1a'
                },
                {
                    key: 'm2',
                    label: '2',
                    pos: 70,
                    color: '#ff2f1a'
                }
            ], false);

            admin_dashboard_table_content_modal_cohorts_setProgress('blue', 25, [{
                key: 'b1',
                label: '1',
                pos: 25,
                color: '#1e57ff'
            }], false);

            window.admin_dashboard_table_content_modal_cohorts_openModal = admin_dashboard_table_content_modal_cohorts_openModal;
            window.admin_dashboard_table_content_modal_cohorts_closeModal = admin_dashboard_table_content_modal_cohorts_closeModal;
            window.admin_dashboard_table_content_modal_cohorts_setProgress = admin_dashboard_table_content_modal_cohorts_setProgress;
        }

        admin_dashboard_table_content_modal_cohorts_init();
    </script>
</body>

</html>