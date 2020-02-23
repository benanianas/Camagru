<?php

Class Account extends Controller{

    public function __construct()
    {

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
                'full_name' => trim($_POST['full_name']),
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'password_c' => $_POST['password_c'],
                'full_name_err' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'password_c_err' => ''
            ];   

            if(empty($data['full_name']))
                $data['full_name_err'] = 'Please enter your full name';
            else if(!preg_match("/^[a-zA-Z ]*$/",$data['full_name']))
                    $data['full_name_err'] = 'Should contains only letters and spaces';
            else
                if(strlen($data['full_name']) > 30)
                    $data['full_name_err'] = 'twiil';
            if(empty($data['username']))
                $data['username_err'] = 'Please enter a username';
            else
                if(!preg_match("/^[1-9a-zA-Z_]*$/",$data['username']))
                    $data['username_err'] = 'Please enter a valid username';
            if(empty($data['email']))
                $data['email_err'] = 'Please enter an email';
            else
                if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
                    $data['email_err'] = 'Please enter an e-mail address';
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
            
            if(empty($data['full_name_err']) && empty($data['username_err']) && empty($data['email_err']) &&
            empty($data['password_err']) && empty($data['password_c_err']))
                {
                    die('success');
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
             'full_name' => '',
             'username' => '',
             'email' => '',
             'password' => '',
             'password_c' => '',
             'full_name_err' => '',
             'username_err' => '',
             'email_err' => '',
             'password_err' => '',
             'password_c_err' => ''
         ];
         //load registration view

         $this->view('account/register', $data);
        }
    }
}
