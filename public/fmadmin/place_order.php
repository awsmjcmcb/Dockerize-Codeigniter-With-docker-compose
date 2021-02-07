<?php
	require("includes/function.php");
	include("includes/connection.php");
	date_default_timezone_set('Asia/Kolkata');	
	
	//MAILER REQUIRED DETAIL
	$company_name=APP_NAME;
	$company_website=APP_WEBSITE;
	$qry="SELECT * FROM tbl_settings where id=1";
	$result=mysqli_query($mysqli,$qry);
	$settings_row=mysqli_fetch_assoc($result);
	$owner_no=$settings_row['phone_no'];
	
	$company_email=$settings_row['email_id']; 
	$mail_msg=$settings_row['email_desc'];  
	
	$phone_msg=$settings_row['message_desc']; 
	
	$jsonObj= array();	

	// get data from android app
  	$app_id 			= $_POST['app_id'];
  	$cat_type 			= $_POST['cat_type'];
	$name 				= $_POST['name'];
	$number_of_people 	= $_POST['number_of_people'];
	$address 			= $_POST['address'];
	$order_type 		= $_POST['order_type'];
	$date_time 			= date('d/m/Y h:i A');
	$advance_date 		= $_POST['date']; 
	$advance_time 		= $_POST['time'];
	$phone 				= $_POST['phone'];
	$order_list 		= addslashes($_POST['order_list']);
	$json_order_list 	= $_POST['json_order_list'];
	$comment 			= $_POST['comment'];
	$email 				= $_POST['email'];
	$mobileid 			= $_POST['mobileid'];
	$city_name 			= $_POST['city'];
	$sub_city_name 		= $_POST['sub_city'];
	$user_id			= $_POST['user_id'];
	$amt				= $_POST['amount'];	
	$coupon_code		= $_POST['coupon_code'];	
 

	$link =mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	
		// Check connection
	if($link === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	
	//update coupon_code
	
		if($coupon_code!=null){
			$c_query="SELECT * FROM tbl_coupon_code where coupon_code = '".$coupon_code."'";

			$c_sql = mysqli_query($mysqli,$c_query)or die(mysql_error());
			$c_data = mysqli_fetch_assoc($c_sql);
			
			
			$check_qry = "SELECT * from tbl_coupon_users where coupon_id='".$c_data['id']."' and user_id='".$user_id."'";
			$check_sql = mysqli_query($mysqli,$check_qry)or die(mysql_error());
			$check_data = mysqli_fetch_assoc($check_sql);
			
			$edit_data = array('availability' => $check_data['availability']-1);
			
			$edit_qry = Update('tbl_coupon_users',$edit_data,"WHERE id='".$check_data['id']."'");
		}
	
	//end
	
	// Attempt insert query execution
	$sql = "INSERT INTO tbl_reservation (hotelid, user_id, cat_type, name, number_of_people, date_time, advance_date, advance_time, phone, order_list, json_order_list, comment, email, order_type, address,mobileid,city_name, sub_city_name) 
	VALUES ('$app_id',
	'$user_id',
	'$cat_type',
	'$name',
	'$number_of_people',
	'$date_time', 
	'$advance_date', 
	'$advance_time', 
	'$phone', 
	'$order_list',
	'$json_order_list',
	'$comment',
	'$email',
	'$order_type',
	'$address',
	'$mobileid',
	'$city_name',
	'$sub_city_name')";
	

	// if new reservation has been successfully added to reservation table 
	// send notification to admin via email
	
	if(mysqli_query($link, $sql))	
	{	
	
		$order_id=mysqli_insert_id($link);
		
		//exit('ADDED');
		/*DEDUCT AMOUNT FROM WALLET*/
		$query11="SELECT * FROM tbl_users where id = '".$user_id."' and removeAt=0";
		$sql11 = mysqli_query($link,$query11)or die(mysqli_error());
		$data11 = mysqli_fetch_assoc($sql11);
		$count11=mysqli_num_rows($sql11);
		if($count11>0)
		{
			$amount=$data11['wallet']-$amt;
			$qry=mysqli_query($link,"UPDATE tbl_users SET wallet=".$amount." WHERE id = '".$user_id."'");
		}
		
		
		//SEND MESSAGE TO USER	
		$order_list=" Your order no is ".$order_id;
		$message=$phone_msg.$order_list;	
		sendMessage($user_id,$message);	
	
		
		if($email=="")	
		{
			$qry11="SELECT * FROM tbl_users where id=$user_id";
			$result11=mysqli_query($mysqli,$qry11); 
			$row11=mysqli_fetch_assoc($result11);
			$email = $row11['email'];
			$name = $row11['name'];
		}
		 
	
		//SEND MAIL TO CLIENT
		$to = $email;
		$subject = 'Your Order is Placed';
		$message = $mail_msg."<br>".$order_list;
		$from = $company_email;
		$headers = "From: $company_name <$from>" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to,$subject,$message,$headers);
		
		//SEND MAIL TO OWNER
		$to =$company_email;
		$subject = 'New order recieved from app';
		$message = $order_list;
		$from = $email;
		$headers = "From: $name <$from>" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to,$subject,$message,$headers);
	
	
		//echo "OK";
		$row['error']="false";
		$row['order_id']=$order_id;
	
		$row['message']="Success";
		array_push($jsonObj,$row);
	
	
		//send message & notification to owner
		$users_sql = "SELECT * FROM tbl_user_token t, tbl_users u where t.mobileno=u.mobile and t.receive_order_notification='1'";
		$users_result = mysqli_query($link,$users_sql);
		while($user_row = mysqli_fetch_assoc($users_result))
		{
		
			//SEND NEW ORDER MESSAGE TO OWNER	
			$owner_mob_no=$user_row['mobile'];
			$owner_msg="Your have received new order. Order No : $order_id";
			sendMessageOwner($owner_mob_no,$owner_msg);	
			
			//SEND NEW ORDER NOTIFICATION TO OWNER	
			$title="New Order Received";
			$msg="Your have received new order";
			$type="Normal";
			$img="";
			echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
		}
		
		echo "end";
		
		//send notification to user
		$users_sql = "SELECT * FROM tbl_user_token where mobileid='".$mobileid."'";     
		$users_result = mysqli_query($link,$users_sql);
		$user_row = mysqli_fetch_assoc($users_result);
		
		$title="Congratulations";
   		$msg="Your order have been received by us.";
   		$type="order";
		$img="";
		echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
		
		
	}
	else
	{
		
		echo "Failed";
		$row['error']="true";
		$row['message']="Failed";
		array_push($jsonObj,$row);
	
	}

	$set['ORDER_PLACED'] = $jsonObj;
	
	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();	 

	
	mysqli_close($link);
    
	
	
?>