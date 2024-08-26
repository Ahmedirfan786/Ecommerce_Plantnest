<?php
session_start();

include('Dashboard/connection.php');


// Get category ID, subcategory ID, and search query from GET parameters
$cat_id = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$subcat_id = isset($_GET['scid']) ? intval($_GET['scid']) : 0;
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Build the base query and parameters array
$query = "SELECT p.*, c.name AS category_name, s.name AS subcategory_name 
          FROM products p 
          JOIN categories c ON p.cat_id = c.category_id 
          JOIN subcategories s ON p.subcat_id = s.subcategory_id 
          WHERE p.status = 1 AND p.name LIKE ?";
$params = [$search];

// Modify the query based on parameters
if ($cat_id > 0) {
    $query .= " AND p.cat_id = ?";
    $params[] = $cat_id;
}
if ($subcat_id > 0) {
    $query .= " AND p.subcat_id = ?";
    $params[] = $subcat_id;
}

// Fetch products from the database
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!-- Product Listings -->
<div class="container" style="max-height: 600px; overflow-y: auto;">
    <div class="row">
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
            <div class="col-lg-3 col-md-6 col-sm-6 pb-1">
                <div class="product-item mb-4" style="background-color: #E3DFD8;">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="w-100" src="Dashboard/img/productimages/<?php echo htmlspecialchars($product['image']); ?>"
                        height="160px"  alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="product_detail.php?proid=<?php echo urlencode($product['product_id']); ?>">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>Rs <?php echo htmlspecialchars($product['price']); ?></h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <!-- Condition on availability In Stock / Out Of Stock -->
                            <?php if ($product['availibility'] == "In Stock"): ?>
                                <small class="text-success"><?php echo htmlspecialchars($product['availibility']); ?></small>
                            <?php else: ?>
                                <small class="text-danger"><?php echo htmlspecialchars($product['availibility']); ?></small>
                            <?php endif; ?>

                            <!-- Condition not to show wishlist heart to admin query starts-->
                                <?php
                                if(!isset($_SESSION['adname'])){
                                    ?>
                                    <!-- Wishlist heart -->
                            <?php if(isset($_SESSION['username'])): ?>
                                <?php
                                // Check if the product is in the user's wishlist
                                $user_id = $_SESSION['userid'];
                                $stmt = $pdo->prepare("SELECT * FROM wishlist WHERE pro_id = ? AND user_id = ?");
                                $stmt->execute([$product['product_id'], $user_id]);
                                $is_in_wishlist = $stmt->fetch();
                                ?>
                                <form method="POST" action="wishlist_action.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button type="submit" name="action" value="<?php echo $is_in_wishlist ? 'remove' : 'add'; ?>" class="btn">
                                        <i class="fa-solid fa-heart <?php echo $is_in_wishlist ? 'text-danger' : 'text-white'; ?> fa-1x ml-2"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="#" onclick="redirectToSignin();">
                                    <i class="fa-solid fa-heart text-white fa-1x ml-2"></i>
                                </a>
                            <?php endif; ?>
                            <!-- Wishlist heart -->
                                    <?php
                                }
                                ?>
                            <!-- Condition not to show wishlist heart to admin query ends-->

                            
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p>No products found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function redirectToSignin() {
        alert('To add product to wishlist, please sign in first.');
        window.location.href = 'signin.php';
    }
</script>
