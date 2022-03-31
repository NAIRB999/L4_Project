<?php  
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_POST['btnAdd'])) 
{
	$ProductID=$_POST['cboProductID'];
	$PurchasePrice=$_POST['txtPurchasePrice'];
	$PurchaseQuantity=$_POST['txtPurchaseQuantity'];

	AddProduct($ProductID,$PurchasePrice,$PurchaseQuantity);
}

if(isset($_GET['action'])) 
{
	$action=$_GET['action'];

	if ($action === 'remove') 
	{
		$ProductID=$_GET['ProductID'];
		RemoveProduct($ProductID);
	}
	elseif ($action === 'clearall') 
	{
		ClearAll();
	}
}

if(isset($_POST['btnSave'])) 
{
	$txtPOID=$_POST['txtPOID'];
	$txtPODate=$_POST['txtPODate'];
	$txtTotalAmount=$_POST['txtTotalAmount'];
	$txtTotalQuantity=$_POST['txtTotalQuantity'];
	$txtVAT=$_POST['txtVAT'];
	$txtGrandTotal=$_POST['txtGrandTotal'];
	$cboSupplier=$_POST['cboSupplier'];

	$StaffID=$_SESSION['StaffID'];
	$Status='Pending';

	//Insert data to Purchase Table (1)
	$InsertOrder="INSERT INTO `purchaseorder`
				  (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `TotalQuantity`, `TaxAmount`, `GrandTotal`, `SupplierID`, `StaffID`, `Status`) 
				  VALUES
				  ('$txtPOID','$txtPODate','$txtTotalAmount','$txtTotalQuantity','$txtVAT','$txtGrandTotal','$cboSupplier','$StaffID','$Status')
				   ";
	$ret=mysqli_query($connection,$InsertOrder);
	//--------------------------------------------------------------------------------

	//Insert data to PurchaseDetails Table (*)----------------------------------------

	$count=count($_SESSION['Purchase_Functions']);

	for ($i=0;$i<$count;$i++) 
	{ 
		$ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$InsertOrderDetails="INSERT INTO `purchaseorderdetail`
					(`PurchaseOrderID`, `ProductID`, `PurchaseQuantity`, `PurchasePrice`) 
					VALUES
					('$txtPOID','$ProductID','$PurchaseQuantity','$PurchasePrice')
					";
		$ret=mysqli_query($connection,$InsertOrderDetails);
	}
	//-------------------------------------------------------------------------------

	if($ret) 
	{
		echo "<script>window.alert('Purchase Order Successfully Saved!')</script>";
		unset($_SESSION['Purchase_Functions']);
		echo "<script>window.location='Staff_Home.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase_Order " . mysqli_errno($connection) . "</p>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
</head>
<body>
<form action="Purchase_Order.php" method="post">
<fieldset>
<legend>Purchase Order Form</legend>
<table cellpadding="5px">
<tr>
	<td>PO Date</td>
	<td>
		: <input type="text" name="txtPODate" value="<?php echo date('Y-m-d') ?>" readonly />
	</td>
	<td>TotalAmount</td>
	<td>
		: <input type="number" name="txtTotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>PO ID</td>
	<td>
		: <input type="text" name="txtPOID" value="<?php echo AutoID('purchaseorder','PurchaseOrderID','PUR-',6) ?>" readonly />
	</td>
	<td>TotalQuantity</td>
	<td>
		: <input type="number" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity() ?>" readonly /> pcs
	</td>
</tr>
<tr>
	<td>StaffInfo</td>
	<td>
		: <input type="text" name="txtStaffInfo" value="<?php echo $_SESSION['StaffName'] ?>" readonly />
	</td>
	<td>VAT (5%)</td>
	<td>
		: <input type="number" name="txtVAT" value="<?php echo CalculateTotalAmount() * 0.05 ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>ProductInfo</td>
	<td>
		: 
		<select name="cboProductID">
			<option>----Choose Product----</option>
			<?php  
			$P_query="SELECT * FROM Product";
			$P_ret=mysqli_query($connection,$P_query);
			$P_count=mysqli_num_rows($P_ret);

			for($i=0; $i < $P_count; $i++) 
			{ 
				$P_arr=mysqli_fetch_array($P_ret);

				$ProductID=$P_arr['ProductID'];
				$ProductName=$P_arr['ProductName'];

				echo "<option value='$ProductID'>$ProductID  -  $ProductName</option>";
			}
			?>
		</select>
	</td>
	<td>GrandTotal</td>
	<td>
		: <input type="number" name="txtGrandTotal" value="<?php echo CalculateTotalAmount() * 0.05 + CalculateTotalAmount()  ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>Purchase Price</td>
	<td>
		: <input type="number" name="txtPurchasePrice" value="0"  /> USD
	</td>
</tr>
<tr>
	<td>Purchase Quantity</td>
	<td>
		: <input type="number" name="txtPurchaseQuantity" value="0"  /> pcs
	</td>
</tr>
<tr>
	<td></td>
	<td>
		: <input type="submit" name="btnAdd" value="Add"  />
		  <input type="reset"  value="Cancel"  />
	</td>
</tr>
</table>

<hr>

<?php  
if(!isset($_SESSION['Purchase_Functions'])) 
{
	echo "<p>No Purchase Record.</p>";
	exit();
}
else
{
?>
	<table border="1" cellpadding="3px">
	<tr>
		<th>ProductID</th>
		<th>ProductName</th>
		<th>PurchasePrice</th>
		<th>PurchaseQuantity</th>
		<th>Sub-Total</th>
		<th>Action</th>
	</tr>
	<?php  
	$count=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
		echo "<tr>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['ProductID'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['ProductName'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchasePrice'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchasePrice'] * 
						  $_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'] . 
				 "</td>";
			echo "<td> <a href='Purchase_Order.php?ProductID=$ProductID&action=remove'>Remove</a> </td>";
		echo "</tr>";
	}
	?>
	<tr>
		<td colspan="6" align="right">
		Choose Info :
		<select name="cboSupplier">
			<option>--Choose-Supplier--</option>
			<?php  
			$S_query="SELECT * FROM supplier";
			$S_ret=mysqli_query($connection,$S_query);
			$S_count=mysqli_num_rows($S_ret);

			for($i=0; $i < $S_count; $i++) 
			{ 
				$S_arr=mysqli_fetch_array($S_ret);

				$SupplierID=$S_arr['SupplierID'];
				$SupplierName=$S_arr['SupplierName'];

				echo "<option value='$SupplierID'>$SupplierID  -  $SupplierName</option>";
			}
			?>
		</select>
		| 
		<input type="submit" name="btnSave" value="Confirmed Purchase" />
		| 
		<a href="Purchase_Order.php?action=clearall">Clear All</a>
		</td>
	</tr>
	</table>
<?php
}
?>

</fieldset>
</form>
</body>
</html>