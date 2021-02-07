<?php

	include("includes/connection.php");
	
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	 		
	//MOBILE API FOR LOGIN USER
	
	
		$id = $_POST['user_id'];
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$gender = $_POST['gender'];
		$image = $_FILES['image']['name'];
		$dob = $_POST['dob'];
		$doa = $_POST['doa'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$address = $_POST['address'];
		$location = $_POST['location'];
		$zipcode = $_POST['zipcode'];
		
					
		$qry="SELECT * FROM tbl_users WHERE id='$id' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_array($result);
  
		if($row['id']==$id && $id!="")
		{
			
			if($_FILES['image']['name']!="")
			{
				$image="Users-".rand(0,99999)."_".$_FILES['image']['name'];			   			
				$tpath1='images/users/'.$image;
				
				if(move_uploaded_file($_FILES["image"]["tmp_name"], $tpath1)) 
				{			
					//image upload successfully
					$sql = "UPDATE tbl_users set name='$name',email='$email',gender='$gender',image='$image',dob='$dob',doa='$doa',latitude='$latitude',longitude='$longitude',address='$address',location='$location',zipcode='$zipcode' where id='$id'";	
				}			
			}
			else
			{
				$sql = "UPDATE tbl_users set name='$name',email='$email',gender='$gender',dob='$dob',doa='$doa',latitude='$latitude',longitude='$longitude',address='$address',location='$location',zipcode='$zipcode' where id='$id'";				
			}
			if(mysqli_query($mysqli, $sql))
			{
				//echo "-------------SUCEESSFULL------------\n";			
			}
			
			$jsonObj= array();	
			
			$qry1="SELECT * FROM tbl_users WHERE id='$id'";
			$result1=mysqli_query($mysqli,$qry1);
			$data=mysqli_fetch_array($result1);
			
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
	
			array_push($jsonObj,$row2);

			$set['UPDATE_PROFILE'] = $row2;
		
			header( 'Content-Type: application/json; charset=utf-8' );
			echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
			die();
			
			
		}
		else
		{
			
			//echo "USER UPDATE PROFILE FAILED - Due to user id are not match!";
			
			$jsonObj= array();
			
			$row2['error']="true";
			
			array_push($jsonObj,$row2);
		
			//$row['hotel_info']=$jsonObj;

			$set['UPDATE_PROFILE'] = $row2;
					

			header( 'Content-Type: application/json; charset=utf-8' );
			echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
			die();
			
			
		}		
		
	// Close connection
	mysqli_close($mysqli);
	
	
?>
