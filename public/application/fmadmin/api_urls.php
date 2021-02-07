<?php include("includes/header.php");

$file_path = 'https://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
?>
<div class="row">
      <div class="col-sm-12 col-xs-12">
     	 	<div class="card">
		        <div class="card-header">
		          Example API urls
		        </div>
       			    <div class="card-body no-padding">
						<pre><code class="html"><b>User Login API (GET)</b><br><?php echo $file_path."login.php?mobile=9999999999"?>						
								<br><br><b>Register FCM API (POST : user_id,token,mobileid)</b><br><?php echo $file_path."registerFCM.php"?>
								
								<br><br><b>User Profile Registration API (POST : name,mobile)</b><br><?php echo $file_path."register.php"?>
								<br><br><b>User Profile Update API (POST : user_id,name,email,gender=Male/Female,image,dob,doa,latitude,longitude,address,location,zipcode)</b><br><?php echo $file_path."update_profile.php"?>
								<br><br><b>User Profile View API (GET : user_id)</b><br><?php echo $file_path."view_profile.php?user_id=1"?>
								
								<br><br><b>Verify Mobile Number (Exist or Not) (GET)</b><br><?php echo $file_path."forgot_password.php?verify_mobile_no=9999999999"?>
								<br><br><b>Change Password (GET)</b><br><?php echo $file_path."forgot_password.php?mobile_no=9999999999&password=123"?> 
								
								<br><br><b>City List Api</b><br><?php echo $file_path."api.php?city_list"?>
								
								<br><br><b>Sub City List By City Id Api</b><br><?php echo $file_path."api.php?sub_city_list_by_city_id=3"?>
								
								<br><br><b>Menu Category List Api</b><br><?php echo $file_path."menu_cat_list.php"?>
								
								<br><br><b>Fast Food List Api</b><br><?php echo $file_path."api.php?fast_food_list"?>
								
								
								
								
								
								
								<br><br><b>Place Order</b><br><?php echo $file_path."place_order.php"?>
								
								<br><br><b>Cancel Order</b><br><?php echo $file_path."api.php?cancel_order_id=1"?>
						
								<br><br><b>Wallet Pay</b><br><?php echo $file_path."api.php?wallet_pay&user_id=1&amount=10"?>
								
								<br><br>
								<br><br><b>Home</b><br><?php echo $file_path."api.php?home"?>
								<br><br><b>Hotel Info</b><br><?php echo $file_path."api.php?hotel_info"?>
								<br><br><b>Room List</b><br><?php echo $file_path."api.php?room_list"?>
								<br><br><b>Single Room</b><br><?php echo $file_path."api.php?room_id=1"?>
								<br><br><b>Gallery Category List</b><br><?php echo $file_path."api.php?cat_list"?>
								<br><br><b>Gallery list by Cat ID</b><br><?php echo $file_path."api.php?cat_id=1"?>
								<br><br><b>Single Gallery</b><br><?php echo $file_path."api.php?wallpaper_id=3"?>
								<br><br><b>Contact API</b><br><?php echo $file_path."api_contact.php?name=kudlip&email=john@gmail.com&phone=1234567891&subject=test msg&message=this is test msg"?>
								<br><br><b>App Details</b><br><?php echo $file_path."api.php"?>										
							</code>					
						</pre>
       		
       				</div>
          	</div>
        </div>
</div>
    <br/>
    <div class="clearfix"></div>
        
<?php include("includes/footer.php");?>       
