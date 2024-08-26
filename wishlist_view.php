<?php
include('includes/header.php');



// Check if the user is logged in
if (isset($_SESSION['userid'])) { 
    // Prepare the query to fetch wishlist items with their associated product details
    $query = $pdo->prepare('
        SELECT w.wishlist_id, p.name as product_name, p.image as product_image ,p.availibility
        FROM wishlist w 
        JOIN products p ON w.pro_id = p.product_id 
        WHERE w.user_id = :userid
    ');
    $query->bindParam(':userid', $_SESSION['userid'], PDO::PARAM_INT);
    $query->execute();

    // Fetch all wishlist items
    $wishlistItems = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If user is not logged in, redirect to login page or show a message
    header("Location: signin.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-4">
            <h2>Wishlist</h2>

            <?php if (!empty($wishlistItems)): ?>
            <table class="table table-bordered">
                <thead class="bg-primary text-dark">
                <tr>
                    <th>Wishlist ID</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($wishlistItems as $item): ?>
                <tr>
                    <td><?php echo $item['wishlist_id']; ?></td>
                    <td><?php echo $item['product_name']; ?></td>
                    <td><img src="Dashboard/img/productimages/<?php echo $item['product_image']; ?>" width="40px" height="40px" alt=""></td>
                    <td>

                    <!-- Disable the add to cart btn if product avaialibilty is out of stock query starts -->

                    <?php
                    if($item['availibility'] == "Out Of Stock"){
                        ?>
                           <a href="#" class="text-white">
                        <button class="btn btn-warning text-dark" disabled>
                                Out of stock
                            </button>
                        </a>
                        <?php
                    }
                    else{
                        ?>
                           <a href="Code.php?wlistproid=<?php echo $item['wishlist_id']; ?>" class="text-white">
                        <button class="btn btn-warning text-dark">
                                Add to cart
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <!-- Disable the add to cart btn if product avaialibilty is out of stock query ends -->

                     
                        <a href="Code.php?wishlistid=<?php echo $item['wishlist_id']; ?>">
                            <button class="btn btn-danger text-light">Remove</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>Your wishlist is currently empty.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>
