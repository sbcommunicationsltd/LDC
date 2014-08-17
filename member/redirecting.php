<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: membership booking login :: London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="logo"><a href="../member/" target="_self"><img src="../images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.londondinnerclub.org/" target="_self">HOME</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->

<div id="contentcol1">
<p>Please Wait...</p>
<p>Redirecting...</p>
<?php
session_start();
include '../database/databaseconnect.php';
$redirect = 0;
$amount = $_POST['amount'];
$item = $_POST['item_name'];
$itemnumber = $_POST['item_number'];
$quantity = $_POST['quantity'];
$id = $_POST['id'];
$gender = $_POST['gender'];

$query = "SELECT * FROM Events WHERE ID = $id";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);
$venue = $row['Venue'] . ' on ' . date('jS F Y', strtotime($row['Date']));
$maxmale = $row['MaxMaleQuantity'];
$maxfemale = $row['MaxFemaleQuantity'];
if($gender == 'Male')
{
	if($maxmale == 0)
	{?>
		<script>
		alert('Sorry - Male Tickets for <?php echo $venue;?> are sold out! Please feel free to choose another event.');
		location.href='../events.php';
		</script>
	<?php
	}
	elseif($maxmale!=0 && ($maxmale < $quantity))
	{?>
		<script>
		alert('Sorry, we cannot provide that many tickets. Please change the quantity of tickets needed.');
		location.href="../events.php";
		</script>
	<?php
	}
	else
	{
		$redirect = 1;
		$url = '=' . $quantity . '&ven=' . $id . '&gen=m';
	}
}
else
{
	if($maxfemale == 0)
	{?>
		<script>
		alert('Sorry - Female Tickets for <?php echo $venue;?> are sold out! Please feel free to choose another event.');
		location.href='../events.php';
		</script>
	<?php
	}
	elseif($maxfemale!=0 && ($maxfemale < $quantity))
	{?>
		<script>
		alert('Sorry, we cannot provide that many tickets. Please change the quantity of tickets needed.');
		location.href="../events.php";
		</script>
	<?php
	}
	else
	{
		$redirect = 1;
		$url = '=' . $quantity . '&ven=' . $id . '&gen=f';
	}
}
?>
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
<?php
if($redirect == 1)
{?>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name='paypal'>
	<input type="hidden" name="business" value="sales@londondinnerclub.org">
	<input type='hidden' name='cmd' value='_xclick'>
	<input type='hidden' name='amount' value="<?php echo $amount;?>">
	<!--<input type='hidden' name='amount' value="0.01">-->
	<input type='hidden' name='currency_code' value="GBP">
	<input type='hidden' name='item_name' value="<?php echo $item;?>">
	<input type='hidden' name='item_number' value="<?php echo $itemnumber;?>">
	<input type="hidden" name="on0" value="Gender">
	<select name="os0" style='display:none;'>
		<option value="Male" <?php if($gender == 'Male'){echo "selected='selected'";}?>>Male</option>
		<option value="Female" <?php if($gender == 'Female'){echo "selected='selected'";}?>>Female</option>
	</select>
	<input type='hidden' name='quantity' value="<?php echo $quantity;?>">
	<input type="hidden" name="return" value="http://www.londondinnerclub.org/events.php?success<?php echo $url;?>">
	<!--added in for quantity countdown-->
	<input type='hidden' name='notify_url' value="http://www.londondinnerclub.org/scripts/ipnprocess.php?success<?php echo $url;?>">
	<input type="hidden" name="cancel_return" value="http://www.londondinnerclub.org/events.php?cancel<?php echo $url;?>">
	</form>
	<script>document.paypal.submit();</script>
<?php
}