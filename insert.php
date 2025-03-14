<?php
    session_start();
    require_once 'config/db.php';
    
    // ตรวจสอบว่ามีการกดปุ่ม submit หรือไม่ ด้วยการใช้ isset() ซึ่งจะเช็คว่ามีค่าในตัวแปร $_POST['submit'] หรือไม่
    if(isset($_POST['submit'])) {
        $f_name = $_POST['f_name']; //ดึงค่ามาจาก input ที่มี name เป็น f_name
        $l_name = $_POST['l_name'];
        $position = $_POST['position'];
        $img = $_FILES['img'];

        $img_name = $img['name']; //เข้าถึงชื่อไฟล์
        $img_tmp = $img['tmp_name']; //เข้าถึง path ของไฟล์
        $img_size = $img['size']; //เข้าถึงขนาดของไฟล์
        $img_error = $img['error']; //เข้าถึง error ของไฟล์

        $allowed = array('jpg', 'jpeg', 'png');// อนุญาตให้ upload ได้เฉพาะไฟล์ที่มีนามสกุล jpg, jpeg, png
        $extention = explode('.', $img_name); // แยกชื่อไฟล์กับนามสกุลออกจากกัน
        $img_actual_ext = strtolower(end($extention)); // แปลงนามสกุลไฟล์เป็นตัวพิมพ์เล็ก
        $imgNew = rand() . "." . $img_actual_ext; // สุ่มชื่อไฟล์ใหม่
        $imgPath = "upload/" . $imgNew; // กำหนด path ของไฟล์ใหม่
        $maxSize = 2 * 1024 * 1024;

        if(in_array($img_actual_ext, $allowed)) {
            if($img_error === 0) {
                // ตรวจสอบขนาดของไฟล์
                if($img_size < $maxSize) {
                    if(move_uploaded_file($img_tmp, $imgPath)) {
                        $sql = "INSERT INTO users (f_name, l_name, position, img) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$f_name, $l_name, $position, $imgNew]);
                        $_SESSION['success'] = "User added successfully";
                        header('location: index.php');
                        // if($stmt) {
                        //     $_SESSION['success'] = "User added successfully";
                        //     header('location: index.php');
                        // } else {
                        //     $_SESSION['error'] = "can't added user";
                        //     header('location: index.php');
                        // }
                    } else {
                        $_SESSION['error'] = "There was an error uploading your file";
                        header('location: index.php');
                    }
                } else {
                    $_SESSION['error'] = "Don't found your file";
                    header('location: index.php');
                }
            } else {
                $_SESSION['error'] = "There was an error uploading your file";
                header('location: index.php');
            }
        } else {
            $_SESSION['error'] = "You cannot upload files of this type";
            header('location: index.php');
        }
    }

?>