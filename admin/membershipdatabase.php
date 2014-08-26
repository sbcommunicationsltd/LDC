<?php session_start();
include '../database/databaseconnect.php';

if(!isset($_SESSION['admin_is_logged_in'])){
	header('Location: login.php');
}

if (isset($_REQUEST['type'])) {
	$type = $_REQUEST['type'];
	if ('Gold' == $type) {
		$tableName = 'Gold_Members';
		$filenametype = 'goldmembers';
		$subtable = 'goldmembertable.php';
	} else {
		$tableName = 'Members';
		$filenametype = 'silvermembers';
		$subtable = 'membertable.php';
	}
}

if(isset($_POST['export']))
{
	$qu = "SELECT * FROM $tableName ORDER BY ID ASC";
	$re = mysql_query($qu) or die(mysql_error());
	$num = mysql_num_fields($re);

	$output = '';

	for($i=1; $i < $num; $i++)
	{
		$fields = mysql_field_name($re, $i);
		$output .= $fields . "\t ";
	}
	$output .= "\n";

	while ($rowr = mysql_fetch_array($re))
	{
		for ($j=1; $j < $num ; $j++)
		{
			$output .= $rowr[$j]."\t ";
		}
		$output .= "\n";
	}

	$filename = "$filenametype_" . date("Y-m-d_H-i", time());
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$filename.".xls");
	print $output;
	exit;
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
			<img src="../images/membership.gif" alt="Membership" width="181" height="50"/>

<?php
if (isset($_REQUEST['type'])) {?>
	<iframe name='members' width='100%' allowTransparency="true" align='center' height='400' frameborder='0' src='<?php echo $subtable;?>'></iframe>

	<p>&nbsp;</p>
	<?php
	$query = "SELECT * FROM $tableName WHERE Gender = 'Male'";
	$result = mysql_query($query) or die(mysql_error());
	$male = mysql_num_rows($result);

	$query2 = "SELECT * FROM $tableName WHERE Gender = 'Female'";
	$result2 = mysql_query($query2) or die(mysql_error());
	$female = mysql_num_rows($result2);

	$total = $male + $female;?>

	<table width='100%' border='0' cellpadding='2' cellspacing='2' style='border:2px #99CCFF double; border-width:6px; background-color:#B0E0E6;'>
	<tr>
		<th align='left'>Total <?php echo $type;?> Members:</th>
		<td> Male </td>
		<td><?php echo $male;?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style='border-bottom:1px black solid;'> Female </td>
		<td style='border-bottom:1px black solid;'><?php echo $female;?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td> Grand Total </td>
		<td><?php echo $total;?></td>
	</tr>
	</table>
	<p>&nbsp;</p>
	<form method='post' name='Export'>
	<input type='hidden' name='export' />
	<input type='hidden' name='type' value='<?php echo $type;?>' />
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
	<input type='submit' class='singlebutton' onclick="if(confirm('Are you sure you want to export the <?php echo $filenametype;?> database?')){document.Export.submit();}else{window.location.reload(false);}" value='Export Membership Table' />
	<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
	</p>
	</form>
	<!--<p><form method='post' action='../admin/'><input type='submit' name='admin' value='Back to Main Admin Page' style='cursor:pointer;' /></form></p>-->
<?php
}  else {?>
	<form method='post' name='redirect'>
	<input type='hidden' name='type' value='Silver' />
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
	<input type='submit' value='View Silver Members' class='singlebutton' />
	<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
	</p>
	</form>
	<br/><br/>
	<form method='post' name='redirect'>
	<input type='hidden' name='type' value='Gold' />
	<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
	<input type='submit' value='View Gold Members' class='singlebutton' />
	<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
	</p>
	</form>
	<br/><br/>
<?php
}?>
<br/>
<form method='post' action='../admin/'>
<input type='hidden' name='admin' />
<p><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" style='float:left;' />
<input type='submit' class='singlebutton' value='Back to Main Admin Page' />
<img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" style='float:left;' />
</p>
</form>
<p><br/></p>

   <div class="clear"></div>
       <div class="spacebreak"></div>
    </div>
   
    <?php include('../footer.php');?>
   
</body>
</html>