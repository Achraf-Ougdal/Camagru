<?php

	include '../database/dbConnect.php';

	session_start();

	// delete all non Confirmed pictures

	if(isset($_SESSION['fullName'])){
		
		$error = "";
		$valid = TRUE;

		// get session variables

		$idUser = $_SESSION["idUser"];
		$fullName = $_SESSION['fullName'];
		$username = $_SESSION['username'];
		$profileIMG =  $_SESSION['profilePicture'];
		$email = $_SESSION['email'];
		$joinDate = $_SESSION['joinDate'];

		// calculate statistics for User

		$userTotalImages = $_SESSION['userTotalImages'];
		$userTotalLikedImages = $_SESSION['userTotalLikedImages'];
		$userTotalCommentedImages = $_SESSION['userTotalCommentedImages'];
		$userTotalEngagment = $_SESSION['userTotalEngagement'];

		if($userTotalImages != 0){
			$userLikeRate = ($userTotalLikedImages/$userTotalImages)*100;
			$userTalkRate = ($userTotalCommentedImages/$userTotalImages)*100;
			$userEngagementRate = ($userTotalEngagment/$userTotalImages)*100;
		}
		else{
			$userLikeRate = 0;
			$userTalkRate = 0;
			$userEngagementRate = 0;
		}

		// calculate global statistics 	

		$totalImagesQuery = $handle->query("SELECT * FROM images");
		$totalLikedImagesQuery = $handle->query("SELECT * FROM images WHERE idImage in (SELECT idImage from likes)");
		$totalcommentedImagesQuery = $handle->query("SELECT * FROM images WHERE idImage in (SELECT idImage from comments)");
		$totalEngagementQuery = $handle->query("SELECT * FROM images WHERE idImage in (SELECT idImage from comments UNION SELECT idImage FROM likes)");

		$totalImages = $totalImagesQuery->rowCount();
		$totalLikedImages = $totalLikedImagesQuery->rowCount();
		$totalCommentedImages = $totalcommentedImagesQuery->rowCount();
		$totalEngagements = $totalEngagementQuery->rowCount();

		if($totalImages != 0){
			$totalLikeRate = ($totalLikedImages/$totalImages)*100;
			$totalTalkRate = ($totalCommentedImages/$totalImages)*100;
			$totalEngagementRate = ($totalEngagements/$totalImages)*100;
		}
		else{
			$totalLikeRate = 0;
			$totalTalkRate = 0;
			$totalEngagementRate = 0;
		}


		if(isset($_POST['submitChanges'])){
		
			// get session variables

			$idUser = $_SESSION["idUser"];

			// get infos

			$changeFirstName = $_POST["changeFirstName"];
			$changeFirstName = trim($changeFirstName);

			$changeLastName = $_POST["changeLastName"];
			$changeLastName = trim($changeLastName);

			$changeEmail = $_POST["changeEmail"];
			$changeEmail = trim($changeEmail);
			$changeEmail = filter_var($changeEmail, FILTER_SANITIZE_EMAIL);


			$changePassword = $_POST["changePassword"];

			//check if email is Valid

			$selectQuery = $handle->query("SELECT email from users where email='$changeEmail'");

				if ($selectQuery->rowCount() > 0){

					$error = "email already registered";
					$valid = FALSE;

				}
			

			// upload Infos

			if ($valid)
			{
				$changeUsername = FALSE;
				$names = explode(' ', $fullName);

				if(strlen($changeFirstName) > 0)
				{
					$handle->query("UPDATE users SET firstName='$changeFirstName' WHERE idUser='$idUser'");
					$changeUsername = TRUE;
				}
				else{
					$changeFirstName = $names[0];
				}
				
				if(strlen($changeLastName) > 0)
				{
					$handle->query("UPDATE users SET lastName='$changeLastName' WHERE idUser='$idUser'");
					$changeUsername = TRUE;
				}
				else{
					$changeLastName = $names[1];
				}
				
				if ($changeUsername)
				{
					//create username

					$countOne = $handle->query("SELECT COUNT(*) from users where (firstName='$changeFirstName' AND lastName='$changeLastName')");

					foreach ($countOne as $row) {
						$count = $row['COUNT(*)'];
					}
					
					$newUsername = "".strtolower($changeFirstName[0]).strtolower($changeLastName).".".$count;

					//update it

					$handle->query("UPDATE users SET username='$newUsername' WHERE idUser='$idUser'");

				}

				if(strlen($changeEmail) > 0)
				{
					$handle->query("UPDATE users SET email='$changeEmail' WHERE idUser='$idUser'");
				}
				
				if(strlen($changePassword) > 0)
				{
					$changePassword = md5($changePassword);
					$handle->query("UPDATE users SET password='$changePassword' WHERE idUser='$idUser'");
				}

				session_unset();
				session_destroy();
				header("location: ../signin.php");
				exit();
				
			}

		}
	}
	else{
		session_unset();
		session_destroy();
		header("location: ../signin.php");
		exit();
	}
