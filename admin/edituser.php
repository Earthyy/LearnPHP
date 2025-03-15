<?php 

    require_once '../config/db.php';
    require_once '../auth/authAdmin.php';

    if(isset($_POST['update'])) {
        $id = $_POST['id'];  //รับ input ที่มี name เป็น id มา
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $role = $_POST['role'];
        $img = $_FILES['img'];
        
        $img2 = $_POST['img2'];
        $upload = $_FILES['img']['name'];
        
        $img_name = $img['name'];
        $img_tmp = $img['tmp_name'];
        $img_size = $img['size'];
        $img_error = $img['error'];

        $allowed = array('jpg', 'jpeg', 'png');
        $extention = explode('.', $img_name);
        $img_actual_ext = strtolower(end($extention));
        $imgNew = rand() . "." . $img_actual_ext;
        $imgPath = "../upload/" . $imgNew;
        $maxSize = 2 * 1024 * 1024;

        // ตรวจสอบว่ามีการเปลี่ยนรูปภาพหรือไม่
        if($upload != "") {
            echo "upload new img";
            if(in_array($img_actual_ext, $allowed)) {
                if($img_error === 0) {
                    if($img_size < $maxSize) {
                        move_uploaded_file($img_tmp, $imgPath);
                    } else {
                        $_SESSION['error'] = "Don't found your file";
                        header('location: userlist');
                    }
                } else {
                    $_SESSION['error'] = "There was an error uploading your file";
                    header('location: userlist');
                }
            } else {
                $_SESSION['error'] = "You cannot upload files of this type";
                header('location: userlist');
            }
        }else {
            $imgNew = $img2;
        }
        $sql = "UPDATE users SET f_name = ?, l_name = ?, role = ?, img = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$f_name, $l_name, $role, $imgNew, $id]);
        if($stmt){
            $_SESSION['success'] = "User updated successfully";
            header('location: userlist');
        }else {
            $_SESSION['error'] = "Can't update user";
            header('location: userlist');
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Edit User</h1>
            </div>
        </div>
        <hr>
        <!-- ส่ง action ไปที่ไฟล์ของตัวเอง -->
        <form action="edituser.php" method="post" enctype="multipart/form-data">
            <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM users WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$id]);
                    $user = $stmt->fetch();
                }
            ?>
            <div class="mb-3">
                <input type="text" readonly class="form-control" name="id" value="<?= $user['id']; ?>">
                <label for="f_name" class="col-form-label">First Name:</label>
                <input type="text" required class="form-control" name="f_name" value="<?= $user['f_name']; ?>">
                <input type="hidden" class="form-control" name="img2" value="<?= $user['img']; ?>"> <!-- กรณีไม่ได้มีการเเก้ไขรูปภาพ -->
            </div>
            <div class="mb-3">
                <label for="l_name" class="col-form-label">Last Name:</label>
                <input type="text" required class="form-control" name="l_name" value="<?= $user['l_name']; ?>">
                    </div>
                    <div class=" mb-3">
                <label for="role" class="col-form-label">Position:</label>
                <input type="text" required class="form-control" name="role" value="<?= $user['role']; ?>">
                    </div>
                    <div class=" mb-3">
                <label for="img" class="col-form-label">Image:</label>
                <input type="file" class="form-control" id="imgInput" name="img">
                <img width="25%" height="25%" class="mt-2 rounded mx-auto d-block" id="imgPreview" src="../upload/<?= $user['img']; ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                <button type="submit" name="update" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        const imgInput = document.getElementById('imgInput');
        const imgPreview = document.getElementById('imgPreview');
        imgInput.onchange = evt => {
            const [file] = imgInput.files
            if (file) {
                imgPreview.src = URL.createObjectURL(file)
            }
        }
    </script>
</body>

</html>