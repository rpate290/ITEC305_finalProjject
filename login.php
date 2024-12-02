<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header('location: welcome.php');
    exit;
}
require_once "config.php";
$database = getDB();

$username = $password = "";
$username_err = $password_err = $login_err= "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
//        var_dump($_POST);

    if(empty(trim($_POST["username"])))
    {
        //            print("username error");
        $username_err = "Please enter a Username";
    }
    else{
        $username =  trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"])))
    {
        //            print("username error");
        $username_err = "Please enter a Password";
    }
    else{
        $password =  trim($_POST["password"]);
    }

    //validate
    $sql = "Select id, username, password FROM users WHERE username = :username";
    if($stmt = $database->prepare($sql))
    {
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $param_username = trim($_POST["username"]);
        if($stmt->execute())
        {
            if($stmt->rowCount() == 1)
            {
                if($row = $stmt->fetch())
                {
                    $id = $row["id"];
                    $username = $row["username"];
                    $hashed_pw = $row["password"];
                    if(password_verify($password, $hashed_pw))
                    {
                        //log them in
                        session_start();
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["loggedin"] = true;
                        header("location:welcome.php");

                    }
                    else{
                        $login_err="Invalid username or password";
                    }
                }
            }
            else{
                //user doesnt exist
            }
        }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your credentials to log in</p>
    <?php
    if(!empty($login_err))
    {
        ?>
        <div class="alert alert-danger">
            <?= $login_err?>
        </div>
        <?php
    }
    ?>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username"
                   class="form-control <?php echo (!empty($username_err)) ?
                       'is-invalid':'';?>" value = "<?= $username ?>">
            <span class="invalid-feedback"><?= $username_err ?></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password"
                   class="form-control <?php echo (!empty($password_err)) ?
                       'is-invalid':'';?>" value = "<?= $password ?>">
            <span class="invalid-feedback"><?= $password_err ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
            <p>Don't have an account? <a href="register.php">Sign up now</a></p>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>