<?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
<ul class="nav nav-pills">
  <li <?php if ($currentPage == 'Index.php') echo 'class="active"'; ?>><a href="./">Accueil</a></li>
  <li <?php if ($currentPage == 'quoibuy.php' || $currentPage == 'buyline.php' || $currentPage == 'howbuy.php' || $currentPage == 'payline.php' || $currentPage == 'paybuy.php' || $currentPage == 'howpay.php' || $currentPage == 'livraison.php' || $currentPage == 'tarifline.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Achats & Paiements<br />par Internet<b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li class="dropdown-submenu">
        <a href="#">Achats en ligne</a>
            <ul class="dropdown-menu">
                <li><a href="buyline.php">Acheter en ligne. Pourquoi pas ?</a></li>
                <li><a href="quoibuy.php">Que peut-on acheter sur Internet ?</a></li>
                <li><a href="howbuy.php">Comment acheter sur Internet ?</a></li>
                <li><a href="livraison.php">Comment se faire livrer un produit acheté sur Internet ?</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu">
        <a href="#">Paiements en ligne</a>
            <ul class="dropdown-menu">
                <li><a href="payline.php">Des produits et des services pour tous sur Internet</a></li>
                <li><a href="howpay.php">Comment payer sur Internet ?</a></li>
            </ul>
        </li>
        <li><a href="paybuy.php">Procédure de paiement</a></li>
    </ul>
  </li>
  <li <?php if ($currentPage == 'domiciliation.php' || $currentPage == 'cmtdom.php' || $currentPage == 'domtarif.php' || $currentPage == 'domprocess.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Domiciliation<br />de commandes <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><a href="domiciliation.php">Vous voulez vous faire livrer chez vous un produit acheté sur Internet ?</a></li>
        <li><a href="cmtdom.php">La domiciliation de commande sur Internet, comment ça marche ?</a></li>
    </ul>
  </li>
  <li <?php if ($currentPage == 'cmtafricard.php' || $currentPage == 'africard.php' || $currentPage == 'recharges.php' || $currentPage == 'perteafricard.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Carte prépayée<br />VISA Africard <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="africard.php">Présentation</a></li>
        <li><a href="cmtafricard.php">Comment ça marche</a></li>
        <li><a href="perteafricard.php">Que faire en cas de perte ?</a></li>
        <li><a href="recharges.php">Rechargements à distance de la carte</a></li>
      </ul>
  </li>
  <!--<li <?php if ($currentPage == 'apa.php') echo 'class="active"'; ?>><a href="apa.php">Alerte Passagers AVION</a></li>-->
 <li <?php if ($currentPage == 'apa.php' || $currentPage == 'apa.php' || $currentPage == 'mline.php' || $currentPage == 'navette.php' || $currentPage == 'vpc.php' || $currentPage == 'tstarif.php' || $currentPage == 'tsprocess.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Alerte Passagers AVION <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="apa.php">Présentation du service</a></li>
            <li><a href="tsprocess.php">Comment souscrire à Alerte Passagers AVION ?</a></li>
        </ul>
  </li>
   <!--<li <?php if ($currentPage == 'monprofil.php' || $currentPage == 'fonctionmp.php' || $currentPage == 'mptarif.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Emplois<br />MON PROFIL<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="monprofil.php">Présentation</a></li>
            <li><a href="fonctionmp.php">Comment ça marche</a></li>
            <li><a href="mptarif.php">Tarification</a></li>
            <li><a href="frmcompte.php">Souscrire au service</a></li>
        </ul>
  </li>-->
  <li <?php if ($currentPage == 'tarification.php') echo 'class="active"'; ?>><a href="tarification.php">Tarification des services</a></li>
  <li <?php if ($currentPage == 'contacts.php') echo 'class="active"'; ?>><a href="contacts.php">Contacts</a></li>
</ul>