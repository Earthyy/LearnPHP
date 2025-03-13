<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
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
                            <img id="imgPreview" >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dangerous" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="sumbit" class="btn btn-success">Sumbit</button>
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add User</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>