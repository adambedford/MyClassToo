<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_myclasstoo = "localhost";
$database_myclasstoo = "adam1234_class";
$username_myclasstoo = "adam1234_admin";
$password_myclasstoo = "4d4mb3d4d";
$myclasstoo = mysql_pconnect($hostname_myclasstoo, $username_myclasstoo, $password_myclasstoo) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_myclasstoo);
?>