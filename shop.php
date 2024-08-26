<?php
include('includes/header.php');

// Get category ID and subcategory ID from GET parameters
$cat_id = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$subcat_id = isset($_GET['scid']) ? intval($_GET['scid']) : 0;

// Build the base query and parameters array
$query = "SELECT p.*, c.name AS category_name, s.name AS subcategory_name 
          FROM products p 
          JOIN categories c ON p.cat_id = c.category_id 
          JOIN subcategories s ON p.subcat_id = s.subcategory_id 
          WHERE p.status = 1";
$params = [];

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

// Fetch category and subcategory names for breadcrumb
$category_name = 'All Products';
$subcategory_name = '';

// Fetch category name if category ID is provided
if ($cat_id > 0) {
    $categoryQuery = "SELECT name FROM categories WHERE category_id = ?";
    $categoryStmt = $pdo->prepare($categoryQuery);
    $categoryStmt->execute([$cat_id]);
    $category = $categoryStmt->fetch();
    $category_name = $category ? $category['name'] : 'Unknown';
}

// Fetch subcategory name if subcategory ID is provided
if ($subcat_id > 0) {
    $subcategoryQuery = "SELECT name FROM subcategories WHERE subcategory_id = ?";
    $subcategoryStmt = $pdo->prepare($subcategoryQuery);
    $subcategoryStmt->execute([$subcat_id]);
    $subcategory = $subcategoryStmt->fetch();
    $subcategory_name = $subcategory ? $subcategory['name'] : 'Unknown';
}
?>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item text-danger"><?php echo($category_name); ?></span>
                <?php if ($subcategory_name): ?>
                    <span class="breadcrumb-item text-danger"><?php echo($subcategory_name); ?></span>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
           <!-- Search bar -->
        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Search</span></h5>
        <div class="bg-light p-4 mb-30">
            <form id="search-form">
                <div class="form-group">
                    <label for="search">Search</label>
                    <input id="search-input" class="form-control" type="text" name="search" placeholder="Filter by Search">
                </div>
            </form>
        </div>


            <!-- Price Start -->
            <!-- <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="input-group">
                            <input type="number" class="form-control" id="min-price" placeholder="Min">
                            <span class="input-group-text bg-warning">to</span>
                            <input type="number" class="form-control" id="max-price" placeholder="Max">
                        </div>
                    </div>
                </form>
            </div> -->
            <!-- Price End -->


        </div>
        <!-- Shop Sidebar End -->

     <!-- Shop Product Start -->
<div class="col-lg-9 col-md-8">
    <div id="product-list" class="row pb-3 mt-3">
        <!-- Products will be loaded here by AJAX -->
    </div>
</div>
<!-- Shop Product End -->

    </div>
</div>
<!-- Shop End -->

<?php
include('includes/footer.php');
?>


<!-- Ajax -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function loadProducts() {
        let query = $('#search-input').val();
        
        $.ajax({
            url: 'search_products.php',
            type: 'GET',
            data: {
                search: query,
                cid: <?php echo $cat_id; ?>,
                scid: <?php echo $subcat_id; ?>,
            },
            success: function(response) {
                $('#product-list').html(response);
            },
            error: function() {
                $('#product-list').html('<p>Error retrieving products.</p>');
            }
        });
    }

    $('#search-input').on('keyup', loadProducts);

    $('#apply-price-filter').on('click', function() {
        loadProducts();
    });

    // Initial load
    loadProducts();
});

function toggleWishlist(productId) {
    $.ajax({
        url: 'wishlist.php',
        type: 'POST',
        data: {
            product_id: productId
        },
        success: function(response) {
            alert(response.message);
            if (response.added) {
                $('#heart-' + productId).removeClass('text-white').addClass('text-danger');
            } else {
                $('#heart-' + productId).removeClass('text-danger').addClass('text-white');
            }
        },
        error: function() {
            alert('Error handling wishlist.');
        }
    });
}
</script>