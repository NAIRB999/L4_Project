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
		$cboPOID=$_POST['cboPOID'];

		$Query="SELECT po.*, sp.SupplierID,sp.SupplierName
				FROM purchaseorder po, supplier sp
				WHERE po.PurchaseOrderID='$cboPOID'
				AND po.SupplierID=sp.SupplierID
			    ";
		$ret=mysqli_query($connection,$Query);

	}
	elseif ($rdoSearchType == 2) 
	{
		$txtFrom=date('Y-m-d',strtotime($_POST['txtFrom']));
		$txtTo=date('Y-m-d',strtotime($_POST['txtTo']));

		$Query="SELECT po.*, sp.SupplierID,sp.SupplierName
				FROM purchaseorder po, supplier sp
				WHERE po.PurchaseOrderDate BETWEEN '$txtFrom' AND '$txtTo'
				AND po.SupplierID=sp.SupplierID
			    ";
		$ret=mysqli_query($connection,$Query);
	}
	elseif ($rdoSearchType == 3) 
	{
		$cboStatus=$_POST['cboStatus'];

		$Query="SELECT po.*, sp.SupplierID,sp.SupplierName
				FROM purchaseorder po, supplier sp
				WHERE po.Status='$cboStatus'
				AND po.SupplierID=sp.SupplierID
			    ";
		$ret=mysqli_query($connection,$Query);
	}
}
elseif(isset($_POST['btnShowAll'])) 
{
	$Query="SELECT po.*, sp.SupplierID,sp.SupplierName
			FROM purchaseorder po, supplier sp
			WHERE po.SupplierID=sp.SupplierID
		    ";
	$ret=mysqli_query($connection,$Query);
}
else
{
	$TodayDate=date('Y-m-d');
	$Query="SELECT po.*, sp.SupplierID,sp.SupplierName
			FROM purchaseorder po, supplier sp
			WHERE po.PurchaseOrderDate='$TodayDate'
			AND po.SupplierID=sp.SupplierID
		    ";
	$ret=mysqli_query($connection,$Query);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order Search</title>

	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css" />

</head>
<body>
<form action="Purchase_Order_Search.php" method="post">
<fieldset>
<legend>Choose Criteria :</legend>
<table cellpadding="5px" >
<tr>
	<td>
		<input type="radio" name="rdoSearchType" value="1" checked />Search by ID :
		<br/>
		<select name="cboPOID">
			<option>--Choose PurhaseID--</option>
			<?php  
			$P_query="SELECT * FROM purchaseorder";
			$P_ret=mysqli_query($connection,$P_query);
			$P_count=mysqli_num_rows($P_ret);

			for($i=0; $i < $P_count; $i++) 
			{ 
				$P_arr=mysqli_fetch_array($P_ret);

				$PurchaseOrderID=$P_arr['PurchaseOrderID'];
				echo "<option value='$PurchaseOrderID'>$PurchaseOrderID</option>";
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
	echo "<p>No Purchase Record Found.</p>";
}
else
{
?>
	<table border="1" width="100%" cellpadding="5px">
	<tr>
		<th>#</th>
		<th>PurchaseID</th>
		<th>Purchase Date</th>
		<th>SupplierName</th>
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

		$PurchaseOrderID=$arr['PurchaseOrderID'];
		
		echo "<tr>";
			echo "<td>" . ($i + 1) . "</td>";
			echo "<td>" . $PurchaseOrderID . "</td>";
			echo "<td>" . $arr['PurchaseOrderDate'] . "</td>";
			echo "<td>" . $arr['SupplierName'] . "</td>";
			echo "<td>" . $arr['TotalQuantity'] . "</td>";
			echo "<td>" . $arr['TotalAmount'] . "</td>";
			echo "<td>" . $arr['TaxAmount'] . "</td>";
			echo "<td>" . $arr['GrandTotal'] . "</td>";
			echo "<td>" . $arr['Status'] . "</td>";
			echo "<td>
				 	<a href='Purchase_Order_Details.php?PurchaseOrderID=$PurchaseOrderID'>Details</a>
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