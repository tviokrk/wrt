<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';
use Aws\S3\S3Client;
// Instantiate an Amazon S3 client.
$objects = $s3Client->getIterator('ListObjects', array(
    'Bucket' => '160689-michalo',
    'Prefix' => 'files/'
));
foreach ($objects as $object) {
    echo $object['Key'] . "\n";
}

exit;
