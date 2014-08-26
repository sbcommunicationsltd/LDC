<?php session_start();
include '../database/databaseconnect.php';

if(!isset($_SESSION['admin_is_logged_in'])){
	header('Location: login.php');
}

$emailsil = "location.href='emailmembers.php?type=Silver';";
if(!isset($_SESSION['admin2_is_logged_in'])){
	$emailsil = "location.href='confirm.php';";
}

$emailgold = "location.href='emailmembers.php?type=Gold';";
if(!isset($_SESSION['admin2_is_logged_in'])){
	$emailgold = "location.href='confirm.php';";
}
?>
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
    <link rel="stylesheet" media="screen" href="../css/styles.css" type="text/css" />
    <link rel="stylesheet" media="screen" href="../css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/forms.css" type="text/css"/>
        
    <!--[if lt IE 9]>  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <!-- Icons -->
    <link rel="icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114.png" type="text/css"/>
    
     <!--JS -->
     <script type="text/javascript" src="../js/retina.js"></script>
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     
     <script type="text/javascript" src="../js/jquery.scrollUp.min.js"></script>
     <script type="text/javascript" src="../js/jquery.easing.min.js"></script>
<style type="text/css">
<!--
.style1 {color: #FF0000}

.adminbutton
{
	font-size:16px;
	background-color:#99CCFF;
	cursor:pointer;
	height:40px;
	width:60px;
	font-weight:normal;
	font-style:italic;
}
-->
</style>
</head>

<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="";?>
   			<?php include('../navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
           <h1 class="medium-header uppercase center">Admin Area</h1>
           <div class="line2"></div>
           
           <div class="spacebreak"></div>

	<h1><img src="../images/welcome.gif" alt="welcome" width="181" height="50"/></h1>
<table width='80%' align='center' cellspacing='2' cellpadding='2' border='0' style='border:2px #99CCFF double; border-width:6px;'>
<tr>
	<th width='50%'><span onclick="location.href='membershipdatabase.php?type=Silver';"><input type='submit' name='memberssilver' value='' class='adminbutton' /><br/><br/><span class='adminbutton'>Silver Members Database</span></span></th>
	<th width='50%'><span onclick="location.href='membershipdatabase.php?type=Gold';"><input type='submit' name='membersgold' value='' class='adminbutton' /><br/><br/><span class='adminbutton'>Gold Members Database</span></span></th>
</tr>
<tr>
	<td colspan='2'>&nbsp;</td>
</tr>
<tr>
	<th width='50%'><span onclick="<?php echo $emailsil;?>"><input type='submit' name='emailmemberssilver' value='' class='adminbutton' /><br/><br/><span class='adminbutton'>Email Silver Members</span></span></th>
	<th width='50%'><span onclick="<?php echo $emailgold;?>"><input type='submit' name='emailmembersgold' value='' class='adminbutton' /><br/><br/><span class='adminbutton'>Email Gold Members</span></span></th>
</tr>
<tr>
	<td colspan='2'>&nbsp;</td>
</tr>
<tr>
	<th width='50%'><span onclick="location.href='eventsdatabase.php';"><input type='submit' name='events' value='' class='adminbutton' /><br/><br/><span class='adminbutton'>Event Management</span></span></th>
	<th width='50%'><span onclick="location.href='pressdatabase.php';"><input type='submit' name='press' value='' class='adminbutton' /><br/><br/><span class='adminbutton'>Press Releases Database</span></span></th>
</tr>
</table>
<p>&nbsp;</p>

<div class="clear"></div>
       <div class="spacebreak"></div>
    </div>
    
   
    <?php include('../footer.php');?>
   
</body>

</html>