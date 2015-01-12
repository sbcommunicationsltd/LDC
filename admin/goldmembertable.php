<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('tr').each(function () {
		$(this).children('td:not(:first)').click(function () {
			parent.location.href = $("#amendLink").find('a').attr("href");
			return false;
		});
	});
});
</script>
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

if(isset($_GET['approved']))
{
	$appid = $_GET['approved'];
	$query2 = "SELECT * FROM Gold_Members WHERE ID = '$appid'";
	$result2 = mysql_query($query2) or die(mysql_error());
	$row2 = mysql_fetch_array($result2);
	$email = $row2['EmailAddress'];
	$to = $email;
	//$to = 'sumita.biswas@gmail.com';
	$subject = "Gold Membership Application Form: London Dinner Club";
	$mess = "Dear Member,<br/>";
	$mess .= "<br/>Welcome to London Dinner Club, an exclusive Private Member's dining club for busy Single professionals.<br/>";
	$mess .= "<br/>To book tickets for our Gold Membership events, please find below your member username and password:<br/>";
	$mess .= "<br/>Username: $to<br/>Password: london<br/>";
	$mess .= "<br/>As a Gold membership holder, you can also attend events for Silver members. To book tickets, your login details for these events are:<br/>";
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

	if(mail($to, $subject, $message, $headers))
	{
		$fullname = $row2['Forename'] . ' ' . $row2['Surname'];
		$joined = $row2['DateJoined'];

		$expire = date('Y-m-d H:i', strtotime(date("Y-m-d H:i", strtotime($joined)) . " +6 months"));

		$query3 = "UPDATE Gold_Members SET Approved = 'Yes', DateExpire = '$expire' WHERE ID = '$appid'";
		$result3 = mysql_query($query3) or die(mysql_error());?>
		<script>
		alert("Thank You! Member - <?php echo $fullname;?> has been approved!");
		parent.location.href='membershipdatabase.php?type=Gold';
		</script>
	<?php
		exit;
	}
	else
	{?>
		<p><b>System Error</b></p><p>A system error has occurred - we apologise for any inconvenience caused. Use the link below to manually email this member.</p>
		<p><a href="mailto:<?php echo $row2['EmailAddress'];?>" style='text-decoration:none;'><?php echo $row2['EmailAddress'];?></a></p>
	<?php
	}
}


if(isset($_GET['renew']))
{
	$renid = $_GET['renew'];
	$query3 = "SELECT * FROM Gold_Members WHERE ID = '$renid'";
	$result3 = mysql_query($query3) or die(mysql_error());
	$row3 = mysql_fetch_array($result3);
	/*$email = $row3['EmailAddress'];
	$to = $email;
	//$to = 'sumita.biswas@gmail.com';
	$subject = 'Renewed Gold Membership to London Dinner Club';
	$body = "<html><head><title>Renewed Gold Membership to London Dinner Club</title></head><body>";
	$body .= "<p>Dear Gold Member,</p>";
	$body .= "<p>Thank you for renewing your Gold Membership for a further 6 months.</p>";
	$body .= "<p>You will need to reset your password so please click on the link below.</p>";
	$body .= "<p><br/></p><p><b>Login- in details</b></p>";
	$body .= "<p>Username: $email</p>";
	$body .= "<p>Password:<a href='http://www.londondinnerclub.org/member/goldmemember/login.php?renew=$renid'>click here</a></p>";
	$body .= "<p><br/></p><p>Best Wishes,</p>";
	$body .= "<p><br/></p><p>London Dinner Club</p>";
	$body .= "<p><img src='http://www.londondinnerclub.org/images/logo.gif' alt='London Dinner Club' border='0' /></p></body></html>";

	$headers = "MIME-Version: 1.0 \r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
	$headers .= "From: London Dinner Club <sales@londondinnerclub.org> \r\n";

	if(mail($to, $subject, $body, $headers))
	{*/
		$fullname = $row3['Forename'] . ' ' . $row3['Surname'];?>
		<script>
		alert("Thank You! Gold Member - <?php echo $fullname;?> has been renewed!");
		</script>
	<?php
		exit;
	/*}
	else
	{?>
		<p><b>System Error</b></p><p>A system error has occurred -  we apologise for any inconvenience caused. Use the link below to manually email this member.</p>
		<p><a href="mailto:<?php echo $row3['EmailAddress'];?>" style='text-decoration:none;'><?php echo $row3['EmailAddress'];?></a></p>
	<?php
	}*/


	$expire = date('Y-m-d H:i', strtotime(date("Y-m-d H:i", strtotime($row3['DateExpire'])) . " +6 months"));

	$query4 = "UPDATE Gold_Members SET Approved = 'Yes', DateExpire = '$expire' WHERE ID = '$renid'";
	$result4 = mysql_query($query4) or die(mysql_error());
}

$query = "SELECT * FROM Gold_Members";

if($_POST['sorted']=='forename')
{
	$query .= " ORDER BY Forename ASC";
}
elseif($_POST['sorted']=='surname')
{
	$query .= " ORDER BY Surname ASC";
}
elseif($_POST['sorted']=='approved')
{
	$query .= " ORDER BY Approved ASC";
}
else
{
	$query .= " ORDER BY ID ASC";
}

