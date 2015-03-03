<?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["mminsert"])) && ($_POST["mminsert"] == "frmGroupe") && (isset($_POST["libg"])) && !empty($_POST["libg"])) {
	
	$modules = array(); $_modules =''; $permissions = array(); $_permissions = '';
	
	if (isset($_POST['gestionnaires']) && !empty($_POST['gestionnaires'])){
		$modules[] = $_POST['gestionnaires'];
		if (isset($_POST['user1']) && !empty($_POST['user1'])) $permissions[] = $_POST['user1'];
		if (isset($_POST['user2']) && !empty($_POST['user2'])) $permissions[] = $_POST['user2'];
		if (isset($_POST['user3']) && !empty($_POST['user3'])) $permissions[] = $_POST['user3'];
		if (isset($_POST['user4']) && !empty($_POST['user4'])) $permissions[] = $_POST['user4'];
		if (isset($_POST['user5']) && !empty($_POST['user5'])) $permissions[] = $_POST['user5'];
		if (isset($_POST['user6']) && !empty($_POST['user6'])) $permissions[] = $_POST['user6'];
	}
	
	if (isset($_POST['rechargements']) && !empty($_POST['rechargements'])){
		$modules[] = $_POST['rechargements'];
		if (isset($_POST['rech1']) && !empty($_POST['rech1'])) $permissions[] = $_POST['rech1'];
		if (isset($_POST['rech2']) && !empty($_POST['rech2'])) $permissions[] = $_POST['rech2'];
		if (isset($_POST['rech3']) && !empty($_POST['rech3'])) $permissions[] = $_POST['rech3'];
	}
	
	if (isset($_POST['monprofil']) && !empty($_POST['monprofil'])){
		$modules[] = $_POST['monprofil'];
		if (isset($_POST['mpf1']) && !empty($_POST['mpf1'])) $permissions[] = $_POST['mpf1'];
		if (isset($_POST['mpf2']) && !empty($_POST['mpf2'])) $permissions[] = $_POST['mpf2'];
		if (isset($_POST['mpf3']) && !empty($_POST['mpf3'])) $permissions[] = $_POST['mpf3'];
	}
	
	if (isset($_POST['valertes']) && !empty($_POST['valertes'])){
		$modules[] = $_POST['valertes'];
		if (isset($_POST['valt1']) && !empty($_POST['valt1'])) $permissions[] = $_POST['valt1'];
		if (isset($_POST['valt2']) && !empty($_POST['valt2'])) $permissions[] = $_POST['valt2'];
		if (isset($_POST['valt3']) && !empty($_POST['valt3'])) $permissions[] = $_POST['valt3'];
	}
	
	if (isset($_POST['privileges']) && !empty($_POST['privileges'])){
		$modules[] = $_POST['privileges'];
		if (isset($_POST['gp1']) && !empty($_POST['gp1'])) $permissions[] = $_POST['gp1'];
		if (isset($_POST['gp2']) && !empty($_POST['gp2'])) $permissions[] = $_POST['gp2'];
		if (isset($_POST['gp3']) && !empty($_POST['gp3'])) $permissions[] = $_POST['gp3'];
		if (isset($_POST['gp4']) && !empty($_POST['gp4'])) $permissions[] = $_POST['gp4'];
	}
	
	if (isset($_POST['abonnes']) && !empty($_POST['abonnes'])){
		$modules[] = $_POST['abonnes'];
		if (isset($_POST['ab1']) && !empty($_POST['ab1'])) $permissions[] = $_POST['ab1'];
		if (isset($_POST['ab2']) && !empty($_POST['ab2'])) $permissions[] = $_POST['ab2'];
		if (isset($_POST['ab3']) && !empty($_POST['ab3'])) $permissions[] = $_POST['ab3'];
	}
	
	$nb = count($modules);
	if ($nb ==1 && !empty($modules[0])) $_modules = $modules[0];
	else 
	{
		$_modules = $modules[0];
		for ($i = 1; $i < $nb; $i++)
		{
			$_modules .= ',' . $modules[$i];
		}
	}
	
	$_nb = count($permissions);
	if ($_nb ==1 && !empty($permissions[0])) $_permissions = $permissions[0];
	else 
	{
		$_permissions = $permissions[0];
		for ($j = 1; $j < $_nb; $j++)
		{
			$_permissions .= ',' . $permissions[$j];
		}
	}
	
  $insertSQL = sprintf("INSERT INTO groupes (libg, modules, droits) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['libg'], "text"),
                       GetSQLValueString($_modules, "text"),
                       GetSQLValueString($_permissions, "text"));

  mysql_select_db($database_liaisondb, $liaisondb);
  $Result1 = mysql_query($insertSQL, $liaisondb) or die(mysql_error());

	if ($Result1){
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La création du groupe et ses permissions s\'est faite avec succès !</div>';
	}
	else { echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La création du groupe et ses permissions a échoué... Veuillez recommencer !</div>';
	}
}
?>