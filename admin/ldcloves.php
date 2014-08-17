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
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: ADMIN AREA - LDC Loves ::  London Dinner Club</title>
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


<div id="contentcol1">
	<h2>Admin Area</h2>
	<img src="../images/ldcloves.png" alt="London Dinner Club Loves" width="436" height="50"/>
<div>
<!-- DELETE SECTION! -->
<?php if(isset($_GET['delete']))
{
	$delid = $_GET['delete'];
	$deleve = $_GET['title'];
	$quer = "SELECT Image_Path FROM LoveItems WHERE ID = $delid";
	$resu = mysql_query($quer) or die(mysql_error());
	$ro = mysql_fetch_array($resu);
	if(file_exists('../member/images/' . $ro[0]))
	{
		unlink('../member/images/' . $ro[0]);
	}
	$query3 = "DELETE FROM LoveItems WHERE ID = $delid";
	$result3 = mysql_query($query3) or die(mysql_error());
	$que = "SELECT ID FROM LoveItems WHERE ID > $delid";
	$res = mysql_query($que) or die(mysql_error());
	while($rowarrange = mysql_fetch_array($res))
	{
		$idnew = $rowarrange[0] - 1;
		$idold = $rowarrange[0];
		$qu = "UPDATE LoveItems SET ID = '$idnew' WHERE ID = '$idold'";
		$re = mysql_query($qu) or die(mysql_error());
    }
	?>
	<script>
	alert("Thanks - Item '<?php echo $deleve;?> Deleted!");
	location.href='ldcloves.php';
	</script>
	<?php
}?>
<!-- DELETE SECTION ENDED-->


