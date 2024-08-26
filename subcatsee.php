<?php
include('includes/header.php');
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Sub category data fetching starts here -->
            <?php
            if (isset($_GET['cid'])) {
                $catid = $_GET['cid'];
                
                // Fetch subcategories with product count
                $subcatquery = $pdo->prepare('SELECT categories.name AS category_name, subcategories.*, 
                                              (SELECT COUNT(*) FROM products WHERE products.subcat_id = subcategories.subcategory_id) AS product_count
                                              FROM subcategories
                                              INNER JOIN categories ON subcategories.cat_id = categories.category_id
                                              WHERE subcategories.cat_id = :catid');
                $subcatquery->bindParam(':catid', $catid);
                $subcatquery->execute();
                
                $sbctdata = $subcatquery->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($sbctdata)) {
                    echo '<h3>See Subcategories</h3>';
                    echo '<p>Category: ' .($sbctdata[0]['category_name']) . '</p>';
                ?>

                <div class="row">
    
                <?php
                foreach ($sbctdata as $subcatdata) {
                    ?>
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <img class="card-img-top" src="img/<?php echo($subcatdata['image']); ?>" height="200px" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php echo($subcatdata['name']); ?>
                                </h4>
                                <p class="card-text">(<?php echo $subcatdata['product_count']; ?>) products</p>
                                <a href="shop.php?cid=<?php echo($subcatdata['cat_id']); ?>&scid=<?php echo($subcatdata['subcategory_id']); ?>" class="btn btn-primary">View Products</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
                <?php
                } else {
                    echo '<p>No subcategories found for this category.</p>';
                }
            }
            ?>
            <!-- Sub category data fetching ends here -->

        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>
