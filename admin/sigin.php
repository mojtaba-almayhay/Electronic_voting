<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('location:login.php');
    exit;
}
?> 

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div class="container" dir="rtl" style="text-align: right !important;">
    <form method="post">
        الاسم : <input class="form-control" type="text" name="name"  ><br>
        المعرف : <input class="form-control"  type="text" name="user" ><br>
        الباسورد : <input class="form-control"  type="password" name="pass"  ><br>
        <button class="btn btn-outline-success" type="submit" name="sub_sing">اضافة ناخب</button>
        <button class="btn btn-outline-danger" type="submit" name="hom_admin">قائمة الناخبين</button>
    </form>
</div>
<?php
if(isset($_POST['sub_sing'])){
    $name = $_POST['name'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if(empty($user)){
        echo '<div class="alert alert-danger" role="alert">لا يمكن ترك حقل المعرف فارغا</div>';
    } else if(empty($pass)) { 
        echo '<div class="alert alert-danger" role="alert">لا يمكن ترك حقل الباسورد فارغا</div>';
    } else if(empty($name)) {
        echo '<div class="alert alert-danger" role="alert">لا يمكن ترك حقل الاسم فارغا</div>';
    } else {    
        require_once('../db/db_connection.php');
        $res_user = mysqli_query($conn, "select * from voters where username = '$user'");
        if ($res_user) {
            if (mysqli_num_rows($res_user) > 0) {
                echo '<div class="alert alert-danger" role="alert">هذا المعرف مستخدما بالفعل</div>';
            } else {
                $result = mysqli_query($conn, "insert into voters(name,username,password,status) value('$name','$user','$pass','Unvoted')");
                if ($result) {
                    header('location: voting.php');
                    exit;
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} elseif (isset($_POST['hom_admin'])) {
    header('location: voting.php');
    exit;
}

?>

