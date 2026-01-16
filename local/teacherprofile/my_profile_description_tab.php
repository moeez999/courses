<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Profile – Description Tab</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_profile_description_tab_text: #121117;
            --my_profile_description_tab_muted: #6B7280;
            --my_profile_description_tab_border: #E4E7EE;
            --my_profile_description_tab_accent: #ff3b1f;
            --my_profile_description_tab_info_bg: #EAF2FF;
            --my_profile_description_tab_info_bd: #CFE0FF;
        }

        .my_profile_description_tab_container p {
            color: var(--my_profile_description_tab_text)
        }

        .my_profile_description_tab_muted {
            color: var(--my_profile_description_tab_muted)
        }

        .my_profile_description_tab_card {
            border: 1.5px solid var(--my_profile_description_tab_border);
            border-radius: 12px;
            background: #fff;
        }

        .my_profile_description_tab_callout {
            border: 1.5px solid var(--my_profile_description_tab_info_bd);
            background: var(--my_profile_description_tab_info_bg);
            border-radius: 10px;
        }

        .my_profile_description_tab_lang_btn {
            border: 1.5px solid var(--my_profile_description_tab_border);
            border-radius: 10px;
            padding: .5rem .9rem;
            line-height: 1;
            font-weight: 500;
            background: #fff;
            transition: all .15s ease;
        }

        .my_profile_description_tab_lang_btn.my_profile_description_tab_active {
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, .06);
        }

        @media (max-width: 640px) {
            .my_profile_description_tab_h1 {
                font-size: 1.625rem;
                line-height: 1.25
            }
        }
    </style>
</head>

