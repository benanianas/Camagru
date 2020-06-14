<?php

class Publisher{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // public function pic($data, $id)
    // {
    //     $this->db->query('UPDATE `users` SET `token` = :pic WHERE `id` = :id');
    //     $this->db->placeholder(':pic', $data);
    //     $this->db->placeholder(':id', $id);
    //     $this->db->execute();
    // }

    public function postIt($id, $path)
    {
        $this->db->query("INSERT INTO `posts` (`user_id`, `img`) VALUES (:user, :imgpath)");
        $this->db->placeholder(':user', $id);
        $this->db->placeholder(':imgpath', $path);
        $this->db->execute();
    }

    public function getPosts($id)
    {
        $this->db->query("SELECT `img` FROM `posts` WHERE `user_id` = :user ORDER BY `created_at` DESC");
        $this->db->placeholder(':user', $id);
        return $this->db->result();
    }

    public function deletePost($id, $img)
    {
        $this->db->query("SELECT * FROM `posts` WHERE `img` = :img AND `user_id` = :id");
        $this->db->placeholder(':id', $id);
        $this->db->placeholder(':img', $img);

        $this->db->single();
        $row = $this->db->rowcount();

        if ($row)
        {
            $this->db->query("DELETE FROM `posts` WHERE `img` = :img");
            $this->db->placeholder(':img', $img);
            $this->db->execute();
            return TRUE;
        }
        else
            return FALSE;
    }

    
}