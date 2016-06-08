<?php
date_default_timezone_set('Europe/Warsaw');
// Include the AWS SDK using the Composer autoloader.
require 'vendor/autoload.php';
require ("fpdf/fpdf.php");
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucket = '160689-michalo';
// Instantiate an Amazon S3 client.
$s3 = new S3Client([
     'version' => 'latest',
     'region'  => 'us-west-2'
 ]);
// FPDF section
$pdf = new FPDF();

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
$pdf->Output($filename,'F');
$publicip =exec('curl -s icanhazip.com');
echo "<a href='http://".$publicip."/upload/test.pdf'>Link do albumu</a>";

//////////////////////////////SQS
use Aws\Sqs\SqsClient;
$client = SqsClient::factory(array(
    //'profile' => '<profile in your aws credentials file>'
    'version' => 'latest',
    'region'  => 'eu-central-1'
));
$client->sendMessage(array(
    'QueueUrl'    => 'https://sqs.eu-central-1.amazonaws.com/881078108084/michalo-album',
    'MessageBody' => 'An awesome message!',
));


/////////////////////////////////

?>
