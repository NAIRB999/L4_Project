<?php  
session_start();
include('connect.php');
include('Shopping_Cart_Functions.php');

if(isset($_GET['action'])) 
{
	$action=$_GET['action'];

	if ($action === 'remove') 
	{
		$ProductID=$_GET['ProductID'];
		RemoveProduct($ProductID);
	}
	else
	{
		ClearAll();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Shopping Cart</title>
</head>
<body>
<form action="#" method="post">

<?php  
if(!isset($_SESSION['ShoppingCart_Functions'])) 
{
	echo "<p>Empty Cart. | <a href='Product_Display.php'>Continue Shopping</a></p>"; 
	exit();
}
else
{
?>
	<table border="1" cellpadding="5px" align="center">
	<tr>
		<th>Image</th>
		<th>ProductID</th>
		<th>ProductName</th>
		<th>Price</th>
		<th>BuyQuantity</th>
		<th>Sub-Total</th>
		<th>Action</th>
	</tr>
	<?php  
	$count=count($_SESSION['ShoppingCart_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$ProductID=$_SESSION['ShoppingCart_Functions'][$i]['ProductID'];
		$ProductImage1=$_SESSION['ShoppingCart_Functions'][$i]['ProductImage1'];
		echo "<tr>";
			echo "<td>
					<img src='$ProductImage1' width='100px' height='120' />
				  </td>";
			echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['ProductID'] . "</td>";
			echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['ProductName'] . "</td>";
			echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['Price'] . " USD</td>";
			echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['BuyQuantity'] . " pcs</td>";
			echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['Price'] * 
						  $_SESSION['ShoppingCart_Functions'][$i]['BuyQuantity'] . 
				 " USD</td>";
			echo "<td> <a href='Shopping_Cart.php?ProductID=$ProductID&action=remove'>Remove</a> </td>";
		echo "</tr>";
	}
	?>
	<tr>
		<td colspan="7">
			Total Quantity : <b><?php echo CalculateTotalQuantity() ?> pcs</b>
			<br/>
			Total Amount : <b><?php echo CalculateTotalAmount() ?> USD</b>
			<br/>
			VAT (5%) : <b><?php echo CalculateTotalAmount() * 0.05 ?> USD</b>
			<br/>
			Grand Total : <b><?php echo CalculateTotalAmount() * 0.05 + CalculateTotalAmount() ?> USD</b>
		</td>
	</tr>
	<tr>
		<td colspan="7" align="right">
		<a href="Product_Display.php">Continue Shopping</a> 
		|
		<a href="Checkout.php">Make Checkout</a>
		|
		<a href="Shopping_Cart.php?action=clearall">Clear All</a>
		</td>
	</tr>
	</table>
<?php
}
?>


</form>
</body>
</html>