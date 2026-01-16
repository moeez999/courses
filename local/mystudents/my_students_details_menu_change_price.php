
<style>
    :root {
        --my_student_details_menu_change_price_bg: #ffffff;
        --my_student_details_menu_change_price_text: #111827;
        --my_student_details_menu_change_price_muted: #6b7280;
        --my_student_details_menu_change_price_soft: #9ca3af;
        --my_student_details_menu_change_price_border: #e5e7eb;
        --my_student_details_menu_change_price_panel: #f3f4f6;
        --my_student_details_menu_change_price_overlay: rgba(17, 24, 39, .55);
        --my_student_details_menu_change_price_primary: #ff3b00;
        --my_student_details_menu_change_price_primary_text: #fff;
        --my_student_details_menu_change_price_focus: #2563eb;
    }


    .my_student_details_menu_change_price_page {
        padding: 24px;
        max-width: 1100px;
        margin: 0 auto
    }

    .my_student_details_menu_change_price_title {
        font-weight: 700;
        font-size: 20px;
        margin: 6px 0 18px
    }

    .my_student_details_menu_change_price_btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid var(--my_student_details_menu_change_price_border);
        padding: 10px 16px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
    }

    /* Overlay + modal container (centered with FLEX) */
    .my_student_details_menu_change_price_overlay {
        position: fixed;
        inset: 0;
        background: var(--my_student_details_menu_change_price_overlay);
        display: none;
        z-index: 999;
    }

    .my_student_details_menu_change_price_modal {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        z-index: 1000;
    }

    /* Dialog */
    .my_student_details_menu_change_price_dialog {
        width: min(800px, 100%);
        background: #fff;
        border-radius: 5px;
        border: 1px solid var(--my_student_details_menu_change_price_border);
        box-shadow: 0 30px 80px rgba(0, 0, 0, .35);
        overflow: hidden;
        position: relative;
    }

    /* Header */
    .my_student_details_menu_change_price_header {
        position: relative;
        padding: 24px 28px 10px
    }

    .my_student_details_menu_change_price_heading {
        margin: 0 44px 0 0;
        font-size: 28px;
        font-weight: 700;
        line-height: 1.25
    }

    .my_student_details_menu_change_price_student {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-left: 12px;
        padding: 6px 10px;
        border: 1px solid var(--my_student_details_menu_change_price_border);
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        background: #f3f4f7;
    }

    .my_student_details_menu_change_price_avatar {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        display: inline-grid;
        place-items: center;
        color: #fff;
        font-size: 12px;
        line-height: 1;
    }

    .my_student_details_menu_change_price_avatar::before {
        content: "👤";
        transform: scale(.85)
    }

    .my_student_details_menu_change_price_close {
        position: absolute;
        right: 16px;
        top: 16px;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid var(--my_student_details_menu_change_price_border);
        background: #fff;
        cursor: pointer;
        display: grid;
        place-items: center;
        z-index: 1001;
    }

    .my_student_details_menu_change_price_close svg {
        width: 18px;
        height: 18px
    }

    .my_student_details_menu_change_price_divider {
        height: 1px;
        background: var(--my_student_details_menu_change_price_border);
        margin: 12px 0 16px
    }

    /* Body */
    .my_student_details_menu_change_price_body {
        display: grid;
        grid-template-columns: 1fr 330px;
        gap: 24px;
        padding: 6px 28px 22px;
    }

    /* Generic label (used for Message) */
    .my_student_details_menu_change_price_label {
        margin: 0 0 4px;
        color: var(--my_student_details_menu_change_price_muted);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .my_student_details_menu_change_price_messageLabel {
        margin-top: 18px;
    }

    /* Left column */

    .my_student_details_menu_change_price_priceRow {
        display: flex;
        align-items: center;
        gap: 18px;
        margin: 6px 0 18px;
    }

    .my_student_details_menu_change_price_priceGroup {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
    }

    .my_student_details_menu_change_price_priceLabel {
        font-size: 13px;
        font-weight: 600;
        color: #111827;
        text-transform: none;
        letter-spacing: 0;
        margin: 0;
    }

    .my_student_details_menu_change_price_current {
        font-size: 50px;
        font-weight: 700;
        letter-spacing: -.02em;
    }

    .my_student_details_menu_change_price_arrow {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .my_student_details_menu_change_price_arrowImg {
        width: 18px;
        height: 18px;
        display: block;
    }

    .my_student_details_menu_change_price_newStack {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .my_student_details_menu_change_price_newField {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        /* container itself has no border; only input does */
    }

    .my_student_details_menu_change_price_currency {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
    }

    .my_student_details_menu_change_price_input {
        border: 1px solid #d1d5db;
        background: #ffffff;
        outline: none;
        flex: 1;
        font-size: 28px;
        font-weight: 700;
        width: 110px;
        padding: 10px 14px;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .my_student_details_menu_change_price_textarea {
        width: 100%;
        min-height: 200px;
        resize: vertical;
        border: 1px solid var(--my_student_details_menu_change_price_border);
        border-radius: 5px;
        padding: 14px;
        font-size: 14.5px;
        line-height: 1.5;
        background: #fff;
        color: #111827;
    }

    /* Right panel */
    .my_student_details_menu_change_price_info {
        background: #f3f4f7;
        border: 1px solid #f3f4f7;
        border-radius: 12px;
        padding: 14px 16px;
    }

    .my_student_details_menu_change_price_info h5 {
        margin: 2px 0 6px;
        font-size: 15px;
        font-weight: 700
    }

    .my_student_details_menu_change_price_info p {
        color: #4b5563;
        margin: 6px 0 0;
        font-size: 13.5px;
        line-height: 1.45
    }

    .my_student_details_menu_change_price_bullets {
        margin: 10px 0 0 0;
        padding-left: 18px
    }

    .my_student_details_menu_change_price_bullets li {
        margin: 6px 0;
        line-height: 1.35;
        font-size: 13.5px;
        color: #111827
    }

    /* Footer */
    .my_student_details_menu_change_price_footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 8px 28px 24px;
    }

    .my_student_details_menu_change_price_cancel {
        background: #fff;
        border: 1px solid var(--my_student_details_menu_change_price_border);
        height: 44px;
        border-radius: 5px;
        padding: 0 14px;
        font-weight: 700;
        cursor: pointer;
        margin-right: auto;
    }

    .my_student_details_menu_change_price_cta {
        background: var(--my_student_details_menu_change_price_primary);
        color: var(--my_student_details_menu_change_price_primary_text);
        border: 2px solid #000;
        height: 44px;
        border-radius: 5px;
        padding: 0 18px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 6px 16px rgba(255, 59, 0, .28);
    }

    .my_student_details_menu_change_price_cta:disabled {
        opacity: .7;
        cursor: not-allowed;
        box-shadow: none
    }

    /* Focus */
    .my_student_details_menu_change_price_btn:focus,
    .my_student_details_menu_change_price_close:focus,
    .my_student_details_menu_change_price_cancel:focus,
    .my_student_details_menu_change_price_cta:focus,
    .my_student_details_menu_change_price_input:focus,
    .my_student_details_menu_change_price_textarea:focus {
        outline: 2px solid var(--my_student_details_menu_change_price_focus);
        outline-offset: 2px;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .my_student_details_menu_change_price_body {
            grid-template-columns: 1fr
        }

        .my_student_details_menu_change_price_info {
            order: 2
        }
    }

    @media (max-width: 520px) {
        .my_student_details_menu_change_price_dialog {
            border-radius: 5px;
            width: 100%
        }

        .my_student_details_menu_change_price_body {
            padding: 10px 16px 16px
        }

        .my_student_details_menu_change_price_header {
            padding: 18px 16px 6px
        }

        .my_student_details_menu_change_price_footer {
            padding: 10px 16px 16px
        }

        .my_student_details_menu_change_price_heading {
            font-size: 24px
        }

        .my_student_details_menu_change_price_current {
            font-size: 40px
        }
    }
</style>

<!-- Overlay + Modal -->
<div id="my_student_details_menu_change_price_overlay"
    class="my_student_details_menu_change_price_overlay"
    aria-hidden="true"></div>

<section id="my_student_details_menu_change_price_modal"
    class="my_student_details_menu_change_price_modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="my_student_details_menu_change_price_heading"
    aria-hidden="true">
    <div class="my_student_details_menu_change_price_dialog">
        <div class="my_student_details_menu_change_price_header">
            <h2 id="my_student_details_menu_change_price_heading"
                class="my_student_details_menu_change_price_heading">
                Propose a new price for
                <span class="my_student_details_menu_change_price_student">
                    <span class="my_student_details_menu_change_price_avatar" aria-hidden="true"></span>
                    Courtney Henry
                </span>
            </h2>
            <button class="my_student_details_menu_change_price_close"
                id="my_student_details_menu_change_price_close_btn"
                type="button"
                aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M6 6l12 12M18 6L6 18" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div class="my_student_details_menu_change_price_divider"></div>
        </div>

        <div class="my_student_details_menu_change_price_body">
            <div>
                <!-- Current + New row -->
                <div class="my_student_details_menu_change_price_priceRow">
                    <div class="my_student_details_menu_change_price_priceGroup">
                        <div class="my_student_details_menu_change_price_priceLabel" style="margin-left:15px;">Current</div>
                        <div class="my_student_details_menu_change_price_current">$12</div>
                    </div>

                    <div class="my_student_details_menu_change_price_arrow">
                        <!-- SVG arrow image -->
                        <img src="img/my_students/change_price_arrow.svg"
                            alt=""
                            class="my_student_details_menu_change_price_arrowImg" style="margin-top: 30px;" />
                    </div>

                    <div class="my_student_details_menu_change_price_newStack">
                        <div class="my_student_details_menu_change_price_priceLabel" style="margin-left:35%;">New</div>
                        <div class="my_student_details_menu_change_price_newField"
                            aria-label="Enter new price">
                            <div class="my_student_details_menu_change_price_currency">$</div>
                            <input id="my_student_details_menu_change_price_input"
                                class="my_student_details_menu_change_price_input"
                                type="text"
                                inputmode="decimal"
                                placeholder="0"
                                autocomplete="off" />
                        </div>
                    </div>
                </div>

                <p class="my_student_details_menu_change_price_label my_student_details_menu_change_price_messageLabel">
                    Message (required)
                </p>
                <textarea id="my_student_details_menu_change_price_textarea"
                    class="my_student_details_menu_change_price_textarea"
                    placeholder="Draft a friendly message asking your student to consider the new price."></textarea>
            </div>

            <aside class="my_student_details_menu_change_price_info" aria-label="Guidance">
                <h5 style="color:black;">Before your proposal</h5>
                <p style="color:black;">Talk to your student about the new price during a lesson. They’ll be more likely to approve if they know more details.</p>

                <div class="my_student_details_menu_change_price_divider" style="margin:12px 0;"></div>

                <h5 style="color:black;">After your proposal</h5>
                <ul style="color:black;" class="my_student_details_menu_change_price_bullets">
                    <li>If they accept, the new price will start with their next renewal. Lessons already scheduled will use the old price.</li>
                    <li>If they do not accept, your price remains the same.</li>
                </ul>
            </aside>
        </div>

        <div class="my_student_details_menu_change_price_footer">
            <button id="my_student_details_menu_change_price_cancel_btn"
                class="my_student_details_menu_change_price_cancel"
                type="button">
                Cancel
            </button>
            <button id="my_student_details_menu_change_price_submit_btn"
                class="my_student_details_menu_change_price_cta"
                type="button"
                disabled>
                Propose new price
            </button>
        </div>
    </div>
</section>

<script>
    const my_student_details_menu_change_price_state = {
        isOpen: false
    };

    function my_student_details_menu_change_price_openModal() {
        if (my_student_details_menu_change_price_state.isOpen) return;
        my_student_details_menu_change_price_state.isOpen = true;

        $('#my_student_details_menu_change_price_overlay')
            .stop(true, true)
            .fadeIn(120)
            .attr('aria-hidden', 'false');

        const $modal = $('#my_student_details_menu_change_price_modal');
        $modal.css('display', 'flex').hide()
            .stop(true, true)
            .fadeIn(120)
            .attr('aria-hidden', 'false');

        $('#my_student_details_menu_change_price_input').trigger('focus');
        $('body').css('overflow', 'hidden');
    }

    function my_student_details_menu_change_price_closeModal() {
        if (!my_student_details_menu_change_price_state.isOpen) return;
        my_student_details_menu_change_price_state.isOpen = false;

        $('#my_student_details_menu_change_price_overlay')
            .stop(true, true)
            .fadeOut(120)
            .attr('aria-hidden', 'true');

        $('#my_student_details_menu_change_price_modal')
            .stop(true, true)
            .fadeOut(120, function() {
                $(this).css('display', 'none');
            })
            .attr('aria-hidden', 'true');

        $('#my_student_details_menu_change_price_open_btn').trigger('focus');
        $('body').css('overflow', 'auto');
    }

    function my_student_details_menu_change_price_updateCtaState() {
        let price = $('#my_student_details_menu_change_price_input').val().trim();
        const msg = $('#my_student_details_menu_change_price_textarea').val().trim();

        // allow only digits and decimal point
        price = price.replace(/[^0-9.]/g, '');
        $('#my_student_details_menu_change_price_input').val(price);

        const enabled = price !== '' && Number(price) > 0 && msg.length > 0;
        $('#my_student_details_menu_change_price_submit_btn').prop('disabled', !enabled);
    }

    $(function() {
        // Open
        $(document).on('click',
            '#my_student_details_menu_change_price_open_btn',
            my_student_details_menu_change_price_openModal);

        // Close: overlay, X, and Cancel
        $(document).on('click',
            '#my_student_details_menu_change_price_overlay',
            my_student_details_menu_change_price_closeModal);
        $(document).on('click',
            '#my_student_details_menu_change_price_close_btn',
            my_student_details_menu_change_price_closeModal);
        $(document).on('click',
            '#my_student_details_menu_change_price_cancel_btn',
            my_student_details_menu_change_price_closeModal);

        // Escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && my_student_details_menu_change_price_state.isOpen) {
                my_student_details_menu_change_price_closeModal();
            }
        });

        // CTA enablement
        $(document).on('input',
            '#my_student_details_menu_change_price_input, #my_student_details_menu_change_price_textarea',
            my_student_details_menu_change_price_updateCtaState);

        // Demo submit
        $(document).on('click',
            '#my_student_details_menu_change_price_submit_btn',
            function() {
                if ($(this).prop('disabled')) return;
                alert('Price proposal submitted!');
                my_student_details_menu_change_price_closeModal();
            });
    });
</script>