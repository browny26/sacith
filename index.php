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
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
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

<body class="relative font-default">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
  <div class="sticky top-0 shadow-md bg-white z-10"><?php require("navbar.php"); ?></div>

  <main class="flex flex-col overflow-hidden">
    <!-- First section -->

    <section
      style="height: calc(90vh - 56px)"
      class="carousel3 relative w-full overflow-hidden h-80 flex items-center justify-center bg-gray-50 mb-20">
      <div
        class="carousel-images3 flex w-full h-full transition-transform duration-500 ease-in-out"
        id="carousel-track">
        <!-- Slide 1 -->
        <div
          class="carousel-item3 min-w-full px-20 h-full flex flex-col md:flex-row items-center justify-center gap-10 xl:gap-20 bg-white text-center">
          <div class="flex flex-col">
            <h2
              class="<?= $lang == "it" ? "text-[45px] md:text-[50px]" : "text-[55px] md:text-[65px]" ?> leading-none text-left font-semibold text-primary flex flex-col">
              <span><?= $page_translations['whirlpool_1'] ?></span>
              <span><?= $page_translations['whirlpool_2'] ?></span>
            </h2>
            <a href="/<?= $lang ?>/product" class="mt-4 bg-primary w-fit text-white px-[22px] py-1 md:px-[32px] md:py-2 rounded-full hover:bg-hover transition">
              <?= $page_translations['hero_btn'] ?>
            </a>
          </div>
          <img
            src="/public/img/home/obj.png"
            alt="whirpool systems"
            class="3xl:w-fit w-[60%] md:w-[40%] h-auto" />
        </div>
        <!-- Slide 2 -->
        <div
          class="carousel-item3 min-w-full h-full px-20 flex flex-col md:flex-row items-center justify-center gap-[120px] bg-white text-center">
          <div class="flex flex-col">
            <h2
              class="text-[55px] md:text-[65px] leading-none text-left font-semibold text-primary flex flex-col">
              <span><?= $page_translations['shower_1'] ?></span>
              <span><?= $page_translations['shower_2'] ?></span>
            </h2>
            <a href="/<?= $lang ?>/product" class="mt-4 bg-primary w-fit text-white px-[22px] py-1 md:px-[32px] md:py-2 rounded-full hover:bg-hover transition">
              <?= $page_translations['hero_btn'] ?>
            </a>
          </div>
          <img
            src="/public/img/home/obj_2.png"
            alt="whirpool systems"
            class="xl:w-fit w-[60%] md:w-[40%] h-auto" />
        </div>
      </div>

      <!-- Controls -->
      <button
        id="prev3"
        class="absolute left-2 top-1/2 -translate-y-1/2 bg-primary text-white px-1 py-2 rounded-full">
        <i class="bi bi-chevron-left"></i>
      </button>
      <button
        id="next3"
        class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary text-white px-1 py-2 rounded-full">
        <i class="bi bi-chevron-right"></i>
      </button>

      <!-- Indicators (pallini) -->
      <div class="absolute bottom-4 flex space-x-2" id="first-carousel">
        <button
          class="w-3 h-3 bg-primary rounded-full"
          data-index="0"></button>
        <button
          class="w-3 h-3 bg-gray-400 rounded-full"
          data-index="1"></button>
      </div>
    </section>

    <!-- Second section -->

    <section class="h-[90vh] w-full overflow-hidden">
      <h1 class="text-primary text-[40px] font-bold ms-10 lg:ms-[115px]">
        <?= $page_translations['new_product_title'] ?>
      </h1>
      <div class="carousel relative w-full" style="height: calc(90vh - 60px)">
        <div
          class="carousel-images flex transition-transform duration-500"
          style="height: calc(90vh - 60px)" id="carousel-track3">
          <!-- Slide 1 -->
          <div
            class="carousel-item flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-between">
            <img
              src="/public/img/home/moon_jet.png"
              class="h-[60%] lg:h-[65%] xl:h-[95%] w-auto object-left-bottom"
              alt="MoonJet" />
            <div
              class="flex flex-col w-full lg:w-fit justify-end items-center lg:items-start pb-10 mb-20 sm:mb-8 lg:mb-0 lg:pb-[120px] lg:pe-[220px]"
              style="height: calc(90vh - 60px)">
              <h2 class="text-[35px] text-primary font-semibold mt-4">
                MoonJet
              </h2>
              <p class="flex flex-col text-lg">
                <span><?= $page_translations['new_product_description_1'] ?></span>
                <span><?= $page_translations['new_product_description_2'] ?></span>
              </p>
              <a href="/<?= $lang ?>/product/water-system/jets/moon-jet?id=38&type=pc"
                class="mt-4 bg-primary w-fit text-white px-[32px] py-2 rounded-full hover:bg-hover transition">
                <?= $page_translations['product_btn'] ?>
              </a>
            </div>
          </div>

          <!-- Slide 2 -->
          <div
            class="carousel-item flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-center lg:justify-between">
            <div class="w-full h-[50%] lg:h-fit flex items-center justify-center">
              <img
                src="/public/img/home/air_jet_moon.png"
                class="h-[50%] lg:h-[80%] w-auto object-left-bottom"
                alt="AirJet Moon" />
            </div>
            <div
              class="flex flex-col w-full lg:w-fit justify-end items-center lg:items-start pb-10 lg:pb-0 lg:pt-[220px] lg:pe-[220px]">
              <h2
                class="text-[35px] text-nowrap w-fit text-primary font-semibold mt-4">
                AirJet Moon
              </h2>
              <p class="flex flex-col text-lg">
                <span><?= $page_translations['new_product_description_1'] ?></span>
                <span><?= $page_translations['new_product_description_2'] ?></span>
              </p>
              <a href="/<?= $lang ?>/product/air-system/airjet/airjet-moon?id=47&type=pc"
                class="mt-4 bg-primary w-fit text-white px-[32px] py-2 rounded-full hover:bg-hover transition">
                <?= $page_translations['product_btn'] ?>
              </a>
            </div>
          </div>

          <!-- Slide 3 -->
          <div
            class="carousel-item flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-center lg:justify-between">
            <div
              class="w-full flex items-center justify-center pb-20 lg:pb-0">
              <img
                src="/public/img/home/micro_jet_moon.png"
                class="h-[60%] lg:h-[80%] w-auto object-left-bottom"
                alt="MicroJet Moon" />
            </div>
            <div
              class="flex flex-col lg:h-full w-full lg:w-fit justify-end items-center lg:items-start pb-10 sm:pb-[120px] lg:pe-[220px]">
              <h2
                class="text-[35px] text-nowrap w-fit text-primary font-semibold mt-4">
                MicroJet Moon
              </h2>
              <p class="flex flex-col text-lg">
                <span><?= $page_translations['new_product_description_1'] ?></span>
                <span><?= $page_translations['new_product_description_2'] ?></span>
              </p>
              <div class="flex gap-5">
                <a href="/<?= $lang ?>/product/water-system/microjets/microjet-moon-st?id=130&type=singolo"
                  class="mt-4 bg-primary w-fit text-white px-[32px] py-2 rounded-full hover:bg-hover transition text-nowrap">
                  <?= $page_translations['version_st'] ?>
                </a>
                <a href="/<?= $lang ?>/product/water-system/microjets/microjet-moon-bi?id=131&type=singolo"
                  class="mt-4 bg-primary w-fit text-white px-[32px] py-2 rounded-full hover:bg-hover transition text-nowrap">
                  <?= $page_translations['version_bi'] ?>
                </a>
              </div>
            </div>
          </div>

          <!-- Slide 4 -->

          <div
            class="carousel-item flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-center lg:justify-between">
            <div
              class="w-full flex items-center justify-center pb-20 lg:pb-0">
              <img
                src="/public/img/home/sacitronic_cover.png"
                class="h-[60%] lg:h-[80%] w-auto object-left-bottom"
                alt="MicroJet Moon" />
            </div>
            <div
              class="flex flex-col lg:h-full w-full lg:w-fit justify-end items-center lg:items-start pb-0 lg:pb-[120px] lg:pe-[120px]">
              <h2
                class="text-[35px] text-nowrap w-fit text-primary font-semibold mt-4">
                Sacitronic cover
              </h2>
              <p class="flex flex-col text-lg">
                <span><?= $page_translations['new_product_description_1'] ?></span>
                <span><?= $page_translations['new_product_description_2'] ?></span>
              </p>
              <a href="/<?= $lang ?>/product/water-system/controls/sacitronic?id=48&type=pc"

                class="mt-4 bg-primary w-fit text-white px-[32px] py-2 rounded-full hover:bg-hover transition">
                <?= $page_translations['product_btn'] ?>
              </a>
            </div>
          </div>

        </div>

        <!-- Controls -->
        <button
          id="prev"
          class="absolute left-2 top-1/2 -translate-y-1/2 bg-primary text-white px-1 py-2 rounded-full">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button
          id="next"
          class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary text-white px-1 py-2 rounded-full">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </section>

    <!-- Third section -->
    <section
      style="height: calc(90vh - 56px)"
      class="relative w-full overflow-hidden flex justify-center items-center mb-20">
      <div
        class="flex w-full h-fit transition-transform duration-500 ease-in-out"
        id="carousel-track2">
        <!-- Slide 1 -->
        <div
          class="min-w-full h-full flex flex-col lg:flex-row items-center lg:items-end justify-center lg:justify-around gap-20 md:gap-7 bg-white text-center">
          <img
            src="/public/img/home/basic_air_kit.png"
            alt="whirpool systems"
            class="lg:w-fit w-[70%]" />
          <div class="flex flex-col">
            <h2
              class="text-[35px] text-left font-semibold text-primary flex flex-col">
              Basic Air Kit
            </h2>
            <p class="flex flex-col text-left">
              <span><?= $page_translations['kit_description_1'] ?></span>
              <span><?= $page_translations['kit_description_2'] ?></span>
            </p>
            <a href="/<?= $lang ?>/product/air-system/basic-air-kit/basic-air-kit?id=17&type=kit"
              class="mt-4 bg-primary w-fit text-white px-[32px] py-2 rounded-full hover:bg-hover transition">
              <?= $page_translations['product_btn'] ?>
            </a>
          </div>
        </div>
        <!-- Slide 2 -->
        <div
          class="min-w-full h-full flex flex-col lg:flex-row items-center lg:items-end justify-center lg:justify-around gap-20 md:gap-7 bg-white text-center">
          <img
            src="/public/img/home/basic_hydro_kit.png"
            alt="whirpool systems"
            class="lg:w-fit w-[70%]" />
          <div class="flex flex-col">
            <h2
              class="text-[35px] text-left font-semibold text-primary flex flex-col">
              Basic Hydro Kit
            </h2>
            <p class="flex flex-col text-left">
              <span><?= $page_translations['kit_description_1'] ?></span>
              <span><?= $page_translations['kit_description_2'] ?></span>
            </p>
            <a href="/<?= $lang ?>/product/water-system/basic-hydro-kit/basic-hydro-kit?id=18&type=kit"
              class="mt-4 bg-primary w-fit text-white px-[32px] py-2 rounded-full hover:bg-hover transition">
              <?= $page_translations['product_btn'] ?>
            </a>
          </div>
        </div>
      </div>

      <!-- Indicators (pallini) -->
      <div class="absolute bottom-4 flex space-x-2" id="second-carousel">
        <button
          class="w-3 h-3 bg-primary rounded-full"
          data-index="0"></button>
        <button
          class="w-3 h-3 bg-gray-400 rounded-full"
          data-index="1"></button>
      </div>
    </section>

    <!-- Fourth section -->
    <section class="h-[70vh] bg-neutral-950 flex flex-col lg:flex-row items-center gap-10 justify-between lg:justify-around">
      <img src="/public/img/home/sacith_lab.png" alt="sacith lab" class="xl:h-full sm:h-[60%] h-fit" />
      <div class="text-white mx-10 flex flex-col gap-3 pb-10 lg:pb-0">
        <div class="flex w-full justify-end">
        </div>
        <h1 class="text-[35px] font-semibold mb-0 leading-none"><?= $page_translations['lab_title'] ?></h1>
        <p class="text-[20px] font-medium"><?= $page_translations['lab_description'] ?></p>
        <div class="flex w-full justify-end">
          <a href="https://sacith-lab.com"
            class="bg-neutral-50 px-[32px] py-2 rounded-full text-nowrap text-neutral-950">
            <?= $page_translations['lab_btn'] ?>
          </a>
        </div>
      </div>
    </section>

    <!-- Fifth section -->

    <section class="h-[90vh] w-full overflow-hidden">
      <div
        class="carousel2 relative w-full"
        style="height: calc(90vh - 60px)">
        <div
          class="carousel-images2 flex transition-transform duration-500"
          style="height: calc(90vh - 60px)">
          <!-- Slide 1 -->
          <div
            class="carousel-item2 relative flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-between">
            <img
              src="/public/img/home/sacith_1.png"
              alt="immagine azienda"
              class="w-full h-full object-cover object-left" />
            <div class="absolute bottom-[47px] left-[50px] md:left-[115px] flex flex-col gap-5">
              <h1 class="<?= $lang == "it" ? "text-[25px] md:text-[44px]" : "text-[34px] md:text-[44px]" ?>  leading-none text-white flex flex-col">
                <span><?= $page_translations['about_title_1'] ?></span><span><?= $page_translations['about_title_2'] ?></span>
              </h1>
              <a href="/<? $lang ?>/about" class="bg-primary px-[32px] w-fit py-2 rounded-full text-nowrap text-white">
                <?= $page_translations['about_btn'] ?>
              </a>
            </div>
          </div>

          <!-- Slide 2 -->
          <div
            class="carousel-item2 relative flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-center lg:justify-between">
            <img
              src="/public/img/home/sacith_2.png"
              alt="immagine azienda"
              class="w-full h-full object-cover object-center" />
            <div class="absolute bottom-[47px] left-[50px] md:left-[115px] flex flex-col gap-5">
              <h1 class="<?= $lang == "it" ? "text-[25px] md:text-[44px]" : "text-[34px] md:text-[44px]" ?> leading-none text-white flex flex-col">
                <span><?= $page_translations['about_title_1'] ?></span><span><?= $page_translations['about_title_2'] ?></span>
              </h1>
              <a href="/<? $lang ?>/about.php" class="bg-primary px-[32px] w-fit py-2 rounded-full text-nowrap text-white">
                <?= $page_translations['about_btn'] ?>
              </a>
            </div>
          </div>

          <!-- Slide 3 -->
          <div
            class="carousel-item2 relative flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-center lg:justify-between">
            <img
              src="/public/img/home/sacith_3.png"
              alt="immagine azienda"
              class="w-full h-full object-cover object-center" />
            <div class="absolute bottom-[47px] left-[50px] md:left-[115px] flex flex-col gap-5">
              <h1 class="<?= $lang == "it" ? "text-[25px] md:text-[44px]" : "text-[34px] md:text-[44px]" ?> leading-none text-white flex flex-col">
                <span><?= $page_translations['about_title_1'] ?></span><span><?= $page_translations['about_title_2'] ?></span>
              </h1>
              <a href="/<? $lang ?>/about.php" class="bg-primary px-[32px] w-fit py-2 rounded-full text-nowrap text-white">
                <?= $page_translations['about_btn'] ?>
              </a>
            </div>
          </div>

          <div
            class="carousel-item2 relative flex-shrink-0 w-full h-full flex lg:flex-row flex-col-reverse items-start lg:items-center justify-center lg:justify-between">
            <img
              src="/public/img/home/sacith_4.png"
              alt="immagine azienda"
              class="w-full h-full object-cover object-center" />
            <div class="absolute bottom-[47px] left-[50px] md:left-[115px] flex flex-col gap-5">
              <h1 class="<?= $lang == "it" ? "text-[25px] md:text-[44px]" : "text-[34px] md:text-[44px]" ?> leading-none text-white flex flex-col">
                <span><?= $page_translations['about_title_1'] ?></span><span><?= $page_translations['about_title_2'] ?></span>
              </h1>
              <a href="/<? $lang ?>/about.php" class="bg-primary px-[32px] w-fit py-2 rounded-full text-nowrap text-white">
                <?= $page_translations['about_btn'] ?>
              </a>
            </div>
          </div>
        </div>

        <!-- Controls -->
        <button
          id="prev2"
          class="absolute left-2 top-1/2 -translate-y-1/2 bg-primary text-white px-1 py-2 rounded-full">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button
          id="next2"
          class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary text-white px-1 py-2 rounded-full">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </section>

    <!-- Sixth section -->

    <section class="h-fit flex flex-col container mx-auto gap-10">
      <h1 class="text-[36px] md:text-[46px] font-semibold text-primary ps-10"><?= $page_translations['values_title'] ?></h1>

      <div class="w-full overflow-x-hidden gallery-wrapper">
        <!-- Flex interno per le immagini, gap regolato -->
        <div class="flex gap-6 min-w-max gallery ms-[120px]">
          <!-- Immagini originali -->
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_1.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_1'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_2.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_2'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_3.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_3'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_4.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_4'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_5.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_5'] ?></h1>
          </div>

          <!-- Duplicato delle immagini per il loop infinito -->
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_1.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_1'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_2.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_2'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_3.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_3'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_4.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_4'] ?></h1>
          </div>
          <div class="relative w-[390px] md:w-[490px] h-[308px] md:h-[408px] flex-shrink-0">
            <img
              src="/public/img/home/values_5.png"
              alt="immagine azienda"
              class="w-[390px] md:w-[490px] h-[308px] md:h-[408px] object-cover rounded-lg" />
            <h1 class="text-[35px] absolute bottom-[10px] left-[20px] text-white"><?= $page_translations['values_5'] ?></h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Seventh section -->

    <section class="h-[90vh] flex flex-col gap-10 px-10 container mx-auto w-full mt-20">
      <h1 class="text-primary text-[30px] md:text-[40px] font-semibold">
        <?= $page_translations['maps_title'] ?>
      </h1>
      <div class="w-full h-[80%] relative">
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