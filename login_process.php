<?php
session_start();
require 'config.php'; // Connection ya database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Tafuta mtumiaji kwa email
    $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ikiwa user yupo
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Thibitisha password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                // Redirect kulingana na role
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: student_dashboard.php");
                }
                exit();
            } else {
                echo "<script>alert('Wrong password.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('User not found.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }
}

$conn->close();
?>
