<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('location:login.php');
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div class="container" dir="rtl" style="text-align: right !important;">
    <form method="post" enctype="multipart/form-data">
        <!--<label class="control-label">Image:</label>-->
        اسم المرشح : <input class="form-control" type="text" name="name" >
        <br>
        اسم الحزب : <input class="form-control" type="text" name="hzeb" >
        <br>
        صورة المرشح  : <input class="form-control" type="file" name="image" >
        <br>
        <button class="btn btn-outline-primary" type="submit" name="cand_add">اضافة</button>
        <button class="btn btn-outline-danger" type="submit" name="cand_list">قائمة المرشحين</button>
    </form>
</div>

<?php
if(isset($_POST['cand_add'])){
    $name = $_POST['name'];
    $hzeb = $_POST['hzeb'];
        
    if(empty($name)){
        echo '<div class="alert alert-danger" role="alert">لا يمكن ترك حقل المعرف فارغا</div>';
    }else if(empty($hzeb)) { 
        echo '<div class="alert alert-danger" role="alert">لا يمكن ترك حقل الباسورد فارغا</div>';
    }else{
        require_once('../db/db_connection.php');        
        $image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name= addslashes($_FILES['image']['name']);
        $image_size= getimagesize($_FILES['image']['tmp_name']);
        move_uploaded_file($_FILES["image"]["tmp_name"],"upload/" . $_FILES["image"]["name"]);			
		$location="upload/" . $_FILES["image"]["name"];

        $result = mysqli_query($conn, "insert into candidate(name,party,image) value('$name','$hzeb','$location')");
        if($result){
            header('location: candidate.php');
            exit;
        }else{
            echo "Error: " . mysqli_error($conn);
        }
    }

}


if(isset($_POST['cand_list'])){
    header('location: candidate.php');
    exit();
}


?>





