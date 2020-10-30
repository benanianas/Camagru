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
        <a href ="<?php echo URLROOT?>/edit/profile"> <button class='tablink' id='selected'>Edit Profile</button></a>
        <a href ="<?php echo URLROOT?>/edit/password"> <button class='tablink'>Change Password</button></a>
        <a href ="<?php echo URLROOT?>/edit/email_notifications"> <button class='tablink'>Email Notifications</button></a>
    </div>
    <div class="tabcontent">
        <h3><b>Edit Profile</b></h3>
        <div id="photo">
        <div id="profile-photo">
        <img id="pimg" src="<?php echo URLROOT.$data['pic'] ?>">
        <i id="c-icon" class="fas fa-camera" onclick="openModal()"></i>
        </div>
        <div id="photo-err"></div>
        </div>

        <form class='sform' action="<?php echo URLROOT?>/edit/profile" method="post">
        <div class="field">
        <label>First Name </label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="name" type="text" value="<?php echo $data['name']?>">
            <span class="icon is-small is-left">
            <i class="fas fa-user"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['name_err']){echo $data['name_err'];} ?></p>
        </div>
        <div class="field">
        <label>Username</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="username" type="text" value="<?php echo $data['username']?>">
            <span class="icon is-small is-left">
            <i class="fas fa-user"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['username_err']){echo $data['username_err'];} ?></p>
        </div>
        <div class="field">
        <label>Email</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="email" type="text" value="<?php echo $data['email']?>">
            <span class="icon is-small is-left">
            <i class="fas fa-envelope"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['email_err']){echo $data['email_err'];} ?></p>
        <br>
        </div>
        <input type="hidden" name="csrf" value="<?php echo $data['csrf']?>">
        <button type='submit' class="button is-light">Save Changes</button>
        </form>
        <?=$data['csrf'] ?>
    </div>
</div>
<div id="profile-modal">
<div class="profile-modal-content">
  <div id="modal-titel">Change Profile Photo?</div><hr>
<span id="close">&times;</span>
<div class="modal-buttons">
<label class="file-label" onclick="">
    <input  class="file-input" type="file" name="file" id="p-photo" onchange="uplaodPPic()">
    <span class="file-cta">
      <span class="file-icon">
        <i class="fas fa-upload"></i>
      </span>
      <span class="file-label">
        Upload Photo
      </span>
    </span>
</label>
<div class="divider"></div>
<button class="button is-danger is-light" type="button" id="delete-btn" onclick="removePPic()" >Remove Current Photo</button>
</div>
</div>
</div>
<?php $jsfile = "settings.js"?>
<?php require APPROOT.'/views/inc/footer.php'?>