<?php	

	include("includes/connection.php");	

	/*----------------------------------CAT-LIST  BY-CAT-TYPE-ID------------------------------------*/
	if(isset($_GET['cat_type']))
	{
		$qry="SELECT * FROM tbl_menucategory where cat_type='".$_GET['cat_type']."' order by cid ASC";
		$result=mysqli_query($mysqli,$qry);
		?>
		<option value="">--Select Category Name--</option>
		<?php
		while($get_row=mysqli_fetch_assoc($result))
		{ 
			?> 
			<option value="<?php echo $get_row['cid'];?>"><?php echo $get_row['category_name'];?></option>
			<?php
		}	
	}
	
	
?> 
<?php //if($_POST['selectedCatId']==$get_row['cid']){echo "selected";} ?>