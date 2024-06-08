<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('location:login.php');
    exit;
}

if (isset($_POST['add_vot'])){
    header('location: sigin.php');
    exit();
}

if(isset($_POST['admin_page'])){
    header('location: index.php');
    exit();
}

?> 

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div dir="rtl" style="text-align: right !important;">
    <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <form method='post'>
            <button class="btn btn-outline-primary" type="submit" name="add_vot">اضافة ناخب</button>
            <button class="btn btn-outline-danger" type="submit" name="admin_page">القائمة الرئيسية</button>
        </form>
    </div>
    </nav>



    <table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>الاسم</th>
      <th>المعرف</th>
      <th>الباسورد</th>
      <th>التصويت</th>
    </tr>
  </thead>
  <tbody>

    <?php
    require_once('../db/db_connection.php');// Connect to the database
    $query = "SELECT * FROM voters";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<form method='post'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $status = $row['status'];
            if($status == "voted"){
                $sta = "تم التصويت";
                $cla = "btn btn-outline-success";
            }else{
                $sta = "غير مصوت";
                $cla = "btn btn-outline-danger";
            }
            echo "<tr>
            <td>
              <div class='d-flex align-items-center'>
                <div class='ms-3'>
                    <p class='fw-bold mb-1'>".$row['name']."</p>
                </div>
              </div>
            </td>
            <td>
                <p class='fw-bold mb-1'>".$row['username']."</p>
              
            </td>
            <td>
                <p class='fw-normal mb-1'>".$row['password']."</p>
            </td>


            <td>
                <p class='$cla'>".$sta."</p>
            </td>
            
            </tr>";
        }
        echo "</form>";
        
        
    
    } else {
        echo "Error: " . mysqli_error($conn);
    }


    ?>
</div>

