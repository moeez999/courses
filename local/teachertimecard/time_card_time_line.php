    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --teach_time_card_table_list_time_line_text: #121117;
            --teach_time_card_table_list_time_line_muted: #6B7280;
            --teach_time_card_table_list_time_line_border: #E4E7EE;
            --teach_time_card_table_list_time_line_radius: 10px;

            /* slot colors (tweak to your palette) */
            --teach_time_card_table_list_time_line_green: #DDEDC6;
            --teach_time_card_table_list_time_line_blue: #B9D9FF;
            --teach_time_card_table_list_time_line_peach: #FFC9B9;

            /* tick badge */
            --teach_time_card_table_list_time_line_badge_bg: #22C55E;
            --teach_time_card_table_list_time_line_badge_ring: #ffffff;
        }



        /* ===== Single row (Mon Oct-15) ===== */
        .teach_time_card_table_list_time_line_row {
            display: grid;
            grid-template-columns: 120px repeat(12, 1fr);
            align-items: stretch;
        }


        /* time slots grid cells */
        .teach_time_card_table_list_time_line_cell {
            position: relative;
            border-left: 1px solid var(--teach_time_card_table_list_time_line_border);
            min-height: 80px;
            width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        /* block that sits inside a cell */
        .teach_time_card_table_list_time_line_block {
            position: absolute;
            inset: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: #111827;
            overflow: visible;
        }

        .teach_time_card_table_list_time_line_block.green {
            background: var(--teach_time_card_table_list_time_line_green);
        }

        .teach_time_card_table_list_time_line_block.blue {
            background: var(--teach_time_card_table_list_time_line_blue);
        }

        .teach_time_card_table_list_time_line_block.peach {
            background: var(--teach_time_card_table_list_time_line_peach);
        }

        /* avatar variant */
        .teach_time_card_table_list_time_line_block.avatar {
            padding: 0;
        }

        .teach_time_card_table_list_time_line_block.avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* tick badge */
        .teach_time_card_table_list_time_line_badge {
            position: absolute;
            top: 4px;
            left: 50px;
            width: 15px;
            height: 15px;
            border-radius: 999px;
            background: var(--teach_time_card_table_list_time_line_badge_bg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .teach_time_card_table_list_time_line_badge svg {
            width: 12px;
            height: 12px;
            color: #fff;
            display: block;
        }

        /* separators */
        .teach_time_card_table_list_time_line_row+.teach_time_card_table_list_time_line_row {
            border-top: 1px solid var(--teach_time_card_table_list_time_line_border);
        }

        /* ===== Responsive: horizontal scroll for small screens ===== */
        .teach_time_card_table_list_time_line_scroller {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .teach_time_card_table_list_time_line_scroller::-webkit-scrollbar {
            height: 10px;
        }

        .teach_time_card_table_list_time_line_scroller::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 8px;
        }

        @media (max-width: 700px) {

            .teach_time_card_table_list_time_line_cell {
                min-height: 56px;
            }

            .teach_time_card_table_list_time_line_block {
                font-size: 13px;

            }
        }
    </style>

    <div class="teach_time_card_table_list_time_line_scroller">
        <div class="teach_time_card_table_list_time_line_row">
            <div class="teach_time_card_table_list_time_line_cell">
                <div class="teach_time_card_table_list_time_line_block green">FL1</div>
            </div>
            <div class="teach_time_card_table_list_time_line_cell">
                <div class="teach_time_card_table_list_time_line_block avatar" data-badge="check">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=300&auto=format&fit=crop"
                        alt="Tutor">
                </div>
            </div>
            <div class="teach_time_card_table_list_time_line_cell"></div>
            <div class="teach_time_card_table_list_time_line_cell">
                <div class="teach_time_card_table_list_time_line_block green" data-badge="check">FL1</div>
            </div>
            <div class="teach_time_card_table_list_time_line_cell"></div>
            <div class="teach_time_card_table_list_time_line_cell"></div>
            <div class="teach_time_card_table_list_time_line_cell"></div>
            <div class="teach_time_card_table_list_time_line_cell"></div>
            <div class="teach_time_card_table_list_time_line_cell"></div>
        </div>
    </div>


    <script>
        (function($) {
            const teach_time_card_table_list_time_line_svgTick =
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="3" d="M5 12.5l4.2 4.2L19 7.8"/></svg>';

            function teach_time_card_table_list_time_line_applyBadges(ctx) {
                $(ctx).find('.teach_time_card_table_list_time_line_block[data-badge="check"]').each(function() {
                    if ($(this).children('.teach_time_card_table_list_time_line_badge').length) return;
                    $(this).append($(
                        '<span class="teach_time_card_table_list_time_line_badge" aria-label="checked"/>'
                    ).html(teach_time_card_table_list_time_line_svgTick));
                });
            }

            $(function() {
                teach_time_card_table_list_time_line_applyBadges(document);

                // Optional demo: toggle tick on click
                $('.teach_time_card_table_list_time_line_block').on('click', function() {
                    const on = $(this).attr('data-badge') === 'check';
                    $(this).attr('data-badge', on ? null : 'check')
                        .children('.teach_time_card_table_list_time_line_badge').remove();
                    teach_time_card_table_list_time_line_applyBadges(this);
                });
            });
        })(jQuery);
    </script>