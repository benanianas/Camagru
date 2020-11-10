<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/login.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>
<body>
<div class="thecontent">
<div class="hp-navbar">
    <div class="logo-side">
        <div class="logo"><a href="<?php echo URLROOT?>"> <img src="<?php echo URLROOT?>/img/logo.png"></a></div>
    </div>
    <div class="login">
    Don't have an account yet?
    <a href="<?php echo URLROOT?>/account/register">Register</a>
</div>
<i id="bars-i" class="bars-i fa fa-bars"></i>
</div>
    <div class="phone-nav">
        <a href="<?php echo URLROOT?>/account/register"><div class="nav-link">Register</div></a>
    </div>
<!-- login box -->

<div  class="login-box">
    <p>Camagru login</p>
    <form class="myform" action="<?php echo URLROOT?>/account/login" method="post">
    <?php 
    if (array_key_exists('msg', $data) && $_SESSION['msg'])
    {
        echo '<article class="message is-success is-small"><div class="message-body ">';
        echo flash_msg('msg');
        echo '</div></article>';
    }
    ?>
    <?php 
    if (array_key_exists('verification', $data) && $data['verification'])
    {
        echo '<article class="message is-danger is-small"><div class="message-body ">';
        echo $data['verification']."<br><a href='";
        echo URLROOT;
        echo"/account/verify'>Verify now</a>";
        echo '</div></article>';
    }
    ?>
    <div class="field">
        <label >Email or Username</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="login" type="text" value="<?php if(!$data['login_err'])echo $data['login'];?>">
            <span class="icon is-small is-left">
            <i class="fas fa-user"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['login_err']){echo $data['login_err'];} ?></p>
    </div>
    <div class="field">
        <label >Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="password" type="password" value="<?php if(!$data['password_err'])echo $data['password'];?>">
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['password_err']){echo $data['password_err'];} ?></p>
    </div>
    <input type="hidden" name="link" value="<?php if (array_key_exists('link', $data)) echo $data['link'];?>">    
        <div class="control">
    <input type="submit" value="Log In" class="button is-linkclass is-primary">
    <div class="f_pass"><a href="<?php echo URLROOT?>/account/reset_password">Forgot password ?</a></div>
</form>
</div>
</div>

<?php require APPROOT.'/views/inc/footer.php'?>


