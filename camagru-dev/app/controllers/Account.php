<?php

Class Account extends Controller{

    public function __construct()
    {
        $this->model = $this->model('User');
    }
    public function index()
    {
        //$this->register();
    }
    
    public function register()
    {
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
                    $data['first_name_err'] = "It's too long";



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
            else{
                if(strlen($data['password']) < 6)
                {
                    $data['password_err'] = 'password must be at least 6 characters';
                    $data['password_c_err'] = ' ';
                }
            }



            if(empty($data['password_c']))
                $data['password_c_err'] = 'Please Confirm your password';
            else{
                    if($data['password'] != $data['password_c'])
                    $data['password_c_err'] = 'Passwords do not match';
            }


            
            if(empty($data['first_name_err']) && empty($data['username_err']) && empty($data['email_err']) &&
            empty($data['password_err']) && empty($data['password_c_err']))
                {
                    $data['first_name'] = ucwords(strtolower($data['first_name']));
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $this->model->register($data);
                    die("success");
                }
            else
            {
                $this->view('account/register', $data);
            }

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
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'login' => $_POST['login'],
                'password' => $_POST['password'],
                'login_err' => '',
                'password_err' => ''
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
            if(empty($data['login_err']) && empty($data['password_err']))
            {
                die ("success");
                echo $data['email'];
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
                'password_err' => ''
            ];
            $this->view('account/login', $data);
        }
    }
}
