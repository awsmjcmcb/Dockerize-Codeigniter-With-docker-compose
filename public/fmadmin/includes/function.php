<?php //error_reporting(0);

/**
 * Copyright 2017 Viaviweb.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
 

#Admin Login
function adminUser($username, $password){
    
    global $mysqli;

    $sql = "SELECT id,username FROM tbl_admin where username = '".$username."' and password = '".md5($password)."'";       
    $result = mysqli_query($mysqli,$sql);
    $num_rows = mysqli_num_rows($result);
     
    if ($num_rows > 0){
        while ($row = mysqli_fetch_array($result)){
            echo $_SESSION['ADMIN_ID'] = $row['id'];
            echo $_SESSION['ADMIN_USERNAME'] = $row['username'];
        return true; 
        }
    }
    
}


# Insert Data 
function Insert($table, $data){

    global $mysqli;
    //print_r($data);

    $fields = array_keys( $data );  
    $values = array_map( array($mysqli, 'real_escape_string'), array_values( $data ) );
    
   //echo "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');";
   //exit;  
    mysqli_query($mysqli, "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');") or die( mysqli_error($mysqli) );

}

// Update Data, Where clause is left optional
function Update($table_name, $form_data, $where_clause='')
{   
    global $mysqli;
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;
         
    // run and return the query result
    return mysqli_query($mysqli,$sql);
}

 
//Delete Data, the where clause is left optional incase the user wants to delete every row!
function Delete($table_name, $where_clause='')
{   
    global $mysqli;
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;
     
    // run and return the query result resource
    return mysqli_query($mysqli,$sql);
}  




function Send_GCM_msg($registration_id,$title,$msg,$img,$type)
{
     
    //$data1['data']=$data;
    $data1 = array("title" => $title,"message" => $msg,"image" => $img,"type" => $type); 
	
    $googleApiKey='CLOUD_MESSAGING_LEGACY_SERVER_KEY';
	
    $url = 'https://fcm.googleapis.com/fcm/send';
  
    $registatoin_ids = array($registration_id);
     // $message = array($data);
   
         $fields = array(
             'registration_ids' => $registatoin_ids,
             'data' => $data1,
         );
  
         $headers = array(
             'Authorization: key='. $googleApiKey,
             'Content-Type: application/json'
         );
         // Open connection
         $ch = curl_init();
  
         // Set the url, number of POST vars, POST data
         curl_setopt($ch, CURLOPT_URL, $url);
  
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
         // Disabling SSL Certificate support temporarly
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  
         // Execute post
         $result = curl_exec($ch);
         if ($result === FALSE) {
             die('Curl failed: ' . curl_error($ch));
         }
  
         // Close connection
         curl_close($ch);
       //echo $result;exit;
}

//Image compress
function compress_image($source_url, $destination_url, $quality) 
{

    $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg')
              $image = imagecreatefromjpeg($source_url);

        elseif ($info['mime'] == 'image/gif')
              $image = imagecreatefromgif($source_url);

      elseif ($info['mime'] == 'image/png')
              $image = imagecreatefrompng($source_url);

        imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}

//Create Thumb Image
function create_thumb_image($target_folder ='',$thumb_folder = '', $thumb_width = '',$thumb_height = '')
 {  
     //folder path setup
         $target_path = $target_folder;
         $thumb_path = $thumb_folder;  
          

         $thumbnail = $thumb_path;
         $upload_image = $target_path;

            list($width,$height) = getimagesize($upload_image);
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($file_ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'png':
                    $source = imagecreatefrompng($upload_image);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($upload_image);
                     break;
                default:
                    $source = imagecreatefromjpeg($upload_image);
            }
       imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width,$height);
            switch($file_ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail,80);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail,80);
                    break;
                case 'gif':
                    imagegif($thumb_create,$thumbnail,80);
                     break;
                default:
                    imagejpeg($thumb_create,$thumbnail,80);
            }
 }    
 
function getCategoryTypeName($id){

    global $mysqli;
	
	$qry="select * from tbl_menucategory where cid=".$id." and visibility=1";
	$result=mysqli_query($mysqli, $qry) or die(mysqli_error($mysqli));
	$data=mysqli_fetch_array($result);
	
	return $data['cat_type'];			
}



function getUserEmailPhoneNo($phone){

    global $mysqli;
	
	$qry="select * from tbl_users where mobile=".$phone." and removeAt=0";
	$result=mysqli_query($mysqli, $qry) or die(mysqli_error($mysqli));
	$data=mysqli_fetch_array($result);
	
	return $data['email'];			
}

# SEND MESSAGE
function sendMessage($u_id,$message){
	 global $mysqli;
	
	$qry="SELECT * FROM tbl_users where id=$u_id";
	$result=mysqli_query($mysqli,$qry); 
	$row11=mysqli_fetch_assoc($result);
	$name = $row11['name'];
	$phone=$row11['mobile'];
			
	$message="Dear ".$name.", ".$message;
	$message=urlencode($message);
	
	$url='YOUR__SMS_API';
	
	$ch = curl_init($url);
	
	$result = curl_exec($ch); 
	curl_close($ch);	
}

function sendMessageSingle($u_id,$message)
{
	global $mysqli;
	
	$qry="SELECT * FROM tbl_users where id=$u_id";
	$result=mysqli_query($mysqli,$qry); 
	$row11=mysqli_fetch_assoc($result);
	$name = $row11['name'];
	$phone=$row11['mobile'];
			
	$message="Dear ".$name.", ".$message;
	$message=urlencode($message);
	
	$url='YOUR__SMS_API';
		
	$ch = curl_init($url);
	
	$result = curl_exec($ch); 
	curl_close($ch);
}

function sendMessageMultiple($uids,$message)
{

	$message=urlencode($message);
	
	$url='YOUR__SMS_API';
		
	$ch = curl_init($url);
	
	$result = curl_exec($ch); 
	curl_close($ch);
	
}

# SEND MESSAGE TO OWNER
function sendMessageOwner($owner_no,$owner_msg){
	global $mysqli;
	
	$qry="SELECT * FROM tbl_users where id=$u_id";
	$result=mysqli_query($mysqli,$qry); 
	$row11=mysqli_fetch_assoc($result);
	$name = $row11['name'];
	$phone=$row11['mobile'];
			
	//$message="Hey ".$name.",\nThank you for visiting Dowell Moulds expo";		
	$message="Dear ".$name.", ".$message;
	$message=urlencode($message);
	
	$url='YOUR__SMS_API';
	
	$ch = curl_init($url);
	
	$result = curl_exec($ch); 
	
	/* if($result)
	{
		echo "cccccccccccccccccccccccccccccccccc Success";
	}
	else
	{
		echo "cccccccccccccccccccccccccccccccccc failed";
	} */
	curl_close($ch);
	
}





