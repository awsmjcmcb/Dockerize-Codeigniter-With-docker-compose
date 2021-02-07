<?php

	require("includes/function.php");
	include("includes/connection.php");
	
	$file_path = 'https://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	 		
	//MOBILE API FOR LOGIN USER
	
		$name = $_POST['name'];
		$mobile = $_POST['mobile'];
		
		$qry="SELECT * FROM tbl_users WHERE mobile='$mobile' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_array($result);
  
		if($row['mobile']!=$mobile)
		{
			
			$sql = "INSERT INTO tbl_users (name,mobile) VALUES ('$name','$mobile')";			
				
			if(mysqli_query($mysqli, $sql))
			{
				//echo "NEW USER REGISTRATION SUCEESSFULL !";
			
				$user_id=mysqli_insert_id($mysqli);	
				
				$jsonObj= array();	
				
				$qry1="SELECT * FROM tbl_users WHERE id='$user_id'";
				$result1=mysqli_query($mysqli,$qry1);
				$data=mysqli_fetch_array($result1);
				
				$row2['error']="false";
				
				$row2['id'] = $data['id'];
				$row2['name'] = $data['name'];
				$row2['mobile'] = $data['mobile'];
					
				array_push($jsonObj,$row2);

				$set['USER_REGISTRATION'] = $row2;
						
			}
			header( 'Content-Type: application/json; charset=utf-8' );
			echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
			die();
			
		}
		else
		{
			
			//echo "USER REGISTRATION FAILED - Mobile Number is Already Registered !";
			
			$jsonObj= array();
			
			$row2['error']="true"; 
			$row2['message']="Your are already register user !";
			
			array_push($jsonObj,$row2);
		
			//$row['hotel_info']=$jsonObj;

			$set['USER_REGISTRATION'] = $row2;
					

			header( 'Content-Type: application/json; charset=utf-8' );
			echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
			die();
			
			
		}		
		
	// Close connection
	mysqli_close($mysqli);
	
	
?>
