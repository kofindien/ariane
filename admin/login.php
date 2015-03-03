<?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
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
  session_name('arianebo');
  session_start();
}

$loginFormAction = "login.php";
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = "login.php";
}
//echo $password = md5($salt2.md5($salt1.'matrix'.$salt2).$salt1);
if (isset($_POST['requetelogin']) && $_POST['requetelogin']=="frmLogin") {
  $salt1 = "qm&h*";	$salt2 = "p#g!@";
  $loginUsername=$_POST['email'];
  $password = md5($salt2.md5($salt1.$_POST['motpasse'].$salt2).$salt1);
  $MM_fldUserAuthorization = "idg";
  $MM_redirectLoginSuccess = "redirectall.php";  
  $MM_redirectLoginFailed = "login.php?acces=error";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_liaisondb, $liaisondb);
  	
  $LoginRS__query=sprintf("SELECT comptes.idc, comptes.nom, comptes.prenoms, groupes.idg, groupes.libg FROM comptes, groupes WHERE comptes.idg = groupes.idg AND comptes.active = 1 AND comptes.email=%s AND comptes.motpasse=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
   
  $LoginRS = mysql_query($LoginRS__query, $liaisondb) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $ariane_admin_id = mysql_result($LoginRS,0,'idc');
    $ariane_admin_idg = mysql_result($LoginRS,0,'idg');
    $ariane_admin_libg = mysql_result($LoginRS,0,'libg');
    $ariane_admin_nom = mysql_result($LoginRS,0,'nom');
    $ariane_admin_prenoms = mysql_result($LoginRS,0,'prenoms');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
			
    //declare two session variables and assign them
    $_SESSION['ariane_admin_id'] = $ariane_admin_id;
    $_SESSION['ariane_admin_idg'] = $ariane_admin_idg;
    $_SESSION['ariane_admin_libg'] = $ariane_admin_libg;
    $_SESSION['ariane_admin_login'] = $loginUsername;
    $_SESSION['ariane_admin_identite'] = $ariane_admin_nom . ' ' . $ariane_admin_prenoms;

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
  $Login_RS__query = sprintf("SELECT * FROM comptes WHERE comptes.email=%s", GetSQLValueString($email, "text"));
  mysql_select_db($database_liaisondb, $liaisondb);
  $_LoginRS=mysql_query($Login_RS__query, $liaisondb) or die(mysql_error());
  $_loginFoundUser = mysql_num_rows($_LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($_loginFoundUser){
	  
	    $newpass = GenerePassword(10);
		$salt1 = "qm&h*";	$salt2 = "p#g!@";
		$_newpass = md5($salt2.md5($salt1.$newpass.$salt2).$salt1);
		
		$ariane_admin_prenoms = mysql_result($_LoginRS,0,'prenoms');
		$ariane_admin_nom = mysql_result($_LoginRS,0,'nom');
		$identite = $ariane_admin_nom . $ariane_admin_prenoms;
		$message = '<p>Bonjour <strong>$identite</strong>,<br /><br /> Ci-dessous vos paramètres de connexion :</p>
		<p>Login : $login<br /><br />Nouveau mot de passe : $newpass</p>
	
		---------------
		Ceci est un mail automatique, merci de ne pas y répondre.';
		
		$updateSQL = sprintf("UPDATE comptes SET comptes.motpasse=%s WHERE comptes.email=%s",
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
		$objet = "Mot de passe oublié !!!";
		mail($email, $objet, $message, $headers);
	  
    $_MM_dupKeyRedirect = $_MM_dupKeyRedirect . "?action=recovery&request=succes";
    header ("Location: $MM_dupKeyRedirect");
  }
  else {
    $_MM_dupKeyRedirect = $_MM_dupKeyRedirect . "?action=recovery&request=echec";
    header ("Location: $MM_dupKeyRedirect");
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Authentification ::: ARIANE</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
</head>
<body>
<div style="min-height:250px; margin:10px 0 0 0;">
  <!--Entête-->
  <div class="row" align="left" style="width:1000px; height:50px; margin:0 auto;">
    <div class="span7">
        <img src="../img/logo.png" width="126" height="29" />&nbsp;&nbsp;&nbsp;&nbsp;
        <img src="../img/titre.png" />
    </div>    
    
  </div>
  <!--Fin Entête-->
  <!--Corps-->
  <div style="width:1024px; min-height:40px; margin:20px auto;">
      <div style="background:#FFF; min-height:300px; width:350px; margin:10% auto 0 auto; opacity:0.9; -webkit-border-radius:10px; border-radius:10px; -moz-border-radius:10px; border:1px solid #CCC;">
          <div align="left" style="padding:30px;">
            <div style="margin:1% 0;">
        <form id="frmLogin" name="frmLogin" method="POST" action="<?php echo $loginFormAction; ?>">
            <div align="center" style="padding-bottom:10px;"><img src="../img/login.jpg" /></div>
            <span class="titreB">Veuillez vous connecter ici</span><br />
            <input name="requetelogin" type="hidden" id="requetelogin" value="frmLogin" />
              <?php if (isset($_GET['acces']) && $_GET['acces']=='error'){ ?>
              <div style="padding:10px; opacity:0.70; background:#FF9; color:#F00; margin:10px 0;">
              Erreur de connexion... Votre mot de passe ou votre identifiant est incorrect.<br />
              Veuillez réessayer !!!
              </div>
              <?php } ?>
              <?php if (isset($_GET['acces']) && $_GET['acces']=='denied'){ ?>
              <div style="padding:10px; opacity:0.70; background:#FF9; color:#F00; margin:10px 0;">
              Erreur de connexion...<br />Votre compte est suspendu. Veuillez contacter l'administrateur !!!
              </div>
              <?php } ?>
              <div style="padding:10px 0 5px 0; color:#666;"><strong>Login :</strong></div>
              <div style="padding:5px 0;">
              <div class="input-append">
              <input name="email" type="text" id="email" size="40" placeholder="email@site.com" required="required" />
              <span class="add-on"><i class="icon-user"></i></span>
              </div>
              </div>
              <div style="padding:5px 0; color:#666;"><strong>Mot de passe :</strong></div>
              <div style="padding:5px 0;">
              <div class="input-append">
              <input name="motpasse" type="password" id="motpasse" size="40" placeholder="Votre mot de passe ..." required="required" />
              <span class="add-on"><i class="icon-lock"></i></span>
              </div>
              <div align="center" style="padding:15px 0;">
                <input name="requetelogin" type="hidden" id="requetelogin" value="frmLogin" />
              <input name="Submit" type="submit" class="btn btn-primary" id="Submit" value="Se connecter" src="include/up.png" />
              </div>
              </div>
        </form>
            </div>
          </div>
        <div style="clear:both;"></div>
      </div>
    </div>
  <!--Fin Corps-->
<!--Début pieds de page-->
<div align="center" style="margin:40px 0 20px 0; clear:both;"><?php require_once('../bin/admin.copyright.php'); ?></div>
<!--Fin pieds de page-->
</div>
</body>
</html>
