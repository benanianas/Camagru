<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/registration.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/login.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>

<body>
    <div class="thecontent">
        <div class="hp-navbar">
            <div class="logo-side">
                <div class="logo"><a href="<?php echo URLROOT?>"> <img src="<?php echo URLROOT?>/img/logo.png"></a>
                </div>
            </div>
            <div class="login">
                Already have an account ?
                <a href="<?php echo URLROOT?>/account/login">Log In</a>
            </div>
            <i id="bars-i" class="bars-i fa fa-bars"></i>
</div>
    <div class="phone-nav">
        <a href="<?php echo URLROOT?>/account/login"><div class="nav-link">Log In</div></a>
    </div>
        <!-- registration box -->

        <div class="registration-box">
            <p>Welcome to Camagru!</p>
            <p>Registration is free, fast, and simple.</p>
            <form class="myform" action="<?php echo URLROOT?>/account/register" method="post">
                <div class="field">

                    <label>First Name</label>
                    <input class="input" name="first_name" type="text"
                        value="<?php if(!$data['first_name_err'])echo $data['first_name'];?>">
                    <p class="help is-danger"><?php if($data['first_name_err']){echo $data['first_name_err'];} ?></p>
                </div>
                <div class="field">
                    <label>Username</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" name="username" type="text"
                            value="<?php if(!$data['username_err'])echo $data['username'];?>">
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                    <p class="help is-danger"><?php if($data['username_err']){echo $data['username_err'];} ?></p>
                </div>
                <div class="field">
                    <label>Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" name="email" type="text"
                            value="<?php if(!$data['email_err'])echo $data['email'];?>">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    <p class="help is-danger"><?php if($data['email_err']){echo $data['email_err'];} ?></p>
                </div>
                <div class="field">
                    <label>Password</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" name="password" type="password"
                            value="<?php if(!$data['password_err'])echo $data['password'];?>">
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                    <p class="help is-danger"><?php if($data['password_err']){echo $data['password_err'];} ?></p>
                </div>
                <div class="field">
                    <label>Confirm Password</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" name="password_c" type="password"
                            value="<?php if(!$data['password_c_err'])echo $data['password_c'];?>">
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