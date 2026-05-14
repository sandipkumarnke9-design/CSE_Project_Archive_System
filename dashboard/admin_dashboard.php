<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || strtolower(trim($_SESSION['role'])) !== "admin") {
    header("Location: ../public/login.php");
    exit();
}

$username = $_SESSION['username'] ?? "Admin";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:linear-gradient(135deg,#3b82f6,#9333ea);
            min-height:100vh;
            color:white;
        }

        .menu-toggle{
            display:none;
            position:fixed;
            top:15px;
            left:15px;
            background:#111827;
            color:white;
            border:none;
            padding:10px 14px;
            border-radius:10px;
            font-size:20px;
            cursor:pointer;
            z-index:1100;
        }

        .sidebar{
            width:260px;
            height:100vh;
            background:rgba(0,0,0,0.85);
            padding:25px;
            position:fixed;
            left:0;
            top:0;
            overflow-y:auto;
            box-shadow:4px 0 15px rgba(0,0,0,0.25);
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:30px;
            font-size:26px;
        }

        .sidebar a{
            display:block;
            text-decoration:none;
            color:#ddd;
            padding:12px 15px;
            margin-bottom:10px;
            border-radius:10px;
            transition:0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active{
            background:#2563eb;
            color:white;
        }

        .main{
            margin-left:260px;
            padding:30px;
        }

        .header{
            margin-bottom:30px;
        }

        .header h2{
            font-size:30px;
            font-weight:600;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:25px;
        }

        .card{
            background:rgba(255,255,255,0.15);
            backdrop-filter:blur(12px);
            padding:25px;
            border-radius:18px;
            text-align:center;
            box-shadow:0 12px 25px rgba(0,0,0,0.2);
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-6px);
            box-shadow:0 18px 35px rgba(0,0,0,0.3);
        }

        .card h3{
            font-size:22px;
            margin-bottom:12px;
        }

        .card p{
            font-size:14px;
            color:#f1f5f9;
            margin-bottom:18px;
            line-height:1.5;
        }

        .btn{
            display:inline-block;
            padding:10px 18px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:10px;
            transition:0.3s;
        }

        .btn:hover{
            background:#1d4ed8;
        }

        @media(max-width:992px){
            .cards{
                grid-template-columns:repeat(2,1fr);
            }
        }

        @media(max-width:768px){
            .menu-toggle{
                display:block;
            }

            .sidebar{
                left:-280px;
                transition:0.3s;
                z-index:1000;
            }

            .sidebar.show{
                left:0;
            }

            .main{
                margin-left:0;
                padding:80px 15px 20px;
            }

            .header h2{
                text-align:center;
                font-size:24px;
            }

            .cards{
                grid-template-columns:1fr;
            }
        }

        @media(max-width:480px){
            .header h2{
                font-size:20px;
            }

            .card{
                padding:20px;
            }

            .card h3{
                font-size:18px;
            }

            .card p{
                font-size:13px;
            }
        }
    </style>
</head>
<body>

<button class="menu-toggle" onclick="toggleMenu()">☰</button>

<div class="sidebar" id="sidebar">
    <h2>Admin Panel</h2>

    <a href="admin_dashboard.php" class="active">🏠 Dashboard</a>
    <a href="../projects/add_project.php">➕ Add Project</a>
    <a href="../projects/manage_projects.php">📁 Manage Projects</a>
    <a href="../projects/search.php">🔍 Search Projects</a>
    <a href="../projects/training.php">🎓 Industrial Training</a>
    <a href="../public/logout.php">🚪 Logout</a>
</div>

<div class="main">

    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?> 👑</h2>
    </div>

    <div class="cards">

        <div class="card">
            <h3>➕ Add Project</h3>
            <p>Add new student project details easily.</p>
            <a href="../projects/add_project.php" class="btn">Open</a>
        </div>

        <div class="card">
            <h3>📁 Manage Projects</h3>
            <p>View and manage all student projects.</p>
            <a href="../projects/manage_projects.php" class="btn">Open</a>
        </div>

        <div class="card">
            <h3>🔍 Search Projects</h3>
            <p>Search projects by student, title, or batch.</p>
            <a href="../projects/search.php" class="btn">Open</a>
        </div>

        <div class="card">
            <h3>🎓 Industrial Training</h3>
            <p>Manage student industrial training records.</p>
            <a href="../projects/training.php" class="btn">Open</a>
        </div>

    </div>

</div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("show");
}
</script>

</body>
</html>