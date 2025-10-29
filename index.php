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
  <meta name="description" content="<?php
                                    if ($lang === 'it') {
                                      echo 'Excellence Made in Italy! Sacith is an Italian producer of high quality hydro and air components for whirlpool and shower systems, with more than 20 years experience in the market. You can choose between a wide range of jets, pneumatic controls, blowers and fittings. Recently, Sacith developed a complete range of Shower Drains, among them the innovative linear drains with 2 and 3 siphons.';
                                    } else {
                                      echo "Eccellenza Made in Italy! Sacith è un produttore italiano di componenti idro e aria di alta qualità per sistemi idromassaggio e doccia, con oltre 20 anni di esperienza nel settore. Puoi scegliere tra un'ampia gamma di getti, comandi pneumatici, soffianti e raccordi. Recentemente, Sacith ha sviluppato una gamma completa di scarichi doccia, tra cui gli innovativi scarichi lineari a 2 e 3 sifoni.";
                                    }
                                    ?>" />
  <meta name="robots" content="index, follow">
  <meta name="author" content="Sacith s.r.l.">
  <link rel="canonical" href="https://www.sacith.com/<?= htmlspecialchars($lang) ?>/" />
  <link rel="alternate" hreflang="it" href="https://www.sacith.com/it/" />
  <link rel="alternate" hreflang="en" href="https://www.sacith.com/en/" />
  <link rel="icon" href="/public/logo/logo_small.png" type="image/png">
  <link rel="stylesheet" href="style.css" />
  <!-- Includi GSAP nel tuo head -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
  <!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
      gsap.registerPlugin(ScrollTrigger);

      // Animazione per il testo introduttivo
      gsap.from('.animate-on-scroll', {
        y: 60,
        opacity: 0,
        duration: 3,
        ease: "power3.out",
        scrollTrigger: {
          trigger: '.animate-on-scroll',
          start: "top 85%",
          end: "bottom 20%",
          toggleActions: "play none none none"
        }
      });

      // Animazione per le cards (entrano una dopo l'altra)
      gsap.from('.animate-card', {
        y: 80,
        opacity: 0,
        duration: 3,
        stagger: 0.3, // Ritardo tra le cards
        ease: "power3.out",
        scrollTrigger: {
          trigger: '.animate-card',
          start: "top 80%",
          end: "bottom 20%",
          toggleActions: "play none none none"
        }
      });
    });
  </script> -->

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

