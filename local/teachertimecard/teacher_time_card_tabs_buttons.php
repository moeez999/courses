<style>
    /* Buttons */
    .ttc-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .ttc-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 16px;
        background: #fff;
        color: #000;
        border: 1px solid #E4E7EE;
        border-radius: 5px;
        font: 500 14px/1 'Inter', sans-serif;
        cursor: pointer;
        transition: background .2s, transform .02s, border-color .2s;
    }

    .ttc-btn:hover {
        background: #F6F7FA;
    }

    .ttc-btn:active {
        transform: translateY(1px);
    }

    .ttc-btn.active-tab {
        border: 1.5px solid #000;
        background: #F6F7FA;
    }

    .ttc-icon {
        width: 18px;
        height: 18px;
        display: block;
    }

    /* Filter Dropdown */
    .ttc-filter-wrap {
        position: relative;
        display: inline-block;
    }

    .ttc-filter-menu {
        position: absolute;
        top: 48px;
        left: 0;
        min-width: 220px;
        background: #fff;
        border: 1px solid #E4E7EE;
        border-radius: 14px;
        box-shadow: 0 10px 24px rgba(16, 24, 40, .08);
        padding: 8px;
        z-index: 1000;
        display: none;
    }

    .ttc-filter-menu.show {
        display: block;
        animation: ttcFade .12s ease-out;
    }

    .ttc-filter-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        user-select: none;
    }

    .ttc-filter-item:hover {
        background: #F6F7FA;
    }

    .ttc-check {
        appearance: none;
        width: 22px;
        height: 22px;
        border-radius: 6px;
        border: 1.5px solid #E4E7EE;
        background: #fff;
        position: relative;
        cursor: pointer;
    }

    .ttc-check:checked {
        background: #F04438;
        border-color: #F04438;
    }

    .ttc-check:checked::before {
        content: "";
        position: absolute;
        left: 6px;
        top: 4px;
        width: 8px;
        height: 12px;
        border-right: 2px solid #fff;
        border-bottom: 2px solid #fff;
        transform: rotate(45deg);
    }

    @keyframes ttcFade {
        from {
            opacity: 0;
            transform: translateY(-4px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Payment History Section */
    .ttc-payment-history {
        display: none;
        border: 1px solid #E4E7EE;
        border-radius: 12px;
        background: #fff;
        padding: 20px;
    }

    .ttc-payment-history.active {
        display: block;
    }

    .ttc-payment-history h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #000;
    }

    .ttc-payment-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
    }

    .ttc-payment-table th {
        text-align: left;
        font-weight: 600;
        padding: 10px 8px;
        border-bottom: 1px solid #E4E7EE;
        color: #555;
    }

    .ttc-payment-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #F2F3F5;
        color: #000;
    }

    .ttc-payment-table a {
        color: #0A66C2;
        font-weight: 500;
        text-decoration: none;
    }

    .ttc-payment-table a:hover {
        text-decoration: underline;
    }
</style>

<div class="ttc-actions">

   <!-- Payment History Button -->
    <button type="button" id="ttc_payment_history_btn" class="ttc-btn active-tab" aria-label="Payment History">
        <svg class="ttc-icon" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M7 3.75h7.5A1.75 1.75 0 0 1 16.25 5.5v13.75l-2.25-1.2-2.25 1.2-2.25-1.2-2.25 1.2V5.5A1.75 1.75 0 0 1 7 3.75z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8.75 8.25V4.75h3v4.75L10.25 8.8 8.75 9.5z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
            <path d="M8.75 12h6.5M8.75 15h6.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
        </svg>
        <span>Payment History</span>
    </button>

    <!-- Filter Dropdown Button -->
    <div class="ttc-filter-wrap">
        <button type="button" id="ttc_filter_btn" class="ttc-btn" aria-expanded="false" aria-controls="ttc_filter_menu">
            <svg class="ttc-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                <circle cx="9" cy="7" r="2.2" fill="none" stroke="currentColor" stroke-width="1.6" />
                <circle cx="15" cy="12" r="2.2" fill="none" stroke="currentColor" stroke-width="1.6" />
                <circle cx="7" cy="17" r="2.2" fill="none" stroke="currentColor" stroke-width="1.6" />
            </svg>
            <span>Filter</span>
        </button>

        <!-- Dropdown -->
        <div id="ttc_filter_menu" class="ttc-filter-menu" role="menu">
            <label class="ttc-filter-item"><input type="checkbox" class="ttc-check"><span>Both</span></label>
            <label class="ttc-filter-item"><input type="checkbox" class="ttc-check"><span>Group hours</span></label>
            <label class="ttc-filter-item"><input type="checkbox" class="ttc-check"><span>1:1 Sessions</span></label>
        </div>
    </div>
</div>

<!-- Hidden Payment History Content -->
<div id="ttc_payment_history_section" class="ttc-payment-history">
    <h3>Payment history</h3>
    <table class="ttc-payment-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Period Paid</th>
                <th>Subject</th>
                <th>Total Paid</th>
                <th>Group Paid</th>
                <th>1:1 Paid</th>
                <th>Download All</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Oct 2, 2025</td>
                <td>Sep 3 - Oct 2, 2025</td>
                <td>English</td>
                <td>$200 (40 hrs)</td>
                <td>$100 (20 hrs) - $5/hr</td>
                <td>$100 (20 hrs) - $6/hr</td>
                <td><a href="#">Get receipt</a></td>
            </tr>
            <tr>
                <td>Sep 3, 2025</td>
                <td>Aug 4 - Sep 3, 2025</td>
                <td>English</td>
                <td>$100 (40 hrs)</td>
                <td>$50 (20 hrs) - $5/hr</td>
                <td>$50 (20 hrs) - $6/hr</td>
                <td><a href="#">Get receipt</a></td>
            </tr>
            <tr>
                <td>Aug 4, 2025</td>
                <td>Jul 2 - Aug 4, 2025</td>
                <td>English</td>
                <td>$300 (40 hrs)</td>
                <td>$150 (20 hrs) - $5/hr</td>
                <td>$150 (20 hrs) - $6/hr</td>
                <td><a href="#">Get receipt</a></td>
            </tr>
        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    jQuery(function($) {

        // ---- FILTER DROPDOWN ----
        const $btn = $('#ttc_filter_btn');
        const $menu = $('#ttc_filter_menu');

        $btn.on('click', function(e) {
            e.stopPropagation();
            $menu.toggleClass('show');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#ttc_filter_menu, #ttc_filter_btn').length) {
                $menu.removeClass('show');
            }
        });

        // ---- PAYMENT HISTORY TAB ----
        $('#ttc_payment_history_btn').on('click', function() {
            $(this).addClass('active-tab');
            $('#ttc_filter_btn').removeClass('active-tab');
            $('#ttc_payment_history_section').addClass('active');
        });
    });
</script>