<body class="bg-white text-[15px] sm:text-[16px]">
    <main class="my_profile_description_tab_container max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <!-- Title -->
        <h1 class="my_profile_description_tab_h1 text-[28px] sm:text-[32px] font-semibold mb-3">
            Profile description
        </h1>
        <p class="my_profile_description_tab_muted mb-6">
            This info will go on your public profile. Write it in the language you’ll be teaching and make sure to follow our
            guidelines below.
        </p>

        <!-- Language chips -->
        <div class="flex flex-wrap gap-2 mb-8" id="my_profile_description_tab_langGroup">
            <button type="button" class="my_profile_description_tab_lang_btn my_profile_description_tab_active" data-lang="Portuguese">Portuguese</button>
            <button type="button" class="my_profile_description_tab_lang_btn" data-lang="English">English</button>
            <button type="button" class="my_profile_description_tab_lang_btn" data-lang="English 2">English</button>
        </div>

        <!-- Section header that changes with language -->
        <h2 id="my_profile_description_tab_sectionTitle" class="text-[18px] sm:text-[20px] font-semibold mb-6">
            Description for English-speaking students
        </h2>

        <!-- =============== 1. Introduce yourself =============== -->
        <section class="mb-10">
            <h3 class="text-[18px] font-semibold mb-2">1. Introduce yourself</h3>
            <p class="my_profile_description_tab_muted mb-4">
                Show potential students who you are! Share your teaching experience and passion for education and briefly mention
                your interests and hobbies.
            </p>

            <div class="my_profile_description_tab_card p-4 sm:p-5 mb-4">
                <p id="my_profile_description_tab_exampleIntro">
                    I’m a kind and detail-oriented person who enjoys helping others throughout their comprehensive learning
                    process. I’m passionate about languages and crafting.
                </p>
            </div>

            <div class="my_profile_description_tab_callout flex items-start gap-3 p-3 sm:p-4">
                <div class="shrink-0 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="1.5"></circle>
                        <path stroke-width="1.5" d="M12 8.25h.01M11.25 11.25h1.5v4.5h-1.5z"></path>
                    </svg>
                </div>
                <p class="text-[15px]">
                    Don’t include your last name or present your information in a CV format.
                </p>
            </div>
        </section>

        <!-- =============== 2. Teaching experience =============== -->
        <section class="mb-10">
            <h3 class="text-[18px] font-semibold mb-2">2. Teaching experience</h3>
            <p class="my_profile_description_tab_muted mb-4">
                Provide a detailed description of your relevant teaching experience. Include certifications, teaching methodology,
                education, and subject expertise.
            </p>

            <div class="my_profile_description_tab_card p-4 sm:p-5 mb-4">
                <p id="my_profile_description_tab_exampleExperience">
                    I have been helping people to study for more than 10 years. I always try to listen carefully to other people's
                    expectations before adjusting the teaching process to their needs. Tell me what your goals are regarding speaking
                    English and I will help you achieve them.
                </p>
            </div>

            <div class="my_profile_description_tab_callout flex items-start gap-3 p-3 sm:p-4">
                <div class="shrink-0 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="1.5"></circle>
                        <path stroke-width="1.5" d="M12 8.25h.01M11.25 11.25h1.5v4.5h-1.5z"></path>
                    </svg>
                </div>
                <p class="text-[15px]">
                    Do not include any information regarding free trial lessons or discounts, or any of your personal contact details.
                </p>
            </div>
        </section>

        <!-- =============== 3. Motivate potential students (ADDED) =============== -->
        <section class="mb-10" id="my_profile_description_tab_motivate">
            <h3 class="text-[18px] font-semibold mb-2">3. Motivate potential students</h3>
            <p class="my_profile_description_tab_muted mb-4">
                Encourage students to book their first lesson. Highlight the benefits of learning with you!
            </p>

            <!-- example paragraph card (same copy as snapshot) -->
            <div class="my_profile_description_tab_card p-4 sm:p-5 mb-4">
                <p id="my_profile_description_tab_exampleMotivate">
                    I have been helping people to study for more than 10 years. I always try to listen carefully to other people's
                    expectations before adjusting the teaching process to their needs. Tell me what your goals are regarding speaking
                    English and I will help you achieve them.
                </p>
            </div>

            <!-- blue info callout -->
            <div class="my_profile_description_tab_callout flex items-start gap-3 p-3 sm:p-4">
                <div class="shrink-0 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="1.5"></circle>
                        <path stroke-width="1.5" d="M12 8.25h.01M11.25 11.25h1.5v4.5h-1.5z"></path>
                    </svg>
                </div>
                <p class="text-[15px]">
                    Do not include any information regarding free trial lessons or discounts, or any of your personal contact details
                </p>
            </div>
        </section>

        <!-- =============== 4. Write a catchy headline =============== -->
        <section class="mb-8">
            <h3 class="text-[18px] font-semibold mb-2">4. Write a catchy headline</h3>
            <p class="my_profile_description_tab_muted mb-4">
                Your headline is the first thing students see about you. Make it attention-grabbing, mention your specific
                teaching language and encourage students to read your full description.
            </p>

            <div class="my_profile_description_tab_card p-4 sm:p-5">
                <p id="my_profile_description_tab_exampleHeadline">
                    Let’s join forces and achieve your English-speaking goals together. I’m going to guide you through this fabulous journey.
                </p>
            </div>
        </section>

        <!-- Save button -->
        <div class="pt-4">
            <button id="my_profile_description_tab_btnSave"
                class="w-full sm:w-auto px-8 h-11 rounded-[10px] text-white font-semibold"
                style="background:var(--my_profile_description_tab_accent);border:2px solid #000;">
                Save
            </button>
        </div>
    </main>

    <script>
        // ===== Namespace: my_profile_description_tab_ =====
        (function($) {
            const my_profile_description_tab_langCopy = {
                "Portuguese": {
                    title: "Description for Portuguese-speaking students",
                    intro: "Sou uma pessoa atenciosa e detalhista que gosta de ajudar outros ao longo do processo de aprendizagem. Sou apaixonado(a) por línguas e artesanato.",
                    exp: "Ajudo pessoas a estudar há mais de 10 anos. Ouço com atenção as expectativas antes de adaptar meu processo de ensino às necessidades de cada aluno. Conte-me seus objetivos em relação ao português e eu ajudarei você a alcançá-los.",
                    motivate: "Ajudo estudantes há mais de 10 anos. Vou adaptar minhas aulas às suas metas para que você avance com confiança.",
                    headline: "Vamos juntos alcançar seus objetivos de fluência em português. Vou guiá-lo(a) nessa jornada!"
                },
                "English": {
                    title: "Description for English-speaking students",
                    intro: "I’m a kind and detail-oriented person who enjoys helping others throughout their learning process. I’m passionate about languages and crafting.",
                    exp: "I have been helping people to study for more than 10 years. I listen carefully to expectations before tailoring lessons to each student’s needs. Tell me your English goals and I’ll help you achieve them.",
                    motivate: "I have been helping people to study for more than 10 years. I always listen carefully and tailor lessons to your goals so you progress confidently.",
                    headline: "Let’s join forces to reach your English-speaking goals. I’ll guide you through this fabulous journey."
                },
                "English 2": {
                    title: "Description for English-speaking students",
                    intro: "Friendly, patient, and organized — I love making complex topics simple and fun. Outside class, I enjoy reading and travel.",
                    exp: "Over the past decade I’ve taught learners of all ages, using communicative methods, real-life tasks, and clear feedback so you improve fast and confidently.",
                    motivate: "Ready to start? Book your first lesson and let’s build a plan that matches your goals and schedule.",
                    headline: "Speak with confidence — I’ll help you make real progress, lesson by lesson."
                }
            };

            function my_profile_description_tab_apply(langKey) {
                const src = my_profile_description_tab_langCopy[langKey] || my_profile_description_tab_langCopy["English"];
                $("#my_profile_description_tab_sectionTitle").text(src.title);
                $("#my_profile_description_tab_exampleIntro").text(src.intro);
                $("#my_profile_description_tab_exampleExperience").text(src.exp);
                $("#my_profile_description_tab_exampleMotivate").text(src.exp); // snapshot shows same paragraph; use exp
                $("#my_profile_description_tab_exampleHeadline").text(src.headline);
            }

            // Language chip interactions
            $("#my_profile_description_tab_langGroup").on("click", ".my_profile_description_tab_lang_btn", function() {
                $(".my_profile_description_tab_lang_btn").removeClass("my_profile_description_tab_active");
                $(this).addClass("my_profile_description_tab_active");
                my_profile_description_tab_apply($(this).data("lang"));
            });

            // Save button (demo)
            $("#my_profile_description_tab_btnSave").on("click", function() {
                $(this).addClass("ring-2 ring-black/10");
                setTimeout(() => $(this).removeClass("ring-2 ring-black/10"), 400);
                alert("Profile description saved (demo).");
            });

            // Initialize default language
            my_profile_description_tab_apply("English");
        })(jQuery);
    </script>
</body>

</html>