<body class="relative font-default">
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->


  <main class="flex flex-col overflow-hidden">
    <section class="relative flex flex-col gap-[43px] items-center justify-end w-full bg-[url(/sacith/image/hero.svg)] h-[100vh] bg-center bg-cover bg-no-repeat">
      <div class="absolute z-10 backdrop-blur-0 w-full top-0" style="background-color: transparent !important;"><?php require("navbar-home.php"); ?></div>

      <div class="flex flex-col gap-[24px] max-w-[626px] animate-slide-up">
        <h1 class="text-[48px] text-white font-bold leading-[50px] text-center">Soluzioni idromassaggio e benessere made in Italy</h1>
        <p class="text-white/50 text-center">Sistemi idromassaggio e componenti tecnici Made in Italy per wellness e arredo bagno. Qualità, innovazione e design firmati Sacith.</p>
      </div>
      <div class="flex gap-[32px] mb-[73px] animate-slide-up">
        <a class="py-[4px] px-[26px] bg-primary rounded-md text-nowrap text-white" href="/product">Vai ai prodotti</a>
        <a class="py-[4px] px-[26px] bg-white rounded-md text-nowrap text-primary" href="/catalogues">Scarica cataloghi</a>
      </div>
      </div>
    </section>

    <section class="px-[100px] my-16">
      <div class="animate-on-scroll" data-animate="fade-up" data-delay="0">
        <div>
          <h6 class="uppercase text-black/50 font-medium text-[14px]">Esplora il catalogo</h6>
          <h2 class="text-black font-medium text-[36px]">Le nostre categorie principali</h2>
        </div>
        <p class="text-black/50">Scopri le due principali linee di prodotti Sacith: soluzioni idromassaggio per il benessere e componenti tecnici per vasche e spa. Tutto studiato per garantire qualità, innovazione ed efficienza.</p>
      </div>
      <div class="mt-[32px] flex flex-col md:flex-row gap-[20px] w-full h-[373px]">
        <div class="relative overflow-hidden rounded-xl flex flex-col justify-end gap-[16px] w-full h-full px-[61px] pb-[60px] animate-card" data-animate="fade-up" data-delay="0.2">
          <div class="z-10">
            <h2 class="uppercase text-[36px] font-medium text-black">HYDROMASSAGE</h2>
            <p class="text-black/50">vasche & docce</p>
          </div>
          <button type="button" data-category="hydromassage" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          <img src="image/h-full.svg" alt="" class="absolute right-20 top-1/2 -translate-y-1/2 opacity-30">
        </div>
        <div class="relative overflow-hidden rounded-xl flex flex-col justify-end gap-[16px] w-full h-full px-[61px] pb-[90px] animate-card" data-animate="fade-up" data-delay="0.4">

          <h2 class="uppercase text-[36px] font-medium text-black z-10">SHOWER DRAINS</h2>
          <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          <img src="image/s-full.svg" alt="" class="absolute right-20 top-1/2 -translate-y-1/2 opacity-20">
        </div>
      </div>
    </section>

    <section class="my-16">
      <div class="px-[100px]" data-animate="fade-up" data-delay="0">
        <div>
          <h6 class=" uppercase text-black/50 font-medium text-[14px]">In evidenza</h6>
          <h2 class="text-black font-medium text-[36px]">Novità dal catalogo</h2>
        </div>
        <p class="text-black/50">Scopri i nostri ultimi sistemi idromassaggio e componenti tecnici, progettati per unire innovazione, design e massima qualità.</p>
      </div>
      <div class="mt-[42px] flex flex-col w-full border-y border-neutral-100" data-animate="fade-up" data-delay="0.2">
        <div class="h-32 hover:h-80 transition-all duration-700 ease-in-out overflow-hidden flex w-full items-center justify-end bg-[url(/sacith/image/moon-jet-full.svg)] bg-center bg-cover bg-no-repeat">
          <div class="me-[100px]">
            <h3 class="text-[24px] font-semibold">MoonJet</h3>
            <p class="font-light mb-2 text-sm">Discover our newest whirpool technology</p>
            <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          </div>
        </div>
        <div class="h-32 hover:h-80 transition-all duration-700 border-y border-neutral-100 ease-in-out overflow-hidden flex w-full items-center justify-start bg-[url(/sacith/image/sacitronic-img.svg)] bg-center bg-cover bg-no-repeat">
          <div class="ms-[100px]">
            <h3 class="text-[24px] font-semibold">Sacitronic Cover</h3>
            <p class="font-light mb-2 text-sm">Discover our newest whirpool technology</p>
            <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          </div>
        </div>
        <div class="h-32 hover:h-80 transition-all duration-700 ease-in-out border-b border-neutral-100 overflow-hidden flex w-full items-center justify-end bg-[url(/sacith/image/microjet-moon-img.svg)] bg-center bg-cover bg-no-repeat">
          <div class="me-[100px]">
            <h3 class="text-[24px] font-semibold">MicroJet Moon</h3>
            <p class="font-light mb-2 text-sm">Discover our newest whirpool technology</p>
            <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          </div>
        </div>
        <div class="h-32 hover:h-80 transition-all duration-700 ease-in-out overflow-hidden flex w-full items-center justify-start bg-[url(/sacith/image/air-jet-moon-img.svg)] bg-center bg-cover bg-no-repeat">
          <div class="ms-[100px]">
            <h3 class="text-[24px] font-semibold">Sacitronic Cover</h3>
            <p class="font-light mb-2 text-sm">Discover our newest whirpool technology</p>
            <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          </div>
        </div>
    </section>

    <section class="px-[100px] my-16">
      <div data-animate="fade-up" data-delay="0">
        <div>
          <h6 class="uppercase text-black/50 font-medium text-[14px]">Scopri le nostre soluzioni</h6>
          <h2 class="text-black font-medium text-[36px]">Kit per ogni esigenza</h2>
        </div>
        <p class="text-black/50">Dai sistemi base a quelli più avanzati, i nostri kit offrono soluzioni complete e versatili per soddisfare ogni necessità nel settore wellness e idromassaggio, combinando qualità, affidabilità e facilità di installazione.</p>
      </div>
      <div class="mt-[42px] flex flex-col justify-center md:flex-row gap-[123px] w-full">
        <div class="flex flex-col gap-[38px]" data-animate="fade-up" data-delay="0.2">
          <img src="image/basic-air-kit.svg" alt="">
          <div class="flex flex-col items-center gap-[14px]">
            <div class="flex flex-col items-center gap-[2px]">
              <h3 class="text-[24px] font-semibold">Basic Air Kit</h3>
              <p class="font-light mb-2 text-sm">Everything you need for your whirpool in one place.</p>
            </div>
            <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          </div>
        </div>
        <div class="flex flex-col gap-[38px]" data-animate="fade-up" data-delay="0.4">
          <img src="image/basic-hydro-kit.svg" alt="">
          <div class="flex flex-col items-center gap-[14px]">
            <div class="flex flex-col items-center gap-[2px]">
              <h3 class="text-[24px] font-semibold">Basic Hydro Kit</h3>
              <p class="font-light mb-2 text-sm">Everything you need for your whirpool in one place.</p>
            </div>
            <button type="button" data-category="shower-drains" class="category py-[4px] px-[26px] bg-primary text-white w-fit rounded-md">Scopri</button>
          </div>
        </div>
    </section>

    <section class="px-[100px] my-16">
      <div data-animate="fade-up" data-delay="0">
        <h6 class="uppercase text-black/50 font-medium text-[14px]">I nostri valori</h6>
        <div class="flex gap-[130px]">
          <h2 class="text-black font-medium text-[36px] text-nowrap">Cosa ci distingue</h2>
          <!--           <p class="text-black/50">In Sacith crediamo che la qualità nasca dall’unione tra innovazione, competenza e cura dei dettagli. Ogni progetto riflette la nostra dedizione nel creare sistemi idromassaggio e componenti tecnici che rappresentano l’eccellenza del Made in Italy.</p>
 -->
        </div>
      </div>
      <div class="mt-[42px] flex flex-col w-full border-y border-neutral-100" data-animate="fade-up" data-delay="0.2">
        <div class="group h-32 hover:h-64 transition-all duration-700 ease-in-out overflow-hidden flex w-full items-start justify-end">
          <div class="mx-[100px] flex flex-col w-full py-3 group-hover:py-6 transition-all duration-700 ease-in-out">
            <div class="flex justify-end relative items-start w-full">
              <span class="absolute left-0 -top-20 text-[200px] font-extralight text-black/10">1</span>
              <h3 class="text-[24px] font-medium mt-8">Innovazione</h3>
            </div>
            <div class="transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700 ease-in-out delay-200">
              <p class="text-black/50 pt-10">Investiamo costantemente in ricerca e sviluppo per offrire soluzioni idromassaggio sempre più performanti, sostenibili e in linea con le nuove tecnologie del settore wellness. Grazie a un approccio che unisce innovazione tecnica, design e attenzione ai materiali, Sacith realizza prodotti affidabili e di alta qualità, pensati per garantire comfort, efficienza e durata nel tempo, nel segno dell'eccellenza Made in Italy.</p>
            </div>
          </div>
        </div>

        <div class="group h-32 hover:h-64 transition-all duration-700 border-y border-neutral-100 ease-in-out overflow-hidden flex w-full items-start justify-end">
          <div class="mx-[100px] flex flex-col w-full py-3 group-hover:py-6 transition-all duration-700 ease-in-out">
            <div class="flex justify-end relative items-start w-full">
              <span class="absolute left-0 -top-20 text-[200px] font-extralight text-black/10">2</span>
              <h3 class="text-[24px] font-medium mt-8">Qualità</h3>
            </div>
            <div class="transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700 ease-in-out delay-200">
              <p class="text-black/50 pt-4">Ogni componente è progettato e testato con la massima attenzione ai dettagli, per garantire affidabilità, durata e standard produttivi elevati. Grazie a controlli rigorosi e processi all’avanguardia, Sacith offre prodotti che soddisfano le esigenze dei professionisti del settore wellness, unendo cura artigianale, precisione e design Made in Italy per un’esperienza di benessere superiore.</p>
            </div>
          </div>
        </div>

        <div class="group h-32 hover:h-64 transition-all duration-700 ease-in-out overflow-hidden flex w-full items-start justify-end">
          <div class="mx-[100px] flex flex-col w-full py-3 group-hover:py-6 transition-all duration-700 ease-in-out">
            <div class="flex justify-end relative items-start w-full">
              <span class="absolute left-0 -top-20 text-[200px] font-extralight text-black/10">3</span>
              <h3 class="text-[24px] font-medium mt-8">Eccellenza</h3>
            </div>
            <div class="transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700 ease-in-out delay-200">
              <p class="text-black/50 pt-4">Dall’idea alla realizzazione seguiamo ogni fase con precisione e cura artigianale: progettazione, produzione, collaudo e installazione. Creiamo sistemi idromassaggio e componenti tecnici che uniscono innovazione, qualità e tradizione Made in Italy, superando le aspettative di professionisti e aziende.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="h-[70vh] bg-neutral-950 flex flex-col lg:flex-row items-center gap-10 justify-between lg:justify-around mt-16">
      <img src="/public/img/home/sacith_lab.png" alt="sacith lab" class="xl:h-full sm:h-[60%] h-fit" />
      <div class="text-white mx-10 flex flex-col items-end gap-3 pb-10 lg:pb-0" data-animate="fade-up" data-delay="0">
        <h1 class="text-[35px] font-medium mb-0 leading-none"><?= $page_translations['lab_title'] ?></h1>
        <p><?= $page_translations['lab_description'] ?></p>
        <div class="flex w-full justify-end">
          <a href="https://sacith-lab.com"
            class="bg-neutral-50 py-[4px] px-[26px] rounded-md text-nowrap text-neutral-950">
            <?= $page_translations['lab_btn'] ?>
          </a>
        </div>
      </div>
    </section>

    <section class="bg-primary/5 py-[90px]">
      <div class="mx-auto flex flex-col items-center gap-[32px]">
        <div class="relative" data-animate="fade-up" data-delay="0">
          <h2 class="text-primary/20 text-[90px] lg:text-[128px] font-bold leading-none"><?= $page_translations['contact_title'] ?></h2>
          <h3 class="z-10 absolute bottom-2 lg:bottom-6 left-1/2 -translate-x-1/2 text-nowrap text-[#005F88] text-[24px] lg:text-[32px] font-bold"><?= $page_translations['contact_subtitle'] ?></h3>
        </div>
        <p class="text-black/60 text-center" data-animate="fade-up" data-delay="0.2"><?= $page_translations['contact_description'] ?></p>
        <div class="flex flex-col md:flex-row gap-[10px]" data-animate="fade-up" data-delay="0.4">
          <button class="py-[4px] px-[26px] rounded-md text-nowrap bg-primary text-white"><?= $page_translations['contact_btn_info'] ?></button>
          <button class="py-[4px] px-[26px] rounded-md text-nowrap text-primary bg-white"><?= $page_translations['contact_btn_catalogues'] ?></button>
        </div>
      </div>
    </section>

    <section class="relative h-[70vh] flex flex-col gap-10 w-full mt-20">
      <div class="w-full h-full relative">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5576.498410786878!2d8.835578677005344!3d45.665897271078165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478689a1d46f2f7f%3A0x9037d39ca0469c04!2sSacith!5e0!3m2!1sit!2sit!4v1740942968789!5m2!1sit!2sit"
          height="100%"
          width="100%"
          style="border: 0"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          class="rounded-lg"></iframe>
      </div>
      <div class="absolute p-[40px] flex flex-col gap-[62px] bg-white top-1/2 left-[100px] -translate-y-1/2 rounded-md shadow-md" data-animate="fade-up" data-delay="0">
        <div class="flex gap-[92px]">
          <div>
            <h3 class="text-[24px font-medium">Telefono</h3>
            <a href="tel:+390331619011">+39 0331 619011</a>
          </div>
          <div>
            <h3 class="text-[24px font-medium">Orari</h3>
            <p class="max-w-[280px]">Dal lunedì al venerdì dalle dalle 08.30 alle 12.00 e dalle 14:00 alle 18:00</p>
          </div>
        </div>
        <div>
          <h3 class="text-[24px font-medium">La nostra sede</h3>
          <p>Via Luigi Pirandello, 21, 21012 Cassano Magnago (VA)</p>
        </div>
        <div>
          <h3 class="text-[24px font-medium">Social</h3>
        </div>
      </div>

    </section>

    <?php require("footer.php"); ?>
  </main>
