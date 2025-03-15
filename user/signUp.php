<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['signup'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'user';

    if (empty($f_name) || empty($l_name) || empty($email) || empty($user_name) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = 'Please fill out the form';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Email not valid';
    } else if ($password != $confirm_password) {
        $_SESSION['error'] = 'Password not match';
    } else {
        $sql = "SELECT * FROM users WHERE email = ? OR user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $user_name]);
        $user = $stmt->fetch();
        if ($user) {
            $_SESSION['error'] = 'Email or user name already exist';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (f_name, l_name, email, user_name, password, role) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$f_name, $l_name, $email, $user_name, $passwordHash, $role]);
            if ($stmt) {
                $_SESSION['success'] = 'Sign up success';
            } else {
                $_SESSION['error'] = 'Sign up fail';
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Sign up Reskill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-5">
        <form action="signUp.php" method="post">
            <h1 class="h3 mb-3 fw-normal">Sign up</h1>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger mt-2" role="alert">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success mt-2" role="alert">
                    <?php echo $_SESSION['success']. ' <a href="login.php">click to Login</a>';
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <hr>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">First name</label>
                <input type="text" class="form-control" name="f_name" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Last name</label>
                <input type="text" class="form-control" name="l_name">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">User name</label>
                <input type="text" class="form-control" name="user_name">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm password</label>
                <input type="password" class="form-control" name="confirm_password">
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                <button type="submit" name="signup" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <hr>
        <p>เป็นสมาชิกอยู่เเล้ว <a href="login.php">เข้าสู่ระบบ</a></p>
    </div>

</body>

</html>