<?php
//this accesses the companies and history tables to display company information and historical financial data
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
                $cmp = $_GET['comp'] ?? null; //get the company from the users input
                $sql = "SELECT * FROM companies WHERE name = :comp OR symbol = :comp"; //sql statement to search for company name or symbol
                $stmt = $pdo->prepare($sql); //preparing the statement
                $stmt->execute([':comp' => $cmp]); //execute the search using the company input
                $companies = $stmt->fetch(PDO::FETCH_ASSOC); //fetch the company information
                //this is echo for company information in html format
                echo "<label for= 'compinfo'><h2>Company Information</h2></label>"; //label for company information
                echo "<table class = 'compinfo'>"; //table for company information, easier css styling
                echo "<tr>";
                echo "<th><strong>Name: </strong>" . $companies['name'] . "</th>"; //company name
                echo "<th><strong>Symbol: </strong>" . $companies['symbol'] . "</th>"; //company symbol
                echo "<th><strong>Sector: </strong>" . $companies['sector'] . "</th>"; //company sector
                echo "<th><strong>subindustry: </strong>" . $companies['subindustry'] . "</th>"; //company subindustry
                echo "<th><strong>Address: </strong>" . $companies['address'] . "</th>"; //company address
                echo "<th><strong>Exchange: </strong>" . $companies['exchange'] . "</th>"; //company exchange
                echo "<th><strong>Website:<a href='" . $companies['website'] ."'></strong>". $companies['website']. "</th>"; //company website
                echo "<strong>Description: </strong>" . $companies['description'] . "</th>"; //company description
                echo "</tr>";
                echo "</table>";
                echo "<label for = 'financials'><h2>History</h2></label>"; //added label for history section
                echo "<table class = 'financials'>"; //table for history, easier css styling
                $sql = "SELECT * FROM history WHERE symbol = :comp"; //sql statement to search for company history
                $stmt = $pdo->prepare($sql); //preparing the statement
                $stmt->execute([':comp' => $cmp]); //execute the search using the company input
                $history = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all history records
                echo "<tr>";
                foreach ($history as $history) { //loop through each history record
                    echo "<th>Date: $" . $history['date'] . "</th>"; //date
                    echo "<th>Volume: " . $history['volume'] . "</th>"; //volume
                    echo "<th>Open: $" . number_format((float)$history['open'],2) . "</th>"; //open and made it a float with 2 decimal places
                    echo "<th>Close: $" . number_format((float)$history['close'],2) . "</th>"; //close and made it a float with 2 decimal places
                    echo "<th>High: $" . number_format((float)$history['high'],2) . "</th>"; //high and made it a float with 2 decimal places
                    echo "<th>Low: $" . number_format((float)$history['low'],2) . "</th>"; //low and made it a float with 2 decimal places
                    echo "</tr>";
                }
                echo "</table>";
        $pdo = null; //close the connection
        ?>

        </div>
            
    </body>
</html>

