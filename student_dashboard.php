<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background-color: #e6f0ff;
            padding: 40px;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
        }
        a {
            display: block;
            margin: 15px 0;
            padding: 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
        }
        a:hover {
            background-color: #218838;
        }
    </style>
</head>


<body>

<div class="container">
    <h2>Welcome student, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

    <a href="view_events.php">📅 Register to Event</a>
    <a href="my_registrations.php">✅ See Your Registered Events</a>
    <a href="approved_certificates.php">📥 View Approved Certificates</a>
<a href="student_account_settings.php">⚙️ Account Settings</a>

    <a href="logout.php">🚪 Logout</a>
</div>
<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>
