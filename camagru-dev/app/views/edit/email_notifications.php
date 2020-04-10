<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/edit.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>
<body>
<div class="thecontent">
<?php require APPROOT.'/views/inc/home-nav.php'?>
<div class= 'settings'>
    <div class='tab'>
        <a href ="<?php echo URLROOT?>/edit/profile"> <button class='tablink'>Edit Profile</button></a>
        <a href ="<?php echo URLROOT?>/edit/password"> <button class='tablink'>Change Password</button></a>
        <a href ="<?php echo URLROOT?>/edit/email_notifications"> <button class='tablink' id='selected'>Email Notifications</button></a>
    </div>
    <div class="tabcontent">
        <h3><b>Email Notifications</b></h3>
        <form class='sform' action="<?php echo URLROOT?>/edit/email_notifications" method="post">
        <label class="checkbox">
        <input id ="comments_n" name='comments_n' type="checkbox" <?php if ($data['comments_n'] == '1') echo 'checked';?> onchange="changeNStatus(this.id, this.name)">
        Recieve Comments notifications 
        </label>
        <br>
        <br>
        <label class="checkbox">
        <input id ="like_n" name='likes_n' type="checkbox" <?php if ($data['comments_n'] == '1') echo 'checked';?> onchange="changeNStatus(this.id, this.name)">
        Recieve Likes notifications 
        </label>
        </form>
    </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'?>