<?php

class User{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    


    public function register($data)
    {
        $this->db->query('INSERT INTO `users` (`first_name`,`username`,`email`,`password`,`status`,`token`, `time`) VALUES (:first_name, :username, :email, :passwd, :stat, :tok, now())');
        $this->db->placeholder(':first_name', $data['first_name']);
        $this->db->placeholder(':username', $data['username']);
        $this->db->placeholder(':email', $data['email']);
        $this->db->placeholder(':passwd', $data['password']);
        $this->db->placeholder(':stat', '0');
        $token = bin2hex(random_bytes(16));
        $this->db->placeholder(':tok', $token);
        return $this->db->execute();
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

    public function checkIfUsernameExist($username)
    {
        $this->db->query('SELECT * FROM `users` WHERE `username` = :username');
        $this->db->placeholder(':username', $username);
        $this->db->single();
        $row = $this->db->rowcount();

        if ($row)
            return TRUE;
        else
            return FALSE;
    }

    public function checkIfLoginExist($login)
    {
        if($this->checkIfEmailExist($login))
            return TRUE;
        else if($this->checkIfUsernameExist($login))
            return TRUE;
        else
            return FALSE;
    }

    public function checkIfPasswordValid($data)
    {
        $this->db->query('SELECT `password` FROM `users` WHERE `username` = :username OR `email` = :email');
        $this->db->placeholder(':username', $data['login']);
        $this->db->placeholder(':email', $data['login']);
        return $this->db->single();
    }

    public function regVer($data)
    {
        $this->db->query("SELECT `token` FROM `users` WHERE `email` = :email");
        $this->db->placeholder(':email', $data['email']);
        return $this->db->single();
    }

    public function checkIfVerified($data)
    {
        $this->db->query("SELECT `status` FROM `users` WHERE `username` = :username OR `email` = :email");
        $this->db->placeholder(':username', $data['login']);
        $this->db->placeholder(':email', $data['login']);
        $ret = $this->db->single();

        if ($ret->status == '1')
            return TRUE;
        else
            return FALSE;
    }
    public function getVerData($data)
    {
        $this->db->query("SELECT * FROM `users` WHERE `username` = :username OR `email` = :email");
        $this->db->placeholder(':username', $data['login']);
        $this->db->placeholder(':email', $data['login']);
        return $this->db->single();
    }
    
    public function updateToken($data)
    {
        $this->db->query("UPDATE `users` SET `token` = :token, `time` = now() WHERE `username` = :username OR `email` = :email");
        $this->db->placeholder(':username', $data['login']);
        $this->db->placeholder(':email', $data['login']);
        $token = bin2hex(random_bytes(16));
        $this->db->placeholder(':token', $token);
        $this->db->execute();
        return $token;
    }

    public function tokenVerification($token)
    {
        $this->db->query("SELECT `token`, `time` FROM  `users` WHERE `token` = :token");
        $this->db->placeholder(':token', $token);
        $ret = $this->db->single();

        $row = $this->db->rowcount();

        if ($row)
            return $ret->time;
        else
            return FALSE;
    }

    public function verifyUSer($token)
    {
        $this->db->query("UPDATE `users` set `status` = 1 WHERE `token` = :token");
        $this->db->placeholder(':token', $token);
        $this->db->execute();
    }
}