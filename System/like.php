<?php
	

	include '../database/dbConnect.php';

	session_start();



	if ($_POST["idImage"] != ""){

		$idUser = $_SESSION["idUser"];
		$idImage = $_POST["idImage"];


		// check if the image exists

		$selectQuery = $handle->query("SELECT * FROM images WHERE idImage='$idImage'");

		if ($selectQuery->rowCount() > 0){

			$ifAlreadyLiked = $handle->query("SELECT * FROM likes WHERE idUser='$idUser' AND idImage='$idImage'");
		
			if ($ifAlreadyLiked->rowCount() === 0){
	            $handle->query("
	            	UPDATE images SET likes=likes+1 WHERE (idImage='$idImage');
	            	INSERT INTO likes VALUES('$idUser','$idImage');
	            	");
	        }

	        else {
	        	$handle->query("
	            	UPDATE images SET likes=likes-1 WHERE (idImage='$idImage');
	            	DELETE FROM likes WHERE idUser='$idUser' AND idImage='$idImage';
	            ");
	        }

		}

	}

