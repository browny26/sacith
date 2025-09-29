<?php require("translator.php") ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica che l'ID e il tipo siano stati inviati tramite GET
    if (isset($_GET['name']) && isset($_GET['parent'])) {
        // Decodifica e pulizia
        function formatName($str)
        {
            $str = rawurldecode($str);             // decode %20
            $str = str_replace("-", " ", $str);    // trattini -> spazi
            $str = str_replace(" and ", " & ", $str);    // trattini -> spazi
            $str = str_replace("_", ", ", $str);    // trattini -> spazi
            return ucwords(strtolower($str));      // Air System
        }
        $parent = isset($_GET['parent']) ? formatName($_GET['parent']) : '';
        $name = isset($_GET['name']) ? formatName($_GET['name']) : '';
        /* $name = html_entity_decode(rawurldecode($_GET["name"]));
        $parent = rawurldecode($_GET["parent"]);
        $parent = str_replace("-", " ", $parent);
        $parent = ucwords($parent); */
        require("config.php");
        //$conn = new mysqli($host, $username, $password, (isset($_COOKIE['lang']) && $_COOKIE['lang'] == 'en' ? $db_name : $db_name_it));
        $lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'it');
        $db_to_use = ($lang === 'en') ? $db_name : $db_name_it;
        $conn = new mysqli($host, $username, $password, $db_to_use);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        // Inizializza gli array
        $data = [];
        $kit = [];
        $pc = [];
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

        $queries = [
            ["SELECT * FROM ProdottoConfigurabile WHERE navigazione LIKE  '%$name%'", &$pc],
            ["SELECT * FROM Kit WHERE navigazione LIKE  '%$name%'", &$kit],
            ["SELECT * FROM ProdottoSingolo WHERE navigazione LIKE  '%$name%'", &$data]
        ];
        foreach ($queries as [$query, &$array]) {
            $result = $conn->query($query);
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
    <div class="flex flex-col min-h-screen overflow-hidden">
        <?php require("navbar.php"); ?>
        <div class="mt-5">
            <a href="../../product" class="ms-4 md:ps-10  no-underline text-primary">
                <i class="bi bi-arrow-left me-5"></i> <?= $page_translations['back'] ?>
            </a>
            <div class="flex gap-8 items-center mt-5 ms-4 mb-5 md:ps-10 overflow-hidden">
                <div class="w-max">
                    <p class="text-2xl font-bold text-primary w-max">
                        <?php
                        $nav_list = [
                            ["WHIRPOOL SYSTEMS", "Air System", "Basic Air Kit", "Blower", "Airjet", "Manifolds", "Pipes & Fittings", "Controls"],
                            ["WHIRPOOL SYSTEMS", "Water System", "Basic Hydro Kit", "Microjet Kit", "Pumps", "Jets", "Microjets", "Suctions", "Controls", "Pipes, Fittings & Disinfection"],
                            ["SHOWER SYSTEMS", "Shower Drains", "Shower Fittings", "Shower Jets", "Steam, Accessories & Fittings"]
                        ];
                        foreach ($nav_list as $nav) {
                            if (in_array(
                                $parent,
                                $nav
                            )) { // Controlla se $parent esiste in $nav
                                foreach ($nav as $n) {
                                    if ($n == $name) {
                                        echo $lang == "it" ? "SISTEMA IDROMASSAGGIO" : $nav[0]; // Stampa il primo elemento (nome della categoria principale)
                                        break; // Esci dal ciclo interno quando trovi la corrispondenza
                                    }
                                }
                            } else if (
                                strpos($parent, "Shower") !== false
                            ) {
                                echo $lang == "it" ? "SISTEMA DOCCE" : "SHOWER SYSTEMS";
                                break;
                            }
                        }
                        ?>
                    </p>
                </div>
                <div class="bg-primary w-full h-[1px]"></div>
            </div>
            <div class="ms-10 sm:ms-20">
                <div class="flex flex-col md:flex-row gap-10 w-screen mt-6">
                    <div class="col-span-8 md:col-span-1 flex flex-col gap-[20px] items-start max-w-[130px]">
                        <div class="flex flex-col font-medium text-lg text-primary min-w-max w-[270px]">
                            <?php
                            #$name = html_entity_decode($_GET["name"]); // Salviamo il valore per l'efficienza
                            $nav_list = [
                                ["WHIRPOOL SYSTEMS", "Air System", "Basic Air Kit", "Blower", "Airjet", "Manifolds", "Pipes & Fittings", "Controls"],
                                ["WHIRPOOL SYSTEMS", "Water System", "Basic Hydro Kit", "Microjet Kit", "Pumps", "Jets", "Microjets", "Suctions", "Controls", "Pipes, Fittings & Disinfection"],
                                ["SHOWER SYSTEMS", "Shower Drains", "Shower Fittings", "Shower Jets", "Steam, Accessories & Fittings"]
                            ];
                            foreach ($nav_list as $nav) {
                                if (in_array($name, $nav) && in_array(
                                    $parent,
                                    $nav
                                )) {
                                    // Verifica se il nome è presente nella lista
                                    if ($nav[0] == "WHIRPOOL SYSTEMS") {
                                        echo '<span class="hidden">' . $nav[1] . '</span>' . (($nav[1] == "Air System" || $nav[1] == "Water System") && $lang == "it" ?
                                            ($nav[1] == "Air System" ? "Sistema Aria" : "Sistema Acqua")
                                            : $nav[1]);
                                    }
                                    $json_nav = json_encode($nav);
                                }
                            }
                            ?>
                        </div>
                        <div>
                            <ul
                                role="list"
                                aria-labelledby="Brands-heading"
                                class="md:mt-6 space-y-2 md:space-y-6 sm:mt-4 sm:space-y-4">
                                <?php
                                //$name = html_entity_decode($_GET["name"]); // Salviamo il valore per l'efficienza
                                // Definizione delle liste in inglese e italiano
                                $nav_list_en = [
                                    ["WHIRPOOL SYSTEMS", "Air System", "Basic Air Kit", "Blower", "Airjet", "Manifolds", "Pipes & Fittings", "Controls"],
                                    ["WHIRPOOL SYSTEMS", "Water System", "Basic Hydro Kit", "Microjet Kit", "Pumps", "Jets", "Microjets", "Suctions", "Controls", "Pipes, Fittings & Disinfection"],
                                    ["SHOWER SYSTEMS", "Shower Drains", "Shower Fittings", "Shower Jets", "Steam, Accessories & Fittings"]
                                ];
                                $nav_list_ita = [
                                    ["SISTEMA IDROMASSAGGIO", "Sistema Aria", "Basic Air Kit", "Blower", "Airjet", "Collettori", "Tubi e Raccordi", "Comandi"],
                                    ["SISTEMA IDROMASSAGGIO", "Sistema Acqua", "Basic Hydro Kit", "Microjet Kit", "Pompe", "Bocchette", "Microjets", "Aspirazioni", "Comandi", "Tubi, Raccordi & Disinfezione"],
                                    ["SISTEMA DOCCE", "Scarichi Doccia", "Raccordi Doccia", "Bocchette Doccia", "Vapori, Tubi e Accessori"]
                                ];
                                // Dizionario di traduzione
                                $translations = [
                                    "WHIRPOOL SYSTEMS" => "SISTEMA IDROMASSAGGIO",
                                    "Air System" => "Sistema Aria",
                                    "Water System" => "Sistema Acqua",
                                    "Basic Air Kit" => "Basic Air Kit",
                                    "Blower" => "Blower",
                                    "Airjet" => "Airjet",
                                    "Manifolds" => "Collettori",
                                    "Pipes & Fittings" => "Tubi e Raccordi",
                                    "Controls" => "Comandi",
                                    "Basic Hydro Kit" => "Basic Hydro Kit",
                                    "Microjet Kit" => "Microjet Kit",
                                    "Pumps" => "Pompe",
                                    "Jets" => "Bocchette",
                                    "Microjets" => "Microjets",
                                    "Suctions" => "Aspirazioni",
                                    "Pipes, Fittings & Disinfection" => "Tubi, Raccordi & Disinfezione",
                                    "SHOWER SYSTEMS" => "SISTEMA DOCCE",
                                    "Shower Drains" => "Scarichi Doccia",
                                    "Shower Fittings" => "Raccordi Doccia",
                                    "Shower Jets" => "Bocchette Doccia",
                                    "Steam, Accessories & Fittings" => "Vapori, Tubi e Accessori"
                                ];
                                // Se la lingua è italiana, traduciamo il nome
                                $translated_name = ($lang === 'it' && isset($translations[$name])) ? $translations[$name] : $name;
                                $translated_parent = ($lang === 'it' && isset($translations[$parent])) ? $translations[$parent] : $parent;
                                /* echo "translated name: " . $translated_name;
                                echo '<br>';
                                echo "translated parent: " . $translated_parent;
                                echo '<br>'; */
                                // Seleziona la lista corretta in base alla lingua
                                $nav_list = ($lang === 'it') ? $nav_list_ita : $nav_list_en;
                                /* print_r($nav_list);
                                echo '<br>'; */
                                foreach ($nav_list as $nav) {
                                    if (in_array($translated_name, $nav)) { // Verifica se il nome è presente nella lista
                                        if ($nav[0] == "SHOWER SYSTEMS" || $nav[0] == "SISTEMA DOCCE") {
                                            for ($i = 1; $i < count($nav); $i++) { // Evitiamo di ripetere il nome stesso
                                                echo '<li class="flex" id="item">';
                                                if ($nav[$i] == $translated_name) {
                                                    echo '<a href="#" class="text-sm text-primary hover:text-gray-800">' . htmlspecialchars($nav[$i]) . '</a>';
                                                } else {
                                                    echo '<a href="#" class="text-sm hover:text-gray-800">' . htmlspecialchars($nav[$i]) . '</a>';
                                                }
                                                echo '</li>';
                                            }
                                            break;
                                        }
                                    }
                                }
                                foreach ($nav_list as $nav) {
                                    /* echo "translated name in array: " . in_array($translated_name, $nav);
                                    echo '<br>';
                                    echo "translated name in array: " . in_array($translated_parent, $nav);
                                    echo '<br>'; */
                                    if (in_array($translated_name, $nav) && in_array(
                                        $translated_parent,
                                        $nav
                                    )) { // Verifica se il nome è presente nella lista
                                        // Gestione caso specifico per Water System e Controls
                                        /* echo $nav[0];
                                        echo '<br>'; */
                                        $parentIndex = array_search($translated_parent, $nav);
                                        $nameIndex = array_search($translated_name, $nav);
                                        if ($parentIndex !== false && $nameIndex !== false && $parentIndex < $nameIndex) {
                                            // Verifica che Water System sia prima di Controls nella lista
                                            /* echo "in <br>"; */
                                            $waterSystemIndex = array_search($lang == 'it' ? "Sistema Acqua" : "Water System", $nav);
                                            $controlsIndex = array_search($lang == 'it' ? "Comandi" : "Controls", $nav);
                                            /* echo "waterSystemIndex: " . $waterSystemIndex;
                                            echo '<br>';
                                            echo "controlsIndex: " . $controlsIndex;
                                            echo '<br>'; */
                                            if ($waterSystemIndex < $controlsIndex) {
                                                for ($i = 2; $i < count($nav); $i++) {
                                                    echo '<li class="flex" id="item">';
                                                    if ($nav[$i] == $translated_name) {
                                                        echo '<a href="#" class="text-sm text-primary hover:text-gray-800">' . htmlspecialchars($nav[$i]) . '</a>';
                                                    } else {
                                                        echo '<a href="#" class="text-sm hover:text-gray-800">' . htmlspecialchars($nav[$i]) . '</a>';
                                                    }
                                                    echo '</li>';
                                                }
                                            }
                                        } else {
                                            // Gestione generale per gli altri casi
                                            $parentIndex = array_search($translated_parent, $nav);
                                            $nameIndex = array_search($translated_name, $nav);
                                            // Verifica che $parent venga prima di $name
                                            if ($parentIndex !== false && $nameIndex !== false && $parentIndex < $nameIndex) {
                                                for ($i = 2; $i < count($nav); $i++) {
                                                    echo '<li class="flex" id="item">';
                                                    if ($nav[$i] == $translated_name) {
                                                        echo '<a href="#" class="text-sm text-primary hover:text-gray-800">' . htmlspecialchars($nav[$i]) . '</a>';
                                                    } else {
                                                        echo '<a href="#" class="text-sm hover:text-gray-800">' . htmlspecialchars($nav[$i]) . '</a>';
                                                    }
                                                    echo '</li>';
                                                }
                                            }
                                        }
                                        break; // Uscita anticipata dopo aver trovato il nome
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-span-8 sm:col-span-7 flex-1 flex flex-col gap-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 w-fit justify-center md:justify-start items-center md:items-start gap-4 my-5" id="no_category">
                        </div>
                        <div class="flex flex-col items-start gap-4 my-5" id="product_container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require("footer.php"); ?>
    </div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    // La variabile 'phpData' contiene i risultati della query in formato JSON
    const products = <?php echo isset($json_data) ? $json_data : 'null'; ?>;
    const kits = <?php echo isset($json_kit) ? $json_kit : 'null'; ?>;
    const pc = <?php echo isset($json_pc) ? $json_pc : 'null'; ?>;
    const nav = <?php echo isset($json_nav) ? $json_nav : 'null'; ?>;
    console.log("NAV: ", nav);
    // Ora i dati sono disponibili in JavaScript
    let navigazione = [];
    console.log(pc); // Stampa i dati per vedere il risultato
    // Concatena navigazione dai pc
    if (pc && pc.length > 0) {
        pc.forEach(p => {
            if (p.navigazione) {
                navigazione.push(p.navigazione);
            }
        });
    }
    console.log(products); // Stampa i dati per vedere il risultato
    // Concatena navigazione dai prodotti
    if (products && products.length > 0) {
        products.forEach(prodotto => {
            if (prodotto.navigazione) {
                navigazione.push(prodotto.navigazione);
            }
        });
    }
    //console.log(navigazione);
    console.log(kits); // Stampa i dati per vedere il risultato
    // Concatena navigazione dai kits
    if (kits && kits.length > 0) {
        kits.forEach(kit => {
            if (kit.navigazione) {
                navigazione.push(kit.navigazione);
            }
        });
    }
    //console.log(navigazione);
    console.log("navigazione: ", navigazione);
    let navigation_list;
    navigazione.forEach(function(navig) {
        console.log("navig: ", navig);
        navig.forEach(function(n) {
            console.log("n-- :", n);
            console.log("nav-- :", nav);
            if (n[0] == "Shower System") {
                console.log("n: ", n);
                navigation_list = n;
            } else if (nav[1] == n[1]) {
                console.log(n);
                navigation_list = n;
            }
        })
    })
    console.log("navigationlist: ", navigation_list ?? null)
    const container = document.getElementById("product_container");
    let elementiAggiunti = new Set(); // Crea un Set per tenere traccia degli elementi già aggiunti
    if (navigazione[0][0].includes("Whirlpool System") || navigazione[0][0].includes("Whirlpool Systems")) {
        navigazione.forEach(function(nav) {
            nav.forEach(function(n) {
                if (navigation_list.length > 1 && n[1] === navigation_list[1] && n.length > 3 && !elementiAggiunti.has(n[3])) { // Controlla se esiste un quarto elemento e se non è già stato aggiunto
                    container.innerHTML += `
            <h3 class="font-bold text-lg text-primary">` + n[3] + `</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 justify-center md:justify-start items-center md:items-start gap-1 my-5" id="category-${n[3]}"></div>`;
                    console.log("n container", `category-${n[2]}`);
                    elementiAggiunti.add(n[3]); // Aggiungi l'elemento al Set per evitare duplicazioni future
                }
            });
        });
    } else {
        navigazione.forEach(function(nav) {
            nav.forEach(function(n) {
                if (navigation_list.length > 1 && n[1] === navigation_list[1] && n.length > 2 && !elementiAggiunti.has(n[2])) { // Controlla se esiste un quarto elemento e se non è già stato aggiunto
                    console.log("n container", `category-${n[2]}`)
                    container.innerHTML += `
            <h3 class="font-bold text-lg text-primary">` + n[2] + `</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 justify-center md:justify-start items-center md:items-start gap-1 my-5" id="category-${n[2]}"></div>`;
                    console.log(n[2]);
                    elementiAggiunti.add(n[2]); // Aggiungi l'elemento al Set per evitare duplicazioni future
                }
            });
        });
    }
    if (nav == null) {
        navigazione.forEach(function(nav) {
            nav.forEach(function(n) {
                if (navigation_list.length > 1 && n[0] === navigation_list[0] && n.length > 2 && !elementiAggiunti.has(n[2])) { // Controlla se esiste un quarto elemento e se non è già stato aggiunto
                    container.innerHTML += `
            <h3 class="font-bold text-lg text-primary">` + n[2] + `</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 4xl:grid-cols-5 justify-center md:justify-start items-center md:items-start gap-1 my-5" id="category-${n[2]}"></div>`;
                    console.log(n[2]);
                    elementiAggiunti.add(n[2]); // Aggiungi l'elemento al Set per evitare duplicazioni future
                }
            });
        });
    }
    var category = document.getElementById("category");
    // Inserimento dei prodotti nelle rispettive categorie
    if (nav != null) {
        console.log("nav != null", products)
        if (products) {
            products.forEach(function(prodotto) {
                let productCategory = prodotto.navigazione && prodotto.navigazione[0] && (prodotto.navigazione[0][0] == "Whirlpool System" ?
                    prodotto.navigazione[0][3] : prodotto.navigazione[0][2]);
                console.log("prodotto:", prodotto)
                console.log(prodotto.navigazione[0][0] == "Whirlpool System" ?
                    prodotto.navigazione[0][3] : prodotto.navigazione[0][2])
                console.log(prodotto.navigazione[0][0] == "Whirlpool System")
                console.log(prodotto.navigazione[0][0])
                console.log(productCategory)
                /* if (prodotto.navigazione) {
                    prodotto.navigazione.forEach(function(pn) {
                        if (pn[1] == navigation_list[1] && pn[2] == navigation_list[2]) {
                            productCategory = pn[3];
                            console.log("esiste sotto categoria", pn[3] ?? null)
                            console.log(" categoria", pn[2] ?? null)
                        }
                    })
                }
                //console.log("prodotto.navigazione[0]", prodotto.navigazione[0][0] ?? null)
                if (prodotto.navigazione && prodotto.navigazione[0] && prodotto.navigazione[0][0] && prodotto.navigazione[0][0] != "Whirlpool System") {
                    prodotto.navigazione.forEach(function(pn) {
                        if (pn[1] == navigation_list[1]) {
                            productCategory = pn[2];
                            console.log("esiste sotto categoria", prodotto.navigazione[0][3] ?? null)
                            console.log(" categoria", prodotto.navigazione[0][2] ?? null)
                        }
                    })
                } */
                if (prodotto.navigazione) {
                    prodotto.navigazione.forEach(function(pn) {
                        if (pn[1] == navigation_list[1]) {
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
                console.log("productCategory", productCategory);
                let categoryId = productCategory ? `category-${productCategory}` : 'no_category';
                let categoryContainer = document.getElementById(categoryId);
                console.log("categoryId", categoryId)
                if (categoryContainer) {
                    let image = []; // Inizializza come array
                    console.log(prodotto.immagine);
                    if (prodotto.immagine.includes("-")) {
                        image = prodotto.immagine.split('-'); // Divide le immagini in base al separatore
                        console.log('Immagini 1:', image);
                    } else if (Array.isArray(prodotto.immagine)) {
                        image = prodotto.img; // Usa direttamente l'array
                        console.log('Immagini 2:', image);
                    } else {
                        image = [prodotto.immagine]; // Caso fallback per immagine singola
                        console.log('Immagini 3:', image);
                    }
                    if (image[0] === "https://placehold.co/300x160") {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoSingolo">
                    <div class="flex flex-col gap-[10px] items-center" id="${prodotto.id}" data-type="singolo" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${prodotto.nome}">
                        <img src="${image[0]}" alt="${prodotto.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${prodotto.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    } else {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoSingolo">
                    <div class="flex flex-col gap-[10px] items-center" id="${prodotto.id}" data-type="singolo" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${prodotto.nome}">
                        <img src="/public/img/${image[0]}" alt="${prodotto.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${prodotto.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    }
                }
            });
        }
        if (kits) {
            kits.forEach(function(kit) {
                let kitCategory = kit.navigazione && kit.navigazione[0] && kit.navigazione[0][3];
                if (kit.navigazione) {
                    kit.navigazione.forEach(function(kn) {
                        if (kn[1] == navigation_list[1]) {
                            kitCategory = kn[3];
                        }
                    })
                }
                console.log(kitCategory);
                let categoryId = kitCategory ? `category-${kitCategory}` : 'no_category';
                let categoryContainer = document.getElementById(categoryId);
                if (categoryContainer) {
                    let image = []; // Inizializza come array
                    console.log(kit.immagine);
                    if (kit.immagine.includes("-")) {
                        image = kit.immagine.split('-'); // Divide le immagini in base al separatore
                        console.log('Immagini 1:', image);
                    } else if (Array.isArray(kit.immagine)) {
                        image = kit.img; // Usa direttamente l'array
                        console.log('Immagini 2:', image);
                    } else {
                        image = [kit.immagine]; // Caso fallback per immagine singola
                        console.log('Immagini 3:', image);
                    }
                    if (image[0] === "https://placehold.co/300x160") {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="Kit">
                    <div class="flex flex-col items-center gap-[10px]" id="${kit.id}"data-type="kit" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${kit.nome}">
                        <img src="${image[0]}" alt="${kit.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${kit.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    } else {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="Kit">
                    <div class="flex flex-col items-center gap-[10px]" id="${kit.id}" data-type="kit" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${kit.nome}">
                        <img src="/public/img/${image[0]}" alt="${kit.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${kit.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    }
                }
            });
        }
        if (pc) {
            pc.forEach(function(p) {
                let pCategory = p.navigazione && p.navigazione[0] && (p.navigazione[0][0] == "Whirlpool System" ?
                    p.navigazione[0][3] : p.navigazione[0][2]);

                /* console.log(p.navigazione[0][0] == "Whirlpool System" ?
                    p.navigazione[0][3] : p.navigazione[0][2])
                console.log(p.navigazione[0][0] == "Whirlpool System")
                console.log(p.navigazione[0][0])
                console.log(p.navigazione[0][3]) */

                console.log("p:", p.nome);

                console.log("p:", p.navigazione[0])

                console.log("pCategory", pCategory);
                /* if (p.navigazione) {
                    p.navigazione.forEach(function(pcn) {
                        if (pcn[1] == navigation_list[1]) {
                            pCategory = pcn[3];
                        }
                    })
                }

                if (p.navigazione[0][0] != "Whirlpool System") {
                    p.navigazione.forEach(function(pcn) {
                        if (pcn[1] == navigation_list[1]) {
                            pCategory = pcn[2];
                        }
                    } )
                }*/

                if (p.navigazione) {
                    p.navigazione.forEach(function(pn) {
                        if (pn[1] == navigation_list[1]) {
                            // Se è Whirlpool System o se esiste pn[3], usa pn[3], altrimenti pn[2]
                            if (pn[0] === "Whirlpool System" || pn[0] === "Whirlpool Systems" || typeof pn[3] !== 'undefined') {
                                console.log("pn[3]", pn[3])
                                pCategory = pn[3];
                            } else {
                                console.log("pn[2]", pn[2])
                                pCategory = pn[2];
                            }
                            console.log("Categoria selezionata:", pCategory);
                        }
                    });
                }

                console.log("pCategory", pCategory);
                /* let categoryId = pCategory && pCategory != undefined ? `category-${pCategory}` : 'no_category';
                console.log(categoryId)
                let categoryContainer = document.getElementById(categoryId); */
                let categoryId = pCategory ? `category-${pCategory}` : 'no_category';
                let categoryContainer = document.getElementById(categoryId);
                console.log("pc name", p.nome);
                console.log("categoryId", categoryId)
                if (categoryContainer) {
                    let image = []; // Inizializza come array
                    console.log(p.immagine);
                    if (p.immagine.includes("-")) {
                        image = p.immagine.split('-'); // Divide le immagini in base al separatore
                        console.log('Immagini 1:', image);
                    } else if (Array.isArray(p.immagine)) {
                        image = p.immagine; // Usa direttamente l'array
                        console.log('Immagini 2:', image);
                    } else {
                        image = [p.immagine]; // Caso fallback per immagine singola
                        console.log('Immagini 3:', image);
                    }
                    if (image[0] === "https://placehold.co/300x160") {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoConfigurabile">
                    <div class="flex flex-col items-center gap-[10px]" id="${p.id}" data-type="pc" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${p.nome}">
                        <img src="${image[0]}" alt="${p.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${p.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    } else {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoConfigurabile">
                    <div class="flex flex-col items-center gap-[10px]" id="${p.id}" data-type="pc" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${p.nome}">
                        <img src="/public/img/${image[0]}" alt="${p.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${p.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    }
                }
            });
        }
    } else {
        if (products) {
            products.forEach(function(prodotto) {
                let productCategory = prodotto.navigazione && prodotto.navigazione[0] && prodotto.navigazione[0][2];
                if (prodotto.navigazione) {
                    prodotto.navigazione.forEach(function(pn) {
                        if (pn[0] == navigation_list[0] && pn[1] == navigation_list[1]) {
                            productCategory = pn[2];
                        }
                    })
                }
                console.log(productCategory);
                let categoryId = productCategory ? `category-${productCategory}` : 'no_category';
                let categoryContainer = document.getElementById(categoryId);
                if (categoryContainer) {
                    let image = []; // Inizializza come array
                    console.log(prodotto.immagine);
                    if (prodotto.immagine.includes("-")) {
                        image = prodotto.immagine.split('-'); // Divide le immagini in base al separatore
                        console.log('Immagini 1:', image);
                    } else if (Array.isArray(prodotto.immagine)) {
                        image = prodotto.img; // Usa direttamente l'array
                        console.log('Immagini 2:', image);
                    } else {
                        image = [prodotto.immagine]; // Caso fallback per immagine singola
                        console.log('Immagini 3:', image);
                    }
                    if (image[0] === "https://placehold.co/300x160") {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoSingolo">
                    <div class="flex flex-col gap-[10px] items-center" id="${prodotto.id}" data-type="singolo" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${prodotto.nome}">
                        <img src="${image[0]}" alt="${prodotto.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${prodotto.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    } else {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoSingolo">
                    <div class="flex flex-col gap-[10px] items-center" id="${prodotto.id}" data-type="singolo" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${prodotto.nome}">
                        <img src="/public/img/${image[0]}" alt="${prodotto.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${prodotto.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    }
                }
            });
        }
        if (kits) {
            kits.forEach(function(kit) {
                let kitCategory = kit.navigazione && kit.navigazione[0] && kit.navigazione[0][2];
                if (kit.navigazione) {
                    kit.navigazione.forEach(function(kn) {
                        if (kn[0] == navigation_list[0]) {
                            kitCategory = kn[2];
                        }
                    })
                }
                console.log(kitCategory);
                let categoryId = kitCategory ? `category-${kitCategory}` : 'no_category';
                let categoryContainer = document.getElementById(categoryId);
                if (categoryContainer) {
                    let image = []; // Inizializza come array
                    console.log(kit.immagine);
                    if (kit.immagine.includes("-")) {
                        image = kit.immagine.split('-'); // Divide le immagini in base al separatore
                        console.log('Immagini 1:', image);
                    } else if (Array.isArray(kit.immagine)) {
                        image = kit.img; // Usa direttamente l'array
                        console.log('Immagini 2:', image);
                    } else {
                        image = [kit.immagine]; // Caso fallback per immagine singola
                        console.log('Immagini 3:', image);
                    }
                    if (image[0] === "https://placehold.co/300x160") {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="Kit">
                    <div class="flex flex-col items-center gap-[10px]" id="${kit.id}" data-type="kit" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${kit.nome}">
                        <img src="${image[0]}" alt="${kit.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${kit.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    } else {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="Kit">
                    <div class="flex flex-col items-center gap-[10px]" id="${kit.id}" data-type="kit" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${kit.nome}">
                        <img src="/public/img/${image[0]}" alt="${kit.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${kit.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    }
                }
            });
        }
        if (pc) {
            pc.forEach(function(p) {
                let pCategory = p.navigazione && p.navigazione[0] && p.navigazione[0][2];
                console.log(pCategory);
                if (p.navigazione) {
                    p.navigazione.forEach(function(pcn) {
                        if (pcn[0] == navigation_list[0]) {
                            pCategory = pcn[2] ?? null;
                        }
                    })
                }
                console.log(pCategory);
                let categoryId = pCategory ? `category-${pCategory}` : 'no_category';
                let categoryContainer = document.getElementById(categoryId);
                console.log("pc name", p.nome);
                console.log("categoryId", categoryId)
                console.log("categoryContainer", categoryContainer);
                if (categoryContainer) {
                    let image = []; // Inizializza come array
                    console.log(p.immagine);
                    if (p.immagine.includes("-")) {
                        image = p.immagine.split('-'); // Divide le immagini in base al separatore
                        console.log('Immagini 1:', image);
                    } else if (Array.isArray(p.immagine)) {
                        image = p.immagine; // Usa direttamente l'array
                        console.log('Immagini 2:', image);
                    } else {
                        image = [p.immagine]; // Caso fallback per immagine singola
                        console.log('Immagini 3:', image);
                    }
                    if (image[0] === "https://placehold.co/300x160") {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoConfigurabile">
                    <div class="flex flex-col items-center gap-[10px]" id="${p.id}" data-type="pc" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${p.nome}">
                        <img src="${image[0]}" alt="${p.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${p.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    } else {
                        categoryContainer.innerHTML += `
                <div class="col-span-1 flex flex-col items-center" id="ProdottoConfigurabile">
                    <div class="flex flex-col items-center gap-[10px]" id="${p.id}" data-type="pc" 
                        data-category="<?= $parent ?>" 
                        data-subcat="<?= $name ?>" 
                        data-slug="${p.nome}">
                        <img src="/public/img/${image[0]}" alt="${p.nome}" loading="lazy"
                            class="product-image cursor-pointer w-[250px] h-[150px] lg:w-[300px] lg:h-[200px] rounded-lg" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg w-[250px] lg:w-[300px] text-center">${p.nome}</h3>
                        </div>
                    </div>
                </div>`;
                    }
                }
            });
        }
    }
    var no_category = document.getElementById("no_category");
    if (no_category.innerHTML.trim() == null || no_category.innerHTML.trim() == "") {
        no_category.style.display = "none";
    }
    const productImages = document.querySelectorAll(".product-image"); // Seleziona tutte le immagini dei prodotti
    const kitImages = document.querySelectorAll(".kit-image"); // Seleziona tutte le immagini dei kit
    const pcImages = document.querySelectorAll(".pc-image"); // Seleziona tutte le immagini dei pc
    document.querySelectorAll(".product-image, .kit-image, .pc-image").forEach((img) => {
        img.addEventListener("click", () => {
            const lang = document.documentElement.lang || 'it';
            const card = img.closest("div");
            const idCard = card.id;
            const type = card.dataset.type;
            const category = card.dataset.category.replace(/&/g, "and").toLocaleLowerCase().replace(/ /g, "-");
            const subcat = card.dataset.subcat.normalize('NFD') // decomponi lettere accentate
                .replace(/[\u0300-\u036f]/g, '') // rimuovi accenti
                .replace(/&/g, 'and') // sostituisci &
                .replace(/, +/g, '_') // virgole + spazi con _
                .toLowerCase() // minuscole
                .replace(/ /g, '-') // spazi con trattini
                .replace(/[^a-z0-9-_]/g, '') // rimuovi caratteri non validi (incl. °)
            ;
            const slug = card.dataset.slug.normalize('NFD') // decomponi lettere accentate
                .replace(/[\u0300-\u036f]/g, '') // rimuovi accenti
                .replace(/&/g, 'and') // sostituisci &
                .replace(/, +/g, '_') // virgole + spazi con _
                .toLowerCase() // minuscole
                .replace(/ /g, '-') // spazi con trattini
                .replace(/[^a-z0-9-_]/g, '') // rimuovi caratteri non validi (incl. °)
            ;
            console.log("dati inviati:", {
                idCard,
                type,
                category,
                subcat,
                slug
            });
            if (!idCard || !type || !slug || !category || !subcat) {
                console.error("Dati mancanti");
                return;
            }
            
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: "product_click",
                product_name: slug,
            });
            
            const url = `/${lang}/product/${category}/${subcat}/${slug}?id=${idCard}&type=${type}`;
            setTimeout(() => {
                window.location.href = url;
            }, 200);
        });
    });
    // Gestisci il click sull'immagine del prodotto
    /* if (productImages) {
        productImages.forEach((img) => {
            img.addEventListener("click", () => {
                //let idCard = img.closest("div").id; // Ottieni l'id del prodotto o del kit
                //let type = img.closest("div").parentElement.id; // Ottieni il tipo, "ProdottoSingolo" o "Kit"
                const lang = document.cookie.lang || 'it'; // Ottieni la lingua dalla cookie, default a 'it'
                console.log("Lingua:", lang);
                const card = img.closest("div");
                const idCard = card.id;
                const type = card.dataset.type;
                const category = card.dataset.category.toLocaleLowerCase().replace(/ /g, "-");
                const subcat = card.dataset.subcat.toLocaleLowerCase().replace(/ /g, "-");
                const slug = card.dataset.slug.toLocaleLowerCase().replace(/ /g, "-");
                console.log("ID Card:", idCard);
                console.log("Type:", type);
                console.log("Category:", category);
                console.log("Subcat:", subcat);
                console.log("Slug:", slug);
                if (!idCard || !type || !slug || !category || !subcat) {
                    console.error("Dati mancanti");
                    return;
                }
                if (type === "ProdottoSingolo") {
                    // Fai una richiesta GET per il prodotto
                    $.ajax({
                        url: "single-product.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        error: function(jqXHR, textStatus, errorThrown) {},
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    }); 
                    /window.location.href = `single-product.php?id=${idCard}&type=${type}`;
                } else if (type === "Kit") {
                    $.ajax({
                        url: "kit.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `kit.php?id=${idCard}&type=${type}`;
                } else if (type === "ProdottoConfigurabile") {
                    $.ajax({
                        url: "configurable-product.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `configurable-product.php?id=${idCard}&type=${type}`;
                }
            });
        });
    }
    if (kitImages) {
        kitImages.forEach((img) => {
            img.addEventListener("click", () => {
                let idCard = img.closest("div").id;
                let type = img.closest("div").parentElement.id;
                console.log(idCard);
                console.log(type);
                if (type === "ProdottoSingolo") {
                    $.ajax({
                        url: "single-product.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `single-product.php?id=${idCard}&type=${type}`;
                } else if (type === "Kit") {
                    $.ajax({
                        url: "kit.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `kit.php?id=${idCard}&type=${type}`;
                } else if (type === "ProdottoConfigurabile") {
                    $.ajax({
                        url: "configurable-product.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `configurable-product.php?id=${idCard}&type=${type}`;
                }
            });
        });
    }
    if (pcImages) {
        pcImages.forEach((img) => {
            img.addEventListener("click", () => {
                let idCard = img.closest("div").id;
                let type = img.closest("div").parentElement.id;
                console.log(idCard);
                console.log(type);
                if (type === "ProdottoSingolo") {
                    $.ajax({
                        url: "single-product.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `single-product.php?id=${idCard}&type=${type}`;
                } else if (type === "Kit") {
                    $.ajax({
                        url: "kit.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `kit.php?id=${idCard}&type=${type}`;
                } else if (type === "ProdottoConfigurabile") {
                    $.ajax({
                        url: "configurable-product.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            'id': idCard,
                            'type': type
                        },
                        success: function(result) {
                            console.log("Dati inviati: " + result);
                        }
                    });
                    window.location.href = `configurable-product.php?id=${idCard}&type=${type}`;
                }
            });
        });
    } */
</script>
<script>
    const items = document.querySelectorAll("#item");
    //const nav = <?php echo isset($json_nav) ? $json_nav : 'null'; ?>;
    console.log("nav: ", nav)

    const translations = {
        "SISTEMA IDROMASSAGGIO": "WHIRPOOL SYSTEMS",
        "Sistema Aria": "Air System",
        "Sistema Acqua": "Water System",
        "Basic Air Kit": "Basic Air Kit",
        "Blower": "Blower",
        "Airjet": "Airjet",
        "Collettori": "Manifolds",
        "Tubi e Raccordi": "Pipes & Fittings",
        "Comandi": "Controls",
        "Basic Hydro Kit": "Basic Hydro Kit",
        "Microjet Kit": "Microjet Kit",
        "Pompe": "Pumps",
        "Bocchette": "Jets",
        "Microjets": "Microjets",
        "Aspirazioni": "Suctions",
        "Tubi, Raccordi & Disinfezione": "Pipes, Fittings & Disinfection",
        "SISTEMA DOCCE": "SHOWER SYSTEMS",
        "Scarichi Doccia": "Shower Drains",
        "Raccordi Doccia": "Shower Fittings",
        "Bocchette Doccia": "Shower Jets",
        "Vapori, Tubi e Accessori": "Steam, Accessories & Fittings"
    };
    // Funzione per ottenere il valore in inglese
    function getEnglishTerm(term) {
        return translations[term] || term; // Se non esiste una traduzione, restituisce l'originale
    }

    function decodeHtmlEntities(text) {
        const txt = document.createElement("textarea");
        txt.innerHTML = text;
        return txt.value;
    }

    if (nav == null) {
        items.forEach((item) => {
            item.addEventListener("click", () => {
                console.log(getEnglishTerm(item.children[0].innerHTML));
                console.log(getEnglishTerm(item.parentElement.parentElement.parentElement.parentElement.children[0].children[1].innerText));
                let pr = getEnglishTerm(item.children[0].innerHTML);
                console.log("pr:", pr);
                let nr = pr.includes("Shower") || pr.includes("Steam") ? "Shower System" : item.parentElement.parentElement.parentElement.parentElement.children[0].children[0].children[1].innerText;
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

                console.log("encodedPr:", encodedPr);
                const lang = document.documentElement.lang
                console.log("Lingua:", lang);
                let slug = pr.toLowerCase().replace(/\s+/g, '-');
                let newUrl = `/${lang}/product/${encodedNr}/${encodedPr}`;
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                  event: "category_click",
                  category_name: encodedNr, // es: accessories
                  item_name: encodedPr      // es: basic-hydro-kit
                });

                setTimeout(() => {
                window.location.href = newUrl;
                }, 200);
            });
        });
    } else {
        items.forEach((item) => {
            item.addEventListener("click", () => {
                console.log(getEnglishTerm(item.children[0].innerHTML));
                console.log(getEnglishTerm(item.parentElement.parentElement.parentElement.parentElement.children[0].children[0].innerHTML.trim()));
                let rawText = item.children[0].innerHTML;
                let decodedPr = decodeHtmlEntities(rawText);
                let pr = getEnglishTerm(decodedPr);
                let nr = pr.includes("Shower") ? "Shower System" : item.parentElement.parentElement.parentElement.parentElement.children[0].children[0].children[0].innerHTML.trim();
                console.log(nr)
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

                console.log("encodedPr:", encodedPr);
                /* $.ajax({
                    url: "productsPage.php",
                    method: "GET",
                    dataType: "html",
                    data: {
                        name: encodedPr,
                        parent: encodedNr,
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Errore: " + textStatus + " " + errorThrown);
                    },
                    success: function(result) {
                        console.log("Dati inviati: " + result);
                    },
                }); */
                const lang = document.documentElement.lang
                console.log("Lingua:", lang);
                let newUrl = `/${lang}/product/${encodedNr}/${encodedPr}`;
               window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                  event: "category_click",
                  category_name: encodedNr, // es: accessories
                  item_name: encodedPr      // es: basic-hydro-kit
                });

                setTimeout(() => {
                window.location.href = newUrl;
                }, 200);
            });
        });
    }
</script>
<!-- <script>
    if (nav == null) {
        items.forEach((item) => {
            item.addEventListener("click", () => {
                console.log(item.children[0].innerHTML);
                console.log(item.parentElement.parentElement.parentElement.parentElement.children[0].children[1].innerText);
                let pr = item.children[0].innerHTML;
                let nr = item.parentElement.parentElement.parentElement.parentElement.children[0].children[1].innerText;
                let encodedPr = encodeURIComponent(pr);
                let encodedNr = encodeURIComponent(nr);
                let newUrl = `products-page.php?name=${encodedPr}&parent=${encodedNr}`;
                window.location.href = newUrl;
            });
        });
    } else {
        items.forEach((item) => {
            item.addEventListener("click", () => {
                console.log(item.children[0].innerHTML);
                console.log(item.parentElement.parentElement.parentElement.parentElement.children[0].children[0].innerHTML.trim());
                let pr = item.children[0].innerHTML;
                console.log("nav[0]", nav[0])
                //let nr = nav[0] == "SHOWER SYSTEMS" ? "Shower DrainsShower FittingsShower JetsSteam, Accessories & Fittings" : item.parentElement.parentElement.parentElement.parentElement.children[0].children[0].innerHTML.trim();
                let nr = nav[0] == "SHOWER SYSTEMS" ? "Shower System" : item.parentElement.parentElement.parentElement.parentElement.children[0].children[0].innerHTML.trim();
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
                /* $.ajax({
                    url: "productsPage.php",
                    method: "GET",
                    dataType: "html",
                    data: {
                        name: encodedPr,
                        parent: encodedNr,
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Errore: " + textStatus + " " + errorThrown);
                    },
                    success: function(result) {
                        console.log("Dati inviati: " + result);
                    },
                }); */
                //let newUrl = `products-page.php?name=${encodedPr}&parent=${encodedNr}`;
                //const lang = document.cookie.lang || 'en';
                const lang = document.documentElement.lang
                console.log("Lingua:", lang);
                let newUrl = `/${lang}/product/${encodedNr}/${encodedPr}`;
                window.location.href = newUrl;
            });
        });
    }
</script>
 -->

</html>