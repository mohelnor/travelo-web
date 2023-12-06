<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_travelo = "localhost";
$database_travelo = "travelo";
$username_travelo = "root";
$password_travelo = "root1234";
$travelo = mysql_pconnect($hostname_travelo, $username_travelo, $password_travelo) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db($database_travelo, $travelo);
?>