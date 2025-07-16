<?php
session_start();
require 'config.php';

// Check admin logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $venue = $_POST['venue'];
    $event_date = $_POST['event_date'];
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO events (title, description, venue, event_date, created_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $venue, $event_date, $created_by);

    if ($stmt->execute()) {
        $message = "event created successful!";
    } else {
        $message = "something happen try again: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
    <style>
        body {
            font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px;
        }
        .container {
            max-width: 500px; background: #fff; padding: 20px; margin: auto; border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, textarea {
            width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff; color: white; border: none; cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-bottom: 15px; color: green;
        }
        a.back {
            display: inline-block; margin-top: 15px; text-decoration: none; color: #007bff;
        }
        a.back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create New Event</h2>
    <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" rows="4" required></textarea>
        <input type="text" name="venue" placeholder="Venue" required>
        <input type="date" name="event_date" required>
        <input type="submit" value="Create Event">
    </form>
    <a href="admin_dashboard.php" class="back">Back to Dashboard</a>
</div>

</body>
</html>
