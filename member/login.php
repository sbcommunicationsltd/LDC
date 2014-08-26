<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Member Login | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="Information on new and upcoming events by London Dinner Club" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="../css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/forms.css" type="text/css"/>
    
    <!--[if lt IE 9]>  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <!-- Icons -->
    <link rel="icon" href="../images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114.png" type="text/css"/>
    
     <!--JS -->
     <script type="text/javascript" src="../js/retina.js"></script>
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     
     <script type="text/javascript" src="../js/jquery.scrollUp.min.js"></script>
     <script type="text/javascript" src="../js/jquery.easing.min.js"></script>

</head>

<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container" style="min-height:820px;">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="new-events";?>
   			<?php include('../navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
		<h1 class="medium-header uppercase center">
		<?php 
		if (!isset($_GET['type'])) {
			echo 'Silver';
		} else {
			echo 'Gold';
		}?>	Member's Login</h1>
       <div class="line2"></div>
       <div class="spacebreak"></div>

<?php
session_start();
include '../database/databaseconnect.php';

$eid = $_GET['eid'];
$errorMessage = '';
if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) {

   $userId = $_POST['txtUserId'];
   $password = $_POST['txtPassword'];

   // check if the user id and password combination exist in database
   if (!isset($_GET['type'])) {
	    $sql = "SELECT *
			    FROM tbl_auth_user
			    WHERE member_id = '$userId'
					AND user_pass = '$password'";
	} else {
		$todaydate = date('Y-m-d');
		$sql = "SELECT * 
				FROM Gold_Members 
				WHERE EmailAddress = '$userId' 
					AND Approved = 'Yes' AND DateExpire > '$todaydate'";
	}

    $result = mysql_query($sql)
				or die('Query failed. ' . mysql_error());
	
	$continue = 0;
    if (mysql_num_rows($result) == 1) {
		if (isset($_GET['type'])) {
			$sqlcheck = "SELECT *
						FROM tbl_auth_user
						WHERE member_id = 'gold'
							AND user_pass = '$password'";
			
			$resultcheck = mysql_query($sqlcheck)
				or die('Query check failed. ' . mysql_error());

			if (mysql_num_rows($resultcheck) == 1) {
				$_SESSION['goldmem_is_logged_in'] = true;
				$url = '../member/?type=gold&eid=' . $eid;
				$continue = 1;
			}
		} else {
			// the user id and password match,
			// set the session
			$_SESSION['member_is_logged_in'] = true;
			$url = '../member/?eid=' . $eid;
			$continue = 1;
		}
	}
	
	if (1 == $continue) {
		// after login we move to the main page
		header("Location: $url");
		exit;
	} else {
		$errorMessage = 'Sorry, wrong user id / password';
	}
}

if ($errorMessage != '') {?>
<p align="center" style='color:#990000; font-weight:bold;'><?php echo $errorMessage; ?></p>
<?php
}?>
<form class="form-container" action="" method="post" style="margin:auto;" name='frmLogin'>
	<a name="contact" id="contact"></a>
    <fieldset>
    <div class="box-260-form" style="margin:auto;">
        <label for="firstname">Username: </label>
        <input class="form-field" type="text" name="txtUserId" id="name" />
    </div>
     
    <div class="box-260-form" style="margin:auto;">
        <label for="firstname">Password: </label>
        <input class="form-field" type="password" name="txtPassword" id="password" />
    </div>
     
    <div class="box-260-form" style="margin:auto;">
        <div class="line2"></div>
        <a href="javascript:document.frmLogin.submit();" target="_self" title="Sign in to London Dinner Club" class="button-login"><span class="displace"></span></a>
        <p class="terms center"><a href="/" title="Back to homepage">Return to Homepage</a></p>
    </div>        
</fieldset>
</form>
<p><br/></p>
<div class="clear"></div>
<div class="spacebreak"></div>   
    </div>
 
    <?php include('../footer.php');?>
   
</body>
</html>