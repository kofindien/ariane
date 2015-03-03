<?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_name('arianebo');
  session_start();
}

$MM_authorizedUsers = $_SESSION['oswagroups'];
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['ariane_admin_login'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['ariane_admin_login'], $_SESSION['ariane_admin_idg'])))) {   
  /*$MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);*/
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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
$query_rsGroupe = "SELECT idg, libg FROM groupes ORDER BY libg ASC";
$rsGroupe = mysql_query($query_rsGroupe, $liaisondb) or die(mysql_error());
$row_rsGroupe = mysql_fetch_assoc($rsGroupe);
$totalRows_rsGroupe = mysql_num_rows($rsGroupe);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsCompagnies = "SELECT idcp, compagnie FROM compagnies ORDER BY compagnie ASC";
$rsCompagnies = mysql_query($query_rsCompagnies, $liaisondb) or die(mysql_error());
$row_rsCompagnies = mysql_fetch_assoc($rsCompagnies);
$totalRows_rsCompagnies = mysql_num_rows($rsCompagnies);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsNVol = "SELECT idnv, numero FROM numvols ORDER BY numero ASC";
$rsNVol = mysql_query($query_rsNVol, $liaisondb) or die(mysql_error());
$row_rsNVol = mysql_fetch_assoc($rsNVol);
$totalRows_rsNVol = mysql_num_rows($rsNVol);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsDestinations = "SELECT iddest, destination FROM destinations ORDER BY destination ASC";
$rsDestinations = mysql_query($query_rsDestinations, $liaisondb) or die(mysql_error());
$row_rsDestinations = mysql_fetch_assoc($rsDestinations);
$totalRows_rsDestinations = mysql_num_rows($rsDestinations);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsDDates = "SELECT iddpt, DATE_FORMAT(ddate, '%d/%m/%Y') AS ddepart FROM departs ORDER BY ddate ASC";
$rsDDates = mysql_query($query_rsDDates, $liaisondb) or die(mysql_error());
$row_rsDDates = mysql_fetch_assoc($rsDDates);
$totalRows_rsDDates = mysql_num_rows($rsDDates);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsTimes = "SELECT idh, DATE_FORMAT(heure, '%Hh%i') AS hdepart FROM horaires ORDER BY heure ASC";
$rsTimes = mysql_query($query_rsTimes, $liaisondb) or die(mysql_error());
$row_rsTimes = mysql_fetch_assoc($rsTimes);
$totalRows_rsTimes = mysql_num_rows($rsTimes);

	/*$salt1 = "qm&h*";	$salt2 = "p#g!@";
	echo $motpasse = md5($salt2.md5($salt1.'deborah'.$salt2).$salt1);*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Ajouter un vol ::: Console d'administration</title>
<!-- InstanceEndEditable -->
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>

<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
</head>
<body>
<div style="min-height:250px; margin:10px 0 0 0;">
  <!--Entête-->
  <div class="row" align="left" style="width:1000px; height:50px; margin:0 auto;">
    <div class="span7">
        <img src="../img/logo.png" width="126" height="29" />&nbsp;&nbsp;&nbsp;&nbsp;
        <img src="../img/titre.png" />
    </div>
    
    <div class="span5">
        <div class="btn-group pull-right" style="padding:20px 0 0 0;">
          <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#">
            <i class="icon-user"></i> <?php echo stripslashes($_SESSION['ariane_admin_identite']); ?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="profil.php"><i class="icon-edit"></i> Modifier son profil</a></li>
            <li><a href="mpasse.php"><i class="icon-lock"></i> Modifier son mot de passe</a></li>
            <li><a href="logout.php"><i class="icon-off"></i> Se déconnecter</a></li>
          </ul>
        </div>        
    </div>
    
    
  </div>
  <!--Fin Entête-->
  <!--Navigation-->
  <div class="row" style="width:1000px; margin:50px auto 20px auto; padding-left:40px; height:5px;">
    <?php require_once('../bin/admin.menu.inc.php'); ?>
  </div>
  <!--Fin Navigation-->
  <!--Corps-->
  <div class="row" align="left" style="width:1000px; margin:0px auto;">
    <div style="padding-top:10px;">
	<!-- InstanceBeginEditable name="corps" -->
      <div style="padding:15px;">
        <div style="padding:25px; border:1px solid #CCC; min-height:270px; background:#fff; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">

<div style="margin-bottom:20px; background:url(../img/_separe.png) center bottom no-repeat; padding-bottom:45px;">
<div class="pull-left titre">Ajouter de vol(s)</div>
</div>

<form method="post" class="form-horizontal" id="frmVol" name="frmVol">

<table id="tabvol" width="100%" style="margin-bottom:20px;" class="table">
  <tr>
    <th>Compagnie aérienne</th>
    <th>N° de Vol</th>
    <th>Destination</th>
    <th>Date de départ</th>
    <th>Horaire</th>
    <th>&nbsp;</th>
  </tr>
  <tr>
    <td>
    <select name="idcp[]" id="idcp" required>
    	<option disabled selected></option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsCompagnies['idcp']?>"><?php echo $row_rsCompagnies['compagnie']?></option>
        <?php
} while ($row_rsCompagnies = mysql_fetch_assoc($rsCompagnies));
  $rows = mysql_num_rows($rsCompagnies);
  if($rows > 0) {
      mysql_data_seek($rsCompagnies, 0);
	  $row_rsCompagnies = mysql_fetch_assoc($rsCompagnies);
  }
?>
    </select></td>
    <td><select name="idnv[]" id="idnv" class="span2" required>
    	<option disabled selected></option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsNVol['idnv']?>"><?php echo $row_rsNVol['numero']?></option>
        <?php
} while ($row_rsNVol = mysql_fetch_assoc($rsNVol));
  $rows = mysql_num_rows($rsNVol);
  if($rows > 0) {
      mysql_data_seek($rsNVol, 0);
	  $row_rsNVol = mysql_fetch_assoc($rsNVol);
  }
?>
    </select></td>
    <td><select name="iddest[]" id="iddest" required>
    	<option disabled selected></option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsDestinations['iddest']?>"><?php echo $row_rsDestinations['destination']?></option>
        <?php
} while ($row_rsDestinations = mysql_fetch_assoc($rsDestinations));
  $rows = mysql_num_rows($rsDestinations);
  if($rows > 0) {
      mysql_data_seek($rsDestinations, 0);
	  $row_rsDestinations = mysql_fetch_assoc($rsDestinations);
  }
?>
    </select></td>
    <td><select name="iddpt[]" id="iddpt" class="span2" required>
    	<option disabled selected></option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsDDates['iddpt']?>"><?php echo $row_rsDDates['ddepart']?></option>
        <?php
} while ($row_rsDDates = mysql_fetch_assoc($rsDDates));
  $rows = mysql_num_rows($rsDDates);
  if($rows > 0) {
      mysql_data_seek($rsDDates, 0);
	  $row_rsDDates = mysql_fetch_assoc($rsDDates);
  }
?>
    </select></td>
    <td><select name="idh[]" id="idh" class="input-small" required>
    	<option disabled selected></option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsTimes['idh']?>"><?php echo $row_rsTimes['hdepart']?></option>
        <?php
} while ($row_rsTimes = mysql_fetch_assoc($rsTimes));
  $rows = mysql_num_rows($rsTimes);
  if($rows > 0) {
      mysql_data_seek($rsTimes, 0);
	  $row_rsTimes = mysql_fetch_assoc($rsTimes);
  }
?>
    </select></td>
    <td><input type="button" name="ajoutinfos" id="ajoutinfos" value="+" onclick="AjInfosVol();"  /></td>
  </tr>
</table>

  <div align="center">
<button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('users.php');"><i class="icon-circle-arrow-left icon-white"></i> Retour</button>
      <button type="submit" id="Submit" name="Submit" class="btn btn-primary"><i class="icon-check icon-white"></i> Enregister</button>
  </div>
</form>

      </div>
      </div>
    <!-- InstanceEndEditable -->
    </div>
    </div>
  <!--Fin Corps-->
<!--Début pieds de page-->
<div align="center" style="margin:40px 0 20px 0; clear:both;"><?php require_once('../bin/admin.copyright.php'); ?></div>
<!--Fin pieds de page-->
</div>
</body>
<!-- InstanceEnd -->
<?php
echo '<script type="text/javascript">
	function AjInfosVol(){
		var tr = document.createElement("tr");
		var tabvol = document.getElementById("tabvol");
		var content = "<td><select name=\'idcp[]\' id=\'idcp\' required><option disabled selected></option>'; do { echo '<option value=\'',$row_rsCompagnies['idcp'],'\'>',$row_rsCompagnies['compagnie'],'</option>'; } while ($row_rsCompagnies = mysql_fetch_assoc($rsCompagnies)); $rows = mysql_num_rows($rsCompagnies); if($rows > 0) { mysql_data_seek($rsCompagnies, 0); $row_rsCompagnies = mysql_fetch_assoc($rsCompagnies);} echo '</select></td>";';
echo 'content += "<td><select name=\'idnv[]\' id=\'idnv\' class=\'span2\' required><option disabled selected></option>'; do { echo '<option value=\'',$row_rsNVol['idnv'],'\'>',$row_rsNVol['numero'],'</option>'; } while ($row_rsNVol = mysql_fetch_assoc($rsNVol)); $rows = mysql_num_rows($rsNVol); if($rows > 0) { mysql_data_seek($rsNVol, 0); $row_rsNVol = mysql_fetch_assoc($rsNVol);} echo '</select></td>";';
echo 'content += "<td><select name=\'iddest[]\' id=\'iddest\' required><option disabled selected></option>'; do { echo '<option value=\'',$row_rsDestinations['iddest'],'\'>',$row_rsDestinations['destination'],'</option>'; } while ($row_rsDestinations = mysql_fetch_assoc($rsDestinations)); $rows = mysql_num_rows($rsDestinations); if($rows > 0) { mysql_data_seek($rsDestinations, 0); $row_rsDestinations = mysql_fetch_assoc($rsDestinations);} echo '</select></td>";';
echo 'content += "<td><select name=\'iddpt[]\' id=\'iddpt\' class=\'span2\' required><option disabled selected></option>'; do { echo '<option value=\'',$row_rsDDates['iddpt'],'\'>',$row_rsDDates['ddepart'],'</option>'; } while ($row_rsDDates = mysql_fetch_assoc($rsDDates)); $rows = mysql_num_rows($rsDDates); if($rows > 0) { mysql_data_seek($rsDDates, 0); $row_rsDDates = mysql_fetch_assoc($rsDDates);} echo '</select></td>";';
echo 'content += "<td><select name=\'idh[]\' id=\'idh\' class=\'input-small\' required><option disabled selected></option>'; do { echo '<option value=\'',$row_rsTimes['idh'],'\'>',$row_rsTimes['hdepart'],'</option>'; } while ($row_rsTimes = mysql_fetch_assoc($rsTimes)); $rows = mysql_num_rows($rsTimes); if($rows > 0) { mysql_data_seek($rsTimes, 0); $row_rsTimes = mysql_fetch_assoc($rsTimes); } echo '</select></td>";';
echo 'content += "<td></td>";	
		tr.innerHTML = content;
		tabvol.appendChild(tr);	
	}
</script>';
?>
</html>
<?php
mysql_free_result($rsGroupe);

mysql_free_result($rsCompagnies);

mysql_free_result($rsNVol);

mysql_free_result($rsDestinations);

mysql_free_result($rsDDates);

mysql_free_result($rsTimes);
?>