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
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9NN1EHK3RT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-9NN1EHK3RT');
    </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="google" content="notranslate">
    <title>Sacith s.r.l.</title>
    <meta
        name="description"
        content="Scopri i migliori <?php echo isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : "prodotti"; ?> selezionati per te." />
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sacith s.r.l.">
    <link rel="canonical" href="https://www.sacith.com/<?= htmlspecialchars($lang) ?>/products" />
    <link rel="alternate" hreflang="it" href="/it/products" />
    <link rel="alternate" hreflang="en" href="/en/products" />
    <link rel="icon" href="/public/logo/logo_small.png" type="image/png">
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
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
                mobileMenu.classList.remove("translate-x-full", "opacity-0");
                mobileMenu.classList.add("translate-x-0", "opacity-100");
                overlay.classList.remove("hidden");
                overlay.classList.add("block");
                body.classList.add("overflow-hidden");
            } else {
                mobileMenu.classList.remove("translate-x-0", "opacity-100");
                mobileMenu.classList.add("translate-x-full", "opacity-0");
                overlay.classList.remove("block");
                overlay.classList.add("hidden");
                body.classList.remove("overflow-hidden");
            }
        }
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
    <div class="bg-white">
        <div class="sticky top-0 shadow-md bg-white z-10">
            <?php require("navbar.php"); ?>
        </div>
        <section class="mx-[10px] md:mx-[115px] flex flex-col gap-[61px] mt-[61px]">
            <div class="animate-slide-up" data-animate="fade-up" data-delay="0">
                <div>
                    <h6 class="uppercase text-black/50 font-medium text-[14px]">Esplora il catalogo</h6>
                    <h2 class="text-black font-medium text-[36px]">Scegli una categoria</h2>
                </div>
                <p class="text-black/50">Scopri le due principali linee di prodotti Sacith: soluzioni idromassaggio per il benessere e componenti tecnici per vasche e spa. Tutto studiato per garantire qualità, innovazione ed efficienza.</p>
            </div>
            <div class="mt-[32px] flex flex-col md:flex-row gap-[120px] md:gap-[20px] w-full md:h-[373px] justify-center items-center">
                <div class="relative overflow-hidden flex flex-col justify-end gap-[16px] w-full h-full md:px-[61px] pb-[60px] animate-slide-up" data-animate="fade-up" data-delay="0.2">
                    <div class="z-10">
                        <h2 class="uppercase text-[36px] font-medium text-black">HYDROMASSAGE</h2>
                        <p class="text-black/50">vasche & docce</p>
                    </div>
                    <button type="button" data-category="hydromassage" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
                    <img src="image/h-full.svg" alt="" class="absolute right-20 top-1/2 -translate-y-1/2 opacity-30">
                </div>
                <div class="relative overflow-hidden flex flex-col justify-end gap-[16px] w-full h-full md:px-[61px] pb-[90px] animate-slide-up" data-animate="fade-up" data-delay="0.4">

                    <h2 class="uppercase text-[36px] font-medium text-black z-10">SHOWER DRAINS</h2>
                    <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
                    <img src="image/s-full.svg" alt="" class="absolute right-20 top-1/2 -translate-y-1/2 opacity-20">
                </div>
            </div>
        </section>
    </div>
    <?php require("footer.php"); ?>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    const categories = document.querySelectorAll(".category");

    categories.forEach((category, index) => {
        category.addEventListener("click", () => {
            const lang = document.documentElement.lang || 'en';
            const dataset = category.dataset.category;
            console.log(dataset);

            let url = `/sacith/${lang}/product/${dataset}`;
            if (dataset === 'hydromassage') {
                url += `/whirlpool-system/air-system`;
            }

            console.log(url)
            setTimeout(() => {
                window.location.href = url;
            }, 200);


        })

    })
</script>

</html>