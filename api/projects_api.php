<?php
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

require_once(__DIR__ . "/../database/db.php");


header("Content-Type: application/json");


$action = $_GET['action'] ?? '';




if ($action == "add") {

    $student = $_POST['student'] ?? '';
    $roll = $_POST['roll_no'] ?? '';
    $batch = $_POST['batch_year'] ?? '';
    $title = $_POST['title'] ?? '';
    $guide = $_POST['guide'] ?? '';

    if (empty($student) || empty($roll) || empty($batch) || empty($title) || empty($guide)) {
        echo json_encode([
            "status" => "error",
            "message" => "All fields required"
        ]);
        exit();
    }

$stmt = $conn->prepare("INSERT INTO projects 
(student_name, roll_no, batch_year, project_title, guide_name, status) 
VALUES (?, ?, ?, ?, ?, 'pending')");

    $stmt->bind_param("sssss", $student, $roll, $batch, $title, $guide);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Project added successfully ✅"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Insert failed ❌"
        ]);
    }
}



elseif ($action == "fetch") {

    $result = mysqli_query($conn, "SELECT * FROM projects ORDER BY id DESC");

    $projects = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $projects[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "data" => $projects
    ]);
}



elseif ($action == "delete") {

    $id = $_GET['id'] ?? 0;

    if ($id == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid ID"
        ]);
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Deleted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Delete failed"
        ]);
    }
}




else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid action"
    ]);
}
