<?php
require("translator.php");

function processResult($result, &$array, $parent, $name)
{
    $addedIds = [];
    while ($row = $result->fetch_assoc()) {
        $immagine = $row["immagine"] ?: "https://placehold.co/300x200";
        $descrizione = $row["descrizione"] ?: "";
        $navigazione = $row["navigazione"];
        $navArray = [];

        if ($navigazione) {
            $splitBySlash = explode("/", $navigazione);
            foreach ($splitBySlash as $part) {
                $explodedPart = explode("-", $part);
                $containsParent = false;
                $containsName = false;
                foreach ($explodedPart as $segment) {
                    if ($segment == $parent) {
                        $containsParent = true;
                    }
                    if ($segment == $name) {
                        $containsName = true;
                    }
                }
                if ($containsParent && $containsName) {
                    $navArray[] = $explodedPart;
                }
            }
        }

        if (empty($navArray) && isset($navigazione)) {
            $explodedNavigation = explode("-", $navigazione);
            $containsParent = false;
            $containsName = false;
            foreach ($explodedNavigation as $segment) {
                if ($segment == $parent) {
                    $containsParent = true;
                }
                if ($segment == $name) {
                    $containsName = true;
                }
            }
            if ($containsParent && $containsName) {
                $navArray[] = $explodedNavigation;
            }
        }

        $addProduct = function () use (&$array, $row, $descrizione, $immagine, $navArray, &$addedIds) {
            if (!in_array($row["id"], $addedIds)) {
                $array[] = [
                    "id" => $row["id"],
                    "nome" => $row["nome"],
                    "codice_univoco" => isset($row["codice_univoco"]) ? $row["codice_univoco"] : null,
                    "descrizione" => $descrizione,
                    "immagine" => $immagine,
                    "dimensioni" => isset($row["dimensioni"]) ? $row["dimensioni"] : null,
                    "finiture" => isset($row["finiture"]) ? $row["finiture"] : null,
                    "materiali" => isset($row["materiali"]) ? $row["materiali"] : null,
                    "navigazione" => $navArray
                ];
                $addedIds[] = $row["id"];
            }
        };

        if (strpos($parent, "Shower") !== false) {
            $splitBySlash = explode("/", $navigazione);
            foreach ($splitBySlash as $part) {
                $explodedPart = explode("-", $part);
                $containsName = false;
                foreach ($explodedPart as $segment) {
                    if ($segment == $name) {
                        $containsName = true;
                    }
                }
                if ($containsName) {
                    $addProduct();
                    break;
                }
            }
        } else {
            if (!empty($navArray)) {
                foreach ($navArray as $navPart) {
                    if ((isset($navPart[1]) && $navPart[1] == $parent) || (isset($navPart[0]) && $navPart[0] == $parent)) {
                        $addProduct();
                        break;
                    }
                }
            }
        }
    }
}

function processResultShowerDrains($result, &$array, $parent, $name)
{
    $addedIds = [];
    while ($row = $result->fetch_assoc()) {
        $immagine = $row["immagine"] ?: "https://placehold.co/300x200";
        $descrizione = $row["descrizione"] ?: "";
        $navigazione = $row["navigazione"] ?? "";
        $navSegments = [];

        if (!empty($navigazione)) {
            $parts = explode("/", $navigazione);
            foreach ($parts as $part) {
                $navSegments[] = explode("-", $part);
            }
        }

        $addProduct = function () use (&$array, $row, $descrizione, $immagine, $navSegments, &$addedIds) {
            if (!in_array($row["id"], $addedIds)) {
                $array[] = [
                    "id" => $row["id"],
                    "nome" => $row["nome"],
                    "codice_univoco" => $row["codice_univoco"] ?? null,
                    "descrizione" => $descrizione,
                    "immagine" => $immagine,
                    "dimensioni" => $row["dimensioni"] ?? null,
                    "finiture" => $row["finiture"] ?? null,
                    "materiali" => $row["materiali"] ?? null,
                    "navigazione" => $navSegments
                ];
                $addedIds[] = $row["id"];
            }
        };

        foreach ($navSegments as $path) {
            if (in_array($parent, $path, true)) {
                $addProduct();
                break;
            }
        }
    }
}

function formatName($str)
{
    $str = rawurldecode($str);
    $str = str_replace("-", " ", $str);
    $str = str_replace(" and ", " & ", $str);
    $str = str_replace("_", ", ", $str);
    return ucwords(strtolower($str));
}

function slugifyName($str)
{
    $str = strtolower($str);
    $str = str_replace(" & ", " and ", $str);
    $str = str_replace(", ", "_", $str);
    $str = str_replace(" ", "-", $str);
    return rawurlencode($str);
}

