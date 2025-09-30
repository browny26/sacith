<?php require("translator.php") ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    /* foreach ($_GET as $key => $value) {
        echo "Parametro: $key - Valore: $value<br>";
        } */
    $lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'it');
    function formatName($str)
    {
        $str = rawurldecode($str);             // decode %20
        $str = str_replace("-", " ", $str);    // trattini -> spazi
        $str = str_replace(" and ", " & ", $str);    // trattini -> spazi
        $str = str_replace("_", ", ", $str);    // trattini -> spazi
        return ucwords(strtolower($str));      // Air System
    }

    function slugifyName($str)
    {
        $str = strtolower($str);                  // minuscolo
        $str = str_replace(" & ", " and ", $str); // & -> and
        $str = str_replace(", ", "_", $str);      // virgole -> underscore
        $str = str_replace(" ", "-", $str);       // spazi -> trattini
        return rawurlencode($str);                // encode caratteri speciali
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

        // Se la lingua non esiste, fallback su italiano
        if (!isset($translations[$lang])) {
            $lang = 'it';
        }

        return $translations[$lang][$str] ?? $str; // ritorna la traduzione oppure la stringa originale
    }


    $parent = isset($_GET['family']) ? formatName($_GET['family']) : '';
    $name = isset($_GET['category']) ? formatName($_GET['category']) : '';
    require("config.php");
    //$conn = new mysqli($host, $username, $password, (isset($_COOKIE['lang']) && $_COOKIE['lang'] == 'en' ? $db_name : $db_name_it));
    /* $db_to_use = ($lang === 'en') ? $db_name : $db_name_it; */
    $host = "localhost";
    $user = "root";       // utente di XAMPP
    $password = "";       // di default la password è vuota
    $dbname = "sacith_it";   // il nome del database che hai creato
    $conn = new mysqli($host, $user, $password, $dbname);
    //$conn = new mysqli($host, $username, $password, $db_to_use);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
    // Inizializza gli array
    function processResult($result, &$array, $parent, $name)
    {
        $addedIds = [];  // Tiene traccia degli ID già aggiunti

        while ($row = $result->fetch_assoc()) {
            $immagine = $row["immagine"] ?: "https://placehold.co/300x200";
            $descrizione = $row["descrizione"] ?: "";
            $navigazione = $row["navigazione"];
            $navArray = [];

            if ($navigazione) {
                $splitBySlash = explode("/", $navigazione);
                // Itera su ciascuna parte separata da "/"
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

            // Se la navigazione non contiene "/", gestisci normalmente
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

            // Funzione per aggiungere prodotto se non duplicato
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

            // Se il parent contiene "Shower" usa questa logica speciale
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
                        // aggiungi prodotto solo se non duplicato
                        $addProduct();
                        break; // basta una volta
                    }
                }
            } else {
                // Logica standard per aggiungere prodotto
                if (!empty($navArray)) {
                    foreach ($navArray as $navPart) {
                        if ((isset($navPart[1]) && $navPart[1] == $parent) || (isset($navPart[0]) && $navPart[0] == $parent)) {
                            $addProduct();
                            break; // basta una volta
                        }
                    }
                }
            }
        }
    }

    function processResultShowerDrains($result, &$array, $parent, $name)
    {
        $addedIds = [];  // Tiene traccia degli ID già aggiunti

        while ($row = $result->fetch_assoc()) {
            $immagine = $row["immagine"] ?: "https://placehold.co/300x200";
            $descrizione = $row["descrizione"] ?: "";
            $navigazione = $row["navigazione"] ?? "";

            // Trasforma la stringa in array di segmenti (split su "/" e poi su "-")
            $navSegments = [];
            if (!empty($navigazione)) {
                $parts = explode("/", $navigazione);
                foreach ($parts as $part) {
                    $navSegments[] = explode("-", $part);
                }
            }

            // Funzione per aggiungere prodotto se non duplicato
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
                        "navigazione" => $navSegments // ✅ qui hai un array di segmenti
                    ];
                    $addedIds[] = $row["id"];
                }
            };

            // Controllo se $parent è dentro i segmenti
            foreach ($navSegments as $path) {
                if (in_array($parent, $path, true)) {
                    $addProduct();
                    break;
                }
            }
        }
    }

    if (isset($_GET['category'])) {
        // Decodifica e pulizia
        $data = [];
        $kit = [];
        $pc = [];
        $parent = isset($_GET['type']) ? formatName($_GET['type']) : formatName($_GET['subfamily']);
        $name = isset($_GET['category']) ? formatName($_GET['category']) : '';


        $queries = [
            ["SELECT * FROM ProdottoConfigurabile WHERE navigazione LIKE  '%$name%'", &$pc],
            ["SELECT * FROM Kit WHERE navigazione LIKE  '%$name%'", &$kit],
            ["SELECT * FROM ProdottoSingolo WHERE navigazione LIKE  '%$name%'", &$data]
        ];
        foreach ($queries as [$query, &$array]) {
            $result = $conn->query($query);
            //echo $result;
            if ($result && $result->num_rows > 0) {
                //print_r($query);
                processResult($result, $array, $parent, $name);
            }
        }
        $conn->close();
        // Se almeno un array contiene dati, restituisci il JSON
        if (!empty($data)) {
            $json_data = json_encode($data);
            //print_r($data);
        }
        if (!empty($kit)) {
            $json_kit = json_encode($kit);
            //print_r($kit);
        }
        if (!empty($pc)) {
            $json_pc = json_encode($pc);
            //print_r($pc);
        }
    }

    if ($_GET['family'] == "shower-drains") {
        $data = [];
        $kit = [];
        $pc = [];
        $queries = [
            ["SELECT * FROM ProdottoConfigurabile WHERE navigazione LIKE  '%Shower Drains%'", &$pc],
            ["SELECT * FROM Kit WHERE navigazione LIKE  '%Shower Drains%'", &$kit],
            ["SELECT * FROM ProdottoSingolo WHERE navigazione LIKE  '%Shower Drains%'", &$data]
        ];
        foreach ($queries as [$query, &$array]) {
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                /* print_r($row = $result->fetch_assoc());
                echo "<br>";
                echo "<br>"; */
                processResultShowerDrains($result, $array, "Shower System", $name);
            }
        }
        $conn->close();
        // Se almeno un array contiene dati, restituisci il JSON
        if (!empty($data)) {
            $json_data = json_encode($data);
            //print_r($data);
        }
        if (!empty($kit)) {
            $json_kit = json_encode($kit);
            //print_r($kit);
        }
        if (!empty($pc)) {
            $json_pc = json_encode($pc);
            //print_r($pc);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<?php require("head.php") ?>

<body class="font-default">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="bg-white">
        <?php require("navbar.php"); ?>
        <div class="relative h-[264px] bg-primary/10 overflow-hidden">
            <div class="h-full h-full bg-[url(image/new.svg)] bg-center bg-cover bg-no-repeat opacity-50 lg:opacity-100"></div><span class="absolute left-1/2 lg:left-auto lg:right-0 top-1/2 -translate-y-1/2 -translate-x-1/2 lg:translate-x-0 text-primary text-[36px] lg:text-[50px] font-bold me-20"><?= $page_translations['new'] ?></span>
        </div>
        <div class="mx-[10px] lg:mx-[115px] mt-[26px] h-fit">

            <div class="flex flex-col gap-[4px]">
                <p class="uppercase text-[12px] text-primary/50 font-semibold"><?= $page_translations['title'] ?></p>
                <h1 class="capitalize font-semibold text-[36px] text-primary"><?= isset($_GET['family']) ? translateFamily(formatName($_GET['family']), $lang) : "famiglia"  ?></h1>
            </div>

            <p class="mt-[32px] mb-[64px]"><?= $page_translations['description'] ?></p>

            <?php if ($_GET['family'] == "hydromassage") {  ?>
                <div class="flex flex-col lg:flex-row gap-[20px] w-full h-full mb-[80px]">
                    <div class="h-full w-full">
                        <div class="relative overflow-hidden h-[120px] border border-black/10 <?= isset($_GET['subfamily']) && $_GET['subfamily'] == "whirlpool-system" ? "border-primary" : "border-black/10"  ?> rounded-xl flex justify-center items-end pb-[16px] w-full text-[24px] text-primary font-semibold transition-all duration-200 hover:border-primary cursor-pointer" onclick="window.location.href = '/sacith/<?= $_COOKIE['lang'] ?>/product/hydromassage/whirlpool-system/air-system'"><span class="z-10"><?= $page_translations['whirlpool'] ?></span><img src="image/h-full.svg" alt="" class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 opacity-30"></div>
                        <div class="flex flex-col lg:flex-row gap-[20px] w-full h-[70px] mt-[20px]">
                            <div class="border <?= isset($_GET['type']) && $_GET['type'] == "air-system" ? "border-primary" : "border-black/10"  ?> rounded-xl flex justify-center items-center h-full w-full text-[20px] text-primary font-semibold transition-all duration-200 hover:border-primary cursor-pointer" onclick="window.location.href = '/sacith/<?= $_COOKIE['lang'] ?>/product/hydromassage/whirlpool-system/air-system'"><?= $page_translations['air_system'] ?></div>
                            <div class="border <?= isset($_GET['type']) && $_GET['type'] == "water-system" ? "border-primary" : "border-black/10"  ?> rounded-xl flex justify-center items-center h-full w-full text-[20px] text-primary font-semibold transition-all duration-200 hover:border-primary cursor-pointer" onclick="window.location.href = '/sacith/<?= $_COOKIE['lang'] ?>/product/hydromassage/whirlpool-system/water-system'"><?= $page_translations['water_system'] ?></div>
                        </div>
                    </div>
                    <div class="relative overflow-hidden h-[120px] border <?= isset($_GET['subfamily']) && $_GET['subfamily'] == "shower-system" ? "border-primary" : "border-black/10"  ?> rounded-xl flex justify-center items-end pb-[16px] w-full text-[24px] text-primary font-semibold transition-all duration-200 hover:border-primary cursor-pointer" onclick="window.location.href = '/sacith/<?= $_COOKIE['lang'] ?>/product/hydromassage/shower-system'"><span class="z-10"><?= $page_translations['shower'] ?></span><img src="image/s-full.svg" alt="" class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 opacity-30"></div>
                </div>
            <?php  }  ?>
            <?php if (!isset($_GET['category']) && isset($_GET['type']) && $_GET['type'] == "air-system" && $_GET['family'] == "hydromassage") {  ?>
                <div class="flex flex-col gap-[10px] w-full h-full mx-auto">
                    <div class="flex flex-col lg:flex-row gap-[10px]">
                        <div class="h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="basic-air-kit">Basic Air Kit</div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="airjet">Airjet</div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="blower">Blower</div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-[10px]">
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="pipes-and-fittings"><?= $page_translations['pipes_fittings'] ?></div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="controls"><?= $page_translations['controls'] ?></div>
                        <div class="h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="manifolds">Manifolds</div>
                    </div>
                </div>
            <?php  }  ?>
            <?php if (!isset($_GET['category']) && isset($_GET['type']) && $_GET['type'] == "water-system" && $_GET['family'] == "hydromassage") {  ?>
                <div class="flex flex-col gap-[10px] w-full h-full mx-auto">
                    <div class="flex flex-col lg:flex-row gap-[10px]">
                        <div class="h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="basic-hydro-kit">Basic Hydro Kit</div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="controls"><?= $page_translations['controls'] ?></div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="jets_suctions-and-sealings">Jets, Suction & Sealings</div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-[10px]">
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="pumps"><?= $page_translations['pumps'] ?></div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="microjet-kit">Microjet Kit</div>
                        <div class="h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="pipes_fittings-and-disinfection"><?= $page_translations['pipes_fittings_disinfections'] ?></div>
                    </div>
                </div>
            <?php  }  ?>
            <?php if (!isset($_GET['category']) && isset($_GET['subfamily']) && $_GET['subfamily'] == "shower-system" && $_GET['family'] == "hydromassage") {  ?>
                <div class="flex flex-col gap-[10px] w-full h-full mx-auto">
                    <div class="flex flex-col lg:flex-row gap-[10px]">
                        <div class="h-[276px] w-full lg:flex-1 border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="shower-fittings">Shower Fittings</div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="shower-jets">Shower Jets</div>
                        <div class="h-[276px] w-full lg:w-[335px] border border-black/10 rounded-xl flex justify-center items-center transition-all duration-200 hover:border-primary cursor-pointer category" data-category="steam_accessories-and-fittings">Steam, Accessories & Fittings</div>
                    </div>
                </div>
            <?php  }  ?>

            <?php if (isset($_GET['category']) && $_GET['family'] == "hydromassage") { ?>

                <div class="flex flex-col md:flex-row gap-10 w-screen mt-6">
                    <div class="flex flex-col gap-[20px] items-start w-fit">

                        <?php
                        $family    = isset($_GET['family']) ? formatName($_GET['family']) : '';
                        $subfamily = isset($_GET['subfamily']) ? formatName($_GET['subfamily']) : '';
                        $type      = isset($_GET['type']) ? formatName($_GET['type']) : '';
                        $category  = isset($_GET['category']) ? formatName($_GET['category']) : '';

                        // Lista gerarchica
                        $nav_list_en = [
                            "Hydromassage" => [
                                "Whirlpool System" => [
                                    "Air System" => ["Airjet", "Basic Air Kit", "Blower", "Controls", "Manifolds", "Pipes & Fittings"],
                                    "Water System" => ["Basic Hydro Kit", "Controls", "Jets, Suction & Sealings", "Microjet Kit", "Pipes, Fittings & Disinfection", "Pumps"]
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
                                    "Water System" => ["Basic Hydro Kit", "Comandi", "Bocchette", "Microjet Kit", "Tubi, Raccordi & Disinfezione", "Pompe"]
                                ],
                                "Shower System" => [
                                    "Raccordi Doccia",
                                    "Bocchette Doccia",
                                    "Vapori, Tubi e Accessori"
                                ]
                            ]
                        ];

                        $nav_list = $lang == "it" ? $nav_list_it : $nav_list_en;

                        // Se siamo in Whirlpool System
                        if ($subfamily === "Whirlpool System") {
                            // Se è selezionato Air o Water System, mostra i rispettivi elementi
                            if ($type && isset($nav_list["Hydromassage"]["Whirlpool System"][$type])) {
                                echo '<ul class="w-fit md:mt-6 space-y-2 md:space-y-6 sm:mt-4 sm:space-y-4">';
                                foreach ($nav_list["Hydromassage"]["Whirlpool System"][$type] as $item) {
                                    $class = ($category === $item) ? 'text-primary' : 'hover:text-gray-800';
                                    // Costruzione dinamica dell'URL
                                    $url = "/sacith/{$lang}/product/"
                                        . slugifyName($family) . "/"
                                        . slugifyName($subfamily) . "/"
                                        . slugifyName($type) . "/"
                                        . slugifyName($item);


                                    echo '<li class="text-nowrap" id="item">';
                                    echo '<a href="' . $url . '" class="text-sm ' . $class . '">' . htmlspecialchars($item) . '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                                $json_nav = json_encode($nav_list["Hydromassage"]["Whirlpool System"][$type]);
                            }
                        }

                        // Se siamo in Shower System
                        elseif ($subfamily === "Shower System") {
                            echo '<ul class="md:mt-6 space-y-2 md:space-y-6 sm:mt-4 sm:space-y-4">';
                            foreach ($nav_list["Hydromassage"]["Shower System"] as $system_name) {
                                $class = ($category === $system_name) ? 'text-primary' : 'hover:text-gray-800';
                                // URL per Shower System (non c’è type)
                                $url = "/sacith/{$lang}/product/"
                                    . slugifyName($family) . "/"
                                    . slugifyName($subfamily) . "/"
                                    . slugifyName($system_name);


                                echo '<li class="text-nowrap" id="item">';
                                echo '<a href="' . $url . '" class="text-sm ' . $class . '">' . htmlspecialchars($system_name) . '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            $json_nav = json_encode($nav_list["Hydromassage"]["Shower System"]);
                        }
                        ?>
                    </div>
                    <div class="col-span-8 sm:col-span-7 flex-1 flex flex-col gap-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 w-fit justify-center md:justify-start items-center md:items-start gap-4" id="no_category">
                        </div>
                        <div class="flex flex-col items-start gap-4" id="product_container">
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($_GET['family'] == "shower-drains") { ?>

                <div class="col-span-8 sm:col-span-7 flex-1 flex flex-col gap-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 w-fit justify-center md:justify-start items-center md:items-start gap-4" id="no_category">
                    </div>
                    <div class="flex flex-col items-start gap-4" id="product_container">
                    </div>
                </div>

            <?php } ?>


            <div id="accordion-flush" class="max-w-[700px] mx-auto mt-[116px]" data-accordion="collapse" data-active-classes="text-[#009FE3]" data-inactive-classes="text-black">
                <h2 id="accordion-flush-heading-1">
                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
                        <span class="flex gap-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            What is Flowbite?</span>
                        <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                    <div class="py-5 border-b border-gray-200">
                        <p class="mb-2 text-gray-500">Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
                        <p class="text-gray-500">Check out this guide to learn how to <a href="/docs/getting-started/introduction/" class="text-blue-600 dark:text-blue-500 hover:underline">get started</a> and start developing websites even faster with components on top of Tailwind CSS.</p>
                    </div>
                </div>
                <h2 id="accordion-flush-heading-2">
                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                        <span class="flex gap-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            Is there a Figma file available?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                    <div class="py-5 border-b border-gray-200">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is first conceptualized and designed using the Figma software so everything you see in the library has a design equivalent in our Figma file.</p>
                        <p class="text-gray-500 dark:text-gray-400">Check out the <a href="https://flowbite.com/figma/" class="text-blue-600 dark:text-blue-500 hover:underline">Figma design system</a> based on the utility classes from Tailwind CSS and components from Flowbite.</p>
                    </div>
                </div>
                <h2 id="accordion-flush-heading-3">
                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                        <span class="flex gap-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            What are the differences between Flowbite and Tailwind UI?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                    <div class="py-5 border-b border-gray-200">
                        <p class="mb-2 text-gray-500">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
                        <p class="mb-2 text-gray-500">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
                        <p class="mb-2 text-gray-500">Learn more about these technologies:</p>
                        <ul class="ps-5 text-gray-500 list-disc">
                            <li><a href="https://flowbite.com/pro/" class="text-blue-600 hover:underline">Flowbite Pro</a></li>
                            <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 dark:text-blue-500 hover:underline">Tailwind UI</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-primary/5 py-[90px] mt-[115px]">
            <div class="mx-auto flex flex-col items-center gap-[32px]">
                <div class="relative">
                    <h2 class="text-primary/20 text-[90px] lg:text-[128px] font-bold"><?= $page_translations['contact_title'] ?></h2>
                    <h3 class="z-10 absolute bottom-10 lg:bottom-14 left-1/2 -translate-x-1/2 text-nowrap text-[#005F88] text-[24px] lg:text-[32px] font-bold"><?= $page_translations['contact_subtitle'] ?></h3>
                </div>
                <p class="text-black/60 text-center"><?= $page_translations['contact_description'] ?></p>
                <div class="flex flex-col md:flex-row gap-[10px]">
                    <button class="px-[30px] py-[10px] bg-primary rounded-full text-white"><?= $page_translations['contact_btn_info'] ?></button>
                    <button class="px-[30px] py-[10px] text-primary border border-primary rounded-full"><?= $page_translations['contact_btn_catalogues'] ?></button>
                </div>
            </div>
        </div>

        <div class="mx-[115px] mt-[90px] flex flex-col gap-[64px]">
            <div class="flex flex-col items-center">
                <p class="uppercase text-[12px] text-primary/50 font-semibold"><?= $page_translations['about_subtitle'] ?></p>
                <h2 class="text-primary text-[32px] text-center"><?= $page_translations['about_title'] ?></h2>
            </div>
            <div class="flex gap-[18px] flex-wrap items-center justify-center">
                <div class="flex flex-col gap-[10px] items-center max-w-[390px]">
                    <h4 class="text-[20px] text-primary font-semibold text-center"><?= $page_translations['about_excelence_title'] ?></h4>
                    <p class="text-[14px] font-medium text-center"><?= $page_translations['about_excelence_description'] ?></p>
                </div>
                <div class="flex flex-col gap-[10px] items-center max-w-[390px]">
                    <h4 class="text-[20px] text-primary font-semibold text-center"><?= $page_translations['about_research_title'] ?></h4>
                    <p class="text-[14px] font-medium text-center"><?= $page_translations['about_research_description'] ?></p>
                </div>
                <div class="flex flex-col gap-[10px] items-center max-w-[390px]">
                    <h4 class="text-[20px] text-primary font-semibold text-center"><?= $page_translations['about_passion_title'] ?></h4>
                    <p class="text-[14px] font-medium text-center"><?= $page_translations['about_passion_description'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php require("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.7.0/dist/flowbite.min.js"></script>

</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    const categories = document.querySelectorAll(".category");
    const family = '<?= isset($_GET['family']) ? $_GET['family'] : '' ?>';
    const subfamily = '<?= isset($_GET['subfamily']) ? $_GET['subfamily'] : '' ?>';
    const type = '<?= isset($_GET['type']) ? $_GET['type'] : '' ?>';

    categories.forEach((category, index) => {
        category.addEventListener("click", () => {
            const lang = document.documentElement.lang || 'en';
            const dataset = category.dataset.category;

            let url = `/sacith/${lang}/product/${family}/${subfamily}${type ? '/' + type + '/'  : '/'}${dataset}`;

            setTimeout(() => {
                window.location.href = url;
            }, 200);
        })

    })
</script>
<script type="text/javascript">
    const products = <?php echo isset($json_data) ? $json_data : 'null'; ?>;
    const kits = <?php echo isset($json_kit) ? $json_kit : 'null'; ?>;
    const pc = <?php echo isset($json_pc) ? $json_pc : 'null'; ?>;
    const nav = <?php echo isset($json_nav) ? $json_nav : 'null'; ?>;
    const category = '<?= isset($_GET['category']) ? $_GET['category'] : '' ?>';
    const container = document.getElementById("product_container");

    console.log("NAV: ", nav);

    console.log("pc: ", pc)
    console.log("kits: ", kits)
    console.log("products: ", products)

    function slugToName(slug) {
        return slug
            .replace(/_/g, ', ') // sostituisce "_" con ", "
            .replace(/-/g, ' ') // sostituisce "-" con spazio
            .replace(/\band\b/gi, '&') // "and" → "&" (ignora maiuscole/minuscole)
            .replace(/\b\w/g, char => char.toUpperCase()); // prima lettera maiuscola
    }

    function nameToSlug(name) {
        return name
            .replace(/,\s*/g, "_") // ", " → "_"
            .replace(/&/g, "and") // "&" → "and"
            .replace(/\s+/g, "-") // spazi → "-"
            .toLowerCase(); // tutto minuscolo
    }


    const readableType = slugToName(type);
    const readableCategory = slugToName(category);
    const readablefamily = slugToName(family);

    console.log(readableType); // "Water System"
    console.log(readablefamily); // "Water System"

    items = []
    subcategory = []

    if (readablefamily !== "Shower Drains") {
        if (pc && pc.length > 0) {
            pc.forEach(p => {
                if (type) {
                    if (p.navigazione[0][1] == readableType) {
                        items.push(p)
                    }
                } else {
                    if (p.navigazione[0][1] == readableCategory) {
                        items.push(p)
                    }
                }
                if (p.navigazione[0][3] && !subcategory.includes(p.navigazione[0][3])) {
                    subcategory.push(p.navigazione[0][3])
                }
            });
        }

        if (products && products.length > 0) {
            products.forEach(prodotto => {
                if (prodotto.navigazione[0][1] == readableType) {
                    items.push(prodotto)
                } else {
                    if (prodotto.navigazione[0][1] == readableCategory) {
                        items.push(prodotto)
                    }
                }
                if (prodotto.navigazione[0][3] && !subcategory.includes(prodotto.navigazione[0][3])) {
                    subcategory.push(prodotto.navigazione[0][3])
                }
            });
        }

        if (kits && kits.length > 0) {
            kits.forEach(kit => {
                if (kit.navigazione[0][1] == readableType) {
                    items.push(kit)
                } else {
                    if (kit.navigazione[0][1] == readableCategory) {
                        items.push(kit)
                    }
                }
                if (kit.navigazione[0][3] && !subcategory.includes(kit.navigazione[0][3])) {
                    subcategory.push(kit.navigazione[0][3])
                }
            });
        }
    } else {
        if (pc && pc.length > 0) {
            pc.forEach(p => {

                if (p.navigazione[0][1] == readablefamily) {
                    items.push(p)
                }
                if (p.navigazione[0][2] && !subcategory.includes(p.navigazione[0][2])) {
                    subcategory.push(p.navigazione[0][2])
                }
            });
        }

        if (products && products.length > 0) {
            products.forEach(prodotto => {

                if (prodotto.navigazione[0][1] == readablefamily) {
                    items.push(prodotto)
                }

                if (prodotto.navigazione[0][2] && !subcategory.includes(prodotto.navigazione[0][2])) {
                    subcategory.push(prodotto.navigazione[0][2])
                }
            });
        }

        if (kits && kits.length > 0) {
            kits.forEach(kit => {

                if (kit.navigazione[0][1] == readablefamily) {
                    items.push(kit)
                }

                if (kit.navigazione[0][2] && !subcategory.includes(kit.navigazione[0][2])) {
                    subcategory.push(kit.navigazione[0][2])
                }
            });
        }
    }

    console.log(items)
    console.log(subcategory)

    subcategory.forEach(sub => {
        container.innerHTML += `
            <h3 class="font-bold text-lg text-primary">` + sub + `</h3>
            <div class="my-5 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 justify-center md:justify-start items-center md:items-start gap-1 my-5" id="category-${sub}"></div>`;
        console.log("n container", `category-${sub}`);
    })



    items.forEach(item => {
        let typeItem = "singolo"; // default

        if (pc && pc.includes(item)) {
            typeItem = "pc";
        } else if (kits && kits.includes(item)) {
            typeItem = "kit";
        }

        let productCategory = item.navigazione && item.navigazione[0] && (item.navigazione[0][0] == "Whirlpool System" ?
            item.navigazione[0][3] : item.navigazione[0][2]);
        if (item.navigazione) {
            item.navigazione.forEach(function(pn) {
                if (pn[1] == readableType) {
                    // Se è Whirlpool System o se esiste pn[3], usa pn[3], altrimenti pn[2]
                    if (pn[0] === "Whirlpool System" || pn[0] === "Whirlpool Systems" || typeof pn[3] !== 'undefined') {
                        productCategory = pn[3];
                    } else {
                        productCategory = pn[2];
                    }
                    console.log("Categoria selezionata:", productCategory);
                }
            });
        }
        let categoryId = productCategory ? `category-${productCategory}` : 'no_category';
        let categoryContainer = document.getElementById(categoryId);
        if (categoryContainer) {
            let image = []; // Inizializza come array
            if (item.immagine.includes("-")) {
                image = item.immagine.split('-'); // Divide le immagini in base al separatore
            } else if (Array.isArray(item.immagine)) {
                image = item.img; // Usa direttamente l'array
            } else {
                image = [item.immagine]; // Caso fallback per immagine singola
            }
            if (image[0] === "https://placehold.co/300x160") {
                categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center">
                    <div class="flex flex-col gap-[10px] items-center product" 
                        id="${item.id}" 
                        data-type="${typeItem}" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${nameToSlug(item.nome)}">
                        <img src="${image[0]}" alt="${item.nome}" loading="lazy"
                            class="cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${item.nome}</h3>
                        </div>
                    </div>
                </div>`;
            } else {
                categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center">
                    <div class="flex flex-col gap-[10px] items-center product"
                        id="${item.id}" 
                        data-type="${typeItem}" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${nameToSlug(item.nome)}">
                        <img src="/public/img/${image[0]}" alt="${item.nome}" loading="lazy"
                            class="cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${item.nome}</h3>
                        </div>
                    </div>
                </div>`;
            }
        }
    })

    function getCookie(name) {
        const cookies = document.cookie.split("; ");
        for (let c of cookies) {
            const [key, value] = c.split("=");
            if (key === name) return value;
        }
        return null; // se non trovato
    }

    const productsCard = document.querySelectorAll(".product");
    productsCard.forEach(product => {
        product.addEventListener("click", function(e) {
            const type = product.dataset.type;
            const slug = product.dataset.slug;
            const id = product.attributes[1].value;
            const lang = getCookie("lang") || "it";

            let url = "";

            if (<?= isset($_GET["type"]) ? 1 : 0 ?> == 1) {
                url = `/sacith/${lang}/product/<?= $_GET["family"] ?><?= isset($_GET["subfamily"]) ? "/" . $_GET["subfamily"] : "" ?><?= isset($_GET["type"]) ? "/" . $_GET["type"] : "" ?><?= isset($_GET["category"]) ? "/" . $_GET["category"] : "" ?>/${id}/${slug}?c=${type}`;
            } else {
                url = `/sacith/${lang}/product/<?= $_GET["family"] ?><?= isset($_GET["subfamily"]) ? "/" . $_GET["subfamily"] : "" ?><?= isset($_GET["category"]) ? "/" . $_GET["category"] : "" ?>/${id}/${slug}?c=${type}`;
            }

            window.location.href = url;
        });
    })
</script>

</html>