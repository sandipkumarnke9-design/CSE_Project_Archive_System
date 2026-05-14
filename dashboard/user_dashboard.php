<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: ../public/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    display:flex;
    background: linear-gradient(135deg,#3b82f6,#9333ea);
    min-height:100vh;
}

.sidebar{
    width:240px;
    background:rgba(0,0,0,0.8);
    color:white;
    padding:25px;
    position:fixed;
    height:100%;
}

.sidebar h2{
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:#ddd;
    text-decoration:none;
    margin:12px 0;
    padding:10px;
    border-radius:6px;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:#2563eb;
    color:white;
}
.main{
    margin-left:240px;
    padding:30px;
    width:100%;
}

.header h1{
    color:white;
    margin-bottom:25px;
}
.cards{
    display:grid;
    grid-template-columns: repeat(2, 1fr);
    gap:20px;
}

.card{
    flex:1;

    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(12px);
    padding:70px;
    border-radius:30px;
    color:white;
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.card h3{
    margin-bottom:10px;
}

.card p{
    font-size:14px;
    margin-bottom:15px;
}
.btn{
    display:inline-block;
    padding:20px 30px;
    border-radius:10px;
    text-decoration:none;
    color:white;
}

.btn-blue{
    background:#2563eb;
}

.btn:hover{
    opacity:0.85;
}
@media(max-width:768px){
    .sidebar{
        width:180px;
    }

    .main{
        margin-left:180px;
    }
}
</style>

</head>

<body>
<div class="sidebar">

<h2>Dashboard</h2>

<a href="user_dashboard.php" class="active">
<i class="fa fa-home"></i> Home
</a>
<a href="../projects/add_project.php">
    <i class="fa fa-code"></i> Add Project
</a>

<a href="../projects/search.php">
<i class="fa fa-search"></i> Search Projects
</a>

<a href="../projects/training.php">
<i class="fa fa-briefcase"></i> Training
</a>

<a href="../public/logout.php">
<i class="fa fa-sign-out-alt"></i> Logout
</a>

</div>
<div class="main">

<div class="header">
<h1>Welcome <?php echo $_SESSION['username']; ?> 👋</h1>
</div>

<div class="cards">

<div class="card">
<h1>Search Projects</h1>
<h3>Find projects using name, roll or batch</h3>
<a href="../projects/search.php" class="btn btn-blue">Search</a>
</div>

<div class="card">
<h1>Industrial Training</h1>
<h3>View training records</h3>
<a href="../projects/training.php" class="btn btn-blue">Open</a>
</div>

</div>

</div>

</body>
</html>