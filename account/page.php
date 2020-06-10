<?php

include '../database/dbConnect.php';

session_start();

	// delete all non Confirmed pictures

	if(isset($_SESSION['fullName'])){

		// get session variables

		$idUser = $_SESSION["idUser"];
		$name = $_SESSION['fullName'];
		$username = $_SESSION['username'];
		$profileIMG =  $_SESSION['profilePicture'];

		// select all non confirmed photos

		$nonConfirmed = $handle->query("SELECT idImage from images where idUser='$idUser'  AND confirmed=0 ");

		// delete non confirmed Photos from directory

		foreach ($nonConfirmed as $row) {
			# code...
			unlink($row["idImage"]);
		}

		// delete non confirmed Photos from database

		$handle->query("DELETE from images where idUser='$idUser'  AND confirmed=0");

		// get stats 

		$userTotalImagesQuery = $handle->query("SELECT * FROM images WHERE idUser='$idUser'");
		$userTotalLikedImagesQuery = $handle->query("SELECT * FROM images WHERE idUser='$idUser' and idImage in (SELECT idImage from likes)");
		$userTotalcommentedImagesQuery = $handle->query("SELECT * FROM images WHERE idUser='$idUser' and idImage in (SELECT idImage from comments)");
		$userEngagementQuery = $handle->query("SELECT * FROM images WHERE idUser='$idUser' and idImage in (SELECT idImage from comments UNION SELECT idImage FROM likes)");

		$_SESSION['userTotalImages'] = $userTotalImagesQuery->rowCount();
		$_SESSION['userTotalLikedImages'] = $userTotalLikedImagesQuery->rowCount();
		$_SESSION['userTotalCommentedImages'] = $userTotalcommentedImagesQuery->rowCount();
		$_SESSION['userTotalEngagement'] = $userEngagementQuery->rowCount();
		
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
		<title>Camagru</title>
		<meta charset="UTF-8">
	    <meta name="author" content="Achraf Ougdal">
	    <link rel="icon" type="image/png"  href="../pics/icon.png">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	   	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	    <link rel="stylesheet" type="text/css" href="../styles/page.css">
	    <script type="text/javascript" src="../scripts/page.js"></script>

	    <script>
	    	$(document).ready(function(){

	    		let count = 15;
	    		let notificationCount = 3;
	    		$("#seeMore").click(function(){
	    			count = count + 15;
	    			$("#posts").load("../System/loadMorePosts.php", {
	    				newCount: count
	    			});
	    		});

	    		$("#moreNotifications").click(function(){
	    			notificationCount = notificationCount + 3;
	    			$("#listNotifications").load("../System/loadMoreNotifications.php", {
	    				newNotificationCount: notificationCount
	    			});
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
	    	<div id="profile-section">
	    		<div id="profileIMG">
	    			<img src='<?=$profileIMG?>' style="max-height: 100%; max-width: 100%; border-radius: 50%">
	    		</div>
	    		<div>
	    			<p id="name"><?=$name;?></p>
	    			<span id="username"><?=$username;?></span>
	    			<div id="miniStats">
	    				<p>Likes recieved</p>
	    				<p>Comments recieved</p>
	    				<span style="color:gray; font-size: 14px;"><?=$_SESSION['userTotalLikedImages']?></span>
	    				<span style="color:gray; font-size: 14px;"><?=$_SESSION['userTotalCommentedImages']?></span>
	    			</div>
	    			<a href="profile.php">View Profile</a>
	    		</div>
	    		
	    	</div>

	    	<section id="main-section">
	    		
	    		<form action="../System/uploadImage.php" method="POST" id="upload-File" enctype="multipart/form-data">
	    			<input type="file" name="file" id="imagePost">
	   				<input type="submit" name="postIt" value="Upload">
	    		</form>
				
				<div id=posts>
				
				<?php 

					// get All Posts

					$allPosts = $handle->query("SELECT images.idImage, images.idUser, images.likes, users.firstName, users.profilePicture, users.lastName,users.username FROM images, users WHERE images.idUser=users.idUser AND images.confirmed=1 ORDER BY images.postDate LIMIT 15");
					// get all liked photos

					$allLiked = $handle->query("SELECT idImage FROM likes WHERE idUser='$idUser'");
					$liked = [];

					foreach ($allLiked as $row) {
						# code...
						$liked[] = $row['idImage'];
					}

	    			foreach ($allPosts as $post):
	    				$idImage = $post['idImage'];
	    				if(in_array($idImage, $liked)){
	    					$cssClass = "liked";
	    				}
	    				else{
	    					$cssClass = "unliked";
	    				}

	    		?>

	    				<div class="post">

		    				<div class="info">

		    					<div class="infoImg">
			    					<img src="<?=$post['profilePicture']?>" style="max-height: 100%; max-width: 100%; border-radius: 50%">
			    				</div>

			    			<p class="postOwner"><?=$post['firstName']?>&nbsp;<?=$post['lastName']?>&nbsp;<span style="color:gray; font-size: 14px;"><i>(<?=$post['username']?>)</i></span></p>
			    		</div>
			    		<div class="image">
			    				<img src="<?=$post['idImage']?>">
			    		</div>
			    		<div class="reaction">
							<label id="<?=$post['idImage']?>" class="<?=$cssClass?>" onclick="liked('<?=$idImage?>')">❤</label>
							<p id="empty">&nbsp;<span style="color:gray; font-size: 14px;"><i></i></span></p>
							<input class="comment" id="<?='comment'.$idImage?>" type="text" name="comment" placeholder="Add a comment...">
							<img src="../pics/send.png" class="send" onclick="commented('<?=$idImage?>')">
			    		</div>
			    		<div class="commentList">
			    			<?php
			    					//get the last 2 comments of the picture

								$lastComments = $handle->query("SELECT comments.commentText, comments.idUser, users.firstName, users.profilePicture, users.lastName,users.username FROM comments, users WHERE comments.idUser=users.idUser AND comments.idImage='$idImage' ORDER BY comments.postDate LIMIT 2");

								foreach ($lastComments as $comment):
				    				
			    			?>
					    		<div class="oneComment">
					    			<div class="commentListImg">
						    			<img src="<?=$comment['profilePicture']?>" style="max-height: 100%; max-width: 100%; border-radius: 50%">
						    		</div>
						    			<div style="display: flex; flex-direction: column; margin-right: 30px;">
						    				<p class="user"><?=$comment["firstName"]?> &nbsp; <?=$comment["lastName"]?> &nbsp;<span style="color:gray; font-size: 10px;"><i>(<?=$comment["username"]?>)</i></span></p>
						    				<p class="said"> <?=$comment["commentText"]?></p>
						    			</div>
						    		</div>
						    
						    <?php endforeach
	    					?>
			    		</div>

			    	</div>

		 
		    		<?php endforeach
	    		?>

	    		</div>

	    		<button id="seeMore">See More Posts</button>

	    		</div>
	    	</section>

	    	<section id="notifications">
	    		<h1>Notifications</h1>

	    		<div id="listNotifications">
	    			<?php
	    			
	    				$likeNotifications = $handle->query("SELECT users.profilePicture, users.firstName, users.lastName, likes.idImage FROM users, likes, images WHERE users.idUser=likes.idUser AND images.idImage=likes.idImage AND images.idUser='$idUser'  AND likes.idUser<>'$idUser' ORDER BY likes.likeDate LIMIT 3");

	    				$commentNotifications = $handle->query("SELECT users.profilePicture, users.firstName, users.lastName, comments.idImage, comments.commentText FROM users, comments, images WHERE users.idUser=comments.idUser AND images.idImage=comments.idImage AND images.idUser='$idUser' AND comments.idUser<>'$idUser' ORDER BY comments.postDate LIMIT 3");

	    				foreach ($likeNotifications as $oneLike) :
	    					# code...
	    			?>
		    		<div class="oneNotification">
		    			<img style="border-radius: 50%;width: 28px; height: 28px;" src="<?=$oneLike['profilePicture']?>">
						<p class="said"><b><?=$oneLike['firstName']?> &nbsp; <?=$oneLike['lastName']?></b> &nbsp; liked your photo</p>
						<div class="whatPic">
							<img src="<?=$oneLike['idImage']?>" >
						</div>
		    		</div>
		    		<?php endforeach
	    		?>

	    		<?php
	    				foreach ($commentNotifications as $oneComment) :
	    					# code...
	    			?>
	    			<div class="oneNotification">
		    			<img style="border-radius: 50%;width: 28px; height: 28px;" src="<?=$oneComment['profilePicture']?>">
						<p class="said"><b><?=$oneComment['firstName']?> &nbsp; <?=$oneComment['lastName']?></b> &nbsp; commented on your photo : &nbsp; <i><?=$oneComment['commentText']?></i></p>
						<div class="whatPic">
							<img src="<?=$oneComment['idImage']?>" >
						</div>
		    		</div>
		    		<?php endforeach
	    		?>

	    		</div>

	    		<button id="moreNotifications">See More</button>

	    	</section>
	    </main>

	    <a href="./upload.php"><img id="postIcon" src="../pics/postIcon.jpg"></a>

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