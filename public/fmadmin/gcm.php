<?php

 //require("includes/function.php");
	//include("includes/connection.php");
	
	
	DEFINE ('DB_USER', 'hotelsilverleaf');
	 DEFINE ('DB_PASSWORD', 'h@rdik@silver');
	 DEFINE ('DB_HOST', 'localhost'); //host name depends on server
	 DEFINE ('DB_NAME', 'silverleafindia');
		
 
	 $link =mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	
		// Check connection
	if($link === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	
	$mobileid 		= $_GET['mobileid'];
	$token 			= $_GET['token'];

		 $qry="SELECT * FROM tbl_user_token WHERE mobileid='$mobileid'";
    		  $result=mysqli_query($link,$qry);
      		$row=mysqli_fetch_assoc($result);
      
     		 if($row['mobileid']==$mobileid)
      		{
       			 $sqll="update tbl_user_token set token='$token' where mobileid='$mobileid'";
       			if(mysqli_query($link, $sqll)){
		
			echo "update OK";
			}else{
			echo "update Failed";
			}	
    		 }
		
		else
		{
		$sql = "INSERT INTO tbl_user_token (mobileid,token) 
						VALUES ('$mobileid',
						'$token')";
									
	
		
	

  // send notification to admin via email
	if(mysqli_query($link, $sql)){
		
		echo "OK";
	}else{
		echo "Failed";
	}
	}
	// Close connection
	mysqli_close($link);
	
	
?>
