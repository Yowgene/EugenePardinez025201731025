<?php
//apitest.php, this should provide links to the different api files created
//i'ved put it in a table for better visuals and structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Portfolio Project</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
   <body>
        <h1>Porfolio Project</h1>
        <div class="nav">
            <h2><a href="index.php">Home</a></h2>
            <h2><a href="about.php">About</a></h2>
            <h2><a href="apitest.php">APIs</a></h2>
        </div>
    <label for="api">APIs</label>
    <table class="api">
        <tr>
            <th><strong>URL</strong></th>
            <th><strong>Description</strong></th>
        </tr>
        <tr>
            <th><a href='api/companies.php?ref=AAP'>api/companies.php?gref=AAP</a></th>
            <th>Should return AAP</th>
        </tr>
        <tr>
            <th><a href='api/companies.php'>api/companies</a></th>
            <th>Should return all companies</th>
        </tr>
        <tr>
            <th><a href='api/portfolio.php?ref=1'>api/portfolio.php?ref=1</a></th>
            <th>Should return portfolio entry number 1</th>
        <tr>
            <th><a href="api/history.php?ref=ads">api/history.php?ref=ads</a></th>
            <th>Should return history for ads</th>
        </tr>
        <tr>
            <th><a href='api/users.php?ref=</th>
        </tr>
    </table>
    </body>
</html>