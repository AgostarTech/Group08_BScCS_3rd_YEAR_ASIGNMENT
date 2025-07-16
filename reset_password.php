<?php
require 'config.php'; // Connection yako ya DB

// Taarifa za reset password
$newPassword = 'newpassword123';  // Password mpya unayotaka kuweka
$userEmail = 'soudshaab@gmail.com';  // Email ya user unayetaka kubadilisha password

// Hash ya password mpya
$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

// Prepare update statement
$sql = "UPDATE users SET password = ? WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database prepare error: " . $conn->error);
}

// Bind parameters na execute
$stmt->bind_param('ss', $newHash, $userEmail);

if ($stmt->execute()) {
    echo "Password imebadilishwa kwa mafanikio. Sasa tumia password mpya: '{$newPassword}' kuingia.";
} else {
    echo "Kosa: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
