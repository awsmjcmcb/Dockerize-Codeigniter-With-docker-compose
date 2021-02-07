<?php
    include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");

echo $coupon=$_POST['id'];

$query="select * from tbl_users";
$result=mysqli_query($mysqli,$query);

  while($row=mysqli_fetch_array($result))	
  {
  	echo $users_id=$row['id'];
  	echo "<br>";

	$data = array( 
		'sc_id'  =>$coupon,
		'user_id'  =>$users_id
		);	
		
	$qry = Insert('tbl_sc_users',$data);	

	$_SESSION['msg']="10";

	header( "Location:manage_users.php");
						
  }
?>