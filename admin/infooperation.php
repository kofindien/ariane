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
 $query_rsOperation = sprintf("SELECT recharges.idr, recharges.idab, recharges.montant, recharges.frais, recharges.fraisp, recharges.mpaie, recharges.cel, recharges.dateaj, recharges.status, recharges.dateserv, services.service, abonnements.numcard, abonnements.dvalidite, abonnements.numid, clients.civilite, clients.nom, clients.prenoms FROM recharges, abonnements, services, clients WHERE recharges.idab = abonnements.idab AND abonnements.idcl = clients.idcl AND abonnements.ids = services.ids AND recharges.idr = %s", GetSQLValueString($colname_rsOperation, "int"));
$rsOperation = mysql_query($query_rsOperation, $liaisondb) or die(mysql_error());
$row_rsOperation = mysql_fetch_assoc($rsOperation);
$totalRows_rsOperation = mysql_num_rows($rsOperation);
?>
<link href="../include/style.css" rel="stylesheet" type="text/css" />
<link href="../include/_css.css" rel="stylesheet" type="text/css" />
<table class="table table-striped table-hover pull-right" width="100%" border="0" cellspacing="1" cellpadding="2">
  <thead>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Identité du client :</th>
    <td width="40%" align="left"><?php echo $row_rsOperation['civilite'], ' ',$row_rsOperation['nom'],' ',$row_rsOperation['prenoms']; ?></td>
  </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">N° carte prépayée VISA UBA Africard :</th>
    <td width="40%" align="left"><?php echo $row_rsOperation['numcard']; ?></td>
  </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Date de validité de la carte :</th>
    <td width="40%" align="left"><?php echo $row_rsOperation['dvalidite']; ?></td>
  </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Client identification :</th>
    <td width="40%" align="left"><?php echo $row_rsOperation['numid']; ?></td>
  </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Date de la demande :</th>
    <td width="40%" align="left"><?php LongDateEN2dateFR($row_rsOperation['dateaj']); ?></td>
    </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Service :</th>
    <td width="40%" align="left"><?php echo $row_rsOperation['service']; ?></td>
    </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Moyen de paiement :</th>
    <td width="40%" align="left"><?php echo $row_rsOperation['mpaie']; ?></td>
    </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Cellulaire / N° transaction :</th>
    <td width="40%" align="left"><?php echo $row_rsOperation['cel']; ?></td>
    </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Montant à préléver/recevoir  :</th>
    <td width="40%" align="left"><?php echo number_format($row_rsOperation['montant'],0,',', ' '); ?> F CFA</td>
  </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Frais plateforme :</th>
    <td width="40%" align="left"><?php echo number_format($row_rsOperation['fraisp'],0,',', ' '); ?> F CFA</td>
    </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Frais de recharge sur carte VISA UBA Africard :</th>
    <td width="40%" align="left"><?php echo number_format($row_rsOperation['frais'],0,',', ' '); ?> F CFA</td>
  </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Montant à recharger sur la carte prépayée VISA UBA Africard :</th>
    <td width="40%" align="left"><?php echo number_format($row_rsOperation['montant']-$row_rsOperation['frais']-$row_rsOperation['fraisp'],0,',', ' '); ?> F CFA</td>
  </tr>
  <tr bgcolor="#000000" style="color:#FFF;">
    <th align="right" nowrap="nowrap">Montant à recharger sur la plateforme UBA :</th>
    <td align="left"><?php echo number_format($row_rsOperation['montant']-$row_rsOperation['fraisp'],0,',', ' '); ?> F CFA</td>
  </tr>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Status :</th>
    <td width="40%" align="left"><?php if ($row_rsOperation['status']) echo 'Servi'; else echo 'En attente'; ?></td>
  </tr>
  <?php if ($row_rsOperation['status']){ ?>
  <tr>
    <th width="60%" align="right" nowrap="nowrap">Servi le :</th>
    <td width="40%" align="left"><?php LongDateEN2dateFR($row_rsOperation['dateserv']); ?></td>
    </tr>
   <?php } ?> 
  </thead>
  <tbody>
  </tbody>
</table>
<?php 
mysql_free_result($rsOperation);
?>