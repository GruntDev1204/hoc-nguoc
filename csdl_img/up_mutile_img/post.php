<?php
$servername = "localhost";
$port = 3306;
$database = "taomoiimg";
$username = "root";
$password = "";


$conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);

// Đặt chế độ lỗi để hiển thị thông báo lỗi chi tiết
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM `all_media`";
$result = $conn->query($sql);

function deleteList($id){
    global $conn;
    $delete = "DELETE FROM `all_media` where id = $id";
    $delete_all_media = "DELETE FROM `media` where id_extend = $id";
    $conn->exec($delete);
    $conn->exec($delete_all_media);
}
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    deleteList($id);
    echo "xóa thành công";
}


function delete($id){
    global $conn;
    $delete_sional = "DELETE FROM `media` where id = $id";
    $conn->exec($delete_sional);
} 
if (isset($_POST['delete_ca_nhan'])) {
    $id = $_POST['id_ca_nhan'];
    delete($id);
    echo "xóa thành công id =$id";
}







//post
if (isset($_FILES['images'])) {
    $images = $_FILES['images'];

    $title = $_POST['title'];
    $query_all_media = "INSERT INTO all_media (name) VALUES ('$title')";
    $conn->exec($query_all_media);
    $id_extend = $conn->lastInsertId();

    // Lặp qua từng tệp ảnh
    foreach ($images['tmp_name'] as $key => $tmp_name) {
        $image_name = $images['name'][$key];
        $image_tmp = $tmp_name;

        // Lưu tệp ảnh vào thư mục tạm thời hoặc thư mục lưu trữ của bạn
        move_uploaded_file($image_tmp, "C:/xampp/htdocs/img/" . $image_name);


        // Thực hiện INSERT vào bảng "media" để lưu thông tin ảnh
        $query = "INSERT INTO media (url , id_extend ) VALUES ('$image_name' , $id_extend)";
        $conn->exec($query);

        echo $image_name  . "<br>\n";
       
    }
    header('Location: success.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Up nhiều ảnh</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
       .dele-hover{
            position: absolute;
            top: 0;
            opacity: 0;
       } .dele-hover:hover{
        opacity: 1;
       }
       .update-hover{
            position: absolute;
            top: 0;
            opacity: 0;
            right: 0;
       }.update-hover:hover{
         opacity: 1;
       }
       .alert-edit{
        position: absolute;
        width: 700px;
        top: 200px;
        left: 21%;
        z-index: 9999;
       }
       .yoyle{
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 9999;
        top: 0;
        background-color: #343a4096;
       }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.4/vue.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
</head>

<body style="background-color: black;color:aliceblue">
<div id="app">
    <div class="yoyle"  v-if="toggle">
    <div class="container ">
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-edit">
                        <form enctype="multipart/form-data" :action="'http://localhost/php/csdl_img/up_mutile_img/edit_ca_nhan.php?id=' + id_update"  method="post">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Chọn tệp tin</label>
                                <input type="file" class="form-control-file" name="img_ca_nhan">
                                    <button  class="btn btn-info mt-5"  type="submit ">save</button>
                            </div>
                        </form>
                        <button  class="btn btn-dark " v-on:click="toggled">close</button>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="yoyle"  v-if="editted">
    <div class="container ">
        <div class="row">
            <div class="col">
                <div class="alert alert-success alert-edit">
                        <form enctype="multipart/form-data" :action="'http://localhost/php/csdl_img/up_mutile_img/edit_ca_nhan.php?id_list=' + id_update_list"  method="post">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Chọn tệp tin</label>
                                <input type="file" multiple class="form-control-file" name="img_ca_nhan[]">
                                    <button  class="btn btn-info mt-5"  type="submit ">save</button>
                            </div>
                        </form>
                        <button  class="btn btn-dark " v-on:click="edit">close</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <div class="row mt-5">
            <h3 class="text-center"> Up nhiều ảnh </h3>
        </div>
        <div class="row mt-5">
            <div class="input-group mb-3">
                <form enctype="multipart/form-data" action="http://localhost/php/csdl_img/up_mutile_img/post.php" method="post">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Chọn tệp tin</label>
                        <input type="file" multiple class="form-control-file" name="images[]">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Đặt tên</label>
                        <input type="text" multiple class="form-control-file" name="title">
                    </div>
                    <button class="btn btn-success" type="submit"> Upload </button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <?php foreach ($result as $row) : ?>
                    <div class="alert alert-info">
                        <h3 class="title text-center"><?php echo  $row['name']; ?></h3>

                        <form method="post"  action="http://localhost/php/csdl_img/up_mutile_img/post.php">
                            <input hidden name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger" name="delete">Xóa</button>
                        </form>
                        <button type="submit" class="btn btn-info" v-on:click="edit(<?php  echo $row['id']; 
                                        ?>)">edit</button>
                       

                        <hr>
                        <div class="row">
                            <?php
                            $query_media = "SELECT * FROM media WHERE id_extend = $row[id]";
                            $stmt_media = $conn->prepare($query_media);
                            $stmt_media->execute();
                            $media_records = $stmt_media->fetchAll(PDO::FETCH_ASSOC);
                            $link = 'http://localhost/img/';
                            foreach ($media_records as $value) :
                            ?>
                                <div class="col-md-3 mt-3">
                                    <img class="img-fluid" style="height: 250px;"  src="<?php echo $link. $value['url']; ?>"/>

                                    <form method="post" class="dele-hover" action="http://localhost/php/csdl_img/up_mutile_img/post.php">
                                        <input hidden name="id_ca_nhan" value="<?php echo $value['id']; ?>">
                                        <button type="submit" class="btn btn-danger " name="delete_ca_nhan">Xóa</button>
                                     
                                    </form>
                                    <button  class="btn btn-success update-hover " v-on:click="toggled(<?php  echo $value['id']; 
                                        ?>)"  >edit</button>
                                  
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
    </div>
</div>
</body>
<script>
   new Vue({
    el : '#app',
    data :{
        toggle : false,
        editted:false,
        id_update : 0,
        id_update_list : 0 ,

    },
    methods:{
        toggled(id_ca_nhan){
            this.id_update = id_ca_nhan
            console.log(this.id_update )
            axios.get('http://localhost/php/csdl_img/up_mutile_img/edit_ca_nhan.php?id='+ id_ca_nhan )
            .then(response => {
                    // Xử lý phản hồi từ máy chủ nếu cần
                    console.log(response.data);
                })
                .catch(error => {
                    // Xử lý lỗi nếu có
                    console.error(error);
                });
                this.toggle =!this.toggle
        },
        edit(id){
            this.id_update_list = id
            console.log(this.editted);
            axios.get('http://localhost/php/csdl_img/up_mutile_img/edit_ca_nhan.php?id_list='+ id )
            .then(response => {
                    // Xử lý phản hồi từ máy chủ nếu cần
                    console.log(response.data);
                })
                .catch(error => {
                    // Xử lý lỗi nếu có
                    console.error(error);
                });
                this.editted = !this.editted;
        }   
    },
   })
</script>

</html>