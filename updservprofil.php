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

mysql_select_db($database_attachedb, $attachedb);
$query_rsDomaines = "SELECT idd, domaine FROM domaines ORDER BY domaine ASC";
$rsDomaines = mysql_query($query_rsDomaines, $attachedb) or die(mysql_error());
$row_rsDomaines = mysql_fetch_assoc($rsDomaines);
$totalRows_rsDomaines = mysql_num_rows($rsDomaines);

$colname_rsProfil = "-1";
if (isset($_SESSION['ariane_user_id'])) {
  $colname_rsProfil = $_SESSION['ariane_user_id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsProfil = sprintf("SELECT clients.idcl, clients.civilite, clients.nom, clients.prenoms, clients.cel FROM clients WHERE clients.idcl = %s", GetSQLValueString($colname_rsProfil, "int"));
$rsProfil = mysql_query($query_rsProfil, $liaisondb) or die(mysql_error());
$row_rsProfil = mysql_fetch_assoc($rsProfil);
$totalRows_rsProfil = mysql_num_rows($rsProfil);

$colname_rsAbonnement = "-1";
if (isset($_GET['serv'])) {
  $colname_rsAbonnement = $_GET['serv'];
}
mysql_select_db($database_liaisondb, $liaisondb);
$query_rsAbonnement = sprintf("SELECT * FROM abonnements WHERE abonnements.ids = %s AND abonnements.idcl = %s", GetSQLValueString($colname_rsAbonnement, "int"), GetSQLValueString($_SESSION['ariane_user_id'], "int"));
$rsAbonnement = mysql_query($query_rsAbonnement, $liaisondb) or die(mysql_error());
$row_rsAbonnement = mysql_fetch_assoc($rsAbonnement);
 $totalRows_rsAbonnement = mysql_num_rows($rsAbonnement);

if ((isset($_POST['frmSend'])) && ($_POST['frmSend']=='Apply')) {
			
	$updateSQL = sprintf("UPDATE abonnements SET idd = %s, niveau = %s, diplome = %s, experience = %s, age = %s  WHERE idab=%s",
		   GetSQLValueString($_POST['idd'], "text"),
		   GetSQLValueString($_POST['niveau'], "text"),
		   GetSQLValueString($_POST['diplome'], "text"),
		   GetSQLValueString($_POST['experience'], "text"),
		   GetSQLValueString($_POST['age'], "text"),
		   GetSQLValueString($_POST['idab'], "int"));
	
	  mysql_select_db($database_liaisondb, $liaisondb);
	  $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());
  
	if ($Result1) $alerte = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La modification des informations de la souscription au service Emplois disponible pour mon PROFIL a été bien prise en compte !</div>';
	else $alerte =  '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La modification des informations de la souscription au service Emplois disponible pour mon PROFIL a échoué... Veuillez recommencer !</div>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Modifier la souscrption au service d'emplois lié à mon PROFIL ::: Ariane</title>
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
<!--<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($){
	//Get the input data using the post method when Submit is clicked .. we pull it using the libp fields of LIBP respectively...
    $("#message").hide();
    $("#retour").hide();
	$("#Submit").click(function(){
		//Get values of the input field and store it into the variable.
		var civilite=$("#civilite").val();
		var nom=$("#nom").val();
		var prenoms=$("#prenoms").val();
		var cel=$("#cel").val();
		var idab=$("#idab").val();
		
		if (civilite =="" || nom =="" || prenoms =="" || cel =="" || idab ==""){
		$("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
		return false;
		}
		
		$("#flash").show();
		$("#flash").fadeIn(800).html('<img src="img/ajax-loader.gif" width="220" height="19" align="absmiddle" /> Traitement en cours ...');
		//use the $.post() method to call insert.php file.. this is the ajax request
		/*$.post('updateprofil.php', {civilite: civilite, nom: nom, prenoms: prenoms, cel: cel, idab: idab},
		function(data){
			$("#message").html(data);
			$("#message").hide();
			$("#flash").hide();
			$("#message").fadeIn(1500).delay(5000).fadeOut(1500); //Fade in the data given by the insert.php file
			$("#retour").fadeIn(1500).delay(5000).fadeOut(1500);
			$("#civilite").val("");
			$("#nom").val("");
			$("#prenoms").val("");
			$("#cel").val("");
			$("#frmCompte").hide();
		});*/
		return false;
	});
});
</script>
-->
<script type="text/javascript" src="highslide/highslide-full.js"></script>
<script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
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
        <div style="padding:25px; border:1px solid #CCC; min-height:600px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
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
                
                <div class="titre" style="margin-bottom:20px; padding:10px 0;">Espace client &raquo; Mon PRrofil</div>
				<div style="background: url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>

                <!--<div id="flash"></div>
                <div id="vide"></div>
                <div id="message"></div>
                <div id="retour" style="margin-top:15px;">
                <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour à l'espace client" onclick="window.location.replace('espaceclient.php');" />
                </div>-->
                
                <?php if (isset($alerte)) echo $alerte; ?>

              <div>
                
                <div style="padding-top:30px;">
                
 <?php if (!isset($alerte)){ ?>
 
<form action="updservprofil.php" method="post" class="form-horizontal" id="Apply" name="Apply">
<div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;"><strong>Informations sur le service :</strong></div>
<div class="control-group">
  <label class="control-label" for="lservice">Service <span class="rouge">*</span></label>
    <div class="controls">
      <input name="lservice" type="text" disabled="disabled" required class="input-small" id="lservice" value="Mon Profil"><input name="ids" id="ids" type="hidden" value="2">
    </div>
</div>
  <div class="control-group">
    <label class="control-label" for="idd">Domaine de compétance <span class="rouge">*</span></label>
    <div class="controls" style="padding-top:13px;">
      <select id="idd" name="idd" class="input-large" required>
		<?php do { ?>
            <option value="<?php echo $row_rsDomaines['idd']?>" <?php if (!(strcmp($row_rsDomaines['idd'], $row_rsAbonnement['idd']))){echo "selected=\"selected\"";} ?>><?php echo $row_rsDomaines['domaine']?></option>
        <?php
            } while ($row_rsDomaines = mysql_fetch_assoc($rsDomaines));
            $rows = mysql_num_rows($rsDomaines);
            if($rows > 0) {
              mysql_data_seek($rsDomaines, 0);
              $row_rsDomaines = mysql_fetch_assoc($rsDomaines);
            }
        ?>
      </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="niveau">Niveau d'études <span class="rouge">*</span></label>
    <div class="controls">
        <select name="niveau" id="niveau" class="span5" required>
          <option selected="selected" value=""></option>
          <option value="CEPE" <?php if (!(strcmp("CEPE", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>CEPE (CAP)</option>
          <option value="BEPC" <?php if (!(strcmp("BEPC", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BEPC (BEP/BEPC)</option>
          <option value="Tle" <?php if (!(strcmp("Tle", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>Niveau Terminale</option>
          <option value="BAC" <?php if (!(strcmp("BAC", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BAC (BT/BAC)</option>
          <option value="BAC+2" <?php if (!(strcmp("BAC+2", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BAC+2 (DUT/DEUG/DUEL/BTS)</option>
          <option value="BAC+3" <?php if (!(strcmp("BAC+3", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BAC+3 (Licence)</option>
          <option value="BAC+4" <?php if (!(strcmp("BAC+4", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BAC+4 (Maîtrise/Master 1)</option>
          <option value="BAC+5" <?php if (!(strcmp("BAC+5", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BAC+5 (DEA/DESS/MBA/Master 2/Ingénieur/Architecte)</option>
          <option value="BAC+6" <?php if (!(strcmp("BAC+6", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BAC+6 (Doctorat du 3ème cycle)</option>
          <option value="BAC+7" <?php if (!(strcmp("BAC+7", $row_rsAbonnement['niveau']))){echo "selected=\"selected\"";} ?>>BAC+7 (Doctorat d'Etat)</option>
        </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="diplome">Diplôme <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="diplome" name="diplome" class="span5" required value="<?php echo $row_rsAbonnement['diplome']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="experience">Nombre d'années d'expériences <span class="rouge">*</span></label>
    <div class="controls" style="padding-top:13px;">
      <input type="text" id="experience" name="experience" class="span1" value="<?php echo $row_rsAbonnement['experience']; ?>" required> an(s)
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="age">Age <span class="rouge">*</span></label>
    <div class="controls">
      <input type="text" id="age" name="age" class="span1" value="<?php echo $row_rsAbonnement['age']; ?>" required>
    ans</div>
  </div>
  <div class="control-group">
    <div class="controls">
      <input name="idab" type="hidden" id="idab" value="<?php echo $row_rsAbonnement['idab']; ?>" />
      <input name="frmSend" type="hidden" id="frmSend" value="Apply" />
<button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('espaceclient.php');">&larr; Retour</button>
<button type="submit" id="Submit" name="Submit" class="btn btn-primary"><i class="icon-edit icon-white"></i> Modifier</button>
    </div>
</div>
</form>
<?php } else { ?>
<button type="button" name="return" id="return" class="btn btn-danger" onclick="window.location.replace('espaceclient.php');"><i class="icon-circle-arrow-left icon-white"></i> Retour</button>
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
<?php
mysql_free_result($rsDomaines);

mysql_free_result($rsProfil);
?>
