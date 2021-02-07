<?php include("includes/connection.php");
      include("includes/session_check.php");
      
      //Get file name
      $currentFile = $_SERVER["SCRIPT_NAME"];
      $parts = Explode('/', $currentFile);
      $currentFile = $parts[count($parts) - 1];       
     	
	  $new_parts = Explode('?', $currentFile); // explode (ex.. add_section.php?add=yes)
      $currentFile = $new_parts[0];       
  
?>
<!DOCTYPE html>
<html>
<head>
<meta name="author" content="">
<meta name="description" content="">
<meta http-equiv="Content-Type"content="text/html;charset=UTF-8"/>
<meta name="viewport"content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME;?></title>
<link rel="stylesheet" type="text/css" href="assets/css/vendor.css">
<link rel="stylesheet" type="text/css" href="assets/css/flat-admin.css">
    <link rel="shortcut icon" href="includes/fv.png" />  		
<!-- Theme -->
<link rel="stylesheet" type="text/css" href="assets/css/theme/blue-sky.css">
<link rel="stylesheet" type="text/css" href="assets/css/theme/blue.css">
<link rel="stylesheet" type="text/css" href="assets/css/theme/red.css">
<link rel="stylesheet" type="text/css" href="assets/css/theme/yellow.css">

 <script src="assets/ckeditor/ckeditor.js"></script>

