<?php include("includes/connection.php");
 	  include("includes/function.php"); 
 	  $hh =getallheaders(); 	
	
	date_default_timezone_set('Asia/Kolkata'); 

	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';

 		$jsonObj= array();
		
		$user_id=$_POST['user_id'];
		$version=$_POST['versioncode'];
		
		$qry="SELECT * FROM tbl_users WHERE id='$user_id' and removeAt=0";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_array($result);
		
		$id=$row['id'];
	
      
     	
       			$sql="update tbl_users set versioncode='$version' where id='$id'";
    	
		
		
		if(mysqli_query($mysqli, $sql))
		{
			$row['error']="false";
			//$row2['type']=$action;
		}		
		else
		{
			$row['error']="true";
		}
		
		array_push($jsonObj,$row);
	
		$set['UPDATE_PROFILE'] = $row;
				
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	
		
 	
?>