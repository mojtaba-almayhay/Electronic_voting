<?php
session_start();
if(isset($_SESSION['user'])){
    header('location: index.php');
    exit();
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div class="container" dir="rtl" style="text-align: right !important;">
    <form method="post">
        المعرف : <input class="form-control" type="text" name="user" required>
        <br>
        الباسورد : <input class="form-control" type="password" name="pass" required>
        <br>
        <button class="btn btn-outline-primary" type="submit" name="sub_login">تسجيل</button>
    </form>
</div>

<?php
if(isset($_POST['sub_login'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    if(empty($user)){
        echo '<div class="alert alert-danger" role="alert">
           لا يمكن ترك حقل المعرف فارغا
      </div>';
    }else if(empty($pass)){ 
        echo '<div class="alert alert-danger" role="alert">
           لا يمكن ترك حقل الباسورد فارغا
      </div>';
    }else{
        require_once('db/db_connection.php');
        $res = mysqli_query($conn,"select * from voters where username = '$user' and password = '$pass'");
        if($res){
            
            $user_id = mysqli_fetch_assoc($res);

            if($user_id){
                $status = $user_id['status'];
                $user_id = $user_id['id'];
                if($status == "voted"){
                    $res_vos = mysqli_query($conn,"select * from votes where user_id = '$user_id'");
                    $data_vos = mysqli_fetch_assoc($res_vos);
                    $id_can = $data_vos['candidate_id'];
                    session_start();
                    $_SESSION['vote']=[
                        'id'=>$user_id,
                        'id_cand'=>$id_can,
                    ];
                    header('location: Vote.php');
                    exit;
                }else{
                    session_start();
                    $_SESSION['user']=['id'=>$user_id,];
                    header('location: index.php');
                    exit;
                }

            }else{
                        echo '<div class="alert alert-danger" role="alert">
                        المعرف او كلمة المرور غير صحية
                        </div>';
                    }
                    
                }else{
                    die("Error(1) : ".mysqli_error($conn));
                }
            }
}
?>