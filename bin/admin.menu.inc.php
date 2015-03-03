<?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
<ul class="nav nav-pills">
  <li <?php if ($currentPage == 'index.php') echo 'class="active"'; ?>><a href="./">Tableau de bord</a></li>
  <li <?php if ($currentPage == 'rechargements.php' || $currentPage == 'attentes.php' || $currentPage == 'majrecharge.php' || $currentPage == 'suprecharge.php' || $currentPage == 'nonrecharger.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Rechargements <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="attentes.php">Rechargements en attente</a></li>
      <li><a href="rechargements.php">Rechargements effectués</a></li>
      <li><a href="nonrecharger.php">Rechargements non effectués</a></li>
      <!--<li><a href="suprecharge.php">Supprimer un rechargement</a></li>-->
    </ul>
  </li>
  <li <?php if ($currentPage == 'mppaiements.php' || $currentPage == 'pattentes.php' || $currentPage == 'supmpay.php' || $currentPage == 'mpnpaid.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mon Profil <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="pattentes.php">Paiements en attente</a></li>
      <li><a href="mppaiements.php">Paiements effectués</a></li>
      <li><a href="mpnpaid.php">Paiements non effectués</a></li>
      <!--<li><a href="supmpay.php">Supprimer un paiement</a></li>-->
    </ul>
  </li>
  <li <?php if ($currentPage == 'avpaiements.php' || $currentPage == 'avattentes.php'|| $currentPage == 'supavpay.php'|| $currentPage == 'avnpaid.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Alertes Voyages<b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="avattentes.php">Paiements en attente</a></li>
      <li><a href="avpaiements.php">Paiements effectués</a></li>
      <li><a href="avnpaid.php">Paiements non effectués</a></li>
      <li class="dropdown-submenu"><a href="#">Autres...</a>
          <ul class="dropdown-menu">
            <li class="dropdown-submenu"><a href="#">Les compagnies aériennes</a>
              <ul class="dropdown-menu">
                <li><a href="compagnies.php">Liste des compagnies aériennes</a></li>
                  <!--<li><a href="apa.php">Ajouter une compagnie aérienne</a></li>-->
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Les numéros de vols</a>
              <ul class="dropdown-menu">
                <li><a href="numvols.php">Liste des numéros de vols</a></li>
                <li><a href="apa.php">Ajouter un numéro de vols</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Les vols</a>
              <ul class="dropdown-menu">
                <li><a href="apa.php">Liste des vols</a></li>
                <li><a href="ajvol.php">Ajouter un vol</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Les horaires</a>
              <ul class="dropdown-menu">
                <li><a href="horaires.php">Liste des horaires</a></li>
                  <!--<li><a href="apa.php">Ajouter un horaire</a></li>-->
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Les dates de départ</a>
              <ul class="dropdown-menu">
                <li><a href="departs.php">Liste des dates</a></li>
                  <!--<li><a href="apa.php">Ajouter une date</a></li>-->
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Les destinations</a>
              <ul class="dropdown-menu">
                <li><a href="destinations.php">Liste des destinations</a></li>
                  <!--<li><a href="apa.php">Ajouter une destination</a></li>-->
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Les pays</a>
              <ul class="dropdown-menu">
                <li><a href="pays.php">Liste des pays</a></li>
                  <!--<li><a href="apa.php">Ajouter un pays</a></li>-->
              </ul>
            </li>
          </ul>
      </li>
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
  <li <?php if ($currentPage == 'abonnes.php' || $currentPage == 'vueabonne.php' || $currentPage == 'vueabonneservice.php') echo 'class="active"'; ?>><a href="abonnes.php">Abonnés</a></li>
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
  <li <?php if ($currentPage == 'groupes.php' || $currentPage == 'ajgroupe.php') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Groupes <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="groupes.php">Groupes & permissions</a></li>
      <li><a href="ajgroupe.php">Ajouter un groupe et ses permissions</a></li>
      <li><a href="rechmajuser.php">Modifier un groupe et ses permissions</a></li>
      <li><a href="supuser.php">Supprimer un groupe et ses permissions</a></li>
      <li><a href="actuser.php">Consulter un groupe et ses permissions</a></li>
    </ul>
  </li>
</ul>