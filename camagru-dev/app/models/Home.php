<?php

class Home{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPosts()
    {
        $this->db->query("SELECT `posts`.`id`,`p_photo`,`username`,`img` FROM `posts` LEFT JOIN `users` ON `posts`.`user_id` = `users`.`id` ORDER BY `created_at` DESC");
        $data = $this->db->result();
        
        foreach ($data as $elm)
        {
            $this->db->query("SELECT COUNT(*) AS 'likes' FROM `likes` WHERE `post_id` = ".$elm->id);
            $likes = $this->db->single()->likes;
            $elm->likes = $likes;

            if(isset($_SESSION['id']))
            {
                $this->db->query("SELECT `user_id` FROM `likes` WHERE `post_id` = ".$elm->id." AND `user_id` =".$_SESSION['id']);
                $this->db->single();
                $liked = $this->db->rowcount();
                $elm->liked = $liked;
            }

            $this->db->query("SELECT `id`,`username`, `comment` FROM `comments` JOIN `users` ON `comments`.`user_id` = `users`.`id` WHERE `post_id` = ".$elm->id." ORDER BY `created_at` DESC LIMIT 3");
            $comments = $this->db->result();
            $elm->comments = $comments;

        }
        
        // foreach ($data as $elm)
        // {
        //     echo $elm->id."  :  ";
        //     foreach($elm->likers as $i)
        //     {
        //         echo $i->user_id."  -  ";
        //     }
        //     echo "<br><br>";
        // }
        
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


}