<?php 
include 'database/databaseconnect.php'; 
if(isset($_GET['success']))
{?>
	<script>alert('You have successfully paid for your Membership. Please wait for the approval email.');
	location.href='../';
	</script>
<?php
}
elseif(isset($_GET['cancel']))
{?>
	<script>alert('You have cancelled the payment for Membership. Please contact sales@londondinnerclub.org when you wish to pay.');
	location.href='../';
	</script>
<?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: home ::  London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club. Singles events london, singles event, dating events, speed dating, match.com, datingdirect.com, dating in london, online dating, dating tips, salima manji, asian dinner club, supperclub, vogue, luxury events, luxe events" />
</head>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-4965994-3");
pageTracker._trackPageview();
} catch(err) {}</script>
<body>
<div id="wrapper">
<div id="header">
<div id='social'><img src="images/sociallink.png" /><a href="https://twitter.com/#!/LdnDinnerClub" target="_blank" title="Tweet Us"><img src="images/twitter.png" border='0' alt='Tweet Us' /></a><a href="https://www.facebook.com/group.php?gid=115974205088756" target="_blank" title="Find us on Facebook"><img src="images/facebook.png" border='0' alt='Find us on Facebook' /></a></div>
<div id="logo"><a href="http://www.londondinnerclub.org/" target="_self" border='0'><img src="images/londondinnerclub.png" alt="London Dinner Club" border='0' /></a></div>
<div id="navigation">
<ul>
<li><a class="active" href="http://www.londondinnerclub.org/" target="_self">HOME</a></li>
<li class="topnav" ><a href="aboutus.php" target="_self">ABOUT<br/>US</a></li>
<li><a href="events.php" target="_self">CURRENT<br/>EVENTS</a></li>
<li><a href="past_events.php" target="_self">PAST<br/>EVENTS</a></li>
<li><a href="membership.php" target="_self">MEMBERSHIP</a></li>
<li><a href="asiandinnerclub.php" target="_self">ASIAN<br/>DINNER CLUB</a></li>
<li><a href="press.php" target="_self">PRESS</a></li>
<li><a href="team.php" target="_self">THE<br/>TEAM</a></li>
<li><a href="contact.php" target="_self">CONTACT</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->


<div id="contentcol1">


	<h1><img src="images/welcome.gif" alt="welcome" width="181" height="50"/></h1>
	 <!--<p><b>The London Dinner Club</b> is a private dining club bringing like-minded, single professionals in London together over food and wine in some of London's more upmarket restaurants and bars such as Morton's and Home House.</p>
    <p>We provide an excellent environment for our members to relax, socialise and network over informal dinners and drinks parties - perfect for time poor individuals who are super choosy and sociable.</p>-->
  <p><b>London Dinner Club</b> is an exclusive Supper Club for those who enjoy relaxing and socialising over outstanding food in some of London's finest restaurants. Ideal for busy single professionals, it not only creates opportunities to meet other eligible singles but also presents luxurious settings at venues in Mayfair such as Mortons and China Tang.</p>
	<p>This Private Dining Club is perfect for time-poor individuals who a super choosy and sociable.</p>
	    <p>To join this unique Club, please go to <a style='text-decoration:none;' href="membership.php">Membership</a>. </p>
	    <p>NOTE: Each registration is vetted and you will be contacted by one of our <a style='text-decoration:none;' href="team.php">Team</a> if your application is successful.<br/>
  </p>
  <div>
    <table width='100%' class='table' style="border:1px solid #d0d3d5; background-color:transparent;" border="0" cellspacing="1" cellpadding="4" align='center'>
    	<tr>
        	<td colspan="6" class='title3' style='background-color:#EAC117;'>&nbsp;LATEST EVENTS</td>
      	</tr>
      	<tr>
        	<td class="title3">Date</td>
        	<td class="title3">Venue</td>
			<td class="title3">City</td>
        	<td class="title3">Age</td>
        	<td class="title3">Event Type</td>
        	<td class="title3">Availability</td>
      	</tr>

      	<?php	$query = "SELECT * FROM Events WHERE Date >= CURDATE() ORDER BY Date ASC";
      			$result = mysql_query($query) or die(mysql_error());
      			if(mysql_num_rows($result) != 0)
      			{
      				$counter = 0;
      				while($row = mysql_fetch_array($result))
      				{
      					$counter++;
						$background_color = ( $counter % 2 == 0 ) ? ('#e9e9e9') : ('#ffffff');
						$venue = addslashes($row['Venue']);
						$date = date('D, d M', strtotime($row['Date']));?>
						<a href='events.php#<?php echo $venue;?>'>
	  					<tr class='table' bgcolor="<?php echo $background_color;?>" onmouseover="this.className='table tablehover'" onmouseout="this.className='table'" onclick="location.href='events.php#<?php echo $venue;?>';">
        					<td style='white-space: nowrap;'><?php echo $date;?></td>
        					<td><?php echo $venue;?></td>
							<td><?php echo $row['City'];?></td>
        					<td style='white-space: nowrap;'><?php echo $row['Age'];?></td>
        					<td><?php echo $row['Event_Type'];?></td>
        					<td><?php echo $row['Availability'];?></td>
      					</tr>
      					</a>
      					<?php
      				}
      			}
      	?>
    </table>
  </div>
