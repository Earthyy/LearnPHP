    <?php
        session_start();
        require_once '../config/db.php';

        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password || !filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $_SESSION['error'] = 'Please fill out the form';
            } else {
                $sql = "SELECT * FROM admin WHERE email = ? ";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);
                $admin = $stmt->fetch();
                if ($admin) {
                    if (password_verify($password, $admin['password'])) {
                        $_SESSION['adminId'] = $admin['email'];
                        header('Location: ../admin/userlist.php');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Password not match';
                    }
                } else if (!$admin) {
                    $sql = "SELECT * FROM users WHERE email = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$email]);
                    $user = $stmt->fetch();
                    if ($user) {
                        if (password_verify($password, $user['password'])) {
                            $_SESSION['userId'] = $user['email'];
                            header('Location: ../user/homeUser.php');
                            exit();
                        } else {
                            $_SESSION['error'] = 'Password not match';
                        }
                    } 
                }else {
                    $_SESSION['error'] = 'user not found';
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
        <title>login Reskill</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>

    <body>
        <div class="container mt-5">
            <form action="login.php" method="post">
            <h1 class="h3 mb-3 fw-normal">login</h1>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger mt-2" role="alert">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success mt-2" role="alert">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <hr>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                <button type="submit" name="login" class="btn btn-primary">Submit</button>
            </div>
            </form>
            <hr>
            <p>ยังไม่ได้เป็นสมาชิก  <a href="signUp.php">สมัครสมาชิก</a></p>
        </div>

    </body>

    </html>