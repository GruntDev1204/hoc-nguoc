<?php
var_dump($_POST);
$hoVaTen = $_POST["ho_va_ten"];
$diaChi = $_POST["dia_chi"];
$idSanPham = $_POST["id_san_pham"];
$soLuong = $_POST["so_luong"];
$ngay_mua_hang = $currentTime = date("Y-m-d H:i:s");

// Tạo câu lệnh SQL
$sql = "INSERT INTO banhang ( ho_va_ten, dia_chi, id_san_pham, so_luong , ngay_mua_hang)
            VALUES ('$hoVaTen', '$diaChi', '$idSanPham', '$soLuong' , '$ngay_mua_hang')";


$connection = new mysqli("localhost", "root", "root", "baiktra");
if ($connection->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $connection->connect_error);
}

if ($connection->query($sql) === TRUE) {
    echo "Thêm dữ liệu thành công";
} else {
    echo "Lỗi: " . $sql . "<br>" . $connection->error;
}

// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>
