<?php

class Settings{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataById($id)
    {
        $this->db->query('SELECT * FROM `users` WHERE `id` = :theid');
        $this->db->placeholder(':theid', $id);
        return $this->db->single(); 
    }

    public function updatePic($img, $id)
    {
        $this->db->query('UPDATE `users` SET `p_photo` = :img WHERE `id` = :id');
        $this->db->placeholder(':img', $img);
        $this->db->placeholder(':id', $id);
        $this->db->execute();
    }

    public function checkIfUsernameExist($username)
    {
        $this->db->query('SELECT * FROM `users` WHERE `username` = :username');
        $this->db->placeholder(':username', $username);
        $this->db->single();
        $row = $this->db->rowcount();

        if ($row)
        {
            
        }
        else
            return 0;
    }
    public function checkIfEmailExist($email)
    {
        $this->db->query('SELECT * FROM `users` WHERE `email` = :email');
        $this->db->placeholder(':email', $email);
        $this->db->single();
        $row = $this->db->rowcount();

        if ($row)
            return TRUE;
        else
            return FALSE;
    }

    public function updateName($data, $id)
    {
        $this->db->query('UPDATE `users` SET `first_name` = :firstname WHERE `id` = :id');
        $this->db->placeholder(':firstname', $data['name']);
        $this->db->placeholder(':id', $id);
        $this->db->execute();
    }

    public function updateUsername($data, $id)
    {
        $this->db->query('UPDATE `users` SET `username` = :username WHERE `id` = :id');
        $this->db->placeholder(':username', $data['username']);
        $this->db->placeholder(':id', $id);
        $this->db->execute();
    }
    

    public function updateEmail($data, $id)
    {
        $this->db->query("UPDATE `users` SET `email` = :email, `token` = :token, `time` = now(), `status` = '0'  WHERE `id` = :id");
        $this->db->placeholder(':email', $data['email']);
        $this->db->placeholder(':id', $id);
        $token = bin2hex(random_bytes(16));
        $this->db->placeholder(':token', $token);
        $this->db->execute();

        return $token;
    }
    public function updatePassword($data, $id)
    {
        $this->db->query("UPDATE `users` SET `password` = :pass WHERE `id` = :id");
        $pass = password_hash($data['newpassword'], PASSWORD_DEFAULT);
        $this->db->placeholder(':pass', $pass);
        $this->db->placeholder(':id', $id);
        $this->db->execute();
    }


    //just for a test
    // you need to remove it Anas
    public function forTest($username)
    {
        $this->db->query('SELECT * FROM `users` WHERE `username` = :user');
        $this->db->placeholder(':user', $username);
        return $this->db->single(); 
    }

    public function notificationStatus($id)
    {
        $this->db->query("SELECT `comments_n`, `likes_n` FROM `users` WHERE `id` = :id");
        $this->db->placeholder(':id', $id);
        return $this->db->single(); 
    }

    public function updateNotification($notif , $val, $id)
    {
        $this->db->query("UPDATE `users` SET `".$notif."` = :val WHERE `id` = :id");
        $this->db->placeholder(':id', $id);
        $this->db->placeholder(':val', $val);
        $this->db->execute();

    }
}