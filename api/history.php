<?php
require_once('database.php');
header('Content-Type: application/json');
$gref = $_GET['gref'] ?? null;

//statements are based on db structure
if ($gref) {
    $stmt = $pdo->prepare("SELECT * FROM history WHERE gref = :gref");
    $stmt->execute(['gref' => $gref]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($history);
} else {
    $stmt = $pdo->query("SELECT * FROM history");
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($history);
}