<?php
session_start();
require_once("../middleware/auth.php");
require_once(__DIR__ . "/../database/db.php");

if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || strtolower(trim($_SESSION['role'])) !== "admin") {
    header("Location: ../public/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM projects WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_projects.php?msg=deleted");
        exit();
    } else {
        echo "Delete failed!";
    }
} else {
    header("Location: manage_projects.php");
    exit();
}
?>