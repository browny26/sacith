<?php require("translator.php") ?>
<?php
// Gestione della richiesta GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica che l'ID e il tipo siano stati inviati tramite GET
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
        require("config.php");
        // Connessione al database
        $lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'it');
        $db_to_use = ($lang === 'en') ? $db_name : $db_name_it;

        $conn = new mysqli($host, $username, $password, $db_to_use);
        // Controllo della connessione
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        // Query SQL per ottenere il prodotto
        $sql = "SELECT * FROM Kit WHERE id = " . $id;
        $result = $conn->query($sql);
        // $stmt = $conn->prepare("SELECT * FROM $type WHERE id = ?");
        // $stmt->bind_param("i", $id);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // Variabili per i dettagli del prodotto
        $immagine = "/public/logo/Logotipo_Sacith_Nosrl.png";  // Default image
        $nome = "Nome non disponibile";
        $codice_univoco = "Codice non disponibile";
        $descrizione = "Descrizione non disponibile";
        $titoli_prodottiConfigurabili = "titoli non disponibili";
        $sottotitoli_prodottiConfigurabili = "sottotitoli non disponibili";
        $titoli_prodottiNonConfigurabili = "titoli non configurabili non disponibili";
        $titoli_prodottiOptional = "titoli optional non disponibili";
        // Verifica se sono stati trovati dei risultati
        if ($result->num_rows > 0) {
            // Estrai i dati dal risultato della query
            $row = $result->fetch_assoc();
            // Assegna i dati a variabili
            if ($row["immagine"] !== "" || $row["immagine"] !== null) {
                $immagine = $row["immagine"];
                $immagini = explode('-', $immagine);
                // print_r($immagini);
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
            // print_r($titoli_prodottiConfigurabili_array);
            // print_r($sottotitoli_prodottiConfigurabili_array);
            // Chiudi la connessione al database
        } else {
            echo "Prodotto non trovato";
            exit;
        }
        // Query SQL per ottenere la struttura del kit
        $sql = "SELECT * FROM StrutturaKit WHERE codice_kit = ?";
        $stmt = $conn->prepare($sql);
        // Controllo che la preparazione sia riuscita
        if ($stmt) {
            $stmt->bind_param("s", $codice_univoco); // Assumendo che $codice_univoco sia una stringa
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
        // Stampa i risultati
        //print_r($strutturaKit);
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
                // Controllo che la preparazione sia riuscita
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoSingolo"]); // Usa il codice prodotto singolo dalla struttura
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
                // Controllo che la preparazione sia riuscita
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoConfigurabile"]); // Usa il codice prodotto singolo dalla struttura
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
                // Controllo che la preparazione sia riuscita
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoSingolo"]); // Usa il codice prodotto singolo dalla struttura
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
                // Controllo che la preparazione sia riuscita
                if ($stmt2) {
                    $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoConfigurabile"]); // Usa il codice prodotto singolo dalla struttura
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
                        // print_r($titolo);
                        // echo "   ----  ";
                        // print_r($strutturaKit[$i]["titolo_configurazione"]);
                        // echo "<br>";
                        if ($strutturaKit[$i]["titolo_configurazione"] === $titolo && $strutturaKit[$i]["codice_prodottoSingolo"] !== null) {
                            $sql2 = "SELECT * FROM ProdottoSingolo WHERE codice_univoco = ?";
                            $stmt2 = $conn->prepare($sql2);
                            // Controllo che la preparazione sia riuscita
                            if ($stmt2) {
                                $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoSingolo"]); // Usa il codice prodotto singolo dalla struttura
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
                            // Controllo che la preparazione sia riuscita
                            if ($stmt2) {
                                $stmt2->bind_param("s", $strutturaKit[$i]["codice_prodottoConfigurabile"]); // Usa il codice prodotto singolo dalla struttura
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
    //print_r($config);
    $json_config = json_encode($config);
    //print_r($nonConfig);
    $json_nonConfig = json_encode($nonConfig);
    //print_r($optional);
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

<body class="font-default">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="bg-white">
        <?php require("navbar.php"); ?>
        <!-- contenuto kit -->
        <!-- Breadcrumb -->
        <div class="container mx-auto mt-6 px-4">
            <nav class="text-gray-500 text-sm">
                <a href="../../../product" class="text-blue-500"><?= $page_translations['product'] ?></a> &gt;
                <a href="javascript:void(0);" onclick="window.history.back()" class="text-blue-500"><?php echo $navigazione[2]; ?></a> &gt;
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
                    <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($nome); ?></h1>
                    <p class="text-gray-700 mb-4">
                        <?php echo nl2br(htmlspecialchars($descrizione)); ?>
                    </p>
                    <div class="flex flex-wrap gap-5">
                        <p
                            class="inline-block px-4 py-2 border border-primary rounded-full">
                            <?php echo htmlspecialchars($codice_univoco); ?>
                        </p>
                        <?php if (!empty($pdf)) { ?>
                            <a href="/public/pdf/<?php echo htmlspecialchars($pdf); ?>" target="_blank" class="bg-primary rounded-full no-underline text-white px-4 py-2">
                                <?= $page_translations['code_quantity_btn'] ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Section: Components -->
            <section class="mt-[87px]">
                <h2 class="text-xl text-primary font-semibold my-[22px]"><?= $page_translations['components_list'] ?></h2>
                <!-- Non-Configurable Components -->
                <div class="w-full mt-8 flex gap-8 items-center">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semibold mb-[26px] w-max">
                            <?= $page_translations['non_configurable'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-center gap-[24px]" id="conponentiNonConfigurabili">
                </div>
                <!-- Configurable Components -->
                <div class="w-full mt-10 flex gap-8 items-center">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semibold mb-[26px] w-max">
                            <?= $page_translations['configurable'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </div>
                <div class="space-y-8" id="componentiConfigurabili">
                </div>
                <!-- Optional Components -->
                <div class="w-full mt-10 flex gap-8 items-center">
                    <div class="w-max">
                        <h3 class="text-lg text-primary font-semibold mb-[26px] w-max">
                            <?= $page_translations['optional'] ?>
                        </h3>
                    </div>
                    <div class="w-full bg-primary h-[1px]"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-center gap-[24px]" id="componentiOptional">
                </div>
            </section>
        </div>
        <?php require("footer.php"); ?>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
        // La variabile 'phpData' contiene i risultati della query in formato JSON
        const kit = <?php echo $json_kit; ?>;
        const strutturaKit = <?php echo $json_strutturaKit; ?>;
        const nonConfig = <?php echo $json_nonConfig; ?>;
        const optional = <?php echo $json_optional; ?>;
        const configItem = <?php echo $json_config; ?>;
        const componentiConfigurabili = document.getElementById("componentiConfigurabili");
        const conponentiNonConfigurabili = document.getElementById("conponentiNonConfigurabili");
        const componentiOptional = document.getElementById("componentiOptional");
        // Ora i dati sono disponibili in JavaScript
        console.log(kit[0]); // Stampa i dati per vedere il risultato
        console.log(kit[0].titoli_prodottiConfigurabili);
        console.log(strutturaKit); // Stampa i dati per vedere il risultato
        console.log(nonConfig);
        console.log(configItem);
        nonConfig.forEach(function(item) {
            console.log('Nome: ' + item);
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
            console.log('Nome: ' + item);
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
        // Esempio di come accedere ai dati
        // kit[0].titoli_prodottiConfigurabili.forEach(function(config) {
        //     console.log('Nome: ' + config);
        //     componentiConfigurabili.innerHTML += `<div class="flex items-center space-x-4">
        //                                     <div>
        //                                         <h4 class="font-semibold">` + config + `</h4>
        //                                         <div class="flex flex-wrap items-center gap-4 mt-4 mb[24px]" id="config-${config}"></div>
        //                                     </div>
        //                                 </div>`;
        //     const configId = document.getElementById(`config-${config}`); // Usa un ID unico
        //     configItem.forEach(function(item) {
        //         if (item.titolo == config) {
        //             console.log('Nome: ' + item.nome);
        //             if (item.immagine.includes("-")) {
        //                 var immagine = item.immagine.split("-");
        //                 configId.innerHTML += `<div class="flex flex-col items-center gap-[10px] me-4">
        //                                     <img
        //                                         src="/public/img/` + immagine[0] + `"
        //                                         loading="lazy"
        //                                         alt="` + item.nome + `"
        //                                         class="rounded-lg shadow w-[300px] h-[200px]" 
        //                                         onclick="window.location.href='redirect.php?id=` + item.id + `'"
        //                                         />
        //                                     <p>` + item.nome + `</p>
        //                                 </div>`;
        //             } else {
        //                 configId.innerHTML += `<div class="flex flex-col items-center gap-[10px] me-4">
        //                                     <img
        //                                         src="/public/img/` + item.immagine + `"
        //                                         loading="lazy"
        //                                         alt="` + item.nome + `"
        //                                         class="rounded-lg shadow w-[300px] h-[200px]" 
        //                                         onclick="window.location.href='redirect.php?id=` + item.id + `'"
        //                                         />
        //                                     <p>` + item.nome + `</p>
        //                                 </div>`;
        //             }
        //         }
        //     });
        // });
        kit[0].titoli_prodottiConfigurabili.forEach(function(config) {
            console.log("Nome: " + config);
            componentiConfigurabili.innerHTML += `
                <div class="space-y-4">
                    <h4 class="font-semibold text-lg">${config}</h4>
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
                    console.log("Nome: " + item.nome);
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
            console.log("Div interno: " + hiddendiv.innerHTML);
            if (hiddendiv.innerHTML == "") {
                console.log("VUOTOOOOO");
                console.log(hiddendiv);
                console.log(btnconfig);
                //hiddendiv.remove();
                if (btnconfig) {
                    btnconfig.classList.add("hidden");
                }
            }
            // Mostra la freccia solo se ci sono prodotti extra
            /* setTimeout(() => {
                if (extraProductsContainer.innerHTML.trim() !== "") {
                    const toggleBtn = firstProductContainer.querySelector(".toggle-products");
                    console.log("arrow")
                    toggleBtn.addEventListener("click", function() {
                        console.log("click")
                        extraProductsContainer.classList.toggle("hidden");
                        const arrow = toggleBtn.querySelector("i");
                        arrow.classList.toggle("bi-chevron-right");
                        arrow.classList.toggle("bi-chevron-left");
                    });
                }
            }, 0); */
            /* componentiConfigurabili.addEventListener("click", function(event) {
                if (event.target.closest(".toggle-products")) {
                    console.log("click");
                    const btn = event.target.closest(".toggle-products");
                    const extraProductsContainer = document.getElementById(btn.dataset.target);
                    extraProductsContainer.classList.toggle("hidden");
                    const arrow = btn.querySelector("i");
                    arrow.classList.toggle("bi-chevron-right");
                    arrow.classList.toggle("bi-chevron-left");
                }
            }); */
        });
        // Aggiungi la logica per il click sulla freccia
        document.querySelectorAll(".toggle-products").forEach(function(button) {
            button.addEventListener("click", function() {
                console.log(this.parentElement.parentElement.parentElement.children[1])
                const extraProducts = this.parentElement.parentElement.parentElement.children[1];
                // Log per verificare se i prodotti extra sono selezionati correttamente
                console.log(extraProducts);
                extraProducts.classList.toggle("hidden"); // Mostra o nascondi gli altri prodotti
                // Cambia l'icona della freccia
                const arrow = this.querySelector("i");
                if (arrow.classList.contains("bi-chevron-right")) {
                    arrow.classList.remove("bi-chevron-right");
                    arrow.classList.add("bi-chevron-left"); // Cambia la freccia verso sinistra
                } else {
                    arrow.classList.remove("bi-chevron-left");
                    arrow.classList.add("bi-chevron-right"); // Cambia la freccia verso destra
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
        updateCarousel(); // Initialize the carousel position
    }
</script>

</html>