<?php require_once("../middleware/auth.php"); ?>
<?php


if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit();
}

require_once(__DIR__ . "/../database/db.php");

$message = "";

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn,$_POST['student_name']);
    $roll = mysqli_real_escape_string($conn,$_POST['roll_no']);
    $department = mysqli_real_escape_string($conn,$_POST['department']);
    $batch = mysqli_real_escape_string($conn,$_POST['batch_year']);
    $title = mysqli_real_escape_string($conn,$_POST['project_title']);
    $abstract = mysqli_real_escape_string($conn,$_POST['abstract']);
    $guide = mysqli_real_escape_string($conn,$_POST['guide_name']);

    $audio = "";
    $video = "";

   
    if(!empty($_FILES['audio']['name'])){
        $ext = strtolower(pathinfo($_FILES['audio']['name'], PATHINFO_EXTENSION));

        if($ext == "mp3"){
            $folder = "../uploads/audio/";
            if(!is_dir($folder)) mkdir($folder,0777,true);

            $audio = time()."_".preg_replace("/[^a-zA-Z0-9.]/","_",$_FILES['audio']['name']);
            move_uploaded_file($_FILES['audio']['tmp_name'],$folder.$audio);
        } else {
            $message = "❌ Only MP3 allowed!";
        }
    }

   
    if(!empty($_FILES['video']['name'])){
        $ext = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));

        if($ext == "mp4"){
            $folder = "../uploads/videos/";
            if(!is_dir($folder)) mkdir($folder,0777,true);

            $video = time()."_".preg_replace("/[^a-zA-Z0-9.]/","_",$_FILES['video']['name']);
            move_uploaded_file($_FILES['video']['tmp_name'],$folder.$video);
        } else {
            $message = "❌ Only MP4 allowed!";
        }
    }

    if($message == ""){
       $query = "INSERT INTO projects
        (student_name, roll_no, department, batch_year, project_title, abstract, guide_name, audio, video, status)
        VALUES
        ('$name','$roll','$department','$batch','$title','$abstract','$guide','$audio','$video','pending')";
        if(mysqli_query($conn,$query)){
            $message = "✅ Project submitted successfully!";
        } else {
            $message = "❌ Database error!";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Add Project</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Poppins;}

body{
    background: linear-gradient(135deg,#3b82f6,#9333ea);
    color:white;
}


.top-bar{
    padding:15px;
}


.back-btn{
    background:rgba(255,255,255,0.2);
    padding:8px 12px;
    border-radius:8px;
    color:white;
    text-decoration:none;
}


.form-container{
    max-width:420px;
    margin:30px auto;
    background:rgba(255,255,255,0.1);
    padding:25px;
    border-radius:12px;
    text-align:center;
}


input,textarea{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:none;
    border-radius:6px;
}


input[type="file"]{
    background:white;
    color:black;
}


button{
    width:100%;
    padding:10px;
    background:#22c55e;
    color:white;
    border:none;
    border-radius:6px;
}


.msg{
    margin-bottom:10px;
    font-size:14px;
}


@media (max-width:768px){
.form-container{width:90%;}
}
</style>

</head>

<body>

<div class="top-bar">
<?php if(strtolower($_SESSION['role']) == "admin"){ ?>
<a href="../dashboard/admin_dashboard.php" class="back-btn">⬅ Back</a>
<?php } else { ?>
<a href="../dashboard/user_dashboard.php" class="back-btn">⬅ Back</a>
<?php } ?>
</div>

<div class="form-container">

<h2>Add Project</h2>

<?php if($message != ""){ ?>
<div class="msg"><?php echo $message; ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

<input name="student_name" placeholder="Student Name" required>
<input name="roll_no" placeholder="Roll No" required>
<select name="department" required>
    <option value="">Select Department</option>
    <option value="CSE">CSE</option>
    <option value="ECE">ECE</option>
    <option value="ME">ME</option>
    <option value="CE">CE</option>
    <option value="EE">EE</option>
    <option value="IT">IT</option>
</select>
<input name="batch_year" placeholder="Batch Year" required>
<input name="project_title" placeholder="Project Title" required>

<textarea name="abstract" placeholder="Abstract"></textarea>

<input name="guide_name" placeholder="Guide Name" required>

<label>Audio (MP3)</label>
<input type="file" name="audio" accept=".mp3">

<label>Video (MP4)</label>
<input type="file" name="video" accept=".mp4">

<button name="submit">Submit</button>

</form>

</div>

</body>
</html>