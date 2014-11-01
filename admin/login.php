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
    
    <div class="container">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="";?>
   			<?php include('../navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
           <h1 class="medium-header uppercase center">Administrator Log In</h1>
           <div class="line2"></div>
           
           <div class="spacebreak"></div>
           <?php
session_start();
include '../database/databaseconnect.php';
$errorMessage1 = 'Sorry, wrong user id / password';
$errorMessage2 = 'Sorry - you have been locked out.';
$errorMessage = '';
if(!isset($_SESSION['countlog']))
{
	$_SESSION['countlog'] = 0;
}

if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) {
	$userId = md5($_POST['txtUserId']);
   
	//Check if user is locked out
	$query = "SELECT status, reset FROM tbl_auth_user WHERE admin_id = '$userId'";
	$res = mysql_query($query) or die(mysql_error());
	$login = 0;
	if (0 != mysql_num_rows($res)) {
		$ro = mysql_fetch_array($res);
		if($ro[0] == 0)
		{
			$password = md5($_POST['txtPassword']);

			// check if the user id and password combination exist in database
			$sql = "SELECT *
					FROM tbl_auth_user
					WHERE admin_id = '$userId'
						AND user_pass = '$password'";

			$result = mysql_query($sql)
					or die('Query failed. ' . mysql_error());

			if (mysql_num_rows($result) == 1) {
				// the user id and password match,
				// set the session
				$_SESSION['admin_is_logged_in'] = true;

				// after login we move to the main page
				header('Location: ../admin/');
				exit;
			} 
			/*else 
			{
				$errorMessage = 'Sorry, wrong user id / password';
			}*/
			else
			{
				if($ro[1] == 1)
				{
					$_SESSION['countlog'] = 1;
					$sql3 = "SELECT * FROM tbl_auth_user WHERE admin_id = '$userId'";
					$result3 = mysql_query($sql3) or die(mysql_error());
					if(mysql_num_rows($result3) == 1)
					{
						$sql4 = "UPDATE tbl_auth_user SET reset = 0 WHERE admin_id = '$userId'";
						mysql_query($sql4) or die(mysql_error());
					}
				}
				else
				{
					$_SESSION['countlog']++;
				}
				//echo 'COUNT: ' . $countlog;
				if($_SESSION['countlog'] < 3)
				{
					$errorMessage = $errorMessage1;
				}
				else
				{
					$errorMessage = $errorMessage2;
					$sql2 = "SELECT * FROM tbl_auth_user WHERE admin_id = '$userId'";
					$result2 = mysql_query($sql2) or die(mysql_error());
					if(mysql_num_rows($result2) == 1)
					{
						$sql3 = "UPDATE tbl_auth_user SET status = 1 WHERE admin_id = '$userId'";
						mysql_query($sql3) or die(mysql_error());
					}
				}
			}
		}
		$login = 1;
	}
	
	if (0 == $login)
   	{
   		$errorMessage = $errorMessage2;
   	}

	mysql_close();
}
if ($errorMessage != '') {
?>
<p align="center" style='color:#990000; font-weight:bold;'><?php echo $errorMessage; ?></p>
<?php
}
?>
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
           
           
       <div class="clear"></div>
       <div class="spacebreak"></div>
    </div>
   
    <?php include('../footer.php');?>
   
</body>
</html>