<?php require_once('Connections/liaisondb.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
}

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST['idab'])) && !empty($_POST['idab'])) {
	
	$client = $_SESSION['ariane_user_identite'];
	$montant = $_POST['montant'];
	$mpaie = $_POST['mpaie'];
			
	$insertSQL = sprintf("INSERT INTO recharges (idab, montant, frais, fraisp, mpaie, cel) VALUES (%s, %s, %s, %s, %s, %s)",
	   GetSQLValueString($_POST['idab'], "int"),
	   GetSQLValueString($montant, "int"),
	   GetSQLValueString($_POST['frais'], "int"),
	   GetSQLValueString($_POST['fraisp'], "int"),
	   GetSQLValueString($mpaie, "text"),
	   GetSQLValueString($_POST['cel'], "text"));
	
	mysql_select_db($database_liaisondb, $liaisondb);
	$Result1 = mysql_query($insertSQL, $liaisondb) or die(mysql_error());
	
	if ($Result1){
		
if ($mpaie=='Orange Money'){
	echo '<div class="alert alert-success">Votre demande a été bien transmise ! Elle sera traitée immédiatement...<br /><br />Vous recevrez un SMS sur votre mobile vous invitant à composer le <strong>#120#</strong> et à suivre les instructions pour valider l\'opération.<br /><br />Vous recevrez ensuite  par votre adresse e-mail et par SMS une notification de rechargement de votre carte prépayée VISA UBA Africard.<br /><br /><strong>NB :</strong> Au cas où vous ne verrez pas de message dans votre boîte de réception, veuillez voir dans les courriers indésirables (SPAMS).</div>';
}

if ($mpaie=='FLOOZ'){
	echo '<div class="alert alert-success">Votre demande a été bien transmise ! Elle sera traitée immédiatement...<br /><br />Vous recevrez par votre adresse e-mail et par SMS une notification de rechargement de votre carte prépayée VISA UBA Africard.<br /><br /><strong>NB :</strong> Au cas où vous ne verrez pas de message dans votre boîte de réception, veuillez voir dans les courriers indésirables (SPAMS).</div>';
}
			
	$sujet = 'Alerte rechargement de carte VISA UBA - ESN ARIANE';
	$to = 'rechargement@ariane.ci';
	$headers = 'MIME-Version: 1.0' . "\n"; // Version MIME
	$headers .= "From: ESN ARIANE <noreplay@ariane.ci>\n";
	$headers .= "Content-Type: text/html; charset=utf-8\n";
	$headers .= "X-Mailer: PHP\n";
	$headers .= "X-Priority:2\n";
	$headers .= "Return-Path: ESN ARIANE <noreplay@ariane.ci>\n";
	$headers .= "Reply-To: ESN ARIANE <noreplay@ariane.ci>\n";
	$headers .= "Date:" . date("D, d M Y h:s:i") . " +0000\n";
	
	$message = "Le client $client souhaite recharger sa carte prépayée VISA UBA Africard. Il vient de transférer $montant f CFA incluant les frais de rechargement sur le compte $mpaie d'ARIANE. 
	
	Sa requête est en attente de traitement !
		
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.";
	
		mail($to, $sujet, $message, $headers) ; // Envoi du mail	
	}
		else echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La transmission de votre demande a échoué... Veuillez recommencer !</div>';
}
?>