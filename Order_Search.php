<?php  
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_POST['btnSearch'])) 
{
	$rdoSearchType=$_POST['rdoSearchType'];

	if ($rdoSearchType == 1) 
	{
		$cboOrderID=$_POST['cboOrderID'];

		$Query="SELECT o.*, c.CustomerID,c.CustomerName
				FROM orders o, customer c
				WHERE o.OrderID='$cboOrderID'
				AND o.CustomerID=c.CustomerID
			    ";
		$ret=mysqli_query($connection,$Query);

	}
	elseif ($rdoSearchType == 2) 
	{
		$txtFrom=date('Y-m-d',strtotime($_POST['txtFrom']));
		$txtTo=date('Y-m-d',strtotime($_POST['txtTo']));

		$Query="SELECT o.*, c.CustomerID,c.CustomerName
				FROM orders o, customer c
				WHERE o.OrderDate BETWEEN '$txtFrom' AND '$txtTo'
				AND o.CustomerID=c.CustomerID
			    ";
		$ret=mysqli_query($connection,$Query);
	}
	elseif ($rdoSearchType == 3) 
	{
		$cboStatus=$_POST['cboStatus'];

		$Query="SELECT o.*, c.CustomerID,c.CustomerName
				FROM orders o, customer c
				WHERE o.Status='$cboStatus'
				AND o.CustomerID=c.CustomerID
			    ";
		$ret=mysqli_query($connection,$Query);
	}
}
elseif(isset($_POST['btnShowAll'])) 
{
	$Query="SELECT o.*, c.CustomerID,c.CustomerName
			FROM orders o, customer c
			WHERE o.CustomerID=c.CustomerID
		    ";
	$ret=mysqli_query($connection,$Query);
}
else
{
	$TodayDate=date('Y-m-d');
	$Query="SELECT o.*, c.CustomerID,c.CustomerName
			FROM orders o, customer c
			WHERE o.OrderDate='$TodayDate'
			AND o.CustomerID=c.CustomerID
		    ";
	$ret=mysqli_query($connection,$Query);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Order Search</title>

	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css" />

</head>
<body>
<form action="Order_Search.php" method="post">
<fieldset>
<legend>Choose Criteria :</legend>
<table cellpadding="5px" >
<tr>
	<td>
		<input type="radio" name="rdoSearchType" value="1" checked />Search by ID :
		<br/>
		<select name="cboOrderID">
			<option>--Choose OrderID--</option>
			<?php  
			$O_query="SELECT * FROM orders";
			$O_ret=mysqli_query($connection,$O_query);
			$O_count=mysqli_num_rows($O_ret);

			for($i=0; $i < $O_count; $i++) 
			{ 
				$O_arr=mysqli_fetch_array($O_ret);

				$OrderID=$O_arr['OrderID'];
				echo "<option value='$OrderID'>$OrderID</option>";
			}
			?>
		</select>
	</td>

	<td>
		<input type="radio" name="rdoSearchType" value="2" />Search by Date :
		<br/>
		From <input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>" onClick="showCalender(calender,this)"/>
		To <input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>" onClick="showCalender(calender,this)"/>
	</td>

	<td>
		<input type="radio" name="rdoSearchType" value="3" />Search by Status :
		<br/>
		<select name="cboStatus">
			<option>--Choose Status--</option>
			<option>Pending</option>
			<option>Confirmed</option>
		</select>
	</td>
	<td>
		<br/>
		<input type="submit" name="btnSearch" value="Search" />
		<input type="submit" name="btnShowAll" value="Show All" />
		<input type="reset" value="Clear" />
	</td>
</tr>
</table>
<hr/>

<?php 
$count=mysqli_num_rows($ret);

if($count < 1) 
{
	echo "<p>No Order Record Found.</p>";
}
else
{
?>
	<table border="1" width="100%" cellpadding="5px">
	<tr>
		<th>#</th>
		<th>OrderID</th>
		<th>OrderDate</th>
		<th>CustomerName</th>
		<th>TotalQuantity</th>
		<th>TotalAmount</th>
		<th>VAT</th>
		<th>GrandTotal</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php  
	for ($i=0;$i<$count;$i++) 
	{ 
		$arr=mysqli_fetch_array($ret);

		$OrderID=$arr['OrderID'];
		
		echo "<tr>";
			echo "<td>" . ($i + 1) . "</td>";
			echo "<td>" . $OrderID . "</td>";
			echo "<td>" . $arr['OrderDate'] . "</td>";
			echo "<td>" . $arr['CustomerName'] . "</td>";
			echo "<td>" . $arr['TotalQuantity'] . "</td>";
			echo "<td>" . $arr['TotalAmount'] . "</td>";
			echo "<td>" . $arr['VAT'] . "</td>";
			echo "<td>" . $arr['GrandTotal'] . "</td>";
			echo "<td>" . $arr['Status'] . "</td>";
			echo "<td>
				 	<a href='Order_Details.php?OrderID=$OrderID'>Details</a>
				  </td>";
		echo "</tr>";	
	}

	?>
	<tr>
		<td colspan="10">
			<?php echo "Search Result : " . $count ?>
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