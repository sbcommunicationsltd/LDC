<?php session_start();
include '../database/databaseconnect.php';

if(!isset($_SESSION['admin_is_logged_in'])){
	header('Location: login.php');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: ADMIN AREA - EVENTS :: London Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club. Singles events london, singles event, dating events, speed dating, match.com, datingdirect.com, dating in london, online dating, dating tips, salima manji, asian dinner club, supperclub, vogue, luxury events, luxe events" />
<script>
function show(id, id2) {
    var style = document.getElementById(id2).style;
    
    if (document.getElementById(id).value == '35+') {
        if (style.display == 'inline') {
            style.display = 'none';
        }
    } else {
        if (style.display == 'none') {
            style.display = 'inline';
        }
    }
}
</script>
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


<div id="contentcol1">
	<h2>Admin Area</h2>
	<img src="../images/current_events.gif" alt="Events" width="210" height="50"/>
<div>
<p>&nbsp;</p>
<h2 align='center'>Event Organiser's Schedule</h2>

<!-- DELETE SECTION! -->
<?php if(isset($_GET['delete']))
{
	$delid = $_GET['delete'];
	$deleve = $_GET['event'];
	$quer = "SELECT Image_Path FROM Events WHERE ID = $delid";
	$resu = mysql_query($quer) or die(mysql_error());
	$ro = mysql_fetch_array($resu);
	if(file_exists('../images/' . $ro[0]))
	{
		unlink('../images/' . $ro[0]);
	}
	$query3 = "DELETE FROM Events WHERE ID = $delid";
	$result3 = mysql_query($query3) or die(mysql_error());
	$que = "SELECT ID FROM Events WHERE ID > $delid";
	$res = mysql_query($que) or die(mysql_error());
	while($rowarrange = mysql_fetch_array($res))
	{
		$idnew = $rowarrange[0] - 1;
		$idold = $rowarrange[0];
		$qu = "UPDATE Events SET ID = '$idnew' WHERE ID = '$idold'";
		$re = mysql_query($qu) or die(mysql_error());
    }
	?>
	<script>
	alert("Thanks - Event '<?php echo $deleve;?> Deleted!");
	location.href='../admin/eventsdatabase.php';
	</script>
	<?php
}?>
<!-- DELETE SECTION ENDED-->


<!--EDIT SECTION-->
<?php
if(isset($_POST['submitedit']))
{
	$errors = array();
	if($_POST['Date_Day']=="" || $_POST['Date_Month']=="" || $_POST['Date_Year']=="")
	{
		$_POST['Date'] == "";
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
		$_POST['Date'] = $_POST['Date_Year'] . '-' . $_POST['Date_Month'] . '-' . $_POST['Date_Day'];
	}

	if($_POST['Date'] < date('Y-m-d'))
	{
		$errors[] = 'The date provided is in the past';
	}
	
    if ($_POST['AgeMin'] == '35+') {
        $_POST['Age'] = $_POST['AgeMin'];
    } else {
        if($_POST['AgeMax'] < $_POST['AgeMin'])
        {
            $errors[] = 'The Maximum Age is younger than the Minumum Age!';
        }
        elseif($_POST['AgeMin']=="" || $_POST['AgeMax']=="")
        {
            $_POST['Age'] == "";
        }
        else
        {
            $_POST['Age'] = $_POST['AgeMin'] . ' - ' . $_POST['AgeMax'];
        }
    }
	
	
	if(!is_numeric($_POST['MaxMaleQuantity']))
	{
		$errors[] = "The Max Male Quantity is not numeric.";
	}


	if(!is_numeric($_POST['MaxFemaleQuantity']))
	{
		$errors[] = "The Max Female Quantity is not numeric.";
	}

	$target_path = "../images/";

	$filename = basename($_FILES['uploadedfile']['name']);

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

		$ven = $_POST['Venue'];
		$ven = strtolower($ven);

		$ven = preg_replace('/[^a-z0-9]/', '', $ven);

		$suffix='';
		if(file_exists("$target_path$ven$suffix.$extension"))
		{
			$suffix = 0;
			while(file_exists("$target_path$ven$suffix.$extension"))
			{
				$suffix++;
			}
		}

		$editfile = $ven . $suffix . '.' . $extension;
		$target_path = $target_path . $editfile;


		if($_POST['MAX_FILE_SIZE'] < $_FILES['uploadedfile']['size'])
		{
			$errors[] = "The file size is too big for the server. Please reduce the size!";
		}

		if($extension!='gif' && $extension!='jpg' && $extension!='jpeg')
		{
			$errors[] = "Your uploaded file must be of JPG or GIF. Other file types are not allowed";
		}

		if(!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
		{
			$errors[] = "There was an error uploading the file!";
		}

		$_POST['Image_Path'] = $editfile;
	}
	else
	{
		$_POST['Image_Path'] = $_POST['image'];
	}

	$query5 = "SELECT * FROM Events";
	$result5 = mysql_query($query5) or die(mysql_error());
	$numfields = mysql_num_fields($result5);

	for ($i=0; $i < $numfields; $i++)
	{
		$fieldname[] = mysql_field_name($result5, $i);
	}

	foreach ($fieldname as $field)
	{
		if($field!='Address_Town' && $field!='Address_City' && $field!='Image_Path')
		{
			$formvar = $_POST[$field];
			if ($formvar=="")
			{
				$errors[] = "You forgot to enter the '$field'.";
			}
		}
	}

	if(empty($errors))
	{
		$editpostid = $_POST['ID'];
		$editvenue = $_POST['Venue'];

		$query6 = "UPDATE Events SET ";
		foreach ($fieldname as $field)
		{
			if($field!='ID')
			{
				$formvar = $_POST[$field];
				$formvar = addslashes($formvar);
				$query6 .= "$field = '$formvar', ";
			}
		}
		$query6 = substr($query6,0,-2) . " WHERE ID=$editpostid";
		mysql_query($query6) or die(mysql_error());

		if($_POST['Image_Path'] != $_POST['image'])
		{
			if(file_exists('../images/' . $_POST['image']))
			{
				unlink('../images/' . $_POST['image']);
			}
		}
		?>
		<script>
		alert("Thanks - Event '<?php echo $editvenue;?>' Details Amended!");
		location.href='../admin/eventsdatabase.php';
		</script>
		<?php
	}
	else
	{ // Report the errors.
		foreach($fieldname as $field)
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

		if($_POST['Image_Path'] == $editfile)
		{
			if(file_exists('../images/' . $editfile))
			{
				unlink('../images/' . $editfile);
			}
		}

		echo '<h3>Error!</h3>
	        <p>The following error(s) occurred:<br />';
	        foreach ($errors as $msg) { // Print each error.
	            echo " - $msg<br />\n";
	        }
	        echo '</p><p>Please try again.</p><p><br /></p>';

	} // End of if (empty($errors)) IF.
}

if(isset($_GET['edit']))
{
	$editid = $_GET['edit'];
	$query4 = "SELECT * FROM Events WHERE ID = $editid";
	$result4 = mysql_query($query4) or die(mysql_error());
	$row2 = mysql_fetch_array($result4);
	$Date = $row2['Date'];
	$arrdate = split("-", $Date);
	$dateday = $arrdate[2];
	$datemonth = $arrdate[1];
	$dateyear = $arrdate[0];
	$age = $row2['Age'];
    if ($age != '35+') {
        $arrage = split(' - ', $age);
        $agemin = $arrage[0];
        $agemax = $arrage[1];
    } else {
        $agemin = $age;
    }
	?>

	<form method='post' name='editevent' enctype="multipart/form-data">
	<table width='600' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
		<tr>
			<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Edit this Event</div></td>
		</tr>
		<input type='hidden' name='ID' value="<?php echo $row2['ID'];?>" />
		<tr>
			<th align='left'>Date</th>
			<td><select name="Date_Day"><option value="">Day</option>
			<?php
					for($days=1 ; $days<=31 ; $days++)
					{
						echo "<option value=\"$days\""; if(isset($_POST['Date_Day'])){if($_POST['Date_Day'] == $days){echo "selected='selected'";}}else{if ($dateday==$days){ echo "selected=\"selected\"";}} echo ">"; if(strlen($days)==1){echo "0";} echo "$days</option>";
					}
			echo "</select> / <select name=\"Date_Month\"><option value=\"\">Month</option>";
					for($month=1 ; $month<=12 ; $month++)
					{
						echo "<option value=\"$month\""; if(isset($_POST['Date_Month'])){if($_POST['Date_Month'] == $month){echo "selected='selected'";}}else{if ($datemonth==$month){ echo "selected=\"selected\"";}} echo ">"; if(strlen($month)==1){echo "0";} echo "$month</option>";
					}
			echo "</select> / <select name=\"Date_Year\"><option value=\"\">Year</option>";
					for($year=2009 ; $year<=2030 ; $year++)
					{
						echo "<option value=\"$year\""; if(isset($_POST['Date_Year'])){if($_POST['Date_Year'] == $year){echo "selected='selected'";}}else{if ($dateyear==$year){ echo "selected=\"selected\"";}} echo ">$year</option>";
					} ?>
			</select></td>
		</tr>
		<tr>
			<th align='left'>Venue</th>
			<td><input type='text' name='Venue' size='40' value="<?php if(isset($_POST['Venue'])){echo $_POST['Venue'];}else{echo $row2['Venue'];}?>" /></td>
		</tr>
		<tr>
			<th align='left'>Event Type</th>
			<td valign='middle'><select name="Event_Type">
			<?php $types = array('Networking Drinks', 'Dinner Party', 'Valentines Dinner', 'Christmas Lunch', 'Cheese and Wine', 'Fine Art/Fine Dining', 'Champagne and Canapes', 'Summer Party', 'Sunday Lunch', 'Party', 'Launch Party', 'Thanksgiving Dinner');
			foreach($types as $ty)
			{
				echo "<option value='$ty' "; if(isset($_POST['Event_Type'])){if($_POST['Event_Type'] == $ty){echo "selected='selected'";}}else{if($row2['Event_Type']== $ty) { echo "selected='selected'";}} echo ">$ty</option>";
			}?></select></td>
		</tr>
		<tr>
			<th align='left'>City</th>
			<td valign='middle'><select name='City'>
			<?php $cities = array('London', 'Paris', 'New York', 'Dubai');
			foreach($cities as $city)
			{
				echo "<option value='$city' "; if(isset($_POST['City'])){if($_POST['City'] == $city){echo "selected='selected'";}}else{if($row2['City'] == $city){echo "selected='selected'";}} echo ">$city</option>";
			}?></select></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<th align='left'>Address:</th>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th align='left'>House Name/Number and Street</th>
			<td><input type='text' name='Address_Street' value="<?php if(isset($_POST['Address_Street'])){echo $_POST['Address_Street'];}else{echo $row2['Address_Street'];}?>" size='40' /></td>
		</tr>
		<tr>
			<th align='left'>Town</th>
			<td><input type='text' name='Address_Town' value="<?php if(isset($_POST['Address_Town'])){echo $_POST['Address_Town'];}else{echo $row2['Address_Town'];}?>" size='40' /></td>
		</tr>
		<tr>
			<th align='left'>City</th>
			<td><input type='text' name='Address_City' value="<?php if(isset($_POST['Address_City'])){echo $_POST['Address_City'];}else{echo $row2['Address_City'];}?>" size='40' /></td>
		</tr>
		<tr>
			<th align='left'>PostCode</th>
			<td><input type='text' name='Address_PostCode' value="<?php if(isset($_POST['Address_PostCode'])){echo $_POST['Address_PostCode'];}else{echo $row2['Address_PostCode'];}?>" size='40' /></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<!--<tr>
			<th align='left'>Age</th>
			<td><select name="Age"><option value="">Select</option>
				<?php
				for($min=24; $min<=50; $min++)
				{
					echo "<option value='$min'"; if(isset($_POST['Age'])){if($_POST['Age'] == $min){echo "selected='selected'";}}else{if($row2['Age']==$min) {echo "selected='selected'";}} echo ">$min</option>";
				}?>
				</select>
			</td>
		</tr>-->
		<tr>
			<th align='left'>Age</th>
			<td><select name="AgeMin" id='AgeMin' onChange="show('AgeMin', 'AgeMax');"><option value="">Min</option>
				<?php
                $display = 'inline';
				for($min=26; $min<=42; $min++)
				{
					echo "<option value='$min'"; if(isset($_POST['AgeMin'])){if($_POST['AgeMin'] == $min){echo "selected='selected'";}}else{if($agemin==$min) {echo "selected='selected'";}} echo ">$min</option>";
				}?>
                <option value='35+' <?php if(isset($_POST['AgeMin'])){if($_POST['AgeMin'] == '35+'){echo "selected='selected'"; $display = 'none';}}else{if($agemin=='35+'){echo "selected='selected'"; $display = 'none';}}?>>35+</option>
				</select> - <select name='AgeMax' id='AgeMax' style='display:<?php echo $display;?>;'><option value="">Max</option>
				<?php
				for($max=26; $max<=42; $max++)
				{
					echo "<option value='$max'"; if(isset($_POST['AgeMax'])){if($_POST['AgeMax'] == $max){echo "selected='selected'";}}else{if($agemax==$max) {echo "selected='selected'";}} echo ">$max</option>";
				}?>
				</select>
			</td>
		</tr>
		<tr>
			<th align='left'>Time</th>
			<td><select name="Time"><option value="">Time</option>
				<?php
				/*$hours = array('7.00', '7.15', '7.30', '7.45', '8.00');
				foreach($hours as $hour)
				{
					echo "<option value='$hour'"; if($row2['Time']==$hour) {echo "selected='selected'";} echo ">$hour pm</option>";
				}*/
				for ($i = 0; $i <= 9; $i++)
				{
    				if($i == 9)
    				{
    					$mins = array('.00', '.15', '.30');
    				}
    				else
    				{
    					$mins = array('.00', '.15', '.30', '.45');
    				}

    				foreach($mins as $min)
    				{
    					if($i == 0)
    					{
    						$time = '12' . $min;
    					}
    					else
    					{
    						$time = "$i" . $min;
    					}
    					echo "<option value='$time'"; if(isset($_POST['Time'])){if($_POST['Time'] == $time){echo "selected='selected'";}}else{if($row2['Time'] == $time){echo "selected='selected'";}} echo ">$time pm</option>";
    				}
    			}?>
				</select>
			</td>
		</tr>
		<tr>
			<th align='left'>Price</th>
			<td><select name="Price"><option value="">Price</option><option value='0' <?php if(isset($_POST['Price'])){if($_POST['Price'] == 0){echo "selected='selected'";}}else{if($row2['Price']==0) {echo "selected='selected'";}}?>>Free</option>
				<?php
				$pr = 10;
				while($pr<=100)
				{
					echo "<option value='$pr'"; if(isset($_POST['Price'])){if($_POST['Price'] == $pr){echo "selected='selected'";}}else{if($row2['Price']==$pr) {echo "selected='selected'";}} echo ">&pound;$pr</option>";

					$pr = $pr + 5;
				}?>
				</select>
			</td>
		</tr>
		<tr>
			<th align='left'>Description</th>
			<td><textarea name='Description' rows="4" cols="30"><?php if(isset($_POST['Description'])){echo $_POST['Description'];}else{echo $row2['Description'];}?></textarea></td>
		</tr>
		<tr>
			<th align='left'>Availability</th>
			<td>
				<table cellspacing='2' cellpadding='2' border='0'>
					<tr>
					<?php $availability = array('Available', 'Female Tickets Sold Out', 'Male Tickets Sold Out', 'Event Sold Out');
					foreach($availability as $avail)
					{
						echo "<td><input type='radio' name='Availability' value='$avail'"; if(isset($_POST['Availability'])){if($_POST['Availability'] == $avail){echo "checked='checked'";}}else{if($row2['Availability'] == $avail){echo "checked='checked'";}} echo "/>$avail</td>";
					}?>
					</tr>
				</table>
			</td>
		</tr>
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
		<tr>
			<th align='left'>Image</th>
			<td><img src="../images/<?php echo $row2['Image_Path'];?>" alt="<?php echo $row2['Venue'];?>" border='0' height='150' /></td>
			<input type='hidden' name='image' value="<?php echo $row2['Image_Path'];?>" />
		</tr>
		<tr>
			<td align='left'>To change above image - input the path to the new image below</td>
			<td><input name="uploadedfile" type="file" /></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<th align='left'>Max Male Ticket Quantity</th>
			<td><input type='text' name='MaxMaleQuantity' size='3' value="<?php if(isset($_POST['MaxMaleQuantity'])){echo $_POST['MaxMaleQuantity'];}else{echo $row2['MaxMaleQuantity'];}?>" /></td>
		</tr>
		<tr>
			<th align='left'>Max Female Ticket Quantity</th>
			<td><input type='text' name='MaxFemaleQuantity' size='3' value="<?php if(isset($_POST['MaxFemaleQuantity'])){echo $_POST['MaxFemaleQuantity'];}else{ echo $row2['MaxFemaleQuantity'];}?>" /></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
			<input type='hidden' name='submitedit' />
				<!--<input type='submit' name='submitedit' value='Amend Event' /><input type='button' name='back' value='Back to Admin Event Area' onclick="location.href='../admin/eventsdatabase.php'" />-->
				<table cellspacing='0' cellpadding='0' border='0'>
					<tr>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title='Amend Event' onclick="javascript:document.editevent.submit();" href='#'>Amend Event</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
						<td>&nbsp;</td>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title="Back" name='back' href="../admin/eventsdatabase.php">Back to Admin Event Area</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
<?php
}

?>
<!--EDIT SECTION ENDED -->


<!--ADD SECTION -->
<?php
if(isset($_POST['submitadd']))
{
	$errors = array();
	if($_POST['Date_Day']=="" || $_POST['Date_Month']=="" || $_POST['Date_Year']=="")
	{
		$_POST['Date'] == "";
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
		$_POST['Date'] = $_POST['Date_Year'] . '-' . $_POST['Date_Month'] . '-' . $_POST['Date_Day'];
	}

	if($_POST['Date'] < date('Y-m-d'))
	{
		$errors[] = 'The date provided is in the past!';
	}

	if ($_POST['AgeMin'] == '35+') {
        $_POST['Age'] = $_POST['AgeMin'];
    } else {
        if($_POST['AgeMax'] < $_POST['AgeMin'])
        {
            $errors[] = 'The Maximum Age is younger than the Minumum Age!';
        }
        elseif($_POST['AgeMin']=="" || $_POST['AgeMax']=="")
        {
            $_POST['Age'] == "";
        }
        else
        {
            $_POST['Age'] = $_POST['AgeMin'] . ' - ' . $_POST['AgeMax'];
        }
    }
	
	if(!is_numeric($_POST['MaxMaleQuantity']))
	{
		$errors[] = "The Max Male Quantity is not numeric";
	}

	if(!is_numeric($_POST['MaxFemaleQuantity']))
	{
		$errors[] = "The Max Female Quantity is not numeric";
	}

	$target_path = "../images/";

	$filename = basename($_FILES['uploadedfile']['name']);

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

		$newven = $_POST['Venue'];

		$newven = strtolower($newven);

		$newven = preg_replace('/[^a-z0-9]/', '', $newven);

		$suffix='';
		if(file_exists("$target_path$newven$suffix.$extension"))
		{
			$suffix = 0;
			while(file_exists("$target_path$newven$suffix.$extension"))
			{
				$suffix++;
			}
		}

		$newfile = $newven . $suffix . '.' . $extension;

		$target_path = $target_path . $newfile;

		if($_POST['MAX_FILE_SIZE'] < $_FILES['uploadedfile']['size'])
		{
			$errors[] = "The file size is too big for the server. Please reduce the size!";
		}

		if($extension!='jpg' && $extension!='jpeg' && $extension!='gif')
		{
			$errors[] = "Your uploaded file must be of JPG or GIF. Other file types are not allowed";
		}

		if(!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
		{
			$errors[] = "There was an error uploading the file!";
		}

		$_POST['Image_Path'] = $newfile;
	}
	else
	{
		$_POST['Image_Path'] = '';
	}

	$query7 = "SELECT * FROM Events";
	$result7 = mysql_query($query7) or die(mysql_error());
	$numfields = mysql_num_fields($result7);

	for ($i=0; $i < $numfields; $i++)
	{
		$fieldname[] = mysql_field_name($result7, $i);
	}

	foreach ($fieldname as $field)
	{
		if($field!='Address_Town' && $field!='Address_City' && $field!='Image_Path' && $field!='ID')
		{
			$formvar = $_POST[$field];
			if ($formvar=="")
			{
				$errors[] = "You forgot to enter the '$field'.";
			}
		}
	}

	//echo 'TIME: ' . $_POST['Time'];
	//echo 'Type: ' . $_POST['Event_Type'];

	if(empty($errors))
	{
		$addvenue = $_POST['Venue'];
		$findid = "SELECT MAX(ID) FROM Events";
		$idres = mysql_query($findid) or die(mysql_error());
		$rowid = mysql_fetch_array($idres);
		$maxid = $rowid[0] + 1;
		$query8 = "INSERT INTO Events VALUES('$maxid', ";
		foreach ($fieldname as $field)
		{
			if($field!='ID')
			{
				$formvar = $_POST[$field];
				$formvar = addslashes($formvar);
				$query8 .= "'$formvar', ";
			}
		}
		$query8 = substr($query8, 0, -2) . ")";
		mysql_query($query8) or die(mysql_error());
		?>
		<script>
		alert("Thanks - Event '<?php echo $addvenue;?>' Details Added!");
		location.href='../admin/eventsdatabase.php';
		</script>
		<?php
	}
	else
	{ // Report the errors.
		foreach($fieldname as $field)
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
		if($_POST['Image_Path'] == $newfile)
		{
			if(file_exists('../images/' . $newfile))
			{
				unlink('../images/' . $newfile);
			}
		}
		echo '<h3>Error!</h3>
	        <p>The following error(s) occurred:<br />';
	        foreach ($errors as $msg) { // Print each error.
	            echo " - $msg<br />\n";
	        }
	        echo '</p><p>Please try again.</p><p><br /></p>';

	} // End of if (empty($errors)) IF.
}

if(isset($_GET['add']))
{?>
	<form method='post' name='addevent' enctype="multipart/form-data">
		<table width='600' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
			<tr>
				<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Add an Event</div></td>
			</tr>
			<tr>
				<th align='left'>Date</th>
				<td><select name="Date_Day"><option value="">Day</option>
				<?php
						for($days=1 ; $days<=31 ; $days++)
						{
							echo "<option value=\"$days\" "; if($days == $_POST['Date_Day']){echo "selected='selected'";} echo ">"; if(strlen($days)==1){echo "0";} echo "$days</option>";
						}
				echo "</select> / <select name=\"Date_Month\"><option value=\"\">Month</option>";
						for($month=1 ; $month<=12 ; $month++)
						{
							echo "<option value=\"$month\" "; if($month == $_POST['Date_Month']){echo "selected='selected'";} echo ">"; if(strlen($month)==1){echo "0";} echo "$month</option>";
						}
				echo "</select> / <select name=\"Date_Year\"><option value=\"\">Year</option>";
						for($year=2009 ; $year<=2030 ; $year++)
						{
							echo "<option value=\"$year\" "; if($year == $_POST['Date_Year']){echo "selected='selected'";} echo ">$year</option>";
						} ?>
				</select></td>
			</tr>
			<tr>
				<th align='left'>Venue</th>
				<td><input type='text' name='Venue' size='40' value="<?php echo $_POST['Venue'];?>" /></td>
			</tr>
			<tr>
				<th align='left'>Event Type</th>
				<td valign='middle'>
				<select name="Event_Type">
				<?php $types = array('Networking Drinks', 'Dinner Party', 'Valentines Dinner', 'Christmas Lunch', 'Cheese and Wine', 'Fine Art/Fine Dining', 'Champagne and Canapes', 'Summer Party', 'Sunday Lunch', 'Party', 'Launch Party', 'Thanksgiving Dinner');
				foreach($types as $ty)
				{
					echo "<option value='$ty' "; if($_POST['Event_Type']== $ty) { echo "selected='selected'";} echo ">$ty</option>";
				}?>
				</select></td>
			</tr>
			<tr>
				<th align='left'>City</th>
				<td valign='middle'>
				<select name="City">
				<?php $cities = array('London', 'Paris', 'New York', 'Dubai');
				foreach($cities as $city)
				{
					echo "<option value='$city' "; if($_POST['City']== $city) { echo "selected='selected'";} echo ">$city</option>";
				}?>
				</select></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th align='left'>Address:</th>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<th align='left'>House Name/Number and Street</th>
				<td><input type='text' name='Address_Street' size='40' value="<?php echo $_POST['Address_Street'];?>" /></td>
			</tr>
			<tr>
				<th align='left'>Town</th>
				<td><input type='text' name='Address_Town' size='40' value="<?php echo $_POST['Address_Town'];?>" /></td>
			</tr>
			<tr>
				<th align='left'>City</th>
				<td><input type='text' name='Address_City' size='40' value="<?php echo $_POST['Address_City'];?>" /></td>
			</tr>
			<tr>
				<th align='left'>PostCode</th>
				<td><input type='text' name='Address_PostCode' size='40' value="<?php echo $_POST['Address_PostCode'];?>" /></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th align='left'>Age</th>
				<!--<td><select name="Age"><option value="">Select</option>
					<?php
					for($min=28; $min<=50; $min++)
					{
						echo "<option value='$min' "; if($min == $_POST['Age']){echo "selected='selected'";} echo ">$min</option>";
					}?>
					</select>
				</td>-->
				<td><select name="AgeMin" id='AgeMin' onChange="show('AgeMin', 'AgeMax');"><option value="">Min</option>
					<?php
                    $display = 'inline';
					for($min=26; $min<=42; $min++)
					{
						echo "<option value='$min' "; if($min == $_POST['AgeMin']){echo "selected='selected'";} echo ">$min</option>";
					}?>
                    <option value='35+' <?php if('35+' == $_POST['AgeMin']){echo "selected='selected'"; $display = 'none';}?>>35+</option>
					</select> - <select name='AgeMax' id='AgeMax' style="display:<?php echo $display;?>;"><option value="">Max</option>
					<?php
					for($max=26; $max<=42; $max++)
					{
						echo "<option value='$max' "; if($max == $_POST['AgeMax']){echo "selected='selected'";} echo ">$max</option>";
					}?>
					</select>
				</td>
			</tr>
			<tr>
				<th align='left'>Time</th>
				<td><select name="Time"><option value="">Time</option>
					<?php
					/*$hours = array('7.00', '7.15', '7.30', '7.45', '8.00');
					foreach($hours as $hour)
					{
						echo "<option value='$hour'>$hour pm</option>";
					}*/
					for ($i = 0; $i <= 9; $i++)
					{
    					if($i == 9)
    					{
    						$mins = array('.00', '.15', '.30');
    					}
    					else
    					{
    						$mins = array('.00', '.15', '.30', '.45');
    					}

    					foreach($mins as $min)
    					{
    						if($i == 0)
    						{
    							$time = '12' . $min;
    						}
    						else
    						{
    							$time = "$i" . $min;
    						}
    						echo "<option value='$time' "; if($time == $_POST['Time']){echo "selected='selected'";} echo ">$time pm</option>";
    					}
    				}?>
					</select>
				</td>
			</tr>
			<tr>
				<th align='left'>Price</th>
				<td><select name="Price"><option value="">Price</option><option value='0' <?php if(0 == $_POST['Price']){echo "selected='selected'";}?>>Free</option>
					<?php
					$pr = 10;
					while($pr<=100)
					{
						echo "<option value='$pr' "; if($pr == $_POST['Price']){echo "selected='selected'";} echo ">&pound;$pr</option>";

						$pr = $pr + 5;
					}?>
					</select>
				</td>
			</tr>
			<tr>
				<th align='left'>Description</th>
				<td><textarea name='Description' rows="4" cols="30"><?php echo $_POST['Description'];?></textarea></td>
			</tr>
			<input type='hidden' name='Availability' value='Available' />
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<tr>
				<th align='left'>Upload Image</th>
				<td><input name="uploadedfile" type="file" /></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th align='left'>Max Male Ticket Quantity</th>
				<td><input name="MaxMaleQuantity" type="text" size='3' value="<?php echo $_POST['MaxMaleQuantity'];?>" /></td>
			</tr>
			<tr>
				<th align='left'>Max Female Ticket Quantity</th>
				<td><input name="MaxFemaleQuantity" type="text" size='3' value="<?php echo $_POST['MaxFemaleQuantity'];?>" /></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='2' align='center'>
				<input type='hidden' name='submitadd' />
				<!--<input type='submit' name='submitadd' value='Add Event' /><input type='button' name='back' value='Back to Admin Event Area' onclick="location.href='../admin/eventsdatabase.php'" />-->
				<table cellspacing='0' cellpadding='0' border='0'>
					<tr>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title='Add Event' onclick="javascript:document.addevent.submit();" href='#'>Add Event</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
						<td>&nbsp;</td>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title="Back" name='back' href="../admin/eventsdatabase.php">Back to Admin Event Area</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
	</form>
	<?php
}
?>
<!--ADD SECTION ENDED -->

<!-- START PAGE -->

<?php
if((!isset($_GET['edit'])) && (!isset($_POST['submitedit'])) && (!isset($_GET['add'])) && (!isset($_POST['submitadd'])))
{
	$query = "SELECT * FROM Events WHERE Date >= CURDATE() ORDER BY Date ASC";
	$result = mysql_query($query) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	$max = 1;
	$page = $_GET["page"];
	if($page == "") $page=1;

	$limits = ($page-1)*$max;

	$query2 = $query . " LIMIT " . $limits . ",$max";
	$result2 = mysql_query($query2) or die(mysql_error());
	$numpages = ceil($num_rows/$max);
	if($numpages == 0)
	{
		$numpages = 1;
	}
	?>

	<!--<p><input type='button' name='add' value='Add An Event' onclick="location.href='?add=add';" /></p>-->
	<table cellspacing='0' cellpadding='0' border='0'>
		<tr>
			<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
			<td class='singlebutton'><a title="Add an Event" name='add' href="?add=add">Add an Event</a></td>
			<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
		</tr>
	</table>
	<?php if($num_rows == 0)
	{?>
		<p><b>There are currently no events.</b></p>
	<?php
	}
	else
	{?>
		<p><b>Page <?php echo "$page"; ?> of <?php echo "$numpages"; ?></b></p>
	<?php
	}

	if($num_rows != 0)
	{
		while($row = mysql_fetch_array($result2))
		{
			$date = date('d/m/Y', strtotime($row['Date']));
			$id = $row['ID'];
			$venue = $row['Venue'];?>
			<table width='600' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
				<tr>
					<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Event <?php echo $page;?></div></td>
				</tr>
				<tr>
					<th align='left' width='25%'>Date</th>
					<td><?php echo $date;?></td>
				</tr>
				<tr>
					<th align='left'>Venue</th>
					<td><?php echo $venue;?></td>
				</tr>
				<tr>
					<th align='left'>Event Type</th>
					<td><?php echo $row['Event_Type']; ?></td>
				</tr>
				<tr>
					<th align='left'>City</th>
					<td><?php echo $row['City']; ?></td>
				</tr>
				<tr>
					<th align='left'>Address</th>
					<td>
						<table>
							<tr>
								<td><?php echo $row['Address_Street'];?></td>
							</tr>
							<?php if($row['Address_Town'] != '') {?>
							<tr>
								<td><?php echo $row['Address_Town'];?></td>
							</tr>
							<?php }
							if($row['Address_City'] != '') {?>
							<tr>
								<td><?php echo $row['Address_City'];?></td>
							</tr>
							<?php } ?>
							<tr>
								<td><?php echo $row['Address_PostCode'];?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th align='left'>Age</th>
					<td><?php echo $row['Age'];?></td>
				</tr>
				<tr>
					<th align='left'>Time</th>
					<td><?php echo $row['Time'];?>pm</td>
				</tr>
				<tr>
					<th align='left'>Price</th>
					<td><?php if($row['Price'] == 0){echo "Free";}else{echo "&pound;" . $row['Price'];}?></td>
				</tr>
				<tr>
					<th align='left'>Description</th>
					<td><?php echo $row['Description'];?></td>
				</tr>
				<tr>
					<th align='left'>Availability</th>
					<td><?php echo $row['Availability'];?></td>
				</tr>
				<tr>
					<th align='left'>Image</th>
					<td><img src="../images/<?php echo $row['Image_Path'];?>" alt="<?php echo $venue;?>" border='0' height='150' /></td>
				</tr>
				<tr>
					<th align='left'>Max Male Ticket Quantity</th>
					<td><?php echo $row['MaxMaleQuantity'];?></td>
				</tr>
				<tr>
					<th align='left'>Max Female Ticket Quantity</th>
					<td><?php echo $row['MaxFemaleQuantity'];?></td>
				</tr>
				<?php
				if(stristr($venue, "'"))
				{
					$venue = str_replace("'", "\'", $venue);
				}?>
				<tr>
					<td colspan='2' align='center'>
					<!--<input type='button' name='edit' value='Amend Event' onclick="location.href='?edit=<?php echo $id;?>';" /><input type='button' name='delete' value='Delete Event' onclick="if(confirm('Are you sure you want to delete this event: <?php echo $venue;?>?')){location.href='?delete=<?php echo $id;?>&event=<?php echo $venue;?>';}" />-->
						<table cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title='Amend Event' name='edit' href="?edit=<?php echo $id;?>">Amend Event</a></td>
								<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
								<td>&nbsp;</td>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title="Delete" name='delete' onclick="if(confirm('Are you sure you want to delete this event: <?php echo $venue;?>?')){location.href='?delete=<?php echo $id;?>&event=<?php echo $venue;?>';}" href="#">Delete Event</a></td>
								<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
<?php	}
	} ?>

	<table align='center' cellspacing='2' cellpadding='2' border='0'>
		<tr>
		<?php
		if($page > 1)
		{
			$pagenum = $page - 1;
			$firstpage = 1;?>
			<td><form method='post' name='gofirst' action='?page=<?php echo $firstpage;?>'>
			<input type='hidden' name='first' />
			<!--<td><input name='first' value='<<' type='submit' class='button' /></form></td>-->
			<table cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
					<td class='singlebutton'><a title='Back to First Event' onclick="javascript:document.gofirst.submit();" href='#'><<</a></td>
					<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
				</tr>
  			</table>
  			</form>
  			</td>
			<td><form method='post' name='goprev' action='?page=<?php echo $pagenum;?>'>
			<input type='hidden' name='prev' />
			<!--<td><input name='back' value='<' type='submit' class='button' /></form></td>-->
			<table cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
					<td class='singlebutton'><a title='Back' onclick="javascript:document.goprev.submit();" href='#'><</a></td>
					<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
				</tr>
  			</table>
  			</form>
  			</td>
<?php	}
		if($page < $numpages && $page >= 1)
		{
			$pagenum = $page + 1;
			$lastpage = $numpages;?>
			<td><form method='post' name='gonext' action='?page=<?php echo $pagenum;?>'>
			<!--<td><input name='next' type='submit' value='>' class='button' /></form></td>-->
			<input type='hidden' name='next' />
			<table cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
					<td class='singlebutton'><a title='Next' onclick="javascript:document.gonext.submit();" href='#'>></a></td>
					<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
				</tr>
  			</table>
  			</form>
  			</td>
			<td><form method='post' name='golast' action='?page=<?php echo $lastpage;?>'>
			<!--<td><input name='last' type='submit' value='>>' class='button' /></form></td>-->
			<input type='hidden' name='last' />
			<table cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
					<td class='singlebutton'><a title='Go to Last Event' onclick="javascript:document.golast.submit();" href='#'>>></a></td>
					<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
				</tr>
  			</table>
  			</form>
  			</td>
<?php	}
		?>
		</tr>
	</table>
	<!--<p><form method='post' action='../admin/'><input type='submit' name='admin' value='Back to Main Admin Page' style='cursor:pointer;' /></form></p>-->
	<form method='post' name='mainadmin' action='../admin/'>
	<table cellspacing='0' cellpadding='0' border='0'>
	<input type='hidden' name='admin' />
		<tr>
			<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
			<td class='singlebutton'><a title='Back to Main Admin Page' onclick="javascript:document.mainadmin.submit();" href='#'>Back to Main Admin Page</a></td>
			<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
		</tr>
  	</table>
  	</form>
<?php
}
?>
</div>
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
    <p>&nbsp;</p>
        <p>&nbsp;</p>
</div>


<!-- end inner content -->

</div>
</div>
<div id="footer">
<div class="footer2col1"><a href="../terms.php">TERMS</a>&nbsp;|&nbsp;<a href="../sitemap.php">SITE MAP</a>&nbsp;|&nbsp;<a class='active' href="../admin/">ADMINISTRATOR</a>&nbsp;|&nbsp;<a class='active' href="../admin/logout.php">LOG OUT</a></div></div>
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