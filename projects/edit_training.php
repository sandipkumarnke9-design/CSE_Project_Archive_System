<?php
session_start();
require_once("../middleware/auth.php");
require_once(__DIR__ . "/../database/db.php");

requireRole('admin');

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    die("Invalid Training ID");
}

$stmt = $conn->prepare("SELECT * FROM industrial_training WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$training = $result->fetch_assoc();

if (!$training) {
    die("Training record not found");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $roll = trim($_POST['roll_no']);
    $name = trim($_POST['student_name']);
    $course = trim($_POST['course']);
    $department = trim($_POST['department']);
    $semester = trim($_POST['semester']);
    $tenure = trim($_POST['tenure']);
    $type = trim($_POST['training_type']);
    $company = trim($_POST['company_name']);
    $dates = trim($_POST['training_dates']);
    $domain = trim($_POST['domain']);
    $learning = trim($_POST['learning']);

    $certificate = $training['certificate'] ?? '';

    if (!empty($_FILES['certificate']['name']) && $_FILES['certificate']['error'] == 0) {

        $ext = strtolower(pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed)) {

            $uploadDir = __DIR__ . "/../uploads/certificates/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "", $_FILES['certificate']['name']);

            if (move_uploaded_file($_FILES['certificate']['tmp_name'], $uploadDir . $newFileName)) {
                $certificate = $newFileName;
            }
        }
    }

    $update = $conn->prepare("
        UPDATE industrial_training SET
            roll_no = ?,
            student_name = ?,
            course = ?,
            department = ?,
            semester = ?,
            tenure = ?,
            training_type = ?,
            company_name = ?,
            training_dates = ?,
            domain = ?,
            learning = ?,
            certificate = ?
        WHERE id = ?
    ");

    $update->bind_param(
        "ssssssssssssi",
        $roll,
        $name,
        $course,
        $department,
        $semester,
        $tenure,
        $type,
        $company,
        $dates,
        $domain,
        $learning,
        $certificate,
        $id
    );

    if ($update->execute()) {
        header("Location: training.php?success=updated");
        exit();
    } else {
        $error = "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Industrial Training</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins,sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#3b82f6,#9333ea);
    padding:20px;
}

.back-btn{
    position:fixed;
    top:20px;
    left:20px;
    background:rgba(0,0,0,0.45);
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:12px;
    z-index:1000;
    transition:0.3s;
}

.back-btn:hover{
    background:rgba(0,0,0,0.65);
}

.container{
    width:100%;
    max-width:950px;
    margin:80px auto 20px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(15px);
    padding:30px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.3);
    color:white;
}

h2{
    text-align:center;
    margin-bottom:25px;
    font-size:30px;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group.full{
    grid-column:span 2;
}

label{
    margin-bottom:8px;
    font-size:14px;
    font-weight:500;
}

input, textarea, select{
    font-size:14px;
    padding:11px;
}

textarea{
    min-height:130px;
    resize:vertical;
}

.file-input{
    width:100%;
    padding:10px;
    border:none;
    border-radius:10px;
    background:white;
    color:#333;
}

.file-input::file-selector-button{
    background:#2563eb;
    color:white;
    border:none;
    padding:10px 16px;
    border-radius:8px;
    cursor:pointer;
    margin-right:10px;
}

.preview{
    margin-top:12px;
}

.preview a{
    display:inline-block;
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:10px 16px;
    border-radius:8px;
}

.btn{
    width:100%;
    margin-top:20px;
    padding:14px;
    background:#22c55e;
    border:none;
    border-radius:12px;
    color:white;
    font-size:16px;
    cursor:pointer;
}

.btn:hover{
    background:#16a34a;
}

.error{
    text-align:center;
    color:#ffd1d1;
    margin-bottom:15px;
}

@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }

    .form-group.full{
        grid-column:span 1;
    }

    .container{
        padding:20px;
        margin-top:70px;
    }

    h2{
        font-size:24px;
    }

    .back-btn{
        top:12px;
        left:12px;
        padding:10px 14px;
        font-size:14px;
    }
}

@media(max-width:480px){
    h2{
        font-size:20px;
    }

    input, textarea{
        font-size:14px;
        padding:11px;
    }

    .btn{
        padding:12px;
    }
}
</style>
</head>

<body>

<a href="training.php" class="back-btn">⬅ Back</a>

<div class="container">

<h2>Edit Industrial Training</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="POST" enctype="multipart/form-data">

<div class="form-grid">

<div class="form-group">
<label>Roll No</label>
<input type="text" name="roll_no" value="<?php echo htmlspecialchars($training['roll_no']); ?>" required>
</div>

<div class="form-group">
<label>Student Name</label>
<input type="text" name="student_name" value="<?php echo htmlspecialchars($training['student_name']); ?>" required>
</div>

<div class="form-group">
<label>Course</label>
<input type="text" name="course" value="<?php echo htmlspecialchars($training['course']); ?>" required>
</div>
<div class="form-group">
    <label>Department</label>
    <select name="department" required>
        <option value="CSE" <?php if(($training['department'] ?? '') == 'CSE') echo 'selected'; ?>>CSE</option>
        <option value="ECE" <?php if(($training['department'] ?? '') == 'ECE') echo 'selected'; ?>>ECE</option>
        <option value="ME" <?php if(($training['department'] ?? '') == 'ME') echo 'selected'; ?>>ME</option>
        <option value="CE" <?php if(($training['department'] ?? '') == 'CE') echo 'selected'; ?>>CE</option>
        <option value="IT" <?php if(($training['department'] ?? '') == 'IT') echo 'selected'; ?>>IT</option>
        <option value="EE" <?php if(($training['department'] ?? '') == 'EE') echo 'selected'; ?>>EE</option>
    </select>
</div>


<div class="form-group">
<label>Semester</label>
<input type="text" name="semester" value="<?php echo htmlspecialchars($training['semester']); ?>" required>
</div>

<div class="form-group">
<label>Tenure</label>
<input type="text" name="tenure" value="<?php echo htmlspecialchars($training['tenure']); ?>" required>
</div>

<div class="form-group">
<label>Training Type</label>
<input type="text" name="training_type" value="<?php echo htmlspecialchars($training['training_type']); ?>" required>
</div>

<div class="form-group">
<label>Company Name</label>
<input type="text" name="company_name" value="<?php echo htmlspecialchars($training['company_name']); ?>" required>
</div>

<div class="form-group">
<label>Training Dates</label>
<input type="text" name="training_dates" value="<?php echo htmlspecialchars($training['training_dates']); ?>" required>
</div>

<div class="form-group full">
<label>Domain</label>
<input type="text" name="domain" value="<?php echo htmlspecialchars($training['domain']); ?>" required>
</div>

<div class="form-group full">
<label>What You Learned</label>
<textarea name="learning" required><?php echo htmlspecialchars($training['learning']); ?></textarea>
</div>

</div>

<div class="form-group">
<label>Certificate Upload (PDF/JPG/PNG)</label>
<input type="file" name="certificate" class="file-input" accept=".pdf,.jpg,.jpeg,.png">

<?php
if (
    !empty($training['certificate']) &&
    file_exists(__DIR__ . "/../uploads/certificates/" . $training['certificate'])
) {
?>
<div class="preview">
    <a href="/CSE_Project_Archive_System/uploads/certificates/<?php echo urlencode($training['certificate']); ?>" target="_blank">
        View Current Certificate
    </a>
</div>
<?php } ?>
</div>

<button type="submit" class="btn">Update Training</button>

</form>

</div>

</body>
</html>