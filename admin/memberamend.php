<?php include '../database/databaseconnect.php';
//RENEW SECTION
if(isset($_GET['renew']))
{
	$renid = $_GET['renew'];
	$query3 = "SELECT * FROM Members WHERE ID = '$renid'";
	$result3 = mysql_query($query3) or die(mysql_error());
	$row3 = mysql_fetch_array($result3);
	$email = $row3['EmailAddress'];
	$to = $email;
	//$to = 'sumita.biswas@gmail.com';
	$subject = 'Renewed Membership to London Dinner Club';
	$body = "<html><head><title>Renewed Membership to London Dinner Club</title></head><body>";
	$body .= "<p>Dear Member,</p>";
	$body .= "<p>Thank you for renewing your Membership for a further year.</p>";
	$body .= "<p><br/></p><p>Best Wishes,</p>";
	$body .= "<p><br/></p><p>London Dinner Club</p>";
	$body .= "<p><img src='http://www.londondinnerclub.org/images/logo2.png' alt='London Dinner Club' border='0' /></p></body></html>";

	$headers = "MIME-Version: 1.0 \r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
	$headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";

	if(mail($to, $subject, $body, $headers))
	{
		$fullname = $row3['Forename'] . ' ' . $row3['Surname'];?>
		<script>
		alert("Thank You! Member - <?php echo $fullname;?> has been renewed!");
		</script>
	<?php
	}
	else
	{?>
		<p><b>System Error</b></p><p>A system error has occurred -  we apologise for any inconvenience caused. Use the link below to manually email this member.</p>
		<p><a href="mailto:<?php echo $row3['EmailAddress'];?>" style='text-decoration:none;'><?php echo $row3['EmailAddress'];?></a></p>
	<?php

	}
	
	$expire = date('Y-m-d H:i', strtotime(date("Y-m-d H:i", strtotime($row3['DateExpire'])) . " +12 months"));

	$query4 = "UPDATE Members SET Approved = 'Yes', DateExpire = '$expire' WHERE ID = '$renid'";
	$result4 = mysql_query($query4) or die(mysql_error());
}
//DELETE SECTION!
if(isset($_GET['delete']))
{
	$delid = $_GET['delete'];
	$query2 = "SELECT Forename, Surname FROM Members WHERE ID = '$delid'";
	$result2 = mysql_query($query2) or die(mysql_error());
	$row = mysql_fetch_array($result2);
	$fullname = "$row[0] $row[1]";
	$query3 = "DELETE FROM Members WHERE ID = $delid";
	$result3 = mysql_query($query3) or die(mysql_error());
	/*$que = "SELECT ID FROM Members WHERE ID > $delid";
	$res = mysql_query($que) or die(mysql_error());
	while($rowarrange = mysql_fetch_array($res))
	{
		$idnew = $rowarrange[0] - 1;
		$idold = $rowarrange[0];
		$qu = "UPDATE Members SET ID = '$idnew' WHERE ID = '$idold'";
		$re = mysql_query($qu) or die(mysql_error());
    }*/
	?>
	<script>
	alert("Thanks - Member '<?php echo $fullname;?> Deleted!");
	top.opener.top.location.reload(true);
	window.close();
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


	$_POST['DietaryReq'] = str_replace("\r\n", ', ', $_POST['DietaryReq']);

	$_POST['Interests'] = str_replace("\r\n", ', ', $_POST['Interests']);

	$sPattern = '/\s*/m';
	$sReplace = '';

	$_POST['Mobile'] = preg_replace( $sPattern, $sReplace, $_POST['Mobile'] );
	$_POST['Mobile'] = trim($_POST['Mobile']);
	if(!is_numeric($_POST['Mobile']))
	{
		$errors[] = "The mobile number must be numeric!";
	}

	$fields = array('Forename', 'Surname', 'Gender', 'Status', 'EmailAddress', 'DOB', 'Profession', 'Mobile', 'DietaryReq', 'Religion', 'Height', 'Drink', 'HeardFrom', 'Interests', 'Achieve');

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
				top.opener.top.location.reload(true);
				window.close();
				</script>
		<?php
	}
}
//AMEND SECTION ENDED PART 1
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: ADMIN AREA - MEMBERSHIP ::  London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club. Singles events london, singles event, dating events, speed dating, match.com, datingdirect.com, dating in london, online dating, dating tips, salima manji, asian dinner club, supperclub, vogue, luxury events, luxe events" />
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="logo"><a href="../admin/" target="_self"><img src="../images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.londondinnerclub.org/" target="_self">HOME</a></li>
<li class="topnav" ><a href="../aboutus.php" target="_self">ABOUT<br/>US</a></li>
<li><a href="../events.php" target="_self">CURRENT<br/>EVENTS</a></li>
<li><a href="../past_events.php" target="_self">PAST<br/>EVENTS</a></li>
<li><a href="../membership.php" target="_self">MEMBERSHIP</a></li>
<li><a href="../asiandinnerclub.php" target="_self">ASIAN<br/>DINNER CLUB</a></li>
<li><a href="../press.php" target="_self">PRESS</a></li>
<li><a href="../team.php" target="_self">THE<br/>TEAM</a></li>
<li><a href="../contact.php" target="_self">CONTACT</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<div id="contentcol1">
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
	<table cellspacing='0' cellpadding='0' border='0'>
		<tr>
			<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" /></td>
			<td class='singlebutton'><a title='Delete' onclick="if(confirm('Are you sure you want to delete this contact: <?php echo $names;?>?')){location.href='?delete=<?php echo $editid;?>';}else{window.location.reload(false);}">Delete Member</a></td>
			<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" /></td>
		</tr>
	</table>
	<?php
	if($row3['Approved'] == 'RenewNo')
	{?>
		<p>&nbsp;</p>
		<table cellspacing='0' cellpadding='0' border='0'>
			<tr>
				<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" /></td>
				<td class='singlebutton'><a title='Renew' onclick="if(confirm('Are you sure you want to renew this contact: <?php echo $names;?>?')){location.href='?renew=<?php echo $editid;?>';}else{window.location.reload(false);}">Renew Member</a></td>
				<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" /></td>
			</tr>
		</table>
	<?php
	}?>
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
			  	            <div class="cell-1">Dietary Requirements<span class="style1">*</span><span class="redasterisk" id="usrDietary_mark" style="display:none;"></span><span class="redasterisk" id="usrPassword_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <textarea name="DietaryReq" cols="20" class="text long" id="usrDietary"><?php if(isset($_POST['DietaryReq'])){echo $_POST['DietaryReq'];}else{echo $row3['DietaryReq'];}?></textarea>
			  	            </div>
			  	          </div>
			  			       <div class="rowwrap">
			  	            <div class="cell-1">Religion <span class="style1">*</span><span class="redasterisk" id="usrReligion_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	            <?php $relarr = array('Christian', 'Jewish', 'Spiritual - Not Religious', 'Hindu', 'Sikh', 'Muslim', 'No Religion', 'Other');?>
			  	              <select class="drop long" name="Religion" id="usrReligion">
			  	                <option value="">Select</option>
			  	                <?php foreach($relarr as $rel)
			  	                {
			  	                	echo "<option value='$rel'"; if(isset($_POST['Religion'])){if($_POST['Religion'] == $rel){echo "selected='selected'";}}else{if($rel == $row3['Religion']){ echo "selected='selected'"; }} echo ">$rel</option>";
			  	                }?>
			  	              </select>
			  	            </div>
			  	          </div>
			  			  		       <div class="rowwrap">
			  	            <div class="cell-1">Height<span class="style1">*</span><span class="redasterisk" id="usrHeight_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	            <?php $heigarr = array("4' 11in", "4' 12in", "5' 0in", "5' 1in", "5 '2in", "5' 3in", "5' 4in", "5' 5in", "5' 6in", "5' 7in", "5' 8in", "5' 9in", "5' 10in", "5' 11in", "6' 0in", "6' 1in", "6' 2in", "6' 3in", "6' 4in", "6' 5in", "6'6in", "6'7in");?>
			  	              <select class="drop long" name="Height" id="usrHeight">
			  	                <option value="">Select</option>
			  	                <?php foreach($heigarr as $heig)
			  	                {
			  	                	echo "<option value=\"$heig\""; if(isset($_POST['Height'])){if($_POST['Height'] == $heig){echo "selected='selected'";}}else{if($heig == $row3['Height']){ echo "selected='selected'"; }} echo ">$heig</option>";
			  	                }?>
			  	              </select>
			  	            </div>
			  	          </div>
			  	          <div class="rowwrap">
			  	            <div class="cell-1">Do You Drink? <span class="style1">*</span><span class="redasterisk" id="usrDrink_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <select class="drop short" name="Drink" id="usrDrink">
			  	                <option value="">Select</option>
			  	                <?php $drarr = array('Yes', 'No');
			  	                foreach($drarr as $dr)
			  	                {
			  	                	echo "<option value='$dr'"; if(isset($_POST['Drink'])){if($_POST['Drink'] == $dr){echo "selected='selected'";}}else{if($dr == $row3['Drink']){ echo "selected='selected'"; }} echo ">$dr</option>";
			  	                }?>
			  	              </select>
			  	            </div>
			  	          </div>
			  	          <div class="rowwrap">
			  	            <div class="cell-1">How did you hear about us?  <span class="style1">*</span><span class="redasterisk" id="usrHear_mark" style="display:none;"> *</span></div>
			  	            <div class="cell-2">
			  	              <select class="drop long" name="HeardFrom" id="usrHear">
			  	                <option value="">Select</option>
			  	                <?php $heararr = array('Google', 'Friend', 'A Small World', 'Magazine', 'Newspaper', 'Decayenne');
			  	                foreach($heararr as $hear)
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
						  		              <div class="cell-1">What do you hope to achieve from Asian Dinner Club? <span class="style1">*</span><span class="redasterisk" id="usrAchieve_mark" style="display:none;"> *</span></div>
						  		              <div class="cell-2">
						  		                <select class="drop long" name="Achieve" id="usrAchieve">
						  		                  <option value="">Select</option>
						  		                  <?php $acharr = array('Friendship', 'Socialising', 'Serious Relationship', 'Networking');
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
			  	              <table cellspacing='0' cellpadding='0' border='0'>
							  				<tr>
							  					<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
							  					<td class='singlebutton'><a title='Amend' onclick="javascript:document.ContactForm.submit();" href='#'>Amend Member</a></td>
							      				<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
							    				</tr>
  			</table>
			  	            </div>
			  	          </div>
			  	          <div class="rowwrap submitbutton">          </div>
			  	    </div>
					<div align='right'><?php if($row3['Image_Path']!=''){?><img src="../member/images/<?php echo $row3['Image_Path'];?>" alt="<?php echo $names;?>" border='0' width='126' /><?php }else{ echo "NO PHOTO AVAILABLE";}?></div>
	        <p></p>
	 </form>
<?php
}?>
</div>







<div id="contentcol2">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
    <p>&nbsp;</p>
  <span class="lefthandpic"><img src="../images/side.jpg" alt="London Dinner Club" width="194" height="194" /></span>
</div>
<!-- end inner content -->

</div>
</div>
<div id="footer">
<div class="footer2col1"><a href="../terms.php">TERMS</a>&nbsp;|&nbsp;<a href="../sitemap.php">SITE MAP</a>&nbsp;|&nbsp;<a class='active' href="../admin/">ADMINISTRATOR</a></div></div>
<div id="footer2">
<div class="footer2col2">Copyright &copy;&nbsp;London Dinner Club&nbsp;2010</div>
<div class="footer2col2">designed by: <a href="http://www.streeten.co.uk" target='_blank'>streeten</a></div>
<div class="footer2col2">redeveloped by: <a href="http://www.sbcommunications.co.uk" target='_blank'>S B Communications Ltd.</a></div></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
  //_uacct = "UA-4965994-1";
  //urchinTracker();
</script>
</div>
</body>
</html>