<?php session_start();
include '../database/databaseconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: ADMIN AREA ::  London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club. Singles events london, singles event, dating events, speed dating, match.com, datingdirect.com, dating in london, online dating, dating tips, salima manji, asian dinner club, supperclub, vogue, luxury events, luxe events" />
<script>
function check()
{
	var subject = document.getElementById('Subject');
	if(subject.value == '')
	{
		alert('Please enter a subject.');
		return false;
	}

	var message = document.getElementById('Message');
	if(message.value == '')
	{
		alert('Please enter a message.');
		return false;
	}
	document.send.submit();
}
</script>
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="logo"><a href="../admin/" target="_self"><img src="../images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.londondinnerclub.org/" target="_self">HOME</a></li>
<li class="topnav" ><a href="../aboutus.php" target="_self">ABOUT<br/>US</a></li>
<li><a href="../events.php" target="_self">CURRENT<br/>EVENTS</a></li>
<li><a href="../past_events.php" target="_self">PAST<br/>EVENTS</a></li>
<li><a href="../membership.php" target="_self">MEMBERSHIP</a></li>
<li><a href="../asiandinnerclub.php" target="_self">ASIAN<br/>DINNER CLUB</a></li>
<li><a href="../press.php" target="_self">PRESS</a></li>
<li><a href="../team.php" target="_self">THE<br/>TEAM</a></li>
<li><a href="../contact.php" target="_self">CONTACT</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->

<div id="contentcol1">

<h2>Admin Area</h2>
<img src="../images/membership.gif" alt="Membership" width="181" height="50"/>
<?php
if(!isset($_POST['Send']) || (isset($_POST['Send']) && !empty($failed)))
{?>
	<table width='100%' align='center' cellspacing='2' cellpadding='2' border='0'>
	<tr>
		<td colspan='3'>&nbsp;</td>
	</tr>
	<tr>
		<th colspan='3' align='left'>Email:</th>
	</tr>
	<tr>
		<th width='33%'><input type='radio' name='email' value='All' <?php if(isset($_GET['email'])){if($_GET['email'] == 'all'){ echo "checked='checked'"; }}else{ echo "checked='checked'"; }  ?> onclick="location.href='?email=all';" />All Standard Members</th>
		<th width='33%'><input type='radio' name='email' value='Male' <?php if($_GET['email'] == 'male'){echo "checked='checked'";} ?> onclick="location.href='?email=male';" />Male</th>
		<th width='33%'><input type='radio' name='email' value='Female' <?php if($_GET['email'] == 'female'){echo "checked='checked'";} ?> onclick="location.href='?email=female';" />Female</th>
	</tr>
	<tr height='40'>
		<td colspan='3'>&nbsp;</td>
	</tr>
	<tr>
		<th align='left' colspan='3'>Compose Message:</th>
	</tr>
	<tr>
		<td colspan='3'>
			<?php
			$query = "SELECT EmailAddress FROM Members";
			if(isset($_GET['email']))
			{
				$gen = $_GET['email'];
				if($gen == 'male')
				{
					$query .= " WHERE Gender = 'Male'";
				}
				elseif($gen == 'female')
				{
					$query .= " WHERE Gender = 'Female'";
				}
			}
			$result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($result))
			{
				$emails .= $row[0] . ',';
			}
			$emails = substr($emails, 0, -1);
			?>
			<form method='post' name='send'>
				<table width='100%' cellspacing='2' cellpadding='2' border='0'>
					<tr>
						<th width='15%' align='left'>To:</th>
						<td><?php
							if(isset($_GET['email']))
							{
								$gen = $_GET['email'];
								if($gen == 'all')
								{
									echo 'All Standard Members';
								}
								elseif($gen == 'male')
								{
									echo 'All Male Standard Members';
								}
								else
								{
									echo 'All Female Standard Members';
								}
							}
							else
							{
								echo 'All Standard Members';
							}?>
							<input type='hidden' name='EmailAdd' value='<?php echo $emails;?>' />
						</td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					<tr>
						<th align='left'>Subject:</th>
						<td><input type='text' name='Subject' id='Subject' size='65' /></td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					<tr>
						<th align='left'valign='top'>Message:</th>
						<td><textarea name='Message' cols='80' rows='15' id='Message' class='fontstyle3'></textarea></td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='2' align='center'>
						<input type='hidden' name='Send' />
						<table cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title='Send Message' href="#" onclick='return check();'>Send Message</a></td>
								<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
							</tr>
						</table>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	</table>
