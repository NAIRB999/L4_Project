<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$cboBrandID=$_POST['cboBrandID'];
	$cboCategoryID=$_POST['cboCategoryID'];
	$txtProductName=$_POST['txtProductName'];
	$txtProductType=$_POST['txtProductType'];
	$txtSize=$_POST['txtSize'];
	$txtColor=$_POST['txtColor'];
	$txtPrice=$_POST['txtPrice'];
	$txtQuantity=$_POST['txtQuantity'];
	$txtDescription=$_POST['txtDescription'];

	//Image upload coding---------------------------------------
	$ProductImage1=$_FILES['FImage']['name']; //shirt1.jpg
	$FolderName='ProductImage/';
	$Time=date('Ymdhms');

	$FileName1=$FolderName . $Time . '_' . $ProductImage1; // ProductImage/20210809080833_shirt1.jpg

	$copied=copy($_FILES['FImage']['tmp_name'], $FileName1);

	if(!$copied) 
	{
		echo "<p>Cannot upload Front Image!</p>";
		exit();
	}
	//----------------------------------------------------------

	$InsertProduct="INSERT INTO `product`
				  (`ProductName`, `ProductType`, `Size`, `Color`, `Price`, `Quantity`, `BrandID`, `CategoryID`, `Description`, `ProductImage1`) 
				  VALUES
				  ('$txtProductName','$txtProductType','$txtSize','$txtColor','$txtPrice','$txtQuantity','$cboBrandID','$cboCategoryID','$txtDescription','$FileName1')";
	$ret=mysqli_query($connection,$InsertProduct);
	echo $InsertProduct;

	if($ret) 
	{
		echo "<script>window.alert('New Product Successfully Created!')</script>";
		echo "<script>window.location='Product_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Product Entry " . mysqli_errno($connection) . "</p>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Product Entry</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />

</head>
<body>

<script>
	$(document).ready
	( function ()
	{
		$('#tableid').DataTable();
	}
	);
</script>

<form action="Product_Entry.php" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Enter Product Infomation</legend>
<table cellspacing="4px">
<tr>
	<td>BrandInfo :</td>
	<td>
		<select name="cboBrandID">
			<option>----Choose Brand----</option>
			<?php  
			$B_query="SELECT * FROM Brand WHERE Status='Active' ";
			$B_ret=mysqli_query($connection,$B_query);
			$B_count=mysqli_num_rows($B_ret);

			for($i=0; $i < $B_count; $i++) 
			{ 
				$B_arr=mysqli_fetch_array($B_ret);

				$BrandID=$B_arr['BrandID'];
				$BrandName=$B_arr['BrandName'];

				echo "<option value='$BrandID'>$BrandID  -  $BrandName</option>";
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td>CategoryInfo :</td>
	<td>
		<select name="cboCategoryID">
			<option>----Choose Category----</option>
			<?php  
			$C_query="SELECT * FROM Category WHERE Status='Active' ";
			$C_ret=mysqli_query($connection,$C_query);
			$C_count=mysqli_num_rows($C_ret);

			for($x=0; $x < $C_count; $x++) 
			{ 
				$C_arr=mysqli_fetch_array($C_ret);

				$CategoryID=$C_arr['CategoryID'];
				$CategoryName=$C_arr['CategoryName'];

				echo "<option value='$CategoryID'>$CategoryID  -  $CategoryName</option>";
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td>Product Name :</td>
	<td>
		<input type="text" name="txtProductName" placeholder="eg. MK Tee TShirt" required />
	</td>
</tr>
<tr>
	<td>Product Type :</td>
	<td>
		<input type="text" name="txtProductType" placeholder="eg. Cotton/Silk" required />
	</td>
</tr>
<tr>
	<td>Size :</td>
	<td>
		<input type="text" name="txtSize" placeholder="eg. M/S/L/XL/XXL" required />
	</td>
</tr>
<tr>
	<td>Color :</td>
	<td>
		<input type="text" name="txtColor" placeholder="eg. White/Dark Blue" required />
	</td>
</tr>
<tr>
	<td>Price :</td>
	<td>
		<input type="number" name="txtPrice" placeholder="eg. 100" required /> USD
	</td>
</tr>
<tr>
	<td>Quantity :</td>
	<td>
		<input type="number" name="txtQuantity" placeholder="eg. 10" required /> pcs
	</td>
</tr>
<tr>
	<td>Front Image :</td>
	<td>
		<input type="file" name="FImage" required />
	</td>
</tr>
<tr>
	<td>Back Image :</td>
	<td>
		<input type="file" name="BImage"  />
	</td>
</tr>
<tr>
	<td>Side Image :</td>
	<td>
		<input type="file" name="SImage"  />
	</td>
</tr>
<tr>
	<td>Description :</td>
	<td>
		<textarea name="txtDescription"></textarea>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="submit" name="btnSave" value="Save" />
		<input type="reset" value="Cancel" />
	</td>
</tr>
</table>

</fieldset>
</form>
</body>
</html>

