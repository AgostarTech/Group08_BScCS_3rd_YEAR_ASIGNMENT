<?php
session_start();
require 'config.php';

// Hakikisha ni admin aliyeingia
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Pata taarifa zote za usajili pamoja na jina la mtumiaji na tukio
$sql = "SELECT r.id, u.name AS student_name, e.title AS event_title, r.registered_at 
        FROM registrations r
        JOIN users u ON r.user_id = u.id
        JOIN events e ON r.event_id = e.id
        ORDER BY r.registered_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Report</title>
    <style>
        body {
            font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px;
        }
        .container {
            max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%; border-collapse: collapse; margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc; padding: 10px; text-align: left;
        }
        th {
            background-color: #007bff; color: white;
        }
        a.back {
            display: inline-block; margin-top: 10px; text-decoration: none; color: #007bff;
        }
        a.back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>list of registered</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>student name</th>
                <th>event</th>
                <th>Event date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $count = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <td><?= htmlspecialchars($row['event_title']) ?></td>
                    <td><?= htmlspecialchars($row['registered_at']) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">no registration yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php" class="back">BACK toDashboard</a>
</div>

</body>
</html>