<!--EDIT SECTION-->
<?php
if(isset($_POST['submitedit']))
{
	$errors = array();

	$target_path = "../member/images/";

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

		$newda = date("Y-m-d");
		$newda = str_replace("-", '' , $newda);

		$suffix='';
		if(file_exists("$target_path$newda$suffix.$extension"))
		{
			$suffix = 0;
			while(file_exists("$target_path$newda$suffix.$extension"))
			{
				$suffix++;
			}
		}

		$editfile = $newda . $suffix . '.' . $extension;
		$target_path = $target_path . $editfile;


		if($_POST['MAX_FILE_SIZE'] < $_FILES['uploadedfile']['size'])
		{
			$errors[] = "The file size is too big for the server. Please reduce the size!";
		}

		if($extension!='jpg' && $extension!='jpeg' && $extension!='gif')
		{
			$errors[] = "Your uploaded file must be of JPG or GIF. Other file types are not allowed";
		}

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

	$query5 = "SELECT * FROM LoveItems";
	$result5 = mysql_query($query5) or die(mysql_error());
	$numfields = mysql_num_fields($result5);

	for ($i=0; $i < $numfields; $i++)
	{
		$fieldname[] = mysql_field_name($result5, $i);
	}

	foreach ($fieldname as $field)
	{
		if($field!='Image_Path')
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

		if(strpos($_POST['Description'], "\r\n") !== false)
		{
			$_POST['Description'] = str_replace("\r\n", '<br/>', $_POST['Description']);
		}

		if(strpos($_POST['Hyperlink'], 'http://')===false)
		{
			$_POST['Hyperlink'] = 'http://' . $_POST['Hyperlink'];
		}

		$query6 = "UPDATE LoveItems SET ";
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
			if(file_exists('../member/images/' . $_POST['image']))
			{
				unlink('../member/images/' . $_POST['image']);
			}
		}
		?>
		<script>
		alert("Thanks - Item '<?php echo $title;?>' Details Amended!");
		location.href='ldcloves.php';
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
			if(file_exists('../member/images/' . $editfile))
			{
				unlink('../member/images/' . $editfile);
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
	$query4 = "SELECT * FROM LoveItems WHERE ID = $editid";
	$result4 = mysql_query($query4) or die(mysql_error());
	$row2 = mysql_fetch_array($result4);

	if(isset($_POST['Description']))
	{
		$description = $_POST['Description'];
		$title = $_POST['Title'];
	}
	else
	{
		$description = $row2['Description'];
		$title = $row2['Title'];
	}

	if(strpos($description, '<br/>')!==false)
	{
		$descriptionpart = explode('<br/>', $description);
		$description = implode("\r\n", $descriptionpart);
	}

	if(strpos($title, "\'")!==false)
	{
		$title = str_replace("\'", "'", $title);
	}

	if(strpos($title, '\"')!==false)
	{
		$title = str_replace('\"', '"', $title);
	}

	if(strpos($description, "\'")!==false)
	{
		$description = str_replace("\'", "'", $description);
	}

	if(strpos($description, '\"')!==false)
	{
		$description = str_replace('\"', '"', $description);
	}

	?>

	<form method='post' name='edititem' enctype="multipart/form-data">
	<table width='600' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
		<tr>
			<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Edit this Item</div></td>
		</tr>
		<input type='hidden' name='ID' value="<?php echo $row2['ID'];?>" />
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
			<th valign='top'>Description:</th>
			<td><textarea name='Description' rows="5" cols="80" class='fontstyle3'><?php echo $description;?></textarea></td>
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
			<th valign='top'>Logo:</th>
			<td><img src="../member/images/<?php echo $row2['Image_Path'];?>" border='0' height='150' alt="<?php echo $title;?>" /></td>
			<input type='hidden' name='image' value="<?php echo $row2['Image_Path'];?>" />
		</tr>
		<tr>
			<td>To change above logo - input the path to the new logo below</td>
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
						<td class='singlebutton'><a title='Amend Love Item' onclick="javascript:document.edititem.submit();" href='#'>Amend</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
						<td>&nbsp;</td>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title="Back" name='back' href="../admin/ldcloves.php">Back to Admin LDC Loves Area</a></td>
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

	$target_path = "../member/images/";


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

		$da = date('Y-m-d');
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

		$newfile = $da . $suffix . '.' . $extension;

		$target_path = $target_path . $newfile;

		if($_POST['MAX_FILE_SIZE'] < $_FILES['uploadedfile']['size'])
		{
			$errors[] = "The file size is too big for the server. Please reduce the size!";
		}

		if($extension!='jpg' && $extension!='jpeg' && $extension!='gif')
		{
			$errors[] = "Your uploaded file must be of JPG or GIF. Other file types are not allowed";
		}

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

	$query7 = "SELECT * FROM LoveItems";
	$result7 = mysql_query($query7) or die(mysql_error());
	$numfields = mysql_num_fields($result7);

	for ($i=0; $i < $numfields; $i++)
	{
		$fieldname[] = mysql_field_name($result7, $i);
	}

	foreach ($fieldname as $field)
	{
		if($field!='Image_Path' && $field!='ID')
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
		if(strpos($_POST['Description'], "\r\n") !== false)
		{
			$_POST['Description'] = str_replace("\r\n", '<br/>', $_POST['Description']);
		}

		if(strpos($_POST['Hyperlink'], 'http://')===false)
		{
			$_POST['Hyperlink'] = 'http://' . $_POST['Hyperlink'];
		}

		$quer = "SELECT MAX(ID) FROM LoveItems";
		$res = mysql_query($quer) or die(mysql_error());
		$ro = mysql_fetch_array($res);
		$maxid = $ro[0] + 1;
		$query8 = "INSERT INTO LoveItems VALUES('$maxid', ";
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
		mysql_query($query8) or die(mysql_error());
		$newtitle = $_POST['Title'];
		?>
		<script>
		alert("Thanks - Item '<?php echo $newtitle;?>' Details Added!");
		location.href='ldcloves.php';
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
			if(file_exists('../member/images/' . $newfile))
			{
				unlink('../member/images/' . $newfile);
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
	<form method='post' name='additem' enctype="multipart/form-data">
		<table width='600' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
			<tr>
				<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">Add Item</div></td>
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
				<th valign='top'>Description:</th>
				<td><textarea name='Description' rows="5" cols="80" class='fontstyle3'><?php echo $_POST['Description'];?></textarea></td>
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
				<th>Upload Logo:</th>
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
						<td class='singlebutton'><a title='Add Love Item' onclick="javascript:document.additem.submit();" href='#'>Add</a></td>
						<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
						<td>&nbsp;</td>
						<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
						<td class='singlebutton'><a title="Back" name='back' href="../admin/ldcloves.php">Back to Admin LDC Loves Area</a></td>
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
	$query = "SELECT * FROM LoveItems ORDER BY ID ASC";
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
			<td class='singlebutton'><a title="Add a Love Item" name='add' href="?add=add">Add an Item</a></td>
			<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
		</tr>
	</table>
	<?php if($num_rows == 0)
	{?>
		<p><b>There are currently no items.</b></p>
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
			$id = $row['ID'];
			$title = $row['Title'];
			if(strpos($title, "\'")!==false)
			{
				$title = str_replace("\'", "'", $title);
			}

			if(strpos($title, '\"')!==false)
			{
				$title = str_replace('\"', '"', $title);
			}

			if(strpos($row['Description'], "\'")!==false)
			{
				$row['Description'] = str_replace("\'", "'", $row['Description']);
			}

			if(strpos($row['Description'], '\"')!==false)
			{
				$row['Description'] = str_replace('\"', '"', $row['Description']);
			}?>
			<table width='500' align='center' style="border:1px solid #d0d3d5; background-color:transparent;" cellspacing='2' cellpadding='2'>
				<tr>
					<th colspan="2" bgcolor="#EAC117"><div style="color: #00225d;">London Dinner Club Loves... <?php echo $page;?></div></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<th align='left'>Title:</th>
					<td><?php echo $title;?></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<th align='left' valign='top'>Description:</th>
					<td><?php echo $row['Description'];?></td>
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
					<td><img src="../member/images/<?php echo $row['Image_Path'];?>" border='0' height='150' alt="<?php echo $title;?>" /></td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
				<?php
				if(strpos($title, "'")!==false)
				{
					$title = str_replace("'", "\'", $title);
				}

				if(strpos($title, '"')!==false)
				{
					$title = str_replace('"', '\"', $title);
				}?>
					<td colspan='2' align='center'>
					<!--<input type='button' name='edit' value='Amend Event' onclick="location.href='?edit=<?php echo $id;?>';" /><input type='button' name='delete' value='Delete Event' onclick="if(confirm('Are you sure you want to delete this event: <?php echo $venue;?>?')){location.href='?delete=<?php echo $id;?>&event=<?php echo $venue;?>';}" />-->
						<table cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title='Amend Love Item' name='edit' href="?edit=<?php echo $id;?>">Amend</a></td>
								<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
								<td>&nbsp;</td>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title="Delete" name='delete' onclick="if(confirm('Are you sure you want to delete this item: <?php echo $title;?>?')){location.href='?delete=<?php echo $id;?>&title=<?php echo $title;?>';}" href="#">Delete</a></td>
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
					<td class='singlebutton'><a title='Back to First Item' onclick="javascript:document.gofirst.submit();" href='#'><<</a></td>
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
					<td class='singlebutton'><a title='Go to Last Item' onclick="javascript:document.golast.submit();" href='#'>>></a></td>
					<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
				</tr>
  			</table>
  			</form>
  			</td>
<?php	}
		?>
		</tr>
	</table>
	<p>&nbsp;</p>
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