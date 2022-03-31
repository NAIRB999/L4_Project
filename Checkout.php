<?php  
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Shopping_Cart_Functions.php');

$_SESSION['CustomerID']="1";
$_SESSION['CustomerName']="Alex";
$_SESSION['Address']="No 331, Pyay Road, Sanchaung Township";
$_SESSION['Phone']="095110110";

if(isset($_POST['btnCheckout'])) 
{
	$txtOrderID=$_POST['txtOrderID'];
	$txtOrderDate=$_POST['txtOrderDate'];
	$rdoDeliveryType=$_POST['rdoDeliveryType'];
	$rdoPaymentType=$_POST['rdoPaymentType'];
	$txtDirection=$_POST['txtDirection'];
	$txtCardNo=$_POST['txtCardNo'];

	$TotalAmount=CalculateTotalAmount();
	$TotalQuantity=CalculateTotalQuantity();
	$VAT=CalculateTotalAmount() * 0.05;
	$GrandTotal=CalculateTotalAmount() * 0.05 + CalculateTotalAmount();
	$Status="Pending";


	$CustomerID=$_SESSION['CustomerID'];

	if($rdoDeliveryType === "SameAddress") 
	{
		$CustomerName=$_SESSION['CustomerName'];
		$Phone=$_SESSION['Phone'];
		$Address=$_SESSION['Address'];
	}
	else
	{
		$CustomerName=$_POST['txtCustomerName'];
		$Phone=$_POST['txtPhone'];
		$Address=$_POST['txtAddress'];
	}
	//iNsert Order Table-(1)-------------------------------------------------------------------
	$Insert1="INSERT INTO `orders`
			 (`OrderID`, `OrderDate`, `CustomerID`, `DeliveryType`, `PaymentType`, `CustomerName`, `Phone`, `Address`, `Direction`, `CardNo`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`) 
			 VALUES
			 ('$txtOrderID','$txtOrderDate','$CustomerID','$rdoDeliveryType','$rdoPaymentType','$CustomerName','$Phone','$Address','$txtDirection','$txtCardNo','$TotalQuantity','$TotalAmount','$VAT','$GrandTotal','$Status')
			 ";
	$ret=mysqli_query($connection,$Insert1);
	//-----------------------------------------------------------------------------------------
	
	//Insert OrdersDetails Data (*)
	$size=count($_SESSION['ShoppingCart_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$ProductID=$_SESSION['ShoppingCart_Functions'][$i]['ProductID'];
		$Price=$_SESSION['ShoppingCart_Functions'][$i]['Price'];
		$Quantity=$_SESSION['ShoppingCart_Functions'][$i]['BuyQuantity'];

		$InsertOD="INSERT INTO OrderDetails
				   (OrderID,ProductID,Price,Quantity)
				   VALUES
				   ('$txtOrderID','$ProductID','$Price','$Quantity')";
		$ret=mysqli_query($connection,$InsertOD);
	}

	if($ret) 
	{
		echo "<script>window.alert('Customer Order Successfully Created!')</script>";
		unset($_SESSION['ShoppingCart_Functions']);

		echo "<script>window.location='Product_Display.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Orders :" . mysqli_error($connection) . "</p>";
	}	
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<script type="text/javascript">
function SameAddress()
{
	document.getElementById('SameAddress').style.display="block";
	document.getElementById('OtherAddress').style.display="none";
}
function OtherAddress()
{
	document.getElementById('SameAddress').style.display="none";
	document.getElementById('OtherAddress').style.display="block";
}
function COD()
{
	document.getElementById('CardPayment').style.display="none";
	document.getElementById('Kpay').style.display="none";
}
function CardPayment()
{
	document.getElementById('CardPayment').style.display="block";
	document.getElementById('Kpay').style.display="none";
}
function Kpay()
{
	document.getElementById('CardPayment').style.display="none";
	document.getElementById('Kpay').style.display="block";
}
</script>
</head>
<body>
<form action="Checkout.php" method="post">
<fieldset>
<legend>Checkout Informations :</legend>
<table cellspacing="8px">
<tr>
	<td>OrderID :</td>
	<td>
		<input type="text" name="txtOrderID" value="<?php echo AutoID('orders','OrderID','ORD-',6) ?>" readonly />
	</td>
	<td>TotalAmount :</td>
	<td>
		<b><?php echo CalculateTotalAmount() ?> USD</b>
	</td>
	<td>VAT (5%) :</td>
	<td>
		<b><?php echo CalculateTotalAmount() * 0.05 ?> USD</b>
	</td>
</tr>
<tr>
	<td>OrderDate :</td>
	<td>
		<input type="text" name="txtOrderDate" value="<?php echo date('Y-m-d') ?>" readonly />
	</td>
	<td>TotalQuantity :</td>
	<td>
		<b><?php echo CalculateTotalQuantity() ?> USD</b>
	</td>
	<td>GrandTotal :</td>
	<td>
		<b><?php echo CalculateTotalAmount() * 0.05 + CalculateTotalAmount() ?> USD</b>
	</td>
</tr>
</table>
<hr/>
<p><b><u>Delivery Details :</u></b></p>
<input type="radio" name="rdoDeliveryType" onClick="SameAddress()" value="SameAddress" checked />Same Address
<input type="radio" name="rdoDeliveryType" onClick="OtherAddress()" value="OtherAddress" />Other Address

<div id="SameAddress" style="display: block;">
<table>
<tr>
	<td>CustomerName</td>
	<td>
		: <b><?php echo $_SESSION['CustomerName'] ?></b>
	</td>
</tr>
<tr>
	<td>Address</td>
	<td>
		: <b><?php echo $_SESSION['Address'] ?></b>
	</td>
</tr>
<tr>
	<td>Phone</td>
	<td>
		: <b><?php echo $_SESSION['Phone'] ?></b>
	</td>
</tr>
</table>
</div>

<div id="OtherAddress" style="display: none;">
<table>
<tr>
	<td>CustomerName</td>
	<td>
		: <input type="text" name="txtCustomerName" placeholder="Eg. Alan" />
	</td>
</tr>
<tr>
	<td>Phone</td>
	<td>
		: <input type="text" name="txtPhone" placeholder="Eg. +95-----------" />
	</td>
</tr>
<tr>
	<td>Address</td>
	<td>
		: <textarea name="txtAddress" cols="30" placeholder="Floor No, Street Name etc."></textarea>
	</td>
</tr>
</table>
</div>

<table>
<tr>
	<td>Direction &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
	<td>
		: <textarea name="txtDirection" cols="50" rows="2" placeholder="Bus-stop etc..."></textarea>
	</td>
</tr>
</table>

<hr/>
<p><b><u>Payment Details :</u></b></p>
<input type="radio" name="rdoPaymentType" onClick="COD()" value="COD" checked />Cash On Delivery
<input type="radio" name="rdoPaymentType" onClick="CardPayment()" value="Card" />Card Payment
<input type="radio" name="rdoPaymentType" onClick="Kpay()" value="Kpay" />Kpay
<input type="radio" name="rdoPaymentType" onClick="" value="Wavepay" />Wave Pay

<div id="CardPayment" style="display: none;">
<br/>
<table>
	<tr>
		<td>
			<input type="text" name="txtCardNo" placeholder="Card Number" /> | 
			<input type="text" name="txtSecurityNo" placeholder="Security Code" size="9" />
		</td>
	</tr>
	<tr>
		<td>
			<input type="text" name="txtMonth" placeholder="Eg. JAN" size="5" /> | 
			<input type="text" name="txtYear" placeholder="2021" size="5" />
		</td>
	</tr>
</table>
</div>

<div id="Kpay" style="display: none">
<p><b>Kpay Account No : 30398390483984</b></p>
<img src="images/Kpay.png" width="100px" height="100px" />
</div>

<hr/>
<input type="submit" name="btnCheckout" value="Make Checkout" />
<input type="reset" value="Cancel" />
<hr/>

<?php  
if(!isset($_SESSION['ShoppingCart_Functions'])) 
{
	echo "<p>Empty Cart. | <a href='Product_Display.php'>Continue Shopping</a></p>"; 
	exit();
}
else
{
?>
	<table border="1" cellpadding="5px" align="center" width="100%">
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
	</table>
<?php
}
?>

</fieldset>

</form>
</body>
</html>