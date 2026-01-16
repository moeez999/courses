<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Profile – Share Profile Modal (Exact)</title>

    <!-- Tailwind CSS + jQuery -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --my_profile_share_profile_modal-radius: 16px;
            --my_profile_share_profile_modal-gray: #E4E7EE;
            --my_profile_share_profile_modal-muted: #6B7280;
            --my_profile_share_profile_modal-outline: #121117;
            --my_profile_share_profile_modal-red: #F04438;
            /* close to figma red */
        }

        html,
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
        }

        /* EXACT-LIKE CARD WIDTH */
        .my_profile_share_profile_modal_card {
            width: 500px;
            /* narrower like your first snapshot */
            max-width: calc(100vw - 32px);
            /* keep mobile friendly */
            border-radius: var(--my_profile_share_profile_modal-radius);
        }

        .my_profile_share_profile_modal_input {
            border: 1px solid var(--my_profile_share_profile_modal-gray);
            border-radius: 5px;
            height: 48px;
        }

        .my_profile_share_profile_modal_btn {
            border: 1px solid var(--my_profile_share_profile_modal-outline);
            border-radius: 5px;
            height: 48px;
        }

        .my_profile_share_profile_modal_iconbtn {
            border: 1px solid var(--my_profile_share_profile_modal-gray);
            border-radius: 5px;
            height: 48px;
        }

        .my_profile_share_profile_modal_badge {
            border: 1px solid var(--my_profile_share_profile_modal-gray);
            border-radius: 999px;
            padding: 2px 8px;
            font-size: 12px;
            line-height: 18px;
        }

        .my_profile_share_profile_modal_close:hover {
            background-color: #F3F4F6;
        }

        .my_profile_share_profile_modal_anim {
            animation: my_profile_share_profile_modal_pop 160ms ease-out;
        }

        @keyframes my_profile_share_profile_modal_pop {
            0% {
                transform: scale(.96);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-white">

    <!-- A sample trigger (your real “Share profile” can keep this id) -->
    <!-- <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <button id="my_profile_share_profile_modal_openBtn"
            class="my_profile_share_profile_modal_btn px-4 bg-white hover:bg-gray-50 text-sm font-medium">
            <span class="inline-flex items-center gap-2 text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-width="2" d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8M16 6l-4-4-4 4M12 2v14" />
                </svg>
                Share profile
            </span>
        </button>
    </div> -->

    <!-- Overlay -->
    <div id="my_profile_share_profile_modal_overlay"
        class="fixed inset-0 bg-black/40 z-50 hidden"></div>

    <!-- Modal -->
    <div id="my_profile_share_profile_modal_root"
        class="fixed inset-0 z-50 hidden items-center justify-center p-5">

        <div class="my_profile_share_profile_modal_card my_profile_share_profile_modal_anim bg-white shadow-xl" style="margin-top: 30px;">
            <!-- Header -->
            <div class="flex items-start justify-between p-3">
                <h2 class="text-[22px] leading-7 font-semibold text-black">Share Your Profile</h2>
                <button id="my_profile_share_profile_modal_closeBtn"
                    class="rounded-full p-2 text-black hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="2" d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 pb-6 text-black">
                <!-- Profile row -->
                <div class="flex items-center gap-3">
                    <img src="https://i.pravatar.cc/96?img=5" alt="avatar"
                        class="h-10 w-10 rounded-lg object-cover" />
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-black">Daniela</span>
                            <span class="inline-flex items-center gap-1 text-sm text-black">
                                <!-- star icon BLACK -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 17.27l6.18 3.73-1.64-7.03L21 9.24l-7.19-.61L12 2 10.19 8.63 3 9.24l4.46 4.73L5.82 21z" />
                                </svg>
                                <span>5</span>
                            </span>
                            <span class="text-sm text-gray-500">(28 reviews)</span>
                        </div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center gap-1 text-xs text-black">
                                <!-- verified (black) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l2.39 2.39L17.17 4l.44 2.78L20 9l-2.39 2.39.44 2.78-2.78-.44L12 20l-2.39-2.39-2.78.44.44-2.78L4 9l2.39-2.39L6.83 4l2.78.39L12 2z" />
                                </svg>
                                Verified
                            </span>
                            <span class="my_profile_share_profile_modal_badge inline-flex items-center gap-1 text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4z" />
                                </svg>
                                Professional
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Link row -->
                <div class="mt-5 flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input id="my_profile_share_profile_modal_link"
                            type="text"
                            class="my_profile_share_profile_modal_input w-full px-4 pr-10 text-sm text-black bg-gray-100"
                            value="https://latingles.com/Robertosr"
                            readonly>
                        <button id="my_profile_share_profile_modal_copyIcon"
                            class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 rounded hover:bg-gray-200 text-black"
                            title="Copy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2" stroke-width="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke-width="2"></path>
                            </svg>
                        </button>
                    </div>
                    <button id="my_profile_share_profile_modal_copyBtn"
                        class="my_profile_share_profile_modal_btn px-5 font-semibold text-white"
                        style="background-color: var(--my_profile_share_profile_modal-red); border-color: transparent;">
                        Copy link
                    </button>
                </div>

                <!-- Share buttons -->
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <button class="my_profile_share_profile_modal_iconbtn flex items-center justify-center gap-2 px-4 hover:bg-gray-50 text-black"
                        id="my_profile_share_profile_modal_emailBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="2"></rect>
                            <path d="M3 7l9 6 9-6" stroke-width="2"></path>
                        </svg>
                        Email
                    </button>

                    <button class="my_profile_share_profile_modal_iconbtn flex items-center justify-center gap-2 px-4 hover:bg-gray-50 text-black"
                        id="my_profile_share_profile_modal_whatsappBtn">
                        <!-- logo black -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M.1 24l1.7-6.2A12 12 0 1 1 12 24a12.3 12.3 0 0 1-5.9-1.5L.1 24z" />
                            <path fill="#fff" d="M7.4 6.7c-.2.3-.8 1-.8 2.4s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4s-.3-.2-.6-.4c-.3-.1-1.8-.9-2.1-1-.3-.1-.5-.1-.7.2-.2.3-.8 1-1 1.2-.2.2-.3.2-.6.1-.3-.2-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2.1-.4 0-.5s-.7-1.6-.9-2.2c-.2-.6-.5-.5-.7-.5l-.6-.01c-.2 0-.5.07-.8.37z" />
                        </svg>
                        WhatsApp
                    </button>

                    <button class="my_profile_share_profile_modal_iconbtn flex items-center justify-center gap-2 px-4 hover:bg-gray-50 text-black"
                        id="my_profile_share_profile_modal_linkedinBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4.98 3.5A2.5 2.5 0 1 1 0 3.5a2.5 2.5 0 0 1 4.98 0zM0 8h5v16H0zM8 8h5v2.3h.1C14 8.9 15.6 8 17.9 8 22.4 8 24 10.3 24 14.4V24h-5v-8.7c0-2.1 0-4.8-2.9-4.8-2.9 0-3.4 2.3-3.4 4.6V24H8z" />
                        </svg>
                        LinkedIn
                    </button>

                    <button class="my_profile_share_profile_modal_iconbtn flex items-center justify-center gap-2 px-4 hover:bg-gray-50 text-black"
                        id="my_profile_share_profile_modal_xBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2H21l-6.56 7.49L22 22h-6.828l-5.36-6.96L3.51 22H1l7.09-8.09L2 2h6.828l4.86 6.345L18.244 2zm-2.403 18h1.335L7.22 4H5.827l10.014 16z" />
                        </svg>
                        X (Twitter)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ================== Modal Logic (prefixed) ==================
        (function($) {
            const my_profile_share_profile_modal_$overlay = $('#my_profile_share_profile_modal_overlay');
            const my_profile_share_profile_modal_$root = $('#my_profile_share_profile_modal_root');
            const my_profile_share_profile_modal_$openBtn = $('#my_profile_share_profile_modal_openBtn');
            const my_profile_share_profile_modal_$closeBtn = $('#my_profile_share_profile_modal_closeBtn');
            const my_profile_share_profile_modal_$copyBtn = $('#my_profile_share_profile_modal_copyBtn');
            const my_profile_share_profile_modal_$copyIcon = $('#my_profile_share_profile_modal_copyIcon');
            const my_profile_share_profile_modal_$link = $('#my_profile_share_profile_modal_link');

            function my_profile_share_profile_modal_open() {
                my_profile_share_profile_modal_$overlay.removeClass('hidden');
                my_profile_share_profile_modal_$root.removeClass('hidden').addClass('flex');
                my_profile_share_profile_modal_$copyBtn.trigger('focus');
            }

            function my_profile_share_profile_modal_close() {
                my_profile_share_profile_modal_$overlay.addClass('hidden');
                my_profile_share_profile_modal_$root.addClass('hidden').removeClass('flex');
            }

            function my_profile_share_profile_modal_copy() {
                navigator.clipboard.writeText(my_profile_share_profile_modal_$link.val() || '').then(() => {
                    my_profile_share_profile_modal_$copyBtn.text('Copied!');
                    setTimeout(() => my_profile_share_profile_modal_$copyBtn.text('Copy link'), 1100);
                }).catch(() => {
                    const t = $('<textarea>').val(my_profile_share_profile_modal_$link.val()).appendTo('body').select();
                    document.execCommand('copy');
                    t.remove();
                    my_profile_share_profile_modal_$copyBtn.text('Copied!');
                    setTimeout(() => my_profile_share_profile_modal_$copyBtn.text('Copy link'), 1100);
                });
            }

            // open/close
            my_profile_share_profile_modal_$openBtn.on('click', my_profile_share_profile_modal_open);
            my_profile_share_profile_modal_$closeBtn.on('click', my_profile_share_profile_modal_close);
            my_profile_share_profile_modal_$overlay.on('click', my_profile_share_profile_modal_close);
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape') my_profile_share_profile_modal_close();
            });

            // copy
            my_profile_share_profile_modal_$copyBtn.on('click', my_profile_share_profile_modal_copy);
            my_profile_share_profile_modal_$copyIcon.on('click', my_profile_share_profile_modal_copy);

            // share targets
            $('#my_profile_share_profile_modal_emailBtn').on('click', function() {
                const url = my_profile_share_profile_modal_$link.val();
                window.open(`mailto:?subject=Check%20out%20this%20profile&body=${encodeURIComponent(url)}`, '_blank');
            });
            $('#my_profile_share_profile_modal_whatsappBtn').on('click', function() {
                const url = my_profile_share_profile_modal_$link.val();
                window.open(`https://wa.me/?text=${encodeURIComponent(url)}`, '_blank');
            });
            $('#my_profile_share_profile_modal_linkedinBtn').on('click', function() {
                const url = my_profile_share_profile_modal_$link.val();
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank');
            });
            $('#my_profile_share_profile_modal_xBtn').on('click', function() {
                const url = my_profile_share_profile_modal_$link.val();
                window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}`, '_blank');
            });
        })(jQuery);
    </script>
</body>

</html>