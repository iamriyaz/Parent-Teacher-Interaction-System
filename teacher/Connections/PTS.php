<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_PTS = "localhost";
$database_PTS = "ptis";
$username_PTS = "root";
$password_PTS = "";
$PTS = mysql_pconnect($hostname_PTS, $username_PTS, $password_PTS) or trigger_error(mysql_error(),E_USER_ERROR); 
?>