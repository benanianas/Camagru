<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/homepage.css">
</head>
<body>
<div class="homepage">
<div class="hp-navbar">
    <div class="logo-side">
        <div class="logo"><a href="<?php echo URLROOT?>"> <img src="<?php echo URLROOT?>/img/logo.png"></a></div>
        <div class="logo-title"><a href="<?php echo URLROOT?>"> Camagru</a></div>
    </div>
    <div class="account-buttons">
    <a href="<?php echo URLROOT?>/account/login">Log In</a>
    <a class="register" href ="<?php echo URLROOT?>/account/register">Register</a>

    </div>
</div>
<div class="home-content">
    The Worst social media Ever !
    <br>
<img class="theimg" src="<?php echo URLROOT?>/img/home.svg">
</div>
</div>
<?php require APPROOT.'/views/inc/footer.php'?>