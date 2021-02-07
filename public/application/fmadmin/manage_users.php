<?php 
	include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");
		 

		// Send SMS to all
		$category_ids = mysqli_fetch_row($getcontactqry)[0];
			echo $category_ids;

			$tokens = array();
			$getcontactqry="SELECT mobile FROM tbl_users";
			$resultmobs = mysqli_query($mysqli, $getcontactqry);
			
			foreach($resultmobs as $device){
				$tokens[] = $device['mobile'];
			}
			//echo count($tokens);
			$mobs= implode(',', $tokens);

		//Get all Category 
		  $tableName="tbl_users";   
		  $targetpage = "manage_users.php"; 
		  $limit = 10; 
		  
		  $query = "SELECT COUNT(*) as num FROM $tableName where removeAt=0";
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
		
		 $qry="SELECT * FROM tbl_users where removeAt=0 order by id DESC LIMIT $start, $limit";
	 
		 $result=mysqli_query($mysqli,$qry); 		
	
	if($_POST['search']!="")
	{		
		$search=$_POST['search'];
		$qry="SELECT * FROM tbl_users WHERE name like '%".$search."%' or  id like '%".$search."%' LIMIT $start, $limit";
		$result=mysqli_query($mysqli,$qry); 	
	}
	
	//delete
	if(isset($_GET['delete_id']))
	{
		$no="1";
		$data = array(
		  'removeAt'  =>  $no
		);	
		
		$category_edit=Update('tbl_users', $data, "WHERE id = '".$_GET['delete_id']."'");
		
		$_SESSION['msg']="12";
		header( "Location:manage_users.php");
		exit;	
	}	
	
	if(isset($_POST['pay_now']))
	{
		$qry="SELECT * FROM tbl_users where id='".$_POST['u_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
		
		$wallet=$row['wallet']+$_POST['wallet'];
		$coming_wallet =$_POST['wallet'];
		$data = array( 'wallet'  =>  $wallet );		
		$category_edit=Update('tbl_users', $data, "WHERE id = '".$_POST['u_id']."'");
		$userid =$_POST['u_id'];
		$_SESSION['msg']="11"; 
		
		//ADD CASHBACK
		date_default_timezone_set('Asia/Kolkata');
		$time = date('Y/m/d H:i:s');
		$add_cashback= "INSERT INTO tbl_cashback(u_id,cashback_amount,datetime) 
						VALUES('$userid','$coming_wallet','$time')";
		$resulltcash = mysqli_query($mysqli,$add_cashback);
		
		$users_sql = "SELECT * FROM tbl_user_token where mobileno='".$row['mobile']."'";     
		$users_result = mysqli_query($mysqli,$users_sql);
		$user_row = mysqli_fetch_assoc($users_result);
		
		if($coming_wallet>0)
		{
			$reward="You have been rewarded Rs.".$coming_wallet." from Cake Lovers Team. You can use it on your next order.";
		
		//SEND MESSAGE TO USER	
		sendMessage($userid,$reward);
		
		//send notification to user
		$title="Congratulations ".$row['name']."!";
   		$msg="You have been rewarded Rs ".$coming_wallet." is your wallet.";
   		$type="order";
		$img="";
		
		echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
		
		}
		
		header( "Location:manage_users.php");
		exit;
	}

	if(isset($_POST['send_sms_text']))
	{
		$usid=$_POST['u_id1'];
		$msg=$_POST['sms_text'];
		sendMessageSingle($usid,$msg);
	}
	
	if(isset($_POST['send_sms_text_to_all']))
	{
		$usid=$_POST['allmobile'];
		$msg=$_POST['sms_text_to_all'];
		sendMessageMultiple($usid,$msg);
	}

	if(isset($_GET['visibility_mode']))
	{
		$mobile = $_GET['mobile'];
		$visibility_mode = $_GET['visibility_mode'];
		
		$sql1 = "Update tbl_users SET receive_order_notification=".$visibility_mode." WHERE mobile=".$mobile;
		$mysqli->query($sql1);
		
		$sql2 = "Update tbl_user_token SET receive_order_notification=".$visibility_mode." WHERE mobileno=".$mobile;
		$mysqli->query($sql2);
	}
		
	
	

	 
?> 
         

    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Users</div>
            </div>
			  
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
			  
                <div class="search_block">
				  <form  method="post" action="">
					<input class="form-control input-sm" placeholder="Search..." type="search" name="search" value="<?php if($_POST['search']!=""){ echo $_POST['search']; }?>">
					<button type="submit" name="search_btn" class="btn-search"><i class="fa fa-search"></i></button>
				  </form>  
				</div>
				
                <div class="add_btn_primary"> 
                	<a data-toggle="modal" data-target="#SendSCRATCHToAll" onclick="SendSCRATCHToAll('<?php echo $row['id']; ?>','<?php echo $image; ?>','<?php echo $row['name'];?>','<?php echo $row['mobile'];?>')">Send  Scratch Coupon To All</a> 
				

					<a data-toggle="modal" data-target="#myModal33" onclick="SendSSmsToAll('<?php echo $row['id']; ?>','<?php echo $image; ?>','<?php echo $row['name'];?>','<?php echo $row['mobile'];?>')">Send SMS To All</a> 
				
					<a href="add_users.php?add=yes">Add Users</a>
				</div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
         
			  
                <?php if(isset($_SESSION['errormsg'])){?> 
               	 <div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	This Mobile Number is already exist ! </div>
                <?php unset($_SESSION['errormsg']);}?>
			
			  </div>
				
            </div>
          </div>
		  
						
          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>                  
                  <th>#</th>
                  <th style="width:17%;">User Name(Mobile)</th>
            
                  <th>Wallet Amount</th>
                  <th style="width:17%;">Receive Order Notification</th>
                  <th style="width:30%;" class="cat_action_list" >Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php	
					$count=mysqli_num_rows($result);
				
					if($count==0)
					{
				?>	
					<tr>                 
						<td style="text-align:center; padding:60px;" colspan="7">No Record Found !</td>
					</tr>
				<?php	
					}
					
					$i=0;
					while($row=mysqli_fetch_array($result))
					{	
									
						?>
						<tr>     

						  <td><?php echo $row['id'];?></td>
						  <td><?php echo $row['name'];?></br><b>(<?php echo $row['mobile'];?>)</b></td>
						  
						  <td>Rs. <b><?php echo $row['wallet'];?>.00</b></td>
						   <!--href="add_wallet_amount.php?u_id=<?php echo $row['id'];?>"-->
							<td>
							  <?php 
								if($row['receive_order_notification']=="1")
								{
								?>		
									<label class="switch1" title="Approved">	
										<input type="checkbox" checked onclick="disable(<?php echo $row['mobile'];?>,0);">
										<span class="slider round1"></span>
									</label>
								
									<script>
										
										function disable(mobile,visibility_mode) {
											$.ajax({
												url:"manage_users.php",
												type:'get',
												data:{mobile:mobile,visibility_mode:visibility_mode},
												success:function(){
													//alert('Visibility change successfully !');
													window.location.reload();
												}
											})
										}
									
									</script>
								<?php
								}
								else{ 
								?>		
									<label class="switch1" title="Rejected">	
										<input type="checkbox" onclick="enable(<?php echo $row['mobile'];?>,1);">
										<span class="slider round1"></span>
									</label>
									
									<script>
										
										function enable(mobile,visibility_mode) {
											$.ajax({
												url:"manage_users.php",
												type:'get',
												data:{mobile:mobile,visibility_mode:visibility_mode},
												success:function(){
													//alert('Visibility change successfully !');
													window.location.reload();
												}
											})
										}
									
									</script>
									
								<?php
								}									  
							  ?>
							  
							</td>
							
						  <td>

							<a data-toggle="modal" data-target="#myModal11" class="btn btn-default"  onclick="payToWallet('<?php echo $row['id']; ?>','<?php echo $image; ?>','<?php echo $row['name'];?>','<?php echo $row['mobile'];?>')" >Add Cashback</a>

							
							<a data-toggle="modal" data-target="#myModal22" class="btn btn-default" onclick="SendSSms('<?php echo $row['id']; ?>','<?php echo $image; ?>','<?php echo $row['name'];?>','<?php echo $row['mobile'];?>')" >Send SMS</a></br></br> 
							<a href="add_users.php?edit_id=<?php echo $row['id'];?>" class="btn btn-default" >Edit</a> 

							<a href="manage_scratch_coupon_show.php?users_id=<?php echo $row['id'];?>" class="btn btn-default" >send coupon</a> <br>

	
							<a href="?delete_id=<?php echo $row['id'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this ?');">Delete</a>

							
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




	function payToWallet(id,image,name,mobile){
		document.getElementById('name_mobile').innerHTML= name+"("+mobile+")";
		document.getElementById('u_id').value=id;
	}
	
	
	function SendSSms(id,image,name,mobile){
		document.getElementById('name_mobile_sms').innerHTML= name+"("+mobile+")";
		document.getElementById('u_id1').value= id;
		document.getElementById('mobileno').value= mobile;
	}

	
	
	function SendSSmsToAll(id,image,name,mobile){
		document.getElementById('name_mobile_sms_all').innerHTML= name+"("+mobile+")";
		document.getElementById('u_id2').value= id;
		document.getElementById('allmobile').value= $mobs;
	}
	
	
	</script>



 <!-- Add Cashback amount -->
  <!-- Modal -->
  <div class="modal fade" id="myModal11" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pay To Wallet</h4>
        </div>
		
        <div class="modal-body">
		
			<form action="" method="post" class="form form-horizontal" >
			  <div class="section">
				<div class="section-body">
			
				  <div class="form-group">
				
					<div class="col-md-11">
					  <p class="control-label" id="name_mobile">USERNAME (MOBILE)</p>
					</div>	
				  </div>
					<hr>
				  <div class="form-group">
					<div class="col-md-8">
					  <input type="hidden" name="u_id" id="u_id" class="form-control" required >
					  <input type="number" name="wallet" id="wallet" placeholder="Add Wallet Amount" value="<?php echo $row['wallet']; ?>" class="form-control" required >
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

  

<!-- Send SMS -->
   <div class="modal fade" id="myModal22" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send SMS</h4>
        </div>
		
        <div class="modal-body">
		
			<form action="" method="post" class="form form-horizontal" >
			  <div class="section">
				<div class="section-body">
			
				  <div class="form-group">
				
					<div class="col-md-11">
					  <p class="control-label" id="name_mobile_sms">USERNAME (MOBILE)</p>
					</div>	
				  </div>
					<hr>
				  <div class="form-group">
					<div class="col-md-8">
						 <input type="hidden" name="u_id1" id="u_id1" value="<?php echo $row['id']; ?>" class="form-control" required >
						  <input type="hidden" name="mobileno" id="mobileno" class="form-control" required >
					  <input type="text" name="sms_text" id="sms_text" placeholder="Type message" value="<?php echo $row['sms_text']; ?>" class="form-control" required >
					</div>
					<div class="col-md-2">
					  <button type="submit" name="send_sms_text" class="btn btn-primary">Send Now</button>
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

<!-- Send SMS To All -->
	<div class="modal fade" id="myModal33" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send SMS To All</h4>
        </div>
		
        <div class="modal-body">
		
			<form action="" method="post" class="form form-horizontal" >
			  <div class="section">
				<div class="section-body">
			
				  <div class="form-group">
				
					<div class="col-md-11">
					  <p class="control-label" id="name_mobile_sms_all">USERNAME (MOBILE)</p>
					</div>	
				  </div>
					<hr>
				  <div class="form-group">
					<div class="col-md-8">
						 <input type="hidden" name="u_id2" id="u_id2" class="form-control" 
							value="<?php echo $row['id'];?>" placeholder="id" required >
						 
						  <input type="hidden" name="allmobile" id="allmobile" class="form-control" required value="<?php echo $mobs;?>">
					  <input type="text" name="sms_text_to_all" id="sms_text_to_all" placeholder="Type message" value="<?php echo $row['sms_text_to_all']; ?>" class="form-control" required >
					</div>
					<div class="col-md-2">
					  <button type="submit" name="send_sms_text_to_all" class="btn btn-primary">Send Now</button>
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

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


<!-- Send SMS To All -->
	<div class="modal fade" id="SendSCRATCHToAll" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Scratch Coupon To All</h4>
      
         
        </div>
		
        <div class="modal-body">
		
			<form action="add_all_scratch_coupon.php" method="post" class="form form-horizontal" >
			  <div class="section">
				<div class="section-body">
			
				  <div class="form-group">
				
					<div class="col-md-11">

					 
					</div>	
				  </div>
					<hr>
				  <div class="form-group">
					<div class="col-md-8">
						<select class="form-control" name="id" id="id" onchange="showDetails(this.value)">

							  <option  value="" selected="selected">select</option>
			  	               <?php 

			                      $qry3="SELECT * FROM tbl_scratch_coupons where Visibility='1'";
			                       $result3=mysqli_query($mysqli,$qry3);
			                          while($row3=mysqli_fetch_array($result3))			  
			                        {
			                  ?>
			                   <option value="<?php echo $row3['id'];?>" ><?php echo $row3['title'];?></option>	
			  	            <?php }?>
			            </select>

					</div>
                    

					<div class="col-md-2">
					  <button type="submit" class="btn btn-primary">Send Now</button>
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
		


<?php include("includes/footer.php");?>  
<script>
 $(document).ready(function(){  
      $('#id').change(function(){  
           var id = $(this).val();  
           $.ajax({  
                url:"hi.php",  
                method:"POST",  
                data:{id:id},  
                success:function(data){  
                     $('#show_product').html(data);  
                }  
           });  
      });  
 });  
</script>