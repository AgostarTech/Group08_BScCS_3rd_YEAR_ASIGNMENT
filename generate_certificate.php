<?php
require 'config.php';
require 'fpdf/fpdf.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    die("please enter.");
}

$name = $_SESSION['name'];

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 20, 'MWECAU Certificate of Participation', 0, 1, 'C');

$pdf->SetFont('Arial', '', 16);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'this confirm that:', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 15, strtoupper($name), 0, 1, 'C');

$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 10, 'participated full to the this event.', 0, 1, 'C');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Tarehe: ' . date("d-m-Y"), 0, 1, 'C');

$pdf->Ln(20);
$pdf->Cell(0, 10, '_____________________________', 0, 1, 'C');
$pdf->Cell(0, 5, 'Dean of Students', 0, 1, 'C');

$pdf->Output('I', 'Certificate.pdf');
exit;
?>