# SEND MAIL
function sendMail($id,$mail_msg,$company_name,$company_website,$company_email){

    global $mysqli;
	
	
	$qry="SELECT * FROM tbl_india_plast_expo where id=$id";
	$result=mysqli_query($mysqli,$qry); 
	$row11=mysqli_fetch_assoc($result);
	$title = $row11['title'];
	$name = $row11['visitor_name'];
	$phone=$row11['phone'];
	$email=$row11['email'];
	$address=$row11['address'];
	$visitor_company_name=$row11['company_name'];
	
	
	
	$message_email = "Dear $title $name<br><br>";
	$message_email .= $mail_msg;
	
	$subject = $company_name." at india plast expo";
	
	$mail_message ='<html><head><link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"><style>body {font-family: Helvetica,Arial,sans-serif; }.row{ background:#fff;}.row #col1 {padding:5px;} table tr td{background:#fff;max-width:806px;min-hieght:20px;;overflow:auto;font-size:12px;font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; line-height: 24px;padding-right:10px;}</style></head><body style="background:#fff">
	<div style="background: #f3f3f3;width:806px;hieght:140px;border: 2px solid #f3f3f3;	border-top-left-radius: 5px;border-top-right-radius: 5px;padding:10px;"><div align="center"><span style="color:#333;text-align: left; font-family: Helvetica,Arial,sans-serif;font-size:25px;font-weight:bold;">You have received An india plast expo visitors detail</span></div></div><div style="background:#fff;width:806px;hieght:140px;padding:10px;border: 2px solid #f3f3f3;"><P style="text-align: left; font-family: Helvetica,Arial,sans-serif; font-size: 14px; font-weight: bold; color: #333; line-height: 24px;"></P><div class="row"><div id="col1"><table><tr><td style="color:#333; font-weight: bold;">Name</td><td>';
	$mail_message .=  $name;
	$mail_message .= '</td></tr><tr><td style="color:#333; font-weight: bold;">Company Name</td><td>';
	$mail_message .= $visitor_company_name;
	$mail_message .= '</td></tr><tr><td style="color:#333; font-weight: bold;">Email Id</td><td>';
	$mail_message .= $email;
	$mail_message .= '</td></tr><tr><td style="color:#333; font-weight: bold;">Phone</td><td>';
	$mail_message .= $phone;
	$mail_message .= '</td></tr><tr><td style="color:#333; font-weight: bold;">Subject</td><td>';
	$mail_message .= $subject;
	$mail_message .= '</td></tr><tr><td style="color:#333; font-weight: bold;">Address</td><td>';
	$mail_message .= $address;
	$mail_message .= '</td></tr></table></div></div></div>		
	<P style="text-align: left; width:820px; font-size: 12px; color: #333; text-align: justify; line-height: 18px;">Disclaimer: This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p>		
	</body></html>';
	
	$headers1 = "From: $name <$email>" . "\r\n";
	//$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
	//$headers .= "CC: susan@example.com\r\n";
	$headers1 .= "MIME-Version: 1.0\r\n";
	$headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$headers2 = "From: $company_name <$company_email>" . "\r\n";
	//$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
	//$headers .= "CC: susan@example.com\r\n";
	$headers2 .= "MIME-Version: 1.0\r\n";
	$headers2 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	

	//To Website OWNER
	/* if(mail("<$company_email>", $subject, $mail_message, $headers1,"$email")){		
		$send_owner="true";
	} */
	
	// To Website CLIENT
	if(mail("<$email>", $subject, $message_email, $headers2,"$company_email")){
		//echo "SENDER Send";		
		$send_client="true";
	}
	
	//if($send_owner=="true" && $send_client=="true")
	if($send_client=="true")
	{
		$_SESSION['msg']="21";
	}
	else
	{
		$_SESSION['msg']="24";
	} 
	
	//echo $mail_message;
		
}

?>