<?php

include './database/dbConnect.php';

$emailError = "";

if (isset($_POST['submit']))
{
	try {
	
		// setup fields

			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$password = $_POST['password'];
			$email = $_POST['email'];

			$email = trim($email);
			$email = filter_var($email, FILTER_SANITIZE_EMAIL); //just in case 


		# select query : check if the email already exists


		$valid = TRUE; // if it stays true, we move to the next step;

		$selectQuery = $handle->query("SELECT email from users");

		foreach ($selectQuery as $row) {
			
			if ($row[0] === $email) // email found in database
			{
				$emailError = "email already registered";
				$valid = FALSE;
				break;
			}
		}

		if ($valid === TRUE)
		{
			$firstName = ucfirst(strtolower($firstName));
			$firstName = trim($firstName);

			$lastName = ucfirst(strtolower($lastName));
			$lastName = trim($lastName);

			$password = md5($password); // password encryption -- security reasons
			$vkey = md5(time().$lastName.$firstName); // verification key -- UNIQUE

			//create username

			$countOne = $handle->query("SELECT COUNT(*) from users where (firstName='$firstName' and lastName='$lastName')");

			foreach ($countOne as $row) {
				$count = $row['COUNT(*)'];
			}

			$count += 1;
			
			$username = "".strtolower($firstName[0]).strtolower($lastName).".".$count;


			// insert to dataabase

			$insertQuery = $handle->query("INSERT INTO users (firstName, lastName, username, email, password, vkey) VALUES ('$firstName', '$lastName', '$username', '$email', '$password', '$vkey');");

			require_once('PHPMailer/PHPMailerAutoload.php');

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
			$mail->Subject = 'Camagru : Verify Your Account';
			$mail->Body = '<a href="http://localhost/Camagru/verify.php?vkey='.$vkey.'">Verify Your Account</a>';
			$mail->AddAddress($email);
			if ($mail->Send())
			{
			    header("location: verificationSent.php?verification=sent");
			    exit();
            }
			else {
                header("location: verificationSent.php?verification=Oops");
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
	<title>Welcome to Camagru</title>
	<meta charset="UTF-8">
  	<meta name="description" content="an Instagram-like website">
  	<meta name="keywords" content="camagru, Camargu">
  	<meta name="author" content="Achraf Ougdal">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="styles/register.css">
	<link rel="icon" type="image/png"  href="pics/icon.png">
	<script defer type="text/javascript" src="scripts/register.js"></script>
</head>
<body>

    <header>
        <a href="index.php"><img id="header-img"  src="pics/camagru.png"></a>
	</header>

	<main>
			<img class="page-img" src="pics/intro1.jpg"  alt="">
			<div>
				<h1>Sign up</h1>
				<form method="POST" id="form" name="register-form" onsubmit="return validateForm()" action="">
					<div id="errorMessage" name="errorMessage" class="error"><?="$emailError";?></div>
					<input type="text" name="firstName" id="firstName" placeholder="First Name" required=""><br>
					<input type="text" name="lastName" id="lastName" placeholder="Last Name" required=""><br>
					<input type="text" name="email" id="email" placeholder="Email" required=""><br>
					<input type="password" id="password" name="password" placeholder="Password" required=""><br>
					<input type="password" name="confirmedPassword" id="confirmedPassword" placeholder="One more time ?" required=""><br>
					<input type="submit" name="submit" value="Register"><br>
					<a href="signin.php">I already have an account</a>
				</form>
			</div>
	</main>

<!--	<footer>
			Made with <i class="fa fa-heart" style="font-size:20px;color:red"></i> By Achraf Ougdal
			onsubmit="return validateForm()"
		</footer>
-->

</body>
</html>