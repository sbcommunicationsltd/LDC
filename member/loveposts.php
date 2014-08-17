<?php
include '../database/databaseconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>London Dinner Club - exclusive dinner parties and drinks events in London :: london dinner club loves... :: London Dinner Club</title>
<meta name="description" content=" Asian Dinner Club, exclusive dinner parties and drinks events in London" />
<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="logo"><a href="http://www.londondinnerclub.org/" target="_self"><img src="../images/logo.png" alt="London Dinner Club" /></a></div>
<div id="navigation">
<ul>
<li><a href="http://www.londondinnerclub.org/" target="_self">HOME</a></li>
</ul>
</div>
</div>
<div id="maincontent">
<div id="innercontent">

<!-- main content area -->

<div id="contentcol1">
<img src="../images/ldcloves.png" alt="London Dinner Club Loves" width="350" />
<br/>
<?php
if(isset($_GET['id']))
{
	$id = $_GET['id'];
	$query = "SELECT * FROM LoveItems WHERE ID = $id";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	if(strpos($row['Title'], "\'")!==false)
	{
		$row['Title'] = str_replace("\'", "'", $row['Title']);
	}

	if(strpos($row['Title'], '\"')!==false)
	{
		$row['Title'] = str_replace('\"', '"', $row['Title']);
	}

	if(strpos($row['Description'], "\'")!==false)
	{
		$row['Description'] = str_replace("\'", "'", $row['Description']);
	}

	if(strpos($row['Description'], '\"')!==false)
	{
		$row['Description'] = str_replace('\"', '"', $row['Description']);
	}?>
	<table width='100%' height='100%' cellspacing='2' cellpadding='2' border='0' class='fontstyle3'>
	<tr>
		<td align='right'>
		<?php
		$image = $row['Image_Path'];
		list($width, $height) = getimagesize("images/$image");
		$modheight = 150;
		$diff = $height / $modheight;
		$modwidth = $width / $diff;

		if($modwidth > 360)
		{?>
			<img src="images/<?php echo $row['Image_Path'];?>" border='0' width='360' alt="<?php echo $row['Title'];?>" /></td>
		<?php
		}
		else
		{?>
			<img src="images/<?php echo $row['Image_Path'];?>" border='0' height='150' alt="<?php echo $row['Title'];?>" /></td>
		<?php
		}?>
	</tr>
	<tr>
		<th align='left'><?php echo $row['Title'];?></th>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><?php echo $row['Description'];?></th>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'>Please go to: <a href="<?php echo $row['Hyperlink'];?>" target='_blank' border='0' style='color:blue;' onmouseover="this.style.color='#FF00FF';" onmouseout="this.style.color='blue';"><?php echo $row['Hyperlink'];?></td>
	</tr>
	</table>
<?php
}
else
{?>
	<table width='100%' height='100%' cellspacing='2' cellpadding='2' border='0' class='fontstyle3'>
	<?php
	$query = "SELECT * FROM LoveItems";
	$result = mysql_query($query) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	$max = 10;
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

	if($page == 1)
	{
		$limits = 1;
	}
	while($row = mysql_fetch_array($result2))
	{?>
		<tr>
			<th align='left'><?php echo $limits . '. ' . $row['Title'];?></th>
		</tr>
		<tr>
			<td align='left'><?php echo $row['Description'];?></td>
		</tr>
		<tr>
			<td align='left'>Please go to: <a href="<?php echo $row['Hyperlink'];?>" target='_blank' border='0' style='color:blue;' onmouseover="this.style.color='#FF00FF';" onmouseout="this.style.color='blue';"><?php echo $row['Hyperlink'];?></a><span style='float:right;'><img src="images/<?php echo $row['Image_Path'];?>" border='0' height='65' alt="<?php echo $row['Title'];?>" /></span></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	<?php
		$limits++;
	}?>
	</table>

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
					<td class='singlebutton'><a title='Back to Oldest Posts' onclick="javascript:document.gofirst.submit();" href='#'><<</a></td>
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
					<td class='singlebutton'><a title='Go to Newest Posts' onclick="javascript:document.golast.submit();" href='#'>>></a></td>
					<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt=""></td>
				</tr>
			</table>
			</form>
			</td>
	<?php	}
		?>
		</tr>
	</table>
<?php
}?>

<p>&nbsp;</p>
<table cellspacing='0' cellpadding='0' border='0'>
	<tr>
		<td><img src="../images/sumi_buttons_04.png" width="11" height="19" alt="" /></td>
		<td class='singlebutton'><a title='Back' href="javascript:history.go(-1);">Back</a></td>
		<td><img src="../images/sumi_buttons_06.png" width="11" height="19" alt="" /></td>
	</tr>
</table>
</div>

<!-- end inner content -->

</div>
</div>
<div id="footer"></div>
<div id="footer2">
<div class="footer2col2">Copyright &copy;&nbsp;London Dinner Club&nbsp;2010</div>
<div class="footer2col2">designed by: <a href="http://www.streeten.com">streeten</a></div>
<div class="footer2col2">redeveloped by: <a href="http://www.sbcommunications.co.uk">S B Communications Ltd.</a></div></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
  //_uacct = "UA-4965994-1";
  //urchinTracker();
</script>
</div>
</body>
</html>