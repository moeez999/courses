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
