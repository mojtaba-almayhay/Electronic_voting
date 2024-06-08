<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('location:login.php');
    exit;
}else{
    $id_admin = $_SESSION['admin']["id"];
    require_once('../db/db_connection.php');
    $res = mysqli_query($conn,"select * from users where id = '$id_admin'");
    if($res){
        $data = mysqli_fetch_assoc($res);
        $name = $data['name'];
        $username = $data['username'];
    }else{
        die("Error(2) : ".mysqli_error($conn));
    }
}
?> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div dir="rtl" style="text-align: right !important;">
<form method="post">
<section class="vh-100" style="background-color: #f4f5f7;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-6 mb-4 mb-lg-0">
        <div class="card mb-3" style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-center text-white"
              style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <img src="images/user.png" alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
            </div>
            <div class="col-md-8">
              <div class="card-body p-4">
                <h6><?php echo $name; ?></h6>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>Username</h6>
                    <p class="text-muted"><?php echo $username;?></p>
                  </div>
                </div>
                <div class="d-flex justify-content-start">
                    <button class="btn btn-outline-danger" type="submit" name="sub_logout">تسجيل خروج</button><spam>
                    <button class="btn btn-outline-primary" type="submit" name="add_candidate">المرشحين</button><spam>
                    <button class="btn btn-outline-success" type="submit" name="add_user">الناخبين</button><spam>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</form>
</div>
<?php
if(isset($_POST['sub_logout'])){
    session_start();
    session_unset();
    header('location:login.php');
    exit();
}

if(isset($_POST['add_user'])){
    header('location:voting.php');
    exit();


} elseif (isset($_POST['add_candidate'])){
    header('location: candidate.php');
    exit();
}
?>