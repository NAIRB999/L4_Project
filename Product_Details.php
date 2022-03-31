<?php  
session_start();
include('connect.php');
include('Shopping_Cart_Functions.php');

if(isset($_POST['btnAddtoCart'])) 
{
	$txtProductID=$_POST['txtProductID'];
	$txtBuyQuantity=$_POST['txtBuyQuantity'];

	AddProduct($txtProductID,$txtBuyQuantity);
}

$ProductID=$_GET['ProductID'];

$query="SELECT p.*,b.BrandID,b.BrandName,c.CategoryID,c.CategoryName 
		FROM product p,brand b,category c
		WHERE p.ProductID='$ProductID'
		AND p.BrandID=b.BrandID
		AND p.CategoryID=c.CategoryID
		";
$ret=mysqli_query($connection,$query);
$row=mysqli_fetch_array($ret);

$ProductID=$row['ProductID'];
$ProductName=$row['ProductName'];
$BrandName=$row['BrandName'];	
$CategoryName=$row['CategoryName'];	
$ProductImage1=$row['ProductImage1'];
$ProductImage2=$row['ProductImage2'];
$ProductImage3=$row['ProductImage3'];
$Price=$row['Price'];	
$Size=$row['Size'];	
$Color=$row['Color'];	
$Quantity=$row['Quantity'];	
$Description=$row['Description'];	

list($width,$height)=getimagesize($ProductImage1);
$w=$width/1.5;
$h=$height/1.5;

?>
<!DOCTYPE html>
<html>
<head>
	
	<title>Product Details</title>
</head>
<body>
<form action="Product_Details.php" method="post">
<fieldset>
<legend>Product Details :</legend>

<table align="center">
<tr>
	<td>
		<img id="PImage" src="<?php echo $ProductImage1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>" />
		<hr/>
		<img src="<?php echo $ProductImage1 ?>" width="108px" height="139px" 
		onClick="document.getElementById('PImage').src='<?php echo $ProductImage1 ?>'" />
		<img src="<?php echo $ProductImage2 ?>" width="108px" height="139px" 
		onClick="document.getElementById('PImage').src='<?php echo $ProductImage2 ?>'" />
		<img src="<?php echo $ProductImage3 ?>" width="108px" height="139px" 
		onClick="document.getElementById('PImage').src='<?php echo $ProductImage3 ?>'" />
	</td>
	<td>
		<fieldset>
		<table cellpadding="5px">
			<tr>
				<td>ProductName</td>
				<td>: <b><?php echo $ProductName ?></b></td>
			</tr>
			<tr>
				<td>BrandName</td>
				<td>: <b><?php echo $BrandName ?></b></td>
			</tr>
			<tr>
				<td>CategoryName</td>
				<td>: <b><?php echo $CategoryName ?></b></td>
			</tr>
			<tr>
				<td>Size</td>
				<td>: <b><?php echo $Size ?></b></td>
			</tr>
			<tr>
				<td>Color</td>
				<td>: <b><?php echo $Color ?></b></td>
			</tr>
			<tr>
				<td>Available Quantity</td>
				<td>: <b><?php echo $Quantity ?></b> pcs</td>
			</tr>
			<tr>
				<td>Price</td>
				<td>: <b><?php echo $Price ?></b> USD</td>
			</tr>
			<tr>
				<td>Buying Quantity</td>
				<td>: 
					<input type="text" name="txtBuyQuantity" value="1" size="3"  />
					<input type="hidden" name="txtProductID" value="<?php echo $ProductID ?>" />
					<input type="submit" name="btnAddtoCart" value="Add to Cart" />
				</td>
			</tr>
		</table>
		</fieldset>
	</td>
</tr>
<tr>
	<td colspan="2">
	<b>Description</b>
	<hr>
	<?php echo $Description ?>
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>