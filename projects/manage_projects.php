<?php
session_start();
require_once("../middleware/auth.php");
require_once(__DIR__ . "/../database/db.php");

if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || strtolower(trim($_SESSION['role'])) !== "admin") {
    header("Location: ../public/login.php");
    exit();
}

if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE projects SET status='approved' WHERE id=$id");
}

if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    mysqli_query($conn, "UPDATE projects SET status='rejected' WHERE id=$id");
}

$search = $_GET['search'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #3b82f6, #9333ea);
            min-height: 100vh;
            color: white;
        }

        .container {
            max-width: 1300px;
            margin: auto;
            padding: 20px;
        }

        .back-btn {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 14px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-box input {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 10px;
            outline: none;
        }

        .search-box button {
            padding: 12px 18px;
            background: #2563eb;
            border: none;
            color: white;
            border-radius: 10px;
            cursor: pointer;
        }

        .table-wrapper {
            overflow-x: auto;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th {
            background: rgba(0, 0, 0, 0.4);
            padding: 14px;
            text-align: center;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
            vertical-align: middle;
        }

        .roll-col {
            min-width: 130px;
            white-space: nowrap;
        }

        .action {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            white-space: nowrap;
        }

        .btn {
            padding: 8px 10px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            min-height: 38px;
        }

        .media {
            width: 120px;
            max-width: 100%;
        }

        audio.media {
            height: 35px;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .badge {
            background: #22c55e;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .media {
            width: 120px;
        }

        audio.media {
            height: 35px;
        }

        .pending {
            color: yellow;
        }

        .approved {
            color: #4ade80;
        }

        .rejected {
            color: #f87171;
        }

        .action {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            white-space: nowrap;
        }

        .btn {
            padding: 8px 10px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
        }

        .approve {
            background: #22c55e;
        }

        .reject {
            background: #facc15;
            color: black;
        }

        .edit {
            background: #3b82f6;
        }

        .delete {
            background: #ef4444;
        }

        .view-btn {
            padding: 6px 10px;
            background: #22c55e;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
        }

        .modal-content {
            background: white;
            color: black;
            width: 90%;
            max-width: 600px;
            margin: 8% auto;
            padding: 20px;
            border-radius: 12px;
            max-height: 75vh;
            overflow-y: auto;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            cursor: pointer;
        }

        @media(max-width:1024px) {
            .container {
                padding: 15px;
            }

            table {
                min-width: 1100px;
            }

            th,
            td {
                font-size: 14px;
                padding: 10px;
            }

            .btn {
                min-width: 34px;
                min-height: 34px;
                padding: 6px 8px;
            }
        }

        @media(max-width:768px) {
            .search-box {
                flex-direction: column;
            }

            .search-box input,
            .search-box button {
                width: 100%;
            }

            .container {
                padding: 10px;
            }

            h2 {
                font-size: 24px;
            }

            .back-btn {
                padding: 8px 12px;
                font-size: 14px;
            }

            th,
            td {
                font-size: 13px;
                padding: 8px;
            }

            .btn {
                min-width: 32px;
                min-height: 32px;
                padding: 5px 7px;
            }

            .media {
                width: 90px;
            }
        }

        @media(max-width:480px) {
            h2 {
                font-size: 20px;
            }

            th,
            td {
                font-size: 12px;
                padding: 6px;
            }

            .btn {
                min-width: 28px;
                min-height: 28px;
                padding: 4px 6px;
            }

            .media {
                width: 75px;
            }

            .roll-col {
                min-width: 100px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <a href="../dashboard/admin_dashboard.php" class="back-btn">
            <i class="fa fa-arrow-left"></i> Back
        </a>

        <h2>📊 Manage Projects</h2>

        <form method="GET" class="search-box">
            <input type="text" name="search" placeholder="Search Projects..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Student</th>
                    <th>Roll</th>
                    <th>Department</th>
                    <th>Batch</th>
                    <th>Project</th>
                    <th>Abstract</th>
                    <th>Guide</th>
                    <th>Audio</th>
                    <th>Video</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php
                $query = "SELECT * FROM projects WHERE 1=1";
               
                if ($search != "") {
                  $query .= " AND (
                  student_name LIKE '%$search%' OR
                  roll_no LIKE '%$search%' OR
                  department LIKE '%$search%' OR
                  batch_year LIKE '%$search%' OR
                  project_title LIKE '%$search%' OR
                  guide_name LIKE '%$search%'
    )";
}

                $query .= " ORDER BY 
    CAST(batch_year AS UNSIGNED) ASC,
    CAST(SUBSTRING_INDEX(roll_no, '-', 1) AS UNSIGNED) ASC";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td class="roll-col"><?php echo htmlspecialchars($row['roll_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><span class="badge"><?php echo htmlspecialchars($row['batch_year']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['project_title']); ?></td>

                            <td>
                                <?php if (!empty($row['abstract'])) { ?>
                                    <?php echo htmlspecialchars(substr($row['abstract'], 0, 30)); ?>...
                                    <br><br>
                                    <button class="view-btn" data-abstract="<?php echo htmlspecialchars($row['abstract']); ?>" onclick="showModal(this)">
                                        View
                                    </button>
                                <?php } else {
                                    echo "N/A";
                                } ?>
                            </td>

                            <td><?php echo htmlspecialchars($row['guide_name']); ?></td>

                            <td>
                                <?php if (!empty($row['audio'])) { ?>
                                    <audio controls class="media">
                                        <source src="../uploads/audio/<?php echo $row['audio']; ?>" type="audio/mpeg">
                                    </audio>
                                <?php } else {
                                    echo "—";
                                } ?>
                            </td>

                            <td>
                                <?php
                                $videoPath = __DIR__ . "/../uploads/videos/" . $row['video'];

                                if (!empty($row['video']) && file_exists($videoPath)) {
                                ?>
                                    <video controls width="140" preload="metadata">
                                        <source src="../uploads/videos/<?php echo htmlspecialchars($row['video']); ?>" type="video/mp4">
                                        Your browser does not support video.
                                    </video>
                                <?php
                                } else {
                                    echo "—";
                                }
                                ?>
                            </td>

                            <td class="<?php echo $row['status']; ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </td>

                            <td class="action">
                                <a href="?approve=<?php echo $row['id']; ?>" class="btn approve"><i class="fa fa-check"></i></a>
                                <a href="?reject=<?php echo $row['id']; ?>" class="btn reject"><i class="fa fa-times"></i></a>
                                <a href="edit_project.php?id=<?php echo $row['id']; ?>" class="btn edit"><i class="fa fa-pen"></i></a>
                                <a href="delete_project.php?id=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Delete project?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='10'>No Data Found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <div id="abstractModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Project Abstract</h3>
            <p id="abstractText"></p>
        </div>
    </div>

    <script>
        function showModal(btn) {
            document.getElementById("abstractText").textContent = btn.getAttribute("data-abstract");
            document.getElementById("abstractModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("abstractModal").style.display = "none";
        }

        window.onclick = function(e) {
            if (e.target === document.getElementById("abstractModal")) {
                closeModal();
            }
        }
    </script>

</body>

</html>