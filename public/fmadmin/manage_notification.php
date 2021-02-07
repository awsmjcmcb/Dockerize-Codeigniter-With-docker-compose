<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	$actual_link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];   
	$split = Explode('/', $actual_link);
	$split_output = $split[count($split) - 1]; 
	$path=str_replace($split_output,"",$actual_link);
	
			
  if($_SESSION['id']==2){

     header( "Location:home.php");
    exit;
  }
	
	//Get all Category 
	$qry="SELECT * FROM tbl_normal_notification WHERE hotelid='".$_SESSION['id']."'";
	$result=mysqli_query($mysqli,$qry);
	

	if(isset($_GET['send_android']))
	{ 
 
		$qry="SELECT * FROM tbl_normal_notification WHERE id='".$_GET['send_android']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);

		$users_sql = "SELECT * FROM tbl_user_token";     
		$users_result = mysqli_query($mysqli,$users_sql);

		while($user_row = mysqli_fetch_assoc($users_result))
		{
		
			
			$title=$row['notification_title'];
     			 $msg=$row['notification_msg'];
    			  $img=$path."images/".$row['notification_image'];
				  
    			  $type="";
			echo Send_GCM_msg($user_row['token'],$title,$msg,$img,$type);
		}


		$_SESSION['msg']="17";
		header( "Location:manage_notification.php");
		exit;
		
	}

	if(isset($_GET['not_id']))
	{ 
 
		Delete('tbl_normal_notification','id='.$_GET['not_id'].'');

		$_SESSION['msg']="12";
		header( "Location:manage_notification.php");
		exit;
		
	}	
	 
?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Notification</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                
                <div class="add_btn_primary"> <a href="add_notification.php?add=yes">Add Notification</a> </div>
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
                  <th>Title</th>
                  <th>Message</th>
                  <th>Image</th>
                  <th>Android</th>
                   <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php	
						$i=0;
						while($row=mysqli_fetch_array($result))
						{					
				?>
                <tr>                 
                  <td><?php echo $row['notification_title'];?></td>
                  <td><?php echo $row['notification_msg'];?></td>
                  <td><img type="image" src="images/<?php echo $row['notification_image'];?>" alt="category image" width="150" height="100" /></td>
                  
                  <td><a href="manage_notification.php?send_android=<?php echo $row['id'];?>" title="Send Pushs"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Send</span></span></a></td>
 

                  <td><a href="add_notification.php?not_id=<?php echo $row['id'];?>" class="btn btn-primary">Edit</a>
                    <a href="?not_id=<?php echo $row['id'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a></td>
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
