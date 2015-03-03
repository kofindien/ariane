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

if ((isset($_POST['idc'])) && !empty($_POST['idc']) && (isset($_POST['idg'])) && !empty($_POST['idg']) && (isset($_POST['nom'])) && !empty($_POST['nom']) && (isset($_POST['prenoms'])) && !empty($_POST['prenoms']) && (isset($_POST['cel'])) && !empty($_POST['cel']) && (isset($_POST['email'])) && !empty($_POST['email']) && (isset($_POST['motp'])) && !empty($_POST['motp'])) {
	
	$salt1 = "qm&h*";	$salt2 = "p#g!@";
	if (isset($_POST['motpasse']) && !empty($_POST['motpasse'])) $motpasse = md5($salt2.md5($salt1.$_POST['motpasse'].$salt2).$salt1);
	else $motpasse = $_POST['motp'];
					
  $updateSQL = sprintf("UPDATE comptes SET idg=%s, nom=%s, prenoms=%s, cel=%s, email=%s, motpasse=%s WHERE idc=%s",
                       GetSQLValueString($_POST['idg'], "text"),
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenoms'], "text"),
                       GetSQLValueString($_POST['cel'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($motpasse, "text"),
                       GetSQLValueString($_POST['idc'], "int"));

  mysql_select_db($database_liaisondb, $liaisondb);
  $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());

	if ($Result1){
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La modification du compte utilisateur s\'est faite avec succès !</div>';
	}
	else { echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La modification du compte utilisateur a échoué... Veuillez recommencer !</div>';
	}
}
?>