<?php
$db = "autoform";
$user = "root";
$pass = "root";
$serverlink = mysql_connect("localhost", $user, $pass) or die (mysql_error());
mysql_select_db($db) or die (mysql_error());
mysql_query('SET NAMES UTF8') or die (mysql_error());
?>
