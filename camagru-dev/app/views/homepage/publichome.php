<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/homepage.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>
<body>
<div class="thecontent">
<?php 
        if (isLoggedIn())
        require APPROOT.'/views/inc/home-nav.php';
        else
        require APPROOT.'/views/inc/nav.php';
        ?>
<div class="home-content">
    The Worst social media Ever !
    <br>
<img class="theimg" src="<?php echo URLROOT?>/img/home.svg">
</div>

<?php require APPROOT.'/views/inc/footer.php'?>