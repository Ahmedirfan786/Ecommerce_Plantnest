<?php
include('includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        <section class="p-4">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="img/signinlog3.jpg" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <h3>Signup Form</h3>
                        </div>
                        
                        <div class="divider d-flex align-items-center my-2"></div>
                        
                        <form id="signupForm" method="POST" action="Code.php" enctype="multipart/form-data">

                            <!-- Name input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Enter a name"/>
                                <label class="form-label" for="name">Name</label>
                                <div id="nameError" class="invalid-feedback"></div>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address"/>
                                <label class="form-label" for="email">Email address</label>
                                <div id="emailError" class="invalid-feedback"></div>
                            </div>

                            <!-- Address input -->
                            <div class="form-outline mb-3">
                                <input type="text" id="address" name="address" class="form-control form-control-lg" placeholder="Enter your address"/>
                                <label class="form-label" for="address">Address</label>
                                <div id="addressError" class="invalid-feedback"></div>
                            </div>

                            <!-- Image input -->
                            <div class="form-outline mb-3">
                                <input type="file" id="image" name="image" class="form-control form-control-md"/>
                                <label class="form-label" for="image">Image</label>
                                <div id="imageError" class="invalid-feedback"></div>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password"/>
                                <label class="form-label" for="password">Password</label>
                                <div id="passwordError" class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Already have an account? <a href="signin.php">Click here!</a>
                                </div>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" name="signup" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Signup</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("signupForm");
    var name = document.getElementById("name");
    var email = document.getElementById("email");
    var address = document.getElementById("address");
    var image = document.getElementById("image");
    var password = document.getElementById("password");
    var nameError = document.getElementById("nameError");
    var emailError = document.getElementById("emailError");
    var addressError = document.getElementById("addressError");
    var imageError = document.getElementById("imageError");
    var passwordError = document.getElementById("passwordError");

    form.addEventListener("submit", function(event) {
      var valid = true;

      // Clear previous error messages
      name.classList.remove("is-invalid");
      email.classList.remove("is-invalid");
      address.classList.remove("is-invalid");
      image.classList.remove("is-invalid");
      password.classList.remove("is-invalid");
      nameError.textContent = "";
      emailError.textContent = "";
      addressError.textContent = "";
      imageError.textContent = "";
      passwordError.textContent = "";

      // Name validation
      if (name.value.trim() === "") {
        name.classList.add("is-invalid");
        nameError.textContent = "Please enter your name.";
        valid = false;
      }

      // Email validation
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email.value)) {
        email.classList.add("is-invalid");
        emailError.textContent = "Please enter a valid email address.";
        valid = false;
      }

      // Address validation
      if (address.value.trim() === "") {
        address.classList.add("is-invalid");
        addressError.textContent = "Please enter your address.";
        valid = false;
      }

      // Image validation
      if (image.files.length === 0) {
        image.classList.add("is-invalid");
        imageError.textContent = "Please upload an image.";
        valid = false;
      }

      // Password validation
      if (password.value.trim() === "") {
        password.classList.add("is-invalid");
        passwordError.textContent = "Please provide a password.";
        valid = false;
      }

      if (!valid) {
        event.preventDefault(); // Prevent form submission
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
</style>
