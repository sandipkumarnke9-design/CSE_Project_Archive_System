<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit();
}

function requireRole($role){
    if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) != strtolower($role)) {
        header("Location: ../public/login.php");
        exit();
    }
}
?>