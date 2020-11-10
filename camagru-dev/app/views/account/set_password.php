<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/login.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/verify.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>
<body>
<div class="thecontent">
<div class="hp-navbar">
    <div class="logo-side">
        <div class="logo"><a href="<?php echo URLROOT?>"> <img src="<?php echo URLROOT?>/img/logo.png"></a></div>
    </div>
    <div class="account-buttons">
    <a href="<?php echo URLROOT?>/account/login">Log In</a>
    <a class="register" href ="<?php echo URLROOT?>/account/register">Register</a>

    </div>
    <i id="bars-i" class="bars-i fa fa-bars"></i>
</div>
    <div class="phone-nav">
        <a href="<?php echo URLROOT?>/account/login"><div class="nav-link">Log In</div></a>
        <a href="<?php echo URLROOT?>/account/register"><div class="nav-link">Register</div></a>
    </div>
<!-- login box -->

<div  class="login-box">
    <p>Set a new passord</p>
    <form class="myform" action="<?php echo URLROOT?>/account/set_password" method="post">
    <?php 
    if (array_key_exists('msg', $data) && $data['msg'])
    {
        echo '<article class="message ';
        echo ($data['status'] === 'danger') ? 'is-danger' : 'is-primary'; 
        echo ' is-small"><div class="message-body ">';
        echo $data['msg'];
        echo '</div></article>';
    }
    ?>
     <div class="field">
        <label >New Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="password" type="password" value="<?php if(!$data['password_err'])echo $data['password'];?>">
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['password_err']){echo $data['password_err'];} ?></p>
    </div>

    <div class="field">
        <label >Confirm Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="password_c" type="password" value="<?php if(!$data['password_err'])echo $data['password'];?>">
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['password_c_err']){echo $data['password_c_err'];} ?></p>
    </div>
    
        <div class="control">
    <input type="submit" value="Submit" class="button is-linkclass is-primary">

</form>
</div>
</div>

<?php require APPROOT.'/views/inc/footer.php'?>


