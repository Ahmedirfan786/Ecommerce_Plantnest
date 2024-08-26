<?php
include('includes/header.php');
if (!isset($_SESSION['username'])) {
    header('Location: signin.php');
    exit();
}

// Fetch user ID from session
$user_id = $_SESSION['userid'];

// Fetch cart items and product details for the logged-in user
$query = $pdo->prepare('
    SELECT c.cart_id, c.price, c.quantity, p.product_id, p.name, p.image, p.price AS product_price
    FROM cart c
    INNER JOIN products p ON c.pro_id = p.product_id
    WHERE c.user_id = :userid
');
$query->bindParam(':userid', $user_id, PDO::PARAM_INT);
$query->execute();
$cartItems = $query->fetchAll(PDO::FETCH_ASSOC);

// Calculate the total price
$totalPrice = 0;

// Handle Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Insert each cart item into the orders table
        foreach ($cartItems as $item) {
            $stmt = $pdo->prepare('
                INSERT INTO orders (pro_id, user_id, price, quantity, status, order_date)
                VALUES (:pro_id, :user_id, :price, :quantity, :status, NOW())
            ');
            $stmt->execute([
                ':pro_id' => $item['product_id'],
                ':user_id' => $user_id,
                ':price' => $item['product_price'],
                ':quantity' => $item['quantity'],
                ':status' => 'Pending'
            ]);
        }

        // Commit transaction
        $pdo->commit();

        // Clear the cart
        $clearCartStmt = $pdo->prepare('DELETE FROM cart WHERE user_id = :user_id');
        $clearCartStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $clearCartStmt->execute();

        // Redirect with success message
        echo '<script>alert("Order placed successfully"); window.location.href = "cart.php";</script>';
        exit();
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $pdo->rollBack();
        echo '<script>alert("Error placing order. Please try again.");</script>';
    }
}
?>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shopping Cart</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php if (count($cartItems) > 0): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <?php
                            // Calculate total price
                            $totalPrice += $item['product_price'] * $item['quantity'];
                            ?>
                            <tr data-cart-id="<?php echo $item['cart_id']; ?>" data-product-id="<?php echo $item['product_id']; ?>">
                                <td class="align-middle">
                                    <img src="Dashboard/img/productimages/<?php echo $item['image'] ?>" width="50px" alt="">
                                    <?php echo($item['name']); ?>
                                </td>
                                <td class="align-middle">Rs <?php echo $item['product_price'];?></td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div> -->
                                        
                                        <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center quantity-input" 
                                        value="<?php echo($item['quantity']); ?>" disabled>

                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div> -->
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="Code.php?cartpro_id=<?php echo $item['product_id']?>">
                                    <button class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-times"></i> Remove
                                    </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Your cart is empty.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Total</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="total-price">Rs <?php echo number_format($totalPrice, 2); ?></h5>
                    </div>
                    <form method="post">
                        <button type="submit" name="checkout" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Order Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

<?php
include('includes/footer.php');
?>

<!-- JavaScript for Dynamic Updates -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateTotalPrice = () => {
        let totalPrice = 0;

        document.querySelectorAll('tr[data-cart-id]').forEach(row => {
            // Select the specific cell that contains the price
            const priceText = row.querySelector('td:nth-child(2)').textContent.replace('Rs ', '').trim();
            const price = parseFloat(priceText);

            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;

            // Ensure price and quantity are valid numbers before adding to the total price
            if (!isNaN(price) && !isNaN(quantity)) {
                totalPrice += price * quantity;
            }
        });

        document.getElementById('total-price').textContent = 'Rs ' + totalPrice.toFixed(2);
    };

    

    // Initialize the total price on page load
    updateTotalPrice();
});
</script>
