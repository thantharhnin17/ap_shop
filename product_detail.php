<?php include('header.php') ?>
<?php
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!--================Single Product Area =================-->
<div class="product_image_area" style="padding-top: 0px; !important">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
      <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($result['image']); ?>" style="width: 500px; object-fit: cover; !important">
          </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($result['name']); ?></h3>
          <h2><?php echo escape($result['price']); ?> MMK</h2>
          <ul class="list">
            <li><a class="active" href="index.php?category_id=<?php echo $result['category_id']; ?>">
            <?php
              $cat_stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$result['category_id'] );
              $cat_stmt->execute();
            
              $cat_result = $cat_stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <span>Category</span> : <?php echo escape($cat_result['name']); ?></a></li>
            <li><a href="#"><span>Availibility</span> : <?php echo escape($result['quantity']); ?> (In Stock)</a></li>
          </ul>
          <p><?php echo escape($result['description']); ?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="<?php echo escape($result['quantity']); ?>" value="1" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
             class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
            <a class="primary-btn" href="index.php">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
