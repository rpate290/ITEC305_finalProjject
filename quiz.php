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
$quizId = $_GET["quiz"];
$sql = "Select * 
            from questions
            where quiz_id = :quizid
";
if($stmt= $db->prepare($sql))
{
    $stmt->bindParam(":quizid",$quizId );
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
<h1>Data</h1>
<form action="results.php">
    <ol>
        <?php
        foreach ($rows as $row)
        {
            ?>
            <li><?=$row["text"]?></li>
            <?php
            //run a query to get all the answer
            //make a OL, but with a-d with radio buttons in lis
        }
        ?>
    </ol>
    <input type="submit" value="Grade Quiz!">
</form>
</body>
</html>