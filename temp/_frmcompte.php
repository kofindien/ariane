<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$civilite = isset($_SESSION['civilite']) ? $_SESSION['civilite'] : '';
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : '';
$prenoms = isset($_SESSION['prenoms']) ? $_SESSION['prenoms'] : '';
$cel = isset($_SESSION['cel']) ? $_SESSION['cel'] : '';
$numcard = isset($_SESSION['numcard']) ? $_SESSION['numcard'] : '';
$dvalidite = isset($_SESSION['dvalidite']) ? $_SESSION['dvalidite'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$alerte = isset($_SESSION['alerte']) ? $_SESSION['alerte'] : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Création de compte ::: Ariane</title>
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
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery.noConflict();
	jQuery(function($){
	   $("#numcard").mask("9999-9999-9999-9999");
	   $("#dvalidite").mask("99/99");
	   $("#cel").mask("99999999");
	});
</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
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
        <div style="padding:25px; border:1px solid #CCC; min-height:1040px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
          <div style="line-height:1.3em;">
            <div align="center" style="float:left; width:250px; padding-top:30px;">
              <ul id="news">
                <li><img src="images/car1.png" width="255" height="255" /></li>
                <li><img src="images/car2.png" width="255" height="255" /></li>
              </ul>
            </div>
            <div style="margin-left:260px;">
                
                <div class="titre" style="margin-bottom:20px; padding:10px 0;">Création de compte client</div>
				<div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>
                
              <div>
                
                <div style="padding-top:30px;">

<form action="finaliser.php" method="post" class="form-horizontal" id="frmCompte">
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le client :</strong></div>
<div class="control-group">
  <label class="control-label" for="civilite">Civilité <span class="rouge">*</span></label>
    <div class="controls">
        <label class="radio inline">
          <input type="radio" name="civilite" id="civilite1" value="Mlle" required="required" <?php if (!(strcmp($civilite, 'Mlle'))) { echo ' checked="checked"';} ?>> Mademoiselle
        </label>
        <label class="radio inline">
          <input type="radio" name="civilite" id="civilite2" value="Mme" required="required" <?php if (!(strcmp($civilite, 'Mme'))) { echo ' checked="checked"';} ?>> Madame
        </label>
        <label class="radio inline">
          <input type="radio" name="civilite" id="civilite3" value="Mr" required="required" <?php if (!(strcmp($civilite, 'Mr'))) { echo ' checked="checked"';} ?>> Monsieur
        </label>
    </div>
</div>
<div class="control-group">
  <label class="control-label" for="nom">Nom <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="nom" name="nom" placeholder="Nom" required="required" value="<?php echo $nom; ?>">
    </div>
</div>
  <div class="control-group">
    <label class="control-label" for="prenoms">Prénoms <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="prenoms" name="prenoms" class="input-xlarge" placeholder="Prénoms" required="required" value="<?php echo $prenoms; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="cel">Cellulaire <span class="rouge">*</span></label>
    <div class="controls">
    <div class="input-prepend">
      <span class="add-on">225</span>
      <input name="cel" type="text" required="required" class="input-small" id="cel" placeholder="00000000" value="<?php echo $cel; ?>" maxlength="8">
    </div>
    </div>
  </div>
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le service :</strong></div>
<script type="text/javascript">	
	function Serv(){
		if (document.getElementById('service').options[document.getElementById('service').selectedIndex].text!="Rechargements de cartes VISA UBA"){
			document.getElementById('idfom').style.display = "none";
			document.frmRecharge.fom.disabled=true;
		}
		else {
			document.getElementById('idfom').style.display = "block";
			document.frmRecharge.fom.disabled=false;
		}
	}
</script>
  <div class="control-group">
    <label class="control-label" for="service">Service</label>
    <div class="controls">
      <select name="service" class="input-xlarge" id="service" onchange="Serv();">
    	<option selected="selected"></option>
        <option value="1">Rechargements de cartes VISA UBA</option>
        <option value="Paiements par Internet" disabled="disabled">Paiements par Internet</option>
        <option value="Achats sur Internet" disabled="disabled">Achats sur Internet</option>
        <option value="Domiciliation de commandes" disabled="disabled">Domiciliation de commandes</option>
    </select>
    </div>
  </div>
  <div id="idfom" style="display:none;">
  <div class="control-group">
    <label class="control-label" for="numcard">Numéro de la carte <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="numcard" name="numcard" class="input-medium" placeholder="0000-0000-0000-0000" required="required" value="<?php echo $numcard; ?>" maxlength="4">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="dvalidite">Date de validité <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="dvalidite" name="dvalidite" class="span1" placeholder="00/00" required="required" value="<?php echo $dvalidite; ?>" maxlength="5">&nbsp;&nbsp;(mm/aa; ex. : 10/16)
    </div>
  </div>
</div>
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le compte :</strong></div>
  <div class="control-group">
    <label class="control-label" for="email">E-mail <span class="rouge">*</span></label>
    <div class="controls">
      <input type="email" id="email" name="email" class="input-xlarge" placeholder="nom@site.com" required="required" value="<?php echo $email; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="motpasse">Mot de passe <span class="rouge">*</span></label>
    <div class="controls"><span id="sprytextfield1">
      <input type="password" class="input-medium" name="motpasse" id="motpasse" placeholder="Mot de passe" required="required" />
      <span class="textfieldRequiredMsg">Une valeur est requise.</span></span></div>
  </div>
  <div class="control-group">
    <label class="control-label" for="motp">Confirmez-le ici <span class="rouge">*</span></label>
    <div class="controls"><span id="spryconfirm1">
      <input type="password" class="input-medium" name="motp" id="motp" placeholder="Mot de passe" required="required" />
      <span class="confirmRequiredMsg">Une valeur est requise.</span><span class="confirmInvalidMsg">Les valeurs ne correspondent pas.</span></span></div>
  </div>
  <div class="control-group">
    <div class="controls">

<!-- Notre image créée -->
      <img src="captcha.php" alt="Captcha" align="absmiddle" id="captcha" />

      <!-- (JavaScript) Changer d'image à la volée si elle est illisible  -->
      &nbsp; &nbsp; <a style="cursor:pointer" onclick="document.images.captcha.src='captcha.php?id='+Math.round(Math.random(0)*1000)+1"><img src="img/reload.png" title="Recharger l'image !" width="30" height="30" align="absmiddle" /></a>
      <p>
          <label for="userCode"><br>
            Entrez le code ci-dessus dans le champ de texte ci-dessous :<br /><br />insensible à la cAsSe <span class="rouge">*</span>
          </label>
          <input name="userCode" type="text" class="span1" id="userCode" maxlength="5" required="required" />
          <?php echo $alerte; ?>
          <input name="frmSend" type="hidden" id="frmSend" value="CreateAccount" />
      </p>
      <br />
      <button type="submit" class="btn btn-success"><i class="icon-check icon-white"></i> Soumettre</button>
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
