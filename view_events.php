<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch all events with creator name
$sql = "SELECT events.*, users.name AS creator_name
        FROM events
        JOIN users ON events.created_by = users.id
        ORDER BY event_date ASC, event_time ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>list of events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef;
            padding: 30px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a.register-btn {
            padding: 6px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.register-btn:hover {
            background-color: #218838;
        }
        a.edit-link {
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            background-color: #ffc107;
            color: #212529;
        }
        a.edit-link:hover {
            background-color: #e0a800;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #bd2130;
        }
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .message.success { color: green; }
        .message.error { color: red; }
        .back-link {
            text-align: center;
        }
        .back-link a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📅 List of Events</h2>

    <!-- Display messages -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <p class="message success" id="status-msg">✅ Event deleted successfully!</p>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'fail'): ?>
        <p class="message error" id="status-msg">❌ Failed to delete event.</p>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'invalid'): ?>
        <p class="message error" id="status-msg">⚠️ Invalid request.</p>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Created By</th>
                <?php if ($user_role === 'student'): ?>
                    <th>Register</th>
                <?php elseif ($user_role === 'admin'): ?>
                    <th>Options</th>
                <?php endif; ?>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= $row['event_date'] ?></td>
                    <td><?= $row['event_time'] ?></td>
                    <td><?= htmlspecialchars($row['creator_name']) ?></td>

                    <?php if ($user_role === 'student'): ?>
                        <td><a class="register-btn" href="register_event.php?event_id=<?= $row['id'] ?>">register</a></td>
                    <?php elseif ($user_role === 'admin'): ?>
                        <td>
                            <a class="edit-link" href="edit_event.php?id=<?= $row['id'] ?>">✏️ edit</a>
                            <form method="POST" action="delete_event.php" style="display:inline;" onsubmit="return confirm('Una uhakika unataka kufuta tukio hili?');">
                                <input type="hidden" name="event_id" value="<?= htmlspecialchars($row['id']) ?>">
                                <button type="submit" class="delete-button">🗑️ delete</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>🚫 No registered event for now.</p>
    <?php endif; ?>

    <div class="back-link">
        <a href="<?= ($user_role === 'admin') ? 'admin_dashboard.php' : 'student_dashboard.php' ?>">⬅️ Back to Dashboard</a>
    </div>
</div>

<!-- JavaScript to remove message from URL -->
<script>
  setTimeout(function () {
    const url = new URL(window.location.href);
    url.searchParams.delete('msg');
    window.history.replaceState({}, document.title, url);

    const msg = document.getElementById('status-msg');
    if (msg) msg.style.display = 'none';
  }, 3000);
</script>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
