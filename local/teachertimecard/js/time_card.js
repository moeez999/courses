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
            //     $(this).attr('data-badge', checked ? null : 'check')
            //         .children('.teacher_time_card_table_list_badge').remove();
            //     teacher_time_card_table_list_applyBadges(this);
            // });
        });
    })(jQuery);





    
    (function($) {
    const GAP = 8;
    const PAD = 8;
    let activeDot = null;
    let closeTimer = null;

    function positionTooltip($dot) {
        const $tip = $dot.find('.session-tooltip');
        const r = $dot[0].getBoundingClientRect();
        const tipW = $tip.outerWidth();
        const tipH = $tip.outerHeight();
        const vw = $(window).width();
        const vh = $(window).height();

        let top = r.top - tipH - GAP;
        let left = r.left + (r.width / 2) - (tipW / 2);

        if (top < PAD) top = r.bottom + GAP;
        left = Math.max(PAD, Math.min(left, vw - tipW - PAD));
        if (top + tipH > vh - PAD) top = Math.max(PAD, vh - tipH - PAD);

        $tip.css({ 
            top: Math.round(top), 
            left: Math.round(left) 
        });
    }

    function showTooltip($dot) {
        // Clear any pending close timer
        clearTimeout(closeTimer);
        
        // Hide previous tooltip immediately
        if (activeDot && !activeDot.is($dot)) {
            activeDot.removeClass('tooltip-visible');
        }
        
        // Show new tooltip
        $dot.addClass('tooltip-visible');
        positionTooltip($dot);
        activeDot = $dot;

        // Add event listeners for tooltip hover
        const $tip = $dot.find('.session-tooltip');
        $tip.off('mouseenter mouseleave').on({
            mouseenter: function() {
                // Cancel close timer when mouse enters tooltip
                clearTimeout(closeTimer);
            },
            mouseleave: function() {
                // Start close timer when mouse leaves tooltip
                startCloseTimer();
            }
        });
    }

    function startCloseTimer() {
        clearTimeout(closeTimer);
        closeTimer = setTimeout(function() {
            if (activeDot) {
                activeDot.removeClass('tooltip-visible');
                activeDot = null;
            }
        }, 2000); // 2 seconds after leaving both dot and tooltip
    }

    function hideTooltip($dot) {
        // Only start close timer if not hovering over the tooltip
        const $tip = $dot.find('.session-tooltip');
        if (!$tip.is(':hover')) {
            startCloseTimer();
        }
    }

    // Event bindings
    $(document)
        .on('mouseenter', '.session-dot-container', function() {
            showTooltip($(this));
        })
        .on('mouseleave', '.session-dot-container', function() {
            hideTooltip($(this));
        });

    // Reposition on window resize
    $(window).on('resize', function() {
        if (activeDot) {
            positionTooltip(activeDot);
        }
    });

})(jQuery);

