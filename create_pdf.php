<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Common\Aws;

// Create a service builder using a configuration file
$aws = Aws::factory('./composer.json');

// Get the client from the builder by namespace
$client = $aws->get('S3');
// Instantiate an Amazon S3 client.
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
//List files in Bucket
$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => '160689-michalo'
));

foreach ($iterator as $object) {
    echo $object['Key'] . "\n";
}

exit;
