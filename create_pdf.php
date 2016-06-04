<?php
use Aws\S3\S3Client;

require 'vendor/autoload.php';

$s3 = S3Client::factory(array(
    'key'    => 'AKIAIXPGZAUCI7HCXYFA',
    'secret' => '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',
    'region' => 'us-west-2'
));

$bucket = '160689-michalo';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,

));

foreach ($objects as $object) {
    echo $object['Key'] . "<br>";
}
exit;
