<?php require_once('Connections/liaisondb.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
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

$colname_rsProfil = "-1";
if (isset($_SESSION['ariane_user_id'])) {
  $colname_rsProfil = $_SESSION['ariane_user_id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsProfil = sprintf("SELECT clients.idcl, clients.civilite, clients.nom, clients.prenoms, clients.cel FROM clients WHERE clients.idcl = %s", GetSQLValueString($colname_rsProfil, "int"));
$rsProfil = mysql_query($query_rsProfil, $liaisondb) or die(mysql_error());
$row_rsProfil = mysql_fetch_assoc($rsProfil);
$totalRows_rsProfil = mysql_num_rows($rsProfil);

mysql_select_db($database_liaisondb, $liaisondb);
$query_rsCompagny = "SELECT * FROM compagnies WHERE compagnies.sup = 0 ORDER BY compagnies.compagnie";
$rsCompagny = mysql_query($query_rsCompagny, $liaisondb) or die(mysql_error());
$row_rsCompagny = mysql_fetch_assoc($rsCompagny);
$totalRows_rsCompagny = mysql_num_rows($rsCompagny);

$nvol_rsVol = "-1";
if (isset($_POST['vol'])) {
  $nvol_rsVol = $_POST['vol'];
}

function dateFR2dateEN($date){
	list($j,$m,$a) = explode('-',$date);
	return $a.'-'.$m.'-'.$j;
}

$dadte_rsVol = "-1";
if (isset($_POST['ddepart'])) {
  $dadte_rsVol = dateFR2dateEN($_POST['ddepart']);
}

 mysql_select_db($database_liaisondb, $liaisondb);
 $query_rsVol = sprintf("SELECT vols.idvol, numvols.numero, compagnies.compagnie, destinations.destination, pays.npays, departs.ddate, horaires.heure FROM vols, numvols, compagnies, destinations, pays, departs, horaires WHERE vols.idnv=numvols.idnv AND numvols.idcp=compagnies.idcp AND vols.iddest=destinations.iddest AND destinations.idpays=pays.idpays AND vols.iddpt=departs.iddpt AND vols.idh=horaires.idh AND numvols.idnv = %s AND departs.ddate = %s", GetSQLValueString($nvol_rsVol, "text"), GetSQLValueString($dadte_rsVol, "date"));
$rsVol = mysql_query($query_rsVol, $liaisondb) or die(mysql_error());
$row_rsVol = mysql_fetch_assoc($rsVol);
$totalRows_rsVol = mysql_num_rows($rsVol);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Souscrire au service d'Alertes voyages ::: Ariane</title>
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
<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css"/>
<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="highslide/highslide-full.js"></script>
<script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
        <div style="padding:25px; border:1px solid #CCC; min-height:650px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
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
                
                <div class="titre" style="margin-bottom:20px; padding:10px 0;">Espace client &raquo; Alertes voyages</div>
				<div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>

                <!--<div id="flash"></div>
                <div id="vide"></div>
                <div id="message"></div>
                <div id="retour" style="margin-top:15px;">
                <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour à l'espace client" onclick="window.location.replace('espaceclient.php');" />
                </div>-->
                
              <div>
                
                <div style="padding-top:30px;">
                 
<form action="ampaie.php" method="post" class="form-horizontal" id="Apply" name="Apply">
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le service :</strong></div>

<div class="control-group">
  <label class="control-label" for="lservice">Service</label>
    <div class="controls">
      <input name="lservice" type="text" readonly class="input-medium" id="lservice" value="Alertes voyages">
      <input name="ids" id="ids" type="hidden" value="3">
    </div>
</div>

  <div class="control-group">
    <label class="control-label" for="compagnie">Compagnie aérienne</label>
     <div class="controls">
      <input name="compagnie" type="text" readonly class="input-large" id="compagnie" value="<?php echo $row_rsVol['compagnie']; ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="vol">N° de vol</label>
     <div class="controls">
      <input name="vol" type="text" readonly class="input-small" id="vol" value="<?php echo $row_rsVol['numero']; ?>">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="destination">Destination</label>
    <div class="controls">
      <input name="destination" type="text" readonly class="input-xlarge" id="destination" value="<?php echo $row_rsVol['destination'], '  (', $row_rsVol['npays'], ')'; ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="ddepart">Date de départ</label>
     <div class="controls">
      <input name="ddepart" type="text" readonly class="input-small" id="ddepart" value="<?php 
	  function dEN2dFR($date){
		list($a,$m,$j) = explode('-',$date);
		return $j.'-'.$m.'-'.$a;
		}
	  echo dEN2dFR($row_rsVol['ddate']);
	   ?>">
    </div>
  </div>
  
<div class="alert alert-danger" style="margin-top:15px;">
Veuillez confirmer la date de départ de votre vol en saisissant la même date ci-dessus ou en entrant une nouvelle date.
</div>
  
  <div class="control-group warning">
    <label class="control-label" for="ndepart">Confirmer la date de départ <span class="rouge">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
    <div id="ndepart" class="input-append">
      <input type="text" id="ndepart" name="ndepart" class="input-small" placeholder="00-00-0000" required>
      <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
    </div>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($){
    $('#ndepart').datetimepicker({
		format: 'dd-MM-yyyy',
		pickTime: false
    });	
});
</script>
</div>

  <div class="control-group">
    <label class="control-label" for="hdepart">Heure de départ</label>
     <div class="controls">
      <input name="hdepart" type="text" class="input-small" id="hdepart" value="<?php echo $row_rsVol['heure']; ?>" readonly>
    </div>
  </div>
  
<div class="alert alert-danger" style="margin-top:15px;">
Veuillez confirmer l'heure de départ de votre vol en saisissant la même heure ci-dessus ou en entrant une nouvelle heure.
</div>
  
  <div class="control-group warning">
    <label class="control-label" for="nheure">Confirmer l'heure de départ <span class="rouge">*</span></label>
    
     <div class="controls">
     <span id="sprytextfield1">
     <input name="heure" type="text" required class="span1" id="heure" />
     </span>
     <span class="help-inline">H</span><span id="sprytextfield2">
     <input name="minute" type="text" required class="span1" id="minute" />
     </span>
     <span class="help-inline">MIN</span>
    </div>
  </div>
  
<div class="alert alert-danger" style="margin-top:15px;">
L'adress e-mail ci-dessous est celle de votre compte ARIANE. Par cette adresse sera utilisée pour vous envoyer les alertes par mail. Vous pouvez par ailleurs la modifier à votre convénance pour récevoir les alertes par mail.
</div>
  
  <div class="control-group warning">
    <label class="control-label" for="email">E-mail <span class="rouge">*</span></label>
     <div class="controls">
      <input name="email" type="email" class="input-xlarge" required id="email" value="<?php echo $_SESSION['ariane_user_login']; ?>">
    </div>
  </div>
  
  <br /><br />

  <div class="control-group">
    <div class="controls">
      <input name="frmSend" type="hidden" id="frmSend" value="Apply" />
      <input name="idvol" id="idvol" type="hidden" value="<?php echo $row_rsVol['idvol']; ?>" />
<button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('alerte.php');"><i class="icon-edit icon-white"></i> Modifier</button>
<button type="submit" id="Submit" name="Submit" class="btn btn-primary">Suivant &rarr;</button>
    </div>
</div>
</form>

                </div>
                                  
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minValue:0, maxValue:23});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {minValue:0, maxValue:59});
      </script>
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
<?php
mysql_free_result($rsProfil);

mysql_free_result($rsVol);
?>
