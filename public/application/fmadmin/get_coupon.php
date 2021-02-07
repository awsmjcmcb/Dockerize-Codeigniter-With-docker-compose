<?php

	include("includes/connection.php");
	include("includes/function.php");

	$hh =getallheaders();
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
	$user_id =$hh['userid'];
	$coupon_code = $hh['coupon_code'];
	$min_value = $hh['min_value'];



	if(isset($_GET['get_discount'])){

		$jsonObj= array();
		$current_date = date("Y-m-d");

		$query="SELECT * FROM tbl_coupon_code where coupon_code = '".$coupon_code."'";

		$sql = mysqli_query($mysqli,$query)or die(mysql_error());
		$data = mysqli_fetch_assoc($sql);


							$add_data = array(
								'coupon_id' => $data['id'],
								'user_id' => $user_id,
								'availability' => $data['no_uses']
							);

		if ($data['visibility']=="1") {
				
			if ($current_date<=$data['exp_date']) {

				if ($data['min_order']<=$min_value) {
			
					//check whether record exist
					$check_qry = "SELECT * from tbl_coupon_users where coupon_id='".$data['id']."' and user_id='".$user_id."'";
					$check_sql = mysqli_query($mysqli,$check_qry)or die(mysql_error());
					$check_data = mysqli_fetch_assoc($check_sql);

					if (is_null($check_data)) {
						//add coupon to user
						 $add_qry = Insert('tbl_coupon_users',$add_data);
						 $row['error'] = "false";
						 $row['message'] = "Coupon code applied successfully.";
						 $row['title'] = "Yay";
						 
						 //check coupon_type and calculate discount
					if($data['coupon_type']=="percentage"){
						//echo "percentage";
						$discount = ($min_value * $data['coupon_value'])/100;
						$discount_amount = $min_value - $discount;
						//echo $discount_amount."\n".$discount;
						$row['pay_amount'] = $discount_amount;
						$row['discount'] = $discount;
						$row['amount'] = $min_value;
					}else{
						//echo "amount";
						$discount = $min_value - $data['coupon_value'];
						//echo $discount."\n".$data['coupon_value'];
						$row['pay_amount'] = $discount;
						$row['discount'] = $data['coupon_value'];
						$row['amount'] = $min_value;
					}
					//end check coupon_type
					
						//end
					}else{
						if($check_data['availability']>0){
							//update coupon
							$edit_data;// $edit_data = array('amount' => $min_value);
							
							//check coupon_type and calculate discount
									if($data['coupon_type']=="percentage"){
										//echo "percentage";
										$discount = ($min_value * $data['coupon_value'])/100;
										$discount_amount = $min_value - $discount;
										//echo $discount_amount."\n".$discount;
										$row['pay_amount'] = $discount_amount;
										$row['discount'] = $discount;
										$row['amount'] = $min_value;
										$edit_data = array('amount' => $min_value,
															'pay_amount' => $discount_amount,
															'discount' => $discount);
									}else{
										//echo "amount";
										$discount_amount = $min_value - $data['coupon_value'];
										//echo $discount."\n".$data['coupon_value'];
										$row['pay_amount'] = $discount_amount;
										$row['discount'] = $data['coupon_value'];
										$row['amount'] = $min_value;
										$edit_data = array('amount' => $min_value,
															'pay_amount' => $discount_amount,
															'discount' => $data['coupon_value']);
									}
									//end check coupon_type
								
							$edit_qry = Update('tbl_coupon_users',$edit_data,"WHERE id='".$check_data['id']."'");
							$row['error'] = "false";
							$row['message'] = "Coupon code applied successfully.";	
							$row['title'] = "Yay";							
								
							//end
						}else{
							$row['error'] = "true";
							$row['message'] = "Coupon Usage Completed";
							$row['title'] = "Oops";
							$row['pay_amount'] = "";
							$row['discount'] = "";
							$row['amount'] = "";
						}
					}
					//end checking record
					
					
					
				}else{
					$row['error'] = "true";
					$row['message'] = "Minimum amount doesn't match";
					$row['title'] = "Oops";
					$row['pay_amount'] = "";
					$row['discount'] = "";
					$row['amount'] = "";
				}
			}else{
				$row['error'] = "true";
				$row['message'] = "Coupon Expired";
				$row['title'] = "Oops";
				$row['pay_amount'] = "";
				$row['discount'] = "";
				$row['amount'] = "";
			}

		}else{
			$row['error'] = "true";
			$row['message'] = "Coupon Not Available";
			$row['title'] = "Oops";
			$row['pay_amount'] = "";
			$row['discount'] = "";
			$row['amount'] = "";
		}
		
		array_push($jsonObj,$row);

		$set['GET_DISCOUNT'] = $jsonObj;
	}else if(isset($_GET['remove_discount'])){
		$jsonObj= array();
		
		//get coupon id
		$query="SELECT * FROM tbl_coupon_code where coupon_code = '".$coupon_code."'";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());
		$data = mysqli_fetch_assoc($sql);
		
		//remove coupon discount
		$edit_data = array('amount' => $min_value,'pay_amount'=>"0",'discount'=>"0");
		$edit_qry = Update('tbl_coupon_users',$edit_data,"where coupon_id='".$data['id']."' and user_id='".$user_id."'");
		
		$row['error'] = "false";
		$row['message'] = "Updated amount";
		
		array_push($jsonObj,$row);
		$set['REMOVE_DISCOUNT'] = $jsonObj;
	}else if(isset($_GET['coupon_list'])){
	    $jsonObj= array();
	
	
    	$query="SELECT * FROM tbl_coupon_code where visibility=1";
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
    
    
    	while($data = mysqli_fetch_array($sql))
    	{
    		$row['id'] = $data['id'];
    		$row['title'] = $data['title'];
    		$row['tandc'] = $data['tandc'];
    		$row['min_order'] = $data['min_order'];
    		$row['exp_date'] = $data['exp_date'];
    		$row['coupon_code'] = $data['coupon_code'];
    		
    		array_push($jsonObj,$row);
    		
    	}
    
    	$set['COUPON_LIST'] = $jsonObj;
	}
		
	
	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();

	// Close connection
	mysqli_close($mysqli);

?>