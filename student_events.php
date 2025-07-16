<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Events</title>
    <style>
        body {
            font-family: Arial, sans-serif; background: #eef7ee; padding: 20px;
        }
        .container {
            max-width: 800px; margin: auto;
        }
        table {
            width: 100%; border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc; padding: 10px; text-align: left;
        }
        th {
            background-color: #28a745; color: white;
        }
        a.logout {
            background-color: #dc3545; color: white; padding: 8px 15px; border-radius: 5px;
            text-decoration: none; float: right; margin-bottom: 15px;
        }
        a.logout:hover {
            background-color: #c82333;
        }
        a.register-btn {
            background-color: #007bff; color: white; padding: 6px 12px; border-radius: 4px;
            text-decoration: none;
        }
        a.register-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Available Events</h1>
    <a href="logout.php" class="logout">Logout</a>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Venue</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($event = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($event['title']) ?></td>
                    <td><?= htmlspecialchars($event['description']) ?></td>
                    <td><?= htmlspecialchars($event['venue']) ?></td>
                    <td><?= htmlspecialchars($event['event_date']) ?></td>
                    <td><a class="register-btn" href="register_event.php?event_id=<?= $event['id'] ?>">Register</a></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No events available at the moment.</td></tr>
        <?php endif; ?>

    </table>
    <a href="student_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
