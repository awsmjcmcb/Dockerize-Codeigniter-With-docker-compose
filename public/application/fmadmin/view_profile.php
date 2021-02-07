<?php

	include("includes/connection.php");
	include("includes/function.php");
	
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	 		
	//GET MAXIMUM
	$qry1="SELECT * FROM tbl_settings where hotelid='1'";
	$result1=mysqli_query($mysqli,$qry1);
	$settings_row=mysqli_fetch_assoc($result1);
  
 
 
	
	if(isset($_GET['user_id']))
	{
			
		$jsonObj1= array();
	
		$id = $_GET['user_id'];
	
		//MY SAVED PROFILE
		
		$qry="SELECT * FROM tbl_users WHERE id='$id' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$data=mysqli_fetch_array($result);
  
		if($data['id']==$id && $id!="")
		{

			$row2['error']="false";
			
			$row2['id'] = $data['id'];
			$row2['name'] = $data['name'];
			$row2['email'] = $data['email'];
			$row2['mobile'] = $data['mobile'];
			$row2['gender'] = $data['gender'];
			if($data['image']!="")
			{
				$row2['image'] = $file_path.'images/users/'.$data['image']; 
			} 
			else
			{
				$row2['image'] = $file_path.'images/users/default.jpg'; 
			}
			$row2['wallet'] = $data['wallet'];
			$row2['dob'] = $data['dob'];
			$row2['doa'] = $data['doa'];
			
			$row2['latitude'] = $data['latitude'];
			$row2['longitude'] = $data['longitude'];
			$row2['address'] = $data['address'];	
			$row2['location'] = $data['location'];	
			$row2['zipcode'] = $data['zipcode'];	
			$row2['min_amount_rs'] = $settings_row['min_amount_rs'];	
			$row2['min_amount_msg'] = $settings_row['min_amount_msg'];	
		
				
		}
		else
		{			
			//echo "FAILED";			
			$row2['error']="true";		
			$row2['message']="User Not Found !";			
		}		
		
		array_push($jsonObj1,$row2);
	
		$set['USER_PROFILE'] = $jsonObj1;
			
		
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
		
	}	 
	
	// Close connection
	mysqli_close($mysqli);
	
	
?>
