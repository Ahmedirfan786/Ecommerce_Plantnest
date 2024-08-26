<?php
include('includes/header.php');

//Query to fetch data reviews data as per logged in user
$query = "
    SELECT 
        r.review_id, 
        o.order_id, 
        p.name AS product_name, 
        o.quantity AS product_qty, 
        p.image AS product_image, 
        r.review, 
        r.rating
    FROM 
        reviews r
    JOIN 
        orders o ON r.order_id = o.order_id
    JOIN 
        products p ON r.pro_id = p.product_id
    WHERE 
        r.user_id = :user_id"; 

// Prepare and execute query
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['userid']); 
$stmt->execute();

// Fetch all results
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-3">
            <h3>My Reviews</h3>

            <div class="table-responsive">
            <table class="table table-bordered">
    <thead class="bg-primary">
        <tr>
            <th>Review ID</th>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Product Quantity</th>
            <th>Product Image</th>
            <th>Review</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reviews as $review): ?>
            <tr>
                <td><?php echo htmlspecialchars($review['review_id']); ?></td>
                <td><?php echo htmlspecialchars($review['order_id']); ?></td>
                <td><?php echo htmlspecialchars($review['product_name']); ?></td>
                <td><?php echo htmlspecialchars($review['product_qty']); ?></td>
                <td><img src="Dashboard/img/productimages/<?php echo htmlspecialchars($review['product_image']); ?>" alt="Product Image" width="100"></td>
                <td><?php echo htmlspecialchars($review['review']); ?></td>
                <td>
                    <?php
                    if($review['rating'] == 5){
                        echo "⭐⭐⭐⭐⭐";
                    }
                    elseif($review['rating'] == 4){
                        echo "⭐⭐⭐⭐";
                    }
                    elseif($review['rating'] == 3){
                        echo "⭐⭐⭐";
                    }
                    elseif($review['rating'] == 2){
                        echo "⭐⭐";
                    }
                    else{
                        echo "⭐";
                    }
                    ?>
                </td>
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