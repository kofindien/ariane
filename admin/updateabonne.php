<?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianebo');
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

if ((isset($_POST['civilite'])) && !empty($_POST['civilite']) && (isset($_POST['nom'])) && !empty($_POST['nom']) && (isset($_POST['prenoms'])) && !empty($_POST['prenoms']) && (isset($_POST['cel'])) && !empty($_POST['cel']) && (isset($_POST['numcard'])) && !empty($_POST['numcard']) && (isset($_POST['dvalidite'])) && !empty($_POST['dvalidite']) && (isset($_POST['idcl'])) && !empty($_POST['idcl']) && (isset($_POST['email'])) && !empty($_POST['email']) && (isset($_POST['motpasse'])) && !empty($_POST['motpasse']) && (isset($_POST['idab'])) && !empty($_POST['idab'])) {				
	
	$salt1 = "qm&h*";	$salt2 = "p#g!@";
	if ((isset($_POST['motp'])) && !empty($_POST['motp'])) $motpasse = md5($salt2.md5($salt1.$_POST['motp'].$salt2).$salt1);	
	else $motpasse = $_POST['motpasse'];	
					
  $updateSQL = sprintf("UPDATE clients SET civilite=%s, nom=%s, prenoms=%s, cel=%s, email=%s, motpasse=%s WHERE idcl=%s",
                       GetSQLValueString($_POST['civilite'], "text"),
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenoms'], "text"),
                       GetSQLValueString($_POST['cel'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($motpasse, "text"),
                       GetSQLValueString($_POST['idcl'], "int"));

  mysql_select_db($database_liaisondb, $liaisondb);
  $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());
	
	if ($Result1){
				  $updateSQL_ = sprintf("UPDATE abonnements SET numcard=%s, dvalidite=%s WHERE idab=%s",
					   GetSQLValueString($_POST['numcard'], "text"),
					   GetSQLValueString($_POST['dvalidite'], "text"),
					   GetSQLValueString($_POST['idab'], "int"));
				
				  mysql_select_db($database_liaisondb, $liaisondb);
				  $Result1_ = mysql_query($updateSQL_, $liaisondb) or die(mysql_error());	
	
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La création de compte abonné s\'est faite avec succès !</div>';
	}
	else echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La création de compte abonné a échoué... Veuillez recommencer !</div>';
}
?>