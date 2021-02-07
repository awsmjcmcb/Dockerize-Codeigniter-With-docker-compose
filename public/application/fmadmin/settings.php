<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");
	 
	
	$qry="SELECT * FROM tbl_settings where hotelid='".$_SESSION['id']."'";
  $result=mysqli_query($mysqli,$qry);
  $settings_row=mysqli_fetch_assoc($result);
  
 

  

  if(isset($_POST['submit']))
  {

     
     $img_res=mysqli_query($mysqli,"SELECT * FROM tbl_settings WHERE hotelid='".$_SESSION['id']."'");
    $rows = mysqli_num_rows($img_res);
if($rows>=1)
{
							

    $img_res=mysqli_query($mysqli,"SELECT * FROM tbl_settings WHERE hotelid='".$_SESSION['id']."'");
    $img_row=mysqli_fetch_assoc($img_res);
    

    if($_FILES['app_logo']['name']!="")
    {        

            unlink('images/'.$img_row['app_logo']);   

            $app_logo=$_FILES['app_logo']['name'];
            $pic1=$_FILES['app_logo']['tmp_name'];

            $tpath1='images/'.$app_logo;      
            copy($pic1,$tpath1);


              $data = array(    
              'app_name'  =>  $_POST['app_name'],
              'app_logo'  =>  $app_logo,  
              'app_description'  => addslashes($_POST['app_description']),
              'app_version'  =>  $_POST['app_version'],
              'app_author'  =>  $_POST['app_author'],
              'app_contact'  =>  $_POST['app_contact'],
              'app_email'  =>  $_POST['app_email'],   
              'app_website'  =>  $_POST['app_website'],
              'app_privacy_policy'  =>  $_POST['app_privacy_policy'],
              'app_developed_by'  =>  $_POST['app_developed_by'],
              'fast_food_name'  =>  $_POST['fast_food_name']                     

              );

    }
    else
    {
  
                $data = array(
                'app_name'  =>  $_POST['app_name'],
                'app_description'  => addslashes($_POST['app_description']),
                'app_version'  =>  $_POST['app_version'],
                'app_author'  =>  $_POST['app_author'],
                'app_contact'  =>  $_POST['app_contact'],
                'app_email'  =>  $_POST['app_email'],   
                'app_website'  =>  $_POST['app_website'],
                'app_developed_by'  =>  $_POST['app_developed_by'],
				'fast_food_name'  =>  $_POST['fast_food_name']                  

                  );

    } 

    $settings_edit=Update('tbl_settings', $data, "WHERE hotelid = '".$_SESSION['id']."'");
  
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
        }
        else
        
        {
         $app_logo=$_FILES['app_logo']['name'];
            $pic1=$_FILES['app_logo']['tmp_name'];

            $tpath1='images/'.$app_logo;      
            copy($pic1,$tpath1);


              $data = array(    
              'hotelid' => $_SESSION['id'],
              'app_name'  =>  $_POST['app_name'],
              'app_logo'  =>  $app_logo,  
              'app_description'  => addslashes($_POST['app_description']),
              'app_version'  =>  $_POST['app_version'],
              'app_author'  =>  $_POST['app_author'],
              'app_contact'  =>  $_POST['app_contact'],
              'app_email'  =>  $_POST['app_email'],   
              'app_website'  =>  $_POST['app_website'],
              'app_privacy_policy'  =>  $_POST['app_privacy_policy'],
              'app_developed_by'  =>  $_POST['app_developed_by'],
              'fast_food_name'  =>  $_POST['fast_food_name']                         

              );
  	 $settings_edit=Insert('tbl_settings', $data);
  
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
        
        }
   
 
  }
 

  if(isset($_POST['app_pri_poly']))
  {

        $data = array(
                'app_privacy_policy'  =>  addslashes($_POST['app_privacy_policy']) 
                  );

    
      $settings_edit=Update('tbl_settings', $data, "WHERE hotelid ='".$_SESSION['id']."'");
 

      if ($settings_edit > 0)
      {

        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;

      }   
 
  }

	if(isset($_POST['email_submit']))	{        $data = array(			'email_id' => $_POST['email_id'], 			'email_desc' => addslashes($_POST['email_desc']) 		);		$settings_edit=Update('tbl_settings', $data, "WHERE hotelid ='".$_SESSION['id']."'");		$_SESSION['msg']="11";		header( "Location:settings.php");		exit;			}
	if(isset($_POST['phone_submit']))	{        $data = array(			'phone_no' => $_POST['phone_no'], 			'message_desc' => addslashes($_POST['message_desc']) , 			'complete_message_desc' => addslashes($_POST['complete_message_desc']) 		);		$settings_edit=Update('tbl_settings', $data, "WHERE hotelid ='".$_SESSION['id']."'");		$_SESSION['msg']="11";		header( "Location:settings.php");		exit;			}
	
	
	
	
  if(isset($_POST['amount_submit']))
  {

	$data = array(
		'min_amount_rs'  =>  $_POST['min_amount_rs'],
		'min_amount_msg'  =>  addslashes($_POST['min_amount_msg']) 
	);

	$settings_edit=Update('tbl_settings', $data, "WHERE hotelid ='".$_SESSION['id']."'");

	if ($settings_edit > 0)
	{
		$_SESSION['msg']="11";
		header( "Location:settings.php");
		exit;
	}   

  }
  
  
