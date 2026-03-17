<?php
session_start();

if($_SESSION['role']!="admin"){
header("Location: ../public/login.php");
}
?>

<h2>Admin Dashboard</h2>

<a href="../projects/add_project.php">Add Project</a>

<br><br>

<a href="../projects/view_projects.php">Manage Projects</a>

<br><br>

<a href="../public/logout.php">Logout</a>
<a href="../projects/add_project.php" class="btn btn-primary">
Add Project
</a>
