<?php
include '../includes/db.php';
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
}
header('Location: categories.php');
exit();
