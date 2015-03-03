<?php 
require_once('../tcpdf/config/lang/fr.php');
require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

require_once('../Connections/liaisondb.php');
require_once('../bin/fonctions.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsOperation = "-1";
if (isset($_GET['id'])) {
  $colname_rsOperation = $_GET['id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsOperation = sprintf("SELECT recharges.idr, recharges.idab, recharges.montant, recharges.frais, recharges.fraisp, recharges.mpaie, recharges.cel, recharges.dateaj, recharges.status, recharges.dateserv, services.service, abonnements.numcard, abonnements.dvalidite, abonnements.numid, clients.civilite, clients.nom, clients.prenoms, clients.cel AS cell, clients.email FROM recharges, abonnements, services, clients WHERE recharges.idab = abonnements.idab AND abonnements.idcl = clients.idcl AND abonnements.ids = services.ids AND recharges.idr = %s", GetSQLValueString($colname_rsOperation, "int"));
$rsOperation = mysql_query($query_rsOperation, $liaisondb) or die(mysql_error());
$row_rsOperation = mysql_fetch_assoc($rsOperation);
$totalRows_rsOperation = mysql_num_rows($rsOperation);

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		$bMargin = $this->getBreakMargin();
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		//$img_file = K_PATH_IMAGES.'image_demo.jpg';
		$this->Image("../img/recharge.png", 0, 0, 0, 0, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);

		// Logo
		$this->Image('../images/logo.png', '', '', 0, 0);
		$this->SetFont('helvetica', '', 13);
		$this->Cell(180, 10, 'Espace de Services Numériques ARIANE', 0, 0, 'R');
		$this->Ln(5);
		$this->SetFont('helvetica', '', 10);
		$this->Cell(180, 10, 'Tél:  24 385 070', 0, 0, 'R');
		$this->Ln(5);
		$this->Cell(180, 10, 'Fax:  24 385 071', 0, 0, 'R');
		$this->Ln(5);
		$this->Cell(180, 10, 'e-mail :  info@ariane.ci', 0, 0, 'R');
		$this->Ln(5);
		$this->Cell(180, 10, 'Site web :  http://www.ariane.ci', 0, 0, 'R');
		//Line break
		$this->Ln(10);
		$this->SetFont('helvetica', '', 9);
		$this->Cell(180, 10, 'Date : '.date('d/m/Y H:i:s'), 0, 0, 'R');
		$this->Ln(5);
	}
	
	// Page footer
	public function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Page number
		$this->Cell(0, 10, 'ARIANE ® - Tous droits réservés - Groupe AMARAS © - E-mail : infos@amaras.ci', 'T', 0, 'L');
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'T', 0, 'R');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ARIANE');
$pdf->SetTitle('Espace de services numériques');
$pdf->SetSubject('Reçu de demande rechargement de carte prépayée VISA UBA Africard');
$pdf->SetKeywords('ARIANE, VISA, UBA, Africard');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------


// add a page
$pdf->AddPage();
$pdf->SetTopMargin(50);
$pdf->setPrintHeader(false);

// set font
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, $row_rsOperation['nom'].' '.$row_rsOperation['prenoms'], 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, 'Cel. : (225) ' . $row_rsOperation['cell'], 0, 1, 'L');
$pdf->Cell(0, 5, 'E-mail : ' . $row_rsOperation['email'], 0, 1, 'L');
$pdf->Ln(20);
$pdf->SetFont('helvetica', 'BU', 10);
$pdf->Cell(14, 5, 'Objet :', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(20, 5, 'Rechargement de carte prépayée VISA UBA Africard', 0, 1, 'L');
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'N° carte VISA UBA Africard', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  '.$row_rsOperation['numcard'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Date de validité ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  '.$row_rsOperation['dvalidite'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'N° Client ID ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  '.$row_rsOperation['numid'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Moyen de paiement ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  '.$row_rsOperation['mpaie'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Cellulaire / N° transaction', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  '.$row_rsOperation['cel'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Date de la demande ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  '.date("d/m/Y à H:i:s", strtotime($row_rsOperation['dateaj'])), 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Status ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  Rechargement effectué', 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Carte rechargée le ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 5, '  '.date("d/m/Y à H:i:s", strtotime($row_rsOperation['dateserv'])), 1, 1, 'L');

$pdf->Ln(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(150, 5, 'Désignation', 'B', 0, 'L');
$pdf->Cell(30, 5, 'Coût (f CFA)', 'B', 0, 'C');
$pdf->Ln(9);
$pdf->SetFont('helvetica', '', 12);

	$pdf->Cell(150, 5, 'Montant prélevé sur le compte '.$row_rsOperation['mpaie'], 0, 0, 'L',0,'',1);
	$pdf->Cell(30, 5, number_format($row_rsOperation['montant'],'0',',',' '), 0, 0, 'R',0,'',1);
	$pdf->Ln(3);
	$pdf->Cell(0, 5, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L',0,'',1);
	$pdf->Ln(5);
	$pdf->Cell(150, 5, 'Frais plateforme ', 0, 0, 'L',0,'',1);
	$pdf->Cell(30, 5, number_format($row_rsOperation['fraisp'],'0',',',' '), 0, 0, 'R',0,'',1);
	$pdf->Ln(3);
	$pdf->Cell(0, 5, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L',0,'',1);
	$pdf->Ln(5);
	$pdf->Cell(150, 5, 'Frais de recharge sur carte VISA UBA Africard ', 0, 0, 'L',0,'',1);
	$pdf->Cell(30, 5, number_format($row_rsOperation['frais'],'0',',',' '), 0, 0, 'R',0,'',1);
	$pdf->Ln(3);
	$pdf->Cell(0, 5, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L',0,'',1);
	$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(150, 5, 'Montant rechargé sur la carte prépayée VISA UBA Africard ', 0, 0, 'L',0,'',1);
	$pdf->Cell(30, 5, number_format($row_rsOperation['montant']-$row_rsOperation['frais']-$row_rsOperation['fraisp'],'0',',',' '), 0, 0, 'R',0,'',1);
	$pdf->Ln(3);

$pdf->Ln(20);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, "Service commercial d'ARIANE", 0, 0, 'R');

///Close and output PDF document
$pdf->Output('recu.pdf', 'I');
?>
<?php 
mysql_free_result($rsOperation);
?>