<?php
date_default_timezone_set('Europe/Warsaw');
require 'vendor/autoload.php'; // Include the AWS SDK using the Composer autoloader.

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
/////////////////////////////////

?>
