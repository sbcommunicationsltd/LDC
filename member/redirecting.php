<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Members Booking | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="Information on new and upcoming events by London Dinner Club" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="../css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/forms.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/styles.css" type="text/css"/>
    
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
</head>
<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="new-events";?>
   			<?php include('../navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>

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
		location.href='../new-events.php';
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
		location.href='../new-events.php';
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
}?>
</div>

<div class="spacebreak"></div>   
    </div>
 
   
    <?php include('../footer.php');?>
   
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
	<input type="hidden" name="return" value="http://www.londondinnerclub.org/new-events.php?success<?php echo $url;?>">
	<!--added in for quantity countdown-->
	<input type='hidden' name='notify_url' value="http://www.londondinnerclub.org/scripts/ipnprocess.php?success<?php echo $url;?>">
	<input type="hidden" name="cancel_return" value="http://www.londondinnerclub.org/new-events.php?cancel<?php echo $url;?>">
	</form>
	<script>document.paypal.submit();</script>
<?php
}