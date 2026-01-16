<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Profile – Video Tab</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_profile_video_tab_text: #121117;
            --my_profile_video_tab_muted: #6B7280;
            --my_profile_video_tab_border: #E4E7EE;
            --my_profile_video_tab_accent: #ff3b1f;
            --my_profile_video_tab_info_bg: #EAF2FF;
            --my_profile_video_tab_info_bd: #CFE0FF;
        }

        .my_profile_video_tab_container p {
            color: var(--my_profile_video_tab_text)
        }

        .my_profile_video_tab_muted {
            color: var(--my_profile_video_tab_muted)
        }

        .my_profile_video_tab_card {
            border: 1.5px solid var(--my_profile_video_tab_border);
            border-radius: 12px;
            background: #fff;
        }

        .my_profile_video_tab_callout {
            border: 1.5px solid var(--my_profile_video_tab_info_bd);
            background: var(--my_profile_video_tab_info_bg);
            border-radius: 10px;
        }

        .my_profile_video_tab_btn_outline {
            border: 1.5px solid #111827;
            border-radius: 10px;
            height: 44px;
            padding: 0 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #fff;
            transition: box-shadow .15s ease, transform .05s ease;
        }

        .my_profile_video_tab_btn_outline:focus {
            outline: 0;
            box-shadow: 0 0 0 4px rgba(17, 24, 39, .06)
        }

        .my_profile_video_tab_btn_outline:active {
            transform: translateY(1px)
        }

        .my_profile_video_tab_btn_primary {
            background: var(--my_profile_video_tab_accent);
            color: #fff;
            height: 44px;
            padding: 0 28px;
            border-radius: 10px;
            font-weight: 600;
            border: 2px solid #000;

        }

        @media (max-width:640px) {
            .my_profile_video_tab_h1 {
                font-size: 1.625rem;
                line-height: 1.25
            }
        }
    </style>
</head>

