<?php
require 'config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role']; // admin au student

// Hash password kabla ya kuhifadhi
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Angalia kama email tayari ipo
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Email exist. use other. <a href='register.php'>Rudi</a>";
    exit();
}
$stmt->close();

// Andika user mpya
$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

if ($stmt->execute()) {
    echo "registration successful! <a href='login.php'>Ingia hapa</a>";
} else {
    echo "something happen: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
