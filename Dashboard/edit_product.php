<?php
include('header.php');

// Check if product_id is provided
if (!isset($_GET['editproid']) || empty($_GET['editproid'])) {
    echo "<p>Product ID is missing.</p>";
    exit();
}

$product_id = $_GET['editproid'];

// Fetch the product details
$sql = "SELECT p.product_id, p.name, p.image, p.price, p.status, p.availibility, p.short_info, p.description, p.cat_id, p.subcat_id, c.name AS category_name, s.name AS subcategory_name
        FROM products p
        INNER JOIN subcategories s ON p.subcat_id = s.subcategory_id
        INNER JOIN categories c ON s.cat_id = c.category_id
        WHERE p.product_id = :product_id";

$query = $pdo->prepare($sql);
$query->execute([':product_id' => $product_id]);
$product = $query->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<p>Product not found.</p>";
    exit();
}

// Fetch categories for the dropdown
$queryCategories = "SELECT category_id, name FROM categories";
$statementCategories = $pdo->prepare($queryCategories);
$statementCategories->execute();
$categories = $statementCategories->fetchAll(PDO::FETCH_ASSOC);

// Fetch subcategories for the dropdown
$querySubcategories = "SELECT subcategory_id, name FROM subcategories";
$statementSubcategories = $pdo->prepare($querySubcategories);
$statementSubcategories->execute();
$subcategories = $statementSubcategories->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">

    <!-- Product Edit form container -->
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Edit Product</h4>

            <!-- Product Edit Form -->
            <form id="productForm" class="forms-sample" method="POST" action="Code.php" enctype="multipart/form-data">
              <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

              <div class="form-group mt-2">
                <label for="productName">Product Name</label>
                <input type="text" name="product_name" class="form-control" id="productName" value="<?php echo htmlspecialchars($product['name']); ?>" placeholder="Enter Product Name">
                <div id="productNameError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="productPrice">Price</label>
                <input type="number" name="product_price" class="form-control" id="productPrice" value="<?php echo htmlspecialchars($product['price']); ?>" placeholder="Enter Product Price">
                <div id="productPriceError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="productShortInfo">Short Info</label>
                <input type="text" name="product_short_info" class="form-control" id="productShortInfo" value="<?php echo htmlspecialchars($product['short_info']); ?>" placeholder="Enter Short Info">
                <div id="productShortInfoError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="productDescription">Description</label>
                <textarea name="product_description" class="form-control" id="productDescription" rows="4" placeholder="Enter Description Here"><?php echo htmlspecialchars($product['description']); ?></textarea>
                <div id="productDescriptionError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label>Availability</label>
                <div class="form-check">
                  <input type="radio" name="product_availability" value="In Stock" class="form-check-input" id="inStock" <?php echo $product['availibility'] == 'In Stock' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="inStock">In Stock</label>
                </div>
                <div class="form-check">
                  <input type="radio" name="product_availability" value="Out Of Stock" class="form-check-input" id="outOfStock" <?php echo $product['availibility'] == 'Out Of Stock' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="outOfStock">Out Of Stock</label>
                </div>
              </div>

              <div class="form-group mt-2">
                <label for="categoryDropdown">Select Category</label>
                <select name="category_id" class="form-control" id="categoryDropdown">
                  <?php
                  foreach ($categories as $category) {
                    $selected = $category['category_id'] == $product['cat_id'] ? 'selected' : '';
                    echo "<option value='" . $category['category_id'] . "' $selected>" . $category['name'] . "</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group mt-2">
                <label for="subcategoryDropdown">Select Subcategory</label>
                <select name="subcategory_id" class="form-control" id="subcategoryDropdown">
                  <?php
                  foreach ($subcategories as $subcategory) {
                    $selected = $subcategory['subcategory_id'] == $product['subcat_id'] ? 'selected' : '';
                    echo "<option value='" . $subcategory['subcategory_id'] . "' $selected>" . $subcategory['name'] . "</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group mt-2">
                <label>Image Upload</label>
                <div class="input-group col-xs-12">
                  <input type="file" name="product_img" class="form-control file-upload-info" id="imageUpload" placeholder="Upload Image" onchange="previewImage(event)">
                  <div id="productImgError" class="invalid-feedback"></div>
                </div>
              </div>

              <div class="form-group mt-2">
                <img id="imagePreview" src="img/productimages/<?php echo htmlspecialchars($product['image']); ?>" alt="Image Preview" style="max-height: 200px;"/>
              </div>

              <div class="form-group mt-3">
                <button type="submit" name="product_update" class="btn btn-primary mr-2">Update Product</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- content-wrapper ends -->

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var form = document.getElementById("productForm");
      var productName = document.getElementById("productName");
      var productPrice = document.getElementById("productPrice");
      var productShortInfo = document.getElementById("productShortInfo");
      var productDescription = document.getElementById("productDescription");
      var productImg = document.getElementById("imageUpload");
      var imgPreview = document.getElementById("imagePreview");

      var productNameError = document.getElementById("productNameError");
      var productPriceError = document.getElementById("productPriceError");
      var productShortInfoError = document.getElementById("productShortInfoError");
      var productDescriptionError = document.getElementById("productDescriptionError");
      var productImgError = document.getElementById("productImgError");

      form.addEventListener("submit", function(event) {
        var valid = true;

        // Clear previous error messages
        productName.classList.remove("is-invalid");
        productPrice.classList.remove("is-invalid");
        productShortInfo.classList.remove("is-invalid");
        productDescription.classList.remove("is-invalid");
        productImg.classList.remove("is-invalid");

        productNameError.textContent = "";
        productPriceError.textContent = "";
        productShortInfoError.textContent = "";
        productDescriptionError.textContent = "";
        productImgError.textContent = "";

        // Product Name validation
        if (productName.value.trim() === "") {
          productName.classList.add("is-invalid");
          productNameError.textContent = "Product name is required.";
          valid = false;
        }

        // Price validation
        if (productPrice.value.trim() === "") {
          productPrice.classList.add("is-invalid");
          productPriceError.textContent = "Price is required.";
          valid = false;
        } else if (isNaN(productPrice.value) || Number(productPrice.value) <= 0) {
          productPrice.classList.add("is-invalid");
          productPriceError.textContent = "Please enter a valid price.";
          valid = false;
        }

        // Short Info validation
        if (productShortInfo.value.trim() === "") {
          productShortInfo.classList.add("is-invalid");
          productShortInfoError.textContent = "Short info is required.";
          valid = false;
        }

        // Description validation
        if (productDescription.value.trim() === "") {
          productDescription.classList.add("is-invalid");
          productDescriptionError.textContent = "Description is required.";
          valid = false;
        }

        // Image validation
        if (productImg.files.length > 0) {
          var file = productImg.files[0];
          var fileType = file.type;
          var validTypes = ["image/jpeg", "image/png", "image/gif"];
          if (!validTypes.includes(fileType)) {
            productImg.classList.add("is-invalid");
            productImgError.textContent = "Invalid image format. Only JPG, PNG, and GIF are allowed.";
            valid = false;
          }
        }

        if (!valid) {
          event.preventDefault();
        }
      });

      function previewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function() {
          imgPreview.src = reader.result;
        }

        if (file) {
          reader.readAsDataURL(file);
        }
      }
    });
  </script>

<?php include('footer.php'); ?>
