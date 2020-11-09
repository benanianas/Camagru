<?php

class Post extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Postm');
    }

    public function index()
    {
        $this->view("notFound/errorpage", $data);
    }
    public function i($id = '')
    {
        if($id == '')
            $this->view("notFound/errorpage", $data);
        else
        {
            $data = $this->model->getPost($id);
            if($data)
            {
                if($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    if($_SESSION['token'] != $_POST['token'])
                    {
                        unset($_SESSION['token']);
                        $_SESSION['token'] = bin2hex(random_bytes(12));
                        $this->view('posts/postv', $data);
                        return;
                    }
                    if(isset($_POST['like']))
                    {
                        if($_POST['like'])
                        {
                            $tmp = explode('/',$_POST['img']);
                            $img = '/img/posts/'.end($tmp);
                            if ($this->model->likePost($img))
                            {
                                $notif = $this->model->getNotifdata($img);
                                $tmp = explode("/",$_POST['img']);
                                $tmp = end($tmp);
                                $notif->link = URLROOT."/post/i/".explode(".",$tmp)[0];
                                if ($notif->id != $_SESSION['id'] && $notif->likes_n)
                                    sendLikeNotif($notif);
                            }

                        }
                        else
                        {
                            $tmp = explode('/',$_POST['img']);
                            $img = '/img/posts/'.end($tmp);
                            $this->model->unlikePost($img);
                        }
                    }

                    else if(isset($_POST['comment']))
                    {
                        $tmp = explode('/',$_POST['post']);
                        $img = '/img/posts/'.end($tmp).'.png';
                        if($cmt_id = $this->model->postComment($img, $_POST['comment']))
                            echo $_SESSION['username'].'/'.$cmt_id."/sent";
                    }

                    else if(isset($_POST['cmt-notif']))
                    {
                        $tmp = explode('/',$_POST['link']);
                        $img = '/img/posts/'.end($tmp).'.png';
                        $notif = $this->model->getNotifdata($img);
                        $notif->link = $_POST['link'];
                        if ($notif->id != $_SESSION['id'] && $notif->comments_n)
                            sendCommentNotif($notif);      
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
                $this->view("notFound/errorpage", $data);
        }
    }

}