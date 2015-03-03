<?php require_once('Connections/liaisondb.php'); ?>
<?php require_once('bin/fonctions.php'); ?>
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

$colname_rsOffre = "-1";
if (isset($_GET['id'])) {
  $colname_rsOffre = $_GET['id'];
}
mysql_select_db($database_attachedb, $attachedb);
 $query_rsOffre = sprintf("SELECT offres.ido, offres.sectactivite, domaines.domaine, offres.contrat, offres.recruteur, offres.adressegeo, offres.bp, offres.tel1, offres.tel2, offres.cel1, offres.cel2, offres.cel3, offres.fax, offres.emailr, offres.siteweb, sources.source, offres.code, offres.`ref`, offres.intitulepost, offres.expertise, offres.nbposte, offres.societe, offres.email, offres.lien, offres.diplome, offres.experience, offres.age, offres.cv, offres.courrier, offres.modeledos, offres.salaire, offres.permis, offres.photo, offres.copie, offres.datepub, offres.datexpir, offres.dateaj FROM offres LEFT JOIN domaines ON offres.idd=domaines.idd LEFT JOIN sources ON offres.ids=sources.ids WHERE offres.ido = %s", GetSQLValueString($colname_rsOffre, "int"));
$rsOffre = mysql_query($query_rsOffre, $attachedb) or die(mysql_error());
$row_rsOffre = mysql_fetch_assoc($rsOffre);
$totalRows_rsOffre = mysql_num_rows($rsOffre);
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/_css.css" rel="stylesheet" type="text/css" />
<table id="hor-minimalist-b" summary="Meeting Results">
            <thead>
              <tr>
                <th width="34%" scope="col">Offre d'emploi<br><br><br></th>
                <th width="33%" scope="col">&nbsp;</th>
                <th width="33%" scope="col">Recruteur<br><br><br></th>
              </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
              <tr>
                <td width="34%" valign="top">
                
                Date de saisie de l'offre : <strong><?php echo LongDateEN2dateFR($row_rsOffre['dateaj']); ?></strong><br />
                  <br />
                Domaine de compétences : <strong><?php echo $row_rsOffre['domaine']; ?></strong><br />
                <br />
                Intitulé du poste : <strong><?php echo $row_rsOffre['intitulepost']; ?></strong><br />
                <br />
                Référence du poste : <strong><?php echo $row_rsOffre['ref']; ?></strong><br />
                Contrat : <strong><?php echo $row_rsOffre['contrat']; ?></strong><br />
                <br />
                Société : <strong><?php echo $row_rsOffre['societe']; ?></strong><br />
                Secteur d'activités : <strong><?php echo $row_rsOffre['sectactivite']; ?></strong><br />
                <br />
                Domaine d'expertise :<strong><?php echo $row_rsOffre['expertise']; ?></strong><br />
                <br />
                Nombre de postes à pourvoir : <strong><?php echo $row_rsOffre['nbposte']; ?></strong><br />
                <br />
                E-mail de soumission à l'offre : <strong><?php echo $row_rsOffre['email']; ?></strong><br />
                <br />
                Lien de l'offre :<a href="<?php echo $row_rsOffre['lien']; ?>" target="_blank" class="lien_bleu_"> <?php echo $row_rsOffre['lien']; ?></a>
                
                <br /><br />
                
                </td>
                <td width="33%" valign="top">
                
                Diplôme : <strong><?php echo $row_rsOffre['diplome']; ?></strong><br />
                  <br />
Experience professionnelle : <strong><?php echo $row_rsOffre['experience']; ?></strong><br />
<br />
Age  exigé : <strong><?php echo $row_rsOffre['age']; ?></strong><br />
<br />
CV : <strong><?php echo $row_rsOffre['cv']; ?></strong><br />
                  <br />
                  Modèle  de dossier : <strong><?php echo $row_rsOffre['modeledos']; ?></strong><br />
                  <br />
                  Lettre de motivation : <strong><?php echo $row_rsOffre['courrier']; ?></strong><br />
                  <br />
                  Photocopie (légalisée) des diplômes  : <strong><?php echo $row_rsOffre['copie']; ?></strong><br />
                  <br />
                  Salaire : <strong><?php echo $row_rsOffre['salaire']; ?></strong><br />
                  <br />
                  Permis de conduire : <strong><?php echo $row_rsOffre['permis']; ?></strong><br />
                  <br />
                  Photo :<strong><?php echo $row_rsOffre['photo']; ?></strong>
                 
                  <br /><br />
                
                </td>
                <td width="33%" valign="top">
                
Recruteur : <strong><?php echo $row_rsOffre['recruteur']; ?></strong><br />
<br />
Boîte postale : <strong><?php echo $row_rsOffre['bp']; ?></strong><br />
<br />
Adresse géographique : <strong><?php echo $row_rsOffre['adressegeo']; ?></strong><br />
<br />
Téléphone(s) :
<strong>
<?php 
if ($row_rsOffre['tel1'] && trim($row_rsOffre['tel1'])!='-') echo $row_rsOffre['tel1']; 
if ($row_rsOffre['tel2'] && trim($row_rsOffre['tel2'])!='-') echo ' / ',$row_rsOffre['tel2']; 
if (trim($row_rsOffre['tel1'])=='-' && trim($row_rsOffre['tel2'])=='-') echo '-'; 
?>
</strong> <br />
<br />
Cellulaire(s) :
<strong>
<?php 
if ($row_rsOffre['cel1'] && trim($row_rsOffre['cel1'])!='-') echo $row_rsOffre['cel1']; 
if ($row_rsOffre['cel2'] && trim($row_rsOffre['cel2'])!='-') echo ' / ',$row_rsOffre['cel2']; 
if ($row_rsOffre['cel3'] && trim($row_rsOffre['cel3'])!='-') echo ' / ',$row_rsOffre['cel3']; 
if (trim($row_rsOffre['cel1'])=='-' && trim($row_rsOffre['cel2'])=='-' && trim($row_rsOffre['cel3'])=='-') echo '-'; 
?>
</strong> <br />
<br />
Fax : <strong><?php echo $row_rsOffre['fax']; ?></strong><br />
<br />
E-mail : <strong><?php echo $row_rsOffre['emailr']; ?></strong><br />
<br />
Site web : <strong><?php echo $row_rsOffre['siteweb']; ?></strong>
                
                </td>
              </tr>
            </tbody>
          </table><table align="center" cellpadding="2" cellspacing="1" class="texte">
  <tr valign="baseline">
    <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
    <td valign="baseline">&nbsp;</td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="middle" nowrap="nowrap">Date de publication de l'offre :</td>
    <td><?php echo dateEN2dateFR($row_rsOffre['datepub']); ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="middle" nowrap="nowrap">Date d'expiration de l'offre :</td>
    <td><?php echo dateEN2dateFR($row_rsOffre['datexpir']); ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="middle" nowrap="nowrap">Source de l'offre :</td>
    <td>
	<?php echo $row_rsOffre['source']; ?>
    </td>
  </tr>
</table>
<?php 
mysql_free_result($rsOffre);
?>