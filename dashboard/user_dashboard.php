<?php
session_start();

if(!isset($_SESSION['user'])){
header("Location: ../public/login.php");
}
?>

<!DOCTYPE html>
<html>

<head>

<title>User Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.card{
margin-top:30px;
}

</style>

</head>

<body>

<div class="container mt-5">

<h2 class="text-center">User Dashboard</h2>

<div class="row">

<div class="col-md-6">

<div class="card shadow">

<div class="card-body text-center">

<h4>Search Projects</h4>

<p>Find project using name or roll number</p>

<a href="../projects/view_projects.php" class="btn btn-primary">
Search Projects
</a>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card shadow">

<div class="card-body text-center">

<h4>Logout</h4>

<p>Exit your account safely</p>

<a href="../public/logout.php" class="btn btn-danger">
Logout
</a>
<a href="../projects/view_projects.php" class="btn btn-primary">
Search Projects
</a>


</div>

</div>

</div>

</div>

</div>

</body>
</html>
