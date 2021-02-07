<?php

	include("includes/connection.php");
	include("includes/function.php");
	
	  $hh =getallheaders(); 	
	//print_r($hh['App-Id']);
	// print_r($_SERVER['Host']);  
	 //exit($_SERVER[Host]);
	 
	$user_id =$hh['userid'];

	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';

	$jsonObj= array();
	
	
	$query="SELECT * FROM tbl_scratch_coupons
		LEFT JOIN tbl_sc_users ON tbl_scratch_coupons.id = tbl_sc_users.sc_id
		where tbl_scratch_coupons.visibility=1 and tbl_sc_users.user_id='".$user_id."' ORDER BY tbl_sc_users.id DESC";
	
	$sql = mysqli_query($mysqli,$query)or die(mysql_error());


	while($data = mysqli_fetch_array($sql))
	{
		$row['id'] = $data['id'];
		$row['title'] = $data['title'];
		$row['message'] = $data['message'];
		$row['sorry_msg'] = "Sorry! Better luck next time.";
		$row['congrats_msg'] = "Congratulations! You have been rewarded ".$data['amount']." in your wallet";
		$row['amount'] = $data['amount'];
		$row['type'] = $data['type'];
		if($data['coupon_text']!= null)
			{
				$row['coupon_text'] = $data['coupon_text'];
			}
			else
			{
				$row['coupon_text'] = "";				
			}
		
		$row['image'] = $file_path."images/coupon/".$data['image'];
		$row['scimage'] = $file_path."images/coupon/".$data['image'];
		$row['status'] = $data['status'];
		
		array_push($jsonObj,$row);
		
	}

	$set['SCRATCH_LIST'] = $jsonObj;
		
		$jsonObj1= array();

		$query1="SELECT sc_master_title,sc_master_image FROM tbl_settings";
		$sql1 = mysqli_query($mysqli,$query1)or die(mysqli_error());
		
		
		// Total Cheshback Details
	$qryamount="SELECT * FROM tbl_cashback WHERE u_id='".$user_id."'";
	
 	$resultamount=mysqli_query($mysqli,$qryamount);
	while($row2=mysqli_fetch_array($resultamount))
	{
		$wallet+=$row2['cashback_amount'];
	}
	
		while($data1 = mysqli_fetch_assoc($sql1))
		{

		$row1['master_image'] = $file_path."images/".$data1['sc_master_image'];//$data['master_image'];
		if ($wallet>0) {
			$row1['master_amount'] = $wallet;//$data1['cashback_amount'];...
		}else{
			$row1['master_amount'] = "0";//$data1['cashback_amount'];
		}
		
		$row1['master_subtitle'] = $data1['sc_master_title'];

			array_push($jsonObj1,$row1);
		
		}
		

		$set['MASTER_SCRATCH'] = $jsonObj1;
		
	
	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();

	// Close connection
	mysqli_close($mysqli);


// else if(isset($_GET['get_coupon_users_id']))
// {
// 	$jsonObj= array();
// 	$u_id=$_GET['get_coupon_users_id'];
// 	$query="SELECT * FROM tbl_sc_users where user_id=$u_id ORDER BY id asc";
// 	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
// 	while($data = mysqli_fetch_assoc($sql))
// 	{
// 		$row['id'] = $data['id'];
// 		$row['sc_id'] = $data['sc_id'];
// 		$row['message'] = $data['message'];
// 		$row['amount'] = $data['amount'];
// 		$row['image '] = $file_path."images/coupon/".$data['image'];
// 		$row['visibility'] = $data['visibility'];
		
// 		array_push($jsonObj,$row);
		
// 	}

// 	$set['SCRATCH_LIST'] = $jsonObj;

// 	header( 'Content-Type: application/json; charset=utf-8' );
// 	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
// 	die();

// 	// Close connection
// 	mysqli_close($mysqli);
// }

?>
