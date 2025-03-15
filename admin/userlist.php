<?php
require_once '../config/db.php';
require_once '../auth/authAdmin.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    //ไปดึงชื่อไฟล์รูปภาพออกมา เพื่อลบไฟล์รูปภาพจาก Folder
    $sql = "SELECT img FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    $imgPath = "../upload/" . $user['img'];
    if (file_exists($imgPath)) {
        unlink($imgPath);
    }

    //ลบข้อมูลใน Database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    if ($stmt) {
        $_SESSION['error'] = "User deleted successfully";
        header('Location: userlist');
        exit(); // หยุดการทำงานของโค้ดหลังจาก Redirect
    } else {
        $_SESSION['error'] = "Can't delete user";
        header('Location: userlist');
        exit();
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

<body">
    <?php
    // echo $_SESSION['adminId'];
    include 'sidebar.php';
    ?>
    <div class="container-fluid" style="margin-left: 150px;">
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- body ไว้ใส่ข้อมูล -->
                    <div class="modal-body">
                        <!-- เมื่อกดไปที่ไฟล์ insert.php กำหนด | post เพราะจะเพิ่มข้อมูล | multipart/form-data เพื่อเพิ่มรูปภาพ เหมือน formData ใน React-->
                        <form action="insert.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="f_name" class="col-form-label">First Name:</label>
                                <input type="text" required class="form-control" name="f_name">
                            </div>
                            <div class="mb-3">
                                <label for="l_name" class="col-form-label">Last Name:</label>
                                <input type="text" required class="form-control" name="l_name">
                            </div>
                            <div class="mb-3">
                                <label for="position" class="col-form-label">Position:</label>
                                <input type="text" required class="form-control" name="position">
                            </div>
                            <div class="mb-3">
                                <label for="img" class="col-form-label">Image:</label>
                                <input type="file" required class="form-control" id="imgInput" name="img">
                                <img width="100%" class="mt-2" id="imgPreview">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-success">Sumbit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h1>CRUD</h1>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <!-- # สื่อถึง id ของ element นั้น . สื่อถึง class -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add
                        User</button>
                </div>
            </div>
            <hr>
            <!-- ต้องการใช้เงื่อนไขเพื่อแสดงข้อความเมื่อมีการเพิ่มข้อมูลสำเร็จหรือไม่ -->
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <!-- เป็นเทคนิคการเขียนสลับกันระหว่า php เเละ html ให้อยู่ร่วมกันได้ -->
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">Img</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM users";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    if (!$users) {
                        echo "<tr><td colspan='6'>No users found</td></tr>";
                    } else {
                        foreach ($users as $user) {
                            ?>
                            <tr>
                                <th scope="row"><?= $user['id']; ?></th>
                                <td><?= $user['f_name']; ?></td>
                                <td><?= $user['l_name']; ?></td>
                                <td><?= $user['role']; ?></td>
                                <td><img src="../upload/<?= $user['img'] ?>" width="100px" height="auto" class="rounded" alt="">
                                </td>
                                <td>
                                    <a href="edituser.php?id=<?= $user["id"] ?>" class="btn btn-warning">edit</a>

                                    <!-- ?delete เหมือน userlist?delete เวลาเอาไปใช้เลยต้องใช้เป็น delete -->
                                    <a href="?delete=<?= $user["id"] ?>" class="btn btn-danger"
                                        onclick="return confirm('Confirm delete its data')">delete</a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        const imgInput = document.getElementById('imgInput');
        const imgPreview = document.getElementById('imgPreview');

        // imgInput.addEventListener('change', function() {
        //     const file = this.files[0];
        //     if (file) {
        //         const reader = new FileReader();
        //         reader.onload = function() {
        //             imgPreview.src = reader.result;
        //         }
        //         reader.readAsDataURL(file);
        //     }
        // });
        imgInput.onchange = evt => {
            const [file] = imgInput.files
            if (file) {
                imgPreview.src = URL.createObjectURL(file)
            }
        }
    </script>
    </body>

</html>