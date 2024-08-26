<?php
include('header.php');


?>

<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light mx-0">
        <div class="col-md-12 p-4 mb-3">
            <h3 class="mb-3">View Subcategories</h3>

            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary text-light">
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Category Name</th>
                        <th scope="col" colspan="3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->prepare("SELECT subcategories.*, categories.name AS category_name
                    FROM subcategories
                    INNER JOIN categories ON subcategories.cat_id = categories.category_id");
                    $query->execute();
                    $data = $query->fetchAll(PDO::FETCH_ASSOC);
                    if ($data) {
                        foreach ($data as $subcatdata) {
                            ?>
                            <tr>
                                <td><?php echo $subcatdata['subcategory_id'] ?></td>
                                <td><?php echo $subcatdata['name'] ?></td>                                
                                <td class="text-center">
                                    <img src="img/subcategoryimages/<?php echo $subcatdata['image'] ?>" width="80px" height="80px" alt="">
                                </td>
                                <td><?php echo $subcatdata['category_name'] ?></td>
                                <td>
                                    <a href="view_subcategorydata.php?subcategory_id=<?php echo $subcatdata['subcategory_id'] ?>" class="text-white">
                                            <button class="btn btn-primary">
                                            View
                                        </button>
                                        </a>

                                    <a href="edit_subcategory.php?edit_subcat=<?php echo $subcatdata['subcategory_id'] ?>" class="text-dark">
                                            <button class="btn btn-warning">
                                            Edit
                                        </button>
                                        </a>

                                    <!-- Applying condition if sub category status is enabled or disabled -->
                                    <?php if ($subcatdata['status'] == 1): ?>
                                        <a href="Code.php?dissubcatid=<?php echo $subcatdata['subcategory_id']; ?>" class="text-white">
                                                <button class="btn btn-danger">
                                                Disable
                                            </button>
                                            </a>
                                    <?php elseif ($subcatdata['status'] == 0): ?>
                                        <a href="Code.php?enbsubcatid=<?php echo $subcatdata['subcategory_id']; ?>" class="text-white">
                                                <button class="btn btn-success">
                                                Enable
                                            </button>
                                            </a>
                                    <?php endif; ?>


                                    <a href="Code.php?delsubcatid=<?php echo $subcatdata['subcategory_id'] ?>" class="text-white">
                                            <button class="btn btn-dark">
                                            Delete
                                        
                                        </button>
                                        </a>

                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">No Categories are there</td>
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
