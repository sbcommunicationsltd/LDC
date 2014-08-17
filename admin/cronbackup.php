<?php
$user = 'london2_1';
$pass = 'towers';
$dbname = 'london2_1';
$dbhost = 'db1';
$date = date('Y-m-d');
$origloc = '../database/';
$filename = 'london2' . $date . '.sql';
$file = $origloc . $filename;
$output = "mysqldump --opt -h $dbhost -u$user -p$pass $dbname > $file";
system($output);

$ch = curl_init();
$fp = fopen($file, 'r');

// set up basic connection
$ftp_server = 'ftp.daily.co.uk';
// login with username and password
$ftp_user_name = 'london2';
$ftp_user_pass = 'Towers123';

$destinationfile = 'database/' . $filename;

curl_setopt($ch, CURLOPT_URL, "ftp://$ftp_user_name:$ftp_user_pass@$ftp_server/public_html/$destinationfile");
curl_setopt($ch, CURLOPT_UPLOAD, 1);
curl_setopt($ch, CURLOPT_INFILE, $fp);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file));

curl_exec ($ch);
$error_no = curl_errno($ch);
curl_close ($ch);

if ($error_no == 0) {
$message = 'File uploaded successfully.';
} else {
$message = "File upload error: $error_no. Error codes explained here http://curl.haxx.se/libcurl/c/libcurl-errors.html";
}
echo $message;

unlink($file);

echo 'DONE';
?>