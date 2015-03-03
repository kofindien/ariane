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

/* Calcul du nombre total d'entrées $total dans la table documents */
mysql_select_db($database_liaisondb, $liaisondb);
$queryOperations = "SELECT * FROM comptes WHERE comptes.suppr = 0";
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
$query_rsUsers = "SELECT comptes.idc, comptes.nom, comptes.prenoms, comptes.cel, comptes.email, comptes.dateaj, groupes.libg FROM comptes, groupes WHERE comptes.suppr = 0 AND comptes.idg = groupes.idg ORDER BY comptes.nom ASC, comptes.prenoms ASC";
$query_limit_rsUsers = sprintf("%s LIMIT %d, %d", $query_rsUsers, $startRow_rsUsers, $maxRows_rsUsers);
$rsUsers = mysql_query($query_limit_rsUsers, $liaisondb) or die(mysql_error());
$row_rsUsers = mysql_fetch_assoc($rsUsers);


mysql_select_db($database_liaisondb, $liaisondb);
$query_rsMontants = "SELECT SUM(recharges.montant-recharges.frais) AS mtr, SUM(recharges.frais) AS mtfr, MONTH(recharges.dateaj) AS mois FROM recharges WHERE recharges.suppr = 0 AND recharges.status = 1 GROUP BY MONTH(recharges.dateaj)";
$rsMontants = mysql_query($query_rsMontants, $liaisondb) or die(mysql_error());
$row_rsMontants = mysql_fetch_assoc($rsMontants);
$totalRows_rsMontants = mysql_num_rows($rsMontants);

	do { 
			$mtr[$row_rsMontants['mois']] = $row_rsMontants['mtr'];
			$mtfr[$row_rsMontants['mois']] = $row_rsMontants['mtfr'];
	} while ($row_rsMontants = mysql_fetch_assoc($rsMontants)); 
	
	for ($i=0; $i < 12; $i++){
		if (isset($mtr[$i])) $_mtr[$i] = $mtr[$i]; else $_mtr[] = 0;
		if (isset($mtfr[$i])) $_mtfr[$i] = $mtfr[$i]; else $_mtfr[] = 0;
		@$moy[] = round( (($_mtr[$i]+$mtfr[$i]) / 2), 2);
	}

	$mt_r = implode(',', $_mtr);
	$mt_fr = implode(',', $_mtfr);
	$_moy = implode(',', $moy);

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsTotJour = "SELECT COUNT(*) AS totJour FROM recharges WHERE suppr = 0 AND status = 1 AND dateserv = CURDATE()";
$rsTotJour = mysql_query($query_rsTotJour, $liaisondb) or die(mysql_error());
$row_rsTotJour = mysql_fetch_assoc($rsTotJour);
$totalRows_rsTotJour = mysql_num_rows($rsTotJour);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsTotGlobal = "SELECT COUNT(*) AS totGlobal FROM recharges WHERE suppr = 0 AND status = 1";
$rsTotGlobal = mysql_query($query_rsTotGlobal, $liaisondb) or die(mysql_error());
$row_rsTotGlobal = mysql_fetch_assoc($rsTotGlobal);
$totalRows_rsTotGlobal = mysql_num_rows($rsTotGlobal);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsMtJour = "SELECT SUM(montant) AS MtJour FROM recharges WHERE suppr = 0 AND status = 1 AND dateserv = CURDATE()";
$rsMtJour = mysql_query($query_rsMtJour, $liaisondb) or die(mysql_error());
$row_rsMtJour = mysql_fetch_assoc($rsMtJour);
$totalRows_rsMtJour = mysql_num_rows($rsMtJour);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsMtGlobal = "SELECT SUM(montant) AS MtGlobal FROM recharges WHERE suppr = 0 AND status = 1";
$rsMtGlobal = mysql_query($query_rsMtGlobal, $liaisondb) or die(mysql_error());
$row_rsMtGlobal = mysql_fetch_assoc($rsMtGlobal);
$totalRows_rsMtGlobal = mysql_num_rows($rsMtGlobal);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsMtFJour = "SELECT SUM(frais) AS MtFJour FROM recharges WHERE suppr = 0 AND status = 1 AND dateserv = CURDATE()";
$rsMtFJour = mysql_query($query_rsMtFJour, $liaisondb) or die(mysql_error());
$row_rsMtFJour = mysql_fetch_assoc($rsMtFJour);
$totalRows_rsMtFJour = mysql_num_rows($rsMtFJour);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsMtFGlobal = "SELECT SUM(frais) AS MtFGlobal FROM recharges WHERE suppr = 0 AND status = 1";
$rsMtFGlobal = mysql_query($query_rsMtFGlobal, $liaisondb) or die(mysql_error());
$row_rsMtFGlobal = mysql_fetch_assoc($rsMtFGlobal);
$totalRows_rsMtFGlobal = mysql_num_rows($rsMtFGlobal);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsMtFGlobal = "SELECT SUM(frais) AS MtFGlobal FROM recharges WHERE suppr = 0 AND status = 1";
$rsMtFGlobal = mysql_query($query_rsMtFGlobal, $liaisondb) or die(mysql_error());
$row_rsMtFGlobal = mysql_fetch_assoc($rsMtFGlobal);
$totalRows_rsMtFGlobal = mysql_num_rows($rsMtFGlobal);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsOM = "SELECT SUM(montant) AS totOM FROM recharges WHERE suppr = 0 AND status = 1 AND mpaie = 'Orange Money'";
$rsOM = mysql_query($query_rsOM, $liaisondb) or die(mysql_error());
$row_rsOM = mysql_fetch_assoc($rsOM);
$totalRows_rsOM = mysql_num_rows($rsOM);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsMTN = "SELECT SUM(montant) AS totMTN FROM recharges WHERE suppr = 0 AND status = 1 AND mpaie = 'MTN Mobile Money'";
$rsMTN = mysql_query($query_rsMTN, $liaisondb) or die(mysql_error());
$row_rsMTN = mysql_fetch_assoc($rsMTN);
$totalRows_rsMTN = mysql_num_rows($rsMTN);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsFLOOZ = "SELECT SUM(montant) AS totFLOOZ FROM recharges WHERE suppr = 0 AND status = 1 AND mpaie = 'Flooz'";
$rsFLOOZ = mysql_query($query_rsFLOOZ, $liaisondb) or die(mysql_error());
$row_rsFLOOZ = mysql_fetch_assoc($rsFLOOZ);
$totalRows_rsFLOOZ = mysql_num_rows($rsFLOOZ);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsBankcell = "SELECT SUM(montant) AS totBank FROM recharges WHERE suppr = 0 AND status = 1 AND mpaie = 'Bankcell'";
$rsBankcell = mysql_query($query_rsBankcell, $liaisondb) or die(mysql_error());
$row_rsBankcell = mysql_fetch_assoc($rsBankcell);
$totalRows_rsBankcell = mysql_num_rows($rsBankcell);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsTotNew = "SELECT COUNT(*) AS totNew FROM recharges WHERE suppr = 0 AND status = 0";
$rsTotNew = mysql_query($query_rsTotNew, $liaisondb) or die(mysql_error());
$row_rsTotNew = mysql_fetch_assoc($rsTotNew);
$totalRows_rsTotNew = mysql_num_rows($rsTotNew);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsClients = "SELECT COUNT(*) AS totAbonne FROM clients WHERE suppr = 0";
$rsClients = mysql_query($query_rsClients, $liaisondb) or die(mysql_error());
$row_rsClients = mysql_fetch_assoc($rsClients);
$totalRows_rsClients = mysql_num_rows($rsClients);

