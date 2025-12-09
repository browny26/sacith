<?php require("translator.php") ?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WR87MMR4');
    </script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="google" content="notranslate">
    <title>Sacith s.r.l.</title>
    <meta name="description" content="<?php
                                        if ($lang === 'it') {
                                            echo 'Scopri la storia, i valori e la missione di Sacith s.r.l., azienda leader nella produzione di componenti industriali di alta qualità.';
                                        } else {
                                            echo 'Learn about Sacith s.r.l.\'s history, values, and mission. A leading company in high-quality industrial components manufacturing.';
                                        }
                                        ?>" />
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sacith s.r.l.">
    <link rel="canonical" href="https://www.sacith.com/<?= htmlspecialchars($lang) ?>/about" />
    <link rel="alternate" hreflang="it" href="/it/about" />
    <link rel="alternate" hreflang="en" href="/en/about" />
    <link rel="icon" href="/public/logo/logo_small.png" type="image/png">
    <link rel="stylesheet" href="style.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
        --color-primary: #009FE3;
        --color-hover: #0C699E;
        --font-default: Raleway, sans-serif;
        --animate-slide-up: slideUp 1s ease-out forwards;

        @keyframes slideUp {
          0% {
            transform: translateY(100%);
            opacity: 0;
          }
          100% {
            transform: translateY(0);
            opacity: 1;
          }
        }
    }
  </style>
    <script>
        function toggleMenu() {
            const mobileMenu = document.getElementById("mobile-menu");
            const overlay = document.getElementById("menu-overlay");
            const body = document.body;
            if (mobileMenu.classList.contains("translate-x-full")) {
                // Mostra il menu (entra da destra)
                mobileMenu.classList.remove("translate-x-full", "opacity-0");
                mobileMenu.classList.add("translate-x-0", "opacity-100");
                overlay.classList.remove("hidden");
                overlay.classList.add("block");
                // Disabilita lo scroll del body
                body.classList.add("overflow-hidden");
            } else {
                // Nasconde il menu (esce verso destra)
                mobileMenu.classList.remove("translate-x-0", "opacity-100");
                mobileMenu.classList.add("translate-x-full", "opacity-0");
                overlay.classList.remove("block");
                overlay.classList.add("hidden");
                // Riattiva lo scroll del body
                body.classList.remove("overflow-hidden");
            }
        }
        // Aggiungi evento per il pulsante del menu
        window.onload = function() {
            const menuButton = document.getElementById("menu-button");
            const closeButton = document.getElementById("close-button");
            const overlay = document.getElementById("menu-overlay");
            menuButton.addEventListener("click", toggleMenu);
            closeButton.addEventListener("click", toggleMenu);
            overlay.addEventListener("click", toggleMenu);
        };
    </script>
</head>

