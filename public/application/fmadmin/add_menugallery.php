<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	
	if(isset($_POST['submit']))
	{
		$albumimgnm="";
		if($_FILES['wallpaper_image']['name']!="")
		{		
			$albumimgnm=rand(0,99999)."_".$_FILES['wallpaper_image']['name'];				
			$tpath1='categories/'.$_POST['cat_id'].'/'.$albumimgnm; 			 
			move_uploaded_file($_FILES["wallpaper_image"]["tmp_name"], $tpath1);
		}
		 
		$date=date('Y-m-j');
		
		//$time = $_GET['opening_time'];
		//$time1 = $_GET['closing_time'];

			$data = array( 
			'food_type'  =>  $_POST['food_type'],
			'hotelid' =>$_SESSION['id'],
			'cat_id'  =>  $_POST['cat_id'],
			'cat_food_type'  =>  $_POST['cat_food_type'],
			'food_opening_time' => $_POST['opening_time'],
			'food_closing_time' => $_POST['closing_time'],
			'name'  =>  $_POST['name'],
			'des'  =>  $_POST['hotel_info'],
			'image_date'  =>  $date,
			'image'  =>  $albumimgnm,
			'price'  =>  $_POST['price'],
			'min_kg'  =>  $_POST['min_kg'],
			'max_kg'  =>  $_POST['max_kg'],
			'f_id' => implode(',',$_POST['flavour'])
		);	
		$qry = Insert('tbl_menuwallpaper',$data);	

		$_SESSION['msg']="10";
 
		header( "Location:manage_menugallery.php");
		exit;	

	}
	
	if(isset($_GET['visibility_mode']))
	{
		
		$qry="SELECT * FROM tbl_category c, tbl_category_position_order p where c.cid=p.category_id and p.app_id=".$_POST['AppId']." order by p.position_order ASC";
		$result=mysqli_query($mysqli,$qry);
		?>

		<option value="">--Select Category Name--</option>

		<?php

		while($get_row=mysqli_fetch_assoc($result))
		{ 
			?>   
			<option value="<?php echo $get_row['cid'];?>" <?php if($_POST['selectedCatId']!="" && $_POST['selectedCatId']==$get_row['cid']){echo "selected";} ?>><?php echo $get_row['category_name'];?></option>
			<?php
		}	
	
	}
					
