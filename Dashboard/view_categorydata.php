<?php
include('header.php');

// Check if category_id is set in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Prepare and execute the query to fetch category details
    $query = $pdo->prepare("SELECT * FROM categories WHERE category_id = ?");
    $query->execute([$category_id]);
    $category = $query->fetch(PDO::FETCH_ASSOC);

    // Check if category data is found
    if ($category) {
        ?>
        <div class="container-fluid pt-4 px-4">
            <div class="row bg-light mx-0">
                <div class="col-md-12 p-4 mb-3">
                    <h3 class="mb-3">Category Details</h3>

                    <table class="table table-bordered">
                        <tr>
                            <th scope="col">Category ID</th>
                            <td><?php echo $category['category_id']; ?></td>
                        </tr>
                        <tr>
                            <th scope="col">Category Name</th>
                            <td><?php echo $category['name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="col">Image</th>
                            <td>
                                <img src="img/categoryimages/<?php echo $category['image']; ?>" width="150px" height="150px" alt="Category Image">
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Status</th>
                            <td><?php echo $category['status'] == 1 ? 'Enabled' : 'Disabled'; ?></td>
                        </tr>
                    </table>

                    <!-- Back Button -->
                    <a href="view_categories.php" class="btn btn-primary mt-3">Back to Categories</a>
                </div>
            </div>
        </div>
        <?php
    } else {
        // If no category found
        echo "<div class='container-fluid pt-4 px-4'><div class='row bg-light mx-0'><div class='col-md-12 p-4 mb-3'><h3 class='mb-3'>Category not found</h3><a href='viewcategories.php' class='btn btn-secondary mt-3'>Back to Categories</a></div></div></div>";
    }
} else {
    // If category_id is not set in the URL
    echo "<div class='container-fluid pt-4 px-4'><div class='row bg-light mx-0'><div class='col-md-12 p-4 mb-3'><h3 class='mb-3'>No category ID provided</h3><a href='viewcategories.php' class='btn btn-secondary mt-3'>Back to Categories</a></div></div></div>";
}

include('footer.php');
?>
