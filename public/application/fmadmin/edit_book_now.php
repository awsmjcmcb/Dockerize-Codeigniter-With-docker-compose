<?php 
	include("includes/connection.php");
	require("includes/function.php");
	
		$user_id=$_POST['user_id'];
		$data = array( 
			'id'  =>  $_POST['user_id'],
			'name'  =>  $_POST['name'],
			'mobile'  =>  $_POST['mobile'],
			'no_of_seat'  =>  $_POST['number'],
			'seats'  =>  $_POST['seats']
		);		

		$submit=Update('tbl_booking', $data, "WHERE id = '".$user_id."'");
	
	
		$seats=$_POST['seats'];
		$seat_number=explode(",",$seats);
		$total=count($seat_number);
		
		
		//clear data
		$data1 = array( 
			'status'  =>  0,
			'u_id'  => 0
		);		
		$submit=Update('tbl_seats', $data1, "WHERE u_id = '".$user_id."'");
		
		
		//update new data
		for($i=0;$i<$total;$i++)
		{
		   
			$seat_no=$seat_number[$i];
			
			
			$data = array( 
				'status'  =>  1,
				'u_id'  => $user_id
			);	
			$submit=Update('tbl_seats', $data, "WHERE seat_no = '".$seat_no."'");
			  
		}
	   
	   
?>