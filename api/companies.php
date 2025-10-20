<?php
require_once("database.php");
header('Content-Type: application/json');

$gref = $_GET['gref'] ?? null;

//statements are based on db structure
if ($gref) {
    $stmt = $pdo->prepare("SELECT * FROM companies WHERE gref = :gref");
    $stmt->execute(['gref' => $gref]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($company);
} else {
    $stmt = $pdo->query("SELECT * FROM companies");
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($companies);
}
?>
