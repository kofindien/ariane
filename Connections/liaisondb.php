<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_liaisondb = "localhost";
$database_liaisondb = "arianedb";
$username_liaisondb = "root";
$password_liaisondb = "";
$liaisondb = mysql_pconnect($hostname_liaisondb, $username_liaisondb, $password_liaisondb) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_query("SET NAMES 'utf8'");
mb_http_input("utf-8");
mb_http_output("utf-8");

$hostname_attachedb = "localhost";
$database_attachedb = "arianedb";
$username_attachedb = "root";
$password_attachedb = "";
$attachedb = mysql_pconnect($hostname_attachedb, $username_attachedb, $password_attachedb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>