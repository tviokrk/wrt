<?php
// Bucket Name
$bucket="160689-michalo";
if (!class_exists('S3'))require_once('S3.php');

//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIXPGZAUCI7HCXYFA');
if (!defined('awsSecretKey')) define('awsSecretKey', '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 ');

$s3 = new S3(awsAccessKey, awsSecretKey);
$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);
?>
