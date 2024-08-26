<?php
session_start();
if(isset($_SESSION['uname'])){
    echo "<script>
    alert('Already Logged In..');
    location.assign('index.php');
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="#" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Dashboard</h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>

                        <form id="signinForm" method="POST" action="Code.php">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com">
                                <label for="email">Email address</label>
                                <div id="emailError" class="invalid-feedback"></div>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                <label for="password">Password</label>
                                <div id="passwordError" class="invalid-feedback"></div>
                            </div>
                            <button type="submit" name="login" class="btn btn-info py-3 w-100 mb-4">Sign In</button>
                        </form>
                        <p><a href="../index.php">⬅️ Back to website</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("signinForm");
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
            if (email.value.trim() === "") {
                email.classList.add("is-invalid");
                emailError.textContent = "Email is required.";
                valid = false;
            } else if (!validateEmail(email.value)) {
                email.classList.add("is-invalid");
                emailError.textContent = "Please enter a valid email address.";
                valid = false;
            }

            // Password validation
            if (password.value.trim() === "") {
                password.classList.add("is-invalid");
                passwordError.textContent = "Password is required.";
                valid = false;
            }

            if (!valid) {
                event.preventDefault(); // Prevent form submission
            }
        });

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }
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
</body>

</html>
