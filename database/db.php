<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "cse_projects";
$port = "4306";

$conn = mysqli_connect($host, $user, $password, $db, $port);

if(!$conn){
die("Database connection failed");
}

?>
