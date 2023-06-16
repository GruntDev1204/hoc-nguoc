
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


    $sql = "SELECT * FROM banhang";
    $result = $conn->query($sql);


} catch (PDOException $e) {
    echo "Lỗi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test mysql</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="row mt-5">
        <div class="container">
            <div class="row mt-5">
                <h3> Thêm vào csdl </h3>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <form action="http://localhost/phptest/csdl/taodulieu.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Họ và tên</label>
                            <input type="text" class="form-control" name="ho_va_ten" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="dia_chi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sản Phẩm</label>
                            <select class="form-control" name="id_san_pham">
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="number" class="form-control" name="so_luong">
                        </div>

                        <button type="submit" class="btn btn-primary text-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="container">
          
                <div class="row mt-5">
                    <h3> Danh sách khách hàng </h3>
                    <h3>================================================================</h3>
                    <?php foreach ($result as $row) : ?>
                        <ul class="list-group">
                            <li class="list-group-item">
                            <form action="http://localhost/phptest/csdl/xoa.php" method="post">
                                <input  hidden name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" >Xóa</button>
                            </form>
                            <a href="http://localhost/phptest/csdl/edit.php?id=<?php echo $row['id']; ?>"  method="post" class="btn btn-success">Edit</a>
                            </li>
                            <li class="list-group-item">  <?php echo $row['ho_va_ten']; ?></li>
                            <li class="list-group-item">  <?php echo $row['dia_chi']; ?></li>
                            <li class="list-group-item">  <?php echo $row['ngay_mua_hang']; ?></li>
                            <li class="list-group-item">  <?php echo $row['so_luong']; ?></li>
                        </ul>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


       

</html>

