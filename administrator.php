<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Administrator | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="London Dinner Club - Admin" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/forms.css" type="text/css"/>
        
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
        	<?php $menu="";?>
   			<?php include('navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
           <h1 class="medium-header uppercase center">Administrator Log In</h1>
           <div class="line2"></div>
           
           <div class="spacebreak"></div>
           
          <form class="form-container" action="" method="post" style="margin:auto;">
			<a name="contact" id="contact"></a>
            
			<fieldset>
            	<div class="box-260-form" style="margin:auto;">
            		<label for="firstname">Username: </label>
            		<input class="form-field" type="text" name="name" id="name" />
                </div>
                 
                <div class="box-260-form" style="margin:auto;">
            		<label for="firstname">Password: </label>
            		<input class="form-field" type="text" name="password" id="password" />
                </div>
                 
                <div class="box-260-form" style="margin:auto;">
                	<div class="line2"></div>
                    <a href="#" target="_self" title="Sign in to London Dinner Club" class="button-login"><span class="displace"></span></a>
                    <p class="terms center"><a href="/" title="Back to homepage">Return to Homepage</a></p>
                </div>
                   
           </fieldset>
           
           
           
       <div class="clear"></div>
       <div class="spacebreak"></div>
    </div>
    
   
    <?php include('footer.php');?>
   
</body>

</html>
