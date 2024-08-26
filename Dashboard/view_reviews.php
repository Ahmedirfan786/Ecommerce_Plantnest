<?php
include('header.php');

// Query to fetch reviews, order ID, product name, and user details
$query = "
    SELECT 
        r.review_id, 
        r.review, 
        r.rating, 
        o.order_id, 
        p.name AS product_name, 
        p.image AS product_image,
        u.name AS user_name, 
        u.email
    FROM reviews r
    JOIN orders o ON r.order_id = o.order_id
    JOIN products p ON r.pro_id = p.product_id
    JOIN users u ON r.user_id = u.user_id
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$reviews = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-3">
            <h3>View Reviews</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Review Id</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Order Id</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Review</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?php echo $review['review_id']; ?></td>
                            <td><?php echo $review['user_name']; ?></td>
                            <td><?php echo $review['email']; ?></td>
                            <td><?php echo $review['order_id']; ?></td>
                            <td><?php echo $review['product_name']; ?></td>
                            <td>
                                <img src="img/productimages/<?php echo $review['product_image']; ?>" width="50px" height="50px" alt="">
                            </td>
                            <td><?php echo $review['review']; ?></td>
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
                                        echo "⭐⭐";
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
include('footer.php');
?>
