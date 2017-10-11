<?php

/* Background */
//$img_file = 'img/certificado/semic-2015.jpg';

/* Construção do PDF */
tcpdf();
$content = '
<style> 
	p { font-size: 15px; }
	h1 { font-size: 19px; line-height: 60%;}
	h2 { font-size: 17px; line-height: 60%; }
	h3 { font-size: 15px; line-height: 60%; } 
</style>' . cr() . '<h1>CONTRATO</h1>' . $content;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf -> SetCreator(PDF_CREATOR);
$pdf -> SetAuthor('Giga Informatica');
//$pdf->SetTitle('TCPDF Example 007');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf -> SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Contrato Nº ' . strzero($id_pp, 7) . '/' . $pp_ano . ', Giga informática - www.giga.inf.br');

// set header and footer fonts
$pdf -> setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf -> setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf -> SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set font
$pdf -> SetFont('times', '', 12);

// add a page
$pdf -> AddPage();

// get current vertical position
$y = $pdf -> getY();

// set color for background
$pdf -> SetFillColor(255, 255, 255);

// set color for text
$pdf -> SetTextColor(0, 0, 0);

// write the first column
$pdf -> writeHTMLCell(0, 0, '', $y, $content, 0, 0, 1, true, 'J', true);

// reset pointer to the last page
$pdf -> lastPage();

if (isset($anexo)) {
	// write the first column
	$pdf->AddPage();
	$pdf -> writeHTMLCell(0, 0, '', $y, $anexo, 0, 0, 1, true, 'J', true);

}

// ---------------------------------------------------------

//Close and output PDF document
$pdf -> Output('contrato.pdf', 'I');
?>