</body>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const track = document.getElementById("carousel-track");
    const slides = document.querySelectorAll("#carousel-track > div");
    const indicators = document.querySelectorAll(
      "#first-carousel [data-index]"
    );
    const prevButton3 = document.getElementById("prev3");
    const nextButton3 = document.getElementById("next3");
    let currentIndex = 0;
    let autoSlideTimer;

    function updateCarousel(index) {
      track.style.transform = `translateX(-${index * 100}%)`;
      indicators.forEach((dot, i) => {
        dot.classList.toggle("bg-primary", i === index);
        dot.classList.toggle("bg-gray-400", i !== index);
      });
      currentIndex = index;
    }

    function nextSlide() {
      let nextIndex = (currentIndex + 1) % slides.length;
      updateCarousel(nextIndex);
    }

    function startAutoSlide() {
      autoSlideTimer = setInterval(nextSlide, 3000); // ogni 5 secondi
    }

    function stopAutoSlide() {
      clearInterval(autoSlideTimer);
    }
    indicators.forEach((dot) => {
      dot.addEventListener("click", () => {
        stopAutoSlide();
        updateCarousel(Number(dot.dataset.index));
        startAutoSlide();
      });
    });
    prevButton3.addEventListener("click", () => {
      stopAutoSlide();
      // Spostarsi alla slide precedente, considerando che torniamo alla fine se siamo alla prima slide
      let prevIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateCarousel(prevIndex);
      startAutoSlide();
    });
    nextButton3.addEventListener("click", () => {
      stopAutoSlide();
      // Correct logic to move to next slide or back to the first
      let nextIndex = (currentIndex + 1) % slides.length;
      updateCarousel(nextIndex);
      startAutoSlide();
    });
    // Inizia lo slide automatico
    startAutoSlide();
    //   const track2 = document.getElementById("carousel-track2");
    //   const slides2 = document.querySelectorAll("#carousel-track2 > div");
    //   const indicators2 = document.querySelectorAll(
    //     "#second-carousel [data-index]"
    //   );
    //   let currentIndex2 = 0;
    //   let autoSlideTimer2;
    //   console.log("track 2", track2);
    //   console.log("slides 2", slides2);
    //   function updateCarousel2(index) {
    //     console.log("index", index);
    //     track2.style.transform = `translateX(-${index * 100}%)`;
    //     indicators2.forEach((dot, i) => {
    //       dot.classList.toggle("bg-primary", i === index);
    //       dot.classList.toggle("bg-gray-400", i !== index);
    //     });
    //     currentIndex2 = index;
    //   }
    //   function nextSlide2() {
    //     console.log("slides2 length", slides2.length);
    //     console.log("currentIndex2 + 1", currentIndex2 + 1);
    //     let nextIndex = (currentIndex2 + 1) % slides2.length;
    //     console.log("nextIndex", nextIndex);
    //     updateCarousel2(nextIndex);
    //   }
    //   function startAutoSlide2() {
    //     autoSlideTimer2 = setInterval(nextSlide2, 5000); // ogni 5 secondi
    //   }
    //   function stopAutoSlide2() {
    //     clearInterval(autoSlideTimer2);
    //   }
    //   indicators2.forEach((dot) => {
    //     dot.addEventListener("click", () => {
    //       stopAutoSlide2();
    //       updateCarousel2(Number(dot.dataset.index));
    //       startAutoSlide2();
    //     });
    //   });
    //   console.log(" ");
    //   // Inizia lo slide automatico
    //   updateCarousel2(0);
    //   startAutoSlide2();
    const track2 = document.getElementById("carousel-track2");
    const slides2 = document.querySelectorAll("#carousel-track2 > div");
    const indicators2 = document.querySelectorAll(
      "#second-carousel [data-index]"
    );
    let currentIndex2 = 0;
    let autoSlideTimer2;

    function updateCarousel2(index) {
      track2.style.transform = `translateX(-${index * 100}%)`;
      indicators2.forEach((dot, i) => {
        dot.classList.toggle("bg-primary", i === index);
        dot.classList.toggle("bg-gray-400", i !== index);
      });
      currentIndex2 = index;
    }

    function nextSlide2() {
      const nextIndex = (currentIndex2 + 1) % slides2.length;
      updateCarousel2(nextIndex);
    }

    function startAutoSlide2() {
      autoSlideTimer2 = setInterval(nextSlide2, 3000);
    }

    function stopAutoSlide2() {
      clearInterval(autoSlideTimer2);
    }
    // Aggiungi gestione click indicatori
    indicators2.forEach((dot) => {
      dot.addEventListener("click", () => {
        stopAutoSlide2();
        updateCarousel2(Number(dot.dataset.index));
        startAutoSlide2();
      });
    });
    // Avvio automatico carousel 2
    startAutoSlide2();
    // Avvio iniziale a slide 0
    updateCarousel2(0);

    const track3 = document.getElementById("carousel-track3");
    const slides3 = document.querySelectorAll("#carousel-track3 > div");
    const indicators3 = document.querySelectorAll(
      "#third-carousel [data-index]"
    );
    let currentIndex3 = 0;
    let autoSlideTimer3;

    function updateCarousel3(index) {
      track3.style.transform = `translateX(-${index * 100}%)`;
      indicators3.forEach((dot, i) => {
        dot.classList.toggle("bg-primary", i === index);
        dot.classList.toggle("bg-gray-400", i !== index);
      });
      currentIndex3 = index;
    }

    function nextSlide3() {
      const nextIndex = (currentIndex3 + 1) % slides3.length;
      updateCarousel3(nextIndex);
    }

    function startAutoSlide3() {
      autoSlideTimer3 = setInterval(nextSlide3, 3000);
    }

    function stopAutoSlide3() {
      clearInterval(autoSlideTimer3);
    }
    // Aggiungi gestione click indicatori
    indicators3.forEach((dot) => {
      dot.addEventListener("click", () => {
        stopAutoSlide3();
        updateCarousel3(Number(dot.dataset.index));
        startAutoSlide3();
      });
    });
    // Avvio automatico carousel 2
    startAutoSlide3();
    // Avvio iniziale a slide 0
    updateCarousel3(0);
  });
