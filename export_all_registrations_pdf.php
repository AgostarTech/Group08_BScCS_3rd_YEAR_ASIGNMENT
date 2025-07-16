<?php
require('fpdf/fpdf.php');
require 'config.php';

// Pata data zote za usajili
$sql = "SELECT u.name AS student_name, u.email, e.title AS event_title, r.registration_date
        FROM registrations r
        JOIN users u ON r.user_id = u.id
        JOIN events e ON r.event_id = e.id
        ORDER BY r.registration_date DESC";

$result = $conn->query($sql);

// Tengeneza PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Orodha ya Wanafunzi Waliosajiliwa kwenye Matukio', 0, 1, 'C');
$pdf->Ln(5);

// Vichwa vya meza
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, '#', 1);
$pdf->Cell(50, 10, 'Jina', 1);
$pdf->Cell(60, 10, 'Barua Pepe', 1);
$pdf->Cell(50, 10, 'Tukio', 1);
$pdf->Cell(30, 10, 'Tarehe', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);
$count = 1;

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $count++, 1);
    $pdf->Cell(50, 10, $row['student_name'], 1);
    $pdf->Cell(60, 10, $row['email'], 1);
    $pdf->Cell(50, 10, $row['event_title'], 1);
    $pdf->Cell(30, 10, $row['registration_date'], 1);
    $pdf->Ln();
}

$pdf->Output('I', 'all_students_registrations.pdf');
exit;
?>
