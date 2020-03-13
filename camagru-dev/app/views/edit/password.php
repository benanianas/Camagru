<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/profile.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>
<body>
<div class="thecontent">
<?php require APPROOT.'/views/inc/home-nav.php'?>
<div class= 'settings'>
    <div class='tab'>
        <a href ="<?php echo URLROOT?>/edit/profile"> <button class='tablink'>Edit Profile</button></a>
        <a href ="<?php echo URLROOT?>/edit/password"> <button class='tablink' id='selected'>Change Password</button></a>
        <a href ="<?php echo URLROOT?>/edit/email_notifications"> <button class='tablink'>Email Notifications</button></a>
    </div>
    <div class="tabcontent">
        <h3><b>Change Passord</b></h3>
        <p>bala akna blabla blabla blabla</p>
    </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'?>