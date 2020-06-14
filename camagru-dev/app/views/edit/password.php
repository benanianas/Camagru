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
        <a href ="<?php echo URLROOT?>/edit/password"> <button class='tablink' id='selected'>Change Password</button></a>
        <a href ="<?php echo URLROOT?>/edit/email_notifications"> <button class='tablink'>Email Notifications</button></a>
    </div>
    <div class="tabcontent">
        <h3><b>Change Password</b></h3>
        <?php
        if(!empty($data['notification'])) echo "<div class='changedpass'>
        <br>
        <article class='message is-primary'>
        <div class='notification is-primary'>
            <button class='delete' onclick='deleteNotif()'></button>
            Your password changed successfully.
        </div>
        </article>
        </div>";
        ?>
        <form class="sform" action="<?php echo URLROOT?>/edit/password" method="post">
        <div class="field">
        <label>Old Password </label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="oldpassword" type="password"  value="<?php echo $data['oldpassword']?>">
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['oldpassword_err']){echo $data['oldpassword_err'];} ?></p>
        </div>
        <div class="field">
        <label>New Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="newpassword" type="password" value="<?php echo $data['newpassword']?>">
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['newpassword_err']){echo $data['newpassword_err'];} ?></p>
        </div>
        <div class="field">
        <label>Confirm New Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="c_newpassword" type="password" value="<?php echo $data['c_newpassword']?>">
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['c_newpassword_err']){echo $data['c_newpassword_err'];} ?></p>
        <br>
        </div>
        <button type='submit' class="button is-light">Change password</button>
        </form>
    </div>
</div>
<?php $jsfile = "settings.js"?>
<?php require APPROOT.'/views/inc/footer.php'?>