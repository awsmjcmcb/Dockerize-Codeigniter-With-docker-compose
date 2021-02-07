<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

	
	//Add scratch coupon
	if(isset($_POST['submit']) and isset($_GET['add']))
	{	
		$image="";
		if($_FILES['image']['name']!="")
		{			
			$image="coupon-".rand(0,99999)."_".$_FILES['image']['name'];
			$tpath1='images/coupon/'.$image; 			 
			move_uploaded_file($_FILES["image"]["tmp_name"], $tpath1);
		}			
		
		           $data = array( 
		           
					'title'  =>  $_POST['title'],
					'image'  =>  $image,
					'message'  =>  $_POST['message'],
					'amount'  =>  $_POST['amount'],
					'type'  =>  $_POST['type'],
					'coupon_text'  => $_POST['coupon_text'],
							
					);		

				 		$qry = Insert('tbl_scratch_coupons',$data);	

				 		$_SESSION['msg']="10";
				 
						header( "Location:manage_scratch_coupon.php");
						exit;	

	}

	if(isset($_GET['id']))
	{
		$qry="SELECT * FROM tbl_scratch_coupons where id='".$_GET['id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
	
	}
	
		
		
	if(isset($_POST['submit']) and isset($_POST['id']))
	{
		 
		 if($_FILES['image']['name']!="")
		 {		


				$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_scratch_coupons WHERE id='.$_GET['id'].'');
			    $img_res_row=mysqli_fetch_assoc($img_res);
			

			    if($img_res_row['image']!="")
		        {
					unlink('images/thumbs/'.$img_res_row['image']);
					unlink('images/'.$img_res_row['image']);
			     }


				$image=rand(0,99999)."_".$_FILES['image']['name'];				
				$tpath1='images/coupon/'.$image; 			 
				move_uploaded_file($_FILES["image"]["tmp_name"], $tpath1);
	

                   $data = array( 
					'title'  =>  $_POST['title'],
					'image'  =>  $image,
					'message'  =>  $_POST['message'],
					'amount'  =>  $_POST['amount'],
					'type'  =>  $_POST['type'],
					'coupon_text'  => $_POST['coupon_text']
					);		


					$category_edit=Update('tbl_scratch_coupons', $data, "WHERE id = '".$_POST['id']."'");

		 }
		 else
		 {

						$data = array( 
						'title'  =>  $_POST['title'],
						'message'  =>  $_POST['message'],
						'amount'  =>  $_POST['amount'],
						'type'  =>  $_POST['type'],
				    	'coupon_text'  => $_POST['coupon_text']
						);		

			         $category_edit=Update('tbl_scratch_coupons', $data, "WHERE id = '".$_POST['id']."'");

		 }

		$_SESSION['msg']="11"; 
		header( "Location:manage_scratch_coupon.php");
		exit;	
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

       
           function minmaxkgFunc()
						{
							var cat_type=document.getElementById('cat_type').value;
							//alert(cat_type);
							if(cat_type=="image")
							{
								//alert("show");
								document.getElementById('textname1').style.display="block";
							}
							else{
                             document.getElementById('textname1').style.display="none";

							}
												
							
						}
				function minmaxkgFunc1()
						{
							var cat_type=document.getElementById('cat_type').value;
							//alert(cat_type);
							if(cat_type=="text")
							{
								//alert("show");
								document.getElementById('textname2').style.display="block";
							}
							else{
                             document.getElementById('textname2').style.display="none";

							}
												
							
						}		

</script>



	<body>
	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Scratch Coupon Settings</div>
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


						  <div class="form-group">
						         <label class="col-md-3 control-label">Select Type:-</label>
						    <div class="col-md-6">

	                         <select name="type" class="select2"  id="cat_type"  onchange="minmaxkgFunc(),minmaxkgFunc1()">
                                      <option> select</option>
                                      <option value="image" <?php if($row['type']=="image"){?>selected<?php }?> >Image</option>
                                       <option value="text" <?php if($row['type']=="text"){?>selected<?php }?>>Text</option>      
                            </select>
   
							 </div>
						 </div><br>
						
					  
					  <div class="form-group" id="textname1" style="<?php if($row['type']=="image"){ ?>display:block;<?php }else{ ?>display:none;<?php } ?>">
						<label class="col-md-3 control-label">Coupon Image :-<p class="control-label-help">(Image Size : 500x500)</p>
						 </label>
						 
						<div class="col-md-6">
						  <div class="fileupload_block">
							<input type="file" name="image" value="fileupload" id="fileupload">
							<?php if(isset($_GET['id']) and $row['image']!="") {?>
                        	  <div class="fileupload_img"><img type="image" src="images/coupon/<?php echo $row['image'];?>" alt="coupon image" /></div>
                        	<?php } else {?>
                        	  <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                        	<?php }?>				
							
						  </div>
						</div>
					  </div>
					  <div class="form-group" id="textname2" style="<?php if($row['type']=="text"){ ?>display:block;<?php }else{ ?>display:none;<?php } ?>">
							<label class="col-md-3 control-label"> Coupon text:-</label>
							<div class="col-md-6">
							  <input type="text" name="coupon_text" id="coupon_text"  value="<?php if(isset($_GET['id'])){echo $row['coupon_text'];}?>" class="form-control">
							</div>
						</div>
                                
						<div class="form-group">
							<label class="col-md-3 control-label"> Title:-</label>
							<div class="col-md-6">
							  <input type="text" name="title" id="title"  value="<?php if(isset($_GET['id'])){echo $row['title'];}?>" class="form-control" required>
							</div>
						</div>
					  
					  
					  <div class="form-group">
						<label class="col-md-3 control-label">Message-</label>
						<div class="col-md-6">
						  <input type="text" name="message"  value="<?php if(isset($_GET['id'])){echo $row['message'];}?>"id="message" class="form-control">
						</div>
					  </div>
					
					  <div class="form-group">
						<label class="col-md-3 control-label">Amount:-</label>
						<div class="col-md-6">
						  <input type="text" name="amount"  value="<?php if(isset($_GET['id'])){echo $row['amount'];}?>" id="amount" class="form-control" required>
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
