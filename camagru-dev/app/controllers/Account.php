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
        if($_SERVER['REQUEST_POST'] == 'POST')
        {
            // Process the form
        }
        else
        {
         //initiate data
         $data = [
             'full_name' => 'anas benani',
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
