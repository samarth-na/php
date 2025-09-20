<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="./style.css">
</head>
<body>
        hello
    <?php
        //


    if (isset($_POST["amount"]) && isset($_POST["crypto"])) {

        $amount = $_POST["amount"];
        $crypto = $_POST["crypto"];

        echo $amount;
        echo $crypto;

    } else {
        echo "Please enter amount and crypto";
    }
    ?>
</body>
</html>
