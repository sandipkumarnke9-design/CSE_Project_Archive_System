<?php

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
");

$name=$_POST['name'];
$email=$_POST['email'];

$password=password_hash($_POST['password'],PASSWORD_DEFAULT);

mysqli_query($conn,"INSERT INTO users
(name,email,password,role,status)
VALUES('$name','$email','$password','user','active')");

echo "Registration Successful";

?>
