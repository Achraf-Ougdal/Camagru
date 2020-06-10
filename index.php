<?php
?>


<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Camagru</title>
    <meta charset="UTF-8">
    <meta name="description" content="an Instagram-like website">
    <meta name="keywords" content="camagru, Camargu">
    <meta name="author" content="Achraf Ougdal">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    <link rel="icon" type="image/png"  href="pics/icon.png">
</head>
<body>
    <header>
        <a href="index.php"><img id="header-img"  src="pics/camagru.png"></a>
    </header>
    
    <div id="container">

        <div id="elements">
           <div id="text">
                <h1>Stay <span>home</span>, Stay <span>connected</span></h1>
                <p>A simple way to share your life and memories with friend, family and the entire network. Enjoy and have fun, all in one place</p>
                <a href="register.php" class="button">Get Started</a>
                <a href="signin.php" class="button" id="signinB">Sign in</a>
            </div>
        </div>
        <img  id="frontImage" src="pics/fontPage-BG.png">
    </div>

    <section id="cards">
        <div class="card">
            <img src="./pics/gender.png">
                <p>Connect</p>
        </div>
        <div class="card">
            <img src="./pics/spread-love.png">
                <p>Spread Love </p>
        </div>
        <div class="card">
            <img src="./pics/enjoy.png" >
                <p>Enjoy</p>
        </div>
    </section>

        <div id="gallery">
            <div>
                <h1><span>Sounds interesting ?</span></h1>
                <a href="./account/gallery.php"> Explore our Gallery</a>
            </div>
        </div>
        <footer>
            <div style="display: block; width :110px; height: 45px;">
                <img src="./pics/lightLogo.png" style="max-width: 100%; max-height: 100%;">    
            </div>
            <div style="display: flex; margin-bottom: auto; margin-top: auto; align-items: center; justify-content: center;">
                <a href="https://www.facebook.com/achraf.ougdal.7" target="_blank"><img src="./pics/facebook.png" style=" display: block; height: 45px; width: 45px; margin-top: 5px; margin-bottom: 5px;"></a>
                <a href="https://github.com/Achraf-Ougdal/" target="_blank"><img src="./pics/github-logo.png" style=" height: 32px; width: 32px; display:block; margin-top: auto; margin-bottom: auto; margin-left: 10px;"></a>
                <a href="https://www.instagram.com/achraf_ougdal/" target="_blank"><img src="./pics/instagramLogo.png" style=" height: 48px; width: 48px; margin-left: 10px; display:block; margin-top: auto; margin-bottom: auto; margin-left: 10px;"></a>

            </div>

            <span style="color:gray; font-size: 15px;"><i>Camargu 1.0</i></span>
            
        </footer>
    </body>
</html>
