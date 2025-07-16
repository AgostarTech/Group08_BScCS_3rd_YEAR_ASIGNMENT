<?php
ob_start();

require 'config.php';
require 'fpdf/fpdf.php';

// Hakikisha event_id na user_id zipo
if (!isset($_GET['event_id']) || empty($_GET['event_id']) || !isset($_GET['user_id']) || empty($_GET['user_id'])) {
    ob_end_clean();
    die("Event ID au User ID haijapokelewa.");
}

$event_id = $_GET['event_id'];
$user_id = $_GET['user_id'];

// Kagua kama huyu mwanafunzi amesajiliwa kwenye tukio hili NA amethibitishwa (approved = 1)
$check_sql = "SELECT r.approved, u.name AS user_name, e.title AS event_title
              FROM registrations r
              JOIN users u ON r.user_id = u.id
              JOIN events e ON r.event_id = e.id
              WHERE r.user_id = ? AND r.event_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $event_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
    ob_end_clean();
    die("Usajili haukupatikana.");
}

$data = $check_result->fetch_assoc();

// Kama hajathibitishwa (approved = 0)
if ($data['approved'] != 1) {
    ob_end_clean();
    die("Cheti hakiwezi kupatikana hadi admin athibitishe ushiriki wako.");
}

$user_name = $data['user_name'];
$event_title = $data['event_title'];

// Andaa PDF
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 40, 'Cheti cha Ushiriki', 0, 1, 'C');

$pdf->SetFont('Arial', '', 16);
$pdf->Ln(10);

$pdf->MultiCell(0, 10, "Huu ni kuthibitisha kuwa mwanafunzi:", 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 10, $user_name, 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 16);
$pdf->MultiCell(0, 10, "amehusika kikamilifu katika tukio la:", 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 10, $event_title, 0, 1, 'C');
$pdf->Ln(20);

$pdf->SetFont('Arial', '', 14);
$pdf->MultiCell(0, 10, "Asante kwa ushiriki wako.", 0, 'C');

ob_end_clean();
$pdf->Output('D', 'cheti_' . preg_replace('/[^a-zA-Z0-9]/', '_', $user_name) . '.pdf');
exit;
