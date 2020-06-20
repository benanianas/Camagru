<?php

class Notfound extends Controller{
    
    public function __construct()
    {
        $this->model = $this->model('Settings');
    }

    public function index()
    {
        $this->view("notFound/errorpage", $data);
    }

    

}