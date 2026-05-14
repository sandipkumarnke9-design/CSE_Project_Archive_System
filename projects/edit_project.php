<?php
session_start();
require_once(__DIR__ . "/../database/db.php");

if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || strtolower(trim($_SESSION['role'])) !== "admin") {
    header("Location: ../public/login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Invalid Project ID");
}

$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Project not found");
}

if (isset($_POST['update'])) {

    $student  = trim($_POST['student']);
    $roll     = trim($_POST['roll_no']);
    $department = trim($_POST['department']);
    $batch    = trim($_POST['batch_year']);
    $title    = trim($_POST['title']);
    $abstract = trim($_POST['abstract']);
    $guide    = trim($_POST['guide']);
    $status   = trim($_POST['status']);

    $audio = $data['audio'];
    $video = $data['video'];

    // AUDIO UPLOAD
    if (!empty($_FILES['audio']['name'])) {
        $audioExt = strtolower(pathinfo($_FILES['audio']['name'], PATHINFO_EXTENSION));
        $allowedAudio = ['mp3', 'wav', 'ogg'];

        if (in_array($audioExt, $allowedAudio)) {
            $audio = time() . "_" . basename($_FILES['audio']['name']);
            move_uploaded_file(
                $_FILES['audio']['tmp_name'],
                __DIR__ . "/../uploads/audio/" . $audio
            );
        }
    }

    // VIDEO UPLOAD
    if (!empty($_FILES['video']['name'])) {
        $videoExt = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
        $allowedVideo = ['mp4', 'webm', 'ogg'];

        if (in_array($videoExt, $allowedVideo)) {
            $video = time() . "_" . basename($_FILES['video']['name']);
            move_uploaded_file(
                $_FILES['video']['tmp_name'],
                __DIR__ . "/../uploads/videos/" . $video
            );
        }
    }

    $update = $conn->prepare("
        UPDATE projects SET
            student_name = ?,
            roll_no = ?,
            department = ?,
            batch_year = ?,
            project_title = ?,
            abstract = ?,
            guide_name = ?,
            audio = ?,
            video = ?,
            status = ?
        WHERE id = ?
    ");

    $update->bind_param(
       "ssssssssssi",
        $student,
        $roll,
        $department,
        $batch,
        $title,
        $abstract,
        $guide,
        $audio,
        $video,
        $status,
        $id
    );

    if ($update->execute()) {
        header("Location: manage_projects.php?msg=updated");
        exit();
    } else {
        $error = "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Project</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    padding:20px;
}

.back-btn{
    position:fixed;
    top:20px;
    left:20px;
    background:rgba(0,0,0,0.35);
    color:#fff;
    text-decoration:none;
    padding:12px 18px;
    border-radius:12px;
    z-index:1000;
}

.container{
    width:100%;
    max-width:1200px;
    margin:70px auto;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(18px);
    padding:40px;
    border-radius:24px;
    box-shadow:0 20px 60px rgba(0,0,0,0.25);
    color:white;
}

h2{
    text-align:center;
    margin-bottom:30px;
    font-size:36px;
    font-weight:600;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:22px;
    align-items:start;
}

.form-group{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.form-group.full{
    grid-column:1 / -1;
}

label{
    font-size:15px;
    font-weight:500;
    color:#fff;
}

input, select, textarea{
    width:100%;
    padding:15px 16px;
    border:none;
    border-radius:14px;
    outline:none;
    font-size:15px;
    background:white;
    color:#111;
    transition:0.3s;
}

input:focus,
select:focus,
textarea:focus{
    box-shadow:0 0 0 3px rgba(37,99,235,0.35);
}

select{
    min-height:54px;
    cursor:pointer;
}

textarea{
    min-height:220px;
    resize:vertical;
}

.media-preview{
    margin-top:10px;
}

audio,
video{
    width:100%;
    max-width:100%;
    border-radius:10px;
    background:white;
}

.btn{
    width:100%;
    margin-top:30px;
    padding:16px;
    background:#22c55e;
    border:none;
    border-radius:14px;
    color:white;
    font-size:17px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#16a34a;
    transform:translateY(-2px);
}

.error{
    text-align:center;
    color:#ffd1d1;
    margin-bottom:15px;
    font-weight:500;
}

@media(max-width:768px){

    .container{
        padding:22px;
        margin:60px auto;
    }

    h2{
        font-size:28px;
    }

    .form-grid{
        grid-template-columns:1fr;
        gap:18px;
    }

    .form-group.full{
        grid-column:span 1;
    }

    input,
    select,
    textarea{
        font-size:14px;
        padding:13px;
    }

    textarea{
        min-height:180px;
    }
}

</style>
</head>

<body>

<a href="manage_projects.php" class="back-btn">⬅ Back</a>

<div class="container">

    <h2>Edit Project</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-grid">

    <div class="form-group">
        <label>Student Name</label>
        <input type="text" name="student" value="<?php echo htmlspecialchars($data['student_name']); ?>" required>
    </div>

    <div class="form-group">
        <label>Roll Number</label>
        <input type="text" name="roll_no" value="<?php echo htmlspecialchars($data['roll_no']); ?>" required>
    </div>

    <div class="form-group">
        <label>Department</label>
        <select name="department" required>
            <option value="CSE" <?php if($data['department']=="CSE") echo "selected"; ?>>CSE</option>
            <option value="ECE" <?php if($data['department']=="ECE") echo "selected"; ?>>ECE</option>
            <option value="ME" <?php if($data['department']=="ME") echo "selected"; ?>>ME</option>
            <option value="CE" <?php if($data['department']=="CE") echo "selected"; ?>>CE</option>
            <option value="EE" <?php if($data['department']=="EE") echo "selected"; ?>>EE</option>
            <option value="IT" <?php if($data['department']=="IT") echo "selected"; ?>>IT</option>
        </select>
    </div>

    <div class="form-group">
        <label>Batch Year</label>
        <input type="text" name="batch_year" value="<?php echo htmlspecialchars($data['batch_year']); ?>" required>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" required>
            <option value="pending" <?php if($data['status']=="pending") echo "selected"; ?>>Pending</option>
            <option value="approved" <?php if($data['status']=="approved") echo "selected"; ?>>Approved</option>
            <option value="rejected" <?php if($data['status']=="rejected") echo "selected"; ?>>Rejected</option>
        </select>
    </div>

    <div class="form-group full">
        <label>Project Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($data['project_title']); ?>" required>
    </div>

    <div class="form-group full">
        <label>Abstract</label>
        <textarea name="abstract" required><?php echo htmlspecialchars($data['abstract']); ?></textarea>
    </div>

    <div class="form-group full">
        <label>Guide Name</label>
        <input type="text" name="guide" value="<?php echo htmlspecialchars($data['guide_name']); ?>" required>
    </div>

    <div class="form-group">
        <label>Audio File (mp3/wav/ogg)</label>
        <input type="file" name="audio" accept="audio/*">

        <?php if(!empty($data['audio'])) { ?>
        <div class="media-preview">
            <audio controls>
                <source src="../uploads/audio/<?php echo htmlspecialchars($data['audio']); ?>">
            </audio>
        </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <label>Video File (mp4/webm/ogg)</label>
        <input type="file" name="video" accept="video/mp4,video/webm,video/ogg">

        <?php if(!empty($data['video'])) { ?>
        <div class="media-preview">
            <video controls preload="metadata" playsinline>
                <source src="../uploads/videos/<?php echo htmlspecialchars($data['video']); ?>" type="video/mp4">
            </video>
        </div>
        <?php } ?>
    </div>

</div>

        <button type="submit" name="update" class="btn">Update Project</button>

    </form>

</div>

</body>
</html>