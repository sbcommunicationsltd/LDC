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
       
       <h1 class="medium-header uppercase">Gold Membership</h1>
       <div class="line2"></div>
       <?php
		if(isset($_POST['Submit']))
		{
			$errors = array();
			
			if ($_POST['Forename'] == $_POST['Surname']) {
				$errors[] = "Please enter valid data";
			}

			if($_POST['Date_Day']=="" || $_POST['Date_Month']=="" || $_POST['Date_Year']=="")
			{
				$_POST['DOB'] == "";
			}
			elseif(!checkdate($_POST['Date_Month'], $_POST['Date_Day'], $_POST['Date_Year']))
			{
				$errors[] = "The Date is not valid";
			}
			else
			{
				while(strlen($_POST['Date_Day'])==1)
				{
					$_POST['Date_Day'] = "0" . $_POST['Date_Day'];
				}
				while(strlen($_POST['Date_Month'])==1)
				{
					$_POST['Date_Month'] = "0" . $_POST['Date_Month'];
				}
				$_POST['DOB'] = $_POST['Date_Day'] . '/' . $_POST['Date_Month'] . '/' . $_POST['Date_Year'];
			}

			if(!filter_input(INPUT_POST, 'EmailAddress', FILTER_VALIDATE_EMAIL))
			{
				$errors[] = "E-Mail Address is not valid";
			}
			if($_POST['EmailAddress'] != $_POST['ConEmailAddress'])
			{
				$errors[] = "The email addresses you confirmed with are not the same.";
			}
			else
			{
				$email = $_POST['EmailAddress'];
				$qu = "SELECT * FROM Members WHERE EmailAddress = '$email'";
				$re = mysql_query($qu) or die(mysql_error());
				if(mysql_num_rows($re) == 1)
				{
					$errors[] = "The email address provided has already been used to register for Membership.";
				}
			}
			
			if(!filter_input(INPUT_POST, 'Interests', FILTER_SANITIZE_STRING))
			{
				$errors[] = "Please enter proper information for the Interests";
			}

			$sPattern = '/\s*/m';
			$sReplace = '';
			
			if(stripos($_POST['Interests'], '[/url]') !== false || stripos($_POST['Interests'], 'http') !== false)
			{
				$errors[] = "Please enter proper information for the Interests without links";
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
			
			$fields = array('Forename', 'Surname', 'Gender', 'Status', 'EmailAddress', 'ConEmailAddress', 'Height', 'Religion', 'DOB', 'Profession', 'Mobile', 'HeardFrom', 'Interests', 'Achieve', 'Image_Path');

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
				$to = 'info@londondinnerclub.org';
				//$to = 'sumita.biswas@gmail.com';
				$subject = 'Membership Form Submission for London Dinner Club';
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
					echo '<p><b>Thank You!</b></p><p>We will contact you within 48hrs to discuss your membership application.</p>';
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
       		<div class="fl box-326">
               <p class="bold">Membership is £59.99 for 6 months </p>
               <p><strong>Benefits include:</strong><br>Silver membership plus: Exclusive events held at Private Members Clubs such as Home House<br>
<br>Dinner parties at Michelin star restaurants in London such as Nobu, Hakkasan and Benares<br><br>Benefits and discounts from elite shops in Knightsbridge and Mayfair, spas and hotels</p>
               
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
            		<label for="gender">Gender: <span class="asterisk">*</span></label>
            		
                     <div class="dropdown">
                      <select class="dropdown-select" name="Gender" id="gender"  >
                        <option value="">Please Select:</option>
                        <option value="Male" <?php if(isset($_POST['Gender']) && $_POST['Gender'] == 'Male'){echo "selected='selected'";}?>>Male</option>
                        <option value="Female" <?php if(isset($_POST['Gender']) && $_POST['Gender'] == 'Female'){echo "selected='selected'";}?>>Female</option>
                      </select>
                    </div>
                 </div>
                 <div class="box-260-form fr">
            		<label for="status">Status: <span class="asterisk">*</span></label>
            		
                     <div class="dropdown">
                      <select class="dropdown-select" name="Status" id="status" >
                        <option value="">Please Select:</option>
                        <option value="Single" <?php if(isset($_POST['Status']) && $_POST['Status'] == 'Single'){echo "selected='selected'";}?>>Single</option>
                        <option value="Divorced" <?php if(isset($_POST['Status']) && $_POST['Status'] == 'Divorced'){echo "selected='selected'";}?>>Divorced</option>
                        <option value="Separated" <?php if(isset($_POST['Status']) && $_POST['Status'] == 'Separated'){echo "selected='selected'";}?>>Separated</option>
                      </select>
                    </div>
                 </div>
                 
                 <div class="box-260-form fl">
            		<label for="height">Height: <span class="asterisk">*</span></label>
            		<div class="dropdown">
                      <select class="dropdown-select" name="Height" id="height">
                        <option value="">Please Select:</option>
                        <?php
                        $proarr = array('4ft 11in', '4ft 12in', '5ft', '5ft 1in', '5ft 2in', '5ft 3in', '5ft 4in', '5ft 5in', '5ft 6in', '5ft 7in', '5ft 8in', '5ft 9in', '5ft 10in', '5ft 11in', '6ft' , '6ft 1in', '6ft 2in', '6ft 3in', '6ft 4in', '6ft 5in', '6ft 6in', '6ft 7in');
                        foreach($proarr as $pro)
                        {
                            echo "<option value='$pro'"; if(isset($_POST['Height']) && $_POST['Height'] == $pro){echo "selected='selected'";} echo ">$pro</option>";
                        }?>
                      </select>
                    </div>
                 </div>
                 <div class="box-260-form fr">
            		<label for="Religion">Religion: <span class="asterisk">*</span></label>
            		<div class="dropdown">
                      <select class="dropdown-select" name="Religion" id="religion">
                        <option value="">Please Select:</option>
                        <?php
                        $proarr = array('Hindu', 'Sikh', 'Muslim', 'Christian', 'Jewish', 'Spiritual - Not religious', 'No religion', 'Other');
                        foreach($proarr as $pro)
                        {
                            echo "<option value='$pro'"; if(isset($_POST['Religion']) && $_POST['Religion'] == $pro){echo "selected='selected'";} echo ">$pro</option>";
                        }?>
                      </select>
                    </div>
                 </div>    
                 
                 <div class="box-260-form fl">
            		<label for="dob">D.O.B: <span class="asterisk">*</span></label>
                    <div class="dropdown-container">
                    <div class="dropdown2">
                      <select name="Date_Day" class="dropdown-select" id="dobname">
                <option value=''>Day:</option>
                <?php 	for($days=1 ; $days<=31 ; $days++)
						{
							echo "<option value=\"$days\""; if(isset($_POST['Date_Day']) && $_POST['Date_Day'] == $days){echo "selected='selected'";} echo ">"; if(strlen($days)==1){echo "0";} echo "$days</option>";
						}
				?>
              </select>
                      </div>
                      
                      <div class="dropdown2">
                          <select name="Date_Month" class="dropdown-select" id="dobmonth">
                <option value=''>Month:</option>
                <?php 	$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                		for($month=1 ; $month<=12 ; $month++)
						{
							$word = $month-1;
							echo "<option value=\"$month\"";  if(isset($_POST['Date_Month']) && $_POST['Date_Month'] == $month){echo "selected='selected'";} echo ">$months[$word]</option>";
						}
				?>
              </select>
                      </div>
                      
                       <div class="dropdown2">
                          <select name="Date_Year" class="dropdown-select" id="dobyear" >
                <option value=''>Year:</option>
                <?php	//$startyear = date("Y")-51;
                        $startyear = 1950;
						$endyear = date("Y")-24;
						for($year=$startyear; $year<=$endyear; $year++)
						{
							echo "<option value=\"$year\""; if(isset($_POST['Date_Year']) && $_POST['Date_Year'] == $year){echo "selected='selected'";} echo ">$year</option>";
						}
				?>
              </select>
                      </div>
                      
                      </div>
                 </div>
                 <div class="box-260-form fr">
            		<label for="profession">Profession: <span class="asterisk">*</span></label>
            	
                     <div class="dropdown">
                      <select class="dropdown-select" name="Profession" id="profession">
                        <option value="">Please Select:</option>
                        <?php
                        $proarr = array('Not Specified', 'Academic', 'Accounting', 'Admin / Secretarial', 'Arts / Media', 'CEO', 'Company Director', 'Construction / Property Services', 'Consultant', 'Designer', 'Doctor / Medical', 'Executive', 'Entrepreneur', 'Financial Services / Insurance', 'Hospitality / Catering', 'Human Resources', 'IT / Computing', 'Legal', 'Leisure / Tourism', 'Managing Director', 'Military', 'Own Business', 'Political / Government', 'Property Developer', 'Real Estate', 'Sales and Marketing', 'Science / Technical', 'Teaching / Education', 'Writer / Journalist', 'Other');
                        foreach($proarr as $pro)
                        {
                            echo "<option value='$pro'"; if(isset($_POST['Profession']) && $_POST['Profession'] == $pro){echo "selected='selected'";} echo ">$pro</option>";
                        }?>
                      </select>
                    </div>
                 </div>
                 
                
                 <div class="box-260-form fl">
            		<label for="email">Email: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="EmailAddress" id="email" value="<?php if(isset($_POST['EmailAddress'])) {echo $_POST['EmailAddress'];}?>" />
                 </div>
                 <div class="box-260-form fr">
            		<label for="confirm-email">Confirm Email: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="ConEmailAddress" id="confirm-email" value="<?php if(isset($_POST['ConEmailAddress'])) {echo $_POST['ConEmailAddress'];}?>" />
                 </div>
                 
                 <div class="clear"></div>
                 
                 <div class="box-260-form">
            		<label for="mobile">Mobile Number: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="Mobile" id="mobile" value="<?php if(isset($_POST['Mobile'])) {echo $_POST['Mobile'];}?>" />
                 </div>
                 
                 <div class="box-260-form fl">
            		<label for="hear">How did you hear about us? <span class="asterisk">*</span></label>
            		
                     <div class="dropdown">
                      <select class="dropdown-select" name="HeardFrom" id="hear" >
                       <option value="">Select</option>
                        <?php 
                $heardarr = array("Google", "Friend", "A Small World", "Magazine", "Newspaper", "Decayenne", "Linked In", "Financial World", "City AM", "Daily Mail", "Telegraph");
                sort($heardarr);
                foreach ($heardarr as $heard) {
                    echo "<option value='$heard'"; if (isset($_POST['HeardFrom']) && $_POST['HeardFrom'] == $heard) {echo "selected='selected'";} echo ">$heard</option>";
                }?>
                      </select>
                    </div>
                 </div>
                 <div class="box-260-form fr">
            		<label for="achieve">What do you hope to achieve? <span class="asterisk">*</span></label>
                   
                    <div class="dropdown">
                      <select class="dropdown-select" name="Achieve" id="achieve">
                        <option value="">Please Select</option>
                          <option value="Socialising" <?php if(isset($_POST['Achieve']) && $_POST['Achieve'] == 'Socialising'){echo "selected='selected'";}?>>Socialising</option>
                          <option value="Networking" <?php if(isset($_POST['Achieve']) && $_POST['Achieve'] == 'Networking'){echo "selected='selected'";}?>>Networking</option>
		                  <option value="Friendship" <?php if(isset($_POST['Achieve']) && $_POST['Achieve'] == 'Friendship'){echo "selected='selected'";}?>>Friendship</option>
						  <option value="Relationship" <?php if(isset($_POST['Achieve']) && $_POST['Achieve'] == 'Relationship'){echo "selected='selected'";}?>>Serious Relationship</option>
                      </select>
                    </div>
            		
                 </div>
                 
                 <div class="clear"></div>
                 
                 <div class="box-510-form2">
            		<label for="interests">What are your interests? <span class="asterisk">*</span></label>
            		<textarea class="form-box" type="text" name="Interests" id="interests" /><?php if(isset($_POST['Interests'])) {echo $_POST['Interests'];}?></textarea>
                 </div>
                 
                 <div class="clear"></div>
                 
                 <div class="box-326 fl">
                     <p class="terms"><span class="bold">Upload Photo</span><br/>
                     Please note that your photo and all details will remain confidential. <span class="bold">Max Image Size: 2MB</span></p>
                 </div>
                 <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                 <input type='file' name='uploadedfile' class="button-upload fr" /><span class="displace"></span>
                 <div class="clear"></div>
                 <div class="line"></div>
                 
                 <input type='submit' name="Submit" value='' class="button-submit fr" /><span class="displace"></span>
                 <div class="clear"></div>
            </fieldset>
       		</form>
            <?php
            }?>
            
       <div class="clear"></div>  
       <div class="spacebreak"></div>   
       
      
    </div>
 
   
    <?php include('footer.php');?>
   
</body>
</html>