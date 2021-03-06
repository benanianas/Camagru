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
     `email` VARCHAR(50) NOT NULL,
     `password` VARCHAR(255) NOT NULL,
     `comments_n` VARCHAR(2) NOT NULL,
     `p_photo` VARCHAR(255) NOT NULL DEFAULT '/img/profile.png',
     `likes_n` VARCHAR(2) NOT NULL,
     `status` VARCHAR(2) NOT NULL,
     `token` VARCHAR(255),
     `time` DATETIME)
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();


    // create posts table

    $sql = " CREATE TABLE IF NOT EXISTS `posts`
    (`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `user_id` int NOT NULL,
     `img` VARCHAR(255) NOT NULL,
     `created_at`TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP())
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    
    //create likes table
   
    $sql = " CREATE TABLE IF NOT EXISTS `likes`
    (`post_id` int NOT NULL,
     `user_id` int NOT NULL)
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();



    //create comments table
    $sql = " CREATE TABLE IF NOT EXISTS `comments`
    (`id_c` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `post_id` int NOT NULL,
     `user_id` int NOT NULL,
     `comment` text NOT NULL,
     `created_at`TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP())
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

}

