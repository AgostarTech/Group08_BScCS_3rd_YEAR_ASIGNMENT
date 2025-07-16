<?php
session_start();
require 'config.php';

// Hakikisha mtumiaji ni admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Endapo form imetumwa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $created_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO events (title, description, location, event_date, event_time, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $title, $description, $location, $event_date, $event_time, $created_by);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>✔️ Tukio limeongezwa kikamilifu!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Hitilafu katika kuongeza tukio.</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add event</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f0f8ff;
            padding: 40px;
        }
        .container {
            background-color: white;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #28a745;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>➕ Add new event</h2>
    <form method="POST" action="">
        <label>Event name:</label>
        <input type="text" name="title" required>

        <label>event description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label>place:</label>
        <input type="text" name="location" required>

        <label>Date:</label>
        <input type="date" name="event_date" required>

        <label>time:</label>
        <input type="time" name="event_time" required>

        <input type="submit" value="save">
    </form>

    <a href="admin_dashboard.php">⬅️  Dashboard</a>
</div>

</body>
</html>
