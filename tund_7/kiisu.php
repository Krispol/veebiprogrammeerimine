<?php
require("functions.php");
$notice = null;
if (isset($_POST['catName']) and isset($_POST['catColor']) and isset($_POST['tailLength'])) {
    strip_data($_POST['catName']);
    strip_data($_POST['catColor']);
    strip_data($_POST['tailLength']);
    $notice = add_cat($_POST['catName'], $_POST['catColor'], $_POST['tailLength']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="Siin lehel leidub igast koolitööga seotud asju">
    <meta name="author" content="Kristjan Põldmets">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kassi lisamine</title>
</head>
<body>
<h1>Kassi lisamine</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <label>Kiisu nimi: </label>
    <input type="text" name="catName" required>
    <label>Kiisu värv: </label>
    <select name="catColor" required>
        <option selected>--</option>
        <option value="gray">Hall</option>
        <option value="red">Punane</option>
        <option value="white">Valge</option>
        <option value="striped">Triibuline</option>
        <option value="spotted">Laiguline</option>
    </select>
    <label>Saba pikkus: </label>
    <input type="number" name="tailLength" min="0" max="20" required>
    <br>
    <br>
    <input type="submit" value="Saada">
</form>
<p><?php echo $notice;?></p>
<p>See leht on valmistatud <a href="https://www.tlu.ee/">TLÜ</a> <a href="https://www.tlu.ee/dt">Digitehnoloogiate instituudi</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu</p>
<hr>

</body>
</html>