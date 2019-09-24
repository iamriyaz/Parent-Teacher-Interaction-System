<?php
# FileName="Connection_php_mysqli.htm"
# Type="mysqli"
# HTTP="true"
$hostname_PTS = "localhost";
$database_PTS = "ptis";
$username_PTS = "root";
$password_PTS = "";
$PTS = mysqli_connect($hostname_PTS, $username_PTS, $password_PTS) or trigger_error(mysqli_error(),E_USER_ERROR); 
?>