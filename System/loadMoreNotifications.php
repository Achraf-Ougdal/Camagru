<?php

include '../database/dbConnect.php';

session_start();

$idUser = $_SESSION["idUser"];
$notificationCount = $_POST["newNotificationCount"];

	    				$likeNotifications = $handle->query("SELECT users.profilePicture, users.firstName, users.lastName, likes.idImage FROM users, likes, images WHERE users.idUser=likes.idUser AND images.idImage=likes.idImage AND images.idUser='$idUser' AND likes.idUser<>'$idUser' ORDER BY likes.likeDate LIMIT $notificationCount");

	    				$commentNotifications = $handle->query("SELECT users.profilePicture, users.firstName, users.lastName, comments.idImage, comments.commentText FROM users, comments, images WHERE users.idUser=comments.idUser AND images.idImage=comments.idImage AND images.idUser='$idUser' AND comments.idUser<>'$idUser' ORDER BY comments.postDate LIMIT $notificationCount");

	    				/*AND comments.idUser<>'$idUser'*/
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
		    			<div  style="border-radius: 50%;width: 28px; height: 28px;">
	    					<img style="border-radius: 50%;max-width: 100%; max-height: 100%;" src="<?=$oneComment['profilePicture']?>">
	    				</div>
						<p class="said"><b><?=$oneComment['firstName']?> &nbsp; <?=$oneComment['lastName']?></b> &nbsp; commented on your photo : &nbsp; <i><?=$oneComment['commentText']?></i></p>
						<div class="whatPic">
							<img src="<?=$oneComment['idImage']?>" >
						</div>
		    		</div>
		    		<?php endforeach
	    		?>