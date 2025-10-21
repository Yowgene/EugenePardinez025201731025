<?php
    try {
        $pdo = new PDO('sqlite:../data/stocks.db'); //pdo connection on SQLite database
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $ref = $_GET['ref'] ?? null; //get the reference from the apitest.php, this will be used to search for symbol
        if ($ref) {//if/else statement to check if there is a reference input
            $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE userId = :ref");
            $stmt->execute([':ref' => $ref]); //using ref to execute the search
            $comp = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all results
            echo json_encode($comp); //encode in json format
    } else {//if theres not reference, 
        $stmt = $pdo->query("SELECT * FROM portfolio");//statement and query search
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all results
        echo json_encode($users); //encode in json format
    }
$pdo = null; //close the connection
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>