<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <link href="style.css" rel="stylesheet" />
  </head>
  <body>
    <form action="convert.php" method="post">

      <label for="amount">amount</label>
      <input id="amount" name="amount"/>

      <label for="crypto">crypto</label>
      <select id="crypto" name="crypto">
        <option value="BTC">btc</option>
        <option value="ETH">eth</option>
      </select>

      <button type="submit">convert</button>
    </form>
    <?php
    $browserUA = $_SERVER['HTTP_USER_AGENT'];
    //var_dump
    echo $browserUA;
    var_dump($_SERVER);
    ?>
  </body>
</html>
