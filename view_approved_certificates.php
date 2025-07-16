<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

// Chukua wanafunzi waliopata vyeti (approved = 1)
$sql = "SELECT users.name AS student_name, events.title AS event_title, events.event_date, registrations.user_id, registrations.event_id
        FROM registrations
        JOIN users ON registrations.user_id = users.id
        JOIN events ON registrations.event_id = events.id
        WHERE registrations.approved = 1
        ORDER BY events.event_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Certificates</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f8f9fa;
            padding: 40px;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a {
            text-decoration: none;
            color: #28a745;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Approved certificate</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>student</th>
                    <th>event</th>
                    <th>date</th>
                    <th>cerificate</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($row['student_name']); ?></td>
                    <td><?= htmlspecialchars($row['event_title']); ?></td>
                    <td><?= htmlspecialchars($row['event_date']); ?></td>
                    <td>
                        <a href="export_certificate_single.php?event_id=<?= $row['event_id']; ?>&user_id=<?= $row['user_id']; ?>" target="_blank">
                            Angalia Cheti
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p> sorry,no approved event.</p>
    <?php endif; ?>

    <p style="text-align:center; margin-top: 30px;"><a href="admin_dashboard.php">⬅️  Dashboard</a></p>
</div>

</body>
</html>
