<?php
include '../includes/db.php';
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM services WHERE id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
}
header('Location: services.php');
exit();
