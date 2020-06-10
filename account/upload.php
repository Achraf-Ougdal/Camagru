<?php
	
	include '../database/dbConnect.php';

	session_start();
	
	$idUser=$_SESSION['idUser'];

	if(!isset($_SESSION['fullName'])){
		header("location:../signin.php");
		exit();
	}


	if (isset($_POST["upload"])){
		$idImage = $_SESSION["idImage"];
		$handle->query("UPDATE images SET confirmed=1 WHERE (idImage='$idImage');");
		unset($_SESSION["idImage"]);
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<meta charset="UTF-8">
	<meta name="author" content="Achraf Ougdal">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/upload.css">
    <link rel="icon" type="image/png"  href="../pics/icon.png">
    <script type="text/javascript" src="../webcamjs-master/webcam.min.js"></script>
    <script  defer type="text/javascript" src="../scripts/upload.js"></script>
</head>

<body>
	<header>
		<a href="page.php"><img id="header-img"  src="../pics/camagru.png"></a>
		<a href="../System/logoutScript.php" id="logout">Logout</a>
	</header>

	<main>
		<div class="part">
			<h1>Smile :)</h1>
			<div class="photoBooth" id="cameraShot">
				
			</div>

			<button onclick="takePhoto()">Take Photo</button>
		</div>
		<div class="part">
			<h1>Here it is</h1>
			<div class="photoBooth" id="showImage">
				
			</div>
			<form method="POST" action="">
				<input id="upload" type="submit" style="opacity: 0.5" name="upload" disabled="true"   value="Confirm Upload"/>
			</form>
		</div>
	</main>

	  <footer>
	    	<div style="display: block; width :110px; height: 45px;">
	    		<img src="../pics/lightLogo.png" style="max-width: 100%; max-height: 100%;">	
	    	</div>
	    	<div style="display: flex; margin-bottom: auto; margin-top: auto; align-items: center; justify-content: center;">
	    		<a href="https://www.facebook.com/achraf.ougdal.7" target="_blank"><img src="../pics/facebook.png" style=" display: block; height: 45px; width: 45px; margin-top: 5px; margin-bottom: 5px;"></a>
	    		<a href="https://github.com/Achraf-Ougdal/" target="_blank"><img src="../pics/github-logo.png" style=" height: 32px; width: 32px; display:block; margin-top: auto; margin-bottom: auto; margin-left: 10px;"></a>
	    		<a href="https://www.instagram.com/achraf_ougdal/" target="_blank"><img src="../pics/instagramLogo.png" style=" height: 48px; width: 48px; margin-left: 10px; display:block; margin-top: auto; margin-bottom: auto; margin-left: 10px;"></a>

	    	</div>

	    	<span style="color:gray; font-size: 15px;"><i>Camargu 1.0</i></span>
	    	
	    </footer>
</body>

</html>