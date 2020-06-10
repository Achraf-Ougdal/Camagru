<?php

    $h1Message = "";
    $h2Message = "" ;

    if (!isset($_GET['status'])){
        header("location: ../notFound.php");
        exit();
    }

    if ($_GET['status'] === 'success') {
        $h1Message = 'password updated successfully';
        $h2Message = ':D';
    }

    else{
        $h1Message = 'Oops... something went wrong';
        $h2Message = ':/';

    }

    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Camargu</title>
    <meta charset="UTF-8">
    <meta name="author" content="Achraf Ougdal">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/checkEmail.css">
    <link rel="icon" type="image/png"  href="../pics/icon.png">
</head>
<body>
<header>
    <a href="../index.php"><img id="header-img"  src="../pics/camagru.png"></a>
</header>

<main>
    <div id=container>
        <h1><?=$h1Message;?></h1>
        <h2><?=$h2Message;?></h2>
    </div>
</main>
</body>
</html>
