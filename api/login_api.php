<?php
session_start();
require_once(__DIR__ . "/../database/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        header("Location: ../public/login.php?error=empty");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {

        $loginSuccess = false;

      
        if (password_verify($password, $user['password'])) {
            $loginSuccess = true;
        }

    
        if ($password === $user['password']) {
            $loginSuccess = true;
        }

        if ($loginSuccess) {
            $_SESSION['user'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['role'] = strtolower(trim($user['role']));

            if ($_SESSION['role'] === "admin") {
                header("Location: ../dashboard/admin_dashboard.php");
            } else {
                header("Location: ../dashboard/user_dashboard.php");
            }
            exit();
        }
    }

    header("Location: ../public/login.php?error=invalid");
    exit();

} else {
    header("Location: ../public/login.php");
    exit();
}
?>