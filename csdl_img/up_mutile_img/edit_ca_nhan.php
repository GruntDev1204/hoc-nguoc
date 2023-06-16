<?php
include "config.php";

$conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);

// Đặt chế độ lỗi để hiển thị thông báo lỗi chi tiết
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function update_ca_nhan($id){
    global $conn;
    if (isset($_FILES['img_ca_nhan'])) {
        // Di chuyển tệp tin đã tải lên vào thư mục đích
        $tmpFilePath = $_FILES['img_ca_nhan']['tmp_name'];

        // Xử lý và di chuyển file tạm thời đến vị trí lưu trữ cuối cùng
        $uploadDir = "C:/xampp/htdocs/img/"; // Thay đổi thành đường dẫn thư mục lưu trữ thực tế trên máy chủ
        $newFileName = uniqid() . '_' . $_FILES['img_ca_nhan']['name']; // Tạo tên file mới để đảm bảo tính duy nhất
        $newFilePath = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            $url = $newFileName;
        } else {
            echo 'Lỗi khi di chuyển file tải lên.';
        }
      
        // Sử dụng prepared statement để tránh lỗ hổng SQL Injection
        $update_ca_nhan = "UPDATE `media` SET url = :url WHERE id = :id";
        $stmt = $conn->prepare($update_ca_nhan);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':id', $id);
        
        // Thực hiện câu truy vấn
        if ($stmt->execute()) {
            echo "Sửa thành công id = $id";
        } else {
            echo "Lỗi khi thực hiện câu truy vấn.";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    update_ca_nhan($id);
    echo "thành công";

    header("Location: post.php");
    exit();
}

function updateList($id){
    global $conn;
    if (isset($_FILES['img_ca_nhan'])) {
        $images = $_FILES['img_ca_nhan'];

        // Xóa các bản ghi cũ liên quan đến $id
        $delete_cai_cu = "DELETE FROM media WHERE id_extend = $id";
        $conn->exec($delete_cai_cu);

        // Lặp qua từng ảnh và chèn vào cơ sở dữ liệu
        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $image_name = $images['name'][$key];
            $image_tmp = $tmp_name;

            // Di chuyển tệp ảnh vào thư mục lưu trữ cuối cùng
            move_uploaded_file($image_tmp, "C:/xampp/htdocs/img/" . $image_name);

            // Thực hiện INSERT vào bảng "media" để lưu thông tin ảnh
            $query = "INSERT INTO media (url, id_extend) VALUES ('$image_name', '$id')";
            $conn->exec($query);
            echo  'update thành công ' .  $image_name  . "<br>\n";
        }      
    }
}

if (isset($_GET['id_list'])) {
    $id = $_GET['id_list'];
    updateList($id);
    echo "thành công";
    header("Location: post.php");
    exit();
}

?>