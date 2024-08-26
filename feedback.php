<?php
include('includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-4">
            <h3>Feedback Form</h3>

            <form id="feedbackForm" method="POST" action="Code.php">
                <?php
                if (isset($_SESSION['username'])) {
                    $useremailquery = $pdo->prepare('SELECT email FROM users WHERE user_id = :userid');
                    $useremailquery->bindParam('userid', $_SESSION['userid']);
                    $useremailquery->execute();
                    $useremail = $useremailquery->fetch(PDO::FETCH_ASSOC);
                ?>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $useremail['email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="feedbackuser">Feedback</label>
                        <textarea id="feedbackuser" class="form-control" rows="3" name="feedback" placeholder="Please give your feedback here"></textarea>
                        <div id="feedbackError2" class="invalid-feedback"></div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name">
                        <div id="nameError" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                        <div id="emailError" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="feedbackguest">Feedback</label>
                        <textarea id="feedbackguest" class="form-control" rows="3" name="feedback" placeholder="Please give your feedback here"></textarea>
                        <div id="feedbackError" class="invalid-feedback"></div>
                    </div>
                <?php
                }
                ?>
                
                <button type="submit" name="submit_feedback" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("feedbackForm");
    var name = document.getElementById("name");
    var email = document.getElementById("email");
    var feedbackUser = document.getElementById("feedbackuser");
    var feedbackGuest = document.getElementById("feedbackguest");
    var nameError = document.getElementById("nameError");
    var emailError = document.getElementById("emailError");
    var feedbackErrorUser = document.getElementById("feedbackError2");
    var feedbackErrorGuest = document.getElementById("feedbackError");

    form.addEventListener("submit", function(event) {
      var valid = true;

      // Clear previous error messages
      if (name) name.classList.remove("is-invalid");
      if (email) email.classList.remove("is-invalid");
      if (feedbackUser) feedbackUser.classList.remove("is-invalid");
      if (feedbackGuest) feedbackGuest.classList.remove("is-invalid");
      if (nameError) nameError.textContent = "";
      if (emailError) emailError.textContent = "";
      if (feedbackErrorUser) feedbackErrorUser.textContent = "";
      if (feedbackErrorGuest) feedbackErrorGuest.textContent = "";

      // Name validation
      if (name && name.value.trim() === "") {
        name.classList.add("is-invalid");
        nameError.textContent = "Name is required.";
        valid = false;
      }

      // Email validation
      if (email) {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value.trim())) {
          email.classList.add("is-invalid");
          emailError.textContent = "Please enter a valid email address.";
          valid = false;
        }
      }

      // Feedback validation
      if (feedbackUser && feedbackUser.value.trim() === "") {
        feedbackUser.classList.add("is-invalid");
        feedbackErrorUser.textContent = "Feedback is required.";
        valid = false;
      }

      if (feedbackGuest && feedbackGuest.value.trim() === "") {
        feedbackGuest.classList.add("is-invalid");
        feedbackErrorGuest.textContent = "Feedback is required.";
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
