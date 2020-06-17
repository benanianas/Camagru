<?php

class Homepage extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Home');
    }

    public function index()
    {
        $data = $this->model->getPosts();
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if(isset($_POST['like']))
                {
                    if($_POST['like'])
                    {
                        $img = '/img/posts/'.end(explode('/',$_POST['img']));
                        if ($this->model->likePost($img))
                            {
                                $notif = $this->model->getNotifdata($img);
                                $notif->link = URLROOT."/post/i/".end(explode("/",explode('.',$_POST['img'])[0]));
                                if ($notif->id != $_SESSION['id'] && $notif->likes_n)
                                    sendLikeNotif($notif);
                            }
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
                $this->view('homepage/userhome', $data);
    }
    
}