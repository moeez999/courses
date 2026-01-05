<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Teacher Time Card – Payment Modal (No Tailwind)</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
    :root {
        --teacher_time_card_payment_form_text: #121117;
        --teacher_time_card_payment_form_muted: #6B7280;
        --teacher_time_card_payment_form_border: #E4E7EE;

        --teacher_time_card_payment_form_accent: #ff3b1f;
        --teacher_time_card_payment_form_accent2: #ff5a2f;

        --teacher_time_card_payment_form_warn_bg: #FFF3CF;
        --teacher_time_card_payment_form_warn_bd: #FFE3A0;
        --teacher_time_card_payment_form_info_bg: #E3EEFF;
        --teacher_time_card_payment_form_info_bd: #D0E0FF;

        --teacher_time_card_payment_form_radius: 5px;
        --teacher_time_card_payment_form_control_h: 50px;
    }

    /* ===== Base / Resets ===== */
    * {
        box-sizing: border-box
    }

    html,
    body {
        height: 100%
    }

    body {
        margin: 0;
        font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        color: var(--teacher_time_card_payment_form_text);
        background: #fff;
    }

    .hidden {
        display: none !important;
    }

    a {
        color: inherit;
        text-decoration: none
    }

    button {
        cursor: pointer;
        font-family: inherit;
        border: 0;
        background: none
    }

    /* ===== Helpers ===== */
    .ttcpf_container {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .ttcpf_btn_demo {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        color: #fff;
        background: #111827;
    }

    /* ===== Modal ===== */
    #teacher_time_card_payment_form_modal {
        position: fixed;
        inset: 0;
        z-index: 1000;
    }

    .teacher_time_card_payment_form_backdrop {
        position: absolute;
        inset: 0;
        background: rgba(18, 17, 23, .45);
    }

    .ttcpf_modalwrap {
        position: relative;
        margin: -7px auto;
        width: 100%;
        max-width: 540px;
        padding: 16px;
    }

    .teacher_time_card_payment_form_shadow {
        box-shadow: 0 16px 48px rgba(0, 0, 0, .18), 0 24px 64px rgba(0, 0, 0, .12);
    }

    .ttcpf_card {
        background: #fff;
        border: 1px solid var(--teacher_time_card_payment_form_border);
        border-radius: 8px;
        max-height: 88vh;
        display: flex;
        flex-direction: column;
        margin-top: 115px;
    }

    /* Header */
    .ttcpf_header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 12px 12px 12px 12px;
    }

    .ttcpf_title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .teacher_time_card_payment_form_closeX {
        width: 36px;
        height: 36px;
        border-radius: 9999px;
        line-height: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .teacher_time_card_payment_form_closeX:hover {
        background: #f3f4f6;
    }

    /* Tabs */
    .ttcpf_tabs_outer {
        padding: 0 20px 16px 20px;
    }

    .teacher_time_card_payment_form_tabswrap {
        position: relative;
        padding-bottom: 16px;
    }

    .teacher_time_card_payment_form_tabs_base {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 20px;
        height: .5px;
        background: rgb(164 164 164 / 65%);
        border-radius: 9999px;
        z-index: 0;
        pointer-events: none;
    }

    .ttcpf_tabs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        align-items: end;
    }

    @media (min-width:640px) {
        .ttcpf_tabs {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .teacher_time_card_payment_form_tab {
        position: relative;
        padding: 8px 4px;
        opacity: .72;
        transition: opacity .15s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .teacher_time_card_payment_form_tab:hover {
        opacity: 1
    }

    .teacher_time_card_payment_form_tab img {
        height: 24px;
        width: auto;
        user-select: none;
        -webkit-user-drag: none
    }

    .teacher_time_card_payment_form_tab_active {
        opacity: 1;
    }

    .teacher_time_card_payment_form_tab_active::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -1px;
        transform: translateX(-50%);
        width: 96px;
        height: 4px;
        border-radius: 9999px;
        background: var(--teacher_time_card_payment_form_accent);
        z-index: 2;
    }

    /* Scrollable body */
    #teacher_time_card_payment_form_scroll_area {
        padding: 0 20px 16px 20px;
        overflow-y: auto;
        max-height: calc(88vh - 186px);
    }

    .teacher_time_card_payment_form_scroll::-webkit-scrollbar {
        width: 8px
    }

    .teacher_time_card_payment_form_scroll::-webkit-scrollbar-thumb {
        background: #E4E7EE;
        border-radius: 9999px
    }

    .ttcpf_muted {
        color: var(--teacher_time_card_payment_form_muted);
        font-size: 14px;
    }

    .ttcpf_field {
        margin-bottom: 16px;
    }

    .ttcpf_label {
        display: block;
        font-size: 14px;
        color: var(--teacher_time_card_payment_form_muted);
        margin-bottom: 6px;
    }

    /* Inputs */
    .teacher_time_card_payment_form_input {
        box-sizing: border-box;
        width: 100%;
        height: var(--teacher_time_card_payment_form_control_h);
        border-radius: var(--teacher_time_card_payment_form_radius);
        border: 1.5px solid var(--teacher_time_card_payment_form_border);
        background: #fff;
        outline: 0;
        transition: border-color .15s, box-shadow .15s;
        padding: 0 16px;
    }

    .teacher_time_card_payment_form_input:focus {
        border-color: #B9C0D4;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
    }

    .ttcpf_amountwrap {
        position: relative;
    }

    #teacher_time_card_payment_form_amount_suffix {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #6b7280;
        user-select: none;
    }

    /* Grid for Amount + Currency */
    .ttcpf_grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    @media (min-width:640px) {
        .ttcpf_grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .ttcpf_span2 {
            grid-column: span 2;
        }
    }

    /* Custom select (Currency) */
    .teacher_time_card_payment_form_select {
        position: relative;
    }

    .teacher_time_card_payment_form_select_btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0 40px 0 16px;
        height: var(--teacher_time_card_payment_form_control_h);
        border: 1.5px solid var(--teacher_time_card_payment_form_border);
        border-radius: var(--teacher_time_card_payment_form_radius);
        background: #fff;
        text-align: left;
        line-height: var(--teacher_time_card_payment_form_control_h);
        font-size: 15px;
    }

    .teacher_time_card_payment_form_select_btn:focus {
        outline: none;
        border-color: #B9C0D4;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
    }

    .teacher_time_card_payment_form_select_icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        width: 20px;
        height: 20px;
        color: #4b5563;
    }

    .teacher_time_card_payment_form_select_menu {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 6px);
        background: #fff;
        border: 1.5px solid var(--teacher_time_card_payment_form_border);
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(18, 17, 23, .15), 0 16px 48px rgba(18, 17, 23, .15);
        max-height: 260px;
        overflow: auto;
        z-index: 50;
    }

    .teacher_time_card_payment_form_select_item {
        padding: 14px 16px;
        cursor: pointer;
    }

    .teacher_time_card_payment_form_select_item:hover {
        background: #F3F4F6;
    }

    /* Notices */
    .teacher_time_card_payment_form_warn {
        background: var(--teacher_time_card_payment_form_warn_bg);
        border: 1px solid var(--teacher_time_card_payment_form_warn_bd);
        border-radius: var(--teacher_time_card_payment_form_radius);
        padding: 8px;
        font-size: 12px;
        line-height: 1.6;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin: 12px 0;
    }

    .teacher_time_card_payment_form_info {
        background: var(--teacher_time_card_payment_form_info_bg);
        border: 1px solid var(--teacher_time_card_payment_form_info_bd);
        border-radius: var(--teacher_time_card_payment_form_radius);
        padding: 8px;
        font-size: 12px;
        line-height: 1.6;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin: 12px 0;
    }

    .teacher_time_card_payment_form_infoicon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 18px;
        border: 1.6px solid #111827;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 12px;
        background: #fff;
        color: #111827;
        margin-top: 2px;
    }

    /* Fees toggle */
    .ttcpf_fees_toggle {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        border-radius: 10px;
    }

    .ttcpf_fees_toggle:hover {
        background: #f9fafb;
    }

    .ttcpf_fees_body {
        padding: 0 12px 8px 12px;
        font-size: 14px;
    }

    /* Footer */
    .ttcpf_footer {
        padding: 14px 20px 14px 20px;
        margin-bottom: 40px;
    }

    .ttcpf_footer_row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .teacher_time_card_payment_form_btn_border {
        border: 1.5px solid var(--teacher_time_card_payment_form_text);
        border-radius: var(--teacher_time_card_payment_form_radius) !important;
    }

    .teacher_time_card_payment_form_btn_sm {
        padding: .6rem 1.25rem;
        font-size: 15px;
        font-weight: 600;
    }

    #teacher_time_card_payment_form_cancel {
        width: 200px;
        background: #fff;
    }

    #teacher_time_card_payment_form_cancel:hover {
        background: #f9fafb;
    }

    .teacher_time_card_payment_form_btn_primary {
        background: linear-gradient(180deg, var(--teacher_time_card_payment_form_accent2), var(--teacher_time_card_payment_form_accent));
        color: #fff;
        box-shadow: 0 8px 18px rgba(255, 59, 31, .25);
    }

    /* Payoneer CTA (single button footer) */
    .teacher_time_card_payment_form_payoneer_cta {
        width: 100%;
        height: 50px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        color: #fff;
        background: #ff3b1f;
    }

    /* Images in tabs should not drag */
    img[draggable="false"] {
        -webkit-user-drag: none;
        user-select: none;
    }

    /* Simple utility paddings for sections */
    .ttcpf_py8 {
        padding-top: 32px;
        padding-bottom: 32px;
    }
    </style>
