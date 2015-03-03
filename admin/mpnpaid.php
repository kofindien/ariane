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
$query_rsTotaux = "SELECT SUM(mprofil.montant) AS preleve, SUM(mprofil.cout) AS coutserv, SUM(mprofil.fraisp) AS plateforme FROM mprofil WHERE mprofil.annule = 1 AND mprofil.sup = 0 AND mprofil.status = 0";
$rsTotaux = mysql_query($query_rsTotaux, $liaisondb) or die(mysql_error());
$row_rsTotaux = mysql_fetch_assoc($rsTotaux);
$totalRows_rsTotaux = mysql_num_rows($rsTotaux);

/* Calcul du nombre total d'entrées $total dans la table documents */
mysql_select_db($database_liaisondb, $liaisondb);
$queryOperations = "SELECT * FROM mprofil WHERE mprofil.annule = 1 AND mprofil.sup = 0 AND mprofil.status = 0";
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
$query_rsOperations = "SELECT mprofil.idp, mprofil.montant, mprofil.cout, mprofil.mensualite, mprofil.cel, mprofil.dateaj, mprofil.ddate, mprofil.fdate, mprofil.status, mprofil.dateserv, services.service, clients.nom, clients.prenoms FROM mprofil, services, abonnements, clients WHERE mprofil.annule = 1 AND mprofil.sup = 0 AND mprofil.status = 0 AND mprofil.idab = abonnements.idab AND abonnements.idcl = clients.idcl AND abonnements.ids = services.ids ORDER BY mprofil.idp DESC";
$query_limit_rsOperations = sprintf("%s LIMIT %d, %d", $query_rsOperations, $startRow_rsOperations, $maxRows_rsOperations);
$rsOperations = mysql_query($query_limit_rsOperations, $liaisondb) or die(mysql_error());
$row_rsOperations = mysql_fetch_assoc($rsOperations);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Les paiements en attentes pour mon profil ::: Console d'administration</title>
<!-- InstanceEndEditable -->
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>

<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="highslide/highslide-full.js"></script>
<script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<!--<script type="text/javascript">
$(document).ready(function(){
	//Get the input data using the post method when Submit is clicked .. we pull it using the libp fields of LIBP respectively...
	
	var progress = setInterval(function() {
		var $bar = $('.bar');
	
		if ($bar.width()==400) {
			clearInterval(progress);
			$('.progress').removeClass('active');
		} else {
			$bar.width($bar.width()+40);
		}
		$bar.text($bar.width()/4 + "%");
	}, 800);	
	
    $("#message").hide();
    $("#retour").hide();
	$("#Submit").click(function(){
		//Get values of the input field and store it into the variable.
		var montant=$("#montant").val();
		var mensualite=$("#mensualite").val();
		var idp=$("#idp").val();
		
		if (montant =="" || mensualite =="" || idp ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
		return false;
		}
		
		$("#flash").show();
		$("#flash").fadeIn(500).html('<div class="container"><div class="progress progress-striped active"><div class="bar" style="width: 0%;"></div></div></div> Traitement en cours ...');
		$("#flash").delay(8000).fadeOut(500);
		//use the $.post() method to call insert.php file.. this is the ajax request
		$.post('pactiver.php', {montant: montant, mensualite: mensualite, idp: idp},
		function(data){
			$("#message").html(data);
			$("#message").hide();
			$("#flash").hide();
			$("#message").fadeIn(500).delay(5000)/*.fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#retour").fadeIn(1500)/*.delay(5000).fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#frmRecharger").hide();
			$("#filariane").hide();
			$("#lstattentes").hide();
		});
		return false;
	});
});
</script>-->
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
<div class="pull-left titre">Les paiements non effectués</div>
<?php if ($totalRows_rsOperations >0){ ?>
<div class="pull-right" id="filariane">
  Affichage de <?php echo ($startRow_rsOperations + 1) ?> &agrave; <?php echo min($startRow_rsOperations + $maxRows_rsOperations, $totalRows_rsOperations) ?> sur <strong><?php echo $totalRows_rsOperations ?></strong>
</div>
<?php } ?>
</div>

<div align="center" style="margin:10px 0;">
  <table class="table table-bordered" cellspacing="1" cellpadding="5">
    <tr>
      <th align="center">Total montant prélevé/reçu</th>
      <th align="center">Total frais plateforme</th>
      <th align="center">Total service</th>
      </tr>
    <tr class="error">
      <td><?php echo number_format($row_rsTotaux['preleve'],0,',',' '); ?> f CFA</td>
      <td><?php echo number_format($row_rsTotaux['plateforme'],0,',',' '); ?> f CFA</td>
      <td><?php echo number_format($row_rsTotaux['coutserv'],0,',',' '); ?> f CFA</td>
      </tr>
  </table>
</div>

<table class="table table-striped table-hover" width="100%" border="0" cellspacing="1" cellpadding="2">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Abonné</th>
                    <th>Durée</th>
                    <th>Montant</th>
                    <th align="center" nowrap="nowrap">Début</th>
                    <th align="center" nowrap="nowrap">Fin</th>
                    <th>Reçu</th>
                  </tr>
                </thead>
                <tbody>
			<?php if ($totalRows_rsOperations >0){ ?>
              <?php do { ?>
                <tr>
                  <td>
                  <a href="pinfooperation.php?id=<?php echo $row_rsOperations['idp']; ?>" class="lien_bleu_" onclick="return hs.htmlExpand(this, { 
                objectType: 'ajax', width: '600', 
                creditsPosition: 'bottom left', headingText: 'Vue détaillée', 
                wrapperClassName: 'titlebar' } )"><?php LongDateEN2dateFR($row_rsOperations['dateaj']); ?></a></td>
                  <td><?php echo $row_rsOperations['service']; ?></td>
                  <td><?php echo $row_rsOperations['nom'], ' ', $row_rsOperations['prenoms']; ?></td>
                  <td><?php echo $row_rsOperations['mensualite']; ?> mois</td>
                  <td><?php echo number_format($row_rsOperations['montant'],0,',', ' '); ?></td>
                  <td nowrap="nowrap"><?php echo dateEN2dateFR($row_rsOperations['ddate']); ?></td>
                  <td nowrap="nowrap"><?php echo dateEN2dateFR($row_rsOperations['fdate']); ?></td>
                  <td>
                  <a href="precu.php?id=<?php echo $row_rsOperations['idp']; ?>" title="Imprimer le reçu" target="_blank"><img src="../img/pdf.png" <?php RedImage("../img/pdf.png",25,0); ?> /></a>
                  </td>
                </tr>
                <?php } while ($row_rsOperations = mysql_fetch_assoc($rsOperations)); ?>
			<?php } ?>
                </tbody>
              </table>
          <div style="margin-bottom:70px;">
              <?php
                    /* Appel de la fonction */
                    echo paginate('mppaiements.php', '?page=', $totalPages_rsOperations, $current);
              ?>          
        </div>
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
mysql_free_result($rsTotaux);

mysql_free_result($rsOperations);
?>