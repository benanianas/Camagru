<?php 
/*
$host = 'db';
$user = 'user';
$passwd = 'passme';
$db = 'test_db';


$dsn = 'mysql:host=' . $host .';port=3306'.';dbname=' . $db;

$pdo = new PDO($dsn, $user, $passwd);

$status = 'user';

$sql = 'SELECT * FROM users';
$stm = $pdo->prepare($sql);
$stm->execute();
$users = $stm->fetchAll();

foreach($users as $id)
{
    echo $id['id']."<br>";
}*/

$host = 'db';
$user = 'user';
$db = 'test_db';
$passwd = 'passme';
$port = '3306';

$dsn = 'mysql:host='.$host.';port='.$port.';dbname='.$db;

$pdo = new PDO($dsn, $user, $passwd);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$tbl = 'users';

$stat = 'user';

$query = 'SELECT * FROM users';

$stm = $pdo->prepare($query);
$stm->execute(['stat' => $stat]);
$users = $stm->fetchAll();

foreach($users as $id)
{
    echo $id->id.'   '.$id->name.'   '.$id->status.'    '.$id->email.'<br>';
}
/*

$name = 'malongo';
$status = 'attacker';
$email = 'malongo@raja.com';


$query = 'INSERT INTO users (name,status,email) VALUES (:qname,:qstatus,:qemail)';
$stm = $pdo->prepare($query);

$stm->execute(['qname'=>$name, 'qstatus'=>$status, 'qemail'=> $email]);*/