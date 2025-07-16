<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Invalid request: no registration ID provided.");
}

$id = intval($_GET['id']);

// Fanya update ya approved = 1
$sql = "UPDATE registrations SET approved = 1 WHERE id = $id";
if (!mysqli_query($conn, $sql)) {
    die("Error approving certificate: " . mysqli_error($conn));
}

// Rudisha kwenye orodha ukiwa na ujumbe wa mafanikio
header("Location: approve_certificate_all.php?approved=1");
exit();
?>
