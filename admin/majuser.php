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
$query_rsGroupe = "SELECT idg, libg FROM groupes ORDER BY libg ASC";
$rsGroupe = mysql_query($query_rsGroupe, $liaisondb) or die(mysql_error());
$row_rsGroupe = mysql_fetch_assoc($rsGroupe);
$totalRows_rsGroupe = mysql_num_rows($rsGroupe);

$colname_rsUser = "-1";
if (isset($_GET['id'])) {
  $colname_rsUser = $_GET['id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsUser = sprintf("SELECT * FROM comptes WHERE idc = %s", GetSQLValueString($colname_rsUser, "int"));
$rsUser = mysql_query($query_rsUser, $liaisondb) or die(mysql_error());
$row_rsUser = mysql_fetch_assoc($rsUser);
$totalRows_rsUser = mysql_num_rows($rsUser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Modifier un utilisateur ::: Console d'administration</title>
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
		var nom=$("#nom").val();
		var prenoms=$("#prenoms").val();
		var cel=$("#cel").val();
		var idg=$("#idg").val();
		var idc=$("#idc").val();
		var email=$("#email").val();
		var motp=$("#motp").val();
		var motpasse=$("#motpasse").val();
		
		if (nom =="" || prenoms =="" || cel =="" || idg =="" || email =="" || idc ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
		return false;
		}
		
		$("#flash").show();
		$("#flash").fadeIn(500).html('<div class="container"><div class="progress progress-striped active"><div class="bar" style="width: 0%;"></div></div></div> Traitement en cours ...');
		$("#flash").delay(8000).fadeOut(500);
		//use the $.post() method to call insert.php file.. this is the ajax request
		$.post('updateuser.php', {nom: nom, prenoms: prenoms, cel: cel, idg: idg, email: email, motpasse: motpasse, motp: motp, idc: idc},
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
<div class="pull-left titre">Modifier un utilisateur</div>
</div>

                <div id="flash"></div>
                <div id="vide"></div>
                <div id="message"></div>
                <div id="retour" style="margin-top:15px;">
                <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour à la liste des utilisateurs" onclick="window.location.replace('users.php');" />
                </div>

<form action="" method="post" class="form-horizontal" id="frmCompte" name="frmCompte">
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;">
<strong>Informations sur l'utilisateur :</strong>
</div>
<div class="control-group">
  <label class="control-label" for="nom">Nom <span class="rouge">*</span></label>
    <div class="controls">
      <input name="nom" type="text" required="required" id="nom" placeholder="Nom" value="<?php echo $row_rsUser['nom']; ?>">
    </div>
</div>
  <div class="control-group">
    <label class="control-label" for="prenoms">Prénoms <span class="rouge">*</span></label>
    <div class="controls">
      <input name="prenoms" type="text" required="required" class="input-xlarge" id="prenoms" placeholder="Prénoms" value="<?php echo $row_rsUser['prenoms']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="cel">Cellulaire <span class="rouge">*</span></label>
    <div class="controls">
    <div class="input-prepend">
      <span class="add-on">225</span>
      <input name="cel" type="text" required="required" class="input-small" id="cel" placeholder="00000000" value="<?php echo $row_rsUser['cel']; ?>" maxlength="8">
    </div>
    </div>
  </div>
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le compte :</strong></div>
<div class="control-group">
  <label class="control-label" for="idg">Groupe d'utilsateur <span class="rouge">*</span></label>
    <div class="controls">
    <select name="idg" class="input-large" id="idg">
      <option selected="selected" value=""></option>
      <?php do { ?>
      <option value="<?php echo $row_rsGroupe['idg']?>"<?php if (!(strcmp($row_rsGroupe['idg'], $row_rsUser['idg']))){echo "selected=\"selected\"";} ?>><?php echo $row_rsGroupe['libg']?></option>
      <?php
		} while ($row_rsGroupe = mysql_fetch_assoc($rsGroupe));
		  $rows = mysql_num_rows($rsGroupe);
		  if($rows > 0) {
			  mysql_data_seek($rsGroupe, 0);
			  $row_rsGroupe = mysql_fetch_assoc($rsGroupe);
		  }
	  ?>
    </select>
    </div>
</div>
  <div class="control-group">
    <label class="control-label" for="email">Login <span class="rouge">*</span></label>
    <div class="controls">
      <input name="email" type="email" required="required" class="input-xlarge" id="email" placeholder="nom@site.com" value="<?php echo $row_rsUser['email']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="motp">Ancien mot de passe</label>
    <div class="controls">
      ***********<input type="hidden" name="motp" id="motp" value="<?php echo $row_rsUser['motpasse']; ?>">
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
      <input name="idc" type="hidden" id="idc" value="<?php echo $row_rsUser['idc']; ?>" />
      <button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('users.php');"><i class="icon-circle-arrow-left icon-white"></i> Retour</button>
      <button type="submit" id="Submit" name="Submit" class="btn btn-primary"><i class="icon-edit icon-white"></i> Modifier le compte</button>
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
mysql_free_result($rsGroupe);

mysql_free_result($rsUser);
?>
