<?php
include('../database/databaseconnect.php');
$user = 'london2_1';
$pass = 'towers';
$dbname = 'london2_1';
$dbhost = 'db1';
$date = date('Y-m-d');
$file = '../database/london' . $date . '.sql';
$output = "mysqldump --opt -h $dbhost -u$user -p$pass $dbname > $file";
system($output);

$to = 'sumita.biswas@gmail.com';
$subject = 'LDC Cron 2 daily';
$body = 'Triggered This';
$headers = "From: Auto <auto@londondinnerclub.org> \r\n";
mail($to, $subject, $body, $headers);

echo 'DONE';
exit;
?>