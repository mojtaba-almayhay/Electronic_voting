<?php
//Check Login in web
session_start();
if(!isset($_SESSION['vote'])){
    header('location: index.php');
    exit();
}else{
    $id_cand = $_SESSION['vote']['id_cand'];
    require_once('db/db_connection.php');
    $sql = "SELECT * FROM candidate WHERE id = $id_cand";
    $result = mysqli_query($conn, $sql);
    if($result){
        $date = mysqli_fetch_assoc($result);
        $path_image = $date['image'];
        $name = $date['name'];
        $party = $date['party'];
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div class="container" dir="rtl" style="text-align: right !important;">
<form method="post">
    <div class="container-fluid py-5">
            <div class="container pt-5 pb-3">
                <div class="text-center mb-5">
                    <div class="card-header bg-light text-center p-4">
                        <div class="alert alert-success">
                            <h1 class="m-0">تم التصويت لصالح</h1>
                        </div>
                    </div>
                    <div class="card-body rounded-bottom bg-light p-5">
                        <img class="rounded mx-auto d-block" src="<?php echo 'admin/'.$path_image;?>">
                    </div>

                    <div class="alert alert-primary">
                            الاسم : <h1 class="m-0"><?php echo $name;?></h1>
                    </div>

                    <div class="alert alert-light">
                        الحزب : <h1 class="m-0"><?php echo $party;?></h1>
                    </div>

                </div>
            </div>
            <button type="submit" class="btn btn-outline-danger"  name="sub_logout">تسجيل الخروج</button>
    </div>

</form>
</div>


<?php
if(isset($_POST['sub_logout'])){
    session_start();
    session_unset();
    header('location:login.php');
    exit();
}
?>


