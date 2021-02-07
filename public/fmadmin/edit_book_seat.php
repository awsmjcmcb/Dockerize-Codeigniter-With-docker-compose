<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

	$edit_id=$_GET['edit_id'];
	if(isset($_GET['edit_id']))
	{

		$qry="SELECT * FROM tbl_booking where id='".$_GET['edit_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$data_row=mysqli_fetch_assoc($result);

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

	<body onload="onLoaderFunc(), takeData(), check_checkbox()">
			
		<div class="form-group">
			<input type="hidden" id="user_id" class="form-control" value="<?php echo $data_row['id']; ?>">
			<div class="col-md-4">
				<label class="control-label">Full Name :-</label>
				<input type="text" id="Username" class="form-control" value="<?php echo $data_row['name']; ?>" placeholder="Enter full name" required>
			</div>
			
			<div class="col-md-4">
				<label class="control-label">Mobile Number :-</label>
				<input type="text" id="mobile" class="form-control" value="<?php echo $data_row['mobile']; ?>" placeholder="Mobile Number" required>
			</div>
			
			<div class="col-md-4">
				<label class="control-label">No of Seats :-</label>
				<input type="number" id="Numseats" class="form-control" value="<?php echo $data_row['no_of_seat']; ?>"  placeholder="No of Seats" required>
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
							
							<tr><td colspan="37"><div class="screen">ROUND TABLE</div></td></tr>
							
							<?php
								
							//get selected seat
							$seats_list=$data_row['seats'];
														
								for($i=0;$i<3;$i++)
								{			
									$start=$i*10;
									
									echo "<tr>";
									$limit=10;		
									$qry="SELECT * FROM tbl_seats where seat_type='round_table' order by id ASC limit $start, $limit";
									$result=mysqli_query($mysqli,$qry); 	
									while($row=mysqli_fetch_array($result))
									{	
										$seat=$row['seat_no'];
										if($row['status']==1)
										{
											?>	
											<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
												
							
							
							<tr><td colspan="37"><div class="screen">VVIP SOFA</div></td></tr>
							
						  
							<?php	
								echo "<tr>";						
								$qry="SELECT * FROM tbl_seats where seat_type='seat' and seat_no like '%A%' order by id ASC";
								$result=mysqli_query($mysqli,$qry); 	
								while($row=mysqli_fetch_array($result))
								{	
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
									$seat=$row['seat_no'];
									if($row['status']==1)
									{
										?>	
										<td><input type="checkbox" id="<?php echo $row['seat_no']; ?>" class="seats <?php if(strpos( $seats_list, $seat ) !== false){ echo "selected_seat";} else { echo "reserved_seat"; } ?>" value="<?php echo $row['seat_no']; ?>" <?php if(strpos( $seats_list, $seat ) !== false){ echo "checked";} else { echo "disabled"; } ?>></td>
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
				<button style="margin-top: 30px; display:none;" id="submitBTN" onclick="editTextArea()" class="btn btn-primary">Confirm Selection</button>
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
		<script  src="booking_file/js/edit_index.js"></script>


			
			
          </div>
        </div>
      </div>
    </div>
     








<?php include("includes/footer.php");?>       
