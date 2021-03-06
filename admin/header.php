
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AP Shopping | Admin Panel</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- datatables.net -->
  <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <?php        
      $link = $_SERVER['PHP_SELF'];
      $link_array = explode('/',$link);
      $page = end($link_array);
    ?>
    
    <?php if($page == "index.php" || $page == "category.php" || $page == "user.php"): ?>
      <!-- SEARCH FORM -->
      <form class="form-inline ml-3" method="post"
      <?php if($page == 'index.php'): ?>
        action = 'index.php'
      <?php elseif($page == 'category.php'): ?>
        action = 'category.php'
      <?php elseif($page == 'user.php'): ?>
        action = 'user.php'
      <?php endif ?>
      >
        <!-- csrf -->
        <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">  

        <div class="input-group input-group-sm">
          <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"
          value="<?php if(empty($_POST['search']) && empty($_COOKIE['search'])) {echo '';} else{ echo isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];}  ?>">
          <!-- echo isset($_POST['search']) ? $_POST['search'] : '';  -->
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    <?php endif ?>

    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <!-- User image -->
         <div class="rounded-circle bg-light text-black text-center float-left img-circle elevation-2 ml-3" style="width:30px; height:30px;opacity: .8;">
              <span class="fas fa-user" style="margin-top: 5px;"></span>
          </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['name'] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="./index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Products
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="./category.php" class="nav-link">
              <i class="nav-icon fa fa-list"></i>
              <p>
                Categories
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="./user.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="./order_list.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Orders
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="report_cal.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sale Report By Calendar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="weekly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="royal_cus.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_seller.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Seller Items</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script>
    function showPassword() {
      var x = document.getElementById("pass");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>