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
                <h3 class="card-title">Sale Order Listings</h3>
              </div>

              <?php

                if(!empty($_GET['pageno'])){
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }
                $numOfRecs = 5;
                $offset = ($pageno - 1) * $numOfRecs;

                
                  $stmt = $pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id='$_GET[id]' ORDER BY id DESC");
                  $stmt->execute();
                  $raw_result = $stmt->fetchAll();
                  $total_pages = ceil(count($raw_result) / $numOfRecs);

                  $stmt = $pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id='$_GET[id]' ORDER BY id DESC LIMIT $offset,$numOfRecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
              ?>

              <!-- /.card-header -->
              <div class="card-body">
                
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  <?php
                      if($result){
                        if(!empty($_GET['pageno'])){
                          $i = $offset+1;
                        }else{
                          $i = 1;
                        }
                        
                        foreach($result as $value){
                    ?>

                    <?php
                      $p_stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                      $p_stmt->execute();
                      $p_result = $p_stmt->fetchAll();
                    ?>

                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo escape($p_result[0]['name']); ?></td>
                      <td><?php echo escape($value['quantity']); ?></td>
                      <td><?php echo escape(date('Y-m-d', strtotime($value['order_date']))); ?></td>
                      
                    </tr>
                       
                    <?php
                    $i++;
                        }
                      }
                    ?>
                    
                  </tbody>
                </table>
                      <br>

                <div>
                  <a href="order_list.php" class="btn btn-secondary float-left">Back to order lists</a>
                </div>

                <nav aria-label="Page navigation example" class="float-right">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link" href="?pageno=1">
                        First
                      </a>
                    </li>
                    <li class="page-item <?php if($pageno <= 1){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1){ echo '#';}else{ echo "?pageno=".($pageno-1); } ?>">
                        Previous
                      </a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">
                        <?php echo $pageno; ?>
                      </a>
                    </li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo "?pageno=".($pageno+1); } ?>">
                        Next
                      </a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="?pageno=<?php echo $total_pages ?>">
                        Last
                      </a>
                    </li>
                  </ul>
                </nav>

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
