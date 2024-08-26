<?php
include('includes/header.php');

// Fetching order data
if (isset($_GET['revieworder_id'])) {
    $orderid = $_GET['revieworder_id'];

    $query = "SELECT 
                o.order_id, 
                o.pro_id, 
                p.name AS pro_name, 
                p.product_id, 
                o.quantity,
                o.price,
                p.image AS product_image
              FROM orders o
              INNER JOIN products p ON o.pro_id = p.product_id
              WHERE o.order_id = :order_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':order_id', $orderid, PDO::PARAM_INT);
    $stmt->execute();

    $orderdata = $stmt->fetch(PDO::FETCH_ASSOC);
}

// User review submit query starts
if (isset($_POST['add_review'])) {
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $order_id = $orderdata['order_id'];
    $pro_id = $orderdata['pro_id'];

    $reviewinsertquery = "INSERT INTO reviews (review, rating, order_id, pro_id, user_id) VALUES (:review, :rating, :order_id, :pro_id, :user_id)";
    $stmt = $pdo->prepare($reviewinsertquery);

    $stmt->bindParam(':review', $review);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':pro_id', $pro_id);
    $stmt->bindParam(':user_id', $_SESSION['userid']);

    if ($stmt->execute()) {
        echo "<script>
        alert('Review submitted successfully!');
        location.assign('orders_view.php');
        </script>";
    } else {
        echo "<script>
        alert('Failed to submit review.');
        location.assign('orders_view.php');
        </script>";
    }
}
// User review submit query ends
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-4">
            <h3>Give a Review for</h3>

            <div class="row">
                <div class="col-lg-5 bg-primary p-3">
                    <p>Order ID: <?php echo $orderdata['order_id']; ?></p>
                    <p>Product ID: <?php echo $orderdata['pro_id']; ?></p>
                    <p>Product Name: <?php echo $orderdata['pro_name']; ?></p>
                    <p>Quantity: <?php echo $orderdata['quantity']; ?></p>
                    <p>Price: <?php echo $orderdata['price']; ?></p>
                    <img src="Dashboard/img/productimages/<?php echo $orderdata['product_image']; ?>" alt="Product Image" width="100px">
                </div>
                <div class="col-lg-7 bg-light p-3">
                    <h4>Give your Precious Review</h4>
                    <form id="reviewForm" method="POST">
                        <div class="form-group">
                            <label>Review</label>
                            <textarea id="review" class="form-control" name="review" rows="3" placeholder="Enter your review here"></textarea>
                            <div id="reviewError" class="invalid-feedback"></div>

                            <label>Rating</label>
                            <select id="rating" name="rating" class="form-control">
                                <option value="">Select Rating</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <div id="ratingError" class="invalid-feedback"></div>
                        </div>

                        <button type="submit" name="add_review" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("reviewForm");
    var review = document.getElementById("review");
    var rating = document.getElementById("rating");
    var reviewError = document.getElementById("reviewError");
    var ratingError = document.getElementById("ratingError");

    form.addEventListener("submit", function(event) {
      var valid = true;

      // Clear previous error messages
      review.classList.remove("is-invalid");
      rating.classList.remove("is-invalid");
      reviewError.textContent = "";
      ratingError.textContent = "";

      // Review validation
      if (review.value.trim() === "") {
        review.classList.add("is-invalid");
        reviewError.textContent = "Review is required.";
        valid = false;
      }

      // Rating validation
      if (rating.value === "" || rating.value === null) {
        rating.classList.add("is-invalid");
        ratingError.textContent = "Rating is required.";
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