</script>
<script>
  const imagesContainer = document.querySelector(".carousel-images");
  const images = document.querySelectorAll(".carousel-item");
  const prevButton = document.getElementById("prev");
  const nextButton = document.getElementById("next");
  let currentIndex = 0;

  function updateCarousel() {
    const offset = -currentIndex * 100;
    imagesContainer.style.transform = `translateX(${offset}%)`;
  }
  prevButton.addEventListener("click", () => {
    currentIndex = currentIndex === 0 ? images.length - 1 : currentIndex - 1;
    updateCarousel();
  });
  nextButton.addEventListener("click", () => {
    currentIndex = currentIndex === images.length - 1 ? 0 : currentIndex + 1;
    updateCarousel();
  });
  updateCarousel(); // Initialize the carousel position


  const imagesContainer2 = document.querySelector(".carousel-images2");
  const images2 = document.querySelectorAll(".carousel-item2");
  const prevButton2 = document.getElementById("prev2");
  const nextButton2 = document.getElementById("next2");
  let currentIndex2 = 0;

  function updateCarousel2() {
    const offset = -currentIndex2 * 100;
    imagesContainer2.style.transform = `translateX(${offset}%)`;
  }
  prevButton2.addEventListener("click", () => {
    currentIndex2 =
      currentIndex2 === 0 ? images2.length - 1 : currentIndex2 - 1;
    updateCarousel2();
  });
  nextButton2.addEventListener("click", () => {
    currentIndex2 =
      currentIndex2 === images2.length - 1 ? 0 : currentIndex2 + 1;
    updateCarousel2();
  });
  updateCarousel2(); // Initialize the carousel position
