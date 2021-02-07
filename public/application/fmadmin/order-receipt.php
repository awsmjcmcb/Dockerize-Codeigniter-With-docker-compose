<?php 
	require("includes/connection.php");
	require("includes/function.php");
	require("language/language.php");
	 
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
 	  
	$qry="SELECT * FROM tbl_settings where id='1'";
	$result=mysqli_query($mysqli,$qry);
	$settings_row=mysqli_fetch_assoc($result);
	
	$ID=$_GET['order_id'];
	$print=$_GET['print'];

	

	
	$qry="SELECT * FROM tbl_reservation where ID=$ID";
	$result=mysqli_query($mysqli,$qry);
	$order_row=mysqli_fetch_array($result);
	
	//convert json data to array
	$json_data=$order_row['json_order_list'];
	$orderDetails = json_decode($json_data, true);
	
	/* 
		echo $orderDetails['order_array'][0]['qty'];
		echo "<pre>";
		print_r($orderDetails);
		echo"</pre>"; 
	*/
	
	$total_order_count=count($orderDetails['order_array']);


	
 ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>Order Reciept of <?php echo $settings_row['app_name']; ?> </title>
    <link rel="shortcut icon" href="includes/fv.png" />  		
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="assets/bill/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/bill/font-awesome/css/font-awesome.min.css" />

    <script type="text/javascript" src="assets/bill/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="assets/bill/bootstrap/js/bootstrap.min.js"></script>
  	
    <?php if (isset($print)) { ?>
	<script type="text/javascript">
        window.onload = function () {
       printpage();
        }
    </script>
<?php } ?>
	

</head>
<body style="background-color: #ebebeb;">

<div class="container">

