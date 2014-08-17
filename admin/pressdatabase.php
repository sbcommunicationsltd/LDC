<?php session_start();
include '../database/databaseconnect.php';

if(!isset($_SESSION['admin_is_logged_in'])){
	header('Location: login.php');
}
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
	<img src="../images/press.gif" alt="Press" width="89" height="50"/>
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
			<td><img src="../images/<?php echo $row2['Image_Path'];?>" border='0' height='200' width='309' /></td>
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
				<p><img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                --><input type='submit' class='singlebuttoncenter' alt='Amend Press Release' value='Amend Event' /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                --><input type='button' class='singlebuttoncenter' value='Back to Admin Press Area' onclick="location.href='../admin/pressdatabase.php';" /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                </p>
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
				<p><img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
				--><input type='submit' class='singlebuttoncenter' alt='Add Press Release' value='Add Press Release' /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                --><input type='button' class='singlebuttoncenter' value='Back to Admin Press Area' onclick="location.href='../admin/pressdatabase.php';" /><!--
                --><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                </p>
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
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
    <input type='button' class='singlebutton' value='Add an Press Release' onclick="location.href='?add=add';" />
    <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
    </p>
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
					<td><img src="../images/<?php echo $row['Image_Path'];?>" border='0' height='200' width='309' /></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
                        <p><img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
						--><input type='button' class='singlebuttoncenter' value='Amend Press Release' onclick="location.href='?edit=<?php echo $id;?>';" /><!--
						--><img src="../images/sumi_buttons_06.png" alt="" class='singlebuttoncenterside' />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="../images/sumi_buttons_04.png" alt="" class='singlebuttoncenterside' /><!--
                        --><input type='button' class='singlebuttoncenter' value='Delete Press Release' alt="Delete" name='delete' onclick="if(confirm('Are you sure you want to delete this press release: <?php echo $date;?>?')){location.href='?delete=<?php echo $id;?>&date=<?php echo $date;?>';}" /><!--
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
            <input type='submit' class='singlebutton' value='>>' alt='Go to Last Press Release' />
            <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
            </p>
  			</form>
  			</td>
<?php	}
		?>
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
}
?>

<div class="clear"></div>
       <div class="spacebreak"></div>
    </div>
    
   
    <?php include('../footer.php');?>
   
</body>

</html>