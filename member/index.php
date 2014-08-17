<?php session_start();
include '../database/databaseconnect.php';
$eid = $_GET['eid'];

if(isset($_GET['type']))
{
	if(!isset($_SESSION['premmem_is_logged_in'])){
		header('Location: login.php?type=premier&eid=' . $eid);
	}
}
else
{
	if(!isset($_SESSION['member_is_logged_in'])){
		header('Location: login.php?eid=' . $eid);
	}
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: events :: London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
<script type='text/javascript'>
function reload(gen, loc)
{
	var val = document.getElementById(gen).value;

	var val2;
	if(val == 'Female')
	{
		val2 = 'f';
	}
	else
	{
		val2 = 'm';
	}
	var pos = loc.indexOf('&gen');

	if(pos!=-1)
	{
		loc = loc.substring(0,pos);
	}
	self.location = loc + '&gen=' + val2 ;
}
</script>
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="logo"><a href="http://www.londondinnerclub.org/" target="_self"><img src="../images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.asiandinnerclub.com/" target="_self">HOME</a></li>
<li class="topnav" ><a href="aboutus.php" target="_self">ABOUT<br/>US</a></li>
<li><a href="events.php" target="_self">CURRENT<br/>EVENTS</a></li>
<li><a href="past_events.php" target="_self">PAST<br/>EVENTS</a></li>
<li><a href="membership.php" target="_self">MEMBERSHIP</a></li>
<li><a href="press.php" target="_self">PRESS</a></li>
<li><a href="team.php" target="_self">THE<br/>TEAM</a></li>
<li><a href="contact.php" target="_self">CONTACT</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>

	<div id="contentcol1">
	<h2>Members Booking</h2>
<p>You can book for any number of events, but please specify if you are MALE or FEMALE as there are limited spaces available for men and women at each event. <strong>Book now to avoid disappointment!</strong></p>
<p>&nbsp;</p>
<?php
$query = "SELECT * FROM Events WHERE ID = $eid";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);?>
<p><span class="righthandpic"><a name="<?php echo $row['Venue'];?>" id="<?php echo $row['Venue'];?>"></a><img src="../images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Venue'];?>" width="188" height="168" /></span></p>
<table width='390' border='0' cellpadding='0' cellspacing='0'>
	<tr>
	  <th align='left' width='100'>Venue:</th>
	  <td>&nbsp;</td>
	  <th align='left'><?php echo $row['Venue'];?></th>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>City:</th>
	  <td>&nbsp;</td>
	  <td align='left'><?php echo $row['City'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Address:</th>
	  <td>&nbsp;</td>
	  <td><?php echo $row['Address_Street'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><?php echo $row['Address_Town'] . ' ' . $row['Address_City'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><?php echo $row['Address_PostCode'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <?php if(stristr($row['Address_PostCode'], ' '))
			{
				$post = str_replace(' ', '+', $row['Address_PostCode']);
			}
			else
			{
				$post = $row['Address_PostCode'];
			}?>
	  <td><a style='text-decoration:none;' href="http://maps.google.co.uk/maps?f=q&hl=en&geocode=&q=<?php echo $post;?>" target="_blank">google map</a></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Date:</th>
	  <td>&nbsp;</td>
	  <?php $date = date('jS F Y', strtotime($row['Date']));?>
	  <td><?php echo $date;?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Time:</th>
	  <td>&nbsp;</td>
	  <td><?php echo $row['Time'];?>pm</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
</table>
<table width='100%' cellspacing='0' cellpadding='0' border='0' />
	<tr>
		<th align='left' valign='top' width='100'>Price:</th>
		<td style='padding-left:10px;'>&pound;<?php echo $row['Price'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Event Type:</td>
	  <td style='padding-left:10px;'><?php echo $row['Event_Type'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Availability:</th>
	  <td style='padding-left:10px;'><?php echo $row['Availability'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th valign="top" align='left'>Description:</th>
	  <td style='padding-left:10px;' valign="top"><?php echo $row['Description'];?></td>
	</tr>
	<tr>
		<td colspan='2'>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align='left'>
		<?php
		$venue = $row['Venue'];
		$amount = $row['Price'];

		$datepart = explode('-', $row['Date']);
		$date2 = $datepart[2] . $datepart[1] . $datepart[0];
		$url = $_SERVER['REQUEST_URI'];?>
			<form action="redirecting.php" method="post" name='redirecting'>
			<input type='hidden' name='amount' value="<?php echo $amount;?>">
			<!--<input type='hidden' name='amount' value="0.01">-->
			<input type='hidden' name='item_name' value="<?php echo $venue;?>">
			<input type='hidden' name='item_number' value="<?php echo $date2;?>">
			<input type='hidden' name='id' value="<?php echo $eid;?>">
			<table>
			<tr>
				<td>Gender:</td><td>Quantity:</td>
			</tr>
			<tr>
				<td>
					<select name="gender" id='gender' onChange="reload('gender', '<?php echo $url;?>');")>
					<option value="Female" <?php if(isset($_GET['gen'])){if($_GET['gen'] == 'f'){echo "selected='selected'";}} if($row['MaxFemaleQuantity'] <= 0) {echo "disabled='disabled'";}?>>Female</option>
					<option value="Male" <?php if(isset($_GET['gen'])){if($_GET['gen'] == 'm'){echo "selected='selected'";}} if($row['MaxMaleQuantity'] <= 0) {echo "disabled='disabled'";}?>>Male</option>
					</select> 
				</td>
				<td>
					<?php
					if(isset($_GET['gen']) && strlen($_GET['gen']) > 0)
					{
						if($_GET['gen'] == 'f')
						{
							$gender = 'Female';
						}
						else
						{
							$gender = 'Male';
						}
					}
					else
					{
						if ($row['MaxFemaleQuantity'] <= 0 && $row['MaxMaleQuantity'] <= 0) {
							$gender = 'Female';
						} elseif ($row['MaxFemaleQuantity'] <= 0) {
							$gender = 'Male';
						} else {
							$gender = 'Female';
						}
						
					}
					
					$fieldname = 'Max' .  $gender . 'Quantity';
					if (3 > $row["$fieldname"]) {
						$quantity = $row["$fieldname"];
					} else {
						$quantity = 3;
					}
					
					$option = '';
					if (0 < $quantity) {
						for($i=1; $i<=$quantity; $i++)
						{
							$option .= "<option value='$i'>$i</option>";
						}
						
						echo "<select name='quantity'>$option</select>";
					} else {
						echo "N/A";
					}?>
				</td>
			</tr>
			</table>
			<input type="image" src="http://www.londondinnerclub.org/images/paypalbutton.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
			</form>
		</td>
	</tr>
</table>
<p>&nbsp;</p>
<table cellspacing='0' cellpadding='0' border='0'>
<tr>
	<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
	<td class='singlebutton'><a title='Back' href='../events.php'>Back to Events</a></td>
	<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
</tr>
</table>
<br/>
</div>


<div id="contentcol2">
<span class="lefthandpic"><img src="../images/side.jpg" alt="London Dinner Club" width="194" height="194" /></span>
</div>

<!-- end inner content -->

</div>
</div>
<div id="footer">
<div class="footer2col1"><a href="terms.php">TERMS</a>&nbsp;|&nbsp;<a href="sitemap.php">SITE MAP</a>&nbsp;|&nbsp;<a href="admin/">ADMINISTRATOR</a></div></div>
<div id="footer2">
<span style='float:left;'>
<a href='http://www.facebook.com/group.php?gid=115974205088756'><img src='../images/Facebook_Badge.gif' border='0' alt='Find us on Facebook' /></a>
</span>
<div class="footer2col2">Copyright &copy;&nbsp;London Dinner Club&nbsp;2010</div>
<div class="footer2col2">designed by: <a href="http://www.streeten.co.uk" target='_blank'>streeten</a></div>
<div class="footer2col2">redeveloped by: <a href="http://www.sbcommunications.co.uk" target='_blank'>S B Communications Ltd.</a></div></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
</div>
</body>
</html>