?>


<!DOCTYPE html>
	<html>
		<head>
			<title><?=$fullName?></title>
			<meta charset="UTF-8">
		  	<meta name="description" content="an Instagram-like website">
		  	<meta name="keywords" content="camagru, Camargu">
		  	<meta name="author" content="Achraf Ougdal">
		  	<link rel="icon" type="image/png"  href="../pics/icon.png">
		  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<link rel="stylesheet" type="text/css" href="../styles/profile.css">
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		  	<script src="../easy-pie-chart-master/dist/jquery.easypiechart.js"></script>
		  	<script defer src="../scripts/profile.js"></script>
		  	<script>
				$(function(){
			    	$('.chart').easyPieChart({
			            barColor:"#6558b0",
			            scaleColor: false,
			            lineWidth: 5
			        });
			    });
			</script>
		</head>
		<body>

		    <header>
	       	 	<a href="page.php"><img id="header-img"  src="../pics/camagru.png"></a>
	        	<a href="../System/logoutScript.php" id="logout">Logout</a>
	    	</header>
			<main>

				<div id="overview">
					<div id="user">
						<div id="user-img">
							<img src="<?=$profileIMG?>">
						</div>
						<button id="changeProfilePicture" class="changeButton" onclick="document.getElementById('uploadProfilePicture').click()">Change your profile picture</button>
						<form method="POST" action="../System/changeProfilePicture.php" enctype="multipart/form-data">
							<input type="file" id="uploadProfilePicture" name="file" style="display: none;" onchange="this.form.submit()">
						</form>
						<hr>
						<div id="userInfo">
							<p>Full name : &nbsp;<span style="color:gray; font-size: 14px;"><i><?=$fullName?></i></span></p>
							<p>Username : &nbsp;<span style="color:gray; font-size: 14px;"><i><?=$username?></i></span></p>
							<p>Email :&nbsp;<span style="color:gray; font-size: 14px;"><i><?=$email?></i></span></p>
							<p>Join date :&nbsp;<span style="color:gray; font-size: 14px;"><i><?=$joinDate?></i></span></p>
						</div>
					</div>
					<div id="stats">
						<div class="container">
							<h1>Global Overview :</h1>
							<div class="statsView">
								<div class="box">
									<div class="chart" data-percent="<?=$totalLikeRate?>"></div>
									<p>Like rate</p>
									<span style="color:gray; font-size: 14px;"><i><?=$totalLikeRate?>%</i></span>
								</div>
								<div class="box">
									<div class="chart" data-percent="<?=$totalTalkRate?>" ></div>
									<p>Talk rate</p>
									<span style="color:gray; font-size: 14px;"><i><?=$totalTalkRate?>%</i></span>
								</div>
								<div class="box">
									<div class="chart" data-percent="<?=$totalEngagementRate?>" ></div>
									<p>Total engagement rate <span class="explain"></span></p>
									<span style="color:gray; font-size: 14px;"><i><?=$totalEngagementRate?>%</i></span>
								</div>
							</div>
						</div>
						<div class="container">
							<h1>User overview :</h1>
							<div class="userStats">
								<div class="box">
									<div class="chart" data-percent="<?=$userLikeRate?>"></div>
									<p>Like rate</p>
									<span style="color:gray; font-size: 14px;"><i><?=$userLikeRate?>%</i></span>
								</div>
								<div class="box">
									<div class="chart" data-percent="<?=$userTalkRate?>" ></div>
									<p>Talk rate</p>
									<span style="color:gray; font-size: 14px;"><i><?=$userTalkRate?>%</i></span>
								</div>
								<div class="box">
									<div class="chart" data-percent="<?=$userEngagementRate?>" ></div>
									<p>Total engagement rate <span class="explain"></span></p>
									<span style="color:gray; font-size: 14px;"><i><?=$userEngagementRate?>%</i></span>
								</div>
							</div>
						</div>
					</div>
					<div id="changeInfos">
						<h1>Change your personal information :</h1>
						<form method="POST" id="form" name="chageInfosForm" onsubmit="return validateChangesForm()" action="">
							<p style="color: #6558b0; font-size: 14px;">Edit only the fields that you would like to change</p>
							<p style="color: #6558b0; font-size: 14px;">You will be redirected to the sign in page after submit</p>
							<p style="color: red; font-size: 14px;" id="error"><?=$error?></p>
							<div id="change">
								<input type="text" id="changeFirstName" name="changeFirstName" placeholder="First name">
								<input type="text" id="changeLastName" name="changeLastName" placeholder="Last name">
								<input type="text" id="changeEmail" name="changeEmail" placeholder="Email">
								<input type="password" id="changePassword" name="changePassword" placeholder="Password">
							</div>
							<input type="submit" name="submitChanges" id="changeInfos" class="changeButton" value="Submit new changes"/>
						</form>
					</div>
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