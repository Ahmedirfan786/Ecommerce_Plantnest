<?php
include('header.php');

// Check if subcategory_id is set in the URL
if (isset($_GET['subcategory_id'])) {
    $subcategory_id = $_GET['subcategory_id'];

    // Prepare and execute the query to fetch subcategory details
    $query = $pdo->prepare("SELECT subcategories.*, categories.name AS category_name
                            FROM subcategories
                            INNER JOIN categories ON subcategories.cat_id = categories.category_id
                            WHERE subcategories.subcategory_id = ?");
    $query->execute([$subcategory_id]);
    $subcategory = $query->fetch(PDO::FETCH_ASSOC);

    // Check if subcategory data is found
    if ($subcategory) {
        ?>
        <div class="container-fluid pt-4 px-4">
            <div class="row bg-light mx-0">
                <div class="col-md-12 p-4 mb-3">
                    <h3 class="mb-3">Subcategory Details</h3>

                    <table class="table table-bordered">
                        <tr>
                            <th scope="col">Subcategory ID</th>
                            <td><?php echo $subcategory['subcategory_id']; ?></td>
                        </tr>
                        <tr>
                            <th scope="col">Subcategory Name</th>
                            <td><?php echo $subcategory['name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="col">Image</th>
                            <td>
                                <img src="img/subcategoryimages/<?php echo $subcategory['image']; ?>" width="150px" height="150px" alt="Subcategory Image">
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Category Name</th>
                            <td><?php echo $subcategory['category_name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="col">Status</th>
                            <td><?php echo $subcategory['status'] == 1 ? 'Enabled' : 'Disabled'; ?></td>
                        </tr>
                    </table>

                    <!-- Back Button -->
                    <a href="view_subcategories.php" class="btn btn-primary mt-3">Back to Subcategories</a>
                </div>
            </div>
        </div>
        <?php
    } else {
        // If no subcategory found
        echo "<div class='container-fluid pt-4 px-4'><div class='row bg-light mx-0'><div class='col-md-12 p-4 mb-3'><h3 class='mb-3'>Subcategory not found</h3><a href='view_subcategories.php' class='btn btn-secondary mt-3'>Back to Subcategories</a></div></div></div>";
    }
} else {
    // If subcategory_id is not set in the URL
    echo "<div class='container-fluid pt-4 px-4'><div class='row bg-light mx-0'><div class='col-md-12 p-4 mb-3'><h3 class='mb-3'>No subcategory ID provided</h3><a href='view_subcategories.php' class='btn btn-secondary mt-3'>Back to Subcategories</a></div></div></div>";
}

include('footer.php');
?>
