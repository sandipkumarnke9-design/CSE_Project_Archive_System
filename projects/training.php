<?php
    session_start();
    // Check if session exists, don't redirect if already on login page
    if (!isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
        header("Location: ../public/login.php");
        exit();
    }

    require_once("../middleware/auth.php"); ?>

<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit();
}

require_once(__DIR__ . "/../database/db.php");

$search = $_GET['search'] ?? "";


if (isset($_POST['add'])) {

    $roll = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $sem = mysqli_real_escape_string($conn, $_POST['semester']);
    $tenure = mysqli_real_escape_string($conn, $_POST['tenure']);
    $type = mysqli_real_escape_string($conn, $_POST['training_type']);
    $company = mysqli_real_escape_string($conn, $_POST['company_name']);
    $dates = mysqli_real_escape_string($conn, $_POST['training_dates']);
    $domain = mysqli_real_escape_string($conn, $_POST['domain']);
    $learning = mysqli_real_escape_string($conn, $_POST['learning']);

    $certificate = "";

    if (!empty($_FILES['certificate']['name']) && $_FILES['certificate']['error'] == 0) {

        $folder = __DIR__ . "/../uploads/certificates/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $cleanName = preg_replace("/[^a-zA-Z0-9._-]/", "", $_FILES['certificate']['name']);
        $file = time() . "_" . $cleanName;

        if (move_uploaded_file($_FILES['certificate']['tmp_name'], $folder . $file)) {
            $certificate = $file;
        } else {
            die("Upload failed.");
        }
    }

    mysqli_query($conn, "INSERT INTO industrial_training 
    (roll_no,department,student_name,course,semester,tenure,training_type,company_name,training_dates,domain,learning,certificate,status)
    VALUES
    ('$roll','$department','$name','$course','$sem','$tenure','$type','$company','$dates','$domain','$learning','$certificate','pending')");
}


if (strtolower($_SESSION['role']) == "admin") {

    if (isset($_GET['approve'])) {
        mysqli_query($conn, "UPDATE industrial_training SET status='approved' WHERE id=" . intval($_GET['approve']));
    }

    if (isset($_GET['reject'])) {
        mysqli_query($conn, "UPDATE industrial_training SET status='rejected' WHERE id=" . intval($_GET['reject']));
    }

    if (isset($_GET['delete'])) {
        mysqli_query($conn, "DELETE FROM industrial_training WHERE id=" . intval($_GET['delete']));
    }
}


$query = "SELECT * FROM industrial_training WHERE 1=1";

if ($search != "") {
    $query .= " AND (
        roll_no LIKE '%$search%' OR
        student_name LIKE '%$search%' OR
        company_name LIKE '%$search%'
    )";
}

