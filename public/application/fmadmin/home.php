// <?php include("includes/header.php");

$qry_cat="SELECT COUNT(*) as num FROM tbl_menucategory where hotelid='".$_SESSION['id']."'";
$total_cat= mysqli_fetch_array(mysqli_query($mysqli,$qry_cat));
$total_categories = $total_cat['num'];

$qry_menu="SELECT COUNT(*) as num FROM tbl_menuwallpaper where hotelid='".$_SESSION['id']."'";
$total_menu = mysqli_fetch_array(mysqli_query($mysqli,$qry_menu));
$total_menu = $total_menu['num'];

$qry_banner="SELECT COUNT(*) as num FROM tbl_home_banner where hotelid='".$_SESSION['id']."'";
$total_banner = mysqli_fetch_array(mysqli_query($mysqli,$qry_banner));
$total_banner = $total_banner['num'];

$qry_users="SELECT COUNT(*) as num FROM tbl_users";
$total_users = mysqli_fetch_array(mysqli_query($mysqli,$qry_users));
$total_users = $total_users['num'];

$qry_feedback="SELECT COUNT(*) as num FROM tbl_contact";
$total_feedback = mysqli_fetch_array(mysqli_query($mysqli,$qry_feedback));
$total_feedback = $total_feedback['num'];


$qry_seat="SELECT COUNT(*) as num FROM tbl_booking";$total_seat = mysqli_fetch_array(mysqli_query($mysqli,$qry_seat));$total_seat = $total_seat['num'];$qry_order="SELECT COUNT(*) as num FROM tbl_reservation";$total_order = mysqli_fetch_array(mysqli_query($mysqli,$qry_order));$total_orders = $total_order['num'];

	//Total Erning Details
	$qry_erning="SELECT * FROM tbl_reservation";
	$result_erning=mysqli_query($mysqli,$qry_erning);
	//$order_row=mysqli_fetch_array($result);
	
	while($order_row=mysqli_fetch_array($result_erning))
	{
	//convert json data to array
	$json_data=$order_row['json_order_list'];
	$orderDetails = json_decode($json_data, true);
	
	$total_amount += $orderDetails['amount']['total_price'];
	echo "\n";
	}
	// Total Cheshback Details
	$qry="SELECT * FROM tbl_cashback";
 	$result=mysqli_query($mysqli,$qry);
	while($row=mysqli_fetch_array($result))
	{
		$wallet+=$row['cashback_amount'];
	}
?>       


         
    <div class="row">        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_home_banner.php" class="card card-banner card-blue-light">        <div class="card-body"> <i class="icon fa fa-buysellads fa-4x"></i>          <div class="content">            <div class="title">Total Banner</div>            <div class="value"><span class="sign"></span><?php echo $total_banner;?></div>          </div>        </div>        </a> </div>
		
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_menucategory.php" class="card card-banner card-green-light">
        <div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
          <div class="content">
            <div class="title">Total Menu Categories</div>
            <div class="value"><span class="sign"></span><?php echo $total_categories;?></div>
          </div>
        </div>
        </a> 
        </div>
		
		
		 <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_users.php" class="card card-banner card-yellow-light">
        <div class="card-body"> <i class="icon fa fa-cutlery fa-4x"></i>
          <div class="content">
            <div class="title">Total Users</div>
            <div class="value"><span class="sign"></span><?php echo $total_users;?></div>
          </div>
        </div>
        </a> 
        </div>
        
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_users.php" class="card card-banner card-blue-light">
        <div class="card-body"> <i class="icon fa fa-cutlery fa-4x"></i>
          <div class="content">
            <div class="title">Feedbacks</div>
            <div class="value"><span class="sign"></span><?php echo $total_feedback;?></div>
          </div>
        </div>
        </a> 
        </div>
        
		
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_menugallery.php" class="card card-banner card-green-light">
        <div class="card-body"> <i class="icon fa fa-cutlery fa-4x"></i>
          <div class="content">
            <div class="title">Total Menu Lists</div>
            <div class="value"><span class="sign"></span><?php echo $total_menu;?></div>
          </div>
        </div>
        </a> 
        </div>
      	        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="reservation.php" class="card card-banner card-yellow-light">        <div class="card-body"> <i class="icon fa fa-list fa-4x"></i>          <div class="content">            <div class="title">Total Orders</div>            <div class="value"><span class="sign"></span><?php echo $total_orders;?></div>          </div>        </div>        </a>         </div>  
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="" class="card card-banner card-blue-light">       
			<div class="card-body"> <i class="icon fa fa-inr fa-4x"></i>         
				<div class="content">            
					<div class="title">Total Earning</div>            
					<div class="value"><span class="sign"></span><?php echo $total_amount;?></div>         
				</div>      			
			</div>        
		  </a>         
		</div>     
			
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_total_cashback.php" class="card card-banner card-green-light">       
			<div class="card-body"> <i class="icon fa fa-list fa-4x"></i>         
				<div class="content">            
					<div class="title">Total Cashback</div>            
					<div class="value"><span class="sign"></span><?php echo $wallet;?></div>         
				</div>      				
			</div>        
		  </a>         
		</div>      
     
    </div>

        
<?php include("includes/footer.php");?>       
