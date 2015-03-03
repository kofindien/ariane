<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_liaisondb = "localhost:3306";
$database_liaisondb = "arianedb";
$username_liaisondb = "oswaaruser";
$password_liaisondb = "Tuc@PG2012rxPb$";
$liaisondb = mysql_pconnect($hostname_liaisondb, $username_liaisondb, $password_liaisondb) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_query("SET NAMES 'utf8'");
mb_http_input("utf-8");
mb_http_output("utf-8");

$hostname_attachedb = "localhost:3306";
$database_attachedb = "jobassistdb";
$username_attachedb = "user_jobassist";
$password_attachedb = "Jobassist@2012$";
$attachedb = mysql_pconnect($hostname_attachedb, $username_attachedb, $password_attachedb) or trigger_error(mysql_error(),E_USER_ERROR); 

?>