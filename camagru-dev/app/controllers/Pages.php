<?php

class Pages extends Controller{

    private $postmodel;

    public function __construct()
    {
        $this->$postmodel = $this->model('Post');
        
    }
    public function index()
    {
        //$data = $this->$postmodel->getUsers();
        if (isLoggedIn())
            $this->view('pages/home', $data);
        else
            $this->view('pages/homepage', $data);
    }
    public function about()
    {
        $this->view('pages/about');
    }
}