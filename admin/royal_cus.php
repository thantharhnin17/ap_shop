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
                <h3 class="card-title">Royal Customers Report</h3>
              </div>

              <?php

                $stmt = $pdo->prepare("SELECT user_id,SUM(total_price) AS total_amount FROM sale_orders GROUP BY user_id HAVING SUM(total_price)>=100000 ORDER BY SUM(total_price) DESC;");
                $stmt->execute();
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
                        <td><?php echo escape($value['total_amount']); ?></td>
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
