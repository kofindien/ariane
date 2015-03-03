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

	/*$salt1 = "qm&h*";	$salt2 = "p#g!@";
	echo $motpasse = md5($salt2.md5($salt1.'deborah'.$salt2).$salt1);*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Ajouter un groupe ::: Console d'administration</title>
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
		var mminsert=$("#MM_insert").val();
		var libg=$("#libg").val();
		
		var gestionnaires=$("#gestionnaires").val();
		var user1=$("#user1").val();
		var user2=$("#user2").val();
		var user3=$("#user3").val();
		var user4=$("#user4").val();
		var user5=$("#user5").val();
		var user6=$("#user6").val();
		
		var rechargements=$("#rechargements").val();
		var rech1=$("#rech1").val();
		var rech2=$("#rech2").val();
		var rech3=$("#rech3").val();
		
		var monprofil=$("#monprofil").val();
		var mpf1=$("#mpf1").val();
		var mpf2=$("#mpf2").val();
		var mpf3=$("#mpf3").val();
		
		var valertes=$("#valertes").val();
		var valt1=$("#valt1").val();
		var valt2=$("#valt2").val();
		var valt3=$("#valt3").val();
		
		var privileges=$("#privileges").val();
		var gp1=$("#gp1").val();
		var gp2=$("#gp2").val();
		var gp3=$("#gp3").val();
		var gp4=$("#gp4").val();
		
		var abonnes=$("#abonnes").val();
		var ab1=$("#ab1").val();
		var ab2=$("#ab2").val();
		var ab3=$("#ab3").val();
		
		if (mminsert =="" || libg ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
		return false;
		}
		
		$("#flash").show();
		$("#flash").fadeIn(500).html('<div class="container"><div class="progress progress-striped active"><div class="bar" style="width: 0%;"></div></div></div> Traitement en cours ...');
		$("#flash").delay(8000).fadeOut(500);
		//use the $.post() method to call insert.php file.. this is the ajax request 
		$.post('insertgroupe.php', {mminsert: mminsert, libg: libg, gestionnaires: gestionnaires, user1: user1, user2: user2, user3: user3, user4: user4, user5: user5, user6: user6, rechargements: rechargements, rech1: rech1, rech2: rech2, rech3: rech3, monprofil: monprofil, mpf1: mpf1, mpf2: mpf2, mpf3: mpf3, valertes: valertes, valt1: valt1, valt2: valt2, valt3: valt3, privileges: privileges, gp1: gp1, gp2: gp2, gp3: gp3, gp4: gp4, abonnes: abonnes, ab1: ab1, ab2: ab2, ab3: ab3},
		function(data){
			$("#message").html(data);
			$("#message").hide();
			$("#flash").hide();
			$("#message").fadeIn(500).delay(5000)/*.fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#retour").fadeIn(1500)/*.delay(5000).fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#frmGroupe").hide();
		});
		return false;
	});
});
</script>

<script type="text/javascript">
	function users(){
		if (document.getElementById('gestionnaires').checked==true){
			document.frmGroupe.user1.disabled=false;
			document.frmGroupe.user2.disabled=false;
			document.frmGroupe.user3.disabled=false;
			document.frmGroupe.user4.disabled=false;
			document.frmGroupe.user5.disabled=false;
			document.frmGroupe.user6.disabled=false;
		}
		else {
			document.frmGroupe.user1.disabled=true;
			document.frmGroupe.user2.disabled=true;
			document.frmGroupe.user3.disabled=true;
			document.frmGroupe.user4.disabled=true;
			document.frmGroupe.user5.disabled=true;
			document.frmGroupe.user6.disabled=true;
			document.frmGroupe.user1.checked=false;
			document.frmGroupe.user2.checked=false;
			document.frmGroupe.user3.checked=false;
			document.frmGroupe.user4.checked=false;
			document.frmGroupe.user5.checked=false;
			document.frmGroupe.user6.checked=false;
		}
	}
	function recharges(){
		if (document.getElementById('rechargements').checked==true){
			document.frmGroupe.rech1.disabled=false;
			document.frmGroupe.rech2.disabled=false;
			document.frmGroupe.rech3.disabled=false;
		}
		else {
			document.frmGroupe.rech1.disabled=true;
			document.frmGroupe.rech2.disabled=true;
			document.frmGroupe.rech3.disabled=true;
			document.frmGroupe.rech1.checked=false;
			document.frmGroupe.rech2.checked=false;
			document.frmGroupe.rech3.checked=false;
		}
	}
	
	function mprofil(){
		if (document.getElementById('monprofil').checked==true){
			document.frmGroupe.mpf1.disabled=false;
			document.frmGroupe.mpf2.disabled=false;
			document.frmGroupe.mpf3.disabled=false;
		}
		else {
			document.frmGroupe.mpf1.disabled=true;
			document.frmGroupe.mpf2.disabled=true;
			document.frmGroupe.mpf3.disabled=true;
			document.frmGroupe.mpf1.checked=false;
			document.frmGroupe.mpf2.checked=false;
			document.frmGroupe.mpf3.checked=false;
		}
	}
	
	function valert(){
		if (document.getElementById('valertes').checked==true){
			document.frmGroupe.valt1.disabled=false;
			document.frmGroupe.valt2.disabled=false;
			document.frmGroupe.valt3.disabled=false;
		}
		else {
			document.frmGroupe.valt1.disabled=true;
			document.frmGroupe.valt2.disabled=true;
			document.frmGroupe.valt3.disabled=true;
			document.frmGroupe.valt1.checked=false;
			document.frmGroupe.valt2.checked=false;
			document.frmGroupe.valt3.checked=false;
		}
	}
	
	function clients(){
		if (document.getElementById('abonnes').checked==true){
			document.frmGroupe.ab1.disabled=false;
			document.frmGroupe.ab2.disabled=false;
			document.frmGroupe.ab3.disabled=false;
		}
		else {
			document.frmGroupe.ab1.disabled=true;
			document.frmGroupe.ab2.disabled=true;
			document.frmGroupe.ab3.disabled=true;
			document.frmGroupe.ab1.checked=false;
			document.frmGroupe.ab2.checked=false;
			document.frmGroupe.ab3.checked=false;
		}
	}
	
	function droits(){
		if (document.getElementById('privileges').checked==true){
			document.frmGroupe.gp1.disabled=false;
			document.frmGroupe.gp2.disabled=false;
			document.frmGroupe.gp3.disabled=false;
			document.frmGroupe.gp4.disabled=false;
		}
		else {
			document.frmGroupe.gp1.disabled=true;
			document.frmGroupe.gp2.disabled=true;
			document.frmGroupe.gp3.disabled=true;
			document.frmGroupe.gp4.disabled=true;
			document.frmGroupe.gp1.checked=false;
			document.frmGroupe.gp2.checked=false;
			document.frmGroupe.gp3.checked=false;
			document.frmGroupe.gp4.checked=false;
		}
	}
	
	function jsreset(){
			document.frmGroupe.user1.disabled=true;
			document.frmGroupe.user2.disabled=true;
			document.frmGroupe.user3.disabled=true;
			document.frmGroupe.user4.disabled=true;
			document.frmGroupe.user5.disabled=true;
			document.frmGroupe.user6.disabled=true;
			
			document.frmGroupe.rech1.disabled=true;
			document.frmGroupe.rech2.disabled=true;
			document.frmGroupe.rech3.disabled=true;
			
			document.frmGroupe.mpf1.disabled=true;
			document.frmGroupe.mpf2.disabled=true;
			document.frmGroupe.mpf3.disabled=true;
			
			document.frmGroupe.valt1.disabled=true;
			document.frmGroupe.valt2.disabled=true;
			document.frmGroupe.valt3.disabled=true;

			document.frmGroupe.gp1.disabled=true;
			document.frmGroupe.gp2.disabled=true;
			document.frmGroupe.gp3.disabled=true;
			document.frmGroupe.gp4.disabled=true;
	}
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
<div class="pull-left titre">Ajouter un groupe et ses permissions</div>
</div>

                <div id="flash"></div>
                <div id="vide"></div>
                <div id="message"></div>
                <div id="retour" style="margin-top:15px;">
                <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour à la liste des groupes" onclick="window.location.replace('groupes.php');" />
                </div>

<form action="" method="POST" name="frmGroupe" id="frmGroupe">
            <div style="padding:0 0 5px 0; border-bottom:2px solid #036; margin:0 0 10px 0;"><strong>Important</strong> : (<span class="rouge">*</span>) champ obligatoire</div>

            <table width="100%" align="center" cellpadding="2" cellspacing="1">
              <tr valign="baseline">
                <td width="35%" align="right" valign="middle" nowrap="nowrap">
                <label class="control-label" for="libg">Groupe <span class="rouge">*</span> :</label>
                </td>
                <td width="65%">
                <input name="libg" type="text" id="libg" class="span6" required="required" />
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td colspan="2" align="left" valign="middle" nowrap="nowrap"><div style="background-color:#09C; padding:5px 5px 5px 15px; color:#FFF; border-left:20px solid #77AD1A;"><strong>Choix de module(s) et de privilèges</strong></div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>
                <label class="control-label" for="gestionnaires">
                <input name="gestionnaires" type="checkbox" id="gestionnaires" value="gestionnaires" onclick="users()" /> 
                Utilisateurs</label>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle">
                <div style="padding:8px; font-size:12px; color:#999; border-right:1px solid #CCC;">
                      Veuillez indiquer le(s) permission(s) à utiliser avec le module UTILISATEURS si ce dernier est coché.
                  </div>
                  </td>
                <td align="center">
                <table width="90%" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                      <td>
                <label class="control-label" for="user1">
                <input name="user1" type="checkbox" id="user1" value="aj_user" disabled="disabled" /> Ajouter</label>
                      </td>
                      <td>
                <label class="control-label" for="user2">
                <input name="user2" type="checkbox" id="user2" value="mod_user" disabled="disabled" /> Modifier</label>
                </td>
                      <td>
                <label class="control-label" for="user3">
               <input name="user3" type="checkbox" id="user3" value="sup_user" disabled="disabled" /> Supprimer</label>
                </td>
                    </tr>
                    <tr>
                      <td>
                <label class="control-label" for="user4">
               <input name="user4" type="checkbox" id="user4" value="activ_user" disabled="disabled" /> Activer</label>
                </td>
                      <td>
                <label class="control-label" for="user5">
           <input name="user5" type="checkbox" id="user5" value="desact_user" disabled="disabled" /> Désactiver</label>
                </td>
                      <td>
                <label class="control-label" for="user6">
           <input name="user6" type="checkbox" id="user6" value="consul_user" disabled="disabled" /> Consulter</label>
                </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>
                <label class="control-label" for="abonnes">
                <input name="abonnes" type="checkbox" id="abonnes" value="abonnes" onclick="clients()" /> 
                Abonnés</label>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle">
                <div style="padding:8px; font-size:12px; color:#999; border-right:1px solid #CCC;">
                      Veuillez indiquer le(s) permission(s) à utiliser avec le module ABONNES si ce dernier est coché.
                  </div>
                </td>
                <td align="center">
                <table width="90%" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                      <td>
                <label class="control-label" for="ab1">
                <input name="ab1" type="checkbox" id="ab1" value="ab_lst" disabled="disabled" /> Voir liste</label>
                      </td>
                      <td>
                <label class="control-label" for="ab2">
                <input name="ab2" type="checkbox" id="ab2" value="ab_serv" disabled="disabled" /> Voir service(s)</label>
                </td>
                      <td>
                <label class="control-label" for="ab3">
               <input name="ab3" type="checkbox" id="ab3" value="ab_op" disabled="disabled" /> Voir opération(s)</label>
                </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>
               <label class="control-label" for="rechargements">
               <input name="rechargements" type="checkbox" id="rechargements" value="rechargements" onclick="recharges()" /> 
               Rechargements</label>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle"><div style="padding:8px; font-size:12px; color:#999; border-right:1px solid #CCC;"> Veuillez indiquer le(s) permission(s) à utiliser avec le module RECHARGEMENTS si ce dernier est coché. </div></td>
                <td align="center">
                <table width="80%" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                      <td>
               <label class="control-label" for="rech1">
              <input name="rech1" type="checkbox" id="rech1" value="rech_cours" disabled="disabled" /> En attente</label>
                      </td>
                      <td>
               <label class="control-label" for="rech2">
              <input name="rech2" type="checkbox" id="rech2" value="rech_eff" disabled="disabled" /> Effectués</label>
                      </td>
                      <td>
               <label class="control-label" for="rech3">
              <input name="rech3" type="checkbox" id="rech3" value="rech_neff" disabled="disabled" /> Non effectués</label>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>
                <label class="control-label" for="monprofil">
                <input name="monprofil" type="checkbox" id="monprofil" value="monprofil" onclick="mprofil()" /> 
                Mon Profil</label></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle">
                <div style="padding:8px; font-size:12px; color:#999; border-right:1px solid #CCC;">
                Veuillez indiquer le(s) permission(s) à utiliser avec le module MON PROFIL si ce dernier est coché.
                </div>
                </td>
                <td align="center"><table width="80%" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                      <td>
               <label class="control-label" for="mpf1">
               <input name="mpf1" type="checkbox" id="mpf1" value="mpf_cours" disabled="disabled" /> En attente</label>
               		  </td>
                      <td>
               <label class="control-label" for="mpf2">
               <input name="mpf2" type="checkbox" id="mpf2" value="mpf_eff" disabled="disabled" /> Effectués</label></td>
                      <td>
               <label class="control-label" for="mpf3">
               <input name="mpf3" type="checkbox" id="mpf3" value="mpf_neff" disabled="disabled" /> Non effectués</label></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>
     <label class="control-label" for="valertes">
     <input name="valertes" type="checkbox" id="valertes" value="valertes" onclick="valert()" /> Alertes Voyages</label> 
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle"><div style="padding:8px; font-size:12px; color:#999; border-right:1px solid #CCC;"> Veuillez indiquer le(s) permission(s) à utiliser avec le module ALERTES VOYAGES si ce dernier est coché. </div></td>
                <td align="center"><table width="80%" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                      <td>
                      <label class="control-label" for="valt1">
                      <input name="valt1" type="checkbox" id="valt1" value="valt_cours" disabled="disabled" /> 
                      En attente</label></td>
                      <td>
                      <label class="control-label" for="valt2">
                      <input name="valt2" type="checkbox" id="valt2" value="valt_eff" disabled="disabled" /> 
                      Effectués</label></td>
                      <td>
                      <label class="control-label" for="valt3">
                      <input name="valt3" type="checkbox" id="valt3" value="valt_neff" disabled="disabled" /> 
                        Non effectués</label>
  </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>
                <label class="control-label" for="privileges">
                <input name="privileges" type="checkbox" id="privileges" value="privileges" onclick="droits()" /> 
                Groupes &amp; Permissions</label>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle"><div style="padding:8px; font-size:12px; color:#999; border-right:1px solid #CCC;"> Veuillez indiquer le(s) permission(s) à utiliser avec le module GROUPES &amp; PERMISSIONS si ce dernier est coché. </div></td>
                <td align="center"><table width="80%" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                      <td>
                      <label class="control-label" for="gp1">
                      <input name="gp1" type="checkbox" id="gp1" value="aj_gp" disabled="disabled" /> Ajouter</label></td>
                      <td>
                      <label class="control-label" for="gp2">
                      <input name="gp2" type="checkbox" id="gp2" value="mod_gp" disabled="disabled" /> Modifier</label></td>
                      <td>
                      <label class="control-label" for="gp3">
                      <input name="gp3" type="checkbox" id="gp3" value="sup_gp" disabled="disabled" /> Supprimer</label></td>
                    </tr>
                    <tr>
                      <td>
                      <label class="control-label" for="gp4">
                      <input name="gp4" type="checkbox" id="gp4" value="voir_gp" disabled="disabled" /> Consulter</label></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td colspan="2" align="center" nowrap="nowrap"><input name="profil" type="hidden" id="profil" value="user" />
                  <input name="ide" type="hidden" id="ide" value="<?php echo $_SESSION['emeraude_user_ide']; ?>" />
                  <br />
                  <br />
                  <div class="control-group well">
                    <div class="controls">
                      <button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('groupes.php');"><i class="icon-remove icon-white"></i> Annuler la création du groupe</button>
                      <button type="submit" id="Submit" name="Submit" class="btn btn-primary"><i class="icon-check icon-white"></i> Créer le gropue et ses permissions</button>
                    </div>
                  </div>
				</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" id="MM_insert" value="frmGroupe" />
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
?>