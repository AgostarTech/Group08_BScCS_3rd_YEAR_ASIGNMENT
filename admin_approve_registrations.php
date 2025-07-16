<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

// Kubadili status ya approval (kama kuna action POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registration_id'])) {
    $registration_id = intval($_POST['registration_id']);
    $approve = isset($_POST['approve']) ? 1 : 0;

    $update_sql = "UPDATE registrations SET approved = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ii", $approve, $registration_id);
    $stmt->execute();
}

// Pata orodha ya registrations zote kwa tukio fulani au zote
$sql = "SELECT registrations.id, users.name AS student_name, events.title AS event_title, registrations.approved 
        FROM registrations
        JOIN users ON registrations.user_id = users.id
        JOIN events ON registrations.event_id = events.id
        ORDER BY registrations.id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Approve Registrations</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #007bff; color: white; }
        form { margin: 0; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>

<h2>list of registered student (Admin Approval)</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>student name</th>
            <th>Event</th>
            <th>Approved?</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['student_name']) ?></td>
            <td><?= htmlspecialchars($row['event_title']) ?></td>
            <td><?= $row['approved'] ? 'yes' : 'NO' ?></td>
            <td>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="registration_id" value="<?= $row['id'] ?>">
                    <?php if (!$row['approved']): ?>
                        <button type="submit" name="approve" value="1">Approve</button>
                    <?php else: ?>
                        <button type="submit" name="approve" value="0">Reject</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="admin_dashboard.php">← Dashboard</a>

</body>
</html>
