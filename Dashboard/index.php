<?php
include('header.php');


// Fetching counts
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalCategories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$totalSubcategories = $pdo->query("SELECT COUNT(*) FROM subcategories")->fetchColumn();
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalReviews = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
$totalFeedbacks = $pdo->query("SELECT COUNT(*) FROM feedbacks")->fetchColumn();

?>
            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4 mb-5">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-users fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Users</p>
                                <h6 class="mb-0"><?php echo $totalUsers; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa-solid fa-cart-shopping fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Categories</p>
                                <h6 class="mb-0"><?php echo $totalCategories; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa-regular fa-cart-shopping fa-3x text-primary"></i>                            
                        <div class="ms-3">
                                <p class="mb-2">Subcategories</p>
                                <h6 class="mb-0"><?php echo $totalSubcategories; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa-solid fa-bag-shopping fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Products</p>
                                <h6 class="mb-0"><?php echo $totalProducts; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa-regular fa-truck fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Orders</p>
                                <h6 class="mb-0"><?php echo $totalOrders; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa-solid fa-pen fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Reviews</p>
                                <h6 class="mb-0"><?php echo $totalReviews; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa-solid fa-comments fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Feedbacks</p>
                                <h6 class="mb-0"><?php echo $totalFeedbacks; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->

<?php
include('footer.php');
?>
