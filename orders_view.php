<?php
include('includes/header.php');

// Prepare and execute the query to fetch orders
$query = "SELECT 
            o.order_id,
            p.name AS product_name,
            o.quantity,
            o.price,
            (o.quantity * o.price) AS total_price,
            p.image AS product_image,
            o.status,
            o.order_date,
            DATE_FORMAT(o.order_date, '%d-%m-%Y %h:%i %p') AS formatted_date
          FROM orders o
          JOIN products p ON o.pro_id = p.product_id
          WHERE o.user_id = :user_id
          ORDER BY o.order_date ASC";

$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $_SESSION['userid']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-3">
            <h2>My Orders</h2>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-dark" style="background-color:orange;">
                        <tr>
                            <th>Order Id</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            <th>Image</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <?php
                            // Check if a review has already been submitted for this order
                            $reviewQuery = "SELECT COUNT(*) FROM reviews WHERE order_id = :order_id";
                            $reviewStmt = $pdo->prepare($reviewQuery);
                            $reviewStmt->execute(['order_id' => $order['order_id']]);
                            $reviewExists = $reviewStmt->fetchColumn() > 0;
                            ?>

                            <!-- Condition to display different order statuses -->
                            <?php if ($order['status'] == "Pending"): ?>
                                <tr class="bg-light text-dark">
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['price']; ?></td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td class="text-center">
                                        <img src="Dashboard/img/productimages/<?php echo $order['product_image']; ?>" width="100px" height="80px" alt="">
                                    </td>
                                    <td><?php echo $order['formatted_date']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td>
                                        <a href="Code.php?cancelorder_id=<?php echo $order['order_id']?>">
                                            <button class="btn btn-danger">Cancel</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php elseif ($order['status'] == "Approved"): ?>
                                <tr class="bg-success text-white">
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['price']; ?></td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td class="text-center">
                                        <img src="Dashboard/img/productimages/<?php echo $order['product_image']; ?>" width="100px" height="80px" alt="">
                                    </td>
                                    <td><?php echo $order['formatted_date']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td>
                                        <a href="Code.php?cancelorder_id=<?php echo $order['order_id']?>">
                                            <button class="btn btn-danger">Cancel</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php elseif ($order['status'] == "Rejected"): ?>
                                <tr class="bg-danger text-white">
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['price']; ?></td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td class="text-center">
                                        <img src="Dashboard/img/productimages/<?php echo $order['product_image']; ?>" width="100px" height="80px" alt="">
                                    </td>
                                    <td><?php echo $order['formatted_date']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td>Rejected</td>
                                </tr>
                            <?php elseif ($order['status'] == "Ontheway"): ?>
                                <tr class="bg-warning text-white">
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['price']; ?></td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td class="text-center">
                                        <img src="Dashboard/img/productimages/<?php echo $order['product_image']; ?>" width="100px" height="80px" alt="">
                                    </td>
                                    <td><?php echo $order['formatted_date']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td>On the way</td>
                                </tr>
                            <?php elseif ($order['status'] == "Delivered"): ?>
                                <tr class="bg-info text-white">
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['price']; ?></td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td class="text-center">
                                        <img src="Dashboard/img/productimages/<?php echo $order['product_image']; ?>" width="100px" height="80px" alt="">
                                    </td>
                                    <td><?php echo $order['formatted_date']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td>
                                        <?php if ($reviewExists): ?>
                                            <button class="btn btn-secondary" disabled>Review Submitted</button>
                                        <?php else: ?>
                                            <a href="order_review.php?revieworder_id=<?php echo $order['order_id']?>">
                                                <button class="btn btn-success">Give Review</button>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr class="bg-dark text-white">
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['price']; ?></td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td class="text-center">
                                        <img src="Dashboard/img/productimages/<?php echo $order['product_image']; ?>" width="100px" height="80px" alt="">
                                    </td>
                                    <td><?php echo $order['formatted_date']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td>Cancelled</td>
                                </tr>
                            <?php endif; ?>
                            <!-- Condition to display different order statuses ends -->
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
