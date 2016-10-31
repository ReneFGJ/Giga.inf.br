<?php

/* Background */
//$img_file = 'img/certificado/semic-2015.jpg';

/* Construção do PDF */
tcpdf();

$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// PAGE 1 - BIG background image
$pdf -> AddPage();
$pdf -> SetAutoPageBreak(false, 0);

/* Background */
if (isset($img_file)) {
	$pdf -> Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
}
// Texto do certificado
$pdf -> SetFont('helvetica', '', 16);
$pdf -> SetTextColor(0, 0, 0);

$pdf -> SetXY(10, 13);
$pdf -> writeHTMLCell(0, 0, '', '', $content, 0, 2, 0, true, 'J', true);

if (isset($content_foot))
	{
		$pdf -> SetXY(10, 240);
		$pdf -> SetFont('helvetica', '', 10);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> writeHTMLCell(0, 0, '', '', $content_foot, 0, 2, 0, true, 'L', true);
	}

/* Arquivo de saida */
//$nome_asc = troca($nome_asc,' ','_');
$pdf -> Output($iv_numero.'-RECIBO-' . UpperCaseSQL($f_razao_social) . '.pdf', 'I');
?>