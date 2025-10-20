<?php
require_once('database.php');
header('Content-Type: application/json');
$gref = $_GET['gref'] ?? null;


//statements are based on db structure
if ($gref) {
    $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE gref = :gref");
    $stmt->execute(['gref' => $gref]);
    $portfolio = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($portfolio);
} else {
    $stmt = $pdo->query("SELECT * FROM portfolio");
    $portfolio = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($portfolio);
}