</div>

<div id="contentcol2">
  <span class="lefthandpic"><img src="images/side.jpg" alt="London Dinner Club" width="194" height="194" /></span>
  <?php
  	 $find = "SELECT MAX(ID) FROM LoveItems";
  	 $res = mysql_query($find) or die(mysql_error());
  	 $ro = mysql_fetch_array($res);
  	 $maxid = $ro[0];
  	 if($maxid<10)
  	 {
  		$firstid = 0;
  	 }
  	 else
  	 {
  		$firstid = $maxid - 10;
  	 }

  	 $query2 = "SELECT * FROM LoveItems LIMIT $firstid, 10";
  	 $result2 = mysql_query($query2) or die(mysql_error());
  	 ?>
  	 <span class='lefthandpic'>
  	 <br/>
  	 &nbsp;<img src="images/ldclovessmall.png" alt="London Dinner Club Loves" width="190" />
  	 &nbsp;<marquee behaviour='scroll' direction='up' scrollamount='1' width='180' style='border:1px solid #EAC117;'>
  	 <?php
  	 $i = 1;
  	 while($row2 = mysql_fetch_array($result2))
  	 {
  			$id = $row2['ID'];
  			$title = $row2['Title'];
  			if(strpos($title, "\'")!==false)
			{
				$title = str_replace("\'", "'", $title);
			}

			if(strpos($title, '\"')!==false)
			{
				$title = str_replace('\"', '"', $title);
			}?>
  			&nbsp;<a href='member/loveposts.php?id=<?php echo $id;?>' style='color:white; text-decoration:none; font-size:11px;' onmouseover="this.style.color='#EAC117';" onmouseout="this.style.color='#FFFFFF';"><?php echo $i . '. ' . $title;?></a><br/><br/>
  	 <?php
  			$i++;
  	 }?>
  	 </marquee>
	 <br/>
  	 &nbsp;<a href='member/loveposts.php' style='color:white; text-decoration:none; font-size:11px;' onmouseover="this.style.color='#EAC117';" onmouseout="this.style.color='#FFFFFF';">See all posts</a>
	 </span>
</div>


<!-- end inner content -->

</div>
</div>
<div id="footer">
<div class="footer2col1"><a href="terms.php">TERMS</a>&nbsp;|&nbsp;<a href="sitemap.php">SITE MAP</a>&nbsp;|&nbsp;<a href="admin/">ADMINISTRATOR</a></div></div>
<div id="footer2">
<!--<span style='float:left;'>
<a href='http://www.facebook.com/group.php?gid=115974205088756'><img src='images/Facebook_Badge.gif' border='0' alt='Find us on Facebook' /></a>
</span>-->
<div class="footer2col2">Copyright &copy;&nbsp;London Dinner Club&nbsp;2010</div>
<div class="footer2col2">designed by: <a href="http://www.streeten.co.uk" target='_blank'>streeten</a></div>
<div class="footer2col2">redeveloped by: <a href="http://www.sbcommunications.co.uk" target='_blank'>S B Communications Ltd.</a></div></div>
</div>
</div>
</body>
</html>
