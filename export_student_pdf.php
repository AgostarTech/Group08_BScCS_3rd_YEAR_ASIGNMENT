<?php
ob_start(); // Anza buffering

require 'config.php';
require 'fpdf/fpdf.php';

if (!isset($_GET['event_id']) || empty($_GET['event_id'])) {
    ob_end_clean();
    die("Event ID haijapokelewa.");
}

$event_id = $_GET['event_id'];

$event_sql = "SELECT title FROM events WHERE id = ?";
$event_stmt = $conn->prepare($event_sql);
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();

if ($event_result->num_rows === 0) {
    ob_end_clean();
    die("Tukio halipo.");
}

$event = $event_result->fetch_assoc();
$event_title = $event['title'];

$sql = "SELECT users.name, users.email
        FROM registrations
        JOIN users ON registrations.user_id = users.id
        WHERE registrations.event_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// PDF generation
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Orodha ya Wanafunzi Waliosajiliwa', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Tukio: ' . $event_title, 0, 1, 'L');
$pdf->Ln(5);

// Table headings
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, '#', 1);
$pdf->Cell(70, 10, 'Jina Kamili', 1);
$pdf->Cell(110, 10, 'Barua Pepe', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$count = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $count++, 1);
    $pdf->Cell(70, 10, $row['name'], 1);
    $pdf->Cell(110, 10, $row['email'], 1);
    $pdf->Ln();
}

// Safisha output yote kabla ya kutuma PDF
ob_clean();
$pdf->Output('D', 'students_list.pdf');
exit;

