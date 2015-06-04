<?php

	if (isset($_REQUEST['pfrom'])){
		$pfrom = $_REQUEST['pfrom'];
	}else{
		$pfrom = "0";
	}
	if (isset($_REQUEST['pto'])){
		$pto = $_REQUEST['pto'];
	}else{
		$pto = "0";
	}
	
	include('fpdf.php');
	$msg="";
	//init
	$pdf=new FPDF("P","mm","A3");
	$pdf->Open();
	$pdf->SetMargins(0,0,0);
	
	
	for ($pagex=$pfrom; $pagex<=$pto; $pagex++){
		$left1 = 17.2;
		$left2 = 60;
		$mid = 150;
		$bottom = 200;
		$cl = 26;
		$page = 0;
		$default_fontsize=12;
		 
		//title
		$pdf->AddPage("P","A3");
		$pdf->Image('20cents_2013.jpg',0,0,297,420);
		
		//1st column
		$nox1 = ($pagex-1)*5;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,29.8);
		$pdf->Cell(0, 0, str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,69.4);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,109.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,149.2);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,188.9);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		

		//2nd column
		$nox1 = (($pagex-1)*5)+5000;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,29.8);
		$pdf->Cell(0, 0, str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,69.4);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,109.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,149.2);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,188.9);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		

		//3rd column
		$nox1 = (($pagex-1)*5)+10000;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,29.8);
		$pdf->Cell(0, 0, str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,69.4);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,109.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,149.2);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,188.9);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		
		
		//4th column
		$nox1 = (($pagex-1)*5)+15000;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,29.8);
		$pdf->Cell(0, 0, str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,69.4);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,109.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,149.2);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,188.9);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		

		
		// 5th column
		$nox1 = (($pagex-1)*5)+20000;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,239.0);
		$pdf->Cell(0, 0,  str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,279.0);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,319.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,359.0);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1,398.6);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		

		

		// 6th column
		$nox1 = (($pagex-1)*5)+25000;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,239.0);
		$pdf->Cell(0, 0,  str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,279.0);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,319.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,359.0);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+71,398.6);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		


		// 7th column
		$nox1 = (($pagex-1)*5)+30000;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,239.0);
		$pdf->Cell(0, 0,  str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,279.0);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,319.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,359.0);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+142.5,398.6);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		

		// 8th column
		$nox1 = (($pagex-1)*5)+35000;
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,239.0);
		$pdf->Cell(0, 0,  str_pad($nox1+1, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,279.0);
		$pdf->Cell(0, 0,  str_pad($nox1+2, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
	
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,319.2);
		$pdf->Cell(0, 0,  str_pad($nox1+3, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,359.0);
		$pdf->Cell(0, 0,  str_pad($nox1+4, 5, "0", STR_PAD_LEFT), 0, 0, "L");	
		
		$pdf->SetFont('Arial','',$default_fontsize); 
		$pdf->SetXY($left1+213.5,398.6);
		$pdf->Cell(0, 0,  str_pad($nox1+5, 5, "0", STR_PAD_LEFT), 0, 0, "L");		
		
	}
	
	$filename = "zhupdf".date('dmY');
	//$pdf->Output($filename.".pdf","D");
	$pdf->Output();
?>
