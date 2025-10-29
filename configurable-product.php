<?php require("translator.php") ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    function formatName($str)
    {
        $str = rawurldecode($str);
        $str = str_replace("-", " ", $str);
        $str = str_replace(" and ", " & ", $str);
        $str = str_replace("_", ", ", $str);
        return ucwords(strtolower($str));
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
        require("config.php");
        $lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'it');
        /* $db_to_use = ($lang === 'en') ? $db_name : $db_name_it;

        $conn = new mysqli($host, $username, $password, $db_to_use); */
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbname = "sacith_it";
        $conn = new mysqli($host, $user, $password, $dbname);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM ProdottoConfigurabile WHERE id = " . $id;
        $result = $conn->query($sql);
        $immagine = "/public/logo/Logotipo_Sacith_Nosrl.png";
        $nome = "Nome non disponibile";
        $codice_base = "Codice non disponibile";
        $descrizione = "Descrizione non disponibile";
        $titoli_configurazione = "titoli non disponibili";
        $sottotitoli_configurazione = "sottotitoli non disponibili";
        $titolo_optional = "titoli optional non disponibili";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["immagine"] !== "" || $row["immagine"] !== null) {
                $immagine = $row["immagine"];
                $immagini = explode('-', $immagine);
            }
            $nome = $row["nome"] ?? $nome;
            $codice_base = $row["codice_base"] ?? $codice_univoco;
            $descrizione = $row["descrizione"] ?? $descrizione;
            $titoli_configurazione = $row["titoli_configurazione"] ?? $titoli_configurazione;
            $titoli_configurazione_array = explode('-', $titoli_configurazione);
            $sottotitoli_configurazione = $row["sottotitoli_configurazione"] ?? $sottotitoli_configurazione;
            $sottotitoli_configurazione_array = explode('/', $sottotitoli_configurazione);
            $titolo_optional = $row["titolo_optional"] ?? null;
            $titolo_optional_array = explode('-', $titolo_optional);
            $pdf = $row["pdf"] ?? null;
            $dimensioni = $row["dimensioni"] ?? null;
            $dimensioni_array = !empty($dimensioni) ? explode('%', $dimensioni) : [];
            $finiture = $row["finiture"] ?? null;
            $finiture_array = explode('%', $finiture);
            $materiali = $row["materiali"] ?? null;
            $navigazione = explode('-', $row["navigazione"]);
            $pc[] = [
                "id" => $row["id"],
                "nome" => $row["nome"],
                "codice_base" => $row["codice_base"],
                "descrizione" => $descrizione,
                "immagine" => $immagine,
                "titoli_configurazione" => $titoli_configurazione_array,
                "sottotitoli_configurazione" => $sottotitoli_configurazione_array,
                "titolo_optional" => $titolo_optional_array,
                "pdf" => $row["pdf"]
            ];
            $json_pc = json_encode($pc);
            $json_titoli_configurazione_array = json_encode($titoli_configurazione_array);
            $json_sottotitoli_configurazione_array = json_encode($sottotitoli_configurazione_array);
            $json_titolo_optional_array = json_encode($titolo_optional_array);
        } else {
            echo "Prodotto non trovato";
            exit;
        }
        $sql = "SELECT * FROM StrutturaPC WHERE codice_pc = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $codice_base);
            $stmt->execute();
            $result = $stmt->get_result();
            $immagine2 = "/public/logo/Logotipo_Sacith_Nosrl.png";
            $nome2 = "Nome non disponibile";
            $tipo = "tipo non disponibile";
            $titolo_configurazione = "titolo non disponibile";
            $strutturaPc = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $immagine2 = ($row["immagine"] == null || $row["immagine"] == "") ? "/public/logo/Logotipo_Sacith_Nosrl.png" : $row["immagine"];
                    $strutturaPc[] = [
                        "nome" => $row["nome"],
                        "codice_pc" => $codice_base,
                        "tipo" => $row["tipo"],
                        "immagine" => $immagine2,
                        "titolo_configurazione" => $row["titolo_configurazione"],
                    ];
                }
            } else {
                echo "Nessun risultato trovato per la struttura del kit.";
            }
            $stmt->close();
        } else {
            echo "Errore nella preparazione della query.";
        }
        $sql = "SELECT * FROM CodiceConfigurazioneComplessa";
        $result = $conn->query($sql);
        $codici = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $codici[] = [
                    "uno" => $row["prodottoRiga1"],
                    "due" => $row["prodottoRiga2"],
                    "tre" => $row["prodottoRiga3"],
                    "codice" => $row["codice_univoco"],
                ];
            }
        }
        $json_codici = json_encode($codici);
        $json_strutturaPc = json_encode($strutturaPc);
    } else {
        echo "ID o tipo non inviati.";
        exit;
    }
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
        content="<?php echo nl2br(htmlspecialchars($descrizione)); ?>" />
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sacith s.r.l.">
    <link rel="canonical" href="https://www.sacith.com/<?= htmlspecialchars($lang) ?>/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=pc" />
    <link rel="alternate" hreflang="it" href="https://www.sacith.com/it/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=pc" />
    <link rel="alternate" hreflang="en" href="https://www.sacith.com/en/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=pc" />
    <link rel="icon" href="/public/logo/logo_small.png" type="image/png">
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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

