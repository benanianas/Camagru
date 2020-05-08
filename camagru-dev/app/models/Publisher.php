<?php

class Publisher{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function pic($data, $id)
    {
        $this->db->query('UPDATE `users` SET `token` = :pic WHERE `id` = :id');
        $this->db->placeholder(':pic', $data);
        $this->db->placeholder(':id', $id);
        $this->db->execute();
    }

    
}