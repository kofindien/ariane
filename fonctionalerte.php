<?php
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
<title>Travel*Star - Comment ça marche  ::: Ariane</title>
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
        <div style="padding:25px; border:1px solid #CCC; min-height:270px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px; padding-bottom:100px;">
          <div style="line-height:1.3em;">
            <div align="center" style="float:left; width:250px; padding-top:30px;">
              <ul id="news">
                <li><img src="images/car1.png" width="255" height="255" /></li>
                <li><img src="images/car2.png" width="255" height="255" /></li>
              </ul>
            </div>
            <div style="margin-left:260px;">
                
                <div class="titre" style="margin-bottom:20px; padding:10px 0;">Travel*Star &raquo; Comment ça marche</div>
 				<div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>
               
              <div style="min-height:250px;">
              
                <div class="accordion" id="accordion2">
                
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse1">
                      <strong>Etape 1 : Allez sur le site d'ARIANE et créez votre compte ARIANE</strong> </a>
                    </div>
                    <div id="collapse1" class="accordion-body collapse in">
                      <div class="accordion-inner">
                      Une fois sur le site d'ARIANE (<a href="http://www.ariane.ci">www.ariane.ci</a>), créez un compte à votre nom en prenant soin de remplir correctement le formulaire d'inscription. Ce sera votre Compte ARIANE. </div>
                    </div>
                  </div>
                  
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2">
                      <strong>Etape 2 : Se connecter à son compte ARIANE et souscrire au service ALERTES VOYAGES</strong> </a>
                    </div>
                    <div id="collapse2" class="accordion-body collapse">
                      <div class="accordion-inner">
                        Une fois votre compte ARIANE créé, veuillez vous connecter et souscrire au service ALERTES VOYAGES.
                      </div>
                    </div>
                  </div>
                  
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse3">
                      <strong>Etape 3 : Soumettez une demande d'alertes voyages</strong> </a>
                    </div>
                    <div id="collapse3" class="accordion-body collapse">
                      <div class="accordion-inner">
                          <ul>
                            <li>Cliquez ensuite sur « Soumettre une demande d'alertes voyages » et renseignez le formulaire</li>
                            <li>Sélectionnez le moyen de paiements (ORANGE Money, FLOOZ ou PAYPAL) et suivez les instructions.</li>
                          </ul>
                      </div>
                    </div>
                  </div>
                
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse4">
                      <strong>Etape 4 : Avoir la somme destinée à régler les frais du service sur votre compte ORANGE Money, FLOOZ ou PAYPAL</strong> </a>
                    </div>
                    <div id="collapse4" class="accordion-body collapse">
                      <div class="accordion-inner">
                          <ul>
                            <li>Avoir sur votre compte ORANGE Money, FLOOZ ou PAYPAL la somme destinée à régler les frais du service.</li>
                            <li>Si vous ne disposez pas d'assez d'argent sur votre compte de téléphonie mobile, rendez vous d'abord à un point de transfert d'argent de votre opérateur de téléphonie mobile et procédez au chargement sur ce compte de la somme que vous voulez utiliser. Faites la même chose, le cas échéant, pour votre compte  PAYPAL.</li>
                          </ul>
                      </div>
                    </div>
                  </div>

                    <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse5">
                      <strong>Etape 5 : Soumettez le formulaire dûment rempli</strong> </a>
                    </div>
                    <div id="collapse5" class="accordion-body collapse">
                      <div class="accordion-inner">
                          <ul>
                            <li>Effectuez ensuite le paiement du montant de la souscription via votre compte ORANGE Money,  FLOOZ ou PAYPAL.</li>
                          </ul>                         
								<u>Procédure Via ORANGE Money</u><br /><br />
                          <ul>
                            <li>Après soumission de votre demande de paiement, vous recevrez un SMS sur votre mobile vous invitant à composer le <strong>#120#</strong> et à suivre les instructions pour valider l'opération.</li>
                            <li>Vous recevrez ensuite un SMS de confirmation de votre achat avec tous les détails de l'opération ainsi que votre nouveau solde.</li>
                            <li>Après la confirmation du règlement des frais de service, vous recevrez un mail vous indiquant l'activation de votre service.</li>
                          </ul>
								<u>Procédure Via FLOOZ</u><br /><br />
                          <ul>
                            <li>Avant soumission de votre demande de paiement, veuillez transférer le montant à prélever pour règlement des frais de service au n° FLOOZ <strong>(225) 039 54 291</strong> ou à <strong>ARIANE</strong> en tapant sur votre téléphone <strong>*155*4#</strong> et suivez les instructions.</li>
                            <li>Vous recevrez un SMS de confirmation du transfert contenant le numéro de transaction de l'opération ainsi que votre nouveau solde.</li>
                            <li>Insérez dans le champ le numéro de transaction (Ref: xxxxxxxxxxxxx) puis soumettez la demande.</li>
                            <li>Après la confirmation du règlement des frais de service, vous recevrez un mail vous indiquant l'activation de votre service.</li>
                          </ul>
                      </div>
                    </div>
                  </div>                  

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