<body class="font-default">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="bg-white">
        <?php require("navbar.php"); ?>
        <!-- Breadcrumb -->
        <div class="container mx-auto mt-6 px-4">
            <nav class="text-gray-500 text-sm">
                <a href="/sacith/<?= $lang ?>/product" class="text-blue-500"><?= $page_translations['product'] ?></a> &gt;
                <a href="/sacith/<?= $lang ?>/product/<?= $_GET["family"] ?>/<?= $_GET["subfamily"] ?>/<?= isset($_GET["type"]) ? $_GET["type"] . "/" . $_GET["category"] : $_GET["category"] ?>" class="text-blue-500">
                    <?= formatName($_GET["category"])  ?>
                </a> &gt;
                <span><?php echo htmlspecialchars($nome); ?></span>
            </nav>
        </div>
        <!-- Product Section -->
        <div class="container mx-auto mt-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end">
                <div class="lg:col-span-8">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="carousel relative w-full overflow-hidden">
                            <div class="carousel-images flex transition-transform duration-500">
                                <?php foreach ($immagini as $img) : ?>
                                    <div class="carousel-item flex-shrink-0 w-full">
                                        <img src="/public/img/<?php echo $img; ?>" class="w-full h-auto object-cover" alt="Immagine Prodotto">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($immagini) > 1) : ?>
                                <button id="prev" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-primary text-white px-1 py-3 rounded-full"><i class="bi bi-chevron-left"></i></button>
                                <button id="next" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary text-white px-1 py-3 rounded-full"><i class="bi bi-chevron-right"></i></button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-3">
                    <div class="bg-white pb-6">
                        <h1 class="text-3xl font-medium mb-2"><?php echo htmlspecialchars($nome); ?></h1>
                        <p class="text-gray-700 mb-4">
                            <?php echo htmlspecialchars(string: $descrizione); ?>
                        </p>
                        <p
                            class="inline-block px-3 py-1 border border-primary rounded-2xl">
                            <?php echo htmlspecialchars($codice_base); ?>
                        </p>
                        <?php if (!empty($pdf)) { ?>
                            <a href="/public/pdf/<?php echo htmlspecialchars($pdf); ?>" target="_blank" class="bg-primary rounded-full no-underline text-white px-4 py-2 ml-5">
                                PDF
                            </a>
                        <?php } ?>
                    </div>
                    <div id="accordion-flush" class="max-w-[700px] mx-auto" data-accordion="collapse" data-active-classes="text-[#009FE3]" data-inactive-classes="text-black">
                        <?php if (!empty($dimensioni_array)) : ?>
                            <h2 id="accordion-flush-heading-1">
                                <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-start rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-1" aria-expanded="false" aria-controls="accordion-flush-body-1">
                                    <span class="flex gap-3">
                                        <?= $page_translations['dimensions'] ?>
                                    </span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                                <div class="py-5 border-b border-gray-200">
                                    <p><?php
                                        for ($i = 0; $i < count($dimensioni_array); $i++) {
                                            echo $dimensioni_array[$i] . "<br>";
                                        }
                                        ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($finiture)) : ?>
                            <h2 id="accordion-flush-heading-2">
                                <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-start rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                                    <span class="flex gap-3">
                                        <?= $page_translations['finishes'] ?>
                                    </span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                                <div class="py-5 border-b border-gray-200">
                                    <p><?php
                                        for ($i = 0; $i < count($finiture_array); $i++) {
                                            echo $finiture_array[$i] . "<br>";
                                        }
                                        ?></p>
                                </div>
                            </div> <?php endif; ?>
                        <?php if (!empty($materiali)) : ?>
                            <h2 id="accordion-flush-heading-3">
                                <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-start rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                                    <span class="flex gap-3">
                                        <?= $page_translations['materials'] ?>
                                    </span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                                <div class="py-5 border-b border-gray-200">
                                    <p><?php echo htmlspecialchars($materiali); ?></p>
                                </div>
                            </div><?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Section: Components -->
            <section class="my-6">
                <!-- Configurable Components -->
                <div class="w-full flex gap-8 items-center">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semimedium mb-3 w-max">
                            <?= $page_translations['configurations'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex flex-col items-center mt-4">
                            <div class="space-y-4">
                                <div class="flex flex-col gap-4" id="configurazioni">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Optional Components -->
                <div class="w-full flex gap-8 items-center mt-5">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semimedium mb-4 w-max">
                            <?= $page_translations['optional'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </div>
                <div>
                    <div id="optional">
                    </div>
                </div>
            </section>
        </div>
        <div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" onclick="modalClose()" style="pointer-events: auto;"></div>
            <div class="fixed inset-0 z-20 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                    <h3 id="modal-title" class="text-base font-semimedium text-gray-900" id="modal-title"><?= $page_translations['code_title'] ?></h3>
                                    <div class="mt-2 flex flex-col gap-2" id="modal-content">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button onclick="modalClose()" type="button" class="inline-flex w-full justify-center rounded-md bg-primary px-3 py-2 text-sm font-semimedium text-white shadow-xs hover:bg-primary/70 sm:ml-3 sm:w-auto"><?= $lang == 'it' ? "Chiudi" : "Close" ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal-img">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" onclick="modalClose2()" style="pointer-events: auto;"></div>
            <div class="fixed inset-0 z-20 w-screen overflow-y-auto">
                <div class="flex min-h-full justify-center p-4 text-center items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                    <img src="" alt="component image" id="modal-src" class="w-[55vw] h-auto rounded-lg shadow">
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button onclick="modalClose2()" type="button" class="inline-flex w-full justify-center rounded-md bg-primary px-3 py-2 text-sm font-semimedium text-white shadow-xs hover:bg-primary/70 sm:ml-3 sm:w-auto"><?= $lang == 'it' ? "Chiudi" : "Close" ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require("footer.php"); ?>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@1.7.0/dist/flowbite.min.js"></script>
    </div>
</body>
<script type="text/javascript">
    const pc = <?php echo $json_pc; ?>;
    const strutturaPc = <?php echo $json_strutturaPc; ?>;
    const titoli_configurazione = <?php echo $json_titoli_configurazione_array; ?>;
    const sottotitoli_configurazione = <?php echo $json_sottotitoli_configurazione_array; ?>;
    const titoli_optional = <?php echo $json_titolo_optional_array; ?>;
    const codici = <?php echo $json_codici; ?>;
    const configurazioni = document.getElementById("configurazioni");
    const optional = document.getElementById("optional");

    let c = 0;
    let array = [];
    sottotitoli_configurazione.forEach(function(item) {
        const array_sott = item.split("-");
        array.push(array_sott);
    })
    let hasSubtitles = false;

    titoli_configurazione.forEach(function(config) {
        configurazioni.innerHTML += `
        <h4 class="font-semimedium uppercase">` + config + `:</h4>
        <div class="flex flex-wrap justify-center sm:justify-start gap-3 mb-3" id="config-${config}">
        </div>
        <button type="button" id="btn-config-complessa" class="btn-${config.replace(/\s+/g, '')} w-[300px] text-sm text-center bg-primary rounded-full no-underline text-white px-4 py-2 mb-[38px]">
        <?= $page_translations['code_btn'] ?>
        </button>`;
        const configId = document.getElementById(`config-${config}`);
        c++;
        hasSubtitles = false;
        sottotitoli_configurazione.forEach(function(item) {
            if (item.startsWith(config)) {
                hasSubtitles = true;
                configId.classList.add("flex-col");
                item = item.split("-")[1];
                let containerId = item.split(" ");
                if (containerId.length > 1) {
                    containerId = containerId.join("_");
                } else {
                    containerId = containerId[0]
                }
                configId.innerHTML += `<h4 class="font-semimedium">` + item + `:</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-center gap-8 mt-4" id="item-${containerId}">
                </div>
                `;
                const itemId = document.getElementById(`item-${containerId}`);
                const lastId = document.querySelectorAll(`#item-${containerId}`);
                let contatore = lastId.length - 1;
                strutturaPc.forEach(function(str) {
                    let prov = str.titolo_configurazione.split("-");
                    let stringa1 = str.nome;
                    let stringa2 = item;
                    let parole = stringa2.split(" ");
                    if (prov[1] == item && prov[0] == config) {
                        if (str.immagine == "/public/logo/Logotipo_Sacith_Nosrl.png") {
                            lastId[contatore].innerHTML += `<div
                                class="flex flex-col items-center bg-white gap-[10px] text-center">
                                <img
                                src="` + str.immagine + `"
                                loading="lazy"
                                alt="` + str.nome + `"
                                class="mb-2 rounded-lg shadow w-[300px] h-[200px] object-contain"/>
                                <p class="w-[300px]">` + str.nome + `</p>
                                </div>`;
                        } else {
                            lastId[contatore].innerHTML += `<div
                                class="flex flex-col items-center gap-[10px] bg-white text-center">
                                <img
                                src="/public/img/` + str.immagine + `"
                                loading="lazy"
                                alt="` + str.nome + `"
                                class="showImg mb-2 rounded-lg shadow w-[300px] h-[200px]"/>
                                <p class="w-[300px]">` + str.nome + `</p>
                                </div>`;
                        }
                    }
                })
            } else {}
        });
        if (!hasSubtitles) {
            const button = document.querySelector(`.btn-${config.replace(/\s+/g, '')}`);
            button.remove();
        }
        strutturaPc.forEach(function(str) {
            if (str.titolo_configurazione === config) {
                if (!configId.querySelector(`[alt="${str.nome}"]`)) {
                    if (str.immagine == "/public/logo/Logotipo_Sacith_Nosrl.png") {
                        configId.innerHTML += `<div
                            class="flex flex-col items-center gap-[10px] bg-white text-center">
                            <img
                            src="` + str.immagine + `"
                            loading="lazy"
                            alt="` + str.nome + `"
                            class="mb-2 rounded-lg shadow w-[300px] h-[200px] object-contain" />
                            <p class="w-[300px]">` + str.nome + `</p>
                            </div>`;
                    } else {
                        configId.innerHTML += `<div
                            class="flex flex-col items-center gap-[10px] bg-white text-center">
                            <img
                            src="/public/img/` + str.immagine + `"
                            loading="lazy"
                            alt="` + str.nome + `"
                            class="showImg mb-2 rounded-lg shadow w-[300px] h-[200px]"/>
                            <p class="w-[300px]">` + str.nome + `</p>
                            </div>`;
                    }
                }
            }
        });
    });
    titoli_optional.forEach(function(op) {
        if (op == "" || op == null) {
            return;
        }
        optional.innerHTML += `<h4 class="font-semimedium">` + op + `</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-center gap-8 my-4" id="op-${op}">
            </div>`;
        const optId = document.getElementById(`op-${op}`);
        strutturaPc.forEach(function(str) {
            if (str.titolo_configurazione === op) {
                if (str.immagine == "/public/logo/Logotipo_Sacith_Nosrl.png") {
                    optId.innerHTML += `<div
                        class="flex flex-col items-center gap-[10px] bg-white text-center">
                        <img
                        src="` + str.immagine + `"
                        loading="lazy"
                        alt="` + str.nome + `"
                        class="mb-2 rounded-lg shadow w-[300px] h-[200px] object-contain" />
                        <p class="w-[300px]">` + str.nome + `</p>
                        </div>`;
                } else {
                    optId.innerHTML += `<div
                        class="flex flex-col items-center gap-[10px] bg-white text-center">
                        <img
                        src="/public/img/` + str.immagine + `"
                        loading="lazy"
                        alt="` + str.nome + `"
                        class="showImg mb-2 rounded-lg shadow w-[300px] h-[200px]"/>
                        <p class="w-[300px]">` + str.nome + `</p>
                        </div>`;
                }
            }
        });
    });
    if (optional.innerHTML.trim() == "") {
        optional.parentElement.parentElement.children[2].style.display = "none";
    }
    const btns = document.querySelectorAll("#btn-config-complessa");
    const modal = document.getElementById("modal");
    const modaltitle = document.getElementById("modal-title");
    const modalcontent = document.getElementById("modal-content");
    let righe = {
        uno: [],
        due: [],
        tre: []
    };
    btns.forEach((btn) => {
        btn.addEventListener("click", () => {
            modal.classList.remove("hidden");
            modaltitle.innerHTML = btn.previousElementSibling.previousElementSibling.innerHTML;
            const elements = btn.previousElementSibling?.children;
            if (!elements) return;
            let righe = {
                uno: [],
                due: [],
                tre: []
            };
            for (let i = 0; i < elements.length; i++) {
                const elem = elements[i].children;
                if (elem.length != 0) {
                    for (let j = 0; j < elem.length; j++) {
                        const childrenArray = [...elem[j].children];
                        if (childrenArray.length > 1) {
                            let valore = childrenArray[1].innerHTML.trim();
                            if (valore) {
                                if (i === 1) {
                                    righe.uno.push(valore);
                                } else if (i === 3) {
                                    righe.due.push(valore);
                                } else if (i === 5) {
                                    righe.tre.push(valore);
                                }
                            }
                        }
                    }
                }
            }
            modalcontent.innerHTML = "";
            codici.forEach((cod) => {
                let matchUno = cod.uno && righe.uno.includes(cod.uno);
                let matchDue = cod.due && righe.due.includes(cod.due);
                let matchTre = cod.tre && righe.tre.includes(cod.tre);
                if (matchUno || matchDue || matchTre) {
                    let details = [cod.uno, cod.due, cod.tre].filter(Boolean).join(" - ");
                    modalcontent.innerHTML += `<p class="w-full text-sm">${details} : ${cod.codice}</p>`;
                }
            });
        });
    });
    const imgshow = document.querySelectorAll(".showImg");
    const modalSrc = document.getElementById("modal-src");
    imgshow.forEach((img) => {
        img.addEventListener("click", () => {
            modalSrc.src = img.src;
            modalimg.classList.remove("hidden");
        })
    })
    const modalimg = document.getElementById("modal-img");

    function modalClose() {
        modalcontent.innerHTML = "";
        modal.classList.add("hidden");
    }

    function modalClose2() {
        modalimg.classList.add("hidden");
    }
</script>
<script>
    const imagesContainer = document.querySelector('.carousel-images');
    const images = document.querySelectorAll('.carousel-item');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    let currentIndex = 0;

    function updateCarousel() {
        const offset = -currentIndex * 100;
        imagesContainer.style.transform = `translateX(${offset}%)`;
    }
    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
        updateCarousel();
    });
    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
        updateCarousel();
    });
    updateCarousel();
</script>

</html>