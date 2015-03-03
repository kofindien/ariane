<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Show me the way ::: ARIANE</title>
<link href="css/bootstrap-responsive.css" rel="stylesheet" media="screen">
<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="css/hosting.css" rel="stylesheet" media="all">
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
<script language="JavaScript1.2">
var howOften = 6; //number often in seconds to rotate
var current = 0; //start the counter at 0
var ns6 = document.getElementById&&!document.all; //detect netscape 6

// place your images, text, etc in the array elements here
var items = new Array();
    items[0]="<a href='http://www.navetteplus.ci' target='_blank'><img alt='www.navetteplus.ci' src='img/pubnavette.gif' border='0' height='200' width='950' /></a>"; 
    items[1]="<a href='http://www.jobassist.ci' target='_blank'><img alt='www.jobassist.ci' src='img/pubmprofil.gif' border='0' height='200' width='950' /></a>"; //a linked image
function rotater() {
    document.getElementById("placeholder").innerHTML = items[current];
    current = (current==items.length-1) ? 0 : current + 1;
    setTimeout("rotater()",howOften*1000);
}

function rotater() {
    if(document.layers) {
        document.placeholderlayer.document.write(items[current]);
        document.placeholderlayer.document.close();
    }
    if(ns6)document.getElementById("placeholderdiv").innerHTML=items[current]
        if(document.all)
            placeholderdiv.innerHTML=items[current];

    current = (current==items.length-1) ? 0 : current + 1; //increment or reset
    setTimeout("rotater()",howOften*1000);
}
window.onload=rotater;
//-->
</script>
    
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
        <div style="padding:25px; border:1px solid #CCC; min-height:300px; background:#F9F9F9; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px; padding-bottom:50px;">
          <div style="line-height:1.1em;">
<div align="center" class="titre" style="padding-bottom:25px; line-height:1.3em; background:url(img/_separe.png) center bottom no-repeat;">Bienvenue sur l'Espace de Services Numériques<br />
<span style="color:#1A8500; padding-top:25px;">ARIANE " Show me the way "</span>
</div>

<!--<div align="center" style="float:right; width:250px; margin-bottom:15px;">
  <ul id="news">
    <li><img src="images/car1.png" width="255" height="255" /></li>
    <li><img src="images/car2.png" width="255" height="255" /></li>
  </ul>
</div>
-->
<div>

<div style="margin:10px 0;">
Les nouvelles technologies deviennent incontournables dans notre quotidien. Elles font tout, partout. Mais le plus important, c'est qu'elles peuvent nous permettre d'économiser beaucoup d'argent et nous rendre la vie beaucoup plus facile dans tous les domaines.<br /><br />
<strong><em>Voici nos offres de services</em></strong> :<br /><br />
</div>

</div>

