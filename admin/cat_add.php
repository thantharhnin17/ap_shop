<?php

  session_start();

  require '../config/config.php';
  require "../config/common.php";

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location: login.php');
  }
  if($_SESSION['role'] != 1){
    header('Location: login.php');
  }

  if($_POST){
    
    if(empty($_POST['name']) || empty($_POST['description'])){
        if(empty($_POST['name'])){
           $nameError = "Please fill category's name"; 
        }
        if(empty($_POST['description'])){
            $descError = "Please fill category's description"; 
         }
    }else{
        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO categories(name,description) VALUES (?,?)");
        $result = $stmt->execute([$name,$description]);

        if($result){
            echo "<script>alert('Category Successfully Added'); window.location.href='category.php';</script>";
        }
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
                <h3 class="card-title">Create New Post</h3>
              </div>

              <div class="card-body">
                <form action="cat_add.php" method="post" enctype="multipart/form-data">
                  <!-- csrf -->
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">       
                               
                  <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"  value="<?php echo escape($_POST['name'] ?? ''); ?>">
                        <div class="form-text text-danger"><?php echo empty($nameError) ? '': '*'.$nameError; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="10"><?php echo escape($_POST['description'] ?? ''); ?></textarea>
                        <div class="form-text text-danger"><?php echo empty($descError) ? '': '*'.$descError; ?></div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Submit</button>
                      <a href="category.php" class="btn btn-warning">Back</a>
                    </div>
                </form>
              </div>
              
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
