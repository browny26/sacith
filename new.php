<?php require("translator.php") ?>
<?php
$products = json_decode(file_get_contents('new-products.json'), true);
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
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
    <meta name="description" content="<?php
                                        if ($lang === 'it') {
                                            echo 'Contatta Sacith s.r.l. per informazioni, richieste commerciali o supporto tecnico. Siamo a tua disposizione per ogni esigenza.';
                                        } else {
                                            echo 'Get in touch with Sacith s.r.l. for information, business inquiries, or technical support. We’re here to assist you.';
                                        }
                                        ?>" />
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sacith s.r.l.">
    <link rel="canonical" href="https://www.sacith.com/<?= htmlspecialchars($lang) ?>/contact" />
    <link rel="alternate" hreflang="it" href="/it/contact" />
    <link rel="alternate" hreflang="en" href="/en/contact" />
    <link rel="icon" href="/public/logo/logo_small.png" type="image/png">
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
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
                        default: ["Raleway", "sans-serif"],
                    },
                    animation: {
                        'slide-up': 'slideUp 1s ease-out forwards',
                    },
                    keyframes: {
                        slideUp: {
                            '0%': {
                                transform: 'translateY(100%)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            },
                        }
                    }
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Animazione universale per tutti gli elementi con data-animate
            gsap.utils.toArray('[data-animate]').forEach(element => {
                const delay = element.getAttribute('data-delay') || 0;

                gsap.from(element, {
                    y: 60,
                    opacity: 0,
                    duration: 1,
                    delay: parseFloat(delay),
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: element,
                        start: "top 85%",
                        toggleActions: "play none none none"
                    }
                });
            });
        });
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
    <main class="mx-[115px] flex flex-col gap-[153px] mt-[68px]">

        <div class="animate-slide-up" data-animate="fade-up" data-delay="0">
            <div>
                <h6 class="uppercase text-black/50 font-medium text-[14px]">In evidenza</h6>
                <h1 class="text-black font-medium text-[36px]">Novità dal catalogo</h1>
            </div>
            <p class="text-black/50">Scopri i nostri ultimi sistemi idromassaggio e componenti tecnici, progettati per unire innovazione, design e massima qualità.</p>
        </div>
        <div class="flex flex-col gap-[88px]">
            <?php foreach ($products as $index => $product): ?>
                <?php
                $reverse = $index % 2 !== 0;
                ?>
                <div class="flex gap-[64px] justify-between <?= $reverse ? 'flex-row-reverse' : '' ?>"
                    data-animate="fade-up"
                    data-delay="0">

                    <img src="<?= htmlspecialchars($product['immagine']) ?>"
                        alt="<?= htmlspecialchars($product['nome']) ?>"
                        loading="lazy"
                        class="h-[200px] w-[400px] object-cover object-center rounded-md border border-neutral-100">

                    <div class="flex flex-col gap-[24px]">
                        <div>
                            <h2 class="text-[24px] font-medium"><?= htmlspecialchars($product['nome']) ?></h2>
                            <p class="text-black/50"><?= nl2br(htmlspecialchars($product['descrizione'])) ?></p>
                        </div>

                        <a href="<?= htmlspecialchars($product['call_to_action']['url']) ?>"
                            class="py-[4px] px-[26px] bg-primary text-white w-fit rounded-md hover:bg-hover transition-colors">
                            <?= htmlspecialchars($product['call_to_action']['label']) ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <section class="flex flex-col lg:flex-row gap-[88px] justify-between">
            <div class="flex flex-col gap-[62px]">
                <div class="flex flex-col md:flex-row gap-[92px]">
                    <article class="flex flex-col gap-[10px]">
                        <h2 class="text-[24px] font-medium text-primary"><?= $page_translations['phone'] ?></h2>
                        <div>
                            <a href="tel:+390331619011" class="flex items-center space-x-2">
                                <img
                                    src="/public/icons/phone-icon.png"
                                    alt="Telefono SAC" class="h-[24px] w-[24px]" />
                                <span class="text-[14px]">+39 0331 619011</span>
                            </a>
                        </div>
                    </article>
                    <article class="flex flex-col gap-[10px]">
                        <h2 class="text-[24px] font-medium text-primary"><?= $page_translations['hours'] ?></h2>
                        <div>
                            <span class="text-[14px]"><?= $page_translations['hours_content'] ?></span>
                        </div>
                    </article>
                </div>
                <div>
                    <article class="flex flex-col gap-[10px]">
                        <h2 class="text-[24px] font-medium text-primary"><?= $page_translations['site'] ?></h2>
                        <div>
                            <span class="text-[14px]">Via Luigi Pirandello, 21, 21012 Cassano Magnago (VA)</span>
                        </div>
                    </article>
                </div>
                <div>
                    <article class="flex flex-col gap-[10px]">
                        <h2 class="text-[24px] font-medium text-primary">Social</h2>
                        <div class="flex gap-[24px]">
                            <a href="https://www.linkedin.com/company/sacith-srl">
                                <img src="image/linkedin-svgrepo-com.svg" alt="" class="h-[24px] w-[24px]">
                            </a><!-- <img src="image/facebook-svgrepo-com.svg" alt="" class="h-[24px] w-[24px]"><img src="image/instagram-svgrepo-com.svg" alt="" class="h-[24px] w-[24px]"> -->
                        </div>
                    </article>
                </div>
            </div>

            <form class="max-w-[700px] mx-auto w-full">
                <h2 class="text-primary text-[24px] font-medium mb-[22px]"><?= $page_translations['form_title'] ?></h2>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="floating_first_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-gray-300 appearance-none utf8mb4_general_ci focus:outline-none focus:ring-0 focus:border-primary peer" placeholder=" " required />
                        <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-primary  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><?= $page_translations['form_name'] ?></label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-gray-300 appearance-none utf8mb4_general_ci focus:outline-none focus:ring-0 focus:border-primary peer" placeholder=" " required />
                        <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-primary  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><?= $page_translations['form_surname'] ?></label>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-gray-300 appearance-none utf8mb4_general_ci focus:outline-none focus:ring-0 focus:border-primary peer" placeholder=" " required />
                        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-primary  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><?= $page_translations['form_phone'] ?></label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="floating_company" id="floating_company" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-gray-300 appearance-none utf8mb4_general_ci focus:outline-none focus:ring-0 focus:border-primary peer" placeholder=" " required />
                        <label for="floating_company" class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-primary  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><?= $page_translations['form_company'] ?></label>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="floating_email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-gray-300 appearance-none utf8mb4_general_ci focus:outline-none focus:ring-0 focus:border-primary peer" placeholder=" " required />
                    <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-primary  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><?= $page_translations['form_email'] ?></label>
                </div>

                <label for="message" class="block mb-2 font-medium text-sm text-gray-500"><?= $page_translations['form_message'] ?></label>
                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none focus:border-primary transition-colors utf8mb4_general_ci"></textarea>

                <button type="submit" class="mt-5 text-white bg-primary hover:bg-[#005F88] focus:ring-1 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            </form>

        </section>
    </main>
    <?php require("footer.php"); ?>
</body>

</html>