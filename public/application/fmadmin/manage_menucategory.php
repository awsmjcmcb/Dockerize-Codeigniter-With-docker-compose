<?php 

	include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	//Get all Category 
	$qry="SELECT * FROM tbl_menucategory where hotelid='".$_SESSION['id']."'";
	$result=mysqli_query($mysqli,$qry);
	
	if(isset($_GET['cat_id']))
	{
		$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_menuwallpaper WHERE cat_id=\''.$_GET['cat_id'].'\'');
		$img_res_row=mysqli_fetch_assoc($img_res);

		if($img_res_row['image']!="")
		  {
			unlink('categories/'.$img_res_row['cat_id'].'/'.$img_res_row['image']);
			unlink('categories/'.$img_res_row['cat_id'].'/thumbs/'.$img_res_row['image']);
		  }
	 
		Delete('tbl_wallpaper','cat_id='.$_GET['cat_id'].'');
			

			$cat_res=mysqli_query($mysqli,'SELECT * FROM tbl_menucategory WHERE cid=\''.$_GET['cat_id'].'\'');
			$cat_res_row=mysqli_fetch_assoc($cat_res);

			if($cat_res_row['category_image']!="")
			{
				unlink('images/'.$cat_res_row['category_image']);
				unlink('images/thumbs/'.$cat_res_row['category_image']);
			}
	 
			Delete('tbl_menucategory','cid='.$_GET['cat_id'].'');

		if(!rmdir('categories/'.$_GET['cat_id']))
		{
		  rmdir('categories/'.$_GET['cat_id'].'/thumbs');
		  rmdir('categories/'.$_GET['cat_id']);       
		}

		$_SESSION['msg']="12";
		header( "Location:manage_menucategory.php");
		exit;
		
	}

	
	if(isset($_GET['visibility_mode']))
	{
		$id = $_GET['id'];
		$visibility_mode = $_GET['visibility_mode'];
		$sql = "Update tbl_menucategory SET visibility=".$visibility_mode." WHERE cid=".$id;
		$mysqli->query($sql);
	}
	 
?>
    
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Menu Categories</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
               			
                <div class="add_btn_primary"> <a href="add_menucategory.php?add=yes">Add Category</a> </div>
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
                  <th>Category Type</th> 
                  <th>Category Name</th>                 
                  <th>Category Image</th>
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
                  <td><?php echo strtoupper($row['cat_type']);?></td>
                  <td><?php echo $row['category_name'];?></td>
                 
                  <td><span class="category_img"><img src="images/<?php echo $row['category_image'];?>" /></span></td>
                 
					<td>
					  <?php 
						if($row['visibility']=="1")
						{
						?>		
							<label class="switch1" title="Approved">	
								<input type="checkbox" checked onclick="disable(<?php echo $row['cid'];?>,0);">
								<span class="slider round1"></span>
							</label>
						
							<script>
								
								function disable(id,visibility_mode) {
									$.ajax({
										url:"manage_menucategory.php",
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
						else{ 
						?>		
							<label class="switch1" title="Rejected">	
								<input type="checkbox" onclick="enable(<?php echo $row['cid'];?>,1);">
								<span class="slider round1"></span>
							</label>
							
							<script>
								
								function enable(id,visibility_mode) {
									$.ajax({
										url:"manage_menucategory.php",
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
					  
					  
                  <td><a href="add_menucategory.php?cat_id=<?php echo $row['cid'];?>" class="btn btn-primary">Edit</a>
                    <a href="?cat_id=<?php echo $row['cid'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this category and related wallpaper?');">Delete</a></td>
                </tr>
                <?php
						
						$i++;
				     	}
				?> 
              </tbody>
            </table>
          </div>
          
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
