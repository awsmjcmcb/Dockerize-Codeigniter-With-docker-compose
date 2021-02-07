<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");
	 
	
	
	if(isset($_POST['submit']))
	{
	$img_res=mysqli_query($mysqli,"SELECT * FROM tbl_admin WHERE username='". $_POST['username']."'");
  	  $rows = mysqli_num_rows($img_res);
  	  if($rows>=1)
	{
			
			$_SESSION['msgg']="16"; 
		header( "Location:addhotel.php");
		exit;	
	}
	else
	{
		 $file_name= str_replace(" ","-",$_FILES['room_image']['name']);

	   $room_image=rand(0,99999)."_".$file_name;
		 	 
     //Main Image
	   $tpath1='images/'.$room_image; 			 
     $pic1=compress_image($_FILES["room_image"]["tmp_name"], $tpath1, 80);
	 
		 //Thumb Image 
	   $thumbpath='images/thumbs/'.$room_image;		
     $thumb_pic1=compress_image($_FILES["room_image"]["tmp_name"], $thumbpath, 50);   
 
					$data = array( 
							    'username'  =>  $_POST['username'],
							    'password'  =>  $_POST['password'],
							    'email'  =>  $_POST['email'],
							    'image'  =>  $room_image
							    );
					
					
					$channel_edit=Insert('tbl_admin', $data);
					
			$_SESSION['msg']="10"; 
		header( "Location:addhotel.php");
		exit;		
					

		 }
		
}
		
		 


?>
 
	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Hotel User</div>
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
          
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msgg'])){?> 
                 <div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <?php echo $client_lang[$_SESSION['msgg']] ; ?></a> </div>
                <?php unset($_SESSION['msgg']);}?> 
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom">
          	  
            <form action="" name="editprofile" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Profile Image :-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="room_image" id="fileupload">
                         
                        	
                        
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Username :-</label>
                    <div class="col-md-6">
                      <input type="text" name="username" id="username"  class="form-control" required autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Password :-</label>
                    <div class="col-md-6">
                      <input type="password" name="password" id="password"  class="form-control" required autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="text" name="email" id="email"  class="form-control" required autocomplete="off">
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
