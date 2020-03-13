<?php

class Settings{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
}