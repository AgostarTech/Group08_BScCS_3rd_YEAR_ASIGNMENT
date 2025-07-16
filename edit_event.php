<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "event not yet available.";
    exit();
}

$event_id = $_GET['id'];

// On form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    $stmt = $conn->prepare("UPDATE events SET title=?, description=?, location=?, event_date=?, event_time=? WHERE id=?");
    $stmt->bind_param("sssssi", $title, $description, $location, $event_date, $event_time, $event_id);
    $stmt->execute();
    header("Location: view_events.php");
    exit();
}

// Get event data
$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
?>

<!-- HTML form -->
<!DOCTYPE html>
<html>
<head><title>edit event</title></head>
<body>
<h2>✏️ edit event</h2>
<form method="POST">
    <input type="text" name="title" value="<?= $event['title'] ?>" required><br>
    <textarea name="description" required><?= $event['description'] ?></textarea><br>
    <input type="text" name="location" value="<?= $event['location'] ?>" required><br>
    <input type="date" name="event_date" value="<?= $event['event_date'] ?>" required><br>
    <input type="time" name="event_time" value="<?= $event['event_time'] ?>" required><br>
    <input type="submit" value="save changes">
</form>
<a href="view_events.php">⬅️ back</a>
</body>
</html>