</head>
<body>
<div class="app app-default">
  <aside class="app-sidebar" id="sidebar">
    <div class="sidebar-header"> <a class="sidebar-brand" href="home.php"><img style="width:auto; height:auto; margin-top: 25px;" src="images/<?php echo APP_LOGO;?>" alt="app logo" /></a>
      <button type="button" class="sidebar-toggle"> <i class="fa fa-times"></i> </button>
    </div>
    <div class="sidebar-menu">
      <ul class="sidebar-nav">  
			<li <?php if($currentFile=="home.php"){?>class="active"<?php }?>> <a href="home.php">
			  <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i> </div>
			  <div class="title">Dashboard</div>
			  </a> 
			</li>
			<!--li <?php if($currentFile=="manage_rooms.php" or $currentFile=="add_room.php" or $currentFile=="edit_room.php"){?>class="active"<?php }?>> <a href="manage_rooms.php">
			  <div class="icon"> <i class="fa fa-hotel" aria-hidden="true"></i> </div>
			  <div class="title">Rooms</div>
			  </a> 
			</li-->			<li <?php if($currentFile=="manage_home_banner.php" or $currentFile=="add_banner.php"){?>class="active"<?php }?>> <a href="manage_home_banner.php">			  <div class="icon"> <i class="fa fa-buysellads" aria-hidden="true"></i> </div>			  <div class="title">Home Banner</div>			  </a> 			</li>
			
			<li <?php if($currentFile=="reservation.php" or $currentFile=="reservation.php" or $currentFile=="reservation.php"){?>class="active"<?php }?>> <a href="reservation.php">
			  <div class="icon"> <i class="fa fa-list" aria-hidden="true"></i> </div>
			  <div class="title">Food Orders</div>
			  
			  </a> 
			</li>
		   
			<li class="dropdown <?php if($currentFile=="manage_menucategory.php" or $currentFile=="add_menucategory.php" or $currentFile=="manage_menugallery.php" or $currentFile=="add_menugallery.php" or $currentFile=="edit_menugallery.php"){?>active<?php }?>">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  <div class="icon">
				<i class="fa fa-cutlery" aria-hidden="true"></i>
			  </div>
			  <div class="title">Manage Menu</div>
			</a>
			<div class="dropdown-menu">
			  <ul>
				<li class="section"><a href="manage_menucategory.php"> <i class="fa fa-sitemap" aria-hidden="true"></i> Categories</a></li>
				<li class="section"><a href="manage_menugallery.php"> <i class="fa fa-cutlery" aria-hidden="true"></i> Menu</a></li>
			   
			  </ul>
			</div>
			</li>						
			
			<li <?php if($currentFile=="manage_users.php" or $currentFile=="add_users.php"){?>class="active"<?php }?>> 
				<a href="manage_users.php">			  
					<div class="icon"> <i class="fa fa-users" aria-hidden="true"></i> </div><div class="title">Manage Users</div>
				</a> 			
			</li>
			
			<li <?php if($currentFile=="manage_flavour.php" or $currentFile=="add_flavour.php"){?>class="active"<?php }?>> 
			<a href="manage_flavour.php">			  
				<div class="icon"> <i class="fa fa-birthday-cake" aria-hidden="true"></i></div><div class="title">manage flavour</div>
				</a> 			
			</li>
		  
			
			<li class="dropdown <?php if($currentFile=="manage_city.php" or $currentFile=="add_city.php" or $currentFile=="manage_sub_city.php" or $currentFile=="add_sub_city.php"){?>active<?php }?>">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  <div class="icon">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
			  </div>
			  <div class="title">Manage City</div>
			</a>
			<div class="dropdown-menu">
			  <ul>
				<li class="section"><a href="manage_city.php"> <i class="fa fa-map-marker" aria-hidden="true"></i> Main City</a></li>
				<li class="section"><a href="manage_sub_city.php"> <i class="fa fa-list" aria-hidden="true"></i> Sub City</a></li>
			   
			  </ul>
			</div>
			</li>	
			
			
			<!--li class="dropdown" <?php if($currentFile=="manage_category.php" or $currentFile=="add_category.php" or $currentFile=="manage_gallery.php" or $currentFile=="add_gallery.php" or $currentFile=="edit_gallery.php"){?>active<?php }?>">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  <div class="icon">
				<i class="fa fa-image" aria-hidden="true"></i>
			  </div>
			  <div class="title">Gallery</div>
			</a>
			<div class="dropdown-menu">
			  <ul>
				<li class="section"><a href="manage_category.php"> <i class="fa fa-sitemap" aria-hidden="true"></i> Categories</a></li>
				<li class="section"><a href="manage_gallery.php"> <i class="fa fa-image" aria-hidden="true"></i> Gallery</a></li>			   
			  </ul>
			</div>
			</li-->
		  	<li <?php if($currentFile=="manage_scratch_coupon.php" or $currentFile=="manage_scratch_coupon.php"){?>class="active"<?php }?>> 
				<a href="manage_scratch_coupon.php">			  
					<div class="icon"> <i class="fa fa-tag fa-lg" aria-hidden="true"></i> </div><div class="title">SCRATCH COUPON </div>
				</a> 			
			</li>
		  
		  	<li <?php if($currentFile=="manage_coupon_code.php" or $currentFile=="manage_coupon_code.php"){?>class="active"<?php }?>> 
				<a href="manage_coupon_code.php">			  
					<div class="icon"> <i class="fa fa-tag fa-lg" aria-hidden="true"></i> </div><div class="title"> COUPON CODE </div>
				</a> 			
			</li>
		  
		   <li <?php if($currentFile=="manage_notification.php" or $currentFile=="add_notification.php"){?>class="active"<?php }?>> <a href="manage_notification.php">
			  <div class="icon"> <i class="fa fa-send" aria-hidden="true"></i> </div>
			  <div class="title">Notification</div>
			  </a> 
			</li>
			
			<!--li <?php if($currentFile=="hotel_info.php"){?>class="active"<?php }?>> <a href="hotel_info.php">
			  <div class="icon"> <i class="fa fa-info" aria-hidden="true"></i> </div>
			  <div class="title">Hotel Info</div>
			  </a> 
			</li-->
			
			<li <?php if($currentFile=="manage_contact_us.php"){?>class="active"<?php }?>> <a href="manage_contact_us.php">
			  <div class="icon"> <i class="fa fa-comments-o" aria-hidden="true"></i> </div>
			  <div class="title">Feedback
			   			  
				<?php
					$qry="SELECT * FROM tbl_contact where status=0";
					$result=mysqli_query($mysqli,$qry); 	
					$count=mysqli_num_rows($result);				
					if($count>0)
					{
						?>
						<i class="fa fa-circle"></i> 
						<?php
					}
				?>				
			  </div>
			  </a> 
			</li>
        

			<li <?php if($currentFile=="settings.php"){?>class="active"<?php }?>> <a href="settings.php">
			  <div class="icon"> <i class="fa fa-cog" aria-hidden="true"></i> </div>
			  <div class="title">Settings</div>
			  </a> 
			</li>

			<li <?php if($currentFile=="api_urls.php"){?>class="active"<?php }?>> <a href="api_urls.php">
			  <div class="icon"> <i class="fa fa-exchange" aria-hidden="true"></i> </div>
			  <div class="title">API URLS</div>
			  </a> 
			</li>
      </ul>
    </div>
     
  </aside>   
  <div class="app-container">
    <nav class="navbar navbar-default" id="navbar">
      <div class="container-fluid">
        <div class="navbar-collapse collapse in">
          <ul class="nav navbar-nav navbar-mobile">
            <li>
              <button type="button" class="sidebar-toggle"> <i class="fa fa-bars"></i> </button>
            </li>
            <li class="logo"> <a class="navbar-brand" href="#"><?php echo APP_NAME;?></a> </li>
            <li>
              <button type="button" class="navbar-toggle">
                <?php if(PROFILE_IMG){?>               
                  <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">
                <?php }else{?>
                  <img class="profile-img" src="assets/images/profile.png">
                <?php }?>
                  
              </button>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-left">
            <li class="navbar-title"><b><?php echo APP_NAME;?></b></li>
             
          </ul>
          <ul class="nav navbar-nav navbar-right">
			<?php if($_SESSION['admin_name']!="admin"){ ?>
			<li  class="profile" style="margin-right:15px;">
				<a href="manage_amit_mishra_event.php" style="padding-top: 10px;  padding-bottom: 10px;" class="btn btn-primary"><i class="fa fa-list" aria-hidden="true"></i> Manage Amit Mishra Event</a>
			</li>
			<?php } ?>
		  
            <li class="dropdown profile"> <a href="profile.php" class="dropdown-toggle" data-toggle="dropdown"> <?php if(PROFILE_IMG){?>               
                  <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">
                <?php }else{?>
                  <img class="profile-img" src="assets/images/profile.png">
                <?php }?>
              <div class="title">Profile</div>
              </a>
              <div class="dropdown-menu">
                <div class="profile-info">
                  <h4 class="username"><?php echo APP_NAME; ?> </h4>
                </div>
                <ul class="action">
				
					<li><a href="profile.php">Profile</a></li>
					<?php if($_SESSION['admin_name']!="admin")
					{ ?>
						<li><a href="addhotel.php">Add Hotel</a></li>   
					<?php
					}
					?>				   
					<li><a href="logout.php">Logout</a></li>
					
                </ul>
              </div>
            </li>
			
          </ul>
        </div>
      </div>
    </nav>