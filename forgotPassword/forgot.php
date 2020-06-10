<?php

    include '../database/dbConnect.php';

    $emailError = "";

if (isset($_POST['submit']))
{
    try {

        // setup fields

        $email = $_POST['email'];

        # select query : check if the email already exists

        // if it stays true, we move to the next step;

        $selectQuery = $handle->query("SELECT email from users where email='$email'");

        if ($selectQuery->rowCount() === 0)
		{
		    $emailError = "email doesn't exist";
		}
        else{

            $selectVKeyQuery = $handle->query("SELECT vkey from users where email='$email'");

            $row = $selectVKeyQuery->fetch( PDO::FETCH_ASSOC);

            $vkey = $row['vkey'];

            require_once('../PHPMailer/PHPMailerAutoload.php');

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->isHTML(true);
            $mail->CharSet = 'utf-8';
            $mail->Username = 'ougdal.camagru.verify@gmail.com';
            $mail->Password = 'Camagru145732698';
            $mail->SetFrom('no-reply@camagru.com');
            $mail->Subject = 'Camagru : Reset Your Password';
            $mail->Body = '<a href="http://localhost/Camagru/forgotPassword/reset.php?vkey='.$vkey.'">Reset Your Password</a>';
            $mail->AddAddress($email);
            if ($mail->Send())
            {
                header("location: forgotCheckEmail.php?email=sent");
                exit();
            }
            else {
                header("location: forgotCheckEmail.php?email=Oops");
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
		<link rel="stylesheet" type="text/css" href="../styles/forgot.css">
        <link rel="icon" type="image/png"  href="../pics/icon.png">
	</head>
	<body>
	<header>
        <a href="../index.php"><img id="header-img"  src="../pics/camagru.png"></a>
		</header>

		<main>
			<div id=container>
				<h1>Forgot your password ?</h1>
                <div id="errorField" name="errorMessage" class="error" style="color: red;"><?="$emailError";?></div>
				<form method="POST" id="form" name="forgot-form" action="">
					<input type="email" name="email" id="email" placeholder="Enter you Email" required=""><br>
					<input type="submit" name="submit" value="Reset Password"><br>
					<a href="../signin.php">Back to sign in page</a>
				</form>
			</div>
		</main>
	</body>
</html>