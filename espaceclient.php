<?php require_once('Connections/liaisondb.php'); ?>
<?php require_once('bin/fonctions.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
}

/*$MM_authorizedUsers = $_SESSION['oswagroups'];
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
if (!((isset($_SESSION['ariane_admin_login'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['ariane_admin_login'], $_SESSION['ariane_admin_idg'])))) { */  
  /*$MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);*/
 /* header("Location: ". $MM_restrictGoTo); 
  exit;
}*/
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
$query_rsService = sprintf("SELECT mprofil.idp FROM mprofil, abonnements WHERE mprofil.idab = abonnements.idab AND  mprofil.status = 1 AND abonnements.idcl = %s", GetSQLValueString($_SESSION['ariane_user_id'], "int"));
$rsService = mysql_query($query_rsService, $liaisondb) or die(mysql_error());
$row_rsService = mysql_fetch_assoc($rsService);
$totalRows_rsService = mysql_num_rows($rsService);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsServices = sprintf("SELECT * FROM abonnements WHERE abonnements.idcl = %s", GetSQLValueString($_SESSION['ariane_user_id'], "int"));
$rsServices = mysql_query($query_rsServices, $liaisondb) or die(mysql_error());
$row_rsServices = mysql_fetch_assoc($rsServices);
$totalRows_rsServices = mysql_num_rows($rsServices);

do { 
		$services[] = $row_rsServices['ids'];
} while ($row_rsServices = mysql_fetch_assoc($rsServices)); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Espace client ::: Ariane</title>
<!-- InstanceEndEditable -->
<link href="css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>

    <link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
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

    
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>

    <script type='text/javascript' src='js/jquery.mobile.customized.min.js'></script>
    <script type="text/javascript" src="js/jquery.easing.js"></script>
    <script type='text/javascript' src='js/camera.min.js'></script> 

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

<script type="text/javascript" src="js/jquery.innerfade.js"></script>
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
<!-- InstanceEndEditable -->

<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools.js"></script>
<script language="javascript" type="text/javascript" src="js/lofbreakingnews_mt1.2.js"></script>

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

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
<body>
<div style="min-height:250px; margin:10px 0 0 0; background:url(img/backpub.png) top center no-repeat fixed;">
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
      <form action="login.php" method="post" name="frmlogin" id="frmlogin" class="form-inline" style="background:#9CC130; padding:5px; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px;">
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
    <?php require_once('bin/menu.inc.php'); ?>
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
        <div style="padding:25px; border:1px solid #CCC; min-height:520px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
          <div style="line-height:1.3em;">
            <div align="center" style="float:left; width:250px; padding-top:30px;">
            
				<div align="left" style="margin-bottom:25px;">
                <div style="padding:8px 20px;"><img src="images/puce.gif" />&nbsp;&nbsp;&nbsp;
                <a href="profil.php" class="lien_bleu_">Modifier mon profil</a></div>
                <div style="padding:8px 20px;"><img src="images/puce.gif" />&nbsp;&nbsp;&nbsp;
                <a href="mpasse.php" class="lien_bleu_">Modifier mon mot de passe</a></div>
                <div style="padding:8px 20px;"><img src="images/puce.gif" />&nbsp;&nbsp;&nbsp;
                <a href="logout.php" class="lien_bleu_">Se déconnecter</a></div>
                </div>
                            
              <ul id="news">
                <li><img src="images/car1.png" width="255" height="255" /></li>
                <li><img src="images/car2.png" width="255" height="255" /></li>
              </ul>
            </div>
            <div style="margin-left:260px;">
                
                <div class="titre" style="margin-bottom:20px; padding:10px 0;">Espace client</div>
				<div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>
                
              <div>

