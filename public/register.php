<?php
include("../database/db.php");

if(isset($_POST['register'])){

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($conn,"INSERT INTO users
(name,email,password,role,status)
VALUES('$name','$email','$password','user','active')");

echo "<div style='color:green'>Registration Successful</div>";

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="text-center">User Registration</h2>

<form method="POST">

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-primary" name="register">
Register
</button>

</form>

<br>

<a href="login.php">Already have account? Login</a>

</div>

</body>
</html>
