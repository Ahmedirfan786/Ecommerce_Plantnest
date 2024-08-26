<?php
include('header.php');

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

    <!-- Product add form container-->
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Product</h4>

            <!-- Product Add Form -->
            <form id="productForm" class="forms-sample" method="POST" action="Code.php" enctype="multipart/form-data">
              <div class="form-group mt-2">
                <label for="productName">Product Name</label>
                <input type="text" name="product_name" class="form-control" id="productName" placeholder="Enter Product Name">
                <div id="productNameError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="productPrice">Price</label>
                <input type="number" name="product_price" class="form-control" id="productPrice" placeholder="Enter Product Price">
                <div id="productPriceError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="productShortInfo">Short Info</label>
                <input type="text" name="product_short_info" class="form-control" id="productShortInfo" placeholder="Enter Short Info">
                <div id="productShortInfoError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="productDescription">Description</label>
                <textarea name="product_description" class="form-control" id="productDescription" rows="4" placeholder="Enter Description Here"></textarea>
                <div id="productDescriptionError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label>Availability</label>
                <div class="form-check">
                  <input type="radio" name="product_availability" value="In Stock" class="form-check-input" id="inStock" checked>
                  <label class="form-check-label" for="inStock">In Stock</label>
                </div>
                <div class="form-check">
                  <input type="radio" name="product_availability" value="Out Of Stock" class="form-check-input" id="outOfStock">
                  <label class="form-check-label" for="outOfStock">Out Of Stock</label>
                </div>
                <div id="productAvailabilityError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="categoryDropdown">Select Category</label>
                <select name="category_id" class="form-control" id="categoryDropdown">
                  <option value="">Select a Category</option>
                  <?php
                  foreach ($categories as $category) {
                    echo "<option value='" . $category['category_id'] . "'>" . $category['name'] . "</option>";
                  }
                  ?>
                </select>
                <div id="categoryDropdownError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="subcategoryDropdown">Select Subcategory</label>
                <select name="subcategory_id" class="form-control" id="subcategoryDropdown">
                  <option value="">Select a Subcategory</option>
                  <?php
                  foreach ($subcategories as $subcategory) {
                    echo "<option value='" . $subcategory['subcategory_id'] . "'>" . $subcategory['name'] . "</option>";
                  }
                  ?>
                </select>
                <div id="subcategoryDropdownError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label>Image Upload</label>
                <div class="input-group col-xs-12">
                  <input type="file" name="product_img" class="form-control file-upload-info" id="imageUpload" placeholder="Upload Image">
                  <div id="productImgError" class="invalid-feedback"></div>
                </div>
              </div>

              <div class="form-group mt-2">
                <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-height: 200px;"/>
              </div>

              <div class="form-group mt-3">
                <button type="submit" name="product_add" class="btn btn-primary mr-2">Add Product</button>
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
      var categoryDropdown = document.getElementById("categoryDropdown");
      var subcategoryDropdown = document.getElementById("subcategoryDropdown");
      var imageUpload = document.getElementById("imageUpload");

      var productNameError = document.getElementById("productNameError");
      var productPriceError = document.getElementById("productPriceError");
      var productShortInfoError = document.getElementById("productShortInfoError");
      var productDescriptionError = document.getElementById("productDescriptionError");
      var productAvailabilityError = document.getElementById("productAvailabilityError");
      var categoryDropdownError = document.getElementById("categoryDropdownError");
      var subcategoryDropdownError = document.getElementById("subcategoryDropdownError");
      var productImgError = document.getElementById("productImgError");

      form.addEventListener("submit", function(event) {
        var valid = true;

        // Clear previous error messages
        productName.classList.remove("is-invalid");
        productPrice.classList.remove("is-invalid");
        productShortInfo.classList.remove("is-invalid");
        productDescription.classList.remove("is-invalid");
        categoryDropdown.classList.remove("is-invalid");
        subcategoryDropdown.classList.remove("is-invalid");
        imageUpload.classList.remove("is-invalid");

        productNameError.textContent = "";
        productPriceError.textContent = "";
        productShortInfoError.textContent = "";
        productDescriptionError.textContent = "";
        categoryDropdownError.textContent = "";
        subcategoryDropdownError.textContent = "";
        productImgError.textContent = "";

        // Product Name validation
        if (productName.value.trim() === "") {
          productName.classList.add("is-invalid");
          productNameError.textContent = "Product name is required.";
          valid = false;
        }

        // Product Price validation
        if (productPrice.value.trim() === "" || isNaN(productPrice.value) || productPrice.value <= 0) {
          productPrice.classList.add("is-invalid");
          productPriceError.textContent = "A valid product price is required.";
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

        // Category Dropdown validation
        if (categoryDropdown.value.trim() === "") {
          categoryDropdown.classList.add("is-invalid");
          categoryDropdownError.textContent = "Please select a category.";
          valid = false;
        }

        // Subcategory Dropdown validation
        if (subcategoryDropdown.value.trim() === "") {
          subcategoryDropdown.classList.add("is-invalid");
          subcategoryDropdownError.textContent = "Please select a subcategory.";
          valid = false;
        }

        // Image validation (optional)
        if (imageUpload.files.length === 0) {
          imageUpload.classList.add("is-invalid");
          productImgError.textContent = "Image upload is required.";
          valid = false;
        }

        if (!valid) {
          event.preventDefault(); // Prevent form submission
        }
      });

      // Image Preview
      imageUpload.addEventListener("change", function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('imagePreview');
          output.src = reader.result;
          output.style.display = 'block';
        }
        if (file) {
          reader.readAsDataURL(file);
        }
      });
    });
  </script>

<?php
include('footer.php');
?>