?>
 
	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Settings</div>
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
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#app_settings" aria-controls="app_settings" role="tab" data-toggle="tab">App Settings</a></li>                                 
				<li role="presentation"><a href="#api_privacy_policy" aria-controls="api_privacy_policy" role="tab" data-toggle="tab">App Privacy Policy</a></li>                
				<li role="presentation"><a href="#email_setting" aria-controls="email_setting" role="tab" data-toggle="tab">Order Email Setting</a></li>                
				<li role="presentation"><a href="#message_setting" aria-controls="message_setting" role="tab" data-toggle="tab">Order Message Setting</a></li>
                                    
				<li role="presentation"><a href="#amount_setting" aria-controls="amount_setting" role="tab" data-toggle="tab">Minimum Order Amount</a></li>
                            
            </ul>
          
           <div class="tab-content">
              
              <div role="tabpanel" class="tab-pane active" id="app_settings">	  
                <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">App Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="app_name" id="app_name" value="<?php echo $settings_row['app_name'];?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">App Logo :-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="app_logo" id="fileupload">
                         
                        	<?php if($settings_row['app_logo']!="") {?>
                        	  <div class="fileupload_img"><img type="image" src="images/<?php echo $settings_row['app_logo'];?>" alt="image" style="width:130px; height:auto;"	 /></div>
                        	<?php } else {?>
                        	  <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="image" /></div>
                        	<?php }?>
                        
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">App Description :-</label>
                    <div class="col-md-6">
                 
                      <textarea name="app_description" id="app_description" class="form-control"><?php echo stripslashes($settings_row['app_description']);?></textarea>

                      <script>CKEDITOR.replace( 'app_description' );</script>
                    </div>
                  </div>
                  <div class="form-group">&nbsp;</div>                 
                  <div class="form-group">
                    <label class="col-md-3 control-label">App Version :-</label>
                    <div class="col-md-6">
                      <input type="text" name="app_version" id="app_version" value="<?php echo $settings_row['app_version'];?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Author :-</label>
                    <div class="col-md-6">
                      <input type="text" name="app_author" id="app_author" value="<?php echo $settings_row['app_author'];?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Contact :-</label>
                    <div class="col-md-6">
                      <input type="text" name="app_contact" id="app_contact" value="<?php echo $settings_row['app_contact'];?>" class="form-control">
                    </div>
                  </div>     
                  <div class="form-group">
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="text" name="app_email" id="app_email" value="<?php echo $settings_row['app_email'];?>" class="form-control">
                    </div>
                  </div>                 
                   <div class="form-group">
                    <label class="col-md-3 control-label">Website :-</label>
                    <div class="col-md-6">
                      <input type="text" name="app_website" id="app_website" value="<?php echo $settings_row['app_website'];?>" class="form-control">
                    </div>
                  </div>                   
                  <div class="form-group">
                    <label class="col-md-3 control-label">Developed By :-</label>
                    <div class="col-md-6">
                      <input type="text" name="app_developed_by" id="app_developed_by" value="<?php echo $settings_row['app_developed_by'];?>" class="form-control">
                    </div>
                  </div>    
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Fast Food Cat Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="fast_food_name" id="fast_food_name" value="<?php echo $settings_row['fast_food_name'];?>" class="form-control">
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
              
           
              <div role="tabpanel" class="tab-pane" id="api_privacy_policy">   
                <form action="" name="api_privacy_policy" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">App Privacy Policy :-</label>
                    <div class="col-md-6">
                 
                      <textarea name="app_privacy_policy" id="privacy_policy" class="form-control"><?php echo stripslashes($settings_row['app_privacy_policy']);?></textarea>

                      <script>CKEDITOR.replace( 'privacy_policy' );</script>
                    </div>
                  </div>
                  
                
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="app_pri_poly" class="btn btn-primary">Save</button>
                       
                    </div>
                  </div>
                </div>
              </div>
               </form>
              </div> 
              
                                        <div role="tabpanel" class="tab-pane" id="email_setting">	                  <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">				  <div class="section">					<div class="section-body">											 					  <div class="form-group">						<label class="col-md-3 control-label">Email Id :-</label>						<div class="col-md-6">						  <input type="text" name="email_id" id="email_id" value="<?php echo $settings_row['email_id'];?>" class="form-control">						</div>					  </div> 						  					  <div class="form-group">						<label class="col-md-3 control-label">Email Description :-</label>						<div class="col-md-6">					 						  <textarea name="email_desc" id="email_desc" class="form-control"><?php echo stripslashes($settings_row['email_desc']);?></textarea>						  <script>CKEDITOR.replace( 'email_desc' );</script><br>						</div>					  </div>						  																  <div class="form-group">						<div class="col-md-9 col-md-offset-3">						  <button type="submit" name="email_submit" class="btn btn-primary">Save</button>						 						</div>					  </div> 					  					</div>				  </div>                </form>              </div>			             		                                           <div role="tabpanel" class="tab-pane" id="message_setting">	                  <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">				  <div class="section">					<div class="section-body">										  <div class="form-group">						<label class="col-md-3 control-label">Phone No :-</label>						<div class="col-md-6">						  <input type="text" name="phone_no" id="phone_no" value="<?php echo $settings_row['phone_no'];?>" class="form-control">						</div>					  </div> 						  					  <div class="form-group">						<label class="col-md-3 control-label">Order Place Message Description :-</label>						<div class="col-md-6">					 						  <textarea name="message_desc" id="message_desc" class="form-control"><?php echo stripslashes($settings_row['message_desc']);?></textarea>						  <!--script>CKEDITOR.replace( 'expo_phone_msg' );</script--><br>						</div>					  </div>						  					  <div class="form-group">						<label class="col-md-3 control-label">Order Complete Message Description :-</label>						<div class="col-md-6">					 						  <textarea name="complete_message_desc" id="complete_message_desc" class="form-control"><?php echo stripslashes($settings_row['complete_message_desc']);?></textarea>						  <!--script>CKEDITOR.replace( 'expo_phone_msg' );</script--><br>						</div>					  </div>					 										  <div class="form-group">						<div class="col-md-9 col-md-offset-3">						  <button type="submit" name="phone_submit" class="btn btn-primary">Save</button>						 						</div>					  </div> 					  					</div>				  </div>                </form>              </div>	



              <div role="tabpanel" class="tab-pane" id="amount_setting">	  
                <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                 
                  <div class="form-group">
                    <label class="col-md-3 control-label">Minimum Amount Rs. :-</label>
                    <div class="col-md-6">
                      <input type="text" name="min_amount_rs" id="min_amount_rs" value="<?php echo $settings_row['min_amount_rs'];?>" class="form-control">
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Minimum Amount Message :-</label>
                    <div class="col-md-6">
                      <input type="text" name="min_amount_msg" id="min_amount_msg" value="<?php echo $settings_row['min_amount_msg'];?>" class="form-control">
                    </div>
                  </div>     
				  
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="amount_submit" class="btn btn-primary">Save</button>
                     
                    </div>
                  </div>
                </div>
              </div>
               </form>
              </div>

			  

            </div>   

          </div>
        </div>
      </div>
    </div>

        
<?php include("includes/footer.php");?>       
