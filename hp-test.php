<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="The website of London Dinner Club - an exclusive Private Members Club, connecting single professionals through stylish dinner parties and cocktail parties. Held in Knightsbridge, Mayfair and Chelsea" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/carousel.css" type="text/css"/>
    
    <!--[if lt IE 9]>  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <!-- Icons -->
    <link rel="icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114.png" type="text/css"/>
    
     <!--JS -->
     <script type="text/javascript" src="js/retina.js"></script>
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     
     <script type="text/javascript" src="js/jcarousel.simple.js"></script>
     <script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
     
     <script type="text/javascript" src="js/jquery.scrollUp.min.js"></script>
     <script type="text/javascript" src="js/jquery.easing.min.js"></script>

</head>

<body id="home">
	<div class="white-border">
    </div>
    
    <div class="container">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="home";?>
   			<?php include('navigation.php');?>
        	
         
         	<h1 class="big-header-home center">Connecting People</h1>
            <h2 class="medium-header center">By creating an elegant environment, we feel that this provides the right setting to connect professionals.</h2>
            <a href="register.php" target="_self" title="Email London Dinner Club" class="button-signup"><span class="displace"></span></a>
       </header>
    	
       
       <!-- Content-->
       <h3 id="home-slogan" class="medium-header center">London Dinner Club connects professionals through upmarket networking drinks and dinners<br/>held mainly in Knightsbridge, Chelsea and Mayfair</h3>
       
        <!-- Upcoming Event -->
        <div class="event-wrapper">
            <?php
            include_once('database/databaseconnect.php');
            
            $query = "SELECT * FROM Events WHERE Date >= CURDATE() ORDER BY Date ASC LIMIT 1";
            $result = mysql_query($query) or die(mysql_error());
            if(mysql_num_rows($result) != 3)
            {
                $row = mysql_fetch_array($result);
                $eid = $row['ID'];
                $venue = $row['Venue'];?>
                <div class="img">
                    <!--<a href="new-events.php#<?php echo $venue;?>" title="<?php echo $row['Event_Title'];?>" target="_self"><img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Event_Title'];?>" width="300" height="209" border='0' /></a>-->
                    <a href="new-events.php#<?php echo $venue;?>" title="<?php echo $venue;?>" target="_self"><img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $venue;?>" width="300" height="209" border='0' /></a>
                    
                    <span class="box-calender">
                    <span class="box-date"><?php echo date('d', strtotime($row['Date']));?></span>
                    <span class="box-month"><?php echo date('M', strtotime($row['Date']));?></span>
                    </span>
                </div>
                
                <div class="description">
                
                <!--<h3 class="little-header uppercase"><a href="new-events.php#<?php echo $venue;?>" title="<?php echo $row['Event_Title'];?>" target="_self"><?php echo $row['Event_Title'];?></a></h3>-->
                <h3 class="little-header uppercase"><a href="new-events.php#<?php echo $venue;?>" title="<?php echo $venue;?>" target="_self"><?php echo $venue;?></a></h3>
                    <div class="details">
                        <p><?php echo $row['Description'];?></p>
                            <ul class="bullets fl">
                                <li><span class="bold">Type:</span><?php echo $row['Event_Type'];?></li>
                                <li><span class="bold">Date:</span><?php echo date('dS F Y', strtotime($row['Date']));?></li>
                                <li><span class="bold">Time:</span><?php echo $row['Time'];?> hrs</li>
                                <li><span class="bold">Price:</span>&pound;<?php echo $row['Price'];?> Per Person</li>
                            </ul>
                            <dl class="bullets fl">
                              <dt class="bold">Location</dt>
                              <dd><?php echo $venue;?></dd>
                              <dd><?php echo $row['Address_Street'];?></dd>
                              <dd><?php echo $row['Address_Town'];?></dd>
                              <dd><?php echo $row['Address_City'];?></dd>
                              <dd><?php echo $row['Address_PostCode'];?></dd>
                            </dl>
                    </div>
                    <div class="event-buttons fr">
                        <a href="member/?eid=<?php echo $eid;?>" title="Book Tickets For This Event" class="button-tickets"><span class="displace"></span></a>
                        <div class="availablity-wrapper relative">
                            <p class="title">Availability</p>
                            <p class="availability"><?php echo $row['Availability'];?></p>
                        </div>
                    </div>
                </div>
            <?php
            }?>
            <div class="clear"></div>
            <div class="line2" style="background:#f2f2f2;"></div>
            
       </div>
  
  
      <div class="box-280-margin fl">
        	<h3 class="little-header free-icon">Free to register</h3>
            <p>No joining or membership fees. Simply join and once approved you’ll have access to our exclusive networking events.</p>
       </div>
        
       <div class="box-280-margin fl">
        	<h3 class="little-header man-icon">Exclusive Networking</h3>
            <p>Meet like-minded professionals in upmarket bars and restaurants in London.</p>
       </div>
        
       <div class="box-280 fl">
        	<h3 class="little-header location-icon">Upmarket Locations</h3>
            <p>Socialising and networking mainly in Knightsbridge, Chelsea and Mayfair.</p>
       </div>
        
        
       <div class="clear"></div>
       <div class="spacebreak"></div>
       
            
  		<div class="carousel-wrapper">
        <h4 class="little-header uppercase">Past Events</h4>
        <div class="line2"></div>
            <div data-jcarousel="true" data-wrap="circular" class="carousel">
                <ul>
                <?php 	
                $query = "SELECT * FROM Events WHERE Date < CURDATE() ORDER BY Date DESC";
                $result = mysql_query($query) or die(mysql_error());
                if(mysql_num_rows($result)!=0)
                {
                    while($row = mysql_fetch_array($result))
                    {
                        $venue = $row['Venue'];?>
                        <li>
                        <!--<a href="past-events.php#<?php echo $venue;?>" title="<?php echo $row['Event_Title'];?>" >-->
                        <a href="past-events.php#<?php echo $venue;?>" title="<?php echo $venue;?>" >
                        <!--<img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Event_Title'];?>" width="220" height="150" border='0' />-->
                        <img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $venue;?>" width="220" height="150" border='0' />
                        <p class="center"><?php echo $row['Event_Type'] . ' at ' . $venue;?><br><span><?php echo date('dS F Y', strtotime($row['Date']));?></span></p></a>
                        </li>
                    <?php
                    }
                }?>
                </ul>
            </div>
            <a data-jcarousel-control="true" data-target="-=1" href="#" class="carousel-control-prev">&lsaquo;</a>
            <a data-jcarousel-control="true" data-target="+=1" href="#" class="carousel-control-next">&rsaquo;</a>
        </div><!-- carousel -->  
        
        
        <h4 class="little-header uppercase">In The Press</h4>
        <div class="line2"></div>  
        
        <a href="press-media.php" title="" target="_self"><div class="box-196 fl fc-logo"></div></a>
        <a href="press-media.php" title="" target="_self"><div class="box-196 fl msn-logo"></div></a>
        <a href="press-media.php" title="" target="_self"><div class="box-196 fl city-logo"></div></a>
        <a href="press-media.php" title="" target="_self"><div class="box-196 fl resident-logo"></div></a>
        <a href="press-media.php" title="" target="_self"><div class="box-196 fl chronicle-logo"></div></a>
        
        <div class="clear"></div>      
        <div class="spacebreak"></div>
    </div>
    <?php include('footer.php');?>
</body>
</html>