<div>
                              
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr align="center" valign="top">
    <td width="20%">
    	<div style="margin-right:10px;">
        <div style="border-top:3px solid #06C; border-bottom:1px solid #06C; font-weight:bold; padding:20px 15px; background-color:#FFF; height:40px;">
          <div style="font-size:12px; padding-bottom:8px;">INTERNET</div>
          <div>Achats & Paiements<br />en ligne</div>
        </div>
        <div style="padding:20px 15px; background-color:#FFF;">
          <img src="img/servinternet.jpg" />
        </div>
        <div style="padding:20px 15px; background-color:#FFF; border-top:1px solid #000; height:40px;">
          <div>Plus facile, plus simple et sécurisé</div>
        </div>
        <div style="border-top:1px solid #666; margin:0 25%;"></div>
        <div style="padding:20px 15px; background-color:#FFF; height:40px;">
          <div>Concrétisez vos opportunités</div>
        </div>
        <div style="background-color:#FFF;">
            <a href="paybuy.php" class="btn btn-success btn-small">En SAVOIR +</a>
        </div>
        </div>
    </td>
    <td width="20%">
    	<div style="margin:0 5px;">
        <div style="border-top:3px solid #06C; border-bottom:1px solid #06C; font-weight:bold; padding:20px 15px; background-color:#FFF; height:40px;">
          <div style="font-size:12px; padding-bottom:8px;">DOMICILIATION</div>
          <div>de  commandes sur Internet</div>
        </div>
        <div style="padding:20px 15px; background-color:#FFF;">
          <img src="img/domiciliation.jpg" />
        </div>
        <div style="padding:20px 15px; background-color:#FFF; border-top:1px solid #000; height:40px;">
          <div>Achetez en toute sérénité sur le net</div>
        </div>
        <div style="border-top:1px solid #666; margin:0 25%;"></div>
        <div style="padding:20px 15px; background-color:#FFF; height:40px;">
          <div>Achetez librement... Développez votre commerce</div>
        </div>
        <div style="background-color:#FFF;">
            <a href="domiciliation.php" class="btn btn-success btn-small">En SAVOIR +</a>
        </div>
        </div>
    </td>
    <td width="20%">
    	<div style="margin:0 5px;">
        <div style="border-top:3px solid #06C; border-bottom:1px solid #06C; font-weight:bold; padding:20px 15px; background-color:#FFF; height:40px;">
          <div style="font-size:12px; padding-bottom:8px;">Cartes Prépayées</div>
          <div>VISA Africard</div>
        </div>
        <div style="padding:20px 15px; background-color:#FFF;">
          <img src="img/servafricard.jpg" />
        </div>
        <div style="padding:20px 15px; background-color:#FFF; border-top:1px solid #000; height:40px;">
          <div>Voyagez partout dans le monde avec VISA Africard</div>
        </div>
        <div style="border-top:1px solid #666; margin:0 25%;"></div>
        <div style="padding:20px 15px; background-color:#FFF; height:40px;">
          <div>Rechargez votre carte à partir de 10.000 points de ventes</div>
        </div>
        <div style="background-color:#FFF;">
            <a href="africard.php" class="btn btn-success btn-small">En SAVOIR +</a>
        </div>
        </div>
    </td>
    <td width="20%">
    	<div style="margin:0 5px;">
        <div style="border-top:3px solid #06C; border-bottom:1px solid #06C; font-weight:bold; padding:20px 15px; background-color:#FFF; height:40px;">
          <div style="font-size:12px; padding-bottom:8px;">Alertes Passagers</div>
          <div>AVION</div>
        </div>
        <div style="padding:20px 15px; background-color:#FFF;">
          <img src="img/alertvoyage.jpg" />
        </div>
        <div style="padding:20px 15px; background-color:#FFF; border-top:1px solid #000; height:40px;">
          <div>TRAVEL STAR vous accompagne ! Voyagez en toute sérénité</div>
        </div>
        <div style="border-top:1px solid #666; margin:0 25%;"></div>
        <div style="padding:20px 15px; background-color:#FFF; height:40px;">
          <div>Service pour passagers avion et agences de voyages</div>
        </div>
        <div style="background-color:#FFF;">
            <a href="apa.php" class="btn btn-success btn-small">En SAVOIR +</a>
        </div>
        </div>
    </td>
    <td width="20%">
    	<div style="margin-left:10px;">
        <div style="border-top:3px solid #06C; border-bottom:1px solid #06C; font-weight:bold; padding:20px 15px; background-color:#FFF; height:40px;">
          <div style="font-size:12px; padding-bottom:8px;">Emplois</div>
          <div>MON PROFIL</div>
        </div>
        <div style="padding:20px 15px; background-color:#FFF;">
          <img src="img/emplois.jpg" />
        </div>
        <div style="padding:20px 15px; background-color:#FFF; border-top:1px solid #000; height:40px;">
          <div>Recevez tous les jours des offres correspondant à votre profil</div>
        </div>
        <div style="border-top:1px solid #666; margin:0 25%;"></div>
        <div style="padding:20px 15px; background-color:#FFF; height:40px;">
          <div>Cherchez un emploi plus efficacement</div>
        </div>
        <div style="background-color:#FFF;">
            <a href="http://www.jobassist.ci" class="btn btn-success btn-small" target="_blank">En SAVOIR +</a>  
        </div>
        </div>
    </td>
  </tr>
</table>
</div>                  

<div align="center" style="clear:both; margin-top:15px; padding-top:20px; background:url(img/_separe.png) center top no-repeat; font-size:14px;">
  <layer id="placeholderlayer"></layer><div id="placeholderdiv" style="height:200px;"></div>
   <br />
  <br />
  Une gamme de services toujours plus faciles à utiliser, plus simples et innovants.<br /><br />
Souscrivez dès aujourd'hui même au service de votre choix. <strong style="color:#F00;">Vivez tranquille !</strong><br /><br />
Faites votre choix. Nous sommes en soutien.</div>

</div>
            <!--</div>-->
            
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
