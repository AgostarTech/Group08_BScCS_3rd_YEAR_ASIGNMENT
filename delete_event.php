<?php
session_start();
require 'config.php';

// Hakikisha user ni admin na ameingia
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Hakikisha request ni POST na kuna event_id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']);

    // Andika query ya kufuta event kwa event_id
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    if (!$stmt) {
        // Kuandaa statement kulikosea
        header("Location: view_events.php?msg=fail");
        exit();
    }

    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        // Futa event kwa mafanikio
        header("Location: view_events.php?msg=deleted");
        exit();
    } else {
        // Tatizo wakati wa kufuta
        header("Location: view_events.php?msg=fail");
        exit();
    }
} else {
    // Ikiwa request sio POST au event_id haipo
    header("Location: view_events.php?msg=invalid");
    exit();
}
?>