<body class="bg-white text-[15px] sm:text-[16px]">
    <main class="my_profile_video_tab_container max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        <h1 class="my_profile_video_tab_h1 text-[28px] sm:text-[32px] font-semibold mb-3">Video introduction</h1>
        <p class="my_profile_video_tab_muted mb-6">Add a horizontal video of up to 2 minutes</p>
        <p class="my_profile_video_tab_muted mb-6">
            Introduce yourself to students in the same language as your written description. If you teach a different language, include a short sample.
        </p>

        <!-- Video preview -->
        <div class="mb-4">
            <div class="relative my_profile_video_tab_card overflow-hidden">
                <div class="w-full aspect-video">
                    <iframe id="my_profile_video_tab_iframe"
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0"
                        title="Intro video"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <button type="button" id="my_profile_video_tab_btnRerecord" class="my_profile_video_tab_btn_outline">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-width="1.6" d="M4 4v6h6M20 20v-6h-6" />
                    <path stroke-width="1.6" d="M20 10A8 8 0 1 0 10 20" />
                </svg>
                <span>Re-record</span>
            </button>
        </div>

        <div class="mb-10">
            <p class="my_profile_video_tab_muted">
                Have a pre-recorded video on Youtube or Vimeo?
                <button id="my_profile_video_tab_insertLink" class="underline font-medium hover:no-underline">Insert link</button>
            </p>
        </div>

        <!-- Thumbnail section -->
        <section class="mb-10">
            <h2 class="text-[18px] sm:text-[20px] font-semibold mb-2">Add a thumbnail (optional)</h2>
            <p class="my_profile_video_tab_muted mb-6">
                Don’t worry if you don’t have a thumbnail ready, we’ll use the preview above.
            </p>

            <p class="text-[13px] my_profile_video_tab_muted mb-2">Current thumbnail</p>

            <!-- Fixed-height thumbnail CARD (matches snapshot proportions) -->
            <div class="my_profile_video_tab_card overflow-hidden mb-4 h-[220px]">
                <img id="my_profile_video_tab_thumbPreview"
                    class="w-full h-full object-cover object-center"
                    alt="Current thumbnail"
                    src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=1200&auto=format&fit=crop" />
            </div>

            <!-- Blue info callout -->
            <div class="my_profile_video_tab_callout flex items-start gap-3 p-3 sm:p-4 mb-6">
                <div class="shrink-0 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="1.5"></circle>
                        <path stroke-width="1.5" d="M12 8.25h.01M11.25 11.25h1.5v4.5h-1.5z"></path>
                    </svg>
                </div>
                <p class="text-[15px]">
                    Do not include your surname, contact info, pricing or discounts, and irrelevant pictures in your thumbnail.
                </p>
            </div>

            <!-- Upload row (button styled like your screenshot) -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="w-full sm:w-auto">
                    <button type="button"
                        id="my_profile_video_tab_btnAddThumb"
                        class="my_profile_video_tab_btn_outline w-full sm:w-[320px]">
                        Add another thumbnail
                    </button>
                    <input id="my_profile_video_tab_file" type="file" accept="image/png,image/jpeg" class="hidden" />
                </div>
                <div class="text-[13px] my_profile_video_tab_muted">
                    JPEG or PNG formats only, size of 20Mb max
                </div>
            </div>

            <p id="my_profile_video_tab_fileMsg" class="text-sm text-red-600 mt-2 hidden"></p>
        </section>

        <div class="pt-2">
            <button id="my_profile_video_tab_btnSave" class="my_profile_video_tab_btn_primary">Save</button>
        </div>
    </main>

    <script>
        (function($) {

            function my_profile_video_tab_embed(url) {
                let embed = url.trim();

                // YouTube
                const yt = /(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([\w\-]{11})/;
                const ytm = url.match(yt);
                if (ytm) {
                    embed = "https://www.youtube.com/embed/" + ytm[1] + "?rel=0";
                }

                // Vimeo
                const vm = /vimeo\.com\/(\d+)/;
                const vmm = url.match(vm);
                if (vmm) {
                    embed = "https://player.vimeo.com/video/" + vmm[1];
                }

                $("#my_profile_video_tab_iframe").attr("src", embed);
            }

            $("#my_profile_video_tab_insertLink").on("click", function(e) {
                e.preventDefault();
                const url = prompt("Paste YouTube or Vimeo link:");
                if (!url) return;
                my_profile_video_tab_embed(url);
            });

            $("#my_profile_video_tab_btnRerecord").on("click", function() {
                const current = $("#my_profile_video_tab_iframe").attr("src");
                const alt = "https://www.youtube.com/embed/tgbNymZ7vqY?rel=0";
                $("#my_profile_video_tab_iframe").attr("src",
                    current.includes("dQw4w9WgXcQ") ? alt : "https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0"
                );
            });

            $("#my_profile_video_tab_btnAddThumb").on("click", function() {
                $("#my_profile_video_tab_file").trigger("click");
            });

            $("#my_profile_video_tab_file").on("change", function() {
                const file = this.files && this.files[0];
                const $msg = $("#my_profile_video_tab_fileMsg");
                $msg.addClass("hidden").text("");

                if (!file) return;

                const validType = /image\/(png|jpeg)/.test(file.type);
                const validSize = file.size <= 20 * 1024 * 1024;

                if (!validType) {
                    $msg.text("Please select a JPEG or PNG image.").removeClass("hidden");
                    this.value = "";
                    return;
                }
                if (!validSize) {
                    $msg.text("Image is larger than 20MB. Please choose a smaller file.").removeClass("hidden");
                    this.value = "";
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => {
                    // Fit exactly in fixed-height card
                    $("#my_profile_video_tab_thumbPreview").attr("src", e.target.result)
                        .addClass("w-full h-full object-cover object-center");
                };
                reader.readAsDataURL(file);
            });

            $("#my_profile_video_tab_btnSave").on("click", function() {
                $(this).addClass("ring-2 ring-black/10");
                setTimeout(() => $(this).removeClass("ring-2 ring-black/10"), 350);
                alert("Video tab saved (demo).");
            });

        })(jQuery);
    </script>
</body>

</html>