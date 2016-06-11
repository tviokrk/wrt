<?php
date_default_timezone_set('Europe/Warsaw');
require 'vendor/autoload.php'; // Include the AWS SDK using the Composer autoloader.

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Sqs\SqsClient;
?>
<center><form method="post" action="send_email_to_SQS.php">
<input type="submit" value="Chcę ponownie wygenerować album!" /></form></center>
