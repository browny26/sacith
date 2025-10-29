<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $lang = $_GET['lang'] ?? 'it';

        function slugify($string)
        {
            $string = strtolower($string);

            $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

            $string = str_replace('&', 'and', $string);
            $string = str_replace(',', '_', $string);
            $string = str_replace(' ', '-', $string);

            $string = preg_replace('/[^a-z0-9\-_]/', '', $string);

            $string = preg_replace('/[-_]+/', '-', $string);

            return trim($string, '-_');
        }

        require("config.php");
        $conn = new mysqli($host, $username, $password, $db_name);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        // ProdottoSingolo
        $sql = "SELECT * FROM ProdottoSingolo WHERE codice_univoco = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $navigazione = $row["navigazione"];
                $name = $row["nome"];
                $primaParte = explode("/", $navigazione)[0];

                $navArray = explode("-", $primaParte);

                echo $row["navigazione"];
                print_r($navArray);
                $id = $row["id"];

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
                $primaParte = explode("/", $navigazione)[0];

                $navArray = explode("-", $primaParte);
                echo $row2["navigazione"];
                print_r($navArray);
                $id = $row2["id"];

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
                $primaParte = explode("/", $navigazione)[0];

                $navArray = explode("-", $primaParte);
                echo $row3["navigazione"];
                print_r($navArray);
                $id = $row3["id"];

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
        $conn->close();
    }
}
