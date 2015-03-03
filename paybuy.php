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
<title>Achats &amp; Paiements &raquo; Procédure de paiement ::: ESN ARIANE</title>
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
                
                <div class="filariane" style="margin-bottom:20px; padding:10px 0;">Accueil / Achats & Paiements par Internet / Achats en ligne / Procédure de paiement</div>
				<div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>
              <img src="img/paybuy.jpg" /><br /><br />
              Vous pouvez utiliser la carte bancaire prépayée dénommée carte prépayée <strong>VISA  Africard</strong> pour payer vos achats ou effectuer des paiements sur Internet.<br><br>
Mais avant de la faire, il faut bien sûr vérifier que le site de e-commerce sur lequel vous voulez effectuer des achats est équipé d'un système de paiement sécurisé. Ce système consiste en un mode de cryptage des données personnelles (nom, adresse, coordonnées bancaires) qui les rend invisibles et inatteignables afin qu'elles ne puissent pas être récupérées par des personnes mal intentionnées.<br><br>
Une fois que vous avez la certitude que le site est correctement sécurisé, vous pouvez procéder au paiement de l'article ou du service que vous avez choisi en suivant les étapes ci-après :
                      <br><br>
                
              <div style="min-height:250px;">
              
                <div class="accordion" id="accordion2">
                
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse1">
                      <strong>Etape 1 : Achetez une carte prépayée VISA  Africard</strong> </a>
                    </div>
                    <div id="collapse1" class="accordion-body collapse in">
                      <div class="accordion-inner">
Achetez votre carte prépayée <strong>VISA  Africard</strong> au prix de 10 000 FCFA dans une agence UBA, auprès de revendeurs agréés de cartes UBA ou à un guichet de l'<strong>Espace de Services Numériques ARIANE</strong>. Nous vous recommandons très fortement d'acheter votre carte aux guichets de l'ESN ARIANE qui vous offre, en plus, une procédure de <u>rechargement à distance de votre carte VISA  Africard</u>, pratiquement partout en Côte d'Ivoire et même de l'étranger.<br><br>
<u>ATTENTION</u> : La procédure d'achat requiert de remplir le formulaire qui vous sera remis pour souscrire au service <strong>VISA  Africard</strong> et de joindre la photocopie de votre pièce d'identité. Une fois votre souscription validée, vous recevrez une enveloppe vous donnant des informations sur la carte et la manière de l'utiliser. L'enveloppe vous donne également des instructions sur votre secret et comment assurer sa confidentialité.<br><br>
Si vous disposez déjà d'une carte prépayée <strong>VISA  Africard</strong>, et assez d'argent sur cette carte pour payer le prix de l'article ou du service que vous avez choisi, ainsi que les frais associés à votre achat, allez directement à L'Etape 3 ci-dessous.
                      </div>
                    </div>
                  </div>
                  
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2">
                      <strong>Etape 2 : Chargez votre carte prépayée VISA  Africard</strong> </a>
                    </div>
                    <div id="collapse2" class="accordion-body collapse">
                      <div class="accordion-inner">
Procédez au chargement (ou au rechargement) de votre carte du montant du prix de l'article ou du service que vous souhaitez acheter sur Internet, augmenté des frais liés à l'achat que vous voulez effectuer (par exemple les commissions dues au site marchand du vendeur, frais de transport ou de dédouanement).<br><br>
Si vous ne vous trouvez pas dans une agence ARIANE, vous pouvez recharger votre carte prépayée <strong>VISA  Africard</strong> en ligne par transfert d'argent par téléphone mobile sur l'un des numéros suivants  (<a href="recharges.php">voir lien de rechargement en ligne</a>) : <br /><br />
                        <ul>
                            <li class="text-info">Orange Money : (225) 773 00 163</li>
                            <li class="text-info">FLOOZ : (225) 039 54 291</li>
                        </ul>
                      </div>
                    </div>
                  </div>

<div style="margin:15px 0;">
A la suite de l'opération de chargement ou de rechargement de votre carte prépayée VISA UBA Africard, une alerte SMS vous sera adressée au numéro de téléphone cellulaire que vous avez indiqué lors de l'achat de cette carte. L'alerte SMS vous indiquera le montant de la somme déposée sur votre carte ainsi que le solde disponible.
</div>

                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse3">
                      <strong>Etape 3 : Sélectionnez l'article ou le service que vous voulez acheter</strong> </a>
                    </div>
                    <div id="collapse3" class="accordion-body collapse">
                      <div class="accordion-inner">
Allez sur le site Internet sur lequel vous avez trouvé l'article ou  le service que vous avez choisi et sélectionnez cet article ou ce service en suivant la procédure de sélection des achats décrite sur ce site.
                      </div>
                    </div>
                  </div>
                
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse4">
                      <strong>Etape 4 : Payez l'article ou le service sélectionné avec votre carte prépayée</strong> </a>
                    </div>
                    <div id="collapse4" class="accordion-body collapse">
                      <div class="accordion-inner">
Effectuez le paiement des produits sélectionnés par carte bancaire avec votre carte prépayée <strong>VISA  Africard</strong> en remplissant correctement le formulaire de paiement qui apparaîtra sur votre écran. Inscrivez toutes les informations demandées, notamment, le numéro de votre carte prépayée <strong>VISA  Africard</strong>, la date de validité de ladite carte  et parfois le nom et le prénom figurant sur la carte. Ces informations sont nécessaires pour enregistrer et valider votre achat.
                      </div>
                    </div>
                  </div>
                  
<div style="margin:15px 0;">
A la fin de l'opération de paiement, une alerte SMS vous sera adressée sur le numéro du téléphone cellulaire que vous avez indiqué lors de l'achat de votre carte prépayée <strong>VISA  Africard</strong>. Ce SMS indiquera le montant débité de  votre carte, le solde disponible, la référence de l'article ou du service payé et l'identité du marchand auprès duquel vous avez acheté l'article ou le service.<br /><br />
<p class="text-warning"><strong>ATTENTION : Veillez à ne pas perdre ce SMS. Il peut vous être utile en cas de réclamation !</strong></p>
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
