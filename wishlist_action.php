<?php
session_start();
include('Dashboard/connection.php'); // Ensure this file properly initializes `$pdo`


if (isset($_SESSION['userid']) && isset($_POST['product_id']) && isset($_POST['action'])) {
    $user_id = $_SESSION['userid'];
    $product_id = intval($_POST['product_id']);
    $action = $_POST['action'];

    if ($action === 'add') {
        $stmt = $pdo->prepare("INSERT INTO wishlist (pro_id, user_id) VALUES (?, ?)");
        $stmt->execute([$product_id, $user_id]);
        echo "<script>
        alert('Product added to wishlist');
        location.assign('shop.php');
        </script>";
    } elseif ($action === 'remove') {
        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE pro_id = ? AND user_id = ?");
        $stmt->execute([$product_id, $user_id]);
        echo "<script>
        alert('Product Removed to wishlist');
        location.assign('shop.php');
        </script>";
    }
}
?>
