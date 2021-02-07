<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  require_once("thumbnail_images.class.php");

  
  //Add scratch coupon
  if(isset($_POST['submit']) and isset($_GET['add']))
  { 
    
    
          $data = array( 
          'type'  =>  $_POST['type']
        
          );    

            $qry = Insert('tbl_coupon_type',$data); 

            $_SESSION['msg']="10";
         
            header( "Location:manage_coupon_type.php");
            exit; 

  }

  if(isset($_GET['id']))
  {
    $qry="SELECT * FROM tbl_coupon_type where id='".$_GET['id']."'";
    $result=mysqli_query($mysqli,$qry);
    $row=mysqli_fetch_assoc($result);
  
  }
  
    
    
  if(isset($_POST['submit']) and isset($_POST['id']))
  {
     
     
     $data = array( 
          'type'  =>  $_POST['type']
        
          ); 
     
        $category_edit=Update('tbl_coupon_type', $data, "WHERE id = '".$_POST['id']."'");

     

    $_SESSION['msg']="11"; 
    header( "Location:manage_coupon_type.php");
    exit; 
}

?>

  <body>
   <div class="row">
      <div class="col-md-12">
        <div class="card">
      <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Coupon Code Settings</div>
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
          
        <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <input  type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
          <div class="section">
          <div class="section-body">
      
             <div class="form-group">
            <label class="col-md-3 control-label">Coupon Code Type:-</label>
            <div class="col-md-6">
              <input type="text" name="type"  value="<?php if(isset($_GET['id'])){echo $row['type'];}?>" id="type" class="form-control" required>
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
