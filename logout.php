<?php
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianefo');
  session_start();
}

  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['ariane_user_id'] = NULL;
  $_SESSION['ariane_user_idab'] = NULL;
  $_SESSION['ariane_user_numcard'] = NULL;
  $_SESSION['ariane_user_dvalidite'] = NULL;
  $_SESSION['sewa_user_login'] = NULL;
  $_SESSION['ariane_user_identite'] = NULL;
  $_SESSION['ariane_user_Group'] = NULL;
  unset($_SESSION['ariane_user_id']);
  unset($_SESSION['ariane_user_idab']);
  unset($_SESSION['ariane_user_numcard']);
  unset($_SESSION['ariane_user_dvalidite']);
  unset($_SESSION['ariane_user_login']);
  unset($_SESSION['ariane_user_identite']);
  unset($_SESSION['ariane_user_Group']);

  $logoutGoTo = "./";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
?>