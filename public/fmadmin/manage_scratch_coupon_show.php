    <?php include("includes/header.php");

      require("includes/function.php");
      require("language/language.php");

   
    ?>
         <div class="row">
          <div class="col-xs-12">
            <div class="card mrg_bottom">
              <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                  <div class="page_title">Manage Scratch Coupon</div>
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
                  <form action="hi.php" method="post" class="form form-horizontal" >
                
                  <thead>
                    <tr>  
                       <th>Id</th>
                      <th>Title</th> 
                      <th>Amount</th>               
                      <th class="cat_action_list" style="width:20%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $qry="SELECT * FROM tbl_scratch_coupons WHERE visibility='1'";
                    $result=mysqli_query($mysqli,$qry);
      
                  $i=0;
                while($row=mysqli_fetch_array($result))
                {         
               ?>
                    <tr>  
                       <td> <input type="hidden" name="users_id" id="users_id" value="<?php echo $_GET['users_id']; ?>" class="form-control"  >  <?php echo ($row['id']);?></td>
             
                      <td><?php echo ($row['title']);?></td>
             
                      <td><?php echo ($row['amount']);?></td>

                      <td><a href="add_sc_users.php?coupon_id=<?php echo $row['id'];?>&users_id=<?php echo $_GET['users_id'];  ?>" class="btn btn-primary">send</a>
                        

                    </tr>
                    <?php
                
                $i++;
                  }
            ?> 
                  </tbody>
                </form>
                </table>
              </div>
              
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
            
    <?php include("includes/footer.php");?>       
