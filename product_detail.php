<?php
include('includes/header.php');

// Fetch product data
if (isset($_GET['proid'])) {
    $proid = $_GET['proid'];
    $productquery = $pdo->prepare("SELECT * FROM products WHERE product_id = :proid");
    $productquery->bindParam('proid', $proid);
    $productquery->execute();
    $productdata = $productquery->fetch(PDO::FETCH_ASSOC);

    // Fetch total reviews count
    $reviewCountQuery = $pdo->prepare("SELECT COUNT(*) as review_count FROM reviews WHERE pro_id = :proid");
    $reviewCountQuery->bindParam('proid', $proid);
    $reviewCountQuery->execute();
    $reviewCount = $reviewCountQuery->fetch(PDO::FETCH_ASSOC)['review_count'];

    // Fetch all reviews
    $reviewsQuery = $pdo->prepare("SELECT reviews.*, users.name, users.image FROM reviews JOIN users ON reviews.user_id = users.user_id WHERE reviews.pro_id = :proid");
    $reviewsQuery->bindParam('proid', $proid);
    $reviewsQuery->execute();
    $reviews = $reviewsQuery->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Product Detail</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="Dashboard/img/productimages/<?php echo $productdata['image']; ?>" alt="Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3><?php echo $productdata['name']; ?></h3>

                <div class="d-flex mb-3">
                    <?php
                    if ($productdata['availibility'] == "In Stock") {
                        echo "<p class='pt-1 text-success'>In Stock</p>";
                    } else {
                        echo "<p class='pt-1 text-danger'>Out Of Stock</p>";
                    }
                    ?>
                </div>

                <h3 class="font-weight-semi-bold mb-4">Rs <?php echo $productdata['price']; ?></h3>

                <p class="mb-4">
                    <?php echo $productdata['short_info']; ?>
                </p>

                <!-- Condition if user product already exists in cart what to do and vice versa query starts -->
                <?php
                $cartcheckquery = $pdo->prepare("SELECT * FROM cart WHERE pro_id = :pro_id AND user_id = :user_id");
                $cartcheckquery->bindParam('pro_id', $_GET['proid']);
                $cartcheckquery->bindParam('user_id', $_SESSION['userid']);
                $cartcheckquery->execute();
                $product_in_cart = $cartcheckquery->rowCount();

                if ($product_in_cart > 0) {
                    echo "<div class='alert alert-success' role='alert'>Product already in the cart</div>";
                } else {
                    if ($productdata['availibility'] == "Out Of Stock") {
                        echo "<div class='alert alert-danger' role='alert'>Product is Out Of Stock</div>";
                    } else {
                        ?>
                       

                            <!-- --Condition if there is admin dont let him add to cart query starts -->
                             <?php
                             if(isset($_SESSION['adname'])){
                                ?>
                                <div class="alert alert-dark">✖️ Admin You cant product add to cart</div>
                                <?php
                             }
                             else{
                                ?>
                                
                                 <!-- Add to Cart Form -->
                        <form action="Code.php" method="POST">
                            <div class="d-flex align-items-center mb-4 pt-2">
                                <div class="input-group quantity mr-3" style="width: 130px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" name="quantity" class="form-control bg-secondary border-0 text-center" value="1" min="1">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <?php if (isset($_SESSION['username'])): ?>
                                    <input type="hidden" name="pro_id" value="<?php echo $productdata['product_id']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $productdata['price']; ?>">
                                    <button type="submit" class="btn btn-primary px-3" name="add_to_cart"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                                <?php else: ?>
                                    <a href="signin.php">
                                        <button type="button" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                        <!-- Add to Cart Form Ends -->

                                <?php
                             }
                             ?>
                            <!-- --Condition if there is admin dont let him add to cart query ends -->



                        <?php
                    }
                }
                ?>
                <!-- Condition if user product already exists in cart what to do and vice versa query ends -->
            </div>
        </div>
    </div>

    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Reviews (<?php echo $reviewCount; ?>)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p><?php echo $productdata['description']; ?></p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <div class="row">
                            <div class="col-lg-12" style="height:250px; overflow-y:scroll;">
                                <?php
                                if ($reviewCount > 0) {
                                    foreach ($reviews as $review) {
                                        // User details including image
                                        $userRating = $review['rating'];

                                        ?>
                                        <div class='alert alert-dark mb-3 d-flex align-items-center'>
                                        <img src='Dashboard/img/userimages/<?php echo $review['image'] ?>' alt='" . $userName . "' class='m-3' style='width: 60px; height: 60px;'>
                                        <div>
                                        <h6 class='mb-1'><?php  echo $review['name'] ?> </h6>
                                        <h6 class='mb-1'><?php  echo $review['review'] ?></h6>
                                        <p class='mb-0'>
                                            <?php  
                                                if($userRating == 5){
                                                    echo "⭐⭐⭐⭐⭐";
                                                }
                                                elseif($userRating == 4){
                                                    echo "⭐⭐⭐⭐";
                                                }
                                                elseif($userRating == 3){
                                                    echo "⭐⭐⭐";
                                                }
                                                elseif($userRating == 2){
                                                    echo "⭐⭐";
                                                }
                                                else{
                                                    echo "⭐";
                                                }
                                            ?>
                                        </p>

                                        </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<div class='alert alert-light'>No reviews yet.</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<?php
include('includes/footer.php');
?>
