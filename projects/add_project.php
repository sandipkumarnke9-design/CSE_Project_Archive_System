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


if($_SESSION['role']!="admin"){
header("Location: ../public/login.php");
}

if(isset($_POST['add'])){

$name=$_POST['student_name'];
$roll=$_POST['roll_no'];
$batch=$_POST['batch_year'];
$title=$_POST['project_title'];

mysqli_query($conn,"INSERT INTO projects
(student_name,roll_no,batch_year,project_title)
VALUES('$name','$roll','$batch','$title')");

echo "<div class='alert alert-success'>Project Added Successfully</div>";

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Add Project</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2>Add New Project</h2>

<form method="POST">

<div class="mb-3">
<label>Student Name</label>
<input type="text" name="student_name" class="form-control" required>
</div>

<div class="mb-3">
<label>Roll Number</label>
<input type="text" name="roll_no" class="form-control" required>
</div>

<div class="mb-3">
<label>Batch Year</label>
<input type="text" name="batch_year" class="form-control" required>
</div>

<div class="mb-3">
<label>Project Title</label>
<input type="text" name="project_title" class="form-control" required>
</div>

<button class="btn btn-success" name="add">
Add Project
</button>

</form>

</div>

</body>
</html>
