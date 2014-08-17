<?php include '../database/databaseconnect.php';
//DELETE SECTION!
if(isset($_GET['delete']))
{
	$delid = $_GET['delete'];
	$query2 = "SELECT Forename, Surname, Image_Path FROM Members WHERE ID = '$delid'";
	$result2 = mysql_query($query2) or die(mysql_error());
	$row = mysql_fetch_array($result2);
	$fullname = "$row[0] $row[1]";
	$query3 = "DELETE FROM Members WHERE ID = $delid";
	$result3 = mysql_query($query3) or die(mysql_error());
    if(file_exists('../member/images/' . $row[2]))
	{
		unlink('../member/images/' . $row[2]);
	}?>
	<script>
	alert("Thanks - Member '<?php echo $fullname;?> Deleted!");
    location.href='membershipdatabase.php';
	</script>
	<?php
}
//DELETE SECTION ENDED

//AMEND MEMBER
if(isset($_POST['Submit']))
{
	$errors = array();
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

	$_POST['Interests'] = str_replace("\r\n", ', ', $_POST['Interests']);

	$sPattern = '/\s*/m';
	$sReplace = '';

	$_POST['Mobile'] = preg_replace( $sPattern, $sReplace, $_POST['Mobile'] );
	$_POST['Mobile'] = trim($_POST['Mobile']);
	if(!is_numeric($_POST['Mobile']))
	{
		$errors[] = "The mobile number must be numeric!";
	}

	$fields = array('Forename', 'Surname', 'Gender', 'Status', 'EmailAddress', 'DOB', 'Profession', 'Mobile', 'HeardFrom', 'Interests', 'Achieve');

	foreach($fields as $field)
	{
		$formvar = $_POST[$field];
		if($formvar == '')
		{
			$errors[] = "You forgot to enter the '$field'";
		}
	}

	if(empty($errors))
	{
		$id = $_POST['ID'];
		$first = $_POST['Forename'];
		$second = $_POST['Surname'];
		$name = "$first $second";
		$query5 = "UPDATE Members SET ";
		foreach($fields as $field)
		{
			$formvar = $_POST[$field];
			$formvar = addslashes($formvar);
			$query5 .= "$field = '$formvar', ";
		}
		$query5 = substr($query5, 0, -2) . " WHERE ID = '$id'";
		$result5 = mysql_query($query5) or die(mysql_error());
		?>
        <script>
        alert("Thanks - Member '<?php echo $name;?>' Details Amended!");
        location.href='membershipdatabase.php';
        </script>
		<?php
	}
}
//AMEND SECTION ENDED PART 1
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
    <link rel="stylesheet" media="screen" href="../css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/forms.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="../css/styles.css" type="text/css" />
        
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
     
     <!-- main content area -->
<style type="text/css">
<!--
.style1 {color: #FF0000}
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
           <p>&nbsp;</p>
            <h2 align='center'>Amend Member</h2>
<!-- AMEND SECTION PART 2 -->
<?php
if(isset($_POST['Submit']))
{
	if(!empty($errors))
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
		echo '<p><b>Error!</b></p>
			<p>The following error(s) occurred:<br />';
			foreach ($errors as $msg) { // Print each error.
				echo " - $msg<br />\n";
			}
			echo '</p><p>Please try again.</p><p><br /></p>';
	} // End of if (empty($errors)) IF.
}
//AMEND MEMBER END PART 2