?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Menu</div>
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
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
 
              <div class="section">
                <div class="section-body">
				
				   <div class="form-group">
                    <label class="col-md-3 control-label">Menu Category Type :-</label>
                    <div class="col-md-6">
                      <select name="cat_type" id="cat_type" class="select2" required onchange="minmaxkgFunc(), ajaxGetCategoryList(),flavourFunc()">
                        <option value="">--Select Menu Category Type--</option>
						<?php
						$cat_qry="SELECT * FROM tbl_category_type ORDER BY id ASC" ;
						$cat_result=mysqli_query($mysqli,$cat_qry); 
						while($cat_row=mysqli_fetch_array($cat_result))
						{
							?>          						 
							<option value="<?php echo $cat_row['name'];?>"><?php echo $cat_row['name'];?></option>
							<?php
						}
						?>
                      </select>
                    </div>
                  </div>
				  
				    <script type="text/javascript">
						function ajaxGetCategoryList(){
							var cat_type=document.getElementById('cat_type').value;
							//alert(cat_type);
							$.ajax({
								url:"getCategoryList.php",
								type:'get',
								data:{cat_type:cat_type},
								success:function(data){
									//alert('your change successfully saved');
									$('#cat_id').html(data);
								}
							})						
						}		

						function minmaxkgFunc()
						{
							var cat_type=document.getElementById('cat_type').value;
							//alert(cat_type);
							if(cat_type=="advance")
							{
								//alert("show");
								document.getElementById('min_max_kg').style.display="block";
							}
							else{	
								//alert("hide");						
								document.getElementById('min_max_kg').style.display="none";
							}						
							
						}
						
						function flavourFunc()
						{
							var cat_type=document.getElementById('cat_type').value;
							//alert(cat_type);
							if(cat_type=="advance")
							{
								//alert("show");
								document.getElementById('flavour').style.display="block";
							}
							else{	
								//alert("hide");						
								document.getElementById('flavour').style.display="none";
							}						
						}
				    </script>
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Category Name :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" required onchange="catFoodType()">
                        <option value="">--Select Category--</option>
						<?php
						/* $cat_qry="SELECT * FROM tbl_menucategory WHERE hotelid='".$_SESSION['id']."' ORDER BY category_name" ;
						$cat_result=mysqli_query($mysqli,$cat_qry); 
						
						while($cat_row=mysqli_fetch_array($cat_result))
						{
							?>          						 
							<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>	          							 
							<?php
						} */
						?>
                      </select>
                    </div>
                  </div>
                  <script type="text/javascript">
						function catFoodType(){
							var cat_id=document.getElementById('cat_id').value;
							
							if(cat_id=="72")  // 72=Fast Food
							{
								document.getElementById('cat_food').style.display="block";
							}
							else{								
								document.getElementById('cat_food').style.display="none";
							}
							
						}	
				    </script>
				  
				  <div class="form-group" id="cat_food" style="display:none;">
                    <label class="col-md-3 control-label">Cat Food Type :-</label>
                    <div class="col-md-6">
                      <select name="cat_food_type" id="cat_food_type" class="select2" >	
                        <option value="">--Select Cat Food Type Type--</option>				 
						<option value="Regular" <?php if($row['cat_food_type']=="Regular"){ echo "selected"; }?>>Regular</option>
						<option value="Jain" <?php if($row['cat_food_type']=="Jain"){ echo "selected"; }?>>Jain</option>	
                      </select>
                    </div>
                  </div>
					<link href="clock/sample/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
					<link href="clock/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
				  <div class="form-group">
                    <!--label class="col-md-3 control-label">Food Time :-</label>
                    <div class="col-md-3">
                      <input type="time" name="opeing_time" id="opeing_time" class="form-control" value="<?php if(isset($_GET['cat_id'])){echo $row['food_opeing_time'];}?>">
					</div>
					<div class="col-md-3">
                      <input type="time" name="closing_time" id="closing_time" value="<?php  if(isset($_GET['cat_id'])){echo $row['food_closing_time'];}?>" class="form-control">
                    </div-->
					
					<div class="form-group">
						<label class="col-md-3 control-label">Available From :-</label>
						<div class="col-md-6">
							<div class="input-group date form_time"  data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
								<input class="form-control" size="10" type="text"  name="opening_time" id="opening_time"  value="" readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>

					</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label">Available Till :-</label>
						<div class="col-md-6">
							<div class="input-group date form_time"  data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
								<input name="closing_time" class="form-control" size="10" type="text" value="" readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>

					</div>
						
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="name" id="name" value="<?php if(isset($_GET['cat_id'])){echo $row['category_name'];}?>" class="form-control" required>
                    </div>
                  </div>
				  
				  <!-- flavour-->
				  	 <div class="form-group" id="flavour" style="display:none;margin-left:2px;">
					<div class="form-group">
						 
                    <label class="col-md-3 control-label">Flavour :-</label>
					<?php
						$qry1="SELECT * FROM tbl_flavour order by f_id asc";
						$result1=mysqli_query($mysqli,$qry1);
						while($row1=mysqli_fetch_array($result1))
						{	
					?>
						
                    <!--div class="col-md-3"-->
					<ul style="list-style-type:none ;"><li style="margin-left:300px;">
                      <input type="checkbox"  name="flavour[]"  value="<?php echo $row1['f_id'];?>" >
                    <?php echo $row1['flavour_name'];?></ul></li>
					<!--/div-->
					<?php
						}
						?>
                  </div>
				</div>
					<!-- flavour end-->
		
                  <div class="form-group">
                    <label class="col-md-3 control-label">Description :-</label>
                    <div class="col-md-6">                    
                      <textarea name="hotel_info" id="hotel_info" class="form-control"><?php echo stripslashes($row['hotel_info']);?></textarea>

                      <script>CKEDITOR.replace( 'hotel_info' );</script>
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Image :-
                    <p class="control-label-help">(Recommended resolution: 600x600)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="wallpaper_image" value="" id="fileupload" required>
                       <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Price :-</label>
                    <div class="col-md-6">
                      <input type="number" name="price" id="price" value="<?php if(isset($_GET['cat_id'])){echo $row['price'];}?>" class="form-control" required>
                    </div>
                  </div>
				  
                  <div class="form-group" id="min_max_kg" style="display:none;">
                    <label class="col-md-3 control-label">Min & Max KG :-</label>
                    <div class="col-md-3">
                      <input type="number" name="min_kg" placeholder="Minimum KG" id="min_kg" value="<?php if(isset($_GET['cat_id'])){echo $row['min_kg'];}?>" class="form-control" >
                    </div>
                    <div class="col-md-3">
                      <input type="number" name="max_kg" placeholder="Maximum KG"  id="max_kg" value="<?php if(isset($_GET['cat_id'])){echo $row['max_kg'];}?>" class="form-control" >
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Food Type :-</label>
                    <div class="col-md-6">
                      <input type="radio" id="enable" name="food_type" value="1" checked /> <label for="enable"> Veg</label>  
                      <input type="radio" id="disable" name="food_type" value="0" /> <label for="disable"> Non-Veg</label>  
					   <br>  <br>  <br>  <br> 
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
	
	
	<script type="text/javascript" src="clock/sample/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="clock/sample/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="clock/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="clock/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
	<script type="text/javascript">
	$('.form_time').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  0,
		autoclose: 1,
		todayHighlight: 0,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
	
	</script>


        
<?php include("includes/footer.php");?>       
