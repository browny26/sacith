<?php
// Gestione della richiesta GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $lang = $_GET['lang'] ?? 'it'; // Imposta la lingua predefinita a 'it'

        function slugify($string)
        {
            // Converti in minuscolo
            $string = strtolower($string);

            // Rimuovi accenti e caratteri Unicode strani
            $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

            // Sostituzioni personalizzate
            $string = str_replace('&', 'and', $string);
            $string = str_replace(',', '_', $string);
            $string = str_replace(' ', '-', $string);

            // Rimuovi tutti i caratteri tranne lettere, numeri, trattino e underscore
            $string = preg_replace('/[^a-z0-9\-_]/', '', $string);

            // Riduci trattini e underscore multipli
            $string = preg_replace('/[-_]+/', '-', $string);

            // Rimuovi eventuali trattini o underscore iniziali/finali
            return trim($string, '-_');
        }

        // Credenziali del database
        require("config.php");
        // Connessione al database
        $conn = new mysqli($host, $username, $password, $db_name);
        // Controllo della connessione
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        // Usare query preparate per prevenire SQL Injection
        // ProdottoSingolo
        $sql = "SELECT * FROM ProdottoSingolo WHERE codice_univoco = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $id); // 's' indica che $id è una stringa
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $navigazione = $row["navigazione"];
                $name = $row["nome"];
                // 1. Prendi la prima parte prima dello slash
                $primaParte = explode("/", $navigazione)[0];

                // 2. Dividi quella parte usando il trattino "-"
                $navArray = explode("-", $primaParte);

                echo $row["navigazione"];
                print_r($navArray);
                $id = $row["id"];

                // Costruzione dell'URL
                $url = 'https://www.sacith.com/' . $lang
                    . '/product/' . slugify($navArray[1])
                    . '/' . slugify($navArray[2])
                    . '/' . slugify($name)
                    . '?id=' . $id . '&type=singolo';
                header("Location: $url");
                exit;
            }
        }
        // Kit
        $sql2 = "SELECT * FROM Kit WHERE codice_univoco = ?";
        if ($stmt2 = $conn->prepare($sql2)) {
            $stmt2->bind_param("s", $id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $id = $row2["id"];
                $navigazione = $row2["navigazione"];
                $name = $row2["nome"];
                // 1. Prendi la prima parte prima dello slash
                $primaParte = explode("/", $navigazione)[0];

                // 2. Dividi quella parte usando il trattino "-"
                $navArray = explode("-", $primaParte);
                echo $row2["navigazione"];
                print_r($navArray);
                $id = $row2["id"];

                // Costruzione dell'URL
                $url = 'https://www.sacith.com/' . $lang
                    . '/product/' . slugify($navArray[1])
                    . '/' . slugify($navArray[2])
                    . '/' . slugify($name)
                    . '?id=' . $id . '&type=singolo';
                header("Location: $url");
                exit;
                exit;
            }
        }
        // ProdottoConfigurabile
        $sql3 = "SELECT * FROM ProdottoConfigurabile WHERE codice_base = ?";
        if ($stmt3 = $conn->prepare($sql3)) {
            $stmt3->bind_param("s", $id);
            $stmt3->execute();
            $result3 = $stmt3->get_result();
            if ($result3->num_rows > 0) {
                $row3 = $result3->fetch_assoc();
                $id = $row3["id"];
                $navigazione = $row3["navigazione"];
                $name = $row3["nome"];
                // 1. Prendi la prima parte prima dello slash
                $primaParte = explode("/", $navigazione)[0];

                // 2. Dividi quella parte usando il trattino "-"
                $navArray = explode("-", $primaParte);
                echo $row3["navigazione"];
                print_r($navArray);
                $id = $row3["id"];

                // Costruzione dell'URL
                $url = 'https://www.sacith.com/' . $lang
                    . '/product/' . slugify($navArray[1])
                    . '/' . slugify($navArray[2])
                    . '/' . slugify($name)
                    . '?id=' . $id . '&type=pc';
                header("Location: $url");
                exit;
                exit;
            }
        }
        // Chiudi la connessione
        $conn->close();
    }
}
