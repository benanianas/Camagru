<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/error.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>

<body>
    <div class="thecontent">
        <?php if (isLoggedIn())
        require APPROOT.'/views/inc/home-nav.php';
        else
        require APPROOT.'/views/inc/nav.php';
        ?>

<img class="error-img" src="<?php echo URLROOT?>/img/error.svg">
<h1>Page not found<h1>
<a href="<?=URLROOT?>"> Return to Homepage   <i class="fas fa-long-arrow-alt-right"></i></a>

<?php require APPROOT.'/views/inc/footer.php'?>