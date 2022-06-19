<?php include('header.php') ?>
			<?php

				if(isset($_POST['search'])){
					setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
				}else{
					if(empty($_GET['pageno'])){
					unset($_COOKIE['search']); 
					setcookie('search', null, -1, '/'); 
					}
				}

                if(!empty($_GET['pageno'])){
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }
                $numOfRecs = 6;
                $offset = ($pageno - 1) * $numOfRecs;

                if(empty($_POST['search']) && empty($_COOKIE['search'])){
					if(!empty($_GET['category_id'])){
						$category_id = $_GET['category_id'];
						$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id='$category_id' AND quantity > 0  ORDER BY id DESC");
						$stmt->execute();
						$raw_result = $stmt->fetchAll();
						$total_pages = ceil(count($raw_result) / $numOfRecs);

						$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id='$category_id' AND quantity > 0  ORDER BY id DESC LIMIT $offset,$numOfRecs");
						$stmt->execute();
						$result = $stmt->fetchAll();
					}else{
						$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
						$stmt->execute();
						$raw_result = $stmt->fetchAll();
						$total_pages = ceil(count($raw_result) / $numOfRecs);

						$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfRecs");
						$stmt->execute();
						$result = $stmt->fetchAll();
					}
                  
                }else{
                  $search_key = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
                  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search_key%' AND quantity > 0 ORDER BY id DESC");
                  $stmt->execute();
                  $raw_result = $stmt->fetchAll();
                  $total_pages = ceil(count($raw_result) / $numOfRecs);

                  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search_key%' AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfRecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                }
            ?>

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb" style="margin-bottom: 50px; !important">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Welcome <?php echo $_SESSION['userName'] ?></h1>

				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">

						<?php
							$cat_stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
							$cat_stmt->execute();
							$cat_result = $cat_stmt->fetchAll();
						?>

						<?php foreach($cat_result as $key => $value){ ?>

						<li class="main-nav-list">
							<a href="index.php?category_id=<?php echo $value['id']; ?>"><?php echo escape($value['name']); ?></a>
						</li>

						<?php } ?>
					</ul>
				</div>
			</div>
			
			<div class="col-xl-9 col-lg-8 col-md-7">

				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="pagination">

						<a href="?pageno=1" class="active">First</a>

						<a <?php if($pageno <= 1){ echo 'disabled';} ?>
						 href="<?php if($pageno <= 1){ echo '#';}else{ echo "?pageno=".($pageno-1); } ?>" 
						 class="prev-arrow">
						 <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
						</a>

						<a href="#" class="active"><?php echo $pageno; ?></a>

						<a <?php if($pageno >= $total_pages){ echo 'disabled';} ?>
						 href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo "?pageno=".($pageno+1); } ?>" 
						 class="next-arrow">
						 <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						</a>

						<a href="?pageno=<?php echo $total_pages ?>" class="active">Last</a>

					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<?php 
							if($result) {
								foreach($result as $key => $value){
						?>
						<!-- single product -->
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<a href="product_detail.php?id=<?php echo $value['id']; ?>">
									<img class="img-fluid" src="admin/images/<?php echo escape($value['image']); ?>" style="height: 250px; object-fit: cover; !important">
								</a>
								<div class="product-details">
									<h6><?php echo escape($value['name']); ?></h6>
									<div class="price">
										<h6><?php echo escape($value['price']); ?></h6>
									</div>
									<div class="prd-bottom">

										<form action="addToCart.php" method="POST">
											<!-- csrf -->
											<input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>"> 
											<input type="hidden" name="id" value="<?php echo escape($value['id']); ?>">
											<input type="hidden" name="qty" value="1">


											<div class="social-info">
												<button type="submit" class="social-info" style="display: contents;">
													<span class="ti-bag"></span>
													<p class="hover-text" style="left:22px;">add to bag</p>
												</button>
											</div>
											<a href="product_detail.php?id=<?php echo $value['id']; ?>" class="social-info">
												<span class="lnr lnr-move"></span>
												<p class="hover-text">view more</p>
											</a>
										</form>
									</div>
								</div>
							</div>
						</div>
						<?php
								}
							}
						?>
					</div>
				</section>
				<!-- End Best Seller -->
			</div>
		</div>
	</div>

<?php include('footer.php');?>
