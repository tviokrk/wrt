<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';

use Aws\S3\S3Client;

// Instantiate an Amazon S3 client.
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

$bucket = '160689-michalo';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,

));
try {
foreach ($objects as $object) {
    echo $object['Key'] . "<br>";
}
}catch (Aws\Exception\S3Exception $e) {
					    echo "There was an error uploading the file.\n";
					}

exit;
