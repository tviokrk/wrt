<?php
date_default_timezone_set('Europe/Warsaw');
require 'vendor/autoload.php'; // Include the AWS SDK using the Composer autoloader.

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Sqs\SqsClient;

$email = $_REQUEST['email'];   //odebranie maila z formularza
//////////////////////////////SQS SENDIND MESSAGES////////////////////////
$url = 'https://sqs.eu-central-1.amazonaws.com/881078108084/michalo-album';
$client = SqsClient::factory(array(    //inicjacja klienta dla SQSa
    'version' => 'latest',
    'region'  => 'eu-central-1'
));
$client->sendMessage(array(    //wysłanie do kolejki maila z formularza
    'QueueUrl'    => $url,
    'MessageBody' => $email,
));
/////////////////////////////////
echo "Do kilku chwil na maila zostanie wysłany wygenerowany album!";
?>
