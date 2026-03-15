<?php
// إعدادات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mohamed"; // تأكد من اسم قاعدة البيانات الخاصة بك

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استقبال البيانات من النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $individuals = $_POST['Individuals'];
    // تحويل تنسيق التاريخ ليناسب MySQL
    $date = str_replace('T', ' ', $_POST['Date']); 
    $notes = $_POST['Notes'];

    // استخدام prepared statements للحماية من SQL Injection
    $stmt = $conn->prepare("INSERT INTO burger (Name, Individuals, Date, Notes) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $name, $individuals, $date, $notes);

    if ($stmt->execute()) {
        echo "تم الحجز بنجاح!";
    } else {
        echo "حدث خطأ: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>