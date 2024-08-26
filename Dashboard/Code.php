<?php
session_start();
include('connection.php');


// Login Code

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $query=$pdo->prepare('select * from admin where email=:pemail && password=:ppass');
    $query->bindParam("pemail",$email);
    $query->bindParam("ppass",$password);
    $query->execute();
    $final = $query->fetch(PDO::FETCH_ASSOC);
    if ($final) {
        $_SESSION['adname'] = $final['name'];
        $_SESSION['adid'] = $final['id'];
        $_SESSION['adimage'] = $final['image'];
        echo "<script>
                alert('Logged in successfully');
                location.assign('index.php');
              </script>";
    } 
    else {
      echo "<script>
      alert('Invalid email or password');
      location.assign('signin.php');
      </script>";
  }
    
}


// Admin Profile update code is in manage profile.php 


// Add category Query Starts 

if(isset($_POST['cat_add'])){ 
    $cname=$_POST['cat_name'];
    $cdes=$_POST['cat_des'];
    $filename=$_FILES["cat_img"]['name'];
    $file_tmp_name=$_FILES['cat_img']['tmp_name'];
    $filesize=$_FILES['cat_img']['size'];
    $extension = pathinfo($filename,PATHINFO_EXTENSION);
    $destination='img/categoryimages/'.$filename;
    if($extension=="jpg" || $extension == "png" || $extension =="jpeg"){
        if(move_uploaded_file($file_tmp_name,$destination)){
            $checkcategory=$pdo->prepare("select * from categories where name=:pname");
            $checkcategory->bindParam("pname",$cname);
            $checkcategory->execute();
            $count = $checkcategory->fetchColumn();
            if($count>0){
                echo "<script>
                alert('Category Already Exists')
                </script>";
            }else{
                
                
                $query= $pdo->prepare("insert into categories (name,description,image) values (:pname,:pdes,:pimg)");
                $query->bindParam("pname",$cname);
                $query->bindParam("pdes",$cdes);
                $query->bindParam("pimg",$filename);
                $query->execute();
                echo"
                <script>
                alert('category added succesfully');
                location.assign('add_category.php');
                </script>
                ";
            }
        }
        else{
            echo"
            <script>
            alert('something went wrong')
            location.assign('add_category.php');
            </script>
            ";
        }
        
    }
}
// Add category Query Ends


