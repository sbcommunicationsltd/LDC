<html>
<head>
<style type='text/css'>
.table {
	font-size:11px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	height: 20px;
	cursor:pointer;
}

.tablehover {
	background-color: #ec008c;
}

.singlebutton {
	 background-image:url(../images/sumi_buttons_05.png);
	 background-repeat:repeat-x;
}

.singlebutton a {
	text-decoration:none;
	color:white;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:bold;
	cursor:pointer;
}
</style>
</head>
<body style="background-color:transparent;">
<?php session_start();
include '../database/databaseconnect.php';

if($_GET['approved'] == 'true')
{
	$query2 = "SELECT * FROM Members WHERE Approved = 'No'";
	$result2 = mysql_query($query2) or die(mysql_error());
	if(mysql_num_rows($result2) != 0)
	{
		$adds = array();
		while($row2 = mysql_fetch_array($result2))
		{
			$id = $row2['ID'];
			$joined = $row2['DateJoined'];
			$expire = date('Y-m-d H:i', strtotime(date("Y-m-d H:i", strtotime($joined)) . " +1 year"));
			
			$query3 = "UPDATE Members SET Approved = 'Yes', DateExpire = '$expire' WHERE ID = $id";
			$result3 = mysql_query($query3) or die(mysql_error());
			
			$to = $row2['EmailAddress'];
			//$to = 'sumita.biswas@gmail.com';
			$subject = 'Membership to London Dinner Club';
			$body = "Dear Member,\n";
			$body .= "\nThank you for contacting London Dinner Club.\n";
			$body .= "\nIf you could let me know the type of person you are hoping to meet, this would help me when planning seating arrangements for any dinner party you may attend.\n";
			$body .= "\nTo book tickets please find below your member username and password:\n";
			$body .= "\nUsername: member\nPassword: paris\n";
			$body .= "\nOur events do get booked up quickly, so if you can plan ahead, that would hopefully ensure you can attend the events.\n";
			$body .= "\nWe hope to see you soon.\n";
			$body .= "\nThanks,\nAdrianna\n";
			$body .= "\nLondon Dinner Club\nMembership Manager";
			$headers = "From: London Dinner Club <sales@londondinnerclub.org> \r\n";

			if(!mail($to, $subject, $body, $headers))
			{
				$adds[] = $row2['EmailAddress'];
			}
		}

		if(empty($adds))
		{
			echo '<p><b>Thank You!</b></p><p>All your members have been approved!</p>';
		}
		else
		{
			foreach($adds as $add)
			{
				$addresses .= '$add';
			}?>
			<p><b>System Error</b></p><p>A system error has occurred. The following emails did not go through:<br />
			<?php echo 'mailto:' . $addresses;?></p><p>Please manually email these addresses to approve these members by clicking on the individual links. Thanks</p>
<?php	}
	}
}

$query = "SELECT * FROM Members";
$result2 = mysql_query($query) or die(mysql_error());
$app = 'true';
while($rows = mysql_fetch_array($result2))
{
	if($rows['Approved'] == 'No')
	{
		$app = 'false';
	}
}

if($app == 'false')
{?>
	<!--<p><input type='button' name='approved' value='Approved' style='cursor:pointer;' onclick="location.href='?approved=true';" /></p>-->
	<table cellspacing='0' cellpadding='0' border='0'>
		<tr>
			<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
			<td class='singlebutton'><a title='Approved' href='?approved=true'>Approved</a></td>
			<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
		</tr>
	</table>
	<br/>
<?php  }

if($_POST['sorted']=='forename')
{
	$query .= " ORDER BY Forename ASC";
}
elseif($_POST['sorted']=='surname')
{
	$query .= " ORDER BY Surname ASC";
}
elseif($app == 'true')
{
	$query .= " ORDER BY Forename ASC";
}
else
{
	$query .= " ORDER BY ID Desc";
}

$result = mysql_query($query) or die(mysql_error());
$numfields = mysql_num_fields($result);
for ($i=0; $i < $numfields; $i++)
{
	$fieldname[] = mysql_field_name($result, $i);
}?>

