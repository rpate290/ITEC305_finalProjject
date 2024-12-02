<?php
require_once "config.php";
$username = "";
$password = "";
$confirm_password = "";

$username_err="";
$password_err="";
$confirm_password_err="";

$database = getDB();
if($_SERVER["REQUEST_METHOD"] == "POST"){
//        var_dump($_POST);
    //Validate Username
    $username = trim($_POST["username"]);
    if(empty($username))
    {
//            print("username error");
        $username_err = "Please enter a Username";

    }
    else if (!preg_match("/^[a-zA-Z0-9]+$/",$username))
    {
        $username_err = "Username can only contain letters and numbers";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = :username";
        if($stmt = $database->prepare($sql)){
            //Stmt was created
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            if($stmt->execute())
            {
                if($stmt->rowCount() ==1)
                {
                    $username_err = "This username is unavailable";
                }
                else{
                    //Username is good
                    $username = trim($_POST["username"]);
                }
            }
            else{
                //stmt couldnt execute
                echo "Couldn't execute";
            }
        }
        else{
            echo "Error preparing statement";
        }
        unset($stmt);
    }

    //Validate Password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password";
    }
    else if (strlen(trim($_POST["password"]) <= 8))
    {
        echo "password not long enough";
        $password_err = "Password must have a length of 8 or more";
    }
    else{
        $password = trim($_POST["password"]);
//            echo $password;
    }

    //Validate Confirm Password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password = "Please confirm password";
    }
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if((empty($password_err)) && $password != $confirm_password)
        {
            $confirm_password_err = "Passwords Didn't Match.";
        }
    }
    //Do the insert
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
    {
        //no errors, so we can proceed
        $sql = "INSERT INTO USERS (username, password) VALUES (:username, :password)";
        if($stmt=$database->prepare($sql))
        {
            //bind variables
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if($stmt->execute())
            {
                header("location:login.php");
            }
            else{
                //execute failed
            }
        }
        else{
            //unable to prepare
        }
    }
    else{
        //do nothing
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="wrapper">
    <h2>Sign Up</h2>
    <p>Please fill this form out to create an account</p>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?= $username ?>">
            <span class="invalid-feedback">
                    <?= $username_err ?>
                </span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value = "<?= $password ?>">
            <span class="invalid-feedback">
                    <?= $password_err ?>
                </span>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value = "<?= $confirm_password ?>">
            <span class="invalid-feedback">
                    <?= $confirm_password_err ?>
                </span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>