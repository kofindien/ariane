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
<title>Domiciliation de commandes - Présentation ::: ESN ARIANE</title>
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
                <div class="filariane" style="margin-bottom:20px; padding:10px 0;">Domiciliation de commandes / Vous voulez vous faire livrer chez vous un produit commandé sur Internet ?</div>
                <div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>
                <img src="img/domlivraison.jpg" /><br /><br />
                <img src="img/dom_accroche1.gif" />
                <br />

                <span class="titre">Importance de la capacité de livraison à domicile dans le commerce en ligne</span><br /><br />
                <strong><span class="text-error">Pour les entreprises</span></strong><br /><br />
                Il existe un nombre inimaginable de sites marchands vendant, à travers Internet, un nombre tout aussi inimaginable de biens et de services à travers le monde. Toutefois, les biens et services vendus par ces sites sont destinés essentiellement aux marchés de leurs pays d'origine, pour lesquels ils offrent des services de livraison des produits vendus rapides et efficaces. Certains de ces sites visent accessoirement quelques pays étrangers, notamment qui offrent localement des services de livraison indépendants de bonne qualité. De tels services n'existent pas en Afrique. Les Internautes de ce continent se retrouvent donc souvent obligés de se livrer à des arrangements pas toujours faciles à mettre en œuvre et très coûteux pour se faire livrer des produits achetés sur Internet.<br /><br />
                Progressivement, un certain nombre d'entreprises africaines s'organisent pour servir d'agents domiciliataires de commandes sur Internet achetés à l'Etranger, notamment en Europe, en Amérique du Nord et en Chine. C'est le cas de l'ESPACE DE SERVICES NUMERIQUES ARIANE (ESN ARIANE), un service spécialisé de la société ivoirienne AMARAS, qui comprend au nombre des services qu'elle offre un service de Domiciliation de commandes sur Internet. Ce service est destiné aux personnes physiques ou morales, les entreprises notamment, qui cherchent une solution de livraison rapide de produits qu'ils ne trouvent pas facilement sur le marché ivoirien ou qui sont vendus à des prix qu'ils jugent inacceptables.<br /><br />
                Vous ne le savez sans doute pas, mais de nombreuses entreprises qui sont autour de vous (notamment les concessionnaires auto, les garagistes, les revendeurs de machines et d'équipements) utilisent tous les jours Internet pour acheter des pièces non disponible en stock pour leurs clients ou effectuer des réparations sur leurs véhicules ou sur leurs machines. Les pièces non disponibles sont achetées à l'étranger par le concessionnaire, au travers d'un canal commercial permettant la livraison jusqu'à chez lui en Côte d'Ivoire des produits achetés.

                <br /><br />
                <img src="img/dom_accroche2.gif" />
                <br /><br />

                Ainsi l'accès à l'immense marché de l'Internet, couplé avec une capacité de livraison efficace se traduit par des avantages commerciaux majeurs pour les entreprises ou les personnes qui en bénéficient :<br /><br />
                <ul>
                    <li>Il n'est plus nécessaire pour ces entreprises de maintenir un stock important et coûteux de pièces ou de marchandises avec l'incertitude de ne pas pouvoir les écouler totalement et d'avoir, en fin de compte, un important stock mort</li><br />
                    <li>Ces entreprises peuvent offrir une gamme beaucoup plus large de produits à leur clientèle, en raison du fait qu'elles s'approvisionnent auprès d'un nombre plus important et plus variés de fournisseurs, notamment en procédant à des comparaisons de prix</li><br />
                    <li>Elles augmentent et diversifient en même temps leur clientèle, étant devenue à même, du fait d'Internet, de toucher une catégorie de clients qui auparavant ne leur était pas accessible</li><br />
                    <li>Elles réduisent leurs coûts opérationnels et augmentent leurs marges commerciales tout en disposant d'une capacité de réduction des prix de vente de leurs produits et services qui les rendent beaucoup plus compétitives.</li>
                </ul>
                Ainsi, l'accès aux énormes possibilités commerciales d'Internet complété par la capacité de se faire livrer à domicile permet à de nombreuses entreprises, notamment les concessionnaires automobiles, les vendeurs de machines et d'équipement, d'effectuer des commandes de pièces de rechange pour les véhicules, les machines et équipements à l'Etranger pour servir les besoins de leurs clients.<br /><br />
                S'il est d'accord, le client paie une avance sur le prix indicatif du produit que lui déclare son fournisseur. Celui-ci passe la commande par Internet auprès d'un fournisseur international qu'il a pu choisir compte tenu des caractéristiques du produit, de son coût et des délais de sa livraison à Abidjan, par exemple. Une société spécialisée de transport de produits achetés sur Internet se charge alors de livrer le produit jusqu'à l'adresse indiquée par le fournisseur ivoirien. Celui-ci retire le produit, acquitte les frais de transport et de douane et fixe le prix final du produit livré à Abidjan. Le client solde le prix du produit (déduction étant faite de l'avance qu'il a payée à la commande) et prend possession du produit.<br /><br />
                Les gains pour l'entreprise qui achètent sur Internet sont encore plus importants si celle-ci bénéficie des coûts de transports très faibles qu'obtient le site marchand auprès duquel elle s'approvisionne. Ces gains peuvent avantageusement être répercutés par l'entreprise aux clients pour les fidéliser et être plus compétitifs que ses concurrentes.
                C'est pour toutes ces raisons que le commerce en ligne se développe de manière vertigineuse dans tous les pays où il a pris pied.

                <br /><br />
                <img src="img/dom_accroche3.gif" />
                <br /><br />

                <strong><span class="text-error">Pour les individus</span></strong><br /><br />
                Des millions d'Africains se retrouvent exclus des énormes avantages du commerce sur Internet en raison de la difficulté, voire de l'impossibilité, de se faire livrer dans leurs pays respectifs les produits vendus sur Internet. Ils sont frustrés, parfois même désespérés. Cependant, tout n'est pas perdu, car aujourd'hui, ils peuvent bénéficier, tout comme les entreprises évoquées ci-dessus, bénéficier de la possibilité de voir leurs commandes de produits achetés sur Internet livrés à Abidjan ou à l'intérieur de la Côte d'Ivoire, grâce au service Domiciliation de commande sur Internet d'ESN ARIANE. Ce service est décrit ci-après.
                <br /><br />
                Vous aussi, bénéficiez des avantages des achats sur Internet couplés à la livraison à domicile, notamment la possibilité :
                <ul>
                    <li>d'acheter moins cher et d'avoir un plus grand choix en matière de sélection de produits</li>
                    <li>de trouver des objets ou produits non disponibles sur le marché local</li>
                    <li>de renouveler des produits ou matériels dépassés</li>
                    <li>d’avoir accès sans entrave aux nouvelles technologies et aux performances améliorées qu’elles apportent</li>
                    <li>de profiter de services après-vente de qualité et de conseils appropriés pour utiliser les produits que vous achetez.</li>
                </ul>
                <br />
                <img src="img/dom_accroche4.gif" />
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
