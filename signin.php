<?php

include './database/dbConnect.php';

$error = "";

            if (isset($_POST['submit'])){
       
               //setup fields
       
               $email = $_POST['email'];
               $password = $_POST['password'];
               $password = md5($password);
       
               // check if the email exists
       
               $selectQuery = $handle->query("SELECT * from users where (email='$email' or username='$email')");
       
               if ($selectQuery->rowCount() === 0){
                   $error = "The email or the username that you have entered does not match any account";
               }
               else{

                   $row = $selectQuery->fetch(PDO::FETCH_ASSOC);
                
                   if ($password !== $row['password']){
                       $error = "Incorrect password";
                   }
                
                   else {
                      
                       if ($row['isVerified'] === '1'){
                           session_start();
                           $_SESSION["idUser"] = $row['idUser'];
                           $_SESSION['fullName'] = $row['firstName'].' '.$row['lastName'];
                           $_SESSION['username'] = $row['username'];
                           $_SESSION['profilePicture'] = $row['profilePicture'];
                           $_SESSION['email'] = $row['email'];
                           $_SESSION['joinDate'] = $row['joinDate'];
                           header("location: ./account/page.php");
                           exit();
                        }

                       else{
                           $error = "Please verify your email first.";
                        }
       
                   }
               }
       
           }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to Camargu</title>
        <meta charset="UTF-8">
        <meta name="author" content="Achraf Ougdal">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./styles/signin.css">
        <link rel="icon" type="image/png"  href="pics/icon.png">
    </head>
    <body>
        <header>
            <a href="index.php"><img id="header-img"  src="./pics/camagru.png"></a>
        </header>

        <main>
                <img class="page-img" src="./pics/intro5.jpg" alt="">
                <div id="container">
                    <h1>Sign In</h1>
                    <form method="POST" id="form" name="signin-form" onsubmit="return validateForm()" action="">
                        <div id="errorMessage" class="error"><?=$error;?></div>
                        <input type="text" name="email" id="email" placeholder="Email" required=""><br>
                        <input type="password" id="password" name="password" placeholder="Password" required=""><br>
                        <a href="forgotPassword/forgot.php" class="forgot">I forgot my password</a>
                        <input type="submit" name="submit" value="Sign in"><br>
                        <a href="register.php">I don't have an account</a>
                    </form>
                </div>
        </main>
    
    </body>
</html>