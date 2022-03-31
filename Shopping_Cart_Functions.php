<?php  
function AddProduct($ProductID,$BuyQuantity)
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

	if($BuyQuantity < 1) 
	{
		echo "<p>Please enter correct quantity.</p>";
		exit();
	}

	if(isset($_SESSION['ShoppingCart_Functions'])) //Session Array check
	{
		
		$index=IndexOf($ProductID);

		if ($index == -1) 
		{
			//Condition 2
			$size=count($_SESSION['ShoppingCart_Functions']);

			$_SESSION['ShoppingCart_Functions'][$size]['ProductID']=$ProductID;
			$_SESSION['ShoppingCart_Functions'][$size]['BuyQuantity']=$BuyQuantity;
			$_SESSION['ShoppingCart_Functions'][$size]['ProductImage1']=$rows['ProductImage1'];
			$_SESSION['ShoppingCart_Functions'][$size]['Price']=$rows['Price'];
			$_SESSION['ShoppingCart_Functions'][$size]['ProductName']=$rows['ProductName'];
		}
		else
		{
			//Condition 3
			$_SESSION['ShoppingCart_Functions'][$index]['BuyQuantity']+=$BuyQuantity;
		}
	}
	else
	{
		//Condition 1
		$_SESSION['ShoppingCart_Functions']=array(); // Create Session Array

		$_SESSION['ShoppingCart_Functions'][0]['ProductID']=$ProductID;
		$_SESSION['ShoppingCart_Functions'][0]['BuyQuantity']=$BuyQuantity;
		$_SESSION['ShoppingCart_Functions'][0]['ProductImage1']=$rows['ProductImage1'];
		$_SESSION['ShoppingCart_Functions'][0]['ProductName']=$rows['ProductName'];
		$_SESSION['ShoppingCart_Functions'][0]['Price']=$rows['Price'];
	}
	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	$size=count($_SESSION['ShoppingCart_Functions']);

	for ($i=0; $i < $size; $i++) 
	{ 
		$Price=$_SESSION['ShoppingCart_Functions'][$i]['Price'];
		$Quantity=$_SESSION['ShoppingCart_Functions'][$i]['BuyQuantity'];

		$TotalAmount+=($Price * $Quantity);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;

	$size=count($_SESSION['ShoppingCart_Functions']);

	for ($i=0; $i < $size; $i++) 
	{ 
		$Quantity=$_SESSION['ShoppingCart_Functions'][$i]['BuyQuantity'];

		$TotalQuantity+=$Quantity;
	}
	return $TotalQuantity;
}

function RemoveProduct($ProductID)
{
	$index=IndexOf($ProductID);

	unset($_SESSION['ShoppingCart_Functions'][$index]);

	$_SESSION['ShoppingCart_Functions']=array_values($_SESSION['ShoppingCart_Functions']);
	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['ShoppingCart_Functions']);
	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function IndexOf($ProductID)
{
	if(!isset($_SESSION['ShoppingCart_Functions'])) 
	{
		return -1;
	}

	$count=count($_SESSION['ShoppingCart_Functions']);

	if($count < 1) 
	{
		return -1;
	}

	for ($i=0; $i < $count; $i++) 
	{ 
		if ($ProductID == $_SESSION['ShoppingCart_Functions'][$i]['ProductID'] ) 
		{
			return $i;
		}
	}
	return -1;
}

?>