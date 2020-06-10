<?php

include '../database/dbConnect.php';

session_start();

	// delete all non Confirmed pictures

				$newCount = $_POST["newCount"];
				$idUser = $_SESSION["idUser"];
				

		
					// get All Posts

					$allPosts = $handle->query("SELECT images.idImage, images.idUser, images.likes, users.firstName, users.profilePicture, users.lastName,users.username FROM images, users WHERE images.idUser=users.idUser AND images.confirmed=1 ORDER BY images.postDate LIMIT $newCount");
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
						    			<div style="display: flex; flex-direction: column;">
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
