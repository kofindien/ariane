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

$colname_rsAbonne = "-1";
if (isset($_GET['id'])) {
  $colname_rsAbonne = $_GET['id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsAbonne = sprintf("SELECT clients.idcl, clients.civilite, clients.nom, clients.prenoms, clients.cel, clients.email, clients.motpasse, clients.dateaj, abonnements.idab, abonnements.numcard, abonnements.dvalidite FROM clients, abonnements WHERE clients.idcl = abonnements.idcl AND clients.idcl = %s", GetSQLValueString($colname_rsAbonne, "int"));
$rsAbonne = mysql_query($query_rsAbonne, $liaisondb) or die(mysql_error());
$row_rsAbonne = mysql_fetch_assoc($rsAbonne);
$totalRows_rsAbonne = mysql_num_rows($rsAbonne);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Ajouter un abonné ::: Console d'administration</title>
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
$(document).ready(function(){
	//Get the input data using the post method when Submit is clicked .. we pull it using the libp fields of LIBP respectively...
    $("#message").hide();
    $("#retour").hide();
	$("#Submit").click(function(){
		//Get values of the input field and store it into the variable.
		var civilite=$("#civilite").val();
		var nom=$("#nom").val();
		var prenoms=$("#prenoms").val();
		var cel=$("#cel").val();
		var numcard=$("#numcard").val();
		var dvalidite=$("#dvalidite").val();
		var email=$("#email").val();
		var motpasse=$("#motpasse").val();
		var motp=$("#motp").val();
		var idcl=$("#idcl").val();
		var idab=$("#idab").val();
		
		if (idcl =="" || civilite =="" || nom =="" || prenoms =="" || cel =="" || numcard =="" || dvalidite =="" || email =="" || idab ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
		return false;
		}
		
		$("#flash").show();
		$("#flash").fadeIn(800).html('<img src="../img/ajax-loader.gif" width="220" height="19" align="absmiddle" /> Traitement en cours ...');
		//use the $.post() method to call insert.php file.. this is the ajax request
		$.post('updateabonne.php', {civilite: civilite, nom: nom, prenoms: prenoms, cel: cel, numcard: numcard, dvalidite: dvalidite, email: email, motpasse: motpasse, motp: motp, idcl: idcl, idab: idab},
		function(data){
			$("#message").html(data);
			$("#message").hide();
			$("#flash").hide();
			$("#message").fadeIn(500).delay(5000)/*.fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#retour").fadeIn(1500)/*.delay(5000).fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#frmCompte").hide();
		});
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
<div class="pull-left titre">Modifier un abonné</div>
</div>
              
                <div id="flash"></div>
                <div id="vide"></div>
                <div id="message"></div>
                <div id="retour" style="margin-top:15px;">
                <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour" onclick="window.location.replace('<?php echo $_SERVER['HTTP_REFERER']; ?>');" />
                </div>


<form action="" method="post" class="form-horizontal" id="frmCompte" name="frmCompte">
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le client :</strong></div>
<div class="control-group">
  <label class="control-label" for="civilite">Civilité <span class="rouge">*</span></label>
    <div class="controls">
        <label class="radio inline">
          <input <?php if (!(strcmp($row_rsAbonne['civilite'],"Mlle"))) {echo "checked=\"checked\"";} ?> type="radio" name="civilite" id="civilite1" value="Mlle" required="required"> Mademoiselle
        </label>
        <label class="radio inline">
          <input <?php if (!(strcmp($row_rsAbonne['civilite'],"Mme"))) {echo "checked=\"checked\"";} ?> type="radio" name="civilite" id="civilite2" value="Mme" required="required"> Madame
        </label>
        <label class="radio inline">
          <input <?php if (!(strcmp($row_rsAbonne['civilite'],"Mr"))) {echo "checked=\"checked\"";} ?> type="radio" name="civilite" id="civilite3" value="Mr" required="required"> Monsieur
        </label>
    </div>
</div>
<div class="control-group">
  <label class="control-label" for="nom">Nom <span class="rouge">*</span></label>
    <div class="controls">
      <input name="nom" type="text" required="required" id="nom" placeholder="Nom" value="<?php echo $row_rsAbonne['nom']; ?>">
    </div>
</div>
  <div class="control-group">
    <label class="control-label" for="prenoms">Prénoms <span class="rouge">*</span></label>
    <div class="controls">
      <input name="prenoms" type="text" required="required" class="input-xlarge" id="prenoms" placeholder="Prénoms" value="<?php echo $row_rsAbonne['prenoms']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="cel1">Cellulaire <span class="rouge">*</span></label>
    <div class="controls">
    <div class="input-prepend">
      <span class="add-on">225</span>
      <input name="cel1" type="text" required="required" class="input-small" id="cel1" placeholder="00000000" value="<?php echo $row_rsAbonne['cel']; ?>">
    </div>
    </div>
  </div>
  
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur service :</strong></div>
  <div class="control-group">
    <label class="control-label" for="service">Service</label>
    <div class="controls">
      <input type="text" id="service" name="service" class="input-xlarge" placeholder="Carte VISA prépayé UBA" style="border:0;" disabled="disabled">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="numcard">Numéro de la carte <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="numcard" name="numcard" class="input-medium" placeholder="0000-0000-0000-0000" required="required" value="<?php echo $row_rsAbonne['numcard']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="dvalidite">Date de validité <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="dvalidite" name="dvalidite" class="span1" placeholder="00/00" required="required" maxlength="5" value="<?php echo $row_rsAbonne['dvalidite']; ?>">&nbsp;&nbsp;(mm/aa; ex. : 10/16)
    </div>
  </div>
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le compte :</strong></div>
  <div class="control-group">
    <label class="control-label" for="email">E-mail <span class="rouge">*</span></label>
    <div class="controls">
      <input type="email" id="email" name="email" class="input-xlarge" placeholder="nom@site.com" required="required" value="<?php echo $row_rsAbonne['email']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="motp">Ancien mot de passe</label>
    <div class="controls">
      <input type="hidden" name="motp" id="motp" value="<?php echo $row_rsAbonne['motpasse']; ?>">xxxxxxxxxxxxxxx
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="motpasse">Mot de passe</label>
    <div class="controls">
      <input type="password" name="motpasse" id="motpasse" placeholder="Mot de passe">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <input name="idcl" type="hidden" id="idcl" value="<?php echo $row_rsAbonne['idcl']; ?>" />
      <input name="idab" type="hidden" id="idab" value="<?php echo $row_rsAbonne['idab']; ?>" />
      <button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('<?php echo $_SERVER['HTTP_REFERER']; ?>');"><i class="icon-circle-arrow-left icon-white"></i> Retour</button>
      <button type="submit" id="Submit" name="Submit" class="btn btn-primary"><i class="icon-edit icon-white"></i> Modifier</button>
    </div>
  </div>
</form>

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
mysql_free_result($rsAbonne);
?>
