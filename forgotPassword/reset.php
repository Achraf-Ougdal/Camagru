<?php

    include '../database/dbConnect.php';

    if (!isset($_GET['vkey'])){
        header("location: ../notFound.php");
        exit();
    }

    $vkey = $_GET['vkey'];

if (isset($_POST['submit']))
{
    try {

        # select query : check if the vkey exists

        $selectQuery = $handle->query("SELECT password from users where vkey='$vkey'");

        if ($selectQuery->rowCount() === 0)
        {
            header("location: ../notFound.php");
            exit();
        }
        else{

            $password = $_POST['password'];
            $password = md5($password);

            # update Password Query

            $updateQuery = $handle->query("UPDATE users set password='$password' where vkey='$vkey'");

            if ($updateQuery){
                header("location: passwordUpdated.php?status=success");
                exit();
            }
            else{
                header("location: passwordUpdated.php?status=failed");
                exit();
            }
        }

    } catch(PDOException $e){
        echo "".$e->getMessage();
        die();
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Camargu</title>
        <meta charset="UTF-8">
        <meta name="author" content="Achraf Ougdal">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../styles/reset.css">
        <script defer type="text/javascript" src="../scripts/reset.js"></script>
        <link rel="icon" type="image/png"  href="../pics/icon.png">
    </head>
    <body>
        <header>
            <a href="../index.php"><img id="header-img"  src="../pics/camagru.png"></a>
        </header>

        <main>
            <div id=container>
                <h1>Reset Your Password</h1>
                <div id="errorMessage" name="errorMessage" class="error" style="color:red"></div>
                <form method="POST" id="form"  onsubmit="return validateForm()" name="reset-form" action="">
                    <input type="password" id="password" name="password" placeholder="New Password" required=""><br>
                    <input type="password" name="confirmedPassword" id="confirmedPassword" placeholder="confirm your Password" required=""><br>
                    <input type="submit" name="submit" value="Reset Password"><br>
                </form>
            </div>
        </main>
    </body>
</html>
