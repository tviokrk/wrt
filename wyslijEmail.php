
<?php
function sendmail($email){


$publicip =exec('curl -s icanhazip.com');
$message = "Link do albumu: ".$publicip."/upload/test.pdf";

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;    //Whether to use SMTP authentication
$mail->Username = "michal.wrt123@gmail.com";   //Username to use for SMTP authentication - use full email address for gmail
$mail->Password = "michal1234567";  //Password to use for SMTP authentication
$mail->setFrom('michal.wrt123@gmail.com', 'Nadawca');  //Set who the message is to be sent from
$mail->addAddress($email, 'Odbiorca');  //Set an alternative reply-to address
$mail->Subject = 'Album Amazon S3';  //Set the subject line
$mail->Body = $message;  
$mail->addAttachment('upload/test.pdf');  //Attach an image file
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
return $email;
} 
?>
