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
                'password' => trim($_POST['password']),
                'password_c' => trim($_POST['password_c']),
                'full_name_err' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'password_c_err' => ''
            ];   

            if(empty($data['full_name']))
                $data['full_name_err'] = 'Please Enter your full name';
            if(empty($data['username']))
                $data['username_err'] = 'Please Enter a valid username';
            if(empty($data['email']))
                $data['email_err'] = 'Please Enter an email';
            if(empty($data['password']))
                $data['password_err'] = 'Please Enter a password';
            else{
                if(strlen($data['password'] < 6))
                    $data['password'] = 'password must be at least 6 characters';
            }
            if(empty($data['password_c']))
                $data['password_c_err'] = 'Please Enter a password';
            else{
                    if($data['password'] != $data['password_c'])
                    $data['password_c_err'] = 'Passwords do not match';
            }
            if(empty($data['full_name_err']) && empty($data['username']) && empty($data['email_err']) &&
            empty($data['password_err']) && empty($data['password_c_err']))
                die('success');
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
