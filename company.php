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
                echo "<th>Name: " . $companies['name'] . "</th>";
                echo "<th>Symbol: " . $companies['symbol'] . "</th>";
                echo "<th>Sector: " . $companies['sector'] . "</th>";
                echo "<th>subindustry: " . $companies['subindustry'] . "</th>";
                echo "<th>Address: " . $companies['address'] . "</th>";
                echo "<th>Exchange: " . $companies['exchange'] . "</th>";
                echo "<th>Website:<a href='" . $companies['website'] ."'>". $companies['website']. "</th>";
                echo "description: " . $companies['description'] . "</th>";
                echo "</tr>";
                echo "</table>";
                echo "<label for = 'financials'><h2>Financial Information</h2></label>";
                
        ?>

        </div>
            
    </body>
</html>

