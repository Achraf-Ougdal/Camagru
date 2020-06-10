<?php

include './database/dbConnect.php';

	$message = "";

	try{


		if (!isset($_GET['vkey']) || $_GET['vkey'] === "")
		{
			header("location: notFound.php");
			exit();
		}

		$vkey = $_GET['vkey'];

		$valid = FALSE;

		# check if the verification key exists

		$selectQuery = $handle->query("SELECT vkey, isVerified from users where vkey='$vkey'");

		if ($selectQuery->rowCount() === 1)
		{
			foreach ($selectQuery as $row) {

				# check if the account has already been isVerified

				$valid = TRUE;

				if ($row[1] === '1')
				{
					$message = "Your Account has already been verified";
					break;
				}
				
				# update the isVerified column to 1

				$updateQuery = $handle->query("UPDATE users set isVerified=1 where vkey='$vkey'");
				
				if ($updateQuery)
				{
					$message = "Your Account is now verified, you can now log in";
					break;
				}
				else
				{

					$message = "Oops. Something went wrong";
					break;
				}

			}	

		}

		else {
			$message = "verification key doesn't exist, please register and try again";
		}

	}catch(PDOException $e){
		echo "<script>alert('$e->getMessage()')</script>";
		die();

	}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to Camargu</title>
		<meta charset="UTF-8">
	  	<meta name="author" content="Achraf Ougdal">
	  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="./styles/checkEmail.css">
		<link rel="icon" type="image/png"  href="pics/icon.png">
	</head>
	<body>
		<header>
            <a href="index.php"><img id="header-img"  src="./pics/camagru.png"></a>
		</header>

		<main>
			<div id=container>
				<h1><?=$message;?></h1>
                <a href="./signin.php">
                    <input type="submit" name="submit" value="Go back to sign in Page"><br>
                </a>
			</div>
		</main>
	</body>
</html>