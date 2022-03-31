<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtStaffName=$_POST['txtStaffName'];
	$cboRole=$_POST['cboRole'];
	$txtEmail=$_POST['txtEmail'];
	$txtPhone=$_POST['txtPhone'];
	$txtPassword=$_POST['txtPassword'];
	$txtAddress=$_POST['txtAddress'];

	//Check Email already exist coding
	$checkEmail="SELECT * FROM Staff 
				WHERE Email='$txtEmail'";
	$ret=mysqli_query($connection,$checkEmail);
	$count=mysqli_num_rows($ret);

	if($count > 0) 
	{
		echo "<script>window.alert('Email address $txtEmail already exist!')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
	else
	{
		$InsertStaff="INSERT INTO Staff
					  (StaffName,Role,Email,Password,Phone,Address)
					  VALUES 
					  ('$txtStaffName','$cboRole','$txtEmail','$txtPassword','$txtPhone','$txtAddress')";
		$ret=mysqli_query($connection,$InsertStaff);

		if($ret) 
		{
			echo "<script>window.alert('Staff Account Created!')</script>";
			echo "<script>window.location='Staff_Entry.php'</script>";
		}
		else
		{
			echo "<p>Something went wrong in Staff Entry " . mysqli_errno($connection) . "</p>";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Staff Entry</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />

</head>
<body>

<script>
	$(document).ready
	( function ()
	{
		$('#tableid').DataTable();
	}
	);
</script>

<form action="Staff_Entry.php" method="post">
<fieldset>
<legend>Enter Staff Infomation</legend>
<table>
<tr>
	<td>Staff Name :</td>
	<td>
		<input type="text" name="txtStaffName" placeholder="Alan Smith" required />
	</td>
</tr>
<tr>
	<td>Role :</td>
	<td>
		<select name="cboRole">
			<option>----Choose Role----</option>
			<option>Admin Manager</option>
			<option>Sales Staff</option>
		</select>
	</td>
</tr>
<tr>
	<td>Email :</td>
	<td>
		<input type="email" name="txtEmail" placeholder="example@email.com" required />
	</td>
</tr>
<tr>
	<td>Password :</td>
	<td>
		<input type="password" name="txtPassword" placeholder="XXXXXXXXXXXXXX" required />
	</td>
</tr>
<tr>
	<td>Phone :</td>
	<td>
		<input type="text" name="txtPhone" placeholder="+95-----------" required />
	</td>
</tr>
<tr>
	<td>Address :</td>
	<td>
		<textarea name="txtAddress"></textarea>
	</td>
</tr>
<tr>
	<td><a href="#">Login?</a></td>
	<td>
		<input type="submit" name="btnSave" value="Save" />
		<input type="reset" value="Cancel" />
	</td>
</tr>
</table>

<hr/>

<table id="tableid" class="display">
<thead>
	<tr>
		<th>#</th>
		<th>StaffID</th>
		<th>StaffName</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Address</th>
		<th>Role</th>
		<th>Action</th>
	</tr>	
</thead>	
<tbody>
<?php  
$query="SELECT * FROM Staff";
$ret=mysqli_query($connection,$query);
$count=mysqli_num_rows($ret);

for ($i=0;$i<$count;$i++) 
{ 
	$arr=mysqli_fetch_array($ret);

	$StaffID=$arr['StaffID'];
	$StaffName=$arr['StaffName'];

	echo "<tr>";
		echo "<td>" . ($i + 1) . "</td>";
		echo "<td>" . $StaffID . "</td>";
		echo "<td>" . $StaffName . "</td>";
		echo "<td>" . $arr['Email'] . "</td>";
		echo "<td>" . $arr['Phone'] . "</td>";
		echo "<td>" . $arr['Address'] . "</td>";
		echo "<td>" . $arr['Role'] . "</td>";
		echo "<td>
			 	<a href='Staff_Update.php?StaffID=$StaffID'>Edit</a>
			 	<a href='Staff_Delete.php?StaffID=$StaffID'>Delete</a>
			  </td>";
	echo "</tr>";	
}
?>
</tbody>
</table>
</fieldset>
</form>
</body>
</html>

