<?php
include('includes/header.php');

// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];

    // Fetch user data from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_name = htmlspecialchars($user['name']);
        $user_email = htmlspecialchars($user['email']);
        $user_address = htmlspecialchars($user['address']);
        $user_image = htmlspecialchars($user['image']);
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "User is not logged in.";
    exit;
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-4">
            <h1>Manage Profile</h1>

            <div class="row">
                <div class="col-lg-4 p-3">
                    <img id="previmg" src="Dashboard/img/userimages/<?php echo $user_image; ?>" height="400" width="100%" alt="User Image">
                </div>
                <div class="col-lg-8">
                    <form id="profileForm" action="Code.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $user_name; ?>">
                            <div id="nameError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $user_email; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" id="address" name="address" class="form-control" value="<?php echo $user_address; ?>">
                            <div id="addressError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" id="image" name="image" class="form-control" onchange="previewImage(event)">
                            <div id="imageError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password (leave blank to keep current)">
                            <div id="passwordError" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("profileForm");
    var name = document.getElementById("name");
    var address = document.getElementById("address");
    var image = document.getElementById("image");
    var password = document.getElementById("password");

    var nameError = document.getElementById("nameError");
    var addressError = document.getElementById("addressError");
    var imageError = document.getElementById("imageError");
    var passwordError = document.getElementById("passwordError");

    form.addEventListener("submit", function(event) {
        var valid = true;

        // Clear previous error messages
        name.classList.remove("is-invalid");
        address.classList.remove("is-invalid");
        image.classList.remove("is-invalid");
        password.classList.remove("is-invalid");

        nameError.textContent = "";
        addressError.textContent = "";
        imageError.textContent = "";
        passwordError.textContent = "";

        // Name validation
        if (name.value.trim() === "") {
            name.classList.add("is-invalid");
            nameError.textContent = "Name is required.";
            valid = false;
        }

        // Address validation
        if (address.value.trim() === "") {
            address.classList.add("is-invalid");
            addressError.textContent = "Address is required.";
            valid = false;
        }

        // Image validation
        var file = image.files[0];
        if (file && !file.type.startsWith('image/')) {
            image.classList.add("is-invalid");
            imageError.textContent = "Please upload a valid image file.";
            valid = false;
        }

        // Password validation (if provided)
        if (password.value.trim() !== "" && password.value.length < 6) {
            password.classList.add("is-invalid");
            passwordError.textContent = "Password must be at least 6 characters long.";
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission
        }
    });
});

function previewImage(event) {
    var output = document.getElementById('previmg');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src);
    }
}
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

<?php
include('includes/footer.php');
?>
