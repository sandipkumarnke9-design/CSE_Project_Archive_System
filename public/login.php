<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#3b82f6,#9333ea);
}

.back-btn{
    position:absolute;
    top:20px;
    left:20px;
    background:rgba(7, 120, 7, 0.86);
    padding:10px 12px;
    border-radius:10px;
    color:black;
    text-decoration:none;
    font-size:18px;
    transition:0.3s;
}

.back-btn:hover{
    background:rgba(255,255,255,0.4);
}

.container{
background:rgba(255,255,255,0.15);
backdrop-filter:blur(20px);
padding:45px;
border-radius:20px;
color:white;
width:350px;
text-align:center;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
}


.logo{
    width:85px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

h2{
margin-bottom:15px;
}

input{
width:100%;
padding:12px;
margin:10px 0;
border:none;
border-radius:8px;
outline:none;
}


.pass-box{
position:relative;
}

.pass-box span{
position:absolute;
right:10px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
font-size:13px;
}


button{
width:100%;
padding:12px;
background:#16a34a;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#15803d;
}


a{
color:white;
text-decoration:underline;
}


.error{
color:#ff6b6b;
margin-bottom:10px;
}
</style>
</head>

<body>

<a href="index.php" class="back-btn">
    <i class="fa fa-arrow-left"></i>
</a>
<div class="container">
<img src="../assets/images/logo.png" class="logo">

<h2>Login to Your Account</h2>

<?php
if(isset($_GET['error'])){
echo "<p class='error'>Invalid Email or Password</p>";
}
?>

<form action="../api/login_api.php" method="POST">

<input type="email" name="email" placeholder="Enter Email" required>

<div class="pass-box">
<input type="password" id="pass" name="password" placeholder="Enter Password" required>
<span onclick="togglePass()">👁</span>
</div>

<button type="submit">Login</button>

</form>

<p style="margin-top:10px;">
New user? <a href="register.php">Register</a>
</p>

</div>

<script>
function togglePass(){
let p=document.getElementById("pass");
p.type = (p.type==="password") ? "text" : "password";
}
</script>

</body>
</html>