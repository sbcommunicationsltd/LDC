<?php include 'database/databaseconnect.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: past events ::  London Dinner Club</title>
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
<div id="logo"><a href="http://www.londondinnerclub.org/" target="_self"><img src="images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.londondinnerclub.org/" target="_self">HOME</a></li>
<li class="topnav" ><a href="aboutus.php" target="_self">ABOUT<br/>US</a></li>
<li><a href="events.php" target="_self">CURRENT<br/>EVENTS</a></li>
<li><a class="active" href="past_events.php" target="_self">PAST<br/>EVENTS</a></li>
<li><a href="membership.php" target="_self">MEMBERSHIP</a></li>
<li><a href="asiandinnerclub.php" target="_self">ASIAN<br/>DINNER CLUB</a></li>
<li><a href="press.php" target="_self">PRESS</a></li>
<li><a href="team.php" target="_self">THE</br>TEAM</a></li>
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

		<h1><img src="images/past_events.gif" alt="Past Events" width="210" height="50"/></h1>

     	<?php 	$query = "SELECT * FROM Events WHERE Date < CURDATE() ORDER BY Date ASC";
     			$result = mysql_query($query) or die(mysql_error());
     			if(mysql_num_rows($result)!=0)
     			{
     				while($row = mysql_fetch_array($result))
     				{?>
                       <div>
                         <p><span class="righthandpic"><a name="<?php echo $row['Venue'];?>" id="<?php echo $row['Venue'];?>"></a><img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Venue'];?>" width="188" height="168" border='0' /></span></p>
                         <table width="390" height="112" border="0" cellpadding="0" cellspacing="0">
                           <tr>
                             <th width="88" align='left'>Venue:</th>
                             <td width="10">&nbsp;</td>
                             <th width="252" align='left'><?php echo $row['Venue'];?></th>
                           </tr>
                           <tr>
						                                <td>&nbsp;</td>
						                                <td>&nbsp;</td>
						                                <td>&nbsp;</td>
                           </tr>
                           <tr>
							<th width="88" align='left'>Event Type:</th>
							<td width="10">&nbsp;</td>
							<td><?php echo $row['Event_Type'];?></th>
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
                           <?php if($row['Address_Town'] != '')
                           {?>
                           <tr>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td><?php echo $row['Address_Town'];?></td>
                           </tr>
                           <?php }
                           if($row['Address_City'] != '')
                           {?>
                           <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><?php echo $row['Address_City'];?></td>
                           </tr>
                           <?php } ?>
                           <tr>
							 <td>&nbsp;</td>
							 <td>&nbsp;</td>
							 <td><?php echo $row['Address_PostCode'];?></td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <?php 	if(stristr($row['Address_PostCode'], ' '))
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
                             <th align='left'>Price:</th>
                             <td>&nbsp;</td>
                             <td>&pound;<?php echo $row['Price'];?> per person </td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                           </tr>
                         </table>
                       </div>
                       <p><hr></p>
                   <?php } }?>
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
<span style='float:left;'>
<a href='http://www.facebook.com/group.php?gid=115974205088756'><img src='images/Facebook_Badge.gif' border='0' alt='Find us on Facebook' /></a>
</span>
<div class="footer2col2">Copyright &copy;&nbsp;London Dinner Club&nbsp;2010</div>
<div class="footer2col2">designed by: <a href="http://www.streeten.co.uk" target='_blank'>streeten</a></div>
<div class="footer2col2">redeveloped by: <a href="http://www.sbcommunications.co.uk" target='_blank'>S B Communications Ltd.</a></div></div>
</div>
</body>
</html>
