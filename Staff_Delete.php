<?php
include('connect.php');

$StaffID=$_GET['StaffID'];

$query="DELETE FROM Staff WHERE StaffID='$StaffID' ";
$ret=mysqli_query($connection,$query);

if($ret) //true
{
	echo "<script>window.alert('Staff Account Deleted!')</script>";
	echo "<script>window.location='Staff_Entry.php'</script>";
}
else
{
	echo "<p>Something went wrong in Staff Delete " . mysqli_errno($connection) . "</p>";
}

?>