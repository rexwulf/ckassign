<?php
	session_start();
	$pdf = new PDF();
	// Column headings
	$header = array('User', 'Message', 'Time', 'Date');
	// Data loading
	$data = $pdf->LoadData($_SESSION['çhat']);
	$pdf->SetFont('Arial','',14);
	$pdf->AddPage();
	$pdf->BasicTable($header,$data);
	$pdf->Output();

	header('Location: ' . $_SERVER['HTTP_REFERER']);

?>