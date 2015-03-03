<?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
<?php
//Activation des Alertes voyages en fonction de l'ID
if (isset($_GET['success'])){
  $idAlerteVoyage = trim($_GET['idAlerteVoyage']);
    $updateSQL = "UPDATE alerts_voyages SET alerts_voyages.statut='1' WHERE alerts_voyages.id = '$idAlerteVoyage' ";

    mysql_select_db($database_liaisondb, $liaisondb);
    $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());

    if ($Result1)  $alerte = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La demande d\'alert validée avec succès.</div>';
    else $alerte =  '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La validation a échouée veuillez reéssayer!</div>';
}

if (isset($_GET['annuler'])){
    $idAlerteVoyage = trim($_GET['idAlerteVoyage']);
    $motif = trim($_GET['motif']);
    //Update du statut a 2 pour indiquer que l'occurrence est annulée
    $updateSQL = "UPDATE alerts_voyages SET alerts_voyages.statut='2' WHERE alerts_voyages.id = '$idAlerteVoyage' ";
    mysql_select_db($database_liaisondb, $liaisondb);
    $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());
     if($Result1){
    //Insertion du motif de l'occurence annulée
    $insertSQL = "INSERT INTO motifs(id_alert_voyage,texte,date_created) VALUES('$idAlerteVoyage','$motif',now())";
    mysql_select_db($database_liaisondb, $liaisondb);
    $Result2 = mysql_query($insertSQL, $liaisondb) or die(mysql_error());
     }
    if ($Result2)  $alerte = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La demande d\'alert annulée avec succès.</div>';
    else $alerte =  '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La validation a échouée veuillez reéssayer!</div>';
}

?>
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

