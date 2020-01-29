<?php

$host = 'db';
$user = 'root';
$password = 'abenani';
$db = 'camagru_db';

$con = new mysqli($host, $user, $password, $db);
if ($con->connect_error){
	echo 'connection failed :) fuuuuck ' . $con->connect_error;
}
else
{
	echo 'Successfully connected to MYSQL';
}
?>
