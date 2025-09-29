<?php require("translator.php") ?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WR87MMR4');</script>
<!-- End Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9NN1EHK3RT"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#009FE3",
                        hover: "#0C699E"
                    },
                    fontFamily: {
                        default: ["Quicksand", "sans-serif"],
                    },
                },
            },
        };
        // Funzione per aprire e chiudere il menu mobile
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
    <div class="bg-white">
        <?php require("navbar.php"); ?>
        <!-- contenuto -->
        <div class="flex items-center my-8">
            <div class="text-sm text-gray-500">
                <div>
                    <div class="pl-8 w-screen">
                        <div class="md:pl-8 w-full ml-50px flex gap-8 items-center">
                            <div class="w-max">
                                <p class="text-2xl font-bold text-primary w-max">
                                    <?= $page_translations['whirlpool'] ?>
                                </p>
                            </div>
                            <div class="bg-primary w-full h-[1px]"></div>
                        </div>
                        <div
                            class="py-8 md:px-16 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-8 text-sm">
                            <div>
                                <p
                                    id="Clothing-heading"
                                    class="font-medium text-lg text-primary text-gray-900">
                                    <span class="hidden">Air System</span><?= $page_translations['air_system'] ?>
                                </p>
                                <ul
                                    role="list"
                                    aria-labelledby="Clothing-heading"
                                    class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Basic Air Kit</span>Basic Air Kit</a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Blower</span>Blower</a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Airjet</span>Airjet</a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Manifolds</span><?= $page_translations['manifolds'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Pipes & Fittings</span><?= $page_translations['pipes_fiting'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Controls</span><?= $page_translations['controls'] ?></a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <p
                                    id="Accessories-heading"
                                    class="font-medium text-lg text-primary text-gray-900">
                                    <span class="hidden">Water System</span><?= $page_translations['water_system'] ?>
                                </p>
                                <ul
                                    role="list"
                                    aria-labelledby="Accessories-heading"
                                    class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Basic Hydro Kit</span>Basic Hydro Kit</a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Microjet Kit</span>Microjet Kit</a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Pumps</span><?= $page_translations['pumps'] ?></a>
                                    </li>
                                    <li class="flex" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Jets</span><?= $page_translations['jets'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Microjets</span>Microjets</a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Suctions</span><?= $page_translations['suctions'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Controls</span><?= $page_translations['controls'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Pipes, Fittings & Disinfection</span><?= $page_translations['pipes_fittings_disifections'] ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="md:pl-8 w-full ml-50px flex gap-8 items-center">
                            <div class="w-max">
                                <p class="text-2xl font-bold text-primary w-max">
                                    <span class="hidden">SHOWER SYSTEMS</span><?= $page_translations['shower'] ?>
                                </p>
                            </div>
                            <div class="bg-primary w-full h-[1px]"></div>
                        </div>
                        <div class="py-8 md:px-16">
                            <div>
                                <ul
                                    role="list"
                                    aria-labelledby="Brands-heading"
                                    class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                    <li class="flex" id="item">
                                        <a href="# item" class="hover:text-gray-800"><span class="hidden">Shower Drains</span><?= $page_translations['drains'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Shower Fittings</span><?= $page_translations['fittings'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Shower Jets</span><?= $page_translations['shower_jets'] ?></a>
                                    </li>
                                    <li class="flex item" id="item">
                                        <a href="#" class="hover:text-gray-800"><span class="hidden">Steam, Accessories & Fittings</span><?= $page_translations['steams_accessories_fittings'] ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require("footer.php"); ?>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    const items = document.querySelectorAll("#item");
    items.forEach((item, index) => {
        item.addEventListener("click", () => {
            console.log(item.children[0].children[0].innerHTML);
            console.log(item.parentElement.parentElement.firstChild.nextElementSibling.children[0].innerText);
            let pr = item.children[0].children[0].innerHTML;
            //let nr = index >= 14 ? "Shower DrainsShower FittingsShower JetsSteam, Accessories & Fittings" : item.parentElement.parentElement.firstChild.nextElementSibling.children[0].innerText;
            let nr = index >= 14 ? "Shower System" : item.parentElement.parentElement.firstChild.nextElementSibling.children[0].innerText;
            let encodedNr = encodeURIComponent(nr);
            encodedNr = encodedNr.replace(/%20/g, "-"); // Sostituisci gli spazi con trattini
            encodedNr = encodedNr.toLocaleLowerCase();
            let encodedPr = pr
                .replace(/, +/g, "_")
                .replace(/&amp;/gi, "and")
                .replace(/&/g, "and")
                .trim()
                .toLowerCase()
                .replace(/\s+/g, "-");

            let slug = pr.toLowerCase().replace(/\s+/g, '-');

            console.log("slug: " + slug);
            
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
              event: "category_click",
              category_name: encodedNr,
              subcategory_name: encodedPr
            });

            // Naviga dopo un breve ritardo per permettere a GA di processare l'evento
            const lang = document.documentElement.lang || 'en';
            setTimeout(() => {
                window.location.href = `/${lang}/product/${encodedNr}/${encodedPr}`;
            }, 200);
        });
    });
</script>

</html>