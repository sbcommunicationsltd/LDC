<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Press & Media | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="Information on press and media by London Dinner Club" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="css/styles.css" type="text/css"/>
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
    
    <div class="container">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="press";?>
   			<?php include('navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
       <h1 class="medium-header uppercase">Press &amp; Media</h1>
       <div class="line2"></div>
        <?php 
        include 'database/databaseconnect.php';
        if(!isset($_GET['id']))
        {       
            $query = "SELECT * FROM Press ORDER BY Date DESC";
            $result = mysql_query($query) or die(mysql_error());
            if(mysql_num_rows($result)!=0)
            {
                while($row = mysql_fetch_array($result))
                {
                    $gid = $row['ID'];?>
                   <!-- Event box-->   
                   <div class="event-wrapper bg-white">
                        <div class="img">
                            <img src="images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Title'];?>" height='209' width='300' />
                        </div>
                    
                        <div class="description">
                            <h3 class="little-header uppercase"><?php echo $row['Title'];?></h3>
                            <p><span class="bold">Date:</span> <?php echo date('d F Y', strtotime($row['Date']));?></p>
                            <p><?php echo $row['Summary'];?></p>
                            <p><a href="?id=<?php echo $gid;?>" class='go fontstyle4'>READ MORE <img src='images/marker-right2.gif' alt='read more' height='8' width='8' border='0' /></a></p>
                        </div>
                        
                        <div class="clear"></div>  
                   </div>
                   <div class="line"></div>
                <?php
                }
            }
        }
        else
        {
            $id = $_GET['id'];
            $query2 = "SELECT * FROM Press WHERE ID = '$id'";
            $result2 = mysql_query($query2) or die(mysql_error());
            $row2 = mysql_fetch_array($result2);?>
            <div class="event-wrapper bg-white">
                <div class="img">
                    <img src="images/<?php echo $row2['Image_Path'];?>" alt="<?php echo $row2['Title'];?>" height='209' width='300' />
                </div>
            
                <div class="description">
                    <h3 class="little-header uppercase"><?php echo $row2['Title'];?></h3>
                    <p><span class="bold">Date:</span> <?php echo date('d F Y', strtotime($row2['Date']));?></p>
                </div>
                
                <div class='article'>
                    <p>&nbsp;</p>
                    <p><?php echo $row2['Article'];?></p>
                    <?php
                    if($row2['Hyperlink'] != '')
                    {?>
                        <p>To read the full article, please go to <br/><a href="<?php echo $row2['Hyperlink'];?>" target='_blank' border='0' style='color:blue;' onmouseover="this.style.color='#EAC117';" onmouseout="this.style.color='blue';"><?php echo $row2['Hyperlink'];?></a></p>
                    <?php
                    }?>
                    <p>&nbsp;</p>
                    <form method='post' name='back' action='press-media.php'>
                    <input type='hidden' name='back' />
                    <p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
                    <input type='submit' value='Back' class='singlebutton' />
                    <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
                    </p>
                    </form>
                </div>
                <div class="clear"></div>  
           </div>
        <?php
        }?>    
       <div class="spacebreak"></div>   
    </div>
 
   
    <?php include('footer.php');?>
   
</body>

</html>