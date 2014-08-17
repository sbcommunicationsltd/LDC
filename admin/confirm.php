<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../member/css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: email login :: London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="logo"><a href="http://www.londondinnerclub.org/admin/" target="_parent"><img src="../images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.londondinnerclub.org/admin/" target="_parent">ADMIN HOME</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->

<div id="contentcol1">

<?php
session_start();
include '../database/databaseconnect.php';

if(!isset($_SESSION['admin_is_logged_in'])){
	header('Location: login.php');
}

$errorMessage1 = 'Sorry, wrong user id / password';
$errorMessage2 = 'Sorry - you have been locked out.';
$errorMessage = '';
if(!isset($_SESSION['countlog2']))
{
	$_SESSION['countlog2'] = 0;
}

if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) {

	$userId = md5($_POST['txtUserId']);
	//Check if user is locked out
	$query = "SELECT status, reset FROM tbl_auth_user WHERE admin_id2 = '$userId'";
	$res = mysql_query($query) or die(mysql_error());
	$ro = mysql_fetch_array($res);
	if($ro[0] == 0)
	{
		$password = md5($_POST['txtPassword']);

		// check if the user id and password combination exist in database
		$sql = "SELECT *
			FROM tbl_auth_user
			WHERE admin_id2 = '$userId'
				AND user_pass = '$password'";

		$result = mysql_query($sql)
				or die('Query failed. ' . mysql_error());

		if (mysql_num_rows($result) == 1) {
			// the user id and password match,
			// set the session
			$_SESSION['admin2_is_logged_in'] = true;

			// after login we move to the main page
			?>
			<script>
			window.opener.location.href = 'emailmembers.php';
			window.close();
			</script>
			<?php
			exit;
		} 
		else
		{
			if($ro[1] == 1)
			{
				$_SESSION['countlog2'] = 1;
				$sql3 = "SELECT * FROM tbl_auth_user WHERE admin_id2 = '$userId'";
				$result3 = mysql_query($sql3) or die(mysql_error());
				if(mysql_num_rows($result3) == 1)
				{
					$sql4 = "UPDATE tbl_auth_user SET reset = 0 WHERE admin_id2 = '$userId'";
					mysql_query($sql4) or die(mysql_error());
				}
			}
			else
			{
				$_SESSION['countlog2']++;
			}
			//echo 'COUNT: ' . $countlog2;
			if($_SESSION['countlog2'] < 3)
			{
				$errorMessage = $errorMessage1;
			}
			else
			{
				$errorMessage = $errorMessage2;
				$sql2 = "SELECT * FROM tbl_auth_user WHERE admin_id2 = '$userId'";
				$result2 = mysql_query($sql2) or die(mysql_error());
				if(mysql_num_rows($result2) == 1)
				{
					$sql3 = "UPDATE tbl_auth_user SET status = 1 WHERE admin_id2 = '$userId'";
					mysql_query($sql3) or die(mysql_error());
				}
			}
		}
	}
	else
   	{
   		$errorMessage = $errorMessage2;
   	}
}
?>
<h1><img src="../images/welcome.gif" alt="welcome" width="181" height="50"/></h1>
<div>
<?php
if ($errorMessage != '') {
?>
<p align="center" style='color:#990000; font-weight:bold;'><?php echo $errorMessage; ?></p>
<?php
}
?>
<form method="post" name="frmLogin" id="frmLogin">
<table style="border:1px solid #d0d3d5; background-color:transparent;" border="0" cellspacing="0" cellpadding="4" width="300" align='center' height='175'>
	<tr>
		<th align='center' colspan="2" bgcolor="#EAC117" class="bghome"><div style="color: #00225d;">&nbsp;MEMBER LOGIN</div></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input name="txtUserId" type="text" id="txtUserId"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input name="txtPassword" type="password" id="txtPassword"></td>
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
</form>
<p><br/></p>
<table cellspacing='0' cellpadding='0' border='0'>
	<tr>
		<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" /></td>
		<td class='singlebutton'><a title='Close' href='javascript:window.close();'>Close</a></td>
		<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" /></td>
	</tr>
</table>
<!--<input type="button" value="Back" onClick="location.href='../index.php'">-->
</div>
</div>

<div id="contentcol2">
<p>&nbsp;</p>
<p>&nbsp;</p>
<!--<span class="lefthandpic"><img src="../images/side.jpg" alt="Asian Dinner Club" width="194" height="194" /></span>-->
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>


<!-- end inner content -->

</div>
</div>
<div id="footer">
</div>
<div id="footer2">
<div class="footer2col2">Copyright &copy;&nbsp;London Dinner Club&nbsp;2010</div>
<div class="footer2col2">designed by: <a href="http://www.streeten.com">streeten</a></div>
<div class="footer2col2">redeveloped by: <a href="http://www.sbcommunications.co.uk">S B Communications Ltd.</a></div></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
  //_uacct = "UA-4965994-1";
  //urchinTracker();
</script>
</div>
</body>
</html>