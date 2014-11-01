<?php include 'database/databaseconnect.php';?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Past Events | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="Information on previous events held by London Dinner Club" />
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
     
     <script type="text/javascript" src="js/jquery.scrollUp.min.js"></script>
     <script type="text/javascript" src="js/jquery.easing.min.js"></script>

</head>

<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container" style="min-height:820px;">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="old-events";?>
   			<?php include('navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
       <h1 class="medium-header uppercase">Past Events</h1>
       <div class="line2"></div>
       <?php 	
        $query = "SELECT * FROM Events WHERE Date < CURDATE() ORDER BY Date DESC";
        $result = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($result)!=0)
        {
            while($row = mysql_fetch_array($result))
            {?>
               <!-- Event box-->   
               <div class="event-wrapper bg-white">
                    <div class="img">
                        <!--<img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Event_Title'];?>" width='300' height='209' border='0' />-->
                        <img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $venue;?>" width='300' height='209' border='0' />
                    </div>
                
                    <div class="description">
                
                        <h3 class="little-header uppercase"><?php echo $row['Venue'];?></h3>
                            <div class="details">
                                <p><?php echo htmlspecialchars($row['Description']);?></p>
                                    <ul class="bullets fl">
                                        <li><span class="bold">Type:</span><?php echo $row['Event_Type'];?></li>
                                        <li><span class="bold">Date:</span><?php echo date('dS F Y', strtotime($row['Date']));?></li>
                                        <li><span class="bold">Time:</span><?php echo $row['Time'];?> hrs</li>
                                        <li><span class="bold">Price:</span>&pound;<?php echo $row['Price'];?> Per Person</li>
                                    </ul>
                                    <dl class="bullets fl">
                                      <dt class="bold">Location</dt>
                                      <dd><?php echo $row['Venue'];?></dd>
                                      <dd><?php echo $row['Address_Street'];?></dd>
                                      <dd><?php 
                                      if ('' != $row['Address_Town']) {
                                        echo $row['Address_Town'] . ', ';
                                      }
                                      echo $row['Address_City'];?></dd>
                                      <dd><?php echo $row['Address_PostCode'];?></dd>
                                    </dl>
                            </div>
                            
                            <div class="event-buttons fr">
                               
                                <div class="expired-wrapper relative">
                                    <p class="title">Event has </p>
                                    <p class="availability">Expired</p>
                                </div>
                            </div>
                        </div>
                        
                    <div class="clear"></div>  
               </div>
               
               <div class="line"></div>
            <?php
            }
        }?>
          
      
       <div class="spacebreak"></div>   
    </div>
 
   
    <?php include('footer.php');?>
   
</body>

</html>