<table class='table' style="border:1px solid #d0d3d5;" cellspacing='2' cellpadding='2' align='center' border='0'>
<tr bgcolor="#999999" style="background-color:#999999; font-size:12px;">
	<th>Image</th>
<?php 	foreach($fieldname as $field)
		{
			if($field!='ID' && $field!='Approved' && $field!='Image_Path')
			{
				if($app == 'true')
				{
					if($field=='Forename')
					{?>
						<form method="post" name="sortedfirst" action='membertable.php'>
						<input type="hidden" name="sorted" value="forename" />
						<th>
						<a href="#" style="color:black; text-decoration:none;" onclick="sorts1();" style="color:black; text-decoration:none;"><img src="../images/marker-down.GIF" height="10" width="10" style="border: none;" alt="sorted by forename" align="left" class="open" />
						<?php if($_POST['sorted'] == 'surname')
						{?>
							<style type="text/css">img.open {display:none;}</style>
							<img src="../images/marker-right.GIF" height="10" width="10" style="border: none;" alt="sort by forename" align="left" class="arrow" />
						<?php
						}?>Forename</a>
						</th></form>
			<?php	}
					elseif($field=='Surname')
					{?>
						<form method="post" name="sortedsecond" action='membertable.php'>
						<input type="hidden" name="sorted" value="surname" />
						<th>
						<a href="#" style="color:black; text-decoration:none;" onclick="sorts2();" style="color:black; text-decoration:none;"><img src="../images/marker-right.GIF" height="10" width="10" style="border: none;" alt="sort by surname" align="left" class="closed" />
						<?php if($_POST['sorted'] == 'surname')
						{?>
							<style type="text/css">img.closed {display:none;}</style>
							<img src="../images/marker-down.GIF" alt="sorted by surname" align="left" class="arrow" height="10" width="10" style="border: none;" />
						<?php
						}?>Surname</a>
						</th></form>
			<?php	}
					else
					{?>
						<th><?php echo $field;?></th>
			<?php	}
				}
				else
				{?>
					<th><?php echo $field;?></th>
		<?php	}
			}
		} ?>
</tr>
<?php
if(mysql_num_rows($result) != 0)
{
	$counter = 0;
	while($row = mysql_fetch_array($result))
	{
		$id = $row['ID'];
		$counter++;
		$background_color = ( $counter % 2 == 0 ) ? ('#EAC117') : ('#ffffff'); 
		$date = date('Y-m-d H:i');
		$dateexpire = $row['DateExpire'];?>
		<tr class='table' bgcolor="<?php echo $background_color;?>" onclick="parent.location.href='memberamend.php?edit=<?php echo $id;?>';" onmouseover="this.className='table tablehover'" onmouseout="this.className='table'" <?php if($row['Approved'] == 'No'){ echo "style='color:red;'"; } if($dateexpire < $date){echo "style='color:blue;'";} ?>>
			<td><img src="../member/images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Forename'];?>" border='0' height='50' /></td>
				<?php
				foreach($fieldname as $field)
				{
					if($field!='ID' && $field!='Approved' && $field!='Image_Path')
					{?>
						<td <?php if($field=='Height' || $field=='Profession' || $field=='DietaryReq' || $field=='Interests'){echo "nowrap='nowrap'";}
						if($field=='DietaryReq' || $field=='Interests')
						{
							$row[$field] = wordwrap($row[$field], 30, "<br />\n");
						}
						if($field == 'DateJoined' || $field == 'DateExpire')
						{
							if($row[$field]!='')
							{
								$row[$field] = date('d/m/Y H:i', strtotime($row[$field]));	
							}
						}?>><?php echo $row[$field];?></td>
			<?php	}
				} ?>
			</tr>
  <?php	}
}
?>

</table>
<script>
function sorts1()
{
	document.sortedfirst.submit();
}

function sorts2()
{
	document.sortedsecond.submit();
}
</script>
</body>
</html>