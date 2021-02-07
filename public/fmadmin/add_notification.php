<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");
	
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
	  
    $file_name= str_replace(" ","-",$_FILES['notification_image']['name']);

    $notification_image=rand(0,99999)."_".$file_name;
       
       //Main Image
    $tpath1='images/'.$notification_image;        
    $pic1=compress_image($_FILES["notification_image"]["tmp_name"], $tpath1, 80);
   
    
		$data = array(
		
		'hotelid' =>$_SESSION['id'],
          'notification_title' => $_POST['notification_title'],  
			    'notification_msg'  =>  $_POST['notification_msg'],
          'notification_image'  =>  $notification_image
			    );		

 		$qry = Insert('tbl_normal_notification',$data);			

		$_SESSION['msg']="10";
 
		header( "Location:manage_notification.php");
		exit;	
		 
		 
	}
	
	if(isset($_GET['not_id']))
	{
			 
			$qry="SELECT * FROM tbl_normal_notification WHERE id='".$_GET['not_id']."'";
			$result=mysqli_query($mysqli,$qry);
			$row=mysqli_fetch_assoc($result);


	}
	if(isset($_POST['submit']) and isset($_POST['not_id']))
	{
		if($_FILES['notification_image']['name']!="")
     {
        $file_name= str_replace(" ","-",$_FILES['notification_image']['name']);

        $notification_image=rand(0,99999)."_".$file_name;
           
           //Main Image
        $tpath1='images/'.$notification_image;        
        $pic1=compress_image($_FILES["notification_image"]["tmp_name"], $tpath1, 80);
       
        
        $data = array(
              'notification_title' => $_POST['notification_title'],  
              'notification_msg'  =>  $_POST['notification_msg'],
              'notification_image'  =>  $notification_image
              );    

     }
     else
     {
        $data = array(
          'notification_title' => $_POST['notification_title'],  
          'notification_msg'  =>  $_POST['notification_msg'] 
          );  
     } 
			
		
		$noti_edit=Update('tbl_normal_notification', $data, "WHERE id = '".$_POST['not_id']."'");

		$_SESSION['msg']="11";
		header( "Location:add_notification.php?not_id=".$_POST['not_id']);
		exit;	
		 
	}


?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['not_id'])){?>Edit<?php }else{?>Add<?php }?> Notification</div>
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
            	<input  type="hidden" name="not_id" value="<?php echo $_GET['not_id'];?>" />

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="notification_title" id="notification_title" value="<?php if(isset($_GET['not_id'])){echo $row['notification_title'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Message :-</label>
                    <div class="col-md-6">
                        <textarea name="notification_msg" id="notification_msg" class="form-control" required><?php if(isset($_GET['not_id'])){echo $row['notification_msg'];}?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Image :-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="notification_image" value="fileupload" id="fileupload">
                            <?php if(isset($_GET['not_id']) and $row['notification_image']!="") {?>
                            <div class="fileupload_img"><img type="image" src="images/<?php echo $row['notification_image'];?>" alt="category image" /></div>
                          <?php } else {?>
                            <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                          <?php }?>
                      </div>
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
