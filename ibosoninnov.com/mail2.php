<?php
if($_POST && isset($_FILES['my_file']))
{

     
    $recipient_email    = 'vineetha@ibosoninnov.com'; 
    
    //Capture POST data from HTML form and Sanitize them, 
    $sender_name    = filter_var($_POST["name"], FILTER_SANITIZE_STRING); //sender name
    
    $subject        = "Job Application"; //get subject from HTML form
    
    


    $dob    = filter_var($_POST["dat"], FILTER_SANITIZE_STRING); 
    $quali = filter_var($_POST["quali"], FILTER_SANITIZE_STRING); 
    $insti        = filter_var($_POST["insti"], FILTER_SANITIZE_STRING); 
    $per        = filter_var($_POST["per"], FILTER_SANITIZE_STRING); 
    $instia    = filter_var($_POST["instia"], FILTER_SANITIZE_STRING); 
    $pera = filter_var($_POST["pera"], FILTER_SANITIZE_STRING); 
    $instib        = filter_var($_POST["instib"], FILTER_SANITIZE_STRING); 
    $perb        = filter_var($_POST["perb"], FILTER_SANITIZE_STRING); 








$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table style='background-color: #4CAF50;    color: white; background-repeat:no-repeat; text-align:center; width:450px;margin:0;'  border='1'>
<tr>
<td>Name:</td>
<td>$sender_name </td>
</tr>
<tr>
<td>Date Of Birth :</td>
<td>$dob</td>
</tr>
<tr>
<td>Highest qualification :</td>
<td>$quali</td>
</tr>
<tr>
<td>Institution :</td>
<td>$insti</td>
</tr>
<tr>
<td>Percentage :</td>
<td>$per</td>
</tr>
<tr>
<td>12th Institution :</td>
<td>$instia</td>
</tr>
<tr>
<td>Percentage :</td>
<td>$pera</td>
</tr>
<tr>
<td>10th Institution :</td>
<td>$instib</td>
</tr>
<tr>
<td>Percentage :</td>
<td>$perb</td>
</tr>
</table>
</body>
</html>
";








    /* //don't forget to validate empty fields 
    if(strlen($sender_name)<1){
        die('Name is too short or empty!');
    } 
    */
    
    //Get uploaded file data
    $file_tmp_name    = $_FILES['my_file']['tmp_name'];
    $file_name        = $_FILES['my_file']['name'];
    $file_size        = $_FILES['my_file']['size'];
    $file_type        = $_FILES['my_file']['type'];
    $file_error       = $_FILES['my_file']['error'];

    if($file_error > 0)
    {
        die('Upload error or No files uploaded');
    }
    //read from the uploaded file & base64_encode content for the mail
    $handle = fopen($file_tmp_name, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $encoded_content = chunk_split(base64_encode($content));

         $boundary = md5("sanwebe");
        //header
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "From:".$sender_name."\r\n"; 
        
        $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
        
        
        //plain text 
        $body = "--$boundary\r\n";
        $body .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
        $body .= chunk_split(base64_encode($message)); 
        
        //attachment
        $body .= "--$boundary\r\n";
        $body .="Content-Type: $file_type; name=".$file_name."\r\n";
        $body .="Content-Disposition: attachment; filename=".$file_name."\r\n";
        $body .="Content-Transfer-Encoding: base64\r\n";
        $body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n"; 
        $body .= $encoded_content; 
    
    $sentMail = @mail($recipient_email, $subject, $body, $headers);
    if($sentMail) //output success or failure messages
    {       
        header('Location: careera.html'); 
    }else{
        die('Could not send mail! Please check your PHP mail configuration.');  
    }

}
?>