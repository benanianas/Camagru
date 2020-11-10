<?php

class Homepage extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Home');
    }

    public function index()
    {
        //pagination Beginning
        $ppp = 2;
        $posts_per_page = $ppp;
        $pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache'); 


        $posts_count = $this->model->postsNbr();
        $pages_nbr = ceil($posts_count / $posts_per_page);
        $page = 1;
        if(!$posts_count)
        {
            $this->view('homepage/publichome', $data='');
            return;
        }
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['page']))
        {
            if(is_numeric($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $pages_nbr )
                $page = $_GET['page'];
        }
        else
        {
            if(isset($_COOKIE['pages']) && $_COOKIE['pages'] != '1' && !$pageRefreshed)
            {
                $posts_per_page = $posts_per_page * $_COOKIE['pages'];
            }
            else if($pageRefreshed)
                setcookie('pages', '1');
            // if(isset($_POST['refresh']))
            // {
            //     $posts_per_page = $ppp;
            //     setcookie('pages', '1');
            // }
        }


        

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
                $posts_per_page = $ppp;
                $from = ($_POST['page'] - 1)*$posts_per_page;
                $posts = $this->model->getPosts($from, $posts_per_page);
                $data = [
                    'posts' => $posts,
                    'page' => $page,
                    'max' =>  $pages_nbr
                ];

                if(!isset($_GET['page']))
                    echo json_encode($data);
                return;
            }
            // if(isset($_POST['max']))
            // {
            //     echo ""
            // }
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
                $cmt_id = $this->model->postComment($img, $_POST['comment']);
                echo $_SESSION['username'].'/'.$cmt_id;
            }
            else if(isset($_POST['delete']))
            {
                $comments = $this->model->deleteComment($_POST['cmt'], $_POST['bimg']);
                echo json_encode($comments);
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