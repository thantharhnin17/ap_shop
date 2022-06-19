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

  if($_POST){
    
    if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category']) 
        || empty($_POST['quantity']) || empty($_POST['price'])){
        if(empty($_POST['name'])){
           $nameError = "Name is required"; 
        }
        if(empty($_POST['description'])){
            $descError = "Description is required"; 
        }
        if(empty($_POST['category'])){
            $catError = "Category is required"; 
        }
        if(empty($_POST['quantity'])){
            $qtyError = "Quantity is required"; 
        }elseif(is_numeric($_POST['quantity']) != 1){
            $qtyError = "Quantity must be number"; 
        }
        if(empty($_POST['price'])){
            $priceError = "Price is required"; 
        }elseif(is_numeric($_POST['price']) != 1){
            $priceError = "Price must be number"; 
        }
    }
    
    else{ //validation success
        if(is_numeric($_POST['quantity']) != 1){
          $qtyError = "Quantity must be number"; 
        }
        if(is_numeric($_POST['price']) != 1){
          $priceError = "Price must be number"; 
        }

        if($qtyError == '' && $priceError == ''){
          
          if($_FILES['image']['name']){
            $file = 'images/'.($_FILES['image']['name']);
            $imageType = pathinfo($file,PATHINFO_EXTENSION);
            
            if($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png'){
                $imageError = "Image should be jpg, jpeg or png";
            }else{ //image validation success
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $category = $_POST['category'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $image = $_FILES['image']['name'];

                move_uploaded_file($_FILES['image']['tmp_name'],$file);

                $stmt = $pdo->prepare("UPDATE products SET name='$name', description='$description', category_id='$category',
                                                            quantity='$quantity', price='$price',image='$image' WHERE id='$id'");
                $result = $stmt->execute();

                if($result){
                    echo "<script>alert('Product Is Successfully Updated'); window.location.href='index.php';</script>";
                }
            }
            }else{
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $category = $_POST['category'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                    
                $stmt = $pdo->prepare("UPDATE products SET name='$name', description='$description', category_id='$category',
                                                                quantity='$quantity', price='$price' WHERE id='$id'");
                $result = $stmt->execute();

                if($result){
                        echo "<script>alert('Product Is Successfully Updated'); window.location.href='index.php';</script>";
                }
            }
        }
        

    }
      
  }

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
  $stmt->execute();

  $result = $stmt->fetchAll();

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
                <h3 class="card-title">Edit Product</h3>
              </div>

              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <!-- csrf -->
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">       

                  <input name="id" type="hidden" value="<?php echo $result[0]['id']; ?>">       
                               
                  <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"  value="<?php echo escape($result[0]['name']); ?>">
                        <div class="form-text text-danger"><?php echo empty($nameError) ? '': '*'.$nameError; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="10"><?php echo escape($result[0]['description']); ?></textarea>
                        <div class="form-text text-danger"><?php echo empty($descError) ? '': '*'.$descError; ?></div>
                    </div>

                    <?php
                      $cat_stmt = $pdo->prepare("SELECT * FROM categories");
                      $cat_stmt->execute();
                      $cat_result = $cat_stmt->fetchAll();
                    ?>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control form-select" name="category">
                            <option value="" selected>Select Category</option>
                            <?php
                                foreach($cat_result as $cat_value){
                            ?>
                                <?php if($cat_value['id'] == $result[0]['category_id']):?>
                                    <option value="<?php echo $cat_value['id'] ?>" selected><?php echo $cat_value['name'] ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $cat_value['id'] ?>"><?php echo $cat_value['name'] ?></option>
                                <?php endif ?>
                            <?php } ?>
                        </select>
                        <div class="form-text text-danger"><?php echo empty($catError) ? '': '*'.$catError; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity"  value="<?php echo escape($result[0]['quantity']); ?>">
                        <div class="form-text text-danger"><?php echo empty($qtyError) ? '': '*'.$qtyError; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price"  value="<?php echo escape($result[0]['price']); ?>">
                        <div class="form-text text-danger"><?php echo empty($priceError) ? '': '*'.$priceError; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label><br>
                        <img src="images/<?php echo escape($result[0]['image']); ?>" width="150" height="150"><br><br>
                        <input type="file" name="image" value="">
                        <div class="form-text text-danger"><?php echo empty($imageError) ? '': '*'.$imageError; ?></div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Submit</button>
                      <a href="index.php" class="btn btn-warning">Back</a>
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
