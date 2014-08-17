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
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: ADMIN AREA - PRESS ::  Asian Dinner Club</title>
<meta name="description" content="London Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
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
	<img src="../images/press.gif" alt="Press" width="89" height="50"/>
<div>
<h2 align='center'>Press Releases</h2>

<!-- DELETE SECTION! -->
<?php if(isset($_GET['delete']))
{
	$delid = $_GET['delete'];
	$deleve = $_GET['date'];
	$quer = "SELECT Image_Path FROM Press WHERE ID = $delid";
	$resu = mysql_query($quer) or die(mysql_error());
	$ro = mysql_fetch_array($resu);
	if(file_exists('../images/' . $ro[0]))
	{
		unlink('../images/' . $ro[0]);
	}
	$query3 = "DELETE FROM Press WHERE ID = $delid";
	$result3 = mysql_query($query3) or die(mysql_error());
	$que = "SELECT ID FROM Press WHERE ID > $delid";
	$res = mysql_query($que) or die(mysql_error());
	while($rowarrange = mysql_fetch_array($res))
	{
		$idnew = $rowarrange[0] - 1;
		$idold = $rowarrange[0];
		$qu = "UPDATE Press SET ID = '$idnew' WHERE ID = '$idold'";
		$re = mysql_query($qu) or die(mysql_error());
    }
	?>
	<script>
	alert("Thanks - Press Release '<?php echo $deleve;?> Deleted!");
	location.href='../admin/pressdatabase.php';
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

	/*if($_POST['Date'] < date('Y-m-d'))
	{
		$errors[] = 'The date provided is in the past';
	}*/

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

		$da = $_POST['Date'];
		$da = str_replace('-', '', $da);

		$suffix='';
		if(file_exists("$target_path$da$suffix.$extension"))
		{
			$suffix = 0;
			while(file_exists("$target_path$da$suffix.$extension"))
			{
				$suffix++;
			}
		}

		$editfile = $da . $suffix . '.' . $extension;
		$target_path = $target_path . $editfile;

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

		$_POST['Image_Path'] = $editfile;
	}
	else
	{
		$_POST['Image_Path'] = $_POST['image'];
	}

	$query5 = "SELECT * FROM Press";
	$result5 = mysql_query($query5) or die(mysql_error());
	$numfields = mysql_num_fields($result5);

	for ($i=0; $i < $numfields; $i++)
	{
		$fieldname[] = mysql_field_name($result5, $i);
	}

	foreach ($fieldname as $field)
	{
		if($field!='Image_Path' && $field!='Hyperlink')
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
		$editdate = $_POST['Date'];

		if(strpos($_POST['Article'], "\r\n") !== false)
		{
			$_POST['Article'] = str_replace("\r\n", '<br/>', $_POST['Article']);
		}

		/*$pos = strpos($_POST['Article'], 'http://');
		if($pos!==false)
		{
			$part = substr($_POST['Article'], $pos);
			if(strpos($part, ' ')!==false)
			{
				$pos2 = strpos($part, ' ');
				$part2 = substr($part, $pos2);
				$link = str_replace($part2, '', $part);
			}
			else
			{
				$link = $part;
			}
			if(strpos($part, '</a>')===false)
			{
				$length = strlen($link);
				$insert = '<a href="' . $link . '">' . $link . '</a>';
				$_POST['Article'] = substr_replace($_POST['Article'], $insert, $pos, $length);
			}
		}*/

		if($_POST['Hyperlink'] != '')
		{
			if(strpos($_POST['Hyperlink'], 'http://')===false)
			{
				$_POST['Hyperlink'] = 'http://' . $_POST['Hyperlink'];
			}
		}


		$query6 = "UPDATE Press SET ";
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
		alert("Thanks - Press Release '<?php echo $editdate;?>' Details Amended!");
		location.href='../admin/pressdatabase.php';
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
	$query4 = "SELECT * FROM Press WHERE ID = $editid";
	$result4 = mysql_query($query4) or die(mysql_error());
	$row2 = mysql_fetch_array($result4);
	if(isset($_POST['submitedit']) && !empty($errors))
	{
		$dateday = $_POST['Date_Day'];
		$datemonth = $_POST['Date_Month'];
		$dateyear = $_POST['Date_Year'];
		$title = $_POST['Title'];
		$summary = $_POST['Summary'];
		$article = $_POST['Article'];
	}
	else
	{
		$Date = $row2['Date'];
		$arrdate = split("-", $Date);
		$dateday = $arrdate[2];
		$datemonth = $arrdate[1];
		$dateyear = $arrdate[0];
		$title = $row2['Title'];
		$summary = $row2['Summary'];
		$article = $row2['Article'];
	}

	if(strpos($article, '<br/>')!==false)
	{
		$articlepart = explode('<br/>', $article);
		$article = implode("\r\n", $articlepart);
	}
	?>

	<form method='post' name='editpress' enctype="multipart/form-data">
	<table width='600' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
		<tr>
			<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Edit this Press Release</div></td>
		</tr>
		<input type='hidden' name='ID' value="<?php echo $row2['ID'];?>" />
		<tr>
			<th>Date:</th>
			<td><select name="Date_Day"><option value="">Day</option>
			<?php
					for($days=1 ; $days<=31 ; $days++)
					{
						echo "<option value=\"$days\""; if ($dateday==$days){ echo "selected=\"selected\"";} echo ">"; if(strlen($days)==1){echo "0";} echo "$days</option>";
					}
			echo "</select> / <select name=\"Date_Month\"><option value=\"\">Month</option>";
					for($month=1 ; $month<=12 ; $month++)
					{
						echo "<option value=\"$month\""; if ($datemonth==$month){ echo "selected=\"selected\"";} echo ">"; if(strlen($month)==1){echo "0";} echo "$month</option>";
					}
			echo "</select> / <select name=\"Date_Year\"><option value=\"\">Year</option>";
					for($year=2009 ; $year<=2030 ; $year++)
					{
						echo "<option value=\"$year\""; if ($dateyear==$year){ echo "selected=\"selected\"";} echo ">$year</option>";
					} ?>
			</select></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<th>Title:</th>
			<td><input type='text' name='Title' size='66' value="<?php echo $title;?>" /></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<th valign='top'>Summary:</th>
			<td><textarea name='Summary' rows="4" cols="80" class='fontstyle3'><?php echo $summary;?></textarea></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<th valign='top'>Article:</th>
			<td><textarea name='Article' rows="12" cols="80" class='fontstyle3'><?php echo $article;?></textarea></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<th>Hyperlink:</th>
			<td><input type='text' name='Hyperlink' size='66' value="<?php if(isset($_POST['Hyperlink'])){echo $_POST['Hyperlink'];}else{echo $row2['Hyperlink'];}?>" /></td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
		<tr>
			<th valign='top'>Image:</th>
			<td><img src="../images/<?php echo $row2['Image_Path'];?>" border='0' height='150' /></td>
			<input type='hidden' name='image' value="<?php echo $row2['Image_Path'];?>" />
		</tr>
		<tr>
			<td>To change above image - input the path to the new image below</td>
			<td><input name="uploadedfile" type="file" /></td>
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
						<td class='singlebutton'><a title='Amend Press Release' onclick="javascript:document.editpress.submit();" href='#'>Amend Press Release</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
						<td>&nbsp;</td>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title="Back" name='back' href="../admin/pressdatabase.php">Back to Admin Press Area</a></td>
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

	/*if($_POST['Date'] < date('Y-m-d'))
	{
		$errors[] = 'The date provided is in the past!';
	}*/

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

		$newda = $_POST['Date'];
		$newda = str_replace('-', '', $newda);

		$suffix='';
		if(file_exists("$target_path$newda$suffix.$extension"))
		{
			$suffix = 0;
			while(file_exists("$target_path$newda$suffix.$extension"))
			{
				$suffix++;
			}
		}

		$newfile = $newda . $suffix . '.' . $extension;

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

	$query7 = "SELECT * FROM Press";
	$result7 = mysql_query($query7) or die(mysql_error());
	$numfields = mysql_num_fields($result7);

	for ($i=0; $i < $numfields; $i++)
	{
		$fieldname[] = mysql_field_name($result7, $i);
	}

	foreach ($fieldname as $field)
	{
		if($field!='Image_Path' && $field!='ID' && $field!='Hyperlink')
		{
			$formvar = $_POST[$field];
			//echo $formvar;
			if ($formvar=="")
			{
				$errors[] = "You forgot to enter the '$field'.";
			}
		}
	}

	if(empty($errors))
	{
		$adddate = $_POST['Date'];
		if(strpos($_POST['Article'], "\r\n") !== false)
		{
			$_POST['Article'] = str_replace("\r\n", '<br/>', $_POST['Article']);
		}

		if($_POST['Hyperlink'] != '')
		{
			if(strpos($_POST['Hyperlink'], 'http://')===false)
			{
				$_POST['Hyperlink'] = 'http://' . $_POST['Hyperlink'];
			}
		}

		$findid = "SELECT MAX(ID) FROM Press";
		$idres = mysql_query($findid) or die(mysql_error());
		$rowid = mysql_fetch_array($idres);
		$maxid = $rowid[0] + 1;
		$query8 = "INSERT INTO Press VALUES('$maxid', ";
		foreach ($fieldname as $field)
		{
			if($field!='ID')
			{
				$formvar = $_POST[$field];
				$formvar = addslashes($formvar);
				$query8 .= "'$formvar', ";
			}
		}
		$query8 = substr($query8, 0, -2) . ')';
		//echo $query8;
		mysql_query($query8) or die(mysql_error());
		?>
		<script>
		alert("Thanks - Press Release '<?php echo $adddate;?>' Details Added!");
		location.href='../admin/pressdatabase.php';
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
	<form method='post' name='addpress' enctype="multipart/form-data">
		<table width='600' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
			<tr>
				<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Add a Press Release</div></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th>Date:</th>
				<td><select name="Date_Day"><option value="">Day</option>
				<?php
						for($days=1 ; $days<=31 ; $days++)
						{
							echo "<option value=\"$days\""; if($days == $_POST['Date_Day']){echo "selected='selected'";} echo ">"; if(strlen($days)==1){echo "0";} echo "$days</option>";
						}
				echo "</select> / <select name=\"Date_Month\"><option value=\"\">Month</option>";
						for($month=1 ; $month<=12 ; $month++)
						{
							echo "<option value=\"$month\""; if($month == $_POST['Date_Month']){echo "selected='selected'";} echo ">"; if(strlen($month)==1){echo "0";} echo "$month</option>";
						}
				echo "</select> / <select name=\"Date_Year\"><option value=\"\">Year</option>";
						for($year=2009 ; $year<=2030 ; $year++)
						{
							echo "<option value=\"$year\""; if($year == $_POST['Date_Year']){echo "selected='selected'";} echo ">$year</option>";
						} ?>
				</select></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th>Title:</th>
				<td><input type='text' name='Title' size='66' value="<?php echo $_POST['Title'];?>" /></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th valign='top'>Summary:</th>
				<td><textarea name='Summary' rows="4" cols="80" class='fontstyle3'><?php echo $_POST['Summary'];?></textarea></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th valign='top'>Article:</th>
				<td><textarea name='Article' rows="12" cols="80" class='fontstyle3'><?php echo $_POST['Article'];?></textarea></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<th>Hyperlink:</th>
				<td><input type='text' name='Hyperlink' size='66' value="<?php echo $_POST['Hyperlink'];?>" /></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<tr>
				<th>Upload Image:</th>
				<td><input name="uploadedfile" type="file" /></td>
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
						<td class='singlebutton'><a title='Add Press Release' onclick="javascript:document.addpress.submit();" href='#'>Add Press Release</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
						<td>&nbsp;</td>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title="Back" name='back' href="../admin/pressdatabase.php">Back to Admin Press Area</a></td>
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
	$query = "SELECT * FROM Press ORDER BY Date ASC";
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
			<td class='singlebutton'><a title="Add a Press Release" name='add' href="?add=add">Add a Press Release</a></td>
			<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
		</tr>
	</table>
	<?php if($num_rows == 0)
	{?>
		<p><b>There are currently no press releases.</b></p>
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
			$id = $row['ID'];?>
			<table width='500' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
				<tr>
					<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Press Release <?php echo $page;?></div></td>
				</tr>
				<tr>
					<th align='left'>Date:</th>
					<td><?php echo $date;?></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<th align='left'>Title:</th>
					<td><?php echo $row['Title'];?></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<th valign='top'>Summary:</th>
					<td><?php echo $row['Summary'];?></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<th align='left' valign='top'>Article:</th>
					<td><?php echo $row['Article'];?></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<th align='left'>Hyperlink:</th>
					<td><?php echo $row['Hyperlink'];?></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<th align='left' valign='top'>Image:</th>
					<td><img src="../images/<?php echo $row['Image_Path'];?>" border='0' height='150' /></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
					<!--<input type='button' name='edit' value='Amend Event' onclick="location.href='?edit=<?php echo $id;?>';" /><input type='button' name='delete' value='Delete Event' onclick="if(confirm('Are you sure you want to delete this event: <?php echo $venue;?>?')){location.href='?delete=<?php echo $id;?>&event=<?php echo $venue;?>';}" />-->
						<table cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title='Amend Press Release' name='edit' href="?edit=<?php echo $id;?>">Amend Press Release</a></td>
								<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
								<td>&nbsp;</td>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title="Delete" name='delete' onclick="if(confirm('Are you sure you want to delete this press release: <?php echo $date;?>?')){location.href='?delete=<?php echo $id;?>&date=<?php echo $date;?>';}" href="#">Delete Press Release</a></td>
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
					<td class='singlebutton'><a title='Back to First Press Release' onclick="javascript:document.gofirst.submit();" href='#'><<</a></td>
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
					<td class='singlebutton'><a title='Go to Last Press Release' onclick="javascript:document.golast.submit();" href='#'>>></a></td>
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