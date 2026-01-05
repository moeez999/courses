<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile – Photo (Middle Content)</title>

    <!-- Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_profile_photo_tab_text: #121117;
            --my_profile_photo_tab_muted: #6B7280;
            --my_profile_photo_tab_border: #E4E7EE;
            --my_profile_photo_tab_accent: #ff3b1f;
            --my_profile_photo_tab_radius: 10px;
            --my_profile_photo_tab_control_h: 52px;
        }

        .my_profile_photo_tab_root {
            font-family: Inter, ui-sans-serif, system-ui, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            color: var(--my_profile_photo_tab_text);
        }

        /* Buttons */
        .my_profile_photo_tab_btn {
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: transform .06s ease, box-shadow .15s ease;
        }

        .my_profile_photo_tab_btn:active {
            transform: translateY(1px)
        }

        .my_profile_photo_tab_btn_primary {
            background: var(--my_profile_photo_tab_accent);
            color: #fff;
            padding: 0 22px;
            border: 2px solid #000;
            
        }

        .my_profile_photo_tab_btn_outline {
            background: #fff;
            border: 1.6px solid #111827;
            color: #111827;
            padding: 0 18px;
        }

        /* Avatar */
        .my_profile_photo_tab_avatar {
            width: 104px;
            height: 104px;
            border-radius: 12px;
            object-fit: cover;
            display: block;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .04);
        }

        /* Helpers */
        .my_profile_photo_tab_helper {
            color: var(--my_profile_photo_tab_muted);
            font-size: .95rem
        }

        .my_profile_photo_tab_chip {
            display: inline-block;
            background: #E8F0FF;
            color: #1F4CF0;
            border-radius: 9999px;
            font-weight: 600;
            font-size: .8rem;
            padding: .25rem .6rem;
        }

        .my_profile_photo_tab_flag {
            width: 20px;
            height: 14px;
            border-radius: 2px;
            overflow: hidden;
            display: inline-block;
            vertical-align: middle;
            box-shadow: 0 0 0 1px #D1D5DB inset;
        }

        .my_profile_photo_tab_flag>span {
            display: block;
            width: 100%
        }

        .my_profile_photo_tab_flag .b1 {
            height: 33%;
            background: #00247D
        }

        .my_profile_photo_tab_flag .b2 {
            height: 33%;
            background: #FFCC00
        }

        .my_profile_photo_tab_flag .b3 {
            height: 33%;
            background: #CF142B
        }

        /* Example portraits */
        .my_profile_photo_tab_examples img {
            width: 108px;
            height: 108px;
            border-radius: 12px;
            object-fit: cover;
            border: 1.5px solid var(--my_profile_photo_tab_border);
        }

        /* Checklist */
        .my_profile_photo_tab_check li {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: .42rem 0;
            border-radius: 8px;
        }

        .my_profile_photo_tab_check svg {
            flex: 0 0 auto;
            margin-top: .25rem
        }
    </style>
</head>

