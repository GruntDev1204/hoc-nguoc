<?php
$servername = "localhost";
$port = 3306;
$database = "baiktra";
$username = "root";
$password = "";

try {
    // Kết nối đến cơ sở dữ liệu
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);

    // Đặt chế độ lỗi để hiển thị thông báo lỗi chi tiết
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   

    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $sql = "DELETE FROM banhang WHERE id = :id";
    
        // Chuẩn bị câu truy vấn
        $stmt = $conn->prepare($sql);
        
        // Gán giá trị cho tham số :id
        $stmt->bindParam(':id', $id);
        
        // Thực hiện truy vấn
        $stmt->execute();
        echo 'xóa dữ liệu thành công';
    }



} catch (PDOException $e) {
    echo "Lỗi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
}
?>