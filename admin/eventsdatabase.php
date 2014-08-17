<?php session_start();
include '../database/databaseconnect.php';

if(!isset($_SESSION['admin_is_logged_in'])){
	header('Location: login.php');
}?>
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
<script>
function show(id, id2) {
    var style = document.getElementById(id2).style;
    
    if (document.getElementById(id).value == '35+' || document.getElementById(id).value == '30+') {
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
	<img src="../images/current_events.gif" alt="Events" width="210" height="50"/>
<p>&nbsp;</p>
<h2 align='center'>Event Organiser's Schedule</h2>

<!-- DELETE SECTION! -->
<?php 
if(isset($_GET['delete']))
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
    }?>
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
			if (isset($_POST[$field]) && $formvar=="")
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
				if (isset($_POST[$field])) {
                    $formvar = $_POST[$field];
                    $formvar = addslashes($formvar);
                    $query6 .= "$field = '$formvar', ";
                }
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
		}?>
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
	$dateyear = $arrdate[0];?>
	<form method='post' name='editevent' enctype="multipart/form-data">
	<table width='600' class='fontstyle' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
		<tr>
			<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Edit this Event</div>
            <input type='hidden' name='ID' value="<?php echo $row2['ID'];?>" /></th>
		</tr>
        <!--<tr>
			<th align='left'>Event Title</th>
			<td><input type='text' name='Event_Title' size='40' value="<?php if(isset($_POST['Event_Title'])){echo $_POST['Event_Title'];}else{echo $row2['Event_Title'];}?>" /></td>
		</tr>-->
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
		<tr>
			<th align='left'>Time</th>
			<td><select name="Time"><option value="">Time</option>
				<?php
				/*for ($i = 12; $i <= 21; $i++)
				{
    				if($i == 21)
    				{
    					$mins = array('.00', '.15', '.30');
    				}
    				else
    				{
    					$mins = array('.00', '.15', '.30', '.45');
    				}

    				foreach($mins as $min)
    				{
    					$time = "$i" . $min;
    					echo "<option value='$time'"; if(isset($_POST['Time'])){if($_POST['Time'] == $time){echo "selected='selected'";}}else{if($row2['Time'] == $time){echo "selected='selected'";}} echo ">$time</option>";
    				}
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
			<td><img src="../images/<?php echo $row2['Image_Path'];?>" alt="<?php echo $row2['Venue'];?>" border='0' height='200' width='309' /></td>
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
                <p><img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                --><input type='submit' class='singlebuttoncenter' alt='Amend Event' value='Amend Event' /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                --><input type='button' class='singlebuttoncenter' value='Back to Admin Event Area' onclick="location.href='../admin/eventsdatabase.php';" /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                </p>
			</td>
		</tr>
	</table>
	</form>
<?php
}?>
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
			if (isset($_POST[$field]) && $formvar=="")
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
		$query8 = "INSERT INTO Events (" . implode(', ', $fieldname) . ") VALUES ('$maxid', ";
		foreach ($fieldname as $field)
		{
			if($field!='ID')
			{
				if (isset($_POST[$field])) {
                    $formvar = $_POST[$field];
                    $formvar = addslashes($formvar);
                } else {
                    $formvar = '';
                }
				$query8 .= "'$formvar', ";
			}
		}
		$query8 = substr($query8, 0, -2) . ")";
		mysql_query($query8) or die(mysql_error());?>
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
		<table width='600' class='fontstyle' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
			<tr>
				<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Add an Event</div></td>
			</tr>
            <!--<tr>
				<th align='left'>Event Title</th>
				<td><input type='text' name='Event_Title' size='40' value="<?php echo $_POST['Event_Title'];?>" /></td>
			</tr>-->
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
				<th align='left'>Time</th>
				<td><select name="Time"><option value="">Time</option>
					<?php
					for ($i = 12; $i <= 21; $i++)
					{
    					if($i == 21)
    					{
    						$mins = array('.00', '.15', '.30');
    					}
    					else
    					{
    						$mins = array('.00', '.15', '.30', '.45');
    					}

    					foreach($mins as $min)
    					{
                            $time = "$i" . $min;
    						echo "<option value='$time' "; if($time == $_POST['Time']){echo "selected='selected'";} echo ">$time</option>";
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
				<p><img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
				--><input type='submit' class='singlebuttoncenter' alt='Add Event' value='Add Event' /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                --><input type='button' class='singlebuttoncenter' value='Back to Admin Event Area' onclick="location.href='../admin/eventsdatabase.php';" /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                </p>
				</td>
			</tr>
		</table>
	</form>
	<?php
}?>
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
	}?>
    <p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
    <input type='button' class='singlebutton' value='Add an Event' onclick="location.href='?add=add';" />
    <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
    </p>
    <p>&nbsp;</p>
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
			<table width='600' class='fontstyle' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
				<tr>
					<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Event <?php echo $page;?></div></td>
				</tr>
                <!--<tr>
					<th align='left' width='25%'>Event Title</th>
					<td><?php echo $row['Event_Title'];?></td>
				</tr>-->
				<tr>
					<th align='left'>Date</th>
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
					<th align='left'>Address</th>
					<td>
						<table>
							<tr>
								<td><?php echo $row['Address_Street'];?></td>
							</tr>
							<?php 
                            if($row['Address_Town'] != '') {?>
							<tr>
								<td><?php echo $row['Address_Town'];?></td>
							</tr>
							<?php 
                            }
							if($row['Address_City'] != '') {?>
							<tr>
								<td><?php echo $row['Address_City'];?></td>
							</tr>
							<?php 
                            } ?>
							<tr>
								<td><?php echo $row['Address_PostCode'];?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th align='left'>Time</th>
					<td><?php echo $row['Time'];?></td>
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
					<td><img src="../images/<?php echo $row['Image_Path'];?>" alt="<?php echo $venue;?>" border='0' height='200' width='309' /></td>
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
						<p><img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
						--><input type='button' class='singlebuttoncenter' value='Amend Event' onclick="location.href='?edit=<?php echo $id;?>';" /><!--
						--><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                        --><input type='button' class='singlebuttoncenter' value='Delete Event' alt="Delete" name='delete' onclick="if(confirm('Are you sure you want to delete this event: <?php echo $venue;?>?')){location.href='?delete=<?php echo $id;?>&event=<?php echo $venue;?>';}" /><!--
                        --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                        </p>
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
			<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
            <input type='submit' class='singlebutton' alt='Back to First Event' value='<<' />
            <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
            </p>
  			</form>
  			</td>
			<td><form method='post' name='goprev' action='?page=<?php echo $pagenum;?>'>
			<input type='hidden' name='prev' />
            <p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
            <input type='submit' class='singlebutton' alt='Back' value='<' />
            <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
            </p>
  			</form>
  			</td>
<?php	}

		if($page < $numpages && $page >= 1)
		{
			$pagenum = $page + 1;
			$lastpage = $numpages;?>
			<td><form method='post' name='gonext' action='?page=<?php echo $pagenum;?>'>
			<input type='hidden' name='next' />
			<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
			<input type='submit' class='singlebutton' alt='Next' value='>' />
			<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
            </p>
  			</form>
  			</td>
			<td><form method='post' name='golast' action='?page=<?php echo $lastpage;?>'>
			<input type='hidden' name='last' />
			<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
            <input type='submit' class='singlebutton' value='>>' alt='Go to Last Event' />
            <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
            </p>
  			</form>
  			</td>
<?php	
        }?>
		</tr>
	</table>
	<form method='post' name='mainadmin' action='../admin/'>
	<input type='hidden' name='admin' />
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
    <input type='submit' value='Back to Main Admin Page' class='singlebutton' />
    <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
    </p>
  	</form>
<?php
}?>
<div class="clear"></div>
       <div class="spacebreak"></div>
    </div>
    
   
    <?php include('../footer.php');?>
   
</body>
</html>