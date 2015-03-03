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

$colname_rsClient = "-1";
if (isset($_GET['id'])) {
  $colname_rsClient = $_GET['id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsClient = sprintf("SELECT * FROM clients WHERE clients.suppr = 0 AND clients.idcl = %s", GetSQLValueString($colname_rsClient, "int"));
$rsClient = mysql_query($query_rsClient, $liaisondb) or die(mysql_error());
$row_rsClient = mysql_fetch_assoc($rsClient);
$totalRows_rsClient = mysql_num_rows($rsClient);

/* Calcul du nombre total d'entrées $total dans la table documents */
mysql_select_db($database_liaisondb, $liaisondb);
$queryOperations = "SELECT * FROM abonnements WHERE abonnements.idcl = ".$row_rsClient['idcl'];
$Operations = mysql_query($queryOperations, $liaisondb) or die(mysql_error());
$totalRows_rsOperations = mysql_num_rows($Operations);
	
/* Libération du résultat */
mysql_free_result($Operations);

/* Déclaration des variables */
$maxRows_rsOperations = 7; // nombre d'entrées à afficher par page (entries per page)
$totalPages_rsOperations = ceil($totalRows_rsOperations/$maxRows_rsOperations); // calcul du nombre de pages $countp (on arrondit à l'entier supérieur avec la fonction ceil() )

/* Récupération du numéro de la page courante depuis l'URL avec la méthode GET */
if(!isset($_GET['page']) || !is_numeric($_GET['page']) ) // si $_GET['page'] n'existe pas OU $_GET['page'] n'est pas un nombre (petite sécurité supplémentaire)
	$current = 1; // la page courante devient 1
else
	{
		$page = intval($_GET['page']); // stockage de la valeur entière uniquement
		if ($page < 1) $current = 1; // cas où le numéro de page est inférieure 1 : on affecte 1 à la page courante
		elseif ($page > $totalPages_rsOperations) $current = $totalPages_rsOperations; //cas où le numéro de page est supérieur au nombre total de pages : on affecte le numéro de la dernière page à la page courante
		else $current=$page; // sinon la page courante est bien celle indiquée dans l'URL
}

/* $start est la valeur de départ du LIMIT dans notre requête SQL (est fonction de la page courante) */
$startRow_rsOperations = (($current - 1) * $maxRows_rsOperations);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsOperations = "SELECT abonnements.idab, abonnements.dateaj, services.service FROM abonnements, services WHERE abonnements.ids = services.ids AND abonnements.idcl = ".$row_rsClient['idcl']." ORDER BY abonnements.idab DESC";
$query_limit_rsOperations = sprintf("%s LIMIT %d, %d", $query_rsOperations, $startRow_rsOperations, $maxRows_rsOperations);
$rsOperations = mysql_query($query_limit_rsOperations, $liaisondb) or die(mysql_error());
$row_rsOperations = mysql_fetch_assoc($rsOperations);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Les abonnés ::: Console d'administration</title>
<!-- InstanceEndEditable -->
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>

<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="highslide/highslide-full.js"></script>
<script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
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
<div class="pull-left titre">Vue détaillée de l'abonné</div>
</div>

<div class="alert alert-info" style="clear:both;">
    <div class="row-fluid">
        <div class="span4"><?php echo $row_rsClient['nom']; ?> <?php echo $row_rsClient['prenoms']; ?></div>              
        <div class="span1">- <strong>Cel.</strong> :</div>              
        <div class="span2"><?php echo $row_rsClient['cel']; ?></div>              
        <div class="span2">- <strong>Compte créé le</strong></div>              
        <div class="span3"><?php LongDateEN2dateFR($row_rsClient['dateaj']); ?></div>              
    </div>              
</div>              

<div style="border-bottom:#069 1px solid; padding-bottom:10px; margin-bottom:15px;">
  <strong>Service(s) souscrit(s) par l'abonné(e) :</strong></div>

<ul class="pager">
  <li class="previous">
    <a href="abonnes.php">&larr; Retour</a>
  </li>
</ul>

<div class="pull-right" style="margin-bottom:20px;">
  Affichage de <?php echo ($startRow_rsOperations + 1) ?> &agrave; <?php echo min($startRow_rsOperations + $maxRows_rsOperations, $totalRows_rsOperations) ?> sur <strong><?php echo $totalRows_rsOperations ?></strong>
</div>

<table class="table table-striped table-hover" width="100%" border="0" cellspacing="1" cellpadding="2">
                  <thead>
                  <tr>
                    <th>Date de souscription</th>
                    <th>Service</th>
                    <th>Total oprération</th>
                    <th></th>
                    </tr>
            </thead>
                  <tbody>
              <?php if ($totalRows_rsOperations >0){ ?>
              <?php do { ?>
                  <tr>
                    <td><?php LongDateEN2dateFR($row_rsOperations['dateaj']); ?></td>
                    <td><?php echo $row_rsOperations['service']; ?></td>
                    <td>
					 <?php
if ($row_rsOperations['service']=='Carte prépayée VISA UBA Africard'){
	$query_rsService = sprintf("SELECT COUNT(recharges.idr) as total FROM recharges WHERE recharges.idab = %s", GetSQLValueString($row_rsOperations['idab'], "int"));
	$rsService = mysql_query($query_rsService, $liaisondb) or die(mysql_error());
	$row_rsService = mysql_fetch_assoc($rsService);
	$totalRows_rsService = mysql_num_rows($rsService);
}
if ($row_rsOperations['service']=='Mon Profil'){
	$query_rsService = sprintf("SELECT COUNT(mprofil.idp) as total FROM mprofil WHERE mprofil.idab = %s", GetSQLValueString($row_rsOperations['idab'], "int"));
	$rsService = mysql_query($query_rsService, $liaisondb) or die(mysql_error());
	$row_rsService = mysql_fetch_assoc($rsService);
	$totalRows_rsService = mysql_num_rows($rsService);
}
if ($row_rsOperations['service']=='Alertes Voyages'){
	$query_rsService = sprintf("SELECT COUNT(valertes.idav) as total FROM valertes WHERE valertes.idab = %s", GetSQLValueString($row_rsOperations['idab'], "int"));
	$rsService = mysql_query($query_rsService, $liaisondb) or die(mysql_error());
	$row_rsService = mysql_fetch_assoc($rsService);
	$totalRows_rsService = mysql_num_rows($rsService);
}
						
						echo $row_rsService['total']; 
					 ?>
                    </td>
                    <td><a href="vueabonneservice.php?client=<?php echo $row_rsClient['idcl']; ?>&abonnement=<?php echo $row_rsOperations['idab']; ?>"><i class="icon-share-alt"></i> Voir les opérations liées au service</a></td>
                  </tr>
                <?php } while ($row_rsOperations = mysql_fetch_assoc($rsOperations)); ?>
              <?php } ?>
                  </tbody>
          </table>
            <div style="margin-bottom:70px;">
                <?php
                    /* Appel de la fonction */
                    echo paginate('vueabonne.php?id='.$_GET['id'], '&page=', $totalPages_rsOperations, $current);
                ?>          
        </div>
        
<ul class="pager">
  <li class="previous">
    <a href="abonnes.php">&larr; Retour</a>
  </li>
</ul>
        
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
mysql_free_result($rsOperations);
?>