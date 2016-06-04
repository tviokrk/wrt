<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';
use Aws\S3\S3Client;

$s3Client = S3Client::factory(array('key' => 'AKIAIXPGZAUCI7HCXYFA', 'secret' => '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'));
//List files in Bucket
$iterator = $s3Client->getIterator('ListObjects', array(
    'Bucket' => '160689-michalo'
));

foreach ($iterator as $object) {
    echo $object['Key'] . "\n";
}

exit;
