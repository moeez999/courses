<!-- login_activity_right.php -->
<style>
    /* ===== LOGIN ACTIVITY (Right Panel section) ===== */
    .la_right_panel {
        /* lives INSIDE .my_profile_about_right */
        width: 100%;
        max-width: 100%;
        margin-top: 14px;
        /* space below the first card */
    }

    .la_card {
        background: #fff;
        border: 1px solid var(--my_profile_about_border, #E4E7EE);
        border-radius: 16px;
        padding: 14px;
        position: sticky;
        /* same behavior as your right card */
        top: 80px;
        /* adjust to your header height */
        box-shadow: 0 6px 18px rgba(0, 0, 0, .04);
    }

    .la_title {
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 12px;
        color: var(--my_profile_about_text, #121117);
    }

    .la_item {
        border: 1px solid var(--my_profile_about_border, #E4E7EE);
        border-radius: 12px;
        padding: 12px;
        background: #fff;
    }

    .la_item+.la_item {
        margin-top: 10px;
    }

    .la_item_label {
        font-weight: 700;
        font-size: .95rem;
        color: var(--my_profile_about_text, #121117);
        margin-bottom: 6px;
    }

    .la_item_value {
        color: var(--my_profile_about_muted, #6B7280);
        font-size: .92rem;
        line-height: 1.25rem;
    }

    .la_item_value small {
        display: block;
        margin-top: 2px;
        opacity: .9;
    }

    /* Mobile: stack under the form without sticky */
    @media (max-width: 1024px) {
        .la_card {
            position: static;
            top: auto;
        }
    }
</style>

<!-- IMPORTANT: place this INSIDE your existing right column -->
<!-- Example:
<aside class="my_profile_about_right">
  ...your first .rpanel_card...
  [PASTE the block below here]
</aside>
-->
<div class="la_right_panel" aria-label="Login Activity Sidebar">
    <div class="la_card">
        <div class="la_title">Login Activity</div>

        <div class="la_item">
            <div class="la_item_label">First access to site</div>
            <div class="la_item_value">
                Wednesday, 23 April 2025, 12:16 PM
                <small>(70 days 21 hours)</small>
            </div>
        </div>

        <div class="la_item">
            <div class="la_item_label">Last access to site</div>
            <div class="la_item_value">
                Wednesday, 23 April 2025, 12:16 PM
                <small>(70 days 21 hours)</small>
            </div>
        </div>

        <div class="la_item">
            <div class="la_item_label">Last IP address</div>
            <div class="la_item_value">38.25.165.161</div>
        </div>
    </div>
</div>