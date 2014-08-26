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
    color:white;
    font-family:Arial, Helvetica, sans-serif;
    font-size:12px;
    font-weight:bold;
    cursor:pointer;
    text-decoration:none;
    border:none;
    float:left;
    height: 19px;
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
			
			$query3 = "UPDATE Members SET Approved = 'Yes' WHERE ID = $id";
			$result3 = mysql_query($query3) or die(mysql_error());
			
			$to = $row2['EmailAddress'];
			//$to = 'sumita.biswas@gmail.com';
			$subject = "Silver Membership Application Form: London Dinner Club";
			$mess = "Dear Member,<br/>";
			$mess .= "<br/>Welcome to London Dinner Club, an exclusive Private Member's dining club for busy Single professionals.<br/>";
			$mess .= "<br/>To book tickets for our Silver Membership events, please find below your member username and password:<br/>";
			$mess .= "<br/>Username: member<br/>Password: paris<br/>";
			$mess .= "<br/>Our events do get booked up quickly, so if you can plan ahead, that would hopefully ensure you can attend our dinner parties and cocktail evenings in Mayfair and Knightsbridge.<br/>";
			$mess .= "<br/>We hope to see you soon.<br/>";
            
            $message = "<html><head></head><body><p>" . $mess . "</p>";
            $message .= "<p>&nbsp;</p><p>Kind Regards,<br/>Adrianna<br/><br/>London Dinner Club<br/>Membership Manager</p>";
            $message .= "<p><img src='http://www.londondinnerclub.org/images/logoapproval.JPG' alt='London Dinner Club' border='0' width='150' /></p>";
            $message .= "<p style='font-size:10px;'>We want to keep you up to date with everything that is happening at London Dinner Club, but you can click here to unsubscribe <a href='mailto:sales@londondinnerclub.org'>sales@londondinnerclub.org</a> if you no longer wish to receive information.Thank you.</p></body></html>";
            $headers = "MIME-Version: 1.0 \r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
            $headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";

			if(!mail($to, $subject, $message, $headers))
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
$result2 = mysql_query($query) or die($query.mysql_error());
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
    <p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
    <input type='button' class='singlebutton' value='Approved' onclick="location.href='?approved=true';" />
    <img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
    </p>
	<p><br/></p>
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
						<a style="color:black; text-decoration:none;" onclick="sorts1();" style="color:black; text-decoration:none;"><img src="../images/marker-down.GIF" height="10" width="10" style="border: none;" alt="sorted by forename" align="left" class="open" />
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
						<a style="color:black; text-decoration:none;" onclick="sorts2();" style="color:black; text-decoration:none;"><img src="../images/marker-right.GIF" height="10" width="10" style="border: none;" alt="sort by surname" align="left" class="closed" />
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
		$date = date('Y-m-d H:i');?>
		<tr class='table' bgcolor="<?php echo $background_color;?>" onclick="parent.location.href='memberamend.php?type=Silver&edit=<?php echo $id;?>';" onmouseover="this.className='table tablehover'" onmouseout="this.className='table'" <?php if($row['Approved'] == 'No'){ echo "style='color:red;'"; }?>>
            <td><img src="../member/images/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Forename'];?>" border='0' height='50' /></td>
            <?php
            foreach($fieldname as $field)
            {
                if($field!='ID' && $field!='Approved' && $field!='Image_Path')
                {?>
                    <td <?php if($field=='Height' || $field=='Profession' || $field=='DietaryReq' || $field=='Interests'){echo "nowrap='nowrap'";}
                    if($field=='Interests' || $field == 'DietaryReq')
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
}?>
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