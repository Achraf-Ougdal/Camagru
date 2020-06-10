<?php
	

	include '../database/dbConnect.php';

	session_start();



	if (isset($_POST["idImage"])){

		$idUser = $_SESSION["idUser"];
		$idImage = $_POST["idImage"];
		$comment = $_POST["commentText"];


		$selectQuery = $handle->query("INSERT INTO comments (idUser, idImage, commentText) VALUES('$idUser','$idImage','$comment')");

	}

