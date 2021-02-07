<?php

	include("includes/connection.php");
	
	$file_path = 'https://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';

	$jsonObj= array();

	$query="SELECT * FROM tbl_flavour ORDER BY f_id asc";
	$sql = mysqli_query($mysqli,$query);
	while($data = mysqli_fetch_assoc($sql))
	{
		$row['f_id'] = $data['f_id'];
		$row['f_name'] = $data['flavour_name'];
		
		array_push($jsonObj,$row);
		
	}

	$set['FLAVOUR_LIST'] = $jsonObj;

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();

	// Close connection
	mysqli_close($mysqli);
	
?>