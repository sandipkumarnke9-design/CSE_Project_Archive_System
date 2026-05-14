<?php
include(__DIR__ . "/../database/db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($check) > 0){
    header("Location: ../public/register.php?error=1");
    exit();
}


$hashed = password_hash($password, PASSWORD_DEFAULT);


mysqli_query($conn, "INSERT INTO users (name,email,password,role,status)
VALUES('$name','$email','$hashed','user','active')");

header("Location: ../public/login.php");
exit();
?>