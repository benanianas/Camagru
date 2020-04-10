<?php

class Test extends Controller{
    
    public function __construct()
    {
        $this->model = $this->model('Settings');
    }

    public function justest()
    {
        $this->view('pages/about', $data);
    }

}