<?php  
function AddProduct($ProductID,$PurchasePrice,$PurchaseQuantity)
{
	include('connect.php');

	$query="SELECT * FROM Product WHERE ProductID='$ProductID' ";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$rows=mysqli_fetch_array($ret);

	if($count < 1) 
	{
		echo "<p>No Product Information Found.</p>";
		exit();
	}

	if($PurchaseQuantity < 1) 
	{
		echo "<p>Please enter correct quantity.</p>";
		exit();
	}

	if(isset($_SESSION['Purchase_Functions'])) //Session Array check
	{
		
		$index=IndexOf($ProductID);

		if ($index == -1) 
		{
			//Condition 2
			$size=count($_SESSION['Purchase_Functions']);

			$_SESSION['Purchase_Functions'][$size]['ProductID']=$ProductID;
			$_SESSION['Purchase_Functions'][$size]['PurchasePrice']=$PurchasePrice;
			$_SESSION['Purchase_Functions'][$size]['PurchaseQuantity']=$PurchaseQuantity;
			$_SESSION['Purchase_Functions'][$size]['ProductName']=$rows['ProductName'];
		}
		else
		{
			//Condition 3
			$_SESSION['Purchase_Functions'][$index]['PurchaseQuantity']+=$PurchaseQuantity;
		}
	}
	else
	{
		//Condition 1
		$_SESSION['Purchase_Functions']=array(); // Create Session Array

		$_SESSION['Purchase_Functions'][0]['ProductID']=$ProductID;
		$_SESSION['Purchase_Functions'][0]['PurchasePrice']=$PurchasePrice;
		$_SESSION['Purchase_Functions'][0]['PurchaseQuantity']=$PurchaseQuantity;
		$_SESSION['Purchase_Functions'][0]['ProductName']=$rows['ProductName'];
	}
	echo "<script>window.location='Purchase_Order.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	$size=count($_SESSION['Purchase_Functions']);

	for ($i=0; $i < $size; $i++) 
	{ 
		$Price=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$Quantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$TotalAmount+=($Price * $Quantity);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;

	$size=count($_SESSION['Purchase_Functions']);

	for ($i=0; $i < $size; $i++) 
	{ 
		$Quantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$TotalQuantity+=$Quantity;
	}
	return $TotalQuantity;
}

function RemoveProduct($ProductID)
{
	$index=IndexOf($ProductID);

	unset($_SESSION['Purchase_Functions'][$index]);

	$_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);
	echo "<script>window.location='Purchase_Order.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['Purchase_Functions']);
	echo "<script>window.location='Purchase_Order.php'</script>";
}

function IndexOf($ProductID)
{
	if(!isset($_SESSION['Purchase_Functions'])) 
	{
		return -1;
	}

	$count=count($_SESSION['Purchase_Functions']);

	if($count < 1) 
	{
		return -1;
	}

	for ($i=0; $i < $count; $i++) 
	{ 
		if ($ProductID == $_SESSION['Purchase_Functions'][$i]['ProductID'] ) 
		{
			return $i;
		}
	}
	return -1;
}

?>