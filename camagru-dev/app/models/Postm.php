<?php

class Postm{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPost($id)
    {
        $img = '/img/posts/'.$id.'.png';
        $this->db->query("SELECT `posts`.`id`,`p_photo`,`username`,`img`,`user_id` FROM `posts` LEFT JOIN `users` ON `posts`.`user_id` = `users`.`id` WHERE `img` = :img");
        $this->db->placeholder(":img", $img);
        $data = $this->db->result();
        if(!$data)
            return FALSE;
        
        $data = $data[0];
    
        $this->db->query("SELECT COUNT(*) AS 'likes' FROM `likes` WHERE `post_id` = ".$data->id);
        $likes = $this->db->single()->likes;
        $data->likes = $likes;

        if(isset($_SESSION['id']))
        {
            $this->db->query("SELECT `user_id` FROM `likes` WHERE `post_id` = ".$data->id." AND `user_id` =".$_SESSION['id']);
            $this->db->single();
            $liked = $this->db->rowcount();
            $data->liked = $liked;
        }

        $this->db->query("SELECT `id_c`,`id`,`username`, `comment` FROM `comments` JOIN `users` ON `comments`.`user_id` = `users`.`id` WHERE `post_id` = ".$data->id." ORDER BY `created_at` DESC");
        $comments = $this->db->result();
        $data->comments = $comments;

        return $data;
    }


    public function likePost($img)
    {
        $this->db->query("SELECT `id` FROM `posts` WHERE `img` = :img");
        $this->db->placeholder(":img", $img);
        $postId = $this->db->single()->id;



        $this->db->query("SELECT * FROM `likes` WHERE `post_id` = :postid AND `user_id` = :userid");
        $this->db->placeholder(':postid', $postId);
        $this->db->placeholder(':userid', $_SESSION['id']);
        $this->db->single();
        $liked = $this->db->rowcount();


        if($postId && !$liked){
            $this->db->query("INSERT INTO `likes` (`post_id`, `user_id`) VALUES (:postid, :userid)");
            $this->db->placeholder(":postid", $postId);
            $this->db->placeholder(":userid", $_SESSION['id']);
            $this->db->execute();
        }
    }


    public function unlikePost($img)
    {
        $this->db->query("SELECT `id` FROM `posts` WHERE `img` = :img");
        $this->db->placeholder(":img", $img);
        $postId = $this->db->single()->id;



        $this->db->query("SELECT * FROM `likes` WHERE `post_id` = :postid AND `user_id` = :userid");
        $this->db->placeholder(':postid', $postId);
        $this->db->placeholder(':userid', $_SESSION['id']);
        $this->db->single();
        $liked = $this->db->rowcount();


        if($postId && $liked){
            $this->db->query("DELETE FROM `likes` WHERE `post_id` = :postid AND `user_id` = :userid");
            $this->db->placeholder(":postid", $postId);
            $this->db->placeholder(":userid", $_SESSION['id']);
            $this->db->execute();
        }
    }

    public function postComment($img, $comment)
    {
        $this->db->query("SELECT `id` FROM `posts` WHERE `img` = :img");
        $this->db->placeholder(":img", $img);
        $id = $this->db->single()->id;

        $this->db->query("INSERT INTO `comments` (`post_id`, `user_id`, `comment`) VALUES (:id, :userid, :comment )");
        $this->db->placeholder(":id", $id);
        $this->db->placeholder(":userid", $_SESSION['id']);
        $this->db->placeholder(":comment", $comment);
        $this->db->execute();


        $this->db->query("SELECT `id_c` FROM `comments` WHERE `comment` = :comment ORDER BY `id_c` DESC LIMIT 1");
        $this->db->placeholder(":comment", $comment);
        return $this->db->single()->id_c;
    }


    public function deleteComment($cmt_id)
    {
        $this->db->query("SELECT `user_id`, `post_id` FROM `comments` WHERE `id_c` = :cmtid");
        $this->db->placeholder(":cmtid", $cmt_id);
        $ret = $this->db->single();

        $cmt_owner = $ret->user_id;
        $post_id = $ret->post_id;

        
        $this->db->query("SELECT `user_id` FROM `posts` WHERE `id` = :post");
        $this->db->placeholder(":post", $post_id);
        $post_owner = $this->db->single()->user_id;
        
        // echo $cmt_owner."   ".$post_owner;
        if ($cmt_owner == $_SESSION['id'] || $post_owner == $_SESSION['id'])
        {
            $this->db->query("DELETE FROM `comments` WHERE `id_c` = :cmtid");
            $this->db->placeholder(":cmtid", $cmt_id);
            $ret = $this->db->execute();
        }
    }


    public function editComment($cmt_id , $cmt)
    {
        $this->db->query("UPDATE `comments` SET `comment` = :cmt WHERE `id_c` = :cmtid AND `user_id` =".$_SESSION['id']);
        $this->db->placeholder(":cmtid", $cmt_id);
        $this->db->placeholder(":cmt", $cmt);
        $this->db->execute();
    }


}