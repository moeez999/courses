<!-- for group -->
<div class="subscribe-modal-backdrop" data-subscribe-modal>
    <div class="subscribe-modal-main">
        <button class="subscribe-modal__close" data-subscribe-close aria-label="Close">
            &times;
        </button>
        <main class="checkout-page">
            <div class="checkout-container">
                <section class="plan-selection-panel">
                    <div class="panel-content">
                        <div class="selection-header">
                            <!--merged image-->
                            <div class="header-icon-wrapper">
                                <img src="../img/subs/Progress-steps.png" alt="" />
                            </div>
                            <div class="selection-header-text">
                                <h2>Time to help you succeed at work!</h2>
                                <p>Consistency is key to progress, so we recommend a weekly schedule. Each
                                    <b>50-min</b>
                                    lesson costs <b>$9.00</b>.
                                </p>
                            </div>
                        </div>
                        <div class="plan-options">
                            <div class="plan-option">
                                <input type="radio" name="plan" id="plan-1" class="visually-hidden">
                                <label for="plan-1" class="plan-label">
                                    <span class="plan-name">1 Month</span>
                                    <span class="plan-price"><b>$36.00</b> per Month</span>
                                </label>
                            </div>
                            <div class="plan-option">
                                <input type="radio" name="plan" id="plan-4" class="visually-hidden">
                                <label for="plan-4" class="plan-label">
                                    <span class="plan-name">4 Months</span>
                                    <span class="plan-price"><b>$72.00</b> per 4 Month</span>
                                </label>
                            </div>
                            <div class="plan-option">
                                <input type="radio" name="plan" id="plan-6" class="visually-hidden" checked>
                                <label for="plan-6" class="plan-label">
                                    <span class="plan-name">6 Months</span>
                                    <span class="plan-price"><b>$108.00</b> per 6 Month</span>
                                </label>
                            </div>
                            <div class="plan-option">
                                <input type="radio" name="plan" id="plan-9" class="visually-hidden">
                                <label for="plan-9" class="plan-label">
                                    <span class="plan-name">9 Months</span>
                                    <span class="plan-price"><b>$144.00</b> per 9 Month</span>
                                </label>
                            </div>
                            <div class="plan-option">
                                <input type="radio" name="plan" id="plan-12" class="visually-hidden">
                                <label for="plan-12" class="plan-label">
                                    <div class="plan-name-wrapper">
                                        <span class="plan-name">12 Months</span>
                                        <span class="popular-badge">Popular</span>
                                    </div>
                                    <span class="plan-price"><b>$180.00</b> per 12 Month</span>
                                </label>
                            </div>
                            <div class="plan-option">
                                <input type="radio" name="plan" id="plan-custom-2" class="visually-hidden">
                                <label for="plan-custom" class="plan-label">
                                    <div class="custom-plan-text">
                                        <span class="plan-name">Custom plan</span>
                                        <p>Choose the number of <b>months</b> if that suits you better.</p>
                                    </div>
                                    <img src="../img/subs/calendar.png" alt="" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <footer class="selection-footer">
                        <button class="checkout-button">Continue to checkout</button>
                    </footer>
                </section>
                <div class="confirm-section">
                    <section id="intro">
                        <div class="intro-container">
                            <!--merged image-->
                            <div class="intro-icon-wrapper">
                                <img src="../img/subs/good-choice.png" alt="icon element" />
                            </div>
                            <div class="intro-text">
                                <h1 class="intro-heading">Good choice. Last step!</h1>
                                <p class="intro-subheading">Enter your details to confirm your monthly subscription.
                                </p>
                            </div>
                        </div>
                    </section>
                    <section id="order">
                        <div class="order-container">
                            <h2 class="order-title">Your order</h2>
                            <hr>
                            <div class="order-items-list">
                                <div class="order-item">
                                    <span class="item-name">6 Months Plan</span>
                                    <span class="item-price">$108.00</span>
                                </div>
                                <div class="order-item">
                                    <div class="item-name-with-icon">
                                        <span class="item-name">Taxes & fees</span>
                                        <img src="../img/subs/question-mark.svg" alt="info icon" class="info-icon">
                                    </div>
                                    <span class="item-price">$12.00</span>
                                </div>
                                <div class="order-item">
                                    <div class="item-name-with-icon">
                                        <span class="item-name">Your latingles credit</span>
                                        <img src="../img/subs/question-mark.svg" alt="info icon" class="info-icon">
                                    </div>
                                    <span class="item-price">$20.00</span>
                                </div>
                            </div>
                            <div class="order-total">
                                <div class="total-row">
                                    <h3 class="total-label">Total</h3>
                                    <span class="total-amount">$120.00</span>
                                </div>
                                <span class="total-period">per 6 Month</span>
                            </div>
                            <!-- Promo code row (hidden until "Have a promo code?" is clicked) -->
                            <div class="promo-row" hidden>
                                <label class="sr-only" for="promo-input">Promo code</label>
                                <input id="promo-input" class="promo-input" type="text" inputmode="text"
                                    autocomplete="off" placeholder="Enter promo code" />
                                <button class="promo-apply" type="button">Apply</button>
                            </div>
                            <a href="#" class="promo-link">Have a promo code?</a>
                        </div>
                    </section>
                    <section id="payment">
                        <div class="payment-container">
                            <hr>
                            <div class="payment-details">
                                <h2 class="payment-title">Payment method</h2>
                                <div class="payment-selector-container">
                                    <button class="payment-selector">
                                        <div class="card-details">
                                            <img src="../img/subs/visa.png" alt="Visa" alt="Visa" class="card-logo">
                                            <span class="card-number">visa****7583</span>
                                        </div>
                                        <img src="../img/subs/arrow-down.svg" alt="dropdown arrow" alt="dropdown arrow"
                                            class="dropdown-arrow">
                                    </button>
                                    <!-- Payment dropdown menu -->
                                    <ul class="payment-menu" role="listbox" aria-label="Payment methods" hidden>
                                        <li class="payment-option" role="option" tabindex="-1" data-method="visa"
                                            data-label="visa ****7583">
                                            <span>visa ****7583</span>
                                        </li>
                                        <li class="payment-option" role="option" tabindex="-1" data-method="new-card"
                                            data-label="New Payment Card">
                                            <span>New Payment Card</span>
                                        </li>
                                        <li class="payment-option" role="option" tabindex="-1" data-method="apple-pay"
                                            data-label="Apple Pay">
                                            <span>Apple Pay</span>
                                        </li>
                                        <li class="payment-option" role="option" tabindex="-1" data-method="google-pay"
                                            data-label="Google Pay">
                                            <span>Google Pay</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- New Card form (hidden until 'New Payment Card' selected) -->
                                <div class="new-card-form" hidden>
                                    <label>Card Number</label>
                                    <input type="text" placeholder="5218 - 9811 - 4323 - 5216" />
                                    <div class="new-card-row">
                                        <div>
                                            <label>Expire Date</label>
                                            <input type="text" placeholder="MM / YYYY" />
                                        </div>
                                        <div>
                                            <label>Security Code</label>
                                            <input type="text" placeholder="CVC / CVV" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Apple Pay button (hidden until Apple Pay selected) -->
                                <button class="apple-pay-button" hidden><img src="../img/subs/apple-pay.svg"
                                        alt="Apple Pay" alt="Apple Pay" class="apple-pay-logo"></button>
                                <!-- Google Pay button (hidden until Google Pay selected) -->
                                <button class="google-pay-button" hidden><img src="../img/subs/google-pay.svg"
                                        alt="Google Pay" alt="Google Pay" class="google-pay-logo"></button>
                                <button class="confirm-button">Confirm monthly subscription</button>
                                <p class="policy-text">
                                    By pressing the "Confirm monthly subscription" button, you agree to <a href="#"
                                        class="policy-link">LAtingles’s Refund and Payment Policy</a>.
                                </p>
                                <div class="info-box-cancellation">
                                    <img src="../img/subs/check-mark.svg" alt="checkmark" class="info-icon">
                                    <p>You can change your tutor for free or cancel your subscriptioat any time</p>
                                </div>
                                <div class="info-box-renewal">
                                    <h3 class="renewal-title">Renews automatically every 6 Months</h3>
                                    <p class="renewal-text">We will charge <strong>$120.00</strong> to your saved
                                        payment method to add <strong>6 Months</strong> plan unless you cancel your
                                        subscription
                                    </p>
                                </div>
                                <p class="security-text">It’s safe to pay on Latingles. All transactions are
                                    protected
                                    by SSL encryption.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
                <section class="plan-summary-panel">
                    <button class="close-button" data-subscribe-close aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                                fill="#121117"></path>
                        </svg>
                    </button>
                    <div class="summary-card">
                        <div class="summary-header">
                            <h3>Your learning plan</h3>
                            <a href="#" class="link open-faq-modal-group">See how our plans work</a>
                        </div>
                        <hr class="separator">
                        <div class="summary-body">
                            <div class="plan-title-section">
                                <h4>6 Months Plan</h4>
                                <p>That’s <b>6 Months Plan at $108.00.</b></p>
                                <span class="flexible-badge"><img src="${ASSET_PATH}/8160_24684.svg" alt="">Flexible
                                    plan</span>
                            </div>
                            <section id="plan-selector">
                                <div class="plan-container">
                                    <div class="plan-header-group">
                                        <h2 class="plan-title">How many Months would you like to<br>Select?</h2>
                                        <div class="plan-dropdown" role="button" tabindex="0">
                                            <span class="plan-dropdown-value">12</span>
                                            <img src="../img/subs/arrow-down.svg" alt="Dropdown arrow"
                                                class="plan-dropdown-arrow">
                                            <section id="pricing-options">
                                                <div class="pricing-list-container">
                                                    <ul class="pricing-list">
                                                        <li class="pricing-item">
                                                            <span class="item-label">4 Months</span>
                                                            <span class="item-price">$72.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">5 Months</span>
                                                            <span class="item-price">$90.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">6 Months</span>
                                                            <span class="item-price">$108.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">7 Months</span>
                                                            <span class="item-price">$120.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">8 Months</span>
                                                            <span class="item-price">$135.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">9 Months</span>
                                                            <span class="item-price">$144.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">10 Months</span>
                                                            <span class="item-price">$156.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">11 Months</span>
                                                            <span class="item-price">$170.00</span>
                                                        </li>
                                                        <li class="pricing-item">
                                                            <span class="item-label">12 Months</span>
                                                            <span class="item-price">$180.00</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <hr class="plan-separator">
                                    <div class="plan-details">
                                        <div class="plan-duration">
                                            <p class="duration-number">12</p>
                                            <p class="duration-label">Months</p>
                                        </div>
                                        <div class="plan-pricing">
                                            <div class="plan-pricing-sub">
                                                <p class="price-amount">$180.00</p>
                                                <div class="plan-badge">save 20%</div>
                                            </div>
                                            <p class="price-description">charged per 12 Month</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <ul class="features-list">
                                <li class="feature-item">
                                    <div class="feature-icon-wrapper"><img src="../img/subs/calender-1.png" alt="">
                                    </div>
                                    <p>your <b>lessons will be scheduled for 6 Months</b></p>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon-wrapper"><img src="../img/subs/cap.png" alt=""></div>
                                    <p>Change your tutor <b>for free at any time.</b></p>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon-wrapper"><img src="../img/subs/stop.png" alt=""></div>
                                    <p>Cancel your plan <b>at any time.</b></p>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon-wrapper"><img src="../img/subs/clock.png" alt=""></div>
                                    <p>Change the duration of your classes <b>at any time.</b></p>
                                </li>
                            </ul>
                        </div>
                        <hr class="separator">
                        <div class="group-details">
                            <img src="../img/subs/group-section/1.png" alt="Florida 1" class="group-logo">
                            <div class="group-info">
                                <div class="group-header">
                                    <h5 class="group-name">English Group (FL1)</h5>
                                    <div class="group-rating">
                                        <img src="../img/subs/star.png" alt="star icon">
                                        <span class="rating-score">5</span>
                                        <a href="#" class="link">(3 reviews)</a>
                                    </div>
                                </div>
                                <div class="group-schedule">
                                    <!--merged image-->
                                    <div class="tutor-avatars">
                                        <img src="../img/subs/1.png" alt="Tutor avatar">
                                        <img src="../img/subs/2.png" alt="Tutor avatar">
                                    </div>
                                    <div class="time-tags">
                                        <span class="time-tag">Mon - 5: 40 am</span>
                                        <span class="time-tag">Tue - 5: 40 am</span>
                                        <span class="time-tag">Fri - 5: 40 am</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="moving-container">
                            <p><img src="" alt=""> moving from FL1 to NY2</p>
                        </div>
                        <div class="group-details new-group">
                            <img src="../img/subs/group-section/2.png" alt="Florida 1" class="group-logo">
                            <div class="group-info">
                                <div class="group-header">
                                    <h5 class="group-name">English Group (NY2)</h5>
                                    <div class="group-rating">
                                        <img src="../img/subs/star.png" alt="star icon">
                                        <span class="rating-score">5</span>
                                        <a href="#" class="link">(3 reviews)</a>
                                    </div>
                                </div>
                                <div class="group-schedule">
                                    <!--merged image-->
                                    <div class="tutor-avatars">
                                        <img src="../img/subs/1.png" alt="Tutor avatar">
                                        <img src="../img/subs/2.png" alt="Tutor avatar">
                                    </div>
                                    <div class="time-tags">
                                        <span class="time-tag">Mon - 5: 40 am</span>
                                        <span class="time-tag">Tue - 5: 40 am</span>
                                        <span class="time-tag">Fri - 5: 40 am</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <!-- Modal + overlay -->
        <div class="modal-overlay" data-faq-overlay-group hidden>
            <div class="modal modal-faq" data-faq>
                <button class="modal-close" type="button" aria-label="Close" data-faq-close>&times;</button>
                <h2 id="faq-modal-title" class="modal-title">See how plans works</h2>
                <div class="faq" data-faq>
                    <!-- Item -->
                    <section class="faq-item">
                        <h3>
                            <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p1" id="faq-h1">
                                How to schedule your lessons
                                <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                        alt=""></span>
                            </button>
                        </h3>
                        <div id="faq-p1" class="faq-panel" role="region" aria-labelledby="faq-h1" hidden>
                            <div class="faq-panel-inner">
                                Dummy content: Go to “My Lessons”, pick a time slot, and confirm. You’ll receive a
                                calendar invite and in-app reminder.
                            </div>
                        </div>
                    </section>
                    <!-- Item -->
                    <section class="faq-item">
                        <h3>
                            <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p2" id="faq-h2">
                                How to change your tutor
                                <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                        alt=""></span>
                            </button>
                        </h3>
                        <div id="faq-p2" class="faq-panel" role="region" aria-labelledby="faq-h2" hidden>
                            <div class="faq-panel-inner">
                                Dummy content: From your dashboard, choose “Change tutor”, review suggestions, and
                                confirm. Your plan and credits carry over.
                            </div>
                        </div>
                    </section>
                    <!-- Item -->
                    <section class="faq-item">
                        <h3>
                            <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p3" id="faq-h3">
                                How to cancel your plan
                                <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                        alt=""></span>
                            </button>
                        </h3>
                        <div id="faq-p3" class="faq-panel" role="region" aria-labelledby="faq-h3" hidden>
                            <div class="faq-panel-inner">
                                Dummy content: Open “Billing & Plan”, click “Cancel plan”, follow the steps, and
                                you’ll see your end date immediately.
                            </div>
                        </div>
                    </section>
                    <!-- Item -->
                    <section class="faq-item">
                        <h3>
                            <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p4" id="faq-h4">
                                How to change your renewal date
                                <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                        alt=""></span>
                            </button>
                        </h3>
                        <div id="faq-p4" class="faq-panel" role="region" aria-labelledby="faq-h4" hidden>
                            <div class="faq-panel-inner">
                                Dummy content: In “Billing & Plan”, choose “Change renewal”, select a new date, and
                                confirm the proration preview.
                            </div>
                        </div>
                    </section>
                    <!-- Item -->
                    <section class="faq-item">
                        <h3>
                            <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p5" id="faq-h5">
                                How automatic payments work
                                <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                        alt=""></span>
                            </button>
                        </h3>
                        <div id="faq-p5" class="faq-panel" role="region" aria-labelledby="faq-h5" hidden>
                            <div class="faq-panel-inner">
                                Dummy content: We charge your saved method on the renewal date. You’ll get a receipt
                                and can update payment any time.
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// for group
(function() {
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
    const $ = (sel, ctx = document) => ctx.querySelector(sel);

    // ====== Elements ======
    const backdrop = $("[data-subscribe-modal]");
    const openers = $$(".subscribe-modal-open");
    const closeBtns = $$("[data-subscribe-close]");
    const planRadios = $$('input[name="plan"]');

    // Summary targets
    const summaryTitleEl = $(".plan-title-section h4");
    const summaryLineEl = $(".plan-title-section p b");
    const scheduledP = $(".features-list .feature-item p");

    // ✅ Use the actual ID present in your HTML
    const customSelector =
        $("#plan-selector") || document.querySelector('[id*="plan-selector" i]');

    // Custom selector sub-elements (scoped to the section)
    const customDropdownBtn = customSelector?.querySelector(".plan-dropdown");
    const customDropdownValue = customSelector?.querySelector(
        ".plan-dropdown-value"
    ); // the "12" in the pill
    const customDurationNum = customSelector?.querySelector(
        ".plan-details .duration-number"
    ); // big "12"
    const customPriceAmount = customSelector?.querySelector(
        ".plan-pricing .price-amount"
    ); // "$180.00"
    const customPriceDesc = customSelector?.querySelector(
        ".plan-pricing .price-description"
    ); // "charged per 12 Month"
    const planBadge = customSelector?.querySelector(".plan-pricing .plan-badge"); // optional
    const pricingOptions = customSelector?.querySelector(
        "#pricing-options"); // dropdown list container (keep it inside the section)

    // ====== Plan map for preset radios ======
    const PLAN_MAP = {
        "plan-1": {
            months: 1,
            price: 36.0,
            label: "1 Month"
        },
        "plan-4": {
            months: 4,
            price: 72.0,
            label: "4 Months"
        },
        "plan-6": {
            months: 6,
            price: 108.0,
            label: "6 Months"
        },
        "plan-9": {
            months: 9,
            price: 144.0,
            label: "9 Months"
        },
        "plan-12": {
            months: 12,
            price: 180.0,
            label: "12 Months"
        },
        "plan-custom": {
            months: null,
            price: null,
            label: "Custom plan"
        },
    };

    // ====== Utils ======
    function money(n) {
        return `$${Number(n).toFixed(2)}`;
    }

    // ✅ Fix regex: use a real regex literal and \d
    function parseMonthsFromText(txt) {
        const m = String(txt).match(/(\d+)\s*Month/i);
        return m ? Number(m[1]) : null;
    }

    function parsePriceFromText(txt) {
        const clean = String(txt).replace(/[^\d.]/g, "");
        return clean ? Number(clean) : null;
    }

    // ====== Modal controls (unchanged) ======
    function openModal() {
        backdrop?.classList.add("is-open");
        document.body.style.overflow = "hidden";
    }

    function closeModal(modal) {
        backdrop?.classList.remove("is-open");
        modal?.classList.remove("active");
        document.body.style.overflow = "";
        closePricingOptions(); // safety
    }
    openers.forEach((btn) =>
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            openModal();
        })
    );
    closeBtns.forEach((btn) => btn.addEventListener("click", closeModal));
    backdrop?.addEventListener("click", (e) => {
        if (e.target === backdrop) closeModal();
    });
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            if (isPricingOpen()) closePricingOptions();
            else closeModal();
        }
    });

    // ====== Pricing dropdown controls ======
    function isPricingOpen() {
        return pricingOptions?.classList.contains("is-open");
    }

    function openPricingOptions() {
        if (!pricingOptions) return;
        pricingOptions.hidden = false;
        pricingOptions.classList.add("is-open");
        document.addEventListener("click", outsideCloseHandler, {
            capture: true
        });
    }

    function closePricingOptions() {
        if (!pricingOptions) return;
        pricingOptions.hidden = true;
        pricingOptions.classList.remove("is-open");
        document.removeEventListener("click", outsideCloseHandler, {
            capture: true,
        });
    }

    function togglePricingOptions() {
        if (!pricingOptions) return;
        isPricingOpen() ? closePricingOptions() : openPricingOptions();
    }

    function outsideCloseHandler(e) {
        if (!pricingOptions) return;
        const clickInsideList = pricingOptions.contains(e.target);
        const clickOnButton = customDropdownBtn?.contains(e.target);
        if (!clickInsideList && !clickOnButton) closePricingOptions();
    }

    // Wire dropdown button
    customDropdownBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        togglePricingOptions();
    });
    customDropdownBtn?.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            togglePricingOptions();
        }
    });

    // Handle item selection from dropdown list
    pricingOptions?.addEventListener("click", (e) => {
        const item = e.target.closest(".pricing-item");
        if (!item) return;

        // prevent the document click handler from running after selection
        e.preventDefault();
        e.stopPropagation();

        const labelEl = item.querySelector(".item-label");
        const priceEl = item.querySelector(".item-price");

        const months = parseMonthsFromText(labelEl?.textContent || "");
        const price = parsePriceFromText(priceEl?.textContent || "");
        if (!months || !price) return;

        // Update UI
        if (customDropdownValue) customDropdownValue.textContent = String(months);
        if (customDurationNum) customDurationNum.textContent = String(months);
        if (customPriceAmount) customPriceAmount.textContent = money(price);
        if (customPriceDesc)
            customPriceDesc.textContent = `charged per ${months} Month`;

        const customRadio = $("#plan-custom");
        if (customRadio && !customRadio.checked) {
            customRadio.checked = true;
            syncCustomVisibility("plan-custom");
        }

        updateSummaryCustom(months, price);

        // Close dropdown (use rAF so updates paint first)
        requestAnimationFrame(closePricingOptions);
    });

    document.addEventListener("click", outsideCloseHandler, {
        capture: true
    });

    // ====== Show/hide custom selector with plan choice ======
    function openCustom() {
        if (!customSelector) return;
        customSelector.hidden = false;
        customSelector.classList.add("is-visible");
        customSelector.setAttribute("aria-hidden", "false");
        customDropdownBtn?.focus({
            preventScroll: false
        });
        $(".plan-title-section").style.display = "none";
        customSelector.scrollIntoView({
            behavior: "smooth",
            block: "nearest"
        });
    }

    function closeCustom() {
        if (!customSelector) return;
        customSelector.hidden = true;
        customSelector.classList.remove("is-visible");
        customSelector.setAttribute("aria-hidden", "true");
        $(".plan-title-section").style.display = "block";
        closePricingOptions();
    }

    function syncCustomVisibility(planId) {
        if (planId === "plan-custom") openCustom();
        else closeCustom();
    }

    // ====== Summary updater ======
    function updateSummaryCustom(months, price) {
        if (summaryTitleEl) summaryTitleEl.textContent = `${months} Months Plan`;
        if (summaryLineEl)
            summaryLineEl.textContent = `${months} Months Plan at ${money(price)}.`;
        if (scheduledP) {
            scheduledP.innerHTML = scheduledP.innerHTML.replace(
                /scheduled for <b>.*?<\/b>/,
                `scheduled for <b>${months} Months</b>`
            );
        }
    }

    function updateSummaryById(planId) {
        const plan = PLAN_MAP[planId];
        if (!plan) return;

        if (planId === "plan-custom") {
            const months = parseInt(customDurationNum?.textContent || "", 10);
            const price = parsePriceFromText(customPriceAmount?.textContent || "");
            if (months && price) {
                updateSummaryCustom(months, price);
            } else {
                if (summaryTitleEl) summaryTitleEl.textContent = "Custom Plan";
                if (summaryLineEl)
                    summaryLineEl.textContent = "Choose a custom number of months.";
                if (scheduledP) {
                    scheduledP.innerHTML = scheduledP.innerHTML.replace(
                        /scheduled for .*?<\/b>/,
                        "scheduled for <b>your chosen duration</b>"
                    );
                }
            }
            return;
        }

        const {
            months,
            price,
            label
        } = plan;
        if (summaryTitleEl) summaryTitleEl.textContent = `${label} Plan`;
        if (summaryLineEl)
            summaryLineEl.textContent = `${label} Plan at ${money(price)}.`;
        if (scheduledP) {
            scheduledP.innerHTML = scheduledP.innerHTML.replace(
                /scheduled for <b>.*?<\/b>/,
                `scheduled for <b>${months} Months</b>`
            );
        }
    }

    // ====== Wire up radios ======
    planRadios.forEach((r) => {
        r.addEventListener("change", () => {
            if (r.checked) {
                updateSummaryById(r.id);
                syncCustomVisibility(r.id);
            }
        });
    });

    // ====== Init ======
    // Hide custom selector unless custom is selected
    const initial = planRadios.find((r) => r.checked) || planRadios[0];
    if (initial) {
        updateSummaryById(initial.id);
        syncCustomVisibility(initial.id);
    } else {
        // no radio? just hide custom UI by default
        closeCustom();
    }

    // ===== Promo code toggle =====
    const promoLink = document.querySelector(".promo-link");
    const promoRow = document.querySelector(".promo-row");
    const promoInput = document.getElementById("promo-input");
    const promoApply = document.querySelector(".promo-apply");

    if (promoLink && promoRow && promoInput && promoApply) {
        promoLink.addEventListener("click", (e) => {
            e.preventDefault();
            promoLink.setAttribute("hidden", ""); // hide the link
            promoRow.hidden = false; // show the input+button
            promoInput.focus(); // focus the input
        });

        promoApply.addEventListener("click", () => {
            const code = promoInput.value.trim();
            if (!code) {
                promoInput.focus();
                return;
            }
            // TODO: replace with your real apply-code call
            // Example: applyPromo(code).then(...).catch(...)
            console.log("Applying promo code:", code);
        });

        // Allow Enter key in the input to trigger Apply
        promoInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                promoApply.click();
            }
        });
    }

    // ===== Payment dropdown =====
    const selectorBtn = document.querySelector(".payment-selector");
    const menu = document.querySelector(".payment-menu");
    const options = menu ?
        Array.from(menu.querySelectorAll(".payment-option")) : [];
    const numberSpan = document.querySelector(".card-number"); // in the button
    let menuOpen = false;
    let activeIndex = -1;

    function openMenu() {
        if (!selectorBtn || !menu) return;
        menu.hidden = false;
        menuOpen = true;
        selectorBtn.setAttribute("aria-expanded", "true");
        selectorBtn.setAttribute("aria-haspopup", "listbox");
        // Focus the first option by default
        setActive(0);
        options[0]?.focus();
        document.addEventListener("click", onDocumentClick);
        document.addEventListener("keydown", onKeydown);
    }

    function closeMenu() {
        if (!selectorBtn || !menu) return;
        menu.hidden = true;
        menuOpen = false;
        selectorBtn.setAttribute("aria-expanded", "false");
        activeIndex = -1;
        document.removeEventListener("click", onDocumentClick);
        document.removeEventListener("keydown", onKeydown);
    }

    function toggleMenu() {
        if (menuOpen) closeMenu();
        else openMenu();
    }

    function onDocumentClick(e) {
        if (!menuOpen) return;
        const isInside = menu.contains(e.target) || selectorBtn.contains(e.target);
        if (!isInside) closeMenu();
    }

    function onKeydown(e) {
        if (!menuOpen) return;
        const key = e.key;

        if (key === "Escape") {
            e.preventDefault();
            closeMenu();
            selectorBtn.focus();
            return;
        }

        if (key === "ArrowDown" || key === "Down") {
            e.preventDefault();
            setActive(Math.min(options.length - 1, activeIndex + 1));
            options[activeIndex]?.focus();
        } else if (key === "ArrowUp" || key === "Up") {
            e.preventDefault();
            setActive(Math.max(0, activeIndex - 1));
            options[activeIndex]?.focus();
        } else if (key === "Enter" || key === " ") {
            // Space or Enter selects when focus is on an option
            if (
                document.activeElement &&
                document.activeElement.classList.contains("payment-option")
            ) {
                e.preventDefault();
                selectOption(document.activeElement);
            }
        }
    }

    function setActive(index) {
        if (activeIndex >= 0 && options[activeIndex]) {
            options[activeIndex].removeAttribute("aria-selected");
        }
        activeIndex = index;
        if (activeIndex >= 0 && options[activeIndex]) {
            options[activeIndex].setAttribute("aria-selected", "true");
        }
    }

    function selectOption(el) {
        const label = el.getAttribute("data-label") || el.textContent.trim();
        const method = el.getAttribute("data-method");

        // Update the visible text on the trigger button
        if (numberSpan && label) {
            numberSpan.textContent = label;
        }

        // Handle special methods
        switch (method) {
            case "new-card":
                // TODO: open your "add card" flow/modal here
                console.log('Open "New Payment Card" flow');
                break;
            case "apple-pay":
                // TODO: trigger your Apple Pay flow
                console.log("Selected Apple Pay");
                break;
            case "google-pay":
                // TODO: trigger your Google Pay flow
                console.log("Selected Google Pay");
                break;
            default:
                // 'visa' or other saved methods—no-op or fetch details
                console.log("Selected saved method:", label);
        }

        closeMenu();
        selectorBtn.focus();
    }

    if (selectorBtn && menu) {
        // Toggle on click
        selectorBtn.addEventListener("click", (e) => {
            e.preventDefault();
            toggleMenu();
        });

        // Make options clickable
        options.forEach((opt, idx) => {
            opt.addEventListener("click", () => selectOption(opt));
            opt.addEventListener("mousemove", () => setActive(idx)); // hover updates active
        });

        // Improve ARIA on first load
        selectorBtn.setAttribute("aria-expanded", "false");
        selectorBtn.setAttribute("aria-haspopup", "listbox");
        menu.setAttribute("role", "listbox");
        options.forEach((o) => o.setAttribute("role", "option"));
    }

    function selectOption(el) {
        const label = el.getAttribute("data-label") || el.textContent.trim();
        const method = el.getAttribute("data-method");

        // Update visible label on the trigger button
        if (numberSpan && label) {
            numberSpan.textContent = label;
        }

        // Hide all conditional sections
        document.querySelector(".new-card-form")?.setAttribute("hidden", "");
        document.querySelector(".apple-pay-button")?.setAttribute("hidden", "");
        document.querySelector(".google-pay-button")?.setAttribute("hidden", "");
        document.querySelector(".confirm-button")?.removeAttribute("hidden");

        // Show relevant UI based on selection
        switch (method) {
            case "new-card":
                document.querySelector(".new-card-form")?.removeAttribute("hidden");
                break;
            case "apple-pay":
                document.querySelector(".apple-pay-button")?.removeAttribute("hidden");
                document.querySelector(".confirm-button")?.setAttribute("hidden", "");
                break;
            case "google-pay":
                document.querySelector(".google-pay-button")?.removeAttribute("hidden");
                document.querySelector(".confirm-button")?.setAttribute("hidden", "");
                break;
            case "visa":
            default:
                // Default saved card → confirm button remains
                break;
        }

        closeMenu();
        selectorBtn.focus();
    }
    const openBtn = document.querySelector(".open-faq-modal-group");
    const overlay = document.querySelector("[data-faq-overlay-group]");
    const modal = overlay?.querySelector(".modal");
    const closeBtn = overlay?.querySelector("[data-faq-close]");
    const triggers = Array.from(overlay?.querySelectorAll(".faq-trigger") || []);

    if (!openBtn || !overlay || !modal || !closeBtn) return;

    // --- Modal open/close with focus trap
    let lastFocused = null;

    function openModalSub() {
        lastFocused = document.activeElement;
        overlay.hidden = false;
        modal.setAttribute("data-anim", "in");
        // focus first interactive element
        (closeBtn || modal).focus();

        document.addEventListener("keydown", onKeydown);
        document.addEventListener("focus", trapFocus, true);
        overlay.addEventListener("click", onOverlayClick);
    }

    function closeModalSub() {
        modal.setAttribute("data-anim", "out");
        // wait for animation end then hide
        const done = () => {
            overlay.hidden = true;
            modal.removeAttribute("data-anim");
            document.removeEventListener("keydown", onKeydown);
            document.removeEventListener("focus", trapFocus, true);
            overlay.removeEventListener("click", onOverlayClick);
            if (lastFocused) lastFocused.focus();
            modal.removeEventListener("animationend", done);
        };
        modal.addEventListener("animationend", done);
    }

    function onOverlayClick(e) {
        if (e.target === overlay) closeModalSub();
    }

    function onKeydown(e) {
        if (e.key === "Escape") {
            e.preventDefault();
            closeModal();
        }
        if (e.key === "Tab") {
            // simple focus trap: keep focus inside modal
            const focusables = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            const list = Array.from(focusables).filter(
                (el) => !el.hasAttribute("disabled")
            );
            if (!list.length) return;

            const first = list[0];
            const last = list[list.length - 1];

            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }

    function trapFocus(e) {
        if (!overlay.hidden && !modal.contains(e.target)) {
            e.stopPropagation();
            (closeBtn || modal).focus();
        }
    }

    openBtn.addEventListener("click", openModalSub);
    closeBtn.addEventListener("click", closeModal);

    // --- FAQ accordion behavior with animation
    triggers.forEach((btn) => {
        btn.addEventListener("click", () => togglePanel(btn));
        btn.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                togglePanel(btn);
            }
        });
    });

    function togglePanel(btn) {
        const panelId = btn.getAttribute("aria-controls");
        const panel = document.getElementById(panelId);
        const expanded = btn.getAttribute("aria-expanded") === "true";

        if (expanded) {
            // Close clicked
            btn.setAttribute("aria-expanded", "false");
            panel.classList.remove("open");

            // Wait until transition ends, then hide
            panel.addEventListener(
                "transitionend",
                () => {
                    if (!panel.classList.contains("open")) {
                        panel.hidden = true;
                    }
                }, {
                    once: true
                }
            );
        } else {
            // Close ALL others first
            triggers.forEach((otherBtn) => {
                const otherId = otherBtn.getAttribute("aria-controls");
                const otherPanel = document.getElementById(otherId);

                if (otherBtn !== btn) {
                    otherBtn.setAttribute("aria-expanded", "false");
                    otherPanel.classList.remove("open");
                    otherPanel.addEventListener(
                        "transitionend",
                        () => {
                            if (!otherPanel.classList.contains("open")) {
                                otherPanel.hidden = true;
                            }
                        }, {
                            once: true
                        }
                    );

                    const chev = otherBtn.querySelector(".chev");
                    if (chev) chev.style.transform = "rotate(0deg)";
                }
            });

            // Open clicked
            panel.hidden = false; // make sure it's visible before animating
            requestAnimationFrame(() => panel.classList.add("open"));
            btn.setAttribute("aria-expanded", "true");
        }

        // Chevron update
        const chev = btn.querySelector(".chev");
        if (chev)
            chev.style.transform = expanded ? "rotate(0deg)" : "rotate(180deg)";
    }

    const checkoutBtn = document.querySelector(".checkout-button");
    const confirmModal = document.querySelector(".confirm-section");
    const planSelectionModal = document.querySelector(".plan-selection-panel");
    checkoutBtn.addEventListener("click", () => {
        confirmModal.style.display = "flex";
        planSelectionModal.style.display = "none";
    });

    const cyp = document.querySelector(".c_y_p");
    cyp.addEventListener("click", () => {
        const popup = document.querySelector(".modal-wrapper");
        popup.classList.add("active");
    });
    const closeModalButton = document.querySelector(".modal-close-button");
    closeModalButton.addEventListener("click", () => {
        const popup = document.querySelector(".modal-wrapper");
        popup.classList.remove("active");
        document.querySelector(".backdrop").classList.remove("active");
    });
})();
</script>