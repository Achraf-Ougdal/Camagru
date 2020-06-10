<?php

include '../database/dbConnect.php';

if(isset($_FILES['file'])){

	session_start();
			//get file information

			$filename = $_FILES['file']['name'];
			$fileTmpName = $_FILES['file']['tmp_name'];
			$fileSize = $_FILES['file']['size'];
			$fileError = $_FILES['file']['error'];
			$fileType = $_FILES['file']['type'];


			// check for upload errors 

			$fileExt = explode('.', $filename);
			$fileActualExt = strtolower(end($fileExt));
			$allowedFiles = array('jpeg','png', 'jpg');


			if (in_array($fileActualExt, $allowedFiles) and $fileError === 0 and $fileSize <= 5000000){ // if the file is valid

				// set new file informations

				$finalName =   $_SESSION["username"].'.'.$fileActualExt; // file name after the upload
				$finalPath = '../profile-pictures/'; // file path after the upload (dest forlder)
				$fullPath = "".$finalPath.$finalName; // full path. ex: ../posts/

				$idUser = $_SESSION["idUser"];

				if(!is_dir($finalPath))
			    	mkdir($finalPath);

			    move_uploaded_file($fileTmpName, $fullPath);

			    $handle->query("UPDATE users SET profilePicture='$fullPath' WHERE idUser='$idUser';");

			    $_SESSION["profilePicture"] = $fullPath;

			}

}

header("location: ../account/profile.php");

