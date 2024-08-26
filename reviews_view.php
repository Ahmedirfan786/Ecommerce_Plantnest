<?php
include('includes/header.php');

$userId = $_SESSION['userid'];

// Query to get reviews for the logged-in user
$sql = "
    SELECT 
        r.review_id, 
        r.review, 
        r.rating, 
        o.order_id, 
        p.name AS product_name, 
        o.quantity AS product_qty, 
        p.image AS product_image
    FROM reviews r
    JOIN orders o ON r.order_id = o.order_id
    JOIN products p ON r.pro_id = p.product_id
    WHERE r.user_id = ?
";

// Prepare and execute the statement
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);

$reviews = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-3">
            <h3>My Reviews</h3>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>Review Id</th>
                            <th>Order Id</th>
                            <th>Product Name</th>
                            <th>Product Qty</th>
                            <th>Product Image</th>
                            <th>Review</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                        <tr class="bg-light">
                            <td><?php echo $review['review_id']; ?></td>
                            <td><?php echo $review['order_id']; ?></td>
                            <td><?php echo $review['product_name']; ?></td>
                            <td><?php echo $review['product_qty']; ?></td>
                            <td>
                                <img src="Dashboard/img/productimages/<?php echo $review['product_image']; ?>" alt="Product Image" style="width: 100px;">
                            </td>
                            <td><?php echo $review['review']; ?></td>
                            <td><?php echo str_repeat('⭐', $review['rating']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>
