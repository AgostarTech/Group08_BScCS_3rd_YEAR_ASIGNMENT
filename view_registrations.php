<?php
session_start();
require 'config.php';

// Hakikisha ni admin pekee anayeweza kufikia
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT r.id, u.name AS student_name, u.email, e.title AS event_title, r.registration_date
        FROM registrations r
        JOIN users u ON r.user_id = u.id
        JOIN events e ON r.event_id = e.id
        ORDER BY r.registration_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>student registration</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 30px; }
        .container { max-width: 950px; margin: auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ccc; }
        th { background-color: #007bff; color: white; }
        .back-link { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div style="text-align: right; margin-bottom: 10px;">
    <a href="export_all_registrations_pdf.php" style="background-color: #28a745; color: white; padding: 8px 14px; text-decoration: none; border-radius: 5px;">
        🧾 download PDF list
    </a>
</div>

<div class="container">
    <h2>📋 sudent registration by event</h2>

    <?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>student</th>
            <th>Email</th>
            <th>Event</th>
            <th>Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['student_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['event_title']) ?></td>
            <td><?= $row['registration_date'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No any registration.</p>
    <?php endif; ?>

    <div class="back-link">
        <a href="admin_dashboard.php">⬅️  Dashboard</a>
    </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
