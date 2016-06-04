<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';
use Aws\S3\S3Client;



// Instantiate an Amazon S3 client.
$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
//List files in Bucket
$iterator = $s3Client->getIterator('ListObjects', array(
    'Bucket' => '160689-michalo'
));

foreach ($iterator as $object) {
    echo $object['Key'] . "\n";
}

exit;
