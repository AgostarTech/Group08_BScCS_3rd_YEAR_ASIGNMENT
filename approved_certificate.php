<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'config.php';
$user_id = $_SESSION['user_id'];

$sql = "SELECT events.id AS event_id, events.title, events.event_date
        FROM registrations 
        JOIN events ON registrations.event_id = events.id
        WHERE registrations.user_id = ? AND registrations.approved = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Certificates</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f9f9f9;
            padding: 40px;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        a {
            color: #28a745;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Approved Certificates</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 1;
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['event_date']); ?></td>
                    <td>
                        <a href="export_certificate_single.php?event_id=<?= $row['event_id']; ?>&user_id=<?= $user_id; ?>" target="_blank">
                            Get Certificate
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no approved certificates yet.</p>
    <?php endif; ?>

    <p style="text-align:center; margin-top: 20px;">
        <a href="student_dashboard.php">⬅ Back to Dashboard</a>
    </p>
</div>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
