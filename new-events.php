<?php include 'database/databaseconnect.php';
session_start();?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>New & Upcoming Events | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="Information on new and upcoming events by London Dinner Club" />
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
    
    <div class="container" style="min-height: 730px;">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="new-events";?>
   			<?php include('navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
       <h1 class="medium-header uppercase">New / Upcoming Events</h1>
       <div class="line2"></div>
       
       <?php
        //EITHER THANKS OR CANCELLED TICKETS
        if(isset($_GET['ven']))
        {
            $eventid = $_GET['ven'];
            $findeve = "SELECT * FROM Events WHERE ID = $eventid";
            $reseve = mysql_query($findeve) or die(mysql_error());
            $roweve = mysql_fetch_array($reseve);
            $ticket = addslashes($roweve['Venue']) . ' on ' . date('jS F Y', strtotime($roweve['Date']));
            
            if(isset($_GET['success']))
            {
                $quantity = $_GET['success'];?>
                <script>alert('Thanks for buying <?php echo $quantity;?> ticket(s) for <?php echo $ticket;?>. Please print email receipt to ensure entry to the event. Please feel free to choose any other event aswell.');</script>
            <?php
                /*$gender = $_GET['success'];
                $stat = '';
                if($gender == 'f')
                {
                    $femalequantity = $roweve['MaxFemaleQuantity'] - 1;
                    if($femalequantity <= 5 && $femalequantity > 0)
                    {
                        $to = 'sales@londondinnerclub.org';
                        $subject = "Female Tickets Alert - $ticket";
                        $body = "This is an auto alert letter you know that the number of Female Tickets for $ticket has reached 5 or less!\r\n";
                        $body .= "\r\nPlease keep checking on the events database to see the ticket status.\r\n";
                        $body .= "\r\nThanks\n Auto Service\n London Dinner Club\r\n";
                        $headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
                        mail($to, $subject, $body, $headers);
                    }

                    if($femalequantity == 0)
                    {
                        $to = 'sales@londondinnerclub.org';
                        $subject = "Female Tickets Alert - $ticket";
                        $body = "This is an auto alert letter you know that the Female Tickets for $ticket has SOLD OUT!\r\n";
                        $body .= "\r\nPlease change the ticket status on the events database asap.\r\n";
                        $body .= "\r\nThanks\n Auto Service\n London Dinner Club\r\n";
                        $headers .= "From: Asian Dinner Club <sales@londondinnerclub.org> \r\n";
                        mail($to, $subject, $body, $headers);
                        
                        if($roweve['MaxMaleQuantity'] == 0)
                        {
                            $stat = 'Event Sold Out';
                        }
                        else
                        {
                            $stat = 'Female Tickets Sold Out';
                        }
                    }
                        
                    $qu = "UPDATE Events SET MaxFemaleQuantity = '$femalequantity'";
                    if($stat != '')
                    {
                        $qu .= ", Availability = '$stat'";
                    }
                    $qu .= " WHERE ID = $eventid";
                    mysql_query($qu) or die(mysql_error());
                }
                else
                {
                    $malequantity = $roweve['MaxMaleQuantity'] - 1;
                    if($malequantity <= 5 && $malequantity > 0)
                    {
                        $to = 'sales@londondinnerclub.org';
                        $subject = "Male Tickets Alert - $ticket";
                        $body = "This is an auto alert letter you know that the number of Male Tickets for $ticket has reached 5 or less!\r\n";
                        $body .= "\r\nPlease keep checking on the events database to see the ticket status.\r\n";
                        $body .= "\r\nThanks\n Auto Service\n London Dinner Club\r\n";
                        $headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
                        mail($to, $subject, $body, $headers);
                    }

                    if($malequantity == 0)
                    {
                        $to = 'sales@londondinnerclub.org';
                        $subject = "Male Tickets Alert - $ticket";
                        $body = "This is an auto alert letter you know that the Male Tickets for $ticket has SOLD OUT!\r\n";
                        $body .= "\r\nPlease change the ticket status on the events database asap.\r\n";
                        $body .= "\r\nThanks\n Auto Service\n London Dinner Club\r\n";
                        $headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
                        mail($to, $subject, $body, $headers);
                        
                        if($roweve['MaxFemaleQuantity'] == 0)
                        {
                            $stat = 'Event Sold Out';
                        }
                        else
                        {
                            $stat = 'Male Tickets Sold Out';
                        }
                    }
                    
                    $qu = "UPDATE Events SET MaxMaleQuantity = '$malequantity'";
                    if($stat != '')
                    {
                        $qu .= ", Availability = '$stat'";
                    }
                    $qu .= " WHERE ID = $eventid";
                    mysql_query($qu) or die(mysql_error());
                }*/
                ?>
                <script>location.href='new-events.php';</script>
            <?php
            }

            if(isset($_GET['cancel']))
            {
                $quantity = $_GET['cancel'];?>
                <script>
                alert("You have just cancelled <?php echo $quantity;?> ticket(s) for <?php echo $ticket;?>. Please feel free to choose any other event.");
                location.href='new-events.php';
                </script>
            <?php
            }
        }

        $query = "SELECT * FROM Events WHERE Date >= CURDATE() ORDER BY Date ASC";
        $result = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($result) != 0)
        {
            while($row = mysql_fetch_array($result))
            {
                $eid = $row['ID'];?>
               <!-- Event box-->   
               <div class="event-wrapper">
                    <div class="img">
                        <!--<a href="member/?eid=<?php echo $eid;?>" title="<?php echo $row['Event_Title'];?>" target="_self"><img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Event_Title'];?>" width='300' height='209' border='0' /></a>-->
                        <a href="member/?eid=<?php echo $eid;?>" title="<?php echo $row['Venue'];?>" target="_self"><img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Venue'];?>" width='300' height='209' border='0' /></a>
                        
                    <span class="box-calender">
                    <span class="box-date"><?php echo date('d', strtotime($row['Date']));?></span>
                    <span class="box-month"><?php echo date('M', strtotime($row['Date']));?></span>
                    </span>
                    
                    </div>
                
                    <div class="description">
                
                        <!--<h3 class="little-header uppercase"><?php echo $row['Event_Title'];?></h3>-->
                        <h3 class="little-header uppercase"><?php echo $row['Venue'];?></h3>
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
                                      <dd><?php echo $row['Venue'];?></dd>
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
                        
                    <div class="clear"></div>  
               </div>
               
               <div class="line"></div>
            <?php
            }
        }?>  
       </div>
       
      
       <div class="spacebreak"></div>   
    </div>
 
   
    <?php include('footer.php');?>
   
</body>

</html>