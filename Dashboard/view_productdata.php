<?php
include('header.php');

// Fetch the product ID from the URL
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';

if ($product_id) {
    // Fetch the product details from the database
    $sql = "
        SELECT p.product_id, 
               p.name AS product_name, 
               p.image, 
               p.price, 
               p.short_info, 
               p.description, 
               p.availibility, 
               p.status, 
               c.name AS category_name, 
               s.name AS subcategory_name 
        FROM products p
        INNER JOIN subcategories s ON p.subcat_id = s.subcategory_id
        INNER JOIN categories c ON s.cat_id = c.category_id
        WHERE p.product_id = :product_id
    ";

    $query = $pdo->prepare($sql);
    $query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $query->execute();
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        ?>
        <div class="container-fluid pt-4 px-4">
            <div class="row bg-light mx-0">
                <div class="col-md-12 p-4 mb-3">
                    <h3 class="mb-3">Product Details</h3>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Product ID</th>
                                <td><?php echo $product['product_id']; ?></td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td><?php echo $product['product_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td><img src="img/productimages/<?php echo $product['image']; ?>" width="100px" height="100px" alt=""></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td><?php echo $product['price']; ?></td>
                            </tr>
                            <tr>
                                <th>Short Info</th>
                                <td><?php echo $product['short_info']; ?></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td><?php echo $product['description']; ?></td>
                            </tr>
                            <tr>
                                <th>Availability</th>
                                <td><?php echo $product['availibility']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo ($product['status'] == 1) ? 'Enabled' : 'Disabled'; ?></td>
                            </tr>
                            <tr>
                                <th>Category Name</th>
                                <td><?php echo $product['category_name']; ?></td>
                            </tr>
                            <tr>
                                <th>SubCategory Name</th>
                                <td><?php echo $product['subcategory_name']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="view_products.php" class="btn btn-primary">Back to Products</a>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='container'><p>Product not found.</p></div>";
    }
} else {
    echo "<div class='container'><p>Invalid product ID.</p></div>";
}

include('footer.php');
?>