$colname_rsRecharge = "-1";
if (isset($_GET['id'])) {
  $colname_rsRecharge = $_GET['id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsRecharge = "SELECT * FROM alerts_voyages WHERE alerts_voyages.statut = '0'";
$rsRecharge = mysql_query($query_rsRecharge, $liaisondb) or die(mysql_error());
$row_rsRecharge = mysql_fetch_assoc($rsRecharge);
$totalRows_rsRecharge = mysql_num_rows($rsRecharge);


/* Calcul du nombre total d'entrées $total dans la table documents */
mysql_select_db($database_liaisondb, $liaisondb);
$queryOperations =  "SELECT * FROM alerts_voyages WHERE alerts_voyages.statut = '0' ";
$rsRecharge = mysql_query($query_rsRecharge, $liaisondb) or die(mysql_error());
$Operations = mysql_query($queryOperations, $liaisondb) or die(mysql_error());
$totalRows_rsOperations = mysql_num_rows($Operations);
	
/* Libération du résultat */
mysql_free_result($Operations);

/* Déclaration des variables */
$maxRows_rsOperations = 15; // nombre d'entrées à afficher par page (entries per page)
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
$query_rsOperations =  "SELECT * FROM alerts_voyages WHERE alerts_voyages.statut = 0 ORDER BY alerts_voyages.id DESC";
//$query_limit_rsOperations = sprintf("%s LIMIT %d, %d", $query_rsOperations, $startRow_rsOperations, $maxRows_rsOperations);
$rsOperations = mysql_query($query_rsOperations, $liaisondb) or die(mysql_error());
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
<script type="text/javascript" src="../js/ckeditor.js"></script>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="highslide/highslide-full.js"></script>
<script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
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

		var to=$("#to").val();
		var action=$("#action").val();
		var idav=$("#idav").val();

		if (action=='success'){
             var_
		}

		if (action=='annuler'){

			var motif=$("#motif").val();
			var observation=$("#observation").val();

			//alert("To : "+to+"\n\nMotif : "+motif+"\n\nObservation : "+observation);

		if (motif =="" || observation =="" || action =="" || idav ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires avant l\'envoi du message...</div>');
		return false;
		}

		$("#flash").show();
		$("#flash").fadeIn(500).html('<div class="container"><div class="progress progress-striped active"><div class="bar" style="width: 0%;"></div></div></div> Traitement en cours ...');
		$("#flash").delay(8000).fadeOut(500);
		//use the $.post() method to call insert.php file.. this is the ajax request
		$.post('avactiver.php', {to: to, motif: motif, observation: observation, action: action, idav: idav},
		function(data){
			$("#message").html(data);
			$("#message").hide();
			$("#flash").hide();
			$("#message").fadeIn(500).delay(5000)/*.fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#retour").fadeIn(1500)/*.delay(5000).fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#frmAnnuler").hide();
			$("#filariane").hide();
			$("#lstattentes").hide();
		});

		}

		return false;
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
<div class="pull-left titre">Les demandes d'alertes voyages en attente</div><br/><br/><br/>
<?php if(isset($alerte)){ echo $alerte ;} ?>
<?php if ($totalRows_rsOperations >0){ ?>
<div class="pull-right" id="filariane">
 Total demande en attentes: <?= $totalRows_rsRecharge; ?></strong>
</div>
<?php } ?>
</div>
              
    <div id="flash"></div>
    <div id="vide"></div>
    <div id="message"></div>
    <div id="retour" style="margin-top:15px;">
    <button type="button" name="return" id="return" class="btn btn-success" onclick="window.location.replace('avattentes.php');"><i class="icon-circle-arrow-left icon-white"></i> Retour</button>
    </div>
              
<?php if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['action']) && $_GET['action']=='valider'){
   $idAlerteVoyage = $_GET['id'];
 ?>
<div align="center" id="frmRecharger">
    <form class="form-inline well" method="get" action="#" id="frmRecharge" name="frmRecharge">
          <label for="abonne">Merci de confirmer votre validation ? </label>

          <input name="idAlerteVoyage" type="hidden" id="idav" value="<?= $idAlerteVoyage ; ?>" />
          <button type="submit" name="success" class="btn btn-primary"><i class="icon-white icon-check"></i> Valider</button>
          <button type="button" id="button" name="button" class="btn btn-danger" onclick="window.location.replace('avattentes.php');">X</button>
    </form>
</div>
<?php } ?>

<?php if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['action']) && $_GET['action']=='annuler'){
    $idAlerteVoyage = $_GET['id'];
    ?>
    <div align="center" id="frmRecharger">
        <form class="form-inline well" method="get" action="#" id="frmRecharge" name="frmRecharge">

                <label >Veuillez choisir le motif d'annulation de cette demande d'alerte SVP ?</label>
                <br/>
            <select name="motif">
                <option value="Solde insuffisant">Solde insuffisant</option>
                <option value="Numéro invalide">Numéro invalide</option>
            </select>
                <br/><br/>
                <input name="idAlerteVoyage" type="hidden" id="idav" value="<?= $idAlerteVoyage ; ?>" />
                <button type="submit" name="annuler" class="btn btn-success"><i class="icon-white icon-check"></i> Valider</button>
                <button type="button" id="button" name="button" class="btn btn-danger" onclick="window.location.replace('avattentes.php');">X</button>

        </form>
    </div>
<?php } ?>


<div id="lstattentes">


<?php if ($totalRows_rsOperations >0){ ?>
<table class="table table-striped table-hover" width="100%" border="0" cellspacing="1" cellpadding="2">
                  <thead>
                  <tr>
                    <th>Date de départ</th>
                    <th>Numéro Vol - (Compagnie)</th>
                    <th>Heure du vol</th>
                    <th>Moyen de paiements</th>
                    <th>Téléphone</th>
                    <th>Date de le demande</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
              <?php do { ?>
                  <tr>
                    <td>
                    <!--<a href="avinfooperation.php?id=<?php echo $row_rsOperations['id']; ?>" class="lien_bleu_" onclick="return hs.htmlExpand(this, {
                objectType: 'ajax', width: '700', 
                creditsPosition: 'bottom left', headingText: 'Vue détaillée', 
                wrapperClassName: 'titlebar' } )"> --><?= $row_rsOperations['date_depart']; ?><!--</a>--></td>
                    <td><?php echo $row_rsOperations['numero_vol']; ?></td>
                    <td><?= $row_rsOperations['heure_debut_vol'] ?> h <?= $row_rsOperations['minuite_debut_vol'] ?> min</td>
                    <td><?php echo $row_rsOperations['mode_paiement']; ?></td>
                      <td><?php echo $row_rsOperations['telephone']; ?></td>
                      <td><?php echo $row_rsOperations['date_creation']; ?></td>
                    <td>
					<div class="btn-group">
                        <a class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            Action
                            <span class="caret"></span>
                        </a>	
                        <ul class="dropdown-menu">
                            <li>
                            <a tabindex="-1" href="avattentes.php?id=<?php echo $row_rsOperations['id']; ?>&action=valider">
                            <i class="icon-check"></i> Valider</a><a tabindex="-1" href="avattentes.php?id=<?php echo $row_rsOperations['id']; ?>&action=annuler">
                                    <i class="icon-remove"></i>Annuler</a>
                            </li>

                        </ul>
                    </div>                    </td>
                  </tr>
                <?php } while ($row_rsOperations = mysql_fetch_assoc($rsOperations)); ?>
                  </tbody>
                </table>
            <div style="margin-bottom:70px;">
                <?php
                    /* Appel de la fonction */
                    echo paginate('avattentes.php', '?page=', $totalPages_rsOperations, $current);
                ?>          
        </div>
<?php 
}
else echo '<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Il n\'y a aucune demande de paiements en attente...</div>';
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
<script type="text/javascript" src="../js/ckeditor/ckeditor.js"></script>
</body>
<!-- InstanceEnd --></html>
<?php
//mysql_free_result($rsRecharge);

//mysql_free_result($rsTotaux);

//mysql_free_result($rsOperations);
?>