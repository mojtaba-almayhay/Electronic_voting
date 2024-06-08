<?php
//Check Login in web
session_start();
if(!isset($_SESSION['user'])){
    header('location: login.php');
    exit();

}

if(isset($_SESSION['vote'])){
    header('location: Vote.php');
    exit();
}

?> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div class="container" dir="rtl" style="text-align: right !important;">
<form method="post">
<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>الصورة</th>
      <th>الاسم</th>
      <th>الحزب</th>
      <th>التصويت</th>
    </tr>
  </thead>
  <tbody>

    <?php
    require_once('db/db_connection.php'); // Connect to the database
    $query = "SELECT * FROM candidate";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<form method='post'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
            <td>
              <div class='d-flex align-items-center'>
                <div class='ms-3'>
                    <img src='admin/" . $row['image'] . "' alt='' style='width: 45px; height: 45px' class='rounded-circle'/>
                </div>
              </div>
            </td>
            <td>
                <p class='fw-bold mb-1'>".$row['name']."</p>
              
            </td>
            <td>
                <p class='fw-normal mb-1'>".$row['party']."</p>
            </td>
            <td><input type='radio' value='".$row['id']."' name='candidate_id'</td>
            </tr>";
        }
        echo "<input type='submit' class='btn btn-outline-primary'  name='ins_vote' value='تصويت'> ";
        echo "</form>";
        
    
    } else {
        echo "Error: " . mysqli_error($conn);
    }


    ?>

    <button class="btn btn-outline-danger" type="submit" name="sub_logout">تسجيل الخروج</button><br>
</form>
</div>
<?php

if(isset($_POST['sub_logout'])){
    session_start();
    session_unset();
    header('location:login.php');
}



if(isset($_POST['ins_vote'])){
    if(isset($_POST['candidate_id'])){
    $id_can = $_POST['candidate_id'];
    $id_use = $_SESSION['user']['id'];
    require_once('db/db_connection.php');
    $re_up = mysqli_query($conn,"UPDATE voters SET status='voted' WHERE id=$id_use");
    if($re_up){
        $result = mysqli_query($conn, "insert into votes(candidate_id,user_id)value('$id_can','$id_use')");
        if ($result) {
            session_start();
            $_SESSION['vote']=[
                'id'=>$id_use,
                'id_cand'=>$id_can,
            ];
            header('location: Vote.php');
            exit;
        }else {echo "Error: " . mysqli_error($conn);}
        mysqli_close($conn);
    }else{echo "Error : " . mysqli_error($conn);}

    } else {
        echo '<div class="alert alert-danger" role="alert">يرجى تحديد احد المرشحين</div>';
    }

}

?>