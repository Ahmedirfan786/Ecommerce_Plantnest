<?php
session_start();
include('Dashboard/connection.php');


    // Fetching categories from the database
    $categoryQuery = $pdo->prepare('SELECT * FROM categories WHERE status = 1');
    $categoryQuery->execute();
    $categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch subcategories from the database
    $subcategoryQuery = $pdo->prepare('SELECT * FROM subcategories WHERE status = 1');
    $subcategoryQuery->execute();
    $subcategories = $subcategoryQuery->fetchAll(PDO::FETCH_ASSOC);
    
    // Organize subcategories by category ID
    $subcategoriesByCategory = [];
    foreach ($subcategories as $sub) {
        $subcategoriesByCategory[$sub['cat_id']][] = $sub;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                    
                    <!-- Check if the user is logged in -->
                    <?php if (isset($_SESSION['username'])): ?>
                        <a class="text-body mr-3" href="feedback.php">Feedback</a>
                        <a class="text-body mr-3" href="contact.php">Contact</a>
                        <a class="text-body mr-3" href="orders_view.php">My Orders</a>
                        <a class="text-body mr-3" href="myreviews_view.php">My Reviews</a>
                        
                    <!-- Check if the user is logged in as an admin -->
                    <?php elseif (isset($_SESSION['adname'])): ?>
                        <a class="text-body mr-3" href="contact.php">Contact</a>
                        
                    <!-- Default links for users who are not logged in -->
                    <?php else: ?>
                        <a class="text-body mr-3" href="feedback.php">Feedback</a>
                        <a class="text-body mr-3" href="contact.php">Contact</a>
                    <?php endif; ?>
                    
                </div>
                
            </div>
            <div class="col-lg-6 text-center text-lg-right">

            <!-- On ADMIN LOgin -->
            <?php
            if(isset($_SESSION['adname'])){
                ?>
                 <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light" data-toggle="dropdown"><?php echo $_SESSION['adname']?></button>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light text-primary">
                        <a href="Dashboard/index.php">
                        <i class="fa-solid fa-home"></i>
                        </a>
                        </button>
                    </div>
                </div>
                <?php
            }
            // On user login
            elseif(isset($_SESSION['username'])){
                ?>
                 <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                            <img src="Dashboard/img/userimages/<?php echo $_SESSION['userimage']?>" width="30px" height="30px" alt="">
                            <?php 
                            echo $_SESSION['username'];
                            ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">
                            <a href="manage_profile.php" class="text-dark">
                                Manage Account</button>
                            </a>    
                            <a href="logout.php" class="text-dark">
                                <button class="dropdown-item" type="button">
                                    Logout</button>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light text-primary">
                        <a href="Dashboard/signin.php">
                        <i class="fa-solid fa-key"></i>
                        </a>
                        </button>
                    </div>
                </div> -->
                <?php
            }
            // On Not admin login
            elseif(!isset($_SESSION['adname']) && !isset($_SESSION['uname'])){
?>
                <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                        Accounts
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">
                        <a href="signin.php" class="text-dark">
                            Sign in</button>
                        </a>    
                        <a href="signup.php" class="text-dark">
                            <button class="dropdown-item" type="button">
                                sign up</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light text-primary">
                    <a href="Dashboard/signin.php">
                    <i class="fa-solid fa-key"></i>
                    </a>
                    </button>
                </div>
            </div>

            <?php   
            }
            
            ?>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Plant</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Nest</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                       <?php foreach ($categories as $category): ?>
    <div class="nav-item dropdown dropright">
        <a href="#" class="nav-link dropdown-toggle" class="ml-2" data-toggle="dropdown">
            <a href="shop.php?cid=<?php echo($category['category_id']); ?>" class="text-dark"><?php echo($category['name']); ?></a> 
            <i class="fa fa-angle-right float-right mt-1"></i>
        </a>
        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
            <?php
            if (isset($subcategoriesByCategory[$category['category_id']])) {
                foreach ($subcategoriesByCategory[$category['category_id']] as $subcategory): ?>
                    <a href="shop.php?cid=<?php echo($category['category_id']); ?>&scid=<?php echo($subcategory['subcategory_id']); ?>" class="dropdown-item">
                        <?php echo($subcategory['name']); ?>
                    </a>
                <?php endforeach;
            }
            ?>
        </div>
    </div>
<?php endforeach; ?>

                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Plant</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Nest</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="shop.php" class="nav-item nav-link">Shop</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <!-- Condintion not to show cart and wishlist heart to admin query starts-->
                         <?php
                         if(isset($_SESSION['username'])){
                            ?>
                                <a href="./wishlist_view.php" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <!-- Fetching the total count of wishlist items of user query starts-->
                                <?php
                                if (isset($_SESSION['username'])) {
                                    // Prepare and execute the query to count wishlist items for the logged-in user
                                    $wlistcountquery = $pdo->prepare('SELECT COUNT(*) FROM wishlist WHERE user_id = :userid');
                                    $wlistcountquery->bindParam(':userid', $_SESSION['userid'], PDO::PARAM_INT);
                                    $wlistcountquery->execute();
                                    
                                    // Fetch the count
                                    $wishlistcount = $wlistcountquery->fetchColumn();
                                } else {
                                    $wishlistcount = 0;
                                }
                                ?>
                                <!-- Fetching the total count of wishlist items of user query ends-->

                                <!-- Displaying the wishlist count in the badge -->
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
                                    <?php echo $wishlistcount; ?>
                                </span>
                            </a>
                            <a href="cart.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>

                                <!-- Fetching the total count of cart items of user query starts-->
                                <?php
                                if (isset($_SESSION['username'])) {
                                    // Prepare and execute the query to count cart items for the logged-in user
                                    $cartcountquery = $pdo->prepare('SELECT COUNT(*) FROM cart WHERE user_id = :userid');
                                    $cartcountquery->bindParam(':userid', $_SESSION['userid']);
                                    $cartcountquery->execute();
                                    
                                    // Fetch the count
                                    $cartcount = $cartcountquery->fetchColumn();
                                } else {
                                    $cartcount = 0;
                                }
                                ?>
                                <!-- Fetching the total count of cart items of user query ends-->
                                 
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
                                    <?php echo $cartcount ?>
                                </span>
                            </a>
                            <?php
                         }
                         else{

                         }
                         ?>
                        <!-- Condintion not to show cart and wishlist heart to admin query ends-->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

