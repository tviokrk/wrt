<?php 
require_once "Mail.php";  
$from = "Sandra Sender"; 
$to = "Ramona Recipient <tviokrk@gmail.com>"; 
$subject = "Hi!"; 
$body = "Hi,\n\nHow are you?";  
$host = "ssl://smtp.wp.pl"; 
$port = "465"; 
$username = "tviokrk"; 
$password = "zaq!@wsx";  
$headers = array ('From' => $from,   'To' => $to,   'Subject' => $subject); 
$smtp = Mail::factory('smtp',   array ('host' => $host,     'port' => $port,     'auth' => true,     'username' => $username,     'password' => $password));  
$mail = $smtp->send($to, $headers, $body);  
if (PEAR::isError($mail)) {   echo("<p>" . $mail->getMessage() . "</p>");
} 
else 
{   echo("<p>Message successfully sent!</p>");  } 
?>
