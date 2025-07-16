<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

$sql = "SELECT 
            registrations.id AS reg_id,
            users.name AS student_name,
            events.title AS event_title,
            events.event_date
        FROM registrations
        JOIN users ON registrations.user_id = users.id
        JOIN events ON registrations.event_id = events.id
        WHERE registrations.approved = 0
        ORDER BY events.event_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Certificates</title>
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
            max-width: 950px;
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
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn-approve, .btn-approve-all {
            padding: 6px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-approve:hover, .btn-approve-all:hover {
            background-color: #218838;
        }
        .checkbox-cell {
            width: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>pending certificate for approval</h2>
    <?php if ($result->num_rows > 0): ?>
        <form action="approve_certificate_all.php" method="POST">
        <table>
            <tr>
                <th class="checkbox-cell"><input type="checkbox" onclick="toggleAll(this)"></th>
                <th>#</th>
                <th>student</th>
                <th>event</th>
                <th>date</th>
            </tr>
            <?php
            $count = 1;
            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><input type="checkbox" name="reg_ids[]" value="<?= $row['reg_id']; ?>"></td>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($row['student_name']); ?></td>
                    <td><?= htmlspecialchars($row['event_title']); ?></td>
                    <td><?= htmlspecialchars($row['event_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <center>
            <button type="submit" class="btn-approve-all">Approve Selected</button>
        </center>
        </form>
    <?php else: ?>
        <p>no pending certificates.</p>
    <?php endif; ?>
</div>

<script>
function toggleAll(source) {
    checkboxes = document.getElementsByName('reg_ids[]');
    for(var i=0; i<checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}
</script>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
