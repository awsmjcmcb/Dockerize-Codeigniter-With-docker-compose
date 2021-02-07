<?php 
	include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");
	
	//edit details
	if(isset($_GET['edit_id']))
	{			 
			$qry="SELECT * FROM tbl_reservation where id='".$_GET['edit_id']."'";
			$result=mysqli_query($mysqli,$qry);
			$row=mysqli_fetch_assoc($result);

	}
	if(isset($_POST['submit']) and isset($_POST['edit_id']))
	{
		   $data = array(
					    'name'  =>  $_POST['name'],
					    'phone'  =>  $_POST['phone'],
						'email' => $_POST['email'],
						'sub_city_name' => $_POST['sub_city_name'],
						'city_name' => $_POST['city_name'],
						'address' => $_POST['address'],
						'comment' => $_POST['comment'],
						'cat_type' => $_POST['order_type_cat'],
						'order_type' => $_POST['order_type_name']
						);

					$category_edit=Update('tbl_reservation', $data, "WHERE id = '".$_POST['edit_id']."'");
		     
		$_SESSION['msg']="11"; 
		//header( "Location:add_banner.php?edit_id=".$_POST['edit_id']);
		header( "Location:reservation.php");
		exit;
 
	}


?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['edit_id'])){?>Edit <?php } ?> Food Order </div>
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
            <form action="" name="editcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
            	<input  type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>" />

              <div class="section">
                <div class="section-body">
				
                  <div class="form-group">
                    <label class="col-md-3 control-label">Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="name" id="name" value="<?php if(isset($_GET['edit_id'])){echo $row['name'];}?>" class="form-control" required>
                    </div>
                  </div>                   
                  
				  <div class="form-group">
                    <label class="col-md-3 control-label">Contact :-</label>
                    <div class="col-md-6">
                      <input type="text" name="phone" id="phone" value="<?php if(isset($_GET['edit_id'])){echo $row['phone'];}?>" class="form-control">
                    </div>
                  </div>

					<div class="form-group">
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="text" name="email" id="email" value="<?php if(isset($_GET['edit_id'])){echo $row['email'];}?>" class="form-control">
                    </div>
                  </div>

					<div class="form-group">
                    <label class="col-md-3 control-label">Sub City Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="sub_city_name" id="sub_city_name" value="<?php if(isset($_GET['edit_id'])){echo $row['sub_city_name'];}?>" class="form-control" >
                    </div>
                  </div> 
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">City Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="city_name" id="city_name" value="<?php if(isset($_GET['edit_id'])){echo $row['city_name'];}?>" class="form-control">
                    </div>
                  </div> 
					
				 <div class="form-group">
                    <label class="col-md-3 control-label">Address :-</label>
                    <div class="col-md-6">
                      <input type="text" name="address" id="address" value="<?php if(isset($_GET['edit_id'])){echo $row['address'];}?>" class="form-control" >
                    </div>
                  </div> 

				  <div class="form-group">
                    <label class="col-md-3 control-label">Comment :-</label>
                    <div class="col-md-6">
                      <input type="text" name="comment" id="comment" value="<?php if(isset($_GET['edit_id'])){echo $row['comment'];}?>" class="form-control" >
                    </div>
                  </div>   

					<div class="form-group">
                    <label class="col-md-3 control-label">Order type :-</label>
                    <div class="col-md-6">
                      <select name="order_type_cat" id="order_type_cat" class="select2">
							<option value="">--Select Order Category Type--</option>
							<?php
								//get cat type
								$cat_type=$row['cat_type'];
								
								$cat_qry="SELECT name FROM tbl_category_type ORDER BY id ASC" ;
								$cat_result=mysqli_query($mysqli,$cat_qry); 
								while($cat_row=mysqli_fetch_array($cat_result))
								{
							?>          						 
								<option value="<?php if(isset($_GET['edit_id'])){echo $cat_row['name'];}?>" <?php if($cat_row['name']==$cat_type){?>selected<?php }?>><?php echo $cat_row['name'];?></option>
								
																<?php
							}
							?>
						  </select>
					</div>
                  </div>   
                  
				  <div class="form-group">
                    <label class="col-md-3 control-label">Order type :-</label>
                    <div class="col-md-6">
                      <select name="order_type_name" id="order_type_name" class="select2">
					  <?php 
							//get cat type
								$cat_type=$row['order_type'];
					  ?>
							<option value="">--Select Order Type--</option>
							<option value="Take Away">Take Away</option>
							<option value="Home Delivery">Home Delivery</option>
							<option value="<?php if(isset($_GET['edit_id'])){echo $row['order_type'];}?>" <?php if($row['order_type']==$cat_type){?>selected<?php }?>><?php echo $row['order_type'];?></option>
						  </select>
					</div>
                  </div> 
				  
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
