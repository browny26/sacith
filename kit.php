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
        $sql = "SELECT * FROM Kit WHERE id = " . $id;
        $result = $conn->query($sql);
        $immagine = "/public/logo/Logotipo_Sacith_Nosrl.png";
        $nome = "Nome non disponibile";
        $codice_univoco = "Codice non disponibile";
        $descrizione = "Descrizione non disponibile";
        $titoli_prodottiConfigurabili = "titoli non disponibili";
        $sottotitoli_prodottiConfigurabili = "sottotitoli non disponibili";
        $titoli_prodottiNonConfigurabili = "titoli non configurabili non disponibili";
        $titoli_prodottiOptional = "titoli optional non disponibili";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["immagine"] !== "" || $row["immagine"] !== null) {
                $immagine = $row["immagine"];
                $immagini = explode('-', $immagine);
            }
            $nome = $row["nome"] ?? $nome;
            $codice_univoco = $row["codice_univoco"] ?? $codice_univoco;
            $descrizione = $row["descrizione"] ?? $descrizione;
            $titoli_prodottiConfigurabili = $row["titoli_prodottiConfigurabili"] ?? $titoli_prodottiConfigurabili;
            $titoli_prodottiConfigurabili_array = explode('-', $titoli_prodottiConfigurabili);
            $sottotitoli_prodottiConfigurabili = $row["sottotitoli_prodottiConfigurabili"] ?? $sottotitoli_prodottiConfigurabili;
            $sottotitoli_prodottiConfigurabili_array = explode('-', $sottotitoli_prodottiConfigurabili);
            $titoli_prodottiNonConfigurabili = $row["titoli_prodottiNonConfigurabili"] ?? $titoli_prodottiNonConfigurabili;
            $titoli_prodottiOptional = $row["titoli_prodottiOptional"] ?? $titoli_prodottiOptional;
            $pdf = $row["pdf"] ?? null;
            $pdf_array = explode('%', $pdf);
            $navigazione = explode('-', $row["navigazione"]);
            $kit[] = [
                "id" => $row["id"],
                "nome" => $row["nome"],
                "codice_univoco" => $row["codice_univoco"],
                "descrizione" => $descrizione,
                "immagine" => $immagine,
                "titoli_prodottiConfigurabili" => $titoli_prodottiConfigurabili_array,
                "sottotitoli_prodottiConfigurabili" => $sottotitoli_prodottiConfigurabili_array,
                "titoli_prodottiNonConfigurabili" => $row["titoli_prodottiNonConfigurabili"],
                "titoli_prodottiOptional" => $row["titoli_prodottiOptional"],
                "pdf" => $row["pdf"]
            ];
            $json_kit = json_encode($kit);
        } else {
            echo "Prodotto non trovato";
            exit;
        }
        $sql = "SELECT * FROM StrutturaKit WHERE codice_kit = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $codice_univoco);
            $stmt->execute();
            $result = $stmt->get_result();
            $codice_singolo = "Codice non disponibile";
            $codice_configurabile = "Codice non disponibile";
            $strutturaKit = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $strutturaKit[] = [
                        "codice_prodottoSingolo" => $row["codice_prodottoSingolo"],
                        "codice_prodottoConfigurabile" => $row["codice_prodottoConfigurabile"],
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
        $json_strutturaKit = json_encode($strutturaKit);
    } else {
        echo "ID o tipo non inviati.";
        exit;
    }
    $nonConfig = [];
    $config = [];
    $optional = [];
    if (isset($strutturaKit) && count($strutturaKit) > 0) {
        for ($i = 0; $i < count($strutturaKit); $i++) {
            if ($strutturaKit[$i]["titolo_configurazione"] === "Non Configurabili" && $strutturaKit[$i]["codice_prodottoSingolo"] !== null) {
                $sql2 = "SELECT * FROM ProdottoSingolo WHERE codice_univoco = ?";
                $stmt2 = $conn->prepare($sql2);
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoSingolo"]);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $immagine2 = "/public/logo/Logotipo_Sacith_Nosrl.png";
                    $nome2 = "nome non disponibile";
                    if ($result2 && $result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $immagine2 = ($row2["immagine"] == null || $row2["immagine"] == "") ? "/public/logo/Logotipo_Sacith_Nosrl.png" : $row2["immagine"];
                        $nome2 = $row2["nome"];
                        $nonConfig[] = [
                            "id" => $strutturaKit[$i]["codice_prodottoSingolo"],
                            "nome" => $nome2,
                            "immagine" => $immagine2,
                        ];
                    } else {
                        echo "Nessun risultato trovato per il prodotto singolo";
                    }
                    $stmt2->close();
                } else {
                    echo "Errore nella preparazione della query.";
                }
            }
            if ($strutturaKit[$i]["titolo_configurazione"] === "Non Configurabili" && $strutturaKit[$i]["codice_prodottoConfigurabile"] !== null) {
                $sql2 = "SELECT * FROM ProdottoConfigurabile WHERE codice_base = ?";
                $stmt2 = $conn->prepare($sql2);
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoConfigurabile"]);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $immagine3 = "/public/logo/Logotipo_Sacith_Nosrl.png";
                    $nome3 = "nome non disponibile";
                    if ($result2 && $result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $immagine2 = ($row2["immagine"] == null || $row2["immagine"] == "") ? "/public/logo/Logotipo_Sacith_Nosrl.png" : $row2["immagine"];
                        $nome2 = $row2["nome"];
                        $nonConfig[] = [
                            "id" => $strutturaKit[$i]["codice_prodottoConfigurabile"],
                            "nome" => $nome2,
                            "immagine" => $immagine2,
                        ];
                    } else {
                        echo "Nessun risultato trovato per il prodotto singolo";
                    }
                    $stmt2->close();
                } else {
                    echo "Errore nella preparazione della query.";
                }
            }
            if ($strutturaKit[$i]["titolo_configurazione"] === "Optional" && $strutturaKit[$i]["codice_prodottoSingolo"] !== null) {
                $sql2 = "SELECT * FROM ProdottoSingolo WHERE codice_univoco = ?";
                $stmt2 = $conn->prepare($sql2);
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoSingolo"]);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $immagine2 = "/public/logo/Logotipo_Sacith_Nosrl.png";
                    $nome2 = "nome non disponibile";
                    if ($result2 && $result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $immagine2 = ($row2["immagine"] == null || $row2["immagine"] == "") ? "/public/logo/Logotipo_Sacith_Nosrl.png" : $row2["immagine"];
                        $nome2 = $row2["nome"];
                        $optional[] = [
                            "id" => $strutturaKit[$i]["codice_prodottoSingolo"],
                            "nome" => $nome2,
                            "immagine" => $immagine2,
                        ];
                    } else {
                        echo "Nessun risultato trovato per il prodotto singolo";
                    }
                    $stmt2->close();
                } else {
                    echo "Errore nella preparazione della query.";
                }
            }
            if ($strutturaKit[$i]["titolo_configurazione"] === "Optional" && $strutturaKit[$i]["codice_prodottoConfigurabile"] !== null) {
                $sql2 = "SELECT * FROM ProdottoConfigurabile WHERE codice_base = ?";
                $stmt2 = $conn->prepare($sql2);
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoConfigurabile"]);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $immagine3 = "/public/logo/Logotipo_Sacith_Nosrl.png";
                    $nome3 = "nome non disponibile";
                    if ($result2 && $result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $immagine2 = ($row2["immagine"] == null || $row2["immagine"] == "") ? "/public/logo/Logotipo_Sacith_Nosrl.png" : $row2["immagine"];
                        $nome2 = $row2["nome"];
                        $optional[] = [
                            "id" => $strutturaKit[$i]["codice_prodottoConfigurabile"],
                            "nome" => $nome2,
                            "immagine" => $immagine2,
                        ];
                    } else {
                        echo "Nessun risultato trovato per il prodotto singolo";
                    }
                    $stmt2->close();
                } else {
                    echo "Errore nella preparazione della query.";
                }
            }
            if (isset($kit)) {
                foreach ($kit as $kItem) {
                    foreach ($kItem["titoli_prodottiConfigurabili"] as $titolo) {
                        if ($strutturaKit[$i]["titolo_configurazione"] === $titolo && $strutturaKit[$i]["codice_prodottoSingolo"] !== null) {
                            $sql2 = "SELECT * FROM ProdottoSingolo WHERE codice_univoco = ?";
                            $stmt2 = $conn->prepare($sql2);
                            if ($stmt2) {
                                $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoSingolo"]);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                $immagine2 = "/public/logo/Logotipo_Sacith_Nosrl.png";
                                $nome2 = "nome non disponibile";
                                if ($result2 && $result2->num_rows > 0) {
                                    $row2 = $result2->fetch_assoc();
                                    $immagine2 = ($row2["immagine"] == null || $row2["immagine"] == "") ? "/public/logo/Logotipo_Sacith_Nosrl.png" : $row2["immagine"];
                                    $nome2 = $row2["nome"];
                                    $config[] = [
                                        "id" => $strutturaKit[$i]["codice_prodottoSingolo"],
                                        "titolo" => $titolo,
                                        "nome" => $nome2,
                                        "immagine" => $immagine2,
                                    ];
                                } else {
                                    echo "Nessun risultato trovato per il prodotto singolo";
                                }
                                $stmt2->close();
                            } else {
                                echo "Errore nella preparazione della query.";
                            }
                        }
                        if ($strutturaKit[$i]["titolo_configurazione"] === $titolo && $strutturaKit[$i]["codice_prodottoConfigurabile"] !== null) {
                            $sql2 = "SELECT * FROM ProdottoConfigurabile WHERE codice_base = ?";
                            $stmt2 = $conn->prepare($sql2);
                            if ($stmt2) {
                                $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoConfigurabile"]);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                $immagine3 = "/public/logo/Logotipo_Sacith_Nosrl.png";
                                $nome3 = "nome non disponibile";
                                if ($result2 && $result2->num_rows > 0) {
                                    $row2 = $result2->fetch_assoc();
                                    $immagine2 = ($row2["immagine"] == null || $row2["immagine"] == "") ? "/public/logo/Logotipo_Sacith_Nosrl.png" : $row2["immagine"];
                                    $nome2 = $row2["nome"];
                                    $config[] = [
                                        "id" => $strutturaKit[$i]["codice_prodottoConfigurabile"],
                                        "titolo" => $titolo,
                                        "nome" => $nome2,
                                        "immagine" => $immagine2,
                                    ];
                                } else {
                                    echo "Nessun risultato trovato per il prodotto singolo";
                                }
                                $stmt2->close();
                            } else {
                                echo "Errore nella preparazione della query.";
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo "ID o tipo non inviati.";
        exit;
    }
    $json_config = json_encode($config);
    $json_nonConfig = json_encode($nonConfig);
    $json_optional = json_encode($optional);
} else {
    echo "Metodo di richiesta non valido.";
    exit;
}
$conn->close();
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
    <link rel="canonical" href="https://www.sacith.com/<?= htmlspecialchars($lang) ?>/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=kit" />
    <link rel="alternate" hreflang="it" href="https://www.sacith.com/it/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=kit" />
    <link rel="alternate" hreflang="en" href="https://www.sacith.com/en/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=kit" />
    <link rel="icon" href="/public/logo/logo_small.png" type="image/png">
    <link rel="stylesheet" href="style.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
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
                <!-- Product Image -->
                <div class="lg:col-span-8 bg-white shadow rounded-lg overflow-hidden">
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
                <!-- Product Details -->
                <div class="lg:col-span-4">
                    <h1 class="text-3xl font-medium mb-2"><?php echo htmlspecialchars($nome); ?></h1>
                    <p class="text-gray-700 mb-4">
                        <?php echo nl2br(htmlspecialchars($descrizione)); ?>
                    </p>
                    <div class="flex flex-wrap gap-5">
                        <p
                            class="inline-block py-[4px] px-[26px] w-fit rounded-md border border-primary">
                            <?php echo htmlspecialchars($codice_univoco); ?>
                        </p>
                        <?php if (!empty($pdf_array)) { ?>
                            <button id="pdfButton" data-dropdown-toggle="dropdown" class="inline-flex items-center justify-center text-white bg-primary box-border border border-transparent hover:bg-hover font-medium leading-5 rounded-md py-[6px] px-[26px]" type="button">
                                PDF
                                <svg class="w-4 h-4 ms-1.5 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="dropdown" class="z-10 hidden rounded-md shadow-lg w-44">
                                <ul class="p-2 text-sm font-medium" aria-labelledby="dropdownDefaultButton">
                                    <?php foreach ($pdf_array as $file): ?>
                                        <li>
                                            <a href="/public/pdf/<?php echo htmlspecialchars($file); ?>"
                                                target="_blank"
                                                class="block px-4 py-2 hover:bg-neutral-100 rounded-md no-underline">
                                                <?= str_replace('_', ' ', pathinfo($file, PATHINFO_FILENAME)) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Section: Components -->
            <section class="mt-[87px]">
                <h2 class="text-xl text-primary font-medium my-[24px]"><?= $page_translations['components_list'] ?></h2>
                <!-- Non-Configurable Components -->
                <section class="w-full mt-8 flex gap-8 items-center">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semimedium mb-[26px] w-max">
                            <?= $page_translations['non_configurable'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </section>
                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-center gap-[24px]" id="conponentiNonConfigurabili">
                </section>
                <!-- Configurable Components -->
                <section class="w-full mt-10 flex gap-8 items-center">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semimedium mb-[26px] w-max">
                            <?= $page_translations['configurable'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </section>
                <section class="space-y-8" id="componentiConfigurabili">
                </section>
                <!-- Optional Components -->
                <section class="w-full mt-10 flex gap-8 items-center">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semimedium mb-[26px] w-max">
                            <?= $page_translations['optional'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </section>
                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-center gap-[24px]" id="componentiOptional">
                </section>
            </section>
        </div>
        <?php require("footer.php"); ?>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
        const kit = <?php echo $json_kit; ?>;
        const strutturaKit = <?php echo $json_strutturaKit; ?>;
        const nonConfig = <?php echo $json_nonConfig; ?>;
        const optional = <?php echo $json_optional; ?>;
        const configItem = <?php echo $json_config; ?>;
        const componentiConfigurabili = document.getElementById("componentiConfigurabili");
        const conponentiNonConfigurabili = document.getElementById("conponentiNonConfigurabili");
        const componentiOptional = document.getElementById("componentiOptional");

        nonConfig.forEach(function(item) {
            if (item.immagine.includes("-")) {
                var immagine = item.immagine.split("-");
                conponentiNonConfigurabili.innerHTML += `<div class="flex flex-col items-center text-center gap-[10px] me-4">
                        <img
                            src="/public/img/` + immagine[0] + `"
                            loading="lazy"
                            alt="` + item.nome + `"
                            class="rounded-lg shadow w-[300px] h-[200px]" 
                            onclick="window.location.href='https://www.sacith.com/${document.documentElement.lang}/redirect?id=` + item.id + `'"
                            />
                        <p class="w-[300px]">` + item.nome +
                    `</p> </div>`
            } else {
                if (item.immagine == "/public/logo/Logotipo_Sacith_Nosrl.png") {
                    conponentiNonConfigurabili.innerHTML += `<div class="flex flex-col items-center text-center gap-[10px] me-4">
                        <img
                            src="` + item.immagine + `"
                            loading="lazy"
                            alt="` + item.nome + `"
                            class="rounded-lg shadow w-[300px] h-[200px] object-contain" 
                            onclick="window.location.href='https://www.sacith.com/${document.documentElement.lang}/redirect?id=` + item.id + `'"
                            />
                        <p class="w-[300px]">` + item.nome +
                        `</p> </div>`
                } else {
                    conponentiNonConfigurabili.innerHTML += `<div class="flex flex-col items-center text-center gap-[10px] me-4">
                        <img
                            src="/public/img/` + item.immagine + `"
                            loading="lazy"
                            alt="` + item.nome + `"
                            class="rounded-lg shadow w-[300px] h-[200px]" 
                            onclick="window.location.href='https://www.sacith.com/${document.documentElement.lang}/redirect?id=` + item.id + `'"
                            />
                        <p class="w-[300px]">` + item.nome +
                        `</p> </div>`
                }
            }
        });
        optional.forEach(function(item) {
            if (item.immagine.includes("-")) {
                var immagine = item.immagine.split("-");
                componentiOptional.innerHTML += `<div class="flex flex-col items-center bg-white text-center gap-[10px] me-4">
                        <img
                            src="/public/img/` + immagine[0] + `"
                            loading="lazy"
                            alt="` + item.nome + `"
                            class="mb-2 rounded-lg shadow w-[300px] h-[200px]" 
                            onclick="window.location.href='https://www.sacith.com/${document.documentElement.lang}/redirect?id=` + item.id + `'"
                            />
                        <p class="w-[300px]">` + item.nome +
                    `</p>
                    </div>`;
            } else {
                if (item.immagine == "/public/logo/Logotipo_Sacith_Nosrl.png") {
                    componentiOptional.innerHTML += `<div class="flex flex-col items-center bg-white text-center gap-[10px] me-4">
                        <img
                            src="` + item.immagine + `"
                            loading="lazy"
                            alt="` + item.nome + `"
                            class="mb-2 rounded-lg shadow w-[300px] h-[200px] object-contain" 
                            onclick="window.location.href='https://www.sacith.com/${document.documentElement.lang}/redirect?id=` + item.id + `'"
                            />
                        <p class="w-[300px]">` + item.nome +
                        `</p>
                    </div>`;
                } else {
                    componentiOptional.innerHTML += `<div class="flex flex-col items-center bg-white text-center gap-[10px] me-4">
                        <img
                            src="/public/img/` + item.immagine + `"
                            loading="lazy"
                            alt="` + item.nome + `"
                            class="mb-2 rounded-lg shadow w-[300px] h-[200px]" 
                            onclick="window.location.href='https://www.sacith.com/${document.documentElement.lang}/redirect?id=` + item.id + `'"
                            />
                        <p class="w-[300px]">` + item.nome +
                        `</p>
                    </div>`;
                }
            }
        });
        if (componentiOptional.innerHTML.trim() == "") {
            componentiOptional.previousElementSibling.classList.add("hidden");
        }
        kit[0].titoli_prodottiConfigurabili.forEach(function(config) {
            componentiConfigurabili.innerHTML += `
                <div class="space-y-4">
                    <h4 class="font-semimedium text-lg">${config}</h4>
                    <div class="flex flex-wrap md:flex-nowrap items-start space-x-4 gap-20 mt-4 mb-6">
                        <!-- Contenitore primo prodotto -->
                        <div id="config-${config}" class="flex items-center gap-4"></div>
                        <!-- Contenitore prodotti extra -->
                        <div class="col-span-3 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 hidden" id="configsecond-${config}"></div>
                    </div>
                </div>`;
            const firstProductContainer = document.getElementById(`config-${config}`);
            const extraProductsContainer = document.getElementById(`configsecond-${config}`);
            let firstProductDisplayed = false;
            configItem.forEach(function(item) {
                if (item.titolo == config) {
                    let imgSrc = item.immagine.includes("-") ? `${item.immagine.split("-")[0]}` : `${item.immagine}`;
                    imgSrc = imgSrc == "/public/logo/Logotipo_Sacith_Nosrl.png" ? imgSrc : `/public/img/${imgSrc}`;
                    let productHTML = `
                <div class="flex flex-col items-center gap-2">
                    <img src="${imgSrc}" loading="lazy" alt="${item.nome}" 
                        class="rounded-lg shadow w-[300px] h-[200px] transition"
                        onclick="window.location.href='https://www.sacith.com/${document.documentElement.lang}/redirect?id=` + item.id + `'"/>
                    <p class="w-[300px] text-center text-gray-700">${item.nome}</p>
                </div>`;
                    if (!firstProductDisplayed) {
                        firstProductContainer.innerHTML = `
                    <div class="relative flex items-center gap-4">
                        ${productHTML}
                        <button id="btn-${config}" class="toggle-products mb-2 text-blue-600 text-2xl cursor-pointer">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>`;
                        firstProductDisplayed = true;
                    } else {
                        extraProductsContainer.innerHTML += productHTML;
                    }
                }
            });
            const hiddendiv = document.getElementById(`configsecond-${config}`)
            const btnconfig = document.getElementById(`btn-${config}`)
            if (hiddendiv.innerHTML == "") {
                if (btnconfig) {
                    btnconfig.classList.add("hidden");
                }
            }
        });
        document.querySelectorAll(".toggle-products").forEach(function(button) {
            button.addEventListener("click", function() {
                const extraProducts = this.parentElement.parentElement.parentElement.children[1];
                extraProducts.classList.toggle("hidden");
                const arrow = this.querySelector("i");
                if (arrow.classList.contains("bi-chevron-right")) {
                    arrow.classList.remove("bi-chevron-right");
                    arrow.classList.add("bi-chevron-left");
                } else {
                    arrow.classList.remove("bi-chevron-left");
                    arrow.classList.add("bi-chevron-right");
                }
            });
        });
    </script>
</body>
<script>
    const imagesContainer = document.querySelector('.carousel-images');
    const images = document.querySelectorAll('.carousel-item');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    let currentIndex = 0;
    if (nextButton !== null) {
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
    }
</script>

</html>