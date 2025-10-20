<?php
require_once('database.php');
header('Content-Type: application/json');
$gref = $_GET['gref'] ?? null;

//statements are based on db structure
if ($gref) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE gref = :gref");
    $stmt->execute(['gref' => $gref]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($portfolio);
} else {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
}
?>