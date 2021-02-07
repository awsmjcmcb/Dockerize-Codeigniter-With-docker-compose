<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	
	//Get all Category 
	  $tableName="tbl_contact";   
      $targetpage = "manage_contact_us.php"; 
      $limit = 10; 
      
      $query = "SELECT COUNT(*) as num FROM $tableName";
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
		     
     $qry="SELECT * FROM tbl_contact order by id DESC LIMIT $start, $limit";
 
     $result=mysqli_query($mysqli,$qry); 	
	 
	 

	//delete
	if(isset($_GET['delete_id']))
	{
		
		Delete('tbl_contact','id='.$_GET['delete_id'].'');
		
		$_SESSION['msg']="12";
		header( "Location:manage_contact_us.php");
		exit;
		
	}		 
?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">User Feedback</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                
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
                  <th>#</th>
                  <th>User Name</th>
                  <th>User Email</th>
                  <th>User Phone</th>
                  <th>User Subject</th>
                  <th>User Message</th>
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php	
						$count=mysqli_num_rows($result);
					
						if($count==0)
						{
					?>	
						<tr>                 
							<td style="text-align:center; padding:60px;" colspan="7">No Record Found !</td>
						</tr>
					<?php	
						}
						
						$i=0;
						while($row=mysqli_fetch_array($result))
						{					
							?>
							<tr>                 
							  <td><?php echo $row['id'];?></td>
							  <td><?php echo $row['name'];?></td>
							  <td><?php echo $row['email'];?></td>
							  <td><?php echo $row['phone'];?></td>
							  <td><?php echo $row['subject'];?></td>
							  <td><?php echo $row['message'];?></td>
							  
							  <td>
								<a href="?delete_id=<?php echo $row['id'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this ?');">Delete</a>
							  </td>
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
    
	<?php
	 $data = array(
	  'status'  =>  "1"
		);	

	 $category_edit=Update('tbl_contact', $data, "");
	 
	?>
    
<?php include("includes/footer.php");?>       
