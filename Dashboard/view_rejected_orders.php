<?php
include('header.php');

// Fetch orders with users data where order status is rejected
$query = "
       SELECT 
    u.user_id, 
    u.name AS user_name, 
    u.email AS user_email, 
    u.address AS user_address, 
    o.order_id, 
    o.price AS order_price, 
    o.quantity AS order_quantity, 
    o.status AS order_status, 
    p.name AS product_name, 
    p.image AS product_image
FROM users u
INNER JOIN orders o ON u.user_id = o.user_id
INNER JOIN products p ON o.pro_id = p.product_id
WHERE o.status = 'Rejected'
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-3">
            <h3>View Rejected Orders</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Order Id</th>
                            <th>User Name</th>
                            <th>User Address</th>
                            <th>Product Name</th>
                            <th>Product Qty</th>
                            <th>Product Price</th>
                            <th>Product Image</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($results)): ?>
                            <?php foreach ($results as $row): ?>
                                <tr class="bg-danger text-white">
                                    <td><?php echo $row['order_id'];?></td>
                                    <td><?php echo $row['user_name'];?></td>
                                    
                                    <td><?php echo $row['user_address'];?></td>
                                    <td><?php echo $row['product_name'];?></td>
                                    <td><?php echo $row['order_quantity'];?></td>
                                    <td><?php echo $row['order_price'];?></td>
                                    <td>
                                        <img src="img/productimages/<?php echo $row['product_image'];?>" alt="Product Image" style="width: 70px; height: 70px;">
                                    </td>
                                    <td>
                                        <?php
                                        echo $row['order_status'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
