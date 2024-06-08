<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('location:login.php');
    exit;
}
?> 

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div dir="rtl" style="text-align: right !important;">
    <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <form method='post'>
            <button class="btn btn-outline-primary" type="submit" name="add_candidate">اضافة مرشح</button>
            <button class="btn btn-outline-danger" type="submit" name="admin_page">القائمة الرئيسية</button>
        </form>
    </div>
    </nav>



    <table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>ID</th>
      <th>الصورة</th>
      <th>الاسم</th>
      <th>الحزب</th>
      <th>الاصوات</th>
    </tr>
  </thead>
  <tbody>

    <?php
    require_once('../db/db_connection.php');
    $query = "SELECT * FROM candidate";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<form method='post'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $id_cad = $row['id'];
            $Sql_vos = "select * from votes where candidate_id = '$id_cad'";
            $result_vos = mysqli_query($conn, $Sql_vos);
            $Vos = 0;
            while ($mm = mysqli_fetch_assoc($result_vos)) {   
                $Vos = $Vos + 1;
            }
            echo "<tr>
            <td>$id_cad</td>
            
            <td>
              <div class='d-flex align-items-center'>
                <div class='ms-3'>
                    <img src='" . $row['image'] . "' alt='' style='width: 45px; height: 45px' class='rounded-circle'/>
                </div>
              </div>
            </td>
            <td>
                <p class='fw-bold mb-1'>".$row['name']."</p>
              
            </td>
            <td>
                <p class='fw-normal mb-1'>".$row['party']."</p>
            </td>

            <td >$Vos</td>
            
            </tr>";
        }
        echo "</form>";
        
        
    
    } else {
        echo "Error: " . mysqli_error($conn);
    }


    ?>
</div>

<?php
if (isset($_POST['add_candidate'])){
    header('location: addCandi.php');
    exit();
}

if (isset($_POST['admin_page'])){
    header('location: index.php');
    exit();
}

?>