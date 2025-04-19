<?php
session_start();
require('fpdf.php');
include("database.php");

if ($_SESSION["role"] != "admin") {
    exit("Unauthorized Access!");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Approved Hall Tickets', 0, 1);

$query = "SELECT * FROM hallticket_requests WHERE status = 'approved'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(0, 10, "{$row['name']} - {$row['course']}", 0, 1);
}

$pdf->Output();
?>
