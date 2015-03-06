<?php require_once('Connections/liaisondb.php'); ?>
<?php require_once('bin/fonctions.php'); ?>
<?php require_once('Class/PHPMailerAutoload.php'); ?>
<?php require_once('sms/API.php'); ?>
<?php $msg = "Demande transmise avec succès.Nous vous notifierons par SMS pour le paiement des frais de services par Orange  Money afin d'activer votre Alerte voyage."; ?>
<?php
if (!isset($_SESSION)) {
    session_name('arianefo');
    session_start();
    $verification = (isset($_POST['verification'])) ? $_SESSION['verification'] =  $_POST['verification'] : "";
    $mode_paiement = (isset($_POST['mpaie'])) ? $_SESSION['mpaie'] =  $_POST['mpaie'] : "";
    $idClient = (isset($_POST['idClient'])) ? $_SESSION['idClient'] =  $_POST['idClient'] : "";
    $date_depart = (isset($_POST['ddepart'])) ? $_SESSION['ddepart'] =  $_POST['ddepart'] : "".'<br/>';
    $vol = (isset($_POST['vol'])) ? $_SESSION['vol'] =  $_POST['vol'] : "";
    $heure = (isset($_POST['Heurevol'])) ? $_SESSION['Heurevol'] =  $_POST['Heurevol'] : "";
    $minuite = (isset($_POST['Minuitevol'])) ? $_SESSION['Minuitevol'] =  $_POST['Minuitevol'] : "";
    $nom_prenoms_clt =  (isset($_POST['identite_clt'])) ? $_SESSION['identite_clt'] =  $_POST['identite_clt'] : "";
    $cel = (isset($_POST['cel'])) ? $_SESSION['cel'] =  $_POST['cel'] : "";
    $montant = (isset($_POST['montant'])) ? $_SESSION['montant'] =  $_POST['montant'] : "";
    $insertSQL = "INSERT INTO alerts_voyages(numero_vol,date_depart,heure_debut_vol, minuite_debut_vol,mode_paiement,telephone,idClient,statut,montant,date_creation) VALUES ('$vol', '$date_depart','$heure','$minuite', '$mode_paiement','$cel',$idClient,'0','$montant',now())";
    mysql_select_db($database_liaisondb, $liaisondb);
    $Result1 = mysql_query($insertSQL, $liaisondb) or die(mysql_error());

    //Envoie des emails aux admins
    mysql_select_db($database_liaisondb, $liaisondb);
    $query_rsOperations = "SELECT comptes.email FROM comptes INNER JOIN groupes ON comptes.idg = groupes.idg WHERE groupes.libg = 'Super administrateur' ";
    $rsOperations = mysql_query($query_rsOperations, $liaisondb) or die(mysql_error());
    $row_rsOperations = mysql_fetch_assoc($rsOperations);
    $totalSuperAdmin = mysql_num_rows($rsOperations);

    if($Result1){
        $mail = new PHPMailer(); // create a new object
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "arianegroupamaras@gmail.com ";
        $mail->AddReplyTo("infos@ariane.ci","Alerte voyage - ariane");
        $mail->Password = "@ri@ne2015";
        $mail->SetFrom("infos@ariane.ci");
        $mail->Subject = "Démande en attente d'activation - Alerte Voyage";
        $mail->Body = "Le client $nom_prenoms_clt désire soumettre une demande d'alertes voyages.Sa requête est en attente de traitement !<br/>
                  ---------------<br/>
		Ceci est un mail automatique, Merci de ne pas y répondre.";

        if($totalSuperAdmin > 0 ){
            do{
                $mail->addAddress($row_rsOperations['email']);
            }while($row_rsOperations = mysql_fetch_assoc($rsOperations));
        }
        if(!$mail->Send())
        {
         ?>
            <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La transmission de votre demande a échoué... Veuillez recommencer !</div>;
        <?php
        }else{

            /************** SENDING SMS **********************/
            $sms = new API();
            $sms->SendSMS("0e2db6ba","9514f30f",$cel,$msg);
            /************** SENDING SMS END**********************/

        }
    }
}
$MM_authorizedUsers = "";
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
if (!((isset($_SESSION['ariane_user_login'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['ariane_user_login'], $_SESSION['ariane_user_Group'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: ". $MM_restrictGoTo);
    exit;
}

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        //$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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


$colname_rsAbonnement = "-1";
if (isset($_SESSION['ariane_user_id'])) {
    $colname_rsAbonnement = $_SESSION['ariane_user_id'];
}
/*mysql_select_db($database_liaisondb, $liaisondb);
$query_rsAbonnement = sprintf("SELECT abonnements.idab FROM abonnements WHERE abonnements.ids = ".$_SESSION['ids']." AND abonnements.idcl = %s", GetSQLValueString($colname_rsAbonnement, "int"));
$rsAbonnement = mysql_query($query_rsAbonnement, $liaisondb) or die(mysql_error());
$row_rsAbonnement = mysql_fetch_assoc($rsAbonnement);
$totalRows_rsAbonnement = mysql_num_rows($rsAbonnement);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Alertes voyages ::: Ariane</title>
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
    <!--<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript">
        jQuery.noConflict();
        jQuery(function($){
           $("#code").mask("9999");
           $("#cel1").mask("99999999");
        });
    </script>-->
    <script type="text/javascript">
        jQuery.noConflict();
        jQuery(document).ready(function($){
            //Get the input data using the post method when Submit is clicked .. we pull it using the libp fields of LIBP respectively...
            $("#message").hide();
            $("#retour").hide();
            $("#Submit").click(function(){
                //Get values of the input field and store it into the variable.
                var mpaie=$("#mpaie").val();
                var montant=$("#montant").val();
                var cout=$("#cout").val();
                var fraisp=$("#fraisp").val();
                var cel=$("#cel").val();
                var idab=$("#idab").val();

                if (mpaie =="" || montant =="" || cout =="" || cel =="" || fraisp ==""){
                    //if (mpaie =="" || montant =="" || cel =="" || frais ==""){
                    $("#vide").fadeIn(400).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attention !</strong> Veuillez renseigner tous les champs obligatoires.</div>');
                    return false;
                }

                $("#flash").show();
                $("#flash").fadeIn(400).html('<img src="img/ajax-loader.gif" width="220" height="19" align="absmiddle" /> Traitement en cours ...');
                //use the $.post() method to call insert.php file.. this is the ajax request
                $.post('insertalerte.php', {mpaie: mpaie, montant: montant, cout: cout, cel: cel, idab: idab, fraisp: fraisp},
                    //$.post('insertrecharge.php', {mpaie: mpaie, montant: montant, cel: cel, frais: frais, idab: idab},
                    function(data){
                        $("#message").html(data);
                        $("#message").hide();
                        $("#flash").hide();
                        $("#message").fadeIn(1500).delay(5000)/*.fadeOut(1500)*/; //Fade in the data given by the insert.php file
                        $("#retour").fadeIn(1500)/*.delay(5000).fadeOut(1500)*/; //Fade in the data given by the insert.php file
                        $("#frmRecharge").hide();
                    });
                return false;
            });

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
            <div style="padding:25px; border:1px solid #CCC; min-height:600px; background:#F9F9F9 url(images/fd.png) bottom center no-repeat; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
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

                        <div class="titre" style="margin-bottom:20px; padding:10px 0;">
                            Espace client &raquo; Alertes voyages &raquo; Confirmation</div>
                        <div style="background:url(img/separe_.png) no-repeat; height:15px; padding-top:20px;"></div>

                        <div id="flash"></div>
                        <div id="vide"></div>
                        <div id="message"></div>
                        <div id="retour" style="margin-top:15px;">
                            <input name="retour" type="button" class="btn btn-success" id="retour" value="Retour à l'espace client" onclick="window.location.replace('espaceclient.php');" />
                        </div>

                        <div>

                            <div style="padding-top:10px;">

                                <form method="post" class="form-horizontal" id="frmRecharge" name="frmRecharge">
                                    <div style="padding:0 0 5px 0; border-bottom:1px solid #06C; margin-bottom:15px;">
                                        <strong>Informations sur votre demande d'alert du <?= date('d/M/Y') ?></strong></div>
                                    <div class="alert alert-success">Votre demande a été bien transmise ! Elle sera traitée immédiatement...<br />
                                        <br />En cas de non réception de SMS appeler l'administrateur au <strong>58197978</strong>/<strong>58021054</strong> /<strong>58025210</strong> .<br />
                                    </div>

                                    <div class="control-group">
                                        <table class="table table-hover">
                                            <tr>
                                                <td>Procéduren de paiement :</td>
                                                <td>
                                                    <?php
                                                    if(trim($_SESSION['mpaie']) === 'ORANGEMoney'){
                                                        ?>
                                                        <img src="images/orangemoney.png" <?php RedImage("images/orangemoney.png",116,0); ?> />
                                                    <?php
                                                    }elseif(trim($_SESSION['mpaie']) === 'Flooz'){
                                                        ?>
                                                        <img src="images/flooz_over.png" <?php RedImage("images/flooz_over.png",116,0); ?> />
                                                    <?php
                                                    }elseif(trim($_SESSION['mpaie']) === 'MobileMoney'){
                                                        ?>
                                                        <img src="images/mtnmoney_over.png" <?php RedImage("images/mtnmoney_over.png",116,0); ?> />
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nombre et cadence de réception des sms alert:</td> <td> 8 SMS</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="retour" style="margin-top:15px;">
                                        <button type="button" name="return" id="return" class="btn btn-primary" onclick="window.location.replace('espaceclient.php');"><i class="icon-circle-arrow-left icon-white"></i> Retour à votre Espace client</button>
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
