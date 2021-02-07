<?php 
	include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");
	
	if($_POST['search']!="")
	{		
		$search=$_POST['search'];
		$qry="SELECT * FROM tbl_menuwallpaper WHERE price like '%".$search."%' or des like '%".$search."%' Order by id ASC";
		$result=mysqli_query($mysqli,$qry); 	
	}
	else
	{
	  //Get all Wallpaper 
      $tableName="tbl_menuwallpaper";   
      $targetpage = "manage_menugallery.php"; 
      $limit = 10; 
      
      $query = "SELECT COUNT(*) as num FROM $tableName WHERE hotelid='".$_SESSION['id']."'";
      $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $total_pages = $total_pages['num'];
     
      $stages = 3;
      $page=0;
      if(isset($_GET['page'])){
      $page = mysqli_real_escape_string($mysqli,$_GET['page']);
      }
      if($page){
        $start = ($page - 1) * $limit; 
      }else{
        $start = 0; 
      } 
      
     $quotes_qry="SELECT *,tbl_menuwallpaper.id as w_id,tbl_menuwallpaper.visibility as w_visibility FROM tbl_menuwallpaper LEFT JOIN tbl_menucategory ON tbl_menuwallpaper.cat_id= tbl_menucategory.cid  WHERE tbl_menuwallpaper.hotelid='".$_SESSION['id']."' ORDER BY tbl_menuwallpaper.id  DESC LIMIT $start, $limit";
 
     $result=mysqli_query($mysqli,$quotes_qry);  
	}
	//delete
	if(isset($_GET['gallery_id']))
	{ 
		$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_menuwallpaper WHERE id=\''.$_GET['gallery_id'].'\'');
		$img_res_row=mysqli_fetch_assoc($img_res);

		if($img_res_row['image']!="")
		  {
			unlink('categories/'.$img_res_row['cat_id'].'/'.$img_res_row['image']);
			unlink('categories/'.$img_res_row['cat_id'].'/thumbs/'.$img_res_row['image']);
		  }
	 
		Delete('tbl_menuwallpaper','id='.$_GET['gallery_id'].'');
		
		$_SESSION['msg']="12";
		header( "Location:manage_menugallery.php");
		exit;
	}  

	if(isset($_GET['visibility_mode']))
	{
		$id = $_GET['id'];
		$visibility_mode = $_GET['visibility_mode'];
		$sql = "Update tbl_menuwallpaper SET visibility=".$visibility_mode." WHERE id=".$id;
		$mysqli->query($sql);
	}
	
?>

    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Menu</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                
				<div class="search_block">
				  <form  method="post" action="">
					<input class="form-control input-sm" placeholder="Search..." type="search" name="search" value="<?php if($_POST['search']!=""){ echo $_POST['search']; }?>">
					<button type="submit" name="search_btn" class="btn-search"><i class="fa fa-search"></i></button>
				  </form>  
				</div>
				
                <div class="add_btn_primary"> <a href="add_menugallery.php">Add Menu</a> </div>
              </div>
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
          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Menu Name</th>
                  <th>Description</th>
				  <th>Food Time</th>
				  <!--th>Flavour</th-->
                  <th>Gallery Image</th>
                  <th>Price</th>
                  <th style="width:10%;">Visibility</th>
                  <th class="cat_action_list" style="width:20%;">Action</th>
                  
                </tr>
              </thead>
              <tbody>
              	<?php	
						$i=0;
						while($row=mysqli_fetch_array($result))
						{					
				?>
                <tr>
                  <td><?php echo $row['category_name'];  $id=$row['cat_id']; $cat_type=getCategoryTypeName($id); echo "<br><b>(".$cat_type.")</b>"; ?></td>
                  <td><?php echo $row['name'];
					if($row['cat_id']=="72" && $row['cat_food_type']=="Jain")
					{
						echo "<br><b>(".$row['cat_food_type']." Food)</b>";
					}
				  ?></td> 
                  <td><?php echo $row['des'];?> <?php if($cat_type=="advance"){ echo "<b>Weight : ".$row['min_kg']."kg - ".$row['max_kg']."kg</b>"; } ?></td>
				  
				   <td><?php echo $row['food_opening_time'];?> To <?php echo $row['food_closing_time'];?></td>
				  
				  <!--flavour-->
				  <!--<td>
				  
				  <?php
				  
					$str_arr = explode (",", $row['f_id']);  
					//echo $str_arr;
							
				  
				  for($i=0;$i<=count($str_arr);$i++){
					   $qry1= "SELECT flavour_name FROM tbl_flavour where f_id='".$str_arr[$i]."'";
					  // echo $qry1;
					   
					   $result1=mysqli_query($mysqli,$qry1);
					   
						while($row1=mysqli_fetch_array($result1))
						{	
							 $fname = $row1['flavour_name'].",";
							  echo $fname;
						}
				  }
				   
				
						?>
				</td>
				  <flavour end-->
				
				
				 <td>
				  <?php if($row['food_type']==1){ echo "<img width='20px' style='border-radius:3px; background-color: white; position: absolute;' src='images/img/veg.png'>"; } else { echo "<img width='20px' style='border-radius:3px; background-color: white; position: absolute;' src='images/img/non.png'>"; } ?>  
				  <span class="category_img"><img src="categories/<?php echo $row['cat_id'];?>/<?php echo $row['image'];?>" /></span></td>
                  <td><span class="fa fa-rupee"><?php echo $row['price']; ?></span></td>
                  
				  
					<td>
					  <?php 
						if($row['w_visibility']=="1")
						{
						
							?>		
							<label class="switch1" title="Approved">	
								<input type="checkbox" checked onclick="disable(<?php echo $row['w_id'];?>,0);">
								<span class="slider round1"></span>
							</label>						
							<script>
							function disable(id,visibility_mode) {
								$.ajax({
									url:"manage_menugallery.php",
									type:'get',
									data:{id:id,visibility_mode:visibility_mode},
									success:function(){
										//alert('Visibility change successfully !');
										window.location.reload();
									}
								})
							}
							</script>
							<?php
							
						}
						else
						{ 
					
							?>		
							<label class="switch1" title="Rejected">	
								<input type="checkbox" onclick="enable(<?php echo $row['w_id'];?>,1);">
								<span class="slider round1"></span>
							</label>							
							<script>
							function enable(id,visibility_mode) {
								$.ajax({
									url:"manage_menugallery.php",
									type:'get',
									data:{id:id,visibility_mode:visibility_mode},
									success:function(){
										//alert('Visibility change successfully !');
										window.location.reload();
									}
								})
							}
							</script>
							<?php
						}									  
					  ?>
					  
					</td>
					  
                   <td><a href="edit_menugallery.php?gallery_id=<?php echo $row['id'];?>" class="btn btn-primary">Edit</a>
                    <a href="?gallery_id=<?php echo $row['id'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this gallery?');">Delete</a></td>
                </tr>
                <?php
						
						$i++;
				     	}
				?> 
              </tbody>
            </table>
          </div>
           <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php include("pagination.php");?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
