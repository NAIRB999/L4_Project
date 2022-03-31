<?php  
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Home</title>
</head>
<body>
<form>
<p>
Welcome : <?php echo $_SESSION['StaffName'] ?> | <?php echo $_SESSION['Role'] ?> | <a href="Staff_Logout.php">Logout</a>
</p>

<ul>
	<li><a href="Staff_Entry.php">Manage Staff</a></li>
	<li><a href="Product_Entry.php">Manage Product</a></li>
	<li><a href="Purchase_Order.php">Manage Purchase</a></li>
	<li><a href="Purchase_Order_Search.php">Purchase Search & Report</a></li>
</ul>

</form>
</body>
</html>