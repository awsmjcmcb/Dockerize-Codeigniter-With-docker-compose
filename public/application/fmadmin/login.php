<?php

	include("includes/connection.php");
	
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	 	
		
	//MOBILE API FOR LOGIN USER
	
	/* DEFINE ('DB_USER', 'silverleafapp');
	DEFINE ('DB_PASSWORD', 'Shah@123');
	DEFINE ('DB_HOST', 'localhost'); //host name depends on server
	DEFINE ('DB_NAME', 'silverleafapp');
		
 
	 $link =mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	
		// Check connection
	if($link === false)
	{
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	 */
	
	
		$mobile = $_GET['mobile'];
		$name = $_GET['name'];
		$dob = $_GET['dob'];
		//$password = $_GET['password'];
	
		$qry="SELECT * FROM tbl_users WHERE mobile='$mobile' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_array($result);
		$count=mysqli_num_rows($result);
		
		/* if($row['mobile']==$mobile && $row['password']==$password) */	
		if($count>0)
		{
		   
		       	$sql="update tbl_users set name='$name',mobile='$mobile',dob='$dob' where id='".$row['id']."'";
		       	$result =mysqli_query($mysqli, $sql);
            // 		if(mysqli_query($mysqli, $sql))
            // 		{
            // 			$row['error']="false";
            // 		}		
            // 		else
            // 		{
            // 			$row['error']="true";
            // 		}
	
			
			//REGISTER USER SET LOGIN SUCEESSFULL
				
				$jsonObj= array();	

				$row2['error']="false";
				$row2['msg']="Login Successfully";
				$row2['id'] = $row['id'];
				$row2['name'] = $row['name'];
				$row2['email'] = $row['email'];
				$row2['mobile'] = $row['mobile'];
				$row2['dob'] = $row['dob'];
				if($row['image']!="")
				{
					$row2['image'] = $file_path.'images/users/'.$row['image']; 
				} 
				else
				{
					$row2['image'] = $file_path.'images/users/default.jpg'; 
				}
				$row2['gender'] = $row['gender'];
			
				array_push($jsonObj,$row2);
			
				$set['LOGGED_IN_USER'] = $row2;
		
			header( 'Content-Type: application/json; charset=utf-8' );
			echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
			die();
			
		}		
		else
		{
			//NOT REGISTER USER JUST REGISTER THEM
			
			$jsonObj= array();
			
			$sql = "INSERT INTO tbl_users (name,mobile,dob) VALUES ('$name','$mobile','$dob')";		
			
			if(mysqli_query($mysqli, $sql))
			{
				$user_id=mysqli_insert_id($mysqli);	
				
				
				$qry="SELECT * FROM tbl_users WHERE id='$user_id' and removeAt=0";
				$result=mysqli_query($mysqli,$qry);
				$row=mysqli_fetch_array($result);
				
				$row2['error']="false";
				$row2['msg']="Login Successfully";
				$row2['id'] = $row['id'];
				$row2['name'] = $row['name'];
				$row2['email'] = $row['email'];
				$row2['mobile'] = $row['mobile'];
				$row2['dob'] = $row['dob'];
				if($row['image']!="")
				{
					$row2['image'] = $file_path.'images/users/'.$row['image']; 
				} 
				else
				{
					$row2['image'] = $file_path.'images/users/default.jpg'; 
				}
				$row2['gender'] = $row['gender'];
			
				array_push($jsonObj,$row2);
			
				$set['LOGGED_IN_USER'] = $row2;
				
			}
			
			header( 'Content-Type: application/json; charset=utf-8' );
			echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
			die();
			
		}
		
	
	// Close connection
	mysqli_close($mysqli);
	
	
?>
