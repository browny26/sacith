<?php require("translator.php") ?>
<?php
// Gestione della richiesta GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica che l'ID e il tipo siano stati inviati tramite GET
    function slugifyName($str)
    {
        $str = strtolower($str);                  // minuscolo
        $str = str_replace(" & ", " and ", $str); // & -> and
        $str = str_replace(", ", "_", $str);      // virgole -> underscore
        $str = str_replace(" ", "-", $str);       // spazi -> trattini
        return rawurlencode($str);                // encode caratteri speciali
    }

    function formatName($str)
    {
        $str = rawurldecode($str);             // decode %20
        $str = str_replace("-", " ", $str);    // trattini -> spazi
        $str = str_replace(" and ", " & ", $str);    // trattini -> spazi
        $str = str_replace("_", ", ", $str);    // trattini -> spazi
        return ucwords(strtolower($str));      // Air System
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null; // Aggiunta per il slug

        require("config.php");
        // Connessione al database
        $lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'it');
        /* $db_to_use = ($lang === 'en') ? $db_name : $db_name_it;

        $conn = new mysqli($host, $username, $password, $db_to_use); */
        $host = "localhost";
        $user = "root";       // utente di XAMPP
        $password = "";       // di default la password è vuota
        $dbname = "sacith_it";   // il nome del database che hai creato
        $conn = new mysqli($host, $user, $password, $dbname);
        // Controllo della connessione
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        // Query SQL per ottenere il prodotto
        $sql = "SELECT * FROM ProdottoSingolo WHERE id = " . $id;
        $result = $conn->query($sql);
        // Variabili per i dettagli del prodotto
        $immagine = "/Logotipo_Sacith_Nosrl.png";  // Default image
        $nome = "Nome non disponibile";
        $codice_univoco = "Codice non disponibile";
        $descrizione = "";
        $dimensioni = "";
        $finiture = "";
        $materiali = "";
        // Verifica se sono stati trovati dei risultati
        if ($result->num_rows > 0) {
            // Estrai i dati dal risultato della query
            $row = $result->fetch_assoc();
            if ($row["immagine"] !== "" || $row["immagine"] !== null) {
                $immagine = $row["immagine"];
                $immagini = explode('-', $immagine);
                // print_r($immagini);
            }
            // Assegna i dati a variabili
            $nome = $row["nome"] ?? null;
            $codice_univoco = $row["codice_univoco"] ?? null;
            $descrizione = $row["descrizione"] ?? null;
            $dimensioni = $row["dimensioni"] ?? null;
            $dimensioni_array = !empty($dimensioni) ? explode('%', $dimensioni) : [];
            $finiture = $row["finiture"] ?? null;
            $materiali = $row["materiali"] ?? null;
            $pdf = $row["pdf"] ?? null;
            $navigazione = explode('-', $row["navigazione"]);
            // Chiudi la connessione al database
            $conn->close();
        } else {
            echo "Prodotto non trovato";
            exit;
        }
    } else {
        echo "ID o tipo non inviati.";
        exit;
    }
} else {
    echo "Metodo di richiesta non valido.";
    exit;
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
    <link rel="canonical" href="https://www.sacith.com/<?= htmlspecialchars($lang) ?>/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=singolo" />
    <link rel="alternate" hreflang="it" href="https://www.sacith.com/it/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=singolo" />
    <link rel="alternate" hreflang="en" href="https://www.sacith.com/en/product/<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>/<?= isset($_GET['subcat']) ? htmlspecialchars($_GET['subcat']) : '' ?>/<?= isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '' ?>?id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>&type=singolo" />
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

<body class="font-default">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WR87MMR4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="h-screen flex flex-col justify-between">
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
        <div class="container flex-1 mx-auto mt-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end">
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
                <div class="lg:col-span-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($nome); ?></h1>
                        <p class="text-gray-700 mb-4">
                            <?php echo nl2br(htmlspecialchars($descrizione)); ?>
                        </p>
                        <p
                            class="inline-block px-3 py-1 border border-primary rounded-full">
                            <?php echo htmlspecialchars($codice_univoco); ?>
                        </p>
                        <?php if (!empty($pdf)) { ?>
                            <a href="/public/pdf/<?php echo htmlspecialchars($pdf); ?>" target="_blank" class="bg-primary rounded-full no-underline text-white px-4 py-2 ml-5">
                                PDF
                            </a>
                        <?php } ?>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <?php if (!empty($dimensioni_array)) : ?>
                            <div>
                                <p class="font-bold mb-1"><?= $page_translations['dimensions'] ?></p>
                                <p class="text-sm"><?php
                                                    for ($i = 0; $i < count($dimensioni_array); $i++) {
                                                        // Stampa ogni elemento seguito da un a capo (HTML <br>)
                                                        echo $dimensioni_array[$i] . "<br>";
                                                    }
                                                    ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($finiture)) : ?>
                            <div>
                                <p class="font-bold mb-1"><?= $page_translations['finishes'] ?></p>
                                <p><?php echo htmlspecialchars($finiture); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($materiali)) : ?>
                            <div>
                                <p class="font-bold mb-1"><?= $page_translations['materials'] ?></p>
                                <p><?php echo htmlspecialchars($materiali); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require("footer.php"); ?>
    </div>
</body>
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
    updateCarousel(); // Initialize the carousel position
</script>

</html>