<?php
    session_start();
    require_once '../config/db.php';
    $id = $_SESSION['userId'];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $admin = $stmt->fetch();
    if (!$admin) {
        $_SESSION['error'] = 'you are not user';
        header(header: 'Location: ../user/login.php');
        exit();
    }
?>