function translateFamily($str, $lang)
{
    $translations = [
        'it' => [
            'Hydromassage' => 'Idromassaggio',
            'Shower Drains' => 'Scarichi Doccia'
        ],
        'en' => [
            'Idromassaggio' => 'Hydromassage',
            'Scarichi Doccia' => 'Shower Drains'
        ]
    ];

    if (!isset($translations[$lang])) {
        $lang = 'it';
    }

    return $translations[$lang][$str] ?? $str;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'it');

    if (isset($_GET['ajax']) && $_GET['ajax'] === 'products') {
        header('Content-Type: application/json');

        $family = $_GET['family'] ?? '';
        $subfamily = $_GET['subfamily'] ?? '';
        $type = $_GET['type'] ?? '';
        $category = $_GET['category'] ?? '';
        $lang = $_GET['lang'] ?? 'it';

        require("config.php");
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbname = "sacith_it";
        $conn = new mysqli($host, $user, $password, $dbname);

        if ($conn->connect_error) {
            echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
            exit;
        }

        $data = [];
        $kit = [];
        $pc = [];

        if (!empty($category)) {
            $parent = !empty($type) ? formatName($type) : formatName($subfamily);
            $name = formatName($category);

            $queries = [
                "ProdottoConfigurabile" => &$pc,
                "Kit" => &$kit,
                "ProdottoSingolo" => &$data
            ];

            foreach ($queries as $table => &$array) {
                $query = "SELECT * FROM $table WHERE navigazione LIKE '%$name%'";
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    processResult($result, $array, $parent, $name);
                }
            }
        }

        if ($family == "shower-drains") {
            $queries = [
                "ProdottoConfigurabile" => &$pc,
                "Kit" => &$kit,
                "ProdottoSingolo" => &$data
            ];

            foreach ($queries as $table => &$array) {
                $query = "SELECT * FROM $table WHERE navigazione LIKE '%Shower Drains%'";
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    processResultShowerDrains($result, $array, "Shower System", $name);
                }
            }
        }

        $conn->close();

        echo json_encode([
            'products' => $data,
            'kits' => $kit,
            'pc' => $pc
        ]);
        exit;
    }

    $parent = isset($_GET['family']) ? formatName($_GET['family']) : '';
    $name = isset($_GET['category']) ? formatName($_GET['category']) : '';

    require("config.php");
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "sacith_it";
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $json_data = 'null';
    $json_kit = 'null';
    $json_pc = 'null';
    $json_nav = 'null';

    $current_family = isset($_GET['family']) ? $_GET['family'] : '';
    $current_subfamily = isset($_GET['subfamily']) ? $_GET['subfamily'] : '';
    $current_type = isset($_GET['type']) ? $_GET['type'] : '';
    $current_category = isset($_GET['category']) ? $_GET['category'] : '';

    if (isset($_GET['category'])) {
        $data = [];
        $kit = [];
        $pc = [];
        $parent = isset($_GET['type']) ? formatName($_GET['type']) : formatName($_GET['subfamily']);
        $name = isset($_GET['category']) ? formatName($_GET['category']) : '';

        $queries = [
            "ProdottoConfigurabile" => &$pc,
            "Kit" => &$kit,
            "ProdottoSingolo" => &$data
        ];

        foreach ($queries as $table => &$array) {
            $query = "SELECT * FROM $table WHERE navigazione LIKE '%$name%'";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                processResult($result, $array, $parent, $name);
            }
        }

        if (!empty($data)) {
            $json_data = json_encode($data);
        }
        if (!empty($kit)) {
            $json_kit = json_encode($kit);
        }
        if (!empty($pc)) {
            $json_pc = json_encode($pc);
        }
    }

    if (isset($_GET['family']) && $_GET['family'] == "shower-drains") {
        $data = [];
        $kit = [];
        $pc = [];

        $queries = [
            "ProdottoConfigurabile" => &$pc,
            "Kit" => &$kit,
            "ProdottoSingolo" => &$data
        ];

        foreach ($queries as $table => &$array) {
            $query = "SELECT * FROM $table WHERE navigazione LIKE '%Shower Drains%'";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                processResultShowerDrains($result, $array, "Shower System", $name);
            }
        }

        if (!empty($data)) {
            $json_data = json_encode($data);
        }
        if (!empty($kit)) {
            $json_kit = json_encode($kit);
        }
        if (!empty($pc)) {
            $json_pc = json_encode($pc);
        }
    }

    $conn->close();
}
?>
<?php
function renderProductsFromPhp($products, $type)
{
    foreach ($products as $item) {
        $imageSrc = getImageSrcFromPhp($item['immagine']);
        $slug = nameToSlug($item['nome']);

        echo '
        <div class="col-span-1 flex flex-col items-center">
            <div class="flex flex-col gap-[10px] items-center product" 
                id="' . $item['id'] . '" 
                data-type="' . $type . '" 
                data-slug="' . $slug . '">
                <img src="' . $imageSrc . '" alt="' . htmlspecialchars($item['nome']) . '" loading="lazy"
                    class="cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg object-cover" />
                <div class="p-4">
                    <h3 class="font-medium text-lg w-[250px] lg:w-[300px] text-center">' . htmlspecialchars($item['nome']) . '</h3>
                </div>
            </div>
        </div>';
    }
}

function getImageSrcFromPhp($immagine)
{
    if (!$immagine) return "https://placehold.co/300x200";

    if (strpos($immagine, "-") !== false) {
        $imageArray = explode("-", $immagine);
        $firstImage = $imageArray[0];
    } else {
        $firstImage = $immagine;
    }

    return $firstImage === "https://placehold.co/300x200" ?
        $firstImage :
        "/public/img/" . $firstImage;
}

function nameToSlug($name)
{
    $slug = str_replace(", ", "_", $name);
    $slug = str_replace("&", "and", $slug);
    $slug = str_replace(" ", "-", $slug);
    return strtolower($slug);
}
?>
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
        content="Excellence Made in Italy! Sacith is an Italian producer of high quality hydro and air components for whirlpool and shower systems, with more than 20 years experience in the market. You can choose between a wide range of jets, pneumatic controls, blowers and fittings. Recently, Sacith developed a complete range of Shower Drains, among them the innovative linear drains with 2 and 3 siphons." />
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sacith s.r.l.">
    <link rel="canonical" href="https://www.sacith.com/">
    <link rel="icon" href="/public/logo/logo_small.png" type="image/png">
    <link rel="stylesheet" href="style.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

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
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Prodotti",
                    "item": "https://www.sacith.com/<?= $lang ?>/product"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "<?= formatName($current_family) ?>",
                    "item": "https://www.sacith.com/<?= $lang ?>/product/<?= $current_family ?>"
                }
                <?php if (!empty($current_subfamily)): ?>,
                    {
                        "@type": "ListItem",
                        "position": 3,
                        "name": "<?= formatName($current_subfamily) ?>",
                        "item": "https://www.sacith.com/<?= $lang ?>/product/<?= $current_family ?>/<?= $current_subfamily ?><?= $current_type ? "/" . $current_type : "" ?>"
                    }
                <?php endif; ?>
                <?php if (!empty($current_category)): ?>,
                    {
                        "@type": "ListItem",
                        "position": <?= !empty($current_subfamily) ? 4 : 3 ?>,
                        "name": "<?= formatName($current_category) ?>",
                        "item": "https://www.sacith.com/<?= $lang ?>/product/<?= $current_family ?>/<?= $current_subfamily ?>/<?= $current_type ? $current_type . "/" . $current_category : $current_category ?>"
                    }
                <?php endif; ?>
            ]
        }
    </script>
</head>

