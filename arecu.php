<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
}

require_once('tcpdf/config/lang/fr.php');
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

require_once('Connections/liaisondb.php');
require_once('bin/fonctions.php');

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
 $query_rsOperation = sprintf("SELECT valertes.idav, valertes.idab, valertes.montant, valertes.cout, valertes.compagnie, valertes.fraisp, valertes.mpaie, valertes.vol, valertes.cel, valertes.ddepart, valertes.hdepart, valertes.hlimite, valertes.destination, valertes.dateaj, valertes.status, valertes.dateserv, services.service FROM valertes, abonnements, services WHERE valertes.idab = abonnements.idab AND abonnements.ids = services.ids AND valertes.status = 1 AND valertes.idav = %s", GetSQLValueString($colname_rsOperation, "int"));
$rsOperation = mysql_query($query_rsOperation, $liaisondb) or die(mysql_error());
$row_rsOperation = mysql_fetch_assoc($rsOperation);
$totalRows_rsOperation = mysql_num_rows($rsOperation);

 $query_rsClient = sprintf("SELECT * FROM clients WHERE clients.idcl = %s", GetSQLValueString($_SESSION['ariane_user_id'], "int"));
$rsClient = mysql_query($query_rsClient, $liaisondb) or die(mysql_error());
$row_rsClient = mysql_fetch_assoc($rsClient);
$totalRows_rsClient = mysql_num_rows($rsClient);

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		$bMargin = $this->getBreakMargin();
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		//$img_file = K_PATH_IMAGES.'image_demo.jpg';
		$this->Image("img/paye.png", 0, 0, 0, 0, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);

		// Logo
		$this->Image('images/logo.png', '', '', 0, 0);
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
$pdf->Cell(0, 5, $_SESSION['ariane_user_identite'], 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, 'Cel. : (225) ' . $row_rsClient['cel'], 0, 1, 'L');
$pdf->Cell(0, 5, 'E-mail : ' . $row_rsClient['email'], 0, 1, 'L');
$pdf->Ln(20);
$pdf->SetFont('helvetica', 'BU', 10);
$pdf->Cell(14, 5, 'Objet :', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(20, 5, 'Alertes Voyages', 0, 1, 'L');
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Compagnie aérienne', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.$row_rsOperation['compagnie'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Destination ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.$row_rsOperation['destination'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'N° de vol ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.$row_rsOperation['vol'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Date de départ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.date("d/m/Y", strtotime($row_rsOperation['ddepart'])), 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Heure de départ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.$row_rsOperation['hdepart'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Heure limite d\'embarquement ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.$row_rsOperation['hlimite'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Moyen de paiement ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.$row_rsOperation['mpaie'], 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Date de la demande ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.date("d/m/Y à H:i:s", strtotime($row_rsOperation['dateaj'])), 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Status ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  Service actif', 1, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 5, 'Effectué le ', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(80, 5, '  '.date("d/m/Y à H:i:s", strtotime($row_rsOperation['dateserv'])), 1, 1, 'L');

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
	$pdf->Cell(150, 5, 'Coût du service ', 0, 0, 'L',0,'',1);
	$pdf->Cell(30, 5, number_format($row_rsOperation['cout'],'0',',',' '), 0, 0, 'R',0,'',1);
	$pdf->Ln(3);
	$pdf->Ln(3);

$pdf->Ln(20);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, "Service commercial d'ARIANE", 0, 0, 'R');

///Close and output PDF document
$pdf->Output('recu.pdf', 'I');
?>
<?php 
mysql_free_result($rsOperation);
mysql_free_result($rsClient);
?>