<!-- Simple Invoice - START -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="text-center" style="margin:20px 0 20px 0;">
                <img src="<?php echo $file_path."images/".$settings_row['app_logo']; ?>" style="padding: 0; text-align: center; width: 200px; height: auto;">
            </div>
			
            <div class="row">
                <div class="col-xs-12 col-md-3 col-lg-3">
				</div>
                <div class="col-xs-12 col-md-6 col-lg-6" style="padding-right: 0px; padding-left: 0px;">
					<img src="https://gallery.mailchimp.com/c6b1236c909d2d0e1b52e9f8f/images/a150d768-f865-4778-9d16-10ce88d1ee4c.png" width="580" height="6" style="display: block; padding: 0; width: 100%; height: 6px; margin-bottom: 0px;">
					
                    <div class="panel panel-default height" style="border: 0px; border-color: #ddd0; margin-bottom: 0px; border-radius: 0px;">
                        <div class="panel-heading" style="background-color: #43515e; border-color: #ddd0; border-radius:0px;">
						
								<div style="padding: 20px 0 20px 0;" class="pad-header">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tbody><tr>
											<td align="center" style="font-size: 19px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #EBEBEB; font-weight: 300;" class="pad-header-copy">
											   Your order has been placed successfully !
											</td>
										</tr>
										<tr>
											<td align="center" style="font-size: 42px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #EBEBEB; font-weight: 300;" class="pad-header-copy">
												<?php echo $settings_row['app_name']; ?>
											</td>
										</tr>
									</tbody></table>
								</div>
						
						</div>
                        <div class="panel-body">
                         
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<!-- RESERVATION DEETS -->
								<tr>
									<td style="padding: 10px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="left" style="padding: 0 0 15px 0; font-size: 20px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #43515E; font-weight: 600;">
													Delivery Information
												</td>
											</tr>
											<!-- CHECK-IN -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 5px 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																		   Order Id :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #999999; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['ID']; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										<?php if($order_row['name']!=""){ ?>	
											<!-- CHECK-IN -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 5px 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																		   Full Name :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #999999; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['name']; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										<?php } ?>	
										<?php if($order_row['phone']!=""){ ?>	
											<!-- CHECK-OUT -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 5px 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																			Phone No :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['phone']; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										<?php } ?>	
										<?php if($order_row['email']!=""){ ?>	
											<!-- # OF NIGHTS -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 5px 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																			Email Address :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['email']; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										<?php } ?>	
										<?php if($order_row['address']!=""){ ?>	
											<!-- NUMBER OF ROOMS -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 5px 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																			Address :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['address']; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										
										<?php } ?>	
										<?php if($order_row['city_name']!=""){ ?>		
											<!-- ROOM TYPE -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 0 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																			City :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['sub_city_name'].",".$order_row['city_name']."."; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										<?php } ?>	
										<?php if($order_row['date_time']!=""){ ?>	
										
											<!-- ROOM TYPE -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 0 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																			Order Date :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['date_time']; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										<?php } ?>	
										<?php if($order_row['comment']!=""){ ?>	
										
											<!-- ROOM TYPE -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 0 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="26%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																			Comment :
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="70%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 400; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p">
																		   <?php echo $order_row['comment']; ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										<?php } ?>	
										
											
											<!--NOTE -->
											<tr>
												<td>
													<hr>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
														<tr>
															<td valign="top" style="padding: 0 0 0 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="100%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #00b1b1; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-bold">
																			Note :   Thank you for order. Your order is placed successfully. We have send SMS to your register number (<?php echo $order_row['phone']; ?>). In case of any query please contact us <?php echo $settings_row['app_contact']; ?>
																		</td>
																	</tr>
																</table>
																
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
											
											
											
										</table>
									</td>
								</tr>
								<!-- DASHED LINE -->
								<tr>
									<td style="padding: 0 0 10px 0;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center" style="padding: 15px 0 0 0; font-size: 16px; line-height: 1px; font-family: Helvetica, Arial, sans-serif; color: #999999; border-bottom: 1px dashed #999999;" class="padding-copy">
													&nbsp;
												</td>
											</tr>
										</table>
									</td>
								</tr>
						   
								<!-- ROOM CHARGES -->
								<tr>
									<td style="padding: 0px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="left" style="padding: 0 0 15px 8px; font-size: 20px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #43515E; font-weight: 600; line-height: 22px; text-align: left;">
													Order Lists
												</td>
											</tr>
											<!-- ROOM 1 -->
											<tr>
												<td>
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
													
													<?php
													for($i=0;$i<$total_order_count;$i++)
													{
														?>									   
														<!-- CHARGE 1 -->
														<tr>
															<td valign="top" style="padding: 0 0 0 0;">
																<!-- LEFT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="60%" align="left" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 10px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: left;" bgcolor="#ffffff" class="flex-p-desc_charges">
																			<?php echo $orderDetails['order_array'][$i]['menu_name'];?>
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="20%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																			<i class="fa fa-inr"></i> <?php echo $orderDetails['order_array'][$i]['sub_total'];?>
																		</td>
																	</tr>
																</table>
																<!-- RIGHT COLUMN -->
																<table cellpadding="0" cellspacing="0" border="0" width="20%" align="right" class="responsive-table">
																	<tr>
																		<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																			Qty : <?php echo $orderDetails['order_array'][$i]['qty'];?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
														
														<?php
													}
													?>		
														
													</table>
													<hr style="margin-top: 10px; margin-bottom: 10px;">
												</td>
											</tr>
										
											<!-- TOTAL COUNT -->
											<tr>
												<td align="right" style="padding: 15 0 0 0; font-size: 15px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 100;" class="align-total-charge">
												
													<table cellpadding="0" cellspacing="0" border="0" width="20%" align="right" class="responsive-table">
														<tr>
															<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																<i class="fa fa-inr"></i> <?php echo $orderDetails['amount']['sub_total'];?>
															</td>
														</tr>
													</table>
													<!-- RIGHT COLUMN -->
													<table cellpadding="0" cellspacing="0" border="0" width="50%" align="right" class="responsive-table">
														<tr>
															<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																Total Order : 
															</td>
														</tr>
													</table>
												
												</td>
												
											</tr>
											
											
											<tr>
												<td align="right" style="padding: 15 0 0 0; font-size: 15px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 100;" class="align-total-charge">
												
													<table cellpadding="0" cellspacing="0" border="0" width="20%" align="right" class="responsive-table">
														<tr>
															<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																<i class="fa fa-inr"></i> <?php echo $orderDetails['amount']['wallet'];?>
															</td>
														</tr>
													</table>
													<!-- RIGHT COLUMN -->
													<table cellpadding="0" cellspacing="0" border="0" width="50%" align="right" class="responsive-table">
														<tr>
															<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																Wallet : 
															</td>
														</tr>
													</table>
												
												</td>
												
											</tr>
											
										<?php
										if($order_row['order_type']=="Home Delivery")
										{
										?>	
											
											<tr>
												<td align="right" style="padding: 15 0 0 0; font-size: 15px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 100;" class="align-total-charge">
												
													<table cellpadding="0" cellspacing="0" border="0" width="20%" align="right" class="responsive-table">
														<tr>
															<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																<i class="fa fa-inr"></i> <?php echo $orderDetails['amount']['delivery_charges'];?>
															</td>
														</tr>
													</table>
													<!-- RIGHT COLUMN -->
													<table cellpadding="0" cellspacing="0" border="0" width="50%" align="right" class="responsive-table">
														<tr>
															<td align="center" style="padding: 0 0 0 0; font-family: Arial, sans-serif; color: #333333; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px; text-align: right;" bgcolor="#ffffff" class="flex-p-charges">
																Delivery Charges : 
															</td>
														</tr>
													</table>
												
												</td>
												
											</tr>
											
										<?php
										}
										?>	
												
											<!-- TOTAL -->
											<tr>
												<td align="right" style="padding: 15 0 0 0; font-size: 32px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #00b1b1; font-weight: 100;" class="align-total-charge"  width="100%">
													<i class="fa fa-inr"></i> <b><?php echo $orderDetails['amount']['total_price'];?></b>
												</td>
											</tr>
											<!-- TOTAL TITLE -->
											<tr>
												<td align="right" style="font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #999999; font-weight: 600; font-size: 12px; line-height: 22px;" class="align-total-charge">
													Total (including tax recovery charges and service fees)
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<!-- DASHED LINE -->
								<tr>
									<td style="padding: 0px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center" style="padding: 15px 0 0 0; font-size: 16px; line-height: 1px; font-family: Helvetica, Arial, sans-serif; color: #999999; border-bottom: 1px dashed #999999;" class="padding-copy">
													&nbsp;
												</td>
											</tr>
										</table>
									</td>
								</tr>
								
								
							</table>

						 
                        </div>
						
				
						
						
                    </div>		
					
					<img src="https://gallery.mailchimp.com/c6b1236c909d2d0e1b52e9f8f/images/b1dca63c-f6a5-454a-a733-bfb5a95f7f1f.png" class="img-max" style="display: block; padding: 0; color: #666666; width: 100%; height: 6px; margin-bottom: 20px; margin-top: -1px; ">
	 
                </div>
            </div>
        </div>
    </div>
	
</div>


<?php 

if(isset($_SESSION['id']))
{
	?>
	<div class="add_btn_primary" id="pp" name="pp" type="submit" style="text-align:center"> <a onclick="printpage()">PRINT</a> </div> <br> <br> <br>
	<?php
	
}

?>

<script>
function printpage()
{
	window.print();
}
</script>


<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
	
	@media print {
	  @page { margin: 0; }
	  body { margin: 1cm; }
	}

</style>


<style>

.add_btn_primary a {
    background-color: #095077;
    box-shadow: 0 2px 3px rgba(9, 80, 119, 0.3);
    border: 1px solid transparent;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    border-radius: 3px;
    border-style: 1px solid;
    margin-bottom: 5px;
    transition: all 0.3s ease 0s;
    padding: 10px 30px;
    color: #ffffff;
}


.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>

<!-- Simple Invoice - END -->

</div>

</body>
</html>