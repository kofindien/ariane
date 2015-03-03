<?php require_once('Connections/liaisondb.php'); ?>
<?php require_once('bin/fonctions.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
}

$loginFormAction = "login.php";
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = "login.php";
}

if (isset($_POST['requetelogin']) && $_POST['requetelogin']=="frmLogin") {
  $salt1 = "qm&h*";	$salt2 = "p#g!@";
  $loginUsername=$_POST['email'];
  $password = md5($salt2.md5($salt1.$_POST['motpasse'].$salt2).$salt1);
  $MM_redirectLoginSuccess = "espaceclient.php";
  $MM_redirectLoginFailed = "login.php?acces=error";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_liaisondb, $liaisondb);
  	
  $LoginRS__query=sprintf("SELECT clients.idcl, clients.nom, clients.prenoms FROM clients WHERE clients.email=%s AND clients.motpasse=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
   
  $LoginRS = mysql_query($LoginRS__query, $liaisondb) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup = "";
    $ariane_user_id = mysql_result($LoginRS,0,'idcl');
    $ariane_user_nom = mysql_result($LoginRS,0,'nom');
    $ariane_user_prenoms = mysql_result($LoginRS,0,'prenoms');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
			
    //declare two session variables and assign them
    $_SESSION['ariane_user_id'] = $ariane_user_id;
    $_SESSION['ariane_user_login'] = $loginUsername;
    $_SESSION['ariane_user_identite'] = $ariane_user_nom . ' ' . $ariane_user_prenoms;
    $_SESSION['ariane_user_Group'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    
	header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

// *** Redirect if username exists
if (isset($_POST['requetelost']) && $_POST['requetelost']=="frmLoginProblem") {
  $_MM_dupKeyRedirect="login.php";
  $email = $_POST['_email'];
  $Login_RS__query = sprintf("SELECT * FROM clients WHERE clients.email=%s", GetSQLValueString($email, "text"));
  mysql_select_db($database_liaisondb, $liaisondb);
  $_LoginRS=mysql_query($Login_RS__query, $liaisondb) or die(mysql_error());
  $_loginFoundUser = mysql_num_rows($_LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($_loginFoundUser){
	    $newpass = GenerePassword(10);
		$salt1 = "qm&h*";	$salt2 = "p#g!@";
		$_newpass = md5($salt2.md5($salt1.$newpass.$salt2).$salt1);
		
		$ariane_user_prenoms = mysql_result($_LoginRS,0,'prenoms');
		$ariane_user_nom = mysql_result($_LoginRS,0,'nom');
		$identite = $ariane_user_nom .' '. $ariane_user_prenoms;
$message = "
<pre>
Bonjour <strong>$identite</strong>,

Ci-dessous vos paramètres de connexion :

Login : $email
Nouveau mot de passe : $newpass

---------------------------------------------
Ceci est un mail automatique, merci de ne pas y répondre.
</pre>";
		
		$updateSQL = sprintf("UPDATE clients SET clients.motpasse=%s WHERE clients.email=%s",
							   GetSQLValueString($_newpass, "text"),
							   GetSQLValueString($email, "text"));
		
		mysql_select_db($database_liaisondb, $liaisondb);
		$Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());
		
		$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
		$headers .= "Content-Type: text/html; charset=utf-8\n";
		$headers .= "X-Mailer: PHP\n";
		$headers .= "X-Priority:1\n";
		$headers .= "Reply-To: no-reply@ariane.ci\n";
		$headers .= "From: no-reply@ariane.ci\n";
		$headers .= "Return-Path: no-reply@ariane.ci";
		$objet = "[ ESN ARIANE ] - Mot de passe oublié !!!";
		mail($email, $objet, $message, $headers);
	  
    $_MM_dupKeyRedirect = $_MM_dupKeyRedirect . "?action=recovery&request=succes";
    header ("Location: $_MM_dupKeyRedirect");
  }
  else {
    $_MM_dupKeyRedirect = $_MM_dupKeyRedirect . "?action=recovery&request=echec";
    header ("Location: $_MM_dupKeyRedirect");
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Authentification ::: Ariane</title>
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
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
	jQuery.noConflict();
	jQuery(function($){
	   $("#code").mask("9999");
	   $("#cel1").mask("99999999");
	});
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
        <div style="padding:25px; border:1px solid #CCC; min-height:350px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
          <div style="line-height:1.3em;">
            <div align="center" style="float:left; width:250px; padding-top:30px;">
              <ul id="news">
                <li><img src="images/car1.png" width="255" height="255" /></li>
                <li><img src="images/car2.png" width="255" height="255" /></li>
              </ul>
            </div>
            <div style="margin-left:260px;">
                
                <div class="titre" style="margin-bottom:20px; padding:10px 0;">Authentification</div>
				<div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>
                
              <div>
                
                <div>

<?php if (isset($_GET['action']) && $_GET['action']=='recovery'){ ?>
<form id="frmLoginProblem" name="frmLoginProblem" method="post" action="<?php echo $loginFormAction; ?>" class="form-horizontal">
      <?php if (isset($_GET['request']) && $_GET['request']=='succes'){ ?>
      <div style="padding:15px 25px; opacity:0.70; background:#093; width:75%; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px; font-size:12px; color:#FFF; margin:10px 0;">
      <strong>Félicitations !!!</strong><br /><br />Un nouveau mot de passe a été posté à l'adresse e-mail que vous avez fourni. Veuillez consulter votre messagerie afin de vous connecter avec votre nouveau de passe.<br /><br /><strong><em>NB</em></strong> : Il se peut que vous ne retrouviez pas ledit message dans votre <strong>boîte de réception</strong>, dans ce cas regardez du côté des <strong>courriers indésirables</strong> ou <strong>SPAM</strong>.<br /><br />Pour des raisons de sécurité, veuillez modifier votre mot de passe une fois vous êtes connecté !
      </div>
    <?php } ?>
      <?php if (isset($_GET['request']) && $_GET['request']=='echec'){ ?>
      <div style="padding:15px 25px; opacity:0.70; background:#F00; width:75%; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px; font-size:12px; color:#FFF; margin:10px 0;">
      Erreur... Votre e-mail ou votre identifiant est incorrect. Veuillez réessayer ou contacter <strong>ESN ARIANE</strong> !!! </div>
    <?php } ?>
  <?php if ((isset($_GET['action']) && $_GET['action']=='recovery') && ( !isset($_GET['request']) || $_GET['request']!='succes') ){ ?>
  <div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;">
  <strong>Vous avez oublié votre mot de passe...</strong></div>
      <div style="padding:5px 0; color:#666;">
          <div style="padding:15px 25px; opacity:0.70; background:#06F; width:75%; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px; font-size:12px; color:#FFF; margin:10px 0;">
              Veuillez indiquer l'adresse e-mail ayant servie à créer votre compte afin de vous générer 
              un nouveau mot de passe !
          </div>
      </div>
      <div style="padding:5px 0;">
      <input name="requetelost" type="hidden" id="requetelost" value="frmLoginProblem" />
      </div>
  <div class="control-group">
    <label class="control-label" for="_email">Login <span class="rouge">*</span></label>
    <div class="controls">
      <input type="email" id="_email" name="_email" class="input-xlarge" placeholder="nom@site.com" required="required">
    </div>
  </div>
<div class="control-group">
    <div class="controls">
      <button type="_submit" class="btn btn-primary">Soumettre</button><br />
    </div>
  <div style="background: url(img/separe.png) bottom no-repeat; height:15px; padding-top:20px;"></div>
  </div></form>
<?php } ?>
<div align="center"><i class="icon-share-alt"></i>&nbsp;&nbsp;<a href="login.php" class="bleulien">Se connecter</a></div>
<?php } else { ?>             
<form action="<?php echo $loginFormAction; ?>" method="post" class="form-horizontal" id="frmlogin" name="frmlogin">
<?php if (isset($_GET['acces']) && $_GET['acces']=='error'){ ?>
<div style="border:#F00 1px solid; padding:20px 40px; width:75%; background-color:#F00; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px; color:#FFF; opacity:0.70; font-size:12px;">
<strong>Login et/ou mot de passe incorrect...</strong><br /><br />
Le login saisi n'est associé à aucun compte ou que vous avez mal saisi le mot de passe. Veuillez essayer de nouveau et assurez-vous qu'ils soient 
tapés correctement.
</div>
<?php } ?>
<?php if (isset($_GET['acces']) && $_GET['acces']=='denied'){ ?>
<div style="padding:20px 40px; opacity:0.70; background:#FF9; color:#F00; width:75%; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px; font-size:12px;">
Erreur de connexion... <br /><br />Votre compte ou l'abonnement à nos services est suspendu. 
Veuillez contacter ARIANE !!!
</div>
<?php } ?>
<br />
  <div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Compte :</strong></div>
  <div class="control-group">
    <label class="control-label" for="email">Login <span class="rouge">*</span></label>
    <div class="controls">
      <input type="email" id="email" name="email" class="input-xlarge" placeholder="nom@site.com" required="required">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="motpasse">Mot de passe <span class="rouge">*</span></label>
    <div class="controls">
      <input type="password" name="motpasse" id="motpasse" placeholder="Mot de passe" required="required" class="input-small">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <input name="requetelogin" type="hidden" id="requetelogin" value="frmLogin" />
      <button type="submit" class="btn btn-primary">Connexion</button><br />
    </div>
  <div style="background: url(img/separe.png) bottom no-repeat; height:15px; padding-top:20px;"></div>
<div align="center"><img src="images/puce.gif" alt="" width="9" height="9" />&nbsp;&nbsp;<a href="login.php?action=recovery" class="bleulien">Mot de passe oublié ?</a></div>
  </div>
</form>

<?php } ?>          
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
