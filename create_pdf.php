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
$pdf = new FPDF('P','in',array(8.5,11));
$pdf->AddPage();
$pdf->SetFont('Helvetica','',12);

// Use the high-level iterators (returns ALL of your objects).
try {
    $objects = $s3->getIterator('ListObjects', array(
        'Bucket' => $bucket
    ));

    echo "Keys retrieved!\n";
    foreach ($objects as $object) {
        echo $object['Key'] . "\n";
        
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}
$pdf->Cell(0,10,$object['Key']. "\n");
//$pdf->Image('https://s3-us-west-2.amazonaws.com/160689-michalo/album_error.png');
$image1='https://s3-us-west-2.amazonaws.com/160689-michalo/album_error.png';
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
$filename="/var/www/html/upload/test.pdf";
$pdf->Output($filename,'F');

?>
