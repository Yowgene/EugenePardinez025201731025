<?php
    try {
        $pdo = new PDO('sqlite:data/stocks.db');
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Project</title>
    <link rel="stylesheet" href="css/styles.css">

</head>
    <body>
        <h1>Porfolio Project</h1>
        <div class="nav">
            <h2><a href="index.php">Home</a></h2>
            <h2><a href="about.php">About</a></h2>
            <h2><a href="apitest.php">APIs</a></h2>
        </div>
        <div class="company_info">
            <?php
                $cmp = $_GET['comp'] ?? null;
                $sql = "SELECT * FROM companies WHERE name = :comp OR symbol = :comp";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':comp' => $cmp]);
                $companies = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<label for= 'compinfo'><h2>Company Information</h2></label>";
                echo "<table class = 'compinfo'>";
                echo "<tr>";
                echo "<th><strong>Name: </strong>" . $companies['name'] . "</th>";
                echo "<th><strong>Symbol: </strong>" . $companies['symbol'] . "</th>";
                echo "<th><strong>Sector: </strong>" . $companies['sector'] . "</th>";
                echo "<th><strong>subindustry: </strong>" . $companies['subindustry'] . "</th>";
                echo "<th><strong>Address: </strong>" . $companies['address'] . "</th>";
                echo "<th><strong>Exchange: </strong>" . $companies['exchange'] . "</th>";
                echo "<th><strong>Website:<a href='" . $companies['website'] ."'></strong>". $companies['website']. "</th>";
                echo "<strong>Description: </strong>" . $companies['description'] . "</th>";
                echo "</tr>";
                echo "</table>";
                echo "<label for = 'financials'><h2>History</h2></label>";
                echo "<table class = 'financials'>";
                $sql = "SELECT * FROM history WHERE symbol = :comp";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':comp' => $cmp]);
                $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<tr>";
                foreach ($history as $history) {
                    echo "<th>Date: $" . $history['date'] . "</th>";
                    echo "<th>Volume: " . $history['volume'] . "</th>";
                    echo "<th>Open: $" . number_format((float)$history['open'],2) . "</th>";
                    echo "<th>Close: $" . number_format((float)$history['close'],2) . "</th>";
                    echo "<th>High: $" . number_format((float)$history['high'],2) . "</th>";
                    echo "<th>Low: $" . number_format((float)$history['low'],2) . "</th>";
                    echo "</tr>";
                }
                echo "</table>";
                
        ?>

        </div>
            
    </body>
</html>

