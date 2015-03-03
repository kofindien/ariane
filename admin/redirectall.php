<?php require_once('../Connections/liaisondb.php'); ?>
<?php
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

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsGroupOSWA = "SELECT idg FROM groupes";
$rsGroupOSWA = mysql_query($query_rsGroupOSWA, $liaisondb) or die(mysql_error());
$row_rsGroupOSWA = mysql_fetch_assoc($rsGroupOSWA);
$totalRows_rsGroupOSWA = mysql_num_rows($rsGroupOSWA);

do { 
		$grposwa[] = $row_rsGroupOSWA['idg'];
} while ($row_rsGroupOSWA = mysql_fetch_assoc($rsGroupOSWA)); 

$colname_rsProfil = "-1";
if (isset($_SESSION['ariane_admin_idg'])) {
  $colname_rsProfil = $_SESSION['ariane_admin_idg'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsProfil = sprintf("SELECT libg, modules, droits FROM groupes WHERE idg = %s", GetSQLValueString($colname_rsProfil, "int"));
$rsProfil = mysql_query($query_rsProfil, $liaisondb) or die(mysql_error());
$row_rsProfil = mysql_fetch_assoc($rsProfil);
$totalRows_rsProfil = mysql_num_rows($rsProfil);

$_grposwa = implode(',',$grposwa);

$MM_redirectLoginSuccessAdmin = "./";  

$tb_modules = explode(',', $row_rsProfil['modules']);
$tb_droits = explode(',', $row_rsProfil['droits']);

$_SESSION['oswagroups'] = $_grposwa;
$_SESSION['tb_modules'] = $tb_modules;
$_SESSION['tb_droits'] = $tb_droits;

header ("Location: $MM_redirectLoginSuccessAdmin");

mysql_free_result($rsGroupOSWA);

mysql_free_result($rsProfil);
?>