<?php if ($services){ ?>
<div class="accordion" id="accordion2">
<?php if (in_array(1, $services)){ ?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        <strong>Carte prépayée VISA  Africard</strong> </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
<img src="images/ubavisa.png" class="pull-right">La carte prépayée VISA Africard est une carte de retrait rechargeable qui vous offre une multitude de possibilités et son coût est très abordable.<a class="btn btn-link" href="africard.php">En savoir plus <i class="icon-chevron-right"></i></a><br><br>
    <img src="images/puce.gif" /> <a class="btn btn-link" href="mpaie.php">Recharger ma carte à distance</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="cours.php">Opérations en cours</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="historic.php">Historique des opérations</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="upservafricard.php?serv=1">Modifier les informations sur le service</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="simulate.php">Simuler un rechargement</a>
      </div>
    </div>
  </div>
<?php } ?>
<!--<?php if (in_array(2, $services)){ ?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
        <strong>Emplois MON PROFIL</strong> </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
    <?php if ($totalRows_rsService > 0){ ?>
     <img src="images/puce.gif" /> <a class="btn btn-link" href="offres.php">Consulter les offres d'emplois</a><br />
    <?php } else { ?>
    <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    Impossible d'accéder aux offres d'emploi liées à votre profil pour l'une des raisons ci-dessous :<br />
	<ul>
    <li>Vous venez juste de souscrire au service et vous n'avez pas encore payer les frais liés au service Mon Profil. Veuillez régler lesdits frais en cliquant sur le lien " Régler / Renouveller mon abonnement au service " ci-dessous.</li>
    <li>Votre bail a expiré. Veuillez cliquer sur le lien " Régler / Renouveller mon abonnement au service " ci-dessous pour le renouveler.</li>
    </ul>
    </div>
     <img src="images/puce.gif" />&nbsp;&nbsp;&nbsp;Consulter les offres d'emplois<br />
	<?php } ?>
    <img src="images/puce.gif" /> <a class="btn btn-link" href="pmpaie.php?service=2">Régler / Renouveler mon abonnement au service</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="pcours.php">Opérations en cours</a>&nbsp;&nbsp;
    <img src="images/puce.gif" /> <a class="btn btn-link" href="phistoric.php">Historique des opérations</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="updservprofil.php?serv=2">Modifier les informations sur le service</a><br />
      </div>
    </div>
  </div>
<?php } ?>-->
<?php if (in_array(3, $services)){ ?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse3">
        <strong>Alerte Passagers AVION</strong> </a>
    </div>
    <div id="collapse3" class="accordion-body collapse">
      <div class="accordion-inner">
<img src="images/alertes.png" class="pull-right"><strong>Alerte Passagers AVION</strong> est un service de messagerie d'accompagnement personnalisé par SMS et par E-mail du passager pour la gestion de son programme de vol.<a class="btn btn-link" href="apa.php">En savoir plus <i class="icon-chevron-right"></i></a><br><br>
    <img src="images/puce.gif" /> <a class="btn btn-link" href="alerte.php">Soumettre une demande d'alerte voyages</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="acours.php">Opérations en cours</a><br />
    <img src="images/puce.gif" /> <a class="btn btn-link" href="ahistoric.php">Historique des opérations</a><br />
    Vous pouvez souscrire à plusieurs services additionnels !<a class="btn btn-link" href="htpp://travelstar.ci" target="_blank">En savoir plus <i class="icon-chevron-right"></i></a>
      </div>
    </div>
  </div>
<?php } ?>
</div>
<?php } ?>
<div>   
     <?php 
        if (count($services)==0){
			echo '<h6 style="margin-top:0">Vous n\'avez pas encore souscrit à un service...</h6>';
			echo '<p>
					Choisissez et cliquez sur chaque service pour lequel vous souhaitez vous abonner.
				  <ul>';
					if (!in_array(1, $services)) echo '<li><a href="servafricard.php">Carte prépayée VISA Africard</a></li>';
					if (!in_array(3, $services)) echo '<li><a href="servalertevoyage.php">Alertes voyages</a></li>';
			echo '</ul>
			   </p>';
		}
        else {
			if (!in_array(1, $services) && !in_array(3, $services)){
				echo '<h6 style="margin-top:0">Vous pouvez souscrire à plusieurs services additionnels !</h6>';
				echo '<p>Choisissez et cliquez sur chaque service pour lequel vous souhaitez vous abonner.<ul>';
				echo '<li><a href="servafricard.php">Carte prépayée VISA Africard</a></li>';
				echo '<li><a href="servalertevoyage.php">Alerte voyages</a></li>';
			}
			if (!in_array(1, $services) && in_array(3, $services)){
				echo '<h6 style="margin-top:0">Vous pouvez souscrire à plusieurs services additionnels !</h6>';
				echo '<p>Choisissez et cliquez sur chaque service pour lequel vous souhaitez vous abonner.<ul>';
				echo '<li><a href="servafricard.php">Carte prépayée VISA Africard</a></li>';
			}
			if (in_array(1, $services) && !in_array(3, $services)){
				echo '<h6 style="margin-top:0">Vous pouvez souscrire à plusieurs services additionnels !</h6>';
				echo '<p>Choisissez et cliquez sur chaque service pour lequel vous souhaitez vous abonner.<ul>';
				echo '<li><a href="servalertevoyage.php">Alerte voyages</a></li>';
			}
			echo '</ul>
			   </p>';
		}
     ?>
    
</div>
                                        
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- InstanceEndEditable -->
    </div>

    <div align="center">
     <?php require_once('bin/reseaux.php'); ?> 
    </div>

    </div>
  <!--Fin Corps-->
<!--Début pieds de page-->
<div align="center" style="margin:40px 0 20px 0; clear:both;"><?php require_once('bin/copyright.php'); ?></div>
<!--Fin pieds de page-->
</div>
</body>
<!-- InstanceEnd --></html>
