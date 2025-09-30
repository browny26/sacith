<?php
$lang = $_GET['lang'] ?? 'en'; // es: en
$family = $_GET['family'] ?? null; // es: hydromassage
$subfamily = $_GET['subfamily'] ?? null; // es: whirlpool-systemn
$type = $_GET['type'] ?? null; // es: controls
$category = $_GET['category'] ?? null; // es: air-system
$slug = $_GET['slug'] ?? null; // es: brass-micro-airjet
$c = $_GET['c'] ?? null; // es: singolo
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id || !$slug || !in_array($c, ['singolo', 'kit', 'pc'])) {
    error_log("manca qualcosa: type={$type}, id={$id}, slug={$slug}");
    include("404.php");
    exit;
}

/* require("config.php"); */
$host = "localhost";
$user = "root";       // utente di XAMPP
$password = "";       // di default la password è vuota
$dbname = "sacith_it";   // il nome del database che hai creato
$conn = new mysqli($host, $user, $password, $dbname);
//$conn = new mysqli($host, $username, $password, (isset($_COOKIE['lang']) && $_COOKIE['lang'] == 'en' ? $db_name : $db_name_it));
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($c === 'singolo' && isset($_GET['id']) && isset($_GET['slug'])) {
    $sql = "SELECT id FROM ProdottoSingolo WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        include("single-product.php");
        exit;
    }
    error_log("non lo trovo");
} else if ($c === 'kit' && isset($_GET['id']) && isset($_GET['slug'])) {
    $sql = "SELECT id FROM Kit WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        include("kit.php");
        exit;
    }
} else if ($c === 'pc' && isset($_GET['id']) && isset($_GET['slug'])) {
    $sql = "SELECT id FROM ProdottoConfigurabile WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        include("configurable-product.php");
        exit;
    }
}

// Nessun risultato
include("404.php");
exit;
