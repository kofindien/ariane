<?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
<ul class="nav nav-pills">
  <li <?php if ($currentPage == 'index.php') echo 'class="active"'; ?>><a href="./">Tableau de bord</a></li>
  <li <?php if ($currentPage == 'rechargements.php' || $currentPage == 'attentes.php' || $currentPage == 'majrecharge.php' || $currentPage == 'suprecharge.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Rechargements <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="attentes.php">Rechargements en attente</a></li>
      <li><a href="rechargements.php">Rechargements effectués</a></li>
      <li><a href="suprecharge.php">Supprimer un rechargement</a></li>
    </ul>
  </li>
  <li <?php if ($currentPage == 'mppaiements.php' || $currentPage == 'pattentes.php' || $currentPage == 'supmpay.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mon Profil <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="pattentes.php">Paiements en attente</a></li>
      <li><a href="mppaiements.php">Paiements effectués</a></li>
      <li><a href="supmpay.php">Supprimer un paiement</a></li>
    </ul>
  </li>
  <li <?php if ($currentPage == 'avpaiements.php' || $currentPage == 'avattentes.php'|| $currentPage == 'supavpay.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Alertes Voyages <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="avattentes.php">Paiements en attente</a></li>
      <li><a href="avpaiements.php">Paiements effectués</a></li>
      <li><a href="supavpay.php">Supprimer un Paiement</a></li>
    </ul>
  </li>
  <li <?php if ($currentPage == '' || $currentPage == '' || $currentPage == '' || $currentPage == '' || $currentPage == '' || $currentPage == '' || $currentPage == '') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Domiciliations <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="#">...</a></li>
      <!--<li><a href="ajuser.php">Ajouter un utilisateur</a></li>
      <li><a href="rechmajuser.php">Modifier un utilisateur</a></li>
      <li><a href="desuser.php">Désactiver un utilisateur</a></li>
      <li><a href="actuser.php">Réactiver un utilisateur</a></li>
      <li><a href="supuser.php">Supprimer un utilisateur</a></li>-->
    </ul>
  </li>
  <li <?php if ($currentPage == 'abonnes.php'/* || $currentPage == 'vueabonne.php' || $currentPage == 'ajabonne.php' || $currentPage == 'rechmajabonne.php' || $currentPage == 'majabonne.php' || $currentPage == 'desabonne.php' || $currentPage == 'actabonne.php' || $currentPage == 'supabonne.php'*/) echo 'class="active"'; /*else echo 'class="dropdown"';*/ ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="abonnes.php">Abonnés<!-- <b class="caret"></b>--></a>
    <!--<ul class="dropdown-menu">
      <li><a href="abonnes.php">Les abonnés</a></li>
      <li><a href="ajabonne.php">Ajouter un abonné</a></li>
      <li><a href="rechmajabonne.php">Modifier un abonné</a></li>
      <!--<li><a href="desabonne.php">Désactiver un abonné</a></li>
      <li><a href="actabonne.php">Réactiver un abonné</a></li>
      <li><a href="supabonne.php">Supprimer un abonné</a></li>
    </ul>-->
  </li>
  <li <?php if ($currentPage == 'users.php' || $currentPage == 'ajuser.php' || $currentPage == 'rechmajuser.php' || $currentPage == 'majuser.php' || $currentPage == 'desuser.php' || $currentPage == 'actuser.php' || $currentPage == 'supuser.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Utilisateurs <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="users.php">Les utilisateurs</a></li>
      <li><a href="ajuser.php">Ajouter un utilisateur</a></li>
      <li><a href="rechmajuser.php">Modifier un utilisateur</a></li>
      <li><a href="desuser.php">Désactiver un utilisateur</a></li>
      <li><a href="actuser.php">Réactiver un utilisateur</a></li>
      <li><a href="supuser.php">Supprimer un utilisateur</a></li>
    </ul>
  </li>
</ul>