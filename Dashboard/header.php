<?php
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">


    <!-- Pro Font Awesome Link -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="../index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Dashboard</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="./img/adminimages/<?php echo $_SESSION['adimage']?>" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">
                        <!-- Displaying admin name query start -->
                        <?php
                            echo $_SESSION['adname']; 
                        ?>
                         <!-- Displaying admin name query end -->
                        </h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">

                    <!-- Index -->
                    <a href="#" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    
                    
                    <!-- Categories -->
                    <div class="nav-item dropdown">

                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-cart-shopping me-2"></i>Categories</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="view_categories.php" class="dropdown-item">View Catgory</a>
                        <a href="add_category.php" class="dropdown-item">Add Catgory</a>
                    </div>
                </div>

                <!-- Sub Categories -->
                <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-regular fa-cart-shopping me-2"></i>Subcategory</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="view_subcategories.php" class="dropdown-item">View Subcategories</a>
                            <a href="add_subcategory.php" class="dropdown-item">Add Subcategory</a>
                        </div>
                </div>

                <!-- Products -->
                <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-bag-shopping me-2"></i>Products</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="view_products.php" class="dropdown-item">View Products</a>
                            <a href="add_product.php" class="dropdown-item">Add Product</a>
                        </div>
                </div>
                

                 <!-- Orders -->
                 <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-regular fa-truck me-2"></i>Orders</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="view_pending_orders.php" class="dropdown-item">View Pending Orders</a>
                            <a href="view_approved_orders.php" class="dropdown-item">View Approved Orders</a>
                            <a href="view_rejected_orders.php" class="dropdown-item">View Rejected Orders</a>
                            <a href="view_ontheway_orders.php" class="dropdown-item">View On the Way Orders</a>
                            <a href="view_delivered_orders.php" class="dropdown-item">View Delivered Orders</a>
                            <a href="view_cancelled_orders.php" class="dropdown-item">User Canceled Orders</a>
                        </div>
                </div>


                <!-- Users -->
                <a href="view_users.php" class="nav-item nav-link"><i class="fa-solid fa-users me-2"></i>Users</a>
                
                <!-- Reviews -->
                <a href="view_reviews.php" class="nav-item nav-link"><i class="fa-solid fa-pen me-2"></i>Reviews</a>
                

                <!-- Feedbacks -->
                <a href="view_feedbacks.php" class="nav-item nav-link"><i class="fa-solid fa-comments me-2"></i>Feedbacks</a>
                
               
                   
                
                
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                   <!-- Back to Website Button -->
    <div class="navbar-nav me-auto">
        <a href="../index.php" class="nav-item nav-link d-flex align-items-center">
            <i class="fa fa-home me-2"></i>Back to Website
        </a>
    </div>
               
                <div class="navbar-nav align-items-center ms-auto">
                  
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="./img/adminimages/<?php echo $_SESSION['adimage']?>" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">

                                <!-- Displaying admin name query start -->
                        <?php
                            echo $_SESSION['adname']; 
                        ?>
                         <!-- Displaying admin name query end -->
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="manage_profile.php" class="dropdown-item">Manage Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

