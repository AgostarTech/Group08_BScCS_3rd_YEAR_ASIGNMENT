<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_id'])) {
    $reg_id = intval($_POST['reg_id']);

    $sql = "UPDATE registrations SET approved = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reg_id);

    if ($stmt->execute()) {
        header("Location: approve_certificates.php?success=1");
        exit();
    } else {
        echo "Kushindwa kuidhinisha.";
    }
} else {
    echo "Taarifa hazijatimia.";
}
?>
