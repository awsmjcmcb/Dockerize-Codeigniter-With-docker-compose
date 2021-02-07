<?php

	include("includes/connection.php");
	
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	 	
		
	//MOBILE API FOR LOGIN USER
	
	
	if(isset($_GET['verify_mobile_no']))
 	{
		$mobile = $_GET['verify_mobile_no'];
	
		$qry="SELECT * FROM tbl_users WHERE mobile='$mobile' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$count=mysqli_num_rows($result);
  
		$jsonObj= array();
		
		if($count > 0)
		{
			$row2['error']="false";
			$row2['message']="Mobile number is successfully verified !";
		}		
		else
		{
			$row2['error']="true";	
			$row2['message']="Mobile number verification failed !";			
		}
		
		
		array_push($jsonObj,$row2);
	
		$set['VERIFY_MOBILE_NNUMBER'] = $row2;
				
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	
	}

	//CHANGE PASSWORD
	if(isset($_GET['mobile_no']))
 	{
		$mobile = $_GET['mobile_no'];
		$password = $_GET['password'];
	
		$qry="SELECT * FROM tbl_users WHERE mobile='$mobile' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$count=mysqli_num_rows($result);
  
		$jsonObj= array();
		
		if($count > 0)
		{
			
			$sql = "UPDATE tbl_users set password='$password' where mobile='$mobile'";				
			if(mysqli_query($mysqli, $sql))	
			{
				
				$qry1="SELECT * FROM tbl_users WHERE mobile='$mobile' and removeAt=0";
				$result1=mysqli_query($mysqli,$qry1);
				$data=mysqli_fetch_array($result1);
				
				$row2['error']="false";
				
				$row2['id'] = $data['id'];
				$row2['name'] = $data['name'];
				$row2['email'] = $data['email'];
				//$row2['password'] = $data['password'];
				$row2['mobile'] = $data['mobile'];
				if($data['image']!="")
				{
					$row2['image'] = $file_path.'images/users/'.$data['image']; 
				} 
				else
				{
					$row2['image'] = $file_path.'images/users/default.jpg'; 
				}
				$row2['gender'] = $data['gender'];
			
				$row2['lat'] = $data['latitude'];
				$row2['long'] = $data['longitude'];
				$row2['address'] = $data['address'];		
				
			}
			
			$row2['message']="Password changed successfully !";
		}		
		else
		{
			$row2['error']="true";	
			$row2['message']="Failed to change password !";			
		}
		
		
		array_push($jsonObj,$row2);
	
		$set['CHANGE_PASSWORD'] = $row2;
				
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	
	}

	
		
	// Close connection
	mysqli_close($mysqli);
		
?>
