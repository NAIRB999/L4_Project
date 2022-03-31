<?php
include('connect.php');

$catid=$_GET['c_id'];

$query="DELETE FROM category WHERE category_id='$catid' ";
$ret=mysqli_query($connection,$query);

echo "<script>location.href = ('categorylist.php')</script>";

?>
