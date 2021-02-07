<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

	 
	
	//Add Users
	
	if(isset($_POST['submit']) and isset($_GET['add']))
	{	

		//CHECK DUPLICATION
		$qry1="SELECT * FROM tbl_users";
		$result1=mysqli_query($mysqli,$qry1);	
		
		while($row1=mysqli_fetch_array($result1))
		{
			if($row1['mobile']==$_POST['mobile'])
			{
				$_SESSION['errormsg']="10"; 
				header( "Location:manage_users.php");
				exit;
			}
			
		}		
		
		$image="";
		if($_FILES['image']['name']!="")
		{			
			$image="Users-".rand(0,99999)."_".$_FILES['image']['name'];
			$tpath1='images/users/'.$image; 			 
			move_uploaded_file($_FILES["image"]["tmp_name"], $tpath1);
		}			
			
        $data = array( 
			'name'  =>  $_POST['name'],
			'image'  =>  $image,
			'email'  =>  $_POST['email'],
			'mobile'  =>  $_POST['mobile'],
			'password'  =>  $_POST['password'],
			'gender'  =>  $_POST['gender']
			);		

 		$qry = Insert('tbl_users',$data);	

		
 	   // $cat_id=mysqli_insert_id($mysqli);			

		$_SESSION['msg']="10";
 
		header( "Location:manage_users.php");
		exit;	

		 
		
	}
	
	if(isset($_GET['edit_id']))
	{
			 
			$qry="SELECT * FROM tbl_users where id='".$_GET['edit_id']."'";
			$result=mysqli_query($mysqli,$qry);
			$row=mysqli_fetch_assoc($result);

	}
	
	
	if(isset($_POST['submit']) and isset($_GET['edit_id']))
	{
		
		
		//CHECK DUPLICATION
		$qry1="SELECT * FROM tbl_users where mobile!=".$_POST['oldmobile']."";
		$result1=mysqli_query($mysqli,$qry1);	
		
		while($row1=mysqli_fetch_array($result1))
		{
			if($row1['mobile']==$_POST['mobile'])
			{
				$_SESSION['errormsg']="10"; 
				header( "Location:manage_users.php");
				exit;
			}
			
		}		
		
		 
		 if($_FILES['image']['name']!="")
		 {		


				$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_users WHERE id='.$_GET['edit_id'].'');
			    $img_res_row=mysqli_fetch_assoc($img_res);
			

			    if($img_res_row['image']!="")
		        {
					unlink('images/users/'.$img_res_row['image']);
			    }
				
					$image="Users-".rand(0,99999)."_".$_FILES['image']['name'];
					$tpath1='images/users/'.$image; 			 
					move_uploaded_file($_FILES["image"]["tmp_name"], $tpath1);
			
                      $data = array( 
						'name'  =>  $_POST['name'],
						'image'  =>  $image,
						'email'  =>  $_POST['email'],
						'mobile'  =>  $_POST['mobile'],
						'password'  =>  $_POST['password'],
						'gender'  =>  $_POST['gender']
						);		
	
				
					$category_edit=Update('tbl_users', $data, "WHERE id = '".$_POST['edit_id']."'");

		 }
		 else
		 {

	 
			 $data = array( 
				'name'  =>  $_POST['name'],
				'email'  =>  $_POST['email'],
				'mobile'  =>  $_POST['mobile'],
				'password'  =>  $_POST['password'],
				'gender'  =>  $_POST['gender']
				);		


			 $category_edit=Update('tbl_users', $data, "WHERE id = '".$_POST['edit_id']."'");

		 }

		
		
		$_SESSION['msg']="11"; 
		header( "Location:manage_users.php");
		exit;
 
	}


  
?>


	<body  onload="checkCount(),checkCountNotif(),checkCountsave()">
	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">User Settings</div>
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
				  <div class="section">
					<div class="section-body">
					
					<input  type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>" />

						<div class="form-group">
							<label class="col-md-3 control-label">User Name :-</label>
							<div class="col-md-6">
							  <input type="text" name="name" id="name" value="<?php if(isset($_GET['edit_id'])){echo $row['name'];}?>" class="form-control" required>
							</div>
						</div>
					  
					  <div class="form-group">
						<label class="col-md-3 control-label">User Image :-<p class="control-label-help">(Image Size : 500x500)</p>
						 </label>
						 
						<div class="col-md-6">
						  <div class="fileupload_block">
							<input type="file" name="image" value="fileupload" id="fileupload">
							<?php if(isset($_GET['edit_id']) and $row['image']!="") {?>
								  <div class="fileupload_img"><img src="images/users/<?php echo $row['image'];?>" alt="category image" /></div>
								<?php } else {?>
								  <div class="fileupload_img"><img src="assets/images/add-image.png" alt="category image" /></div>
								<?php }?>						
							
						  </div>
						</div>
					  </div>
					  
					  <div class="form-group">
						<label class="col-md-3 control-label">Email Address :-</label>
						<div class="col-md-6">
						  <input type="email" name="email" id="email" value="<?php if(isset($_GET['edit_id'])){echo $row['email'];}?>" class="form-control">
						</div>
					  </div>
					  
					   <input type="hidden" name="oldmobile" id="oldmobile" value="<?php if(isset($_GET['edit_id'])){echo $row['mobile'];}?>" class="form-control">
					   
					  <div class="form-group">
						<label class="col-md-3 control-label">Mobile No :-</label>
						<div class="col-md-6">
						  <input type="text" name="mobile" id="mobile" value="<?php if(isset($_GET['edit_id'])){echo $row['mobile'];}?>" class="form-control" required>
						</div>
					  </div>
					  
					  <!--div class="form-group">
						<label class="col-md-3 control-label">Password :-</label> 
						<div class="col-md-6">
						  <input type="text" name="password" id="password" value="<?php if(isset($_GET['edit_id'])){echo $row['password'];}?>" class="form-control" required>
						</div>
					  </div-->
					  
					  <div class="form-group">
						<label class="col-md-3 control-label">Gender :-</label>
						<div class="col-md-6">
						   <select name="gender" id="gender" class="select2">
								<option value="">--Select Gender--</option>
																			 
								<option value="Male" <?php if(isset($_GET['edit_id']) && $row['gender']=="Male"){?>selected<?php }?> >Male</option>	          							 
								<option value="Female" <?php if(isset($_GET['edit_id']) && $row['gender']=="Female"){?>selected<?php }?> >Female</option>
								
						  </select>
						</div>
					  </div>    
					  
				  
					  
					  <div class="form-group">
						<label class="col-md-3 control-label">Latitude :-</label>
						<div class="col-md-6">
						  <input type="text" value="<?php if(isset($_GET['edit_id'])){echo $row['latitude'];}?>" class="form-control" <?php if(!isset($_GET['add'])){echo "readonly";}?> >
						</div>
					  </div>				  
					  
					  <div class="form-group">
						<label class="col-md-3 control-label">Longitude :-</label>
						<div class="col-md-6">
						  <input type="text" value="<?php if(isset($_GET['edit_id'])){echo $row['longitude'];}?>" class="form-control"  <?php if(!isset($_GET['add'])){echo "readonly";}?>>
						</div>
					  </div>				  
					  
					  <div class="form-group">
						<label class="col-md-3 control-label">Address :-</label>
						<div class="col-md-6">
						  <input type="text" value="<?php if(isset($_GET['edit_id'])){echo $row['address'];}?>" class="form-control"  <?php if(!isset($_GET['add'])){echo "readonly";}?>>
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