//$$$$$$$$$$$$$$$$$$$$$$$$
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Console d'administration ARIANE</title>
<!-- InstanceEndEditable -->
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>

<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="highslide/highslide-full.js"></script>
<script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />

<script type="text/javascript">
$(function () {
	$('#container').highcharts({
		chart: {
		},
		title: {
			text: 'Montants & moyennes mensuels des rechargements et des frais liés'
		},
		xAxis: {
			categories: ['Janvier','Février', 'Mars','Avril', 'Mai', 'Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre']
		},
		tooltip: {
			formatter: function() {
				var s;
				if (this.point.name) { // the pie chart
					s = ''+
						this.point.name +': '+ this.y +'';
				} else {
					s = ''+
						this.x  +': '+ this.y;
				}
				return s;
			}
		},
		labels: {
			items: [{
				html: 'Repartition des montants',
				style: {
					left: '40px',
					top: '8px',
					color: 'black'
				}
			}]
		},
		series: [{
			type: 'column',
			name: 'Rechargements',
			data: [<?php echo $mt_r; ?>]
		},{
			type: 'column',
			name: 'Frais de rechargements',
			data: [<?php echo $mt_fr; ?>]
		}, {
			type: 'spline',
			name: 'Moyenne',
			data: [<?php echo $_moy; ?>],
			marker: {
				lineWidth: 2,
				lineColor: Highcharts.getOptions().colors[3],
				fillColor: 'white'
			}
		}, {
			type: 'pie',
			name: 'Total consumption',
			data: [{
				name: 'Rechargements',
				y: <?php echo array_sum($_mtr); ?>,
				color: Highcharts.getOptions().colors[0] // Jane's color
			}, {
				name: 'Frais de rechargements',
				y: <?php echo array_sum($_mtfr); ?>,
				color: Highcharts.getOptions().colors[2] // Joe's color
			}],
			center: [100, 80],
			size: 100,
			showInLegend: false,
			dataLabels: {
				enabled: false
			}
		}]
	});
});
</script>
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
<div class="pull-left titre">Tableau de bord</div>
</div>
              
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div align="center" style="margin:15px 0;"><img src="../img/_separe.png" /></div>

