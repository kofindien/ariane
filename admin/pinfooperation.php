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
 $query_rsOperation = sprintf("SELECT mprofil.idp, mprofil.idab, mprofil.montant, mprofil.cout, mprofil.cel, mprofil.fraisp, mprofil.mpaie, mprofil.mensualite, mprofil.dateaj, mprofil.ddate, mprofil.fdate, mprofil.status, mprofil.dateserv, services.service, abonnements.niveau, abonnements.diplome, abonnements.experience, abonnements.age, domaines.domaine, clients.civilite, clients.nom, clients.prenoms FROM mprofil, abonnements, services, domaines, clients WHERE mprofil.idab = abonnements.idab AND abonnements.ids = services.ids AND abonnements.idd = domaines.idd AND abonnements.idcl = clients.idcl AND mprofil.idp = %s", GetSQLValueString($colname_rsOperation, "int"));
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
    <th width="50%" align="right">Domaine d'activités :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['domaine']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Niveau  :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['niveau']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Diplôme :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['diplome']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Nombre d'années d'expérience :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['experience']; ?> an(s)</td>
    </tr>
  <tr>
    <th width="50%" align="right">Age :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['age']; ?> ans</td>
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
  <tr>
    <th width="50%" align="right">Durée :</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['mensualite']; ?> mois</td>
  </tr>
  <?php if ($row_rsOperation['status']){ ?>
  <tr>
    <th width="50%" align="right">Servi le :</th>
    <td width="50%" align="left"><?php LongDateEN2dateFR($row_rsOperation['dateserv']); ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Début :</th>
    <td width="50%" align="left"><?php echo dateEN2dateFR($row_rsOperation['ddate']); ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Fin :</th>
    <td width="50%" align="left"><?php echo dateEN2dateFR($row_rsOperation['fdate']); ?></td>
  </tr>
   <?php } ?> 
  </thead>
  <tbody>
  </tbody>
</table>
<?php 
mysql_free_result($rsOperation);
?>
