<?php
session_start();
	 include("includes/connection.php");
	
	
	
					$sqll = "select count(ID) from tbl_reservation where status='0' AND hotelid='".$_SESSION['id']."'";
						$res = mysqli_query($mysqli,$sqll);	
						$count=mysqli_fetch_array($res);
						$co=$count[0];
						
						echo json_encode($co);
?>