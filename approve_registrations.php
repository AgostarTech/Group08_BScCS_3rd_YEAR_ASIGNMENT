<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

// Approved if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_user_id'], $_POST['approve_event_id'])) {
    $user_id = $_POST['approve_user_id'];
    $event_id = $_POST['approve_event_id'];

    $update = $conn->prepare("UPDATE registrations SET approved = 1 WHERE user_id = ? AND event_id = ?");
    $update->bind_param("ii", $user_id, $event_id);
    $update->execute();
}

$events_sql = "SELECT id, title, event_date FROM events ORDER BY event_date DESC";
$events = $conn->query($events_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 40px; }
        .container { background-color: white; padding: 30px; border-radius: 10px; max-width: 1000px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.2); }
        h2, h3 { text-align: center; }
        a { display: block; margin: 15px 0; color: #007bff; text-decoration: none; text-align: center; }
        a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        form { display: inline; }
        button { padding: 5px 10px; background: green; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>Karibu Admin, <?= htmlspecialchars($_SESSION['name']); ?>!</h2>

    <a href="add_event.php">➕ Add new event</a>
    <a href="view_events.php">📅 See all events</a>
    <a href="view_registrations.php">👥 See registrations</a>

    <h3>Matukio na Wanafunzi Waliosajiliwa</h3>
    <?php
    if ($events && $events->num_rows > 0):
        while ($event = $events->fetch_assoc()):
            $event_id = $event['id'];
            echo "<h4>" . htmlspecialchars($event['title']) . " (" . $event['event_date'] . ")</h4>";

            $stmt = $conn->prepare("SELECT r.user_id, u.name, r.approved FROM registrations r JOIN users u ON r.user_id = u.id WHERE r.event_id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0):
                echo '<table><tr><th>#</th><th>Jina la Mwanafunzi</th><th>Status</th><th>Tendo</th></tr>';
                $num = 1;
                while ($row = $result->fetch_assoc()):
                    echo '<tr>';
                    echo '<td>' . $num++ . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . ($row['approved'] ? 'Approved' : 'Pending') . '</td>';
                    echo '<td>';
                    if (!$row['approved']) {
                        echo '<form method="POST">';
                        echo '<input type="hidden" name="approve_user_id" value="' . $row['user_id'] . '">';
                        echo '<input type="hidden" name="approve_event_id" value="' . $event_id . '">';
                        echo '<button type="submit">Approve</button>';
                        echo '</form>';
                    } else {
                        echo '<span style="color: green;">✔</span>';
                    }
                    echo '</td></tr>';
                endwhile;
                echo '</table>';
            else:
                echo '<p>Hakuna wanafunzi waliopo kwa tukio hili.</p>';
            endif;
        endwhile;
    else:
        echo '<p>Hakuna matukio yaliyosajiliwa.</p>';
    endif;
    ?>
    <a href="logout.php">🚪 Logout</a>
</div>
</body>
</html>
