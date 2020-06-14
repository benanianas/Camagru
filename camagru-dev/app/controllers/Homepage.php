<?php

class Homepage extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Home');
    }

    public function index()
    {
        $data = $this->model->getPosts();
        if (isLoggedIn())
        {

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if(isset($_POST['like']))
                {
                    if($_POST['like'])
                    {
                        $img = '/img/posts/'.end(explode('/',$_POST['img']));
                        $this->model->likePost($img);
                    }
                    else
                    {
                        $img = '/img/posts/'.end(explode('/',$_POST['img']));
                        $this->model->unlikePost($img);
                    }
                }
            }
            else
                $this->view('homepage/userhome', $data);
        }
        else
            $this->view('homepage/publichome', $data);
    }
    
}