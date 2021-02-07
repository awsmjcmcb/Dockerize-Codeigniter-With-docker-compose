<script src="assets/js/jquery.min.js"></script>	

<script type='text/javascript' src="assets/js/neworder.js"></script>

    

<script>
function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td1 = tr[i].getElementsByTagName("td")[1];
     td2 = tr[i].getElementsByTagName("td")[4];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td1.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1 ) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}



function bill(billid)
{
	if (confirm("Are you sure want to print? "))
	{
		window.location='genratepdf.php?bill_id='+billid;
	}
	
}
</script>
	
<?php 

include("includes/header.php");
require("includes/function.php");
	require("language/language.php");
		
		
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
	


	 $tableName="tbl_reservation";   
      $targetpage = "reservation.php"; 
      $limit = 10; 
      
      $query = "SELECT COUNT(*) as num FROM $tableName where hotelid='".$_SESSION['id']."'";
      $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $total_pages = $total_pages['num'];
      
      $stages = 3;
      $page=0;
      if(isset($_GET['page'])){
      $page = mysqli_real_escape_string($mysqli,$_GET['page']);
      }
      if($page){
        $start = ($page - 1) * $limit; 
      }else{
        $start = 0; 
        } 
		
	//Get all Category 
	$qry="SELECT * FROM tbl_reservation where hotelid='".$_SESSION['id']."' ORDER BY ID DESC LIMIT $start, $limit";
	$result=mysqli_query($mysqli,$qry);
	
	$qrry="SELECT * FROM tbl_reservation where cancel_status='1' AND  hotelid='".$_SESSION['id']."'";
	$resullt=mysqli_query($mysqli,$qrry);
	$res1=mysqli_num_rows($resullt);
	
	$qr="SELECT * FROM tbl_reservation where status='2' AND  hotelid='".$_SESSION['id']."'";
	$resu=mysqli_query($mysqli,$qr);
	$res2=mysqli_num_rows($resu);
	
	$q="SELECT * FROM tbl_reservation where status='1' AND hotelid='".$_SESSION['id']."'";
	$r=mysqli_query($mysqli,$q);
	$res3=mysqli_num_rows($r);
	
	
	
	//Change status to pending  as  1
	if(isset($_GET['status_pending_id']))
	{
		$dtimesec = $_GET['timee'] ;
		//$dtimesec = str_replace(',', $_get['timee']);

		$data = array('status'  =>  '1','delivery_time' => $dtimesec);
		
		$edit_status=Update('tbl_reservation', $data, "WHERE ID = '".$_GET['status_pending_id']."'");
		
		$qry="SELECT * FROM tbl_reservation WHERE ID='".$_GET['status_pending_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
		
		$users_sql = "SELECT * FROM tbl_user_token where mobileid='".$row['mobileid']."'";     
		$users_result = mysqli_query($mysqli,$users_sql);
		$user_row = mysqli_fetch_assoc($users_result);
		
		
		//SEND MESSAGE TO USER	
		$user_id=$row['user_id'];
		$phone_msg= "Your order number ".$_GET['status_pending_id']." is in Progress. Expected delivery time is ".$_GET['timee']." Minutes";	
		//sendMessage($user_id,$phone_msg);	
		

		//send notification to user
		$title="Congratulations.";
   		$msg="Your order number ".$_GET['status_pending_id']." is in Progress.";
   		$type="order";
		$img="";
		echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
		 
		 $_SESSION['msg']="14";
		 header( "Location:reservation.php");
		 exit;
	}
	
	//ORDER Dispatched  as   3
	if(isset($_GET['status_dispatch_id']))
	{
		
		$data = array('status'  =>  '3');
		
		$edit_status=Update('tbl_reservation', $data, "WHERE ID = '".$_GET['status_dispatch_id']."'");
		
		$qry="SELECT * FROM tbl_reservation WHERE ID='".$_GET['status_dispatch_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
				
		$users_sql = "SELECT * FROM tbl_user_token where mobileid='".$row['mobileid']."'";     
		$users_result = mysqli_query($mysqli,$users_sql);
		$user_row = mysqli_fetch_assoc($users_result);
	
	
		//SEND MESSAGE TO USER	
		$user_id=$row['user_id'];
		$phone_msg= "Your order number ".$_GET['status_dispatch_id']." is Dispatched.";	
		//sendMessage($user_id,$phone_msg);	
		
		
		//send notification to user
		$title="Congratulations";
   		$msg="Your order number ".$_GET['status_dispatch_id']." is Dispatched";
   		$type="order";
		$img="";
		
		echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
	
		$_SESSION['msg']="14";
		header( "Location:reservation.php");
		exit;
		
	}
	
	//ORDER COMPLETED   2
	if(isset($_GET['status_active_id']))
	{
		//START ADD WALLET AMOUNT
 		$qry="SELECT * FROM tbl_users where id='".$_GET['u_id']."'";
 		$result=mysqli_query($mysqli,$qry);
  		$row=mysqli_fetch_assoc($result);
		$coming_wallet =$_GET['wallet'];
 		$wallet=$row['wallet']+$coming_wallet;
 		$data = array( 'wallet'  =>  $wallet );	
		$userid =$_GET['u_id'];
		$category_edit=Update('tbl_users', $data, "WHERE id = '".$userid."'"); 
		
		//ADD CASHBACK
		date_default_timezone_set('Asia/Kolkata');
		$time = date('Y/m/d H:i:s');
		$add_cashback= "INSERT INTO tbl_cashback(u_id,cashback_amount,datetime) 
						VALUES('$userid','$coming_wallet','$time')";
		$resulltcash = mysqli_query($mysqli,$add_cashback);
		
		//END ADD WALLET AMOUNT
				
		$data = array('status'  =>  '2');
		
		$edit_status=Update('tbl_reservation', $data, "WHERE ID = '".$_GET['status_active_id']."'");
		
		 $qry="SELECT * FROM tbl_reservation WHERE ID='".$_GET['status_active_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);				$order_id=$row['ID'];		$name=$row['name'];		$phone=$row['phone'];
		
		$users_sql = "SELECT * FROM tbl_user_token where mobileid='".$row['mobileid']."'";     
		$users_result = mysqli_query($mysqli,$users_sql);
		$user_row = mysqli_fetch_assoc($users_result);						
		
				
		//SEND MAIL TO CLIENT
		$email=getUserEmailPhoneNo($phone);
		$to = $email;
		$subject = 'Congratulations !';
		
		if($_GET['wallet']>0)
		{
		$reward="You have been rewarded Rs. ".$_GET['wallet']." on your previous order.";
		}
		else { $reward=""; } 
		
		$message = "Your Order is completed ! <br> ".$reward."".$order_list;
		
		$from = $company_email;
		$headers = "From: $company_name <$from>" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to,$subject,$message,$headers);
				
	
		//SEND MESSAGE TO USER	
		$user_id=$row['user_id'];
		$phone_msg= "Your order number ".$_GET['status_active_id']." is completed. ".$reward;	
		sendMessage($user_id,$phone_msg);	
		
		
		//send notification to user
		$title="Congratulations";
   		$msg="Your order number ".$_GET['status_active_id']." is completed. ".$reward;
   		$type="order";
		$img="";
		
		echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
		
		
		$_SESSION['msg']="13";
		 header( "Location:reservation.php");
		 exit;
	}
	if(isset($_GET['status_cancel']))
	{
		$data = array('cancel_status'  =>  '1','status' => 'c');
		
		$edit_status=Update('tbl_reservation', $data, "WHERE ID = '".$_GET['status_cancel']."'");
		
		 $qry="SELECT * FROM tbl_reservation WHERE ID='".$_GET['status_cancel']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
		
		$users_sql = "SELECT * FROM tbl_user_token where mobileid='".$row['mobileid']."'";     
		$users_result = mysqli_query($mysqli,$users_sql);
		$user_row = mysqli_fetch_assoc($users_result);
		
		//SEND MESSAGE TO USER		
		//sendMessage($phone,$phone_msg);	
		
		//send notification to user
		$title="Sorry";
   		$msg="Your order with ".APP_NAME." has been Cancelled.";
   		$type="order";
		$img="";
		echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
		
		$_SESSION['msg']="13";
		 header( "Location:reservation.php");
		 exit;
	}
	
	//echo sendMessage(9,"this is test msg");	
	
	if(isset($_GET['delete_id']))
	{
		Delete('tbl_reservation','id='.$_GET['delete_id'].'');
		$_SESSION['msg']="12";
		header( "Location:reservation.php");
		exit;
	}	
	
?>

	<style>
	.badge-notify{
	   background:red;
	   position:relative;
	   top: -20px;
	   left: -35px;
	}	 
	</style>
	
	<script>
function printpage()
{
	window.print();
}
</script>
  
  <style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
	
	@media print {
	  @page { margin: 0; }
	  body { margin: 1cm; }
	}

</style>


<style>

.add_btn_primary a {
    background-color: #095077;
    box-shadow: 0 2px 3px rgba(9, 80, 119, 0.3);
    border: 1px solid transparent;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    border-radius: 3px;
    border-style: 1px solid;
    margin-bottom: 5px;
    transition: all 0.3s ease 0s;
    padding: 10px 30px;
    color: #ffffff;
}


.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>
	

	<div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-12 col-xs-12">
              <div class="page_title">Reservation<br><br>
             <span class="badge badge-dark badge-icon"><i class="fa fa-cutlery" aria-hidden="true"></i><span>New Orders</span></span><span id="neworder" class="badge badge-notify"></span>
                <span class="badge badge-danger badge-icon"><i class="fa fa-eye" aria-hidden="true"></i><span>Orders in Progress</span></span><span class="badge badge-notify"><?php echo $res3; ?></span>
                 <span class="badge badge-success badge-icon"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Orders Completed</span></span><span class="badge badge-notify"><?php echo $res2; ?></span>
                 <span class="badge badge-danger badge-icon"><i class="fa fa-times-circle" aria-hidden="true"></i><span>Orders Cancelled</span></span><span class="badge badge-notify"><?php echo $res1; ?></span>
                <div class="search_list">
                    <div class="search_block">
                     
                        <input class="form-control input-sm" placeholder="Search..." id="myInput" onkeyup="myFunction()" aria-controls="DataTables_Table_0" type="search" name="room_name" required>
                        <button type="submit" name="rooms_search" class="btn-search"><i class="fa fa-search"></i></button>
                      
                    </div>
                   
                  </div>
             
              </div>
            </div>
           
            <!--<div class="col-md-6 col-xs-12">
              <div class="search_list">
                          
              </div>
            </div>!-->
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
          <div class="col-md-12 mrg-top table-responsive">
            <table class="table table-striped table-bordered table-hover" id="myTable">
              <thead>
                <tr>    
                 <th>Order No</th>              
                  <th>Name & Contact</th>
                  <th>Order & Comment</th>
                  <th>Order Type</th>
                  <th>Status</th>
                  <th class="cat_action_list" >Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php	
				$i=0;
				while($row=mysqli_fetch_array($result))
				{			
					?>
					<tr>    
					<td><?php echo $row['ID'];?></td>             
					
					<td><b>#<?php echo $row['user_id'];?></b><br><?php echo $row['name'];?><br><?php echo $row['phone'];?><br><?php echo $row['email'];?></td>
				
					<!--  <td><?php echo $row['address'];?><br><b><?php echo $row['sub_city_name'].",".$row['city_name'];?></b></td> 
					 
					<td><?php echo $row['date_time']; ?></td> -->
					
					 
					  
					  
					  
					  <td><?php echo $row['order_list'];?> <br><b><?php if($row['comment']!=""){  echo "[ Comments: ".$row['comment']."]"; } else { echo ""; }?></b><br>
					

					  <?php //echo $row['order_list'];?>  <a href="order-receipt.php?order_id=<?php echo $row['ID'];?>" class="btn btn-default" target="_blank">View</a>
					  <a href="order-receipt.php?print=true&order_id=<?php echo $row['ID'];?> <?php if(isset($_row['ID'])){ ?> onclick="printpage()" <?php }?>" class="btn btn-primary" target="_blank">Print</a></td>
						
						<td><?php echo $row['order_type'];?> <br><b>(<?php if($row['cat_type']=="advance"){ echo $row['cat_type']." : ".$row['advance_date']." ".$row['advance_time']; } else { echo $row['cat_type']; }  ?>)</b></td>
					  
						<td>	
						<?php 
							//STATUS NEW ORDER    0
							if($row['status']=="0" && $row['cancel_status']=="0"){?>
							
							
							 <a  data-toggle="modal" data-target="#myModalDelivery"  onclick="addDeliveryTime('<?php echo $row['ID']; ?>')" href=""  title="Change Status"><span   class="badge badge-info badge-icon"><i class="fa fa-eye" aria-hidden="true"></i><span>New Order</span></span></a><br><br>
							 
							<a href="reservation.php?status_cancel=<?php echo $row['ID'];?>" title="Cancel Order?"><span class="badge badge-danger badge-icon"><i class="fa fa-close" aria-hidden="true"></i><span>Cancel</span></span></a>
						   <?php }
						   
						   
						   //STATUS ORDER CANCEL 
						   elseif ($row['cancel_status']=="1") {?>
							<a  title="Change Status"><span class="badge badge-danger badge-icon"><i class="fa fa-times-circle" aria-hidden="true"></i><span>Cancelled</span></span></a>
						  <?php }
						  
						  //STATUS INPROGRESS     1
						  elseif ($row['status']=="1") {?>
						  
						  <a href="reservation.php?status_dispatch_id=<?php echo $row['ID'];?>" title="Change Status"><span   class="badge badge-danger badge-icon"><i class="fa fa-eye" aria-hidden="true"></i><span>Progress</span></span></a><br><br>
						 
						  <?php }
						  
						  //STATUS DISPATCH     3
						  elseif ($row['status']=="3") {?>
						  
						  <a  data-toggle="modal" data-target="#myModal"  onclick="payToWallet('<?php echo $row['ID']; ?>','<?php echo  $row['user_id']; ?>','<?php echo $row['name'];?>','<?php echo $row['phone'];?>')" href=""  title="Change Status"><span   class="badge badge-info badge-icon"><i class="fa fa-eye" aria-hidden="true"></i><span>Dispatched</span></span></a><br><br>
						  
						  <!--a href="reservation.php?status_active_id=<?php echo $row['ID'];?>" title="Change Status"><span   class="badge badge-info badge-icon"><i class="fa fa-eye" aria-hidden="true"></i><span>Dispatched</span></span></a><br><br-->
						   <!--a href="javascript:bill(<?php  echo $row["ID"]?>)" title="Change Status"><span   class="badge badge-primary badge-icon"><i class="fa fa-print" aria-hidden="true"></i><span>Print</span></span></a-->
						  <?php }
						  
						  //STATUS COMPLETES    2
						  elseif ($row['status']=="2") { ?>
						  <a href="reservation.php?status_completed=<?php echo $row['ID'];?>" title="Change Status"><span onclick='return false;'  class="badge badge-success badge-icon"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Completed</span></span></a>
						  <?php } ?>
						</td>
						
						
						<td>
							<a href="edit_reservation.php?edit_id=<?php echo $row['ID'];?>" class="btn btn-primary">Edit</a>
							<a href="?delete_id=<?php echo $row['ID'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this ?');">Delete</a>
						</td>
					 
					</tr>
					<?php	
					$i++;
				}
				?> 
              </tbody>
            </table>
          </div>
            <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php include("pagination.php");?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>

	<script>
	function payToWallet(order_id,u_id,name,mobile)
	{
		document.getElementById('name_mobile').innerHTML=name+" ("+mobile+")";
		document.getElementById('status_active_id').value=order_id;
		document.getElementById('u_id').value=u_id;
	}
	
	function addDeliveryTime(order_id)
	{
		document.getElementById('status_pending_id').value=order_id;
		
	}
	</script>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
		  
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Pay To Wallet</h4>
			</div>
			
			<div class="modal-body">
			
				<form action="" method="get" class="form form-horizontal" >
				  <div class="section">
					<div class="section-body">
				
					  <div class="form-group">
						<div class="col-md-1">
							<div class="fileupload_img">
								<img  style="border-radius: 50%; width:40px; height:40px;" id="payUser" src="images/users/default.jpg" alt="user" />
							</div>
						</div>					
						<div class="col-md-11">
						  <p class="control-label" id="name_mobile">USERNAME (MOBILE)</p>
						</div>	
					  </div>
						<hr>
					  <div class="form-group">
						<div class="col-md-8">
						  <input type="hidden" name="status_active_id" id="status_active_id" class="form-control" required >
						  <input type="hidden" name="u_id" id="u_id" class="form-control" required >
						  <input type="number" name="wallet" id="wallet" placeholder="Add Wallet Amount" value="0" class="form-control" required >
						</div>
						<div class="col-md-2">
						  <button type="submit" name="pay_now" class="btn btn-primary">Pay Now</button>
						</div>
					  </div>
						
					</div>
				  </div>
				</form>
			
			</div>
			
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			
		  </div>
		  
		</div>
	</div>
	
	<!-- Delivery Time -->
	
	
	<div class="modal fade" id="myModalDelivery" role="dialog" >

		<div class="modal-dialog" style="left:auto;">
		<link href="clock/sample/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
						<link href="clock/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
						
		  <!-- Modal content-->
		  <div class="modal-content">
		  
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Add Delivery Time</h4>
			</div>
			
			<div class="modal-body">
			
				<form action="" method="get" class="form form-horizontal" >
				  <div class="section">
					<div class="section-body">
				
					
						<hr>
						<div class="container">

					  <div class="form-group">
						  <input type="hidden" name="status_pending_id" id="status_pending_id" class="form-control" required >
						  <input type="hidden" name="order_id" id="order_id" class="form-control" required >
						  <div class="input-group date form_datetime col-md-5" data-date="" data-date-format="dd-mm-yyyy, hh:ii:ss" data-link-field="timee1">
							<input class="form-control" size="16" type="text"  id="timee" name ="timee" value=""    required  data-readonly style="pointer-events: none;">
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
							</div><br/>
						<div class="col-md-2">
						  <button type="submit" name="time_now" class="btn btn-primary">Accept Order</button>
						</div>
					  </div>
					  </div>
						
					</div>
				  </div>
				</form>
			
			</div>
			
			
			
		  </div>
		  	</div>
			
	</div>
	
  <script type="text/javascript" src="clock/sample/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="clock/sample/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="clock/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="clock/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        //showMeridian: 1
    });
	
</script>

<?php include("includes/footer.php");?>       