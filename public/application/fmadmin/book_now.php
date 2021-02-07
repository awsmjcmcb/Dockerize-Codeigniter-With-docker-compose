<?php 
	include("includes/connection.php");
	require("includes/function.php");
	
	
		$data = array( 
			'name'  =>  $_POST['name'],
			'mobile'  =>  $_POST['mobile'],
			'no_of_seat'  =>  $_POST['number'],
			'seats'  =>  $_POST['seats']
		);		

 		$submit = Insert('tbl_booking',$data);	
		
		$last_id = mysqli_insert_id($mysqli);
		 
		
		$seats=$_POST['seats'];
		$seat_number=explode(",",$seats);
		$total=count($seat_number);
		
	   for($i=0;$i<$total;$i++)
	   {
		   
			$seat_no=$seat_number[$i];
			
			
			$data = array( 
				'status'  =>  1,
				'u_id'  => $last_id
			);	
		  $submit=Update('tbl_seats', $data, "WHERE seat_no = '".$seat_no."'");
		  
	   }
	   
	   
?>