// Update Category Query Starts
if (isset($_POST['cat_update'])) {
    $catid = $_POST['cat_id'];
    $cname = $_POST['cat_name'];
    $cdes = $_POST['cat_des'];
    $filename = $_FILES["cat_img"]['name'];
    $file_tmp_name = $_FILES['cat_img']['tmp_name'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $destination = 'img/categoryimages/' . $filename;

    // Fetch existing category data to retain the current image if no new image is uploaded
    $query = $pdo->prepare("SELECT image FROM categories WHERE category_id = :catid");
    $query->bindParam('catid', $catid);
    $query->execute();
    $currentData = $query->fetch(PDO::FETCH_ASSOC);
    $currentImage = $currentData['image'];

    if ($filename) {
        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
            if (move_uploaded_file($file_tmp_name, $destination)) {
                // Update with new image
                $query = $pdo->prepare("UPDATE categories SET name = :pname, description = :pdes, image = :pimg WHERE category_id = :catid");
                $query->bindParam("pimg", $filename);
                $alertMessage = 'Category updated with image';
            } else {
                echo "<script>alert('Image upload failed'); location.assign('edit_category.php?catid=$catid');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid image format'); location.assign('edit_category.php?catid=$catid');</script>";
            exit;
        }
    } else {
        // Update without changing the image
        $query = $pdo->prepare("UPDATE categories SET name = :pname, description = :pdes WHERE category_id = :catid");
        $alertMessage = 'Category updated without image';
    }

    $query->bindParam("pname", $cname);
    $query->bindParam("pdes", $cdes);
    $query->bindParam("catid", $catid);
    $query->execute();

    echo "<script>
    alert('$alertMessage');
    location.assign('view_categories.php');
    </script>";
}
// Update Category Query Ends



// Category Delete Query Starts
if(isset($_GET['delcatid'])){
    $catid=$_GET['delcatid'];
    $catdelquery=$pdo->prepare("DELETE FROM categories WHERE category_id = :catid");
    $catdelquery->bindParam('catid',$catid);

    if($catdelquery->execute()){
        echo "<script>
        alert('Category #$catid Deleted');
        location.assign('view_categories.php');
        </script>";
    }
    else{
        echo "<script>
        alert('Category #$catid Didnot Deleted');
        location.assign('view_categories.php');
        </script>";

    }
}
// Category Delete Query Ends


// Category Disable Code Starts

if(isset($_GET['discat_id'])){
    $discatid=$_GET['discat_id'];

    $query=$pdo->prepare('update categories set status = 0 where category_id = :discatid');
    $query->bindParam('discatid',$discatid);
    $query->execute();

    echo "
    <script>
    alert('Category #.$discatid. Disabled');
    location.assign('view_categories.php');
    </script>
    ";

}

// Category Disable Code Ends


// Category Enable Code Starts

if(isset($_GET['enbcat_id'])){
    $enbcatid=$_GET['enbcat_id'];

    $query=$pdo->prepare('update categories set status = 1 where category_id = :enbcatid');
    $query->bindParam('enbcatid',$enbcatid);
    $query->execute();

    echo "
    <script>
    alert('Category #.$enbcatid. Enabled');
    location.assign('view_categories.php');
    </script>
    ";

}

// Category Enable Code Ends




// Add Subcategory Query Starts 
if (isset($_POST['subcat_add'])) {
    $subcatName = $_POST['subcat_name'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['subcat_description'];
    $filename = $_FILES["subcat_img"]['name'];
    $fileTmpName = $_FILES['subcat_img']['tmp_name'];
    $fileSize = $_FILES['subcat_img']['size'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $destination = 'img/subcategoryimages/' . $filename;

    if ($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
        if (move_uploaded_file($fileTmpName, $destination)) {
            $query = $pdo->prepare("INSERT INTO subcategories (name, description, image, cat_id) VALUES (:pname, :pdes, :pimg, :pcat)");
            $query->bindParam("pname", $subcatName);
            $query->bindParam("pdes", $description);
            $query->bindParam("pimg", $filename);
            $query->bindParam("pcat", $categoryId);
            $query->execute();
            echo "
            <script>
            alert('Subcategory added successfully');
            location.assign('add_subcategory.php');
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Image upload failed');
            location.assign('add_subcategory.php');
            </script>
            ";
        }
    } else {
        echo "
        <script>
        alert('Invalid image format');
        location.assign('add_subcategory.php');
        </script>
        ";
    }
}
// Add Subcategory Query Ends



// Update Subcategory Query Starts
if (isset($_POST['subcat_update'])) {
    $subcatid = $_POST['subcat_id'];
    $subcatName = $_POST['subcat_name'];
    $description = $_POST['subcat_description'];
    $categoryId = $_POST['category_id'];
    $filename = $_FILES["subcat_img"]['name'];
    $fileTmpName = $_FILES['subcat_img']['tmp_name'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $destination = 'img/subcategoryimages/' . $filename;

    // Fetch existing subcategory data to retain the current image if no new image is uploaded
    $query = $pdo->prepare("SELECT image FROM subcategories WHERE subcategory_id = :subcatid");
    $query->bindParam('subcatid', $subcatid);
    $query->execute();
    $currentData = $query->fetch(PDO::FETCH_ASSOC);
    $currentImage = $currentData['image'];

    if ($filename) {
        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
            if (move_uploaded_file($fileTmpName, $destination)) {
                // Update with new image
                $query = $pdo->prepare("UPDATE subcategories SET name = :pname, description = :pdes, image = :pimg, cat_id = :pcat WHERE subcategory_id = :subcatid");
                $query->bindParam("pimg", $filename);
                $alertMessage = 'Subcategory updated with image';
            } else {
                echo "<script>alert('Image upload failed'); location.assign('edit_subcategory.php?edit_subcat=$subcatid');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid image format'); location.assign('edit_subcategory.php?edit_subcat=$subcatid');</script>";
            exit;
        }
    } else {
        // Update without changing the image
        $query = $pdo->prepare("UPDATE subcategories SET name = :pname, description = :pdes, cat_id = :pcat WHERE subcategory_id = :subcatid");
        $alertMessage = 'Subcategory updated without image';
    }

    $query->bindParam("pname", $subcatName);
    $query->bindParam("pdes", $description);
    $query->bindParam("pcat", $categoryId);
    $query->bindParam("subcatid", $subcatid);
    $query->execute();

    echo "<script>
    alert('$alertMessage');
    location.assign('view_subcategories.php');
    </script>";
}
// Update Subcategory Query Ends




// Delete Subcategory Query Starts
if(isset($_GET['delsubcatid'])){
    $subcatid=$_GET['delsubcatid'];
    $subcatdelquery=$pdo->prepare("DELETE FROM subcategories WHERE subcategory_id = :subcatid");
    $subcatdelquery->bindParam('subcatid',$subcatid);

    if($subcatdelquery->execute()){
        echo "<script>
        alert('SubCategory #$subcatid Deleted');
        location.assign('view_subcategories.php');
        </script>";
    }
    else{
        echo "<script>
        alert('SubCategory #$subcatid Didnot Deleted');
        location.assign('view_subcategories.php');
        </script>";

    }
}
// Delete Subcategory Query Ends





// Sub Category Disable Code Starts

if(isset($_GET['dissubcatid'])){
    $dissubcatid=$_GET['dissubcatid'];

    $query=$pdo->prepare('update subcategories set status = 0 where subcategory_id = :dissubcatid');
    $query->bindParam('dissubcatid',$dissubcatid);
    $query->execute();

    echo "
    <script>
    alert('Sub Category #.$dissubcatid. Disabled');
    location.assign('view_subcategories.php');
    </script>
    ";

}

// Sub Category Disable Code Ends


// Sub Category Enable Code Starts

if(isset($_GET['enbsubcatid'])){
    $enbsubcatid=$_GET['enbsubcatid'];

    $query=$pdo->prepare('update subcategories set status = 1 where subcategory_id = :enbsubcatid');
    $query->bindParam('enbsubcatid',$enbsubcatid);
    $query->execute();

    echo "
    <script>
    alert('SubCategory #.$enbsubcatid. Enabled');
    location.assign('view_subcategories.php');
    </script>
    ";

}

// Sub Category Enable Code Ends







// Add Product Code Starts
if (isset($_POST['product_add'])) {
    // Extract form data
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productShortInfo = $_POST['product_short_info'];
    $productDescription = $_POST['product_description'];
    $productAvailability = $_POST['product_availability'];
    $categoryId = $_POST['category_id'];
    $subcategoryId = $_POST['subcategory_id'];
    
    // Initialize variable for image name
    $imageName = '';
    
    // Handle file upload
    if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'img/productimages/'; // Directory where the image will be stored
        $uploadFile = $uploadDir . basename($_FILES['product_img']['name']);
        $imageName = basename($_FILES['product_img']['name']);
        
        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Move the uploaded file
        if (move_uploaded_file($_FILES['product_img']['tmp_name'], $uploadFile)) {
            // File uploaded successfully
        } else {
            die('Failed to upload file.');
        }
    }
    
    // Prepare SQL query for insertion
    $query = "INSERT INTO products (name, price, short_info, description, availibility, image, status, cat_id, subcat_id) 
              VALUES (:product_name, :product_price, :product_short_info, :product_description, :product_availability, :product_img, :status, :category_id, :subcategory_id)";
    
    $stmt = $pdo->prepare($query);
    
    // Bind parameters
    $status = 1; // Assuming the default status is 1 (Active)
    $stmt->bindParam(':product_name', $productName);
    $stmt->bindParam(':product_price', $productPrice);
    $stmt->bindParam(':product_short_info', $productShortInfo);
    $stmt->bindParam(':product_description', $productDescription);
    $stmt->bindParam(':product_availability', $productAvailability);
    $stmt->bindParam(':product_img', $imageName);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->bindParam(':subcategory_id', $subcategoryId);
    
    // Execute query
    if ($stmt->execute()) {
        echo '<script>alert("Product added successfully!"); window.location.href="add_product.php";</script>';
    } else {
        echo '<script>alert("Failed to add product."); window.location.href="add_product.php";</script>';
    }
} 
// Add Product Code Ends






// Update Product Code Starts
// Check if the form is submitted
if (isset($_POST['product_update'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_short_info = $_POST['product_short_info'];
    $product_description = $_POST['product_description'];
    $product_availability = $_POST['product_availability'];
    $category_id = $_POST['category_id'];
    $subcategory_id = $_POST['subcategory_id'];

    // Handle file upload
    $image_name = $_FILES['product_img']['name'];
    $image_tmp_name = $_FILES['product_img']['tmp_name'];
    $image_size = $_FILES['product_img']['size'];
    $image_error = $_FILES['product_img']['error'];
    $image_type = $_FILES['product_img']['type'];
    
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $new_image_name = $product_id . '.' . $image_ext;
    $upload_directory = 'img/productimages/';

    if ($image_name) {
        // Check if image upload is successful
        if ($image_error === 0) {
            if (in_array($image_ext, $allowed_extensions)) {
                if ($image_size < 5000000) { // Limit file size to 5MB
                    $upload_path = $upload_directory . $new_image_name;

                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($image_tmp_name, $upload_path)) {
                        // Delete old image if exists
                        $old_image_query = "SELECT image FROM products WHERE product_id = :product_id";
                        $old_image_stmt = $pdo->prepare($old_image_query);
                        $old_image_stmt->execute([':product_id' => $product_id]);
                        $old_image = $old_image_stmt->fetchColumn();
                        if ($old_image && file_exists($upload_directory . $old_image)) {
                            unlink($upload_directory . $old_image);
                        }
                    } else {
                        echo "<script>
                        alert('Product updated Successfully :)');
                        location.assign('view_products.php');
                        </script>";
                    }
                } else {
                    echo "<script>
                        alert('Error File size excedd :(');
                        location.assign('edit_product.php');
                        </script>";
                }
            } else {
                echo "<script>
                        alert('Invalid Format :(');
                        location.assign('edit_product.php');
                        </script>";
            }
        } else {
            echo "<script>
                        alert('Upload Error :(');
                        location.assign('edit_product.php');
                        </script>";
        }
    } else {
        // If no new image is uploaded, retain the old image
        $new_image_name = $_POST['old_image'];
    }

    // Update product details in the database
    $update_query = "
        UPDATE products
        SET name = :product_name,
            price = :product_price,
            short_info = :product_short_info,
            description = :product_description,
            availibility = :product_availability,
            cat_id = :category_id,
            subcat_id = :subcategory_id,
            image = :image_name
        WHERE product_id = :product_id
    ";

    $update_stmt = $pdo->prepare($update_query);
    $update_result = $update_stmt->execute([
        ':product_name' => $product_name,
        ':product_price' => $product_price,
        ':product_short_info' => $product_short_info,
        ':product_description' => $product_description,
        ':product_availability' => $product_availability,
        ':category_id' => $category_id,
        ':subcategory_id' => $subcategory_id,
        ':image_name' => $new_image_name,
        ':product_id' => $product_id
    ]);

    if ($update_result) {
        echo "<script>
                        alert('Product Updated Successfully :)');
                        location.assign('view_products.php');
                        </script>";
    } else {
       echo "<script>
                        alert('Update Failed :(');
                        location.assign('edit_product.php');
                        </script>";
    }
}
// Update Product Code Ends



// Delete Product Query Starts
if(isset($_GET['delproid'])){
    $proid=$_GET['delproid'];
    $prodelquery=$pdo->prepare("DELETE FROM products WHERE product_id = :proid");
    $prodelquery->bindParam('proid',$proid);

    if($prodelquery->execute()){
        echo "<script>
        alert('Product #$proid Deleted');
        location.assign('view_products.php');
        </script>";
    }
    else{
        echo "<script>
        alert('Product #$proid Didnot Deleted');
        location.assign('view_products.php');
        </script>";

    }
}
// Delete Product Query Ends



// Product Disable Code Starts

if(isset($_GET['disproid'])){
    $disproid=$_GET['disproid'];

    $query=$pdo->prepare('update products set status = 0 where product_id = :disproid');
    $query->bindParam('disproid',$disproid);
    $query->execute();

    echo "
    <script>
    alert('Product #.$disproid. Disabled');
    location.assign('view_products.php');
    </script>
    ";

}

// Product Disable Code Ends


// Product Enable Code Starts

if(isset($_GET['enbproid'])){
    $enbproid=$_GET['enbproid'];

    $query=$pdo->prepare('update products set status = 1 where product_id = :enbproid');
    $query->bindParam('enbproid',$enbproid);
    $query->execute();

    echo "
    <script>
    alert('Product #.$enbproid. Enabled');
    location.assign('view_products.php');
    </script>
    ";

}

// Product Enable Code Ends



// Code to approve orders code start
if(isset($_GET['apprord_id'])){
    $approveorderid=$_GET['apprord_id'];
    
    // Approve order query
    $apprordquery=$pdo->prepare("Update orders set status = 'Approved' where order_id = :orderid ");
    $apprordquery->bindParam('orderid',$approveorderid);
    
    if($apprordquery->execute()){
        echo "<script>
        alert('Order Approved Successfully');
        location.assign('view_pending_orders.php');
        </script>";
    }
    else{
        echo "<script>
        alert('Order Didnt Approved :(');
        location.assign('view_pending_orders.php');
        </script>";
    }
    
}

// Code to approve orders code start



// Code to reject orders code starts
if(isset($_GET['rejord_id'])){
    $rejectorderid=$_GET['rejord_id'];
    
    // Approve order query
    $rejordquery=$pdo->prepare("Update orders set status = 'Rejected' where order_id = :orderid ");
    $rejordquery->bindParam('orderid',$rejectorderid);
    
    if($rejordquery->execute()){
        echo "<script>
        alert('Order Rejected !');
        location.assign('view_pending_orders.php');
        </script>";
    }
    else{
        echo "<script>
        alert('Order Didnt Rejected');
        location.assign('view_pending_orders.php');
        </script>";
    }
    
}
// Code to reject orders code ends


// Code to set orders status from Approved to Ontheway code starts
if(isset($_GET['stonwyord_id'])){
    $setorderonthewayid=$_GET['stonwyord_id'];
    
    // Approve order query
    $setonthewayquery=$pdo->prepare("Update orders set status = 'Ontheway' where order_id = :orderid ");
    $setonthewayquery->bindParam('orderid',$setorderonthewayid);
    
    if($setonthewayquery->execute()){
        echo "<script>
        alert('Order Set on the way :) ');
        location.assign('view_approved_orders.php');
        </script>";
    }
    else{
        echo "<script>
        alert('Order Didnt Set on the way :( ');
        location.assign('view_approved_orders.php');
        </script>";
    }
    
}
// Code to set orders status from Approved to Ontheway code ends


// Code to set orders status from Ontheway to Delivered code starts
if(isset($_GET['dlvord_id'])){
    $setorderdeliveredid=$_GET['dlvord_id'];
    
    // Approve order query
    $setorderdeliveredquery=$pdo->prepare("Update orders set status = 'Delivered' where order_id = :orderid ");
    $setorderdeliveredquery->bindParam('orderid',$setorderdeliveredid);
    
    if($setorderdeliveredquery->execute()){
        echo "<script>
        alert('Order Delivered :) ');
        location.assign('view_ontheway_orders.php');
        </script>";
    }
    else{
        echo "<script>
        alert('Order Didnt Deliverd :( ');
        location.assign('view_ontheway_orders.php');
        </script>";
    }
    
}
// Code to set orders status from Ontheway to Delivered code ends

?>