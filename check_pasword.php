<?php
$hash = '$2y$10$nSbaS8yBGl4XnluuqN3ClOfQ.NGq/N3m1XpB2r2AKsJ/k8L0/EB/q';

// Badilisha hapa password unayotaka kujaribu
$passwordsToTest = ['123', 'password', 'admin123', 'yourpassword', 'test123'];

foreach ($passwordsToTest as $password) {
    if (password_verify($password, $hash)) {
        echo "Password is: " . $password;
        exit;
    }
}

echo "Password not found in tested list.";
?>
