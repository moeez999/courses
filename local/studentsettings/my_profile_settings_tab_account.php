<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account – Right Content</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_profile_setting_tab_account_border: #E4E7EE;
            --my_profile_setting_tab_account_text: #121117;
            --my_profile_setting_tab_account_muted: #6B7280;
            --my_profile_setting_tab_account_red: #FF3B11;
            --my_profile_setting_tab_account_red_hover: #e2340f;
            --my_profile_setting_tab_account_radius: 12px;
        }

        .my_profile_setting_tab_account_input,
        .my_profile_setting_tab_account_select {
            width: 100%;
            border: 1px solid var(--my_profile_setting_tab_account_border);
            border-radius: 10px;
            background: #fff;
            padding: .625rem .875rem;
            line-height: 1.35;
        }

        .my_profile_setting_tab_account_input:focus,
        .my_profile_setting_tab_account_select:focus {
            outline: none;
            border-color: #C7CDD8;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .10);
        }

        /* ===== Phone number: single field with embedded left addon ===== */
        .my_profile_setting_tab_account_phone_wrap {
            position: relative;
        }

        .my_profile_setting_tab_account_phone_input {
            padding-left: 86px;
            /* room for flag+code block */
            padding-right: 42px;
            /* room for help icon */
        }

        .my_profile_setting_tab_account_phone_addon {
            position: absolute;
            top: 70%;
            left: 10px;
            transform: translateY(-50%);
            height: 32px;
            display: flex;
            align-items: center;
            gap: 8px;
            /* padding: 0 10px;
            border: 1px solid var(--my_profile_setting_tab_account_border);
            border-radius: 8px;
            background: #fff; */
            cursor: pointer;
        }

        .my_profile_setting_tab_account_flag {
            width: 20px;
            height: 14px;
            border-radius: 3px;
        }

        .my_profile_setting_tab_account_phone_dropdown {
            position: absolute;
            top: 100%;
            left: 10px;
            margin-top: 8px;
            width: 240px;
            max-height: 220px;
            overflow: auto;
            background: #fff;
            border: 1px solid var(--my_profile_setting_tab_account_border);
            border-radius: 10px;
            box-shadow: 0 10px 18px rgba(0, 0, 0, .08);
            display: none;
            z-index: 9999;
        }

        .my_profile_setting_tab_account_phone_item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            cursor: pointer;
            transition: background .12s ease;
            font-size: .93rem;
        }

        .my_profile_setting_tab_account_phone_item:hover {
            background: #F3F4F6;
        }

        /* Help icon inside phone input (right side) */
        .my_profile_setting_tab_account_help {
            position: absolute;
            right: 12px;
            top: 70%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            border: 2px solid #000;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .82rem;
            color: #444;
            background: #fff;
            font-weight: 800;
        }

        /* Social rows: text then a pill button below with exact size */
        .my_profile_setting_tab_account_social_row {
            display: flex;
            flex-direction: column;
            gap: .55rem;
        }

        .my_profile_setting_tab_account_pill_btn {
            width: 260px;
            /* matches the snapshot’s compact pill width */
            border: 1px solid var(--my_profile_setting_tab_account_border);
            background: #fff;
            border-radius: 12px;
            padding: .625rem 1rem;
            font-weight: 600;
            text-align: center;
        }

        .my_profile_setting_tab_account_pill_btn:hover {
            background: #F6F7FB;
        }

        /* Save changes: red with black border, big and centered */
        .my_profile_setting_tab_account_savebtn {
            background: var(--my_profile_setting_tab_account_red);
            border: 1px solid #000;
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 14px 20px;
            width: 100%;
            max-width: 560px;
        }

        .my_profile_setting_tab_account_savebtn:hover {
            background: var(--my_profile_setting_tab_account_red_hover);
        }
    </style>
</head>

