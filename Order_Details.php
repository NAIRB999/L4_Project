<?php
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_POST['btnConfirmed'])) 
{
	$txtOrderID=$_POST['txtOrderID'];

	$result=mysqli_query($connection,"SELECT * FROM orderdetails WHERE OrderID='$txtOrderID'");

	while($arr=mysqli_fetch_array($result)) 
	{
		$ProductID=$arr['ProductID'];
		$Quantity=$arr['Quantity'];

		$UpdateQty="UPDATE product
					SET Quantity = Quantity - '$Quantity'
					WHERE ProductID=$ProductID
				   ";
		$ret=mysqli_query($connection,$UpdateQty);
	}

	$UpdateStatus="UPDATE orders
				   SET Status='Confirmed'
				   WHERE OrderID='$txtOrderID'
				   ";
	$ret=mysqli_query($connection,$UpdateStatus);
	
	if($ret) 
	{
		echo "<script>window.alert('Order Successfully Confirmed')</script>";
		echo "<script>window.location='Order_Search.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase_Order_Details " . mysqli_errno($connection) . "</p>";
	}			   
}


$OrderID=$_GET['OrderID'];

//Query1 Single----------------------------------------------------------
$Query1="SELECT o.*, c.CustomerID,c.CustomerName
		 FROM orders o, customer c
		 WHERE o.OrderID='$OrderID'
		 AND o.CustomerID=c.CustomerID
		";
$ret1=mysqli_query($connection,$Query1);
$row1=mysqli_fetch_array($ret1);
//------------------------------------------------------------------------
$Query2="SELECT o.*,od.*,p.ProductID,p.ProductName
		 FROM orders o, orderdetails od, product p
		 WHERE od.OrderID='$OrderID'
		 AND o.OrderID=od.OrderID
		 AND od.ProductID=p.ProductID	
		 ";
$ret2=mysqli_query($connection,$Query2);
$count=mysqli_num_rows($ret2);
//------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
	<title>Order_Details</title>
</head>
<body>
<form action="Order_Details.php" method="post">
<fieldset>
<legend>Order Details : </legend>

<table align="center" border="1" cellpadding="5px">
<tr>
	<td>OrderID :</td>
	<td>
		<b><?php echo $row1['OrderID'] ?></b>
	</td>
	<td>Status :</td>
	<td>
		<b><?php echo $row1['Status'] ?></b>
	</td>
</tr>
<tr>
	<td>Order Date :</td>
	<td>
		<b><?php echo $row1['OrderDate'] ?></b>
	</td>
	<td>Report Date :</td>
	<td>
		<b><?php echo date('Y-M-d') ?></b>
	</td>
</tr>
<tr>
	<td>Customer Info :</td>
	<td>
		<b><?php echo $row1['CustomerName'] ?></b>
	</td>
	<td>Delivery Info :</td>
	<td>
		<b><?php echo $row1['Address'] . " | " .  $row1['Phone'] ?></b>
	</td>
</tr>
<tr>
	<td colspan="4" >
		<table width="100%" bgcolor="#ccc">
		<tr>
			<th>#</th>
			<th>ProductName</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Sub-Total</th>
		</tr>
		<?php  
		for ($i=0;$i<$count;$i++) 
		{ 
			$row2=mysqli_fetch_array($ret2);
			
			echo "<tr>";
				echo "<td>" . ($i + 1) . "</td>";
				echo "<td>" . $row2['ProductName'] . "</td>";
				echo "<td>" . $row2['Price'] . "</td>";
				echo "<td>" . $row2['Quantity'] . "</td>";
				echo "<td>" . $row2['Price'] * $row2['Quantity'] . "</td>";
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
		VAT (5%) : <b><?php echo $row1['VAT'] ?></b> USD
		<hr/>
		Grand Total : <b><?php echo $row1['GrandTotal'] ?></b> USD
		<hr/>
		<input type="hidden" name="txtOrderID" value="<?php echo $row1['OrderID'] ?>" />
		
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
		| 
		<input type='submit' name='btnDeliveryConfirm' value='Finished Delivery' />
	</td>
</tr>
</table>

</fieldset>
</form>
</body>
</html>