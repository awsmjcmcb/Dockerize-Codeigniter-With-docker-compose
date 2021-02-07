<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

	 
	
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
	
	   $banner_image=rand(0,99999)."_".$_FILES['banner_image']['name'];
	
       //Main Image
	   $tpath1='images/'.$banner_image; 			 
       $pic1=compress_image($_FILES["banner_image"]["tmp_name"], $tpath1, 80);
	 
	   //Thumb Image 
	   $thumbpath='images/thumbs/'.$banner_image;		
       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');   
  
		$data = array( 
			'hotelid' => $_SESSION['id'],
			'banner_name'  =>  $_POST['banner_name'],
			'banner_image'  =>  $banner_image
		);		

 		$qry = Insert('tbl_home_banner',$data);	

		$_SESSION['msg']="10"; 
		header( "Location:manage_amit_mishra_event.php");
		exit;	
		
	}
	
	if(isset($_GET['banner_id']))
	{
	
			$qry="SELECT * FROM tbl_home_banner where id='".$_GET['banner_id']."'";
			$result=mysqli_query($mysqli,$qry);
			$row=mysqli_fetch_assoc($result);

	}
	if(isset($_POST['submit']) and isset($_POST['banner_id']))
	{
		 
		 if($_FILES['banner_image']['name']!="")
		 {	
	 
			$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_home_banner WHERE id='.$_GET['banner_id'].'');
			$img_res_row=mysqli_fetch_assoc($img_res);
		
			if($img_res_row['banner_image']!="")
			{
				unlink('images/thumbs/'.$img_res_row['banner_image']);
				unlink('images/'.$img_res_row['banner_image']);
			}

			$banner_image=rand(0,99999)."_".$_FILES['banner_image']['name'];
		 
			//Main Image
			$tpath1='images/'.$banner_image; 			 
			$pic1=compress_image($_FILES["banner_image"]["tmp_name"], $tpath1, 80);
			 
			//Thumb Image 
			$thumbpath='images/thumbs/'.$banner_image;		
			$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');

			$data = array(
				'banner_name'  =>  $_POST['banner_name'],
				'banner_image'  =>  $banner_image
				);

			$category_edit=Update('tbl_home_banner', $data, "WHERE id = '".$_POST['banner_id']."'");

		 }
		 else
		 {
			$data = array(
				'banner_name'  =>  $_POST['banner_name']
			);	

			$category_edit=Update('tbl_home_banner', $data, "WHERE id = '".$_POST['banner_id']."'");
		 }

		     
		$_SESSION['msg']="11"; 
		header( "Location:add_banner.php?banner_id=".$_POST['banner_id']);
		exit;
 
	}


?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-7 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['banner_id'])){?>Edit<?php }else{?>Add<?php }?> Book Your Seats</div>
			      
            </div>
			
			 <div class="col-md-5 col-xs-12">              
				<div class="col-md-4 page_title smallBox greenBox">Selected</div>
				
				<div class="col-md-4 page_title smallBox redBox">Reserved</div>
				
				<div class="col-md-4 page_title smallBox emptyBox">Empty</div> 
				
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


		
		
		
		
	
			
	<link rel="stylesheet" href="booking_file/css/style.css">

	<body onload="onLoaderFunc()">
			
		<div class="form-group">
			
			<div class="col-md-4">
				<label class="control-label">Full Name :-</label>
				<input type="text" id="Username" class="form-control" placeholder="Enter full name" required>
			</div>
			
			<div class="col-md-4">
				<label class="control-label">Mobile Number :-</label>
				<input type="text" id="mobile" class="form-control" placeholder="Mobile Number" required>
			</div>
			
			<div class="col-md-4">
				<label class="control-label">No of Seats :-</label>
				<input type="number" id="Numseats" class="form-control" placeholder="No of Seats" required>
			</div>
			
			<div class="col-md-12">
				<center>
					<button onclick="takeData()" class="btn btn-primary" >Start Selecting</button>
				</center><br>
			</div>
			
		</div>  	
		
		<div class="seatStructure">	
			<center>
				<div class="col-md-12 mrg-top table-responsive">
						  
					<div class="col-md-12 col-sm-12" id="notification" style="display:none;">
						<div class="alert alert-warning alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><!--span aria-hidden="true">×</span--></button>
							Please Select your Seats NOW!
						</div>	
					</div>
			
					<table class="table table-striped" border="0" id="seatsBlock" style="display:none;">
							
							<tr><td colspan="38"><div class="screen">ROUND TABLE</div></td></tr>
							
							<?php
								
								for($i=0;$i<3;$i++)
								{			
									$start=$i*10;
									
									echo "<tr>";
									$limit=10;		
									$qry="SELECT * FROM tbl_seats where seat_type='round_table' order by id ASC limit $start, $limit";
									$result=mysqli_query($mysqli,$qry); 	
									while($row=mysqli_fetch_array($result))
									{	
										if($row['status']==1)
										{
											?>	
											<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
											<?php
										}
										elseif($row['status']==0)
										{
											?>	
											<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
											<?php
										}
										
										?>
											<style>
											#<?php echo $row['seat_no']; ?>:before {
												content: "<?php echo $row['seat_no']; ?>";
											}
											</style>
										<?php
									}	
									echo "</tr>";
								}
								
							?>	
							
							<tr><td colspan="38"><div class="screen">VVIP SOFA</div></td></tr>
							
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%A%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%B%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%C%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%D%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%E%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
							<tr><td colspan="38"><div class="screen">VIP SOFA</div></td></tr>
							
						  
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%F%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%G%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%H%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%I%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%J%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%K%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%L%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats reserved_seat" value="<?php echo $row['seat_no']; ?>" disabled></td>
										<?php
									}
									elseif($row['status']==0)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats empty" value="<?php echo $row['seat_no']; ?>"></td>
										<?php
									}
									
									?>
										<style>
										#<?php echo $row['seat_no']; ?>:before {
											content: "<?php echo $row['seat_no']; ?>";
										}
										</style>
									<?php
								}	
								echo "</tr>";						
							?>
							
					</table>
					
				</div>	
		<br/><br/>	
		<br/><br/>		
				<button style="margin-top: 30px; display:none;" id="submitBTN" onclick="addTextArea()" class="btn btn-primary">Confirm Selection</button>
			</center>	
		</div>	 	
	
		<br/><br/>	

		<!--div class="displayerBoxes table-responsive">
			<center>
			  <table class="Displaytable" style="width:100%">
			  <tr>
				<th>Name</th>
				<th>total</th>
				<th>Seats</th>
				<th>Mobile</th>
			  </tr>
			  <tr>
				<td><input id="nameDisplay" /></td>
				<td><input id="NumberDisplay" /></td>
				<td><input id="seatsDisplay" /></td>
				<td><input id="mobileDisplay" /></td>
			  </tr>
			</table>
			</center>
		</div-->
		
		<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
		<script  src="booking_file/js/index.js"></script>


			
			
          </div>
        </div>
      </div>
    </div>
     








<?php include("includes/footer.php");?>       
