<?php
session_start();
if(!isset($_SESSION["loggedin"]) ||
    $_SESSION["loggedin"] !== true)
{
    header('location: login.php');
    exit;
}
require_once "config.php";

$db = getDB();
$sql = "Select * from quizzes";
if($stmt = $db->prepare($sql)){
    if($stmt->execute())
    {
        $rows = $stmt->fetchAll();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="quiz.php">
    <?php
    foreach($rows as $row)
    {
        ?>
        <label><input type="radio" name="quiz" value="<?= $row["id"]?>"><?= $row["name"]?></label><br>
        <?php
    }
    ?>
    <input type="submit" value="submit">
</form>
</body>
</html>