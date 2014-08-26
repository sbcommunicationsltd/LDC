<?php session_start();
include '../database/databaseconnect.php';
$eid = $_GET['eid'];

if (isset($_GET['type'])) {
	if(!isset($_SESSION['goldmem_is_logged_in'])){
		header('Location: login.php?type=gold&eid=' . $eid);
	}
} else {
	if(!isset($_SESSION['member_is_logged_in'])){
		header('Location: login.php?eid=' . $eid);
	}
}?>
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
        <?php
		if (!isset($_GET['type'])) {?>
			<h1 class="medium-header uppercase">Silver Members Booking</h1>
		<?php
		} else {?>
			<h1 class="medium-header uppercase">Gold Members Booking</h1>
		<?php
		}?>
       <div class="line"></div>
       
		<p>You can book for any number of events, but please specify if you are MALE or FEMALE as there are limited spaces available for men and women at each event. <span class="bold">Book now to avoid disappointment!</span></p>
		<p>&nbsp;</p>
<?php
$query = "SELECT * FROM Events WHERE ID = $eid";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);?>
<p><span class="righthandpic fl"><a name="<?php echo $row['Venue'];?>" id="<?php echo $row['Venue'];?>"></a><img src="../images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Venue'];?>" width="300" height="209" /></span></p>
<table width='600' border='0' cellpadding='0' cellspacing='0' class="fr">
	<tr>
	  <th align='left' width='120'>Venue:</th>
	  <th align='left'><?php echo $row['Venue'];?></th>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Address:</th>
	  <td><?php echo $row['Address_Street'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><?php echo $row['Address_Town'] . ' ' . $row['Address_City'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><?php echo $row['Address_PostCode'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <?php if(stristr($row['Address_PostCode'], ' '))
			{
				$post = str_replace(' ', '+', $row['Address_PostCode']);
			}
			else
			{
				$post = $row['Address_PostCode'];
			}?>
	  <td><a  href="http://maps.google.co.uk/maps?f=q&hl=en&geocode=&q=<?php echo $post;?>" target="_blank">View on Google Maps</a></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Date:</th>
	  <?php $date = date('jS F Y', strtotime($row['Date']));?>
	  <td><?php echo $date;?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Time:</th>
	  <td><?php echo $row['Time'];?> hrs</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>

	<tr>
		<th align='left' valign='top' >Price:</th>
		<td>&pound;<?php echo $row['Price'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Event Type:</td>
	  <td><?php echo $row['Event_Type'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th align='left'>Member Type:</td>
	  <td><?php echo $row['Member_Type'];?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <th valign="top" align='left'>Description:</th>
	  <td valign="top"><?php echo $row['Description'];?></td>
	</tr>
	<tr>
		<td colspan='2'>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align='left'>
		<?php
		$venue = $row['Venue'];
		if (!isset($_GET['type'])) {
			$item = $venue . ' - Silver';
		} else {
			$item = $venue . ' - Gold';
		}
		$amount = $row['Price'];

		$datepart = explode('-', $row['Date']);
		$date2 = $datepart[2] . $datepart[1] . $datepart[0];
		$url = $_SERVER['REQUEST_URI'];?>
			<form action="redirecting.php" method="post" name='redirecting'>
			<input type='hidden' name='amount' value="<?php echo $amount;?>">
			<!--<input type='hidden' name='amount' value="0.01">-->
			<input type='hidden' name='item_name' value="<?php echo $item;?>">
			<input type='hidden' name='item_number' value="<?php echo $date2;?>">
			<input type='hidden' name='id' value="<?php echo $eid;?>">
			<?php
			if (!isset($_GET['type'])) {?>
				<input type='hidden' name='location' value='silver'>
			<?php
			} else {?>
				<input type='hidden' name='location' value='gold'>
			<?php
			}?>
			<table class="fl">
			<tr>
                <td><span class="bold">Gender:</span></td>
                <td><span class="bold">Quantity:</span></td>
            </tr>
            <tr>
                <td>
                    <select name="gender" id='gender' onChange="reload('gender', '<?php echo $url;?>');")>
                    <option value="Male" <?php if(isset($_GET['gen'])){if($_GET['gen'] == 'm'){echo "selected='selected'";}} if ($row['MaxMaleQuantity'] <= 0) {echo "disabled='disabled'";}?>>Male</option>
                    <option value="Female" <?php if(isset($_GET['gen'])){if($_GET['gen'] == 'f'){echo "selected='selected'";}} if ($row['MaxFemaleQuantity'] <= 0) {echo "disabled='disabled'";}?>>Female</option>
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
			<div class="event-buttons fr" style="height:80px">
                <a href="javascript:document.redirecting.submit();" title="Book Tickets For This Event" class="button-tickets"><span class="displace"></span></a>
               <!-- <div class="availablity-wrapper relative">
                    <p class="title">Availability</p>
                    <p class="availability"><?php echo $row['Availability'];?></p>
                </div>
            </div>-->
			<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
			</form>
		</td>
	</tr>
</table>
<div class="clear"></div>
</div>


<div class="spacebreak"></div>   
    </div>
 
   
    <?php include('../footer.php');?>
   
</body>

</html>