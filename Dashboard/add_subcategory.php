<?php
include('header.php');

// Fetch categories for the dropdown
$query = "SELECT category_id, name FROM categories";
$statement = $pdo->prepare($query);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">

    <!-- Subcategory add form container-->
    <div class="row ">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Subcategory</h4>

            <!-- Subcategory Add Form -->
            <form id="subcategoryForm" class="forms-sample" method="POST" action="Code.php" enctype="multipart/form-data">
              <div class="form-group mt-2">
                <label for="subcategoryName">Subcategory Name</label>
                <input type="text" name="subcat_name" class="form-control" id="subcategoryName" placeholder="Enter Subcategory Name">
                <div id="subcat_nameError" class="invalid-feedback"></div>
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
                <div id="category_idError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="subcategoryDescription">Description</label>
                <textarea name="subcat_description" class="form-control" id="subcategoryDescription" rows="4" placeholder="Enter Description Here"></textarea>
                <div id="subcat_descriptionError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label>Image Upload</label>
                <div class="input-group col-xs-12">
                  <input type="file" name="subcat_img" class="form-control file-upload-info" id="imageUpload" placeholder="Upload Image">
                  <div id="subcat_imgError" class="invalid-feedback"></div>
                </div>
              </div>

              <div class="form-group mt-2">
                <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-height: 200px;"/>
              </div>

              <div class="form-group mt-3">
                <button type="submit" name="subcat_add" class="btn btn-primary mr-2">Add Subcategory</button>
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
      var form = document.getElementById("subcategoryForm");
      var subcatName = document.getElementById("subcategoryName");
      var categoryDropdown = document.getElementById("categoryDropdown");
      var subcatDescription = document.getElementById("subcategoryDescription");
      var imageUpload = document.getElementById("imageUpload");

      var subcatNameError = document.getElementById("subcat_nameError");
      var category_idError = document.getElementById("category_idError");
      var subcatDescriptionError = document.getElementById("subcat_descriptionError");
      var subcat_imgError = document.getElementById("subcat_imgError");

      form.addEventListener("submit", function(event) {
        var valid = true;

        // Clear previous error messages
        subcatName.classList.remove("is-invalid");
        categoryDropdown.classList.remove("is-invalid");
        subcatDescription.classList.remove("is-invalid");
        imageUpload.classList.remove("is-invalid");

        subcatNameError.textContent = "";
        category_idError.textContent = "";
        subcatDescriptionError.textContent = "";
        subcat_imgError.textContent = "";

        // Subcategory Name validation
        if (subcatName.value.trim() === "") {
          subcatName.classList.add("is-invalid");
          subcatNameError.textContent = "Subcategory name is required.";
          valid = false;
        }

        // Category Dropdown validation
        if (categoryDropdown.value.trim() === "") {
          categoryDropdown.classList.add("is-invalid");
          category_idError.textContent = "Please select a category.";
          valid = false;
        }

        // Description validation
        if (subcatDescription.value.trim() === "") {
          subcatDescription.classList.add("is-invalid");
          subcatDescriptionError.textContent = "Description is required.";
          valid = false;
        }

        // Image validation (optional, remove if not needed)
        if (imageUpload.files.length === 0) {
          imageUpload.classList.add("is-invalid");
          subcat_imgError.textContent = "Image upload is required.";
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
        reader.readAsDataURL(file);
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
    #imagePreview {
      border: 1px solid #ddd;
      padding: 5px;
      border-radius: 4px;
    }
  </style>
</div>

<?php
include('footer.php');
?>
