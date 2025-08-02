<?php
include '../includes/db.php';
if (isset($_GET['id'])) {
    // Delete from provider_profiles first
    $stmt = $conn->prepare("DELETE FROM provider_profiles WHERE user_id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    // Then delete from users
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
}
header('Location: providers.php');
exit();
