<?php
include "config.php";
try {
    // Kết nối đến cơ sở dữ liệu
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);

    // Đặt chế độ lỗi để hiển thị thông báo lỗi chi tiết
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Lấy dữ liệu của bản ghi có id tương ứng
        $sql = "SELECT * FROM files WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($row);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_input'];
            $name = $_POST["name_src"];
            $title = $_POST["title"];

            // Di chuyển tệp tin đã tải lên vào thư mục đích
            $tmpFilePath = $_FILES['src']['tmp_name'];

            // Xử lý và di chuyển file tạm thời đến vị trí lưu trữ cuối cùng
            $uploadDir = "C:/xampp/htdocs/img/"; // Thay đổi thành đường dẫn thư mục lưu trữ thực tế trên máy chủ
            $newFileName = uniqid() . '_' . $_FILES['src']['name']; // Tạo tên file mới để đảm bảo tính duy nhất
            $newFilePath = $uploadDir . $newFileName;
            if (empty($_FILES['src']['name'])) {
                $src = $row['src'];
            }else{
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $src =  $newFileName;
                } else {
                    echo 'sida rồi con trai';          
                }
            }
          
            $sql = "UPDATE `files` SET 
            src = :src, 
            name_src = :name_src, 
            title = :title
            WHERE id = :id";
            // Chuẩn bị câu truy vấn
            $stmt = $conn->prepare($sql);

            // Gán giá trị cho các tham số
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':src', $src);
            $stmt->bindParam(':name_src', $name);
            $stmt->bindParam(':title', $title);

            // Thực hiện truy vấn
            $stmt->execute();

            header("Location: loadimg.php");
            exit();
        }
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
                <form enctype="multipart/form-data" method="POST" action="http://localhost/php/csdl_img/update.php?id=<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">id</label>
                        <input class="form-control-file" name="id_input" value="<?php echo $row['id']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Chọn tệp tin</label>
                        <input type="file" class="form-control-file" name="src">
                        <span><?php echo $row['src']; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" name="name_src" value="<?php echo $row['name_src']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
