<?php  
session_start();
include('connect.php');

if(isset($_POST['btnLogin'])) 
{
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];


	$check="SELECT * FROM Staff 
			WHERE Email='$txtEmail'
			AND Password='$txtPassword'";
	$ret=mysqli_query($connection,$check);
	$count=mysqli_num_rows($ret);
	$row=mysqli_fetch_array($ret);

	if($count < 1) 
	{
		echo "<script>window.alert('UserName or Password Incorrect!')</script>";
		echo "<script>window.location='Staff_Login.php'</script>";
	}
	else
	{
		$_SESSION['StaffID']=$row['StaffID'];
		$_SESSION['StaffName']=$row['StaffName'];
		$_SESSION['Role']=$row['Role'];

		echo "<script>window.alert('Login Success!')</script>";
		echo "<script>window.location='Staff_Home.php'</script>";	
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Login</title>
</head>
<body>
<form action="Staff_Login.php" method="post">
<fieldset>
<legend>Enter Staff Login Infomation</legend>
<table>
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
	<td><a href="#">Register?</a></td>
	<td>
		<input type="submit" name="btnLogin" value="Login" />
		<input type="reset" value="Cancel" />
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>