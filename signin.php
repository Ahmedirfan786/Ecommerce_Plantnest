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
                            <h3>Login Form</h3>
                        </div>
                        
                        <div class="divider d-flex align-items-center my-2"></div>

                        <form id="loginForm" method="POST" action="Code.php">

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control form-control-lg"
                                    placeholder="Enter a valid email address" />
                                <label class="form-label" for="email">Email address</label>
                                <div id="emailError" class="invalid-feedback"></div>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input type="password" id="password" name="password" class="form-control form-control-lg"
                                    placeholder="Enter password" />
                                <label class="form-label" for="password">Password</label>
                                <div id="passwordError" class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    Don't have an account <a href="signup.php">Click here!</a>
                                </div>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" name="login" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
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
    var form = document.getElementById("loginForm");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var emailError = document.getElementById("emailError");
    var passwordError = document.getElementById("passwordError");

    form.addEventListener("submit", function(event) {
      var valid = true;

      // Clear previous error messages
      email.classList.remove("is-invalid");
      password.classList.remove("is-invalid");
      emailError.textContent = "";
      passwordError.textContent = "";

      // Email validation
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email.value)) {
        email.classList.add("is-invalid");
        emailError.textContent = "Please enter a valid email address.";
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