</script>

<script>
  window.addEventListener('load', () => {
    const gallery = document.querySelector('.gallery');
    const galleryWrapper = document.querySelector('.gallery-wrapper');

    // First check if elements exist
    if (!gallery || !galleryWrapper) return;

    // Function to initialize the gallery
    function initGallery() {
      const totalWidth = gallery.scrollWidth;
      const visibleWidth = galleryWrapper.clientWidth;
      let scrollAmount = 0;
      const scrollStep = 1;

      function scrollGallery() {
        if (scrollAmount < totalWidth / 2) { // Only scroll through half (original images)
          scrollAmount += scrollStep;
        } else {
          scrollAmount = 0;
        }
        gallery.style.transform = `translateX(-${scrollAmount}px)`;
      }

      // Clear any existing interval to prevent multiple instances
      if (window.galleryInterval) {
        clearInterval(window.galleryInterval);
      }

      window.galleryInterval = setInterval(scrollGallery, 10);
    }

    // Check if images are already loaded
    const images = gallery.querySelectorAll('img');
    let loadedImages = 0;

    if (images.length === 0) {
      initGallery();
      return;
    }

    images.forEach(img => {
      if (img.complete) {
        loadedImages++;
      } else {
        img.addEventListener('load', () => {
          loadedImages++;
          if (loadedImages === images.length) {
            initGallery();
          }
        });
        img.addEventListener('error', () => {
          loadedImages++; // Count even if error to prevent infinite wait
          if (loadedImages === images.length) {
            initGallery();
          }
        });
      }
    });

    // If all images are already loaded
    if (loadedImages === images.length) {
      initGallery();
    }

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        if (window.galleryInterval) {
          clearInterval(window.galleryInterval);
        }
        initGallery();
      }, 200);
    });
  });
</script>

</html>