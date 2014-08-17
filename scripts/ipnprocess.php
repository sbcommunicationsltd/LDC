<?php
include('../database/databaseconnect.php');

/*$to = 'sumita.biswas@gmail.com';
$subject = 'check 1';
$message = 'gone to notify';
$headers = "From: AutoSystem <auto@londondinnerclub.org> \r\n";
mail($to, $subject, $message, $headers);*/

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];

$txn_id = $_POST['txn_id'];
$deleteold = "DELETE FROM PrevTxns WHERE ID = '1'";
mysql_query($deleteold) or die(mysql_error());
for($i=2; $i<=10; $i++)
{
	$j = $i-1;
	$findtxn = "UPDATE PrevTxns SET ID = '$j' WHERE ID = '$i'";
	mysql_query($findtxn) or die(mysql_error());
}

$savetxn = "INSERT INTO PrevTxns VALUES('10', '$txn_id')";
mysql_query($savetxn) or die(mysql_error());

/*$to = 'sumita.biswas@gmail.com';
$subject = 'check 2';
$message = 'got txn ids - gender - ' . $_GET['success'] . ' - eid - ' . $_GET['ven'];
$headers = "From: AutoSystem <auto@londondinnerclub.org> \r\n";
mail($to, $subject, $message, $headers);*/

$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
	// HTTP ERROR
	$to = 'sumita.biswas@gmail.com';
	$subject = 'ticket quantity could not be verified';
	$message = 'ticket quantity could not be verified as variables could not be sent back to PayPal for validation.';
	$headers = "From: AutoSystem <auto@londondinnerclub.org> \r\n";
	mail($to, $subject, $message, $headers);
} 
else 
{
	fputs ($fp, $header . $req);
	while (!feof($fp)) 
	{
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) 
		{
			$validated = array();
			// check the payment_status is Completed
			if($payment_status == 'Completed')
			{
				$validated[] = 1;
			}
			else
			{
				$validated[] = 0;
			}
			
			// check that txn_id has not been previously processed
			$findtxn = "SELECT * FROM PrevTxns";
			$restxn = mysql_query($findtxn) or die(mysql_error());
			while($rowtxn = mysql_fetch_array($restxn))
			{
				$prevtxn[] = $rowtxn['TxnID'];
			}
			
			if(in_array($txn_id, $prevtxn))
			{
				$validated[] = 0;
			}
			else
			{
				$validated[] = 1;
			}
			
			// check that receiver_email is your Primary PayPal email
			if($receiver_email == 'sales@londondinnerclub.org')
			{
				$validated[] = 1;
			}
			else
			{
				$validated[] = 0;
			}
			
			// check that payment_amount/payment_currency are correct
			$eid = $_GET['ven'];
			
			$findeve = "SELECT * FROM Events WHERE ID = $eid";
			$reseve = mysql_query($findeve) or die(mysql_error());
			$roweve = mysql_fetch_array($reseve) or die(mysql_error());
			
			if($payment_amount == $roweve['Price'])
			{
				$validated[] = 1;
			}
			else
			{
				$validated[] = 0;
			}
		
			// process payment
			if(in_array(1, $validated))
			{
				$stat = '';
				$ticket = addslashes($roweve['Venue']) . ' on ' . date('jS F Y', strtotime($roweve['Date']));
			
				$gender = $_GET['success'];
				if($gender == 'f')
				{
					$femalequantity = $roweve['MaxFemaleQuantity'] - 1;
					if($femalequantity <= 5 && $femalequantity > 0)
					{
						$to = 'sales@londondinnerclub.org';
						$subject = "Female Tickets Alert - $ticket";
						$body = "This is an auto alert:\r\n";	
						$body .= "\r\nFemale Tickets for $ticket has reached 5 or less.\r\n";
						$body .= "\r\nPlease keep checking on the events database to see the ticket status.\r\n";
						$body .= "\r\nThanks\nAuto Service\nLondon Dinner Club\r\n";
						$headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
						mail($to, $subject, $body, $headers);
					}

					if($femalequantity == 0)
					{
						$to = 'sales@londondinnerclub.org';
						$subject = "Female Tickets Alert - $ticket";
						$body = "This is an auto alert:\r\n";
						$body .= "\r\nFemale Tickets for $ticket has SOLD OUT!\r\n";
						$body .= "\r\nPlease change the ticket status on the events database asap.\r\n";
						$body .= "\r\nThanks\nAuto Service\nLondon Dinner Club\r\n";
						$headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
						mail($to, $subject, $body, $headers);
						
						if($roweve['MaxMaleQuantity'] == 0)
						{
							$stat = 'Event Sold Out';
						}
						else
						{
							$stat = 'Female Tickets Sold Out';
						}
					}
						
					$qu = "UPDATE Events SET MaxFemaleQuantity = '$femalequantity'";
					if($stat != '')
					{
						$qu .= ", Availability = '$stat'";
					}
					$qu .= " WHERE ID = $eid";
					mysql_query($qu) or die(mysql_error());
				}
				else
				{
					$malequantity = $roweve['MaxMaleQuantity'] - 1;
					if($malequantity <= 5 && $malequantity > 0)
					{
						$to = 'sales@londondinnerclub.org';
						$subject = "Male Tickets Alert - $ticket";
						$body = "This is an auto alert:\r\n";
						$body .= "\r\nMale Tickets for $ticket has reached 5 or less.\r\n";
						$body .= "\r\nPlease keep checking on the events database to see the ticket status.\r\n";
						$body .= "\r\nThanks\nAuto Service\nLondon Dinner Club\r\n";
						$headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
						mail($to, $subject, $body, $headers);
					}

					if($malequantity == 0)
					{
						$to = 'sales@londondinnerclub.org';
						$subject = "Male Tickets Alert - $ticket";
						$body = "This is an auto alert:\r\n";
						$body .= "Male Tickets for $ticket has SOLD OUT!\r\n";
						$body .= "\r\nPlease change the ticket status on the events database asap.\r\n";
						$body .= "\r\nThanks\nAuto Service\nLondon Dinner Club\r\n";
						$headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
						mail($to, $subject, $body, $headers);
						
						if($roweve['MaxFemaleQuantity'] == 0)
						{
							$stat = 'Event Sold Out';
						}
						else
						{
							$stat = 'Male Tickets Sold Out';
						}
					}
					
					$qu = "UPDATE Events SET MaxMaleQuantity = '$malequantity'";
					if($stat != '')
					{
						$qu .= ", Availability = '$stat'";
					}
					$qu .= " WHERE ID = $eid";
					mysql_query($qu) or die(mysql_error());
				}
			}
			else
			{
				$to = 'sumita.biswas@gmail.com';
				$subject = 'Payment Validation failed';
				$message = 'PayPal Validation Failed to match details with original details.';
				$headers = "From: AutoSystem <auto@londondinnerclub.org> \r\n";
				mail($to, $subject, $message, $headers);
			}
		}
		else if (strcmp ($res, "INVALID") == 0) 
		{
			// log for manual investigation
			$to = 'sumita.biswas@gmail.com';
			$subject = 'Payment Validation failed - Paypal INVALID';
			$message = 'PayPal Validation Failed to match details with original details - PAYMENT INVALID.';
			$headers = "From: AutoSystem <auto@londondinnerclub.org> \r\n";
			mail($to, $subject, $message, $headers);
		}
	}
	fclose ($fp);
}
?>
