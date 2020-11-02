
<?php

Class Account extends Controller{

    public function __construct()
    {
        $this->model = $this->model('User');
    }
    public function index()
    {
        $this->login();
    }
    
    public function register()
    {
        if(isLoggedIn())
            redirect('/');
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'first_name' => trim($_POST['first_name']),
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'password_c' => $_POST['password_c'],
                'first_name_err' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'password_c_err' => ''
            ];   

            if(empty($data['first_name']))
                $data['first_name_err'] = 'Please enter your first name';
            else if(!preg_match("/^[a-zA-Z]*$/",$data['first_name']))
                    $data['first_name_err'] = 'Should contains only letters';
            else
                if(strlen($data['first_name']) > 30)
                    $data['first_name_err'] = "Enter a name under 30 characters.";



            if(empty($data['username']))
                $data['username_err'] = 'Please enter a username';
            else if(!preg_match("/^[0-9a-zA-Z_.]*$/",$data['username']))
                $data['username_err'] = 'Username can only use letters, numbers, underscores';
            else
                if($this->model->checkIfUsernameExist($data['username']))
                    $data['username_err'] = 'Username has already been taken';




            if(empty($data['email']))
                $data['email_err'] = 'Please enter an email';
            else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
                $data['email_err'] = 'Please enter an e-mail address';
            else
                if($this->model->checkIfEmailExist($data['email']))
                    $data['email_err'] = 'Email has already been taken';



            if(empty($data['password']))
                $data['password_err'] = 'Please enter a password';
            else
            {
                if(strlen($data['password']) < 8)
                    $data['password_err'] = 'password must be at least 8 characters';
                else if(strlen($data['password']) > 25)
                    $data['password_err'] = 'password too long!';
                else if(!preg_match('#[A-Z]#', $data['password']) || !preg_match('#[a-z]#', $data['password']) || !preg_match('#[\W]#', $data['password']))
                    $data['password_err'] = 'password should contain at least :<br>• one uppercase character<br>• one lowercase character<br>• one special character';   
            }


            if(empty($data['password_c']) && empty($data['password_err']))
                $data['password_c_err'] = 'Please Confirm your password';
            else{
                    if($data['password'] != $data['password_c'] && empty($data['password_err']))
                        $data['password_c_err'] = 'Passwords do not match';
            }
            if($data['password_err'])
            $data['password_c'] = '';



            
            if(empty($data['first_name_err']) && empty($data['username_err']) && empty($data['email_err']) &&
            empty($data['password_err']) && empty($data['password_c_err']))
                {
                    $data['first_name'] = ucwords(strtolower($data['first_name']));
                    $data['email'] = strtolower($data['email']);
                    $data['username'] = strtolower($data['username']);
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    if ($this->model->register($data))
                    {
                        $ret = $this->model->regVer($data);
                        flash_msg('msg', 'You are registred now, we sent you a verification mail please verify your email to log in.');
                        header("Location: ".URLROOT."/account/login");
                        sendVerification($data, $ret->token);
                    }
                    else
                        die("registration error!");
                }
            else
                $this->view('account/register', $data);

        }
        else
        {
         //initiate data
         $data = [
             'first_name' => '',
             'username' => '',
             'email' => '',
             'password' => '',
             'password_c' => '',
             'first_name_err' => '',
             'username_err' => '',
             'email_err' => '',
             'password_err' => '',
             'password_c_err' => ''
         ];
         //load registration view

         $this->view('account/register', $data);
        }
    }

    public function login()
    {
        if(isLoggedIn())
            redirect('/');
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'login' => trim($_POST['login']),
                'password' => $_POST['password'],
                'login_err' => '',
                'password_err' => '',
                'verification' => '',
                'link' => $_POST['link']
            ];
            if(empty($data['login']))
                $data['login_err'] = "Please enter an email or a username";
            if(empty($data['password']))
                $data['password_err'] = "Please enter a password";
            else{
                if(!$this->model->checkIfLoginExist($data['login']))
                {
                    if(filter_var($data['login'], FILTER_VALIDATE_EMAIL))
                        $data['login_err'] = "The email address that you've entered doesn't match any account";
                    else
                        $data['login_err'] = "The username that you've entered doesn't match any account";
                }
                else
                {
                    $ret = $this->model->checkIfPasswordValid($data);
                    if(!password_verify($data['password'], $ret->password))
                        $data['password_err'] = "The password that you've entered is incorrect.";
                }
            }
            if(!empty($data['login_err']))
                $data['password'] = '';
            if(empty($data['login_err']) && empty($data['password_err']))
            {
                if($this->model->checkIfVerified($data))
                {
                    $user = $this->model->getVerData($data);
                    $this->createUserSession($user);
                    redirect($_POST['link']);
                }
                else
                {
                    $data['verification'] = "You need to verify your email first in order to log in.";
                    $data['password'] = '';
                    $this->view('account/login', $data);
                }
                
            }
            else
                $this->view('account/login', $data);
        }
        else
        {
            $data = [
                'login' => '',
                'login_err' => '',
                'password' => '',
                'password_err' => '',
                'verification' => ''
            ];
            $this->view('account/login', $data);
        }
    }

    public function verify($token = '')
    {
        if(isLoggedIn())
            redirect('/');
        if(!empty($token))
        {
            if ($time = $this->model->tokenVerification($token))
            {
                $time = time() - strtotime($time);
                if($time < 86400)
                {
                    $this->model->verifyUser($token);
                    flash_msg('msg', 'Your email address is verified now.');
                    redirect('/account/login');
                }
                else
                {
                    $data['msg'] = "The verification link is expired, enter your username or email to receive a new one";
                    $data['status'] = 'danger';
                    $this->view('account/verify', $data);
                }
            }
            else
            {
                $data['msg'] = "Something went wrong, enter your username or email to receive a new one";
                $data['status'] = 'danger';
                $this->view('account/verify', $data);
            }

        }
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'login' => trim($_POST['login']),
                'login_err' => '',
                'msg' => '',
                'status' => ''
            ];
            if(!$this->model->checkIfLoginExist($data['login']))
            {
                if(filter_var($data['login'], FILTER_VALIDATE_EMAIL))
                    $data['login_err'] = "The email address that you've entered doesn't match any account";
                else
                    $data['login_err'] = "The username that you've entered doesn't match any account";
            }
            else if ($this->model->checkIfVerified($data))
                $data['msg'] = 'This account is already verified, <a href="'.URLROOT.'/account/login">Log In</a> now !';
            if (empty($data['login_err']) && empty($data['msg']))
            {
                $ret = $this->model->getVerData($data);
                $time = strtotime($ret->time);
                $time = time() - $time;
                $token = $ret->token;
                $arg = [
                    'email' => $ret->email,
                    'first_name' => $ret->first_name
                ];
                if($time > 86400)
                    $token = $this->model->updateToken($data);
                sendVerification($arg, $token);
                $data['msg'] = "We sent you a verification mail check your email address! ";
            }
            $this->view('account/verify', $data);
        }
        else
        {
            $data = [
                'login' => $_SERVER['login'],
                'login_err' => '',
                'msg' => '',
                'status' => ''
            ];
            $this->view('account/verify', $data);
        }
        
    }

    public function reset_password($token = '')
    {
        if(isLoggedIn())
            redirect('/');
        if(!empty($token))
        {
            if($time = $this->model->tokenVerification($token))
            {
                $time = time() - strtotime($time);
                if($time < 7200)
                {
                    $this->model->verifyUser($token);
                    redirect('/account/set_password/'.$token);
                }
                else
                {
                    $data['msg'] = "the link is expired.";
                    $data['status'] = "danger";
                }
            }
            else
            {
                $data['msg'] = "something went wrong, enter your username or email to receive a new link";
                $data['status'] = "danger";   
            }
            $this->view('account/reset_password', $data);
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'login' => $_POST['login'],
                'login_err' => '',
                'msg' => '',
                'status' => ''
            ];
            if($this->model->checkIfLoginExist($data['login']))
            {
                $token = $this->model->updateToken($data);
                $ret = $this->model->getVerData($data);
                $arg = [
                    'first_name' => $ret->first_name,
                    'email' => $ret->email
                ];
                sendPasswordReset($arg, $token);
                $data['msg'] = 'an email is sent to you containing a link to reset your password.';
            }
            else
            {
                if(filter_var($data['login'], FILTER_VALIDATE_EMAIL))
                    $data['login_err'] = "The email address that you've entered doesn't match any account";
                else
                    $data['login_err'] = "The username that you've entered doesn't match any account";
            }
            $this->view('account/reset_password', $data);
        }
        else
        {
            $data = [
                'login' => '',
                'login_err' => '',
                'msg' => '',
                'status' => ''
            ];

            $this->view('account/reset_password', $data);

        }
    }

    public function set_password($token = '')
    {
        if(isLoggedIn())
            redirect('/');
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'password' => $_POST['password'],
                'password_c' => $_POST['password_c'],
                'password_err' => '',
                'password_c_err' => ''
            ];   
            if(empty($data['password']))
                $data['password_err'] = 'Please enter a password';
            else
            {
                if(strlen($data['password']) < 8)
                    $data['password_err'] = 'password must be at least 8 characters';
                else if(strlen($data['password']) > 25)
                    $data['password_err'] = 'password too long!';
                else if(!preg_match('#[A-Z]#', $data['password']) || !preg_match('#[a-z]#', $data['password']) || !preg_match('#[\W]#', $data['password']))
                    $data['password_err'] = 'password should contain at least :<br>• one uppercase character<br>• one lowercase character<br>• one special character';   
            }
            if(empty($data['password_c']) && empty($data['password_err']))
                $data['password_c_err'] = 'Please Confirm your password';
            else{
                    if($data['password'] != $data['password_c'] && empty($data['password_err']))
                        $data['password_c_err'] = 'Passwords do not match';
            }
            if($data['password_err'])
            {
                $data['password_c'] = '';
                $data['password_c_err'] = '';
            }
            if(empty($data['password_err']) && empty($data['password_c_err']))
            {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->model->resetPassword($data['password'], $_SESSION['token']);
                unset($_SESSION['token']);
                flash_msg('msg', 'Password changed, you can login now!');
                redirect('/account/login');
            }
            else
                $this->view('account/set_password', $data);
        }
        else
        {
        $data = [
            'password' => '',
            'password_c' => '',
            'password_err' => '',
            'password_c_err' => ''
        ];
        $_SESSION['token'] = $token;
        $this->view('account/set_password', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['username'] = $user->username;
        $_SESSION['token'] = bin2hex(random_bytes(12));
        redirect('');
    }

    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        unset($_SESSION['token']);
        session_destroy();
        redirect('/account/login');
    }
}