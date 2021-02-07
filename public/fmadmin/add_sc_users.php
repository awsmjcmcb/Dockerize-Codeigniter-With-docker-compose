<?php
    include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");



 echo $coupon_id=$_GET['coupon_id'];
 echo $users_id=$_GET['users_id'];

 $data = array( 

		 'sc_id'  =>$coupon_id,
		 'user_id'  =>$users_id
					);		
				 		$qry = Insert('tbl_sc_users',$data);	

				 		$_SESSION['msg']="10";
				 
						header( "Location:manage_users.php");
						 exit;	
 


?>