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
        <div class="content">
            <div class="table_customers">
            <?php
                $stmt = $pdo->query("SELECT * FROM users ORDER BY lastname ASC");
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<table>";
                echo "<tr><th><strong>Customers</strong></th></tr>";
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td><a href='?userId=" . $user['id'] . "'>" . $user['lastname'] . " " . $user['firstname'] . "</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            ?>
            </div>
            <div class="table_info">
                <?php
                $selected_userId = $_GET['userId'] ?? null;
                if (!$selected_userId) { //checks if there is a selected user or input
                    echo "<p>Please select a user to view portfolio details.</p>";

                } else {
                    //this is for total companies
                    $sql = "SELECT COUNT(*) as total_companies FROM portfolio WHERE userId = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':id' => $selected_userId]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $totalcompanies = $result['total_companies'] ?? 0; //gets the total companies in the portfolio
                    //this is for total amount
                    $sql = "SELECT SUM(amount) as total_amount FROM portfolio WHERE userId = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':id' => $selected_userId]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $totalamount = $result['total_amount'] ?? 0; //gets the total amount of shares in the portfolio
                    //this is for total cash
                    $sql = "SELECT p.userId, p.symbol, p.amount, h.close, (p.amount * h.close) as total_cash 
                            FROM portfolio p
                            JOIN history h ON p.symbol = h.symbol
                            WHERE p.userId = :id 
                            AND h.date = (SELECT MAX(date) FROM history y WHERE y.symbol = p.symbol)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':id' => $selected_userId]); //based on the internet, id will be selected from the response from user.
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $totalcash = 0;
                    foreach ($result as $row) {
                        $totalcash += $row['total_cash'];
                    }
                    echo "<h3>Portfolio Summary</h3>";
                    echo "<table border='1'>
                          <tr class='table-header'>
                            <th><strong>Companies</strong></th>
                            <th><strong># of Shares</strong></th>
                            <th><strong>Total Value</strong></th>
                          </tr>";
                    echo "<tr>";
                    echo "<th>". $totalcompanies . "</th>";
                    echo "<th>". $totalamount . "</th>";
                    echo "<th>$". $totalcash . "</th>";
                    echo "</tr>";
                    echo "</table>";
                //this is for the details of the companies
                echo "<h3>Portfolio Details</h3>";
                echo "<table border='1'>
                      <tr class='table-header'>
                        <th><strong></strong>Symbol</th>
                        <th><strong>Name</strong></th>
                        <th><strong>Sector</strong></th>
                        <th><strong>Amount</strong></th>
                        <th><strong>Value</strong></th>
                      </tr>";
                $sql = "SELECT c.name, c.sector, p.symbol, p.amount, h.close, (p.amount * h.close) as total_value
                        FROM portfolio p
                        JOIN companies c ON p.symbol = c.symbol
                        JOIN history h ON p.symbol = h.symbol
                        WHERE p.userId = :id
                        AND h.date = (SELECT MAX(date) FROM history y WHERE y.symbol = p.symbol)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $selected_userId]); //based on the internet, id will be selected from the response from user.
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<th><a href='company.php?comp=" . $row['symbol'] ."'>" .$row['symbol'] . "</a></th>";
                    echo "<th><a href='company.php?comp=" .$row['name'] ."'>".$row['name'] . "</th>";
                    echo "<th>" .$row['sector'] . "</th>";
                    echo "<th>" .$row['amount'] . "</th>";
                    echo "<th>$" . $row['total_value'] . "</th>";
                    echo "</tr>";
                }

                }
                ?>
            </div>
    </body>
</html>