</head>


<body>

    <!-- DEMO trigger -->
    <!-- <div class="ttcpf_container">
        <button id="teacher_time_card_payment_form_pay_btn" class="ttcpf_btn_demo">Pay</button>
    </div> -->

    <!-- ============ MODAL ============ -->
    <div id="teacher_time_card_payment_form_modal" class="hidden">
        <div class="teacher_time_card_payment_form_backdrop"></div>

        <div class="ttcpf_modalwrap">
            <div class="teacher_time_card_payment_form_shadow ttcpf_card">

                <!-- Header -->
                <div class="ttcpf_header">
                    <h2 class="ttcpf_title">Withdraw From The Internal Account</h2>
                    <button id="teacher_time_card_payment_form_close" class="teacher_time_card_payment_form_closeX"
                        aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="ttcpf_tabs_outer">
                    <div class="teacher_time_card_payment_form_tabswrap">
                        <div class="ttcpf_tabs">
                            <button class="teacher_time_card_payment_form_tab teacher_time_card_payment_form_tab_active"
                                data-teacher_time_card_payment_form_tab="wise" aria-label="Wise">
                                <img src="images/tabs/wise.svg" alt="Wise" draggable="false">
                            </button>
                            <button class="teacher_time_card_payment_form_tab"
                                data-teacher_time_card_payment_form_tab="paypal" aria-label="PayPal">
                                <img src="images/tabs/paypal.svg" alt="PayPal" draggable="false">
                            </button>
                            <button class="teacher_time_card_payment_form_tab"
                                data-teacher_time_card_payment_form_tab="skrill" aria-label="Skrill">
                                <img src="images/tabs/skrill.svg" alt="Skrill" draggable="false">
                            </button>
                            <button class="teacher_time_card_payment_form_tab"
                                data-teacher_time_card_payment_form_tab="payoneer" aria-label="Payoneer">
                                <img src="images/tabs/payoneer.svg" alt="Payoneer" draggable="false">
                            </button>
                        </div>
                        <span class="teacher_time_card_payment_form_tabs_base"></span>
                    </div>
                </div>

                <!-- Scrollable Body -->
                <div id="teacher_time_card_payment_form_scroll_area" class="teacher_time_card_payment_form_scroll">
                    <!-- WISE CONTENT -->
                    <div id="teacher_time_card_payment_form_provider_wise">
                        <p class="ttcpf_muted" style="margin:0 0 12px 0;">Enter the amount you want to withdraw to see
                            how fees apply</p>

                        <!-- Email -->
                        <div class="ttcpf_field">
                            <label class="ttcpf_label">Email (linked to Teacher’s Wise account)</label>
                            <input id="teacher_time_card_payment_form_email_wise" type="email"
                                class="teacher_time_card_payment_form_input" placeholder="name@example.com">
                        </div>

                        <!-- Amount + Currency -->
                        <div class="ttcpf_grid">
                            <div class="ttcpf_span2">
                                <label class="ttcpf_label">Amount</label>
                                <div class="ttcpf_amountwrap">
                                    <input id="teacher_time_card_payment_form_amount" type="number" min="0" step="0.01"
                                        class="teacher_time_card_payment_form_input" placeholder="Amount"
                                        style="padding-right:64px;">
                                    <span id="teacher_time_card_payment_form_amount_suffix">USD</span>
                                </div>
                            </div>

                            <!-- Custom select (Currency) -->
                            <div class="ttcpf_span2">
                                <label class="ttcpf_label">Currency</label>

                                <!-- hidden select kept in sync for submission -->
                                <select id="teacher_time_card_payment_form_currency_native" name="currency"
                                    class="hidden">
                                    <option value="EUR">EUR</option>
                                    <option value="USD" selected>USD</option>
                                    <option value="INR">INR</option>
                                    <option value="TAKA">TAKA</option>
                                    <option value="PKR">PKR</option>
                                </select>

                                <div id="teacher_time_card_payment_form_currency"
                                    class="teacher_time_card_payment_form_select">
                                    <button type="button" id="teacher_time_card_payment_form_currency_btn"
                                        class="teacher_time_card_payment_form_select_btn">
                                        <span id="teacher_time_card_payment_form_currency_label">USD</span>
                                    </button>
                                    <svg class="teacher_time_card_payment_form_select_icon" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <div id="teacher_time_card_payment_form_currency_menu"
                                        class="teacher_time_card_payment_form_select_menu hidden" role="listbox">
                                        <div class="teacher_time_card_payment_form_select_item" data-val="EUR"
                                            role="option">EUR</div>
                                        <div class="teacher_time_card_payment_form_select_item" data-val="USD"
                                            role="option">USD</div>
                                        <div class="teacher_time_card_payment_form_select_item" data-val="INR"
                                            role="option">INR</div>
                                        <div class="teacher_time_card_payment_form_select_item" data-val="TAKA"
                                            role="option">TAKA</div>
                                        <div class="teacher_time_card_payment_form_select_item" data-val="PKR"
                                            role="option">PKR</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notices -->
                        <div class="teacher_time_card_payment_form_warn">
                            <span class="teacher_time_card_payment_form_infoicon">i</span>
                            <p style="margin:0">To withdraw, please make sure your <strong>WISE USD</strong> account
                                details are up to date.</p>
                        </div>

                        <div class="teacher_time_card_payment_form_info">
                            <span class="teacher_time_card_payment_form_infoicon" style="width:28px !important">i</span>
                            <p style="margin:0">Make sure to select the currency matching the currency of your bank
                                account to avoid conversion fees.</p>
                        </div>

                        <!-- Fees toggle -->
                        <div class="ttcpf_field">
                            <button id="teacher_time_card_payment_form_fees_toggle" type="button"
                                class="ttcpf_fees_toggle" aria-expanded="false"
                                aria-controls="teacher_time_card_payment_form_fees_body">
                                <span style="font-weight:600;">Explore Wise fees</span>
                                <svg id="teacher_time_card_payment_form_fees_icon"
                                    style="width:20px;height:20px; transition:transform .15s" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="teacher_time_card_payment_form_fees_body" class="hidden ttcpf_fees_body">
                                <p style="margin:0; line-height:1.6;">Wise charges a transaction fee and foreign
                                    exchange fee for non-USD currency.</p>
                            </div>
                        </div>
                    </div>

                    <!-- OTHER PROVIDERS (PHP includes preserved) -->
                    <div id="teacher_time_card_payment_form_provider_paypal" class="hidden ttcpf_py8">
                        <?php require_once('teacher_time_card_payment_form_paypal.php'); ?>
                    </div>

                    <div id="teacher_time_card_payment_form_provider_skrill" class="hidden ttcpf_py8">
                        <?php require_once('teacher_time_card_payment_form_skrill.php'); ?>
                    </div>

                    <div id="teacher_time_card_payment_form_provider_payoneer" class="hidden ttcpf_py8">
                        <?php require_once('teacher_time_card_payment_form_payoneer.php');
            ?>
                    </div>
                </div>

                <!-- Footer -->
                <div class="ttcpf_footer">
                    <!-- Standard footer (Cancel + Withdraw) -->
                    <div id="teacher_time_card_payment_form_footer_standard" class="ttcpf_footer_row">
                        <button id="teacher_time_card_payment_form_cancel"
                            class="teacher_time_card_payment_form_btn_border teacher_time_card_payment_form_btn_sm">Cancel</button>
                        <button id="teacher_time_card_payment_form_withdraw"
                            class="teacher_time_card_payment_form_btn_primary teacher_time_card_payment_form_btn_border teacher_time_card_payment_form_btn_sm">Withdraw
                            earnings</button>
                    </div>

                    <!-- Payoneer-only footer (single CTA) -->
                    <div id="teacher_time_card_payment_form_footer_payoneer" class="hidden">
                        <button id="teacher_time_card_payment_form_payoneer_join"
                            class="teacher_time_card_payment_form_payoneer_cta teacher_time_card_payment_form_btn_border">Join
                            Payoneer</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require_once('teacher_time_card_payment_form_verify.php'); 
  ?>

    <script>
    (function($) {
        const $modal = $('#teacher_time_card_payment_form_modal');
        const $tabs = $modal.find('.teacher_time_card_payment_form_tab');

        function openModal() {
            $modal.removeClass('hidden');
        }

        function closeModal() {
            $modal.addClass('hidden');
        }

        $('#teacher_time_card_payment_form_pay_btn').on('click', openModal);
        $('#teacher_time_card_payment_form_close, #teacher_time_card_payment_form_cancel').on('click', closeModal);
        $modal.on('click', function(e) {
            if (!$(e.target).closest('.ttcpf_card').length) {
                closeModal();
            }
        });
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$modal.hasClass('hidden')) closeModal();
        });

        /* Provider switching */
        const views = {
            wise: $('#teacher_time_card_payment_form_provider_wise'),
            paypal: $('#teacher_time_card_payment_form_provider_paypal'),
            skrill: $('#teacher_time_card_payment_form_provider_skrill'),
            payoneer: $('#teacher_time_card_payment_form_provider_payoneer'),
        };

        const $footerStandard = $('#teacher_time_card_payment_form_footer_standard');
        const $footerPayoneer = $('#teacher_time_card_payment_form_footer_payoneer');

        function setProvider(p) {
            $tabs.removeClass('teacher_time_card_payment_form_tab_active');
            $tabs.filter('[data-teacher_time_card_payment_form_tab="' + p + '"]').addClass(
                'teacher_time_card_payment_form_tab_active');

            $.each(views, function(k, $el) {
                (k === p) ? $el.removeClass('hidden'): $el.addClass('hidden');
            });

            if (p === 'payoneer') {
                $footerStandard.addClass('hidden');
                $footerPayoneer.removeClass('hidden');
            } else {
                $footerPayoneer.addClass('hidden');
                $footerStandard.removeClass('hidden');
            }
        }
        $tabs.on('click', function() {
            setProvider($(this).data('teacher_time_card_payment_form_tab'));
        });
        setProvider('wise'); // default

        /* Custom currency select (WISE only) */
        const $native = $('#teacher_time_card_payment_form_currency_native');
        const $btn = $('#teacher_time_card_payment_form_currency_btn');
        const $menu = $('#teacher_time_card_payment_form_currency_menu');
        const $label = $('#teacher_time_card_payment_form_currency_label');
        const $suffix = $('#teacher_time_card_payment_form_amount_suffix');

        function setCurrency(val) {
            $native.val(val);
            $label.text(val);
            $suffix.text(val);
        }

        function openMenu() {
            $menu.removeClass('hidden');
            $btn.attr('aria-expanded', 'true');
        }

        function closeMenu() {
            $menu.addClass('hidden');
            $btn.attr('aria-expanded', 'false');
        }

        $btn.on('click', function(e) {
            e.stopPropagation();
            $menu.hasClass('hidden') ? openMenu() : closeMenu();
        });
        $menu.on('click', '.teacher_time_card_payment_form_select_item', function(e) {
            e.stopPropagation();
            setCurrency($(this).data('val'));
            closeMenu();
        });
        $(document).on('click', function() {
            closeMenu();
        });
        setCurrency($native.val());

        /* Withdraw demo */
        $('#teacher_time_card_payment_form_withdraw').on('click', function() {
            alert('Withdrawal submitted (demo):\nProvider: ' +
                $('.teacher_time_card_payment_form_tab_active').data(
                    'teacher_time_card_payment_form_tab') +
                '\nAmount: ' + $('#teacher_time_card_payment_form_amount').val() + ' ' + $label.text());
            closeModal();
        });

        /* Payoneer CTA demo */
        $('#teacher_time_card_payment_form_payoneer_join').on('click', function() {
            alert('Redirecting to Payoneer sign-up (demo).');
            closeModal();
        });

        /* Fees toggle */
        $('#teacher_time_card_payment_form_fees_toggle').on('click', function() {
            const $body = $('#teacher_time_card_payment_form_fees_body');
            const $ico = $('#teacher_time_card_payment_form_fees_icon');
            const open = !$body.hasClass('hidden');
            $body.toggleClass('hidden', open);
            $ico.css('transform', open ? '' : 'rotate(180deg)');
        });

    })(jQuery);

    /* Verify modal hook (kept as-is) */
    $('#teacher_time_card_payment_form_withdraw, #teacher_time_card_payment_form_payoneer_join').on('click', function(
        e) {
        e.preventDefault();
        const email = $('#teacher_time_card_payment_form_email_wise').val() || 'ranaali2247407@gmail.com';
        if (typeof teacher_time_card_payment_form_verify_open === 'function') {
            teacher_time_card_payment_form_verify_open(email);
        }
    });
    </script>
</body>

</html>