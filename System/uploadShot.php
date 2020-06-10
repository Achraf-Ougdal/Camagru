<?php

	include '../database/dbConnect.php'; 

	session_start();
	
	$filename =   $_SESSION["username"].time().'.jpg';
	$filepath = '../posts/';
	$file = "".$filepath.$filename;
	$idUser = $_SESSION['idUser'];
	if(!is_dir($filepath))
    	mkdir($filepath);
	if(isset($_FILES['webcam'])){   
    	move_uploaded_file($_FILES['webcam']['tmp_name'], $file);
    	$handle->query("INSERT INTO images (idImage, idUser) VALUES ('$file', '$idUser');");
    	$_SESSION['idImage'] = $file;
	}
?>