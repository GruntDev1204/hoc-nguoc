<?php
include "config.php";

try {
    // Kết nối đến cơ sở dữ liệu
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);

    // Đặt chế độ lỗi để hiển thị thông báo lỗi chi tiết
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $sql = "SELECT * FROM files";
    $result = $conn->query($sql);
    $link = 'http://localhost/img/';
  
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
    <title>Xem hình ảnh</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h3>Xem hình ảnh với PHP thuần</h3>
            </div>
        </div>

        <div class="row mt-5">
            <div class="container">

                <div class="row mt-5">
                    <h3> Danh sách files   <a href="http://localhost/php/csdl_img/img.php"    class="btn btn-success">up ảnh mới</a></h3>
                    <h3>================================================================</h3>
                    <?php foreach ($result as $row) : ?>
                        <ul class="list-group" style="margin-left: 50px;margin-top: 50px;">

                            <li class="list-group-item"> <?php echo $row['name_src']; ?></li>
                            <li class="list-group-item"> <?php echo $row['title']; ?></li>
                            <li class="list-group-item">
                                <img style="height: 200px; width:200px" src="<?php echo $link . $row['src']; ?>" alt="Image">
                            </li>
                            <li class="list-group-item" style="display: flex; gap:20px">
                                <form action="http://localhost/php/csdl_img/delete.php?id=<?php echo $row['id']; ?>" method="post">
                                    <input hidden name="id"  type="text" value="<?php echo $row['id']; ?>" />
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                                <a href="http://localhost/php/csdl_img/update.php?id=<?php echo $row['id']; ?>"    class="btn btn-success">Edit</a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


    </div>
</body>

</html>