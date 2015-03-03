<?php
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianebo');
  session_start();
}

  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['ariane_admin_id'] = NULL;
  $_SESSION['ariane_admin_idg'] = NULL;
  $_SESSION['ariane_admin_libg'] = NULL;
  $_SESSION['sewa_admin_login'] = NULL;
  $_SESSION['ariane_admin_identite'] = NULL;
  unset($_SESSION['ariane_admin_id']);
  unset($_SESSION['ariane_admin_idg']);
  unset($_SESSION['ariane_admin_libg']);
  unset($_SESSION['sewa_admin_login']);
  unset($_SESSION['ariane_admin_identite']);

  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
?>