<body class="font-default overflow-x-hidden">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="bg-white">
        <?php require("navbar.php"); ?>
        <div class="relative h-[113px] bg-primary/10 overflow-hidden">
            <div class="h-full h-full bg-[url(/sacith/image/new.svg)] bg-center bg-cover bg-no-repeat opacity-50 lg:opacity-100"></div><span class="absolute left-1/2 lg:left-auto lg:right-0 top-1/2 -translate-y-1/2 -translate-x-1/2 lg:translate-x-0 text-primary text-[36px] lg:text-[44px] font-medium me-20"><?= $page_translations['new'] ?></span>
        </div>
        <div class="mx-[10px] md:mx-[50px] xl:mx-[100px] mt-[26px] h-fit">
            <div data-animate="fade-up" data-delay="0">
                <div>
                    <p class="uppercase text-black/50 font-medium text-[14px]"><?= $page_translations['title'] ?></p>
                    <h1 class="text-black font-medium text-[36px]"><?= isset($_GET['family']) ? translateFamily(formatName($_GET['family']), $lang) : "famiglia"  ?></h1>
                </div>

                <div class=" mb-[64px] flex flex-col gap-5 text-black/50">
                    <p><?= $page_translations['description_1'] ?></p>
                    <p><?= $page_translations['description_2'] ?></p>
                </div>
            </div>
            <div id="product_container">
                <?php if ($_GET['family'] == "hydromassage") {  ?>
                    <div class="flex flex-col lg:flex-row gap-[20px] w-full h-full mb-[80px]" data-animate="fade-up" data-delay="0">
                        <div class="h-full w-full">
                            <div class="relative overflow-hidden h-[120px] border border-black/10 <?= isset($_GET['subfamily']) && $_GET['subfamily'] == "whirlpool-system" ? "border-primary text-primary" : "border-black/10 text-black"  ?> rounded-xl flex justify-center items-end pb-[16px] w-full text-[24px] font-medium transition-all duration-200 hover:border-primary cursor-pointer" data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="air-system"><span class="z-10"><?= $page_translations['whirlpool'] ?></span><!-- <img src="image/h-full.svg" alt="" class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 opacity-30"> --></div>
                            <div class="flex flex-col lg:flex-row gap-[20px] w-full h-[70px] mt-[20px]">
                                <div class="border <?= isset($_GET['type']) && $_GET['type'] == "air-system" ? "border-primary text-primary" : "border-black/10 text-black"  ?> rounded-xl flex justify-center items-center h-full w-full text-[20px] font-medium transition-all duration-200 hover:border-primary cursor-pointer"
                                    data-family="hydromassage"
                                    data-subfamily="whirlpool-system"
                                    data-type="air-system"><?= $page_translations['air_system'] ?></div>
                                <div class="border <?= isset($_GET['type']) && $_GET['type'] == "water-system" ?  "border-primary text-primary" : "border-black/10 text-black"  ?> rounded-xl flex justify-center items-center h-full w-full text-[20px] font-medium transition-all duration-200 hover:border-primary cursor-pointer"
                                    data-family="hydromassage"
                                    data-subfamily="whirlpool-system"
                                    data-type="water-system"><?= $page_translations['water_system'] ?></div>
                            </div>
                        </div>
                        <div class="relative overflow-hidden h-[120px] border <?= isset($_GET['subfamily']) && $_GET['subfamily'] == "shower-system" ?  "border-primary text-primary" : "border-black/10 text-black"  ?> rounded-xl flex justify-center items-end pb-[16px] w-full text-[24px] font-medium transition-all duration-200 hover:border-primary cursor-pointer" data-family="hydromassage"
                            data-subfamily="shower-system"><span class="z-10"><?= $page_translations['shower'] ?></span><!-- <img src="image/s-full.svg" alt="" class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 opacity-30"> --></div>
                    </div>
                <?php  }  ?>
                <?php if (!isset($_GET['category']) && isset($_GET['type']) && $_GET['type'] == "air-system" && $_GET['family'] == "hydromassage") {  ?>
                    <div class="flex flex-col gap-[10px] w-full h-full mx-auto">
                        <div class="flex flex-col lg:flex-row gap-[10px]">
                            <div class="font-medium h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="air-system"
                                data-category="basic-air-kit">Basic Air Kit</div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Air_System/Airjet/Airjet/B_Airjet.jpg)] bg-center bg-cover bg-no-repeat font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="air-system"
                                data-category="airjet">Airjet</div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/B_Blower_Silent_400W.jpg)] bg-center bg-cover bg-no-repeat font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="air-system"
                                data-category="blower">Blower</div>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-[10px]">
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_90%C2%B0/B_Airsystem_Fitting_90%C2%B0.jpg)] bg-center bg-cover bg-no-repeat font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="air-system"
                                data-category="pipes-and-fittings"><?= $page_translations['pipes_fittings'] ?></div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Air_System/Controls/Pneumatic_Push/Round_Pneumatic_Push/B_Round_Pneumatic_Push.jpg)] bg-center bg-cover bg-no-repeat font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="air-system"
                                data-category="controls"><?= $page_translations['controls'] ?></div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_8_Outlet/B_Manifold_8_Outlet.jpg)] bg-center bg-cover bg-no-repeat font-medium h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="air-system"
                                data-category="manifolds"><?= $page_translations['manifolds'] ?></div>
                        </div>
                    </div>
                <?php  }  ?>
                <?php if (!isset($_GET['category']) && isset($_GET['type']) && $_GET['type'] == "water-system" && $_GET['family'] == "hydromassage") {  ?>
                    <div class="flex flex-col gap-[10px] w-full h-full mx-auto">
                        <div class="flex flex-col lg:flex-row gap-[10px]">
                            <div class="h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="basic-hydro-kit">Basic Hydro Kit</div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Water_System/Controls/Sacitronic/B_Sacitronic.jpg)] bg-center bg-cover bg-no-repeat font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="controls"><?= $page_translations['controls'] ?></div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/B_Moon_Jet.png)] bg-center bg-cover font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="jets">Jets</div>

                        </div>
                        <div class="flex flex-col lg:flex-row gap-[10px]">
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Moon_Bi/B_Microjet_Moon_Bi.png)] bg-center bg-cover  font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="microjets">Microjets</div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Water_System/Pumps/Pump/Pump.jpg)] bg-center bg-cover  font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="pumps"><?= $page_translations['pumps'] ?></div>
                            <div class="font-medium h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="microjet-kit">Microjet Kit</div>

                        </div>
                        <div class="flex flex-col lg:flex-row gap-[10px]">
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/B_Suction_Slim.jpg)] bg-center bg-cover  font-medium h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="suctions"><?= $page_translations['suctions'] ?></div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Push_Push_Plug_for_Tank/B_Push_Push_Plug_for_Tank.jpg)] bg-center bg-cover  font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="pipes_fittings-and-disinfection"><?= $page_translations['pipes_fittings_disinfections'] ?></div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Water_System/Controls/Sacitronic/B_Sacitronic.jpg)] bg-center bg-cover  font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="whirlpool-system"
                                data-type="water-system"
                                data-category="manifolds"><?= $page_translations['manifolds'] ?></div>
                        </div>

                    </div>
                <?php  }  ?>
                <?php if (!isset($_GET['category']) && isset($_GET['subfamily']) && $_GET['subfamily'] == "shower-system" && $_GET['family'] == "hydromassage") {  ?>
                    <div class="flex flex-col gap-[10px] w-full h-full mx-auto">
                        <div class="flex flex-col lg:flex-row gap-[10px]">
                            <div class="bg-[url(https://www.sacith.com/public/img/Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_Straight/B_Airsystem_Fitting_Straight.jpg)] bg-center bg-cover font-medium h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="shower-system"
                                data-category="shower-fittings">Shower Fittings</div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Shower_System/Shower_Jets/Minimal_Shower_Jet/B_Minimal_Shower_Jet.jpg)] bg-center bg-cover font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="shower-system"
                                data-category="shower-jets">Shower Jets</div>
                            <div class="bg-[url(https://www.sacith.com/public/img/Shower_System/Steam_Accessories_&_Fittings/Closed_Cap_Steam_Outlet/B_Closed_Cap_Steam_Outlet.jpg)] bg-center bg-cover font-medium h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-end pb-5 transition-all duration-200 hover:border-primary cursor-pointer category"
                                data-family="hydromassage"
                                data-subfamily="shower-system"
                                data-category="steam_accessories-and-fittings">Steam, Accessories & Fittings</div>
                        </div>
                    </div>
                <?php  }  ?>


                <?php if (isset($_GET['category']) && $_GET['family'] == "hydromassage") { ?>

                    <div class="flex flex-col sm:flex-row gap-20 w-screen mt-6">
                        <!-- <div class="flex flex-col gap-[20px] items-start w-fit">

                            <?php
                            $family    = isset($_GET['family']) ? formatName($_GET['family']) : '';
                            $subfamily = isset($_GET['subfamily']) ? formatName($_GET['subfamily']) : '';
                            $type      = isset($_GET['type']) ? formatName($_GET['type']) : '';
                            $category  = isset($_GET['category']) ? formatName($_GET['category']) : '';

                            $nav_list_en = [
                                "Hydromassage" => [
                                    "Whirlpool System" => [
                                        "Air System" => ["Airjet", "Basic Air Kit", "Blower", "Controls", "Manifolds", "Pipes & Fittings"],
                                        "Water System" => ["Basic Hydro Kit", "Controls", "Jets, Suction & Sealings", "Microjet Kit", "Manifolds", "Pipes, Fittings & Disinfection", "Pumps"]
                                    ],
                                    "Shower System" => [
                                        "Shower Fittings",
                                        "Shower Jets",
                                        "Steam, Accessories & Fittings"
                                    ]
                                ]
                            ];

                            $nav_list_it = [
                                "Hydromassage" => [
                                    "Whirlpool System" => [
                                        "Air System" => ["Airjet", "Basic Air Kit", "Blower", "Comandi", "Collettori", "Tubi e Raccordi"],
                                        "Water System" => ["Basic Hydro Kit", "Comandi", "Bocchette", "Microjet Kit", "Collettori", "Tubi, Raccordi & Disinfezione", "Pompe"]
                                    ],
                                    "Shower System" => [
                                        "Raccordi Doccia",
                                        "Bocchette Doccia",
                                        "Vapori, Tubi e Accessori"
                                    ]
                                ]
                            ];

                            $nav_list = $lang == "it" ? $nav_list_it : $nav_list_en;

                            if ($subfamily === "Whirlpool System") {
                                if ($type && isset($nav_list["Hydromassage"]["Whirlpool System"][$type])) {
                                    echo '<ul class="w-fit md:mt-6 space-y-2 md:space-y-6 sm:mt-4 sm:space-y-4">';
                                    foreach ($nav_list["Hydromassage"]["Whirlpool System"][$type] as $item) {
                                        $class = ($category === $item) ? 'text-primary' : 'hover:text-gray-800';
                                        $url = "/sacith/{$lang}/product/"
                                            . slugifyName($family) . "/"
                                            . slugifyName($subfamily) . "/"
                                            . slugifyName($type) . "/"
                                            . slugifyName($item);


                                        echo '<li class="text-nowrap" id="item">';
                                        echo '<a href="javascript:void(0)" 
                                            class="text-sm ' . $class . ' sidebar-link"
                                            data-family="' . htmlspecialchars(slugifyName($family)) . '"
                                            data-subfamily="' . htmlspecialchars(slugifyName($subfamily)) . '"
                                            data-type="' . htmlspecialchars(slugifyName($type)) . '"
                                            data-category="' . htmlspecialchars(slugifyName($item)) . '">' . htmlspecialchars($item) . '</a>';
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                    $json_nav = json_encode($nav_list["Hydromassage"]["Whirlpool System"][$type]);
                                }
                            } elseif ($subfamily === "Shower System") {
                                echo '<ul class="md:mt-6 space-y-2 md:space-y-6 sm:mt-4 sm:space-y-4">';
                                foreach ($nav_list["Hydromassage"]["Shower System"] as $system_name) {
                                    $class = ($category === $system_name) ? 'text-primary' : 'hover:text-gray-800';
                                    $url = "/sacith/{$lang}/product/"
                                        . slugifyName($family) . "/"
                                        . slugifyName($subfamily) . "/"
                                        . slugifyName($system_name);


                                    echo '<li class="text-nowrap" id="item">';
                                    echo '<a href="javascript:void(0)" 
                                        class="text-sm ' . $class . ' sidebar-link"
                                        data-family="' . htmlspecialchars(slugifyName($family)) . '"
                                        data-subfamily="' . htmlspecialchars(slugifyName($subfamily)) . '"
                                        data-category="' . htmlspecialchars(slugifyName($system_name)) . '">' . htmlspecialchars($system_name) . '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                                $json_nav = json_encode($nav_list["Hydromassage"]["Shower System"]);
                            }
                            ?>
                        </div> -->

                        <div class="flex flex-col gap-[20px] items-start w-fit">

                            <?php
                            $family    = isset($_GET['family']) ? formatName($_GET['family']) : '';
                            $subfamily = isset($_GET['subfamily']) ? formatName($_GET['subfamily']) : '';
                            $type      = isset($_GET['type']) ? formatName($_GET['type']) : '';
                            $category  = isset($_GET['category']) ? formatName($_GET['category']) : '';

                            $nav_list_en = [
                                "Hydromassage" => [
                                    "Whirlpool System" => [
                                        "Air System" => ["Airjet", "Basic Air Kit", "Blower", "Controls", "Manifolds", "Pipes & Fittings"],
                                        "Water System" => ["Basic Hydro Kit", "Controls", "Jets", "Suctions", "Microjets", "Microjet Kit", "Manifolds", "Pipes, Fittings & Disinfection", "Pumps"]
                                    ],
                                    "Shower System" => [
                                        "Shower Fittings",
                                        "Shower Jets",
                                        "Steam, Accessories & Fittings"
                                    ]
                                ]
                            ];

                            $nav_list_it = [
                                "Hydromassage" => [
                                    "Whirlpool System" => [
                                        "Air System" => ["Airjet", "Basic Air Kit", "Blower", "Comandi", "Collettori", "Tubi e Raccordi"],
                                        "Water System" => ["Basic Hydro Kit", "Comandi", "Bocchette", "Aspirazioni", "Microjets", "Microjet Kit",  "Collettori", "Tubi, Raccordi & Disinfezione", "Pompe"]
                                    ],
                                    "Shower System" => [
                                        "Raccordi Doccia",
                                        "Bocchette Doccia",
                                        "Vapori, Tubi e Accessori"
                                    ]
                                ]
                            ];

                            $nav_list = $lang == "it" ? $nav_list_it : $nav_list_en;

                            // Funzione per trovare il corrispondente valore in inglese
                            function findEnglishValue($italianValue, $nav_list_it, $nav_list_en)
                            {
                                // Cerca nel Whirlpool System
                                foreach ($nav_list_it["Hydromassage"]["Whirlpool System"] as $type_it => $categories_it) {
                                    if (is_array($categories_it)) {
                                        foreach ($categories_it as $index => $category_it) {
                                            if ($category_it === $italianValue) {
                                                return $nav_list_en["Hydromassage"]["Whirlpool System"][$type_it][$index];
                                            }
                                        }
                                    }
                                }

                                // Cerca nel Shower System
                                foreach ($nav_list_it["Hydromassage"]["Shower System"] as $index => $system_it) {
                                    if ($system_it === $italianValue) {
                                        return $nav_list_en["Hydromassage"]["Shower System"][$index];
                                    }
                                }

                                // Se non trova corrispondenza, restituisce il valore originale
                                return $italianValue;
                            }

                            if ($lang == "it") {
                                $category_compare = findEnglishValue($category, $nav_list_it, $nav_list_en);
                            } else {
                                $category_compare = $category;
                            }

                            if ($subfamily === "Whirlpool System") {
                                if ($type && isset($nav_list["Hydromassage"]["Whirlpool System"][$type])) {
                                    echo '<ul class="w-fit md:mt-6 space-y-2 md:space-y-6 sm:mt-4 sm:space-y-4">';
                                    foreach ($nav_list["Hydromassage"]["Whirlpool System"][$type] as $item) {

                                        // Trova il valore inglese per i data attribute
                                        $item_en = $lang == "it" ? findEnglishValue($item, $nav_list_it, $nav_list_en) : $item;
                                        $type_en = $lang == "it" ? findEnglishValue($type, $nav_list_it, $nav_list_en) : $type;
                                        $subfamily_en = $lang == "it" ? "Whirlpool System" : $subfamily;
                                        $family_en = $lang == "it" ? "Hydromassage" : $family;
                                        $class = ($category_compare === $item_en) ? 'text-primary' : 'hover:text-gray-800';

                                        echo '<li class="text-nowrap" id="item">';
                                        echo '<a href="javascript:void(0)" 
                                            class="text-sm ' . $class . ' sidebar-link"
                                            data-family="' . htmlspecialchars(slugifyName($family_en)) . '"
                                            data-subfamily="' . htmlspecialchars(slugifyName($subfamily_en)) . '"
                                            data-type="' . htmlspecialchars(slugifyName($type_en)) . '"
                                            data-category="' . htmlspecialchars(slugifyName($item_en)) . '">' . htmlspecialchars($item) . '</a>';
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                    $json_nav = json_encode($nav_list["Hydromassage"]["Whirlpool System"][$type]);
                                }
                            } elseif ($subfamily === "Shower System") {
                                echo '<ul class="md:mt-6 space-y-2 md:space-y-6 sm:mt-4 sm:space-y-4">';
                                foreach ($nav_list["Hydromassage"]["Shower System"] as $system_name) {
                                    $system_name_en = $lang == "it" ? findEnglishValue($system_name, $nav_list_it, $nav_list_en) : $system_name;
                                    $subfamily_en = $lang == "it" ? "Shower System" : $subfamily;
                                    $family_en = $lang == "it" ? "Hydromassage" : $family;
                                    $class = ($category_compare === $system_name_en) ? 'text-primary' : 'hover:text-gray-800';

                                    echo '<li class="text-nowrap" id="item">';
                                    echo '<a href="javascript:void(0)" 
                                        class="text-sm ' . $class . ' sidebar-link"
                                        data-family="' . htmlspecialchars(slugifyName($family_en)) . '"
                                        data-subfamily="' . htmlspecialchars(slugifyName($subfamily_en)) . '"
                                        data-category="' . htmlspecialchars(slugifyName($system_name_en)) . '">' . htmlspecialchars($system_name) . '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                                $json_nav = json_encode($nav_list["Hydromassage"]["Shower System"]);
                            }
                            ?>
                        </div>
                        <div class="col-span-8 sm:col-span-7 flex-1 flex flex-col gap-4 justify-center items-center">
                            <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 w-fit justify-center items-center gap-4" id="no_category">
                            </div>
                            <div class="flex flex-col items-start gap-4" id="items_container">
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($_GET['family'] == "shower-drains") { ?>

                    <div class="col-span-8 sm:col-span-7 flex-1 flex flex-col items-center gap-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 4xl:grid-cols-5 w-fit justify-center md:justify-start items-center md:items-start gap-4" id="no_category">
                            <?php
                            if (isset($data) && !empty($data)) {
                                renderProductsFromPhp($data, "singolo");
                            }
                            if (isset($kit) && !empty($kit)) {
                                renderProductsFromPhp($kit, "kit");
                            }
                            if (isset($pc) && !empty($pc)) {
                                renderProductsFromPhp($pc, "pc");
                            }

                            if ((!isset($data) || empty($data)) && (!isset($kit) || empty($kit)) && (!isset($pc) || empty($pc))) {
                                echo '<div class="col-span-full text-center p-8">Nessun prodotto trovato per questa categoria</div>';
                            }
                            ?>
                        </div>
                        <div class="flex flex-col items-start gap-4" id="items_container">
                        </div>
                    </div>

                <?php } ?>
            </div>


            <div id="accordion-flush" class="max-w-[700px] mx-auto mt-[116px]" data-accordion="collapse" data-active-classes="text-[#009FE3]" data-inactive-classes="text-black" data-animate="fade-up" data-delay="0.2">
                <?php
                $faqs = $_GET['family'] == "shower-drains" ? $page_translations['faq_drains'] : $page_translations['faq_whirlpool'];
                $faqCount = count($faqs);

                for ($i = 0; $i < $faqCount; $i++) {
                    $faq = $faqs[$i];
                    $headingId = "accordion-flush-heading-" . ($i + 1);
                    $bodyId = "accordion-flush-body-" . ($i + 1);
                    $isFirst = $i === 0;
                    $expanded = $isFirst ? 'true' : 'false';
                    $iconClass = $isFirst ? 'w-3 h-3 shrink-0' : 'w-3 h-3 rotate-180 shrink-0';
                ?>
                    <h2 id="<?= $headingId ?>" class="<?= $expanded ? 'text-primary' : 'text-gray-500' ?>">
                        <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-start rtl:text-right border-b border-gray-200 gap-3" data-accordion-target="#<?= $bodyId ?>" aria-expanded="<?= $expanded ?>" aria-controls="<?= $bodyId ?>">
                            <span class="flex gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                                <?= htmlspecialchars($faq['question']) ?>
                            </span>
                            <svg data-accordion-icon class="<?= $iconClass ?>" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="<?= $bodyId ?>" class="<?= $isFirst ? '' : 'hidden' ?>" aria-labelledby="<?= $headingId ?>">
                        <div class="py-5 border-b border-gray-200">
                            <p class="text-gray-500"><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>


        </div>

        <div class="bg-primary/5 py-[90px] mt-[115px]">
            <div class="mx-auto flex flex-col items-center gap-[32px]">
                <div class="relative" data-animate="fade-up" data-delay="0">
                    <h2 class="text-primary/20 text-[90px] lg:text-[128px] font-bold"><?= $page_translations['contact_title'] ?></h2>
                    <h3 class="z-10 absolute bottom-10 lg:bottom-14 left-1/2 -translate-x-1/2 text-nowrap text-[#005F88] text-[24px] lg:text-[32px] font-bold"><?= $page_translations['contact_subtitle'] ?></h3>
                </div>
                <p class="text-black/60 text-center" data-animate="fade-up" data-delay="0.2"><?= $page_translations['contact_description'] ?></p>
                <div class="flex flex-col md:flex-row gap-[10px]" data-animate="fade-up" data-delay="0.4">
                    <a href="<?= $lang ?>/contact" class="py-[4px] px-[26px] rounded-md bg-primary rounded-full text-white"><?= $page_translations['contact_btn_info'] ?></a>
                    <a href="<?= $lang ?>/download" class="py-[4px] px-[26px] rounded-md bg-white text-primary border border-primary rounded-full"><?= $page_translations['contact_btn_catalogues'] ?></a>
                </div>
            </div>
        </div>

        <div class="mx-[115px] mt-[90px] flex flex-col gap-[64px]">
            <div class="flex flex-col items-center" data-animate="fade-up" data-delay="0">
                <p class="uppercase text-[12px] text-black/50 font-medium"><?= $page_translations['about_subtitle'] ?></p>
                <h2 class="text-black text-[32px] text-center"><?= $page_translations['about_title'] ?></h2>
            </div>
            <div class="flex gap-[20px] flex-wrap items-center justify-center">
                <div class="flex flex-col gap-[10px] items-center max-w-[390px]" data-animate="fade-up" data-delay="0.2">
                    <h4 class="text-[20px] font-medium text-center"><?= $page_translations['about_excelence_title'] ?></h4>
                    <p class="text-[14px] text-black/50 text-center"><?= $page_translations['about_excelence_description'] ?></p>
                </div>
                <div class="flex flex-col gap-[10px] items-center max-w-[390px]" data-animate="fade-up" data-delay="0.4">
                    <h4 class="text-[20px] font-medium text-center"><?= $page_translations['about_research_title'] ?></h4>
                    <p class="text-[14px] text-black/50 text-center"><?= $page_translations['about_research_description'] ?></p>
                </div>
                <div class="flex flex-col gap-[10px] items-center max-w-[390px]" data-animate="fade-up" data-delay="0.6">
                    <h4 class="text-[20px] font-medium text-center"><?= $page_translations['about_passion_title'] ?></h4>
                    <p class="text-[14px] text-black/50 text-center"><?= $page_translations['about_passion_description'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php require("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.7.0/dist/flowbite.min.js"></script>

</body>

<script>
    let currentAjaxRequest = null;

    function handleDynamicNavigation() {
        document.removeEventListener('click', navigationClickHandler);
        document.addEventListener('click', navigationClickHandler);
    }

    function navigationClickHandler(e) {
        const subfamilyEl = e.target.closest('[data-family]');
        if (subfamilyEl) {
            e.preventDefault();
            e.stopPropagation();

            const family = subfamilyEl.dataset.family;
            const subfamily = subfamilyEl.dataset.subfamily;
            const type = subfamilyEl.dataset.type;
            const category = subfamilyEl.dataset.category;

            navigateTo(family, subfamily, type, category);
            return;
        }

        if (e.target.hasAttribute('onclick') && e.target.getAttribute('onclick').includes('window.location.href')) {
            e.preventDefault();
            e.stopPropagation();

            const onclickContent = e.target.getAttribute('onclick');
            const urlMatch = onclickContent.match(/window\.location\.href\s*=\s*'([^']+)'/);

            if (urlMatch && urlMatch[1]) {
                const url = urlMatch[1];
                navigateByUrl(url);
            }
        }
    }

    function navigateTo(family, subfamily, type, category) {
        const lang = getCookie('lang') || 'en';
        let url = `/sacith/${lang}/product/${family}`;

        if (subfamily) url += `/${subfamily}`;
        if (type) url += `/${type}`;
        if (category) url += `/${category}`;

        loadContentDynamic(url, family, subfamily, type, category);
    }

    function navigateByUrl(fullUrl) {
        const urlParts = fullUrl.split('/');
        const langIndex = urlParts.indexOf('sacith') + 1;
        const productIndex = urlParts.indexOf('product') + 1;

        const lang = urlParts[langIndex] || 'en';
        const family = urlParts[productIndex];
        const subfamily = urlParts[productIndex + 1];
        const type = urlParts[productIndex + 2];
        const category = urlParts[productIndex + 3];

        loadContentDynamic(fullUrl, family, subfamily, type, category);
    }

    function loadContentDynamic(url, family, subfamily, type, category) {
        const container = document.getElementById('product_container');
        container.innerHTML = '<div class="flex justify-center items-center p-8 h-[100dvh]"><div class="animate-spin rounded-full h-7 w-7 border-b-2 border-primary mr-2"></div></div>';

        if (currentAjaxRequest) {
            currentAjaxRequest.abort();
            currentAjaxRequest = null;
        }

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;

                const newContent = tempDiv.querySelector('#product_container');
                if (newContent) {
                    container.innerHTML = newContent.innerHTML;

                    setTimeout(() => {
                        handleDynamicNavigation();

                        if (category) {
                            loadProductsViaAjax(family, subfamily, type, category);
                        }
                    }, 300);

                    window.history.pushState({}, '', url);
                }
            })
            .catch(error => {
                if (error.name !== 'AbortError') {
                    console.error('Error loading content:', error);
                    window.location.href = url;
                }
            });
    }

    function loadProductsViaAjax(family, subfamily, type, category) {
        console.log('Loading products via AJAX for:', {
            family,
            subfamily,
            type,
            category
        });

        if (currentAjaxRequest) {
            currentAjaxRequest.abort();
        }

        const lang = getCookie('lang') || 'en';

        const productsContainer = document.getElementById('items_container');

        if (!productsContainer) {
            console.error('Products container not found');
            return;
        }

        productsContainer.innerHTML = '<div class="flex justify-center items-center p-8 h-[100dvh]"><div class="animate-spin rounded-full h-7 w-7 border-b-2 border-primary mr-2"></div></div>';

        const params = new URLSearchParams({
            ajax: 'products',
            family: family,
            subfamily: subfamily || '',
            type: type || '',
            category: category,
            lang: lang
        });

        const controller = new AbortController();
        currentAjaxRequest = controller;

        fetch(`?${params}`, {
                signal: controller.signal
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('AJAX Products data received:', data);

                currentAjaxRequest = null;

                if (data.error) {
                    productsContainer.innerHTML = '<div class="text-center p-8">' + data.error + '</div>';
                    return;
                }

                const hasProducts = data.products && data.products.length > 0;
                const hasKits = data.kits && data.kits.length > 0;
                const hasPc = data.pc && data.pc.length > 0;

                if (!hasProducts && !hasKits && !hasPc) {
                    productsContainer.innerHTML = '<div class="text-center p-8">No products found</div>';
                    return;
                }

                renderProductsFromAjax(data, family, subfamily, type, category);
            })
            .catch(error => {
                if (error.name !== 'AbortError') {
                    console.error('Error loading products via AJAX:', error);
                    productsContainer.innerHTML = '<div class="text-center p-8 text-red-500">Error loading products</div>';
                    currentAjaxRequest = null;
                }
            });
    }

    function renderProductsFromAjax(data, family, subfamily, type, category) {
        const products = data.products || [];
        const kits = data.kits || [];
        const pc = data.pc || [];

        console.log('Rendering AJAX products:', {
            products,
            kits,
            pc
        });

        const container = document.getElementById("items_container");
        if (container) {
            container.innerHTML = '';
        }
        if (!container) {
            console.error('Items container not found');
            return;
        }

        const allItems = [...products, ...kits, ...pc];

        const subcategory = [];
        allItems.forEach(item => {
            if (item.navigazione && item.navigazione[0]) {
                let productCategory = null;

                if (family === "hydromassage") {
                    if (item.navigazione[0][0] === "Whirlpool System" || item.navigazione[0][0] === "Whirlpool Systems") {
                        productCategory = item.navigazione[0][3];
                    } else {
                        productCategory = item.navigazione[0][2];
                    }
                } else if (family === "shower-drains") {
                    productCategory = item.navigazione[0][2];
                }

                if (!productCategory) {
                    productCategory = 'no_category';
                }

                if (productCategory && productCategory !== 'no_category' && !subcategory.includes(productCategory)) {
                    subcategory.push(productCategory);
                }
            }
        });

        console.log("Subcategories from AJAX:", subcategory);

        const productsGrid = container.querySelector('#no_category');
        if (productsGrid) {
            productsGrid.innerHTML = '';
        }

        const existingCategoryContainers = container.querySelectorAll('[id^="category-"]');
        existingCategoryContainers.forEach(container => container.remove());

        const existingCategoryTitles = container.querySelectorAll('h3');
        existingCategoryTitles.forEach(title => {
            if (title.textContent && subcategory.includes(title.textContent)) {
                title.remove();
            }
        });

        subcategory.forEach(sub => {
            const categoryTitle = document.createElement('h3');
            categoryTitle.className = 'font-medium text-lg text-primary';
            categoryTitle.textContent = sub;
            container.appendChild(categoryTitle);

            const categoryContainer = document.createElement('div');
            categoryContainer.className = 'my-5 grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 justify-center md:justify-start items-center md:items-start gap-1 my-5';
            categoryContainer.id = `category-${sub.replace(/\s+/g, '-')}`;
            container.appendChild(categoryContainer);
        });

        if (subcategory.length === 0) {
            if (!productsGrid) {
                const noCategoryContainer = document.createElement('div');
                noCategoryContainer.className = 'grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 w-fit justify-center items-center gap-4';
                noCategoryContainer.id = 'no_category';
                container.appendChild(noCategoryContainer);
            }
        }

        allItems.forEach(item => {
            let typeItem = "singolo";
            if (pc.includes(item)) {
                typeItem = "pc";
            } else if (kits.includes(item)) {
                typeItem = "kit";
            }

            let productCategory = null;
            if (item.navigazione && item.navigazione[0]) {
                if (family === "hydromassage") {
                    if (item.navigazione[0][0] === "Whirlpool System" || item.navigazione[0][0] === "Whirlpool Systems") {
                        productCategory = item.navigazione[0][3];
                    } else {
                        productCategory = item.navigazione[0][2];
                    }
                } else if (family === "shower-drains") {
                    productCategory = item.navigazione[0][2];
                }
            }

            if (!productCategory) {
                productCategory = 'no_category';
            }

            let categoryId = productCategory !== 'no_category' ? `category-${productCategory.replace(/\s+/g, '-')}` : 'no_category';
            let categoryContainer = document.getElementById(categoryId);

            if (!categoryContainer) {
                categoryContainer = document.getElementById('no_category');
            }

            if (categoryContainer) {
                let image = [];
                if (item.immagine && item.immagine.includes("-")) {
                    image = item.immagine.split('-');
                } else if (Array.isArray(item.immagine)) {
                    image = item.immagine;
                } else {
                    image = [item.immagine || "https://placehold.co/300x200"];
                }

                const imageSrc = image[0] === "https://placehold.co/300x200" ?
                    image[0] :
                    `/public/img/${image[0]}`;

                categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center">
                    <div class="flex flex-col gap-[10px] items-center product" 
                        id="${item.id}" 
                        data-type="${typeItem}" 
                        data-slug="${nameToSlug(item.nome)}">
                        <img src="${imageSrc}" alt="${item.nome}" loading="lazy"
                            class="cursor-pointer w-[250px] h-[150px] 2xl:w-[300px] 2xl:h-[200px] rounded-lg object-cover" />
                        <div class="p-4">
                            <h3 class="font-medium text-lg w-[250px] lg:w-[300px] text-center">${item.nome}</h3>
                        </div>
                    </div>
                </div>`;
            }
        });

        addProductEventListeners();
    }

    function slugToName(slug) {
        return slug
            .replace(/_/g, ', ')
            .replace(/-/g, ' ')
            .replace(/\band\b/gi, '&')
            .replace(/\b\w/g, char => char.toUpperCase());
    }

    function nameToSlug(name) {
        return name
            .replace(/,\s*/g, "_")
            .replace(/&/g, "and")
            .replace(/\s+/g, "-")
            .toLowerCase();
    }

    function addProductEventListeners() {
        const productsCard = document.querySelectorAll(".product");
        productsCard.forEach(product => {
            const newProduct = product.cloneNode(true);
            product.parentNode.replaceChild(newProduct, product);

            newProduct.addEventListener("click", function(e) {
                const type = this.dataset.type;
                const slug = this.dataset.slug;
                const id = this.id;
                const lang = getCookie("lang") || "it";

                const path = window.location.pathname.split('/');
                const currentFamily = path[4];
                const currentSubfamily = path[5];
                const currentType = path[6];
                const currentCategory = path[7];

                let url = "";
                if (currentType) {
                    url = `/sacith/${lang}/product/${currentFamily}/${currentSubfamily}/${currentType}/${currentCategory}/${id}/${slug}?c=${type}`;
                } else {
                    url = `/sacith/${lang}/product/${currentFamily}/${currentSubfamily}/${currentCategory}/${id}/${slug}?c=${type}`;
                }

                window.location.href = url;
            });
        });
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    window.addEventListener('popstate', function(event) {
        const path = window.location.pathname.split('/');
        const family = path[4];
        const subfamily = path[5];
        const type = path[6];
        const category = path[7];

        loadContentDynamic(window.location.href, family, subfamily, type, category);
    });

    document.addEventListener('DOMContentLoaded', function() {
        handleDynamicNavigation();
        handleSidebarNavigation();

        const path = window.location.pathname.split('/');
        const family = path[4];
        const subfamily = path[5];
        const type = path[6];
        const category = path[7];

        setTimeout(() => {
            const existingProducts = document.querySelectorAll('.product');
            console.log('Existing products found on page load:', existingProducts.length);

            if (existingProducts.length > 0) {
                console.log('Products already rendered by PHP, adding event listeners');
                addProductEventListeners();
            } else if (category) {
                console.log('No products found, loading via AJAX');
                loadProductsViaAjax(family, subfamily, type, category);
            }
        }, 100);
    });

    function handleSidebarNavigation() {
        document.addEventListener('click', function(e) {
            const sidebarLink = e.target.closest('.sidebar-link');
            if (sidebarLink) {
                e.preventDefault();
                e.stopPropagation();

                const family = sidebarLink.dataset.family;
                const subfamily = sidebarLink.dataset.subfamily;
                const type = sidebarLink.dataset.type;
                const category = sidebarLink.dataset.category;

                updateSidebarActiveState(category);

                loadProductsViaAjax(family, subfamily, type, category);

                updateBrowserUrl(family, subfamily, type, category);
            }
        });
    }

    function updateSidebarActiveState(activeCategory) {
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            if (link.dataset.category === activeCategory) {
                link.classList.add('text-primary');
                link.classList.remove('hover:text-gray-800');
            } else {
                link.classList.remove('text-primary');
                link.classList.add('hover:text-gray-800');
            }
        });
    }

    function updateBrowserUrl(family, subfamily, type, category) {
        const lang = getCookie('lang') || 'en';
        let url = `/sacith/${lang}/product/${family}`;

        if (subfamily) url += `/${subfamily}`;
        if (type) url += `/${type}`;
        if (category) url += `/${category}`;

        window.history.pushState({}, '', url);
    }
</script>

</html>