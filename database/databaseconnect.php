<?php
$connection = @mysql_connect("db1", "london2_1", "1Tow2Ers3");
if (!$connection) {
echo "Could not connect to MySql server!";
exit;
}

$db = mysql_select_db("london2_1", $connection);
if (!$db) {
echo "Could not select database";
exit;
}

?>