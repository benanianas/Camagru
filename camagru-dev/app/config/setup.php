<?php

// all i do is creating database for the first time 

include 'database.php';

try{
    $db = new PDO($DB_DSN.';dbname='.$DB_NAME, $DB_USER, $DB_PASSWORD);
}catch(Exception $e){

    // creat the database

    $sql = 'CREATE DATABASE '.$DB_NAME.';';
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $stmt = $db->prepare($sql);
    $stmt->execute();


    // create the users table
    $db = new PDO($DB_DSN.';dbname='.$DB_NAME, $DB_USER, $DB_PASSWORD);

    $sql = " CREATE TABLE IF NOT EXISTS `users`
    (`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `first_name` VARCHAR(30) NOT NULL,
     `username` VARCHAR(25)  NOT NULL,
     `email` Varchar(50) NOT NULL,
     `password` Varchar(255) NOT NULL)
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    //just a users tabel test
    $sql = "INSERT INTO `users`
     (`first_name`, `username`, `email`, `password`)
     VALUES
     ('anas benani','benanas','anas@gmail.com', 'passtest_djwjdijwijd'),
     ('mouad bhaya','dobby','bhaya@gmail.com', 'passtest_djwjdijwijd'),
     ('mouad azami','aza_moud','mouadazami@gmail.com', 'passtest_djwjdijwijd'),
     ('nourdine hamid','nhamid','hamidnourdin@gmail.com', 'passtest_djwjdijwijd')
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

}

