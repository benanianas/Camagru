<?php require APPROOT.'/views/inc/header.php'?>
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
</div>
<!-- login box -->

<div  class="login-box">
    <p>Reset Password</p>
    <form class="myform" action="<?php echo URLROOT?>/account/reset_password" method="post">
    <?php 
    if ($data['msg'])
    {
        echo '<article class="message ';
        echo ($data['status'] === 'danger') ? 'is-danger' : 'is-primary'; 
        echo ' is-small"><div class="message-body ">';
        echo $data['msg'];
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
  
    
        <div class="control">
    <input type="submit" value="Continue" class="button is-linkclass is-primary">

</form>
</div>
</div>

<?php require APPROOT.'/views/inc/footer.php'?>


