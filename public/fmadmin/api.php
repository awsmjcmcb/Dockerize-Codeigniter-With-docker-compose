<?php 

	include("includes/connection.php");
 	include("includes/function.php"); 
 	  $hh =getallheaders(); 	
	//print_r($hh['App-Id']);
	// print_r($_SERVER['Host']);  
	 //exit($_SERVER[Host]);
	 
	$app_id =$hh['App-Id'];
	$user_id =$hh['userid'];
	 
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	 	
 	if(isset($_GET['get_hotels']))
	{
		$jsonObj_2= array();	

		$query1="SELECT * FROM tbl_admin ORDER BY sorting";
		$sql1 = mysqli_query($mysqli,$query1)or die(mysql_error());

		while($data1 = mysqli_fetch_assoc($sql1))
		{
		$query2="SELECT * FROM tbl_settings where hotelid='".$data1['id']."' ORDER BY sort";
		$sql2 = mysqli_query($mysqli,$query2)or die(mysql_error());

		while($data2 = mysqli_fetch_assoc($sql2))
		{	
			$row2['app_name'] = $data2['app_name'];
			$row2['app_logo'] = $data2['app_logo'];			
		}

		$row2['id'] = $data1['id'];
		
		array_push($jsonObj_2,$row2);
	
		}

		//$row['hotel_info']=$jsonObj_2;

		$set['SINGLE_HOTEL_APP'] = $jsonObj_2;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}

 	else if(isset($_GET['home']))
	{		 
		$jsonObj_1= array();	

		$query="SELECT id,hotelid,banner_name,banner_image FROM tbl_home_banner where hotelid=1 ORDER BY tbl_home_banner.id";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			$row1['id'] = $data['id'];
			$row1['banner_image'] = $file_path.'images/'.$data['banner_image'];
   
			array_push($jsonObj_1,$row1);	
		}

		$row['home_banner']=$jsonObj_1;
		
		$jsonObj_2= array();	

		$query2="SELECT hotel_name,hotelid,hotel_address FROM tbl_hotel WHERE hotelid=1";
		$sql2 = mysqli_query($mysqli,$query2)or die(mysql_error());

		while($data2 = mysqli_fetch_assoc($sql2))
		{
		
			$row2['hotel_name'] = $data2['hotel_name'];
			$row2['hotel_address'] = $data2['hotel_address'];

			array_push($jsonObj_2,$row2);		
		}

		$row['hotel_info']=$jsonObj_2;

		$set['SINGLE_HOTEL_APP'] = $row;
		//echo "22";
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	else if(isset($_GET['hotel_info']))
	{
	
		$jsonObj_2= array();	

		$query2="SELECT * FROM tbl_hotel WHERE hotelid='$app_id'";
		$sql2 = mysqli_query($mysqli,$query2)or die(mysql_error());

		while($data2 = mysqli_fetch_assoc($sql2))
		{
			
			$row2['hotel_name'] = $data2['hotel_name'];
			$row2['hotel_address'] = $data2['hotel_address'];
			$row2['hotel_lat'] = $data2['hotel_lat'];
			$row2['hotel_long'] = $data2['hotel_long'];
			$row2['hotel_info'] = $data2['hotel_info'];
			$row2['hotel_amenities'] = $data2['hotel_amenities'];
 			
			array_push($jsonObj_2,$row2);
		}

		$row['hotel_info']=$jsonObj_2;

		$set['SINGLE_HOTEL_APP'] = $row;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}	
	else if(isset($_GET['cat_list']))
 	{
 		$jsonObj= array();

		$query="SELECT cid,hotelid,category_name,category_image FROM tbl_category where hotelid='$app_id' ORDER BY tbl_category.cid";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			//Wallpaper count
			$query_wall = "SELECT COUNT(*) as num FROM tbl_wallpaper WHERE cat_id='".$data['cid']."'";
	        $total_wall = mysqli_fetch_array(mysqli_query($mysqli,$query_wall));
	        $total_wall = $total_wall['num'];	

			$row['cid'] = $data['cid'];
			$row['category_name'] = $data['category_name'];
			$row['category_image'] = $file_path.'images/'.$data['category_image'];
			$row['category_image_thumb'] = $file_path.'images/thumbs/'.$data['category_image'];

			$row['total_wallpaper'] = $total_wall;
			 

			array_push($jsonObj,$row);
		
		}

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
 	}
 	//Menu Category
 	else if(isset($_GET['menucat_list']))
 	{
 		$jsonObj= array();
	
		$query="SELECT cid,hotelid,category_name,category_image FROM tbl_menucategory where visibility=1 and hotelid='$app_id' ORDER BY tbl_menucategory.cid";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			//Wallpaper count
			$query_wall = "SELECT COUNT(*) as num FROM tbl_menuwallpaper WHERE visibility=1 and cat_id='".$data['cid']."'";
	        $total_wall = mysqli_fetch_array(mysqli_query($mysqli,$query_wall));
	        $total_wall = $total_wall['num'];	

			$row['cid'] = $data['cid'];
			$row['category_name'] = $data['category_name'];
			$row['category_image'] = $file_path.'images/'.$data['category_image'];
			$row['category_image_thumb'] = $file_path.'images/thumbs/'.$data['category_image'];

			$row['total_wallpaper'] = $total_wall;
			array_push($jsonObj,$row);
		}

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
 	}
	
	else if(isset($_GET['city_list']))
 	{
 	
 		$jsonObj= array();

		$query="SELECT * FROM tbl_city ORDER BY id asc";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			$row['id'] = $data['id'];
			$row['city_name'] = $data['city_name'];
			$row['delivery_amount'] = $data['delivery_amount'];
			array_push($jsonObj,$row);
		}

		$set['CITY_LIST'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
		
 	}
	
	else if(isset($_GET['sub_city_list_by_city_id']))
 	{
 		$jsonObj= array();
		$city_id=$_GET['sub_city_list_by_city_id'];
		
		$query="SELECT * FROM tbl_city_list where city_id=$city_id ORDER BY id asc";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			$row['id'] = $data['id'];
			$row['city_id'] = $data['city_id'];
			$row['sub_city_name'] = $data['sub_city'];
			array_push($jsonObj,$row);
		}

		$set['SUB_CITY_LIST'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// mobile id count
 	else if(isset($_GET['mobileid']))
 	{
 	
 		$mobileid=$_GET['mobileid'];
 		$jsonObj= array();
	
		$query="SELECT *  FROM tbl_reservation where hotelid='$app_id' AND  mobileid='".$mobileid."' ORDER BY tbl_reservation.ID DESC";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			//Wallpaper count
			//$query_wall = "SELECT COUNT(*) as num FROM tbl_menuwallpaper WHERE cat_id='".$data['cid']."'";
	        //$total_wall = mysqli_fetch_array(mysqli_query($mysqli,$query_wall));
	        //$total_wall = $total_wall['num'];
	        $row['ID'] = $data['ID'];
	        $row['mobileid'] = $data['mobileid'];	
			$row['name'] = $data['name'];
			//$row['number_of_people'] = $data['number_of_people'];
			$row['date_time'] = $data['date_time'];
			$row['cat_type'] = $data['cat_type'];
			$row['phone'] = $data['phone'];
			$row['order_list'] = $data['order_list'];
			//$row['status'] = $data['status'];
			if ($data['status']=='0')
			{
				$row['status']="Pending";
			}
			if ($data['status']=='1')
			{
				$row['status']="In Progress";
			}
			if ($data['status']=='2')
			{
				$row['status']="Completed";
			}
			if ($data['status']=='3')
			{
				$row['status']="Dispatched";
			}
			if ($data['cancel_status']=='1')
			{
				$row['status']="Order Cancelled";
			}
			$row['comment'] = $data['comment'];
			$row['email'] = $data['email'];
			$row['deltime'] = $data['delivery_time'];

			$row['addate'] = $data['advance_date'];
			$row['adtime'] = $data['advance_time'];
			$row['admsg'] = "Expected delivery date is %s.";
			$row['delmsg'] = "Expected delivery time is %s.";
			$row['deldone'] = "Your Order is completed.";
			$row['order_type'] = $data['order_type'];
			$row['address'] = $data['address'];
			
			array_push($jsonObj,$row);	
		}

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
 	}
	
 	//Menu Subcategory
 	else if(isset($_GET['menusubcat_id']))
	{
 
	$cat_id=$_GET['menusubcat_id'];	
	
	$jsonObj= array();

	$jsonObj1= array();
	
	$query="SELECT * FROM tbl_menuwallpaper
		LEFT JOIN tbl_menucategory ON tbl_menuwallpaper.cat_id= tbl_menucategory.cid 
		where tbl_menuwallpaper.visibility=1 and tbl_menuwallpaper.cat_id='".$cat_id."' AND tbl_menuwallpaper.hotelid=1 ORDER BY tbl_menuwallpaper.id ASC";
	
	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
	while($data = mysqli_fetch_assoc($sql))
	{
		$row['id'] = $data['id'];
		
		if($data['food_type']==1)
			{
				$row['food_type_icon'] = $file_path.'images/img/veg.png';
			}
			else
			{
				$row['food_type_icon'] = $file_path.'images/img/none.png';				
			}
			
		if($data['cat_food_type']=="Jain")
			{
				$row['cat_food_type'] = $data['cat_food_type'];
			}
			else
			{
				$row['cat_food_type'] = "";				
			}
		
		$row['food_type'] = $data['food_type'];
		$row['cat_type'] = $data['cat_type'];
		$row['cat_id'] = $data['cat_id'];
		$row['name'] = $data['name'];
		$row['des'] = $data['des'];
		
		
		$row['food_opening_time'] = $data['food_opening_time'];
		$row['food_closing_time'] = $data['food_closing_time'];
		$row['food_time_msg'] = "Sorry! %s is not available now. Available between %s";
		$row['wallpaper_image'] = $file_path.'categories/'.$data['cat_id'].'/'.$data['image'];
		$row['wallpaper_image_thumb'] = $file_path.'categories/'.$data['cat_id'].'/thumbs/'.$data['image'];
		$row['price'] = $data['price'];
		$row['min_kg'] = $data['min_kg'];
		$row['max_kg'] = $data['max_kg'];
		$fla=explode(',',$data['f_id']);
		
		if($data['cat_type']=="instock")
		{
			$row['flavour_list']="";
		}	
		//sublist start		  
		else
		{
			for($i=0;$i<=count($fla);$i++){
					   $qry1= "SELECT * FROM tbl_flavour where f_id='".$fla[$i]."' ORDER BY f_id asc";
					   
					   $result1=mysqli_query($mysqli,$qry1);
					   
						while($data1=mysqli_fetch_assoc($result1))
						{	
							$row1['f_id'] = $data1['f_id'];
							$row1['flavour_name'] = $data1['flavour_name'].",";
							array_push($jsonObj1,$row1);
						}
						 $row['flavour_list']=$jsonObj1;
				  }
				  $jsonObj1= array();	  
		}
		//sublist end
		array_push($jsonObj,$row);
	}

	$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
/* 
		$jsonObj= array();	
	
	    $query="SELECT * FROM tbl_menuwallpaper
		LEFT JOIN tbl_menucategory ON tbl_menuwallpaper.cat_id= tbl_menucategory.cid 
		where tbl_menuwallpaper.visibility=1 and tbl_menuwallpaper.cat_id='".$cat_id."' AND tbl_menuwallpaper.hotelid=1 ORDER BY tbl_menuwallpaper.id ASC";

		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			
			$row['id'] = $data['id'];
			
			if($data['food_type']==1)
			{
				$row['food_type_icon'] = $file_path.'images/img/veg.png';
			}
			else
			{
				$row['food_type_icon'] = $file_path.'images/img/none.png';				
			}
			
			
			if($data['cat_food_type']=="Jain")
			{
				$row['cat_food_type'] = $data['cat_food_type'];
			}
			else
			{
				$row['cat_food_type'] = "";				
			}
			
			$row['cat_type'] = $data['cat_type'];
			$row['cat_id'] = $data['cat_id'];
			$row['name'] = $data['name'];
			$row['des'] = $data['des'];
 			$row['wallpaper_image'] = $file_path.'categories/'.$data['cat_id'].'/'.$data['image'];
 			$row['wallpaper_image_thumb'] = $file_path.'categories/'.$data['cat_id'].'/thumbs/'.$data['image']; 
 			$row['price'] = $data['price'];
 			$row['min_kg'] = $data['min_kg'];
 			$row['max_kg'] = $data['max_kg'];
 			$row['total_views'] = $data['total_views'];

			//$row['cid'] = $data['cid'];
			$row['category_name'] = $data['category_name'];
			$row['category_image'] = $file_path.'images/'.$data['category_image'];
			$row['category_image_thumb'] = $file_path.'images/thumbs/'.$data['category_image'];
		
			array_push($jsonObj,$row);
		
		}

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
 */		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
	}
	
 	//Menu Fast Food List
 	else if(isset($_GET['fast_food_list']))
	{ 
 
		$cat_id=72;	  //CATEGORY fast_food=72 

		$jsonObj= array();	
		$jsonObj1= array();	
	
	$qry11="SELECT * FROM tbl_settings where hotelid='1'";
	$result11=mysqli_query($mysqli,$qry11);
	$settings_row=mysqli_fetch_assoc($result11);
  
		$query="SELECT * FROM tbl_menucategory where cid=$cat_id";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());
		$count=mysqli_num_rows($sql);
		$data = mysqli_fetch_array($sql);
		
		$row1['cid'] = $data['cid'];
		//$row1['category_name'] = $data['category_name'];
		$row1['category_name'] = $settings_row['fast_food_name'];


		array_push($jsonObj1,$row1);

		$set['MENU_CATEGORY'] = $jsonObj1;

	    $query="SELECT * FROM tbl_menuwallpaper
		LEFT JOIN tbl_menucategory ON tbl_menuwallpaper.cat_id= tbl_menucategory.cid 
		where tbl_menuwallpaper.visibility=1 and tbl_menuwallpaper.cat_id='".$cat_id."' AND tbl_menuwallpaper.hotelid=1 ORDER BY tbl_menuwallpaper.id ASC LIMIT 10";

		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			
			$row['id'] = $data['id'];
			
			if($data['food_type']==1)
			{
				$row['food_type_icon'] = $file_path.'images/img/veg.png';
			}
			else
			{
				$row['food_type_icon'] = $file_path.'images/img/none.png';				
			}
			
			
			if($data['cat_food_type']=="Jain")
			{
				$row['cat_food_type'] = $data['cat_food_type'];
			}
			else
			{
				$row['cat_food_type'] = "";				
			}
			
			$row['cat_type'] = $data['cat_type'];
			$row['cat_id'] = $data['cat_id'];
			$row['name'] = $data['name'];
			$row['des'] = $data['des'];
			$row['food_opening_time'] = $data['food_opening_time'];
			$row['food_closing_time'] = $data['food_closing_time'];
			$row['food_time_msg'] = "Sorry! %s is not available now. Available between %s";
 			$row['wallpaper_image'] = $file_path.'categories/'.$data['cat_id'].'/'.$data['image'];
 			$row['wallpaper_image_thumb'] = $file_path.'categories/'.$data['cat_id'].'/thumbs/'.$data['image']; 
 			$row['price'] = $data['price'];
 			
			array_push($jsonObj,$row);
		
		}

		$set['FOOD_LIST'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	
	
	//Reservation	
	else if(isset($_GET['placeorder']))
	{
	
		
		echo $_GET['placeorder'];
		
		
		$name 				= $_GET['name'];
		/*$number_of_people 		= $_GET['number_of_people'];
		$address 			= $_GET['address'];
		$order_type 			= $_GET['order_type'];
		$date_time 			= $_GET['date_time'];
		$phone 				= $_GET['phone'];
		$order_list 			= $_GET['order_list'];
		$comment 			= $_GET['comment'];
		$email 				= $_GET['email'];
		
		
		
		$query="insert into tbl_reservation(name,number_of_people,date_time,phone,order_list,comment,email,order_type,address)
		values('".$name."','".$number_of_people."',now(),'".$phone."','".$order_list."','".$comment."','".$email."','".$order_type."','".$address."')";
		//echo $query;
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
		
		
		 if(mysqli_query($mysqli,$query)){
 
 					echo 'Success';
 
 						} 
			 else{
 
 			echo 'Try Again';
 
 				}
		*/
		$query="insert into tbl_reservation(name)
		values('".$name."')";
		
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
		
		
		 if(mysqli_query($mysqli,$query))
		 {
 			echo 'yes'; 
 		} else{
 			echo 'no';
 
 				}
		
	}	
	
	// token
	/*else  if ( isset ( $_POST['mobileid'], $_POST['token'] ) )
	{
		 $mobileid = $_POST['mobileid'];
  		  $token = $_POST['token'];*/
		
	/*  $qry="SELECT * FROM tbl_user_token WHERE token='".$_GET['android_token']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);
      
      if($row['token']==$_GET['android_token'])
      {
       		$set['DIRECTORY_APP'][]=array('msg' => "token already added",'success'=>'0');
      }
      else
	  {*/
			 
/*		     $data = array(            
               'mobileid'  =>  $mobileid,
                'token'  =>  $token,
               );  
      
     		$qry = Insert('tbl_user_token',$data);

            $set['DIRECTORY_APP'][]=array('msg' => 'Success','Success'=>'1');
				
	 // }

 
	 	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();

	}*/
	else if(isset($_GET['placeorderr']))
	{
	
    		$name = isset($_POST['name']) ? mysql_real_escape_string($_POST['name']) : "";
  	 	/* $number_of_people = isset($_POST['number_of_people']) ? mysql_real_escape_string($_POST['number_of_people']) : "";
  	 	 $address = isset($_POST['address']) ? mysql_real_escape_string($_POST['address']) : "";
  	 	 $order_type = isset($_POST['order_type']) ? mysql_real_escape_string($_POST['order_type']) : "";
		$date_time = isset($_POST['date_time']) ? mysql_real_escape_string($_POST['date_time']) : "";
		$phone = isset($_POST['phone']) ? mysql_real_escape_string($_POST['phone']) : "";
		$order_list = isset($_POST['order_list']) ? mysql_real_escape_string($_POST['order_list']) : "";
		$comment = isset($_POST['comment']) ? mysql_real_escape_string($_POST['comment']) : "";
		$email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) : "";*/
		
		//$query="INSERT INTO tbl_reservation  VALUES ('$name','$number_of_people',now(),'$phone','$order_list','$comment','$email','$order_type','$address');";
		$query="INSERT INTO tbl_reservation  VALUES ('$name');";
		 $qur = mysql_query($query);
		  if ($qur) 
			{
       			 $json = array("msg"=>"successfully");
		
   			 } else {
			        $json = array("msg"=>"not successfully");
   		 }
   		 
	}
	else if(isset($_GET['cat_id']))
	{
 
		$cat_id=$_GET['cat_id'];	

		$jsonObj= array();	
	
	    $query="SELECT * FROM tbl_wallpaper
		LEFT JOIN tbl_category ON tbl_wallpaper.cat_id= tbl_category.cid 
		where tbl_wallpaper.cat_id='".$cat_id."'  AND tbl_wallpaper.hotelid='$app_id'  ORDER BY tbl_wallpaper.id DESC";

		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			$row['id'] = $data['id'];
			$row['cat_id'] = $data['cat_id'];
 			$row['wallpaper_image'] = $file_path.'categories/'.$data['cat_id'].'/'.$data['image'];
 			$row['wallpaper_image_thumb'] = $file_path.'categories/'.$data['cat_id'].'/thumbs/'.$data['image']; 
 			$row['total_views'] = $data['total_views'];

			$row['cid'] = $data['cid'];
			$row['category_name'] = $data['category_name'];
			$row['category_image'] = $file_path.'images/'.$data['category_image'];
			$row['category_image_thumb'] = $file_path.'images/thumbs/'.$data['category_image'];
			 

			array_push($jsonObj,$row);
		
		}

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();

		
	} 	
	else if(isset($_GET['cancel_order_id']))
	{
		$jsonObj= array();	

		$qry=mysqli_query($mysqli,"UPDATE tbl_reservation SET cancel_status=1 WHERE id = '".$_GET['cancel_order_id']."'");
 
		if($qry)
		{
			$row['error']="false";
			$row['message']="Success";
			array_push($jsonObj,$row);
		}
		else
		{
			$row['error']="true";
			$row['message']="failed";
			array_push($jsonObj,$row);
		
		}
  
		$set['CANCEL_ORDER'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	 

	}
	
	else if(isset($_GET['wallet_pay']))
	{
		
		$jsonObj= array();	
		$amt=$_GET['amount'];
		$sc_id=$_GET['sc_id'];

		
		
		
		$query="SELECT * FROM tbl_users where id = '".$user_id."' and removeAt=0";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
		$data = mysqli_fetch_assoc($sql);
		$count=mysqli_num_rows($sql);
		
		if($count>0)
		{
			$amount=$data['wallet']+$amt;
			
			$qry=mysqli_query($mysqli,"UPDATE tbl_users SET wallet=".$amount." WHERE id = '".$user_id."'");
	 
			if($qry)
			{

				date_default_timezone_set('Asia/Kolkata');
				$time = date('Y/m/d H:i:s');
		        $data1 = array( 
					'u_id'  =>  $user_id,
					'cashback_amount'  =>  $amt,
					'datetime' => $time
					);		

		 		$qry = Insert('tbl_cashback',$data1);

				$data2 = array('status'  =>  1);		
				$qry2=Update('tbl_sc_users', $data2, "WHERE id = '".$sc_id."'");


//send notification
		 		$users_sql = "SELECT * FROM tbl_user_token where mobileno='".$data['mobile']."'";     
				$users_result = mysqli_query($mysqli,$users_sql);
				$user_row = mysqli_fetch_assoc($users_result);
		
		

//end notification 

				$row['error']="false";
				$row['user_id']=$user_id;
				$row['wallet']=$amount;
				$row['error']="false";
				$row['message']="Success";
				array_push($jsonObj,$row);

				if($amt>0)
						{
							$reward="You have been rewarded Rs.".$amt." from Cake Lovers Team. You can use it on your next order.";
						
						//SEND MESSAGE TO USER	
						sendMessage($user_id,$reward);
						
						//send notification to user
						$title="Congratulations ".$data['name']."!";
				   		$msg="You have been rewarded Rs ".$amt." is your wallet.";
				   		$type="order";
						$img="";
						
						echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
					}
					echo "end";
			}
			else
			{
				$row['error']="true";
				$row['message']="failed";
				array_push($jsonObj,$row);
			
			}
	 
		}
		else
		{
			$row['error']="true";
			$row['message']="User not found !";
			array_push($jsonObj,$row);
		
		}
	 
		$set['WALLET_PAY'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	 

	}
	
	else if(isset($_GET['wallpaper_id']))
	{
		  
				 
		$jsonObj= array();	

		$query="SELECT * FROM tbl_wallpaper WHERE id='".$_GET['wallpaper_id']."'  AND hotelid='$app_id' ";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			 
			$row['id'] = $data['id'];
			$row['cat_id'] = $data['cat_id'];
 			$row['wallpaper_image'] = $file_path.'categories/'.$data['cat_id'].'/'.$data['image'];
 			$row['wallpaper_image_thumb'] = $file_path.'categories/'.$data['cat_id'].'/thumbs/'.$data['image']; 
 			$row['total_views'] = $data['total_views'];
 

			array_push($jsonObj,$row);
		
		}

		$view_qry=mysqli_query($mysqli,"UPDATE tbl_wallpaper SET total_views = total_views + 1 WHERE id = '".$_GET['wallpaper_id']."'");
 

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
 

	}
	else if(isset($_GET['room_list']))
	{
		  
				 
		$jsonObj= array();	

		$query="SELECT * FROM tbl_rooms where hotelid='$app_id'  ORDER BY tbl_rooms.id";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			 
			$row['id'] = $data['id'];
			$row['room_name'] = $data['room_name'];
 			$row['room_image'] = $file_path.'images/'.$data['room_image'];
 			$row['room_image_thumb'] = $file_path.'images/thumbs/'.$data['room_image'];
 			$row['room_description'] = $data['room_description'];
 			$row['room_amenities'] = $data['room_amenities'];
 			$row['room_price'] = $data['room_price'];

			array_push($jsonObj,$row);
		
		}
 

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
 

	}
	else if(isset($_GET['room_id']))
	{
		  
				 
		$jsonObj= array();	

		$query="SELECT * FROM tbl_rooms WHERE id='".$_GET['room_id']."' AND hotelid='$app_id'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			 
			$row['id'] = $data['id'];
			$row['room_name'] = $data['room_name'];
 			$row['room_image'] = $file_path.'images/'.$data['room_image'];
 			$row['room_image_thumb'] = $file_path.'images/thumbs/'.$data['room_image'];
 			$row['room_description'] = $data['room_description'];
 			$row['room_amenities'] = $data['room_amenities'];
 			$row['room_price'] = $data['room_price'];

 			//Gallery Images
		      $qry1="SELECT * FROM tbl_room_gallery WHERE room_id='".$_GET['room_id']."'";
		      $result1=mysqli_query($mysqli,$qry1); 

		      if($result1->num_rows > 0)
		      {
		      		while ($row_img=mysqli_fetch_array($result1)) {
 		      	
		 		      	$row1['image_name'] = $file_path.'images/gallery/'.$row_img['image_name'];

		 		      	$row['galley_image'][]= $row1;
				      }
		     
		      }
		      else
		      {	
		      		 
		      		$row['galley_image'][]= '';
		      }

			array_push($jsonObj,$row);
		
		}
 

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
 

	}
	else if(isset($_GET['home_banner']))
 	{
 		$jsonObj= array();
		
		 
		$query="SELECT id,hotelid,banner_name,banner_image FROM tbl_home_banner where hotelid='$app_id' ORDER BY tbl_home_banner.id";
		$sql = mysqli_query($mysqli,$query)or die(mysql_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			 

			$row['id'] = $data['id'];
			$row['banner_name'] = $data['banner_name'];
			$row['banner_image'] = $file_path.'images/'.$data['banner_image'];
   
			array_push($jsonObj,$row);
		
		}

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
 	}
	else 
	{
		$jsonObj= array();	

		$query="SELECT * FROM tbl_settings WHERE hotelid='$app_id'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());

		while($data = mysqli_fetch_assoc($sql))
		{
			 
			$row['app_name'] = $data['app_name'];
			$row['app_logo'] = $data['app_logo'];
			$row['app_version'] = $data['app_version'];
			$row['app_author'] = $data['app_author'];
			$row['app_contact'] = $data['app_contact'];
			$row['app_email'] = $data['app_email'];
			$row['app_website'] = $data['app_website'];
			$row['app_description'] = stripslashes($data['app_description']);
			$row['app_developed_by'] = $data['app_developed_by'];
			$row['min_amount_rs'] = $data['min_amount_rs'];
			$row['min_amount_msg'] = $data['min_amount_msg'];

			$row['app_privacy_policy'] = stripslashes($data['app_privacy_policy']);

 

			array_push($jsonObj,$row);
		
		}

		$set['SINGLE_HOTEL_APP'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
	}		
	 
	 
?>