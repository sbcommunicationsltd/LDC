<?php
include '../database/databaseconnect.php';

function daysDiff($start, $end)
{
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}

$to = 'sumita.biswas@gmail.com';
$subject = 'ldc cron daily';
$body = "Triggered \n";

$query = "SELECT * FROM Members";
$result = mysql_query($query) or die(mysql_error());
$date = date('Y-m-d H:i');
while($row = mysql_fetch_array($result))
{
	$id = $row['ID'];
	//if($id == '25')
	//{
		$expire = $row['DateExpire'];
		if($date < $expire)
		{
			if(daysDiff($date, $expire) == 7)
			{
				$update = "UPDATE Members SET Approved = 'RenewNo' WHERE ID = '$id'";
				mysql_query($update) or die(mysql_error());

				$email = $row['EmailAddress'];
				$to2 = $email;
				//$to = 'sumita.biswas@gmail.com';
				$firstname = $row['Forename'];
				$subject2 = 'Renew Membership to London Dinner Club';
				$body2 = "<html><head><title>Renew Membership to London Dinner Club</title></head><body>";
				$body2 .= "<p>Dear $firstname,</p>";
				$body2 .= "<p>Your Membership will be expiring in 7 days.</p>";
				$body2 .= "<p>If you would like to continue, please <a href='http://www.londondinnerclub.org/member/paypal.php' style='text-decoration:underline;' border='0'>click here</a>. After you have paid, you will receive email confirmation.</p>";
				$body2 .= "<p><br/></p><p>Best Wishes,</p>";
				$body2 .= "<p><br/></p><p>London Dinner Club</p>";
				$body2 .= "<p><img src='http://www.londondinnerclub.org/images/logo2.png' alt='London Dinner Club' border='0' /></p></body></html>";

				$headers2 = "MIME-Version: 1.0 \r\n";
				$headers2 .= "Content-type: text/html; charset=iso-8859-1 \r\n";
				$headers2 .= "From: London Dinner Club <info@londondinnerclub.org> \r\n";
				$headers2 .= "Cc: sales@londondinnerclub.org \r\n";


				if(mail($to2, $subject2, $body2, $headers2))
				{
					$body .= "Mail Sent \n";
				}
			}
		}
		else
		{
			$body .= "NONE Expired \n";
		}
	//}
}

$headers = "From: Auto <auto@londondinnerclub.org> \r\n";
mail($to, $subject, $body, $headers);

exit;
?>