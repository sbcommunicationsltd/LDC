<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: ADMIN AREA :: London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
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
	<h1><img src="../images/welcome.gif" alt="welcome" width="181" height="50"/></h1>
<div>

<?php
session_start();
include '../database/databaseconnect.php';
$errorMessage1 = 'Sorry, wrong user id / password';
$errorMessage2 = 'Sorry - you have been locked out.';
$errorMessage = '';
if(!isset($_SESSION['countlog']))
{
	$_SESSION['countlog'] = 0;
}

if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) {

	$userId = md5($_POST['txtUserId']);
   
	//Check if user is locked out
	$query = "SELECT status, reset FROM tbl_auth_user WHERE admin_id = '$userId'";
	$res = mysql_query($query) or die(mysql_error());
	$ro = mysql_fetch_array($res);
	if($ro[0] == 0)
	{
		$password = md5($_POST['txtPassword']);

		// check if the user id and password combination exist in database
		$sql = "SELECT *
				FROM tbl_auth_user
				WHERE admin_id = '$userId'
					AND user_pass = '$password'";

		$result = mysql_query($sql)
				or die('Query failed. ' . mysql_error());

		if (mysql_num_rows($result) == 1) {
			// the user id and password match,
			// set the session
			$_SESSION['admin_is_logged_in'] = true;

			// after login we move to the main page
			header('Location: ../admin/');
			exit;
		} 
		/*else 
		{
			$errorMessage = 'Sorry, wrong user id / password';
		}*/
		else
   		{
   			if($ro[1] == 1)
   			{
   				$_SESSION['countlog'] = 1;
				$sql3 = "SELECT * FROM tbl_auth_user WHERE admin_id = '$userId'";
   		   		$result3 = mysql_query($sql3) or die(mysql_error());
   		   		if(mysql_num_rows($result3) == 1)
				{
					$sql4 = "UPDATE tbl_auth_user SET reset = 0 WHERE admin_id = '$userId'";
					mysql_query($sql4) or die(mysql_error());
				}
   			}
   			else
   			{
   				$_SESSION['countlog']++;
   			}
   			//echo 'COUNT: ' . $countlog;
   			if($_SESSION['countlog'] < 3)
   			{
   		   		$errorMessage = $errorMessage1;
   		   	}
   		   	else
   		   	{
   		   		$errorMessage = $errorMessage2;
   		   		$sql2 = "SELECT * FROM tbl_auth_user WHERE admin_id = '$userId'";
   		   		$result2 = mysql_query($sql2) or die(mysql_error());
   		   		if(mysql_num_rows($result2) == 1)
   		   		{
   		   			$sql3 = "UPDATE tbl_auth_user SET status = 1 WHERE admin_id = '$userId'";
   		   			mysql_query($sql3) or die(mysql_error());
   		   		}
   		   	}
   		}
	}
	else
   	{
   		$errorMessage = $errorMessage2;
   	}

	mysql_close();
}
if ($errorMessage != '') {
?>
<p align="center" style='color:#990000; font-weight:bold;'><?php echo $errorMessage; ?></p>
<?php
}
?>
<form method="post" name="frmLogin" id="frmLogin" action='login.php'>
<table style="border:1px solid #d0d3d5; background-color:transparent;" border="0" cellspacing="0" cellpadding="4" width="400" align='center' height='175'>
	<tr>
    	<th align='center' colspan="2" bgcolor="#EAC117" class="bghome"><div style="color: #00225d;">&nbsp;ADMINISTRATIVE LOGIN</div></th>
    </tr>
    <tr>
		<th align='left'>Username</th>
		<td><input name="txtUserId" type="text" id="txtUserId" /></td>
	</tr>
	<tr>
		<th align='left'>Password</th>
		<td><input name="txtPassword" type="password" id="txtPassword" /></td>
	</tr>
</table>
<table cellspacing='0' cellpadding='0' border='0' align='center'>
	<tr>
		<td colspan='3'>&nbsp;</td>
	</tr>
	<tr>
		<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" /></td>
		<td class='singlebutton'><a title='Log In' onclick="javascript:document.frmLogin.submit();" href='#'>Log In</a></td>
		<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" /></td>
	</tr>
</table>
<!--<table height="50" colspan="2" align="center">
	<tr>
		<td><a onclick="javascript:document.frmLogin.submit();" href='#'><img src="../images/login.gif" alt="Login" border="0" /></a></td>
	</tr>
</table>-->
</form>
<p><br/></p>
<table cellspacing='0' cellpadding='0' border='0'>
	<tr>
		<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" /></td>
		<td class='singlebutton'><a title='Back to Main Page' href="http://www.londondinnerclub.org/">Back to Main Page</a></td>
		<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" /></td>
	</tr>
</table>
<!--<input type="button" value="Back to Main Page" onClick="location.href='../index.php'" />-->
</div>
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
<div class="footer2col1"><a href="../terms.php">TERMS</a>&nbsp;|&nbsp;<a href="../sitemap.php">SITE MAP</a>&nbsp;|&nbsp;<a class='active' href="../admin/">ADMINISTRATOR</a></div></div>
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