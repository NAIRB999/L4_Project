<?php  
session_start();
include('connect.php');

if(isset($_GET['StaffID'])) 
{
	$StaffID=$_GET['StaffID'];
	$query="SELECT * FROM Staff WHERE StaffID='$StaffID' ";
	$ret=mysqli_query($connection,$query);
	$row=mysqli_fetch_array($ret);
}

if(isset($_POST['btnUpdate'])) 
{
	$txtStaffID=$_POST['txtStaffID'];
	$txtStaffName=$_POST['txtStaffName'];
	$cboRole=$_POST['cboRole'];
	$txtEmail=$_POST['txtEmail'];
	$txtPhone=$_POST['txtPhone'];
	$txtPassword=$_POST['txtPassword'];
	$txtAddress=$_POST['txtAddress'];

	$Update="UPDATE Staff
			 SET 
			 StaffName='$txtStaffName',
			 Role='$cboRole',
			 Email='$txtEmail',
			 Password='$txtPassword',
			 Phone='$txtPhone',
			 Address='$txtAddress'
			 WHERE StaffID='$txtStaffID'
			";
	$ret=mysqli_query($connection,$Update);

	if($ret) 
	{
		echo "<script>window.alert('Staff Account Updated!')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Staff Update " . mysqli_errno($connection) . "</p>";
	}

}

?>
<!DOCTYPE html>
<html>
<head>
<title>Staff Update</title>
</head>
<body>
<form action="Staff_Update.php" method="post">
<fieldset>
<legend>Enter Staff Update Infomation</legend>
<table>
<tr>
	<td>Staff Name :</td>
	<td>
		<input type="text" name="txtStaffName" value="<?php echo $row['StaffName'] ?>" required />
	</td>
</tr>
<tr>
	<td>Role :</td>
	<td>
		<select name="cboRole">
			<option><?php echo $row['Role'] ?></option>
			<option>----Choose Role----</option>
			<option>Admin Manager</option>
			<option>Sales Staff</option>
		</select>
	</td>
</tr>
<tr>
	<td>Email :</td>
	<td>
		<input type="email" name="txtEmail" value="<?php echo $row['Email'] ?>" required />
	</td>
</tr>
<tr>
	<td>Password :</td>
	<td>
		<input type="password" name="txtPassword" value="<?php echo $row['Password'] ?>" required />
	</td>
</tr>
<tr>
	<td>Phone :</td>
	<td>
		<input type="text" name="txtPhone" value="<?php echo $row['Phone'] ?>" required />
	</td>
</tr>
<tr>
	<td>Address :</td>
	<td>
		<textarea name="txtAddress"><?php echo $row['Address'] ?></textarea>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="hidden" name="txtStaffID" value="<?php echo $row['StaffID'] ?>"  />
		<input type="submit" name="btnUpdate" value="Update" />
		<input type="reset" value="Cancel" />
	</td>
</tr>
</table>

</fieldset>
</form>
</body>
</html>

