<?php
/*$today = date('Y-m-d H:i');
$next = date('Y-m-d H:i', strtotime(date("Y-m-d H:i", strtotime($today)) . " +6 months"));
echo $next;
echo dirname(__FILE__);*/

include '../database/databaseconnect.php';

$user = md5('London896673');
$pass = md5('Towers123');
$update = "UPDATE tbl_auth_user SET admin_id = '$user', user_pass = '$pass' WHERE ID = 'a'";
mysql_query($update) or die(mysql_error());
echo 'DONE';
?>