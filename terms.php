<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: terms :: London Dinner Club</title>
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

		<h1><img src="images/terms.gif" alt="Terms" width="181" height="50"/></h1>
        <p><strong>Exchange and Refund Policy</strong></p>
        <p>All ticket purchases are non-refundable. On occasion, London Dinner Club may refund or offer an exchange to a customer post investigation into a specific refund request. As such, there can be no order cancellations made. </p>
        <p><strong>Prices</strong></p>
        <p>The price for each product is shown on londondinnerclub.org in UK Sterling and includes VAT (where applicable) at 17.5%. We reserve the right at any time to revise prices to account for any increases in costs including the increase or imposition of any duty, tax, levy or exchange rate variation. We will take all reasonable steps to notify you of any relevant revision of prices before processing your order. </p>
        <p><strong>Delivery charges</strong></p>
        <p>There are no such delivery charges as all ticket purchases are based on an eTicket system. Please bring your payment confirmation email to the event as your ticket.</p>
        <p><strong> Registered office</strong></p>
        <p>42 Mendora Road, <br>London SW6 7NB</p>
        <p><strong> Company Number: 8370160</strong></p>
        <p>London Dinner Club is a sub-division of City Networking Events Limited.</p>
        <p>&nbsp;</p>
    </div>

    <div id="contentcol2">
    <span class="lefthandpic"><img src="images/side.jpg" alt="Asian Dinner Club" width="194" height="194" /></span>
        <?php
        include('database/databaseconnect.php');
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

        $query = "SELECT * FROM LoveItems LIMIT $firstid, 10";
        $result = mysql_query($query) or die(mysql_error());?>
        <span class='lefthandpic'>
        <br/>
        &nbsp;<img src="images/ldclovessmall.png" alt="London Dinner Club Loves" width="190" />
        &nbsp;<marquee behaviour='scroll' direction='up' scrollamount='1' width='180' style='border:1px solid #EAC117;'>
        <?php
        $i = 1;
        while($row = mysql_fetch_array($result))
        {
            $id = $row['ID'];
            $title = $row['Title'];
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
<div class="footer2col1"><a href="terms.php" class='active'>TERMS</a>&nbsp;|&nbsp;<a href="sitemap.php">SITE MAP</a>&nbsp;|&nbsp;<a href="admin/">ADMINISTRATOR</a></div></div>
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