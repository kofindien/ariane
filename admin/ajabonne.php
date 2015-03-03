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
<style type="text/css">
.container {
    margin-top: 30px;
    width: 400px;
}
</style>
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
		var civilite=$("#civilite").val();
		var nom=$("#nom").val();
		var prenoms=$("#prenoms").val();
		var cel=$("#cel").val();
		var numcard=$("#numcard").val();
		var dvalidite=$("#dvalidite").val();
		var email=$("#email").val();
		var motpasse=$("#motpasse").val();
		
		if (civilite =="" || nom =="" || prenoms =="" || cel =="" || numcard =="" || email =="" || dvalidite =="" || motpasse ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
		return false;
		}
		
		$("#flash").show();
		$("#flash").fadeIn(500).html('<div class="container"><div class="progress progress-striped active"><div class="bar" style="width: 0%;"></div></div></div> Traitement en cours ...');
		$("#flash").delay(8000).fadeOut(500);
		//use the $.post() method to call insert.php file.. this is the ajax request
		$.post('insertabonne.php', {civilite: civilite, nom: nom, prenoms: prenoms, cel: cel, numcard: numcard, dvalidite: dvalidite, email: email, motpasse: motpasse},
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
<script type="text/javascript" src="../js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
	$(function(){
	   $("#numcard").mask("9999-9999-9999-9999");
	   $("#dvalidite").mask("99/99");
	   $("#cel").mask("99999999");
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
<div class="pull-left titre">Ajouter un abonné</div>
</div>
              
                <div id="flash"></div>
                <div id="vide"></div>
                <div id="message"></div>
                <div id="retour" style="margin-top:15px;">
                <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour à la liste des abonnés" onclick="window.location.replace('abonnes.php');" />
                </div>


<form action="" method="post" class="form-horizontal" id="frmCompte" name="frmCompte">
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le client :</strong></div>
<div class="control-group">
  <label class="control-label" for="civilite">Civilité <span class="rouge">*</span></label>
    <div class="controls">
        <label class="radio inline">
          <input type="radio" name="civilite" id="civilite" value="Mlle" required="required"> Mademoiselle
        </label>
        <label class="radio inline">
          <input type="radio" name="civilite" id="civilite" value="Mme" required="required"> Madame
        </label>
        <label class="radio inline">
          <input type="radio" name="civilite" id="civilite" value="Mr" required="required"> Monsieur
        </label>
    </div>
</div>
<div class="control-group">
  <label class="control-label" for="nom">Nom <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="nom" name="nom" placeholder="Nom" required="required">
    </div>
</div>
  <div class="control-group">
    <label class="control-label" for="prenoms">Prénoms <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="prenoms" name="prenoms" class="input-xlarge" placeholder="Prénoms" required="required">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="cel">Cellulaire <span class="rouge">*</span></label>
    <div class="controls">
    <div class="input-prepend">
      <span class="add-on">225</span>
      <input type="text" id="cel" name="cel" class="input-small" placeholder="00000000" required="required">
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
      <input type="text" id="numcard" name="numcard" class="input-medium" placeholder="0000-0000-0000-0000" required="required" maxlength="4">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="dvalidite">Date de validité <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="dvalidite" name="dvalidite" class="span1" placeholder="00/00" required="required" maxlength="5">&nbsp;&nbsp;(mm/aa; ex. : 10/16)
    </div>
  </div>
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le compte :</strong></div>
  <div class="control-group">
    <label class="control-label" for="email">E-mail <span class="rouge">*</span></label>
    <div class="controls">
      <input type="email" id="email" name="email" class="input-xlarge" placeholder="nom@site.com" required="required">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="motpasse">Mot de passe <span class="rouge">*</span></label>
    <div class="controls">
      <input type="password" name="motpasse" id="motpasse" placeholder="Mot de passe" required="required">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('abonnes.php');"><i class="icon-circle-arrow-left icon-white"></i> Retour</button>
      <button type="submit" id="Submit" name="Submit" class="btn btn-primary"><i class="icon-check icon-white"></i> Soumettre</button>
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