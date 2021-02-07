<?php include("includes/connection.php");
 	  include("includes/function.php"); 
 	  $hh =getallheaders(); 	
	//print_r($hh['App-Id']);
	// print_r($_SERVER['Host']);  
	//exit($_SERVER[Host]);

	date_default_timezone_set('Asia/Kolkata'); 

	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';

 		$jsonObj= array();
		
		$user_id=$_POST['user_id'];
		$token=$_POST['token'];
		$mobileid=$_POST['mobileid'];
		
		$qry="SELECT * FROM tbl_users WHERE id='$user_id' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_array($result);
		
		$name=$row['name'];
		$mobileno=$row['mobile'];
		$emailid=$row['email'];
		
     		
			$qry1="SELECT * FROM tbl_user_token WHERE mobileno='$mobileno'";
    		$result1=mysqli_query($mysqli,$qry1);
      		$row1=mysqli_fetch_array($result1);
      
     		if($row1['mobileno']==$mobileno)
      		{
				//$action="update";
       			$sql="update tbl_user_token set name='$name',emailid='$emailid',mobileid='$mobileid',token='$token' where mobileno='$mobileno'";
    		}		
			else
			{				
				//$action="insert";
				$sql = "INSERT INTO tbl_user_token (name,mobileno,emailid,mobileid,token) VALUES ('$name','$mobileno','$emailid','$mobileid','$token')";
			}	

		
		if(mysqli_query($mysqli, $sql))
		{
			$row2['error']="false";
			//$row2['type']=$action;
		}		
		else
		{
			$row2['error']="true";
		}
		
		array_push($jsonObj,$row2);
	
		$set['FEED_SETTING_UPDATE'] = $row2;
				
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	
		
 	
?>