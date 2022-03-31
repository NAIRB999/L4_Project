<?php  
session_start();
include('connect.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Display</title>

	<style type="text/css">
	.price
	{
		color: red;
		background: #000;
		font-size: 20pt;
		padding: 3px;
		font-family: Century Gothic;
	}
	.price:hover
	{
		color: blue;
		background: #CCC;
		font-size: 20pt;
		padding: 3px;
		font-family: Century Gothic;
	}
	</style>
</head>
<body>
<form action="Product_Display.php" method="post">

<fieldset>
<legend>Product Display</legend>
<table width="100%">
<tr align="right">
	<td>
		<input type="text" name="txtData" placeholder="Enter Keywords" />
		<input type="submit" name="btnSearch" value="Search">
	</td>
</tr>
</table>	
<hr/>
<table width="100%">
<?php  
	
if(isset($_POST['btnSearch'])) 
{
	$txtData=$_POST['txtData'];

	$query1="SELECT * FROM product
			 WHERE ProductName LIKE '%$txtData%'
			 OR Price='$txtData' 
			 ";
	$ret1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($ret1);

	for($i=0;$i<$count1;$i+=4) 
	{ 
		$query2="SELECT * FROM product 
				 WHERE ProductName LIKE '%$txtData%'
			 	 OR Price='$txtData'
				 LIMIT $i,4";
		$ret2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($ret2);

		echo "<tr>";
		for ($x=0;$x<$count2;$x++) 
		{ 
			$row=mysqli_fetch_array($ret1);

			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];
			$ProductImage1=$row['ProductImage1'];
			$Price=$row['Price'];	

			list($width,$height)=getimagesize($ProductImage1);
			$w=$width/2;
			$h=$height/2;
		?>
			<td align="center">
				<img src="<?php echo $ProductImage1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>" />
				<hr/>
				<b><?php echo $ProductName ?></b>
				<br/>
				<b class="price"><?php echo $Price ?> USD</b> 
				<hr/>
				<a href="Product_Details.php?ProductID=<?php echo $ProductID ?>">Details</a>
			</td>
		<?php
		}
		echo "</tr>";
	}
}
else
{
	$query1="SELECT * FROM product";
	$ret1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($ret1);

	for($i=0;$i<$count1;$i+=4) 
	{ 
		$query2="SELECT * FROM product LIMIT $i,4";
		$ret2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($ret2);

		echo "<tr>";
		for ($x=0;$x<$count2;$x++) 
		{ 
			$row=mysqli_fetch_array($ret1);

			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];
			$ProductImage1=$row['ProductImage1'];
			$Price=$row['Price'];	

			list($width,$height)=getimagesize($ProductImage1);
			$w=$width/2;
			$h=$height/2;
		?>
			<td align="center">
				<img src="<?php echo $ProductImage1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>" />
				<hr/>
				<b><?php echo $ProductName ?></b>
				<br/>
				<b class="price"><?php echo $Price ?> USD</b> 
				<hr/>
				<a href="Product_Details.php?ProductID=<?php echo $ProductID ?>">Details</a>
			</td>
		<?php
		}
		echo "</tr>";
	}

}

?>
</table>
</fieldset>

</form>
</body>
</html>
product.* ,brand.brandid, brand.brandname