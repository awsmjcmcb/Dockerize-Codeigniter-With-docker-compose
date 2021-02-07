<?php 

	include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");

	//Get all Category 
	$qry="SELECT *, cl.id as city_id FROM  tbl_city_list cl, tbl_city c where c.id=cl.city_id order by cl.id desc";
	$result=mysqli_query($mysqli,$qry);

	if(isset($_GET['delete_id']))
	{
		Delete('tbl_city_list','id='.$_GET['delete_id'].'');
		$_SESSION['msg']="12";
		header( "Location:manage_sub_city.php");
		exit;
	}	

	?>

    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
		
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Sub City</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="add_btn_primary"> <a href="add_sub_city.php?add=yes">Add Sub City</a> </div>
              </div>
            </div>
          </div>
		  
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> 
				</div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
		  
          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>                  
                  <th style="width:10%;">No</th>
                  <th>City Name</th>
                  <th >Sub City Name</th>
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
					  <td><?php echo $row['city_id'];?></td>
					  <td><?php echo $row['city_name'];?></td>
					  <td><?php echo $row['sub_city'];?></td>
					  <td><a href="add_sub_city.php?edit_id=<?php echo $row['city_id'];?>" class="btn btn-primary">Edit</a>
						<a href="?delete_id=<?php echo $row['city_id'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this ?');">Delete</a>
					  </td>
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