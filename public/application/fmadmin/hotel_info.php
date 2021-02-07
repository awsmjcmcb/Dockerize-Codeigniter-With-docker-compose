<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");
	 
	
	 
			 
		$qry="select * from tbl_hotel where hotelid='".$_SESSION['id']."'";
		 
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
 
	if(isset($_POST['submit']))
	{       
		       $img_res=mysqli_query($mysqli,"SELECT * FROM tbl_hotel WHERE hotelid='".$_SESSION['id']."'");
  			  $rows = mysqli_num_rows($img_res);
			if($rows>=1)
	{  

					$data = array( 
							    'hotel_name'  =>  addslashes($_POST['hotel_name']),
                  'hotel_info'  =>  addslashes($_POST['hotel_info']),
                  'hotel_address'  =>  addslashes($_POST['hotel_address']),
                  'hotel_lat'  =>  addslashes($_POST['hotel_lat']),
                  'hotel_long'  =>  addslashes($_POST['hotel_long']),
                  'hotel_amenities'  =>  addslashes($_POST['hotel_amenities'])
  							    );
					
					$channel_edit=Update('tbl_hotel', $data, "WHERE hotelid ='".$_SESSION['id']."'"); 
		 

		$_SESSION['msg']="11"; 
		header( "Location:hotel_info.php");
		exit;
		 
	}
	else
	{
	$data = array( 
	'hotelid' =>  $_SESSION['id'],
							    'hotel_name'  =>  addslashes($_POST['hotel_name']),
                  'hotel_info'  =>  addslashes($_POST['hotel_info']),
                  'hotel_address'  =>  addslashes($_POST['hotel_address']),
                  'hotel_lat'  =>  addslashes($_POST['hotel_lat']),
                  'hotel_long'  =>  addslashes($_POST['hotel_long']),
                  'hotel_amenities'  =>  addslashes($_POST['hotel_amenities'])
  							    );
					
					$channel_edit=Insert('tbl_hotel', $data); 
		 

		$_SESSION['msg']="11"; 
		header( "Location:hotel_info.php");
		exit;
	
	}
	}


?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

 
	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Hotel Info</div>
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
          	  
            <form action="" name="editprofile" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                   
                  <div class="form-group">
                    <label class="col-md-3 control-label">Hotel Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="hotel_name" id="hotel_name" value="<?php echo stripslashes($row['hotel_name']);?>" class="form-control" required autocomplete="off">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Hotel Address :-</label>
                    <div class="col-md-6">
                      <input type="text" name="hotel_address" id="hotel_address" value="<?php echo stripslashes($row['hotel_address']);?>" class="form-control" required autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Hotel Latitude :-</label>
                    <div class="col-md-6">
                      <input type="text" name="hotel_lat" id="hotel_lat" value="<?php echo stripslashes($row['hotel_lat']);?>" class="form-control" required autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Hotel Longitude :-</label>
                    <div class="col-md-6">
                      <input type="text" name="hotel_long" id="hotel_long" value="<?php echo stripslashes($row['hotel_long']);?>" class="form-control" required autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp;</label>
                    <div class="col-md-6">
                      Get Latitude and Longitude <a href="http://www.latlong.net" target="_blank">Here!</a>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="col-md-3 control-label">Hotel Description :-</label>
                    <div class="col-md-6">                    
                      <textarea name="hotel_info" id="hotel_info" class="form-control"><?php echo stripslashes($row['hotel_info']);?></textarea>

                      <script>CKEDITOR.replace( 'hotel_info' );</script>
                    </div>
                  </div><br>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Hotel Amenities :-</label>
                    <div class="col-md-6">
                      
                      <textarea name="hotel_amenities" id="hotel_amenities" class="form-control" placeholder="Air conditioning,Gym,Internet"><?php echo stripslashes($row['hotel_amenities']);?></textarea>
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
