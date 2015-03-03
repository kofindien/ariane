<?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
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

$colname_rsOperation = "-1";
if (isset($_GET['id'])) {
  $colname_rsOperation = $_GET['id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
 $query_rsOperation = sprintf("SELECT valertes.idav, valertes.idab, valertes.montant, valertes.cout, valertes.compagnie, valertes.fraisp, valertes.mpaie, valertes.vol, valertes.cel, valertes.ddepart, valertes.hdepart, valertes.hlimite, valertes.destination, valertes.dateaj, valertes.status, valertes.dateserv, services.service, clients.civilite, clients.nom, clients.prenoms FROM valertes, abonnements, services, clients WHERE valertes.idab = abonnements.idab AND abonnements.ids = services.ids AND abonnements.idcl = clients.idcl AND valertes.idav = %s", GetSQLValueString($colname_rsOperation, "int"));
$rsOperation = mysql_query($query_rsOperation, $liaisondb) or die(mysql_error());
$row_rsOperation = mysql_fetch_assoc($rsOperation);
$totalRows_rsOperation = mysql_num_rows($rsOperation);
?>
<link href="./include/style.css" rel="stylesheet" type="text/css" />
<link href="./include/_css.css" rel="stylesheet" type="text/css" />
<table class="table table-striped table-hover pull-right" width="100%" border="0" cellspacing="1" cellpadding="2">
  <thead>
  <tr>
    <th width="50%" align="right">Identité du client :</th>
    <td width="50%" align="left">
	<?php echo $row_rsOperation['civilite'], ' ',$row_rsOperation['nom'],' ',$row_rsOperation['prenoms']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Compagnie aérienne :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['compagnie']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">N° de vol  :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['vol']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Destination :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['destination']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Date de départ :</th>
    <td width="50%" align="left"><?php echo dateEN2dateFR($row_rsOperation['ddepart']); ?></td>
    </tr>
  <tr>
    <th width="50%" align="right">Heure de départ :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['hdepart']; ?></td>
    </tr>
  <tr>
    <th align="right">Heure limite d'embarquement :</th>
    <td align="left"><?php echo $row_rsOperation['hlimite']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Moyen de paiement :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['mpaie']; ?></td>
    </tr>
  <tr>
    <th width="50%" align="right">Cellulaire / N° transaction :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['cel']; ?></td>
    </tr>
  <tr>
    <th align="right">Coût du service :</th>
    <td align="left"><?php echo number_format($row_rsOperation['cout'],0,',', ' '); ?> F CFA</td>
  </tr>
  <tr>
    <th width="50%" align="right">Frais plateforme :</th>
    <td width="50%" align="left"><?php echo number_format($row_rsOperation['fraisp'],0,',', ' '); ?> F CFA</td>
    </tr>
  <tr>
    <th width="50%" align="right">
    <?php 
	if ($row_rsOperation['status']) echo 'Montant prélévé/reçu :';
	else echo 'Montant à préléver/recevoir :';
	?>
    </th>
    <td width="50%" align="left"><?php echo number_format($row_rsOperation['montant'],0,',', ' '); ?> F CFA</td>
    </tr>
  <tr>
    <th width="50%" align="right">Status :</th>
    <td width="50%" align="left"><?php if ($row_rsOperation['status']) echo 'Servi'; else echo 'En attente'; ?></td>
  </tr>
  <?php if ($row_rsOperation['status']){ ?>
  <tr>
    <th width="50%" align="right">Servi le :</th>
    <td width="50%" align="left"><?php LongDateEN2dateFR($row_rsOperation['dateserv']); ?></td>
    </tr>
   <?php } ?> 
  </thead>
  <tbody>
  </tbody>
</table>
<?php 
mysql_free_result($rsOperation);
?>
