<?php
session_start();
require 'config.php';

// Hakikisha admin ameingia
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Pata taarifa za admin sasa hivi (email pekee)
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found");
}

// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($email)) {
        $message = "Email hawezi kuwa tupu.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email si sahihi.";
    } elseif (!empty($password) && $password !== $confirm_password) {
        $message = "Password hazilingani.";
    } else {
        // Update database
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssi", $email, $password_hash, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmt->bind_param("si", $email, $user_id);
        }
        if ($stmt->execute()) {
            $message = "Taarifa zimehifadhiwa kwa mafanikio.";
            $_SESSION['email'] = $email;  // Sasisha session email kama unaitumia
        } else {
            $message = "Kuna tatizo katika kuhifadhi taarifa: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Account Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 20px;
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            margin-top: 15px;
            text-align: center;
            color: green;
        }
        .error {
            color: red;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Account Settings</h2>

    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'tatizo') !== false ? 'error' : '' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>

        <label for="password">Password mpya (acha tupu kama hutaki kubadilisha):</label>
        <input type="password" name="password" id="password" placeholder="Password mpya">

        <label for="confirm_password">Thibitisha Password mpya:</label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Thibitisha password">

        <button type="submit">Hifadhi Mabadiliko</button>
    </form>

    <a href="admin_dashboard.php">← Rudi Dashboard</a>
</div>

</body>
</html>
