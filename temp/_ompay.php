<?php require_once('Connections/liaisondb.php'); ?>
<?php require_once('bin/fonctions.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
}
$MM_authorizedUsers = "";
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
if (!((isset($_SESSION['ariane_user_login'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['ariane_user_login'], $_SESSION['ariane_user_Group'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

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


$colname_rsAbonnement = "-1";
if (isset($_SESSION['ariane_user_id'])) {
  $colname_rsAbonnement = $_SESSION['ariane_user_id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsAbonnement = sprintf("SELECT abonnements.idab, abonnements.numcard, abonnements.dvalidite, abonnements.numid FROM abonnements, services WHERE abonnements.ids = 1 AND abonnements.idcl = %s", GetSQLValueString($colname_rsAbonnement, "int"));
$rsAbonnement = mysql_query($query_rsAbonnement, $liaisondb) or die(mysql_error());
$row_rsAbonnement = mysql_fetch_assoc($rsAbonnement);
$totalRows_rsAbonnement = mysql_num_rows($rsAbonnement);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Recharger sa carte VISA prépayée UBA ::: Ariane</title>
<!-- InstanceEndEditable -->
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>

    <link rel='stylesheet' id='camera-css'  href='../css/camera.css' type='text/css' media='all'> 
    <style>
		.fluid_container {
			margin: 0 auto;
			max-width: 1000px;
			width: 100%;
		}
	</style>

<style type="text/css">
ul#news {
	list-style:none;
	text-indent:-3em;
}
</style>

    
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>

    <script type='text/javascript' src='../js/jquery.mobile.customized.min.js'></script>
    <script type="text/javascript" src="../js/jquery.easing.js"></script>
    <script type='text/javascript' src='../js/camera.min.js'></script> 

    <script>
			jQuery.noConflict();
		jQuery(function($){
			jQuery('#camera_random').camera({
				thumbnails:false,
				pagination:false,
				fx: 'random',
				height: '290px'
			});

		});
	</script> 

<script type="text/javascript" src="../js/jquery.innerfade.js"></script>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(
		function($){
			$('#news').innerfade({
				/*animationtype: 'slide',*/
				speed: 'slow',
				timeout: 10000,
				type: 'random',
				containerheight: '1em'
			});
			
			$('#trajets').innerfade({
				/*animationtype: 'slide',*/
				speed: 'slow',
				timeout: 10000,
				type: 'random',
				containerheight: '1em'
			});
			
			$('ul#banner').innerfade({
				speed: 1000,
				timeout: 5000,
				type: 'random_start',
				containerheight: '145px'
			});
			
			$('.fade').innerfade({
				speed: 1000,
				timeout: 6000,
				type: 'random_start',
				containerheight: '1.5em'
			});
			
			$('.adi').innerfade({
				speed: 'slow',
				timeout: 5000,
				type: 'random',
				containerheight: '150px'
			});

	});
</script>
<!-- InstanceBeginEditable name="head" -->
<!--<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
	jQuery.noConflict();
	jQuery(function($){
	   $("#code").mask("9999");
	   $("#cel1").mask("99999999");
	});
</script>-->
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($){
	
$("#aide1").popover();
$("#aide2").popover();
$("#aide3").popover();

	//Get the input data using the post method when Submit is clicked .. we pull it using the libp fields of LIBP respectively...
    $("#message").hide();
    $("#retour").hide();
	$("#Submit").click(function(){
		//Get values of the input field and store it into the variable.
		var mpaie=$("#mpaie").val();
		var montant=$("#montant").val();
		var cel=$("#cel").val();
		var frais=$("#frais").val();
		var fraisp=$("#fraisp").val();
		var idab=$("#idab").val();
		
		if (mpaie =="" || montant =="" || cel =="" || frais =="" || fraisp ==""){
		//if (mpaie =="" || montant =="" || cel =="" || frais ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
		return false;
		}
		
		$("#flash").show();
		$("#flash").fadeIn(400).html('<img src="img/ajax-loader.gif" width="220" height="19" align="absmiddle" /> Traitement en cours ...');
		//use the $.post() method to call insert.php file.. this is the ajax request
		$.post('insertrecharge.php', {mpaie: mpaie, montant: montant, cel: cel, frais: frais, idab: idab, fraisp: fraisp},
		//$.post('insertrecharge.php', {mpaie: mpaie, montant: montant, cel: cel, frais: frais, idab: idab},
		function(data){
			$("#message").html(data);
			$("#message").hide();
			$("#flash").hide();
			$("#message").fadeIn(1500).delay(5000)/*.fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#retour").fadeIn(1500)/*.delay(5000).fadeOut(1500)*/; //Fade in the data given by the insert.php file
			$("#montant").val("");
			$("#cel").val("");
			$("#frais").val("");
			$("#mtr").val("");
			$("#mpaie").val("");
			$("#frmRecharge").hide();
		});
		return false;
	});
	
});
</script>
<!-- InstanceEndEditable -->

<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools.js"></script>
<script language="javascript" type="text/javascript" src="../js/lofbreakingnews_mt1.2.js"></script>

<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>

<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
</head>
<body>
<div style="min-height:250px; margin:10px 0 0 0; background:url(../img/backpub.png) top center no-repeat fixed;">
  <!--Entête-->
  <div class="row" align="left" style="width:1000px; height:50px; margin:0 auto;">
    <div class="span7">
        <img src="img/logo.png" width="126" height="29" />&nbsp;&nbsp;&nbsp;&nbsp;
        <img src="img/titre.png" />
    </div>
    
    <div class="span5">
	  <?php if (basename($_SERVER['SCRIPT_NAME']) != 'login.php'){ ?>
	  <?php if (!isset($_SESSION['ariane_user_login'])){ ?>
      <div align="left" style="padding-bottom:8px;"> 
      <strong style=" color:#0F0">Espace client &raquo;</strong>
      <a href="frmcompte.php" class="white">Ouvrir un compte ?</a> &nbsp;
      <a href="login.php?action=recovery" class="white">Mot de passe oublié ?</a>
      </div>
      <form action="../login.php" method="post" name="frmlogin" id="frmlogin" class="form-inline" style="background:#9CC130; padding:5px; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px;">
            <input type="text" name="email" id="email" class="input-medium" placeholder="E-mail..." style="height:14px; font-size:11px;">
            <input type="password" name="motpasse" id="motpasse" class="input-small" placeholder="Mot de passe..." style="height:14px; font-size:11px;">
            <input name="requetelogin" type="hidden" id="requetelogin" value="frmLogin" />
            <button type="submit" class="btn btn-primary btn-small">Connexion</button>
      </form>
     <?php } else { ?>
        <div class="btn-group pull-right" style="padding:20px 0 0 0;">
          <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#">
            <i class="icon-user"></i> <?php echo stripslashes($_SESSION['ariane_user_identite']); ?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="profil.php"><i class="icon-edit"></i> Modifier son profil</a></li>
            <li><a href="mpasse.php"><i class="icon-lock"></i> Modifier son mot de passe</a></li>
            <li class="divider"></li>
            <li><a href="espaceclient.php"><i class="i"></i> Espace client</a></li>
            <li class="divider"></li>
            <li><a href="logout.php"><i class="icon-off"></i> Se déconnecter</a></li>
          </ul>
        </div>        
	 <?php } ?>
      <?php } else { ?>
      <div align="right" style="padding:20px 5px 0 0;"><a href="frmcompte.php" class="white">Ouvrir un compte ?</a></div>
	 <?php } ?>
    </div>
    
    
  </div>
  <!--Fin Entête-->
  <!--Navigation-->
  <div class="row" style="width:1000px; margin:35px auto 20px auto; padding-left:40px; height:30px;">
    <?php require_once('../bin/menu.inc.php'); ?>
  </div>
  <!--Fin Navigation-->
  <!--Banner-->
  <div style="height:290px;">
    <div style="width:970px; margin:0 auto;">

        <div>
        <!--Slideshow-->
        <div align="center" class="fluid_container" style="height:250px;">
            <div class="camera_wrap camera_azure_skin" id="camera_random">
            <?php
            $slides = array(
                        '<div data-src="slides/s.jpg"></div>',
                        '<div data-src="slides/s0.jpg"></div>',
                        '<div data-src="slides/s2.jpg"></div>',
                        '<div data-src="slides/s1.jpg"></div>'
            );
            shuffle($slides);
            foreach ($slides as $slides) {
                echo "$slides\n";
            }
            ?>
            </div>
         </div>
        <!--/Slideshow-->
        </div>

    </div>
  </div>
<!--Fin Banner-->
  <!--Corps-->
  <div class="row" align="left" style="width:1000px; margin:0px auto; background:url(images/separecorps.png) top center no-repeat;">
    <div style="padding-top:30px;">
    <div style="padding:0 20px;">

<!-------------------- FLASH INFOS ------------------------------------->
<div id="lofbreakingnews" class="lof-breakingnews lof-layout-vrup" style="height:20px;">
    <!-- BUTTONS DRIVEN -->  
  <div class="lof-module-nav">
     <div class="lof-module-title">Infos :</div>
     <div class="lof-button-driven"> 
       <a href="/" onclick="return false;" class="lof-button-previous"><span>PREVIOUS</span></a> 
       <a href="/" onclick="return false;" class="lof-button-next"><span>Next</span></a> 
      </div>
  </div>
    <!-- BUTTONS DRIVEN -->
  <!-- MAIN CONTENT -->
  <div class="lof-breakingnews-wrapper" >
    <div class="lof-breakingnew-item"> 
    	<strong class="rouge">ESN ARIANE Plateau</strong> - Immeuble Les ACACIAS BD Clozel 3ème étage porte 302. Téléphone (225) 20 30 13 90 </div>
    <div class="lof-breakingnew-item">
    	<strong class="rouge">ESN ARIANE Plateau DOKUI</strong> - Immeuble SYLLA 2ème étage Route du Zoo face Station OILYBIA. Téléphone : (225) 24 38 50 70 </div>
    <div class="lof-breakingnew-item">
    	<strong class="rouge">ESN ARIANE 2 PLATEAUX</strong> - derrière Hypermarché SOCOCE rue K 125. Téléphone : (225) 22 41 14 16 </div>
  </div>
    <!-- END MAIN CONTENT -->
</div>
<script type="text/javascript">
	var _lofmain =  $('lofbreakingnews');
	var _button  =  {next:_lofmain.getElement('.lof-button-next'), previous :_lofmain.getElement('.lof-button-previous')};
	var _fx 	 =
	new LofBreakingNews( _lofmain, { interval:4000,
									 layoutStyle:'hrleft',
									 fxObject:{ transition:Fx.Transitions.Expo.easeInOut, duration:400 } } 
	).registerButtonsControl( 'click',_button ).start( true );
</script>
   <!-------------------- FLASH INFOS ------------------------------------->    
    
    </div>
	<!-- InstanceBeginEditable name="corps" -->
    

    
      <div style="padding:15px;">
        <div style="padding:25px; border:1px solid #CCC; min-height:850px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
          <div style="line-height:1.3em;">
            <div align="center" style="float:left; width:250px; padding-top:30px;">
            
				<div align="left" style="margin-bottom:25px;">
                <div style="padding:8px 20px;"><img src="images/puce.gif" />&nbsp;&nbsp;&nbsp;
                <a href="profil.php" class="lien_bleu_">Modifier son profil</a></div>
                <div style="padding:8px 20px;"><img src="images/puce.gif" />&nbsp;&nbsp;&nbsp;
                <a href="mpasse.php" class="lien_bleu_">Modifier son mot de passe</a></div>
                <div style="padding:8px 20px;"><img src="images/puce.gif" />&nbsp;&nbsp;&nbsp;
                <a href="logout.php" class="lien_bleu_">Se déconnecter</a></div>
                </div>

              <ul id="news">
                <li><img src="images/car1.png" width="255" height="255" /></li>
                <li><img src="images/car2.png" width="255" height="255" /></li>
              </ul>
            </div>
            <div style="margin-left:260px;">
                
                <div class="titre" style="margin-bottom:20px; padding:10px 0;">
                Espace client &raquo; Recharger sa carte prépayée VISA UBA Africard</div>
				<div style="background:url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>

                <div id="flash"></div>
                <div id="vide"></div>
                <div id="message"></div>
                <div id="retour" style="margin-top:15px;">
                <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour à l'espace client" onclick="window.location.replace('espaceclient.php');" />
                </div>
                
            <div>
                
                <div style="padding-top:10px;">

<form method="post" class="form-horizontal" id="frmRecharge" name="frmRecharge">
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;">
<strong>Informations de rechargement :</strong></div>
  <div class="control-group">
    <label class="control-label" for="code">Numéro de la carte</label>
    <div class="controls">
      <input type="text" id="code" name="code" class="input-medium" value="<?php echo $row_rsAbonnement['numcard']; ?>" readonly="readonly">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="dval">Date de validité</label>
    <div class="controls">
      <input type="text" id="dval" name="dval" class="span1" value="<?php echo $row_rsAbonnement['dvalidite']; ?>" readonly="readonly">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="numid">Client identification</label>
    <div class="controls">
      <input type="text" id="numid" name="numid" class="input-small" value="<?php echo $row_rsAbonnement['numid']; ?>" readonly="readonly">
    </div>
  </div>
<script type="text/javascript">	
	function cFrais(){
		var fom = 0;
		var frais = 0;
		var fraisp = 0.0;
		var mtr = 0;
		var mt = document.forms["frmRecharge"].montant.value;
		
		if (mt <= 55000){
			frais =1100;
			fraisp =309;
		}
		else {
			frais = ((mt)*2/100);
			frais = Math.ceil(frais/10)*10;
			
			fraisp = ((mt)*0.7/100);
			fraisp = Math.ceil(fraisp/10)*10;
		}
		mtr = Math.round(mt-fraisp-frais);
		document.forms["frmRecharge"].fraisp.value = fraisp;
		document.forms["frmRecharge"].mtr.value = mtr;
		document.forms["frmRecharge"].frais.value = frais;
	}
</script>
<div class="control-group">
  <label class="control-label" for="mpaie">Moyen de paiement <span class="rouge">*</span></label>
    <div class="controls">
    <input name="mpaie" type="hidden" id="mpaie" value="Orange Money" />
    <img src="images/orangemoney.png" <?php RedImage("images/orangemoney.png",116,0); ?> />
    </div>
</div>
  <div class="control-group">
    <label class="control-label" for="montant">Montant à prélever sur le compte Orange Money <span class="rouge">*</span></label>
    <div class="controls" style="padding-top:25px;">
    <div class="input-append">
      <input type="text" id="montant" name="montant" class="input-small" placeholder="0" required onblur="cFrais();" onchange="cFrais();" onfocus="cFrais();" style="text-align:right">
      <span class="add-on">F CFA</span>
    </div>
    &nbsp;&nbsp;

<a href="#montant" id="aide3" class="btn btn-success" rel="popover"  data-html="true" data-content="Montant à préléver sur le compte Orange Money." data-original-title="Montant à préléver">?</a>
&nbsp;&nbsp;(Cliquer pour afficher/masquer l'aide)
    </div>
  </div>
  <div id="idfom" class="control-group">
    <label class="control-label" for="fraisp">Frais plateforme</label>
    <div class="controls">
    <div class="input-append">
      <input type="text" id="fraisp" name="fraisp" class="input-small" placeholder="0" readonly="readonly" disabled="disabled" style="text-align:right">
      <span class="add-on">F CFA</span>
    </div>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="frais">Frais de recharge sur carte VISA UBA Africard</label>
    <div class="controls" style="padding-top:25px;">
    <div class="input-append">
        <input type="text" id="frais" name="frais" class="input-small" placeholder="0" readonly="readonly" style="text-align:right">
      <span class="add-on">F CFA</span>
    </div>&nbsp;&nbsp;

<a href="#frais" id="aide1" class="btn btn-success" rel="popover"  data-html="true" data-content="Les montants liés au frais de rechargement seront arrondis au franc supérieur au cours du rechargement. Ex: 1233 f CFA sera 1235 f CFA.<br /><br />NB: les frais de recharge sont de 1 100 f CFA si le montant à recharger est inférieur ou égal à 55 000 f CFA et de 2% du montant à recharger au délà de 55 000 f CFA + 100 f CFA." data-original-title="Frais de recharge">?</a>
&nbsp;&nbsp;(Cliquer pour afficher/masquer l'aide)
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="mtr">Montant à recharger sur la carte prépayée VISA UBA Africard</label>
    <div class="controls" style="padding-top:25px;">
    <div class="input-append">
      <input type="text" id="mtr" name="mtr" class="input-small" placeholder="0" readonly="readonly" style="font-weight:bold; color:#F00; text-align:right">
      <span class="add-on">F CFA</span>
    </div><!--&nbsp;&nbsp;sur la carte prépayée VISA UBA Africard-->
    </div>
  </div>
<div class="control-group">
  <label class="control-label" for="cel">N° cellulaire <span class="rouge">*</span></label>
    <div class="controls"><a name="cell" id="cell"></a>
      <input type="text" id="cel" name="cel" class="input-small" placeholder="00000000" required>&nbsp;&nbsp;
      
<a href="#cell" id="aide2" class="btn btn-success" rel="popover" data-content="Veuillez indiquer le n° de celullaire du compte Orange Money à partir duquel vous faites l'opération." data-original-title="N° cellulaire">?</a>
&nbsp;&nbsp;(Cliquer pour afficher/masquer l'aide)      
    </div>
</div>

<!--<div class="control-group">
  <label class="control-label" for="ctransact">N° transaction <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="ctransact" name="ctransact" placeholder="N° transaction" required>
    </div>
</div>-->
  <div class="control-group">
    <div class="controls">
      <input name="idab" type="hidden" id="idab" value="<?php echo $row_rsAbonnement['idab']; ?>" />
      <button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('mpaie.php');"><i class="icon-chevron-left icon-white"></i> Précédent</button>
      <button type="submit" name="Submit" id="Submit" class="btn btn-primary"><i class="icon-check icon-white"></i> Soumettre</button>
    </div>
  </div>
</form>

                </div>
                                  
              </div>
              
            </div>
          </div>
        </div>
      </div>
    <!-- InstanceEndEditable -->
    </div>

    <div align="center">
     <?php require_once('../bin/reseaux.php'); ?> 
    </div>

    </div>
  <!--Fin Corps-->
<!--Début pieds de page-->
<div align="center" style="margin:40px 0 20px 0; clear:both;"><?php require_once('../bin/copyright.php'); ?></div>
<!--Fin pieds de page-->
</div>
</body>
<!-- InstanceEnd --></html>
