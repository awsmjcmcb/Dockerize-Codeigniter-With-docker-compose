<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

	
	//Add scratch coupon
	if(isset($_POST['submit']) and isset($_GET['add']))
	{	
		
		           $data = array( 
					'title'  =>  $_POST['title'],
					'tandc'  =>  $_POST['tandc'],
					'min_order'  =>  $_POST['min_order'],
					'exp_date'  =>  $_POST['exp_date'],
					'no_uses'  =>  $_POST['no_uses'],
					'coupon_code'  =>  $_POST['coupon_code'],
					'coupon_type'  =>  $_POST['coupon_type'],
					'coupon_value'  =>  $_POST['coupon_value']
					);		

	            	$qry = Insert('tbl_coupon_code',$data);	

				 		$_SESSION['msg']="10";
				 
						header( "Location:manage_coupon_code.php");
						exit;	

	}




	if(isset($_GET['id']))
	{
		$qry="SELECT * FROM tbl_coupon_code where id='".$_GET['id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
	
	}
	
		
		
	if(isset($_POST['submit']) and isset($_POST['id']))
	{
		 
	
			 

		           $data = array( 
					'title'  =>  $_POST['title'],
					'tandc'  =>  $_POST['tandc'],
					'min_order'  =>  $_POST['min_order'],
					'exp_date'  =>  $_POST['exp_date'],
					'no_uses'  =>  $_POST['no_uses'],
					'coupon_code'  =>  $_POST['coupon_code'],
					'coupon_type'  =>  $_POST['coupon_type'],
					'coupon_value'  =>  $_POST['coupon_value']
					);	
			         $edit=Update('tbl_coupon_code', $data, "WHERE id = '".$_POST['id']."'");

							$_SESSION['msg']="11"; 
							header( "Location:manage_coupon_code.php");
							exit;	
					}

?>

	<body>
	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Coupon Code</div>
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
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom">
          
				<form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
					<input  type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
				  <div class="section">
					<div class="section-body">
			

						<div class="form-group">
							<label class="col-md-3 control-label"> Title:-</label>
							<div class="col-md-6">
							  <input type="text" name="title" id="title"  value="<?php if(isset($_GET['id'])){echo $row['title'];}?>" class="form-control" required>
							</div>
						</div>
					  <div class="form-group">
						<label class="col-md-3 control-label">Terms & condition-</label>
						<div class="col-md-6">
						  <input type="text" name="tandc"  value="<?php if(isset($_GET['id'])){echo $row['tandc'];}?>"id="tandc" class="form-control">
						</div>
					  </div>
					
					  <div class="form-group">
						<label class="col-md-3 control-label">Minimum Order:-</label>
						<div class="col-md-6">
						  <input type="text" name="min_order"  value="<?php if(isset($_GET['id'])){echo $row['min_order'];}?>" id="min_order" class="form-control" required>
						</div>
					  </div>
					    <div class="form-group">
						<label class="col-md-3 control-label">Expiry Date:-</label>
						<div class="col-md-6">
						  <input type="date" name="exp_date"  value="<?php if(isset($_GET['id'])){echo $row['exp_date'];}?>" id="exp_date " class="form-control" required>
						</div>
					  </div>
					   <div class="form-group">
						<label class="col-md-3 control-label">NO of Uses Coupon:-</label>
						<div class="col-md-6">


			              <select class="select2"  name="no_uses">
			              	<option value="">Select NO of Uses Coupon:</option>
			  	               <?php 

			                      $qry3="SELECT * FROM tbl_uses_coupon ";
			                       $result3=mysqli_query($mysqli,$qry3);
			                          while($row3=mysqli_fetch_array($result3))			  
			                        {
			                  ?>

			                   <option   <?php if($row3['no_of_uses_coupon']==$row['no_uses']){ echo "selected"; } ?> ><?php echo $row3['no_of_uses_coupon'];?></option>	
			  	            <?php }?>
			            </select>
							</div>
						 </div><br>
					    <div class="form-group">
						<label class="col-md-3 control-label">Coupon Code:-</label>
						<div class="col-md-6">
						  <input type="text" name="coupon_code"  value="<?php if(isset($_GET['id'])){echo $row['coupon_code'];}?>" id="coupon_code" class="form-control" required>
						</div>
					  </div>
                        
                     <div class="form-group">
						<label class="col-md-3 control-label">Coupon Value:-</label>
						<div class="col-md-6">
						  <input type="text" name="coupon_value"  value="<?php if(isset($_GET['id'])){echo $row['coupon_value'];}?>" id="coupon_value" class="form-control" required>
						</div>
					  </div>
					  
					   <div class="form-group">
						<label class="col-md-3 control-label">Coupon Type:-</label>
						<div class="col-md-6">


			              <select class="select2"  name="coupon_type">
			              		<option value="">Select Coupon type:</option>
			  	               <?php 

			                      $qry4="SELECT * FROM tbl_coupon_type ";
			                       $result4=mysqli_query($mysqli,$qry4);
			                      $i=0;
			                          while($row4=mysqli_fetch_array($result4))
			  
			                        {
			                  ?>
			                    	<option   <?php if($row4['type']==$row['coupon_type']){ echo "selected"; } ?> ><?php echo $row4['type'];?></option>
			  	            <?php }?>
			            </select>

							</div>
						 </div><br>


					  
					  
					  <div class="form-group">
						<div class="col-md-9 col-md-offset-3">
						  <button type="submit" name="submit" class="btn btn-primary">Save</button>
						</div>
					  </div>
					
					</div>
				  </div>
				</form>
			
          </div>
        </div>
      </div>
    </div>





        
<?php include("includes/footer.php");?>       