<body class="bg-white antialiased">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-semibold mb-6">Account Setting</h1>

        <!-- Profile image -->
        <div class="mb-6">
            <p class="font-semibold mb-3">Profile image</p>
            <div class="flex items-start gap-5 flex-wrap">
                <div class="w-[140px] h-[140px] border border-gray-200 rounded-[10px] flex items-center justify-center bg-white">
                    <img id="my_profile_setting_tab_account_avatar_preview"
                        src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png"
                        class="w-24 h-24 object-contain opacity-80" alt="avatar">
                </div>
                <div class="flex flex-col gap-3">
                    <label class="inline-flex items-center gap-2 cursor-pointer my_profile_setting_tab_account_pill_btn w-auto">
                        <input id="my_profile_setting_tab_account_file" type="file" accept="image/png,image/jpeg" class="hidden">
                        <span>Upload photo</span>
                    </label>
                    <span class="text-gray-500 text-sm">Maximum size — 2MB<br>JPG or PNG format</span>
                </div>
            </div>
        </div>

        <form id="my_profile_setting_tab_account_form" class="space-y-5" style="width:70%;">
            <div>
                <label class="block font-semibold mb-2">First name <span class="text-gray-400">•</span> <span class="text-gray-500">Required</span></label>
                <input type="text" class="my_profile_setting_tab_account_input" value="Addyson">
            </div>

            <div>
                <label class="block font-semibold mb-2">Last name</label>
                <input type="text" class="my_profile_setting_tab_account_input" value="Arnold">
            </div>

            <!-- Phone number (single input with embedded left dropdown) -->
            <div class="my_profile_setting_tab_account_phone_wrap">
                <label class="block font-semibold mb-2">Phone number</label>

                <!-- embedded addon -->
                <div id="my_profile_setting_tab_account_phone_addon"
                    class="my_profile_setting_tab_account_phone_addon" title="Change country">
                    <img id="my_profile_setting_tab_account_phone_flag" class="my_profile_setting_tab_account_flag" src="https://flagcdn.com/w20/us.png" alt="US">
                    <span id="my_profile_setting_tab_account_phone_code">+1</span>
                    <span class="text-gray-500 -ml-1">▾</span>
                </div>

                <input id="my_profile_setting_tab_account_phone_input"
                    type="text"
                    class="my_profile_setting_tab_account_input my_profile_setting_tab_account_phone_input"
                    placeholder="Enter phone number">

                <div class="my_profile_setting_tab_account_help" title="Used for notifications and account security">?</div>

                <!-- dropdown -->
                <div id="my_profile_setting_tab_account_phone_dropdown"
                    class="my_profile_setting_tab_account_phone_dropdown"></div>
            </div>

            <!-- Timezone -->
            <div>
                <label class="block font-semibold mb-2">Timezone</label>
                <div class="relative">
                    <select class="my_profile_setting_tab_account_select pr-10">
                        <option selected>Europe/Madrid GMT +1:0</option>
                        <option>Europe/London GMT +0:0</option>
                        <option>Asia/Karachi GMT +5:0</option>
                        <option>America/New_York GMT -5:0</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">▾</div>
                </div>
            </div>

            <!-- Social networks -->
            <div class="space-y-6 pt-1">
                <label class="block font-semibold">Social networks</label>

                <div class="my_profile_setting_tab_account_social_row">
                    <div class="flex items-center gap-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c2/F_icon.svg" class="w-5 h-5" alt="Facebook">
                        <span class="text-gray-800 text-sm">Not connected to Facebook account</span>
                    </div>
                    <button type="button" class="my_profile_setting_tab_account_pill_btn">Connect</button>
                </div>

                <div class="my_profile_setting_tab_account_social_row">
                    <div class="flex items-center gap-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" class="h-4" alt="Google">
                        <span class="text-gray-800 text-sm">Connected as Latingles</span>
                    </div>
                    <button type="button" class="my_profile_setting_tab_account_pill_btn">Disconnect</button>
                </div>
            </div>

            <!-- Save -->
            <div class="pt-4 flex">
                <button type="submit" class="my_profile_setting_tab_account_savebtn mx-auto">Save changes</button>
            </div>
        </form>
    </div>

    <script>
        // ===== INIT =====
        function my_profile_setting_tab_account_init() {
            // Country list for phone
            const countries = [{
                    n: "United States",
                    c: "+1",
                    f: "https://flagcdn.com/w20/us.png"
                },
                {
                    n: "United Kingdom",
                    c: "+44",
                    f: "https://flagcdn.com/w20/gb.png"
                },
                {
                    n: "Pakistan",
                    c: "+92",
                    f: "https://flagcdn.com/w20/pk.png"
                },
                {
                    n: "Spain",
                    c: "+34",
                    f: "https://flagcdn.com/w20/es.png"
                },
                {
                    n: "Canada",
                    c: "+1",
                    f: "https://flagcdn.com/w20/ca.png"
                },
                {
                    n: "Australia",
                    c: "+61",
                    f: "https://flagcdn.com/w20/au.png"
                },
                {
                    n: "Germany",
                    c: "+49",
                    f: "https://flagcdn.com/w20/de.png"
                },
                {
                    n: "France",
                    c: "+33",
                    f: "https://flagcdn.com/w20/fr.png"
                },
                {
                    n: "India",
                    c: "+91",
                    f: "https://flagcdn.com/w20/in.png"
                }
            ];

            const $dd = $('#my_profile_setting_tab_account_phone_dropdown');
            $dd.empty();
            countries.forEach(({
                n,
                c,
                f
            }) => {
                $dd.append(`
          <div class="my_profile_setting_tab_account_phone_item" data-code="${c}" data-flag="${f}">
            <img class="my_profile_setting_tab_account_flag" src="${f}" alt="${n}">
            <span>${n}</span>
            <span class="ml-auto text-gray-600">${c}</span>
          </div>
        `);
            });

            // Open/close dropdown by clicking left embedded addon
            $('#my_profile_setting_tab_account_phone_addon').on('click', function(e) {
                e.stopPropagation();
                $dd.toggle();
            });
            $(document).on('click', function() {
                $dd.hide();
            });

            // Select country
            $dd.on('click', '.my_profile_setting_tab_account_phone_item', function() {
                const code = $(this).data('code');
                const flag = $(this).data('flag');
                $('#my_profile_setting_tab_account_phone_code').text(code);
                $('#my_profile_setting_tab_account_phone_flag').attr('src', flag);
                $dd.hide();
            });

            // Image preview
            $('#my_profile_setting_tab_account_file').on('change', function() {
                const file = this.files?.[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('Max size 2MB');
                    this.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => $('#my_profile_setting_tab_account_avatar_preview').attr('src', e.target.result);
                reader.readAsDataURL(file);
            });

            // Demo submit
            $('#my_profile_setting_tab_account_form').on('submit', function(e) {
                e.preventDefault();
                alert('Changes saved (demo).');
            });
        }

        $(document).ready(my_profile_setting_tab_account_init);
    </script>
</body>

</html>