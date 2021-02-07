<link rel="stylesheet" type="text/css" href="assets/css/bill.css">
<?php
include("includes/connection.php");

$bill=$_REQUEST['bill_id'];
 $qry="SELECT * FROM tbl_reservation WHERE ID=$bill";
		$result=mysqli_query($mysqli,$qry);
		if($row=mysqli_fetch_assoc($result))
		{
		$orderno=$row["ID"];
		$name=$row["name"];
		$date_time=$row["date_time"];
		$phone=$row["phone"];
		$order_list=$row["order_list"];
		$email=$row["email"];
		$ordertype=$row["order_type"];
		$address=$row["address"];
		}
?>
<div class="container">
	<table>
		<caption>
			
			<img src=./images/logo.jpg />
		</caption>
		<thead>
			<tr>
				<th colspan="3">Order No: <?php echo $orderno; ?></th>
				<th><?php echo date('d/m/y'); ?></th>
			</tr>
			<tr>
			<td colspan="4">
			<b>Order Type: </b><?php echo $ordertype; ?>
			</td>
			</tr>
			<tr>
				<td colspan="1">
					<h4>Pay to:</h4>
					
					<p>HOTEL SILVER LEAF<br>
					</p>
				</td>
				<td colspan="2">
					<h4>Customer:</h4>
					
					<p><?php echo $name; ?><br>
					<?php echo $address; ?>
					</p>
				</td>
				<td colspan="1">
					<h4>Contact Details:</h4>
					
					<p><?php echo $phone; ?><br>
					<?php echo $email; ?>
					</p>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				
				<th colspan=4>Items/Description</th>
				
			</tr>
			<tr>
			

			<td colspan=4>
			<center>
			<?php
			
			$myArray = explode(',', $order_list);
			foreach($myArray as $my_Array){
			
			 // echo $my_Array.'<br><br>';
		
			}
				 $colpos = strrpos($order_list, ",");
				  $result = substr($order_list, 0, $colpos);
				 // echo $result;
				 $values = str_replace( ',', '<br />', $result );
				 echo $values;
			?>
			</center>
			</td>
			</tr>
			
		</tbody>
		<tfoot>
		<tr>
			<td colspan=4> <center>
			<?php
			$output = explode(",",$order_list);
			echo $output[count($output)-1];
			
			
			?>
			
			</center></td>
			</tr>
			
		</tfoot>
		
	</table>
	<br>
	<center><button type="submit" name="submit" onclick="print();" class="btn btn-primar">Print</button></center>
</div>