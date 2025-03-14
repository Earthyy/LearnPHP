<!-- เอามาจาก W3Schools พิมพ์ว่า pdo db connect -->
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..'); // ใช้คำสั่ง __DIR__ . '/..' เพื่อให้ไฟล์ .env อยู่ในโฟลเดอร์ข้างนอก

$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    // สร้าง Instance ของ PDO โดยใส่ Database และ username password ที่ต้องการเชื่อมต่อ
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception ช่วยให้การจัดการ error เร็วขึ้น
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //หมายความว่าเมื่อดึงข้อมูลจากฐานข้อมูลออกมา (ด้วยคำสั่ง fetch() หรือ fetchAll()), ผลลัพธ์จะถูกดึงออกมาในรูปแบบของ Associative Array (อาเรย์ที่มี key เป็นชื่อคอลัมน์ในตารางฐานข้อมูล)
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 

    // ปิดการใช้งาน Emulated Prepared Statements ใน PDO ช่วยเพิ่มความปลอดภัยในการป้องกัน SQL injection และช่วยให้ฐานข้อมูลสามารถทำการแคชคำสั่ง SQL ที่ถูกเตรียมไว้ได้ดีขึ้น
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>