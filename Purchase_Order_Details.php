<?php
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_POST['btnConfirmed'])) 
{
	$txtPurchaseOrderID=$_POST['txtPurchaseOrderID'];

	$result=mysqli_query($connection,"SELECT * FROM purchaseorderdetail WHERE PurchaseOrderID='$txtPurchaseOrderID'");

	while($arr=mysqli_fetch_array($result)) 
	{
		$ProductID=$arr['ProductID'];
		$PurchaseQuantity=$arr['PurchaseQuantity'];

		$UpdateQty="UPDATE product
					SET Quantity = Quantity + '$PurchaseQuantity'
					WHERE ProductID=$ProductID
				   ";
		$ret=mysqli_query($connection,$UpdateQty);
	}

	$UpdateStatus="UPDATE purchaseorder
				   SET Status='Confirmed'
				   WHERE PurchaseOrderID='$txtPurchaseOrderID'
				   ";
	$ret=mysqli_query($connection,$UpdateStatus);
	
	if($ret) 
	{
		echo "<script>window.alert('Purchase Order Successfully Confirmed')</script>";
		echo "<script>window.location='Purchase_Order_Search.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase_Order_Details " . mysqli_errno($connection) . "</p>";
	}			   
}


$PurchaseOrderID=$_GET['PurchaseOrderID'];

//Query1 Single----------------------------------------------------------
$Query1="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName
		 FROM purchaseorder po,staff st,supplier sup
		 WHERE po.PurchaseOrderID='$PurchaseOrderID'	
		 AND po.SupplierID=sup.SupplierID
		 AND po.StaffID=st.StaffID
		";
$ret1=mysqli_query($connection,$Query1);
$row1=mysqli_fetch_array($ret1);
//------------------------------------------------------------------------
$Query2="SELECT po.*,pod.*,p.ProductID,p.ProductName
		 FROM purchaseorder po, purchaseorderdetail pod, product p
		 WHERE pod.PurchaseOrderID='$PurchaseOrderID'
		 AND po.PurchaseOrderID=pod.PurchaseOrderID
		 AND pod.ProductID=p.ProductID	
		 ";
$ret2=mysqli_query($connection,$Query2);
$count=mysqli_num_rows($ret2);
//------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase_Order_Details</title>
</head>
<body>
<form action="Purchase_Order_Details.php" method="post">
<fieldset>
<legend>Purchase Order Details : </legend>

<table align="center" border="1" cellpadding="5px">
<tr>
	<td>PurchaseOrderID :</td>
	<td>
		<b><?php echo $row1['PurchaseOrderID'] ?></b>
	</td>
	<td>Status :</td>
	<td>
		<b><?php echo $row1['Status'] ?></b>
	</td>
</tr>
<tr>
	<td>PO Date :</td>
	<td>
		<b><?php echo $row1['PurchaseOrderDate'] ?></b>
	</td>
	<td>Report Date :</td>
	<td>
		<b><?php echo date('Y-M-d') ?></b>
	</td>
</tr>
<tr>
	<td>Supplier Info :</td>
	<td>
		<b><?php echo $row1['SupplierName'] ?></b>
	</td>
	<td>Staff Info :</td>
	<td>
		<b><?php echo $row1['StaffName'] ?></b>
	</td>
</tr>
<tr>
	<td colspan="4" >
		<table width="100%" bgcolor="#ccc">
		<tr>
			<th>#</th>
			<th>ProductName</th>
			<th>P-Price</th>
			<th>P-Quantity</th>
			<th>Sub-Total</th>
		</tr>
		<?php  
		for ($i=0;$i<$count;$i++) 
		{ 
			$row2=mysqli_fetch_array($ret2);
			
			echo "<tr>";
				echo "<td>" . ($i + 1) . "</td>";
				echo "<td>" . $row2['ProductName'] . "</td>";
				echo "<td>" . $row2['PurchasePrice'] . "</td>";
				echo "<td>" . $row2['PurchaseQuantity'] . "</td>";
				echo "<td>" . $row2['PurchasePrice'] * $row2['PurchaseQuantity'] . "</td>";
			echo "</tr>";
		}
		?>
		</table>
	</td>
</tr>
<tr>
	<td colspan="4"  align="right">
		Total Quantity : <b><?php echo $row1['TotalQuantity'] ?></b> pcs
		<hr/>
		Total Amount : <b><?php echo $row1['TotalAmount'] ?></b> USD
		<hr/>
		VAT (5%) : <b><?php echo $row1['TaxAmount'] ?></b> USD
		<hr/>
		Grand Total : <b><?php echo $row1['GrandTotal'] ?></b> USD
		<hr/>
		<input type="hidden" name="txtPurchaseOrderID" value="<?php echo $row1['PurchaseOrderID'] ?>" />
		
		<?php 
		if ($row1['Status'] !== 'Pending') 
		{
			echo "<input type='submit' name='btnConfirmed' value='Confirm PO' disabled />";
		}
		else
		{
			echo "<input type='submit' name='btnConfirmed' value='Confirm PO' />";
		}

		 ?>
		
	</td>
</tr>
</table>

</fieldset>
</form>
</body>
</html>