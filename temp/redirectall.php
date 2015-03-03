<?php require_once('Connections/liaisondb.php'); ?>
<?php
if (!isset($_SESSION)) {
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

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsGroups = "SELECT idg FROM groupes";
$rsGroups = mysql_query($query_rsGroups, $liaisondb) or die(mysql_error());
$row_rsGroups = mysql_fetch_assoc($rsGroups);
$totalRows_rsGroups = mysql_num_rows($rsGroups);

do { 
		$groupes[] = $row_rsGroups['idg'];
} while ($row_rsGroups = mysql_fetch_assoc($rsGroups)); 

$colname_rsProfil = "-1";
if (isset($_SESSION['sewa_user_profil'])) {
  $colname_rsProfil = $_SESSION['sewa_user_profil'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsProfil = sprintf("SELECT libg, modules, droits FROM groupes WHERE idg = %s", GetSQLValueString($colname_rsProfil, "int"));
$rsProfil = mysql_query($query_rsProfil, $liaisondb) or die(mysql_error());
$row_rsProfil = mysql_fetch_assoc($rsProfil);
$totalRows_rsProfil = mysql_num_rows($rsProfil);


$_groupes = implode(',',$groupes);

$MM_redirectLoginSuccessSEWA = "./console/";  
$MM_redirectLoginSuccessAgences = "./agences/";

$tb_modules = explode(',', $row_rsProfil['modules']);
$tb_droits = explode(',', $row_rsProfil['droits']);

$_SESSION['sewa_user_profil_lib'] = $row_rsProfil['libg'];
$_SESSION['sewa_groupes'] = $_groupes;
$_SESSION['tb_modules'] = $tb_modules;
$_SESSION['tb_droits'] = $tb_droits;


if (isset($_SESSION['sewa_user_ide']) && !empty($_SESSION['sewa_user_ide'])) header ("Location: $MM_redirectLoginSuccessAgences");
if (isset($_SESSION['sewa_user_id']) && empty($_SESSION['sewa_user_ide'])) header ("Location: $MM_redirectLoginSuccessSEWA");


mysql_free_result($rsGroups);

mysql_free_result($rsProfil);
?>
