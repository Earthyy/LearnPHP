<?php
    session_start();
    require_once '../config/db.php';
    $id = $_SESSION['adminId'];
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $admin = $stmt->fetch();
    if (!$admin) {
        $_SESSION['error'] = 'you are not admin';
        header(header: 'Location: ../user/login.php');
        exit();
    }
?>