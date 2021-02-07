<?php 
	
	include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");
	require_once("thumbnail_images.class.php");

	//Add Users
	if(isset($_POST['submit']) and isset($_GET['add']))
	{	
		date_default_timezone_set('Asia/Kolkata');
		$time = date('Y/m/d H:i:s');
        $data = array( 
			'u_id'  =>  $_SESSION['id'],
			'cashback_amount'  =>  $_POST['cashback_amount'],
			'datetime' => $time
			);		

 		$qry = Insert('tbl_cashback',$data);	

		$_SESSION['msg']="10"; 
		header( "Location:manage_total_cashback.php");
		exit;	
	}

	//edit
	if(isset($_GET['edit_id']))
	{			 
		$qry="SELECT * FROM tbl_cashback where id='".$_GET['edit_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
	}
	
	if(isset($_POST['submit']) and isset($_GET['edit_id']))
	{	
	  date_default_timezone_set('Asia/Kolkata');
	  $time = date('Y/m/d H:i:s');
	  $data = array( 
		'u_id'  =>  $_SESSION['id'],
		'cashback_amount'  =>  $_POST['cashback_amount'],
		'datetime' => $time
		);		
		
		$category_edit=Update('tbl_cashback', $data, "WHERE id = '".$_POST['edit_id']."'");
		
		$_SESSION['msg']="11"; 
		header( "Location:manage_total_cashback.php");
		exit; 
	}
?>

	<body>
	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['edit_id'])){?>Edit<?php }else{?>Add<?php }?> Cashback</div>
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

				<form action="" name="" method="post" class="form form-horizontal" enctype="multipart/form-data">
				  <div class="section">
					<div class="section-body">
					
					<input type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>" />

						<div class="form-group">
							<label class="col-md-3 control-label">Cashback Amount :-</label>
							<div class="col-md-6">
							  <input type="text" name="cashback_amount" id="cashback_amount" value="<?php if(isset($_GET['edit_id'])){echo $row['cashback_amount'];}?>" class="form-control" required>
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