<div align="center">
<button type="button" class="btn btn-success" data-toggle="collapse" data-target="#stats"><i class="icon-plus icon-white"></i> Statistiques</button>
</div>
<div id="stats" class="collapse">

<div style="padding:15px;">
  <div class="row-fluid">
    <div class="span6"><img src="../img/puce4.gif" /> 
    Nombre total des rechargements du jour : <span class="label label-info"><?php echo number_format($row_rsTotJour['totJour'],0,',', ' '); ?></span>
    </div>
    <div class="span6"><img src="../img/puce4.gif" /> 
    Nombre total des rechargements : <span class="label label-info"><?php echo number_format($row_rsTotGlobal['totGlobal'],0,',', ' '); ?></span>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span6"><img src="../img/puce4.gif" /> 
    Montant total des rechargements du jour : <span class="label label-info"><?php echo number_format($row_rsMtJour['MtJour'],0,',', ' '); ?> f CFA</span>
    </div>
    <div class="span6"><img src="../img/puce4.gif" /> 
    Montant total des rechargements : <span class="label label-info"><?php echo number_format($row_rsMtGlobal['MtGlobal'],0,',', ' '); ?> f CFA</span>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span6"><img src="../img/puce4.gif" /> 
    Montant total des frais de rechargements du jour : <span class="label label-success"><?php echo number_format($row_rsMtFJour['MtFJour'],0,',', ' '); ?> f CFA</span>
    </div>
    <div class="span6"><img src="../img/puce4.gif" /> 
    Montant total des frais de rechargements : <span class="label label-success"><?php echo number_format($row_rsMtFGlobal['MtFGlobal'],0,',', ' '); ?> f CFA</span>
    </div>
  </div>
  <div style="background-color:#9CC; padding:15px; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px;">
  <div class="row-fluid">
    <div class="span6"><img src="../img/puce.gif" /> 
    Orange Money : <span class="label label-info"><?php echo number_format($row_rsOM['totOM'],0,',', ' '); ?> f CFA</span>
    </div>
    <div class="span6"><img src="../img/puce.gif" /> 
    MTN Mobile Money : <span class="label label-info"><?php echo number_format($row_rsMTN['totMTN'],0,',', ' '); ?> f CFA</span>
    </div>
  </div>
    <div class="row-fluid">
      <div class="span6"><img src="../img/puce.gif" /> 
        MOOV Flooz : <span class="label label-info"><?php echo number_format($row_rsFLOOZ['totFLOOZ'],0,',', ' '); ?> f CFA</span>
        </div>
      <div class="span6"><img src="../img/puce.gif" /> 
        La Caisse d'Epargne Bankcell : <span class="label label-info"><?php echo number_format($row_rsBankcell['totBank'],0,',', ' '); ?> f CFA</span>
        </div>
    </div>
  </div>
</div>

</div>

<div class="row-fluid" style="padding:15px; margin-top:15px;">
	<div class="span5"><img src="../img/puce3.gif" /> 
    <?php if ($row_rsTotNew['totNew']){ ?>
    <a href="attentes.php">Demande(s) de rechargement en attente</a> <span class="badge badge-important"><?php echo number_format($row_rsTotNew['totNew'],0,',', ' '); ?></span>
    <?php } else echo 'Demande(s) de rechargement en attente'; ?>
    </div>
	<div class="span3"><img src="../img/puce3.gif" /> <a href="rechargements.php">Rechargements effectués</a></div>
	<div class="span4"><img src="../img/puce3.gif" /> <a href="abonnes.php">Nouveau(x) abonné(s)</a> <span class="label label-info"><?php echo number_format($row_rsClients['totAbonne'],0,',', ' '); ?></span></div>
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
mysql_free_result($rsUsers);

mysql_free_result($rsTotGlobal);

mysql_free_result($rsTotJour);
?>