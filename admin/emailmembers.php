<?php session_start();
include '../database/databaseconnect.php';

if(!isset($_SESSION['admin_is_logged_in'])){
	header('Location: login.php');
}

if(!isset($_SESSION['admin2_is_logged_in'])){
	header('Location: ../admin/');
}?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Administrator | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="London Dinner Club - Admin" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="../css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/forms.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/styles.css" type="text/css" />
        
    <!--[if lt IE 9]>  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <!-- Icons -->
    <link rel="icon" href="../images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114.png" type="text/css"/>
    
     <!--JS -->
     <script type="text/javascript" src="../js/retina.js"></script>
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     
     <script type="text/javascript" src="../js/jquery.scrollUp.min.js"></script>
     <script type="text/javascript" src="../js/jquery.easing.min.js"></script>
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
<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="";?>
   			<?php include('../navigation.php');?>
    
       </header>
    	
       <!-- Content-->
       <div class="spacebreak"></div>
       
           <h1 class="medium-header uppercase center">Admin Area</h1>
           <div class="line2"></div>
           
           <div class="spacebreak"></div>
            <img src="../images/membership.gif" alt="Membership" width="181" height="50"/>
            <p>&nbsp;</p>
			<?php
			if (isset($_REQUEST['type'])) {
				$type = $_REQUEST['type'];
				if ('Gold' == $type) {
					$tableName = 'Gold_Members';
				} else {
					$tableName = 'Members';
				}?>
				
				<h2 align='center'>Email <?php echo $type;?> Members</h2>
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
						<th width='33%'><input type='radio' name='email' value='Male' <?php if(isset($_GET['email']) && $_GET['email'] == 'male'){echo "checked='checked'";} ?> onclick="location.href='?email=male';" />Male</th>
						<th width='33%'><input type='radio' name='email' value='Female' <?php if(isset($_GET['email']) && $_GET['email'] == 'female'){echo "checked='checked'";} ?> onclick="location.href='?email=female';" />Female</th>
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
							$query = "SELECT EmailAddress FROM $tableName";
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
							$emails = substr($emails, 0, -1);?>
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
													echo "All $type Members";
												}
												elseif($gen == 'male')
												{
													echo "All Male $type Members";
												}
												else
												{
													echo "All Female $type Members";
												}
											}
											else
											{
												echo "All $type Members";
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
										<td>&nbsp;</td>
										<td>
										<input type='hidden' name='Send' />
										<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' /><!--
										--><input type='submit' class='singlebutton' alt='Send Message' value='Send Message' onclick='return check();' /><!--
										--><img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
										</p></td>
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
					$toemails = $_POST['EmailAdd'];
					//$toemails = 'sumita.biswas@gmail.com,sumi@blueyonder.co.uk,sumita_biswas@hotmail.com';
					//$toemails = 'sumita.biswas@gmail.com';
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
						$message .= "<p><img src='http://www.londondinnerclub.org/images/logo.png' alt='London Dinner Club' border='0' width='150' /></p>";
						$message .= "<p style='font-size:10px;'>We want to keep you up to date with everything that is happening at London Dinner Club, but you can click here to unsubscribe <a href='mailto:sales@londondinnerclub.org'>sales@londondinnerclub.org</a> if you no longer wish to receive information. Thank you.</p></body></html>";
						$headers = "MIME-Version: 1.0 \r\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
						$headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";

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
						<form method='post' name='mainadmin' action='emailmembers.php'>
						<input type='hidden' name='sendmore' />
						<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
						<input type='submit' value='Send More Emails' class='singlebutton' />
						<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
						</p>
						</form>
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
				}
			} else {?>
				<form method='post' name='redirect'>
				<input type='hidden' name='type' value='Silver' />
				<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
				<input type='submit' value='Email Silver Members' class='singlebutton' />
				<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
				</p>
				</form>
				<br/><br/>
				<form method='post' name='redirect'>
				<input type='hidden' name='type' value='Gold' />
				<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
				<input type='submit' value='Email Gold Members' class='singlebutton' />
				<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
				</p>
				</form>
				<br/><br/>
			<?php
			}?>


<form method='post' name='mainadmin' action='../admin/'>
	<input type='hidden' name='admin' />
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
    <input type='submit' value='Return to main admin screen' class='singlebutton' />
    <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
    </p>
  	</form>
<p>&nbsp;</p>
</div>

<div class="clear"></div>
       <div class="spacebreak"></div>
    </div>

    <?php include('../footer.php');?>
   
</body>
</html>