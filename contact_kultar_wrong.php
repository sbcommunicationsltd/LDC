<?php 
session_start(); 
include 'database/databaseconnect.php';?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Contact | London Dinner Club | Connecting People | London</title>
    
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


</head>

<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container relative">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="contact";?>
   			<?php include('navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
       <h1 class="medium-header uppercase">Contact</h1>
       <div class="line2"></div>
       <?php
		if(isset($_POST['Submit']))
		{
			$errors = array();
			
			if ($_POST['Forename'] == $_POST['Surname']) {
				$errors[] = "Please enter valid Name";
			}

			

			if(!filter_input(INPUT_POST, 'EmailAddress', FILTER_VALIDATE_EMAIL))
			{
				$errors[] = "E-Mail Address is not valid";
			}
			
			
			
			if(!filter_input(INPUT_POST, 'Interests', FILTER_SANITIZE_STRING))
			{
				$errors[] = "Please enter proper information for Message";
			}
            
          
			$sPattern = '/\s*/m';
			$sReplace = '';
			
			if(stripos($_POST['Interests'], '[/url]') !== false || stripos($_POST['Interests'], 'http') !== false)
			{
				$errors[] = "Please enter proper information for Message without links";
			}
            
        
			
			$_POST['Interests'] = str_replace("\r\n", ', ', $_POST['Interests']);
			//$_POST['Interests'] = preg_replace( $sPattern, $sReplace, $_POST['Interests'] );
			$_POST['Mobile'] = preg_replace( $sPattern, $sReplace, $_POST['Mobile'] );
			$_POST['Mobile'] = trim($_POST['Mobile']);
			if(!is_numeric($_POST['Mobile']))
			{
				$errors[] = "The mobile number must be numeric!";
			}
			
			$target_path = 'member/images/';

			$filename = basename($_FILES['uploadedfile']['name']);
			
			$query = "SELECT MAX(ID) FROM Members";
			$result = mysql_query($query) or die(mysql_error());
			if(mysql_num_rows($result) == 0)
			{
				$idmax = 1;
			}
			else
			{
				$row = mysql_fetch_array($result);
				$idmax = $row[0] + 1;
			}

			if($filename != '')
			{
				function getExtension($str)
				{
					$i = strrpos($str,".");
					if (!$i) { return ""; }
					$l = strlen($str) - $i;
					$ext = substr($str,$i+1,$l);
					return $ext;
				}

				$extension = getExtension($filename);
				$extension = strtolower($extension);

				$imagefile = $idmax . '.' . $extension;
				$target_path = $target_path . $imagefile;
				//echo $target_path;
				//echo 'SIZE' . $_FILES['uploadedfile']['size'];


				/*if($_POST['MAX_FILE_SIZE'] < $_FILES['uploadedfile']['size'])
				{
					$errors[] = "The file size is too big for the server. Please reduce the size!";
				}*/

				if(!($extension == "jpg" || $extension == "gif" || $extension == "jpeg"))
				{
					$errors[] = "Your uploaded file must be JPG or GIF. Other file types are not allowed";
				}

				/*if(!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
				{
					$errors[] = "There was an error uploading the file.";
				}*/
				
				list($width, $height) = getimagesize($_FILES['uploadedfile']['tmp_name']) ;
				if($width > 360)
				{
					$modwidth = 360;
					$diff = $width / $modwidth;

					$modheight = $height / $diff;
					$tn = imagecreatetruecolor($modwidth, $modheight) ;
					if($extension == 'jpg' || $extension == 'jpeg')
					{
						$image = imagecreatefromjpeg($_FILES['uploadedfile']['tmp_name']);
						imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
						imagejpeg($tn, $_FILES['uploadedfile']['tmp_name'], 100);
					}
					else
					{
						$image = imagecreatefromgif($_FILES['uploadedfile']['tmp_name']);
						imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
						imagegif($tn, $_FILES['uploadedfile']['tmp_name'], 100);
					}
				}
				
				if (!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
				{
					switch ($_FILES['uploadedfile']['error'])
					{  
						case 1:
						$errors[] = 'The file is bigger than this PHP installation allows';
						break;
						case 2:
						$errors[] = 'The file is bigger than this form allows';
						break;
						case 3:
						$errors[] = 'Only part of the file was uploaded';
						break;
						case 4:
						$errors[] = 'No file was uploaded';
						break;
					}
				}
				
				$_POST['Image_Path'] = $imagefile;
			}
			else
			{
				$_POST['Image_Path'] = '';
			}
			
			/*if(md5($_POST['Captcha_Code']) != $_SESSION['key']) 
			{ 
				$errors[] = "You must enter the code correctly"; 
			}*/
			
			$fields = array('Forename', 'Surname', 'EmailAddress','Mobile', 'Interests');

			foreach($fields as $field)
			{
				if($field!='Image_Path')
				{
					$formvar = $_POST[$field];
					if($formvar == '')
					{
						$errors[] = "You forgot to enter the '$field'";
					}
				}
			}

			if(empty($errors))
			{
				$fields = array_diff($fields, array('ConEmailAddress'));
				$date = date('Y-m-d H:i');
				$query2 = "INSERT INTO Members (ID, " . implode(', ', $fields) . ", DateJoined, Approved) VALUES ('$idmax', ";
				//$to = 'info@asiandinnerclub.com, lovesalima@googlemail.com';
				$to = 'lovesalima@gmail.com, sumita.biswas@gmail.com';
				//$to = 'ksruprai@hotmail.co.uk';
				$subject = 'Contact Form From London Dinner Club';
				$body = '';
				foreach($fields as $field)
				{
					$formvar = $_POST[$field];
					//if($field!='ConEmailAddress' && $field!='Captcha_Code')
					if($field!='ConEmailAddress')
					{
						$formvar = addslashes($formvar);
						$query2 .= "'$formvar', ";
					}
					$formvar2 = $formvar;
					if(strpos($formvar2, "\'")!==false)
					{
						$formvar2 = str_replace("\'", "'", $formvar2);
					}
					if(strpos($formvar2, '\"')!==false)
					{
						$formvar2 = str_replace('\"', '"', $formvar2);
					}
					//if($field!='ConEmailAddress' && $field!='Captcha_Code')
					if($field!='ConEmailAddress')
					{
						$body .= "\n$field: $formvar2 \n";
					}
				}
				$query2 .= "'$date', 'No')";
				$headers = "From: London Dinner Club <sales@londondinnerclub.org> \r\n";
				if(mail($to, $subject, $body, $headers))
				{
					echo '<p><b>Thank You!</b></p><p>We will contact you shortly to about your enquiry.</p>';
					$result2 = mysql_query($query2) or die(mysql_error());
		                    //echo 'QUERY: ' . $query2;
				}
				else
				{
					$errormess = '<p><b>System Error</b></p><p>A system error has occurred. We apologise for the inconvenience. Please try again soon.</p>';
				}
			}
			else
			{ // Report the errors.
				foreach($fields as $field)
				{
					if(strpos($_POST[$field], "\'")!==false)
					{
						$_POST[$field] = str_replace("\'", "'", $_POST[$field]);
					}
					if(strpos($_POST[$field], '\"')!==false)
					{
						$_POST[$field] = str_replace('\"', '"', $_POST[$field]);
					}
				}
				
				unlink('member/images/' . $imagefile);
				$errormess = '<p><b>Error</b></p>
					<p>The following error(s) occurred:<br />';
					foreach ($errors as $msg) { // Print each error.
						$errormess .= " - $msg<br />\n";
					}
					$errormess .= '</p><p>Please try again.</p><p><br /></p>';
			} // End of if (empty($errors)) IF.
		}
		
        if(!isset($_POST['Submit']) || isset($errormess))
        {?>
       		<div class="fl box-326 contact">
               <p>If you have any enquiries please feel free to contact us via the contact form, and a member of the team will contact you back as soon as possible.</p>
               <p>Alternatively you can contact us directly by the details below:</p>
               <p><span class="bold">Email: </span><a href="mailto:info@londondinnerclub.org" target="_blank">info@londondinnerclub.org</a></p>
               
                    <a href="https://www.facebook.com/pages/London-Dinner-Club/233376956703832" rel="nofollow" target="_blank" title="Follow London Dinner Club on Facebook" class="footer-icon facebook fl"><span class="displace"></span></a>
                    <a href="https://twitter.com/#!/LdnDinnerClub" rel="nofollow" target="_blank" title="Follow London Dinner Club on twitter" class="footer-icon twitter fl"><span class="displace"></span></a>
                    <a href="http://uk.linkedin.com.pub/salima-manji/4/6a1/3a0" rel="nofollow" target="_blank" title="Follow London Dinner Club on linkedin" class="footer-icon linkedin fl"><span class="displace"></span></a>
                    <div class="clear"></div>
               
               <?php 
               if (isset($errormess)) {?>
                   <div class="errorbox">
                        <?php echo $errormess;?>
                   </div>
                <?php
                }?>
               
      		</div>
            <form class="form-container fr" action="" method="post" name='membership' enctype="multipart/form-data">
			
			<fieldset>
            	<div class="box-260-form fl">
            		<label for="firstname">First Name: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="Forename" id="firstname" value="<?php if(isset($_POST['Forename'])) {echo $_POST['Forename'];}?>" />
                 </div>
                 <div class="box-260-form fr">
            		<label for="surname">Surname: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="Surname" id="surname" value="<?php if(isset($_POST['Surname'])) {echo $_POST['Surname'];}?>" />
                 </div>
                 
                 <div class="box-260-form fl">
            		<label for="email">Email: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="EmailAddress" id="email" value="<?php if(isset($_POST['EmailAddress'])) {echo $_POST['EmailAddress'];}?>" />
                 </div>
                 <div class="box-260-form fr">
            		<label for="mobile">Mobile Number: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="Mobile" id="mobile" value="<?php if(isset($_POST['Mobile'])) {echo $_POST['Mobile'];}?>" />
                 </div>
                 
                 
                 <div class="clear"></div>
                 
                 <div class="box-510-form2">
            		<label for="interests">Message<span class="asterisk">*</span></label>
            		<textarea class="form-box" type="text" name="Interests" id="interests" /><?php if(isset($_POST['Interests'])) {echo $_POST['Interests'];}?></textarea>
                 </div>
                 
                 <div class="clear"></div>
                 
                
                 <div class="line"></div>
                 
                 <input type='submit' name="Submit" value='' class="button-submit fr" /><span class="displace"></span>
                 <div class="clear"></div>
            </fieldset>
       		</form>
            <?php
            }?>
            
        <div class="clear"></div> 
       <div class="line"></div>
        <div class="spacebreak"></div>   
       <h3 class="medium-header center">Sign up to London Dinner Club for free to stay up to date on all the latest networking events in the Knightsbridge, Chelsea and Mayfair area!</h3>
       <p class="center"><a href="register.php" target="_blank" title="Email London Dinner Club" class="button-signup"><span class="displace"></span></a></p>
       
       <div class="spacebreak"></div>    
       
      
    </div>
 
   
    <?php include('footer.php');?>
   
</body>
</html>