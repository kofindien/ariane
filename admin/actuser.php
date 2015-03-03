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

$requetes ='WHERE comptes.suppr = 0 AND comptes.idc = -1';
if (isset($_GET['frmUser']) && $_GET['frmUser']=='user'){
	if (!empty($_GET['nom'])) $criteres[] = "comptes.nom LIKE '%". addslashes($_GET['nom'])."%'";
	if (!empty($_GET['prenoms'])) $criteres[] = "comptes.prenoms LIKE '%". addslashes($_GET['prenoms'])."%'";
	if (!empty($_GET['code'])) $criteres[] = "comptes.email ='".addslashes($_GET['email'])."'";

	if (isset($criteres) && count($criteres)){
		$nb = count($criteres);
		if ($nb == 1) $requetes = "WHERE comptes.suppr = 0 AND comptes.active = 0 AND ".$criteres[0];
		else {
			$requetes = "WHERE comptes.suppr = 0 AND comptes.active = 0 AND ".$criteres[0];
			for ($i = 1; $i < $nb; $i++){
				$requetes .= ' AND '.$criteres[$i];
			}
		}
	}
}

/* Calcul du nombre total d'entrées $total dans la table documents */
mysql_select_db($database_liaisondb, $liaisondb);
$queryOperations = "SELECT * FROM comptes $requetes";
$Operations = mysql_query($queryOperations, $liaisondb) or die(mysql_error());
$totalRows_rsUsers = mysql_num_rows($Operations);
	
/* Libération du résultat */
mysql_free_result($Operations);

/* Déclaration des variables */
$maxRows_rsUsers = 7; // nombre d'entrées à afficher par page (entries per page)
$totalPages_rsUsers = ceil($totalRows_rsUsers/$maxRows_rsUsers); // calcul du nombre de pages $countp (on arrondit à l'entier supérieur avec la fonction ceil() )

/* Récupération du numéro de la page courante depuis l'URL avec la méthode GET */
if(!isset($_GET['page']) || !is_numeric($_GET['page']) ) // si $_GET['page'] n'existe pas OU $_GET['page'] n'est pas un nombre (petite sécurité supplémentaire)
	$current = 1; // la page courante devient 1
else
	{
		$page = intval($_GET['page']); // stockage de la valeur entière uniquement
		if ($page < 1) $current = 1; // cas où le numéro de page est inférieure 1 : on affecte 1 à la page courante
		elseif ($page > $totalPages_rsUsers) $current = $totalPages_rsUsers; //cas où le numéro de page est supérieur au nombre total de pages : on affecte le numéro de la dernière page à la page courante
		else $current=$page; // sinon la page courante est bien celle indiquée dans l'URL
}

/* $start est la valeur de départ du LIMIT dans notre requête SQL (est fonction de la page courante) */
$startRow_rsUsers = (($current - 1) * $maxRows_rsUsers);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsUsers = "SELECT comptes.idc, comptes.nom, comptes.prenoms, comptes.cel, comptes.email, comptes.dateaj, groupes.libg FROM comptes, groupes $requetes AND comptes.idg = groupes.idg ORDER BY comptes.nom ASC, comptes.prenoms ASC";
$query_limit_rsUsers = sprintf("%s LIMIT %d, %d", $query_rsUsers, $startRow_rsUsers, $maxRows_rsUsers);
$rsUsers = mysql_query($query_limit_rsUsers, $liaisondb) or die(mysql_error());
$row_rsUsers = mysql_fetch_assoc($rsUsers);


if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_GET['action'])) && ($_GET['action'] == "activer")) {
   $updateSQL = sprintf("UPDATE comptes SET comptes.active=1 WHERE comptes.idc=%s",
					   GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_liaisondb, $liaisondb);
  $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());

  $updateSQL = "actuser.php?action=succes&frmUser=user";
  if (isset($_GET['nom']) && !empty($_GET['nom'])) $updateSQL .= "&nom=".$_GET['nom'];
  if (isset($_GET['prenoms']) && !empty($_GET['prenoms'])) $updateSQL .= "&prenoms=".$_GET['prenoms'];
  if (isset($_GET['email']) && !empty($_GET['email'])) $updateSQL .= "&email=".$_GET['email'];
  header(sprintf("Location: %s", $updateSQL));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Les utilisateurs ::: Console d'administration</title>
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
<div class="pull-left titre">Activer un utilisateur</div>
<?php if ($totalRows_rsUsers >0){ ?>
<div class="pull-right">
  Affichage de <?php echo ($startRow_rsUsers + 1) ?> &agrave; <?php echo min($startRow_rsUsers + $maxRows_rsUsers, $totalRows_rsUsers) ?> sur <strong><?php echo $totalRows_rsUsers ?></strong>
</div>
<?php } ?>
</div>

<div align="center">
<form class="form-inline well" action="" method="get">
    <input name="frmUser" type="hidden" id="frmUser" value="user" />
    <label for="nom">Nom : </label>
    <input type="text" class="input-small" id="nom" name="nom" placeholder="Nom">
    <label for="prenoms">- Prénoms : </label>
    <input type="text" class="input-medium" id="prenoms" name="prenoms" placeholder="Prénoms">
    <label for="email">- E-mail : </label>
    <input type="email" id="email" name="email" class="input-large" placeholder="email@site.com" maxlength="4">
    <button type="submit" class="btn btn-primary"><i class="icon-white icon-search"></i> Rechercher</button>
</form>
</div>
              
<?php if ($totalRows_rsUsers >0){ ?>
<table class="table table-striped table-hover" width="100%" border="0" cellspacing="1" cellpadding="2">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Prénoms</th>
                    <th>Cellulaire</th>
                    <th>E-mail</th>
                    <th>Groupe</th>
                    <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
              <?php do { ?>
                  <tr>
                    <td><?php LongDateEN2dateFR($row_rsUsers['dateaj']); ?></td>
                    <td><?php echo $row_rsUsers['nom']; ?></td>
                    <td><?php echo $row_rsUsers['prenoms']; ?></td>
                    <td><?php echo $row_rsUsers['cel']; ?></td>
                    <td><?php echo $row_rsUsers['email']; ?></td>
                    <td><?php echo $row_rsUsers['libg']; ?></td>
                    <td><a href="actuser.php?action=activer&id=<?php echo $row_rsUsers['idc']; ?>" class="lien_bleu_"><i class="icon-eye-open"></i> activer</a></td>
                  </tr>
                <?php } while ($row_rsUsers = mysql_fetch_assoc($rsUsers)); ?>
                  </tbody>
                </table>
            <div style="margin-bottom:70px;">
                <?php
                    /* Appel de la fonction */
                    echo paginate('actuser.php', '?page=', $totalPages_rsUsers, $current);
                ?>          
        </div>
<?php } else echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>Aucun résultat trouvé...</div>'; ?>
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
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsUsers);
?>