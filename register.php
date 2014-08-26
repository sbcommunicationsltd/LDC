<?php 
session_start(); 
include 'database/databaseconnect.php';?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Membership | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="Register with London Dinner Club for free and stay up to date with all the latest events" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/forms.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/dropdown.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/styles.css" type="text/css"/>
    
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

	<style>
    
    .box475{
		width:400px;
		height:650px;
		text-align:center;
		background:#fcfcfc;
		border-radius:5px;	
		padding:20px 40px;
		position:relative;
	}
	
	.membership-icon{
		margin:50px auto;
			
	}
	
	.button-silvermembership{
		border: none;
		padding: 0;
		width:250px;
		height: 51px;
		text-indent: 10000px;
		overflow: hidden;
		display: block;
		font-size: 0px;
		cursor: pointer;
		background: url("images/button-silvermembership.png") top left no-repeat;
		margin:25px auto;
		
		position:absolute;
		bottom:10px;
		left:110px;
	}
	.button-goldmembership{
		border: none;
		padding: 0;
		width:250px;
		height: 51px;
		text-indent: 10000px;
		overflow: hidden;
		display: block;
		font-size: 0px;
		cursor: pointer;
		background: url("images/button-goldmembership.png") top left no-repeat;
		margin:25px auto;
		
		position:absolute;
		bottom:10px;
		left:110px;
	}
	
	.button-silvermembership:hover,.button-goldmembership:hover{
	background-position:bottom left;	
	}
    </style>
</head>

<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container relative">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="register";?>
   			<?php include('navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
       <h2 class="medium-header">London Dinner Club offers two levels of membership, a Silver Membership and a Gold Membership</h2>
       <div class="line2"></div>
       
       <div class="box475 fl">
       		<img src="images/membership1.png" alt="Silver membership" class="membership-icon" />
            
            <h3 class="little-header uppercase">Silver membership</h3>
            <div class="line" style="width:300px;margin:20px auto;"></div>
            <p>This is a FREE membership</p>
			<p><strong>Benefits include:</strong><br>Dinner parties in Knightsbridge and Mayfair including restaurants such as Budhha Bar and Harvey Nichols</p>
    		<p>Drinks/cocktail evenings at Baku Lounge Bar and No 5 Cavendish</p>

			<a href="register-silver.php" target="_self" title="Silver membership London Dinner Club" class="button-silvermembership"><span class="displace"></span></a>

       </div>
       
       <div class="box475 fr">
       	    <img src="images/membership2.png" alt="Gold membership" class="membership-icon" />
            <h3 class="little-header uppercase">Gold membership</h3>
            <div class="line" style="width:300px;margin:20px auto;"></div>
            <p>Membership is £59.99 for 6 months <br><u>(only £10 per month)</u></p>
			<p><strong>Benefits include:</strong><br>Silver membership plus: Exclusive events held at Private Members Clubs such as Home House</p>
    		<p>Dinner parties at Michelin star restaurants in London such as Nobu, Hakkasan and Benares</p>
            <p>Benefits and discounts from elite shops in Knightsbridge and Mayfair, spas and hotels</p>
            
            <a href="register-gold.php" target="_self" title="Gold membership London Dinner Club" class="button-goldmembership"><span class="displace"></span></a>
       </div>
            
       <div class="clear"></div>  
       <div class="spacebreak"></div>   
       
      
    </div>
 
   
    <?php include('footer.php');?>
   
</body>
</html>