$query .= " ORDER BY 
    CAST(SUBSTRING_INDEX(roll_no, '-', -1) AS UNSIGNED) ASC,
    CAST(SUBSTRING_INDEX(roll_no, '-', 1) AS UNSIGNED) ASC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Industrial Training</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins;
        }

        body {
            background: linear-gradient(135deg, #3b82f6, #9333ea);
            color: white;
            padding: 20px;
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.45);
            padding: 12px 18px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            z-index: 1000;
            font-size: 15px;
            font-weight: 500;
            transition: 0.3s;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .back-btn:hover {
            background: rgba(0, 0, 0, 0.65);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .back-btn {
                top: 12px;
                left: 12px;
                padding: 10px 14px;
                font-size: 14px;
                border-radius: 10px;
            }

            body {
                padding-top: 60px;
            }
        }

        @media (max-width: 480px) {
            .back-btn {
                top: 10px;
                left: 10px;
                padding: 8px 12px;
                font-size: 13px;
            }
        }

        .container {
            background: rgba(0, 87, 217, 0.85);
            padding: 20px;
            border-radius: 15px;
        }


        .search-box {
            display: flex;
            gap: 10px;
            margin: 15px 0;
        }

        .search-box input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 6px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 10px;
        }

        input,
        textarea {
            padding: 10px;
            border: none;
            border-radius: 6px;
        }

        textarea {
            grid-column: span 2;
        }

        button {
            background: #22c55e;
            padding: 10px;
            border: none;
            border-radius: 6px;
            color: white;
        }


        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1400px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
            table-layout: fixed;
        }

        th,
        td {
            padding: 12px 10px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        td:nth-child(1) {
            white-space: nowrap;
        }

        .learning {
            max-width: 220px;
            text-align: left;
            line-height: 1.4;
        }

        .learning-text {
            display: block;
            margin-bottom: 8px;
            color: #fff;
        }

        .view-btn {
            display: inline-block;
            background: #22c55e;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-size: 13px;
        }


        .pending {
            color: yellow;
        }

        .approved {
            color: #4ade80;
        }

        .rejected {
            color: red;
        }


        .action-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: nowrap;
            min-width: 180px;
        }

        .action-btns .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            font-size: 16px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .btn {
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .edit {
            background: #3b82f6;
        }

        .approve {
            background: #22c55e;
        }

        .reject {
            background: #facc15;
            color: black;
        }

        .delete {
            background: #ef4444;
        }

        .download {
            background: #06b6d4;
        }


        .view-btn {
            background: #22c55e;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .popup-content {
            background: white;
            color: black;
            padding: 20px;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            max-height: 70vh;
            overflow: auto;
        }

        .close {
            float: right;
            font-size: 22px;
            cursor: pointer;
        }

        .file-cell {
            min-width: 120px;
        }

        .file-btn {
            display: inline-block;
            background: #06b6d4;
            color: white;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            white-space: nowrap;
        }

        .file-btn:hover {
            background: #0891b2;
        }

        @media(max-width:768px) {
            .action-btns {
                gap: 6px;
                min-width: 160px;
            }

            .action-btns .btn {
                width: 34px;
                height: 34px;
                font-size: 14px;
            }
        }
    </style>

</head>

<body>

    <?php
    $backLink = "../dashboard/admin_dashboard.php";

    if (isset($_SESSION['role']) && strtolower($_SESSION['role']) !== "admin") {
        $backLink = "../dashboard/user_dashboard.php";
    }
    ?>

    <a href="<?php echo $backLink; ?>" class="back-btn">⬅ Back</a>
    <div class="container">

        <h2 style="text-align:center;">Industrial Training</h2>


        <form method="GET" class="search-box">
            <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            <button>Search</button>
        </form>


        <form method="POST" enctype="multipart/form-data" class="form-grid">

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

            <input name="student_name" placeholder="Name" required>
            <input name="course" placeholder="Course" required>
            <input name="semester" placeholder="Semester" required>
            <input name="tenure" placeholder="Tenure" required>
            <input name="training_type" placeholder="Training Type" required>
            <input name="company_name" placeholder="Company" required>
            <input name="training_dates" placeholder="Dates" required>
            <input name="domain" placeholder="Domain" required>

            <textarea name="learning" placeholder="What you learned..." required></textarea>

            <input type="file" name="certificate">

            <button name="add">Add Training</button>

        </form>

        <br>


        <div class="table-wrap">
            <table>

                <tr>
                    <th>Roll</th>
                    <th>Department</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Sem</th>
                    <th>Company</th>
                    <th>Tenure</th>
                    <th>Type</th>
                    <th>Dates</th>
                    <th>Domain</th>
                    <th>Learning</th>
                    <th>File</th>
                    <th>Status</th>
                    <?php if (strtolower($_SESSION['role']) == "admin") { ?>
                        <th>Action</th>
                    <?php } ?>
                </tr>

                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>

                        <tr>

                            <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['course']); ?></td>
                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['tenure']); ?></td>
                            <td><?php echo htmlspecialchars($row['training_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['training_dates']); ?></td>
                            <td><?php echo htmlspecialchars($row['domain']); ?></td>

                            <td class="learning">
                                <span class="learning-text">
                                    <?php echo htmlspecialchars(mb_substr($row['learning'], 0, 40)); ?>...
                                </span>

                                <button type="button" class="view-btn"
                                    onclick='showModal(<?php echo json_encode($row["learning"]); ?>)'>
                                    View
                                </button>
                            </td>

                            <td class="file-cell">
                                <?php
                                if (!empty($row['certificate'])) {
                                    $filePath = __DIR__ . "/../uploads/certificates/" . $row['certificate'];

                                    if (file_exists($filePath)) {
                                ?>
                                        <a href="../uploads/certificates/<?php echo urlencode($row['certificate']); ?>" target="_blank" class="file-btn">
                                            Certificate
                                        </a>
                                <?php
                                    } else {
                                        echo "File Missing";
                                    }
                                } else {
                                    echo "No File";
                                }
                                ?>
                            </td>

                            <td class="<?php echo $row['status']; ?>">
                                <?php echo $row['status']; ?>
                            </td>

                            <?php if (strtolower($_SESSION['role']) == "admin") { ?>
                                <td class="action-btns">

                                    <a href="edit_training.php?id=<?php echo $row['id']; ?>" class="btn edit">✏</a>

                                    <a href="?approve=<?php echo $row['id']; ?>" class="btn approve">✔</a>

                                    <a href="?reject=<?php echo $row['id']; ?>" class="btn reject">✖</a>

                                    <a href="?delete=<?php echo $row['id']; ?>" class="btn delete">🗑</a>

                                </td>
                            <?php } ?>

                        </tr>

                <?php }
                } else {
                    echo "<tr><td colspan='13'>❌ No Data Found</td></tr>";
                }
                ?>

            </table>
        </div>

    </div>

    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Learning Details</h3>
            <p id="popupText"></p>
        </div>
    </div>

    <script>
        function showModal(text) {
            console.log("Clicked:", text); // debug
            document.getElementById("popup").style.display = "flex";
            document.getElementById("popupText").innerText = text;
        }

        function closeModal() {
            document.getElementById("popup").style.display = "none";
        }
    </script>

</body>

</html>