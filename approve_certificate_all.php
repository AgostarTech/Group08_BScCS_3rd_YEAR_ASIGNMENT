<?php
session_start();
require 'config.php';

// Thibitisha kisheria utambulisho wa admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Chukua registrations zote zisizoidhinishwa (approved = 0), bila attendance check
$sql = "
SELECT 
    r.id AS reg_id,
    u.name AS student_name,
    e.title AS event_name,
    e.event_date AS event_date
FROM registrations r
JOIN users u ON r.user_id = u.id
JOIN events e ON r.event_id = e.id
WHERE r.approved = 0
ORDER BY e.event_date DESC, u.name
";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Certificates Pending Approval</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: sans-serif; margin: 0; padding: 0; }
    h2 { text-align: center; margin: 20px 0; }
    .alert-success {
      width: 90%;
      margin: 10px auto;
      padding: 12px;
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
      border-radius: 4px;
      text-align: center;
    }
    table { border-collapse: collapse; width: 90%; margin: 0 auto 40px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background-color: #f9f9f9; }
    a.button {
      display: inline-block;
      padding: 6px 12px;
      background-color: #28a745;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      font-size: 0.9em;
    }
    a.button:hover { background-color: #218838; }
    .no-data {
      text-align: center;
      color: #666;
      padding: 20px 0;
    }
  </style>
</head>
<body>
  <h2>Certificates Pending Approval</h2>

  <!-- Success message -->
  <?php if (isset($_GET['approved']) && $_GET['approved'] == '1'): ?>
    <div class="alert-success">
      Certificate approved successfully!
    </div>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Student</th>
        <th>Event</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): 
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['student_name']) ?></td>
            <td><?= htmlspecialchars($row['event_name']) ?></td>
            <td><?= date('Y-m-d', strtotime($row['event_date'])) ?></td>
            <td>
              <a 
                class="button" 
                href="approve_single_certificate.php?id=<?= $row['reg_id'] ?>" 
                onclick="return confirm('Approve certificate for <?= htmlspecialchars(addslashes($row['student_name'])) ?>?');"
              >Approve</a>
            </td>
          </tr>
        <?php }
      else: ?>
        <tr>
          <td colspan="5" class="no-data">
            Hakuna certificates za kuapprove.
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
