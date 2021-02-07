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
    

    if($_FILES['sc_master_image']['name']!="")
    {        

            unlink('images/'.$img_row['sc_master_image']);   

            $sc_master_image=$_FILES['sc_master_image']['name'];
            $pic1=$_FILES['sc_master_image']['tmp_name'];

            $tpath1='images/'.$sc_master_image;      
            copy($pic1,$tpath1);


                $data = array(    
              'sc_master_title'  => $_POST['sc_master_title'],
              'sc_master_image'  => $sc_master_image 
                                

              );

             $settings_edit=Update('tbl_settings', $data, "WHERE hotelid = '".$_SESSION['id']."'");
  

     }
     else
     {
                       $data = array(    
                               'sc_master_title'  => $_POST['sc_master_title'],
            

                             );

                       $settings_edit=Update('tbl_settings', $data, "WHERE hotelid = '".$_SESSION['id']."'");
  

     }

    $_SESSION['msg']="11"; 
    header( "Location:manage_scratch_coupon.php");
    exit; 
}

 }


  //Get all Scratch_coupon
     
      if(isset($_GET['visibility_mode']))
      {
        $id = $_GET['id'];
        $visibility_mode = $_GET['visibility_mode'];
        $sql = "Update tbl_scratch_coupons SET visibility=".$visibility_mode." WHERE id=".$id;
        $mysqli->query($sql);
      }



      if(isset($_GET['delete_id']))
      {
        $img_res=mysqli_query($mysqli,'SELECT * FROM tbl_scratch_coupons WHERE id=\''.$_GET['delete_id'].'\'');
        $img_res_row=mysqli_fetch_assoc($img_res);

        Delete('tbl_scratch_coupons','id='.$_GET['delete_id'].'');
       
        $_SESSION['msg']="12";
        header( "Location:manage_scratch_coupon.php");
        exit;
        
      }

  
  
?>
 
   <div class="row">
      <div class="col-md-12">
        <div class="card">
      <div class="page_title_block">
            <div class="col-md-5 col-xs-12">


              <div class="page_title">Settings</div>
            </div><br>
            <div class="add_btn_primary" style="margin-left:350px;"> <a href="add_scratch_coupon.php?add=yes">Add Coupon Code</a> 
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
                <li role="presentation" class="active"><a href="#app_settings" aria-controls="app_settings" role="tab" data-toggle="tab">List  of Coupon</a></li>   

                                              
                      
                   
     
                                    
        <li role="presentation"><a href="#amount_setting" aria-controls="amount_setting" role="tab" data-toggle="tab">Master image-title</a></li>
                            
            </ul>
          
           <div class="tab-content">
              
              <div role="tabpanel" class="tab-pane active" id="app_settings">   
                <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
                   <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>  
                       <th>Id</th>
                      <th>Coupon Title</th> 
                      <th>Message</th>   
                      <th>Amount</th>                
                      <th>Coupon Details</th> 
                      <th style="width:10%;">Visibility</th>
                      <th class="cat_action_list" style="width:20%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $qry="SELECT * FROM tbl_scratch_coupons";
                    $result=mysqli_query($mysqli,$qry);
      
                  $i=0;
                while($row=mysqli_fetch_array($result))
                {         
               ?>
                    <tr>  
                       <td><?php echo ($row['id']);?></td>
             
                      <td><?php echo ($row['title']);?></td>

                      <td><?php echo ($row['message']);?></td>
             
                      <td><?php echo ($row['amount']);?></td>



                      <td>
                        <?php  if($row['coupon_text']){

                          echo ($row['coupon_text']);

                        }
                        else{
                           echo'<img src="images/coupon/'.$row['image'].'"width="100" height="100">'; 
                              
        

                        }

                        ?>

                       
                     
              <td>


                <?php 
                if($row['visibility']=="1")
                {
                ?>    
                  <label class="switch1" title="Approved">  
                    <input type="checkbox" checked onclick="disable(<?php echo $row['id'];?>,0);">
                    <span class="slider round1"></span>
                  </label>
                
                  <script>
                    
                    function disable(id,visibility_mode) {
                      $.ajax({
                        url:"manage_scratch_coupon.php",
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
                    <input type="checkbox" onclick="enable(<?php echo $row['id'];?>,1);">
                    <span class="slider round1"></span>
                  </label>
                  
                  <script>
                    
                    function enable(id,visibility_mode) {
                      $.ajax({
                        url:"manage_scratch_coupon.php",
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
                
                
                      <td><a href="add_scratch_coupon.php?id=<?php echo $row['id'];?>" class="btn btn-primary">Edit</a>
                        <a href="?delete_id=<?php echo $row['id'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this coupon ?');">Delete</a></td>

                    </tr>
                    <?php
                
                $i++;
                  }
            ?> 
                  </tbody>
                </table>

             
               </form>
              </div>
              
           
              
              



              <div role="tabpanel" class="tab-pane" id="amount_setting">    
                <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                 
                    <div class="form-group">
                    <label class="col-md-3 control-label">Master title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="sc_master_title" id="app_name" value="<?php echo $settings_row['sc_master_title'];?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Master image:-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="sc_master_image" id="fileupload">
                         
                          <?php if($settings_row['sc_master_image']!="") {?>
                            <div class="fileupload_img"><img type="image" src="images/<?php echo $settings_row['sc_master_image'];?>" alt="image" style="width:130px; height:auto;"   /></div>
                          <?php } else {?>
                            <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="image" /></div>
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
      </div>
    </div>

        
<?php include("includes/footer.php");?>       
