<?php
session_start();
include('Dashboard/connection.php');


//Sign up code
if(isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $image_name = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $file_size = $_FILES['image']['size'];
    $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $destination = 'Dashboard/img/userimages/' . $image_name;

    if($file_extension == "jpg" || $file_extension == "png" || $file_extension == "jpeg" || $file_extension == "webp") {
        if(move_uploaded_file($image_temp, $destination)) {
            $checkuser = $pdo->prepare("SELECT * FROM users WHERE email=:email");
            $checkuser->bindParam("email", $email);
            $checkuser->execute();
            $count = $checkuser->fetchColumn();
            if($count > 0) {
                echo "<script>
                alert('Email already exists');
                location.assign('signup.php');
                </script>";
            } else {
                $query = $pdo->prepare("INSERT INTO users (name, email, password, address, image) VALUES (:name, :email, :password, :address, :image)");
                $query->bindParam("name", $name);
                $query->bindParam("email", $email);
                $query->bindParam("password", $password);
                $query->bindParam("address", $address);
                $query->bindParam("image", $image_name);
                if($query->execute()) {
                    echo "<script>
                    alert('Signup Successful');
                    location.assign('signin.php');
                    </script>";
                } else {
                    echo "<script>
                    alert('Signup Unsuccessful');
                    location.assign('signup.php');
                    </script>";
                }
            }
        } else {
            echo "<script>
            alert('Image Upload Failed');
            location.assign('signup.php');
            </script>";
        }
    } else {
        echo "<script>
        alert('Invalid image format. Only PNG, JPEG, JPG, and WEBP are allowed.');
        location.assign('signup.php');
        </script>";
    }
}


// Sign in code
if(isset($_POST['login'])){
$email=$_POST['email'];
$password=$_POST['password'];


$loginquery=$pdo->prepare('Select * from users where email = :email and password = :password');
$loginquery->bindParam('email',$email);
$loginquery->bindParam('password',$password);
$loginquery->execute();

$final = $loginquery->fetch(PDO::FETCH_ASSOC);

if ($final) {
    $_SESSION['username'] = $final['name'];
    $_SESSION['userimage'] = $final['image'];
    $_SESSION['userid'] = $final['user_id'];
    
    echo "<script>
    alert('Logged in Successfully " . $_SESSION['username'] . "');
    location.assign('index.php');
    </script>";
}
else{
    echo "<script>
alert('Invalid username or password');
location.assign('signin.php');
</script>";
}

}



// User profile update code starts
if (isset($_POST['update_profile'])) {
    // Fetch form data
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $password = htmlspecialchars($_POST['password']);
    $user_id = $_SESSION['userid']; // Get the user ID from the session

    // Handle the uploaded image
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_query = ""; // Initialize image query part

    if ($image) {
        // Check the file extension
        $file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($file_extension, $allowed_extensions)) {
            // Move the uploaded image to the desired directory
            $target_directory = "Dashboard/img/userimages/";
            $target_file = $target_directory . basename($image);

            if (move_uploaded_file($image_temp, $target_file)) {
                // Prepare the query part for updating the image
                $image_query = ", image = :image";
            } else {
                echo "<script>
                alert('Failed to upload image.');
                location.assign('profile.php');
                </script>";
                exit;
            }
        } else {
            echo "<script>
            alert('Invalid image format. Only JPG, JPEG, PNG, and WEBP are allowed.');
            location.assign('profile.php');
            </script>";
            exit;
        }
    }

    // Prepare the SQL query for updating the user profile
    $stmt = $pdo->prepare("UPDATE users SET name = :name, address = :address, password = :password $image_query WHERE user_id = :user_id");

    // Bind the parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':user_id', $user_id);

    if ($image) {
        $stmt->bindParam(':image', $image);
    }

    // Execute the update query
    if ($stmt->execute()) {
        // Update session variables if the profile is updated successfully
        $_SESSION['username'] = $name;
        if ($image) {
            $_SESSION['userimage'] = $image;
        }
        echo "<script>
        alert('Profile updated successfully');
        location.assign('index.php');
        </script>";
    } else {
        echo "<script>
        alert('Failed to update profile.');
        location.assign('manage_profile.php');
        </script>";
    }
}
// User profile update code ends




// Wishlist item remove code
if (isset($_GET['wishlistid'])) {
    $wishlist_id = $_GET['wishlistid'];

    $query = $pdo->prepare('DELETE FROM wishlist WHERE wishlist_id = :wishlist_id');
    $query->bindParam(':wishlist_id', $wishlist_id);

    if ($query->execute()) {
        echo "<script>
        alert('Item removed from wishlist');
        location.assign('wishlist_view.php');
        </script>";
    } else {
        echo "<script>
        alert('Error occured while removing Item from wishlist');
        location.assign('wishlist_view.php');
        </script>";
    }
    exit();
}




// From wishlist add to cart code and remove from wishlist code


// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    if (isset($_GET['wlistproid'])) {
        $wishlist_id = intval($_GET['wlistproid']);
        $user_id = intval($_SESSION['userid']);

        // Get the product details from the wishlist
        $query = $pdo->prepare('SELECT pro_id FROM wishlist WHERE wishlist_id = :wishlist_id AND user_id = :user_id');
        $query->bindParam(':wishlist_id', $wishlist_id, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $product_id = $item['pro_id'];

            // Check if the product is already in the cart
            $query = $pdo->prepare('SELECT * FROM cart WHERE pro_id = :product_id AND user_id = :user_id');
            $query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->execute();
            $cartItem = $query->fetch(PDO::FETCH_ASSOC);

            if (!$cartItem) {
                // Add the product to the cart
                $query = $pdo->prepare('INSERT INTO cart (price, quantity, pro_id, user_id) 
                                        SELECT price, 1, product_id, :user_id FROM products WHERE product_id = :product_id');
                $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $query->execute();

                // Remove the product from the wishlist
                $query = $pdo->prepare('DELETE FROM wishlist WHERE wishlist_id = :wishlist_id');
                $query->bindParam(':wishlist_id', $wishlist_id, PDO::PARAM_INT);
                $query->execute();

                echo "<script>
                alert('Product added from wishlist to cart');
                location.assign('wishlist_view.php');
                </script>";
            } else {
                echo "<script>
                alert('Product is already in the cart');
                location.assign('wishlist_view.php');
                </script>";
            }
        } else {
            echo "<script>
            alert('Wishlist item not found');
            location.assign('wishlist_view.php');
            </script>";
        }
    }

    // Handle the case where 'wlsitid' parameter is set for removing from wishlist
    if (isset($_GET['wlsitid'])) {
        $product_id = intval($_GET['wlsitid']);
        $user_id = intval($_SESSION['userid']);

        // Remove the product from the wishlist
        $query = $pdo->prepare('DELETE FROM wishlist WHERE pro_id = :product_id AND user_id = :user_id');
        $query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();

        echo "<script>
            alert('Product deleted from wishlist');
            location.assign('wishlist_view.php');
            </script>";
    }
}






// Add to cart code
if (isset($_POST['add_to_cart'])) {
    // Check if user is logged in
    if (isset($_SESSION['userid'])) {
        // Get form data
        $pro_id = $_POST['pro_id'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $userid = $_SESSION['userid'];

        // Prepare SQL query
        $stmt = $pdo->prepare("INSERT INTO cart (price, quantity, pro_id, user_id) VALUES (:price, :quantity, :pro_id, :user_id)");
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':pro_id', $pro_id);
        $stmt->bindParam(':user_id', $userid);

        // Execute query
        if ($stmt->execute()) {
            echo "<script>alert('Product added to cart successfully!'); window.location.href = 'product_detail.php?proid=$pro_id';</script>";
        } else {
            echo "<script>alert('Failed to add product to cart.'); window.location.href = 'product_detail.php?proid=$pro_id';</script>";
        }
    } else {
        // Redirect to sign-in page if user is not logged in
        echo "<scrip>alert('Please log in to add products to the cart.'); window.location.href = 'signin.php';</scrip>";
    }
}




// Product/Item remove from cart code 

if (isset($_GET['cartpro_id'])) {
    $cartproid = $_GET['cartpro_id'];

        $userid = $_SESSION['userid'];

        $itemremovequery = $pdo->prepare('DELETE FROM cart WHERE pro_id = :pro_id AND user_id = :user_id');
        $itemremovequery->bindParam(':pro_id', $cartproid);
        $itemremovequery->bindParam(':user_id', $userid);

        if ($itemremovequery->execute()) {
            echo "<script>
            alert('Item removed from cart');
            location.assign('cart.php');
            </script>";
        } else {
            echo "<script>
            alert('Item did not remove from cart');
            location.assign('cart.php');
            </script>";
        }
  
}




// User order cancel code start
if(isset($_GET['cancelorder_id'])){
    $cancelorderid=$_GET['cancelorder_id'];
    
    // Cancel order query
    $cancelorderquery=$pdo->prepare("Update orders set status = 'Cancelled' where order_id = :orderid ");
    $cancelorderquery->bindParam('orderid',$cancelorderid);
    
    if($cancelorderquery->execute()){
        echo "<script>
        alert('Order Cancelled Successfully :) ');
        location.assign('orders_view.php');
        </script>";
    }
    else{
        echo "<script>
        alert('Order Didnt Cancelled :( ');
        location.assign('orders_view.php');
        </script>";
    }
    
}
// User order cancel code ends 





// Feedback Submit code starts here

if (isset($_POST['submit_feedback'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];
    
    $sql = "INSERT INTO feedbacks (name, email, feedback) VALUES (:name, :email, :feedback)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':feedback', $feedback);
    
    if ($stmt->execute()) {
        echo "
        <script>
        alert('Feedback Submitted Successfully :) ');
        location.assign('index.php');
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Feedback Didnt Submitted :( ');
        location.assign('index.php');
        </script>
        ";
    }
}

// Feedback Submit code ends here


?>



