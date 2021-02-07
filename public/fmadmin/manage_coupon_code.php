    <?php include("includes/header.php");

      require("includes/function.php");
      require("language/language.php");

      //Get all Scratch_coupon
     
      if(isset($_GET['visibility_mode']))
      {
        $id = $_GET['id'];
        $visibility_mode = $_GET['visibility_mode'];
        $sql = "Update tbl_coupon_code SET visibility=".$visibility_mode." WHERE id=".$id;
        $mysqli->query($sql);
      }

      if(isset($_GET['delete_id']))
      {
        $delete=mysqli_query($mysqli,'SELECT * FROM tbl_coupon_code WHERE id=\''.$_GET['delete_id'].'\'');
        $delete_row=mysqli_fetch_assoc($delete);

        Delete('tbl_coupon_code','id='.$_GET['delete_id'].'');
       
        $_SESSION['msg']="12";
        header( "Location:manage_coupon_code.php");
        exit;
        
      }

     
    ?>

         <div class="row">
          <div class="col-xs-12" style="overflow: scroll;">
            <div class="card mrg_bottom">
              <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                  <div class="page_title">Manage  Coupon Code</div>
                </div>
                <div class="col-md-7 col-xs-12">
                  <div class="search_list">
                        <div class="add_btn_primary"> <a href="manage_coupon_type.php?add=yes">Add Coupon Type</a> 
                    </div>&nbsp;&nbsp;&nbsp;
                    <div class="add_btn_primary"> <a href="add_coupon_code.php?add=yes">Add Coupon Code</a> 
                    </div>

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
                     <th>id</th> 
                      <th>Coupon Title</th> 
                     <th>Tame condition</th>   
                      <th>Minimum Order</th>                
                      <th>Coupon Code</th>   
                      <th>Coupon Type</th>                
                      <th>Coupon Value</th> 
                      <th style="width:10%;">Visibility</th>
                      <th class="cat_action_list" style="width:20%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $qry="SELECT * FROM tbl_coupon_code";
                    $result=mysqli_query($mysqli,$qry);
      
                  $i=0;
                while($row=mysqli_fetch_array($result))
                {         
               ?>
                    <tr>  
                       <td><?php echo ($row['id']);?></td>

                       <td><?php echo ($row['title']);?></td>
                     
                      <td><?php echo ($row['tandc']);?></td>

                       <td><?php echo ($row['min_order']);?></td>
             
                      <td><?php echo ($row['coupon_code']);?></td>

                      <td><?php echo ($row['coupon_type']);?></td>
             
                      <td><?php echo ($row['coupon_value']);?></td>

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
                        url:"manage_coupon_code.php",
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
                        url:"manage_coupon_code.php",
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
                
                
                      <td><a href="add_coupon_code.php?id=<?php echo $row['id'];?>" class="btn btn-primary">Edit</a>
                        <a href="?delete_id=<?php echo $row['id'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this coupon ?');">Delete</a></td>

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
