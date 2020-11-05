<?php

class Homepage extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Home');
    }

    public function index()
    {
        //pagination Beginning
        
        $posts_per_page = 2;
        $posts_count = $this->model->postsNbr();
        $pages_nbr = ceil($posts_count / $posts_per_page);
        $page = 1;
        if(!$posts_count)
        {
            $this->view('homepage/publichome', $data);
            return;
        }
        // if(isset($_GET['page']))
        // {
        //     if(is_numeric($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $pages_nbr )
        //         $page = $_GET['page'];
        // }
        $from = ($page - 1)*$posts_per_page;

        // pagination End


        $posts = $this->model->getPosts($from, $posts_per_page);
        $data = [
            'posts' => $posts,
            'page' => $page,
            'max' =>  $pages_nbr
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(isset($_POST['page']))
            {
                $from = ($_POST['page'] - 1)*$posts_per_page;
                $posts = $this->model->getPosts($from, $posts_per_page);
                $data = [
                    'posts' => $posts,
                    'page' => $page,
                    'max' =>  $pages_nbr
                ];


                echo json_encode($data);
                return;
            }
            if($_SESSION['token'] != $_POST['token'])
            {
                unset($_SESSION['token']);
                $_SESSION['token'] = bin2hex(random_bytes(12));
                $this->view('homepage/userhome', $data);
                return;
            }
            if(isset($_POST['like']))
            {
                if($_POST['like'])
                {
                    $img = '/img/posts/'.end(explode('/',$_POST['img']));
                    if ($this->model->likePost($img))
                        {
                            $notif = $this->model->getNotifdata($img);
                            $notif->link = URLROOT."/post/i/".explode(".",end(explode("/",$_POST['img'])))[0];

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