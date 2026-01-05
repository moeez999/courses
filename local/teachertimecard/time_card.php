<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
    :root {
        --teacher_time_card_table_list_text: #121117;
        --teacher_time_card_table_list_muted: #6B7280;
        --teacher_time_card_table_list_border: #E4E7EE;
        --teacher_time_card_table_list_chip: 44px;
        --teacher_time_card_table_list_radius: 12px;

        /* chip palette */
        --teacher_time_card_table_list_green: #CDE7C1;
        --teacher_time_card_table_list_yellow: #F5E9B7;
        --teacher_time_card_table_list_blue: #B9D9FF;
        --teacher_time_card_table_list_lime: #D6E7A9;
        --teacher_time_card_table_list_peach: #FFC9B9;
        --teacher_time_card_table_list_outline: #121117;

        /* tick badge */
        --teacher_time_card_table_list_badge_bg: #22C55E;
        --teacher_time_card_table_list_badge_ring: #ffffff;
    }

    /* === FIXED-WIDTH SCROLLER WRAPPER (forces horizontal scroll) === */
    .teacher_time_card_table_list_scroller {
        width: 520px;
        /* <-- set your fixed width here */
        max-width: 100%;
        overflow-x: auto;
        /* horizontal scroll */
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        border: 1px solid var(--teacher_time_card_table_list_border);
        border-radius: var(--teacher_time_card_table_list_radius);
        padding: 10px;
        /* inner padding around chips */
        box-sizing: border-box;
        scrollbar-width: thin;
        /* Firefox */
        scrollbar-color: #ccc transparent;
    }

    /* Optional custom scrollbar styling */
    .teacher_time_card_table_list_scroller::-webkit-scrollbar {
        height: 8px;
    }

    .teacher_time_card_table_list_scroller::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .teacher_time_card_table_list_scroller::-webkit-scrollbar-track {
        background: transparent;
    }

    /* chips row: make it one line & wider than container */
    .teacher_time_card_table_list_chiprow {
        display: inline-flex;
        /* inline so width = content width */
        gap: 10px;
        align-items: center;
        flex-wrap: nowrap;
        /* single line */
        width: max-content;
        /* expands to fit all chips */
        min-width: 100%;
        /* avoids collapsing smaller than container */
    }

    .teacher_time_card_table_list_chip {
        width: var(--teacher_time_card_table_list_chip);
        height: var(--teacher_time_card_table_list_chip);
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        user-select: none;
        border: 2px solid transparent;
        position: relative;
        /* for badge */
    }

    /* solids */
    .teacher_time_card_table_list_chip.green {
        background: var(--teacher_time_card_table_list_green);
    }

    .teacher_time_card_table_list_chip.yellow {
        background: #edbca6;
        /* as you set */
        border: 2px solid black;
    }

    .teacher_time_card_table_list_chip.blue {
        background: var(--teacher_time_card_table_list_blue);
    }

    .teacher_time_card_table_list_chip.lime {
        background: var(--teacher_time_card_table_list_lime);
    }

    .teacher_time_card_table_list_chip.peach {
        background: var(--teacher_time_card_table_list_peach);
    }

    /* outlined variant */
    .teacher_time_card_table_list_chip.outline {
        background: #fff;
        border-color: var(--teacher_time_card_table_list_outline);
        font-weight: 800;
    }

    /* avatar chip */
    .teacher_time_card_table_list_chip.avatar {
        padding: 0;
        overflow: visible;
    }

    .teacher_time_card_table_list_chip.avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 999px;
    }

    /* tick badge */
    .teacher_time_card_table_list_badge {
        position: absolute;
        top: 0px;
        left: 30px;
        width: 15px;
        height: 15px;
        border-radius: 999px;
        background: var(--teacher_time_card_table_list_badge_bg);
        /* box-shadow: 0 0 0 2px var(--teacher_time_card_table_list_badge_ring); */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }

    .teacher_time_card_table_list_badge svg {
        width: 12px;
        height: 12px;
        color: #fff;
        display: block;
    }

    /* responsive spacing */
    @media (max-width:640px) {
        .teacher_time_card_table_list_chip {
            width: 40px;
            height: 40px;
            font-size: 13px;
        }

        .teacher_time_card_table_list_scroller {
            width: 100%;
        }

        /* full width on small screens */
    }
</style>

<!-- ======= ONLY THE HIGHLIGHTED “MAIN SESSION” CONTENT (MERGED) ======= -->
<div class="teacher_time_card_table_list_scroller">
    <div class="teacher_time_card_table_list_chiprow">
        <div class="teacher_time_card_table_list_chip green" data-badge="check">FL1</div>
        <div class="teacher_time_card_table_list_chip avatar" data-badge="check" title="Tutor">
            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop" alt="Tutor">
        </div>
        <div class="teacher_time_card_table_list_chip blue" data-badge="check">FL3</div>
        <div class="teacher_time_card_table_list_chip lime">FL4</div>
        <div class="teacher_time_card_table_list_chip yellow">FL5</div>
        <!-- add more to test overflow -->
        <div class="teacher_time_card_table_list_chip green">FL6</div>
        <div class="teacher_time_card_table_list_chip blue">FL7</div>
        <div class="teacher_time_card_table_list_chip peach">FL8</div>

        <div class="teacher_time_card_table_list_chip peach">FL8</div>

        <div class="teacher_time_card_table_list_chip peach">FL8</div>

    </div>
</div>

<script>
    /* ========= Minimal, namespaced badge logic ========= */
    (function($) {
        const teacher_time_card_table_list_badgeSVG_check =
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="3" d="M5 12.5l4.2 4.2L19 7.8"/></svg>';

        function teacher_time_card_table_list_applyBadges(ctx) {
            $(ctx).find('.teacher_time_card_table_list_chip[data-badge="check"]').each(function() {
                if ($(this).children('.teacher_time_card_table_list_badge').length) return;
                $(this).append($('<span class="teacher_time_card_table_list_badge" aria-label="checked"/>')
                    .html(teacher_time_card_table_list_badgeSVG_check));
            });
        }

        $(function() {
            teacher_time_card_table_list_applyBadges(document);


            // (Optional) Demo toggle on click — remove if not needed.
            // $('.teacher_time_card_table_list_chip').on('click', function() {
            //     const checked = $(this).attr('data-badge') === 'check';
            //     if (checked) {
            //         $(this).removeAttr('data-badge')
            //             .children('.teacher_time_card_table_list_badge').remove();
            //     } else {
            //         $(this).attr('data-badge', 'check');
            //         teacher_time_card_table_list_applyBadges(this);
            //     }
            // });


        });
    })(jQuery);
</script>