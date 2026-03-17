<?php
session_start();
include("../database/db.php");

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($q);

if($user){

if(password_verify($password,$user['password'])){

$_SESSION['user'] = $user['id'];
$_SESSION['role'] = $user['role'];

if($user['role'] == "admin"){

header("Location: ../dashboard/admin_dashboard.php");

}else{

header("Location: ../dashboard/user_dashboard.php");

}

}else{

echo "<div style='color:red'>Wrong Password</div>";

}

}else{

echo "<div style='color:red'>User Not Found</div>";

}

}
?>
<!DOCTYPE html>
<html>

<head>

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="text-center">Login</h2>

<form method="POST">

<div class="mb-3">

<label>Email</label>
<input type="email" name="email" class="form-control" required>

</div>

<div class="mb-3">

<label>Password</label>
<input type="password" name="password" class="form-control" required>

</div>

<button class="btn btn-success" name="login">Login</button>

</form>

</div>

</body>
</html>
