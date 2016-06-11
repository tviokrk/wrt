<?php
date_default_timezone_set('Europe/Warsaw');
require 'phpmailer/PHPMailerAutoload.php';
require 'vendor/autoload.php'; // Include the AWS SDK using the Composer autoloader.
require ("fpdf/fpdf.php");
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Sqs\SqsClient;

$email = $_REQUEST['email'];
//////////////////////////////SQS SENDIND MESSAGES////////////////////////
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
            echo "\n Teraz tworzę PDF i wysyłam na podany e-mail";
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

    echo "Keys retrieved!\n";
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

echo "Robię PDF\n";
$pdf->Output($filename,'F');
echo "DONE!\n";

//////////////////WYSYŁAM EMAIL/////////////////


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
