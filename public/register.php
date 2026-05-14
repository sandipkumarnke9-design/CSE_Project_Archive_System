<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins';}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#3b82f6,#9333ea);
}

.container{
background:rgba(255,255,255,0.15);
backdrop-filter:blur(25px);
padding:40px;
border-radius:20px;
color:white;
width:400px;
text-align:center;
}

.logo{
    width:85px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

input{
width:100%;
padding:12px;
margin:10px 0;
border:none;
border-radius:8px;
}

button{
width:100%;
padding:12px;
background:#2563eb;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

button:hover{
background:#1d4ed8;
}

.msg{margin:10px 0;}
.success{color:lightgreen;}
.error{color:red;}

a{color:white;}
</style>
</head>

<body>

<div class="container">

<img src="../assets/images/logo.png" class="logo">

<h2>Create Account</h2>


<?php
if(isset($_GET['success'])){
echo "<p class='msg success'>Registration Successful</p>";
}
if(isset($_GET['error'])){
echo "<p class='msg error'>Email already exists</p>";
}
?>

<form action="../api/register_api.php" method="POST">

<input type="text" name="name" placeholder="Enter Name" required>
<input type="email" name="email" placeholder="Enter Email" required>
<input type="password" name="password" placeholder="Enter Password" required>

<button type="submit">Register</button>

</form>

<p>Already have account? <a href="login.php">Login</a></p>

</div>

</body>
</html>