<body class="my_profile_photo_tab_root bg-white">

    <!-- Center column wrapper (drop into your middle column) -->
    <div class="max-w-[760px] w-full mx-auto px-4 md:px-2 lg:px-4 py-6">

        <!-- Title + helper -->
        <h1 class="text-3xl md:text-4xl font-semibold tracking-tight">Profile photo</h1>
        <p class="my_profile_photo_tab_helper mt-3">
            Choose a photo that will help learners get to know you.
        </p>

        <!-- Profile row -->
        <div class="mt-6 flex items-start gap-5">
            <!-- avatar (click to replace) -->
            <label class="cursor-pointer relative">
                <img id="my_profile_photo_tab_preview"
                    src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=400&auto=format&fit=crop"
                    alt="Profile photo" class="my_profile_photo_tab_avatar">
                <input id="my_profile_photo_tab_file" type="file" accept="image/*" class="hidden">
            </label>

            <div class="min-w-0">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="text-[1.25rem] md:text-[1.35rem] font-semibold">Daniela C.</div>
                    <span class="my_profile_photo_tab_flag" title="Venezuela">
                        <span class="b1"></span><span class="b2"></span><span class="b3"></span>
                    </span>
                </div>

                <!-- bullets -->
                <div class="mt-3 space-y-2 text-[.98rem]">
                    <div class="flex items-start gap-2">
                        <!-- icon -->
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M4 7h16M4 12h10M4 17h7" stroke="#111827" stroke-width="1.6"
                                stroke-linecap="round" />
                        </svg>
                        <span class="text-[color:var(--my_profile_photo_tab_text)]">Teaches English lessons</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M12 21c4.97 0 9-4.03 9-9S16.97 3 12 3 3 7.03 3 12s4.03 9 9 9z" stroke="#111827"
                                stroke-width="1.6" />
                            <path d="M3.6 12h16.8M12 3.6v16.8" stroke="#111827" stroke-width="1.2" opacity=".55" />
                        </svg>
                        <span>Speaks Portuguese (B2), English (B2), English (Native)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Save (outlined, full width like snapshot) -->
        <div class="mt-5">
            <button id="my_profile_photo_tab_save_top"
                class="my_profile_photo_tab_btn my_profile_photo_tab_btn_outline w-full">
                Save
            </button>
        </div>

        <!-- What your photo needs -->
        <h2 class="mt-8 text-2xl md:text-[1.75rem] font-semibold">What your photo needs</h2>

        <!-- Example portraits -->
        <div class="my_profile_photo_tab_examples mt-4 flex flex-wrap gap-4">
            <img src="https://images.unsplash.com/photo-1512314889357-e157c22f938d?q=80&w=320&auto=format&fit=crop"
                alt="">
            <img src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=320&auto=format&fit=crop" alt="">
            <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=320&auto=format&fit=crop"
                alt="">
            <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=320&auto=format&fit=crop&ixid=Mnwx"
                alt="">
        </div>

        <!-- Checklist -->
        <ul class="my_profile_photo_tab_check mt-6 text-[1.05rem] leading-7">
            <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="#111827" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>You should be facing forward</span>
            </li>
            <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="#111827" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>Frame your head and shoulders</span>
            </li>
            <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="#111827" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>You should be centered and upright</span>
            </li>
            <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="#111827" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>Your face and eyes should be visible (except for religious reasons)</span>
            </li>
            <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="#111827" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>You should be the only person in the photo</span>
            </li>
            <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="#111827" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>Use a color photo with high resolution and no filters</span>
            </li>
            <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="#111827" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>Avoid logos or contact information</span>
            </li>
        </ul>

        <!-- Bottom Save (solid) -->
        <div class="mt-8 flex justify-center">
            <button id="my_profile_photo_tab_save_bottom"
                class="my_profile_photo_tab_btn my_profile_photo_tab_btn_primary min-w-[150px]">
                Save
            </button>
        </div>
    </div>

    <script>
        // ======= tiny interactions (preview + save state) =======
        const my_profile_photo_tab_state = {
            changed: false
        };

        function my_profile_photo_tab_updateButtons() {
            const $top = $('#my_profile_photo_tab_save_top');
            const $bottom = $('#my_profile_photo_tab_save_bottom');
            if (my_profile_photo_tab_state.changed) {
                $top.removeClass('opacity-60 cursor-not-allowed');
                $bottom.removeClass('opacity-60 cursor-not-allowed');
            } else {
                $top.addClass('opacity-60 cursor-not-allowed');
                $bottom.addClass('opacity-60 cursor-not-allowed');
            }
        }

        $(function() {
            // clicking avatar opens file chooser
            $('#my_profile_photo_tab_preview').on('click', function() {
                $('#my_profile_photo_tab_file').trigger('click');
            });

            // preview chosen image
            $('#my_profile_photo_tab_file').on('change', function(e) {
                const f = e.target.files && e.target.files[0];
                if (!f) return;
                const reader = new FileReader();
                reader.onload = function(evt) {
                    $('#my_profile_photo_tab_preview').attr('src', evt.target.result);
                    my_profile_photo_tab_state.changed = true;
                    my_profile_photo_tab_updateButtons();
                };
                reader.readAsDataURL(f);
            });

            // save buttons (demo only)
            $('#my_profile_photo_tab_save_top, #my_profile_photo_tab_save_bottom').on('click', function() {
                if (!my_profile_photo_tab_state.changed) return;
                // simulate save
                my_profile_photo_tab_state.changed = false;
                my_profile_photo_tab_updateButtons();
                // tiny feedback
                $(this).blur();
            });

            // init disabled (until something changes)
            my_profile_photo_tab_updateButtons();
        });
    </script>
</body>

</html>