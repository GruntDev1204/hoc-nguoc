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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Lấy dữ liệu của bản ghi có id tương ứng
        $sql = "SELECT * FROM banhang WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }

   

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE `banhang` SET 
            ho_va_ten = :ho_va_ten, 
            dia_chi = :dia_chi, 
            ngay_mua_hang = :ngay_mua_hang,
            so_luong = :so_luong,
            id_san_pham  = :id_san_pham                    
         WHERE id = :id";

        // Chuẩn bị câu truy vấn
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho tham số :id
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ho_va_ten', $hoVaTen);
        $stmt->bindParam(':dia_chi', $diaChi);
        $stmt->bindParam(':id_san_pham', $idSanPham);
        $stmt->bindParam(':so_luong', $soLuong);
        $stmt->bindParam(':ngay_mua_hang', $ngay_mua_hang);

        // Thực hiện truy vấn


        $hoVaTen = $_POST["ho_va_ten"];
        $diaChi = $_POST["dia_chi"];
        $idSanPham = $_POST["id_san_pham"];
        $soLuong = $_POST["so_luong"];
        $ngay_mua_hang = $currentTime = date("Y-m-d H:i:s");

        $stmt->execute();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>sửa csdl</title>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <h3> Chỉnh sửa csdl </h3>
        </div>
        <div class="row mt-5">
            <div class="col">
                <form action="http://localhost/phptest/csdl/edit.php?id=<?php echo $row['id']; ?>" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">id KH</label>
                        <input class="form-control" name="id" value="<?php echo $row['id']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Họ và tên</label>
                        <input type="text" class="form-control" name="ho_va_ten" value=" <?php echo $row['ho_va_ten']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" name="dia_chi" class="form-control" value=" <?php echo $row['dia_chi']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Sản Phẩm</label>
                        <select class="form-control" name="id_san_pham">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" class="form-control" name="so_luong" value="<?php echo $row['so_luong']; ?>" >
                    </div>
                    <button type="submit" class="btn btn-primary text-right">Submit</button>
                </form>
            </div>
        </div>
</body>

</html>
