<?php 
if ($_POST['mpaie']=='Orange Money') $url = 'aompay.php';
if ($_POST['mpaie']=='MTN Mobile Money') $url = 'ammmpay.php';
if ($_POST['mpaie']=='Flooz') $url = 'afloozpay.php';
header(sprintf("Location: %s",$url));
?>