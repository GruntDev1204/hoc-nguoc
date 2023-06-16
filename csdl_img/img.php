<?php
include "config.php";
try {
    // Kết nối đến cơ sở dữ liệu
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);

    // Đặt chế độ lỗi để hiển thị thông báo lỗi chi tiết
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_FILES['src']['error'] === UPLOAD_ERR_OK) {
            $tmpFilePath = $_FILES['src']['tmp_name'];

            // Xử lý và di chuyển file tạm thời đến vị trí lưu trữ cuối cùng
            $uploadDir = "C:/xampp/htdocs/img/"; // Thay đổi thành đường dẫn thư mục lưu trữ thực tế trên máy chủ
            $newFileName = uniqid() . '_' . $_FILES['src']['name']; // Tạo tên file mới để đảm bảo tính duy nhất
            $newFilePath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                // Tệp tin đã được di chuyển thành công
                // $link = 'http://localhost/img/';
                // Lưu đường dẫn của tệp tin vào cơ sở dữ liệu
                $src =  $newFileName;
            } else {
                echo 'sida rồi con trai';          
              }
            // Lưu đường dẫn file vào cơ sở dữ liệu
            $sql = "INSERT INTO files (src , name_src , title ) VALUES (:src , :name_src , :title)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':src', $src);

            $name = $_POST["name_src"];
            $title = $_POST["title"];
            $stmt->bindValue(':name_src', $name);
            $stmt->bindValue(':title', $title);
            $stmt->execute();

            echo "Tải lên và lưu trữ file thành công.";
        } else {
            echo "Lỗi khi tải lên file.";
        }
        header("Location: loadimg.php");
        exit();
    }
   
} catch (PDOException $e) {
    echo "Lỗi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Tải lên hình ảnh</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h3>Tải lên hình ảnh với PHP thuần</h3>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <form enctype="multipart/form-data" method="POST" action="http://localhost/php/csdl_img/img.php">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Chọn tệp tin</label>
                        <input type="file" class="form-control-file" name="src">
                    </div>

                    <div class="form-group">
                        <label >Tên</label>
                        <input type="text" class="form-control" name="name_src">
                    </div>

                    <div class="form-group">
                        <label >Note</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
