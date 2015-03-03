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

if ((isset($_POST['civilite'])) && !empty($_POST['civilite']) && (isset($_POST['nom'])) && !empty($_POST['nom']) && (isset($_POST['prenoms'])) && !empty($_POST['prenoms']) && (isset($_POST['cel'])) && !empty($_POST['cel']) && (isset($_POST['idab'])) && !empty($_POST['idab'])) {				
			
  $updateSQL = sprintf("UPDATE clients SET civilite=%s, nom=%s, prenoms=%s, cel=%s WHERE idcl=%s",
                       GetSQLValueString($_POST['civilite'], "text"),
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenoms'], "text"),
                       GetSQLValueString($_POST['cel'], "text"),
                       GetSQLValueString($_SESSION['ariane_user_id'], "int"));

  mysql_select_db($database_liaisondb, $liaisondb);
  $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());
  
	if ($Result1) echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Votre profil a été bien modifié ! Il prendra effet lors de votre prochaine connexion.</div>';
	else echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La modification de votre profil a échoué... Veuillez recommencer !</div>';
}
?>