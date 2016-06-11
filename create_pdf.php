<?php
date_default_timezone_set('Europe/Warsaw');
require 'phpmailer/PHPMailerAutoload.php';
require 'vendor/autoload.php'; // Include the AWS SDK using the Composer autoloader.
require ("fpdf/fpdf.php");
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


$email = $_REQUEST['email'] ;
//////////////////////////////SQS SENDIND MESSAGES////////////////////////
use Aws\Sqs\SqsClient;
$url = 'https://sqs.eu-central-1.amazonaws.com/881078108084/michalo-album';
$client = SqsClient::factory(array(
    //'profile' => '<profile in your aws credentials file>'
    'version' => 'latest',
    'region'  => 'eu-central-1'
));
$client->sendMessage(array(
    'QueueUrl'    => $url,
    'MessageBody' => $email,
));
//////////////////////////////SQS RECEVING MESSAGES////////////////////////
while(true) {
    $res = $client->receiveMessage(array(
        'QueueUrl'          => $url,
        'WaitTimeSeconds'   => 1
    ));
    if ($res->getPath('Emails')) {

        foreach ($res->getPath('Emails') as $msg) {
            echo "Received Msg: ".$msg['Body'];
///////////////CAŁY KOD/////////////////////////
$bucket = '160689-michalo';
$s3 = new S3Client([   // Instantiate an Amazon S3 client.
     'version' => 'latest',
     'region'  => 'us-west-2'
 ]);

$pdf = new FPDF(); // FPDF section
$pdf->SetFont('Helvetica','',12);
// Use the high-level iterators (returns ALL of your objects).
try {
    $objects = $s3->getIterator('ListObjects', array(
        'Bucket' => $bucket
    ));

    //echo "Keys retrieved!\n";
    foreach ($objects as $object) {
        //echo $object['Key'] . "\n";
        $pdf->AddPage();
        $pdf->Cell(1,1,$object['Key']);
        $pdf->Image('https://s3-us-west-2.amazonaws.com/160689-michalo/'.$object['Key'],30,20,160,110);
    }

} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}

unlink('/var/www/html/upload/test.pdf');
$filename="/var/www/html/upload/test.pdf";
//$pdf_file_contents = $pdf->Output("","S");
$pdf->Output($filename,'F');
//$publicip =exec('curl -s icanhazip.com');
//echo "<a href='http://".$publicip."/upload/test.pdf'>Link do albumu</a>";

//////////////////WYSYŁAM EMAIL/////////////////

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

////////////////SKONCZYŁEM WYSYŁKĘ///////////////

////////////////////////////////////////////////
           

            $res = $client->deleteMessage(array(
                'QueueUrl'      => $url,
                'ReceiptHandle' => $msg['ReceiptHandle']
            ));
        }
    }
}
/////////////////////////////////

?>
