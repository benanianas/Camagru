<?php

class Notfound extends Controller{
    
    public function __construct()
    {
        $this->model = $this->model('Settings');
    }

    public function index()
    {
        echo "<h1> ERROR 404<h1>";
    }

    

}