$result = mysql_query($query) or die(mysql_error());
$numfields = mysql_num_fields($result);
for ($i=0; $i < $numfields; $i++)
{
	$fieldname[] = mysql_field_name($result, $i);
}?>
<table class='table' style="border:1px solid #d0d3d5;" cellspacing='2' cellpadding='2' align='center' border='0'>
	<tr style="background-color:#999999; font-size:12px;">
		<th>
			<form method="post" name="sortedthird" action='goldmembertable.php'>
				<input type="hidden" name="sorted" value="approved" />
				<a style="color:black; text-decoration:none;" onclick="sorts3();"><img src="../images/marker-right.GIF" height="10" width="10" style="border: none;" alt="sort by approved" align="left" class="closed2" />
		<?php	if($_POST['sorted'] == 'approved')
				{?>
					<style type="text/css">img.closed2 {display:none;}
					</style>
					<img src="../images/marker-down.GIF" alt="sorted by approved" align="left" class="arrow" height="10" width="10" style="border: none;" />
				<?php
				}?>Approved</a>
			</form>
		</th>
		<th>Image</th>
<?php 	foreach($fieldname as $field)
		{
			if($field!='ID' && $field!='Image_Path' && $field!='Approved')
			{
				if($field=='Forename')
				{?>
					<form method="post" name="sortedfirst" action='goldmembertable.php'>
					<input type="hidden" name="sorted" value="forename" />
					<th>
						<a style="color:black; text-decoration:none;" onclick="sorts1();"><img src="../images/marker-down.GIF" height="10" width="10" style="border: none;" alt="sorted by forename" align="left" class="open" />
						<?php if($_POST['sorted'] == 'surname' || $_POST['sorted'] == 'approved')
						{?>
							<style type="text/css">img.open {display:none;}</style>
							<img src="../images/marker-right.GIF" height="10" width="10" style="border: none;" alt="sort by forename" align="left" class="arrow" />
						<?php
						}?>Forename</a>
					</th></form>
		<?php	}
				elseif($field=='Surname')
				{?>
					<form method="post" name="sortedsecond" action='goldmembertable.php'>
					<input type="hidden" name="sorted" value="surname" />
					<th>
						<a style="color:black; text-decoration:none;" onclick="sorts2();"><img src="../images/marker-right.GIF" height="10" width="10" style="border: none;" alt="sort by surname" align="left" class="closed1" />
						<?php if($_POST['sorted'] == 'surname')
						{?>
							<style type="text/css">img.closed1 {display:none;}</style>
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
			$dateexpire = $row['DateExpire'];
			$fullname = $row['Forename'] . ' ' . $row['Surname'];?>
			<tr class='table' id='dataTable' 
				<?php if($row['Approved'] == 'No'){ echo "style='color:red;'"; } if ($dateexpire!=''){if($dateexpire < $date){echo "style='color:blue;'";}}?> 
				bgcolor="<?php echo $background_color;?>" onmouseover="this.className='table tablehover'" onmouseout="this.className='table'">
				<td><?php 
					if($row['Approved']=='No') {?><!--<input type='button' name='approve' value='Approve' style='cursor:pointer; font-size:14px;' onclick="location.href='?approved=<?php echo $id;?>';" />-->
						<table cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title='Approve'  onclick="if(confirm('Are you sure you want to approve the applicant <?php echo $fullname; ?>?')){location.href='?approved=<?php echo $id;?>';}">Approve</a></td>
								<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
							</tr>
						</table>
					<?php 
					} elseif($row['Approved'] == 'RenewNo') {?>
						<table cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt=""></td>
								<td class='singlebutton'><a title='Renew' href="?renew=<?php echo $id;?>">Renew</a></td>
								<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
							</tr>
						</table>
					<?php
					} else{ 
						echo 'Yes';
					}?>
				</td>
				<td id='amendLink'><a href='memberamend.php?type=Gold&edit=<?php echo $id;?>' target='_parent'><img src="../member/goldimages/<?php echo $row['Image_Path'];?>" alt="<?php echo $row['Forename'];?>" border='0' height='50' /></a></td>
				<?php
				foreach ($fieldname as $field) {
					if ($field == 'DateJoined' || $field == 'DateExpire') {
						if ($row[$field]!='') {
							$row[$field] = date('d/m/Y H:i', strtotime($row[$field]));
						}
					}

					if ($field=='Interests') {
						$row[$field] = wordwrap($row[$field], 50, "<br />\n");
					}

					if ($field!='ID' && $field!='Image_Path' && $field!='Approved') {?>
						<td <?php if($field=='Height' || $field=='Profession' || $field=='DOB' || $field=='Interests'){echo "nowrap='nowrap'";}?>><?php echo $row[$field];?></td>
			<?php	}
				} ?>
			</tr>
		<?php
		}
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

function sorts3()
{
	document.sortedthird.submit();
}
</script>
</body>
</html>