if(isset($_GET['edit']))
{
	$editid = $_GET['edit'];
	$query4 = "SELECT * FROM Members WHERE ID = '$editid'";
	$result4 = mysql_query($query4) or die(mysql_error());
	$row3 = mysql_fetch_array($result4);
	$DOB = $row3['DOB'];
	$arrdate = split("/", $DOB);
	$dateday = $arrdate[0];
	$datemonth = $arrdate[1];
	$dateyear = $arrdate[2];
	$fore = $row3['Forename'];
	$sur = $row3['Surname'];
	$names = "$fore $sur";
	?>
    <form method='post' name='memberdatabase' action='membershipdatabase.php'>
	<input type='hidden' name='member' />
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
    <input type='submit' value='Back to Members Database' class='singlebutton' />
    <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
    </p>
  	</form><br/><br/>
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
	<input type='button' class='singlebutton' name='Delete' onclick="if(confirm('Are you sure you want to delete this contact: <?php echo $names;?>?')){location.href='?delete=<?php echo $editid;?>';}else{window.location.reload(false);}" value='Delete Member' />
	<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' /></p>
	<form method="post" id="profileform" name="ContactForm">
		       <div id="regformwrap">
			    <div class='rowwrap'>
				<div class="cell-1">(<span class="style1">*</span>All Fields are compulsory)</div>
				 </div>
		          <div class="rowwrap">
		            <div class="cell-2"  style="display:none;"  id="div_nicname">
					<input type='hidden' name='ID' value='<?php echo $editid;?>' />
		            </div>
	          </div>
	          <div class="rowwrap">
			  	            	<div class="cell-1">First Name<span class="style1">*</span> <span class="redasterisk" id="usrForename_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <input class="text long" name="Forename" id="usrForename" value="<?php if(isset($_POST['Forename'])){echo $_POST['Forename'];}else{echo $row3['Forename'];}?>" type="text">
			  	            </div>
	          </div>
	          <div class="rowwrap">
			  	            <div class="cell-1">Surname <span class="style1">*</span><span class="redasterisk" id="usrSurname_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <input class="text long" name="Surname" id="usrSurname" value="<?php if(isset($_POST['Surname'])){echo $_POST['Surname'];}else{echo $row3['Surname'];}?>" type="text">
			  	            </div>
	          </div>
	          <div class="rowwrap">
			  	            <div class="cell-1">Gender<span class="style1">*</span> <span class="redasterisk" id="usrGender_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	            <?php $genderarr = array('Female', 'Male');?>
			  	              <select class="drop short" name="Gender" id="usrGender">
			  	                <option value="">Select</option>
			  	               	<?php foreach($genderarr as $gen)
			  	               	{
			  	               		echo "<option value='$gen'"; if(isset($_POST['Gender'])){if($gen == $_POST['Gender']){echo "selected='selected'";}}else{if($gen == $row3['Gender']){ echo "selected='selected'"; }} echo ">$gen</option>";
			  	               	}?>
			  	              </select>
			  	            </div>
	          </div>
			  <div class="rowwrap">
			  <div class="cell-1">Status<span class="style1">*</span> <span class="redasterisk" id="usrStatus_mark" style="display:none;"> *</span></div>
			  <div class="cell-2">
				<select class="drop short" name="Status" id="usrStatus">
				  <option value="">Select</option>
				  <option value="Married" <?php if(isset($_POST['Status'])){if($_POST['Status'] == 'Married'){echo "selected='selected'";}}else{if($row3['Status'] == 'Married'){echo "selected='selected'";}}?>>Married</option>
				  <option value="Single" <?php if(isset($_POST['Status'])){if($_POST['Status'] == 'Single'){echo "selected='selected'";}}else{if($row3['Status'] == 'Single'){echo "selected='selected'";}}?>>Single</option>
				  <option value="Separated" <?php if(isset($_POST['Status'])){if($_POST['Status'] == 'Separated'){echo "selected='selected'";}}else{if($row3['Status'] == 'Separated'){echo "selected='selected'";}}?>>Separated</option>
				  <option value="Divorced" <?php if(isset($_POST['Status'])){if($_POST['Status'] == 'Divorced'){echo "selected='selected'";}}else{if($row3['Status'] == 'Divorced'){echo "selected='selected'";}}?>>Divorced</option>
				</select>
			  </div>
          </div>
	          <div class="rowwrap">
			  	            <div class="cell-1">Email Address<span class="style1">*</span> <span class="redasterisk" id="usrEmailAddress_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <input class="text long" name="EmailAddress" id="usrEmailAddress" value="<?php if(isset($_POST['EmailAddress'])){echo $_POST['EmailAddress'];}else{echo $row3['EmailAddress'];}?>" type="text" >
			  	            </div>
	          </div>
	          <div class="rowwrap">
			  	            <div class="cell-1">Date of Birth<span class="style1">*</span> <span class="redasterisk" id="usrDOB_day_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <select name="Date_Day" id="usrDOB_day" class="drop date">
			  	                <option value=''>--</option>
			  	                <?php 	for($days=1 ; $days<=31 ; $days++)
			  							{
			  								echo "<option value=\"$days\""; if(isset($_POST['Date_Day'])){if($_POST['Date_Day'] == $days){echo "selected='selected'";}}else{if ($dateday==$days){ echo "selected=\"selected\"";}} echo ">"; if(strlen($days)==1){echo "0";} echo "$days</option>";
			  							}
			  					?>
			  	              </select>
			  	              <select name="Date_Month" id="usrDOB_month" class="drop date">
			  	                <option value=''>--</option>
			  	                <?php 	$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
			  	                		for($month=1 ; $month<=12 ; $month++)
			  							{
			  								$word = $month-1;
			  								echo "<option value=\"$month\""; if(isset($_POST['Date_Month'])){if($_POST['Date_Month'] == $month){echo "selected='selected'";}}else{if ($datemonth==$month){ echo "selected=\"selected\"";}} echo ">$months[$word]</option>";
			  							}
			  					?>
			  	              </select>
			  	              <select name="Date_Year" id="usrDOB_year" class="drop date">
			  	                <option value=''>--</option>
			  	                <?php	for($year=1966 ; $year<=1990 ; $year++)
			  							{
			  								echo "<option value=\"$year\""; if(isset($_POST['Date_Year'])){if($_POST['Date_Year'] == $year){echo "selected='selected'";}}else{if ($dateyear==$year){ echo "selected=\"selected\"";}} echo ">$year</option>";
			  							}
			  					?>
			  	              </select>
			  	            </div>
	          </div>
	          <div class="rowwrap">
			  	            <div class="cell-1">Profession <span class="style1">*</span><span class="redasterisk" id="usrProfession_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	            <?php $proarr = array('Not Specified', 'Academic', 'Accounting', 'Admin / Secretarial', 'Arts / Media', 'Company Director', 'Construction / Property Services', 'Consultant', 'Designer', 'Doctor / Medical', 'Financial Services / Insurance', 'Hospitality / Catering', 'Human Resources', 'IT / Computing', 'Legal', 'Leisure / Tourism', 'Military', 'Own Business', 'Political / Government', 'Sales and Marketing', 'Science / Technical', 'Teaching / Education', 'Writer / Journalist', 'Other');?>
			  	              <select class="drop long" name="Profession" id="usrProfession" value="profession">
			  	                <?php foreach($proarr as $pro)
			  	                {
			  	                	echo "<option value='$pro'"; if(isset($_POST['Profession'])){if($_POST['Profession'] == $pro){echo "selected='selected'";}}else{if($pro == $row3['Profession']){ echo "selected='selected'"; }} echo ">$pro</option>";
			  	                }?>
			  	              </select>
			  	            </div>
	          </div>
	          <div class="rowwrap">
			  	           <div class="cell-1">Mobile Number<span class="style1">*</span><span class="redasterisk" id="usrPhone_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <input type="text" size="20" class="text phone" name="Mobile" id="usrPhone" value="<?php if(isset($_POST['Mobile'])){echo $_POST['Mobile'];}else{ echo $row3['Mobile'];}?>">
			  	            </div>
			  	          </div>
			  	          <div class="rowwrap">
			  	            <div class="cell-1">How did you hear about us?  <span class="style1">*</span><span class="redasterisk" id="usrHear_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <select class="drop long" name="HeardFrom" id="usrHear">
			  	                <option value="">Select</option>
			  	                <?php $heardarr = array("Google", "Friend", "A Small World", "Magazine", "Newspaper", "Decayenne", "Linked In", "Financial World", "City AM", "Daily Mail", "Telegraph");
			  	                foreach($heardarr as $hear)
			  	               	{
			  	               		echo "<option value='$hear'"; if(isset($_POST['HeardFrom'])){if($_POST['HeardFrom'] == $hear){echo "selected='selected'";}}else{if($hear == $row3['HeardFrom']){ echo "selected='selected'"; }} echo ">$hear</option>";
			  	               	}?>
			  	              </select>
			  	            </div>
			  	          </div>
			  	          <div class="rowwrap">
			  	            <div class="cell-1">Interests <span class="style1">*</span><span class="redasterisk" id="usrInterests_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <textarea name="Interests" cols="20" class="text long" id="usrInterests"><?php if(isset($_POST['Interests'])){echo $_POST['Interests'];}else{ echo $row3['Interests'];}?></textarea>
			  	            </div>
			  	          </div>
			  	          <div class="rowwrap">
						  		              <div class="cell-1">What do you hope to achieve? <span class="style1">*</span><span class="redasterisk" id="usrAchieve_mark" style="display:none;"> *</span></div>
						  		              <div class="cell-2">
						  		                <select class="drop long" name="Achieve" id="usrAchieve">
						  		                  <option value="">Select</option>
						  		                  <?php $acharr = array('Friendship', 'Socialising', 'Networking');
						  		                  foreach($acharr as $ach)
						  		                  {
								  		          		echo "<option value='$ach'"; if(isset($_POST['Achieve'])){if($_POST['Achieve'] == $ach){echo "selected='selected'";}}else{if($ach == $row3['Achieve']){ echo "selected='selected'"; }} echo ">$ach</option>";
								  		          }?>
						  		                </select>
						  		              </div>
          </div>
			  	          <div class="rowwrap">
			  	            <div class="cell-1">&nbsp;</div>
			  	            <div class="cell-2"></div>
			  	          </div>
			  	          <div class="rowwrap submitbutton">
			  	           <div class="cell-1">&nbsp;</div>
			  	            <div class="cell-2">
			  	              <!--<input type="submit" name="Submit" value="Amend">-->
			  	              <input type='hidden' name='Submit' />
			  	              <p><img src="../images/sumi_buttons_04.png" class='singlebuttoncenterside' /><!--
                              --><input type='submit' class='singlebuttoncenter' name='Amend' value='Amend Member' /><!--
							  --><img src="../images/sumi_buttons_06.png" class='singlebuttoncenterside' /></p>
			  	            </div>
			  	          </div>
			  	          <div class="rowwrap submitbutton">          </div>
			  	    </div>
					<div align='right'><?php if($row3['Image_Path']!=''){?><img src="../member/images/<?php echo $row3['Image_Path'];?>" alt="<?php echo $names;?>" border='0' width='200' /><?php }else{ echo "NO PHOTO AVAILABLE";}?></div>
	        <p></p>
	 </form>
<?php
}?>
<p>&nbsp;</p>

</div>

<div class="clear"></div>
       <div class="spacebreak"></div>
    </div>
    
   
    <?php include('../footer.php');?>
   
</body>
</html>