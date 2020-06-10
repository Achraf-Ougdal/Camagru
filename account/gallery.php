<?php
	include '../database/dbConnect.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Gallery</title>
		<meta charset="UTF-8">
	  	<meta name="author" content="Achraf Ougdal">
		<link rel="stylesheet" type="text/css" href="../styles/gallery.css">
		<link rel="icon" type="image/png"  href="../pics/icon.png">
	</head>
	<body>

		<header>
            <a href="../index.php"><img id="header-img"  src="../pics/camagru.png"></a>
		</header>

			<div id="title">
				<h1>Explore Our Gallery</h1>
			</div>

			<div id=container>
				<?php 

					// get All Posts

					$allPosts = $handle->query("SELECT images.idImage, images.idUser, images.likes, users.firstName, users.profilePicture, users.lastName,users.username FROM images, users WHERE images.idUser=users.idUser AND images.confirmed=1 ORDER BY images.postDate LIMIT 15");

	    			foreach ($allPosts as $post):
	    				$idImage = $post['idImage'];
	    		?>

	    				<div class="post">

		    				<div class="info">

		    					<div class="infoImg">
			    					<img src="<?=$post['profilePicture']?>" style="max-height: 100%; max-width: 100%; border-radius: 50%">
			    				</div>

			    				<p class="postOwner"><?=$post['firstName']?>&nbsp;<?=$post['lastName']?></p>
			    			</div>
				    		<div class="image">
				    				<img src="<?=$post['idImage']?>">
				    		</div>
				    		<div class="reaction">
								<label class="liked">❤</label>
								<p>&emsp;<span style="color:gray; font-size: 14px;"><i><?=$post['likes']?></i></span></p>
				    		</div>
			    		</div>

		 
		    		<?php endforeach
	    		?>
			</div>

			<div>
				<a href="../signin.php" id="signIn">Sign in</a>
			</div>


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