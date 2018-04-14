<?php
	require('fpdf/fpdf.php');

	class PDF extends FPDF
	{
		function LoadData($header, $res)
		{
			$i=0;
		    foreach($header as $col)
		        {
		        	if($i==1)
		        		$this->Cell(35,6,$col,1);
		        	else
		        		$this->Cell(25,6,$col,1);
		    		$i++;
		    	}
		    $this->Ln();
		    
		    if($res)
		    foreach($res as $row)
		    {	
		    	print_r($row);
				$this->SetFont('Arial','',12);	
				$this->Ln();
				$i=0;
				foreach($row as $col)
					{
						if($i==1)
							$this->Cell(35,6,$col,1);
						else 
							$this->Cell(25,6,$col,1);
						$i++;
					}
			}		   
		}

	}

	$pdf = new PDF();
	$header = array('id','Name', 'Course', 'Branch', 'Semester', 'CGPA','Result');
	require("server.php");
	$query = "SELECT *";
	$query.= "FROM student";
	$q = mysqli_query($conn, $query);
	
	$pdf->SetFont('Arial','',14);
	$pdf->AddPage();
	$data = $pdf->LoadData($header,$q);
	ob_end_clean();
	$pdf->Output();
?>
