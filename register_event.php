<?php
session_start();
require 'config.php';

// Hakikisha ni mwanafunzi aliyeingia
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Pata event_id kutoka URL
if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    $user_id = $_SESSION['user_id'];

    // Angalia kama tayari mwanafunzi amesajiliwa kwenye tukio hili
    $check_stmt = $conn->prepare("SELECT id FROM registrations WHERE user_id = ? AND event_id = ?");
    $check_stmt->bind_param("ii", $user_id, $event_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<p style='text-align:center; color:orange;'>⚠️ already you have registerd .</p>";
    } else {
        // Sasa jisajili
        $stmt = $conn->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $event_id);

        if ($stmt->execute()) {
            echo "<p style='text-align:center; color:green;'>✔️ registration successful!</p>";
        } else {
            echo "<p style='text-align:center; color:red;'>❌ fail to register try again .</p>";
        }
        $stmt->close();
    }

    $check_stmt->close();
} else {
    echo "<p style='text-align:center; color:red;'>❌ event not found.</p>";
}
?>

<p style="text-align:center;">
    <a href="view_events.php">⬅️ Bck to event list</a>
</p>
