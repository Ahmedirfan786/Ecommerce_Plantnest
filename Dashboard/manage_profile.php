<?php
include('header.php');

// Check if the admin is logged in
if (!isset($_SESSION['adid'])) {
    echo "Please log in first.";
    exit;
}

$admin_id = $_SESSION['adid'];
$query = "SELECT * FROM admin WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $admin_id);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

$errors = [];

if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);

    // Server-side validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Handle image upload
    $image_query = "";
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "img/adminimages/" . basename($image);

        $fileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        $validImageTypes = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($fileType, $validImageTypes)) {
            $errors[] = "Please upload a valid image file (JPG, JPEG, PNG, GIF).";
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image_query = ", image = :image";
            } else {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    // If no errors, proceed with the update
    if (empty($errors)) {
        $update_query = "UPDATE admin SET name = :name, password = :password" . $image_query . " WHERE id = :id";
        $stmt = $pdo->prepare($update_query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        if (!empty($_FILES['image']['name'])) {
            $stmt->bindParam(':image', $image);
        }
        $stmt->bindParam(':id', $admin_id);

        if ($stmt->execute()) {
            echo "<script>
            alert('Admin profile updated successfully');
            location.assign('logout.php');
            </script>";
        } else {
            $errors[] = "Failed to update profile.";
        }
    }
}
?>

<div class="container">
    <h2>Manage Profile</h2>
    <?php
    if (!empty($errors)) {
        echo '<div class="alert alert-danger">';
        foreach ($errors as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
    }
    ?>
    <form action="manage_profile.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($admin['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($admin['password']); ?>">
        </div>
        <div class="form-group">
            <label for="image">Profile Image:</label>
            <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)">
            <br>
            <img id="imagePreview" src="img/adminimages/<?php echo htmlspecialchars($admin['image']); ?>" alt="Profile Image" width="100" height="100" style="display: block;">
        </div>
        <button type="submit" name="update_profile" class="btn btn-primary mt-2">Update Profile</button>
    </form>
</div>

<script>
function validateForm() {
    var name = document.getElementById('name').value.trim();
    var password = document.getElementById('password').value.trim();
    var image = document.getElementById('image').value;
    var valid = true;
    var errorMessage = '';

    if (name === '') {
        errorMessage += 'Name is required.\n';
        valid = false;
    }

    if (password === '') {
        errorMessage += 'Password is required.\n';
        valid = false;
    } else if (password.length < 6) {
        errorMessage += 'Password must be at least 6 characters long.\n';
        valid = false;
    }

    if (image !== '') {
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(image)) {
            errorMessage += 'Please upload a valid image file (JPG, JPEG, PNG, GIF).\n';
            valid = false;
        }
    }

    if (!valid) {
        alert(errorMessage);
    }

    return valid;
}

function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block'; // Ensure the image is visible
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php
include('footer.php');
?>
