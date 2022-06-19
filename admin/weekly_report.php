<?php

  session_start();
  require '../config/config.php';
  require "../config/common.php";

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location: ./login.php');
  }
  if($_SESSION['role'] != 1){
    header('Location: ./login.php');
  }
  if(isset($_POST['search'])){
    setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
  }else{
    if(empty($_GET['pageno'])){
      unset($_COOKIE['search']); 
      setcookie('search', null, -1, '/'); 
    }
  }

?>

<?php
  include 'header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Weekly Report</h3>
              </div>

              <?php

                $currentDate = date("Y-m-d");

                $from_date = date("Y-m-d",strtotime($currentDate . '+1 day'));
                $to_date = date("Y-m-d",strtotime($currentDate . '-7 day'));

                $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE order_date<:from_date AND order_date>=:to_date ORDER BY id DESC");
                $stmt->execute([':from_date'=>$from_date, ':to_date'=>$to_date]);
                $result = $stmt->fetchAll(); 

              ?>

              <!-- /.card-header -->
              <div class="card-body">
                <br>
                <table class="table table-bordered" id="d-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User</th>
                      <th>Total Amount</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                      if($result){
                        $i = 1;
                        foreach($result as $value){
                    ?>

                    <?php
                      $user_stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                      $user_stmt->execute();
                      $user_result = $user_stmt->fetchAll();
                    ?>

                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo escape($user_result[0]['name']); ?></td>
                        <td><?php echo escape($value['total_price']); ?></td>
                        <td><?php echo escape(date("Y-m-d", strtotime($value['order_date']))); ?></td>
                        </tr>

                    <?php
                    $i++;
                        }
                      }
                    ?>

                  </tbody>
                </table>
                      <br>

              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.php' ?>

  <script>
    $(document).ready(function () {
        $('#d-table').DataTable();
    });
  </script>

  
<script>
  $( function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker1" ).datepicker();
  } );
</script>
