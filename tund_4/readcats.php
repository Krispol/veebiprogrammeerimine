<?php
require('functions.php');
$notice = read_cats();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Siin lehel leidub igast koolitööga seotud asju">
    <meta name="author" content="Kristjan Põldmets">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Anonüümsed kassid
    </title>
</head>

<body>
    <p>See leht on valmistatud <a href="https://www.tlu.ee/">TLÜ</a> <a href="https://www.tlu.ee/dt">Digitehnoloogiate instituudi</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu</p>
    <ul><?php echo $notice;?></ul>
    <br>
</body>

</html>
