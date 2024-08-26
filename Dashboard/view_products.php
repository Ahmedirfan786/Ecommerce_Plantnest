<?php
include('header.php');
?>

<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light mx-0">
        <div class="col-md-12 p-4 mb-3">
            <h3 class="mb-3">View Products</h3>

            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary text-light">
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Availability</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">SubCategory Name</th>
                        <th scope="col">Price</th>
                        <th scope="col" colspan="4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$sql = "
   SELECT p.product_id, 
       p.name AS product_name, 
       p.image, 
       p.price, 
       p.status, 
       p.availibility,
       c.name AS category_name, 
       s.name AS subcategory_name, 
       s.cat_id
FROM products p
INNER JOIN subcategories s ON p.subcat_id = s.subcategory_id
INNER JOIN categories c ON s.cat_id = c.category_id;
";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

if ($data) {
    foreach ($data as $product) {
        ?>
        <tr>
            <td><?php echo $product['product_id']; ?></td>
            <td><?php echo $product['product_name']; ?></td>
            <td>
                <img src="img/productimages/<?php echo $product['image']; ?>" width="80px" height="80px" alt="">
            </td>
            <td><?php echo $product['availibility']; ?></td>
            <td><?php echo $product['category_name']; ?></td>
            <td><?php echo $product['subcategory_name']; ?></td>
            <td><?php echo $product['price']; ?></td>
            <td>
                <a href="view_productdata.php?product_id=<?php echo $product['product_id']; ?>" class="text-white">
                        <button class="btn btn-primary">
                        View
                        </button>
                </a>

                <a href="edit_product.php?editproid=<?php echo $product['product_id']; ?>" class="text-dark">
                        <button class="btn btn-warning">
                        Edit
                    </button>
                    </a>

                <?php if ($product['status'] == 1): ?>
                    <a href="Code.php?disproid=<?php echo $product['product_id']; ?>" class="text-white">
                            <button class="btn btn-danger">
                            Disable
                        </button>
                        </a>
                <?php elseif ($product['status'] == 0): ?>
                    <a href="Code.php?enbproid=<?php echo $product['product_id']; ?>" class="text-white">
                            <button class="btn btn-success">
                            Enable
                        </button>
                        </a>
                <?php endif; ?>

                <a href="Code.php?delproid=<?php echo $product['product_id']?>">
                    <button class="btn btn-dark mt-2">Delete
                        </button>
                    </a>
            </td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr>
        <td colspan="8" class="text-center">No Products Available</td>
    </tr>
    <?php
}
?>

                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- Blank End -->

<?php
include('footer.php');
?>
