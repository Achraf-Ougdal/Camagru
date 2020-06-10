<?php

	try {

		$handle = new PDO('mysql:host=localhost;dbname=camagrudb', "root", "");
		$handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e){
		die("oops. couldn't connect to the server, Please try again");
	}

