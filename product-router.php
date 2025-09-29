<?php

/* $type = $_GET['type'] ?? null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$slug = $_GET['slug'] ?? null; */

$lang = $_GET['lang'] ?? 'en'; // es: en
$category = $_GET['category'] ?? null; // es: air-system
$subcat = $_GET['subcat'] ?? null; // es: airjet
$slug = $_GET['slug'] ?? null; // es: brass-micro-airjet
$type = $_GET['type'] ?? null; // es: singolo
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$type || !$id || !$slug || !in_array($type, ['singolo', 'kit', 'pc'])) {
    error_log("manca qualcosa: type={$type}, id={$id}, slug={$slug}");
    include("404.php");
    exit;
}

require("config.php");

$conn = new mysqli($host, $username, $password, (isset($_COOKIE['lang']) && $_COOKIE['lang'] == 'en' ? $db_name : $db_name_it));
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($type === 'singolo' && isset($_GET['id']) && isset($_GET['slug'])) {
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
} else if ($type === 'kit' && isset($_GET['id']) && isset($_GET['slug'])) {
    $sql = "SELECT id FROM Kit WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        include("kit.php");
        exit;
    }
} else if ($type === 'pc' && isset($_GET['id']) && isset($_GET['slug'])) {
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
