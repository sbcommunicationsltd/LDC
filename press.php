<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: press ::  London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-52364856-1', 'auto');
    ga('send', 'pageview');
</script>
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="logo"><a href="http://www.londondinnerclub.org/" target="_self"><img src="images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.londondinnerclub.org/" target="_self">HOME</a></li>
<li class="topnav" ><a href="aboutus.php" target="_self">ABOUT<br/>US</a></li>
<li><a href="events.php" target="_self">CURRENT<br/>EVENTS</a></li>
<li><a href="past_events.php" target="_self">PAST<br/>EVENTS</a></li>
<li><a href="membership.php" target="_self">MEMBERSHIP</a></li>
<li><a class="active" href="press.php" target="_self">PRESS</a></li>
<li><a href="team.php" target="_self">THE<br/>TEAM</a></li>
<li><a href="contact.php" target="_self">CONTACT</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->
	<div id="contentcol1">

		<h1><img src="images/press.gif" alt="Press Releases" width="89" height="50"/></h1>
        <?php
        include 'database/databaseconnect.php';
        if(!isset($_GET['id']))
        {?>
            <table width='100%' cellspacing='2' cellpadding='2' border='0'>
            <?php
            $query = "SELECT * FROM Press ORDER BY Date DESC";
            $result = mysql_query($query) or die(mysql_error());
            while($row = mysql_fetch_array($result))
            {
                $gid = $row['ID'];?>
                <tr>
                    <td style='color:#EAC117;'><?php $date = date('d.m.Y', strtotime($row['Date'])); echo $date;?></td>
                </tr>
                <tr>
                    <th align='left' style='color:#0000A0;' class='fontstyle3'><a href="?id=<?php echo $gid;?>" class='go'><?php echo $row['Title'];?></a></th>
                </tr>
                <tr>
                    <td style='color:#0000A0;' class='fontstyle4'><?php echo $row['Summary'];?></td>
                </tr>
                <tr>
                    <td><a href="?id=<?php echo $gid;?>" class='go fontstyle4'>READ MORE <img src='images/marker-right2.gif' alt='read more' height='8' width='8' border='0' /></a><span style='float:right;'><img src="images/<?php echo $row['Image_Path'];?>" border='0' height='65' /></span></td>
                </tr>
                <tr height='50'>
                    <td>&nbsp;</td>
                </tr>
            <?php
            }?>
            </table>
        <?php
        }
        else
        {
            $id = $_GET['id'];
            $query2 = "SELECT * FROM Press WHERE ID = '$id'";
            $result2 = mysql_query($query2) or die(mysql_error());
            $row2 = mysql_fetch_array($result2);?>
            <table width='100%' cellspacing='2' cellpadding='2' border='0'>
            <tr>
                <td style='color:#EAC117;'><?php $date = date('d.m.Y', strtotime($row2['Date'])); echo $date;?><span style='float:right;'><img src="images/<?php echo $row2['Image_Path'];?>" border='0' height='150' /></span></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th align='left' style='color:#0000A0;'><?php echo $row2['Title'];?></th>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style='color:#0000A0;'><?php echo $row2['Article'];?></td>
            </tr>
            <?php

            if($row2['Hyperlink'] != '')
            {?>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align='left'>To read the full article, please go to <br/><a href="<?php echo $row2['Hyperlink'];?>" target='_blank' border='0' style='color:blue;' onmouseover="this.style.color='#EAC117';" onmouseout="this.style.color='blue';"><?php echo $row2['Hyperlink'];?></td>
            </tr>
            <?php
            }?>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table cellspacing='0' cellpadding='0' border='0'>
                        <tr>
                            <td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
                            <td class='singlebutton'><a title="Back" name='back' href="press.php">Back</a></td>
                            <td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
        <?php
        }?>

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
	    <div><div></div></div>
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

        $query3 = "SELECT * FROM LoveItems LIMIT $firstid, 10";
        $result3 = mysql_query($query3) or die(mysql_error());?>
        <span class='lefthandpic'>
        <br/>
        &nbsp;<img src="images/ldclovessmall.png" alt="London Dinner Club Loves" width="190" />
        &nbsp;<marquee behaviour='scroll' direction='up' scrollamount='1' width='180' style='border:1px solid #EAC117;'>
        <?php
        $i = 1;
        while($row3 = mysql_fetch_array($result3))
        {
  			$id = $row3['ID'];
  			$title = $row3['Title'];
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