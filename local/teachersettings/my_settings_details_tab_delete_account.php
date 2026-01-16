<!-- Delete Account – Right Section Only -->
<section id="my_settings_details_tab_password_delete_account_section"
    class="w-full max-w-2xl">

    <!-- Heading -->
    <h1 class="text-3xl sm:text-[32px] font-semibold tracking-tight mb-4">
        Delete account
    </h1>

    <!-- Description -->
    <p class="text-[#64748B] leading-relaxed max-w-xl mb-8">
        Deleting your account is permanent and all your account information will be deleted along with it. If you're sure you want to proceed, enter your email address below.
    </p>

    <!-- Email field -->
    <div class="max-w-md mb-8">
        <label for="my_settings_details_tab_password_delete_account_email"
            class="block text-sm font-medium mb-2 text-[#0F172A]">
            Email
        </label>
        <input id="my_settings_details_tab_password_delete_account_email"
            type="email"
            placeholder="Enter your email"
            class="w-full border border-[#E5E7EB] rounded-md px-3.5 py-2.5 focus:border-black focus:ring-0 outline-none" />
    </div>

    <!-- Delete button -->
    <button style="border: 2px solid #c0c0c0 !important;" id="my_settings_details_tab_password_delete_account_btn"
        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-base font-semibold text-[#0F172A]
                 border border-black rounded-md bg-[#F3F4F6] hover:bg-[#E5E7EB] transition">
        <!-- Trash Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="1.8"
            class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 6h18M9 6v12m6-12v12M10 6h4l1 0m-8 0l1 0M5 6l1 14h12l1-14" />
        </svg>
        Delete account
    </button>
</section>