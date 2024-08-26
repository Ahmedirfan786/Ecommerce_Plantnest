<?php
include('header.php');

// Query to fetch feedbacks table data
$query = "
    SELECT * from feedbacks
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$feedbacks = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-3">
            <h3>View Feedbacks</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Feedback Id</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Feed Back</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?php echo $feedback['feedback_id']; ?></td>
                            <td><?php echo $feedback['name']; ?></td>
                            <td><?php echo $feedback['email']; ?></td>
                            <td><?php echo $feedback['feedback']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