<body class="overflow-y-auto font-default overflow-x-hidden">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="sticky top-0 shadow-md bg-white z-10">
        <?php require("navbar.php"); ?>
    </div>
    <main class="flex flex-col">
        <section style="height: calc(100vh - 56px);" class="w-screen relative">
            <img src="/public/img/about/sacith.png" alt="immagine azienda" class="w-full h-full object-cover object-left">
            <div class="absolute bottom-[47px] left-[50px] md:left-[115px] text-white">
                <h1><?= $page_translations['hero_title_1'] ?></h1>
                <h1 class="text-[44px]"><?= $page_translations['hero_title_2'] ?></h1>
            </div>
        </section>
        <section class="w-screen container mx-auto my-20 px-10 flex flex-col gap-[60px]">
            <div class="text-center mb-10 lg:mb-0">
                <h6 class="uppercase text-black/50 font-medium text-[14px]"><?= $page_translations['first_section_title_1'] ?></h6>
                <h2 class="text-black font-medium md:text-[36px] text-[24px]"><?= $page_translations['first_section_title_2'] ?></h2>
            </div>
            <div class="flex flex-col lg:flex-row justify-around items-center gap-[60px] lg:gap-[120px]">
                <article class="text-center lg:text-left max-w-[390px]">
                    <p><?= $page_translations['first_section_1'] ?></p>
                </article>
                <img src="/public/img/about/sacith2.png" width="490" height="400" alt="">
            </div>
            <div class="flex flex-col lg:flex-row justify-around items-center gap-[60px] lg:gap-[120px]">
                <img src="/public/img/about/sacith4.png" width="490" height="400" alt="">
                <article class="text-center lg:text-left max-w-[390px]">
                    <p><?= $page_translations['first_section_2'] ?></p>
                </article>
            </div>
        </section>
        <section class="w-screen overflow-hidden h-[70vh] relative">
            <img src="/public/img/about/sacith3.png" alt="immagine azienda" class="w-full h-full object-cover object-center">
            <h1 class="text-[44px] absolute bottom-[20px] md:bottom-[47px] left-[50px] md:left-[115px] text-white"><?= $page_translations['img_title_1'] ?></h1>
        </section>
        <section class="w-screen container mx-auto my-20 px-10 flex flex-col gap-[60px]">
            <div class="text-center mb-10 lg:mb-0">
                <h6 class="uppercase text-black/50 font-medium text-[14px]"><?= $page_translations['second_section_title_1'] ?></h6>
                <h2 class="text-black font-medium  md:text-[36px] text-[24px]"><?= $page_translations['second_section_title_2'] ?></h2>
            </div>
            <div class="flex flex-col lg:flex-row justify-around items-center gap-[60px] lg:gap-[120px]">
                <img src="/public/img/about/sacith6.png" width="490" height="400" alt="">
                <article class="text-center lg:text-left max-w-[390px]">
                    <p><?= $page_translations['second_section'] ?></p>
                </article>
            </div>
        </section>
        <section class="w-screen overflow-hidden h-[70vh] relative">
            <img src="https://www.sacith.com/public/img/home/values_3.png" alt="immagine azienda" class="w-full h-full object-cover object-center">
            <h1 class="text-[44px] absolute bottom-[20px] md:bottom-[47px] left-[50px] md:left-[115px] text-white"><?= $page_translations['img_title_2'] ?></h1>
        </section>
        <section class="w-screen container mx-auto my-20 px-10 flex flex-col gap-[60px]">
            <div class="text-center mb-10 lg:mb-0">
                <h6 class="uppercase text-black/50 font-medium text-[14px]"><?= $page_translations['fourth_section_title_1'] ?></h6>
                <h2 class="text-black font-medium  md:text-[36px] text-[24px]"><?= $page_translations['fourth_section_title_2'] ?></h2>
            </div>
            <div class="flex flex-col lg:flex-row justify-around items-center gap-[60px] lg:gap-[120px]">
                <img src="https://www.sacith.com/public/img/home/values_2.png" width="490" height="400" alt="">
                <article class="text-center lg:text-left max-w-[390px]">
                    <p><?= $page_translations['fourth_section'] ?></p>
                </article>
            </div>
        </section>
        <section class="w-screen overflow-hidden h-[70vh] relative">
            <img src="/public/img/about/sacith5.png" alt="immagine azienda" class="w-full h-full object-cover object-center">
            <h1 class="text-[44px] absolute bottom-[20px] md:bottom-[47px] left-[50px] md:left-[115px] text-white"><?= $page_translations['img_title_2'] ?></h1>
        </section>
        <section class="w-screen container mx-auto mt-20 px-10 flex flex-col gap-[60px]">
            <div class="text-center mb-10 lg:mb-0">
                <h6 class="uppercase text-black/50 font-medium text-[14px]"><?= $page_translations['third_section_title_1'] ?></h6>
                <h2 class="text-black font-medium  md:text-[36px] text-[24px]"><?= $page_translations['third_section_title_2'] ?></h2>
            </div>
            <div class="flex flex-col gap[20px] max-w-5xl mx-auto">
                <p class="text-center"><?= $page_translations['third_section_1'] ?></p>
                <br>
                <p class="text-center"><?= $page_translations['third_section_2'] ?></p>
            </div>
        </section>
    </main>
    <?php require("footer.php"); ?>
</body>

</html>