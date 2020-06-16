<?php

class Post extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Postm');
    }

    public function index()
    {
        echo "error";
    }
    public function i($id = '')
    {
        if($id == '')
            echo "error";
        else
        {
            $data = $this->model->getPost($id);
            if($data)
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

                    else if(isset($_POST['comment']))
                    {
                        $img = '/img/posts/'.end(explode('/',$_POST['post'])).'.png';
                        $cmt_id = $this->model->postComment($img, $_POST['comment']);
                        echo $_SESSION['username'].'/'.$cmt_id;
                    }
                    else if(isset($_POST['delete']))
                    {
                        $this->model->deleteComment($_POST['cmt']);
                    }
                    else if(isset($_POST['edit']))
                    {
                        echo $_POST['id']." :  ".$_POST['cmt'];
                        $this->model->editComment($_POST['id'], $_POST['cmt']);
                    }
                }
                else
                    $this->view('posts/postv', $data);
            }
            else
                echo "error3";
        }
    }

}