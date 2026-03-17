<?php
include("../database/db.php");
?>

<!DOCTYPE html>
<html>

<head>

<title>Search Projects</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="text-center">Search CSE Projects</h2>

<form method="GET">

<input type="text" name="search" class="form-control"
placeholder="Search Student / Roll / Batch">

<br>

<button class="btn btn-primary">Search</button>

</form>

<br>

<table class="table table-bordered">

<tr>
<th>Student</th>
<th>Roll</th>
<th>Batch</th>
<th>Project</th>
</tr>

<?php

if(isset($_GET['search'])){

$s=$_GET['search'];

$q=mysqli_query($conn,"SELECT * FROM projects
WHERE student_name LIKE '%$s%'
OR roll_no LIKE '%$s%'
OR batch_year LIKE '%$s%'");

while($row=mysqli_fetch_assoc($q)){

echo "<tr>

<td>".$row['student_name']."</td>
<td>".$row['roll_no']."</td>
<td>".$row['batch_year']."</td>
<td>".$row['project_title']."</td>

</tr>";

}

}

?>

</table>

</div>

</body>
</html>
