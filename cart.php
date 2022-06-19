<?php include('header.php') ?>

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Cart Page</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="cart.php">cart</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area" style="padding-top: 0px; !important">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php
                        if(!empty($_SESSION['cart'])):
                    ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $total = 0;
                                    foreach($_SESSION['cart'] as $key => $qty):
                                        $id = str_replace('id', '', $key);

                                        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
                                        $stmt->execute();

                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $total += $result['price'] * $qty;
                                    
                                ?>
                                    
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="admin/images/<?php echo escape($result['image']); ?>" style="width:100px; height: 100px; object-fit: cover; !important">
                                                </div>
                                                <div class="media-body">
                                                    <p><?php echo escape($result['name']) ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5><?php echo escape($result['price']) ?></h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                                <input type="text" value='<?php echo $qty ?>' title="Quantity:" class="input-text qty" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <h5><?php echo escape($result['price']) * $qty ?></h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="cart_item_clear.php?pid=<?php echo escape($result['id']) ?>"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                <?php endforeach ?>
                                
                                <tr class="bg-light">
                                    <td></td>
                                    <td></td>
                                    <td><h5>Subtotal</h5></td>
                                    <td>
                                        <h5><?php echo $total ?></h5>
                                    </td>
                                    <td></td>
                                </tr>
                                
                                <tr class="out_button_area">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner d-flex align-items-center" style="margin-left: -450px; !important">
                                            <a class="gray_btn"  href="clearAll.php" style="background-color:#666666; color:#f9f9ff; !important">Clear All</a>
                                            <a class="gray_btn" href="index.php">Continue Shopping</a>
                                            <a class="primary-btn" href="sale_order.php">Order Submit</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="container text-center">
                            <h3 class="text-warning">There is no order data.</h3>  
                         </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
<?php include('footer.php') ?>
