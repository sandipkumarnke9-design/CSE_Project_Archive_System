<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Academic Project Management System</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#3b82f6,#9333ea);
    overflow:hidden;
}


body::before, body::after{
    content:"";
    position:absolute;
    border-radius:50%;
    filter:blur(100px);
    opacity:0.4;
}
body::before{
    width:300px;
    height:300px;
    background:#60a5fa;
    top:10%;
    left:10%;
}
body::after{
    width:300px;
    height:300px;
    background:#c084fc;
    bottom:10%;
    right:10%;
}


.container{
    position:relative;
    text-align:center;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(20px);
    padding:60px 40px;
    border-radius:25px;
    color:white;
    width:90%;
    max-width:750px;
    box-shadow:0 20px 50px rgba(0,0,0,0.3);
    animation:fadeIn 1s ease-in-out;
}


.logo{
    width:85px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

h1{
    font-size:28px;
    font-weight:700;
    margin-bottom:8px;
    letter-spacing:1px;
}

h2{
    font-size:15px;
    font-weight:300;
    margin-bottom:30px;
    opacity:0.9;
}


.btn{
    padding:13px 30px;
    margin:10px;
    border-radius:10px;
    text-decoration:none;
    color:white;
    display:inline-block;
    transition:0.3s;
    font-size:15px;
    position:relative;
    overflow:hidden;
}


.btn-register{
    background:linear-gradient(45deg,#2563eb,#3b82f6);
}

.btn-login{
    background:linear-gradient(45deg,#16a34a,#22c55e);
}


.btn:hover{
    transform:translateY(-4px) scale(1.05);
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

.btn::after{
    content:"";
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:-100%;
    background:rgba(255,255,255,0.2);
    transition:0.4s;
}
.btn:hover::after{
    left:100%;
}


.footer{
    margin-top:25px;
    font-size:13px;
    opacity:0.8;
}


@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.footer-pro{
    margin-top:40px;
    padding:20px;
    text-align:center;
    border-radius:15px;

    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(12px);

    box-shadow:0 10px 30px rgba(0,0,0,0.25);
    color:white;

    transition:0.3s;
}


.footer-pro:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 40px rgba(0,0,0,0.35);
}

.footer-content{
    line-height:1.8;
}

.footer-content .developer span{
    color:#22c55e;
    font-weight:600;
}

.footer-content .roll{
    font-size:12px;
    opacity:0.8;
}
</style>
</head>

<body>

<div class="container">

    <img src="../assets/images/logo.png" class="logo">

    <h1>BABA GHULAM SHAH BADSHAH UNIVERSITY</h1>
    <h2>Academic Project Management System</h2>

 
    <a href="register.php" class="btn btn-register">Register</a>
    <a href="login.php" class="btn btn-login">Login</a>

   
    <div class="footer">
    © 2026 BGSBU Rajouri J&K India <br>
    Developed with ❤️ by <strong>Sandip Kumar & Ahsan Noorani</strong> <br>
    <span class="roll">Roll No: 48-CSE/L-2023 & 26-CSE-2022</span>
     </div>

</div>

</body>
</html>