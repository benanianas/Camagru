<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/registration.css">
</head>
<body>
<div class="homepage">
<div class="hp-navbar">
    <div class="logo-side">
        <div class="logo"><a href="<?php echo URLROOT?>"> <img src="<?php echo URLROOT?>/img/logo.png"></a></div>
        <div class="logo-title"><a href="<?php echo URLROOT?>"> Camagru</a></div>
    </div>
    <div class="login">
    Already have an account ?
    <a href="#">Log In</a>
</div>
</div>
<!-- registration box -->

<div  class="registration-box">
    <p>Welcome to Camagru!</p>
    <p>Registration is free, fast, and simple.</p>
    <form class="myform"action="<?php echo URLROOT?>/account/register" method="post">
    <div class="field">
        
        <label >Full Name</label>
        <input class="input" name="full_name" type="text">
        <p class="help is-danger"><?php if($data['full_name_err']){echo $data['full_name_err'];} ?></p>
    </div>
    <div class="field">
        <label >Username</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="username" type="text" >
            <span class="icon is-small is-left">
            <i class="fas fa-user"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['username_err']){echo $data['username_err'];} ?></p>
    </div>
    <div class="field">
        <label >Email</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="email" type="text" >
            <span class="icon is-small is-left">
            <i class="fas fa-envelope"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['email_err']){echo $data['email_err'];} ?></p>
    </div>
    <div class="field">
        <label >Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="password" type="password" >
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['password_err']){echo $data['password_err'];} ?></p>
    </div>
    <div class="field">
        <label >Confirm Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input" name="password_c" type="password" >
            <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
            </span>
        </div>
        <p class="help is-danger"><?php if($data['password_c_err']){echo $data['password_c_err'];} ?></p>
    </div>
        <div class="control">
    <input type="submit" value="Register" class="button is-linkclass is-primary">
  </div>
</form>
</div>

<?php require APPROOT.'/views/inc/footer.php'?>
