<?php include("includes/connection.php");
 
	include('includes/function.php');

		$host = $_SERVER['HTTP_HOST'];
		preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        $domain_name=$matches[0];
         
	 	  
		
		if($_GET['email']!="")
		{
 
			$to = APP_EMAIL;
			// subject
			$subject = ''.APP_NAME.' contact detail';
 			
			$message='<div style="background-color: #f9f9f9;" align="center"><br />
					  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
					    <tbody>
					      <tr>
					        <td colspan="2" bgcolor="#FFFFFF" align="center"><img src="http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/images/'.APP_LOGO.'" alt="header" /></td>
					      </tr>
					      <tr>
					        <td width="600" valign="top" bgcolor="#FFFFFF"><br>
					          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
					            <tbody>
					              <tr>
					                <td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
					                    <tbody>
					                      <tr>
					                        <td> 
					                          <p style="color:#262626; font-size:16px; line-height:32px;font-weight:500;"> 
					                            Name: '.$_GET['name'].'</p>
					                            <p style="color:#262626; font-size:16px; line-height:32px;font-weight:500;"> 
					                            Email: '.$_GET['email'].'</p>

					                            <p style="color:#262626; font-size:16px; line-height:32px;font-weight:500;"> 
					                            Phone: '.$_GET['phone'].'</p>

					                            <p style="color:#262626; font-size:16px; line-height:32px;font-weight:500;"> 
					                            Subject: '.$_GET['subject'].'</p>

					                            <p style="color:#262626; font-size:16px; line-height:32px;font-weight:500;"> 
					                            Message: '.$_GET['message'].'</p>

					                          <p style="color:#262626; font-size:18px; line-height:32px;font-weight:500;margin-bottom:30px;">Thanks you,<br />
					                            '.APP_NAME.'.</p></td>
					                      </tr>
					                    </tbody>
					                  </table></td>
					              </tr>
					               
					            </tbody>
					          </table></td>
					      </tr>
					      <tr>
					        <td style="color: #262626; padding: 20px 0; font-size: 20px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">Copyright © '.date('Y').' '.APP_NAME.'.</td>
					      </tr>
					    </tbody>
					  </table>
					</div>';

			 
			 
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.APP_NAME.' <noreply@'.$domain_name.'>' . "\r\n";
			// Mail it
			@mail($to, $subject, $message, $headers);
			$name=$_GET['name'];				$email=$_GET['email'];				$phone=$_GET['phone'];				$subject=$_GET['subject'];				$message=$_GET['message'];							$sql = "INSERT INTO tbl_contact (name,email,phone,subject,message) 					VALUES ('$name','$email','$phone','$subject','$message')";  			 			mysqli_query($mysqli, $sql); 
			 	 
			  
			$set['SINGLE_HOTEL_APP'][]=array('msg' => "Message has been sent on your mail!",'success'=>'1');
		}
		else
		{  	 
				
			$set['SINGLE_HOTEL_APP'][]=array('msg' => "Message not sent!",'success'=>'0');
					
		}

	  
 	 header( 'Content-Type: application/json; charset=utf-8');
     $json = json_encode($set);
				
	 echo $json;
	 exit;
	 
?>