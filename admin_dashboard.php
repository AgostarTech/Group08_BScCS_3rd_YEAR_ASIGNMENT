<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

// Approve student participation if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_user_id'], $_POST['approve_event_id'])) {
    $user_id = $_POST['approve_user_id'];
    $event_id = $_POST['approve_event_id'];

    $update = $conn->prepare("UPDATE registrations SET approved = 1 WHERE user_id = ? AND event_id = ?");
    $update->bind_param("ii", $user_id, $event_id);
    $update->execute();
}

$sql = "SELECT id, title, event_date FROM events ORDER BY event_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f6fa; 
            padding: 40px; 
            margin: 0;
            color: #333;
        }
        .container { 
            background-color: green; 
            padding: 30px 40px; 
            border-radius: 12px; 
            max-width: 1100px; 
            margin: auto; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
            text-align: center;
        }
        h2 {
            font-weight: 700;
            margin-bottom: 25px;
            color: #007bff;
            font-size: 2.2rem;
        }
        .nav-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }
        .nav-buttons button {
            background-color: #007bff;
            color: white;
            padding: 12px 22px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 3px 6px rgba(0,123,255,0.3);
            transition: background-color 0.3s ease;
        }
        .nav-buttons button:hover {
            background-color: #0056b3;
            box-shadow: 0 5px 15px rgba(0,86,179,0.5);
        }
        button.logout {
            background-color: #dc3545;
            margin-top: 40px;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 700;
            box-shadow: 0 3px 6px rgba(220,53,69,0.3);
            display: inline-block;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        button.logout:hover {
            background-color: #a71d2a;
            box-shadow: 0 5px 15px rgba(167,29,42,0.6);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome Admin, <?= htmlspecialchars($_SESSION['name']); ?>!</h2>

    <div class="nav-buttons">
        <button onclick="location.href='add_event.php'">➕ Add New Event</button>
        <button onclick="location.href='view_events.php'">📅 See All Events</button>
        <button onclick="location.href='view_registrations.php'">👥 See Registrations</button>
        <button onclick="location.href='approve_certificates.php'">✅ Approve Certificates</button>
        <button onclick="location.href='view_approved_certificates.php'">📄 Approved Certificates</button>
        <button onclick="location.href='admin_account_settings.php'">⚙️ Account Settings</button>
    </div>
    <button class="logout" onclick="location.href='logout.php'">🚪 Logout</button>
</div>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
