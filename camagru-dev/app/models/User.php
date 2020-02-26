<?php

class User{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    


    public function register($data)
    {
        $this->db->query('INSERT INTO `users` (`first_name`,`username`,`email`,`password`) VALUES (:first_name, :username, :email, :passwd)');
        $this->db->placeholder(':first_name', $data['first_name']);
        $this->db->placeholder(':username', $data['username']);
        $this->db->placeholder(':email', $data['email']);
        $this->db->placeholder(':passwd', $data['password']);
        $this->db->execute();
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
}