<?php
}
else
{
	//$toemails = $_POST['EmailAdd'];
	$toemails = 'sales@asiandinnerclub.com, sumita.biswas@gmail.com';
	$toemails2 = explode(',', $toemails);
	foreach($toemails2 as $toe)
	{
		$to = $toe;
		$subject = $_POST['Subject'];
		if(strpos($subject, '\"') !== false)
		{
			$subject = str_replace('\"', '"', $subject);
		}

		if(strpos($subject, "\'") !== false)
		{
			$subject = str_replace("\'", "'", $subject);
		}

		$mess = $_POST['Message'];
		if(strpos($mess, "\r\n") !== false)
		{
			$mess = str_replace("\r\n", '<br/>', $mess);
		}

		if(strpos($mess, '\"') !== false)
		{
			$mess = str_replace('\"', '"', $mess);
		}

		if(strpos($mess, "\'") !== false)
		{
			$mess = str_replace("\'", "'", $mess);
		}

		$message = "<html><head></head><body><p>" . $mess . "</p>";
		$message .= "<p>&nbsp;</p><p>Best Wishes,<br/><br/>From the London Dinner Club Team</p>";
		$message .= "<p><img src='http://www.londondinnerclub.org/images/logo2.png' alt='London Dinner Club' border='0' /></p><p style='font-size:10px;'>We want to keep you up to date with everything that is happening at London Dinner Club, but you can click here to unsubscribe <a href='mailto:sales@londondinnerclub.org'>sales@londondinnerclub.org</a> if you no longer wish to receive information.Thank you.</p></body></html>";
		$headers = "MIME-Version: 1.0 \r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
		$headers .= "From: London Dinner Club <sales@londondinnerclub.com> \r\n";

		if(!mail($to, $subject, $message, $headers))
		{
			$failed[] = $toe;
		}
	}

	if(empty($failed))
	{?>
		<p>All Email(s) have been sent successfully!</p>
		<p>&nbsp;</p>
		<p>
		<table cellspacing='0' cellpadding='0' border='0'>
			<tr>
				<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
				<td class='singlebutton'><a title='Send More Emails' href="emailmembers.php">Send More Emails</a></td>
				<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
			</tr>
		</table>
		</p>
<?php
	}
	else
	{?>
		<p>Sorry, a few emails couldn't be sent.</p>
		<p>There is a temporary error in the system. We apologise for any inconvenience caused.</p>
		<p>Please try again later or email manually by clicking the recipient(s) below:</p>
		<p>
		<?php
		foreach($failed as $fail)
		{
			echo "- <a href='mailto:$fail'>$fail</a><br/>";
		}?>
		</p>
<?php
	}
}?>

<table cellspacing='0' cellpadding='0' border='0'>
	<tr>
		<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
		<td class='singlebutton'><a title='Return' href="../admin/">Return</a></td>
		<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
	</tr>
</table>
<p>&nbsp;</p>

</div>

<div id="contentcol2">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
    <p>&nbsp;</p>
  <span class="lefthandpic"><img src="../images/side.jpg" alt="London Dinner Club" width="194" height="194" /></span>
    <p>&nbsp;</p>
        <p>&nbsp;</p>
</div>


<!-- end inner content -->

</div>
</div>
<div id="footer">
<div class="footer2col1"><a href="../terms.php">TERMS</a>&nbsp;|&nbsp;<a href="../sitemap.php">SITE MAP</a>&nbsp;|&nbsp;<a class='active' href="../admin/">ADMINISTRATOR</a>&nbsp;|&nbsp;<a class='active' href="../admin/logout.php">LOG OUT</a></div></div>
<div id="footer2">
<div class="footer2col2">Copyright &copy;&nbsp;London Dinner Club&nbsp;2010</div>
<div class="footer2col2">designed by: <a href="http://www.streeten.co.uk" target='_blank'>streeten</a></div>
<div class="footer2col2">redeveloped by: <a href="http://www.sbcommunications.co.uk" target='_blank'>S B Communications Ltd.</a></div></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
  //_uacct = "UA-4965994-1";
  //urchinTracker();
</script>
</div>
</body>
</html>