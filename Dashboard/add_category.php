<?php
include('header.php');
?>

<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">

    <!-- Category add form container-->
    <div class="row ">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Category Add</h4>

            <!-- Category Add Form -->
            <form id="categoryForm" class="forms-sample" method="POST" action="Code.php" enctype="multipart/form-data">
              <div class="form-group mt-2">
                <label for="exampleInputName1">Name</label>
                <input type="text" name="cat_name" class="form-control" id="cat_name" placeholder="Name">
                <div id="cat_nameError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label for="exampleTextarea1">Description</label>
                <textarea class="form-control" name="cat_des" id="cat_des" rows="4" placeholder="Enter Description Here"></textarea>
                <div id="cat_desError" class="invalid-feedback"></div>
              </div>

              <div class="form-group mt-2">
                <label>Image upload</label>
                <div class="input-group col-xs-12">
                  <input type="file" name="cat_img" class="form-control file-upload-info" id="cat_img" placeholder="Upload Image">
                  <div id="cat_imgError" class="invalid-feedback"></div>
                </div>
                <div class="mt-2">
                  <img id="img_preview" src="" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px;"/>
                </div>
              </div>

              <div class="form-group mt-3">
                <button type="submit" name="cat_add" class="btn btn-primary mr-2">Add Category</button>
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
    var form = document.getElementById("categoryForm");
    var catName = document.getElementById("cat_name");
    var catDes = document.getElementById("cat_des");
    var catImg = document.getElementById("cat_img");
    var imgPreview = document.getElementById("img_preview");

    var catNameError = document.getElementById("cat_nameError");
    var catDesError = document.getElementById("cat_desError");
    var catImgError = document.getElementById("cat_imgError");

    form.addEventListener("submit", function(event) {
      var valid = true;

      // Clear previous error messages
      catName.classList.remove("is-invalid");
      catDes.classList.remove("is-invalid");
      catImg.classList.remove("is-invalid");

      catNameError.textContent = "";
      catDesError.textContent = "";
      catImgError.textContent = "";

      // Name validation
      if (catName.value.trim() === "") {
        catName.classList.add("is-invalid");
        catNameError.textContent = "Category name is required.";
        valid = false;
      }

      // Description validation
      if (catDes.value.trim() === "") {
        catDes.classList.add("is-invalid");
        catDesError.textContent = "Description is required.";
        valid = false;
      }

      // Image validation
      if (catImg.files.length === 0) {
        catImg.classList.add("is-invalid");
        catImgError.textContent = "Image upload is required.";
        valid = false;
      }

      if (!valid) {
        event.preventDefault(); // Prevent form submission
      }
    });

    catImg.addEventListener("change", function(event) {
      var file = event.target.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          imgPreview.src = e.target.result;
          imgPreview.style.display = "block";
        }
        reader.readAsDataURL(file);
      } else {
        imgPreview.src = "";
        imgPreview.style.display = "none";
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
    #img_preview {
      border: 1px solid #ddd;
      padding: 5px;
      border-radius: 4px;
    }
  </style>
</div>
