<?php

session_start();

include("<?php

$host="127.0.0.1";
$user="root";
$password="";
$db="cse_projects";
$port="4306";

$conn=mysqli_connect($host,$user,$password,$db,$port);

if(!$conn){
die("Database connection failed");
}

?>
p");

$email=$_POST['email'];
$password=$_POST['password'];

$q=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

$user=mysqli_fetch_assoc($q);

if(password_verify($password,$user['password'])){

$_SESSION['user']=$user['id'];
$_SESSION['role']=$user['role'];

echo "success";

}else{

echo "Invalid Login";

}

?>
