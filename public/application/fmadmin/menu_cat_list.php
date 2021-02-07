<?php
	require("includes/function.php");
	include("includes/connection.php");
 	
	$jsonObj1= array();
	$jsonObj2= array();

	$app_id =1;
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	 
	 
	 
	
	 
	//-----------------------------------INSTOCK_CATEGORY_LIST-------------------------- 
	 
	$query="SELECT * FROM tbl_menucategory where cat_type='instock' and visibility=1 and hotelid='$app_id' ORDER BY tbl_menucategory.cid";
	$sql = mysqli_query($mysqli,$query)or die(mysql_error());

	while($data = mysqli_fetch_assoc($sql))
	{
		//Wallpaper count
		$query_wall = "SELECT COUNT(*) as num FROM tbl_menuwallpaper WHERE visibility=1 and cat_id='".$data['cid']."'";
		$total_wall = mysqli_fetch_array(mysqli_query($mysqli,$query_wall));
		$total_wall = $total_wall['num'];	

		$row['cid'] = $data['cid'];
		$row['cat_type'] = $data['cat_type'];
		$row['category_name'] = $data['category_name'];
		$row['category_image'] = $file_path.'images/'.$data['category_image'];
		$row['category_image_thumb'] = $file_path.'images/thumbs/'.$data['category_image'];

		$row['total_wallpaper'] = $total_wall;

		array_push($jsonObj1,$row);
	
	}

	$set['INSTOCK_CATEGORY_LIST'] = $jsonObj1;
	
	
	 
	 
	//-----------------------------------ADVANCE_CATEGORY_LIST--------------------------
	
	$query1="SELECT * FROM tbl_menucategory where cat_type='advance' and visibility=1 and hotelid='$app_id' ORDER BY tbl_menucategory.cid";
	$sql1 = mysqli_query($mysqli,$query1)or die(mysql_error());

	while($data1 = mysqli_fetch_assoc($sql1))
	{
		//Wallpaper count
		$query_wall = "SELECT COUNT(*) as num FROM tbl_menuwallpaper WHERE visibility=1 and cat_id='".$data1['cid']."'";
		$total_wall = mysqli_fetch_array(mysqli_query($mysqli,$query_wall));
		$total_wall = $total_wall['num'];	

		$row1['cid'] = $data1['cid'];
		$row1['cat_type'] = $data1['cat_type'];
		$row1['category_name'] = $data1['category_name'];
		$row1['category_image'] = $file_path.'images/'.$data1['category_image'];
		$row1['category_image_thumb'] = $file_path.'images/thumbs/'.$data1['category_image'];

		$row1['total_wallpaper'] = $total_wall;
		 
		array_push($jsonObj2,$row1);
	
	}

	$set['ADVANCE_CATEGORY_LIST'] = $jsonObj2;
	
	
	
	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
		


?>