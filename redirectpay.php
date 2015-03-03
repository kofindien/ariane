<?php 
	if ($_POST['mpaie']=='Orange Money') $url = 'ompay.php';
	if ($_POST['mpaie']=='MTN Mobile Money') $url = 'mmmpay.php';
	if ($_POST['mpaie']=='Flooz') $url = 'floozpay.php';
	header(sprintf("Location: %s",$url));
?>