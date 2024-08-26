<?php
include('header.php');
include('connection.php');

// Fetching the subcategory details
if (isset($_GET['edit_subcat'])) {
    $subcatid = $_GET['edit_subcat'];
    $query = $pdo->prepare("SELECT * FROM subcategories WHERE subcategory_id = :subcatid");
    $query->bindParam('subcatid', $subcatid);
    $query->execute();
    $subcatdata = $query->fetch(PDO::FETCH_ASSOC);
    if (!$subcatdata) {
        echo "<script>alert('Subcategory not found'); location.assign('view_subcategories.php');</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid Request'); location.assign('view_subcategories.php');</script>";
    exit;
}

// Fetching categories for the dropdown
$categoriesQuery = $pdo->prepare("SELECT * FROM categories");
$categoriesQuery->execute();
$categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main Panel -->
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Subcategory Edit Form Container -->
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Subcategory</h4>

                        <!-- Subcategory Edit Form -->
                        <form id="subcategoryForm" class="forms-sample" method="POST" action="Code.php" enctype="multipart/form-data">
                            <input type="hidden" name="subcat_id" value="<?php echo htmlspecialchars($subcatdata['subcategory_id']); ?>">

                            <div class="form-group mt-2">
                                <label for="subcat_name">Name</label>
                                <input type="text" name="subcat_name" class="form-control" id="subcat_name" 
                                       value="<?php echo htmlspecialchars($subcatdata['name']); ?>" placeholder="Name">
                                <div id="subcat_nameError" class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="subcat_description">Description</label>
                                <textarea class="form-control" name="subcat_description" id="subcat_description" rows="4"
                                          placeholder="Enter Description Here"><?php echo htmlspecialchars($subcatdata['description']); ?></textarea>
                                <div id="subcat_descriptionError" class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="categorySelect">Category</label>
                                <select name="category_id" id="categorySelect" class="form-control">
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['category_id']); ?>" 
                                                <?php if ($subcatdata['cat_id'] == $category['category_id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group mt-2">
                                <label>Change Image</label>
                                <div class="input-group col-xs-12">
                                    <input type="file" name="subcat_img" class="form-control file-upload-info" 
                                           id="subcat_img" placeholder="Upload Image" onchange="previewImage(event)">
                                    <div id="subcat_imgError" class="invalid-feedback"></div>
                                </div>
                            </div>
                            
                            <div class="form-group mt-2">
                                <label>Current Image</label>
                                <div class="mb-3">
                                    <img src="img/subcategoryimages/<?php echo htmlspecialchars($subcatdata['image']); ?>" 
                                         id="subcategoryImagePreview" width="150px" height="150px" alt="Subcategory Image">
                                </div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <button type="submit" name="subcat_update" class="btn btn-primary mr-2">Update Subcategory</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->

<?php
include('footer.php');
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("subcategoryForm");
    var subcatName = document.getElementById("subcat_name");
    var subcatDescription = document.getElementById("subcat_description");
    var subcatImg = document.getElementById("subcat_img");
    var imgPreview = document.getElementById("subcategoryImagePreview");

    var subcatNameError = document.getElementById("subcat_nameError");
    var subcatDescriptionError = document.getElementById("subcat_descriptionError");
    var subcatImgError = document.getElementById("subcat_imgError");

    form.addEventListener("submit", function(event) {
        var valid = true;

        // Clear previous error messages
        subcatName.classList.remove("is-invalid");
        subcatDescription.classList.remove("is-invalid");
        subcatImg.classList.remove("is-invalid");

        subcatNameError.textContent = "";
        subcatDescriptionError.textContent = "";
        subcatImgError.textContent = "";

        // Name validation
        if (subcatName.value.trim() === "") {
            subcatName.classList.add("is-invalid");
            subcatNameError.textContent = "Subcategory name is required.";
            valid = false;
        }

        // Description validation
        if (subcatDescription.value.trim() === "") {
            subcatDescription.classList.add("is-invalid");
            subcatDescriptionError.textContent = "Description is required.";
            valid = false;
        }

        // Image validation (optional, if you want to ensure image is provided)
        if (subcatImg.files.length > 0 && !['image/jpeg', 'image/png'].includes(subcatImg.files[0].type)) {
            subcatImg.classList.add("is-invalid");
            subcatImgError.textContent = "Please upload a valid image file (JPEG/PNG).";
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission
        }
    });

    subcatImg.addEventListener("change", function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = "block";
            }
            reader.readAsDataURL(file);
        } else {
            imgPreview.src = "img/subcategoryimages/<?php echo htmlspecialchars($subcatdata['image']); ?>";
            imgPreview.style.display = "block";
        }
    });
});
</script>

<style>
.invalid-feedback {
    color: #dc3545;
    font-size: 0.875em;
}
.is-invalid {
    border-color: #dc3545;
}
#subcategoryImagePreview {
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 4px;
}
</style>
</div>
